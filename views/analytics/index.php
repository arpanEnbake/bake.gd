<html>
<head>
<base href="<?php echo base_url(); ?>" />
<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>

</head>
<body>
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
		bar5.Set('chart.width', 500);
		bar5.Set('chart.background.grid.width', 0.3); // Decimals are permitted
		bar5.Set('chart.text.angle', 0);
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
/*
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
  }*/  
  </script>

</body>
</html>