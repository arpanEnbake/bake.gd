<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta content="IE=8" http-equiv="X-UA-Compatible" />
	<meta name="keywords" content="bake.gd, brand building, link marketting" />
	<meta name="description" content="bake.gd, build your brand with every short link" />
	

	<base href="<?php echo base_url(); ?>" />

	<title>bake.gd | Metrics Summary</title>
<!-- Stylesheets-->
	<link rel="stylesheet" href="resource/app/js/RGraph/css/website.css" type="text/css" media="screen" />
	<link href="resource/app/css/inner.css" rel="stylesheet"  type="text/css">

	<!--[if lte IE 8]>
	<link rel="stylesheet" href="IE.css" type="text/css" charset="utf-8" />
	<![endif]-->
	<link rel="icon" type="image/png" href="favicon.png" />

<!-- scripts-->
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
	<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="js/moo.js"></script>
	<script type="text/javascript" src="js/hero.js"></script>
</head>
<?php $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>

<body>
<!-- HEADER START-->
<div id="mainHeader">
<div id="header">
<ul class="ul">
<li><a href="<?php echo base_url()?>"<?php if((!isset($selected_menu) || $selected_menu == 'Default')) 
		echo 'class="active"'?>>Shorten & Share</a></li>
<li><a href="<?php echo base_url()?>analytics"<?php if((isset($selected_menu) && $selected_menu == 'Analyze')) 
		echo 'class="active"'?>>Analyze  </a></li>
<li><?php echo anchor('account/sign_out', lang('website_sign_out')); ?></a></li>
</ul>
<div class="loginBtns"><img src="<?php echo $account_details->picture?>"><strong>
<?php echo anchor('account/account_settings', $account->username); ?></strong>&nbsp;</div>
<p><img src="resource/app/images/inner_logo.jpg" width="98" height="34"></p>


</div>
</div>
<!-- HEADER END-->