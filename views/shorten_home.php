<?php echo $this->load->view('inner_elements/header'); ?>
<script src="resource/app/js/ZeroClipboard.js" type="text/javascript"></script>

<!-- BODY START-->
<div id="mainBody">
<div id="body">
<div class="content">
<div style="color:red">
<?php 		echo validation_errors(); ?>
<?php if (isset($error))
		echo "<h2>OOOOpsieee {$error}</h2>";?>
		</div>
<?php echo form_open('/home/index', array('id' => 'unAuthShortenForm')); ?>
<div class="left">
	<input name="url" class="textbox" tabindex="1"  
		<?php if (!isset($Result['url'])){?>onclick="if (this.value=='Shorten your links and share from here') this.value = ''" onmouseout="if (this.value=='') this.value = 'Shorten your links and share from here'" type="text" maxlength="140" size="28" value="Shorten your links and share from here"
		<?php }?>
		value="<?php echo set_value('url', isset($Result['url']) ? $Result['url'] : null); ?>">

	<div>
		<input type="button" class="shorten" id="shorten_button">
<!--		<input type="button" class="share">-->
	</div>
<?php echo form_close();?>

  	<?php if (isset($Result['keyword'])) {
  		$bake_url = 'http://' . $Result['domain'] . '/' . $Result['keyword'];
  	?>
  	<div  class="popup_error" id="copy-success-00" style="display: none; width:140px; margin-left: 250px"></div>
  	<div id="result-table"  style="opacity:0.1; background-color: #bcdcfa">
  	<table width="100%" border="0" cellspacing="3" cellpadding="0" >
  <tr>
        <td  align="left" valign="middle">Shortened Link</td>
        <td  align="left" valign="middle">Info Plus</td>
        <td  align="left" valign="middle">Long link</td>
    
  </tr>
  		<tr>
  			<td align="left"><strong><?php echo anchor($bake_url, $bake_url, array('class'=>"short_url", 'id' => "short_url_00")) ?>
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
  	
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500sLorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
<p><table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="3%" align="center"><img src="resource/app/images/sharing.jpg" width="12" height="12"></td>
    <td width="97%"><a href="#">Share settings</a></td>
    <td width="97%">&nbsp;</td>
    <td width="97%" align="right" nowrap>Active</td>
    <td width="97%" nowrap><img src="resource/app/images/facebook.png" width="25" height="25">&nbsp;<img src="resource/app/images/twitter.png" width="25" height="25"></td>
  </tr>
</table>
</p>
</div>
</p>

<div class="right">
  <h2>Shorten anywhere with </h2>
  <img src="resource/app/images/sidebar.jpg">
  <ul>
<li>Drag to your toolbar  Learn More</li>
<li>Search your link history
Easily find links with our new search</li>
<li>
See more tips & tricks
Take our tour to see what you can do</li>
</ul>
</div>

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

<div class="BoxContainer">
<p><strong>Link History: 1 - 3</strong></p>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td height="30" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="7%">View All</td>
        <td width="43%">   <a href="#">Bundles
        </a></td>
        <td width="49%" align="right"><img src="resource/app/images/bundle.jpg" width="102" height="35"></td>
        <td width="1%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" align="left" valign="middle" bgcolor="#bcdcfa"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="4%" align="center" valign="middle"><input type="checkbox"></td>
        <td width="8%" align="center" valign="middle">Clicks</td>
        <td width="55%" align="left" valign="middle">Links</td>
        <td width="10%" align="left" valign="middle">Info Plus</td>
        <td width="15%" align="left" valign="middle">Date</td>
        <td width="17%" align="left" valign="middle">Options</td>
      </tr>
    </table></td>
  </tr>
  <?php // some bad code because of new design merging?>
  	<?php if (!empty($my_urls)) {
					foreach ($my_urls as $row)
					{
						$bake_url = 'http://' . $row->domain . '/' . $row->keyword;
						show_row($row, $bake_url,  $twitter, $fb);
					}
				}
				?>

</table>
  
  
<?php function show_row($url_obj, $bake_url,$twitter = null, $fb = null) {
 $url = $url_obj->url;
 $url_id = $url_obj->id;
 $title = $url_obj->title;
 $timestamp = $url_obj->timestamp;
 $clicks = $url_obj->clicks?>
<?php
$to_time=strtotime($timestamp);
$from_time=time();
$days = round(abs($to_time - $from_time) / (60*24*60),0);
if ($days < 1) {
	$hours = round(abs($to_time - $from_time) / (60*60),0);
	if ($hours < 1) {
		$time_str = round(abs($to_time - $from_time) / (60),0) . ' minutes ago.';
	} else {
		$time_str = $hours . ' hours ago.';
	}
} else {
	$time_str = $days . ' days ago.';
}
?>
<tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="4%" align="center" valign="top" bgcolor="#BCDCFA"><input type="checkbox"></td>
              <td width="8%" align="center" valign="top">0<br>
					out of<br>0</td>
  
  	        <td width="55%" align="left" valign="top">
  	        <strong><?php echo anchor($bake_url, $title, array('class'=>"short_url", 'id' => "short_url_{$url_id}")) ?>
  	        </strong><br>
  	        
  	        <div class="popup_error" id="copy-success-<?php  echo $url_id?>" style="display: none;"></div>
  	        
  	        <?php echo anchor($url, substr($url, 0, 50),
  	        		 array('class'=>"short_url", 'id' => "short_url_{$url_id}")) ?>
  	        		 <br>
          <?php echo $bake_url?>&nbsp; - &nbsp;
					<a style = "text-indent: 0px; " class="copy_button" id="copy_<?php echo $url_id?>"  href="javascript:void(0)">
						Copy</a>
				<br>        </td>
        
        <td width="10%" align="left" valign="top"><?php echo anchor($bake_url.'+', 'Bake+')?></td>
        <td width="15%" align="left" valign="top"><?php echo $time_str?></td>
        <td width="17%" align="left" valign="top">
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
										echo '<br>';
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
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<?php } ?>
  
</div>


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





<div class="Container"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="84%">  <p><strong>10 Click(s) on this link </strong></p></td>
    <td width="16%"><select style="width:170px;"><option>one</option><option>one</option><option>one</option></select></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#BCDCFA">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#BCDCFA"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>1</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>2</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
          <tr>
            <td colspan="6" align="left" valign="top" bgcolor="#FFFFFF">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <td width="17%" bgcolor="#FFFFFF"><p>&nbsp;</p>
                        <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p></td>
                    <td width="17%" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="10%" bgcolor="#6baff0">&nbsp;</td>
                    <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="10%" bgcolor="#6BAFF0">&nbsp;</td>
                    <td width="17%" bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>
                </table>
                </td>
            </tr>
          <tr>
            <td width="17%">0 May 16, 2011</td>
            <td width="17%">0 May 16, 2011</td>
            <td width="10%" nowrap>0 May 16, 2011</td>
            <td width="29%">0 May 16, 2011</td>
            <td width="10%" nowrap>0 May 16, 2011</td>
            <td width="17%">0 May 16, 2011</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#BCDCFA">&nbsp;</td>
  </tr>
</table>
</div>
</div></div>
<!-- BODY END-->

<?php echo $this->load->view('inner_elements/footer'); ?>

