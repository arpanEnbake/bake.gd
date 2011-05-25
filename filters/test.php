<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Test filter - logs message on filter enter and exit
*/
class Test_filter extends Filter {
    function before() {
    	log_message('debug', 'Before '.$this->controller.' -> '.$this->method);
    }
    
    function after() {
    	log_message('debug', 'After '.$this->controller.' -> '.$this->method);
    }
}
?>