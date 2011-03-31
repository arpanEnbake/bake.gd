<?php
class Url_model extends Model {
	var $id = null; // last insert id
	/*
	** constructor
	*/
	function __construct()
	{
		parent::__construct();
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
			$this->load->library('util');
			$url = $this->util->yourls_sanitize_url( $url );
			
			if ( !$url || $url == 'http://' || $url == 'https://' ) {
				return array('error' => 'Invalid Url');
		 	}

		 	// Prevent DB flood
			$this->util->check_ip_flood(  );
				// Prevent internal redirection loops: cannot shorten a shortened URL
			$url = $this->util->yourls_escape( $url );
			if( preg_match( '!^'. base_url() .'/!', $url ) ) {
				if( $this->yourls_is_shorturl( $url ) ) {
					return array('error' => 'URL is a short URL');
				}
			}

			$keyword = $this->random_keyword();
	
			$data = array('url'=>$url, 'title'=>null, 
							'keyword'=>$keyword,
							'account_id'=>$account_id,
							'ip'=>$this->input->ip_address());

			 $this->db->insert('yourls_url', $data);
			 $this->id = $this->db->insert_id();
		}
		return $keyword;
	}

	/*
	 * get_my_urls
	 * account_id -> account id of the user
	 * limit of results
	 */
	function get_my_urls($account_id, $limit = 10) {
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
	
	function get_click_counts($start_time = null, $end_time = null) {
		$this->db->group_by('referrer');
		if ($start_time && $end_time) {
			$this->db->where("click_time >= '{$start_time}' AND click_time <= '{$end_time}'");	
		}
		$this->db->select ('count(*) as Count, referrer');
		$query = ($this->db->get('yourls_log'));
		
		$query->row();

		if (isset($query->result_object[0]))
			return $query->result_object;
		else 
			return null;
	}
}
?>
