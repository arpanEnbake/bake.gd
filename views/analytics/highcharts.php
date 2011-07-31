<script type="text/javascript" src="resource/app/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="resource/app/js/highcharts/js/highcharts.js"></script>
<!--<script type="text/javascript" src="resource/app/js/highcharts/js/themes/gray.js"></script>-->
<!--<script type="text/javascript" src="resource/app/js/highcharts/js/modules/exporting.js"></script>-->

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
			<div style="width: 1000px; margin-bottom: 50px;"> 
				<div id="myCanvas" width="<?php echo $graph_width; + 50?>" 
						style=" align:center; background-color:white" 
						height="<?php echo $graph_height + 5;?>"><img src="resource/app/images/ajax-loader.gif" width="238" height="34"></img></div>
			
			</div>
			<div style="width: 1000px; margin-bottom: 50px;">
				<div id="linegraph" width="<?php echo $graph_width; + 50?>" 
						style=" align:center; background-color:white" 
						height="<?php echo $graph_height + 5;?>"><img src="resource/app/images/ajax-loader.gif" width="238" height="34"></img></div>
			
			</div>
			<div style="width: 1000px; margin-bottom: 50px;">
				<div id="piegraph" width="<?php echo $graph_width; + 50?>" 
						style=" align:center; background-color:white" 
						height="<?php echo $graph_height + 5;?>"><img src="resource/app/images/ajax-loader.gif" width="238" height="34"></img></div>
			
			</div>
			
		</div>  <!-- END #middle -->
	</div> <!-- end #external_container -->
</div>
	
	
<script>
//$("#TimePeriodDDId").selectmenu({width:'120px'});
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
	    	//success_pie_draw(response)
	    }
	});
}


</script>
	
<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
	var chart;
	function success_draw(response) {
		response['title'] = 'Clicks';
		var labels = response['labels'];
		var x = new Array();
		x = response['data'];

		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'myCanvas',
				defaultSeriesType: 'column'
			},
			title: {
				text: response['title']
			},
			xAxis: {
				categories: response['labels']
			},
			yAxis: {
				allowDecimals: false,
				min: 0,
				title: {
					text: 'Clicks'
				}
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.x +'</b><br/>'+
						 this.series.name +': '+ this.y +'<br/>'+
						 'Total: '+ this.point.stackTotal;
				}
			},
			plotOptions: {
				column: {
					stacking: 'normal'
				}
			},
		    series: x
		});

	}
</script>

<script>
var line_chart;
function success_line_draw(response){
	var data = new Array(new Array(), new Array());
	for (i in response['data'][0]) {
		data[0].push(parseInt(response['data'][0][i]));
	}
	for (i in response['data'][1]) {
		data[1].push(parseInt(response['data'][1][i]));
	}
	line_chart = new Highcharts.Chart({
		chart: {
			renderTo: 'linegraph',
			defaultSeriesType: 'area'
		},
		title: {
			text: 'Likes vs Tweets'
		},
		subtitle: {
			text: ''
		},
		xAxis: {
			labels:response['labels']
//				 {
//				formatter: function() {
//					return this.value; // clean, unformatted number for year
//				}
//			}
		},
		yAxis: {
			title: {
				text: 'Activity'
			},
			labels: {
				formatter: function() {
					return this.value;
				}
			}
		},
		tooltip: {
			formatter: function() {
				return this.series.name +' produced <b>'+
					Highcharts.numberFormat(this.y, 0) +'</b><br/>warheads in '+ this.x;
			}
		},
		plotOptions: {
//			area: {
//				pointStart: '23-Jul',
//				marker: {
//					enabled: false,
//					symbol: 'circle',
//					radius: 2,
//					states: {
//						hover: {
//							enabled: true
//						}
//					}
//				}
//			}
		},
		series: [{
			name: 'Likes',
			data: data[0]
		}, {
			name: 'Tweets',
			data:  data[1]
		}]
	});

};

</script>
