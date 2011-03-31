<?php 
class Analytics extends Controller {

	var $account = null;
  function Analytics() {
 		parent::Controller();

 		$this->load->library('form_validation');
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
  
  
  	function index() {
  		$this->load->view('analytics/index', isset($data) ? $data : NULL);
	}
	
  

}