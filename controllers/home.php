<?php
class Home extends Controller {

	var $account = null;

	// following remap is required for handling arguments on index action
	// for this we need to add every additional controller name to the routes. 
	function	_remap ($method )	{
		$param_offset = 2;
	
		// Default to index
		if ( ! method_exists($this, $method))
		{
			// We need one more param
			$param_offset = 1;
			$method = 'index';
		}
	
		// Since all we get is $method, load up everything else in the URI
		$params = array_slice($this->uri->segment_array(), 0/*$param_offset*/);
	
		// Call the determined method with all params
		call_user_func_array(array($this, $method), $params);
	}

	function Home()
	{
		
		parent::Controller();

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url'));
		$this->load->library(array('account/authentication'));
		$this->load->model(array('account/account_model'));
		$this->lang->load(array('general'));

		if ($this->authentication->is_signed_in())
		{
			$this->account = $this->account_model->get_by_id($this->session->userdata('account_id'));
		}
		
	}
	
	/*
	 * send_to_url
	 * on basis of key forward the request
	 */
	function _send_to_url($key = null) {
		$response = false;
		$this->load->model('Url_model');
		$this->load->helper('url');

		if (strpos ($key, '+', strlen($key) - 1)) {
			$key = str_replace('+', '' , $key);
			redirect('/home/detail/'.$key, 'location');
		}			
		
		$url = $this->Url_model->get_url($key);

		if (isset($url->url)) {
			$this->register_click($url);
			redirect($url->url, 'location');
			$response = true;
		}
		return $response;
	}
	
	function detail($controller = 'home', $func = 'detail', $key =null) {
		$this->load->model('Url_model');
		$this->load->helper('url');

		$url = $this->Url_model->get_url($key);
		$data['url'] = ($url);
		if (isset($url->url)) {
			$this->load->model('account/account_facebook_model');
			$data['likes'] = $url->likes;
			
			$this->load->model('account/account_twitter_model');
			$data['retweets'] = $url->retweets;

			$data['clicks'] = ($this->Url_model->get_url_clicks($url->id));
			$data['user'] = (	$this->account_model->get_by_id($url->account_id));
			$this->load->view('detail', isset($data) ? $data : NULL);
		}
		
	}
	
	function index($key = null)
	{
		$this->load->model('Url_model');
		$this->load->library('form_validation');
		
		if ($key) {
			$response = $this->_send_to_url($key);
		}

		// login details and account association
		$data['account'] = $this->account;
		$account_id = null;
		if ($this->account)
		{ 
			$account_id = $this->account->id;
			$this->load->model('account/account_twitter_model');
			$tw = ($this->account_twitter_model->get_by_account_id($account_id));
			if ($tw)
				$data['twitter'] = $tw[0];

			$this->load->model('account/account_facebook_model');
			$fb = ($this->account_facebook_model->get_by_account_id($account_id));
			if ($fb)
				$data['fb'] = $fb[0];	
		}
		// shorten the url
		$url = $this->input->post('url');
		if (!empty($url)) {
			$this->form_validation->run('url');
			
			if (filter_var($url, FILTER_VALIDATE_URL)) {
				$res = $this->get_shortened_url($url, $account_id);
				$data['Result'] = $res['Result'];
				if ($data['Result']['id'])
					$this->add_cookie($data['Result']['id']);
			} else {
				$data['error'] = 'Not a valid url';
			}
		}
		
		// cookie filling
		$data['my_urls'] = $this->recent_urls();

		$this->load->view('home', isset($data) ? $data : NULL);
	}
	
	/*
	 * saves and returns the keyword generated for the url
	 */
	function get_shortened_url($url , $account_id) {
		$url = stripslashes($url);
		
		$url_model = new Url_model();
		
		$return = $url_model->add($account_id, $url);
		//$return = $this->Url_model->add($account_id, $url);

		$domain = isset($this->account) && isset($this->account->domain) ? $this->account->domain : $_SERVER['HTTP_HOST'];

		if (!empty($return['error'])) {
			$data['Result']['url'] = ($url);
			$data['Result']['domain'] = $domain;
			$data['Result']['keyword'] = $return;
			$data['Result']['id']  = $this->Url_model->id;
		} else {
			$data['Result']['url'] = ($url);
			$data['Result']['keyword'] = null;
			$data['Result']['id']  = null;
			$data['Result']['error'] = $return['error'];
		}

		return $data;
	}

	function recent_urls() {
		$urls = null;
		if ($this->account) {
			$urls = $this->Url_model->get_my_urls($this->account->id);
		}
		else {
			$this->load->helper('cookie');
			$ids = get_cookie('bakegdids');
			$url_ids = explode(',', $ids);

			$this->db->order_by('timestamp', 'desc');
			$this->db->from('yourls_url');
			$this->db->where_in('id', $url_ids);
			$query =  $this->db->get();
			$urls = $query->result_object();
		}
		return $urls;
	}
	
	function add_cookie($id) {
		if(!$this->account) {
			$this->load->helper('cookie');

			$name = 'bakegdids';
			$existing = get_cookie($name, TRUE);
			$id_array = array();
			if (!empty($existing)) {
				$id_array = explode(',' , $existing);
				$id_array = array_unique($id_array);
			}

			array_unshift($id_array, $id);
			$limited_ids = array_slice ($id_array, 0, 10);
			$id_str = implode(',', $limited_ids);
			$cookie = array(
			    'name'   => $name,
			    'value'  => $id_str,
			    'expire' => '86500',
				'domain' => '',
			);
			delete_cookie($name);
			set_cookie($cookie);
		}
	}
	
	function register_click($yourl) {
		$this->load->model(array('Url_model'));
		$this->load->library('util');
		
		$referrer = ( isset( $_SERVER['HTTP_REFERER'] ) ? $this->util->yourls_sanitize_url( $_SERVER['HTTP_REFERER'] ) : 'direct' );
		$ua = $this->util->yourls_get_user_agent();
		$ip = $this->util->yourls_get_IP();
		$location = $this->util->yourls_geo_ip_to_countrycode( $ip );
		
		$parsed_url = parse_url($referrer);
		$host = explode(':', $parsed_url['host']);
		$hostname = $host[0]; 

		if (strpos($hostname, 'twitter') !== false) {
			$referrer = 'twitter';
		} else if (strpos($hostname, 'facebook') !== false) {
			$referrer = 'facebook';
		}else if (strpos($hostname, 'facebook' !== false)) {
			$referrer = 'linkedin';
		}else {
			$referrer = 'Others';
		}
		
		$data = array('referrer'=>$referrer, 'user_agent'=>$ua, 
				'yourl_id'=>$yourl->id,
				'ip_address'=>$ip, 'click_time'=> date('Y-m-d H:m:s'));

		
		$this->Url_model->register_click($data, $yourl);
	}
	
}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */