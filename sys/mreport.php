<?php $this->load->view('header');
//array_push($errors,"Main View");
//print_r($header3_item);
$user = 0;
$show_js_div = TRUE;
$data['test'] = 0;
$data['fk_employee_id'] = 0;
$view_project_statistics = FALSE;
$view_ts_statistics = FALSE;
$territory = 0;
if ($this->session->userdata('userrole') != 'Admin' && $this->session->userdata('userrole') != 'secratery') {
	$user = 1;
	$data['fk_employee_id'] = $this->session->userdata('userid');
	if ($this->session->userdata('userrole') == 'FSE' || $this->session->userdata('userrole') == 'Supervisor') $view_ts_statistics = TRUE;
	else $view_project_statistics = TRUE;
}
else {
	if (isset($_GET['user'])) $data['fk_employee_id'] = $_GET['user'];
}

$sd = date('Y-m-01');
$number = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($sd)), date('Y', strtotime($sd))); 
$ed = date('Y-m-').$number;
if (isset($_GET['month']) && $_GET['month']!= "") {
	$sd = $_GET['month'];
	$temp = strtotime($_GET['month']);
	$number = cal_days_in_month(CAL_GREGORIAN, date('m', $temp), date('Y', $temp)); 
	$ed = date('Y-m-'.$number,strtotime($_GET['month']));
}
$data['start_date'] = $sd;
$data['end_date'] = $ed;
$data['territory'] = $territory;
//$data['fk_employee_id'] = 27;
/****************************/
define ('SITE_ROOT', dirname(dirname(dirname(__FILE__))));
$file_name = date('m_Y_',strtotime($data['end_date'])).md5($data['fk_employee_id']).'.html';
$path = 'monthly_reports/'.$file_name;
$errors_in_report = TRUE;
/****************************/

