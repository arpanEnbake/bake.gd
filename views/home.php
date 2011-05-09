
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="nojs">
<!-- MIME TYPE Guidlines and references: http://hixie.ch/advocacy/xhtml -->
<head>
<title>bake.gd | Basic | Every link builds a brand</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="IE=8" http-equiv="X-UA-Compatible" />
<meta name="keywords" content="bake.gd, brand building, link marketting" />
<meta name="description" content="bake.gd, build your brand with every short link" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>

<base href="<?php echo base_url(); ?>" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
<link type="text/css" rel="stylesheet" href="resource/app/css/common.css" />

<!-- <link type="text/css" rel="stylesheet" href="resource/app/css/960gs.css" />
<link type="text/css" rel="stylesheet" href="resource/app/css/style.css" />-->


<!--[if lte IE 8]>
<link rel="stylesheet" href="IE.css" type="text/css" charset="utf-8" />
<![endif]-->

 <style type="text/css">
 html:before, #middle:before { /* Opera and IE8 "redraw" bug fix */
 content:"";
 float:left;
 height:100%;
 margin-top:-999em;
 }
 </style>

</head>
<body class="unauth_home" onLoad="init()">

	<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>
	<script src="resource/app/js/ZeroClipboard.js" type="text/javascript"></script>

	<div class="ext_bitly_chrome_promo_delay"></div>

<?php $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>
<div id="external_container">
	<div id="container">
	<div id="notification" class="notification roundbtm" style="display:block;">
		<span id="notification-text">
		<?php if (!$this->session->userdata('account_id')) { ?>	
			
			Sign in now to track your links
				<span class="fb-sign">
				<a class="fb_button fb_button_medium" href="<?php echo 'account/connect_facebook'?>">
					<span class="fb_button_text">Login with Facebook</span></a></span>
				<a href="<?php echo 'account/connect_twitter'?>" class="twitter-sign">
				<img src="http://si0.twimg.com/images/dev/buttons/sign-in-with-twitter-l.png" /></a>
			<?php } else {?>
							<span class="fb-sign">
			
			<a href="#">
			<?php if ($this->session->userdata('picture')) {  ?>
				<img src="<?php echo $this->session->userdata('picture')?>" />
			<?php }?>
			<?php echo $this->session->userdata('fullname')?>
			<?php echo anchor('account/sign_out' , 'Log Out', array()) ?>
			</a></span>
			<?php }?>
		</span>
	</div>
<!-- Put Content Here -->

<div id="top">


</div> <!-- end #top -->

<?php if(!isset($twitter)) $twitter = null;?>
<?php if(!isset($fb)) $fb = null;?>
<?php // echo $this->load->view('header'); ?>
<?php 		echo validation_errors(); ?>

<?php if (isset($error))
		echo "<h2>{$error}</h2>";?>

<div id="middle">

	<!-- Sorry, you are not logged -->
	<div id="middle_inner">
		<div id="header">
			<a id="logo" href="/">bake.gd</a>
		</div>
		<div id="middleLevelContainer1">
			<div id="mainSearchContainer">
				<div id="mainSearchContainerInner" class="mainUnAuthShortenContainerInner">
					<div class="formActionContainer">
						<?php echo form_open('/home/index', array('id' => 'unAuthShortenForm')); ?>
								<div class="shortenUnAuthBox clearfix">
								<div id="mainUnAuthShortenContainer" class="inputBoxContainer">
									<input  tabindex="1" id="shortenUnAuthContainer"  type="text" name="url"
											value="<?php echo set_value('url', isset($url) ? $url : null); ?>" />
								</div>
									<button id="shorten_button" type="submit"><p>Shorten</p></button>
							</div>
						</form>
					</div>
				</div>
			</div>


			<div class="shortenedListListBox last_shorten " style="display:block;">
			<div style="display:none" id="share_box">
				<?php echo form_open('/home/index', array('id' => 'share-form')); ?>
					<textarea  id="share_text"   name="share_text" value="" rows="4" cols="100"></textarea>
					<button id="shares_button" type="submit"><p>Share</p></button>	
				<?php echo form_close()?>
			</div>
				<div class="linkCapsule_link clearfix">
					<strong class="shortened_url">Shortened link</strong>
					<strong class="realtime_stats">stats</strong>
					<strong class="long_link">Long link</strong>
					<strong class="sharing_options">Sharing</strong>
				</div>
				<ul class="shortened_results_list"></ul>
			</div>


			<div class="resultsContainer roundbtm10">
				<div id="historyHeadline"></div>
				<div id="weeklySparkLines"></div>
				<div id="results" style="display: block; ">
					<div class="shortenedListListBox">
						<ul class="shortened_results_list">

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
						</ul>
					</div>
					<div id="pagination"></div>
				</div> <!-- end #resultsContainer -->
			</div>

		</div>
	</div>
</div> <!-- END #middle -->



<?php function show_row($bake_url, $url, $url_id, $timestamp = null, $twitter = null, $fb = null) {?>
							<li hash="fRi0f2" class="linkCapsule_link clearfix">
								<div class="shortened_url clearfix">
									<?php echo anchor($bake_url, $bake_url, array('class'=>"short_url", 'id' => "short_url_{$url_id}")) ?>
									<span class="copy_customize flash">
										<!-- <a class="customize_button" href="/a/sign_in">Customize</a>
										<span class="copy_separator"> | </span> -->
											<a style = "text-indent: 0px; " class="copy_button" id="copy_<?php echo $url_id?>"  href="javascript:void(0)">
													Copy
											</a>
									</span>
								</div>
								<div class="popup_error" id="copy-success-<?php  echo $url_id?>" style="display: none;"></div>
								<?php $str =  $bake_url . '+'; 
									echo anchor($str, 'Info Page+', array('class'=>"realtime_stats", 'style'=>"float:left"));?></a>
								<a target="_blank" href="#" class="long_link"><?php echo substr($url, 0, 50); ?></a>
								<span id="share_links">
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
										if (isset($fb)) {
											$fb_flag = true;
											echo anchor("account/connect_facebook/post_wall/{$fb->facebook_id}/{$url_id}", 'Facebook'
											, 	array('class'=>"share_tw", 'rel' => $bake_url));
											if (!isset($twitter)) {
													echo anchor("account/connect_twitter", 'Connect Twitter');
											}
											
										}
										if (!$tw_flag && !$fb_flag) {
											echo anchor('/account/account_linked', 'Link your A/cs here');
										}

									?>
								</span>
							</li>
<?php } ?>

<div id="bottom">

</div> <!-- end #bottom -->
</div> <!-- end #container -->
</div> <!-- end #external_container -->


 <div id="footer">
	© 2010 Enabake Consulting Pvt Ltd

	<a href="#">Help</a>
	<a href="#">API</a>
	<a href="#">Privacy Policy</a>
	<a href="#">TOS</a>

</div>

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


</body>
</html>

