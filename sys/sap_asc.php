<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Sap <small>ACS</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                SAP ASC
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="portlet box grey-cascade" style="display:none;">
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
                  
                                              <thead>
                                                <tr><th>Statistic Name</th><th>Statistic Value</th></tr>
                                              </thead>
                                              <tbody>
                                                     <tr class="odd gradeX">
                                                            <td>
                                                            Total Assigned Customers 
                                                           </td>
                                                           <td>
                                                            <?php $nq="select * from tbl_customer_sap_bridge where fk_user_id='".$this->session->userdata('userid')."'";
                                                                  $nq6 = $this->db->query($nq);?>
                                                                  <span class="total_assigned_customer_sapn"><?php echo  $nq6->num_rows();?></span>
                                                           </td>
                                                     </tr>
                                                     <tr class="odd gradeX">
                                                            <td>
                                                            Customers Visited in Last 30 Days
                                                           </td>
                                                           <td>
                                                            <?php echo '';?><span class="customer_visited_in_last_30_days_span"></span>
                                                           </td>
                                                     </tr>
                                                     <tr class="odd gradeX">
                                                            <td>
                                                            Customers Not Visited in Last 30 Days
                                                           </td>
                                                           <td>
                                                            <?php echo '';?><span class="count_of_customers_not_visited_in_last_30_days_span"></span> Customers
                                                           </td>
                                                     </tr>
                                                     <tr class="odd gradeX">
                                                            <td>
                                                            Average Visits Per Day
                                                           </td>
                                                           <td>
                                                            <?php echo '';?><span class="visits_show"></span> Visits/ Day
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
														   $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$this->session->userdata('userid')."' 
																		   AND date 
																		   between '".$lastmonth_start."' 
																		   AND 
																		   '".$lastmonth_end."'
																		   
																			AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$'
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
														   $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$this->session->userdata('userid')."' 
																		   AND date 
																		   between '".date('Y-m-d', time() - 60 * 60 * 24 * $today_date)."' 
																		   AND 
																		   '".date('Y-m-d')."'
																		   
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
                                              </tbody>
                                         </table>
                                  </div>
                                 </div>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET--> 
                           </div>
                     <form method="post" action="<?php echo base_url();?>sys/insert_dvr">
                      <input type="hidden" name="form_name" value="sap_dvr" />
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box grey-cascade">
              
                          <div class="portlet-title">
              
                            <div class="caption"> <i class="fa fa-globe"></i>View ASC</div>
              
                            <div class="tools"> 
                              <a href="javascript:;" class="collapse"> </a> 
                              
                              <a href="javascript:;" class="remove"> </a> 
                            </div>
              
                          </div>
              
                          <div class="portlet-body">
                          		<div class="table-toolbar">
                            	<?php
									$visits=0;
									$mas_hour_result=0;
									if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												DVR Updated Successfully.  
											  </div>';
									  }
								  ?>
                            </div>
                                <div class="portlet-body flip-scroll">
                                          
                                      <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
                                         
                                      <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
              
                                          <thead>
                          
                                            <tr>
                                              <th style="padding-right:150px;"> Customer&nbsp;Name </th>
                                              <th style="padding-right:100px;"> Area</th>
                                              <th> Total Visits</th>
                                              <?php $i=0;
											  while( $i<=30)
                                              { 
												 
												 if($i==0)
												  { 
												    $myndate=date('d-M-Y');
													//date to put in th class
													$myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i);
													$week_day = date('D');
												  }
												 else 
												  {
													$myndate=date('d-M-Y', time() - 60 * 60 * 24 * $i);
													$week_day = date('D', time() - 60 * 60 * 24 * $i);
													//date to put in th class
													$myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i);
												  }
													$timeexploded=explode('-',$myndate);
													echo '<th';
													echo ' class="';
													echo $myndateclass.'Parent';
													if($week_day=="Sun")
													{
														echo " redbackgrounclass";
													}
													echo '">'.$timeexploded[0].'<br>'.$timeexploded[1].'<br>'.$timeexploded[2];?>
                                                  </th>
                                                  <?php
                                              $i++;
											   }?>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          <?php 
											  $no_of_total_records=0;
											  if (sizeof($get_eng_dvr) == "0") 
                                          {
                                                                    
                                          } 
                                          else 
                                          {
                                              
											  $visited_client_array= array();
											  $visited_clients= array();
											  $size_of_total_rows=0;
											  foreach ($get_eng_dvr as $eng_dvr) 
                                              {
											  //////////////////////////////////// zaaid
												if (in_array($eng_dvr['fk_customer_id'], $visited_clients)) {
													continue;}
													//////////////// zaaid
													if(substr($eng_dvr['fk_customer_id'],0,1)=='o')
																{
																	$office_id		=	substr($eng_dvr['fk_customer_id'],13,1);
																	$qu2			=	"SELECT * from tbl_offices where pk_office_id =  '".$office_id."'";
																	$gh2			=	$this->db->query($qu2);
																	$rt2			=	$gh2->result_array();
																	$myclient 		= 	$rt2[0]['office_name'];
																	$myarea			=	$rt2[0]['office_name'];
																	$none			=	" style='display:none;'";
																}
																else
																{
																	 $maxqu = $this->db->query("SELECT * FROM tbl_clients where pk_client_id='".$eng_dvr['fk_customer_id']."' ");
																	 $maxval=$maxqu->result_array();
																	 $myclient = $maxval[0]['client_name'];
																	 //for are finding
																	 $maxqu7 = $this->db->query("SELECT * FROM tbl_area where pk_area_id='".$maxval[0]['fk_area_id']."' "); 
                                                             		 $maxval7=$maxqu7->result_array();
																	 $myarea=$maxval7[0]['area'];
																	 $none			=	" ";
																}
                                                  
                                                  ?>
                                                 <tr class="odd gradeX" <?php echo $none;?>>
                                                        <td>
                                                             <?php 
																echo $myclient;
																?>
                                                        </td>  
                                                        <td>
                                                             <?php 
															 echo $myarea;?>
                                                        </td>
                                                        <td>
                                                             <span class="total_visits_in_row<?php echo $size_of_total_rows;?>"></span>
                                                             <script>
															 $(document).ready( function() {
																 var size=$('#row_visits<?php echo $size_of_total_rows;?>').val();
																 $('.total_visits_in_row<?php echo $size_of_total_rows;?>').html(size);
																 if(size==0)
																 {
																	 //alert('siz id zero');
																	 $('.total_visits_in_row<?php echo $size_of_total_rows;?>').closest('tr').hide();
																 }
															 });
															 </script>
                                                        </td>
                                                        <?php $i=0;
														$row_visits=0;
														while( $i<=30 )
                                                        { 
															if($i==0){ $myndate=date('Y-m-d');} else {$myndate=date('Y-m-d', time() - 60 * 60 * 24 * $i);}
															/*if( $myndate==date('Y-m-d',strtotime($eng_dvr['date'])))
															{ 
																echo '<td style="background:#000; color:#fff; text-align:center;">1</td>';
																array_push($visited_client_array, $eng_dvr['fk_customer_id']);
															}
															else
															{
																 echo '<td></td>';
															}*/
															
															$zaaid=0;
															
															foreach ($get_eng_dvr as $eng_dvrr) {
																if( $myndate==date('Y-m-d',strtotime($eng_dvrr['date'])) AND $eng_dvr['fk_customer_id'] == $eng_dvrr['fk_customer_id'] )
																{ 
																	//echo '1';
																	$zaaid=$zaaid+1;
																	//array_push($visited_client_array, $eng_dvr['fk_customer_id']);
																}
																else
																{
																	 $zaaid=$zaaid+0;
																	 //echo '0';
																}															
															}
															
															if( $zaaid>0)
															{ 
																echo '<td class="blackbackgroundclass"></td>';
																$row_visits++;
																$visits++;
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
																//for only office
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
																	
																}
																//array_push($visited_client_array, $eng_dvr['fk_customer_id']);
																
															array_push($visited_client_array, $eng_dvr['fk_customer_id']);
															array_push($visited_clients, $eng_dvr['fk_customer_id']);
															}
															else
															{
																 echo '<td class="';
																 echo $myndate;
																 echo'"></td>';
															}
														$i++;
                                                        }?>  
                                                 	<input type="hidden" name="row_visits" id="row_visits<?php echo $size_of_total_rows;?>" value="<?php echo $row_visits;?>" />
                                                 </tr>
												<?php
													$no_of_total_records++;
													$size_of_total_rows++; 
													}
                                                  
                                                  }?>
                                          </tbody>
                                     </table>
                                  <input type="hidden" name="no_of_total_records" value="<?php echo $no_of_total_records;?>" id="no_of_total_records" />
                                 
									  <?php $i=0;
											  while( $i<=30)
                                              { 
												 
												 if($i==0)
												  { 
													$myndateclass=date('Y-m-d');
												  }
												 else 
												  {
													$myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i);
												  }
												  ?>
												  <script>
								  				  $(document).ready( function(){
												  var class_ocurances = $(".<?php echo $myndateclass?>").length;
												  //alert('class ocurances = '+class_ocurances);
												  var no_of_total_records = $("#no_of_total_records").val();
												  //alert('no_of_total_records = '+no_of_total_records);
												  if(class_ocurances==no_of_total_records)
												  {
													  //alert('class ocurances = '+class_ocurances + 'no_of_total_records = '+no_of_total_records);
													  //$(".<?php echo $myndateclass?>"+Parent).css("background-color", "green");
													  $(".<?php echo $myndateclass.'Parent'?>").addClass('greenbackgrounclass');
												  }
												  });
												  </script>
                                                  <?php
                                              $i++;
											   }?>
                                               
                                               <?php
											   $dbres = $this->db->query("SELECT * FROM tbl_dvr where fk_engineer_id = '".$this->session->userdata('userid')."' 
											   							   AND date 
																		   between '".date('Y-m-d', time() - 60 * 60 * 24 * 30)."' 
																		   AND 
																		   '".date('Y-m-d')."' order by date DESC");
           									   $dbresResult=$dbres->result_array();
											   $offices_mas_hour_result=0;
											   $mas_hour_result=0;
											   $count_total=0;
											   $count_office=0;
											   foreach ($dbresResult as $eng_dvr ) {
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
																		   
											   }
											   $count_visits=$count_total - $count_office;	
											   
											   ?>
											   
											   <?php
											   
												$daysqu = $this->db->query("SELECT COUNT(DISTINCT `date`) AS work_days FROM tbl_dvr where fk_engineer_id = '".$this->session->userdata('userid')."' 
															   AND date 
															   between '".date('Y-m-d', time() - 60 * 60 * 24 * 30)."' 
															   AND 
															   '".date('Y-m-d')."'");
												$daysval=$daysqu->result_array();
												$work_days = $daysval[0]['work_days'];
												//echo "workdays= ". $work_days;
												
											   
											   ?>
                                        <script>
										
										
										 $(document).ready( function() {
											 var holi = $(".greenbackgrounclass").length;
											//var holidays = 31-holi;
											var holidays =<?php echo $work_days;?>;
											 //alert(holidays);
											 // for all hours
											 var mas_hour_result_hidden							=$('#mas_hour_result_hidden').val();
											 var mas_hour_result_hidden_2 						=	mas_hour_result_hidden/holidays;
											 var mas_hour_result_hidden_3 						= Math.round(mas_hour_result_hidden_2 * 100) / 100;
											 $('.hours_show').html(mas_hour_result_hidden_3);
											 // for offices hours
											 var offices_mas_hour_result_hidden					=$('#offices_mas_hour_result_hidden').val();
											 var offices_mas_hour_result_hidden_2 				=	offices_mas_hour_result_hidden/holidays;
											 var offices_mas_hour_result_hidden_3 				= Math.round(offices_mas_hour_result_hidden_2 * 100) / 100;
											 $('.offices_mas_hour_result_hidden_span').html(offices_mas_hour_result_hidden_3);
											 // for filed hours
											 var field_mas_hour_result_hidden_var 				= mas_hour_result_hidden_3 - offices_mas_hour_result_hidden_3;
											 var field_mas_hour_result_hidden_var_3 				= Math.round(field_mas_hour_result_hidden_var * 100) / 100;
											 $('.field_mas_hour_result_hidden_span').html(field_mas_hour_result_hidden_var_3);
											 //
											 var visits_hidden									=	$('#visits_hidden').val();
											 var visits_hidden_2 								=	<?php echo $count_visits;?> / holidays; 
											 var visits_hidden_3 								=	Math.round(visits_hidden_2 * 100) / 100;
											 $('.visits_show').html(visits_hidden_3);
											 //
											 var count_of_customers_not_visited_in_last_30_days = $('#count_of_customers_not_visited_in_last_30_days').val();
											 $('.count_of_customers_not_visited_in_last_30_days_span').html(count_of_customers_not_visited_in_last_30_days);
											 //total_assigned_customer);
											 
											 //
											 var total_assigned_customer 						= $('.total_assigned_customer_sapn').html();
											 var customer_visited_in_last_30_days 				= total_assigned_customer - count_of_customers_not_visited_in_last_30_days;
											 $('.customer_visited_in_last_30_days_span').html(customer_visited_in_last_30_days);
											 
											 
										 });
										 </script> 
                             </div>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET--> 
                      </form>
                      <?php
                      $visits			=	$visits;
					  $mas_hour_result  = 	$mas_hour_result;
					  //for only offices
					  $offices_mas_hour_result  = 	$offices_mas_hour_result;
					  
					  ?>
                      <?php
					  $visits_round		=	round($visits, 2);
					  //
					  $mas_hour_result_round		=	round($mas_hour_result, 2);
					   $offices_mas_hour_result_round		=	round($offices_mas_hour_result, 2);
					  ?>
                      <input type="hidden" name="visits_hidden" value="<?php echo $visits_round;?>" id="visits_hidden" />
                      <input type="hidden" name="mas_hour_result_hidden" value="<?php echo $mas_hour_result_round;?>" id="mas_hour_result_hidden" />
                      <input type="hidden" name="offices_mas_hour_result_hidden" value="<?php echo $offices_mas_hour_result_round;?>" id="offices_mas_hour_result_hidden" />
                      
                      <div class="portlet box grey-cascade">
                        <div class="portlet-title">
            
                          <div class="caption"> <i class="fa fa-globe"></i>List of Customers not Visited in Last 30 Days</div>
            
                          <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
            
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                            </div>
                                <div class="portlet-body flip-scroll">
                                  <table class="table table-striped table-bordered table-hover flip-content" id="sample_3">
                                      <thead>
                                        <tr>
                                          <th> Customer&nbsp;Name </th>
                                          <th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Area &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                        </tr>
                                      </thead>
                                       <tbody>
                                      <?php 
                                           $count_of_customers_not_visited_in_last_30_days=0;
                                         // $myquery="SELECT * FROM tbl_clients where pk_client_id !=  '0' ";
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
                                           AND  tbl_customer_sap_bridge.fk_user_id =  '".$this->session->userdata('userid')."'
										    AND tbl_clients.delete_status = '0'";
                                          // for all values of array
                                          
                                          //echo '<pre>';print_r($visited_client_array);echo '</pre>';exit;
                                          if(!empty($visited_client_array))
                                          {
                                          foreach($visited_client_array as $visited)
                                              {
                                                  $myquery.=" AND tbl_clients.pk_client_id !=  '".$visited."'";
                                              }
                                          }
                                          //echo $myquery;exit;
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
                                           $nq6 = $this->db->query($nq);
                                           if ($nq6->num_rows() == 0){
                                              ?>
                                             <tr class="odd gradeX">
                                                    <td>
                                                         <?php echo $not_visited['client_name'];?>
                                                    </td>  
                                                    <td>
                                                         <?php $maxqu = $this->db->query("SELECT * FROM tbl_area where pk_area_id='".$not_visited['fk_area_id']."' "); 
                                                         $maxval=$maxqu->result_array();echo $maxval[0]['area'];?>
                                                    </td>
                                                    
                                             </tr>
                                        <?php 
                                              $count_of_customers_not_visited_in_last_30_days++;
                                              }
                                          }
                                        }
                                        ?>
                                      </tbody>
                                 </table>
                       </div>
                      </div>
                      <input type="hidden" name="count_of_customers_not_visited_in_last_30_days" value="<?php echo $count_of_customers_not_visited_in_last_30_days;?>" 
                      id="count_of_customers_not_visited_in_last_30_days" />
                      <!-- END EXAMPLE TABLE PORTLET--> 
                    </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<style>
        .redbackgrounclass
        {
            background-color:#F00 !important;
        }
        .redbackgrounclass.greenbackgrounclass
        {
            background-color:#F00 !important;
        }
        .greenbackgrounclass
        {
            background-color:#0F0 !important;
        }
		.blackbackgroundclass
		{
			background:#000 !important; 
			color:#fff; 
			text-align:center;
		}
        </style>
<?php $this->load->view('footer');?>