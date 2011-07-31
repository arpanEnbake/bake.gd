<?php
/*
 * Connect_twitter Controller
 */
class Connect_twitter extends Controller {
	
	/**
	 * Constructor
	 */
	function Connect_twitter()
	{
		parent::Controller();
		
		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
        $this->load->library(array('account/authentication', 'account/twitter_lib'));
		$this->load->model(array('account/account_model', 'account_twitter_model','account/account_details_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/account_linked', 'account/connect_third_party'));
	}
	
	function index()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
		
		if ($this->input->get('oauth_token'))
		{
			try 
			{
				// Perform token exchange
				$this->twitter_lib->etw->setToken($this->input->get('oauth_token'));
				$twitter_token = $this->twitter_lib->etw->getAccessToken();
				$this->twitter_lib->etw->setToken($twitter_token->oauth_token, $twitter_token->oauth_token_secret);
				
				// Get account credentials
				$twitter_info = $this->twitter_lib->etw->get_accountVerify_credentials()->response;
			}
			catch (Exception $e) 
			{
				$this->authentication->is_signed_in() ?
					redirect('account/account_linked') :
						redirect('account/sign_up');
			}
			
			// Store user's twitter data in session
					$data['connect_create'] = array(
						array(
							'provider' => 'twitter', 
							'provider_id' => $twitter_info['id'],
							'username' => $twitter_info['screen_name'],
							'token' => $twitter_token->oauth_token,
							'secret' => $twitter_token->oauth_token_secret
						), 
						array(
							'fullname' => $twitter_info['name'],
							'picture' => $twitter_info['profile_image_url']
						)
					);
			
			// Check if user has connect twitter to a3m
			if ($user = $this->account_twitter_model->get_by_twitter_id($twitter_info['id']))
			{
				// Check if user is not signed in on a3m
				if ( ! $this->authentication->is_signed_in())
				{
					// Run sign in routine
					$this->authentication->sign_in($user->account_id);
					redirect('');
				} else {
					$user->account_id === $this->session->userdata('account_id') ?
					$this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_this_account'), lang('connect_twitter'))) :
							$this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_another_account'), lang('connect_twitter')));
					redirect('account/account_linked');
				}
			}
			// The user has not connect twitter to a3m
			else
			{
				// Check if user is signed in on a3m
				if ( ! $this->authentication->is_signed_in())
				{
					// code came from connect_create here
					$user_id = $this->account_model->create($twitter_info['screen_name'].$twitter_info['id'], 
								$twitter_info['id'].'@twitter.com');
				
					// Add user details
					$this->account_details_model->update($user_id, $data['connect_create'][1]);
					
					//	case 'twitter': 
					$this->account_twitter_model->insert($user_id, $data['connect_create'][0]['provider_id'], 
						$data['connect_create'][0]['token'], $data['connect_create'][0]['secret']);
					// Run sign in routine
					$this->authentication->sign_in($user_id);
					
					// Connect twitter to a3m
					$this->session->set_flashdata('linked_info', sprintf(lang('linked_linked_with_your_account'), lang('connect_twitter')));
					redirect('');
				} else {
					//	case 'twitter': 
					$this->account_twitter_model->insert($this->session->userdata('account_id'), $data['connect_create'][0]['provider_id'], 
						$data['connect_create'][0]['token'], $data['connect_create'][0]['secret']);
					$this->session->set_flashdata('linked_info', sprintf(lang('linked_linked_with_your_account'), lang('connect_twitter')));
					redirect('account/account_linked');
				}
			}
		}
		
		// Redirect to authorize url
		header("Location: ".$this->twitter_lib->etw->getAuthenticateUrl());
	}
	
	/*
	 * post_status
	 * post status to twitter
	 */
	
	function post_status($twitter_id = null, $yourl_id = null) {

		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
		
		if (!$this->authentication->is_signed_in()) {
			 redirect('account/sign_up');
		}
		if ($user = $this->account_twitter_model->get_by_twitter_id($twitter_id)) {
			$this->twitter_lib->etw->setToken($user->oauth_token, $user->oauth_token_secret);
			$twitter_info = $this->twitter_lib->etw->get_accountVerify_credentials()->response;
			
			$this->load->model('Url_model');
			$yourl = $this->db->get_where('yourls_url', array('id' => $yourl_id))->row();
			
			$statusText = $this->input->post('share_text');
			
			if (!$statusText) $statusText = 'http://bake.gd'.rand(5,1);

			try {
				$response = $this->twitter_lib->etw->post_statusesUpdate(array('status' => $statusText));
				$this->account_twitter_model->db->where('id', $yourl_id)->update('yourls_url', 
						array('tweet_id'=>$response->response['id_str']));
				// save the twitter status id for analytics page.
				
			} catch(Exception $e) {
				$str = ($e->getMessage());
				echo $str;
			}
			//redirect('');
			
		} else {
			// redirect('account/account_linked');
		}
		return true;
	}
	
}


/* End of file connect_twitter.php */
/* Location: ./system/application/modules/account/controllers/connect_twitter.php */