<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo lang('sign_in_page_name'); ?></title>
<base href="<?php echo base_url(); ?>" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
<link type="text/css" rel="stylesheet" href="resource/app/css/960gs.css" />
<link type="text/css" rel="stylesheet" href="resource/app/css/style.css" />
<link type="text/css" rel="stylesheet" href="resource/app/css/common.css" />
</head>
<body>
<div class="container_12">
	<div class="grid_12">
		<h2><?php echo lang('sign_in_page_name'); ?></h2>
	</div>
	<div class="clear"></div>
	<div class="prefix_1 grid_5" style="width:auto;">
		<h3><?php echo sprintf(lang('sign_in_third_party_heading')); ?></h3>
		<ul>
			<?php /*foreach($this->config->item('third_party_auth_providers') as $provider) :*/?>
			<li class="third_party <?php //echo $provider; ?>">
				<?php // echo anchor('account/connect_'.$provider, lang('connect_'.$provider), 
					//array('title'=>sprintf(lang('sign_in_with'), lang('connect_'.$provider)))); ?></li>
			<?php //endforeach; ?>
		</ul>
		<div id="openid_btns">
			<a title="log in with Facebook" style="background: #fff url(http://localhost/bakegd/resource/app/images/openid-logos.png); background-position: -1px -456px" class="facebook openid_large_btn"></a>
			<a title="log in with Twitter" style="background: #fff url(http://localhost/bakegd/resource/app/images/openid-logos.png); background-position: -1px -518px" class="twitter openid_large_btn"></a>
			<a title="log in with Google" class="google openid_large_btn"></a>
			<a title="log in with Yahoo"  class="yahoo openid_large_btn"></a>
			<a title="log in with MyOpenID" style="background: #fff url(http://localhost/bakegd/resource/app/images/openid-logos.png); background-position: -1px -187px" class="myopenid openid_large_btn"></a>				
			<div id="simple-openid-selector"><br>
            <div id="openid_input_area"></div>
            <p>Or, you can manually enter your OpenID</p>
            <table id="openid-url-input">
                <tbody><tr>         
                <td class="vt large">
                    <input id="openid_identifier" name="openid_identifier" class="openid-identifier" style="height:28px; width:500px;" type="text" tabindex="100">
                </td>
                <td class="vt large">
                    <input id="submit-button" style="margin-left:5px; height:36px;" type="submit" value="Log in" tabindex="101">
                </td>
                </tr>
            </tbody></table>             
        </div></div></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

<!--  is required for testing purposes.. can be removed after it. -->
<?php echo form_open(uri_string()); ?>
			<?php echo form_fieldset(); ?>
				<h3><?php echo lang('sign_in_heading'); ?></h3>
				<?php if (isset($sign_in_error)) : ?>
				<div class="grid_6 alpha">
					<div class="form_error"><?php echo $sign_in_error; ?></div>
				</div>
				<div class="clear"></div>
				<?php endif; ?>
				<div class="grid_2 alpha">
					<?php echo form_label(lang('sign_in_username_email'), 'sign_in_username_email'); ?>
				</div>
				<div class="grid_4 omega">
					<?php echo form_input(array(
							'name' => 'sign_in_username_email',
							'id' => 'sign_in_username_email',
							'value' => set_value('sign_in_username_email'),
							'maxlength' => '24'
						)); ?>
					<?php echo form_error('sign_in_username_email'); ?>
					<?php if (isset($sign_in_username_email_error)) : ?>
					<span class="field_error"><?php echo $sign_in_username_email_error; ?></span>
					<?php endif; ?>
				</div>
				<div class="clear"></div>
				<div class="grid_2 alpha">
					<?php echo form_label(lang('sign_in_password'), 'sign_in_password'); ?>
				</div>
				<div class="grid_4 omega">
					<?php echo form_password(array(
							'name' => 'sign_in_password',
							'id' => 'sign_in_password',
							'value' => set_value('sign_in_password')
						)); ?>
					<?php echo form_error('sign_in_password'); ?>
				</div>
				<div class="clear"></div>
				<?php if (isset($recaptcha)) : ?>
				<div class="prefix_2 grid_4 alpha">
					<?php echo $recaptcha; ?>
				</div>
				<?php if (isset($sign_in_recaptcha_error)) : ?>
				<div class="prefix_2 grid_4 alpha">
					<span class="field_error"><?php echo $sign_in_recaptcha_error; ?></span>
				</div>
				<?php endif; ?>
				<div class="clear"></div>
				<?php endif; ?>
				<div class="prefix_2 grid_4 alpha">
					<span>
						<?php echo form_button(array(
								'type' => 'submit',
								'class' => 'button',
								'content' => lang('sign_in_sign_in')
							)); ?>
					</span>
					<span>
						<?php echo form_checkbox(array(
								'name' => 'sign_in_remember',
								'id' => 'sign_in_remember',
								'value' => 'checked',
								'checked' => $this->input->post('sign_in_remember'),
								'class' => 'checkbox'
							)); ?>
						<?php echo form_label(lang('sign_in_remember_me'), 'sign_in_remember'); ?>
					</span>
				</div>
				
				
				
				
<?php echo $this->load->view('footer'); ?>
</body>
</html>