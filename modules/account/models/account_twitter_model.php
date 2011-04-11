<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_twitter_model extends Model {
	
	/**
	 * Constructor
	 */
	function Account_twitter_model()
	{
		### Call the Model constructor
		parent::Model();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get account twitter
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account twitter
	 */
	function get_by_account_id($account_id)
	{
		return $this->db->get_where('a3m_account_twitter', 
				array('account_id' => $account_id))->result();
	}

	function get_all_by_account_id($account_id)
	{
		return $this->db->get_where('a3m_account_twitter', 
				array('account_id' => $account_id))->result();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get account twitter
	 *
	 * @access public
	 * @param string $twitter_id
	 * @return object account twitter
	 */
	function get_by_twitter_id($twitter_id)
	{
		return $this->db->get_where('a3m_account_twitter', 
				array('twitter_id' => $twitter_id))->row();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert account twitter
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $twitter_id
	 * @param string $oauth_token
	 * @param string $oauth_token_secret
	 * @return void
	 */
	function insert($account_id, $twitter_id, $oauth_token, $oauth_token_secret, $default = 1)
	{
		$this->load->helper('date');
		
		if ( ! $this->get_by_twitter_id($twitter_id)) // ignore insert
		{
			// if first twitter then add it as default
			if ($this->db->get_where('a3m_account_twitter', array('account_id' => $account_id))->result()) {
				$default = 1;
			}

			$this->db->insert('a3m_account_twitter', array(
				'account_id' => $account_id, 
				'twitter_id' => $twitter_id, 
				'oauth_token' => $oauth_token, 
				'oauth_token_secret' => $oauth_token_secret, 
				'linkedon' => mdate('%Y-%m-%d %H:%i:%s', now()),
				'default' => $default
			));
			return TRUE;
		}
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete account twitter
	 *
	 * @access public
	 * @param int $twitter_id
	 * @return void
	 */
	function delete($twitter_id)
	{
		$this->db->delete('a3m_account_twitter', array('twitter_id' => $twitter_id)); 
	}
	
}


/* End of file account_twitter_model.php */
/* Location: ./system/application/modules/account/models/account_twitter_model.php */