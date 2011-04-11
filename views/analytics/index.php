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
<?php $graph_width = 998;?>
<?php $graph_height = 300;?>

<div id="external_container">
	<div id="container">
	<?php echo form_open(uri_string(), array('id'=>'TimePeriodFormId')); ?>
			
			<select name="data[Time][period]" id="TimePeriodDDId">
				<option value="1">Past Hour</option>
				<option selected ="selected" value="<?php echo 7 * 24;?>">Past 7 days</option>
				<option value="<?php echo 14 * 24;?>">Past 14 days</option>
				<option value="<?php echo 30 * 24;?>">Past 30 days</option>
			</select>
			<?php echo form_close()?>
	
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
				<canvas id="myCanvas" width="<?php echo $graph_width; + 50?>" style="border: 0.5px solid grey; align:center; background-color:white" 
						height="<?php echo $graph_height + 5;?>">[No canvas support]</canvas>
			
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


<script>

$('#TimePeriodDDId').live('change', function(e) {
	$('#myCanvas').empty();
	tp = ($('#TimePeriodDDId').val());
	draw_chart(tp);
})
function draw_chart(tp) {
	
	if (!tp)
		tp = 168;
	
	$.ajax({
	    type: "post",
	    url: "<?php echo base_url();?>ajax/barchartdata/"+tp,    
	    dataType: 'json',
	    success: function(response){
		    success_draw(response);  
	    }
	});
}
draw_chart();
</script>

<script>
var bar5 = null;
function success_draw(response) {
	data = response['data'];
	
	var units_pre = response['units_pre'];
	//var title = response['title'];
	var title = "Clicks";
	var colors = response['colors'];
	var labels = response['labels'];
	var key = response['key'];
	var tooltips = response['tooltips'];

	if (bar5)
		RGraph.Clear(bar5.canvas);

	bar5 = new RGraph.Bar('myCanvas', data);
	
	bar5.Set('chart.units.pre', units_pre);
	bar5.Set('chart.title', title);
	bar5.Set('chart.gutter', 40);
	bar5.Set('chart.shadow', false);
	bar5.Set('chart.shadow.color', '#aff');
	bar5.Set('chart.background.barcolor1', '#efd');
	bar5.Set('chart.background.barcolor2', '#efd');
	bar5.Set('chart.colors', ['rgb(64,163,255)', 'rgb(145,210,120)', 'purple', 'orange']);

	//bar5.Set('chart.background.grid', false);
	bar5.Set('chart.background.grid.hsize', 3);
	bar5.Set('chart.background.grid.vsize', 3);
	bar5.Set('chart.grouping', 'stacked');
	bar5.Set('chart.labels', labels);
	bar5.Set('chart.labels.above', true);
	bar5.Set('chart.key', key);
	bar5.Set('chart.key.background', 'rgba(255,255,255,0.7)');
	bar5.Set('chart.key.position', 'gutter');
	bar5.Set('chart.key.position.gutter.boxed', false);
	bar5.Set('chart.key.position.y', bar5.Get('chart.gutter') - 15);
	bar5.Set('chart.key.border', false);
	bar5.Set('chart.height', <?php echo $graph_height;?>);
	bar5.Set('chart.width', <?php echo $graph_width;?>);
	bar5.Set('chart.background.grid.width', 0.3); // Decimals are permitted

	bar5.Set('chart.text.color', '#000');
	bar5.Set('chart.text.font', '"Helvetica Neue",Arial,sans-serif');
	bar5.Set('chart.text.angle', 25);
	bar5.Set('chart.strokecolor', 'rgba(0,0,0,0)');
	bar5.Set('chart.tooltips.event', 'onmousemove');
	bar5.Set('chart.tooltips.effect', 'expand');
	
	if (!RGraph.isIE8()) {
	    bar5.Set('chart.tooltips', tooltips);
	}
	bar5.Draw();
}
  </script>

</body>
</html>