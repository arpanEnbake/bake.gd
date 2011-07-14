<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>bake.gd | Basic | Every link builds a brand</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="IE=8" http-equiv="X-UA-Compatible" />
<meta name="keywords" content="bake.gd, brand building, link marketting" />
<meta name="description" content="bake.gd, build your brand with every short link" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>

<base href="<?php echo base_url(); ?>" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />

<!-- Stylesheets-->
<link href="resource/app/css/bake.css" rel="stylesheet"  type="text/css">
<link href="resource/app/css/jquery-ui-1.8.13.custom.css" rel="stylesheet"  type="text/css">
<!--[if lte IE 8]>
<link rel="stylesheet" href="IE.css" type="text/css" charset="utf-8" />
<![endif]-->

<!-- scripts-->

</head>

<body class="unauth_home" onLoad="init()">

	<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="resource/app/js/jquery-ui-1.8.13.custom.min.js"></script>
	<script type="text/javascript" src="resource/app/js/jquery.cycle.js"></script>	
	<script src="resource/app/js/ZeroClipboard.js" type="text/javascript"></script>
	<div class="ext_bitly_chrome_promo_delay"></div>

<!-- HEADER START-->
<div>	
	<?php echo $this->load->view('inner_elements/header_new'); ?>
</div>
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
        </div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>

<?php echo $this->load->view('footer'); ?>
</body>
</html>