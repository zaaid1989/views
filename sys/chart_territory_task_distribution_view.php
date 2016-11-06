<?php 

$products = array('');
$product_ids = array('');
$complaint_types = array('complaint','PM');
$complaint_status = array('Shifted','Pending Verification','SPRF Approved','Pending SPRF','Pending','Pending Registration','Closed');
$user_color = array('#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281');

if ($territory!=0){
$q = $this->db->query("SELECT * FROM user WHERE id IN (SELECT DISTINCT assign_to from tbl_complaints WHERE fk_office_id IN($territory)  AND CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ) AND delete_status=0 AND userrole IN('FSE','Supervisor')");
}
else
	$q = $this->db->query("SELECT * FROM user WHERE id IN (SELECT DISTINCT assign_to from tbl_complaints WHERE CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ) AND userrole IN('FSE','Supervisor')");
$users = $q->result_array();

$m = 0;
foreach ($users AS $u)	{
		$s = substr(md5($u['first_name']), 25, 6);
		$result ="#".$s;
		$user_color[$m]=$result;
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
WHERE tbl_instruments.pk_instrument_id IN (SELECT DISTINCT fk_instrument_id from tbl_complaints WHERE CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ORDER BY `date` ASC ) AND tbl_products.fk_category_id >= 1 AND tbl_products.status=0 AND tbl_instruments.fk_office_id IN($territory)");
$product_results = $q->result_array();
$n = 0;
foreach ($product_results AS $p)	{
	if ($p['product_name']!=""){
		$t ="'".$p['product_name']."'";
		$products[$n]=$t;
		$product_ids[$n]=$p['pk_product_id'];
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

        xAxis: [
			{
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
            align: 'center',
            x: 0,
			y: 2,
            verticalAlign: 'top',
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
				$i=0;
				foreach ($product_ids AS $product_id) {
					$s = "";
					$comma_limit 		= 	sizeof($product_ids) - 1;
					
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
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status IN ('Completed','Closed')  AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."' AND CAST(`date` AS DATE) BETWEEN '".$ed."' AND '".$sd."' AND tbl_instruments.fk_office_id IN($territory) ORDER BY `date` ASC");
						
						
						$cqueryyy = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status NOT IN ('Completed','Closed')  AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."' AND CAST(`date` AS DATE) BETWEEN '".$ed."' AND '".$sd."' AND tbl_instruments.fk_office_id IN($territory) ORDER BY `date` ASC");
						
						$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."'  AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."' AND CAST(`date` AS DATE) BETWEEN '".$ed."' AND '".$sd."' AND tbl_instruments.fk_office_id IN($territory) ORDER BY `date` ASC");
					}	
						$cresultt = $cqueryy->result_array();
						$cresulttt = $cqueryyy->result_array();
						$cresult = $cquery->result_array();
						
						if ($complaint_nature=='PM') {
							$s .= "<br/><b style=\"color: #DC143C;\">PM Pending: ".sizeof($cresulttt)."</b>";
							$total_pm += sizeof($cresult);
							$pending_pm += sizeof($cresulttt);
						}
						else {
							$s .= "<br/><b style=\"color: #DC143C;\">Complaints Pending: ".sizeof($cresulttt)."</b><br/>";
							$total_complaints += sizeof($cresult);
							$pending_complaints += sizeof($cresulttt);
						}
						
						echo "{y: ".sizeof($cresult).", myData: '$s'}";
						
					// End Code to count complaints

					if ($i<$comma_limit) echo ",";
					$i++;
				}
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
    
    $('#chart_territory_task_distribution_view').highcharts(options);
	});
	
	$('#total_complaints').text('<?php echo $total_complaints; ?>');
	$('#total_pm').text('<?php echo $total_pm; ?>');
	$('#pending_complaints').text('<?php echo $pending_complaints; ?>');
	$('#pending_pm').text('<?php echo $pending_pm; ?>');
</script>	