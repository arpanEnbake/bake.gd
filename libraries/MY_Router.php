<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

/**
 * Router Class
 *
 * Extends MX Router
 *
 * @author	Original by EllisLab - extension by Too Pixel
 * @see	http://codeigniter.com/forums/viewthread/104074/P15/ to know whats going
 * on here.
 */

class MY_Router extends MX_Router {

	/**
		* Constructor
		
		* @access    public
		*/
		function MY_Router() {
			parent::MX_Router();
		}

	/**
		* Validate Routing Request
		*
		* This is a special code handle the static pages, the routing is otherwise
		* handled completely by MX router.
		* 
		* @access	public
		*/
		function _validate_request($segments)
		{
			// Check for a page to load in views/pages/ folder
			if (count($segments) == 1) {
				if(file_exists(APPPATH.'views/pages/'.$segments[0].EXT)) {
					array_unshift($segments, 'page', 'show');
					return $segments;
				}
			}

			return parent::_validate_request($segments);
		}
}
// END MY_Router class

/* End of file MY_Router.php */
/* Location: ./application/libraries/MY_Router.php */  