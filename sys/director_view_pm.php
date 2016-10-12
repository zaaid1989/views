<?php $this->load->view('header');
function pm_frequency($rtz) {
$average_pm_frequency = "N/A";

$days_since_last_pm = "N/A";
//$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$e."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
//$rtz	= 	$tyz->result_array();
$total_pms_c	=	sizeof($rtz);

if ($total_pms_c > 1 ) {
		$max_pms_index		=	$total_pms_c - 1;
		$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
		$last_pm			=	strtotime($rtz[0]['finish_time']);
		$diff				=	$last_pm - $first_pm;
		$total_days			=	floor($diff/(60*60*24));
		$pm_frequency		=	$total_days/$max_pms_index;
		$average_pm_frequency =	$pm_frequency . " days";
		}
		elseif ($total_pms_c == 1 ) {
			$current_date		=	time();
			$last_pm			=	strtotime($rtz[0]['finish_time']);
			$diff				=	$current_date - $last_pm;
			$total_days			=	floor($diff/(60*60*24));
			$average_pm_frequency = "N/A";
		}
		else $average_pm_frequency = "N/A"; 
		echo $average_pm_frequency;
}
?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Director <small>View PM</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home 
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        View PM (Director)                        
                    </li>
                    
                </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
					 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box purple">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa icon-book-open"></i>Director PM View</div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	 <?php
								  if(isset($_GET['msg']))
									{ 
									  echo '<div class="alert alert-success alert-dismissable">  
											  <a class="close" data-dismiss="alert">×</a>  
											  PM Added Successfully.  
											</div>';
									}
									if(isset($_GET['msg_delete']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												PM Deleted Successfully.  
											  </div>';
									  }
								?>
								<div class="note note-active">
								  <h3>
								  <label class="label bg-blue">Note: PM Calls in red indicate the calls that are delayed for over 3 days</label>
								  </h3>
								</div>
                            </div>
                            <div class="portlet-body flip-scroll">
                            <table class="table table-striped table-bordered table-hover flip-content" id="sample_220">
                              <thead class="bg-grey-cascade">
							   <tr>
                                    
                                    <th class="sorting"></th>
                                    <th></th>
					<!--				<th>
                                         Closing Date
                                    </th> -->
                                    
                                    <th></th>
									<!--<th>
										Time Taken
                                         
                                    </th>-->
                                    <th></th>
									<th></th>
									<th></th>
									<th></th>
									
									<th></th>
  
                                   <!-- <th>
                                         Problem Summary
                                    </th>-->
                                    
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                              
							  
                                <tr>
                                    
                                    <th class="sorting">
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
					<!--				<th>
                                         Closing Date
                                    </th> -->
                                    
                                    <th>
                                         Time Elapsed
                                    </th>
									<!--<th>
										Time Taken
                                         
                                    </th>-->
                                    <th>
										 City
									</th>
									<th>
										 Customer
									</th>
								<!--	<th>
										 Area
									</th> -->
									<th>
										Equipment
									</th>
									
									<th>
										 S/No
									</th>
									<th>
                                         Average PM Frequency
                                    </th>
  
                                   <!-- <th>
                                         Problem Summary
                                    </th>-->
                                    
                                    <th>
                                         FSE/SAP
                                    </th>
                                    <th>
                                         Status
                                    </th>
                                    <th>
                                         Actions
                                    </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  function nicetime($date)
										{
											if(empty($date)) {
												return "No date provided";
											}
											$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
											$lengths         = array("60","60","24","7","4.35","12","10");
											$now             = time();
											$unix_date         = strtotime($date);
											   // check validity of date
											if(empty($unix_date)) {   
												return "Bad date";
											}
											// is it future date or past date
											if($now > $unix_date) {   
												$difference     = $now - $unix_date;
												$tense         = "ago";
											} else {
												$difference     = $unix_date - $now;
												$tense         = "from now";
											}
											for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
												$difference /= $lengths[$j];
											}
											$difference = round($difference);
											if($difference != 1) {
												$periods[$j].= "s";
											}
											return "$difference $periods[$j] {$tense}";
										}
										//
										function nicetime2($date, $end_time)
										{
											if(empty($date)) {
												return "No date provided";
											}
											$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
											$lengths         = array("60","60","24","7","4.35","12","10");
											$now             = strtotime($end_time);
											$unix_date         = strtotime($date);
											   // check validity of date
											if(empty($unix_date)) {   
												return "Bad date";
											}
											// is it future date or past date
											if($now > $unix_date) {   
												$difference     = $now - $unix_date;
												$tense         = "ago";
											} else {
												$difference     = $unix_date - $now;
												$tense         = "from now";
											}
											for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
												$difference /= $lengths[$j];
											}
											$difference = round($difference);
											if($difference != 1) {
												$periods[$j].= "s";
											}
											return "$difference $periods[$j] ";//{$tense}
										}
										//end nice time fucntion
										function nicetime_two_parameters($start_date, $end_date)
										{
											
											if(empty($start_date)) {
												return "No date provided";
											}
											$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
											$lengths         = array("60","60","24","7","4.35","12","10");
											$unix_start_date         = strtotime($start_date);
											$unix_end_date   = strtotime($end_date);
											   // check validity of date
											if(empty($unix_start_date)) {   
												return "Bad date";
											}
											// is it future date or past date
											if($unix_end_date > $unix_start_date) {   
												$difference     = $unix_end_date - $unix_start_date;
												$tense         = "";
											} else {
												$difference     = $unix_start_date - $unix_end_date;
												$tense         = "";
											}
											for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
												$difference /= $lengths[$j];
											}
											$difference = round($difference);
											if($difference != 1) {
												$periods[$j].= "s";
											}
											return "$difference $periods[$j] ";//{$tense}
										
										}
										//
										function time_elapsed_string3($start_dat, $end_date, $full) {
											$from_timezone = 'America/New_York';
											$tz1 = new DateTimezone($from_timezone);
											$now = new DateTime($end_date, $tz1);
											$ago = new DateTime($start_dat, $tz1);
											$diff = $now->diff($ago);
											$diff->w = floor($diff->d / 7);
											$diff->d -= $diff->w * 7;
										
											$string = array(
												'y' => 'year',
												'm' => 'month',
												'w' => 'week',
												'd' => 'day',
												'h' => 'hour',
												'i' => 'minute',
												's' => 'second',
											);
											foreach ($string as $k => &$v) {
												if ($diff->$k) {
													$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
												} else {
													unset($string[$k]);
												}
											}
										
											if (!$full) $string = array_slice($string, 0, 1);
											return $string ? implode(', ', $string) . '' : '';
										}
										//
									/*$dbres = $this->db->query("SELECT * FROM tbl_complaints where complaint_nature='PM' AND status NOT IN('Completed','Pending Verification')  order by `pk_complaint_id` DESC");*/
									$dbres = $this->db->query("SELECT tbl_complaints.*, 
									  COALESCE(tbl_cities.city_name) AS city_name,
									  COALESCE(tbl_clients.client_name) AS client_name,
									  COALESCE(tbl_area.area) AS area,
									  COALESCE(user.first_name) AS first_name,
									  COALESCE(tbl_instruments.serial_no) AS serial_no,
									  COALESCE(tbl_products.product_name) AS product_name 
									  
									  FROM tbl_complaints 
									  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
									  LEFT JOIN user ON tbl_complaints.assign_to = user.id
									  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
									  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
									  
									  WHERE tbl_complaints.complaint_nature='PM' AND tbl_complaints.status NOT IN('Completed','Pending Verification') 
									  
									  order by `pk_complaint_id` DESC");
            						$dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
												$date1 = $complaint_list['date'];
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
											  ?>
											  <tr class="
											  <?php //if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}
											  if($diff>86400*3 && $complaint_list['status']!='Completed'){ echo "danger even";} else { echo "odd gradeX";}	
											  ?>
											  ">
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php 
															echo date('d-M-Y',strtotime($complaint_list["date"])); 
													  ?>
												  </td>
                                           <!--       <td> -->
													  <?php  /*
													  	if($complaint_list["status"]=='Closed')
														{
															echo date('d-M-Y',strtotime($complaint_list["solution_date"])); 
														}
														else
														{
															echo 'Not Closed';
														} */
													  ?> 
											<!--	  </td> -->
											
												<td>
                                                      <?php 
													  	if($complaint_list["status"]=='Completed')
														{
															echo "Completed ". nicetime($complaint_list["solution_date"]); 
														}
														else
														{
															echo nicetime($complaint_list["date"]);
														}
													  ?>
												  </td>
												  <!--<td>
                                                      <?php
													  	if($complaint_list["status"]=='Closed')
														{
															echo nicetime_two_parameters($complaint_list["date"],$complaint_list["solution_date"]); 
															//echo time_elapsed_string3($complaint_list["date"],$complaint_list["solution_date"], true);
														}
														else
														{
															echo 'N/A';
														}
													  ?>
												  </td>-->
                                                  
												                                            
                                          <td>
                                              <?php 
                                              echo $complaint_list['city_name']; ?>
                                          </td>
										  <td>
                                              <?php    
												echo $complaint_list['client_name'];
												?>
                                          </td>
											
									<!--	  <td>
										  <?php 
												echo $complaint_list['area'];
												?>
										  </td> -->
										  
										  <td>
                                              <?php 
                                              echo $complaint_list['product_name']; ?>
                                          </td>
                                          <td>
                                              <?php 
											  echo $complaint_list['serial_no'];
											  ?>
                                          </td>

                                                  <td>
												  <?php
												  $tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$complaint_list["fk_instrument_id"]."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
													$rtz	= 	$tyz->result_array();
													pm_frequency($rtz);
												  ?>
												  </td>
                                                  
                                                  <td>
													  <?php 
													  echo $complaint_list['first_name']; ?>
												  </td>
                                          <td>
                                              <?php 
													  $this->load->model("complaint_model");
													  $obj=new Complaint_model();
													  $obj->current_status($complaint_list['status']);
												?>
                                          </td>
                                          <td> <div class="btn-group-vertical btn-group-solid">
                                          <a class="btn btn-sm default blue" 
                                          href="<?php echo base_url();?>sys/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	PM Form &nbsp;
											<i class="fa fa-eye"></i>
                                          </a>
									<?php if($this->session->userdata('userrole')=='Admin') {?>
                                          <a class="btn btn-sm default purple"  
                                            href="<?php echo base_url();?>sys/update_pm/<?php echo $complaint_list["pk_complaint_id"];?>">
											
                                              Update 
											  <i class="fa fa-edit"></i>
                                            </a>
										  
										  <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')" 
                                            href="<?php echo base_url();?>sys/delete_pm/<?php echo $complaint_list["pk_complaint_id"];?>">
                                              Delete <i class="fa fa-trash-o"></i>
                                            </a>
									<?php } ?>
									</div>
                                          </td>
												 
											  </tr>
											  <?php
										  }
									  }
                              ?>
                                
                              </tbody>
                            </table>
                           </div>
                          </div>
                        </div>
                      
					  
						<!-- BEGIN EXAMPLE TABLE PORTLET -->
							
						<div class="portlet box yellow-zed">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa icon-book-open"></i>Director PM (Pending Verification)</div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	
                              
                            </div>
                                      <div class="portlet-body flip-scroll">
                                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_221">
                              <thead class="bg-grey-cascade">
							  
							  <tr>
                                    
                                    <th class="sorting"></th>
                                    <th></th>
					<!--				<th>
                                         Closing Date
                                    </th> -->
                                    
                                    <th></th>
									<!--<th>
										Time Taken
                                         
                                    </th>-->
                                    <th></th>
									<th></th>
									<th></th>
									<th></th>
									
									<th></th>
  
                                   <!-- <th>
                                         Problem Summary
                                    </th>-->
                                    
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                              
                                <tr>
                                    
                                    <th class="sorting">
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
					<!--				<th>
                                         Closing Date
                                    </th> -->
                                    
                                    <th>
                                         Time Elapsed
                                    </th>
									<!--<th>
										Time Taken
                                         
                                    </th>-->
                                    <th>
										 City
									</th>
									<th>
										 Customer
									</th>
							<!--		<th>
										 Area
									</th> -->
									<th>
										Equipment
									</th>
									
									<th>
										 S/No
									</th>
									<th>
                                         Average PM Frequency
                                    </th>
  
                                   <!-- <th>
                                         Problem Summary
                                    </th>-->
                                    
                                    <th>
                                         FSE/SAP
                                    </th>
                                    <th>
                                         Status
                                    </th>
                                    <th>
                                         Actions
                                    </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
										
									/*$dbres = $this->db->query("SELECT * FROM tbl_complaints where complaint_nature='PM' AND status='Pending Verification'  order by `pk_complaint_id` DESC");*/
									$dbres = $this->db->query("SELECT tbl_complaints.*, 
									  COALESCE(tbl_cities.city_name) AS city_name,
									  COALESCE(tbl_clients.client_name) AS client_name,
									  COALESCE(tbl_area.area) AS area,
									  COALESCE(user.first_name) AS first_name,
									  COALESCE(tbl_instruments.serial_no) AS serial_no,
									  COALESCE(tbl_products.product_name) AS product_name 
									  
									  FROM tbl_complaints 
									  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
									  LEFT JOIN user ON tbl_complaints.assign_to = user.id
									  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
									  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
									  
									  WHERE tbl_complaints.complaint_nature='PM' AND tbl_complaints.status ='Pending Verification' 
									  
									  order by `pk_complaint_id` DESC");
            						$dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
												$date1 = $complaint_list['date'];
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
											  ?>
											  <tr class="
											  <?php //if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}
											  if($diff>86400*3 && $complaint_list['status']!='Completed'){ echo "danger even";} else { echo "odd gradeX";}	
											  ?>
											  ">
                                                  <td>
													  <?php echo $complaint_list["ts_number"]; ?>
												  </td>
												  <td>
													  <?php 
															echo date('d-M-Y',strtotime($complaint_list["date"])); 
													  ?>
												  </td>
                                           <!--       <td> -->
													  <?php  /*
													  	if($complaint_list["status"]=='Closed')
														{
															echo date('d-M-Y',strtotime($complaint_list["solution_date"])); 
														}
														else
														{
															echo 'Not Closed';
														} */
													  ?> 
											<!--	  </td> -->
											
												<td>
                                                      <?php 
													  	if($complaint_list["status"]=='Completed')
														{
															echo "Completed ". nicetime($complaint_list["solution_date"]); 
														}
														else
														{
													  		//echo nicetime2($complaint_list["date"],$complaint_list["finish_time"]); // changed by sanaullah 18-8-2015
															echo nicetime($complaint_list["date"]); 
														}
													  ?>
												  </td>
												  <!--<td>
                                                      <?php
													  	if($complaint_list["status"]=='Completed')
														{
															echo nicetime_two_parameters($complaint_list["date"],$complaint_list["solution_date"]); 
															//echo time_elapsed_string3($complaint_list["date"],$complaint_list["solution_date"], true);
														}
														else
														{
															echo 'N/A';
														}
													  ?>
												  </td>-->
                                                  
												                                            
                                           <td>
                                              <?php 
                                              echo $complaint_list['city_name']; ?>
                                          </td>
										  <td>
                                              <?php    
												echo $complaint_list['client_name'];
												?>
                                          </td>
											
									<!--	  <td>
										  <?php 
												echo $complaint_list['area'];
												?>
										  </td> -->
										  
										  <td>
                                              <?php 
                                              echo $complaint_list['product_name']; ?>
                                          </td>
                                          <td>
                                              <?php 
											  echo $complaint_list['serial_no'];
											  ?>
                                          </td>


                                                  <td>
													  <?php
												  $tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$complaint_list["fk_instrument_id"]."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
													$rtz	= 	$tyz->result_array();
													pm_frequency($rtz);
												  ?>
												  </td>
                                                  
                                                  <td>
													  <?php 
													  echo $complaint_list['first_name']; ?>
												  </td>
                                          <td>
                                              <?php 
													  $this->load->model("complaint_model");
													  $obj=new Complaint_model();
													  $obj->current_status($complaint_list['status']);
												?>
                                          </td>
                                          <td><div class="btn-group-vertical btn-group-solid">
                                          <a class="btn btn-sm default blue" 
                                          href="<?php echo base_url();?>sys/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	PM Form &nbsp;
											<i class="fa fa-eye"></i>
                                          </a>
										<?php if($this->session->userdata('userrole')=='Admin') {?>  
										  <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')" 
                                            href="<?php echo base_url();?>sys/delete_pm/<?php echo $complaint_list["pk_complaint_id"];?>">
                                              Delete <i class="fa fa-trash-o"></i>
                                            </a>
										<?php } ?>
										</div>
                                          </td>
												 
											  </tr>
											  <?php
										  }
									  }
                              ?>
                                
                              </tbody>
                            </table>
                           </div>
                          </div>
                        </div>
					  
					  
						<!-- BEGIN EXAMPLE TABLE PORTLET -->
                        
                        <div class="portlet box purple">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa icon-book-open"></i>Director PM (Completed)</div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	
                              
                            </div>
                      	<div class="portlet-body flip-scroll">
                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_222">
                              <thead class="bg-grey-cascade">
                                <tr>
                                    
                                    <th class="sorting">
                                    </th>
                                    <th>
                                    </th>
					<!--				<th>
                                         Closing Date
                                    </th> -->
                                    
                                    <th>
                                    </th>
									<th>
                                    </th>
                                    <th>
									</th>
									<th>
									</th>
									<th>
									</th>
									<th>
									</th>
									
									<th>
									</th>
                                   <!-- <th>
                                         Problem Summary
                                    </th>-->
                                    <th>
                                    </th>
                                    <th>
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                              <tr>
                                    
                                    <th class="sorting">
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
					<!--				<th>
                                         Closing Date
                                    </th> -->
                                    
                                    <th>
                                         Time Elapsed
                                    </th>
									<th>
										Time Taken
                                         
                                    </th>
                                    <th>
										 City
									</th>
									<th>
										 Customer
									</th>
							<!--		<th>
										 Area
									</th> -->
									<th>
										Equipment
									</th>
									
									<th>
										 S/No
									</th>
									<th>
                                         Average PM Frequency
                                    </th>
                                   <!-- <th>
                                         Problem Summary
                                    </th>-->
                                    
                                    <th>
                                         FSE/SAP
                                    </th>
									
                                    <th>
                                         Status
                                    </th>
                                    <th>
                                         Actions
                                    </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
										
									// $dbres = $this->db->query("SELECT * FROM tbl_complaints where complaint_nature='PM' AND status='Completed'  order by `pk_complaint_id` DESC");
									$dbres = $this->db->query("SELECT tbl_complaints.*, 
									  COALESCE(tbl_cities.city_name) AS city_name,
									  COALESCE(tbl_clients.client_name) AS client_name,
									  COALESCE(tbl_area.area) AS area,
									  COALESCE(user.first_name) AS first_name,
									  COALESCE(tbl_instruments.serial_no) AS serial_no,
									  COALESCE(tbl_products.product_name) AS product_name 
									  
									  FROM tbl_complaints 
									  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
									  LEFT JOIN user ON tbl_complaints.assign_to = user.id
									  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
									  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
									  
									  WHERE tbl_complaints.complaint_nature='PM' AND tbl_complaints.status ='Completed' 
									  
									  order by `pk_complaint_id` DESC");
            						$dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
												$date1 = $complaint_list['date'];
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
											  ?>
											  <tr class="
											  <?php //if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}
											  if($diff>86400*3 && $complaint_list['status']!='Completed'){ echo "danger even";} else { echo "odd gradeX";}	
											  ?>
											  ">
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php 
															echo date('d-M-Y',strtotime($complaint_list["date"])); 
													  ?>
												  </td>
                                                  <td> 
													  <?php  
													  	if($complaint_list["status"]=='Completed')
														{
															echo "Completed ". nicetime($complaint_list["solution_date"]); 
														}
														else
														{
															echo nicetime($complaint_list["date"]);
														}
													  ?> 
												  </td> 
											
												  <td>
                                                      <?php
													  	if($complaint_list["status"]=='Completed')
														{
															echo nicetime_two_parameters($complaint_list["date"],$complaint_list["finish_time"]); 
															//echo time_elapsed_string3($complaint_list["date"],$complaint_list["solution_date"], true);
														}
														else
														{
															echo 'N/A';
														}
													  ?>
												  </td>
                                                  
												                                            
                                          <td>
                                              <?php 
                                              echo $complaint_list['city_name']; ?>
                                          </td>
										  <td>
                                              <?php    
												echo $complaint_list['client_name'];
												?>
                                          </td>
											
									<!--	  <td>
										  <?php 
												echo $complaint_list['area'];
												?>
										  </td> -->
										  
										  <td>
                                              <?php 
                                              echo $complaint_list['product_name']; ?>
                                          </td>
                                          <td>
                                              <?php 
											  echo $complaint_list['serial_no'];
											  ?>
                                          </td>

                                                  <td>
													  <?php
												  $tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$complaint_list["fk_instrument_id"]."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
													$rtz	= 	$tyz->result_array();
													pm_frequency($rtz);
												  ?>
												  </td>
                                                  
                                                  <td>
													  <?php 
													  echo $complaint_list['first_name']; ?>
												  </td>
                                          <td>
                                              <?php 
													  $this->load->model("complaint_model");
													  $obj=new Complaint_model();
													  $obj->current_status($complaint_list['status']);
												?>
                                          </td>
                                          <td><div class="btn-group-vertical btn-group-solid">
                                          <a class="btn btn-sm default blue" 
                                          href="<?php echo base_url();?>sys/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	PM Form &nbsp;
											<i class="fa fa-eye"></i>
                                          </a>
										  <?php if($this->session->userdata('userrole')=='Admin') {?>
										  <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')" 
                                            href="<?php echo base_url();?>sys/delete_pm/<?php echo $complaint_list["pk_complaint_id"];?>">
                                              Delete <i class="fa fa-trash-o"></i>
                                            </a>
										  <?php } ?>
										  </div>
                                          </td>
												 
											  </tr>
											  <?php
										  }
									  }
                              ?>
                                
                              </tbody>
                            </table>
                           </div>
                          </div>
                        </div>
					  </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer');?>
		
<script> 
		 $(document).ready(function() { 
			var table = $('#sample_220').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
								{ type: "text" },
								{ type: "text" },
                                { type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
		var table2 = $('#sample_221').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
								{ type: "text" },
								{ type: "text" },
                                { type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
		var table3 = $('#sample_222').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
								{ type: "text" },
								{ type: "text" },
                                { type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
		var table4 = $('#sample_225').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
								{ type: "text" },
								{ type: "text" },
                                { type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
});

</script>