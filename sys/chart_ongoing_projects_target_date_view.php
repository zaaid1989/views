<?php 

$month = time();
$months = array('');
$monthss = array('');

$months[1] = "'".date('F Y', strtotime("-1 months", $month))."'";
$monthss[1] = date('Y-m', strtotime("-1 months", $month));
$months[0] = "'".date('F Y', strtotime("-2 months", $month))."'";
$monthss[0] = date('Y-m', strtotime("-2 months", $month));
$months_to_show = 12;

for ($i=2;$i<$months_to_show;$i++) {
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("+1 month", $month);
}

$user_color = array('#BC7642','#ee0000','#ff1493','#ffc0cb','#000000','#d2d3d5');
$project_statuses = array('Final Extension','Extension 2','Extension 1','Original Date','Expired');
$project_types = array('New Business','Recurring','Assay Addition','Techincal Support','Base Protection','Others','Unknown');
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
                text: 'Projects',
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
            y: 0,
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
                return '<b>' + this.x +  '' 
				+ ''+  '</b><br/>' 
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
			foreach ($project_statuses AS $project_status) {
				
				echo "{ name: '".$project_status."',";
				echo "data: [";
				for ($i=0;$i<12;$i++) { // Loops through months
				
					$comma_limit 		= 	11;
					
					$first_of_month 	= 	$monthss[$i].'-01';
					$last_of_month		= 	$monthss[$i].'-31';
					
					$original_date_projects = 0;
					$extension_projects = 0; // renamed to extension 1
					$extension_1_projects = 0; // renamed to extension 2
					$final_extension_projects = 0;
					$expired_projects = 0;
					$no_td_projects = 0;
					
					$queryy = "select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_business_types.businesstype_name,tbl_project_strategy.fk_project_id, max(tbl_project_strategy.target_date) AS `target_date_recent`
					from tbl_project_strategy
					JOIN business_data ON business_data.pk_businessproject_id = tbl_project_strategy.fk_project_id
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
					where  CAST(tbl_project_strategy.`target_date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."'  AND business_data.`status`=0 AND tbl_project_strategy.`strategy_status`='1' ";
					
					if ($territory!=0) {
						$queryy .= " AND `Territory`='".$territory."' ";
					}
					if ($sap!=0) {
						$queryy .= " AND `Sales Person`='".$sap."' ";
					}
					$queryy .= " Group By tbl_project_strategy.fk_project_id ";
					$queryy .= " ORDER BY tbl_clients.client_name ";
					$pq	=	$this->db->query($queryy);
					$pr =	$pq->result_array();
					
					$s_original_date = ""; // string ignored projects
					$s_extension = ""; // string inactive projects // renamed to extension 1
					$s_extension_1 = ""; // string inactive projects // renamed to extension 2
					$s_final_extension = ""; // string inactive projects
					$s_expired = ""; // string inactive projects
					$s_no_td = ""; // string inactive projects
					
					foreach ($pr as $project) {
						
						$ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$project["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
						  $rt=$ty->result_array();
						  $pc = $project['client_name'] . "-" . $project['businesstype_name']."-";
						  if($ty->num_rows()>0)  //at least one visit
							$d = date('d-M-Y',strtotime($rt[0]['date']));
						  else 
							   $d = "No Visits";
							  
							  
							  $now 		 = time(); 
							  $your_date = strtotime($project["target_date_recent"]);
							  $datediff  = $now - $your_date;
							  $mydiffrence = floor($datediff/(60*60*24));
							  $qc =$this->db->query("select * from tbl_project_strategy where fk_project_id='".$project["pk_businessproject_id"]."' AND strategy_status='1' ORDER BY target_date DESC ");
							  $rc = $qc->result_array();
							  
							  $target_date_count = sizeof($rc);
							  
							  if ($target_date_count>0 && $project['target_date_recent']!=$rc[0]['target_date']) {
								  // WHEN more than one strategies AND current project record is not the latest
								  continue;
							  }
							  
							  if($mydiffrence>0) { // expired
								  $expired_projects++;
								  if ($project['priority']=='1') //echo "zaaid";
									$s_expired .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_expired .= $pc."(".$d."),<br/>";
							  }
							  
							  elseif($mydiffrence<0 && $target_date_count == 1 ) { // original_date
								  $original_date_projects++;
								  if ($project['priority']=='1') $s_original_date .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_original_date .= $pc."(".$d."),<br/>";
							  }
							  elseif($mydiffrence<0 && $target_date_count == 2 ) { // extension 1
								  $extension_projects++; // renamed to extension 1
								  if ($project['priority']=='1') $s_extension .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_extension .= $pc."(".$d."),<br/>";
							  }
							  elseif($mydiffrence<0 && $target_date_count == 3 ) { // extension 2
								  $extension_1_projects++; // renamed to extension 2
								  if ($project['priority']=='1') $s_extension_1 .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_extension_1 .= $pc."(".$d."),<br/>";
							  }
							  elseif($mydiffrence<0 && $target_date_count >= 4 ) { // final extension
								  $final_extension_projects++;
								  if ($project['priority']=='1') $s_final_extension .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_final_extension .= $pc."(".$d."),<br/>";
							  }
							
					} 
				
				if ($project_status == "Extension 2") {
					echo "{y: ".$extension_1_projects.", myData: '$s_extension_1'}";
				}
				if ($project_status == "Final Extension") {
					echo "{y: ".$final_extension_projects.", myData: '$s_final_extension'}";
				}
				if ($project_status == "Extension 1") {
					echo "{y: ".$extension_projects.", myData: '$s_extension'}";
				}
				if ($project_status == "Expired") {
					echo "{y: ".$expired_projects.", myData: '$s_expired'}";
				}
				if ($project_status == "Original Date") {
					echo "{y: ".$original_date_projects.", myData: '$s_original_date'}";
				}
						
					if ($i<$comma_limit) echo ",";
				}
				echo "],";
				echo "color:'".$user_color[$k]."',";
				echo "showInLegend: true,";
				echo "},";
				$k++;
			}
		
		?> ]
    };
    
    $('#chart_ongoing_projects_target_date_view').highcharts(options);
	});
</script>	