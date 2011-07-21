<?php
/*
 * Account_settings Controller
 */
class Account_settings extends Controller {
	
	/**
	 * Constructor
	 */
	function Account_settings()
	{
		parent::Controller();
		
		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('date', 'language', 'account/ssl', 'url'));
        $this->load->library(array('account/authentication', 'form_validation'));
		$this->load->model(array('account/account_model', 'account/account_details_model', 
				'account/ref_country_model', 'account/ref_language_model', 'account/ref_zoneinfo_model'));
		$this->load->language(array('general', 'account/account_settings'));
		
				// Redirect unauthenticated users to signin page
		if ( ! $this->authentication->is_signed_in()) 
		{
			redirect('account/sign_in/?continue='.urlencode(base_url().'account/account_settings'));
		}
		
	}
	
	/**
	 * Custom Domain
	 * 
	 * You can set a custom domain here
	 */
	function custom() {
		// Retrieve sign in user
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
		
		
		if (isset($_POST) && !empty($_POST)) {
			$this->account_model->update_domain($data['account']->id, 
				$this->input->post('settings_domain') ? $this->input->post('settings_domain') : $_SERVER['HTTP_HOST']);
				redirect(uri_string());
		}
		
		
		$this->load->view('account/custom', isset($data)? $data : null);
		
	}
	
	/**
	 * Account settings
	 */
	function index()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
		
		
		// Retrieve sign in user
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
		
		// Retrieve countries, languages and timezones
		$data['countries'] = $this->ref_country_model->get_all();
		$data['languages'] = $this->ref_language_model->get_all();
		$data['zoneinfos'] = $this->ref_zoneinfo_model->get_all();
		
		// Split date of birth into month, day and year
		if ($data['account_details'] && $data['account_details']->dateofbirth)
		{
			$dateofbirth = strtotime($data['account_details']->dateofbirth);
			$data['account_details']->dob_month = mdate('%m', $dateofbirth);
			$data['account_details']->dob_day = mdate('%d', $dateofbirth);
			$data['account_details']->dob_year = mdate('%Y', $dateofbirth);
		}
		
		// Setup form validation
		$this->form_validation->set_error_delimiters('<div class="field_error">', '</div>');
		$this->form_validation->set_rules(array(
			array('field'=>'settings_email', 'label'=>'lang:settings_email', 'rules'=>'trim|required|valid_email|max_length[160]'),
			array('field'=>'settings_domain', 'label'=>'Custom Domain', 'rules'=>'trim|required|max_length[160]'),
			array('field'=>'settings_fullname', 'label'=>'lang:settings_fullname', 'rules'=>'trim|max_length[160]'),
			array('field'=>'settings_firstname', 'label'=>'lang:settings_firstname', 'rules'=>'trim|max_length[80]'),
			array('field'=>'settings_lastname', 'label'=>'lang:settings_lastname', 'rules'=>'trim|max_length[80]'),
			array('field'=>'settings_postalcode', 'label'=>'lang:settings_postalcode', 'rules'=>'trim|max_length[40]')
		));
		
		// Run form validation
		if ($this->form_validation->run()) 
		{
			// If user is changing email and new email is already taken
			if (strtolower($this->input->post('settings_email')) != strtolower($data['account']->email)
					&& $this->email_check($this->input->post('settings_email')) === TRUE)
			{
				$data['settings_email_error'] = lang('settings_email_exist');
			}
			// Detect incomplete birthday dropdowns
			elseif ( ! (($this->input->post('settings_dob_month') && $this->input->post('settings_dob_day') && $this->input->post('settings_dob_year')) || 
					( ! $this->input->post('settings_dob_month') && ! $this->input->post('settings_dob_day') && ! $this->input->post('settings_dob_year'))) )
			{
				$data['settings_dob_error'] = lang('settings_dateofbirth_incomplete');
			}
			else
			{
				// Update account email
				$this->account_model->update_email($data['account']->id, 
							$this->input->post('settings_email') ? $this->input->post('settings_email') : NULL);
				$this->account_model->update_domain($data['account']->id, 
							$this->input->post('settings_domain') ? $this->input->post('settings_domain') : NULL);
							
				
				// Update account details
				if ($this->input->post('settings_dob_month') && $this->input->post('settings_dob_day') && $this->input->post('settings_dob_year'))
					$attributes['dateofbirth'] = mdate('%Y-%m-%d', strtotime($this->input->post('settings_dob_day').'-'.$this->input->post('settings_dob_month').'-'.$this->input->post('settings_dob_year')));
				$attributes['fullname'] = $this->input->post('settings_fullname') ? $this->input->post('settings_fullname') : NULL;
				$attributes['firstname'] = $this->input->post('settings_firstname') ? $this->input->post('settings_firstname') : NULL;
				$attributes['lastname'] = $this->input->post('settings_lastname') ? $this->input->post('settings_lastname') : NULL;
				$attributes['gender'] = $this->input->post('settings_gender') ? $this->input->post('settings_gender') : NULL;
				$attributes['postalcode'] = $this->input->post('settings_postalcode') ? $this->input->post('settings_postalcode') : NULL;
				$attributes['country'] = $this->input->post('settings_country') ? $this->input->post('settings_country') : NULL;
				$attributes['language'] = $this->input->post('settings_language') ? $this->input->post('settings_language') : NULL;
				$attributes['timezone'] = $this->input->post('settings_timezone') ? $this->input->post('settings_timezone') : NULL;
				$this->account_details_model->update($data['account']->id, $attributes);
				
				$data['settings_info'] = lang('settings_details_updated');
			}
		}
		$this->load->view('account/account_settings', $data);
	}
	
	/**
	 * Check if an email exist
	 *
	 * @access public
	 * @param string
	 * @return bool
	 */
	function email_check($email)
	{
		return $this->account_model->get_by_email($email) ? TRUE : FALSE;
	}
	
}


/* End of file account_settings.php */
/* Location: ./system/application/modules/account/controllers/account_settings.php */