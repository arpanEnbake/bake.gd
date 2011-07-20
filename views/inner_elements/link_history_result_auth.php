<?php
	$to_time=strtotime($timestamp);
	$from_time=time();
	$days = round(abs($to_time - $from_time) / (60*24*60),0);

	if ($days < 1) {
		$hours = round(abs($to_time - $from_time) / (60*60),0);

		if ($hours < 1) {
			$time_str = round(abs($to_time - $from_time) / (60),0) . ' minutes ago.';
		} else {
			$time_str = $hours . ' hours ago.';
		}
	} else {
		$time_str = $days . ' days ago.';
	}
?>
<tr>
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="8%" align="center" valign="top" class="blue-bottom-border"><br><?php echo $clicks?><br>clicks</td>
				<td width="55%" align="left" valign="top" class="blue-bottom-border">
					<strong><?php echo anchor($bake_url, $title, 
  	        			array('class'=>"short_url", 'id' => "short_url_{$id}")) ?></strong><br>
					<div class="popup_error" id="copy-success-<?php  echo $id?>" style="display: none;"></div>
					<?php echo anchor($url, substr($url, 0, 50),
								array('class'=>"short_url", 'id' => "short_url_{$id}")) ?><br>
					<?php echo $bake_url?>&nbsp; - &nbsp;
					<a style = "text-indent: 0px; " class="copy_button" id="copy_<?php echo $id?>"  href="javascript:void(0)">Copy</a>
					<br>
				</td>
				<td width="10%" align="left" valign="top" class="blue-bottom-border"><?php echo anchor($bake_url.'+', 'Bake+', array('class'=>'bakeplus'))?></td>
				<td width="15%" align="left" valign="top" class="blue-bottom-border"><?php echo $time_str?></td>
				<td width="17%" align="left" valign="top" class="blue-bottom-border">
				<?php
				$tw_flag = false; $fb_flag = false;
				if (isset($twitter)) {
					echo anchor("account/connect_twitter/post_status/{$twitter->twitter_id}/{$id}", 
						img(array('src'=>'resource/app/images/share/twitter.png','border'=>'0','alt'=>'twitter'))
							, 	array('class'=>"share_tw", 'rel' => $bake_url));
							
					if (!isset($fb)) {
							echo anchor("account/connect_facebook", 
								img(array('src'=>'resource/app/images/share/facebook.png','border'=>'0','alt'=>'facebook'))
							);
						
					}
				}
				if (isset($fb)) {
					$fb_flag = true;
					echo anchor("account/connect_facebook/post_wall/{$fb->facebook_id}/{$id}", 
					img(array('src'=>'resource/app/images/share/facebook.png','border'=>'0','alt'=>'facebook'))
					, 	array('class'=>"share_tw", 'rel' => $bake_url));
					if (!isset($twitter)) {
								echo anchor("account/connect_twitter", 
							img(array('src'=>'resource/app/images/share/twitter.png','border'=>'0','alt'=>'twitter'))
						)	;								
					}
				}
					
				if (!$tw_flag && !$fb_flag) {
					echo anchor('/account/account_linked', 'Login now to start sharing');
				}
				?>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>