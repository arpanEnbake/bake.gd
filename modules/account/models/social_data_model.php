<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social_data_model extends Model {
	
	/**
	 * Constructor
	 */
	function Social_data_model()
	{
		### Call the Model constructor
		parent::Model();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get account Social
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account Social
	 */
	function get_by_account_id($account_id)
	{
		// return $this->db->get_where('Social', array('account_id' => $account_id))->result();
	}
	
}?>