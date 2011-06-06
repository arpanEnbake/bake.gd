<?php 
	if (!empty($urls) || isset($result['keyword'])) {
?>
<div class="linkCapsule_link clearfix"> 
	<strong class="shortened_url">Shortened link</strong> 
	<strong class="realtime_stats">Stats</strong> 
	<strong class="long_link">Long link</strong> 
	<strong class="sharing_options">Sharing</strong> 
</div>
<div class="resultsContainer">
	<ul>
	<?php
		if (isset($result['keyword'])) {
				$bake_url = 'http://' . $result['domain'] . '/' . $result['keyword'];
				$this->load->view('inner_elements/link_history_result',
								array('bake_url'=>$bake_url, 'url'=>$result['url'],
										'id'=>$result['id'], 'fb'=>$fb, 'timestamp'=>null,
										'twitter'=>$twitter));
			 }
			foreach ($urls as $row)
			{
				$bake_url = 'http://' . $row->domain . '/' . $row->keyword;
				$this->load->view('inner_elements/link_history_result',
								array('bake_url'=>$bake_url, 'url'=>$row->url,
										'id'=>$row->id, 'fb'=>$fb, 'timestamp'=>$row->timestamp,
										'twitter'=>$twitter));
			}
		}
	?>
	</ul>
</div>