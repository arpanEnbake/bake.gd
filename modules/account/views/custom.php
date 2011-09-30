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
				<?php echo form_label(lang('settings_customdomain'),
											'settings_customdomain',
											array('style' => 'font-size:14px;width:140px;')); ?>
				<div class="input_elem">
				<?php echo form_input(array(
						'name' => 'settings_domain',
						'id' => 'settings_domain',
						'value' => set_value('settings_domain') ? set_value('settings_domain') : 
									(isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST']),
						'maxlength' => 40,
						'class' => 'text_input'
					)); ?>
				<?php echo form_button(array(
						'type' => 'submit',
						'class' => 'button',
						'content' => lang('settings_save')
					)); ?>
				</div>
			</div>
			<div class="clear"></div>
			
			<?php echo form_close(); ?>
			<div class="custom-faq">
				<h3>How do I set up my custom short domain?</h3>
				<p>To Use your own domain, please follow these 3 easy steps:</p>
				<ol>
					<li>Purchase the short domain you'd like to use. This domain can only be used for your shortened URLs.
					You can start your search at <a href="http://godaddy.com">godaddy.com</a>. Shorter the domain better it is.</li>
					<li>Fill up the domain name in the above edit box</li>
					<li>Create a DNS record for your domain. Using the control panel of the host with whom you registered your short domain (GoDaddy, etc), set the DNS A Record for your short domain to point to 107.20.179.200. If you are using a subdomain (such as s.bake.gd) as your custom short domain, you can set the CNAME Record for that subdomain to point to cname.bake.gd.</li>
				</ol>
				Remember that DNS changes can take up to 24 hours to propagate.
				Done !!
			</div>
		</div>
		<div class="tile right">
			<h3>Why Custom domain?</h3>
			<p style="text-align:justify;">
				The Custom Short Domain is the domain that takes the place of "bake.gd" in a shortened URL. It helps you to:<BR/>
				<ul class="custom-advantages">
					<li>Use your own domain name so that your links would appear like:<br />
					mydomain.com/bOm096G instead of bake.gd/b0m096G</li>
					<li>Brand your content across the web!</li>
					<li>Have shortened keywords of your choice.</li>
				</ul>
			</p>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php echo $this->load->view('footer'); ?>
</body>
</html>