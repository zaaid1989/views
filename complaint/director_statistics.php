<?php $this->load->view('header');?>
<?php /*
<script src="<?php echo base_url();?>assets/global/plugins/colResizable-1.5.min.js" type="text/javascript"></script>
*/ ?>

<!-- BEGIN PAGE HEADER-->
        <h3 class="page-title"> Director Statistics <small>Statistics</small> </h3>
        <div class="page-bar">
          <ul class="page-breadcrumb">
            <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> </li>
            <li> Statistics </li>
          </ul>
        </div>
        <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
          <div class="col-md-12"> 
           <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bg-inverse">
                <div class="portlet-title">
                  <div class="caption"> <i class="fa fa-globe"></i>View Statistics FSE</div>
                  <div class="tools">
                       <input type="button" value="Transpose" class="btn btn-sm default yellow" onclick="transpose_table()"> 
                  </div>
                </div>
                <div class="portlet-body">
                <?php
                    $visits=0;
                    $mas_hour_result=0;
                    $offices_mas_hour_result=0;
                    if(isset($_GET['msg']))
                      { 
                        echo '<div class="alert alert-success alert-dismissable">  
                                <a class="close" data-dismiss="alert">×</a>  
                                Success.  
                              </div>';
                      }        
                  ?>
                  <div class="row">
                   <!---->
                   <div class="col-md-12">
                    <!--  <div class="table-scrollable">  -->
                          <table class="table  table-bordered dataaTable ">
                              <thead >
                                <tr class="bg-green-jungle">
                                  <td><span style="font-weight:bold;">Employee</span></td>
                                  <td><span style="font-weight:bold;">Total Leaves</span></td>
                                  <td><span style="font-weight:bold;">Daily Allowance of Previous Month</span></td>
                                  <td><span style="font-weight:bold;">Daily Allowance of current Month</span></td>
                                  <td><span style="font-weight:bold;">Average Visits Per Day</span></td>
                                  
                                  <td><span style="font-weight:bold;">Average Hours Per Day</span></td>
                                  <td><span style="font-weight:bold;">Average Hours Per Day in Field</span></td>
                                  <td><span style="font-weight:bold;">Average Hours Per Day in Office</span></td>
                                  <td><span style="font-weight:bold;">Explanation Calls Amount Charged this Month</span></td>
                                  <td><span style="font-weight:bold;">Explanation Calls Amount Charged Previous Month</span></td>
								  <td><span style="font-weight:bold;">Explanation Calls Amount Pending</span></td>
                                  <td><span style="font-weight:bold;">Explanation Calls Amount Discarded</span></td>
                                  <td><span style="font-weight:bold;">Complaints Assigned in last 30 days</span></td>
                                  <td><span style="font-weight:bold;">Complaints Pending</span></td>
                                  <td><span style="font-weight:bold;">Complaints Completed in last 30 days</span></td>
                                  <td><span style="font-weight:bold;">PM Assigned in last 30 days</span></td>
                                  <td><span style="font-weight:bold;">PM Pending</span></td>
                                  <td><span style="font-weight:bold;">PM Completed in last 30 days</span></td>
                                  <td><span style="font-weight:bold;">Average time to resolve Service call</span></td>
                                  <td><span style="font-weight:bold;">Average time to resolve PM</span></td>
                                  <td><span style="font-weight:bold;">Remaining/Balance Leaves</span></td>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php 
								  	$maxqu = $this->db->query("SELECT * FROM user where userrole IN ('FSE','Supervisor') AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
							 		$maxval=$maxqu->result_array();
									foreach($maxval as $value)
									{
								  ?>
                                  <tr class="add">
                                      <td>
										<span style="font-weight:bold;">
                                      	<?php
											echo $value['first_name'];
									    ?>
										</span>
                                      </td>
                                      <td>
                                      <!--Total Leaves-->
                                      	<?php
											echo $value['total_leaves'];
									    ?>
                                      </td>
                                      <td>
                                 	 	<!--Daily Allowance of Previous month-->
                                      	<?php
                                                 // this is seperate calculation for  visits  calculation from first of this month.
                                                 $m = date('n'); 
												 //$m=1;
                                                  $lastmonth_start = date('Y-m-d',mktime(1,1,1,$m-1,1,date('Y'))); 
                                                  $lastmonth_end = date('Y-m-d',mktime(1,1,1,$m,0,date('Y'))); 
												  //echo $lastmonth_start;
                                                 $dbres_query = "SELECT * FROM tbl_dvr where (fk_engineer_id = '".$value['id']."' 
                                                                 AND date 
                                                                 between '".$lastmonth_start."' 
                                                                 AND 
                                                                 '".$lastmonth_end."'
                                                                 
                                                                  AND  (`fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$'
                                                                  OR `outstation` = '1' ))
																  GROUP BY DATE
                                                                 ";
                                                 $dbres = $this->db->query($dbres_query);
                                                 $dbresResult=$dbres->result_array();
                                                 //
                                                 $sunday_visits_this_month=0;
                                                 $non_sunday_visits_this_month=0;
                                                 //
                                                 foreach ($dbresResult as $eng_dvr ) 
                                                 {
                                                    $mynewdate = date('D',strtotime($eng_dvr['date']));
                                                      if($mynewdate=='Sun')
                                                      {
                                                          $sunday_visits_this_month++;
                                                      }
                                                      elseif($mynewdate!='Sun')
                                                      {
                                                          $non_sunday_visits_this_month++;
                                                      }					   
                                                 }
                                               $maxqu = $this->db->query("SELECT * FROM user where id='".$value['id']."'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
                                               $maxval=$maxqu->result_array();
                                               $specific_amount_1 = $maxval[0]['specific_amount'];
                                               
                                              $daily_allownce_of_this_month 	= ($non_sunday_visits_this_month* $specific_amount_1)+($sunday_visits_this_month 
                                              * $specific_amount_1); 											
                                              echo ' ('.$non_sunday_visits_this_month.', '.$sunday_visits_this_month.') ';
											  //
                                              echo $daily_allownce_of_this_month;?>
                                      </td>
                                      <td>
                                      	<!--Daily Allowance of current month-->
										<?php
                                                 // this is seperate calculation for  visits  calculation from first of this month.
                                                 $today_date = date('d', time() - 60 * 60 * 24);
                                                 $dbres_query = "SELECT * FROM tbl_dvr where (fk_engineer_id = '".$value['id']."' 
                                                                 AND date 
                                                                 between '".date('Y-m-d', time() - 60 * 60 * 24 * $today_date)."' 
                                                                 AND 
                                                                 '".date('Y-m-d')."'
                                                                 
                                                                  AND  (`fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$'
                                                                  OR `outstation` = '1' ))
																  GROUP BY DATE
                                                                 ";
                                                 $dbres = $this->db->query($dbres_query);
                                                 $dbresResult=$dbres->result_array();
                                                 //
                                                 $sunday_visits_this_month=0;
                                                 $non_sunday_visits_this_month=0;
                                                 //
                                                 foreach ($dbresResult as $eng_dvr ) 
                                                 {
                                                    $mynewdate = date('D',strtotime($eng_dvr['date']));
                                                      if($mynewdate=='Sun')
                                                      {
                                                          $sunday_visits_this_month++;
                                                      }
                                                      elseif($mynewdate!='Sun')
                                                      {
                                                          $non_sunday_visits_this_month++;
                                                      }					   
                                                 }
                                               $maxqu = $this->db->query("SELECT * FROM user where id='".$value['id']."' ");
                                               $maxval=$maxqu->result_array();
                                               $specific_amount_1 = $maxval[0]['specific_amount'];
                                               
                                              $daily_allownce_of_this_month 	= ($non_sunday_visits_this_month* $specific_amount_1)+($sunday_visits_this_month 
                                              * $specific_amount_1); 											
                                              echo ' ('.$non_sunday_visits_this_month.', '.$sunday_visits_this_month.') ';
                                          	  echo $daily_allownce_of_this_month;
											 ?>
                                      </td>
                                      <td>
                                      	<!--Average Visits Per Day-->
										<?php
											   // this is seperate calculation for  visits  calculation from first of this month. AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$'
											   $today_date = date('d', time() - 60 * 60 * 24);
											   $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$value['id']."' 
											   				   
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 30)."' 
															   AND 
															   '".date('Y-m-d')."' order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
											   //$divider = $dbres->num_rows();
											   //echo $divider.' ';
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
											   foreach ($dbresResult as $eng_dvr ) 
											   {
												  $count_total_this_month	= $count_total_this_month+1;
												  $mynewdate = date('D',strtotime($eng_dvr['date']));
															  if($mynewdate=='Sun')
															  {
																  $sunday_visits_this_month++;
																  //echo $sunday_visits_this_month;
															  }
															  elseif($mynewdate!='Sun')// && substr($eng_dvr['fk_customer_id'],0,1)!='o'
															  {
																  $non_sunday_visits_this_month++;
																  //echo $non_sunday_visits_this_month;
															  }
															  
												   if(substr($eng_dvr['fk_customer_id'],0,1)=='o')
													  {
														  $count_office_this_month = $count_office_this_month+1;								
													  }	
													  
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
																	//echo $positive_hours . ", ";
																	$mas_hour_result=$mas_hour_result + $positive_hours;
																	$count_total= $count_total+1;
																	
																	
													   		if(substr($eng_dvr['fk_customer_id'],0,1)=='o')
																	{
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
																		//echo $offices_positive_hours . ", ";
																		$offices_mas_hour_result	=$offices_mas_hour_result + $offices_positive_hours;
																		$count_office = $count_office+1;								
																	}
																		   
											   
													  /*calculating hours*/
													  
													  			   
											   }
											   $count_visits=$count_total - $count_office;	
											   //print_r($date_array);
											   $count_visits_this_month	=	$count_total_this_month - $count_office_this_month;	
											   //calculate open days using group by query as it will return only unique Dates.
											   // AND fk_customer_id REGEXP '^[0-9]+\\.?[0-9]*$' 
											   $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$value['id']."' 
											   				   
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 30)."' 
															   AND 
															   '".date('Y-m-d')."' group by date order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
           									   $divider = $dbres->num_rows();
											   //echo $divider.' ';
											   //echo $count_visits_this_month . '----' . $divider . '----'; //zaaid
											   if($divider>0)
											   {
											   	echo round($count_visits_this_month/$divider, 2);
											   }
											   ?> Visits/ Day
                                      </td>
                                      <td>
									  	<!--Average Hours Per Day-->
										<?php 
											//z
											//echo $mas_hour_result."-----".$divider."-----";
											//z
											if($divider>0)
											   {
											   	$office_plus_filed_hours = round($mas_hour_result/$divider, 2);
												echo $office_plus_filed_hours;
											   }
										?> Hours
                                      </td>
                                      <td>
                                      	<!--Average Hours Per Day in filed-->
										<?php 
											if($divider>0)
											   {
											   	$offices_hours=  round($offices_mas_hour_result/$divider, 2);
												//
												$field_hours = $office_plus_filed_hours-$offices_hours;
												echo $field_hours;
											   }
										?> Hours 
                                      </td>
                                      <td>
                                      	<!--Average Hours Per Day in office-->
										<?php 
											if($divider>0)
											   {
											   	echo $offices_hours;
											   }
										?> Hours 
                                      </td>
                                      <td>
                                      	<!--Fine This Month-->
										<?php 
                                              $query2 = $this->db->query("select * from tbl_fine 
																		 where status = 'Charged' AND fk_employee_id = '".$value['id']."' 
																		 AND date like '".date('Y-m')."%'");
                                              $amount_count = $query2->result_array();
											  $total=0;
											  foreach($amount_count as $value2)
											  {
												  $total= $total + $value2['amount'];
											  }
                                              echo $total;
                                            ?>
                                      </td>
                                      <td>
                                      	<!--Fine Previous Month-->
										<?php 
                                              $month=date('m')-1;
											  if( strlen($month)==1)
											  { $month= '0'.$month; }
											  $year=date('Y');
											  if ($month == '01') $year = $year - 1;
											  //echo $month;
											  $my_query = "select * from tbl_fine 
														   where status = 'Charged' AND fk_employee_id = '".$value['id']."' 
														   AND date like '".$year.'-'.$month."%'";
											  //echo $my_query;
											  $query2 		 = $this->db->query($my_query);
                                              $amount_count = $query2->result_array();
											  $total=0;
											  foreach($amount_count as $value1)
											  {
												  $total= $total + $value1['amount'];
											  }
                                              echo $total;
                                            ?>
                                      </td>
									  <td>
									  <!--Fine Calls Amount Pending-->
										<?php 
                                              $month=date('m')-1;
											  if( strlen($month)==1)
											  { $month= '0'.$month; }
											  $year=date('Y');
											  if ($month == '01') $year = $year - 1;
											  //echo $month;
											  $my_query = "select * from tbl_fine 
														   where status = 'Pending' AND fk_employee_id = '".$value['id']."' ";
														  // AND date like '".$year.'-'.$month."%'";
											  //echo $my_query;
											  $query2 		 = $this->db->query($my_query);
                                              $amount_count = $query2->result_array();
											  $total=0;
											  foreach($amount_count as $value1)
											  {
												  $total= $total + $value1['amount'];
											  }
                                              echo $total;
                                            ?>
                                      </td>
									  <td>
									  <!--Explanation Calls Amount Discarded-->
										<?php 
                                              $month=date('m')-1;
											  if( strlen($month)==1)
											  { $month= '0'.$month; }
											  $year=date('Y');
											  if ($month == '01') $year = $year - 1;
											  //echo $month;
											  $my_query = "select * from tbl_fine 
														   where status = 'Discarded' AND fk_employee_id = '".$value['id']."'"; 
														   //AND date like '".$year.'-'.$month."%'";
											  //echo $my_query;
											  $query2 		 = $this->db->query($my_query);
                                              $amount_count = $query2->result_array();
											  $total=0;
											  foreach($amount_count as $value1)
											  {
												  $total= $total + $value1['amount'];
											  }
                                              echo $total;
                                            ?>
                                      </td>
                                      <td>
                                      <!--Complaints Assigned in last 30 days -->
                                      	<?php 
											$dbres_query = "SELECT * FROM tbl_complaints where assign_to = '".$value['id']."' 
											   				   AND complaint_nature = 'complaint'
															   
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 31)."' 
															   AND 
															   '".date('Y-m-d')."' order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
											   $C_A_I_L_T_D = $dbres->num_rows();
											   echo $C_A_I_L_T_D;
           									   //$dbresResult=$dbres->result_array();
										?>
                                      </td>
                                      <td>
                                      <!--Complaints Pending-->
                                      	<?php
                                        	$dbres_query = "SELECT * FROM tbl_complaints where assign_to = '".$value['id']."' 
											   				   AND complaint_nature = 'complaint'
															   AND status = 'pending' order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres 				= $this->db->query($dbres_query);
											   $Complaints_Pending  = $dbres->num_rows();
											   echo $Complaints_Pending;
           									   //$dbresResult=$dbres->result_array();
										?>
                                      </td>
                                      <td>
                                      	<!--Complaints Completed in last 30 days-->
                                        <?php 
											$dbres_query = "SELECT * FROM tbl_complaints where assign_to = '".$value['id']."' 
											   				   AND complaint_nature = 'complaint'
															   AND status = 'Closed'
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 31)."' 
															   AND 
															   '".date('Y-m-d')."' order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
											   $C_C_I_L_T_D = $dbres->num_rows();
											   echo $C_C_I_L_T_D;
           									   //$dbresResult=$dbres->result_array();
										?>
                                      </td>
                                      <td>
                                      	<!--PM Assigned in last 30 days-->
                                        <?php 
											$dbres_query = "SELECT * FROM tbl_complaints where assign_to = '".$value['id']."' 
											   				   AND complaint_nature = 'PM'
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 31)."' 
															   AND 
															   '".date('Y-m-d')."' order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
											   $C_C_I_L_T_D = $dbres->num_rows();
											   echo $C_C_I_L_T_D;
           									   //$dbresResult=$dbres->result_array();
										?>
                                      </td>
                                      <td>
                                      	<!--PM Pending-->
                                        <?php 
											$dbres_query = "SELECT * FROM tbl_complaints where assign_to = '".$value['id']."' 
											   				   AND complaint_nature = 'PM'
															   AND status ='Pending' order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
											   $C_C_I_L_T_D = $dbres->num_rows();
											   echo $C_C_I_L_T_D;
           									   //$dbresResult=$dbres->result_array();
										?>
                                      </td>
                                      <td>
                                      	<!--PM Completed in last 30 days-->
                                        <?php 
											$dbres_query = "SELECT * FROM tbl_complaints where assign_to = '".$value['id']."' 
											   				   AND complaint_nature = 'PM'
															   AND status = 'Completed'
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 31)."' 
															   AND 
															   '".date('Y-m-d')."' order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
											   $PM_C_I_L_T_D = $dbres->num_rows();
											   echo $PM_C_I_L_T_D;
           									   //$dbresResult=$dbres->result_array();
										?>
                                      </td>
                                      
                                      <!--New fields starts here-->
                                      <td>
                                      <?php $qu_int_sc	="select * from tbl_complaints where assign_to='".$value['id']."' 
											  					  AND complaint_nature='complaint' AND status='Closed' ";
													$qh_int_sc	=$this->db->query($qu_int_sc);
													if($qh_int_sc->num_rows()>0)
													{
														$res_int_sc = $qh_int_sc->result_array();
														$average=0;
														$count=0;
														foreach($res_int_sc as $interval)
														{
															$count++;
															/*$to_time_date= substr($interval['solution_date'],0,10);
															$to_time_time = explode(' ',$interval['solution_time']);
															$hour_minut = explode(':', $to_time_time[0]);
															if($to_time_time[1]=='PM')
															{
																$hour=$hour_minut[0]+12;
															}
															else
															{
																$hour=$hour_minut[0];
															}
															$minut= $hour_minut[1];
															if(strlen($hour)<2)
															{
																$hour='0'.$hour;
															}
															$to_time=$to_time_date.' '.$hour.':'.$minut.':00';
															$to_time=strtotime($to_time);*/
															$to_time   = strtotime($interval['finish_time']);
															$from_time = strtotime($interval['date']);
															$average   = round(abs($to_time - $from_time) / 3600,2);//.', ';
														}
														echo round($average/$count,2).' Hours';
													}
													else
													{
														echo  "N / A";
													}
											 ?>
                                      </td>
                                      <td>
                                      <?php $qu_int_sc	="select * from tbl_complaints where assign_to='".$value['id']."' 
											  					  AND complaint_nature='PM' AND status='Completed' ";
													$qh_int_sc	=$this->db->query($qu_int_sc);
													if($qh_int_sc->num_rows()>0)
													{
														$res_int_sc = $qh_int_sc->result_array();
														$average=0;
														$count=0;
														foreach($res_int_sc as $interval)
														{
															$count++;
															$to_time= strtotime($interval['solution_date']);
															$from_time = strtotime($interval['date']);
															$average = round(abs($to_time - $from_time) / 3600,2);//.', ';
														}
														echo round($average/$count,2).' Hours';
													}
													else
													{
														echo  "N / A";
													}
											 ?>
                                      </td>
                                      <td>
                                      <!--Remaining Leaves-->
                                      	<?php
											$start_month	=	7; // July
											 $available_leaves	=	21;
											 $leaves_per_month	=	$available_leaves/12;
											 $working_months_current_year	=	12; ////////////total months  for which leaves will be given
											 $current_month	=	date('m');
											 $current_year	=	date('Y');
											 $previous_year	=	date('Y')-1;
											 $join_date		= 	$value["date_of_joining"];
											 $join_month	=	date('m',strtotime($join_date));
											 $join_year		=	date('Y',strtotime($join_date));
											 
											 
											 if ($current_month>$start_month && $join_month>$start_month && $join_year == $current_year ){
												 $working_months_current_year	= 12 + $start_month - $join_month;
											 }
											 elseif ($current_month<$start_month && $join_month>$start_month && $join_year == $previous_year){
												 $working_months_current_year	= 12 + $start_month - $join_month;
											 }
											 elseif ($current_month<$start_month && $join_month<$start_month && $join_year == $current_year) {
												 $working_months_current_year	= $start_month - $join_month;
											 }
											 else $working_months_current_year = 12;
											 $available_leaves	=	$working_months_current_year * $leaves_per_month;
											 
											echo $available_leaves - $value['total_leaves'];
									    ?>
                                      </td>
                                   </tr> 
                                   <?php
									}
								   ?>
                              </tbody>
                         </table>
                    <!-- </div> -->
                   </div>
                 </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET--> 
            </div>
            
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bg-inverse">
                <div class="portlet-title">
                  <div class="caption"> <i class="fa fa-globe"></i>View Statistics SAP</div>
                  <div class="tools">
                       <a href="javascript:;" class="collapse"> </a> 
                       <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
                <div class="portlet-body">
                <?php
                    $visits=0;
                    $mas_hour_result=0;
                    $offices_mas_hour_result=0;       
                  ?>
                  <div class="row">
                   <!---->
                   <div class="col-md-12">
                      <!--  <div class="table-scrollable">  -->
                          <table class="table  table-bordered dataaTable">
                              <thead>
                                <tr class="bg-green-jungle">
                                  <td><span style="font-weight:bold;">Employee</span></td>
                                  <td><span style="font-weight:bold;">Total Assigned Customers</span></td>
                                  <td><span style="font-weight:bold;">Customers Visited in Last 30 Days</span></td>
                                  <td><span style="font-weight:bold;">Customers Not Visited in Last 30 Days</span></td>
                                  <td><span style="font-weight:bold;">Average Visits Per Day</span></td>
                                  
                                  <td><span style="font-weight:bold;">PM Completed in last 30 days</span></td>
                                  <td><span style="font-weight:bold;">Total leaves</span></td>
                                  <td><span style="font-weight:bold;">Average Hours Per Day</span></td>
                                  <td><span style="font-weight:bold;">Average Hours Per Day in Field</span></td>
                                  <td><span style="font-weight:bold;">Average Hours Per Day in Office</span></td>
                                  <td><span style="font-weight:bold;">Daily Allowance of Previous month</span></td>
                                  <td><span style="font-weight:bold;">Daily Allowance of current month</span></td>
                                  <td><span style="font-weight:bold;">Fine This Month</span></td>
                                  <td><span style="font-weight:bold;">Fine Previous Month</span></td>
                                  <td><span style="font-weight:bold;">Average time to resolve Service call</span></td>
                                  <td><span style="font-weight:bold;">Average time to resolve PM</span></td>
                                  <td><span style="font-weight:bold;">Remaining/Balance Leaves</span></td>
                                  
                                </tr>
                              </thead>
                              <tbody>
                                  <?php 
								  	$maxqu = $this->db->query("SELECT * FROM user where userrole='Salesman' AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
							 		$maxval=$maxqu->result_array();
									foreach($maxval as $value)
									{
								  ?>
                                  <tr class="add">
                                      <td><span style="font-weight:bold;">
                                      	<?php
											echo $value['first_name'];
									    ?>
                                      </span></td>
                                      <td>
                                      <!--Total Assigned Customers-->
                                      	<?php 
											  $nq="select * from tbl_customer_sap_bridge where fk_user_id='".$value['id']."'";
											  $nq6 = $this->db->query($nq);
											  echo  $nq6->num_rows();
										?>
                                      </td>
                                      <td>
                                 	 	<!--Customers Visited in Last 30 Days-->
                                        <?php 
											 $count_of_customers_not_visited_in_last_30_days=0;
											$myquery="SELECT 
											tbl_customer_sap_bridge.fk_client_id, tbl_customer_sap_bridge.fk_user_id, 
											tbl_clients.client_name, tbl_clients.fk_city_id, tbl_clients.fk_area_id
											 FROM 
											 tbl_customer_sap_bridge 
											 INNER JOIN
											 tbl_clients
											 ON
											 tbl_clients.pk_client_id 	=	tbl_customer_sap_bridge.fk_client_id
											 where
											 tbl_clients.pk_client_id !=  '0' 
											 AND  tbl_customer_sap_bridge.fk_user_id =  '".$value['id']."'";
											if(!empty($visited_client_array))
											{
											foreach($visited_client_array as $visited)
												{
													$myquery.=" AND tbl_clients.pk_client_id !=  '".$visited."'";
												}
											}
											$maxqu6 = $this->db->query($myquery); 
											if($maxqu6->num_rows()>0)
											{
											$maxval6=$maxqu6->result_array();
											foreach ($maxval6 as $not_visited) 
											{
												$nq="select * from
													 tbl_dvr
													 WHERE
													 fk_engineer_id 	=	'".$not_visited['fk_user_id']."'
													 AND
													 fk_customer_id= '".$not_visited['fk_client_id']."'
													 AND
													 date
													 BETWEEN '".date('Y-m-d', time() - 60 * 60 * 24 * 30)."' 	AND  	'".date('Y-m-d')."'";
													 //echo $nq;exit;
											 $nq7 = $this->db->query($nq);
											 if ($nq7->num_rows() == 0){
												$count_of_customers_not_visited_in_last_30_days++;
												}
											}
										  }
										  ?>
										<?php 
											  $customer_visited_in_last_30_days = $nq6->num_rows() - $count_of_customers_not_visited_in_last_30_days;
                                              echo $customer_visited_in_last_30_days;
                                        ?>
                                      </td>
                                      <td>
                                      	<!--Customers Not Visited in Last 30 Days-->
										<?php
											  echo $count_of_customers_not_visited_in_last_30_days;
										?>
                                      </td>
                                      <td>
                                      	<!--Average Visits Per Day-->
										<?php
											   // this is seperate calculation for  visits  calculation from first of this month. AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$'
											   $today_date = date('d', time() - 60 * 60 * 24);
											   $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$value['id']."' 
											   				   
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 30)."' 
															   AND 
															   '".date('Y-m-d')."' order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
											   //$divider = $dbres->num_rows();
											   //echo $divider.' ';
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
											   foreach ($dbresResult as $eng_dvr ) 
											   {
												  $count_total_this_month	= $count_total_this_month+1;
												  $mynewdate = date('D',strtotime($eng_dvr['date']));
															  if($mynewdate=='Sun')
															  {
																  $sunday_visits_this_month++;
																  //echo $sunday_visits_this_month;
															  }
															  elseif($mynewdate!='Sun')// && substr($eng_dvr['fk_customer_id'],0,1)!='o'
															  {
																  $non_sunday_visits_this_month++;
																  //echo $non_sunday_visits_this_month;
															  }
															  
												   if(substr($eng_dvr['fk_customer_id'],0,1)=='o')
													  {
														  $count_office_this_month = $count_office_this_month+1;								
													  }	
													  
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
																	//echo $positive_hours . ", ";
																	$mas_hour_result=$mas_hour_result + $positive_hours;
																	$count_total= $count_total+1;
																	
																	
													   		if(substr($eng_dvr['fk_customer_id'],0,1)=='o')
																	{
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
																		//echo $offices_positive_hours . ", ";
																		$offices_mas_hour_result	=$offices_mas_hour_result + $offices_positive_hours;
																		$count_office = $count_office+1;								
																	}
																		   
											   
													  /*calculating hours*/
													  
													  			   
											   }
											   $count_visits=$count_total - $count_office;	
											   //print_r($date_array);
											   $count_visits_this_month	=	$count_total_this_month - $count_office_this_month;	
											   //calculate open days using group by query as it will return only unique Dates.
											   // AND fk_customer_id REGEXP '^[0-9]+\\.?[0-9]*$' 
											   $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$value['id']."' 
											   				   
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 30)."' 
															   AND 
															   '".date('Y-m-d')."' group by date order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
           									   $divider = $dbres->num_rows();
											   //echo $divider.' ';
											   //echo $count_visits_this_month . '----' . $divider . '----'; //zaaid
											   if($divider>0)
											   {
											   	echo round($count_visits_this_month/$divider, 2);
											   }
											   ?> Visits/ Day
                                      </td>
                                      <td>
                                      	<!--PM completed in Last 30 Days-->
										<?php 
											$dbres_query = "SELECT * FROM tbl_complaints where assign_to = '".$value['id']."' 
											   				   AND complaint_nature = 'PM'
															   AND status = 'Completed'
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 31)."' 
															   AND 
															   '".date('Y-m-d')."' order by date DESC";
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
											   $C_A_I_L_T_D = $dbres->num_rows();
											   echo $C_A_I_L_T_D;
           									   //$dbresResult=$dbres->result_array();
										?>
                                      </td>
                                      <td>
                                      	<!--Total leaves-->
										<?php
											echo $value['total_leaves'];
									    ?>
                                      </td>
                                      <td>
									  	<!--Average Hours Per Day-->
										<?php
											//z
											//echo $mas_hour_result."-----".$divider."-----";
											//z
											if($divider>0)
											   {
											   	$office_plus_filed_hours = round($mas_hour_result/$divider, 2);
												echo $office_plus_filed_hours;
											   }
										?> Hours
                                      </td>
                                      <td>
                                      	<!--Average Hours Per Day in filed-->
										<?php 
											
											if($divider>0)
											   {
											   	$offices_hours=  round($offices_mas_hour_result/$divider, 2);
												//
												$field_hours = $office_plus_filed_hours-$offices_hours;
												echo $field_hours;
											   }
										?> Hours 
                                      </td>
                                      <td>
                                      	<!--Average Hours Per Day in office-->
										<?php 
											if($divider>0)
											   {
											   	echo $offices_hours;
											   }
										?> Hours 
                                      </td>
                                      
                                      <td>
                                        <!--Daily Allowance of Previous month-->
                                      	<?php
                                                 // this is seperate calculation for  visits  calculation from first of this month.
                                                 $m = date('n'); 
                                                  $lastmonth_start = date('Y-m-d',mktime(1,1,1,$m-1,1,date('Y'))); 
                                                  $lastmonth_end = date('Y-m-d',mktime(1,1,1,$m,0,date('Y'))); 
                                                 $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$value['id']."' 
                                                                 AND date 
                                                                 between '".$lastmonth_start."' 
                                                                 AND 
                                                                 '".$lastmonth_end."'
                                                                 
                                                                  AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$'
                                                                  GROUP BY DATE
                                                                 ";
                                                 $dbres = $this->db->query($dbres_query);
                                                 $dbresResult=$dbres->result_array();
                                                 //
                                                 $sunday_visits_this_month=0;
                                                 $non_sunday_visits_this_month=0;
                                                 //
                                                 foreach ($dbresResult as $eng_dvr ) 
                                                 {
                                                    $mynewdate = date('D',strtotime($eng_dvr['date']));
                                                      if($mynewdate=='Sun')
                                                      {
                                                          $sunday_visits_this_month++;
                                                      }
                                                      elseif($mynewdate!='Sun')
                                                      {
                                                          $non_sunday_visits_this_month++;
                                                      }					   
                                                 }
                                               $maxqu = $this->db->query("SELECT * FROM user where id='".$value['id']."' ");
                                               $maxval=$maxqu->result_array();
                                               $specific_amount_1 = $maxval[0]['specific_amount'];
                                               
                                              $daily_allownce_of_this_month 	= ($non_sunday_visits_this_month* $specific_amount_1)+($sunday_visits_this_month 
                                              * $specific_amount_1); 											
                                              echo ' ('.$non_sunday_visits_this_month.', '.$sunday_visits_this_month.') ';
											  //
                                              echo $daily_allownce_of_this_month;?>
                                      </td>
                                      <td>
                                      	<!--Daily Allowance of Current month-->
                                      	<?php
                                                 // this is seperate calculation for  visits  calculation from first of this month.
                                                 $today_date = date('d', time() - 60 * 60 * 24);
                                   $dbres_query = "SELECT * FROM tbl_dvr where (fk_engineer_id = '".$value['id']."' 
                                                   AND date 
                                                   between '".date('Y-m-d', time() - 60 * 60 * 24 * $today_date)."' 
                                                   AND 
                                                   '".date('Y-m-d')."'
                                                   
                                                    AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$')
                                                    GROUP BY DATE
                                                   ";
                                   $dbres = $this->db->query($dbres_query);
                                   $dbresResult=$dbres->result_array();
                                   //
                                   $sunday_visits_this_month=0;
                                   $non_sunday_visits_this_month=0;
                                   //
                                   foreach ($dbresResult as $eng_dvr )  
                                                 {
                                                    $mynewdate = date('D',strtotime($eng_dvr['date']));
                                                      if($mynewdate=='Sun')
                                                      {
                                                          $sunday_visits_this_month++;
                                                      }
                                                      elseif($mynewdate!='Sun')
                                                      {
                                                          $non_sunday_visits_this_month++;
                                                      }					   
                                                 }
                                               $maxqu = $this->db->query("SELECT * FROM user where id='".$value['id']."' ");
                                               $maxval=$maxqu->result_array();
                                               $specific_amount_1 = $maxval[0]['specific_amount'];
                                               
                                              $daily_allownce_of_this_month 	= ($non_sunday_visits_this_month* $specific_amount_1)+($sunday_visits_this_month 
                                              * $specific_amount_1); 											
                                              echo ' ('.$non_sunday_visits_this_month.', '.$sunday_visits_this_month.') ';
											  //
                                              echo $daily_allownce_of_this_month;?>
                                      </td>
                                      
                                      
                                      <td>
                                      	<!--Fine This Month-->
										<?php 
                                              $query2 = $this->db->query("select * from tbl_fine 
																		 where status = 'Charged' AND fk_employee_id = '".$value['id']."' 
																		 AND date like '".date('Y-m')."%'");
                                              $amount_count = $query2->result_array();
											  $total=0;
											  foreach($amount_count as $value2)
											  {
												  $total= $total + $value2['amount'];
											  }
                                              echo $total;
                                            ?>
                                      </td>
                                      <td>
                                      	<!--Fine Previous Month-->
										<?php 
                                              $month=date('m')-1;
											  if( strlen($month)==1)
											  { $month= '0'.$month; }
											  $year=date('Y');
											  //echo $month;
											  $my_query = "select * from tbl_fine 
														   where status = 'Charged' AND fk_employee_id = '".$value['id']."' 
														   AND date like '".$year.'-'.$month."%'";
											  //echo $my_query;
											  $query2 		 = $this->db->query($my_query);
                                              $amount_count = $query2->result_array();
											  $total=0;
											  foreach($amount_count as $value1)
											  {
												  $total= $total + $value1['amount'];
											  }
                                              echo $total;
                                            ?>
                                      </td>
                                      <!--New fields starts here-->
                                      <td>
                                      <?php $qu_int_sc	="select * from tbl_complaints where assign_to='".$value['id']."' 
											  					  AND complaint_nature='complaint' AND status='Closed' ";
													$qh_int_sc	=$this->db->query($qu_int_sc);
													if($qh_int_sc->num_rows()>0)
													{
														$res_int_sc = $qh_int_sc->result_array();
														$average=0;
														$count=0;
														foreach($res_int_sc as $interval)
														{
															$count++;
															/*$to_time_date= substr($interval['solution_date'],0,10);
															$to_time_time = explode(' ',$interval['solution_time']);
															$hour_minut = explode(':', $to_time_time[0]);
															if($to_time_time[1]=='PM')
															{
																$hour=$hour_minut[0]+12;
															}
															else
															{
																$hour=$hour_minut[0];
															}
															$minut= $hour_minut[1];
															if(strlen($hour)<2)
															{
																$hour='0'.$hour;
															}
															$to_time=$to_time_date.' '.$hour.':'.$minut.':00';
															$to_time=strtotime($to_time);*/
															$to_time	= strtotime($interval['finish_time']);
															$from_time = strtotime($interval['date']);
															$average = round(abs($to_time - $from_time) / 3600,2);//.', ';
														}
														echo round($average/$count,2).' Hours';
													}
													else
													{
														echo  "N / A";
													}
											 ?>
                                      </td>
                                      <td>
                                      <?php $qu_int_sc	="select * from tbl_complaints where assign_to='".$value['id']."' 
											  					  AND complaint_nature='PM' AND status='Completed' ";
													$qh_int_sc	=$this->db->query($qu_int_sc);
													if($qh_int_sc->num_rows()>0)
													{
														$res_int_sc = $qh_int_sc->result_array();
														$average=0;
														$count=0;
														foreach($res_int_sc as $interval)
														{
															$count++;
															$to_time= strtotime($interval['solution_date']);
															$from_time = strtotime($interval['date']);
															$average = round(abs($to_time - $from_time) / 3600,2);//.', ';
														}
														echo round($average/$count,2).' Hours';
													}
													else
													{
														echo  "N / A";
													}
											 ?>
                                      </td>
                                      <td>
                                      <!--Remaining Leaves-->
                                      	<?php
										
											 $start_month	=	7; // July
											 $available_leaves	=	21;
											 $leaves_per_month	=	$available_leaves/12;
											 $working_months_current_year	=	12; ////////////total months  for which leaves will be given
											 $current_month	=	date('m');
											 $current_year	=	date('Y');
											 $previous_year	=	date('Y')-1;
											 $join_date		= 	$value["date_of_joining"];
											 $join_month	=	date('m',strtotime($join_date));
											 $join_year		=	date('Y',strtotime($join_date));
											 
											 
											 if ($current_month>$start_month && $join_month>$start_month && $join_year == $current_year ){
												 $working_months_current_year	= 12 + $start_month - $join_month;
											 }
											 elseif ($current_month<$start_month && $join_month>$start_month && $join_year == $previous_year){
												 $working_months_current_year	= 12 + $start_month - $join_month;
											 }
											 elseif ($current_month<$start_month && $join_month<$start_month && $join_year == $current_year) {
												 $working_months_current_year	= $start_month - $join_month;
											 }
											 else $working_months_current_year = 12;
											 $available_leaves	=	$working_months_current_year * $leaves_per_month;
											 
											echo $available_leaves - $value['total_leaves'];
									    ?>
                                      </td>
                                      
                                   </tr> 
                                   <?php
									}
								   ?>
                              </tbody>
                         </table>
                     <!-- </div> -->
                   </div>
                 </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET--> 
            </div>
          </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>

