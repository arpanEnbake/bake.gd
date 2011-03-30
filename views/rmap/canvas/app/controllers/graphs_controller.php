<?php
class GraphsController extends AppController {

	var $name = 'Graphs';
	var $helpers = array('Javascript');
	var $components = array('RequestHandler');
	var $uses=array();
	function index(){		
	}
	
	function barchartdata(){
				
		$this->autoRender = false;
		if ( $this->RequestHandler->isAjax() ) {
		   Configure::write ( 'debug', 0 );		   
		}		
		
		$units_pre = '$';
		$title = 'Sales in the last 8 months (tooltips)';
		$key = array('faheem', 'arpan', 'deepak', 'money');
		$keycolors = array('red', 'yellow', 'green', 'orange');
		$labels = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September','October','November','December');
		$tooltips = array();
		foreach($labels as $label){
			foreach($key as $k){
				$tooltips[] = $k;
			}
		}		
		
		$json = array(
			'units_pre' => $units_pre,
			'title' => $title, 
			'labels' =>$labels, 
			'colors' => $keycolors,
			'key' => $key,
			'tooltips' => $tooltips,
			'data' => array(
				array(20,20,19,21),
				array(23,25, 27, 30),
				array(30,25,29, 32),
				array(30,25,29, 32),
				array(27,28,35,33),
				array(26,18,29,30),
				array(31,20,25,27),
				array(39,28,28,35),
				array(27,29,28,29),
				array(26,23,26,27),
				array(30,20,19,21),
				array(30,20,19,21),
				array(30,20,19,21)
			)			
		);
			
		echo json_encode($json);	
			
	}
}
?>
