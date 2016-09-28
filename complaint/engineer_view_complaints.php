<?php $this->load->view('header');
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
?>
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
            Engineer <small>View Complaints</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        Engineer Complaints
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
                    <div class="caption"> <i class="fa fa-globe"></i>Engineer Complaints View </div>
                    <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
                  </div>
                  <div class="portlet-body">
                    <div class="table-toolbar">
                        <?php
                            if(isset($_GET['msg']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        '.$_GET['msg'].'  
                                      </div>';
                              }
					  ?>
                    </div>
					
               		<div class="portlet-body flip-scroll">
                     <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                      <thead>
                        <tr>
                            <th class="table-checkbox">
                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                            </th>
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
                      <!--      <th>
                                 Area
                            </th> -->
                            
                            <th>
                                 Equipment
                            </th>
                            
                            <th>
                                 S/No
                            </th>
                            <th>
                                 Problem Summary
                            </th>
                            <th>
                                 Status
                            </th>
                            
                            <th>
                                Actions
                            </th>
							<th>
								Comments
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


						/*	$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to='".$this->session->userdata('userid')."' AND complaint_nature='complaint'  
							AND 
							status NOT IN ('Pending Verification', 'Closed','Pending Registration')
							order by `pk_complaint_id` DESC"); */
							
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
									  
									  WHERE assign_to='".$this->session->userdata('userid')."' AND tbl_complaints.complaint_nature='complaint' AND tbl_complaints.status NOT IN ('Pending Verification','Pending SPRF', 'Closed','Pending Registration') 
									  
									  order by `pk_complaint_id` DESC");
							
							$dbresResult=$dbres->result_array();



                              if (sizeof($dbresResult) == "0") 
                              {
                                //do somthing  
                              } else {
                                  foreach ($dbresResult as $complaint_list) {
                                      ?>
                                      <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                          <th class="table-checkbox">
                                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                            </th>
                                          <td>
                                              <?php echo $complaint_list["ts_number"] ?>
                                          </td>
                                          <td>
                                              <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
                                          </td>
                                          <td>
                                              <?php 
                                                //$nowtime = strtotime(date('Y-m-d H:i:s'));
                                                echo nicetime($complaint_list["date"]);
                                                //echo time_elapsed_B($nowtime - strtotime($complaint_list["date"]));
                                              //echo $complaint_list["date"] ?>
                                          </td>
                                          
                                         <td>
                                              <?php 
                                              
                                              echo $complaint_list["city_name"]; ?>
                                          </td>
										  <td>
                                              <?php    
												
												echo $complaint_list["client_name"];
												?>
                                          </td>
											
								<!--		  <td>
										  <?php 
												
												echo $complaint_list["area"];
												?>
										  </td> -->
										  
										  <td>
                                              <?php 
                                              echo $complaint_list["product_name"]; ?>
                                          </td>
                                          <td>
                                              <?php 
											  echo $complaint_list["serial_no"];
											  ?>
                                          </td>

                                          <td>
                                              <?php echo substr($complaint_list["problem_summary"], 0, 30); ?>
                                          </td>
                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											$obj->current_status($complaint_list['status']);
										  ?>
                                          </td>
                                          <td>
										  <div class="btn-group-vertical btn-group-solid">
                                          <a class="btn btn-default green-haze" 
                                          href="<?php echo base_url();?>complaint/technical_service_pvr/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	 TSR
                                          </a>
                                          
                                          <?php if($complaint_list["problem_type"]=='equipment' || $complaint_list["status"]=='Pending (BB)') {?>
                                          <a class="btn btn-default green-haze-stripe" 
                                              href="<?php echo base_url();?>products/sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                              	SPRF
                                          </a>
                                          <?php }?>
                                          </div>
                                          </td>
										  
										  <?php
												$userid		=	$this->session->userdata('userid');
												$userrole	=	$this->session->userdata('userrole');
												$complaint_id =	$complaint_list["pk_complaint_id"];
												$count_msgs	=	0;
												$count_msgs_r	=	0;
												$countfield	=	'read_director';
												
												
												if($userrole=='Admin') $countfield = 'read_director';
												if($userrole=='secratery') $countfield = 'read_secratery';
												if($userrole=='Supervisor') $countfield = 'read_supervisor';
												if($userrole=='FSE' || $userrole=='Salesman') $countfield = 'read_employee';
												
												$cq			=	"select * from tbl_comments where `fk_complaint_id`='".$complaint_id."' AND `".$countfield."`=0";
												$cr			=	$this->db->query($cq);
												$count_msgs	=	sizeof($cr->result_array());
												
												$cq			=	"select * from tbl_comments where `fk_complaint_id`='".$complaint_id."'";
												$cr			=	$this->db->query($cq);
												$count_msgs_r	=	sizeof($cr->result_array());
												
												$cq			=	"select * from tbl_dvr where `fk_complaint_id`='".$complaint_id."'";
												$cr			=	$this->db->query($cq);
												$count_msgs_r	+=	sizeof($cr->result_array());
											?>	
										  
										  <td>
										  <a class="icon-btn" 
                                          href="<?php echo base_url();?>complaint/comments/<?php echo $complaint_list["pk_complaint_id"] ?>">                                         	
											<i class="fa fa-comments-o"></i>
											<div>Comments</div>
											<?php if ($count_msgs>0) {?>
												<span class="badge bg-blue">
												<?php echo $count_msgs; ?>
												</span>
											<?php } ?>
											<?php if ($count_msgs==0 && $count_msgs_r>0) {?>
												<span class="badge bg-grey-cascade">
												<?php echo $count_msgs_r; ?>
												</span>
											<?php } ?>
                                          </a>
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
                
                <!-- BEGIN EXAMPLE TABLE PORTLET Pending Verification-->
                <div class="portlet box yellow-zed">
                  <div class="portlet-title">
                    <div class="caption"> <i class="fa fa-globe"></i>Engineer Complaints (Pending Verification) </div>
                    <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
                  </div>
                  <div class="portlet-body">
                    <div class="table-toolbar">
                        
                    </div>
					
               		<div class="portlet-body flip-scroll">
                     <table class="table table-striped table-bordered table-hover flip-content" id="sample_21">
                      <thead>
                        <tr>
                            <th class="table-checkbox">
                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                            </th>
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
                     <!--       <th>
                                 Area
                            </th> -->
                            
                            <th>
                                 Equipment
                            </th>
                            
                            <th>
                                 S/No
                            </th>
                            <th>
                                 Problem Summary
                            </th>
                            <th>
                                 Status
                            </th>
                            
                            <th>
                                Actions
                            </th>
							<th>
								Comments
							</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
					/*	$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to='".$this->session->userdata('userid')."' AND complaint_nature='complaint'  
						AND 
						status IN ('Pending Verification')
						order by `pk_complaint_id` DESC"); */
						
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
									  
									  WHERE assign_to='".$this->session->userdata('userid')."' AND tbl_complaints.complaint_nature='complaint' AND tbl_complaints.status  IN ('Pending Verification') 
									  
									  order by `pk_complaint_id` DESC");
							
							$dbresResult=$dbres->result_array();



                              if (sizeof($dbresResult) == "0") 
                              {
                                //do somthing  
                              } else {
                                  foreach ($dbresResult as $complaint_list) {
                                      ?>
                                      <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                          <th class="table-checkbox">
                                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                            </th>
                                          <td>
                                              <?php echo $complaint_list["ts_number"] ?>
                                          </td>
                                          <td>
                                              <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
                                          </td>
                                          <td>
                                              <?php 
                                                //$nowtime = strtotime(date('Y-m-d H:i:s'));
                                                echo nicetime($complaint_list["date"]);
                                                //echo time_elapsed_B($nowtime - strtotime($complaint_list["date"]));
                                              //echo $complaint_list["date"] ?>
                                          </td>
                                          
                                          <td>
                                              <?php 
                                              
                                              echo $complaint_list["city_name"]; ?>
                                          </td>
										  <td>
                                              <?php    
												
												echo $complaint_list["client_name"];
												?>
                                          </td>
											
								<!--		  <td>
										  <?php 
												
												echo $complaint_list["area"];
												?>
										  </td> -->
										  
										  <td>
                                              <?php 
                                              echo $complaint_list["product_name"]; ?>
                                          </td>
                                          <td>
                                              <?php 
											  echo $complaint_list["serial_no"];
											  ?>
                                          </td>

                                          <td>
                                              <?php echo substr($complaint_list["problem_summary"], 0, 30); ?>
                                          </td>
                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											$obj->current_status($complaint_list['status']);
										  ?>
                                          </td>
                                          <td>
										  <div class="btn-group-vertical btn-group-solid">
                                          <a class="btn btn-default green-haze" 
                                          href="<?php echo base_url();?>complaint/technical_service_pvr/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	 TSR
                                          </a>
                                          
                                          <?php if($complaint_list["problem_type"]=='equipment' || $complaint_list["status"]=='Pending (BB)') {?>
                                          <a class="btn btn-default green-haze-stripe" 
                                              href="<?php echo base_url();?>products/sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                              	SPRF
                                          </a>
                                          <?php }?>
                                          </div>
                                          </td>
										  
										  <?php
												$userid		=	$this->session->userdata('userid');
												$userrole	=	$this->session->userdata('userrole');
												$complaint_id =	$complaint_list["pk_complaint_id"];
												$count_msgs	=	0;
												$countfield	=	'read_director';
												
												
												if($userrole=='Admin') $countfield = 'read_director';
												if($userrole=='secratery') $countfield = 'read_secratery';
												if($userrole=='Supervisor') $countfield = 'read_supervisor';
												if($userrole=='FSE' || $userrole=='Salesman') $countfield = 'read_employee';
												
												$cq			=	"select * from tbl_comments where `fk_complaint_id`='".$complaint_id."' AND `".$countfield."`=0";
												$cr			=	$this->db->query($cq);
												$count_msgs	=	sizeof($cr->result_array());
											?>	
										  
										  <td>
										  <a class="icon-btn" 
                                          href="<?php echo base_url();?>complaint/comments/<?php echo $complaint_list["pk_complaint_id"] ?>">                                         	
											<i class="fa fa-comments-o"></i>
											<div>Comments</div>
											<?php if ($count_msgs>0) {?>
												<span class="badge bg-blue">
												<?php echo $count_msgs; ?>
												</span>
											<?php } ?>
                                          </a>
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
                
                <!-- BEGIN EXAMPLE TABLE PORTLET Pending SPRF-->
                <div class="portlet box blue">
                  <div class="portlet-title">
                    <div class="caption"> <i class="fa fa-globe"></i>Engineer Complaints (Pending SPRF) </div>
                    <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
                  </div>
                  <div class="portlet-body">
                    <div class="table-toolbar">
                        
                    </div>
					
               		<div class="portlet-body flip-scroll">
                     <table class="table table-striped table-bordered table-hover flip-content" id="sample_25">
                      <thead>
                        <tr>
                            <th class="table-checkbox">
                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                            </th>
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
                  <!--          <th>
                                 Area
                            </th> -->
                            
                            <th>
                                 Equipment
                            </th>
                            
                            <th>
                                 S/No
                            </th>
                            <th>
                                 Problem Summary
                            </th>
                            <th>
                                 Status
                            </th>
                            
                            <th>
                                Actions
                            </th>
							<th>
								Comments
							</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
						/*$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to='".$this->session->userdata('userid')."' AND complaint_nature='complaint'  
						AND 
						status IN ('Pending SPRF')
						order by `pk_complaint_id` DESC"); */
						
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
									  
									  WHERE assign_to='".$this->session->userdata('userid')."' AND tbl_complaints.complaint_nature='complaint' AND tbl_complaints.status  IN ('Pending SPRF') 
									  
									  order by `pk_complaint_id` DESC");
							
							$dbresResult=$dbres->result_array();



                              if (sizeof($dbresResult) == "0") 
                              {
                                //do somthing  
                              } else {
                                  foreach ($dbresResult as $complaint_list) {
                                      ?>
                                      <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                          <th class="table-checkbox">
                                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                            </th>
                                          <td>
                                              <?php echo $complaint_list["ts_number"] ?>
                                          </td>
                                          <td>
                                              <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
                                          </td>
                                          <td>
                                              <?php 
                                                //$nowtime = strtotime(date('Y-m-d H:i:s'));
                                                echo nicetime($complaint_list["date"]);
                                                //echo time_elapsed_B($nowtime - strtotime($complaint_list["date"]));
                                              //echo $complaint_list["date"] ?>
                                          </td>
                                          
                                          <td>
                                              <?php 
                                              
                                              echo $complaint_list["city_name"]; ?>
                                          </td>
										  <td>
                                              <?php    
												
												echo $complaint_list["client_name"];
												?>
                                          </td>
											
								<!--		  <td>
										  <?php 
												
												echo $complaint_list["area"];
												?>
										  </td> -->
										  
										  <td>
                                              <?php 
                                              echo $complaint_list["product_name"]; ?>
                                          </td>
                                          <td>
                                              <?php 
											  echo $complaint_list["serial_no"];
											  ?>
                                          </td>

                                          <td>
                                              <?php echo substr($complaint_list["problem_summary"], 0, 30); ?>
                                          </td>
                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											$obj->current_status($complaint_list['status']);
										  ?>
                                          </td>
                                          <td>
										  <div class="btn-group-vertical btn-group-solid">
                                          <a class="btn btn-default green-haze" 
                                          href="<?php echo base_url();?>complaint/technical_service_pvr/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	 TSR
                                          </a>
                                          
                                          <?php if($complaint_list["problem_type"]=='equipment' || $complaint_list["status"]=='Pending (BB)') {?>
                                          <a class="btn btn-default green-haze-stripe" 
                                              href="<?php echo base_url();?>products/sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                              	SPRF
                                          </a>
                                          <?php }?>
                                          </div>
                                          </td>
										  
										  <?php
												$userid		=	$this->session->userdata('userid');
												$userrole	=	$this->session->userdata('userrole');
												$complaint_id =	$complaint_list["pk_complaint_id"];
												$count_msgs	=	0;
												$countfield	=	'read_director';
												
												
												if($userrole=='Admin') $countfield = 'read_director';
												if($userrole=='secratery') $countfield = 'read_secratery';
												if($userrole=='Supervisor') $countfield = 'read_supervisor';
												if($userrole=='FSE' || $userrole=='Salesman') $countfield = 'read_employee';
												
												$cq			=	"select * from tbl_comments where `fk_complaint_id`='".$complaint_id."' AND `".$countfield."`=0";
												$cr			=	$this->db->query($cq);
												$count_msgs	=	sizeof($cr->result_array());
											?>	
										  
										  <td>
										  <a class="icon-btn" 
                                          href="<?php echo base_url();?>complaint/comments/<?php echo $complaint_list["pk_complaint_id"] ?>">                                         	
											<i class="fa fa-comments-o"></i>
											<div>Comments</div>
											<?php if ($count_msgs>0) {?>
												<span class="badge bg-blue">
												<?php echo $count_msgs; ?>
												</span>
											<?php } ?>
                                          </a>
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
                
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box green-meadow">
                  <div class="portlet-title">
                    <div class="caption"> <i class="fa fa-globe"></i>Engineer Complaints (Closed) </div>
                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                  </div>
                  <div class="portlet-body">
                    <div class="table-toolbar">
                    </div>
					
               		<div class="portlet-body flip-scroll">
                     <table class="table table-striped table-bordered table-hover flip-content" id="sample_22">
                      <thead>
                        <tr>
                            <th class="table-checkbox">
                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                            </th>
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
                     <!--       <th>
                                 Area
                            </th> -->
                            
                            <th>
                                 Equipment
                            </th>
                            
                            <th>
                                 S/No
                            </th>
                            <th>
                                 Problem Summary
                            </th>
                            <th>
                                 Status
                            </th>
                            
                            <th>
                                Actions
                            </th>
							<th>
								Comments
							</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php


						/*	$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to='".$this->session->userdata('userid')."' AND complaint_nature='complaint'
							AND 
							status IN ('Closed')
							order by `pk_complaint_id` DESC"); */
							
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
									  
									  WHERE assign_to='".$this->session->userdata('userid')."' AND tbl_complaints.complaint_nature='complaint' AND tbl_complaints.status  IN ('Closed') 
									  
									  order by `pk_complaint_id` DESC");
							
							$dbresResult=$dbres->result_array();



                              if (sizeof($dbresResult) == "0") 
                              {
                                //do somthing  
                              } else {
                                  foreach ($dbresResult as $complaint_list) {
                                      ?>
                                      <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                          <th class="table-checkbox">
                                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                            </th>
                                          <td>
                                              <?php echo $complaint_list["ts_number"] ?>
                                          </td>
                                          <td>
                                              <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
                                          </td>
                                          <td>
                                              <?php 
                                                //$nowtime = strtotime(date('Y-m-d H:i:s'));
                                                echo nicetime($complaint_list["date"]);
                                                //echo time_elapsed_B($nowtime - strtotime($complaint_list["date"]));
                                              //echo $complaint_list["date"] ?>
                                          </td>
                                          <td>
											  <?php
												if($complaint_list["status"]=='Closed')
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
                                              
                                              echo $complaint_list["city_name"]; ?>
                                          </td>
										  <td>
                                              <?php    
												
												echo $complaint_list["client_name"];
												?>
                                          </td>
											
								<!--		  <td>
										  <?php 
												
												echo $complaint_list["area"];
												?>
										  </td> -->
										  
										  <td>
                                              <?php 
                                              echo $complaint_list["product_name"]; ?>
                                          </td>
                                          <td>
                                              <?php 
											  echo $complaint_list["serial_no"];
											  ?>
                                          </td>

                                          <td>
                                              <?php echo substr($complaint_list["problem_summary"], 0, 30); ?>
                                          </td>
                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											$obj->current_status($complaint_list['status']);
										  ?>
                                          </td>
                                          <td>
										  <div class="btn-group-vertical btn-group-solid">
                                          <a class="btn btn-default green-haze" 
                                          href="<?php echo base_url();?>complaint/technical_service_pvr/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	 TSR
                                          </a>
                                          
                                          <?php if($complaint_list["problem_type"]=='equipment' || $complaint_list["status"]=='Pending (BB)') {?>
                                          <a class="btn btn-default green-haze-stripe" 
                                              href="<?php echo base_url();?>products/sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                              	SPRF
                                          </a>
                                          <?php }?>
                                          </div>
                                          </td>
										  
										  <?php
												$userid		=	$this->session->userdata('userid');
												$userrole	=	$this->session->userdata('userrole');
												$complaint_id =	$complaint_list["pk_complaint_id"];
												$count_msgs	=	0;
												$countfield	=	'read_director';
												
												
												if($userrole=='Admin') $countfield = 'read_director';
												if($userrole=='secratery') $countfield = 'read_secratery';
												if($userrole=='Supervisor') $countfield = 'read_supervisor';
												if($userrole=='FSE' || $userrole=='Salesman') $countfield = 'read_employee';
												
												$cq			=	"select * from tbl_comments where `fk_complaint_id`='".$complaint_id."' AND `".$countfield."`=0";
												$cr			=	$this->db->query($cq);
												$count_msgs	=	sizeof($cr->result_array());
											?>	
										  
										  <td>
										  <a class="icon-btn" 
                                          href="<?php echo base_url();?>complaint/comments/<?php echo $complaint_list["pk_complaint_id"] ?>">                                         	
											<i class="fa fa-comments-o"></i>
											<div>Comments</div>
											<?php if ($count_msgs>0) {?>
												<span class="badge bg-blue">
												<?php echo $count_msgs; ?>
												</span>
											<?php } ?>
                                          </a>
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