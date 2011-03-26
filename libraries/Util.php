<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *	Application utility library.
 *
 * Various utility functions used across the application.
 *
 * @package		Shortner
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Enbake Consulting pvt ltd
 */
class Util {
	/*
	 * Check if a particular ip is flooding the system.
	 */
	function check_ip_flood($ip='')
	{	
		//yourls_do_action( 'pre_check_ip_flood', $ip ); // at this point $ip can be '', check it if your plugin hooks in here
		if(( defined('FLOOD_DELAY_SECONDS') && FLOOD_DELAY_SECONDS === 0 ) 
				|| !defined('FLOOD_DELAY_SECONDS')
		) {
			return true;
		}
	
		$CI =& get_instance();
		$ip = $CI->input->ip_address();
		// Don't throttle whitelist IPs
		/* if( defined('YOURLS_FLOOD_IP_WHITELIST' && YOURLS_FLOOD_IP_WHITELIST ) ) {
			$whitelist_ips = explode( ',', YOURLS_FLOOD_IP_WHITELIST );
			foreach( (array)$whitelist_ips as $whitelist_ip ) {
				$whitelist_ip = trim( $whitelist_ip );
				if ( $whitelist_ip == $ip )
					return true;
			}
		} */
		
		// Don't throttle logged in users
		/* if( yourls_is_private() ) {
			 if( yourls_is_valid_user() === true )
				return true;
		}*/
		
		//yourls_do_action( 'check_ip_flood', $ip );
		$CI->load->database();
		$CI->db->select('timestamp')->from('yourls_url')->order_by('timestamp', 'desc')->limit(1);
		$lasttime = $CI->db->get()->row(0)->timestamp;

		if( $lasttime ) {
			$now = date( 'U' );
			$then = date( 'U', strtotime( $lasttime ) );
			if( ( $now - $then ) <= FLOOD_DELAY_SECONDS ) {
				// Flood!
				//yourls_do_action( 'ip_flood', $ip, $now - $then );
				print_r( 'Too many URLs added too fast. Slow down please.');
				exit;
			}
		}
		
		return true;
	}
}
?>	