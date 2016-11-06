<?php 

$products = array('');
$product_ids = array('');
$user_color = array('#DC143C','#FFD700','#939393','#292421','#00CD66');
$pm_statuses = array('PM Neglected','Due PM','Assigned','NO PM Data','Good Units');

$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_products.fk_category_id > 1 AND tbl_products.status=0 AND tbl_instruments.status=1");
if ($territory!=0)
	$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
	FROM `tbl_instruments`
	LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
	WHERE tbl_products.fk_category_id > 1 AND tbl_products.status=0 AND tbl_instruments.status=1 AND tbl_instruments.fk_office_id IN(".$territory.")");
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

	var options = {

        chart: {
            type: 'column',
			marginBottom: 100,
			backgroundColor: null
        },

        title: {
            text: ''
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
            verticalAlign: 'top',
            y: 25,
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
					if ($territory != 0)
						$eq	=	$this->db->query("select tbl_instruments.*,tbl_clients.client_name,tbl_cities.city_name
						from tbl_instruments
						LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_instruments.fk_client_id
						LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
						where `fk_product_id`=".$product_id ." AND tbl_instruments.`status`=1 AND tbl_instruments.fk_office_id IN(".$territory.")");
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
								$sap .= $rtza[0]['client_name']."(".$rtza[0]['serial_no']."), $interval days<br/>";
								
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
				echo "],";
				echo "color:'".$user_color[$k]."',";
				echo "showInLegend: true,";
				echo "},";
				$k++;
			}
		
		?> ]
    };
    
    $('#chart_real_time_territory_pm_view').highcharts(options);
	});
	
</script>	

