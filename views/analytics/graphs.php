<link rel="stylesheet" href="resource/app/js/RGraph/css/website.css" type="text/css" media="screen" />
<link rel="stylesheet" href="resource/app/css/ui.selectmenu.css" type="text/css" />
<?php $js = array('rgraph/RGraph.common.core.js',
				'rgraph/RGraph.common.annotate.js',
				'rgraph/RGraph.common.context.js',
				'rgraph/RGraph.common.tooltips.js',
				'rgraph/RGraph.common.resizing.js',
				'rgraph/RGraph.bar.js',
				'rgraph/RGraph.line.js',
					'rgraph/RGraph.pie.js');
foreach ($js as $j) {
	echo '<script type="text/javascript" src="resource/app/js/'. $j. '"></script>';
}
?>
<script type="text/javascript" src="resource/app/js/ui.selectmenu.js"></script>

<?php $graph_width = 998;?>
<?php $graph_height = 300;?>

<!-- BODY START-->
<div id="mainBody">
	<div id="body">
	<?php echo form_open(uri_string(), array('id'=>'TimePeriodFormId')); ?>
		<div style="padding:5px 0px;">
			<span style="float:right;">
				<select name="data[Time][period]" id="TimePeriodDDId">
					<option value="1">Past Hour</option>
					<option selected ="selected" value="<?php echo 7 * 24;?>">Past 7 days</option>
					<option value="<?php echo 14 * 24;?>">Past 14 days</option>
					<option value="<?php echo 30 * 24;?>">Past 30 days</option>
				</select>
			</span>
			<div style="clear:both;"></div>
		</div>
			<?php echo form_close()?>
	
		<!-- Put Content Here -->
		<div id="notification" class="signed-in roundbtm" style="display:block;">
				<div class="clearfix"></div>
		</div>
		<div id="top"></div> <!-- end #top -->
		<div id="middle">
			<div style="width: 1000px;">
				<canvas id="myCanvas" width="<?php echo $graph_width; + 50?>" 
						style="border: 0.5px solid grey; align:center; background-color:white" 
						height="<?php echo $graph_height + 5;?>">[No canvas support]</canvas>
			
			</div>
			<div style="width: 1000px;">
				<canvas id="linegraph" width="<?php echo $graph_width; + 50?>" 
						style="border: 0.5px solid grey; align:center; background-color:white" 
						height="<?php echo $graph_height + 5;?>">[No canvas support]</canvas>
			
			</div>
			<div style="width: 1000px;">
				<canvas id="piegraph" width="<?php echo $graph_width; + 50?>" 
						style="border: 0.5px solid grey; align:center; background-color:white" 
						height="<?php echo $graph_height + 5;?>">[No canvas support]</canvas>
			
			</div>
			
		</div>  <!-- END #middle -->
	</div> <!-- end #external_container -->
</div>

<!--[if IE]><script language="javascript" type="text/javascript" src="/s/v255/js/ie-hacks/excanvas.min.js"></script><![endif]-->

<script>
$("#TimePeriodDDId").selectmenu({width:'120px'});
draw_chart();

// on change of time period
$('#TimePeriodDDId').live('change', function(e) {
	$('#myCanvas').empty();
	$('#linegraph').empty();
	
	tp = ($('#TimePeriodDDId').val());
	draw_chart(tp);
})



function draw_chart(tp) {
	
	if (!tp)
		tp = 168;
	
	$.ajax({
	    type: "post",
	    data: $('#TimePeriodFormId').serialize(),
	    url: "<?php echo base_url();?>ajax/barchartdata/"+tp,    
	    dataType: 'json',
	    success: function(response){
		    success_draw(response);  
	    }
	});

	$.ajax({
	    type: "post",
	    url: "<?php echo base_url();?>ajax/linechartdata/"+tp,    
	    dataType: 'json',
	    success: function(response){
	    	success_line_draw(response)
	    }
	});

	$.ajax({
	    type: "post",
	    url: "<?php echo base_url();?>ajax/piechartdata/"+tp,    
	    dataType: 'json',
	    success: function(response){
	    	success_pie_draw(response)
	    }
	});
}


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
	bar5.Set('chart.text.angle', 0);
	bar5.Set('chart.strokecolor', 'rgba(0,0,0,0)');
	bar5.Set('chart.tooltips.event', 'onmousemove');
	bar5.Set('chart.tooltips.effect', 'expand');
	
	if (!RGraph.isIE8()) {
	    bar5.Set('chart.tooltips', tooltips);
	}
	bar5.Draw();
}
  </script>

