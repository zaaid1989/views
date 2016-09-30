<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"><small>View Half Complaints</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        View Complaints 
                    </li>
                    
                </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box green-jungle">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa icon-book-open"></i>View Half Complaints </div>
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
									  if(isset($_GET['del']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Complaint Deleted Successfully.  
											  </div>';
									  }
								  ?>
                              
                            </div>
                           <div class="portlet-body flip-scroll">
                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_20">
                              <thead>
                                <tr>
                                    <th>
										Created By
									</th>
                                    <th class="sorting">
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
						<!--			<th>
                                         Time Elapsed
                                    </th> -->
                                    <th>
										 City
									</th>
									<th>
										 Customer
									</th>
						<!--			<th>
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
									 // $dbres = $this->db->query("SELECT * FROM tbl_complaints where complaint_nature='complaint' AND status='Pending Registration'  order by `pk_complaint_id` DESC");
									  $dbres = $this->db->query(" SELECT tbl_complaints.*, 
									  COALESCE(tbl_cities.city_name) AS city_name,
									  COALESCE(tbl_clients.client_name) AS client_name,
									  COALESCE(tbl_area.area) AS area,
									  COALESCE(tbl_offices.office_code) AS office_code,
									  COALESCE(user.first_name) AS first_name,
									  COALESCE(tbl_parts.part_number) AS part_number,
									  COALESCE(tbl_instruments.serial_no) AS serial_no,
									  COALESCE(tbl_products.product_name) AS product_name 
									  
									  FROM tbl_complaints 
									  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
									  LEFT JOIN user ON tbl_complaints.created_by = user.id
									  LEFT JOIN tbl_offices ON tbl_complaints.fk_office_id = tbl_offices.pk_office_id
									  LEFT JOIN tbl_sprf ON tbl_complaints.pk_complaint_id = tbl_sprf.fk_complaint_id
									  LEFT JOIN tbl_parts ON tbl_sprf.fk_part_id = tbl_parts.pk_part_id
									  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
									  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id 
							
							WHERE  tbl_complaints.status IN('Pending Registration') AND complaint_nature='complaint'  ");
            						  $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											  ?>
											  <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
												  <td>
													  <?php 
													  // $ty=$this->db->query("select * from user where id='".$complaint_list["created_by"]."'");
													  // $rt=$ty->result_array();
													  echo $complaint_list["first_name"];
													  // $ty=$this->db->query("select * from tbl_offices where pk_office_id='".$rt[0]["fk_office_id"]."'");
													  // $rt=$ty->result_array();
													  echo ' ('. $complaint_list["office_code"].')';
													?>
												</td>
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
												  </td>
									<!--		<td>
													  <?php echo nicetime($complaint_list["date"]);//echo $complaint_list["date"] ?>
												  </td>	       -->                                      
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
													  <?php if ($complaint_list["problem_summary"]!= "Auto Generated from SPRF") 
														  echo $complaint_list["problem_summary"]; 
													  else {
													  ?>
													  <?php 
													  // $ty=$this->db->query("select * from tbl_sprf WHERE fk_complaint_id='".$complaint_list['pk_complaint_id']."'");
														// $rt=$ty->result_array();
														
														// $ty=$this->db->query("select * from tbl_parts where pk_part_id='".$rt[0]['fk_part_id']."'");
														// $rt=$ty->result_array();
														// echo 'Install back .. '.$rt[0]['part_number'];
														echo 'Install back .. '.$complaint_list['part_number'];
													  }
													  ?>
													  
												  </td>
                                                  
                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											//$obj->current_status($complaint_list['status']);
											if ($complaint_list['software_generated']==1)
												echo '<span class="label label-sm label-warning bg-purple"> '.$complaint_list['status'].' </span>';
											else 
												echo '<span class="label label-sm label-warning"> '.$complaint_list['status'].' </span>';
										  ?>
                                          </td>
										  <td>
                                          <a class="btn btn-default" href="<?php echo base_url();?>complaint/add_complaint_registration/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	Open Form
                                          </a>
                                           <a class="btn btn default red-thunderbird"  
											  href="<?php echo base_url();?>products/delete_complaint/<?php echo $complaint_list["pk_complaint_id"];?>"
											  onClick="return confirm('Are you sure you want to delete?')">
												Delete <i class="fa fa-trash-o"></i>
										   </a>
												 
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
		$('#reloadd').click(function() {
    location.reload();
});
		</script>