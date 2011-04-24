<?php
/*
 * Connect_facebook Controller
 */
class Connect_facebook extends Controller {
	
	/**
	 * Constructor
	 */
	function Connect_facebook()
	{
		parent::Controller();
		
		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
		#$this->CI->load->library('session');
        $this->load->library(array('account/authentication', 'account/facebook_lib'));
		$this->load->model(array('account/account_model', 'account_facebook_model', 'account/account_details_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/account_linked', 'account/connect_third_party'));
	}
	
	function index()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
		// Check if user is signed in on facebook
		if ($this->facebook_lib->user)
		{
				// Store user's facebook data in session
					$data['connect_create'] = array(
						array(
							'provider' => 'facebook', 
							'provider_id' => $this->facebook_lib->user['id']
						), 
						array(
							'fullname' => $this->facebook_lib->user['name'],
							'firstname' => $this->facebook_lib->user['first_name'],
							'lastname' => $this->facebook_lib->user['last_name'],
							'gender' => $this->facebook_lib->user['gender'],
							'dateofbirth' => $this->facebook_lib->user['birthday'],
							'picture' => 'http://graph.facebook.com/'.$this->facebook_lib->user['id'].'/picture',
							// $this->facebook_lib->user['link'],// $this->facebook_lib->user['bio']// $this->facebook_lib->user['timezone']// $this->facebook_lib->user['locale']// $this->facebook_lib->user['verified']// $this->facebook_lib->user['updated_time']
						)
					);
			
			// Check if user has connect facebook to a3m
			if ($user = $this->account_facebook_model->get_by_facebook_id($this->facebook_lib->user['id']))
			{
				// Check if user is not signed in on a3m
				if ( ! $this->authentication->is_signed_in())
				{
					// Run sign in routine
					$this->authentication->sign_in($user->account_id);
					redirect('/');
				}
				else {
					$user->account_id === $this->session->userdata('account_id') ?
					$this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_this_account'), lang('connect_facebook'))) :
							$this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_another_account'), lang('connect_facebook')));
					redirect('account/account_linked');		
				}
			}
			// The user has not connect facebook to a3m
			else
			{
				// Check if user is signed in on a3m
				if ( ! $this->authentication->is_signed_in())
				{
					// code came from connect_create here
					$user_id = $this->account_model->create($this->facebook_lib->user['username'].$this->facebook_lib->user['id'], 
								$this->facebook_lib->user['email']);
				
					// Add user details
					$this->account_details_model->update($user_id, $data['connect_create'][1]);
					
					//	case 'facebook': 
					$this->account_facebook_model->insert($user_id, $this->facebook_lib->user['id']);
					// Run sign in routine
					$this->authentication->sign_in($user_id);
					redirect('/');
				}
				else
				{
					// Connect facebook to a3m
					$this->account_facebook_model->insert($this->session->userdata('account_id'), $this->facebook_lib->user['id']);
					$this->session->set_flashdata('linked_info', sprintf(lang('linked_linked_with_your_account'), lang('connect_facebook')));
					redirect('account/account_linked');
				}
			}
		}
		
		// redirect to login url
		header("Location: ".$this->facebook_lib->fb->getLoginUrl(array('req_perms' => 'user_birthday, email, read_stream, publish_stream')));
	}
	
	/*
	 * post_wall
	 * post feed to user
	 */
	
	function post_wall($facebook_id , $yourl_id = null) {
		/*pr($this->facebook_lib->fb->api(array(
			'method' => 'fql.query',
	        //'query' => 'SELECT name FROM profile WHERE id=4',
				'query' => 'SELECT "" FROM like WHERE post_id in("672193296_10150163456703297", "672193296_10150163937168297")'
				)));
		*/
		// Enable SSL?
		//return;
		maintain_ssl($this->config->item("ssl_enabled"));

		if (!$this->authentication->is_signed_in()) {
			redirect('account/sign_up');
		}
		if ($user = $this->account_facebook_model->get_by_facebook_id($facebook_id)) {
			$this->load->model('Url_model');
			
			// $yourl = $this->db->get_where('yourls_url', array('id' => $yourl_id))->row();
			$statusText = $this->input->post('share_text');

			try {
				$response = $this->facebook_lib->fb->api("/$facebook_id/feed", 'POST'
      						,array('message' => "$statusText")
      						);

      			// save the fb post id for analytics page.
      			$this->account_facebook_model->db->where('id', $yourl_id)->update('yourls_url', 
						array('tweet_id'=>$response->response['id_str']));
      			
   			} catch(Exception $e) {
					$str = ($e->getMessage());
					echo $str;
			}
      						
			// redirect('/');
			
		} else {
			// redirect('account/account_linked');
		}
	}
	
	
}


/* End of file connect_facebook.php */
/* Location: ./system/application/modules/account/controllers/connect_facebook.php */