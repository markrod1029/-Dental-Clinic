<?php include('include/session.php');?>

<?php 
  include '../timezone.php'; 
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }
?>





            <?php
   $and = 'AND YEAR(date) = '.$year;
   $months = array();
   $Asthma = array();
   $Diaria = array();
   $Diabetes = array();
   $Dengue = array();
   $Others = array();
   for( $m = 1; $m <= 12; $m++ ) {
 
 
 
     $sql = "SELECT * FROM appointment_table WHERE MONTH(date) = '$m' AND disease = 'Asthma' $and";
     $oquery = $conn->query($sql);
     array_push($Asthma, $oquery->num_rows);
 
     $sql = "SELECT * FROM appointment_table WHERE MONTH(date) = '$m' AND disease = 'Diaria' $and";
     $pquery = $conn->query($sql);
     array_push($Diaria, $pquery->num_rows);
 
     
 
     $sql = "SELECT * FROM appointment_table WHERE MONTH(date) = '$m' AND disease = 'Diabetes' $and";
     $bquery = $conn->query($sql);
     array_push($Diabetes, $bquery->num_rows);
 
     $sql = "SELECT * FROM appointment_table WHERE MONTH(date) = '$m' AND disease = 'Dengue' $and";
     $cquery = $conn->query($sql);
     array_push($Dengue, $cquery->num_rows);
 
     $sql = "SELECT * FROM appointment_table WHERE MONTH(date) = '$m' AND disease = 'Others' $and";
     $cquery = $conn->query($sql);
     array_push($Others, $cquery->num_rows);
 
 
  
 
  
 
     $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
     $month =  date('M', mktime(0, 0, 0, $m, 1));
     array_push($months, $month);
   }
   
 
 
   $months = json_encode($months);
   $Asthma = json_encode($Asthma);
   $Diaria = json_encode($Diaria);
   $Diabetes = json_encode($Diabetes);
   $Dengue = json_encode($Dengue);
   $Others = json_encode($Others);

 
 
 

?>






<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Top Oil Reserves"
	},
	axisY: {
		title: "Reserves(MMbbl)"
	},
	data: [{        
		type: "column",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "MMbbl = one million barrels",
		dataPoints: [      
			{ y: <?php echo $Asthma;   ?>, label: 'Asthma'}
			{ y: <?php echo $Diabetes;   ?>,  label: 'Diabetes' },
			{ y: <?php echo $Dengue;   ?>,  label: 'Dengue'},
			{ y: <?php echo $Others;   ?>,  label: 'Others' },


		]
	}]
});
chart.render();

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>