<?php 
$user_color = array('#00CD66','#FFD700','#DC143C','#000000','#cf3000');
$project_statuses = array('Active','Inactive','Ignored','Never Visited');
$project_types = array('Active','Inactive','Ignored','Never Visited');
?>

<script>
$(document).ready(function() {
	var options = {
        chart: {
            type: 'column',
			marginBottom: 800,
			backgroundColor: null
        },

        title: {
            text: ''
        },

        xAxis: {
			categories: ['Active','Inactive','Ignored','Never Visited']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Customers',
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
            x: 30,
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
				$i = 0;
				foreach ($project_types AS $project_type) {
					$comma_limit 		= 	sizeof($project_types) - 1;
					$active_projects = 0;
					$never_visited_projects = 0;
					$inactive_projects = 0;
					$ignored_projects = 0;
					$neglected_projects = 0;
					
					$pt = $project_type;
					if ($project_type == "Unknown") $pt = "";
					
					$queryy = "select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_business_types.businesstype_name,user.first_name
					from business_data
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
					LEFT JOIN user ON business_data.`Sales Person` = user.id
					where business_data.`status`=0 ";
				
					if ($territory!=0) {
						$queryy .= " AND business_data.Customer IN (SELECT pk_client_id FROM tbl_clients WHERE fk_office_id='".$territory."')";
					}
					if ($sap!=0) {
						$queryy .= " AND `Sales Person`='".$sap."' ";
					}
					$queryy .= " ORDER BY tbl_clients.client_name ";
					$pq	=	$this->db->query($queryy);
					$pr =	$pq->result_array();
					
					$s_active = ""; // string ignored projects
					$s_never_visited = ""; // string inactive projects
					$s_inactive = ""; // string active projects
					$s_ignored = ""; // string active projects
					$s_neglected = ""; // string active projects
					
					foreach ($pr as $project) {
						
						$rvqq = "SELECT max(tbl_dvr.date) AS `recent_visit_date`,user.first_name FROM `tbl_dvr`
						LEFT JOIN user ON tbl_dvr.fk_engineer_id = user.id
							WHERE fk_business_id='".$project["pk_businessproject_id"]."' "; 
						if ($sap!=0) {
							$rvqq .=  "AND fk_engineer_id = '".$sap."'";
						}
							$rvq = $this->db->query($rvqq);
							$rvr = $rvq->result_array();
						
						 $pc = $project['client_name'] . "- (" . $project['businesstype_name'].") ";
						 
						  if($rvr[0]["recent_visit_date"]!= NULL) { // IF at least one visit
							  
							  $now 		 = time(); 
							  $your_date = strtotime($rvr[0]["recent_visit_date"]);
							  $datediff  = $now - $your_date;
							  $mydiffrence = floor($datediff/(60*60*24));
							  
							  $pc .= " (". date('d M Y',strtotime($rvr[0]["recent_visit_date"])) . ")" ;
							
							  if($project_status == "Ignored" && $project_type == "Ignored" && $mydiffrence>=49 ) { //ignored_projects
								  $ignored_projects++;
								  $s_ignored .= $pc.",<br/>";
							  }
							  elseif($project_status == "Inactive" && $project_type == "Inactive" && $mydiffrence<=48 && $mydiffrence>=22 ) { //inactive_projects
								  $inactive_projects++;
								  $s_inactive .= $pc.",<br/>";
							  }
							  else { //active_projects
							  if ($project_status == "Active" && $project_type == "Active" && $mydiffrence<=21 ) {
								  $active_projects++;
								  $s_active .= $pc.",<br/>";
							  }
							  } 
							  
						  }
						  else { //if no project
							  if ($project_status == "Never Visited" && $project_type == "Never Visited") {
								$never_visited_projects++;
								$s_never_visited .= $pc.",<br/>";
							  }
						  }
					} 
				
				if ($project_status == "Ignored") {
					echo "{y: ".$ignored_projects.", myData: '$s_ignored'}";
				}
				if ($project_status == "Inactive") {
					echo "{y: ".$inactive_projects.", myData: '$s_inactive'}";
				}
				if ($project_status == "Active") {
					echo "{y: ".$active_projects.", myData: '$s_active'}";
				}
				if ($project_status == "Neglected") {
					echo "{y: ".$neglected_projects.", myData: '$s_neglected'}";
				}
				if ($project_status == "Never Visited") {
					echo "{y: ".$never_visited_projects.", myData: '$s_never_visited'}";
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
		
		?>
		 ]
    };
    
    $('#chart_sap_territory_visit_review_view').highcharts(options);
	});
	
</script>	