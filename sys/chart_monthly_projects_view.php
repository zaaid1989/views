<?php 
$errors = "";
$projects_missing_comments = 0;
$projects_without_strategy = 0;
$month = time();
$months = array('');
$monthss = array('');
$months_to_show = 6;
for ($i=0;$i<$months_to_show;$i++) {
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-1 months", $month); // might have to change this to -1 months or something
}
$months = array_reverse($months); // in application format
$monthss = array_reverse($monthss); // in sql format

$user_color = array('#00CD66','#FFD700','#DC143C','#000000','#cf3000');
$project_statuses = array('Active','Inactive','Ignored','Never Visited');
$project_types = array('Active','Inactive','Ignored','Never Visited');
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
				for ($i=0;$i<$months_to_show;$i++) { //foreach ($project_types AS $project_type) {
					$comma_limit 		= 	$months_to_show - 1;
					$number = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($monthss[$i])), date('Y', strtotime($monthss[$i]))); // number of days in this month
					$first_of_month 	= 	$monthss[$i].'-01';
					$last_of_month		= 	$monthss[$i].'-'.$number;
					
					//$comma_limit 		= 	sizeof($project_types) - 1;
					$active_projects = 0;
					$never_visited_projects = 0;
					$inactive_projects = 0;
					$ignored_projects = 0;
					$neglected_projects = 0;
					
					//$pt = $project_type;
					//if ($project_type == "Unknown") $pt = "";
					
					$queryy = "select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_business_types.businesstype_name,user.first_name
					from business_data
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
					LEFT JOIN user ON business_data.`Sales Person` = user.id
					WHERE business_data.`status`=0 AND CAST(business_data.`date` AS DATE) <= '$last_of_month' AND (`Sales Person`='$fk_employee_id' OR pk_businessproject_id IN (SELECT DISTINCT fk_business_id FROM tbl_dvr WHERE fk_engineer_id = '$fk_employee_id' AND CAST(tbl_dvr.`date` AS DATE) BETWEEN '$first_of_month' AND '$last_of_month')) 
					ORDER BY tbl_clients.client_name 
					";
				
					$pq	=	$this->db->query($queryy);
					$pr =	$pq->result_array();
					
					$s_active = ""; // string ignored projects
					$s_never_visited = ""; // string inactive projects
					$s_inactive = ""; // string active projects
					$s_ignored = ""; // string active projects
					$s_neglected = ""; // string active projects
					
					foreach ($pr as $project) {
						
						$rvqq = "	SELECT max(tbl_dvr.date) AS `recent_visit_date`,user.first_name FROM `tbl_dvr`
									LEFT JOIN user ON tbl_dvr.fk_engineer_id = user.id
									WHERE fk_business_id='".$project["pk_businessproject_id"]."' AND fk_engineer_id = '".$fk_employee_id."' AND CAST(tbl_dvr.`date` AS DATE) <= '$last_of_month' ";
						
							$rvq = $this->db->query($rvqq);
							$rvr = $rvq->result_array();
						
						 $pc = $project['client_name'] . "- (" . $project['businesstype_name'].") ";
						 
						  if($rvr[0]["recent_visit_date"]!= NULL) { // IF at least one visit
							  $now = strtotime($last_of_month);
							  if($monthss[$i] == date('Y-m'))
								$now 		 = time(); 
							  $your_date = strtotime($rvr[0]["recent_visit_date"]);
							  $datediff  = $now - $your_date;
							  $mydiffrence = floor($datediff/(60*60*24));
							  
							  $pc .= " (". date('d M Y',strtotime($rvr[0]["recent_visit_date"])) . ")" ;
							
							  if($project_status == "Ignored" && $mydiffrence>=49 ) { //ignored_projects
								  $ignored_projects++;
								  $s_ignored .= $pc.",<br/>";
							  }
							  elseif($project_status == "Inactive"  && $mydiffrence<=48 && $mydiffrence>=22 ) { //inactive_projects
								  $inactive_projects++;
								  $s_inactive .= $pc.",<br/>";
							  }
							  else { //active_projects
							  if ($project_status == "Active"  && $mydiffrence<=21 ) {
								  $active_projects++;
								  $s_active .= $pc.",<br/>";
							  }
							  } 
							  
						  }
						  else { //if no project
							  if ($project_status == "Never Visited") {
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
    
    $('#chart_monthly_projects').highcharts(options);
	});
	
</script>	
<script>
$(document).ready(function() { 
			var table = $('.projectTable').dataTable({
			  'iDisplayLength': 2000
			});;
});

</script>
<?php
$portlet_title = array('Projects Target Date UPTO '. date('F Y',strtotime($start_date)),'Priority Projects','Assay Addition','Base Protection','Recurring','New Business','Others');
$portlet_color = array('red-intense','blue','purple-medium','green-meadow','grey-cascade','blue-hoki','yellow-casablanca');
$already_displayed_projects = array('0');
?>
<?php for($i=0;$i<7;$i++){
	
if ($i == 0) {
	$q = "
	SELECT 
								business_data.*, 
								tbl_report_comments.report_comments,
								COALESCE(tbl_cities.city_name) AS city_name,
								COALESCE(tbl_clients.client_name) AS client_name,
								COALESCE(tbl_area.area) AS area,
								COALESCE(user.first_name) AS first_name,
								COALESCE(s1.date) AS strategy_date,
								COALESCE(s1.target_date) AS target_date,
								COALESCE(s1.strategy) AS strategy,
								COALESCE(s1.tactics) AS tactics,
								COALESCE(s1.investment) AS investment,
								COALESCE(s1.sales_per_month) AS sales_per_month,
								MAX(tbl_dvr.date) AS dvr_date,
								COUNT(tbl_dvr.date) AS total_visits,
								COALESCE(tbl_business_types.businesstype_name) AS businesstype_name ,
								(SELECT max(tbl_dvr.date) FROM tbl_dvr WHERE tbl_dvr.fk_engineer_id = '$fk_employee_id' AND tbl_dvr.fk_business_id = business_data.pk_businessproject_id AND CAST(tbl_dvr.`date` AS DATE) <= '$end_date') AS recent_visit,
								(SELECT max(tbl_project_strategy.date) FROM tbl_project_strategy WHERE tbl_project_strategy.fk_project_id = business_data.pk_businessproject_id AND tbl_project_strategy.strategy_status != '4') AS last_strategy_date,
								(SELECT target_date FROM tbl_project_strategy WHERE tbl_project_strategy.fk_project_id = business_data.pk_businessproject_id AND tbl_project_strategy.strategy_status != '4' ORDER BY pk_project_strategy_id DESC LIMIT 0, 1) AS last_target_date,
								(SELECT COUNT(*) FROM tbl_project_strategy WHERE fk_project_id = business_data.pk_businessproject_id  GROUP BY fk_project_id) AS `Extensions`
								
								FROM business_data 
								
								LEFT JOIN tbl_cities ON business_data.City = tbl_cities.pk_city_id 
								LEFT JOIN tbl_area ON business_data.Area = tbl_area.pk_area_id 
								LEFT JOIN tbl_clients ON business_data.Customer = tbl_clients.pk_client_id 
								LEFT JOIN user ON business_data.`Sales Person` = user.id 
								LEFT JOIN tbl_business_types ON business_data.`Business Project`  = tbl_business_types.pk_businesstype_id
								LEFT JOIN tbl_dvr ON business_data.pk_businessproject_id = tbl_dvr.fk_business_id
								LEFT JOIN (SELECT * from tbl_project_strategy WHERE strategy_status = 1) s1 ON business_data.pk_businessproject_id = s1.fk_project_id
								LEFT JOIN (SELECT * from tbl_project_strategy WHERE strategy_status = 1) s2 ON business_data.pk_businessproject_id = s2.fk_project_id AND s1.pk_project_strategy_id < s2.pk_project_strategy_id
								LEFT JOIN tbl_report_comments ON (business_data.pk_businessproject_id = tbl_report_comments.fk_project_id AND tbl_report_comments.month = '$end_date' AND tbl_report_comments.ts='0')
								
								WHERE business_data.status='0' AND s2.pk_project_strategy_id IS NULL  AND business_data.`Sales Person` = '$fk_employee_id' AND (CAST(s1.target_date AS DATE) <= '$end_date' OR s1.target_date IS NULL)
								GROUP BY pk_businessproject_id
								ORDER BY s1.target_date
								"; ///changing CAST(ps.target_date AS DATE) BETWEEN '$start_date' AND '$end_date'  
}
if ($i==1) {
		$q = "SELECT tbl_report_comments.report_comments,pk_businessproject_id,project_type,priority,tbl_business_types.businesstype_name, tbl_clients.client_name, business_data.`Project Description`,
	(SELECT max(tbl_dvr.date) FROM tbl_dvr WHERE tbl_dvr.fk_engineer_id = '$fk_employee_id' AND tbl_dvr.fk_business_id = business_data.pk_businessproject_id AND CAST(tbl_dvr.`date` AS DATE) <= '$end_date') AS recent_visit,
	(SELECT target_date FROM tbl_project_strategy WHERE tbl_project_strategy.fk_project_id = business_data.pk_businessproject_id AND tbl_project_strategy.strategy_status != '4' ORDER BY pk_project_strategy_id DESC LIMIT 0, 1) AS last_target_date,
(SELECT COUNT(*) FROM tbl_project_strategy WHERE fk_project_id = business_data.pk_businessproject_id  GROUP BY fk_project_id) AS `Extensions`
FROM business_data
LEFT JOIN tbl_business_types ON business_data.`Business Project` = tbl_business_types.pk_businesstype_id
LEFT JOIN tbl_clients ON business_data.Customer = tbl_clients.pk_client_id
LEFT JOIN tbl_report_comments ON (business_data.pk_businessproject_id = tbl_report_comments.fk_project_id AND tbl_report_comments.month = '$end_date' AND tbl_report_comments.ts='0')
WHERE priority = '1' AND business_data.`Sales Person` = '$fk_employee_id' AND business_data.status = '0' AND pk_businessproject_id NOT IN(".implode(',',$already_displayed_projects).") 
ORDER BY `Extensions` DESC";
	}
if ($i>1) {
	$q = "SELECT tbl_report_comments.report_comments,pk_businessproject_id,project_type,priority,tbl_business_types.businesstype_name, tbl_clients.client_name, business_data.`Project Description`,
	(SELECT max(tbl_dvr.date) FROM tbl_dvr WHERE tbl_dvr.fk_engineer_id = '$fk_employee_id' AND tbl_dvr.fk_business_id = business_data.pk_businessproject_id AND CAST(tbl_dvr.`date` AS DATE) <= '$end_date') AS recent_visit,
	(SELECT target_date FROM tbl_project_strategy WHERE tbl_project_strategy.fk_project_id = business_data.pk_businessproject_id AND tbl_project_strategy.strategy_status != '4' ORDER BY pk_project_strategy_id DESC LIMIT 0, 1) AS last_target_date,
(SELECT COUNT(*) FROM tbl_project_strategy WHERE fk_project_id = business_data.pk_businessproject_id  GROUP BY fk_project_id) AS `Extensions`
FROM business_data
LEFT JOIN tbl_business_types ON business_data.`Business Project` = tbl_business_types.pk_businesstype_id
LEFT JOIN tbl_clients ON business_data.Customer = tbl_clients.pk_client_id
LEFT JOIN tbl_report_comments ON (business_data.pk_businessproject_id = tbl_report_comments.fk_project_id AND tbl_report_comments.month = '$end_date' AND tbl_report_comments.ts='0')
WHERE project_type = '".$portlet_title[$i]."' AND business_data.`Sales Person` = '$fk_employee_id' AND business_data.status = '0' AND pk_businessproject_id NOT IN(".implode(',',$already_displayed_projects).")
ORDER BY `Extensions` DESC";
}
if ($i==0) $this->db->query("SET SQL_BIG_SELECTS=1");
$pq = $this->db->query($q);
$pr = $pq->result_array();
//echo '<a href="#'.$i.'"></a>';
?>

<div class="col-md-12" id="<?php echo 'd'.$i; ?>">
<div class="portlet solid bordered light bg-inverse" >
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
			
			<?php  	if ($i==0)
						echo '<div class="alert alert-info"><strong>Strategy Revised Status No:</strong> Projects Target date is same is Month of Report and No Revised Strategy has been submitted so far.<br/><strong>Strategy Revised Status Yes:</strong> Projects last target date was same as Month of Report and Revised Strategy has been submitted after last day of the month and its not disapproved.</div>';
					if( $this->session->flashdata('note') == $portlet_title[$i])
						echo '<div class="alert alert-success">Project comments updated successfully.</div>';
			?>
			<div class="row">
                    <div class="col-md-12"> 
					<form method="post" action="<?php echo base_url();?>sys/insert_report_comments" class="form-horizontal"> 
					<?php //echo $q; ?>
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
						<table class="table table-hover table-bordered projectTable" id="table_<?php echo $i; ?>">
							<thead class="bg-<?php echo $portlet_color[$i]; ?>">
								<tr >
									<th>Status</th>
									<th>Extent</th>
									<th>Type</th>
									<th>Category</th>
									<th>Customer</th>
									<th>Project</th>
									<th>Target Date</th>
									<?php if($i==0) echo '<th>Strategy Revised</th>'; ?>
									<th class="col-md-6">Comments</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if (sizeof($pr) == "0") {} 
							else {        $j = 0;
										  foreach ($pr as $project) {
											  //if (in_array($project['pk_businessproject_id'],$already_displayed_projects)) continue 2;
											  $now 		 = strtotime($end_date); 
											  $your_date = strtotime($end_date);
											  $status = "Never Visited";
											  //$now 		 = time(); 
											  //$your_date = time();
											  if ($project["recent_visit"]!="")
												$your_date = strtotime($project["recent_visit"]);
											  $datediff  = $now - $your_date;
											  $mydiffrence = floor($datediff/(60*60*24));
											  if ($project["recent_visit"]!="") {
												  if ($mydiffrence>=49) $status = "Ignored";
												  if ($mydiffrence<=48 && $mydiffrence>=22) $status = "Inactive";
												  if ($mydiffrence<=21 ) $status = "Active";
											  }
											if ($i == 0 || $i==1) {
												$temp = "'".$project['pk_businessproject_id']."'";
												array_push($already_displayed_projects,$temp);
											}
											
											if (trim($project['report_comments']) == "") $projects_missing_comments++;
											  
											?>
											
											<tr style="background-color: white;" class="<?php if($project['priority']==1) echo "danger even"; ?>">
												<td><?php echo $status; ?></td>
												<td><?php echo $project["Extensions"]-1; ?></td>
												<td><?php echo $project["project_type"];?></td>
												<td><?php echo $project["businesstype_name"]; ?></td>
												<td><?php echo $project["client_name"]; ?></td>
												<td><?php echo $project["Project Description"]; ?></td>
												<?php 
												if ($project["last_target_date"]!='') echo '<td>'.date('d-M-Y',strtotime($project["last_target_date"])).'</td>';else echo '<td></td>';
												if($i==0) { 
														
														if(strtotime($project["last_target_date"])>strtotime($end_date)) //last_strategy_date
															echo '<td align="center"><span class="label bg-green">Yes</span></td>';
														else {
																echo '<td align="center"><span class="label bg-red">No</span></td>';
																$projects_without_strategy++;
															}
														} ?>
												<input type="hidden" class="form-control"  name="fk_project_id[<?php echo $j; ?>]" value="<?php echo $project['pk_businessproject_id']; ?>" >
												<input type="hidden" class="form-control"  name="month[<?php echo $j; ?>]" value="<?php echo $end_date; ?>" >
												<td class="reportcomments">
													<textarea rows="3" id="report_comments_<?php echo $j; ?>" class="form-control report_comments col-md-6" name="report_comments[<?php echo $j; ?>]"><?php echo $project['report_comments']; ?></textarea>
												</td>
												<td>
													<a class="btn btn-sm default blue-hoki-stripe" target="_blank"
														href="<?php echo base_url();?>sys/details_business_project/<?php echo $project["pk_businessproject_id"];?>">
															Details
														  </a>
													<?php if ($this->session->userdata('userrole')!= 'Admin' && $this->session->userdata('userrole')!= 'secratery') { ?>
														<a class="btn btn-sm default green-stripe" target="_blank"
														href="<?php echo base_url();?>sys/add_strategy/<?php echo $project["pk_businessproject_id"];?>">
															Strategy 
														  </a>
													
													<?php } ?>
												</td>
												</tr>
							<?php $j++; 
							}}
?>
						</tbody>
						</table>
						</div>
						<?php if(sizeof($pr)>0) { ?>
						<div class="col-md-offset-5 col-md-7">
							<input type="hidden" name = "div" value = "<?php echo 'd'.$i; ?>" />
							<input type="hidden" name = "portlet" value = "<?php echo $portlet_title[$i]; ?>" />
							<input type="hidden" name = "redirect_url" value = "<?php echo current_url().'?'.$_SERVER['QUERY_STRING']; ?>" />
							<button type="submit" class="btn blue">Save</button>
						</div>
						<?php } ?>
						</form>
                    </div>
						
				</div>
				</div>	
</div>
<?php }
//array_push($errors,"Projects");
 ?>
 <?php 
 $query="insert INTO `tbl_report_errors_temp` SET 	
				  `fk_user_id`						='".$fk_employee_id."',
				  `month`							='".$end_date."',
				  `projects_missing_comments`		='".$projects_missing_comments."',
				  `projects_without_strategy`		='".$projects_without_strategy."'
				  ON DUPLICATE KEY UPDATE 
				  `projects_missing_comments`		='".$projects_missing_comments."',
				  `projects_without_strategy`		='".$projects_without_strategy."'";
$this->db->query($query);
?>