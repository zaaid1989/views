<?php 

$user_color = array('#00CD66','#0099CC','#FFD700','#DC143C','#000000','#cf3000');
$project_statuses = array('Active','Never Visited Projects','Inactive','Ignored','Never Visited Clients'); 
$project_types = array('Active','Never Visited Projects','Inactive','Ignored','Never Visited Clients'); 

//// Finding projects with no visits / neglected projects. It wont be needed in loop
$queryy = "select COUNT(pk_businessproject_id) AS `total_projects`, business_data.*,tbl_clients.client_name, tbl_cities.city_name, tbl_business_types.businesstype_name
					from business_data
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
					where business_data.`status`=0 AND Customer NOT IN (SELECT DISTINCT fk_customer_id from tbl_dvr WHERE fk_business_id>0)";
if ($territory!=0) $queryy .= " AND `Territory` IN(".$territory.") ";
if ($sap!=0) $queryy .= " AND `Sales Person`='".$sap."' ";
$queryy .= " GROUP BY Customer ORDER BY tbl_clients.client_name";
$pq	=	$this->db->query($queryy);
$pr =	$pq->result_array();
$never_visited_projects_count = sizeof($pr);
$s_never_visited_s = "";
foreach ($pr AS $project) {
	$pc = $project['client_name'] . "- (" . $project['total_projects'].")";
	$s_never_visited_s .= $pc.",<br/>";
}

//// Finding clients with no projects. It wont be needed in loop, // if you want to show all clients including ones not assigned to saps, use left join
$queryy = "SELECT tbl_clients.*, tbl_customer_sap_bridge.fk_user_id from tbl_clients
JOIN tbl_customer_sap_bridge ON tbl_clients.pk_client_id = tbl_customer_sap_bridge.fk_client_id
WHERE pk_client_id NOT IN (SELECT Customer FROM business_data WHERE business_data.status = 0) AND tbl_clients.delete_status = 0";

if ($territory!=0) $queryy .= " AND `fk_office_id` IN(".$territory.") ";
if ($sap!=0) $queryy .= " AND `fk_user_id`='".$sap."' ";
if ($sap == 0) { // using this query because for all saps the above query will have repeated customers when a customer is assigned to multiple saps. Furthermore if you want to show all the clients rather ones only assigned to saps, remove the last condition in query
	/*$queryy = "	SELECT tbl_clients.* from tbl_clients
				WHERE pk_client_id NOT IN (SELECT Customer FROM business_data WHERE business_data.status = 0) AND tbl_clients.delete_status = 0
				AND pk_client_id IN (SELECT fk_client_id from tbl_customer_sap_bridge)
	";*/
	$queryy .= " GROUP BY tbl_clients.pk_client_id";
}
$queryy .= " ORDER BY tbl_clients.client_name";

$pq	=	$this->db->query($queryy);
$pr =	$pq->result_array();
$never_visited_clients_count = sizeof($pr);
$s_never_visited_clients = "";
foreach ($pr AS $project) {
	$pc = $project['client_name'] . "- (0)";
	$s_never_visited_clients .= $pc.",<br/>";
}
?>

