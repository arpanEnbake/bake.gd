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
<!--[if lte IE 8]>
<link rel="stylesheet" href="IE.css" type="text/css" charset="utf-8" />
<![endif]-->

<!-- scripts-->
<script type="text/javascript" src="resource/app/js/moo.js"></script>
<script type="text/javascript" src="resource/app/js/hero.js"></script>

</head>

<body class="unauth_home" onLoad="init()">

	<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>
	<script src="resource/app/js/ZeroClipboard.js" type="text/javascript"></script>
	<div class="ext_bitly_chrome_promo_delay"></div>
<?php $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>
<?php if(!isset($twitter)) $twitter = null;?>
<?php if(!isset($fb)) $fb = null;?>

<!-- HEADER START-->
<div id="mainHeader">
<div id="header">
<ul class="ul">
<li><a href="#">Home</a></li>
<li><a href="#">Our tour</a></li>
<li><a href="#">Cutomers</a></li>
</ul>
<div class="loginBtns"><a href="<?php echo 'account/connect_twitter'?>" class="twitter-sign"><img src="resource/app/images/tl.png" width="84" height="26" ></a>
<a href="<?php echo 'account/connect_facebook'?>"><img src="resource/app/images/fl.png" width="84" height="26"></a>
<a href="#"><img src="resource/app/images/gl.png" width="84" height="26"></a></div>
<p><img src="resource/app/images/logo.png"></p>

<div id="hero-container">
      <div class="hero-wrapper" id="hero-1">
      <div class="textContainer">Transform your business 
communications with bake.gd </div>
      <div class="imageContainer"><img src="resource/app/images/img1.png" width="648" height="346"></div> 
      </div>
      
      <div class="hero-wrapper" id="hero-2">
      <div class="textContainer">Transform your business communications with bake.gd </div>
      <div class="imageContainer"><img src="resource/app/images/img1.png" width="648" height="346"></div> 
      </div>
      
      <div class="hero-wrapper" id="hero-3">
      <div class="textContainer">Transform your business communications with bake.gd </div>
      <div class="imageContainer"><img src="resource/app/images/img1.png" width="648" height="346"></div> 
      </div>
      
      <div class="hero-wrapper" id="hero-4">
      <div class="textContainer">Transform your business communications with bake.gd </div>
      <div class="imageContainer"><img src="resource/app/images/img1.png" width="648" height="346"></div> 
      </div>
      
      <div class="hero-wrapper" id="hero-5">
      <div class="textContainer">Transform your business communications with bake.gd </div>
      <div class="imageContainer"><img src="resource/app/images/img1.png" width="648" height="346"></div> 
      </div>
      
      <ul id="hero-frames">
        <li><a class="frame-1-active" href="#1"><span>1</span></a></li>
        <li><a class="frame-2" href="#2"><span>2</span></a></li>
        <li><a class="frame-3" href="#3"><span>3</span></a></li>
        <li><a class="frame-3" href="#4"><span>3</span></a></li>
        <li><a class="frame-3" href="#5"><span>3</span></a></li>
      </ul>
    </div>
</div>
</div>
<!-- HEADER END-->


<!-- BODY START-->
<div id="mainBody">
<div id="body">
<?php 		echo validation_errors(); ?>
<?php if (isset($error))
		echo "<h2>{$error}</h2>";?>
<?php echo form_open('/home/index', array('id' => 'unAuthShortenForm')); ?>

<div class="shorten-textarea">

	<input type="text" id="shortenUnAuthContainer" name="url" value="<?php echo set_value('url', isset($Result['url']) ? $Result['url'] : null); ?>"></input>
		<input  class="btns" id="shorten_button" type="submit"></input>
</div>


