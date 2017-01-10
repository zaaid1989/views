<?php 

$month = time();
$months = array('');
$monthss = array('');
$months_to_show = 12;
for ($i=0;$i<$months_to_show;$i++) {
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-1 months", $month); // might have to change this to -1 months or something
}
$months = array_reverse($months); // in application format
$monthss = array_reverse($monthss); // in sql format


$visits_per_month = array('');
$CI =& get_instance();
for ($i=0;$i<$months_to_show;$i++) {
	$visits_per_month[$i] =	$CI->visits_in_month($fk_employee_id,$monthss[$i]); 
}

?>

<script>
///////////////////*********************** VISITS PER Month CHART ***********************\\\\\\\\\\\\\\\\\\\\
$(document).ready(function() {
/*
	var options = {
		chart: {
			backgroundColor: null
        },
        title: {
            text: '',
           // x: -20 //center
        },
        subtitle: {
           // text: 'Source: WorldClimate.com',
           // x: -20
        },
        xAxis: {
            categories: [<?php echo  implode(',',$months);?>]
        },
        yAxis: {
            title: {
                text: 'Average Visits'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' Visits'
        },
        legend: {
            layout: 'vertical',
            align: 'center',
            verticalAlign: 'top',
            borderWidth: 0
        },

        series: [{
            name: 'Visits Per Month',
            data: [<?php echo  implode(',',$visits_per_month);?>]
        }]
    };
*/
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
                text: 'Number of Visits',
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
                return '' + this.series.name + ': ' + this.y + this.point.myData ;
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
		
				echo "{ name: 'Vists this Month',";
				echo "data: [";
				for ($i=0;$i<$months_to_show;$i++) { // Loops through months
					$comma_limit 		= 	$months_to_show - 1;
					
					$first_of_month 	= 	$monthss[$i].'-01';
					$number = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($monthss[$i])), date('Y', strtotime($monthss[$i])));
					$last_of_month		= 	$monthss[$i].'-'.$number;
					//$last_of_month		= 	$monthss[$i].'-31';
					
					$string = "";
					echo "{y: ".$visits_per_month[$i].", myData: '$string'}";
					if ($i<$comma_limit) echo ",";
				}
				echo "],";
				echo "color:'#FF007F',";
				echo "showInLegend: true";
				echo "}";
				
		?>
		]
    };
    
    $('#chart_visits_per_month').highcharts(options);
	});
</script>
<script>
		 
		 $(document).ready(function() { 
			var table0 = $('#table_0').dataTable({
			  'iDisplayLength': 1000,
			  'aaSorting': []
			 // ,'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
		
			var table1 = $('#table_1').dataTable({
			  'iDisplayLength': 1000,
			  'aaSorting': []
			 // ,'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
		
		var table2 = $('#table_2').dataTable({
			  'iDisplayLength': 1000,
			  'aaSorting': []
			 // ,'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
});

</script>
<?php
$cq = $this->db->query("SELECT tbl_clients.pk_client_id,tbl_clients.client_name, COALESCE(tbl_cities.city_name) AS city_name,COALESCE(GROUP_CONCAT(mp.product_name SEPARATOR ', ')) AS main_equipment, COALESCE(GROUP_CONCAT(ap.product_name SEPARATOR ', ')) AS aux_equipment,
(SELECT COUNT(*) FROM business_data WHERE Customer = tbl_clients.pk_client_id AND status=0) as total_projects,
(SELECT max(tbl_dvr.date) FROM tbl_dvr WHERE tbl_dvr.fk_engineer_id = '$fk_employee_id' AND tbl_dvr.fk_customer_id = tbl_clients.pk_client_id AND CAST(tbl_dvr.`date` AS DATE) <= '$end_date') AS recent_visit
FROM `tbl_clients`
LEFT JOIN tbl_offices ON tbl_clients.fk_office_id = tbl_offices.pk_office_id
LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
LEFT JOIN tbl_instruments mi ON mi.fk_client_id = tbl_clients.pk_client_id
LEFT JOIN (SELECT * FROM tbl_products WHERE tbl_products.fk_type_id='1') mp ON mi.fk_product_id = mp.pk_product_id
LEFT JOIN (SELECT * FROM tbl_products WHERE tbl_products.fk_type_id='2') ap ON mi.fk_product_id = ap.pk_product_id
WHERE  tbl_clients.delete_status = '0'  AND tbl_clients.pk_client_id IN (SELECT fk_client_id FROM tbl_customer_sap_bridge WHERE fk_user_id='$fk_employee_id')
GROUP BY tbl_clients.pk_client_id");
$cr = $cq->result_array();
$portlet_title = array('Never Visited Customers (With Project & Last Visit > 120 days)','Ignored Customers','Never Visited Customers (No Projects Assigned)');
$portlet_color = array('grey-gallery','blue-chambray','purple-plum');
?>
<?php for($i=0;$i<3;$i++){?>
<div class="col-md-12">
<div class="portlet solid bordered light bg-inverse">
                <div class="portlet-title">
					<div class="caption font-<?php echo $portlet_color[$i]; ?>">
								<i class="icon-globe font-<?php echo $portlet_color[$i]; ?>"></i>
								<span class="caption-subject bold uppercase"><?php echo $portlet_title[$i]; ?></span>
					</div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
				
            <div class="portlet-body">
			<div class="row">
                    <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
						<table class="table table-hover " id="table_<?php echo $i; ?>">
							<thead class="bg-<?php echo $portlet_color[$i]; ?>">
								<tr >
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
								<tr >
									<th>City</th>
									<th>Customer</th>
									<th>Installed Equipment</th>
									<th>Other Assigned SAP</th>
									<th>Total Projects</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if (sizeof($cr) == "0") {} 
							else {        
										  foreach ($cr as $client) {
											  $now 		 = strtotime($end_date); 
											  $your_date = strtotime($end_date);
											  //$now 		 = time(); 
											  //$your_date = time();
											  if ($client["recent_visit"]!="")
												$your_date = strtotime($client["recent_visit"]);
											  $datediff  = $now - $your_date;
											  $mydiffrence = floor($datediff/(60*60*24));
											  if ($i==0) {
												  if ($client["recent_visit"] == "" || $mydiffrence <= 120) continue;
											  }
											  if ($i==1) {
												  if ($client["recent_visit"] == "" || $mydiffrence > 120 || $mydiffrence < 49) continue;
											  }
											  
											  if ($i==2) {
												  if ($client["total_projects"]>0) continue;
											  }
											 
											?>
											<tr>
												<td><?php echo $client["city_name"]; ?></td>
												<td><?php echo $client["client_name"]; ?></td>
												<td><?php echo $client["main_equipment"];?></td>
												<td><?php //if($client["recent_visit"]!="") echo date('d-M-Y',strtotime($client["recent_visit"]));?></td>
												<td><?php echo $client["total_projects"]; ?></td>
												</tr>
											
							<?php  
							}}
?>
						</tbody>
						</table>
						</div>
                    </div>
					
				</div>
				</div>	
</div>
<?php } ?>