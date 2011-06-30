<?php
class Url_model extends DataMapper {
	var $table = 'yourls_url';
	var $id = null; // last insert id
	
	var $validation = array(
		array(
			'field' => 'url',
			'label' => 'URL',
			'rules' => array('required', 'not_spam')
		)
	);
	
	/*
	** constructor
	*/
	function __construct()
	{
		parent::DataMapper();
	}

	/*
	 * not_spam
	 * 
	 * check that this link is not a spam link.
	 */
	function _not_spam($field)
	{
		$CI = &get_instance();
		$CI->load->library('urlguard');
		$list = $CI->urlguard->isSpamUrl($this->{$field});
	}

	/*
	** add
	**
	** saves the url.
	* if already an existing entry returns its keywords instead of adding new
	*/
	function add($account_id = null, $url = null)
	{
		$keyword = null;

		$this->db->select(array('keyword', 'id'))->from('yourls_url')->where('url', $url);
		$res = $this->db->get();

		if ($res->num_rows > 0) {
			$keyword = $res->row(0)->keyword;
			$this->id = $res->row(0)->id;
		}

		// no existing keyword found.. add a new one.
		if (!$keyword) {
			// Temporary Patch. Data Mapper corrupts up the CI loader and hence
			// accessing libs like $this->util does not work.
			$CI = &get_instance();
			$CI->load->library('util');
			$url = $CI->util->yourls_sanitize_url( $url );
			
			if ( !$url || $url == 'http://' || $url == 'https://' ) {
				return array('error' => 'Invalid Url');
		 	}

		 	// Prevent DB flood
			$CI->util->check_ip_flood(  );

			// Prevent internal redirection loops: cannot shorten a shortened URL
			$url = $CI->util->yourls_escape( $url );
			if( preg_match( '!^'. base_url() .'/!', $url ) ) {
				if( $this->yourls_is_shorturl( $url ) ) {
					return array('error' => 'URL is a short URL');
				}
			}

			$keyword = $this->random_keyword();
			$domain = $_SERVER['HTTP_HOST'];
			
			if ($account_id) {
				$account = $CI->account_model->get_by_id($account_id);
				$domain = isset($account->domain) ? $account->domain : $domain;
			}
			
			$data = array('url'=>$url, 'title'=> $this->get_details($url), 
							'keyword'=>$keyword,
							'domain'=>$domain,
							'account_id'=>$account_id,
							'ip'=>$CI->input->ip_address());

			$this->id = $this->save_url_to_db($data);
		}

		return $keyword;
	}
	
	function get_details($url) {
		$title = 'Title N/A';
		$description = 'Description N/A';
		 
		$file = file_get_contents($url, false, null, null, 500);
		$str = "/<title>(.+)<\\/title>/smU";
		if($file && preg_match($str, $file, $t)) {
			$title = trim($t[1]);
				
			$metatagarray = get_meta_tags( $url );
		    $keywords = @$metatagarray[ "keywords" ];
		    $description = @$metatagarray[ "description" ];
		}
	    return  $title . ' <br>'. $description . ' <br>';
	}

	/*
	 * save_url_to_db
	 * 
	 * data -> The data to save
	 * 
	 * Converts the data in format how Datamapper expects it and saves it.
	 * 
	 * @return the saved id.
	 */
	function save_url_to_db($data)
	{
		$this->url = $data['url'];
		$this->keyword = $data['keyword'];
		$this->domain = $data['domain'];
		$this->account_id = $data['account_id'];
		$this->ip = $data['ip'];
		$this->title = $data['title'];

		$this->save();
		
		return $this->db->insert_id();
	}

	/*
	 * get_my_urls
	 * account_id -> account id of the user
	 * limit of results
	 */
	function get_my_urls($account_id, $limit = null, $fields = '*') {
		$this->db->select($fields);
		$this->db->order_by('timestamp', 'desc');
		$query = $this->db->get_where('yourls_url', array('account_id' => $account_id), $limit);
		($query->row());
		return $query->result_object;
	}

	/*
	** random_keyword
	**
	** generates a random keyword by looking up in urls table
	*/
	function random_keyword()
	{
		//$keyword = yourls_apply_filter( 'random_keyword', $keyword );
		$id = $this->get_next_id();

		$uid = substr(md5(uniqid(rand(), true)), 0, 6);

		if($this->check_keyword_availability($uid) != 0) {
			return $this->random_keyword();
		} else {
			return $uid;	
		}
		// update the value of next id.
		// $this->db->where('option_name', 'next_id')->update('yourls_options', array('option_value'=>$id));
		
	}
	
		/*
		** get_next_id
		**
		** get next id for the url keyword.
		**
		*/
		function get_next_id()
		{
			$this->db->select('option_value')->from('yourls_options')->where('option_name', 'next_id');
		
			return $this->db->get()->row(0)->option_value;
		}
	
		/*
		** check_keyword_availability
		**
		** get next id for the url keyword.
		**
		*/
	function check_keyword_availability($id)
	{
		$this->db->like('keyword', "`$id`")->from('yourls_url');

		return $this->db->count_all_results();
	}
	
	function get_url($key) {
		$query = $this->db->get_where('yourls_url', array('keyword' => $key), 10);
		($query->row());
		if (isset($query->result_object[0]))
			return $query->result_object[0];
		else 
			return null;
		
	}
	
	function register_click($data, $yourl) {
		$this->db->insert('yourls_log', $data);
		$this->db->where('id', $yourl->id)->update('yourls_url', array('clicks'=>$yourl->clicks + 1));
	}

	function _clicks($condition) {
		$this->db->group_by('referrer');
		if ($condition) {
			$this->db->where($condition);	
		}

		$this->db->select ('count(*) as Count, referrer');
		$query = ($this->db->get('yourls_log'));
		$query->row();
		
		if (isset($query->result_object[0]))
			return $query->result_object;
		else 
			return null;
	}
	
	function get_url_clicks($url_id) {
		return $this->_clicks("yourl_id = {$url_id}");
	}
	
	// if url belongs to this account_id
	function get_click_counts($start_time = null, $end_time = null, $account_id = null) {
		$conditions = '';
		if ($start_time)
			$conditions = "click_time >= '{$start_time}' ";
		if ($end_time)
			$conditions .= (isset($conditions) ?  ' AND ' : '') .  "click_time <= '{$end_time}'";
		if ($account_id)
			$conditions .= (isset($conditions) ?  ' AND ' : '') .  
							"yourl_id in (select id from yourls_url where account_id = '{$account_id}')";
			
		return $this->_clicks($conditions);
	}
	
	function get_location($start_time = null, $end_time = null, $account_id = null) {
		
		$conditions = '';
		if ($start_time)
			$conditions = "click_time >= '{$start_time}' ";
		if ($end_time)
			$conditions .= (isset($conditions) ?  ' AND ' : '') .  "click_time <= '{$end_time}'";
		if ($account_id)
			$conditions .= (isset($conditions) ?  ' AND ' : '') .  
							"yourl_id in (select id from yourls_url where account_id = '{$account_id}')";

		$this->db->group_by('country_code');
		$this->db->where($conditions);	

		$this->db->select ('count(*) as Count, country_code');
		$query = ($this->db->get('yourls_log'));
		
		$query->row();

		if (isset($query->result_object[0]))
			return $query->result_object;
		else 
			return null;
		
	}
}
?>
