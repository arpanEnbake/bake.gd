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
	
	
	// Make sure a link keyword (ie "1fv" as in "site.com/1fv") is valid.
	function yourls_sanitize_string( $string ) {
		// make a regexp pattern with the shorturl charset, and remove everything but this
		$pattern = $this->yourls_make_regexp_pattern( yourls_get_shorturl_charset() );
		$valid = substr(preg_replace('/[^'.$pattern.']/', '', $string ), 0, 199);
		
		return yourls_apply_filter( 'sanitize_string', $valid, $string );
	}
	
	// Determine the allowed character set in short URLs
	function yourls_get_shorturl_charset() {
		static $charset = null;
		if( $charset !== null )
			return $charset;
			
		if( !defined('YOURLS_URL_CONVERT') ) {
			$charset = '0123456789abcdefghijklmnopqrstuvwxyz';
		} else {
			switch( YOURLS_URL_CONVERT ) {
				case 36:
					$charset = '0123456789abcdefghijklmnopqrstuvwxyz';
					break;
				case 62:
				case 64: // just because some people get this wrong in their config.php
					$charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
			}
		}
		
		$charset = $this->yourls_apply_filter( 'get_shorturl_charset', $charset );
		return $charset;
	}

		// A few sanity checks on the URL
	function yourls_sanitize_url($url) {
		// make sure there's only one 'http://' at the beginning (prevents pasting a URL right after the default 'http://')
		$url = str_replace('http://http://', 'http://', $url);
	
		// make sure there's a protocol, add http:// if not
		if ( !preg_match('!^([a-zA-Z]+://)!', $url ) )
			$url = 'http://'.$url;
		
		$url = $this->yourls_clean_url($url);
		
		return substr( $url, 0, 1999 );
	}
	
	// Function to filter all invalid characters from a URL. Stolen from WP's clean_url()
	function yourls_clean_url( $url ) {
		$url = preg_replace('|[^a-z0-9-~+_.?\[\]\^#=!&;,/:%@$\|*\'"()\\x80-\\xff]|i', '', $url );
		$strip = array('%0d', '%0a', '%0D', '%0A');
		$url = $this->yourls_deep_replace($strip, $url);
		$url = str_replace(';//', '://', $url);
		$url = str_replace('&amp;', '&', $url); // Revert & not to break query strings
		
		return $url;
	}
	
	// Perform a replacement while a string is found, eg $subject = '%0%0%0DDD', $search ='%0D' -> $result =''
	// Stolen from WP's _deep_replace
	function yourls_deep_replace($search, $subject){
		$found = true;
		while($found) {
			$found = false;
			foreach( (array) $search as $val ) {
				while(strpos($subject, $val) !== false) {
					$found = true;
					$subject = str_replace($val, '', $subject);
				}
			}
		}
		
		return $subject;
	}
	
		// Escape a string
	function yourls_escape( $in ) {
		return mysql_real_escape_string($in);
	}

		// Is an URL a short URL?
	function yourls_is_shorturl( $shorturl ) {
		// TODO: make sure this function evolves with the feature set.
		
		$is_short = false;
		$keyword = preg_replace( '!^'.base_url().'/!', '', $shorturl ); // accept either 'http://ozh.in/abc' or 'abc'
		if( $keyword && $keyword == $this->yourls_sanitize_string( $keyword ) 
				/*&& $this->yourls_keyword_is_taken( $keyword )*/ ) {
			$is_short = true;
		}
		
		return false;
	}
	
	// Returns a sanitized a user agent string. Given what I found on http://www.user-agents.org/ it should be OK.
	function yourls_get_user_agent() {
		if ( !isset( $_SERVER['HTTP_USER_AGENT'] ) )
			return '-';
		
		$ua = strip_tags( html_entity_decode( $_SERVER['HTTP_USER_AGENT'] ));
		$ua = preg_replace('![^0-9a-zA-Z\':., /{}\(\)\[\]\+@&\!\?;_\-=~\*\#]!', '', $ua );
		
		return substr( $ua, 0, 254 );
	}

	// Function: Get IP Address. Returns a DB safe string.
	function yourls_get_IP() {
		if( !empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else if(!empty($_SERVER['HTTP_VIA '])) {
				$ip = $_SERVER['HTTP_VIA '];
			}
		}
	
		return $ip;
	}
	
	// Converts an IP to a 2 letter country code, using GeoIP database if available in includes/geo/
	function yourls_geo_ip_to_countrycode( $ip = '', $default = '' ) {
		// allow a plugin to shortcircuit the Geo IP API
		$location = null;
		$default = null;

			
		if ( !file_exists( '/geo/GeoIP.dat') || !file_exists( '/geo/geoip.inc') )
			return $default;
	
		if ( $ip == '' )
			$ip = $this->yourls_get_IP();
		
		require_once('/geo/geoip.inc') ;
		$gi = geoip_open( YOURLS_INC.'/geo/GeoIP.dat', GEOIP_STANDARD);
		$location = geoip_country_code_by_addr($gi, $ip);
		geoip_close($gi);
	
		return $location;
	}
	
	
}
?>