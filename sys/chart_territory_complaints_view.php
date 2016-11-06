<?php 
$month = time();
$months = array('');
$monthss = array('');
$months_to_show = 6;
for ($i=0;$i<$months_to_show;$i++) {
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-31 Days", $month); // might not to change this to -1 months or something
}
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
		$products[$n]=$t;
		$product_ids[$n]=$p['pk_product_id'];
	}
	$n++;
}

$product_color = array('#E94C6F','#1FDA9A','#28ABE3','#E8B71A','#542733','#5A6A62','#C6D5CD','#FDF200','#69D2E7','#F38630','#588C73','#5E412F','#DB3340','#E8B71A','#F7EAC8','#1FDA9A','#28ABE3','#E94C6F','#542733','#5A6A62','#C6D5CD','#FDF200','#69D2E7','#F38630','#588C73','#5E412F');

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
            align: 'center',
			enabled: true,
            x: 0,
            verticalAlign: 'top',
            y: 25,
            floating: false,
            backgroundColor: '#FFF',
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
						WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_instruments`.fk_office_id IN(".$territory.") AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ORDER BY `date` ASC");
						$cresult = $cquery->result_array();
						
						$cqueryy = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status!='Closed' AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_instruments`.fk_office_id IN(".$territory.") AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."'  ORDER BY `date` ASC");
						$cresultt = $cqueryy->result_array();
						
						
						$q = $this->db->query("SELECT * from tbl_instruments WHERE status='1' AND fk_product_id='".$product_id."' AND fk_office_id IN(".$territory.")");
						$productss = $q->result_array();
						$string= "(".sizeof($productss)." units)<br/>Total = ".sizeof($cresult)."<br/>Pending = ".sizeof($cresultt);
						}
						
						// count products
						
						if ($j==0)
							echo "{y: ".sizeof($cresult).", myData: '$string'}";
						
					// End Code to count complaints

					if ($i<$comma_limit) echo ",";
				}
				echo "],";
				echo "color:'".$product_color[$k]."',";
				echo "showInLegend: true,";
				echo "},";
				$k++;
			}
		} 
		?>
		]
    };
    
    $('#chart_territory_complaints_view').highcharts(options);
	});
</script>	