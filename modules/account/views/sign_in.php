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
<div id="mainBody" style="min-height: 410px;">
	<div id="body">
		<div class="content">
			<div class="subheader">
				<h1 style="text-align:left;"><?php echo lang('sign_in_third_party_heading'); ?></h2>
			</div>
			<div class="clear"></div>
			<div style="width:600px;">
				<div id="openid_btns">
					<a title="log in with Facebook" style="background: #fff url(resource/app/images/openid-logos.png); background-position: -1px -456px" class="facebook openid_large_btn"></a>
					<a title="log in with Twitter" style="background: #fff url(resource/app/images/openid-logos.png); background-position: -1px -518px" class="twitter openid_large_btn"></a>
					<a title="log in with Google" class="google openid_large_btn"></a>
					<a title="log in with Yahoo"  class="yahoo openid_large_btn"></a>
					<a title="log in with MyOpenID" style="background: #fff url(resource/app/images/openid-logos.png); background-position: -1px -187px" class="myopenid openid_large_btn"></a>								</div>
			</div>
			<div class="right_signin">
				<h2>Why Sign in?</h2>
				<img src="resource/app/images/sidebar.jpg">
				<ul>
				Signing in helps you tracks the analytics.
				Also, you get access to a lot of application
				features which you dont get otherwise.
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<div class="clear"></div>

<?php echo $this->load->view('footer'); ?>
</body>
</html>