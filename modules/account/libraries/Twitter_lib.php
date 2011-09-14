<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitter_lib {

	var $CI, $etw;
	
	/**
	 * Constructor
	 */
	function Twitter_lib()
	{
		// Obtain a reference to the ci super object
		$this->CI =& get_instance();
		
        $this->CI->load->config('account/twitter');
		$this->CI->load->plugin('account/twitter');
		
		// Require Facebook app keys to be configured
		if ( ! $this->CI->config->item('twitter_consumer_key') || ! $this->CI->config->item('twitter_consumer_secret'))
		{
			echo 'Visit '.anchor('http://dev.twitter.com/apps', 'http://dev.twitter.com/apps').' to register your app.'.
			'<br />The config file is located at "system\application\modules\account\config\twitter.php"';
			die;
		}
		
		// Create EpiTwitter object
		$this->etw = new EpiTwitter($this->CI->config->item('twitter_consumer_key'), $this->CI->config->item('twitter_consumer_secret'));
		
		// Complain loudly if base url contains "://localhost"
		/* if (strpos($this->CI->config->item('base_url'), '://localhost') !== FALSE)
		{
			echo 'Erm... Twitter doesn\'t like your base URL to start with "http://localhost/".<br />';
			die;
		}*/
	}
	
	// --------------------------------------------------------------------
	
}


/* End of file Twitter_lib.php */
/* Location: ./system/application/libraries/Twitter_lib.php */