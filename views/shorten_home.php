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
	<link href="resource/app/css/bake.css" rel="stylesheet"  type="text/css">

	<!--[if lte IE 8]>
	<link rel="stylesheet" href="IE.css" type="text/css" charset="utf-8" />
	<![endif]-->
	<link rel="icon" type="image/png" href="favicon.png" />

<!-- scripts-->
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
	<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="js/moo.js"></script>
	<script type="text/javascript" src="js/hero.js"></script>
	<script src="resource/app/js/ZeroClipboard.js" type="text/javascript"></script>
</head>
<?php $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>

<body>
<div>
	<?php echo $this->load->view('inner_elements/header_new'); ?>
</div>

<?php $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>
<?php if(!isset($twitter)) $twitter = null;?>
<?php if(!isset($fb)) $fb = null;?>

<!-- BODY START-->
<div id="mainBody" style="min-height:600px;">
<div id="body">
<div class="content">
<div style="color:red">
<?php 		echo validation_errors(); ?>
<?php if (isset($error))
		echo "<h2>OOOOpsieee {$error}</h2>";?>
		</div>
		
	<?php
	$Result['id'] = '';
	$bake_url = '';
	if (isset($Result['keyword'])) {
  		$bake_url = 'http://' . $Result['domain'] . '/' . $Result['keyword'];
	}
  	?>

  	<?php echo form_open('/home/index', array('id' => 'unAuthShortenForm')); ?>
<div class="left">
	<input name="url" class="textbox" tabindex="1"  
		<?php if (!isset($Result['url'])){?>
					onclick="if (this.value=='Shorten your links and share from here') this.value = ''"
					 onmouseout="if (this.value=='') this.value = 'Shorten your links and share from here'" 
					 type="text" maxlength="140" size="28" value="Shorten your links and share from here"
		<?php }?>
		value="<?php echo set_value('url', isset($Result['url']) ? $Result['url'] : null); ?>">

	<div style="padding-right: 1px; height:50px; padding-top:8px">
		<a  class="shorten"  id="shorten_button" href="javascript:void(0)">Shorten</a>
<!--		<input type="button" class="shorten" id="shorten_button">-->
		<?php if (isset($Result['url']) && isset($twitter)) { ?>
			<a rel = "<?php echo $bake_url?>" class="share_tw share"
				href="account/connect_twitter/post_status/<?php
				 echo "{$twitter->twitter_id}/{$Result['id']}"?>">Share</a>
		<?php } ?>
	</div>
	
<?php echo form_close();?>
<?php  if (isset($Result['keyword'])) {?>
  	
  	<div  class="popup_error" id="copy-success-00" style="display: none; width:140px; margin-left: 250px"></div>
  	<div id="result-table"  style="opacity:0.1; background-color: #bcdcfa">
  	<table width="100%" border="0" cellspacing="3" cellpadding="0" >
  <tr>
        <td  align="left" valign="middle">Shortened Link</td>
        <td  align="left" valign="middle">Info Plus</td>
        <td  align="left" valign="middle">Long link</td>
    
  </tr>
  		<tr>
  			<td align="left"><strong><?php echo anchor($bake_url, $bake_url, 
  					array('class'=>"short_url", 'id' => "short_url_00")) ?>
  	        </strong></td>
			<td align="left">
				<a style = "text-indent: 0px; " class="copy_button" id="copy_00"  href="javascript:void(0)">Copy</a>
				<?php echo anchor($bake_url.'+', 'Bake+', array('style'=>'margin-left:30px'));?></td>			
			<td align="left"><?php echo anchor($Result['url'], substr($Result['url'], 0, 50));?></td>
						
</tr></table>
</div>
<script>$('#result-table').animate({ opacity : '1'}, 8000, function() {
	$('#result-table').css('background-color', '#bcdcfa');
    // Animation complete.
});
 </script>
<?php }?>
<!---->
<!--<p><table width="100%" border="0" cellspacing="0" cellpadding="3">-->
<!--  <tr>-->
<!--    <td width="3%" align="center"><img src="resource/app/images/sharing.jpg" width="12" height="12"></td>-->
<!--    <td width="97%"><a href="#">Share settings</a></td>-->
<!--    <td width="97%">&nbsp;</td>-->
<!--    <td width="97%" align="right" nowrap>Active</td>-->
<!--    <td width="97%" nowrap><img src="resource/app/images/facebook.png" width="25" height="25">&nbsp;-->
<!--    	<img src="resource/app/images/twitter.png" width="25" height="25"></td>-->
<!--  </tr>-->
<!--</table>-->
<!--</p>-->
</div>
</p>

