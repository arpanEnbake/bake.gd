<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_facebook_model extends Model {
	
	/**
	 * Constructor
	 */
	function Account_facebook_model()
	{
		### Call the Model constructor
		parent::Model();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get account facebook
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account facebook
	 */
	function get_by_account_id($account_id)
	{
		return $this->db->get_where('a3m_account_facebook', array('account_id' => $account_id))->result();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get account facebook
	 *
	 * @access public
	 * @param string $facebook_id
	 * @return object account facebook
	 */
	function get_by_facebook_id($facebook_id)
	{
		return $this->db->get_where('a3m_account_facebook', array('facebook_id' => $facebook_id))->row();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert account facebook
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $facebook_id
	 * @return void
	 */
	function insert($account_id, $facebook_id)
	{
		$this->load->helper('date');
		
		if ( ! $this->get_by_facebook_id($facebook_id))  // ignore insert
		{
			$this->db->insert('a3m_account_facebook', array(
				'account_id' => $account_id, 
				'facebook_id' => $facebook_id, 
				'linkedon' => mdate('%Y-%m-%d %H:%i:%s', now())
			));
			return TRUE;
		}
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete account facebook
	 *
	 * @access public
	 * @param int $facebook_id
	 * @return void
	 */
	function delete($facebook_id)
	{
		$this->db->delete('a3m_account_facebook', array('facebook_id' => $facebook_id)); 
	}
	
	/**
	 * Insert account facebook
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $facebook_id
	 * @return void
	 */
	function add_status($account_id, $status_id, $url_id)
	{		
		$this->db->insert('a3m_account_fbstatus', array(
				'account_id' => $account_id, 
				'status_id' => $status_id, 
				'created' => mdate('%Y-%m-%d %H:%i:%s', now())
			));
	}

	function get_likes_count($status_id = null) {
/*		pr($this->facebook_lib->fb->api(array(
			'method' => 'likes',
	        //'query' => 'SELECT name FROM profile WHERE id=4',
				'query' => 'SELECT "" FROM like WHERE post_id in("672193296_10150163456703297", "672193296_10150163937168297")'
				)));
				
*/	
		if (!$status_id)
			return 0;
		$this->load->library(array('account/facebook_lib'));
		
		$data = ($this->facebook_lib->fb->api("/$status_id/likes", 'GET', array()));
		$likes = $data['data'];
		return count($likes);
	
	}
	
}


/* End of file account_facebook_model.php */
/* Location: ./system/application/modules/account/models/account_facebook_model.php */