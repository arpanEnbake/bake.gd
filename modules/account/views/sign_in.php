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
<?php echo $this->load->view('footer'); ?>
</body>
</html>