<script>
$(document).ready(function() { 


	
	
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 100,
	  "bSort" : false,
	  "paging":   false,
	  "information":   false,
	  "searching":   false
	});
	
	
	$(".dataaTable").each(function() {
        var $this = $(this);
        var newrows = [];
        $this.find("tr").each(function(){
            var i = 0;
            $(this).find("td").each(function(){
                i++;
                if(newrows[i] === undefined) { if (i==1) {newrows[i] = $("<tr class='bg-green-jungle'></tr>");} else {newrows[i] = $("<tr class='add'></tr>");} }
                newrows[i].append($(this));
            });
        });
        $this.find("tr").remove();
        $.each(newrows, function(){
            $this.append(this);
        });
    });
});

function transpose_table() {
	/*
  var bTranspose = oTable.fnTransposeState();
  oTable.fnTranspose(!bTranspose);  // alternate the rotation of the table and redraw
  */
  /*
  var t = $('#transposetable tbody').eq(0);
    var r = t.find('tr');
    var cols= r.length;
    var rows= r.eq(0).find('td').length;
    var cell, next, tem, i = 0;
    var tb= $('<tbody></tbody>');

    while(i<rows){
        cell= 0;
        tem= $('<tr></tr>');
        while(cell<cols){
            next= r.eq(cell++).find('td').eq(0);
            tem.append(next);
        }
        tb.append(tem);
        ++i;
    }
    $('#transposetable').append(tb);
    $('#transposetable').show();
	*/
	$(".dataaTable").each(function() {
        var $this = $(this);
        var newrows = [];
        $this.find("tr").each(function(){
            var i = 0;
            $(this).find("td").each(function(){
                i++;
                if(newrows[i] === undefined) { if (i==1) {newrows[i] = $("<tr class='bg-green-jungle'></tr>");} else {newrows[i] = $("<tr class='add'></tr>");} }
                newrows[i].append($(this));
            });
        });
        $this.find("tr").remove();
        $.each(newrows, function(){
            $this.append(this);
        });
    });

    return false;
 
}
<?php /*
$(document).ready(function() { 
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 100,
		'customProp': 'Hello World',
		'initComplete': function(settings) { 
			$('.dataaTable').colResizable({liveDrag:true}); //http://www.bacubacu.com/colresizable/
    }
	});
});
*/ ?>

$('.add').click(function() {
$(this).toggleClass('bg-blue');
})
</script>
<style>
table td, table th
{
    padding: 8px !important; /* 'cellpadding' equivalent */
}
</style>