<div class="right">
  <h2>Shorten anywhere with </h2>
  <img src="resource/app/images/sidebar.jpg">
  <h3><ul>
	<li><?php echo anchor('/account/account_settings/custom', 'Customize your shortened urls now!!!' 
  					) ?></li>
</ul></h3>
</div>

</div>

<div class="BoxContainer">
		<?php echo $this->load->view('inner_elements/link_history',
				array('urls'=>$my_urls, 'fb'=>$fb, 'twitter'=>$twitter));?>
</div>


<script>
$('#shorten_button').live('click', function(e){
	e.preventDefault();
	$('#unAuthShortenForm').submit();

});
</script>

<script>
$('.share_tw').live('click', function(e){
	e.preventDefault();
	share_box_updates($(this).attr('rel'), $(this));
});

function share_box_updates(str, elem) {
	$('#share_text').val('');
	$('#share-form').attr("action", elem.attr("href"));
	$('#share_text').val(str);
	$('#basic-modal-content').modal({maxHeight:10,
									maxWidth: 10
							});
}

$('#shares_button').live('click', function(e){
	e.preventDefault();
	$.ajax({
	    type: "POST",
	    url: 	$('#share-form').attr("action"),
	    data: $('#share-form').serialize(),
	    dataType: "json",
	    success: function(msg) {
		$.modal.close();
		$('#modal-result').innerHtml = (msg);
    		if(msg) {
        		if(msg['error']) {
	    			alert(msg['error']);
        		}
    		}
			$('#share_text').val('');
	    },
	    failure: function (msg) {
	    	$('#modal-result').innerHtml = (msg);
		    alert(msg);
	    }
	  });
});

</script>

<script type="text/javascript">
	// setup single ZeroClipboard object for all our elements
	// function init() {

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
    				  $(str).html('<div style="border:2px;background-color:yellow">Copied to clipboard  &nbsp;<div>');
    				  setTimeout("$(str).fadeOut(); ", 1000); //display message for 3 seconds
                });
				
              
           });
        });
	//}                             
    </script>

<!--  changes for the modal dialog -->
<link type='text/css' href='resource/app/css/basic.css' rel='stylesheet' media='screen' />

	<!-- modal content -->
	<div id="basic-modal-content">

		<div style="text-align: center;">
			<h2> Share Now </h2>
		</div>
		<br></br>
		<?php echo form_open('/home/index', array('id' => 'share-form')); ?>
		<textarea id="share_text" name="share_text" value="" rows="5" cols="50"
			style = "margin-left:60px;"></textarea>
		<button id="shares_button" type="submit"><p>Share</p></button>
		<div style="text-align: justify; align: center;" id="modal-long-link"></div>
		<?php echo form_close()?>
		<div style="text-align: center;" id="modal-result">
			
		</div>
		

	</div>

<!-- Load jQuery, SimpleModal and Basic JS files -->

<script type='text/javascript' src='resource/app/js/jquery.simplemodal.js'></script>
<!--  changes for the modal dialog -->





</div></div>
<!-- BODY END-->

<?php echo $this->load->view('inner_elements/footer'); ?>
<!-- FOOTER END-->
</body>
</html>