function portlet_begin($title,$color,$height = 0) {
	
	if ($height == 0) {
		echo '
		<div class="portlet solid bordered light bg-inverse " >
							<!-- Portlet Title -->
							<div class="portlet-title">
								<div class="caption font-'.$color.'">
									<i class="icon-bar-chart font-'.$color.'"></i>
									<span class="caption-subject bold uppercase"> '.$title.'</span>
								</div>
								
								<div class="tools">
									<a href="" class="collapse" data-original-title="" title=""></a>
									<a href="" class="fullscreen"></a>
									<a href="" class="remove" data-original-title="" title=""></a>
								</div>
							</div>
				<div class="portlet-body" style="margin-left:3%; margin-right:3%; ">
			';
	}
	else {
		echo '
		<div class="portlet solid bordered light bg-inverse hClass" >
							<!-- Portlet Title -->
							<div class="portlet-title">
								<div class="caption font-'.$color.'">
									<i class="icon-bar-chart font-'.$color.'"></i>
									<span class="caption-subject bold uppercase"> '.$title.'</span>
								</div>
								
								<div class="tools">
									<a href="" class="collapse" data-original-title="" title=""></a>
									<a href="" class="fullscreen"></a>
									<a href="" class="remove" data-original-title="" title=""></a>
								</div>
							</div>
				<div class="portlet-body" style="margin-left:3%; margin-right:3%; ">
			';
	}
}
function portlet_end(){
	echo '</div>
						<!-- End Portlet Body -->
					</div>';
}
?>	

  
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Monthly Report <?php //echo $test; ?>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Monthly Report
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
       <!-- BEGIN PAGE CONTENT-->
	   
       <div class="row">
        <div class="col-md-12"> 
		
		<?php 
			if (file_exists($path) ) {
				$show_js_div = FALSE;
				echo '<div class="alert alert-info" id="report_status">This report has been submitted successfully</div>';
			}
			else {
				echo '<div class="" id="report_status"></div>';
				//echo '<div class="alert alert-danger"> Report Has not been submitted yet</div>';
				// above error alert will keep on showing when errors in report will be TRUE. When user will remove all errors and press save, page will refresh but this alert will keep showing as file will be saved at the end of this page refresh when there will be no errors.
				// So, when there are errors, this div should show those errors. When there are no errors and file does not exist, this div should show message that Congratulations !! all errors have been removed. Your report has been submitted for this month.
				// The message will be assigned dynamically at the end of page, so the if no errors, the dynamic message can be the same as the one in first condition of if file exists, in this way the saved html will not contain error alert.
			}
		?>
		
		<!-- Search Form -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Employee Report </span>
								<span class="caption-helper">Monthly Report of Individual</span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>sys/mreport">
								<?php if ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery'){ ?>	
                                <div class="col-md-4">
                            		<div class="form-group">
                            			
                                        <select name="user" id="user" class="form-control" required>
                                            <option value="">--Select employee--</option>
											<?php 
											$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status = '0' AND userrole NOT IN ('Admin','secratery') ORDER BY  `fk_office_id` ,  `userrole` ASC ");
											if ($this->session->userdata('userrole')=="Supervisor")
												$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status = '0' AND userrole='FSE' AND fk_office_id='".$this->session->userdata('territory')."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['id'];?>" <?php if(isset($_GET['user']) && $_GET['user']==$val['id']){
												if ($val['userrole'] == 'Salesman' || $val['sap_supervisor'] == '1' ) $view_project_statistics = TRUE;
												if ($val['userrole'] == 'FSE' || $val['userrole'] == 'Supervisor' ) $view_ts_statistics = TRUE;
												echo 'selected="selected"';}?>>
													<?php echo $val['first_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>
								<?php } ?>
								<div class="col-md-3">
                            		<div class="form-group">
                            			
                                        <select name="month" id="month" class="form-control" required>
											<?php 
											$month = time();
											$months_to_show = 12;
											for ($i=0;$i<$months_to_show;$i++) { 
												$current_month = date('Y-m-01', $month);
												//$current_month .= '-01';
											?>
												<option value="<?php echo $current_month;?>" <?php if(isset($_GET['month']) && $_GET['month']==$current_month){
												echo 'selected="selected"';}?>>
											<?php
												echo date('F Y', $month);
												$month = strtotime("-1 months", $month);
											}
                                           
                                            ?>
                                        </select>
                            		</div>
                          		</div>
								<!--
                          		<div class="col-md-2">
                            		<div class="form-group">
                            			
                                        <input type="text" name="start_mydate" class="form-control datepicker" id="start_mydate" value="<?php if(isset($_GET['start_mydate'])){ echo $_GET['start_mydate']; } else { echo '01-'.date('M-Y');}?>" required  />
										<span class="help-block">Start Date</span>
									</div>
                                </div>
                                <div class="col-md-2">
                            		<div class="form-group">
                            			
                                        <input type="text" name="end_mydate" class="form-control datepicker" id="end_mydate" value="<?php if(isset($_GET['end_mydate'])){ echo $_GET['end_mydate']; } else { echo date('d-M-Y');}?>" required />
										<span class="help-block">End Date</span>
									</div>
                                </div>
								-->
                                <div class="col-md-1">
                            		<div class="form-group">
                                        
                                            <input type="submit"  class="btn btn-default purple-seance" value="Search" >
                                    </div>
									
                                </div>
								<!--
								<div class="col-md-2">
								<div class="form-group">
								
									<a class="btn btn-default green-seagreen " onclick="javascript:window.print();">
										Print <i class="fa fa-print font-grey-cararra"></i>
										</a>
								
								<a class="btn btn-default green-seagreen " href="<?php echo base_url().'sys/report_comments'; ?>">
										Report Comments
										</a>
								
								</div>
								</div>
								-->
								<div class="col-md-4">
								Note: Press Search Button to refresh the report status. On no errors, report will be automatically be submitted and saved in your report comments thread.
								</div>
                          		</form>
                           </div>	
							
						</div>
					</div>
		</div>
	</div>
<?php
ob_start();
?>
<div class="row">
        <div class="col-md-12"> 
