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

  	function get_click_data($start_time = null, $end_time = null) {
		$this->load->model(array('Url_model'));
		
		$clicks = $this->Url_model->get_click_counts($start_time, $end_time);
		return $clicks;
	}
	

  function _output($output) {
    echo json_encode($this->json_data);
  }
  
	function barchartdata($timePeriod = 1){

		$units_pre = '';
		$title = 'Clicks till date';
		$key = array('facebook', 'twitter', 'linkedin', 'Others');
		$keycolors = array('red', 'yellow', 'green', 'orange');

		$tot_less_days = floor($timePeriod / 24); 
		$data = null;
		
		for ($i = $tot_less_days - 1; $i >=0 ; --$i) {
			$labels[] = date('M-d', strtotime("-{$i} day"));
			$data[] = array();
		}

		$tooltips = array();
		foreach($labels as $label){
			foreach($key as $index => $k){
				// only initialization for later use
				 $tooltips[] = $k;
			}
		}		

		$prev_start_time = date('Y-m-d H:m:s');
		for ($i = 1; $i <= $tot_less_days; ++$i) {
			$end_time = $prev_start_time;

			$prev_day  = date('Y-m-d', strtotime("-{$i} day"));
			$prev_day_arr = explode('-', $prev_day);
			
			$prev_date = $prev_day_arr[2];
			$prev_month = $prev_day_arr[1];
			$prev_year = $prev_day_arr[0];
			
			$hour = date('H'); // $timePeriod - ($less_days * 24);
			$time = date('m:s');
			
			$start_time = "{$prev_year}-{$prev_month}-{$prev_date} {$hour}:{$time}";
			
			$clicks = $this->get_click_data($start_time, $end_time);
			$prev_start_time = $start_time;
			
			$org_data = null;

			foreach($key as $index => $media) {
				$org_data[$index] = 0;
			}		
			
			if ($clicks) {
				foreach($key as $index => $media) {
					foreach($clicks as $click) {
						if ($click->referrer == $media) {
							$org_data[$index] = $click->Count * 1;
							break;
						}
					}
				}
			}
			
			// tool tip creation in reverse order
			foreach($key as $index => $media) {
				// count the index of prev entries and add 
				$tooltip_index = ($tot_less_days - $i) * count($key);
				$str = "({$org_data[$index]})";
				if ($org_data[$index] != '0')
					$tooltips[$tooltip_index + $index] = $media . $str;
				else 
					$tooltips[$tooltip_index + $index] = $index; 
			}
			$data[$tot_less_days - $i] = $org_data;
		}
		
		$json = array(
			'units_pre' => $units_pre,
			'title' => $title, 
			'labels' =>$labels, 
			'colors' => $keycolors,
			'key' => $key,
			'tooltips' => $tooltips,
			'data' => $data,
		);
			
		$this->json_data = $json;	
			
	}
  
  
  
  
}  