<script>
chart = null;
cloneToolTip = null;
$(document).ready(function() {
cloneToolTip = null;
cloneToolTip2 = null;
chart = new Highcharts.Chart({
        chart: {
			renderTo: 'chart_sap_territory_visit_review_projects_customers_view',
            type: 'column',
			marginBottom: 20,
			backgroundColor: null
        },

        title: {
            text: ''
        },

        xAxis: {
			categories: ['Active','Never Visited Projects','Inactive','Ignored','Never Visited Clients']
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
            x: -30,
            verticalAlign: 'top',
            y: 0,
            floating: false,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },

        tooltip: {
			 useHTML: true ,
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
            },
			series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() { 
                            if (cloneToolTip)
                            {                                chart.container.firstChild.removeChild(cloneToolTip);
                            }
                            if (cloneToolTip2)
                            {
                                cloneToolTip2.remove();
                            }
                            cloneToolTip = this.series.chart.tooltip.label.element.cloneNode(true);
                            chart.container.firstChild.appendChild(cloneToolTip);
                            
                            cloneToolTip2 = $('.highcharts-tooltip').clone(); 
                            $(chart.container).append(cloneToolTip2);
                        }
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
					
					$queryy = "select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_business_types.businesstype_name
					from business_data
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
					where business_data.`status`=0 ";
					
					$queryy = "SELECT tbl_clients.client_name, tbl_dvr.fk_customer_id, max(tbl_dvr.date) AS `recent_visit`,business_data.Territory, business_data.`Sales Person`,tbl_dvr.`fk_engineer_id`,business_data.`pk_businessproject_id` FROM `tbl_dvr`
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_dvr.fk_customer_id
					JOIN business_data ON business_data.pk_businessproject_id = tbl_dvr.fk_business_id
					WHERE tbl_dvr.fk_business_id>0
					"; // This query will only fetch unique clients in the visited table, it wont find any neglected projects having no entry in tbl_dvr. Also it won't consider if the project is deleted, it will check customer is active or ignored based on visit irrespective of project status
					if ($territory!=0) {
						$queryy .= " AND tbl_dvr.fk_customer_id IN (SELECT pk_client_id FROM tbl_clients WHERE fk_office_id IN(".$territory."))";
					}
					if ($sap!=0) {
						$queryy .= " AND tbl_dvr.fk_customer_id IN (SELECT fk_client_id FROM tbl_customer_sap_bridge WHERE fk_user_id='".$sap."')";
					}
					$queryy .= " GROUP BY tbl_dvr.fk_customer_id";
					$queryy .= " ORDER BY tbl_clients.client_name ";
					$pq	=	$this->db->query($queryy);
					$pr =	$pq->result_array();
					
					$s_active = ""; // string ignored projects
					$s_never_visited = ""; // string inactive projects
					$s_inactive = ""; // string active projects
					$s_ignored = ""; // string active projects
					$s_neglected = ""; // string active projects
					
					foreach ($pr as $project) {
						
						$rvr;
						if ($sap!=0) {
							$rvq = $this->db->query("SELECT max(tbl_dvr.date) AS `recent_visit_date` FROM `tbl_dvr`
							WHERE fk_business_id='".$project["pk_businessproject_id"]."' AND fk_engineer_id = '".$sap."'");
							$rvr = $rvq->result_array();
						}
						$ty=$this->db->query("select * from business_data WHERE status=0 AND Customer='".$project["fk_customer_id"]."' ");
						 $pc = $project['client_name'] . "- (" . $ty->num_rows().")";
						  if($ty->num_rows()>0) { // IF at least one project
							  
							  $rt=$ty->result_array();
							  $now 		 = time(); 
							  $your_date = strtotime($project["recent_visit"]);
							  $datediff  = $now - $your_date;
							  $mydiffrence = floor($datediff/(60*60*24));
							
							if($project_status == "Never Visited Projects" && $project_type == "Never Visited Projects" && $mydiffrence>120) { 
							// neglected_projects
								  $never_visited_projects_count++;
								  $s_never_visited_s .= $pc."*,<br/>";
							  }
							  
							  elseif($project_status == "Ignored" && $project_type == "Ignored" && $mydiffrence<=120 && $mydiffrence>=49 ) { 
							  //ignored_projects
								  $ignored_projects++;
								  $s_ignored .= $pc.",<br/>";
							  }
							  elseif($project_status == "Inactive" && $project_type == "Inactive" && $mydiffrence<=48 && $mydiffrence>=22 ) { //Inactive_projects
								  $inactive_projects++;
								  $s_inactive .= $pc.",<br/>";
							  }
							  elseif ($project_status == "Active" && $project_type == "Active" && $mydiffrence<=21) {
								  $active_projects++;
								  $s_active .= $pc.",<br/>";
							  }
							  
						  }
						
					} 
					
				if ($project_status == "Ignored") {
					echo "{y: ".$ignored_projects.", myData: '".$s_ignored."'}";
				}
				if ($project_status == "Inactive") {
					echo "{y: ".$inactive_projects.", myData: '".$s_inactive."'}";
				}
				if ($project_status == "Active") {
					echo "{y: ".$active_projects.", myData: '".$s_active."'}";
				}
				if ($project_status == "Never Visited Projects") {
					if ($project_type == "Never Visited Projects")
						echo "{y: ".$never_visited_projects_count.", myData: '".$s_never_visited_s."'}";
					else echo "{y: 0, myData: ''}";
				}
				if ($project_status == "Never Visited Clients" ) {
					if ($project_type == "Never Visited Clients")
						echo "{y: ".$never_visited_clients_count.", myData: '".addslashes($s_never_visited_clients)."'}";
					else echo "{y: 0, myData: ''}";
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
  });
});	
</script>	