<h3 class="page-title" style="font-weight: 800;">
<?php
$repot_name = "";
$uq = $this->db->query("SELECT * FROM user WHERE id = '".$data['fk_employee_id']."' ");
$ur = $uq->result_array();
if (sizeof($ur)>0) {
	$report_name = "Monthly Report - ".$ur[0]['first_name']." - ".date('F Y',strtotime($data['end_date']));
	echo $report_name;
}
 ?>
                    </h3>		
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<?php if ($view_ts_statistics == TRUE || $view_project_statistics == TRUE) { ?>

	 
					<div class = "col-md-6">
					<?php portlet_begin('Average Working Hours Daily','grey-gallery'); ?>
								<div id="chart_working_hours" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					
					<div class = "col-md-6">
					<?php portlet_begin('Average Visits Per Day','grey-gallery'); ?>
								<div id="chart_average_visits_per_day" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
<?php if ($view_ts_statistics == TRUE) { ?>	
					<div class = "col-md-6">
					<?php portlet_begin('Average PM Times','grey-gallery'); ?>
								<div id="chart_pm_hours" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					
					<div class = "col-md-6">
					<?php portlet_begin('Chart Average TS Times','grey-gallery'); ?>
								<div id="chart_ts_hours" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					
					<div class = "col-md-6">
					<?php portlet_begin('PM Equipment Experience','grey-gallery'); ?>
								<div id="chart_pm_equipment_distribution" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					
					<div class = "col-md-6">
					<?php portlet_begin('Complaint Equipment Experience','grey-gallery'); ?>
								<div id="chart_complaint_equipment_distribution" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					
					<div class = "col-md-12">
					<?php portlet_begin('Chart Monthly PM','grey-gallery'); ?>
								<div id="chart_employee_monthly_pm" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					<?php $this->load->view('sys/chart_employee_monthly_pm_view',$data); ?>
					<div class = "col-md-12">
					<?php portlet_begin('Chart Monthly TS','grey-gallery'); ?>
								<div id="chart_employee_monthly_ts" style="width: 100% !important; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					<?php $this->load->view('sys/chart_employee_monthly_ts_view',$data); ?>
					
<?php } if ($view_project_statistics == TRUE) { ?>
					<div class = "col-md-12">
					<?php portlet_begin('Customer Visits','grey-gallery'); ?>
								<div id="chart_visits_per_month" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					
					
					<?php $this->load->view('sys/chart_sap_customer_visits_view',$data); ?>
					
					
					<div class = "col-md-12">
					<?php portlet_begin('SAP Projects (Monthly)','grey-gallery'); ?>
								<div id="chart_monthly_projects" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					<?php $this->load->view('sys/chart_monthly_projects_view',$data); ?>
<?php } ?>					
					
					
					<div class = "col-md-6">
					<?php portlet_begin('Leaves Summary','grey-gallery',1); ?>
								<div id="chart_leaves" style="width: 100%; height: auto; margin-left:20px; "></div>
					<?php portlet_end(); ?>
					</div>
					<?php $this->load->view('sys/chart_leaves_view',$data);?>
					
					
					<div class = "col-md-6">
					<?php portlet_begin('Explanation Calls Summary','grey-gallery',1); ?>
								<div id="chart_explanation_calls" style="width: 100%; height: auto; margin-left:20px; "></div> 
					<?php portlet_end(); ?>
					</div>
					
					<?php $this->load->view('sys/chart_explanation_calls_view',$data);?>
					
   
<!-- END EXAMPLE TABLE PORTLET--> 

      </div>

     </div>

<?php 

$this->load->view('sys/chart_working_hours_view',$data);
	  
if ($view_ts_statistics == TRUE) {
	  $this->load->view('sys/chart_pm_equipment_distribution_view',$data);
	  $this->load->view('sys/chart_complaint_equipment_distribution_view',$data);
}

if ($view_project_statistics == TRUE) {	 
	  
}
	 
?>
<?php } // if either view_project_statistics OR view_ts_statistics ?>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<script>
$(document).ready(function() {
  setTimeout(function() {
	   window.dispatchEvent(new Event('resize'));
	   console.log('zzz');
    //$("#signInButton").trigger('click');
  }, 000);
});
$(document).ready(function(){
   
});

