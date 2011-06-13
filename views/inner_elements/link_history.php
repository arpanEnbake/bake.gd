<?php 
	if (!empty($urls) || isset($result['keyword'])) {
		$CI = &get_instance();

		if ($CI->session->userdata('account')) { 
?>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr>
		<td height="30" align="left" valign="middle" bgcolor="#bcdcfa">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="8%" align="center" valign="middle">Clicks</td>
					<td width="55%" align="left" valign="middle">Links</td>
					<td width="10%" align="left" valign="middle">Info Plus</td>
					<td width="15%" align="left" valign="middle">Date</td>
					<td width="17%" align="left" valign="middle">Share</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php 
		if (!empty($my_urls)) {
			foreach ($my_urls as $row) {
				$bake_url = 'http://' . $row->domain . '/' . $row->keyword;
	
				$this->load->view('inner_elements/link_history_result_auth',
						array('bake_url'=>$bake_url, 'url'=>$row->url,
								'id'=>$row->id, 'timestamp'=>$row->timestamp,
								'clicks'=>$row->clicks, 'title'=>$row->title,
								'fb'=>$fb, 'twitter'=>$twitter));
			}
		}
	?>
</table>
<?php } else { ?>
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
<?php } ?>