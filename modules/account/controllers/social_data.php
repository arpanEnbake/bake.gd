<?php
/*
 * Facebook Controller
 */
class Social_data extends Controller {
	
	/**
	 * Constructor
	 */
	function Social_data()
	{
		parent::Controller();
		
		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
		#$this->CI->load->library('session');
        $this->load->library(array('account/authentication', 'account/facebook_lib', 'account/twitter_lib'));
		$this->load->model(array('account/account_model', 'social_data_model','account/account_details_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/account_linked', 'account/connect_third_party'));
	}
	
	function index()
	{
		
	}
	
	function process_fb($url) {
		$likes_id = array();

		$data = ($this->facebook_lib->fb->api("/{$url->status_id}/likes", 'GET', array()));
		$likes = $data['data'];
		// if no change in likes dont do anything		
		if (count($likes) > $url->likes) {
			echo 'likes for status' . $url->status_id;
			pr($likes);
			
			$query = $this->social_data_model->db->select(array('fb_id'))->from('fb_status_likes')->where('status_id', $url->status_id);
			$res = $this->social_data_model->db->get();
			
			for($i = 0; $i < $res->num_rows;++$i)
				$likes_id[] = $res->row($i)->fb_id;
			
			foreach ($likes as $like) {
				if (empty($likes_id) || !in_array($like['id'], $likes_id)) {
					$like_data = array(
								'status_id' => $url->status_id, 
								'fb_id' => ($like['id']),
								'name' => $like['name'],
								'date' => date('Y-m-d'), 
							);
					$this->social_data_model->db->insert('fb_status_likes', $like_data);
				}
			}		
		}
		
		return count($likes);
		
	}

	function process_tw($url) {
		$resp = ($this->twitter_lib->etw->get("/statuses/retweets/{$url->tweet_id}.json" 
				,array('trim_user' => 'true')
				));
				
		$retweets_id = array();
		
		// if no change in retweets dont do anything		
		if (count($resp->response) > $url->retweets) {
			$query = $this->social_data_model->db->select(array('retweet_id'))->from(' tw_retweets')->where('tweet_id', $url->tweet_id);
			$res = $this->social_data_model->db->get();
			
			for($i = 0; $i < $res->num_rows;++$i)
				$retweets_id[] = $res->row($i)->retweet_id;
				

			echo 'retweets for tweets' . $url->tweet_id;
			pr($retweets_id);
						
			foreach($resp->response as $retweet) {
				if (empty($retweets_id) || !in_array($retweet['id_str'], $retweets_id)) {
				
					$retweet_data = array(
						'tweet_id' => $retweet['retweeted_status']['id_str'], 
						'retweet_id' => $retweet['id_str'],
						'user_id' => $retweet['user']['id_str'],
						'date' => date('Y-m-d'),
						//	'name' => $like['name'] 
						);
					$this->social_data_model->db->insert('tw_retweets', $retweet_data);
				}		
			}
		}
		return count($resp->response);
	}
	
	function cron_get_data () {
		$this->twitter_lib->etw->setToken('98854015-zq16wLn3zy2nL8Kl96hVSSm4liz5RH2d9fhXYFAHo', 
				"zCKoLXSzVenG6OFDyjXxpraabxandav4totvjVBSY8");
		
		$urls = $this->social_data_model->db->get_where('yourls_url', 
			array('status_id is not null or tweet_id is not null' => null))->result();
		
		foreach($urls as $key => $url) {
			echo '=************************************=';
			if ($url->status_id) {
				$url->likes = $this->process_fb($url);
				$url->like_date = date('Y-m-d');
			}
			if ($url->tweet_id) {
				$url->retweets = $this->process_tw($url);
				$url->tweet_date = date('Y-m-d');
			}
			echo '=************************************=';
			$this->social_data_model->db->update('yourls_url', $url, array('id' => $url->id));
		}
		
	}
	
	
	// code to be moved to model.. temp here
	// for one link, give status_id
	// for the day give day
	// for the account_id give account number or else string null
	function get_likes_data($day, $account_id = 'null', $status_id = null) { // $day = 2011-05-03
		
		$cond = array('created like' => $day . '%');
		if ($account_id && $account_id != 'null') $cond['account_id'] = $account_id;
		if ($status_id)  $cond['status_id'] = $status_id;
		$likes = $this->social_data_model->db->get_where('facebook', $cond)->result();
		
		pr($likes);
	}
}
