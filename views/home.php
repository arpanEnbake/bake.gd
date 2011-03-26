<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>URL Shortner</title>

<base href="<?php echo base_url(); ?>" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
<link type="text/css" rel="stylesheet" href="resource/app/css/960gs.css" />
<link type="text/css" rel="stylesheet" href="resource/app/css/style.css" />
</head>
<body>

<?php if(!isset($twitter)) $twitter = null;?>
<?php if(!isset($fb)) $fb = null;?>
<?php echo $this->load->view('header'); ?>
<?php 		echo validation_errors(); ?>

<?php echo form_open('/home/index'); ?>
<?php if (isset($error))
echo "<h2>{$error}</h2>";?>
<h5>Enter the URL to Shorten</h5>

<input type="text" name="url" value="<?php echo set_value('url', isset($url) ? $url : null); ?>" size="50" />

<div><input type="submit" value="Submit" /></div>
</form>
<?php function show_row($bake_url, $url, $url_id, $timestamp = null, $twitter = null, $fb = null) {
			echo '<tr>';
			echo '<td>'. anchor($bake_url, $bake_url) .  '    &nbsp;&nbsp;&nbsp;</td>   ';
			echo '<td>'. substr($url, 0, 50) . '&nbsp;&nbsp;&nbsp;&nbsp;</td>';
			echo '<td>'; echo isset($timestamp) ? $timestamp : date('m-d-Y H:m:s');
			echo '</td>';
			echo '<td>';
			$link = false;
			if (isset($twitter)) {
				echo anchor("account/connect_twitter/post_status/{$twitter->twitter_id}/{$url_id}", 'Twitter');
				$link = true;
			} 
			if (isset($fb)) {
				$link = true;
				echo anchor("account/connect_facebook/post_wall/{$fb->facebook_id}/{$url_id}", 'Facebook');
			} 
			
			if (!$link) {
				echo anchor('/account/account_linked', 'Link your A/cs here');
			}
			
			echo '</td>';
			echo '</tr>';
	
}?>
<?php if (!empty($my_urls) || isset($Result['keyword'])) {?>
	<h2><?php echo isset($account) ? 'My' : 'Your'?> Recent URLs</h2> 
	<table>
	<tr>
		<th>Shorten URL</th>
		<th>URL</th>
		<th>Created</th>
		<th>Share</th>
	</tr>
	<?php if (isset($Result['keyword'])) {?>
	<?php 				
			$bake_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $Result['keyword'];
			show_row($bake_url, $Result['url'], $Result['id'], null, $twitter, $fb); 
	?>
	<?php } ?>
	<?php
 		foreach ($my_urls as $row)
		{
			$bake_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $row->keyword;
			show_row($bake_url, $row->url, $row->id, $row->timestamp, $twitter, $fb);
		}
			
	?>
	</table>
	<?php }?>
<?php echo $this->load->view('footer'); ?>
</body>
</html>