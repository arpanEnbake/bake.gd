<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php echo $this->load->view('header_new_includes');?>
<body>
<?php echo $this->load->view('inner_elements/header_new'); ?>
<div id="mainBody">
	<div id="body">
		<div class="subheader">
			<span style="float:left">
				<h1><?php echo lang('profile_page_name'); ?></h1>
			</span>
			<span style="float:right;">
				<ul>
					<li><?php echo anchor('account/account_linked', lang('linked_page_name')); ?></li>
					<li><?php echo anchor('account/account_settings', lang('settings_page_name')); ?></li>
				</ul>
			</span>
		</div>
		<div class="clear"></div>
		<div class="settings_block">
			<?php echo form_open_multipart(uri_string(), array('class' => 'settings_form')); ?>
			<?php if (isset($profile_info)) : ?>
			<div class="grid_8 alpha">
				<div class="form_info"><?php echo $profile_info; ?></div>
			</div>
			<div class="clear"></div>
			<?php endif; ?>
			<div class="form_row">
				<?php echo form_label(lang('profile_username'), 'profile_username'); ?>
				<div class="input_elem">
					<?php echo form_input(array(
						'name' => 'profile_username',
						'id' => 'profile_username',
						'value' => set_value('profile_username') ? set_value('profile_username') : (isset($account->username) ? $account->username : ''),
						'maxlength' => '24',
						'class' => 'text_input'
					)); ?>
					<?php echo form_error('profile_username'); ?>
					<?php if (isset($profile_username_error)) : ?>
					<span class="field_error"><?php echo $profile_username_error; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="form_row">
				<?php echo form_label(lang('profile_picture'), 'profile_picture'); ?>
				<div class="input_elem">
				<p>
					<?php if (isset($account_details->picture)) : ?>
					<img src="<?php echo $account_details->picture; ?>?t=<?php echo md5(time()); ?>" alt="" /> <?php echo anchor('account/account_profile/index/delete', lang('profile_delete_picture')); ?>
					<?php else : ?>
					<img src="resource/app/img/default-picture.gif" alt="" />
					<?php endif; ?>
				</p>
				<div class="clear"></div>
				<?php echo form_upload(array(
					'name' => 'account_picture_upload',
					'id' => 'account_picture_upload'
				)); ?>
				<p><small><?php echo lang('profile_picture_guidelines'); ?></small></p>
				<?php if (isset($profile_picture_error)) : ?>
				<span class="field_error"><?php echo $profile_picture_error; ?></span>
				<?php endif; ?>
				</div>
			</div>			
			<div class="clear"></div>
			<div class="prefix_2 grid_6 alpha">
				<?php echo form_button(array(
						'type' => 'submit',
						'class' => 'button',
						'content' => lang('profile_save')
					)); ?>
			</div>
			<?php echo form_close(); ?>
		</div>
		<div class="tile right">
			<h3>Profile settings</h3>
			<p>You can configure the profile settings here. The information that you set here would be
			 publicly visible.</p>
		</div>		
	</div>
	<div class="clear"></div>
</div>
<?php echo $this->load->view('footer'); ?>
</body>
</html>