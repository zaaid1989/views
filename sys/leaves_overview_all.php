<?php $this->load->view('header.php');?>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Leaves Statistics</h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
              <li> Leaves Statistics </li>
            </ul>
            
          </div>
          <!-- END PAGE HEADER--> 
          <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet box purple">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-eyeglasses"></i>Leaves Statistics </div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
                <div class="portlet-body">
                  <div class="table-toolbar">
                    <div class="row">
                      
                      
                    </div>
                  </div>
                  <div class="font-red-sunglo" style="text-align:center; font-size:20px; font-weight:bold;">Leaves are Counted From 1st July To 30th June of Pakistan Financial Year</div>
                  <div class="portlet-body flip-scroll">
                   <table class="table table-bordered table-hover flip-content bg-grey" id="sample_2">
                    <thead>
                      <tr>
                        <th class="bg-grey-gallery"> Employee Name 		</th>
                       <!-- <th class="bg-grey-gallery"> Designation	</th> -->
						<th class="bg-grey-gallery"> Join Date 		</th>
						<th class="bg-grey-gallery"> Work Months 		</th>
						<th class="bg-grey-gallery"> Leaves Allowed </th>
                        
                        <th class="bg-grey-gallery"> Jul </th>
						<th class="bg-grey-gallery"> Aug </th>
						<th class="bg-grey-gallery"> Sep </th>
						<th class="bg-grey-gallery"> Oct </th>
						<th class="bg-grey-gallery"> Nov </th>
						<th class="bg-grey-gallery"> Dec </th>
						<th class="bg-grey-gallery"> Jan </th>
						<th class="bg-grey-gallery"> Feb </th>
						<th class="bg-grey-gallery"> Mar </th>
						<th class="bg-grey-gallery"> Apr </th>
						<th class="bg-grey-gallery"> May </th>
						<th class="bg-grey-gallery"> Jun </th>

                        
                        <th class="bg-grey-gallery"> Total Leaves Availed </th>
						<th class="bg-grey-gallery"> Balance </th>
                        <th class="bg-grey-gallery"> Average Monthly Leaves </th>
                      <!--  <th class="bg-grey-gallery"> Monthly Leaves Percentage </th>
                        <th class="bg-grey-gallery"> Overall Leaves Percentage </th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                            $myquery="select * from user WHERE `delete_status`='0' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
							$ty22=$this->db->query($myquery);
                            $rt22=$ty22->result_array();
                                foreach ($rt22 as $get_users_list) {
									
									$start_month	=	7; // July
											 $available_leaves	=	21;
											 $leaves_per_month	=	$available_leaves/12;
											 $working_months_current_year	=	12; ////////////total months  for which leaves will be given
											 $current_month	=	date('m');
											 $current_year	=	date('Y');
											 $previous_year	=	date('Y')-1;
											 $join_date		= 	$get_users_list["date_of_joining"];
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
                                    ?>
                                    <tr class="odd gradeX">
                                        
                                        <td>
                                            <?php 
											echo $get_users_list["first_name"];
											?>
                                        </td>
                                    <!--    <td>
                                            <?php 
											echo $get_users_list["office_designation"];
											?>
                                        </td> -->
                                        <td>
                                            <?php 
											echo date('d-M-Y',strtotime($get_users_list["date_of_joining"]));
											?>
                                        </td>
										<td>
                                            <?php 
											echo $working_months_current_year;
											?>
                                        </td>
                                        
										<td style="text-align:center;">
                                             <?php
											echo $available_leaves;
											 ?>                                           
                                        </td>
                                       
                                        <?php 
										$current_month	=	date('m');
                                        $current_year	=	date('Y');
                                        if($current_month < 7)
									    {
										$last_year = $current_year - 1;
										$start_date = $last_year.'-07-01';
										
										$end_date = $current_year.'-06-30';
										
									    } else {
							
										$next_year = $current_year + 1;
										$start_date = $current_year.'-07-01';
										$end_date = $next_year.'-06-30';
										
									    }
										$leaves_query='SELECT start_date,end_date,leave_type FROM `tbl_leaves` WHERE fk_employee_id = "'.$get_users_list['id'].'" and start_date >= "'.$start_date.'" and end_date <= "'.$end_date.'" ';
										$leaves_result = $this->db->query($leaves_query);
										$leaves_loop = $leaves_result->result_array();
										$jan=0; $feb=0; $mar=0; $apr=0; $may=0; $jun=0; $july=0; $aug=0; $sep=0; $oct=0; $nov=0; $dec=0; $sundays=0;$checkforbeginday=0;
									   
									    $today = date("Y-m-d"); // Get today date
										$diff = abs(strtotime($today) - strtotime($start_date)); //Difference between today and startdate
										$years = floor($diff / (365*60*60*24)); //calculate total years
										$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); // calculate total months
										
										foreach ($leaves_loop as $leaves) {
											$begintime = $leaves["start_date"]; // Check start date of leave
                                            $endtime = $leaves["end_date"];   // Check end date of leave
											$leavetype = $leaves['leave_type']; // Check whether half leave or full day leave
											$beginmonth = date('m',strtotime($begintime));  // Check starting month. We need this because if different from end month then we need to calculate days of each month
											$endmonth = date('m',strtotime($endtime)); // Check End Month
										
											$totalmonthdays = date('t',strtotime($begintime));  // Check how many days are there in starting month
											
											if($beginmonth == $endmonth && $leavetype == 0) { // Check if both are same and full day leave required
                                             $weekdaycheck = date('N',strtotime($begintime)); // Check which day is the starting day. 1 is for Monday and 7 is for Sunday
										     $days = floor(abs(strtotime($endtime) - strtotime($begintime))/(60*60*24)); // Total days to between end date and start date
											 $sundays = intval($days / 7) + ($weekdaycheck + $days % 7 >= 7); // Check how many sundays are there
											
											
											 if($beginmonth==1) { $jan += ($days + 1) - $sundays; }
											 
											 if($beginmonth==2) { $feb += ($days + 1) - $sundays; }
											 
											 if($beginmonth==3) {$mar += ($days + 1) - $sundays; }
											 
											 if($beginmonth==4) {$apr += ($days + 1) - $sundays; }
											 
											 if($beginmonth==5) {$may += ($days + 1) - $sundays; }
											 
											 if($beginmonth==6) {$jun += ($days + 1) - $sundays; }
											 
											 if($beginmonth==7) {$july += ($days + 1) - $sundays;}
											 
											 if($beginmonth==8) {$aug += ($days + 1) - $sundays;}
											 
											 if($beginmonth==9) { $sep += ($days + 1) - $sundays; }
											 
											 if($beginmonth==10) {$oct += ($days + 1) - $sundays; }
											 
											 if($beginmonth==11) {$nov += ($days + 1) - $sundays; }
											 
											 if($beginmonth==12) { $dec += ($days + 1) - $sundays;}
											 
											 
											 }
											  
											 if($beginmonth == $endmonth && $leavetype == 1) { // Check if both are same and half day leave required
                                              $days = floor(abs(strtotime($endtime) - strtotime($begintime))/(60*60*24));
											 if($beginmonth==1) {$jan += $days + 0.5; }
											 
											 if($beginmonth==2) {$feb += $days + 0.5; }
											 
											 if($beginmonth==3) {$mar += $days + 0.5; }
											 
											 if($beginmonth==4) { $apr += $days + 0.5; }
											 
											 if($beginmonth==5) { $may += $days + 0.5;}
											 
											 if($beginmonth==6) {$jun += $days + 0.5; }
											 
											 if($beginmonth==7) {$july += $days + 0.5; }
											 
											 if($beginmonth==8) {$aug += $days + 0.5;}
											 
											 if($beginmonth==9) {$sep += $days + 0.5; }
											 
											 if($beginmonth==10) {$oct += $days + 0.5;}
											 
											 if($beginmonth==11) { $nov += $days + 0.5; }
											 
											 if($beginmonth==12) { $dec += $days + 0.5;}
											 
											 
											 }
											 
											 
											 if($beginmonth != $endmonth) { // Check if start and end month are not same
												  
												  $begindate = date('d',strtotime($begintime)); //// Check for begin date. It returns just number not full date
												  $lastdayofmonth = date('Y-m-t', strtotime($begintime)); // Check for last date of month
												  $weekdaycheck = date('N',strtotime($begintime)); // Check for weekday
												  $days = floor(abs(strtotime($lastdayofmonth) - strtotime($begintime))/(60*60*24)); 
												  $sundays = intval($days / 7) + ($weekdaycheck + $days % 7 >= 7);
												  
												 
												  if($beginmonth == 1) {$jan += (($totalmonthdays- $begindate)+1)-$sundays; }
												  if($beginmonth == 2) {$feb += (($totalmonthdays- $begindate)+1)-$sundays;}
												  if($beginmonth == 3) {$mar += (($totalmonthdays- $begindate)+1)-$sundays;}
												  if($beginmonth == 4) { $apr += (($totalmonthdays- $begindate)+1)-$sundays;}
												  if($beginmonth == 5) {$may += (($totalmonthdays- $begindate)+1)-$sundays;}
												  if($beginmonth == 6) {$jun += (($totalmonthdays- $begindate)+1)-$sundays;}
												   if($beginmonth == 7) {$july += (($totalmonthdays- $begindate)+1)-$sundays;}
												   if($beginmonth == 8) { $aug += (($totalmonthdays- $begindate)+1)-$sundays; }
												  if($beginmonth == 9) {$sep += (($totalmonthdays- $begindate)+1)-$sundays; }
												  if($beginmonth == 10) { $oct += (($totalmonthdays- $begindate)+1)-$sundays; }
												  if($beginmonth == 11) { $nov += (($totalmonthdays- $begindate)+1)-$sundays; }
												   if($beginmonth == 12) {$dec += (($totalmonthdays- $begindate)+1)-$sundays;}
												
												 
												  $enddate = date('d',strtotime($endtime)); /*Check for EndMonth and start counting for end month days*/
												  $firstdayofmonth = date('Y-m-01',strtotime($endtime)); // Calculate first date of month
												  $weekdaycheck = date('N',strtotime($firstdayofmonth));
												  $days = floor(abs(strtotime($endtime) - strtotime($firstdayofmonth))/(60*60*24));
												  $sundays = intval($days / 7) + ($weekdaycheck + $days % 7 >= 7);
												  
												  if($endmonth == 1) {
													   $jan += ($days +1) - $sundays; 
													 }
												  if($endmonth == 2) {
													   $feb += ($days +1) - $sundays; 
													 }
													  if($endmonth == 3) {
														$mar +=($days +1) - $sundays; 
													  }
													  if($endmonth == 4) {
													   $apr += ($days +1) - $sundays; 
													  }
													  if($endmonth == 5) {
													   $may += ($days +1) - $sundays; 
													   }
													  if($endmonth == 6) {
													   $jun += ($days +1) - $sundays; 
													  }
													  if($endmonth == 7) {
													   $july += ($days +1) - $sundays; 
													  }
													  if($endmonth == 8) {
													    $aug += ($days +1) - $sundays; 
													  }
													  if($endmonth == 9) {
													   $sep += ($days +1) - $sundays; 
													  }
													  if($endmonth == 10) {
													   $oct += ($days +1) - $sundays; 
													  }
													  if($endmonth == 11) {
													   $nov += ($days +1) - $sundays;  
													  }
													  if($endmonth == 12) {
													   $dec += ($days +1) - $sundays;  
													  }
												 
												 
												 }

											
											 } 
											 
								         ?>
                                        
                                         <td>
                                            <?php 
											echo $july;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $aug;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $sep;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $oct;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $nov;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $dec;
											?>
                                        </td>
                                        <td>
                                            <?php 
											echo $jan;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $feb;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $mar;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $apr;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $may;
											?>
                                        </td>
                                         <td>
                                            <?php 
											echo $jun;
											?>
                                        </td>
                                        
                                        
                                        <td style="text-align:center;">
                                             <?php 
												if($get_users_list["total_leaves"] > $available_leaves)
												{
													?>
														<div class="pulsate-regular" style="margin:0 30px;"><?php  echo $get_users_list["total_leaves"];?></div>
													<?php
												}
												else
												{
													echo $get_users_list["total_leaves"];
												}
											 ?>
                                             
                                        </td>
										<td style="text-align:center;">
                                             <?php
											if($get_users_list["total_leaves"] > $available_leaves)
												{
													?>
														<div class="pulsate-regular" style="margin:0 30px;"><?php  echo $available_leaves - $get_users_list["total_leaves"];?></div>
													<?php
												}
												else
												{
													echo $available_leaves - $get_users_list["total_leaves"];
												}
											 ?>                                           
                                        </td>
                                        <td style="text-align:center;">
                                             <?php
											$totalmonthleaves = $jan+$feb+$mar+$apr+$may+$jun+$july+$aug+$sep+$oct+$nov+$dec;
											if ($months!=0)
												$monthlyavg = $totalmonthleaves/$months;
											else
												$monthlyavg = 0;
											
											echo number_format((float)$monthlyavg, 2, '.', ''); // Output Monthly Average
											 ?>                                           
                                        </td>
                                        
                              <!--          <td style="text-align:center;">
                                             <?php
											$totalmonthleaves = $jan+$feb+$mar+$apr+$may+$jun+$july+$aug+$sep+$oct+$nov+$dec;
											$per = (($totalmonthleaves/$available_leaves)/$months)*100;
											$roundper = number_format((float)$per, 2, '.', ''); 
											echo $roundper."%";    // Output Monthly percentage. Not sure whether I am calculating right but What Ayesha told me I have done here.
											
											 ?>                                           
                                        </td>
                                        
                                         <td style="text-align:center;">
                                             <?php
											$totalmonthleaves = $jan+$feb+$mar+$apr+$may+$jun+$july+$aug+$sep+$oct+$nov+$dec;
											$peroverall = ($totalmonthleaves/$available_leaves)*100;
											$roundperoverall = number_format((float)$peroverall, 2, '.', ''); 
											echo $roundperoverall."%";  // Overall leaves percentage
											
											 ?>                                           
                                        </td>-->
                                    </tr>
                                    <?php
                                }
                    ?>
                      
                    </tbody>
                  </table>
                            </div>
                </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET--> 
            </div>
          </div>
          <!-- END PAGE CONTENT-->
          
          
      </div>
  </div>
  <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer.php');?>