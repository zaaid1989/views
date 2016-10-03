<?php include('header.php');?>
<style>
.page-content
{
	padding:0 0 0 0 !important;
}
</style>

<script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>	

<?php  // 2nd
$territory = 0;
if ($this->session->userdata('userrole') != 'Admin' && $this->session->userdata('userrole') != 'secratery') {
	$territory = $this->session->userdata('territory');
}
$month = time();
$months = array('');
$products = array('');
$product_ids = array('');
$monthss = array('');
$offices = array('Rawalpindi Office','Lahore Office','Karachi Office','Multan Office','Peshawar Office');
$complaint_types = array('complaint','PM');
$complaint_status = array('Shifted','Pending Verification','SPRF Approved','Pending SPRF','Pending','Pending Registration','Closed');

$user_color = array('#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281');

$months_to_show = 6;
for ($i=0;$i<$months_to_show;$i++) {
	//array_push($months,date('F Y', $month), PHP_EOL) ;
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-1 month", $month);
}

if ($territory!=0){
//$q = $this->db->query("SELECT * FROM user WHERE fk_office_id='$territory' AND delete_status=0 AND userrole IN('FSE','Supervisor')");
$q = $this->db->query("SELECT * FROM user WHERE id IN (SELECT DISTINCT assign_to from tbl_complaints WHERE fk_office_id='$territory'  AND CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ) AND delete_status=0 AND userrole IN('FSE','Supervisor')");
}
else
	$q = $this->db->query("SELECT * FROM user WHERE id IN (SELECT DISTINCT assign_to from tbl_complaints WHERE CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ) AND userrole IN('FSE','Supervisor')");
$users = $q->result_array();

$m = 0;
foreach ($users AS $u)	{
		$s = substr(md5($u['first_name']), 25, 6);
		$result ="#".$s;
		$user_color[$m]=$result;//array_push($products,$t) ;
		$m++;
}
/////////////// Below for PM chart
$user_colorr = array('#292421','#00CD66','#FFD700','#DC143C');
$user_colorr = array('#DC143C','#FFD700','#939393','#292421','#00CD66');
$pm_statuses = array('NO PM Data','Good Units','Due PM','PM Neglected');
$pm_statuses = array('PM Neglected','Due PM','Assigned','NO PM Data','Good Units');





$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_products.fk_category_id > 1 AND tbl_products.status=0 AND tbl_instruments.status=1");
if ($territory != 0)
	$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
	FROM `tbl_instruments`
	LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
	WHERE tbl_products.fk_category_id > 1 AND tbl_products.status=0 AND tbl_instruments.status=1 AND tbl_instruments.fk_office_id='".$territory."'");
$product_results = $q->result_array();
$n = 0;
foreach ($product_results AS $p)	{
	if ($p['product_name']!=""){
		$t ="'".$p['product_name']."'";
		$products[$n]=$t;//array_push($products,$t) ;
		$product_ids[$n]=$p['pk_product_id'];//array_push($product_ids,$p['pk_product_id']) ;
	}
	$n++;
}
?>

