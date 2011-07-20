<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php echo $this->load->view('header_new_includes');?>
<body>
<?php echo $this->load->view('inner_elements/header_new'); ?>
<div id="mainBody">
	<div id="body">
		<div class="subheader">
			<span style="float:left">
				<h1>Custom Domain</h1>
			</span>
			<span style="float:right;">
				<ul>
					<li><?php echo anchor('account/account_linked', lang('linked_page_name')); ?></li>
					<li><?php echo anchor('account/account_profile', lang('website_profile')); ?></li>
				</ul>
			</span>
		</div>
		<div class="clear"></div>
		<div class="settings_block">
			<?php echo form_open(uri_string(), array('class' => 'settings_form')); ?>
			<?php if (isset($settings_info)) : ?>
			<div class="grid_8 alpha">
				<div class="form_info"><?php echo $settings_info; ?></div>
			</div>
			<div class="clear"></div>
			<?php endif; ?>
			<div class="clear"></div>
			<div class="form_row">
			Create your custom domain based urls in 3 steps now
			<br></br>
			1. go to your hosting.
			<br></br>
			2. create add on domain
			<br></br>
			3. watch the video here how to do it
			<br></br>
			</div>
			<div class="form_row">
				<?php echo form_label(lang('settings_customdomain'), 'settings_customdomain'); ?>
				<div class="input_elem">
				<?php echo form_input(array(
						'name' => 'settings_domain',
						'id' => 'settings_domain',
						'value' => set_value('settings_domain') ? set_value('settings_domain') : 
									(isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST']),
						'maxlength' => 40,
						'class' => 'text_input'
					)); ?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="prefix_2 grid_6 alpha">
				<?php echo form_button(array(
						'type' => 'submit',
						'class' => 'button',
						'content' => lang('settings_save')
					)); ?>
			</div>
			
			<?php echo form_close(); ?>
		</div>
		<div class="tile right">
			<h3>Privacy</h3>
			<p><?php echo sprintf(lang('settings_privacy_statement'), anchor('page/privacy-policy', lang('settings_privacy_policy'))); ?></p>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php echo $this->load->view('footer'); ?>
</body>
</html>