<li hash="fRi0f2" class="linkCapsule_link clearfix">
	<div class="shortened_url clearfix">
		<?php echo anchor($bake_url, $bake_url,
						array('class'=>"short_url", 'id' => "short_url_{$id}")) ?>
		<span class="copy_customize flash">
			<a style = "text-indent: 0px; " class="copy_button" id="copy_<?php echo $id?>"  href="javascript:void(0)">Copy</a>
			<div class="popup_error" id="copy-success-<?php  echo $id?>" style="display: none;"></div>
		</span>
	</div>
	<?php $str =  $bake_url . '+'; 
			echo anchor($str, 'Info Page+', array('class'=>"realtime_stats", 'style'=>"float:left"));?>
	<a target="_blank" href="#" class="long_link"><?php echo substr($url, 0, 50); ?></a>
	<span id="share_links">
	<?php
		$tw_flag = false; $fb_flag = false;
		
		if (isset($twitter)) {
			echo anchor("account/connect_twitter/post_status/{$twitter->twitter_id}/{$id}", 'Twitter', 
					array('class'=>"share_tw", 'rel' => $bake_url));
			if (!isset($fb)) {
				echo anchor("account/connect_facebook", 
					img(array('src'=>'resource/app/images/share/facebook.png','border'=>'0','alt'=>'facebook'))
				);
								
			}
			$tw_flag = true;
		}
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';
		if (isset($fb)) {
			$fb_flag = true;
			echo anchor("account/connect_facebook/post_wall/{$fb->facebook_id}/{$id}", 'Facebook'
			, 	array('class'=>"share_tw", 'rel' => $bake_url));
			if (!isset($twitter)) {
								echo anchor("account/connect_twitter", 
							img(array('src'=>'resource/app/images/share/twitter.png','border'=>'0','alt'=>'twitter'))
						)	;								
			}
			
		}
		if (!$tw_flag && !$fb_flag) {
			echo anchor('/account/account_linked', 'Link Your Accounts here');
		}

	?>
	</span>
</li>