<script>
$(document).ready(function() {


	
	var optionss = {

        chart: {
            type: 'column',
			height: 400,
			marginBottom: 150,
			backgroundColor: null
        },

        title: {
            text: 'PM Status - (Real Time)'
        },

        xAxis: {
			categories: [<?php echo  implode(',',$products);?>]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of Units',
				margin:20
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }
        },
		legend: {
            align: 'center',
            x: 0,
            verticalAlign: 'bottom',
            y: 2,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },

        tooltip: {
            formatter: function () {
				if (this.series.options.type === 'pie' || this.series.options.type === 'spline') { // the pie chart
                        return this.point.name + ': ' + this.y;
                    }
				else {
                return '' + this.x +  '<br/><b>' 
				+ 'PM'+  '</b><br/>' 
				+ this.series.name + ': ' + this.y + '<br/>'
				+ '<b>Details:</b>' + this.point.myData + '<br/>';
				}
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 0px black'
                    }
                }
            }
        },

        series: [
		<?php 
		
			$k=0;
			foreach ($pm_statuses AS $pm_status) {
				
				echo "{ name: '".$pm_status."',";
				echo "data: [";
				$i = 0;
				foreach ($product_ids AS $product_id) {
					$comma_limit 		= 	sizeof($product_ids) - 1;
					
					
					////////////////////////////// ************* Code for PM Graph *************** \\\\\\\\\\\\\\\\\\\\\\\\\\\\\
					$total_pms_completed	=	0; // Needed in PM graph
					$total_pms_pending	=	0; // Needed in PM graph
										
					$no_pm_data		=	0; // Needed in PM graph
					$good_units		=	0; // Needed in PM graph
					$due_units		=	0; // Needed in PM graph
					$past_due		=	0; // Needed in PM graph
					$neglected		=	0; // Needed in PM graph
					$pmc_assigned	=	0; // Needed in PM graph
					$pmc_assigned_late	=	0; // Needed in PM graph
					
					
					$eq	=	$this->db->query("select tbl_instruments.*,tbl_clients.client_name,tbl_cities.city_name
					from tbl_instruments
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_instruments.fk_client_id
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					where `fk_product_id`=".$product_id ." AND tbl_instruments.`status`=1");
					if ($territory!=0)
						$eq	=	$this->db->query("select tbl_instruments.*,tbl_clients.client_name,tbl_cities.city_name
						from tbl_instruments
						LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_instruments.fk_client_id
						LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
						where `fk_product_id`=".$product_id ." AND tbl_instruments.`status`=1 AND tbl_instruments.fk_office_id='".$territory."'");
					$er =	$eq->result_array();
					
					$sgu = "";
					$sdp = "";
					$spn = "";
					$snp = "";
					$sap = "";
					
					foreach ($er as $equipment) {
						if ($territory==0)
							$tyza	=	$this->db->query("select tbl_complaints.*,tbl_clients.client_name, tbl_instruments.serial_no
							from tbl_complaints
							LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_complaints.fk_customer_id
							LEFT JOIN tbl_instruments ON tbl_instruments.pk_instrument_id = tbl_complaints.fk_instrument_id
							where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC LIMIT 1");
						else
							$tyza	=	$this->db->query("select tbl_complaints.*,tbl_clients.client_name, tbl_instruments.serial_no
							from tbl_complaints
							LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_complaints.fk_customer_id
							LEFT JOIN tbl_instruments ON tbl_instruments.pk_instrument_id = tbl_complaints.fk_instrument_id
							where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC LIMIT 1");
						$rtza	= 	$tyza->result_array();
						
						if (!empty($rtza)) {
							  if ($rtza[0]['status'] != 'Completed') { // Pending or Pending Verification
								$total_pms_pending+=1;
								/// 13 July
								//$status			=	$rtza[0]['status'];
								$last_pm_date	=	strtotime($rtza[0]['date']);
								$current_date	=	time();
								$difference		=	$current_date - $last_pm_date;
								$interval		=	floor($difference/(60*60*24));
								if	($interval>10)	$pmc_assigned_late	+=	1;	
								else $pmc_assigned	+=	1;
								/// 13 July
								$sap .= $rtza[0]['client_name']."(".$rtza[0]['serial_no']."),<br/>";
								
							  }
							  else { //// Completed
								  $total_pms_completed+=1;	
								/// 13 July
								//$status			=	$rtza[0]['status'];
								$last_pm_date	=	strtotime($rtza[0]['finish_time']);
								$current_date	=	time();
								$difference		=	$current_date - $last_pm_date;
								$interval		=	floor($difference/(60*60*24));
								if	($interval<31)	{
									$good_units	+=	1; // Needed in PM graph Good Units
									$sgu .= $rtza[0]['client_name']."(".$rtza[0]['serial_no']."),<br/>";
								}
								if	($interval>30 && $interval<41)	{
									$due_units	+=	1; //needed in PM graph Due PM
									$sdp .= $rtza[0]['client_name']."(".$rtza[0]['serial_no']."),<br/>";
								}
								if	($interval>40 && $interval<51)	$past_due	+=	1;
								if	($interval>40)	{ // first it was 50 but then Yasir sb asked to make it 40
									$neglected	+=	1;
									$spn .= $rtza[0]['client_name']."(".$rtza[0]['serial_no']."),<br/>";
								}								
								
							  }													  
						}
						else {
							$total_pms_pending+=1;
							$no_pm_data	+=1;	// 13 July //Needed in PM graph No PM Data
							$snp .= $equipment['client_name']."(".$equipment['serial_no']."),<br/>";
						}
					}
				
				//$pm_statuses = array('NO PM Data','Good Units','Due PM','PM Neglected');
				//$units = 0;
					// Begin code to count Units of respective PM status
				if ($pm_status == "NO PM Data") {
					// code to calculate number of units
					echo "{y: ".$no_pm_data.", myData: '$snp'}";
				}
				if ($pm_status == "Good Units") {
					// code to calculate number of units
					echo "{y: ".$good_units.", myData: '$sgu'}";
				}
				if ($pm_status == "Assigned") {
					// code to calculate number of units
					$t = $pmc_assigned+$pmc_assigned_late;
					echo "{y: ".$t.", myData: '$sap'}";
				}
				if ($pm_status == "Due PM") {
					// code to calculate number of units
					echo "{y: ".$due_units.", myData: '$sdp'}";
				}
				if ($pm_status == "PM Neglected") {
					// code to calculate number of units
					echo "{y: ".$neglected.", myData: '$spn'}";
				}
						
					if ($i<$comma_limit) echo ",";
					$i++;
				}
				//echo "3, 4, 4, 2, 5,6";
				echo "],";
				echo "color:'".$user_colorr[$k]."',";
				echo "showInLegend: true,";
				//echo "stack: '".$complaint_nature."'";
				echo "},";
				$k++;
			}
		
		?> ]
    };
    
    $('#containerr').highcharts(optionss);
	});
	
</script>







<?php ///////////// 1st

if ($territory==0)
$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_instruments.pk_instrument_id IN (SELECT DISTINCT fk_instrument_id from tbl_complaints WHERE tbl_complaints.status NOT IN ('Closed','Completed') AND CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."') AND tbl_products.fk_category_id >= 1 AND tbl_products.status=0");
else
$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_instruments.pk_instrument_id IN (SELECT DISTINCT fk_instrument_id from tbl_complaints WHERE tbl_complaints.status NOT IN ('Closed','Completed') AND CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."') AND tbl_products.fk_category_id >= 1 AND tbl_products.status=0 AND tbl_instruments.fk_office_id ='".$territory."'");
$product_results = $q->result_array();

	
$n = 0;
foreach ($product_results AS $p)	{
	if ($p['product_name']!=""){
		$t ="'".$p['product_name']."'";
		$products[$n]=$t;//array_push($products,$t) ;
		$product_ids[$n]=$p['pk_product_id'];//array_push($product_ids,$p['pk_product_id']) ;
	}
	$n++;
}
//echo "unnus";
//print_r($product_ids);
//echo implode(',',$offices);



?>


<script>

$(document).ready(function() {


	
	var options = {

        chart: {
            type: 'column',
			height: 400,
			marginBottom: 150,
			backgroundColor: null
        },

        title: {
            text: 'TS Department PENDING Task (Real Time)'
        },

        xAxis: {
            //categories: ['Feb', 'Jan', 'Dec', 'Nov', 'Oct']
			//categories: [<?php echo  implode(',',$months);?>]
			categories: [<?php echo  implode(',',$products);?>]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of Pending Complaints and Assigned PM',
				margin:20
            },
            stackLabels: {
                enabled: true,
				shadow: false,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                },
				formatter: function() {
                    return  this.stack+"<br/>("+this.total+")";
                }
            }
        },
		legend: {
            align: 'center',
            x: 0,
            verticalAlign: 'bottom',
            y: 2,
            floating: false,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },

        tooltip: {
            formatter: function () {
				if (this.series.options.type === 'pie' || this.series.options.type === 'spline') { // the pie chart
                        return this.point.name + ': ' + this.y;
                    }
				else {
                //return '' + this.x +  '<br/><b>' + this.series.options.stack +  '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Total : ' + this.point.stackTotal;
				return '<b>' + this.series.name + '</b><br/><b style=\"color: #DC143C;\">Pending: ' + this.y + '</b><br/>'+ this.point.myData;
				}
            }
        },

        plotOptions: {
			"series": {
                events:{
                    legendItemClick:function(){
                        var name = this.name,
                            series = this.chart.series;
                        
                        $.each(series, function(i,serie){
                            if(serie.name == name) {
                                if(serie.visible)
                                    serie.hide();
                                else
                                    serie.show();
                            }
                        });
                        
                        return false;
                    }
			}},
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                }
            }
        },

        series: [
		<?php 
		$pending_complaints=0;
		$pending_pm=0;
		foreach ($complaint_types AS $complaint_nature) {
			$k=0;
			foreach ($users AS $user) {
				
				echo "{ name: '".$user['first_name']."',";
				echo "data: [";
				//for ($i=0;$i<$months_to_show;$i++) { // Loops through months
				$i=0;
				foreach ($product_ids AS $product_id) {
					$s="";
					$comma_limit 		= 	sizeof($product_ids) - 1;
					//$equipment_id		=	10;
					
					
					
					// Begin code to count complaints
					if ($territory!=0)
						$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status NOT IN ('Closed','Completed') AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_instruments`.fk_office_id = '".$territory."' AND `tbl_complaints`.assign_to='".$user['id']."'");
					else 
						$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status NOT IN ('Closed','Completed') AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."'");
						
						
						$cresult = $cquery->result_array();
						foreach ($cresult AS $comp)
								$s .= "<br/>".$comp['client_name'];
						
						if ($complaint_nature=='PM') $pending_pm += sizeof($cresult);
						else $pending_complaints += sizeof($cresult);
						
						echo "{y: ".sizeof($cresult).", myData: '$s'}";
					// End Code to count complaints

					if ($i<$comma_limit) echo ",";
					$i++;
				}
				//echo "3, 4, 4, 2, 5,6";
				echo "],";
				echo "color:'".$user_color[$k]."',";
				echo "showInLegend: true,";
				echo "stack: '".ucfirst($complaint_nature)."'";
				echo "},";
				$k++;
			}
		} 
		?>
	 ]
    };
    
    $('#container').highcharts(options);
	});
	
</script>	  

	
<?php //3rd
if ($territory!=0){ 
//$q = $this->db->query("SELECT * FROM user WHERE fk_office_id='$territory' AND delete_status=0 AND userrole IN('FSE','Supervisor')");
$q = $this->db->query("SELECT * FROM user WHERE id IN (SELECT DISTINCT assign_to from tbl_complaints WHERE fk_office_id='$territory'  AND CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ) AND delete_status=0 AND userrole IN('FSE','Supervisor')");
}
else
	$q = $this->db->query("SELECT * FROM user WHERE id IN (SELECT DISTINCT assign_to from tbl_complaints WHERE CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ) AND userrole IN('FSE','Supervisor')");
$users = $q->result_array();

$m = 0;
foreach ($users AS $u)	{
		$s = substr(md5($u['first_name']), 25, 6);
		$result ="#".$s;
		$user_color[$m]=$result;//array_push($products,$t) ;
		$m++;
}




if ($territory==0)
$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_instruments.pk_instrument_id IN (SELECT DISTINCT fk_instrument_id from tbl_complaints WHERE CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ORDER BY `date` ASC ) AND tbl_products.fk_category_id >= 1 AND tbl_products.status=0 ");
else
$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_instruments.pk_instrument_id IN (SELECT DISTINCT fk_instrument_id from tbl_complaints WHERE CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ORDER BY `date` ASC ) AND tbl_products.fk_category_id >= 1 AND tbl_products.status=0 AND tbl_instruments.fk_office_id='$territory'");
$product_results = $q->result_array();
$n = 0;
foreach ($product_results AS $p)	{
	if ($p['product_name']!=""){
		$t ="'".$p['product_name']."'";
		$products[$n]=$t;//array_push($products,$t) ;
		$product_ids[$n]=$p['pk_product_id'];//array_push($product_ids,$p['pk_product_id']) ;
	}
	$n++;
}
//echo "unnus";
//print_r($user_color);
//echo implode(',',$offices);



?>


<script>

$(document).ready(function() {

var ugly = ['', '2014', '', '2015',  ''];
var cats = ugly.concat(ugly).concat(ugly).concat(ugly).concat(ugly);
var zeroes = [];
cats.forEach(function () {zeroes.push(0);}); 
	
	var optionsss = {

        chart: {
            type: 'column',
			height: 400,
			marginBottom: 150,
			backgroundColor: null
        },

        title: {
            text: 'TS Department Activities (Last 30 Days - Real Time)'
        },

        xAxis: [
			{
            //categories: ['Feb', 'Jan', 'Dec', 'Nov', 'Oct']
			//categories: [<?php echo  implode(',',$months);?>]
			categories: [<?php echo  implode(',',$products);?>]
        }
	],
        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of Complaints and PM (Last 30 days)',
				margin:20
            },
            stackLabels: {
				//verticalAlign:"bottom",
                enabled: true,
				shadow: false,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                },
				formatter: function() {
                    return  this.stack+"<br/>("+this.total+")";
                }
            }
        },
		legend: {
            align: 'right',
            x: -20,
			y: 2,
            verticalAlign: 'bottom',
            floating: false,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },

        tooltip: {
            formatter: function () {
				if (this.series.options.type === 'pie' || this.series.options.type === 'spline') { // the pie chart
                        return this.point.name + ': ' + this.y;
                    }
				else {
               // return '' + this.x +  '<br/><b>' + this.series.options.stack +  '</b><br/><b>' + this.series.name + '</b><br/><b style=\"color: #009ACD;\">Total: ' + this.y + '</b><br/>' + this.point.myData + '<br/>';
			   return '<b>' + this.series.name + '</b><br/><b style=\"color: #009ACD;\">Total: ' + this.y + '</b><br/>' + this.point.myData + '<br/>';
				}
            }
        },

        plotOptions: {
			"series": {
                events:{
                    legendItemClick:function(){
                        var name = this.name,
                            series = this.chart.series;
                        
                        $.each(series, function(i,serie){
                            if(serie.name == name) {
                                if(serie.visible)
                                    serie.hide();
                                else
                                    serie.show();
                            }
                        });
                        
                        return false;
                    }
			}},
            column: {
                stacking: 'normal',
				groupPadding: 0.10,
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 0px black'
                    }
                }
            }
        },

        series: [
		<?php 
		$total_complaints=0;
		$total_pm = 0;
		$pending_complaints=0;
		$pending_pm=0;
		foreach ($complaint_types AS $complaint_nature) {
			$k=0;
			foreach ($users AS $user) {
				
				echo "{ name: '".$user['first_name']."',";
				echo "data: [";
				//for ($i=0;$i<$months_to_show;$i++) { // Loops through months
				$i=0;
				foreach ($product_ids AS $product_id) {
					$s = "";
					$comma_limit 		= 	sizeof($product_ids) - 1;
					//$equipment_id		=	10;
					
					$sd = date('Y-m-d');
					$ed = date('Y-m-d',strtotime("-30 days"));
					
					// Begin code to count complaints
					if ($territory==0) {
					$cqueryy = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status IN ('Completed','Closed')  AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."' AND CAST(`date` AS DATE) BETWEEN '".$ed."' AND '".$sd."' ORDER BY `date` ASC");
						
						
						$cqueryyy = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status NOT IN ('Completed','Closed')  AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."' AND CAST(`date` AS DATE) BETWEEN '".$ed."' AND '".$sd."' ORDER BY `date` ASC");
						
						$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."'  AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."' AND CAST(`date` AS DATE) BETWEEN '".$ed."' AND '".$sd."' ORDER BY `date` ASC");
					}
					else {
						$cqueryy = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status IN ('Completed','Closed')  AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."' AND CAST(`date` AS DATE) BETWEEN '".$ed."' AND '".$sd."' AND tbl_instruments.fk_office_id='$territory' ORDER BY `date` ASC");
						
						
						$cqueryyy = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status NOT IN ('Completed','Closed')  AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."' AND CAST(`date` AS DATE) BETWEEN '".$ed."' AND '".$sd."' AND tbl_instruments.fk_office_id='$territory' ORDER BY `date` ASC");
						
						$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."'  AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."' AND CAST(`date` AS DATE) BETWEEN '".$ed."' AND '".$sd."' AND tbl_instruments.fk_office_id='$territory' ORDER BY `date` ASC");
					}	
						$cresultt = $cqueryy->result_array();
						
						
						
						$cresulttt = $cqueryyy->result_array();
				
						
						
						$cresult = $cquery->result_array();
						
						//if (sizeof($cresult)==0) continue;
						
						if ($complaint_nature=='PM') {
							//$s .= "<br/><b style=\"color: #00CD66;\">PM Completed: ".sizeof($cresultt)."</b>";
							$s .= "<br/><b style=\"color: #DC143C;\">PM Pending: ".sizeof($cresulttt)."</b>";
							$total_pm += sizeof($cresult);
							$pending_pm += sizeof($cresulttt);
						}
						else {// complaint
							//$s .= "<br/><b style=\"color: #00CD66;\">Complaints Closed: ".sizeof($cresultt)."</b>";
							$s .= "<br/><b style=\"color: #DC143C;\">Complaints Pending: ".sizeof($cresulttt)."</b><br/>";
							/*
							foreach ($cresulttt AS $pending_complaint) {
								$s.= "<br/>".$pending_complaint['ts_number'];
							}*/
							$total_complaints += sizeof($cresult);
							$pending_complaints += sizeof($cresulttt);
						}
						
						//echo sizeof($cresult);
						echo "{y: ".sizeof($cresult).", myData: '$s'}";
						/*
						if (sizeof($cresult)!=0)
							echo "{y: ".sizeof($cresult).", myData: '$s'}";
						else
							echo "{y: null, myData: '$s'}";
						*/
					// End Code to count complaints

					if ($i<$comma_limit) echo ",";
					$i++;
				}
				//echo "3, 4, 4, 2, 5,6";
				echo "],";
				echo "color:'".$user_color[$k]."',";
				echo "showInLegend: true,";
				echo "stack: '".ucfirst($complaint_nature)."'";
				echo "},";
				$k++;
			}
		} 
		?>
		 ]
    };
    
    $('#containerrr').highcharts(optionsss);
	});
	
</script>	

<?php //4th

$month = time();
$months = array('');
$monthss = array('');
$offices = array('Rawalpindi Office','Lahore Office','Karachi Office','Multan Office','Peshawar Office');
$complaint_status = array('Shifted','Pending Verification','SPRF Approved','Pending SPRF','Pending','Pending Registration','Closed');
$status_color = array('#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281');
$months_to_show = 6;
for ($i=0;$i<$months_to_show;$i++) {
	//array_push($months,date('F Y', $month), PHP_EOL) ;
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-31 Days", $month); // might not to change this to -1 months or something
}
//print_r($months);
//echo implode(',',$offices);
$months = array_reverse($months);
$monthss = array_reverse($monthss);

$products = array('');
$product_ids = array('');
$chart_type = array('Complaints','Products');

$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_products.fk_category_id > 1 AND tbl_products.status=0 ORDER BY tbl_products.product_name ");
$product_results = $q->result_array();
$n = 0;
foreach ($product_results AS $p)	{
	if ($p['product_name']!=""){
		$t ="'".$p['product_name']."'";
		$products[$n]=$t;//array_push($products,$t) ;
		$product_ids[$n]=$p['pk_product_id'];//array_push($product_ids,$p['pk_product_id']) ;
	}
	$n++;
}
//print_r($products);
//print_r($product_ids);

$product_color = array('#E94C6F','#1FDA9A','#28ABE3','#E8B71A','#542733','#5A6A62','#C6D5CD','#FDF200','#69D2E7','#F38630','#588C73','#5E412F','#DB3340','#E8B71A','#F7EAC8','#1FDA9A','#28ABE3','#E94C6F','#542733','#5A6A62','#C6D5CD','#FDF200','#69D2E7','#F38630','#588C73','#5E412F');

?>


<script>
$(document).ready(function() {


	
	var optionssss = {

        chart: {
            type: 'column',
			backgroundColor: null
        },

        title: {
            text: 'Complaints Monthly Overview'
        },

        xAxis: {
            //categories: ['Feb', 'Jan', 'Dec', 'Nov', 'Oct']
			categories: [<?php echo  implode(',',$months);?>]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of Complaints',
				margin:20
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }
        },
		legend: {
            align: 'right',
			enabled: true,
            x: 0,
            verticalAlign: 'bottom',
            y: 5,
            floating: false,
            backgroundColor: 'white',
            borderColor: '#CCC', 
            borderWidth: 1,
            shadow: false
        },

        tooltip: {
            formatter: function () {
				if (this.series.options.type === 'pie' || this.series.options.type === 'spline') { // the pie chart
                        return this.point.name + ': ('+this.point.myData+' units)' + this.y;
                    }
				else {
                return '' + this.series.name + ': ' + this.point.myData ;
				}
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 0px black'
                    }
                }
            }
        },

        series: [
		<?php 
		$j= 0; // will be used for office id, started from 1 as id of rawalpindi office is 1
		//for($j=0;$j<2;$j++) { // 1 for complaints stack 2nd for total number of products
		for($j=0;$j<1;$j++) { // changing above to present as they dont need total number of products in this graph
			$k=0;
			foreach ($product_ids AS $product_id) {
				
				echo "{ name: ".$products[$k].",";
				echo "data: [";
				for ($i=0;$i<$months_to_show;$i++) { // Loops through months
					$comma_limit 		= 	$months_to_show - 1;
					//$equipment_id		=	10;
					
					$first_of_month 	= 	$monthss[$i].'-01';
					$last_of_month		= 	$monthss[$i].'-31';
					
					// Begin code to count complaints
					if ($territory==0) {
					$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_instruments`.fk_product_id = '".$product_id."' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ORDER BY `date` ASC");
						$cresult = $cquery->result_array();
						
						$cqueryy = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status!='Closed' AND `tbl_instruments`.fk_product_id = '".$product_id."' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."'  ORDER BY `date` ASC");
						$cresultt = $cqueryy->result_array();
						
						$q = $this->db->query("SELECT * from tbl_instruments WHERE status='1' AND fk_product_id='".$product_id."'");
						$productss = $q->result_array();
						$string= "(".sizeof($productss)." units)<br/>Total = ".sizeof($cresult)."<br/>Pending = ".sizeof($cresultt);
					}
						if ($territory!=0) {
						$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_instruments`.fk_office_id = '".$territory."' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ORDER BY `date` ASC");
						$cresult = $cquery->result_array();
						
						$cqueryy = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status!='Closed' AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_instruments`.fk_office_id = '".$territory."' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."'  ORDER BY `date` ASC");
						$cresultt = $cqueryy->result_array();
						
						
						$q = $this->db->query("SELECT * from tbl_instruments WHERE status='1' AND fk_product_id='".$product_id."' AND fk_office_id='".$territory."'");
						$productss = $q->result_array();
						$string= "(".sizeof($productss)." units)<br/>Total = ".sizeof($cresult)."<br/>Pending = ".sizeof($cresultt);
						}
						
						
						// count products
						
						
						
						if ($j==0)
							echo "{y: ".sizeof($cresult).", myData: '$string'}";//echo sizeof($cresult);
						//else echo 5;
					// End Code to count complaints

					if ($i<$comma_limit) echo ",";
				}
				//echo "3, 4, 4, 2, 5,6";
				echo "],";
				echo "color:'".$product_color[$k]."',";
				echo "showInLegend: true,";
				//echo "stack: '".$chart_type[$j]."'";
				echo "},";
				$k++;
			}
		} 
		?>
		]
    };
    
    $('#containerrrr').highcharts(optionssss);
	});
	
	
	
