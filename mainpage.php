<?php include('header.php');?>
<style>
.page-content
{
	padding:0 0 0 0 !important;
}
</style>

<script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>	

     <!-- BEGIN PAGE HEADER-->
                    <div class="col-lg-12"  style="background-color:#e5e5e5 ;color: #333333; padding:5px 0; font-size:20px;">
                    	
                    	<marquee class="col-lg-11">
					<?php
						  $ty21=$this->db->query("select * from user where id='".$this->session->userdata('userid')."'");
						  $rt21=$ty21->result_array();
						  $ty22=$this->db->query("select * from tbl_news where fk_office_id IN ('".$rt21[0]['fk_office_id']."', '0') order by pk_news_id DESC");
						  $rt22=$ty22->result_array();
						  if (sizeof($rt22) == "0") {
							  
						  } else {
							  
							  if($this->session->userdata('userrole')=='Admin')
							  { /* ?>
						  
										<span style="font-size:16px;  color: #d91e18; margin: 0px 0px 15px 0px;font-weight: bold;  ">
                                            <?php echo "Just for Mr Yasir"; ?>&nbsp;
                                        </span>
                                        <span style="font-size:16px;  color: #d91e18; margin: 0px 0px 15px 0px;font-weight: 300; text-decoration: underline;">
										<?php echo "A comments thread has been added (see the last column) against every complaint. It is accessible by FSE/SAP, Respective Supervisor and Director. New comments notification will appear on the button of individual complaint. In my personal opinion it is quite good for complaint related discussion. If you like it, we will put it in PMs too, otherwise remove it from here as well.";?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  
						<?php */ }
							  foreach ($rt22 as $get_users_list) {
								  ?>
                                        <span style="font-size:16px;  color: #333333; margin: 0px 0px 15px 0px;font-weight: bold;">
                                            <?php echo urldecode(substr($get_users_list["news_title"], 0, 75));?>&nbsp;
                                        </span>
                                        <span style="font-size:16px;  color: #333333; margin: 0px 0px 15px 0px;font-weight: 300;">
										<?php echo urldecode(substr($get_users_list["news_description"], 0, 100));?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <?php
							  }
						  }
					?>
                    </marquee>
                    </div>
