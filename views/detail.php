<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="nojs">
<!-- MIME TYPE Guidlines and references: http://hixie.ch/advocacy/xhtml -->
<head>
	<base href="<?php echo base_url(); ?>" />
	<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>
	
	<title>bake.gd | Metrics Summary</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="IE=8" http-equiv="X-UA-Compatible" />
	<meta name="keywords" content="bake.gd, brand building, link marketting" />
	<meta name="description" content="bake.gd, build your brand with every short link" />
	
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
	
	<link rel="stylesheet" href="resource/app/css/common.css" type="text/css" charset="utf-8" />
	<link rel="stylesheet" href="resource/app/js/RGraph/css/website.css" type="text/css" media="screen" />
	
	<!--[if lte IE 8]>
	<link rel="stylesheet" href="IE.css" type="text/css" charset="utf-8" />
	<![endif]-->
	<link rel="icon" type="image/png" href="favicon.png" />
	
	<style type="text/css">
	html:before, #middle:before { /* Opera and IE8 "redraw" bug fix */
	content:"";
	float:left;
	height:100%;
	margin-top:-999em;
	}
	</style>

</head>
<body class="unauth_home">
<?php echo $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>

<div id="external_container">
	<div id="container">
		<!-- Put Content Here -->
		<div id="notification" class="signed-in roundbtm" style="display:block;">
			<span id="top-nav">
				<span id="logo-top"><img src="resource/app/css/images/logo_top.gif" height="30px"/></span>
				<ul id="main_nav" class="clearfix">
					<li class=""><a href="/">Shorten &amp; Share</a></li>
					<li class="active"><a href="/a/analyze">Analyze</a></li>
					<li class=""><a href="/u/sarabdeep">Public Timeline</a></li>
					<li>
						<div id="loginContainer">
							<a class="user_link" href="/a/account">
								<span class="user_avatar rounded" 
								style="background-image: url(/http://graph.facebook.com/sarabdeeps/picture);"></span>sarabdeep</a>
						</div>
					</li>
				</ul>
				<div class="clearfix"></div>
			</span>
		</div>
		<div id="top"></div> <!-- end #top -->
		<div id="middle">
			<div style="width: 1000px;">
			<h1>Shortened URL: <?php echo 'http://' . $url->domain . '/' . $url->keyword;?></h1>
			Created on <?php echo $url->timestamp?> by <?php echo $user->username?>
			<h2>Keyword: <?php echo $url->keyword?></h2>
			<h2>URL: <?php echo $url->url?></h2>
			<h3>Clicks:</h3>
			<?php $total_count = 0;
				if (isset($clicks)) {
				foreach($clicks as $key => $count) {
					echo "Clicks via  $count->referrer : $count->Count <br />";
					$total_count += $count->Count;
				}
			}
			echo "Total Clicks: $total_count";
			?>
			
<?php echo "<h2>Retweets made : $retweets </h2><br />" ;?>
<?php echo "<h2>FB Likes : $likes </h2><br />" ;?>

			
			</div>
		</div>  <!-- END #middle -->
	</div>  <!-- end #container -->
	<div id="bottom"></div> <!-- end #bottom -->
</div> <!-- end #external_container -->


 <div id="footer">
© 2010 Enabake Consulting Pvt Ltd

<a href="#">Help</a>
<a href="#">API</a>
<a href="#">Privacy Policy</a>
<a href="#">TOS</a>

</div>

<!--[if IE]><script language="javascript" type="text/javascript" src="/s/v255/js/ie-hacks/excanvas.min.js"></script><![endif]-->



</body>
</html>