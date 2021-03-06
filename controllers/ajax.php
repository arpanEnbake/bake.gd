<?php 

class Ajax extends Controller {
	var $key = array('facebook', 'twitter', 'linkedin', 'Others');
	var $media = array('likes', 'retweets');
	var $keycolors = array('red', 'yellow', 'green', 'orange');	

	var $data = array();
	var $account = null;
	
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
		
		$this->load->library(array('account/authentication'));
		$this->load->model(array('account/account_model','account/account_details_model'));
		if ($this->authentication->is_signed_in())
		{
			$this->account = $this->account_model->get_by_id($this->session->userdata('account_id'));
		}
		$this->load->model(array('Url_model', 'account/social_data_model'));
	}

	function get_click_data($start_time = null, $end_time = null, $url_id = null) {
		$account_id = null;
		
		// if for one url, a/c doesnt matter
		if (!$url_id)
			$account_id = $this->session->userdata('account_id');
			
		$clicks = $this->Url_model->get_click_counts($start_time, $end_time, 
					$account_id, $url_id);
		return $clicks;
	}
	
	function get_media_data($start_time = null, $end_time = null, $url_id = null) {
		$status_id = null;$tweet_id = null;
		$data = array('likes' => 0, 'retweets' => 0);
		$account_id = null;
		
		// if for one url, a/c doesnt matter
		if ($url_id) {
			$query = $this->db->get_where('yourls_url', array('id' => $url_id));
			$query->row();
			$url = null;
			if (!isset($query->result_object[0]))
				return data;
			$status_id = $query->result_object[0]->status_id;
			$tweet_id =  $query->result_object[0]->tweet_id;
			
			// only fire if thre is sharing
			if ($status_id)
				$data['likes'] = $this->social_data_model->fb_likes($start_time, $end_time, $account_id, $status_id);
			if ($tweet_id)
				$data['retweets'] = $this->social_data_model->tw_retweets($start_time, $end_time, $account_id, $tweet_id);
		} else {
			$account_id = $this->session->userdata('account_id');
			$data['likes'] = $this->social_data_model->fb_likes($start_time, $end_time, $account_id, $status_id);
			$data['retweets'] = $this->social_data_model->tw_retweets($start_time, $end_time, $account_id, $tweet_id);
		}
		return $data;
	}
	
	function get_location_data($start_time = null, $end_time = null, $url_id = null) {
		$account_id = null;
		
		// if for one url, a/c doesnt matter
		if (!$url_id) {
			$account_id = $this->session->userdata('account_id');
		}
		$data = $this->Url_model->get_location($start_time, $end_time, 
				$account_id , $url_id);
		return $data;
	}

	function _output($output) {
		echo json_encode($this->json_data);
	}
	
	function barchartdata($timePeriod = 1, $url_id = null){
		$units_pre = '';
		$i = 0;
		$tot_less_days = floor($timePeriod / 24);
		$data = null;
		$interval = 5 * 60;
		$hourly = $tot_less_days == 0 ? true: false;
		$tot_intervals = $timePeriod * 60 * 60 / $interval;

		if ($hourly) {
			for ($i = $tot_intervals - 1; $i >= 0 ; --$i) {
				$label =	$this->subtractTime('H:m:s', 0, 0, 300);
				if ($tot_intervals > 20 && $i % 2 != 0 && $i > 0) {
					$label = ' ';
				}
				$labels[] = $label;
				$data[] = array();
			}
		}
		 else {
		 	$skip = false;
			for ($i = $tot_less_days - 1; $i >=0 ; --$i) {
				$label = date('M d', strtotime("-{$i} day"));
				if ($tot_less_days > 20 && $skip) {
					$label = ' ';
				}
				$skip = !$skip;
				
				$labels[] = $label;
				$data[] = array();
			}
		}

		$tooltips = array();
		foreach($labels as $label){
			// only initialization for later use
			$tooltips[] = array(count($this->key));
		}		

		$prev_start_time = date('Y-m-d H:m:s');
		for ($i = 1; $i <= count($labels); ++$i) {
			$end_time = $prev_start_time;

			$prev_day = date('Y-m-d');
			$prev_time = date('H:m:s');
			if (!$hourly) {
				$prev_day	= date('Y-m-d', strtotime("-{$i} day"));
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
			
			$clicks = $this->get_click_data($start_time, $end_time, $url_id);
			$prev_start_time = $start_time;
			
			$org_data = null;
			foreach($this->key as $index => $media) {
				$org_data[$index] = 0;
			}		
			
			if ($clicks) {
				foreach($this->key as $index => $media) {
					foreach($clicks as $click) {
						if ($click->referrer == $media) {
							$org_data[$index] = $click->Count * 1;
							break;
						}
					}
				}
			}
			
			// tool tip creation in reverse order
			foreach($this->key as $index => $media) {
				// count the index of prev entries and add 
				$tooltip_index = ($tot_less_days - $i) * count($this->key);
				$str = "({$org_data[$index]})";
				if ($org_data[$index] != '0')
					$tooltips[$tooltip_index + $index] = $media . $str;
				else 
					$tooltips[$tooltip_index + $index] = $index; 
			}
			$data[$tot_less_days - $i] = $org_data;
		}
		
		// for highcharts transposing array
		foreach($data as $key => $value) {
			foreach($value as $index => $val) {
				$high_data[$index]['data'][] = $val;
				$high_data[$index]['name'] = $this->key[$index];				
			}
		}
		
		$json = array(
			'units_pre' => $units_pre,
//			'title' => $title, 
			'labels' =>$labels, 
			//'colors' => $this->keycolors,
			'key' => $this->key,
			'tooltips' => $tooltips,
			'data' => $high_data,
		);
			
		$this->json_data = $json;	
			
	}
	
	function linechartdata($timePeriod = 1, $url_id = null){
		$units_pre = '';
		$i = 0;
		$tot_less_days = floor($timePeriod / 24);
		$data = null;
		$interval = 5 * 60;
		$hourly = $tot_less_days == 0 ? true: false;
		$tot_intervals = $timePeriod * 60 * 60 / $interval;

		if ($hourly) {
			for ($i = $tot_intervals - 1; $i >= 0 ; --$i) {
				$label =	$this->subtractTime('H:m:s', 0, 0, 300);
				if ($tot_intervals > 20 && $i % 2 != 0) {
					$label = ' ';
				}
				$labels[] = $label;
			}
		}
		 else {
			for ($i = $tot_less_days - 1; $i >=0 ; --$i) {
				$label = date('M-d', strtotime("-{$i} day"));
				// for alternative texts in case graph is too big
				if ($tot_less_days > 20 && $i % 2 != 0) {
					$label = ' ';
				}
				$labels[] = $label;
			}
		}
		
		$total = array('likes' => 0, 'retweets' => 0);

		$end_time = date('Y-m-d');
		$start_time	= date('Y-m-d', strtotime("-{$tot_less_days} day"));
		$raw_data = $this->get_media_data($start_time, $end_time, $url_id);

		foreach($this->media as $key => $med) {
			$inner_data = null;
			for ($i = $tot_less_days - 1; $i >= 0  ; --$i) {
				$day	= date('Y-m-d', strtotime("-{$i} day"));
				$value = 0;
				if (isset($raw_data[$med][$day])) {
					$value= $raw_data[$med][$day];
					$total[$med]+= $value;
				} 
				$tooltips[] = $value;
				$inner_data[] = $value;
			}
			$data[] = $inner_data;
		}
		
		
		$json = array(
			'units_pre' => $units_pre,
//			'title' => $title, 
			'labels' =>$labels, 
			//'colors' => $this->keycolors,
			'key' => $this->media,
			'tooltips' => $tooltips,
			'data' => $data,
			'total' => $total
		);
			
		$this->json_data = $json;	
			
	}
	
	function piechartdata($timePeriod = 1, $url_id = null){
		$units_pre = '';
		$i = 0;
		$tot_less_days = floor($timePeriod / 24);
		$data = null;
		$interval = 5 * 60;
		$hourly = $tot_less_days == 0 ? true: false;
		$tot_intervals = $timePeriod * 60 * 60 / $interval;
		$total_count = 0; // total count for %ages

		$end_time = date('Y-m-d');
		$start_time	= date('Y-m-d', strtotime("-{$tot_less_days} day"));
		$locations = $this->get_location_data($start_time, $end_time, $url_id);

		if ($locations) {
			foreach($locations as $loc) {
				if (!isset($locations[$loc->country_code])) {
					$key = $loc->country_code == '' ? 'Unknown' : $loc->country_code;
					$raw_data[$key] = 0;
				}
				$raw_data[$key] += $loc->Count;
				$total_count += $loc->Count;
			}
			
			foreach($raw_data as $key => &$val) {
				if ($total_count > 1000) {
					// convert this to thousands later
				}
				// convert to %ages, pain in the back
				$data[$key] = round($val / $total_count * 100,0);
			}
			$json = array(
				'key' => array_keys($raw_data),
				'data' => $raw_data,
				'percent' => $data
			);
			
			$this->json_data = $json;	
		}
			
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