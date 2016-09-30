<?php $this->load->view('header');?>
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title"> FSE Projects <small>Statistics</small> </h3>
        <div class="page-bar">
          <ul class="page-breadcrumb">
            <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
            <li> Statistics </li>
          </ul>
        </div>
        <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
          <div class="col-md-12"> 
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                  <div class="caption"> <i class="fa fa-globe"></i>View Statistics</div>
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
                    if(isset($_GET['msg']))
                      { 
                        echo '<div class="alert alert-success alert-dismissable">  
                                <a class="close" data-dismiss="alert">×</a>  
                                DVR Updated Successfully.  
                              </div>';
                      }        
                  ?><input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-hover">
							
							<?php
							
							$userid	=	$this->session->userdata('userid');;
							
								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND status!='Closed'";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$pending_ts = sizeof($result); 

								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND status!='Completed' ";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$pending_pm = sizeof($result);

								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$month_ts = sizeof($result);

								//WHERE   create_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
								//$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND MONTH(`date`) = MONTH(CURRENT_DATE) AND YEAR(`date`) = YEAR(CURRENT_DATE)";
								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$month_pm = sizeof($result);
								
								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND status='Closed' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$month_ts_completed = sizeof($result);

								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND status='Completed' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$month_pm_completed = sizeof($result);
							
							?>
    
                                <thead>
                                  <tr><th>Statistic Name</th><th>Statistic Value</th></tr>
                                </thead>
                                <tbody>
                                       <tr class="odd gradeX">
                                             <td>
                                              Average time to resolve Service call
                                             </td>
                                             <td>
                                              <?php $qu_int_sc	="select * from tbl_complaints where assign_to='".$this->session->userdata('userid')."' 
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
                                       </tr>
                                       <tr class="odd gradeX">
                                             <td>
                                              Average time to resolve PM
                                             </td>
                                             <td>
                                              <?php $qu_int_sc	="select * from tbl_complaints where assign_to='".$this->session->userdata('userid')."' 
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
															$to_time	= strtotime($interval['solution_date']);
															$from_time  = strtotime($interval['date']);
															$average 	= round(abs($to_time - $from_time) / 3600,2);//.', ';
														}
														echo round($average/$count,2).' Hours';
													}
													else
													{
														echo  "N / A";
													}
											 ?>
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                              <td>
                                              Complaints Assigned in last 30 days
                                             </td>
                                             <td>
                                              <?php echo $month_ts;?>
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                             <td>
                                              Complaints Pending
                                             </td>
                                             <td>
                                              <?php echo $pending_ts;?>
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                             <td>
                                              Complaints Completed in last 30 days
                                             </td>
                                             <td>
                                              <?php echo $month_ts_completed;?>
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                              <td>
                                              PM Assigned in last 30 days
                                             </td>
                                             <td>
                                              <?php echo $month_pm;?>
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                              <td>
                                              PM Pending
                                             </td>
                                             <td>
                                              <?php echo $pending_pm;?>
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                              <td>
                                              PM Completed in last 30 days
                                             </td>
                                             <td>
                                              <?php echo $month_pm_completed;?>
                                             </td>
                                       </tr>
                                       <?php
                                       		$query = $this->db->query("select * from user where id = '".$this->session->userdata('userid')."'");
											$user_result = $query->result_array();
									   ?>
                                       <tr class="odd gradeX">
                                              <td>
                                              Total Leaves
                                              </td>
                                             <td>
                                              <?php echo $user_result[0]['total_leaves'];?>
                                             </td>
                                       </tr>
                                       
                                </tbody>
                           </table>
                    </div>
                   </div>
                    <div class="col-md-6">
                      <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-hover">
    
                                <thead>
                                  <tr><th>Statistic Name</th><th>Statistic Value</th></tr>
                                </thead>
                                <tbody>
                                       <tr class="odd gradeX">
                                              <td>
                                              Average Visits Per Day
                                             </td>
                                             <td>
                                              <?php echo '';?><span class="visits_show"></span> Visits/ Day
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                              <td>
                                              Average Hours Per Day
                                             </td>
                                             <td>
                                              <?php echo '';?><span class="hours_show"></span> Hours / Day 
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                              <td>
                                              Average Hours Per Day in Field
                                             </td>
                                             <td>
                                              <?php echo '';?><span class="field_mas_hour_result_hidden_span"></span> Hours / Day 
                                             </td>
                                       </tr>
                                      <tr class="odd gradeX">
                                              <td>
                                              Average Hours Per Day in Office
                                             </td>
                                             <td>
                                              <?php echo '';?><span class="offices_mas_hour_result_hidden_span"></span> Hours / Day 
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                              <td>
                                              Daily Allowance of Previous month
                                              <?php
                                                 // this is seperate calculation for  visits  calculation from first of this month.
                                                 $m = date('n'); 
                                                  $lastmonth_start = date('Y-m-d',mktime(1,1,1,$m-1,1,date('Y'))); 
                                                  $lastmonth_end = date('Y-m-d',mktime(1,1,1,$m,0,date('Y'))); 
                                                 $dbres_query = "SELECT * FROM tbl_dvr where (fk_engineer_id = '".$this->session->userdata('userid')."' 
                                                                 AND date 
                                                                 between '".$lastmonth_start."' 
                                                                 AND 
                                                                 '".$lastmonth_end."'
                                                                 
                                                                  AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$')
                                                                  OR `outstation` = '1' 
																  GROUP BY DATE
                                                                 ";
                                                 //echo "<br>first day of previous month=".$lastmonth_start."<br>";
                                                  //echo "last day of previous month=".$lastmonth_end."<br>";
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
                                                          //echo $sunday_visits_this_month;
                                                      }
                                                      elseif($mynewdate!='Sun')
                                                      {
                                                          $non_sunday_visits_this_month++;
                                                          //echo $non_sunday_visits_this_month;
                                                      }					   
                                                 }
                                               $maxqu = $this->db->query("SELECT * FROM user where id='".$this->session->userdata('userid')."' ");
                                               $maxval=$maxqu->result_array();
                                               $specific_amount_1 = $maxval[0]['specific_amount'];
                                               
                                              $daily_allownce_of_this_month 	= ($non_sunday_visits_this_month* $specific_amount_1)+($sunday_visits_this_month 
                                              * $specific_amount_1); 											
                                              echo ' ('.$non_sunday_visits_this_month.', '.$sunday_visits_this_month.')';
                                          
                                              ?>
                                             </td>
                                            
                                             <td>
                                               <?php echo $daily_allownce_of_this_month;?>
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                              <td>
                                              Daily Allowance of current month
                                              <?php
                                                 // this is seperate calculation for  visits  calculation from first of this month.
                                                 $today_date = date('d', time() - 60 * 60 * 24);
                                                 $dbres_query = "SELECT * FROM tbl_dvr where (fk_engineer_id = '".$this->session->userdata('userid')."' 
                                                                 AND date 
                                                                 between '".date('Y-m-d', time() - 60 * 60 * 24 * $today_date)."' 
                                                                 AND 
                                                                 '".date('Y-m-d')."'
                                                                 
                                                                  AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$')
                                                                  OR `outstation` = '1' 
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
                                                          //echo $sunday_visits_this_month;
                                                      }
                                                      elseif($mynewdate!='Sun')
                                                      {
                                                          $non_sunday_visits_this_month++;
                                                          //echo $non_sunday_visits_this_month;
                                                      }					   
                                                 }
                                               $maxqu = $this->db->query("SELECT * FROM user where id='".$this->session->userdata('userid')."' ");
                                               $maxval=$maxqu->result_array();
                                               $specific_amount_1 = $maxval[0]['specific_amount'];
                                               
                                              $daily_allownce_of_this_month 	= ($non_sunday_visits_this_month* $specific_amount_1)+($sunday_visits_this_month 
                                              * $specific_amount_1); 											
                                              echo ' ('.$non_sunday_visits_this_month.', '.$sunday_visits_this_month.')';
                                          
                                              ?>
                                             </td>
                                            
                                             <td>
                                               <?php echo $daily_allownce_of_this_month;?>
                                             </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                            <td>
                                            Fine This Month
                                           </td>
                                           <td>
                                            <?php 
                                              $query2 		 = $this->db->query("select * from tbl_fine 
											  									 where status = 'Charged' AND fk_employee_id = '".$this->session->userdata('userid')."' 
											  									 AND date like '".date('Y-m')."%'");
                                              $amount_count = $query2->result_array();
											  $total=0;
											  foreach($amount_count as $value)
											  {
												  $total= $total + $value['amount'];
											  }
                                              echo $total;
                                            ?>
                                           </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                            <td>
                                            Fine Previous Month
                                           </td>
                                           <td>
                                            <?php 
                                              $month=date('m')-1;
											  if( strlen($month)==1)
											  { $month= '0'.$month; }
											  $year=date('Y');
											  //echo $month;
											  $my_query = "select * from tbl_fine 
											  									 where status = 'Charged' AND fk_employee_id = '".$this->session->userdata('userid')."' 
											  									 AND date like '".$year.'-'.$month."%'";
											  //echo $my_query;
											  $query2 		 = $this->db->query($my_query);
                                              $amount_count = $query2->result_array();
											  $total=0;
											  foreach($amount_count as $value)
											  {
												  $total= $total + $value['amount'];
											  }
                                              echo $total;
                                            ?>
                                           </td>
                                       </tr>
                                       <tr class="odd gradeX">
                                              <td>
                                              Remaining/Balance Leaves
                                              </td>
                                             <td>
                                              <?php echo 22-$user_result[0]['total_leaves'];?>
                                             </td>
                                       </tr>
                                </tbody>
                           </table>
                    </div>
                   </div>
                  </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET--> 
            </div>
            
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green-sharp">
              <div class="portlet-title">
                <div class="caption"> <i class="fa fa-users"></i>FSE Projects Statistics City</div>
                <div class="tools"> 
                    <a href="javascript:;" class="collapse"> </a> 
                    
                    <a href="javascript:;" class="remove"> </a> 
                </div>
              </div>
              <div class="portlet-body">
                <div class="table-toolbar">
                  
                </div>
                
            	<div class="portlet-body flip-scroll">
                 <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                  <thead>
                    <tr>
                      <th class="sorting"> Cities 				</th>
                      <?php 
						$ty=$this->db->query("select * from tbl_business_types where status='0'");
						$rt=$ty->result_array();
						foreach ($rt as $category)
						{
					  ?>
                      <th> <?php echo $category['businesstype_name']?> </th>
                      <?php }?>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                          $query=$this->db->query("select * from tbl_cities");
						  $query_res=$query->result_array();
                          foreach ($query_res as $get_users_list) {
					?>
					<tr class="odd gradeX mytr_city<?php echo $get_users_list['pk_city_id'];?>">
						
						<td>
							<?php echo $get_users_list["city_name"]; ?>
						</td>
						<?php 
							  $total=0;
							  $ty=$this->db->query("select * from tbl_business_types where status='0'");
							  $rt=$ty->result_array();
							  foreach ($rt as $category)
							  {
							?>
							<td> 
							  <?php 
								  $business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."'
								  AND `City` = '".$get_users_list['pk_city_id']."' AND `status`='0' AND `Sales Person`='".$this->session->userdata('userid')."'";
								  $projects_query=$this->db->query($business_data);
								  $projects=$projects_query->result_array();
								  echo $projects_query->num_rows();
								  $total=$total+$projects_query->num_rows();
							  ?> 
							</td>
						<?php }?>
							<td> 
							  <?php 
								  echo $total;
								  if($total==0)
								  {
									  ?>
									  <style>
										  .mytr_city<?php echo $get_users_list['pk_city_id'];?>
										  {
											  display:none !important;
										  }
									  </style>
									  <?php
								  }
							  ?> 
							</td>
					</tr>
					<?php
					}
					?>
					<tr class="odd gradeX">
						
						<td>
							<b>Category Total</b>
						</td>
						<?php 
							  $ty=$this->db->query("select * from tbl_business_types where status='0'");
							  $rt=$ty->result_array();
							  foreach ($rt as $category)
							  {
							?>
							<td> 
							  <?php 
								  $business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."' AND `status`='0' AND 
								  `Sales Person`='".$this->session->userdata('userid')."'";
								  //echo $business_data;
								  $projects_query=$this->db->query($business_data);
								  $projects=$projects_query->result_array();
								  //echo sizeof($projects_query);
								  echo $projects_query->num_rows();
							  ?> 
							</td>
						<?php }?>
							<td> 
							  <?php 
								  echo '';
							  ?> 
							</td>
					</tr>
                  </tbody>
                </table>
               </div>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET--> 
            
            <!--this is just for calculation purpose-->

			   <?php
                $visits			=	$visits;
                $visits_round		=	round($visits, 2);
                //for only offices
                $offices_mas_hour_result  = 	$offices_mas_hour_result;
                 $offices_mas_hour_result_round		=	round($offices_mas_hour_result, 2);
                //
                $mas_hour_result  			= 	$mas_hour_result;
                $mas_hour_result_round		=	round($mas_hour_result, 2);
                ?>
                <input type="hidden" name="visits_hidden" value="<?php echo $visits_round;?>" id="visits_hidden" />
                <input type="hidden" name="mas_hour_result_hidden" value="<?php echo $mas_hour_result_round;?>" id="mas_hour_result_hidden" />
                <input type="hidden" name="offices_mas_hour_result_hidden" value="<?php echo $offices_mas_hour_result_round;?>" id="offices_mas_hour_result_hidden" />
            <!--this is just for calculation purpose-->
          </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>