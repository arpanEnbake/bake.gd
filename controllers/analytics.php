<?php 
class Analytics extends Controller {

	var $account = null;
  function Analytics() {
 		parent::Controller();

 		$this->load->library('form_validation');
		// Load the necessary stuff...
		$this->load->helper(array('language', 'url'));
		$this->load->library(array('account/authentication'));
		$this->load->model(array('account/account_model','account/account_details_model'));
		$this->lang->load(array('general'));
		
		if ($this->authentication->is_signed_in())
		{
			$this->account = $this->account_model->get_by_id($this->session->userdata('account_id'));
			$this->account_details = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));

			$this->data['account'] = $this->account;
			$this->data['account_details'] = $this->account_details;
			$this->_logged_in($this->data);
		}
				
  }
  
  	/*
	 * function logged_in.
	 * 
	 * if user is logged in upload its details about fb /twitter
	 */
		function _logged_in() {

		// login details and account association
		$account_id = $this->account->id;
		
		$this->load->model('account/account_twitter_model');
		$tw = ($this->account_twitter_model->get_by_account_id($account_id));
		if ($tw)
			$this->data['twitter'] = $tw[0];

		$this->load->model('account/account_facebook_model');
		$fb = ($this->account_facebook_model->get_by_account_id($account_id));
		if ($fb)
			$this->data['fb'] = $fb[0];	
	}
  
  
  	function index() {
  		$this->load->view('analytics/index', isset($this->data) ? $this->data : NULL);
	}
	
  
	function fusion() {
		$this->load->view('analytics/fusion', isset($this->data) ? $this->data : NULL);
		
	}

}