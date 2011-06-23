<?php echo $this->load->view('inner_elements/header'); ?>
  
  <script type="text/javascript" src="resource/app/js/FusionCharts/FusionCharts.js"></script>    
    <div id="chartContainer">FusionCharts will load here!</div>          
    <script type="text/javascript">    

    var data = '{ "chart": { "caption" : "Weekly Sales Summary" , "xAxisName" : "Week", "yAxisName" : "Sales", "numberPrefix" : "$" }, "data" : [ { "label" : "Week 1", "value" : "14400" }, { "label" : "Week 2", "value" : "19600" }, { "label" : "Week 3", "value" : "24000" }, { "label" : "Week 4", "value" : "15700" } ] }';
      var myChart =  new FusionCharts( "resource/app/js/FusionCharts/Column3D.swf", 
                                      "myChartId", "400", "300", "0" , "0" );
      myChart.setDataURL(data);
      myChart.render("chartContainer");
      
    </script>        
  <?php echo $this->load->view('inner_elements/footer'); ?>