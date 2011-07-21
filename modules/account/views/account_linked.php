<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo lang('linked_page_name'); ?></title>
<base href="<?php echo base_url(); ?>" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
<link type="text/css" rel="stylesheet" href="resource/app/css/bake.css" />
</head>
<body class="account_linked">
<?php echo $this->load->view('inner_elements/header_new'); ?>
<div id="mainBody" style="min-height: 410px;">
	<div id="body">
		<?php if ($this->session->flashdata('linked_info')) { ?>
		<div class="flash rounded">
			<?php echo $this->session->flashdata('linked_info'); ?>
		</div>
		<?php } ?>
		<div class="subheader">
			<span style="float:left">
				<h1><?php echo lang('linked_page_name'); ?></h1>
			</span>
			<span style="float:right;">
				<ul>
					<li><?php echo anchor('account/account_settings', lang('website_account')); ?></li>
					<li><?php echo anchor('account/account_profile', lang('website_profile')); ?></li>
				</ul>
			</span>
		</div>
		<div class="clear"></div>
		<div class="settings_block">
			<table width="100%" border="0" cellspacing="3" cellpadding="0">
				<tr>
					<td colspan="3" height="30" align="left" valign="middle" bgcolor="#bcdcfa">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="15%" align="center" valign="middle"><strong>Service</strong></td>
								<td width="55%" align="center" valign="middle"><strong>Account</strong></td>
								<td width="30%" align="center" valign="middle"><strong>Actions</strong></td>
							</tr>
						</table>
					</td>
				</tr>
				<?php if ($num_of_linked_accounts == 0) { ?>
					<tr><td><?php echo lang('linked_no_linked_accounts'); ?></td></tr>
				<?php } else { ?>
				<?php foreach ($twitter_links as $twitter_link) { ?>
				<tr>
					<td width="15%" class="blue-bottom-border">
						<img src="resource/app/img/icon/twitter.png" alt="<?php echo lang('connect_twitter'); ?>" title="<?php echo lang('connect_twitter'); ?>" width="40" />
					</td>
					<td width="55%" class="blue-bottom-border">
						<?php echo lang('connect_twitter'); ?><br />
						<?php echo anchor('http://twitter.com/'.$twitter_link->twitter->screen_name, substr('http://twitter.com/'.$twitter_link->twitter->screen_name, 0, 30).(strlen('http://twitter.com/'.$twitter_link->twitter->screen_name) > 30 ? '...' : ''), array('target' => '_blank', 'title' => 'http://twitter.com/'.$twitter_link->twitter->screen_name)); ?>
							&nbsp;[<?php echo $twitter_link->default == 1 ? 'Default' : anchor("/account/connect_twitter/default/$twitter_link->twitter_id/$account->id",
							'Mark as Default');?>]
					</td>
					<?php if ($num_of_linked_accounts != 1) { ?>
					<td width="30%" class="blue-bottom-border">
						<?php echo form_open(uri_string()); ?>
						<?php echo form_hidden('twitter_id', $twitter_link->twitter_id); ?>
						<?php echo form_button(array(
									'type' => 'submit',
									'class' => 'button',
									'content' => lang('linked_remove')
						)); ?>
		            <?php echo form_close(); ?>
	            </td>
					<?php } ?>
				</tr>
				<?php } ?>
				<?php foreach ($facebook_links as $facebook_link) { ?>
				<tr>
				<td width="15%" class="blue-bottom-border">
					<img src="resource/app/img/icon/facebook.png" alt="<?php echo lang('connect_facebook'); ?>" title="<?php echo lang('connect_facebook'); ?>" width="40" />
				</td>
				<td width="55%" class="blue-bottom-border">
					<?php echo lang('connect_facebook'); ?><br />
					<?php echo anchor('http://facebook.com/profile.php?id='.$facebook_link->facebook_id, substr('http://facebook.com/profile.php?id='.$facebook_link->facebook_id, 0, 30).(strlen('http://facebook.com/profile.php?id='.$facebook_link->facebook_id) > 30 ? '...' : ''), array('target' => '_blank', 'title' => 'http://facebook.com/profile.php?id='.$facebook_link->facebook_id)); ?>
				</td>
				<td width="30%" class="blue-bottom-border">
				<?php if ($num_of_linked_accounts != 1) { ?>
					<?php echo form_open(uri_string()); ?>
					<?php echo form_hidden('facebook_id', $facebook_link->facebook_id); ?>
					<?php echo form_button(array(
								'type' => 'submit',
								'class' => 'button',
								'content' => lang('linked_remove')
						)); ?>
					<?php echo form_close(); ?>
				<?php } ?>
				</td>
				</tr>
				<?php } ?>
				<?php foreach ($openid_links as $openid_link) { ?>
				<tr></tr>
				<td width="15%" class="blue-bottom-border">
					<img src="resource/app/img/icon/<?php echo $openid_link->provider; ?>.png" alt="<?php echo lang('connect_'.$openid_link->provider); ?>" width="40" />
				</td>
				<td width="55%" class="blue-bottom-border">
					<?php echo lang('connect_'.$openid_link->provider); ?><br />
					<?php echo anchor($openid_link->openid, substr($openid_link->openid, 0, 30).(strlen($openid_link->openid) > 30 ? '...' : ''), array('target' => '_blank', 'title' => $openid_link->openid)); ?>
				</td>
				<td width="30%" class="blue-bottom-border">
				<?php if ($num_of_linked_accounts != 1) { ?>
					<?php echo form_open(uri_string()); ?>
					<?php echo form_hidden('openid', $openid_link->openid); ?>
					<?php echo form_button(array(
									'type' => 'submit',
									'class' => 'button',
									'content' => lang('linked_remove'))); ?>
				<?php echo form_close(); ?>
				<?php } ?>
				</td>
				<?php } ?>
				<?php } // end the linked accounts if ?>
			</table>
			<div class="link_accounts">
			<h3><?php echo lang('linked_link_with_your_account_from'); ?></h3>
			</div>
			<?php if ($this->session->flashdata('linked_error')) : ?>
				<div class="form_error"><?php echo $this->session->flashdata('linked_error'); ?></div>
				<?php endif; ?>
				<div id="openid_btns">
					<a title="log in with Facebook" style="background: #fff url(resource/app/images/openid-logos.png); background-position: -1px -456px" class="facebook openid_large_btn" href="account/connect_facebook"></a>
					<a title="log in with Twitter" style="background: #fff url(resource/app/images/openid-logos.png); background-position: -1px -518px" class="twitter openid_large_btn" href="account/connect_twitter"></a>
					<a title="log in with Google" class="google openid_large_btn" href="account/connect_google"></a>
					<a title="log in with Yahoo"  class="yahoo openid_large_btn" href="account/connect_yahoo"></a>
					<a title="log in with MyOpenID" style="background: #fff url(resource/app/images/openid-logos.png); background-position: -1px -187px" class="myopenid openid_large_btn"  href="account/connect_openid"></a>
				</div>
			</div>
			<div class="tile right" style="text-align: left;">
				<h3>Why link multiple accounts</h3>
				<p>Linking multiple accounts will help you track your links on multiple platform
				 and hence enabling more data for your analysis.</p>
			</div>
			<div class="clear"></div>
		</div>
		</div>
<?php echo $this->load->view('footer'); ?>
</body>
</html>