<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook_data_model extends Model {
	
	/**
	 * Constructor
	 */
	function Facebook_data_model()
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
		// return $this->db->get_where('facebook', array('account_id' => $account_id))->result();
	}
	
}?>