</script>	


            <!-- BEGIN PAGE HEADER-->
                    <div class="col-lg-12"  style="background-color:#e5e5e5 ;color: #333333; padding:5px 0; font-size:20px;">
                    	
                    	<marquee class="col-lg-11">
					<?php
						  $ty21=$this->db->query("select * from user where id='".$this->session->userdata('userid')."'");
						  $rt21=$ty21->result_array();
						  $ty22=$this->db->query("select * from tbl_news where fk_office_id IN ('".$rt21[0]['fk_office_id']."', '0') order by pk_news_id DESC");
						  $rt22=$ty22->result_array();
						  if (sizeof($rt22) == "0") {
							  
						  } else {
							  
							  if($this->session->userdata('userrole')=='Admin')
							  { /* ?>
						  
										<span style="font-size:16px;  color: #d91e18; margin: 0px 0px 15px 0px;font-weight: bold;  ">
                                            <?php echo "Just for Mr Yasir"; ?>&nbsp;
                                        </span>
                                        <span style="font-size:16px;  color: #d91e18; margin: 0px 0px 15px 0px;font-weight: 300; text-decoration: underline;">
										<?php echo "A comments thread has been added (see the last column) against every complaint. It is accessible by FSE/SAP, Respective Supervisor and Director. New comments notification will appear on the button of individual complaint. In my personal opinion it is quite good for complaint related discussion. If you like it, we will put it in PMs too, otherwise remove it from here as well.";?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  
						<?php */ }
							  foreach ($rt22 as $get_users_list) {
								  ?>
                                        <span style="font-size:16px;  color: #333333; margin: 0px 0px 15px 0px;font-weight: bold;">
                                            <?php echo urldecode(substr($get_users_list["news_title"], 0, 75));?>&nbsp;
                                        </span>
                                        <span style="font-size:16px;  color: #333333; margin: 0px 0px 15px 0px;font-weight: 300;">
										<?php echo urldecode(substr($get_users_list["news_description"], 0, 100));?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <?php
							  }
						  }
					?>
                    </marquee>
                    </div>
					
					<?php if($this->session->userdata('userrole')=="FSE" || $this->session->userdata('userrole')=="Supervisor") {?>
				<div class="row" style="padding-top:60px;padding-left:60px;padding-right:60px;">
				
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">TS Department PENDING Task (Real Time)</span>
								</div>
							</div>
							<div class="portlet-body" style="  ">
									<div id="container" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">PM Status - (Real Time)</span>
								</div>
							</div>
							<div class="portlet-body" style="   ">
									<div id="containerr" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			
			<?php if($this->session->userdata('userrole')=="Supervisor") {?>
				<div class="row" style="padding-top:10px;padding-left:60px;padding-right:60px;">
				
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">TS Department Activities (Last 30 Days - Real Time)</span>
								</div>
							</div>
							<div class="portlet-body" style="  ">
									<div id="containerrr" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">Complaints Monthly Overview</span>
								</div>
							</div>
							<div class="portlet-body" style="   ">
									<div id="containerrrr" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($this->session->userdata('userrole')!="FSE" && $this->session->userdata('userrole')!="Supervisor") {?>
					<center >
					<img style="margin-top:35px;" src="<?php echo base_url();?>assets/global/img/PMA23.png" class="imgresponsive2"  >
					</center>
					<h3 class="page-title" style="text-align:center;margin-top:35px;">
			<?php } else echo '<h3 class="page-title" style="text-align:center;">	'; ?>
                Welcome to Online Management Portal
                <p><small>You last logged in from IP <span class="font-green-jungle" ><?php echo $rt21[0]['last_login_ip'];?></span></small>
                <small> on <?php echo date('d-M-Y', strtotime($rt21[0]['last_login_date']));?></small>
                <small> at <?php echo date('h:i A', strtotime($rt21[0]['last_login_date']));?></small>
				<?php
					$country	= 	"Unknown";
					$city 		=	"Unknown";
					$isp		=	"Unknown";
					//$ip = $_REQUEST['REMOTE_ADDR']; // the IP address to query
					$ip	=	$rt21[0]['last_login_ip'];
					$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
					if($query && $query['status'] == 'success') {
					  //echo 'Hello visitor from '.$query['country'].', '.$query['city'].'!';
						$country	= 	$query['country'];
						$city 		=	$query['city'];
						$isp		=	$query['isp'];
						echo '<small> from ' . $city . ', '. $country . ' using ' . $isp . '</small>';
					} else {
					  //echo 'Unable to get location';
					}
				?>
              </p>  
			</h3>
			
				
                <div class="row">
                	<div class="col-lg-12">
                    </div>
                </div>
				
	
	</div>
	
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	<a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
	
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<?php include('footer.php');?>