<div class="BoxContainer">
<div class="box4">
	<table  width ="720px">
		<tr><th width="160px" style="text-align:left"><strong class="shortened_url">Shortened link</strong></th>`
				<th width="120px" style="text-align:left">	<strong class="realtime_stats">stats</strong></th>
				<th width="185px"  style="text-align:left">	<strong class="long_link">Long link</strong></th>
				<th width="156px"  style="text-align:center">	<strong class="sharing_options">Sharing</strong></th>
			</tr>
				<?php if (!empty($my_urls) || isset($Result['keyword'])) {
								if (isset($Result['keyword'])) {
									$bake_url = 'http://' . $Result['domain'] . '/' . $Result['keyword'];
									show_row($bake_url, $Result['url'], $Result['id'], null, $twitter, $fb);
								 }
								foreach ($my_urls as $row)
								{
									$bake_url = 'http://' . $row->domain . '/' . $row->keyword;
									show_row($bake_url, $row->url, $row->id, $row->timestamp, $twitter, $fb);
								}
							}

							?>
	</table>
			
</div>

<div class="box1"><img src="resource/app/images/box3.png" width="210" height="127"><p>Extra World</p>
<div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,...</div>
</div>

</div>

<div class="Container">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</div>
</div></div>
<!-- BODY END-->


<!-- FOOTER START-->
<div id="mainFooter">
<div id="footer">
<ul>
<p>Feature</p>
<li><a href="#">bakegd</a></li>
<li><a href="#">Phoine And Mobiles</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
</ul><ul>
<p>Price</p>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">Phoine And Mobiles</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
</ul>
<ul>
<p>Bussiness</p>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
</ul><ul>
<p>Services</p>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
<li><a href="#">bakegd</a></li>
</ul>
<div><img src="resource/app/images/followus.png"><a href="#"><img src="resource/app/images/f.png" width="45" height="41"></a><a href="#"><img src="resource/app/images/t.png" width="45" height="41"></a></div>
</div>
</div>

<?php function show_row($bake_url, $url, $url_id, $timestamp = null, $twitter = null, $fb = null) {?>
<tr>
							<td>
									<?php echo anchor($bake_url, $bake_url, array('class'=>"short_url", 'id' => "short_url_{$url_id}")) ?>
							</td>
							<td style="text-align:center">		
											<a style = "text-indent: 0px; " class="copy_button" id="copy_<?php echo $url_id?>"  href="javascript:void(0)">
													Copy
											</a>
							
								<div class="popup_error" id="copy-success-<?php  echo $url_id?>" style="display: none;"></div>
								<?php $str =  $bake_url . '+'; 
									echo anchor($str, 'Info Page+', array('class'=>"realtime_stats", 'style'=>"float:left"));?></a>
							</td>				
							<td>
								<div style="overflow:hidden; width:195px">	
								<a target="_blank" href="#" class="long_link"><?php echo substr($url, 0, 50); ?></a>
								</div>
							</td>
							<td  style="text-align:center">	
									<?php
										$tw_flag = false; $fb_flag = false;
										if (isset($twitter)) {
											echo anchor("account/connect_twitter/post_status/{$twitter->twitter_id}/{$url_id}", 'Twitter', 
													array('class'=>"share_tw", 'rel' => $bake_url));
											if (!isset($fb)) {
													echo anchor("account/connect_facebook", 'Connect Facebook');
											}
											$tw_flag = true;
										}
										echo '&nbsp;&nbsp;&nbsp;&nbsp;';
										if (isset($fb)) {
											$fb_flag = true;
											echo anchor("account/connect_facebook/post_wall/{$fb->facebook_id}/{$url_id}", 'Facebook'
											, 	array('class'=>"share_tw", 'rel' => $bake_url));
											if (!isset($twitter)) {
													echo anchor("account/connect_twitter", 'Connect Twitter');
											}
											
										}
										if (!$tw_flag && !$fb_flag) {
											echo anchor('/account/account_linked', 'Login now to start sharing');
										}

									?>
							</td>
							</tr>	
<?php } ?>

<!--[if IE]><script language="javascript" type="text/javascript" src="/s/v255/js/ie-hacks/excanvas.min.js"></script><![endif]-->

<script>
$('#shorten_button').live('click', function(e){
	$('unAuthShortenForm').submit();

});
</script>




<script>
$('.share_tw').live('click', function(e){
	e.preventDefault();
	share_box_updates($(this).attr('rel'), $(this));
});

function share_box_updates(str, elem) {
	$('#share_text').val('');
	$('#share_box').show();
	$('#share-form').attr("action", elem.attr("href"));
	$('#share_text').val(str);
}

$('#shares_button').live('click', function(e){
	e.preventDefault();
	
	$.ajax({
	    type: "POST",
	    url: 	$('#share-form').attr("action"),
	    data: $('#share-form').serialize(),
	    dataType: "json",
	    success: function(msg) {
    		if(msg) {
        		if(msg['error']) {
	    			alert(msg['error']);
        		}
    		}
			$('#share_text').val('');
			$('#share_box').hide();
	    },
	    failure: function (msg) {
		    alert(msg);
	    }
	  });
});

</script>

<script type="text/javascript">
	// setup single ZeroClipboard object for all our elements
	function init() {

		$(function() {
        	$(".copy_button").each(function() {
                //Create a new clipboard client
                var clip = new ZeroClipboard.Client();
        		clip.setHandCursor( true );

            	id = $(this).attr('id');
            	id_arr = (id.split('_'));
            	url_id = (id_arr[1]);
            	str = '#short_url_' + url_id;
            	txt = ($(str).attr('href'));
            	clip.setText(txt);
				var last = $(this);
				clip.glue(last[0]);

                //Add a complete event to let the user know the text was copied
                clip.addEventListener('complete', function(client, text) {
                    id = $((client.elem)).attr('id');
                	id_arr = (id.split('_'));
                	url_id = (id_arr[1]);
                        
                	str = '#copy-success-' + url_id;
                	$('.popup_error').hide();
                        	
                	  $(str).show();
    				  $(str).html('Copied to clipboard');
    				  setTimeout("$(str).hide(); ", 2000); //display message for 3 seconds
                });
				
              
           });
        });
	}                             
    </script>



<!-- FOOTER END-->
</body>
</html>
