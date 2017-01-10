<?php 
$data['test'] = 1;
$test = 1;
$month = time();
$months = array('');
$monthss = array('');
$months_to_show = 12;
for ($i=0;$i<$months_to_show;$i++) {
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-1 months", $month); // might not to change this to -1 months or something
}
$months = array_reverse($months);
$monthss = array_reverse($monthss);

$products = array('');
$product_ids = array('');
$chart_type = array('Complaints','Products');

$q = $this->db->query("SELECT DISTINCT status FROM tbl_complaints WHERE complaint_nature='complaint' ");
$complaint_results = $q->result_array();
$n = 0;
foreach ($complaint_results AS $p)	{
		$pm_status[$n]=$p['status'];
		$n++;
	}
	

$product_color = array('#006A4E','#F36A5A','#8E44AD','#E43A45','#ffce00','#5A6A62','#C6D5CD','#FDF200','#69D2E7','#F38630','#588C73','#5E412F','#DB3340','#E8B71A','#F7EAC8','#1FDA9A','#28ABE3','#E94C6F','#542733','#5A6A62','#C6D5CD','#FDF200','#69D2E7','#F38630','#588C73','#5E412F');
//print_r($pm_status);
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
			foreach ($pm_status AS $status) {
				
				echo "{ name: '".$status."',";
				echo "data: [";
				for ($i=0;$i<$months_to_show;$i++) { // Loops through months
					$comma_limit 		= 	$months_to_show - 1;
					
					$first_of_month 	= 	$monthss[$i].'-01';
					$number = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($monthss[$i])), date('Y', strtotime($monthss[$i])));
					$last_of_month		= 	$monthss[$i].'-'.$number;
					
					// Begin code to count complaints
					
					$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE assign_to = $fk_employee_id AND `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status = '".$status."' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ORDER BY `date` ASC");
						$cresult = $cquery->result_array();
						
						$string = "";
						
						foreach ($cresult AS $pm) {
							$solution_date = date('Y-m-d H:i:s');
							if ($status == "Completed")
								$solution_date = date('Y-m-d H:i:s',strtotime($pm["solution_date"]));
							$CI =& get_instance();
							$time_taken = $CI->nicetime_two_parameters($pm["date"],$solution_date);
							$string .= "<br/>".$pm['ts_number']." - ".$pm['product_name']." - ".$pm['client_name'];
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
    
    $('#chart_employee_monthly_ts').highcharts(options);
	});
</script>	
<script>
		 
		 $(document).ready(function() { 
			var table1 = $('#table_2').dataTable({
			  'iDisplayLength': 1000,
			  'aaSorting': []
			 // ,'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								null
								
						]

		});
});

</script>
<div class="col-md-12" id="dts">

<div class="portlet solid bordered light bg-inverse">
                <div class="portlet-title">
                  <div class="caption font-red">
								<i class="icon-globe font-red"></i>
								<span class="caption-subject bold uppercase"> Service Calls List </span>
							</div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
				
            <div class="portlet-body">
					<?php  if( $this->session->flashdata('note') == 'Service Calls List')
						echo '<div class="alert alert-success">Complaint comments updated successfully!</div>';
			?>
			<div class="row">
                    <div class="col-md-12"> 
					<form method="post" action="<?php echo base_url();?>sys/insert_report_comments" class="form-horizontal"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
						<table class="table table-hover " id="table_2">
							<thead class="bg-red">
								<tr >
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
								<tr >
									<th>Equipment</th>
									<th>Time Elapsed</th>
									<th>City</th>
									<th>Customer</th>
									<th>Serial</th>
									<th>Problem Summary</th>
									<th>Status</th>
									<th>Comments</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
<?php 
	$complaint_nature = "complaint";
									  $dbres = $this->db->query("SELECT tbl_report_comments.report_comments,tbl_complaints.*, 
									  COALESCE(tbl_offices.office_name) AS office_name,
									  COALESCE(tbl_cities.city_name) AS city_name,
									  COALESCE(tbl_clients.client_name) AS client_name,
									  COALESCE(tbl_area.area) AS area,
									  COALESCE(user.first_name) AS first_name,
									  COALESCE(u.first_name) AS created_by_name,
									  COALESCE(tbl_instruments.serial_no) AS serial_no,
									  COALESCE(tbl_products.product_name) AS product_name 
									  
									  FROM tbl_complaints 
									  LEFT JOIN tbl_report_comments ON (tbl_complaints.pk_complaint_id = tbl_report_comments.fk_project_id AND tbl_report_comments.month = '$end_date' AND tbl_report_comments.ts='1')
									  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
									  LEFT JOIN user ON tbl_complaints.assign_to = user.id
									  LEFT JOIN user u ON tbl_complaints.created_by = u.id
									  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
									  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
									  LEFT JOIN tbl_offices ON tbl_complaints.fk_office_id = tbl_offices.pk_office_id
									  
									  WHERE tbl_complaints.complaint_nature='complaint' AND CAST(tbl_complaints.`date` AS DATE) BETWEEN '$start_date' AND '$end_date' AND assign_to = '$fk_employee_id'
									  
									  order by `pk_complaint_id` DESC");
           							  $dbresResult=$dbres->result_array();
									  $ts_missing_comments = 0;
									  if (sizeof($dbresResult) == "0") {
										  
									  } else { $j = 0;
										  foreach ($dbresResult as $complaint_list) {
											 $show_time_taken = FALSE;
											if( $complaint_list['status']=='Closed' || $complaint_list['status']=='Completed') $show_time_taken = TRUE;
											  // Calculations for PM
											$date1 = $complaint_list['date'];
											$date2 = date('Y-m-d');
											$diff = abs(strtotime($date2) - strtotime($date1));
											  // Time Taken
											$time_taken = "N/A";
											$sprf_time = "N/A";
											if ($complaint_nature == 'complaint')
												$solution_date = date('Y-m-d',strtotime($complaint_list["solution_date"])).' '.date('H:i:s',strtotime($complaint_list["solution_time"]));
											else $solution_date = date('Y-m-d H:i:s',strtotime($complaint_list["solution_date"]));
											if($show_time_taken) $time_taken = nicetime_two_parameters($complaint_list["date"],$solution_date);
											
											// Closed Since or Time Elapsed
											$time_elapsed = "Closed ";
											if ($complaint_nature == 'PM') $time_elapsed = "Completed ";
											if($complaint_list["status"]=='Closed' || $complaint_list["status"]=='Completed') {
												$time_elapsed .=  ' since'; 
												$time_elapsed .=  nicetime($solution_date); 
											}
											else $time_elapsed =  nicetime($complaint_list["date"]);
											$rtzp = "";
											if ($complaint_nature == "PM")	{
												 $tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$complaint_list["fk_instrument_id"]."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
													$rtzp	= 	$tyz->result_array();
											}
											$days_since_pm = "N/A";
											if (!empty($rtzp)){
												$last_pm_date	=	strtotime($rtzp[0]['finish_time']);
												$current_date	=	time();
												$difference		=	$current_date - $last_pm_date;
												$interval		=	floor($difference/(60*60*24));
												$days_since_pm	= 	$interval . " day(s)";
											}
											if (trim($complaint_list['report_comments']) == "") $ts_missing_comments++;
											$this->load->model("complaint_model");
											$obj	=	new Complaint_model(); // for status
											?>
											<tr class=" 
												<?php if	( ($complaint_list['urgent_priority']==1 && $complaint_nature=='complaint') || 
														($diff>86400*3 && $complaint_list['status']!='Completed' && $complaint_nature=='PM') ) echo "danger ";
												?>
											  ">
                                                
												<td><?php echo $complaint_list["product_name"]; ?></td>
												<td><?php echo ($show_time_taken) ? $time_taken : $time_elapsed; ?></td>
												<td><?php echo $complaint_list["city_name"]; ?></td>
												<td><?php echo $complaint_list["client_name"];?></td>
												<td><?php echo $complaint_list["serial_no"];?></td>
												<td><?php echo ($complaint_nature == 'complaint') ? $complaint_list["problem_summary"] : pm_frequency($rtzp);?></td>
												<td><?php $obj->current_status($complaint_list['status']);?></td>
												<input type="hidden" class="form-control"  name="fk_project_id[<?php echo $j; ?>]" value="<?php echo $complaint_list["pk_complaint_id"]; ?>" >
												<input type="hidden" class="form-control"  name="month[<?php echo $j; ?>]" value="<?php echo $end_date; ?>" >
												<td class="reportcomments">
													<textarea rows="3" id="report_comments_<?php echo $j; ?>" class="form-control report_comments col-md-6" name="report_comments[<?php echo $j; ?>]"><?php echo $complaint_list['report_comments']; ?></textarea>
												</td>
												<td>
												<div class="btn-group-vertical btn-group-solid">
												<a class="btn btn-sm default blue-stripe" 
													  href="<?php  echo base_url().'sys/technical_service_pvr/'.$complaint_list["pk_complaint_id"]; ?>">
														TSR
														<i class="fa fa-eye"></i>
													  </a>
													  <?php if ($this->session->userdata('userrole')=="Admin") { ?>
													  <a class="btn btn-sm default grey-gallery-stripe" 
													  href="<?php  echo base_url().'sys/equipment_audit?equipment='.$complaint_list["fk_instrument_id"]; ?>">
														Audit
														<i class="fa fa-eye"></i>
													  </a>
													  <?php } ?>
										  </div>
										  </td>
												</tr>
											
									  <?php $j++;  }}
?>
						</tbody>
						</table>
                        
						
                      </div>
					  <?php if(sizeof($dbresResult)>0) { ?>
						<div class="col-md-offset-5 col-md-7">
							<input type="hidden" name = "ts" value = "1" />
							<input type="hidden" name = "div" value = "dts" />
							<input type="hidden" name = "portlet" value = "Service Calls List" />
							<input type="hidden" name = "redirect_url" value = "<?php echo current_url().'?'.$_SERVER['QUERY_STRING']; ?>" />
							<button type="submit" class="btn blue">Save</button>
						</div>
						<?php } ?>
						</form>
                    </div>
					
				</div>
				</div>	
</div>
 <?php 
 $query="insert INTO `tbl_report_errors_temp` SET 	
				  `fk_user_id`						='".$fk_employee_id."',
				  `month`							='".$end_date."',
				  `ts_missing_comments`				='".$ts_missing_comments."'
				  ON DUPLICATE KEY UPDATE 
				  `ts_missing_comments`				='".$ts_missing_comments."'";
$this->db->query($query);
?>