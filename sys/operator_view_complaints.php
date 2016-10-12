<?php $this->load->view('header');
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
?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Operator <small>View Complaints</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        View Complaints (Operator)
                    </li>
                    
                </ul>
              </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red-intense">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa icon-book-open"></i>Operator Complaints View</div>
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
												Complaint Added Successfully.  
											  </div>';
									  }
								  ?>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>sys/add_sys/o" id="sample_editable_1_new" class="btn red-intense"> Add New <i class="fa fa-plus"></i> </a>
                                  </div>
                                </div>
                                
                              </div>
                            </div>
                                      <div class="portlet-body flip-scroll">
                                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                    
                                    <th class="sorting">
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
									<th>
										 Area
									</th>
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
                                         FSE/SAP
                                    </th>
                                    <th>
                                         Status
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
										//end nice time fucntion
									  $dbres = $this->db->query("SELECT * FROM tbl_complaints where complaint_nature='complaint' 
									  AND 
									  status NOT IN ('Pending Verification', 'Pending SPRF', 'Closed','Pending Registration') order by `pk_complaint_id` DESC");
            						  $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											  ?>
											  <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
												  
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
												  </td>
											<td>
													  <?php echo nicetime($complaint_list["date"]);//echo $complaint_list["date"] ?>
												  </td>	                                            
                                          <td>
                                              <?php 
                                              $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint_list["fk_city_id"]."'");
                                              $rt=$ty->result_array();
                                              echo $rt[0]["city_name"] ?>
                                          </td>
										  <td>
                                              <?php    
												$nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$complaint_list['fk_customer_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['client_name'];
												?>
                                          </td>
											
										  <td>
										  <?php 
												$nsql3=$this->db->query("select area from tbl_area where pk_area_id ='".$n2sql3[0]['fk_area_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['area'];
												?>
										  </td>
										  <td>
                                              <?php 
                                              $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
                                              $rt=$ty->result_array();
                                              //echo $rt[0]["fk_brand_id"];
											  if($ty->num_rows()>0)
											  {
												  $ty2=$this->db->query("select * from tbl_products where pk_product_id='".$rt[0]["fk_product_id"]."'");
												  $rt2=$ty2->result_array();
												  echo $rt2[0]["product_name"];
											  }
                                              //echo $complaint_list["instrument_name"] ?>
                                          </td>
                                          <td>
                                              <?php 
											  if($ty->num_rows()>0)
											  {
											  	echo $rt[0]["serial_no"]; 
											  }
											  ?>
                                          </td>

                                                  <td>
													  <?php echo $complaint_list["problem_summary"] ?>
												  </td>
                                                  
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from user where id ='".$complaint_list["assign_to"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"];
										  				}
													  //echo $complaint_list["FSE_SAP"] ?>
												  </td>
												  </td>
                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											$obj->current_status($complaint_list['status']);
										  ?>
                                          </td>
										  <?php /*
                                          <td>
                                          <a class="btn btn-default" href="<?php echo base_url();?>sys/ts_report_director/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	Open Form
                                          </a>
                                          </td> */?>
												 
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
                            <div class="caption"> <i class="fa icon-book-open"></i>Operator Complaints (Pending Verification)</div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                              
                            </div>
                                      <div class="portlet-body flip-scroll">
                                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_20">
                              <thead>
                                <tr>
                                    
                                    <th class="sorting">
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
									<th>
										 Area
									</th>
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
                                         FSE/SAP
                                    </th>
                                    <th>
                                         Status
                                    </th>
                                    
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  
									  $dbres = $this->db->query("SELECT * FROM tbl_complaints where complaint_nature='complaint' 
									  AND 
									  status IN ('Pending Verification') order by `pk_complaint_id` DESC");
            						  $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											  ?>
											  <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
												  
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
												  </td>
											<td>
													  <?php echo nicetime($complaint_list["date"]);//echo $complaint_list["date"] ?>
												  </td>	                                            
                                          <td>
                                              <?php 
                                              $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint_list["fk_city_id"]."'");
                                              $rt=$ty->result_array();
                                              echo $rt[0]["city_name"] ?>
                                          </td>
										  <td>
                                              <?php    
												$nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$complaint_list['fk_customer_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['client_name'];
												?>
                                          </td>
											
										  <td>
										  <?php 
												$nsql3=$this->db->query("select area from tbl_area where pk_area_id ='".$n2sql3[0]['fk_area_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['area'];
												?>
										  </td>
										  <td>
                                              <?php 
                                              $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
                                              $rt=$ty->result_array();
                                              //echo $rt[0]["fk_brand_id"];
											  if($ty->num_rows()>0)
											  {
												  $ty2=$this->db->query("select * from tbl_products where pk_product_id='".$rt[0]["fk_product_id"]."'");
												  $rt2=$ty2->result_array();
												  echo $rt2[0]["product_name"];
											  }
                                              //echo $complaint_list["instrument_name"] ?>
                                          </td>
                                          <td>
                                              <?php 
											  if($ty->num_rows()>0)
											  {
											  	echo $rt[0]["serial_no"]; 
											  }
											  ?>
                                          </td>

                                                  <td>
													  <?php echo $complaint_list["problem_summary"] ?>
												  </td>
                                                  
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from user where id ='".$complaint_list["assign_to"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"];
										  				}
													  //echo $complaint_list["FSE_SAP"] ?>
												  </td>
												  </td>
                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											$obj->current_status($complaint_list['status']);
										  ?>
                                          </td>
										  <?php /*
                                          <td>
                                          <a class="btn btn-default" href="<?php echo base_url();?>sys/ts_report_director/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	Open Form
                                          </a>
                                          </td> */?>
												 
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
                            <div class="caption"> <i class="fa icon-book-open"></i>Operator Complaints (Pending SPRF)</div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                              
                            </div>
                                      <div class="portlet-body flip-scroll">
                                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_25">
                              <thead>
                                <tr>
                                    
                                    <th class="sorting">
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
									<th>
										 Area
									</th>
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
                                         FSE/SAP
                                    </th>
                                    <th>
                                         Status
                                    </th>
                                    
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  
									  $dbres = $this->db->query("SELECT * FROM tbl_complaints where complaint_nature='complaint' 
									  AND 
									  status IN ('Pending SPRF') order by `pk_complaint_id` DESC");
            						  $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											  ?>
											  <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
												  
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
												  </td>
											<td>
													  <?php echo nicetime($complaint_list["date"]);//echo $complaint_list["date"] ?>
												  </td>	                                            
                                          <td>
                                              <?php 
                                              $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint_list["fk_city_id"]."'");
                                              $rt=$ty->result_array();
                                              echo $rt[0]["city_name"] ?>
                                          </td>
										  <td>
                                              <?php    
												$nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$complaint_list['fk_customer_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['client_name'];
												?>
                                          </td>
											
										  <td>
										  <?php 
												$nsql3=$this->db->query("select area from tbl_area where pk_area_id ='".$n2sql3[0]['fk_area_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['area'];
												?>
										  </td>
										  <td>
                                              <?php 
                                              $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
                                              $rt=$ty->result_array();
                                              //echo $rt[0]["fk_brand_id"];
											  if($ty->num_rows()>0)
											  {
												  $ty2=$this->db->query("select * from tbl_products where pk_product_id='".$rt[0]["fk_product_id"]."'");
												  $rt2=$ty2->result_array();
												  echo $rt2[0]["product_name"];
											  }
                                              //echo $complaint_list["instrument_name"] ?>
                                          </td>
                                          <td>
                                              <?php 
											  if($ty->num_rows()>0)
											  {
											  	echo $rt[0]["serial_no"]; 
											  }
											  ?>
                                          </td>

                                                  <td>
													  <?php echo $complaint_list["problem_summary"] ?>
												  </td>
                                                  
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from user where id ='".$complaint_list["assign_to"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"];
										  				}
													  //echo $complaint_list["FSE_SAP"] ?>
												  </td>
												  </td>
                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											$obj->current_status($complaint_list['status']);
										  ?>
                                          </td>
										  <?php /*
                                          <td>
                                          <a class="btn btn-default" href="<?php echo base_url();?>sys/ts_report_director/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	Open Form
                                          </a>
                                          </td> */?>
												 
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
                            <div class="caption"> <i class="fa icon-book-open"></i>Operator Complaints (Closed)</div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                              
                            </div>
                                      <div class="portlet-body flip-scroll">
                                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_21">
                              <thead>
                                <tr>
                                    
                                    <th class="sorting">
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
									<th>
										 Area
									</th>
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
                                         FSE/SAP
                                    </th>
                                    <th>
                                         Status
                                    </th>
                                    
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  
									  $dbres = $this->db->query("SELECT * FROM tbl_complaints where complaint_nature='complaint' 
									  AND 
									  status IN ('Closed') order by `pk_complaint_id` DESC");
            						  $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											  ?>
                                      <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                          
                                          <td>
                                              <?php echo $complaint_list["ts_number"] ?>
                                          </td>
                                          <td>
                                              <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
                                          </td>
                                          <td>
                                              <?php echo nicetime($complaint_list["date"]);//echo $complaint_list["date"] ?>
                                          </td>	 
                                          <td>
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
                                          </td>                                           
                                          <td>
                                              <?php 
                                              $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint_list["fk_city_id"]."'");
                                              $rt=$ty->result_array();
                                              echo $rt[0]["city_name"] ?>
                                          </td>
										  <td>
                                              <?php    
												$nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$complaint_list['fk_customer_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['client_name'];
												?>
                                          </td>
											
										  <td>
										  <?php 
												$nsql3=$this->db->query("select area from tbl_area where pk_area_id ='".$n2sql3[0]['fk_area_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['area'];
												?>
										  </td>
										  <td>
                                              <?php 
                                              $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
                                              $rt=$ty->result_array();
                                              //echo $rt[0]["fk_brand_id"];
											  if($ty->num_rows()>0)
											  {
												  $ty2=$this->db->query("select * from tbl_products where pk_product_id='".$rt[0]["fk_product_id"]."'");
												  $rt2=$ty2->result_array();
												  echo $rt2[0]["product_name"];
											  }
                                              //echo $complaint_list["instrument_name"] ?>
                                          </td>
                                          <td>
                                              <?php 
											  if($ty->num_rows()>0)
											  {
											  	echo $rt[0]["serial_no"]; 
											  }
											  ?>
                                          </td>

                                                  <td>
													  <?php echo $complaint_list["problem_summary"] ?>
												  </td>
                                                  
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from user where id ='".$complaint_list["assign_to"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"];
										  				}
													  //echo $complaint_list["FSE_SAP"] ?>
												  </td>
												  </td>
                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											$obj->current_status($complaint_list['status']);
										  ?>
                                          </td>
										  <?php /*
                                          <td>
                                          <a class="btn btn-default" href="<?php echo base_url();?>sys/ts_report_director/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	Open Form
                                          </a>
                                          </td> */?>
												 
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