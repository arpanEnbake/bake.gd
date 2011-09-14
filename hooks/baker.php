<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Baker Class
 *
 * This class loads up the bakegd enviornment
 *
 * @package     CodeIgniter
 * @subpackage  Hooks
 * @category    Hooks
 * @author      enbake
 * @version     1.0
 */
class Baker
{
	/*
	 * Load the bakegd environment.
	 */
	function doLoadEnvironment() {
		$CI =& get_instance();
		$router =& load_class('Router');
		$called_function = $router->fetch_method();

		$user_name = preg_replace("/^(.*?)\.(.*)\.(.*)$/","$1",$_SERVER['HTTP_HOST']);
	}
}
