<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Engineer <small>View Projects</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Engineer Projects
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                      <?php
						  //ingnored and active projects Calculations
						  $active_projects_array = array();
						  $ignored_projects_array = array();
						  if (sizeof($get_engineer_projects) == "0") 
						  {
										  
						  } 
						  else 
						  {
							  foreach ($get_engineer_projects as $my_business_data) 
							  {
								  $ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$my_business_data["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
								  if($ty->num_rows()>0)
								  {
									  $rt=$ty->result_array();
									  $now 		 = time(); 
									  $your_date = strtotime($rt[0]["date"]);
									  $datediff  = $now - $your_date;
									  $mydiffrence = floor($datediff/(60*60*24));
									  if($mydiffrence>30)
									  {
										  array_push($ignored_projects_array,$my_business_data['pk_businessproject_id']);
									  }
									  else
									  {
										  array_push($active_projects_array,$my_business_data['pk_businessproject_id']);
									  } 
								  }
								  else
								  {
									  array_push($ignored_projects_array,$my_business_data['pk_businessproject_id']);
								  }
							
							}
						}
					  ?>
                        <!-- BEGIN EXAMPLE TABLE PORTLET All (displayed None)-->
                        <div class="portlet box grey-cascade" style="display:none;">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Engineer Projects </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
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
									  if(isset($_GET['msg_update']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												'.$_GET['msg_update'].'  
											  </div>';
									  }
									  
								  ?>
                              
                            </div>
                            <div class="portlet-body flip-scroll">
                                 <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                  <th> Territory 				</th>
                                  <th> City 					</th>
                                  <th> Customer 				</th>
                                  <th> Area 					</th>
                                  <!--<th> Department 				</th>
                                  <th> Sales Person 			</th>-->
                                  <th> Business Project 		</th>
                                  <th> Project Description		</th>
                                  <th> Time Lapsed 					</th>
                                  <th> Last Visit Date			</th>
                                  <th> Total No of Visits		</th>
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_engineer_projects) == "0") {
										  
									  } else {
										  foreach ($get_engineer_projects as $my_business_data) {
											  ?>
											  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                                  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_offices where pk_office_id='".$my_business_data["Territory"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["office_name"]; 
													  }?>
												  </td>
												  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$my_business_data["City"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["city_name"]; 
													  }?>
												  </td>
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from tbl_clients where pk_client_id='".$my_business_data["Customer"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["client_name"]; 
													  }?> 
												  </td>
												  
                                                  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_area where pk_area_id='".$my_business_data["Area"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["area"]; 
													  }?> 
												  </td>
                                                  <!--<td>
													  <?php echo $my_business_data["Department"] ?>
												  </td>
                                                   <td>
                                                      <?php 
													  $ty=$this->db->query("select * from user where id='".$my_business_data["Sales Person"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"]; 
													  }?> 
												  </td>-->
												  <td> 
                                                       <?php 
													  $ty=$this->db->query("select * from tbl_business_types where pk_businesstype_id='".$my_business_data["Business Project"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["businesstype_name"]; 
													  }?>
												  </td>
												  
                                                  <td>
													  <?php echo $my_business_data["Project Description"] ?>
												  </td>
                                                  <?php $obj=new Complaint_model(); ?>
												  <td>
													  <?php //echo date('d-M-Y', strtotime($my_business_data["Date"])); ?>
                                                      <?php echo $obj->nicetime($my_business_data["Date"]); ?>
												  </td>
                                                  <td>
                                                  	<?php 
													  $ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$my_business_data["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  //echo $rt[0]["date"];
													  echo date('d-M-Y', strtotime($rt[0]["date"])); 
													  }?>
												  </td>
                                                  <td>
                                                  	<?php 
													  
													  echo $ty->num_rows(); 
													  ?>
												  </td>
                                                  <!--<td>
													  <?php echo $my_business_data["Date"] ?>
												  </td>-->
                                                  
                                                  
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
                        
                        <!-- BEGIN EXAMPLE TABLE PORTLET Active-->
                        <div class="portlet box green">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Engineer Projects Active</div>
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
									  if(isset($_GET['msg_update']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												'.$_GET['msg_update'].'  
											  </div>';
									  }
									  
								  ?>
                              
                            </div>
                            <div class="portlet-body flip-scroll">
                                 <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                  <th> Territory 				</th>
                                  <th> City 					</th>
                                  <th> Customer 				</th>
                                  <th> Area 					</th>
                                  <!--<th> Department 				</th>
                                  <th> Sales Person 			</th>-->
                                  <th> Business Project 		</th>
                                  <th> Project Description		</th>
                                  <th> Time Lapsed 					</th>
                                  <th> Last Visit Date			</th>
                                  <th> Total No of Visits		</th>
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_engineer_projects) == "0") {
										  
									  } else {
										  foreach ($get_engineer_projects as $my_business_data) {
											  if(in_array($my_business_data["pk_businessproject_id"],$active_projects_array))
											  {
											  ?>
											  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                                  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_offices where pk_office_id='".$my_business_data["Territory"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["office_name"]; 
													  }?>
												  </td>
												  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$my_business_data["City"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["city_name"]; 
													  }?>
												  </td>
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from tbl_clients where pk_client_id='".$my_business_data["Customer"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["client_name"]; 
													  }?> 
												  </td>
												  
                                                  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_area where pk_area_id='".$my_business_data["Area"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["area"]; 
													  }?> 
												  </td>
                                                  <!--<td>
													  <?php echo $my_business_data["Department"] ?>
												  </td>
                                                   <td>
                                                      <?php 
													  $ty=$this->db->query("select * from user where id='".$my_business_data["Sales Person"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"]; 
													  }?> 
												  </td>-->
												  <td> 
                                                       <?php 
													  $ty=$this->db->query("select * from tbl_business_types where pk_businesstype_id='".$my_business_data["Business Project"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["businesstype_name"]; 
													  }?>
												  </td>
												  
                                                  <td>
													  <?php echo $my_business_data["Project Description"] ?>
												  </td>
                                                  <?php $obj=new Complaint_model(); ?>
												  <td>
													  <?php //echo date('d-M-Y', strtotime($my_business_data["Date"])); ?>
                                                      <?php echo $obj->nicetime($my_business_data["Date"]); ?>
												  </td>
                                                  <td>
                                                  	<?php 
													  $ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$my_business_data["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  //echo $rt[0]["date"];
													  echo date('d-M-Y', strtotime($rt[0]["date"])); 
													  }?>
												  </td>
                                                  <td>
                                                  	<?php 
													  
													  echo $ty->num_rows(); 
													  ?>
												  </td>
                                                  <!--<td>
													  <?php echo $my_business_data["Date"] ?>
												  </td>-->
                                                  
                                                  
											  </tr>
											  <?php
										  		}
										  }
									  }
                              ?>
                                
                              </tbody>
                            </table>
                           </div>
                          </div>
                        </div>
                        
                        <!-- BEGIN EXAMPLE TABLE PORTLET Ignored-->
                        <div class="portlet box grey-cascade">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Engineer Projects Ignored</div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                              
                            </div>
                            <div class="portlet-body flip-scroll">
                                 <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                  <th> Territory 				</th>
                                  <th> City 					</th>
                                  <th> Customer 				</th>
                                  <th> Area 					</th>
                                  <!--<th> Department 				</th>
                                  <th> Sales Person 			</th>-->
                                  <th> Business Project 		</th>
                                  <th> Project Description		</th>
                                  <th> Time Lapsed 					</th>
                                  <th> Last Visit Date			</th>
                                  <th> Total No of Visits		</th>
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_engineer_projects) == "0") {
										  
									  } else {
										  foreach ($get_engineer_projects as $my_business_data) {
											  if(in_array($my_business_data["pk_businessproject_id"],$ignored_projects_array))
											  {
											  ?>
											  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                                  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_offices where pk_office_id='".$my_business_data["Territory"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["office_name"]; 
													  }?>
												  </td>
												  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$my_business_data["City"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["city_name"]; 
													  }?>
												  </td>
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from tbl_clients where pk_client_id='".$my_business_data["Customer"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["client_name"]; 
													  }?> 
												  </td>
												  
                                                  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_area where pk_area_id='".$my_business_data["Area"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["area"]; 
													  }?> 
												  </td>
                                                  <!--<td>
													  <?php echo $my_business_data["Department"] ?>
												  </td>
                                                   <td>
                                                      <?php 
													  $ty=$this->db->query("select * from user where id='".$my_business_data["Sales Person"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"]; 
													  }?> 
												  </td>-->
												  <td> 
                                                       <?php 
													  $ty=$this->db->query("select * from tbl_business_types where pk_businesstype_id='".$my_business_data["Business Project"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["businesstype_name"]; 
													  }?>
												  </td>
												  
                                                  <td>
													  <?php echo $my_business_data["Project Description"] ?>
												  </td>
                                                  <?php $obj=new Complaint_model(); ?>
												  <td>
													  <?php //echo date('d-M-Y', strtotime($my_business_data["Date"])); ?>
                                                      <?php echo $obj->nicetime($my_business_data["Date"]); ?>
												  </td>
                                                  <td>
                                                  	<?php 
													  $ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$my_business_data["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  //echo $rt[0]["date"];
													  echo date('d-M-Y', strtotime($rt[0]["date"])); 
													  }?>
												  </td>
                                                  <td>
                                                  	<?php 
													  
													  echo $ty->num_rows(); 
													  ?>
												  </td>
                                                  <!--<td>
													  <?php echo $my_business_data["Date"] ?>
												  </td>-->
                                                  
                                                  
											  </tr>
											  <?php
											  }
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