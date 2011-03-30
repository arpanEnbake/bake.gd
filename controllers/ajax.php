<?php 

class Ajax extends Controller {

  var $json_data=Array(
    'error' => 1,
    'html' => 'Ajax Error: Invalid Request'
    );

  function __construct() {
    parent::Controller();
    $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
    $this->output->set_header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache");
  }

  	function get_click_data() {
		$this->load->model(array('Url_model'));
		
		$clicks = $this->Url_model->get_click_counts();
		return $clicks;
	}
	

  function _output($output) {
    echo json_encode($this->json_data);
  }
  
	function barchartdata(){
				
		$units_pre = '';
		$title = 'Clicks till date';
		$key = array('facebook', 'twitter', 'linkedin', 'Others');
		$keycolors = array('red', 'yellow', 'green', 'orange');
		$labels = array('January', 'February', 'March');
		$tooltips = array();
		foreach($labels as $label){
			foreach($key as $index => $k){
				$tooltips[] = $k;
				$org_data[$index] = 0;
			}
		}		

		$clicks = $this->get_click_data();
		$medias = array('facebook', 'twitter', 'Others');
		
		
		foreach($clicks as $click) {
			$flag = false;
			foreach($key as $index => $media) {
				if ($click->referrer == $media) {
					$org_data[$index] = $click->Count * 5;
					$flag = true;
				}
				if ($flag)
					break;
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
				$org_data,//array(20,20,19,21),
				$org_data,//array(23,25, 27, 30),
				$org_data,//array(30,25,29, 32),
			)			
		);
			
		$this->json_data = $json;	
			
	}
  
  
  
  
}  


