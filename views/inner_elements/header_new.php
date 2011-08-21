<?php $CI = &get_instance(); ?>
<?php if ($CI->session->userdata('account')) { ?>
<div id="header">
	<div class="bar">
		<span class="logo"><img src="resource/app/images/logoWhite.png"></span>
		<div style="float:right;">
			<ul class="ul">
				<li>
					<a href="<?php echo base_url()?>"<?php if((!isset($selected_menu) || $selected_menu == 'Default')) 
						echo 'class="active"'?>>Shorten & Share</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>analytics"<?php if((isset($selected_menu) && $selected_menu == 'Analyze')) 
						echo 'class="active"'?>>Analyze</a>
				</li>
				<li>
					<?php echo anchor('account/sign_out', lang('website_sign_out')); ?>
				</li>
			</ul>
		</div>
		<div style="float:right;margin-right:30px; margin-top:5px;">
			<?php echo anchor('account/account_settings',
					"<span class=\"user_avatar rounded\" style=\"background-image: url({$account_details->picture});\"></span>"); ?>
		</div>
	</div>
</div>
<?php } else { ?>
<div id="header">
	<div class="bar">
		<span class="logo"><a href="<?php echo base_url()?>"><img src="resource/app/images/logoWhite.png"></a></span>
		<div style="float:left;">
			<ul class="ul">
				<li><a href="#">Home</a></li>
				<li><a href="#">Tour</a></li>
				<li><a href="#">Our Customers</a></li>
			</ul>
		</div>
		<div class="loginBtns">
			<a href="<?php echo 'account/connect_twitter'?>" class="twitter-sign"><img src="resource/app/images/tl.png" width="84" height="26" ></a>
			<a href="<?php echo 'account/connect_facebook'?>"><img src="resource/app/images/fl.png" width="84" height="26"></a>
			<a href="#"><img src="resource/app/images/gl.png" width="84" height="26"></a>
		</div>
	</div>
</div>
<?php } ?>