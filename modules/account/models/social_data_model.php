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
	
	function fb_likes($start_time = null, $end_time = null) {
		
		$condition = ("date >= '{$start_time}' AND date <= '{$end_time}'");
		return $this->get_promotes($condition, 'fb_status_likes');
		
	}
	
	function tw_retweets($start_time = null, $end_time = null) {
		
		$condition = ("date >= '{$start_time}' AND date <= '{$end_time}'");
		return $this->get_promotes($condition, 'tw_retweets');
		
	}
	
	function get_promotes($condition, $table) {
				
		$this->db->group_by('date');
		if ($condition) {
			$this->db->where($condition);	
		}

		$this->db->select ('count(*) as Count, date');
		$query = ($this->db->get($table));
		
		$query->row();
		
		if (isset($query->result_object[0])) {
			foreach ($query->result_object as $pro) {
				$data[$pro->date] = $pro->Count;
			}
			return $data;
		}
		else 
			return array();
		
	}
	
	
}?>