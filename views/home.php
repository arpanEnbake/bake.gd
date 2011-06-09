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
<?php $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>
<?php if(!isset($twitter)) $twitter = null;?>
<?php if(!isset($fb)) $fb = null;?>

<!-- HEADER START-->
<div>	
	<?php echo $this->load->view('inner_elements/header_new'); ?>
</div>
<!-- HEADER END-->
<div id="hero-container">
	<div class="positioning">
		<h1>Shorten and customise your links</h1>
		<h3>Share your links</h3>
		<div class="snapshots">
			<div class="slide">
				<img src="resource/app/images/shorten.png" width="750" height="265" alt="Shorten and Share" border="0" />
			</div>
		</div>
	</div>
	<div class="positioning">
		<h1>Get Social analytics and dashboard</h1>
		<h3>Social dashboard for your brand's social performance</h3>
		<div class="snapshots">
			<div class="slide">
				<img src="resource/app/images/social.png" width="750" height="265" alt="Shorten and Share" border="0" />
			</div>
		</div>
	</div>
</div>

<!-- BODY START-->
<div id="mainBody">
	<div id="body">
		<?php echo validation_errors(); ?>
		<?php if (isset($error))
				echo "<h2>{$error}</h2>";
		?>
		<?php echo form_open('/home/index', array('id' => 'unAuthShortenForm')); ?>
		
		<div>
			<input class="home-shorten" type="text" name="url" value="<?php echo set_value('url', isset($Result['url']) ? $Result['url'] : null); ?>"></input>
			<input  class="home-shorten-button" id="shorten_button" type="submit" value="Shorten"></input>
		</div>		
		<div class="BoxContainer">
			<div class="box4">
				<?php echo $this->load->view('inner_elements/link_history',
									array('urls'=>$my_urls, 'result'=>$Result, 'fb'=>$fb,
											'twitter'=>$twitter));
				?>			
			</div>
		</div>
	</div>
</div>
<!-- BODY END-->
<?php echo $this->load->view('inner_elements/footer'); ?>

<!--[if IE]><script language="javascript" type="text/javascript" src="/s/v255/js/ie-hacks/excanvas.min.js"></script><![endif]-->

<script>
$('#shorten_button').live('click', function(e){
	$('unAuthShortenForm').submit();

});
</script>

 <div style="display:none" id="share_box">
<?php echo form_open('/home/index', array('id' => 'share-form')); ?>
<textarea id="share_text" name="share_text" value="" rows="4" cols="100"></textarea>
<button id="shares_button" type="submit"><p>Share</p></button>
<?php echo form_close()?>
</div>


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
	$(function() {
		$("#hero-container").cycle();
	});
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