<!-- **************** BOXES **************** -->
<?php if($this->session->userdata('userrole')!="Admin" && $this->session->userdata('userrole')!="secratery" ) { 
	
	$start_date_month = date('Y-m').'-01';
	$start_date = date('Y-m-d',strtotime($start_date_month));
	$end_date = date('Y-m-d');
	
/*********** Explanation Calls Charged This Month *****************/
	$query2 = $this->db->query("SELECT * from tbl_fine 
							 where status = 'Charged' AND fk_employee_id = '".$this->session->userdata('userid')."' 
							 AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
	$amount_count = $query2->result_array();
	$total=0;
	foreach($amount_count as $value2) $total= $total + $value2['amount'];
	$fine_this_month = $total;

/*********** Daily Allowance *****************/
	$dbres = $this->db->query("SELECT * FROM tbl_dvr where (fk_engineer_id = '".$this->session->userdata('userid')."' 
							 AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'
							  AND  (`fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$'
							  OR `outstation` = '1') )
							  GROUP BY DATE
							 ");
	$dbresResult	=	$dbres->result_array();
	
	$maxqu = $this->db->query("SELECT * FROM user where id='".$this->session->userdata('userid')."' ");
	$maxvall=$maxqu->result_array();
	$daily_allowance_this_month = sizeof($dbresResult) * $maxvall[0]['specific_amount'];
	
/*********** Visits Per Day *****************/
$average_visits_per_day = "N/A";

	$dbres = $this->db->query("SELECT * FROM tbl_dvr where fk_engineer_id = '".$this->session->userdata('userid')."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' order by date DESC");
    $dbresResult=$dbres->result_array();
   //
   $count_total_this_month=0;
   $count_office_this_month=0;
   $sunday_visits_this_month=0;
   $non_sunday_visits_this_month=0;
   //
   $offices_mas_hour_result=0;
   $mas_hour_result=0;
   $count_total=0;
   $count_office=0;
   //
   foreach ($dbresResult as $eng_dvr ) {
		$count_total_this_month	= $count_total_this_month+1;
		$mynewdate = date('D',strtotime($eng_dvr['date']));
		if($mynewdate=='Sun') $sunday_visits_this_month++;
		elseif($mynewdate!='Sun') $non_sunday_visits_this_month++;
				  
		if(substr($eng_dvr['fk_customer_id'],0,1)=='o') $count_office_this_month = $count_office_this_month+1;
		  
		  /*calculating hours*/
		$str_tim=explode(':',$eng_dvr['start_time']);
		$str_hour=$str_tim[0]*60;
		$str_mint=$str_hour + $str_tim[1];
		//
		$end_tim=explode(':',$eng_dvr['end_time']);
		$end_hour=$end_tim[0]*60;
		$end_mint=$end_hour + $end_tim[1];
		//
		$hours_mi=$str_mint- $end_mint;
		$hours= $hours_mi/60;
		$positive_hours=abs($hours);
		$mas_hour_result=$mas_hour_result + $positive_hours;
		$count_total= $count_total+1;
						
		if(substr($eng_dvr['fk_customer_id'],0,1)=='o') {
					$str_tim=explode(':',$eng_dvr['start_time']);
					$str_hour=$str_tim[0]*60;
					$str_mint=$str_hour + $str_tim[1];
					//
					$end_tim=explode(':',$eng_dvr['end_time']);
					$end_hour=$end_tim[0]*60;
					$end_mint=$end_hour + $end_tim[1];
					//
					$hours_mi=$str_mint- $end_mint;
					$hours_offices= $hours_mi/60;
					$offices_positive_hours		=abs($hours_offices);
					$offices_mas_hour_result	=$offices_mas_hour_result + $offices_positive_hours;
					$count_office = $count_office+1;								
		}
		  
   }
   $count_visits=$count_total - $count_office;
   $count_visits_this_month	=	$count_total_this_month - $count_office_this_month;	
   //calculate open days using group by query as it will return only unique Dates.
   // AND fk_customer_id REGEXP '^[0-9]+\\.?[0-9]*$' 
   $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$this->session->userdata('userid')."' 
				   AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' group by date order by date DESC";

   $dbres = $this->db->query($dbres_query);
   $divider = $dbres->num_rows();
   
   if($divider>0) $average_visits_per_day = round($count_visits_this_month/$divider, 2). ' Visits' ;//. ' Visits/Day';
   else $average_visits_per_day = "N/A";

/*********** Hours Per Day *****************/
$average_hours_per_day = "N/A";
	if($divider>0) {
			$office_plus_filed_hours = round($mas_hour_result/$divider, 2);
			$average_hours_per_day = $office_plus_filed_hours . " Hours";
	}

?>
<div class="row" style="padding-top:60px;padding-left:60px;padding-right:60px;">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-steel">
						<div class="visual">
							<i class="fa fa-money"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $daily_allowance_this_month.' Rs'; ?>
							</div>
							<div class="desc">
								 Daily Allowance <?php echo date('F'); ?>
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>sys/monthly_report">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat yellow-gold">
						<div class="visual">
							<i class="fa fa-clock-o"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $average_hours_per_day; ?>
							</div>
							<div class="desc">
								 Average Hours Per Day <?php echo date('F'); ?>
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>sys/monthly_report">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-jungle">
						<div class="visual">
							<i class="fa fa-car"></i>
						</div>
						<div class="details">
							<div class="number">
								<?php echo $average_visits_per_day; ?>
							</div>
							<div class="desc">
								 Average Visits Per Day <?php echo date('F'); ?>
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>sys/monthly_report">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bell"></i>
						</div>
						<div class="details">
							<div class="number">
								<?php echo $fine_this_month.' Rs'; ?>
							</div>
							<div class="desc">
								 Explanation Calls Amount <?php echo date('F'); ?>
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>sys/monthly_report">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
<?php } ?>
<!-- **************** BOXES END ************ -->
			
			<?php if($this->session->userdata('userrole')=="Salesman" ) {
				$data['sap'] = $this->session->userdata('userid');
				$data['territory'] = 0;
			?>
				<div class="row" style="padding-top:10px;padding-left:60px;padding-right:60px;">
					
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">SAP Projects Review - Products</span>
								</div>
							</div>
							<div class="portlet-body" style="   ">
									<div id="chart_sap_projects_review_prod_view" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">Ongoing Projects - Target Date</span>
								</div>
							</div>
							<div class="portlet-body" style="  ">
									<div id="chart_ongoing_projects_target_date_view" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="row" style="padding-top:10px;padding-left:60px;padding-right:60px;">
				
					<div class="col-md-12">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">SAP Territory Visit Review</span>
								</div>
							</div>
							<div class="portlet-body" style="   ">
							<div id="chart_sap_territory_visit_review_projects_customers_view" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
					
				</div>
			
			<?php $this->load->view('sys/chart_sap_projects_review_prod_view',$data);?>
			<?php $this->load->view('sys/chart_sap_territory_visit_review_projects_customers_view',$data);?>
			<?php $this->load->view('sys/chart_ongoing_projects_target_date_view',$data);?>			
			<?php } ?>
					
			<?php if($this->session->userdata('userrole')=="FSE" || $this->session->userdata('userrole')=="Supervisor") {
				$data['territory'] = $this->session->userdata('territory');
				?>
				<div class="row" style="padding-top:10px;padding-left:60px;padding-right:60px;">
				
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">TS Department PENDING Task (Real Time)</span>
								</div>
							</div>
							<div class="portlet-body" style="  ">
									<div id="chart_real_time_territory_report_view" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">PM Status - (Real Time)</span>
								</div>
							</div>
							<div class="portlet-body" style="   ">
									<div id="chart_real_time_territory_pm_view" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
				</div>
				
				<?php $this->load->view('sys/chart_real_time_territory_report_view',$data);?>
				<?php $this->load->view('sys/chart_real_time_territory_pm_view',$data);?>
			<?php } ?>
			
			<?php if($this->session->userdata('userrole')=="Supervisor") {
				$data['territory'] = $this->session->userdata('territory');
				?>
				<div class="row" style="padding-top:10px;padding-left:60px;padding-right:60px;">
				
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">TS Department Activities (Last 30 Days - Real Time)</span>
								</div>
							</div>
							<div class="portlet-body" style="  ">
									<div id="chart_territory_task_distribution_view" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="portlet solid bordered light bg-inverse ">
							<div class="portlet-title">
								<div class="caption font-purple-seance">
									<i class="icon-bar-chart font-purple-seance"></i>
									<span class="caption-subject bold uppercase">Complaints Monthly Overview</span>
								</div>
							</div>
							<div class="portlet-body" style="   ">
									<div id="chart_territory_complaints_view" style="width: 100%; height:400px; margin-left:20px; "></div> 
							</div>
						</div>
					</div>
				</div>
				<?php $this->load->view('sys/chart_territory_task_distribution_view',$data);?>
				<?php $this->load->view('sys/chart_territory_complaints_view',$data);?>
			<?php } ?>
			<?php if($this->session->userdata('userrole')!="FSE" && $this->session->userdata('userrole')!="Supervisor" && $this->session->userdata('userrole')!="Salesman") {?>
					<center >
					<img style="margin-top:35px;" src="<?php echo base_url();?>assets/global/img/PMA23.png" class="imgresponsive2"  >
					</center>
					<h3 class="page-title" style="text-align:center;margin-top:35px;">
			<?php } else echo '<h3 class="page-title" style="text-align:center;">	'; ?>
                Welcome to Online Management Portal
                <p><small>You last logged in from IP <span class="font-green-jungle" ><?php echo $rt21[0]['last_login_ip'];?></span></small>
                <small> on <?php echo date('d-M-Y', strtotime($rt21[0]['last_login_date']));?></small>
                <small> at <?php echo date('h:i A', strtotime($rt21[0]['last_login_date']));?></small>
				<?php
					$country	= 	"Unknown";
					$city 		=	"Unknown";
					$isp		=	"Unknown";
					//$ip = $_REQUEST['REMOTE_ADDR']; // the IP address to query
					$ip	=	$rt21[0]['last_login_ip'];
					$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
					if($query && $query['status'] == 'success') {
					  //echo 'Hello visitor from '.$query['country'].', '.$query['city'].'!';
						$country	= 	$query['country'];
						$city 		=	$query['city'];
						$isp		=	$query['isp'];
						echo '<small> from ' . $city . ', '. $country . ' using ' . $isp . '</small>';
					} else {
					  //echo 'Unable to get location';
					}
				?>
              </p>  
			</h3>
			
				
                <div class="row">
                	<div class="col-lg-12">
                    </div>
                </div>
				
	
	</div>
	
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	<a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
	
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<?php include('footer.php');?>
<style>

.highcharts-container { overflow: visible !important; } 
.highcharts-root { overflow: visible !important; } 
svg { overflow: visible; }

</style>