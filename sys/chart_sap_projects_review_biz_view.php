<?php 

$active_projects_array = array('');
$inactive_projects_array = array('');
$ignored_projects_array = array('');

$user_color = array('#DC143C','#FFD700','#00CD66');
$project_statuses = array('Ignored','Inactive','Active');
$project_types = array('New Business','Recurring','Assay Addition','Technical Support','Base Protection','Others','Unknown');




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
			categories: ['New Business','Recurring','Assay Addition','Technical Support','Base Protection','Others','Unknown']
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
				$i = 0;
				foreach ($project_types AS $project_type) {
					$comma_limit 		= 	sizeof($project_types) - 1;
					
					$ignored_projects = 0;
					$active_projects = 0;
					$inactive_projects = 0;
					
					$pt = $project_type;
					if ($project_type == "Unknown") $pt = "";
					
					$queryy = "select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_business_types.businesstype_name
					from business_data
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
					where `project_type`='".$pt ."' AND business_data.`status`=0 ";
					
					if ($territory!=0) {
						$queryy .= " AND `Territory` IN(".$territory.") ";
					}
					if ($sap!=0) {
						$queryy .= " AND `Sales Person`='".$sap."' ";
					}
					$queryy .= " ORDER BY tbl_clients.client_name ";
					$pq	=	$this->db->query($queryy);
					$pr =	$pq->result_array();
					
					$s_ignored = ""; // string ignored projects
					$s_inactive = ""; // string inactive projects
					$s_active = ""; // string active projects
					
					foreach ($pr as $project) {
						
						$ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$project["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
						  $pc = $project['client_name'] . "-" . $project['businesstype_name']."-";
						  if($ty->num_rows()>0) {
							  
							  $rt=$ty->result_array();
							  $now 		 = time(); 
							  $your_date = strtotime($rt[0]["date"]);
							  $datediff  = $now - $your_date;
							  $mydiffrence = floor($datediff/(60*60*24));
							  
							  
							  if($mydiffrence>=49) {
								  $ignored_projects++;
								  $d = date('d-M-Y',strtotime($rt[0]['date']));
								  if ($project['priority']=='1') //echo "zaaid";
									$s_ignored .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_ignored .= $pc."(".$d."),<br/>";
								  array_push($ignored_projects_array,$project['pk_businessproject_id']);
							  }
							  
							  elseif($mydiffrence<49 && $mydiffrence>=22 ) {
								  $inactive_projects++;
								  $d = date('d-M-Y',strtotime($rt[0]['date']));
								  if ($project['priority']=='1') $s_inactive .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_inactive .= $pc."(".$d."),<br/>";
								  array_push($inactive_projects_array,$project['pk_businessproject_id']);
							  }
							  else {
								  $active_projects++;
								  $d = date('d-M-Y',strtotime($rt[0]['date']));
								  if ($project['priority']=='1') $s_active .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_active .= $pc."(".$d."),<br/>";
								  array_push($active_projects_array,$project['pk_businessproject_id']);
							  } 
							  
						  }
						  else {
							  
							  $ignored_projects++;
							  $d = "No Visits";
								  if ($project['priority']=='1') $s_ignored .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_ignored .= $pc."(".$d."),<br/>";
							  array_push($ignored_projects_array,$project['pk_businessproject_id']);
							  
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
    
    $('#chart_sap_projects_review_biz_view').highcharts(options);
	});
	
</script>	
