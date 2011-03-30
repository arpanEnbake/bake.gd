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

<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>
<?php $js = array('rgraph/RGraph.common.core.js',
				'rgraph/RGraph.common.annotate.js',
				'rgraph/RGraph.common.context.js',
				'rgraph/RGraph.common.tooltips.js',
				'rgraph/RGraph.common.resizing.js',
				'rgraph/RGraph.bar.js');
foreach ($js as $j) {
	echo '<script type="text/javascript" src="resource/app/js/'. $j. '"></script>';
}
?>

<canvas id="myCanvas" width="600" height="300">[No canvas support]</canvas>
<script>
$.ajax({
    type: "post",
    url: "<?php echo base_url();?>ajax/barchartdata/",    
    dataType: 'json',
    success: function(response){  
    	data = response['data'];

    	var units_pre = response['units_pre'];
		var title = response['title'];
		var colors = response['colors'];
		var labels = response['labels'];
		var key = response['key'];
		var tooltips = response['tooltips'];
		
		var bar5 = new RGraph.Bar('myCanvas', data);
		bar5.Set('chart.units.pre', units_pre);
		bar5.Set('chart.title', title);
		bar5.Set('chart.colors', colors);
		bar5.Set('chart.gutter', 40);
		bar5.Set('chart.shadow', true);
		bar5.Set('chart.shadow.color', '#aaa');
		bar5.Set('chart.background.barcolor1', 'white');
		bar5.Set('chart.background.barcolor2', 'white');
		bar5.Set('chart.background.grid.hsize', 5);
		bar5.Set('chart.background.grid.vsize', 5);
		bar5.Set('chart.grouping', 'stacked');
		bar5.Set('chart.labels', labels);
		bar5.Set('chart.labels.above', true);
		bar5.Set('chart.key', key);
		bar5.Set('chart.key.background', 'rgba(255,255,255,0.7)');
		bar5.Set('chart.key.position', 'gutter');
		bar5.Set('chart.key.position.gutter.boxed', false);
		bar5.Set('chart.key.position.y', bar5.Get('chart.gutter') - 15);
		bar5.Set('chart.key.border', false);
		bar5.Set('chart.height', 200);
		bar5.Set('chart.background.grid.width', 0.3); // Decimals are permitted
		bar5.Set('chart.text.angle', 90);
		bar5.Set('chart.strokecolor', 'rgba(0,0,0,0)');
		bar5.Set('chart.tooltips.event', 'onmousemove');
		
		if (!RGraph.isIE8()) {
		    bar5.Set('chart.tooltips', tooltips);
		}
		
		bar5.Draw();

    }
});
</script>


<script>
$.ajax({
    url: '<?php echo base_url();?>ajax/get_click_data/',
    type: 'POST',
    //data: {field: value},
    dataType: 'json',
    timeout: 8000,
    success: success_function
  });

  function success_function(json) {
    if (json.error)
      alert(json);
    else
      $('#result_div').html(json.html);

    if (json.another_variable == 42)
      alert("I've found the secret of life!");
  }  
  </script>
</body>
</html>

