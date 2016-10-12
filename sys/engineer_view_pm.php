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
                    Engineer <small>Preventive Maintenance</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Preventive Maintenance
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue-madison">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Engineer PM View </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Complaint Added Successfully.  
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
                            <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                    
                                    <th>
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
                                    <th>
                                         Time Elapsed
                                    </th>
                                    							
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
										 Avergae PM Frequency
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
									return "$difference $periods[$j]";// {$tense};
								}
								
							/*	$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to='".$this->session->userdata('userid')."' 
														   AND complaint_nature='PM' AND status NOT IN ('Completed','Pending Verification') order by `pk_complaint_id` DESC"); */
														   
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
									  
									  WHERE assign_to='".$this->session->userdata('userid')."' AND tbl_complaints.complaint_nature='PM' AND tbl_complaints.status NOT IN('Completed','Pending Verification') 
									  
									  order by `pk_complaint_id` DESC");
							
								$dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
												$date1 = $complaint_list['date'];
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
											  ?>
											  <tr class="<?php
												if($diff>86400*3 && $complaint_list['status']!='Completed'){ echo "danger even";} else { echo "odd gradeX";}											  
											  ?>">
												  
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
														<?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>										  
												  </td>
                                                  <td>
													  <?php 
													  echo nicetime($complaint_list["date"]);
													  //echo date("H:i", strtotime($complaint_list["date"])); ?>
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
													$this->load->model("complaint_model");
													$obj=new Complaint_model();
													$obj->current_status($complaint_list['status']);
												  ?>
												  </td>												  
                                                                                                 
                                                  											  
                                                  <?php if($this->session->userdata('userrole')=='Supervisor'){?>                                                
                                                  <td>
													  <a class="btn btn-default blue-madison-stripe" href="<?php echo base_url();?>sys/s_pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>">PM Form</a>
												  </td>
                                                  <?php } else {?>
                                                   <td>
													  <a class="btn btn-default blue-madison-stripe" href="<?php echo base_url();?>sys/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>">PM Form</a>
												  </td>
                                                  <?php } ?>
                                                   
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
                        
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box yellow-zed">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Engineer PM (Pending Verification) </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                              
                            </div>
                      		<div class="portlet-body flip-scroll">
                            <table class="table table-striped table-bordered table-hover flip-content" id="sample_20">
                              <thead>
                                <tr>
                                    
                                    <th>
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
                                    <th>
                                         Time Elapsed
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
										 Avergae PM Frequency
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
								//
							/*	$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to='".$this->session->userdata('userid')."' AND complaint_nature='PM' AND status='Pending Verification' order by `pk_complaint_id` DESC"); */
								
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
									  
									  WHERE assign_to='".$this->session->userdata('userid')."' AND tbl_complaints.complaint_nature='PM' AND tbl_complaints.status IN('Pending Verification') 
									  
									  order by `pk_complaint_id` DESC");
							
								$dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
												$date1 = $complaint_list['date'];
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
											  ?>
											  <tr class="<?php
												if($diff>86400*3 && $complaint_list['status']!='Completed'){ echo "danger even";} else { echo "odd gradeX";}											  
											  ?>">
												  
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
														<?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>										  
												  </td>
                                                  <td>
													  <?php 
													  echo nicetime($complaint_list["date"]);
													  //echo date("H:i", strtotime($complaint_list["date"])); ?>
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
													$this->load->model("complaint_model");
													$obj=new Complaint_model();
													$obj->current_status($complaint_list['status']);
												  ?>
												  </td>												  
                                                                                                 
                                                  											  
                                                  <?php if($this->session->userdata('userrole')=='Supervisor'){?>                                                
                                                  <td>
													  <a href="<?php echo base_url();?>sys/s_pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>" 
                                                      class="btn btn-default blue-madison-stripe" >
                                                      	PM Form
                                                      </a>
												  </td>
                                                  <?php } else {?>
                                                   <td>
													  <a href="<?php echo base_url();?>sys/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>" 
                                                      class="btn btn-default blue-madison-stripe">
                                                      	PM Form
                                                      </a>
												  </td>
                                                  <?php } ?>
                                                   
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
                      
					  
					  <!-- zzzzzz -->
					  
					   <div class="portlet box blue-madison">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Engineer PM View (Completed: Last 30 Days) </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                              
                            </div>
                      		<div class="portlet-body flip-scroll">
                            <table class="table table-striped table-bordered table-hover flip-content" id="sample_21">
                              <thead>
                                <tr>
                                    
                                    <th>
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
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
										 Avergae PM Frequency
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
								
							/*	$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to='".$this->session->userdata('userid')."' AND complaint_nature='PM' AND status='Completed' AND CAST(`finish_time` AS DATE) BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");// */
								
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
									  
									  WHERE assign_to='".$this->session->userdata('userid')."' AND tbl_complaints.complaint_nature='PM' AND tbl_complaints.status IN('Completed') 
									  
									  order by `pk_complaint_id` DESC");
							
								$dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
												$date1 = $complaint_list['date'];
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
											  ?>
                                        <tr class="<?php
                                          if($diff>86400*3 && $complaint_list['status']!='Completed'){ echo "danger even";} else { echo "odd gradeX";}											  
                                        ?>">
												  
                                          <td>
                                              <?php echo $complaint_list["ts_number"] ?>
                                          </td>
                                          <td>
                                                <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>										  
                                          </td>
                                          
                                          <td>
											  <?php 
                                                if($complaint_list["status"]=='Completed')
                                                {
                                                    echo "Completed ". nicetime($complaint_list["finish_time"]); 
                                                }
                                                else
                                                {
                                                    echo nicetime($complaint_list["date"]);
                                                }
                                              ?>
                                          </td>
                                          <td>
                                              <?php 
                                              echo nicetime2($complaint_list["date"],$complaint_list["finish_time"]); ?>
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
													$this->load->model("complaint_model");
													$obj=new Complaint_model();
													$obj->current_status($complaint_list['status']);
												  ?>
												  </td>												  
                                                                                                 
                                                  											  
                                                  <?php if($this->session->userdata('userrole')=='Supervisor'){?>                                                
                                                  <td>
													  <a href="<?php echo base_url();?>sys/s_pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>" 
                                                      class="btn btn-default blue-madison-stripe" >
                                                      	PM Form
                                                      </a>
												  </td>
                                                  <?php } else {?>
                                                   <td>
													  <a href="<?php echo base_url();?>sys/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>" 
                                                      class="btn btn-default blue-madison-stripe" >
                                                      	PM Form
                                                      </a>
												  </td>
                                                  <?php } ?>
                                                   
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
  
					  <!-- zzzzzz -->
					  </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer');?>