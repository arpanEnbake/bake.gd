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

<body class="unauth_home" onLoad="">

	<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="resource/app/js/jquery-ui-1.8.13.custom.min.js"></script>
	<script type="text/javascript" src="resource/app/js/jquery.cycle.js"></script>	
	<script src="resource/app/js/ZeroClipboard.js" type="text/javascript"></script>
	<div class="ext_bitly_chrome_promo_delay"></div>
<?php $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>
<?php if(!isset($twitter)) $twitter = null;?>
<?php if(!isset($fb)) $fb = null;?>

<!-- HEADER START-->
<div>	
	<?php echo $this->load->view('inner_elements/header_new'); ?>
</div>

<?php echo  $this->load->view('analytics/graphs'); ?>
<?php echo $this->load->view('inner_elements/footer'); ?>
