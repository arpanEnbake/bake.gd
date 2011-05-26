<?php
/*
 * Fb_pages Controller
 */
class Fb_pages extends Controller {
	
	/**
	 * Constructor
	 */
	function Fb_pages()
	{
		parent::Controller();
		
		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
        $this->load->library(array('account/authentication', 'form_validation'));
		$this->load->model(array('account/account_model', 'account/account_facebook_model', 'account/account_twitter_model', 'account/account_openid_model'));
		$this->load->language(array('general', 'account/account_linked', 'account/connect_third_party'));
	}
	
	/*
	 * index
	 * 
	 * The action to list the facebook pages for this user.
	 */
	function index()
	{
		// Redirect unauthenticated users to signin page
		if (!$this->authentication->is_signed_in()) 
		{
			redirect('account/sign_in/?continue='.urlencode(base_url().'account/account_linked'));
		}
	}
}


/* End of file fb_pages.php */
/* Location: ./system/application/modules/account/controllers/fb_pages.php */