<script>
var line = null;
function success_line_draw(response) {
	data = response['data'];
	
	var units_pre = response['units_pre'];
	//var title = response['title'];
	var title = "Clicks";
	var colors = response['colors'];
	var labels = response['labels'];
	var key = response['key'];
	var tooltips = response['tooltips'];

	if (line)
		RGraph.Clear(line.canvas);

	line = new RGraph.Line('linegraph', data[0], data[1]);
	
	//line.Set('chart.units.pre', units_pre);
	line.Set('chart.title', title);
	line.Set('chart.gutter', 40);
	line.Set('chart.shadow', false);
	line.Set('chart.shadow.color', '#aff');
	line.Set('chart.background.barcolor1', '#efd');
	line.Set('chart.background.barcolor2', '#efd');
	line.Set('chart.colors', ['rgb(64,163,255)', 'rgb(145,210,120)']);

	line.Set('chart.background.grid.color', 'rgba(238,238,238,1)');

	line.Set('chart.labels', labels);
	line.Set('chart.labels.above', true);
	line.Set('chart.key', key);
	line.Set('chart.key.background', 'rgba(255,255,255,0.7)');
	line.Set('chart.key.position', 'gutter');
	line.Set('chart.key.position.gutter.boxed', false);
	line.Set('chart.key.position.y', line.Get('chart.gutter') - 15);
	line.Set('chart.key.border', false);
	line.Set('chart.height', <?php echo $graph_height;?>);
	line.Set('chart.width', <?php echo $graph_width;?>);
	line.Set('chart.background.grid.width', 0.3); // Decimals are permitted
	line.Set('chart.tickmarks', ['circle', 'square']);

	line.Set('chart.linewidth', 2);
	line.Set('chart.tooltips.highlighting', false);
	

	line.Set('chart.text.color', '#000');
	line.Set('chart.text.font', '"Helvetica Neue",Arial,sans-serif');
	line.Set('chart.text.angle', 0);
	line.Set('chart.strokecolor', 'rgba(0,0,0,0)');
	line.Set('chart.tooltips.event', 'onmousemove');
	line.Set('chart.tooltips.effect', 'expand');
	
	if (!RGraph.isIE8()) {
	    line.Set('chart.tooltips', tooltips);
	}
	line.Draw();
}
  </script>
  
  
<script>
var pie = null;
function success_pie_draw(response) {
	data = response['data'];
		
	
	var title = "Location";
	//var colors = response['colors'];
	var labels = response['labels'];
	var key = response['key'];
	var tooltips = response['tooltips'];

	if (pie)
		RGraph.Clear(pie.canvas);

	pie = new RGraph.Pie('piegraph', data);

	pie.Set('chart.height', <?php echo $graph_height;?>);
	pie.Set('chart.width', <?php echo $graph_width;?>);
	//line.Set('chart.units.pre', units_pre);
	//line.Set('chart.colors', ['rgb(64,163,255)', 'rgb(145,210,120)']);

	pie.Set('chart.shadow', false);
	pie.Set('chart.title', title);
	pie.Set('chart.gutter', 40);
	pie.Set('chart.labels', labels);
	pie.Set('chart.key', key);
	pie.Set('chart.key.background', 'rgba(255,255,255,0.7)');
//	pie.Set('chart.key.position', 'gutter');
	pie.Set('chart.key.position.gutter.boxed', true);
	pie.Set('chart.key.position.y', pie.Get('chart.gutter') - 15);
	pie.Set('chart.key.border', false);
	pie.Set('chart.highlight.style', '3d');
	
	pie.Set('chart.background.grid.width', 0.3); // Decimals are permitted

	pie.Set('chart.linewidth', 5);
	pie.Set('chart.text.color', '#000');
	pie.Set('chart.text.font', '"Helvetica Neue",Arial,sans-serif');
	pie.Set('chart.tooltips.event', 'onmousemove');
	pie.Set('chart.tooltips.effect', 'fade');
	pie.Set('chart.labels.sticks', true);
	pie.Set('chart.strokestyle', 'white');
	
	if (!RGraph.isIE8()) {
		pie.Set('chart.zoom.hdir', 'center');
		pie.Set('chart.zoom.vdir', 'up');
		pie.Set('chart.labels.sticks', true);
		pie.Set('chart.labels.sticks.color', '#aaa')
		pie.Set('chart.tooltips', tooltips);
	}
	pie.Draw();
}
  </script>