</script>
<style>
textarea {
  width: 100%;
}
.highcharts-container { overflow: visible !important; } 
.highcharts-root { overflow: visible !important; } 
svg { overflow: visible; }

.hClass {
	height: 580px;
}
@media screen and (max-width:990px) {
	.hClass {
		height:auto;
	}
}
</style>
<?php
//echo '1';
if ($data['fk_employee_id']!=0) {
$error = "";
$eq = $this->db->query("SELECT * FROM tbl_report_errors_temp WHERE fk_user_id= '".$data['fk_employee_id']."' AND month = '".$data['end_date']."'");
$er = $eq->result_array();
if ($er[0]['explanation_calls_pending'] == '0' && $er[0]['projects_missing_comments'] == '0' && $er[0]['projects_without_strategy'] == '0'
 && $er[0]['pm_missing_comments'] == '0' && $er[0]['ts_missing_comments'] == '0'
)
	$errors_in_report = FALSE;
else {
if ($er[0]['explanation_calls_pending'] != '0') $error .= "".$er[0]['explanation_calls_pending']." pending explanation calls ";
if ($er[0]['projects_missing_comments'] != '0') $error .= "".$er[0]['projects_missing_comments']." projects without comments ";
if ($er[0]['projects_without_strategy'] != '0') $error .= "".$er[0]['projects_without_strategy']." projects without revised strategy ";
if ($er[0]['pm_missing_comments'] != '0') $error .= "".$er[0]['pm_missing_comments']." PMCs without comments ";
if ($er[0]['ts_missing_comments'] != '0') $error .= "".$er[0]['ts_missing_comments']." Service Calls without comments ";
}
// Get the content that is in the buffer and put it in your file //
if(!($errors_in_report) && !(file_exists($path)) && $user != 0 && $data['end_date']<time()) { // if no errors in report and report hasn't been saved and today should be greater than last of submitted report month
	// We have to make query for when this condition is true to make an entry in report_comments with message that report for respective month saved by user
	$t = "submitted,".date('F Y',strtotime($data['end_date'])).",".substr($file_name, 0, -5);;
	$query="insert into tbl_report_comments SET 				
								`date`						=	'".date('Y-m-d H:i:s')."',
								`fk_user_id`  				=	'".$data['fk_employee_id']."',
								`report_user`  				=	'".$data['fk_employee_id']."',
								`report_comments`			=	'".$t."'
							  ";
		$dbres = $this->db->query($query);
	file_put_contents($path, ob_get_contents());
}
?>
<?php if($error != "") { ?>
 <script>
 $(document).ready(function() { 
	var theDiv = document.getElementById("report_status");
	var content = document.createTextNode("<?php echo 'REPORT Status (Report will not be submitted for Review unless all following observations are cleared)\n: '.$error; ?>");
	//theDiv.removeClass("alert-info");
	//$("#report_status").removeClass("intro");
	//theDiv.addClass("alert-danger");
	$("#report_status").addClass("alert alert-danger");
	theDiv.appendChild(content);
});
</script>
 <?php } elseif($show_js_div && $user == 1){ ?>
 <script>
 $(document).ready(function() { 
	var theDiv = document.getElementById("report_status");
	var content = document.createTextNode("This report has been submitted successfully");
	$("#report_status").addClass("alert alert-info");
	theDiv.appendChild(content);
});
</script>
 <?php } elseif($show_js_div) { ?>
 <script>
 $(document).ready(function() { 
	var theDiv = document.getElementById("report_status");
	var content = document.createTextNode("<?php
		if ($user==1) echo "Report can only be submitted after the last date of month.";
		else echo "Report not submitted yet";
	?>
	");
	$("#report_status").addClass("alert alert-danger"); 
	theDiv.appendChild(content);
});
</script>
 <?php } ?>
<?php }
$this->load->view('footer');?>
