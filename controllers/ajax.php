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
		$i = 0;
		
		$key = array('facebook', 'twitter', 'linkedin', 'Others');
		$keycolors = array('red', 'yellow', 'green', 'orange');

		$tot_less_days = floor($timePeriod / 24);
		$data = null;
		$interval = 5 * 60;
		$hourly = $tot_less_days == 0 ? true: false;
		$tot_intervals = $timePeriod * 60 * 60 / $interval;

		if ($hourly) {
			for ($i = $tot_intervals - 1; $i >= 0 ; --$i) {
				echo date('H:m:s' , strtotime(time() - 30));
				$label =  $this->subtractTime('H:m:s', 0, 0, 300);
				if ($tot_intervals > 20 && $i % 2 != 0) {
					$label = ' ';
				}
				$labels[] = $label;
				$data[] = array();
			}
		}
		 else {
				
			for ($i = $tot_less_days - 1; $i >=0 ; --$i) {
				$label = date('M-d', strtotime("-{$i} day"));
				if ($tot_less_days > 20 && $i % 2 != 0) {
					$label = ' ';
				}
				$labels[] = $label;
				$data[] = array();
			}
		}


		$tooltips = array();
		foreach($labels as $label){
			foreach($key as $index => $k){
				// only initialization for later use
				$tooltips[] = $k;
			}
		}		

		$prev_start_time = date('Y-m-d H:m:s');
		for ($i = 1; $i <= count($labels); ++$i) {
			$end_time = $prev_start_time;

			$prev_day = date('Y-m-d');
			$prev_time = date('H:m:s');
			if (!$hourly) {
				$prev_day  = date('Y-m-d', strtotime("-{$i} day"));
			} else {
				$prev_time = date('H:m:s', time() - $i * $interval);
			}
			$prev_day_arr = explode('-', $prev_day);
			$prev_date = $prev_day_arr[2];
			$prev_month = $prev_day_arr[1];
			$prev_year = $prev_day_arr[0];
			
			$prev_time_arr = explode(':', $prev_time);
			$prev_sec = $prev_time_arr[2];
			$prev_min = $prev_time_arr[1];
			$prev_hour = $prev_time_arr[0];
			
			$start_time = "{$prev_year}-{$prev_month}-{$prev_date} {$prev_hour}:{$prev_min}:{$prev_sec}";
			
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
//			'title' => $title, 
			'labels' =>$labels, 
			//'colors' => $keycolors,
			'key' => $key,
			'tooltips' => $tooltips,
			'data' => $data,
		);
			
		$this->json_data = $json;	
			
	}
  
		
	function subtractTime($format, $hours = 0, $minutes=0, $seconds=0, $months=0, $days=0, $years = 0)
	{
		$totalHours = date("H") - $hours;
		
		$totalMinutes = date("i") - $minutes;
		
		$totalSeconds = date("s") - $seconds;
		
		$totalMonths = date("m") - $months;
		
		$totalDays = date("d") - $days;
		
		$totalYears = date("Y") - $years;
		
		$timeStamp = mktime($totalHours, $totalMinutes, $totalSeconds, $totalMonths, $totalDays, $totalYears);
		
		$myTime = date($format, $timeStamp);
		
		return $myTime;
		
	}

  
  
}  


