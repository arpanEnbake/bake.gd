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
		
		$url = $this->Url_model->get_url($key);

		if (isset($url->url)) {
			redirect($url->url, 'location');
			$response = true;
		}
		return $response;
	}
	
	function index($key = null)
	{
		if ($key)
			$response = $this->_send_to_url($key);
			
			echo 'now';
			$this->load->library('util');
			 $this->util->check_ip_flood();
echo 'now';
		$this->load->library('form_validation');
		$this->load->model('Url_model');

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

		$data['my_urls'] = $this->recent_urls();

		$post = $this->input->post('url');
		if (!empty($post)) {
			$this->form_validation->run('url');
	
			if (filter_var($post, FILTER_VALIDATE_URL)) {
				$return = $this->Url_model->add($account_id);
				$data['Result']['url'] = ($post);
				$data['Result']['keyword'] = $return;
				$data['Result']['id']  = $this->Url_model->id;
				if ($this->Url_model->id)
					$this->add_cookie($this->Url_model->id);
			} else {
				$data['error'] = 'Not a valid url';
			}
		}

		$this->load->view('home', isset($data) ? $data : NULL);
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
	
	function check_ip()
	{
		$this->load->library('util');
	
		$this->util->check_ip_flood();
	}

	
}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */