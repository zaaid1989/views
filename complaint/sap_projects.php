<?php $this->load->view('header');?>

                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    SAP <small>View Projects</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                SAP Projects
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
						  $inactive_projects_array = array();
						  $ignored_projects_array = array();
						  if (sizeof($get_sap_projects) == "0") 
						  {
										  
						  } 
						  else 
						  { //// classifying into active inactive
							  foreach ($get_sap_projects as $my_business_data) 
							  {
								  $ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$my_business_data["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
								  if($ty->num_rows()>0)
								  {
									  $rt=$ty->result_array();
									  $now 		 = time(); 
									  $your_date = strtotime($rt[0]["date"]);
									  $datediff  = $now - $your_date;
									  $mydiffrence = floor($datediff/(60*60*24));
									  
									  if($mydiffrence>=49)
									  {
										  array_push($ignored_projects_array,$my_business_data['pk_businessproject_id']);
									  }
									  elseif($mydiffrence<49 && $mydiffrence>=22 )
									  {
										  array_push($inactive_projects_array,$my_business_data['pk_businessproject_id']);
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
					  
					  
			<!------------------------ ************** SAP Statistics NEW BEGIN *************** ------------------>
			
			
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box purple">
              <div class="portlet-title">
                <div class="caption"> <i class="fa fa-users"></i>SAP Projects Statistics</div>
                <div class="tools"> 
                    <a href="javascript:;" class="collapse"> </a> 
                </div>
              </div>
              <div class="portlet-body">
                
            	<div class="portlet-body flip-scroll">
                 <table class="table table-striped table-bordered table-hover flip-content dataaaTable " >
                  <thead>
                    <tr>
                      <th class="sorting"> Project Type				</th>
                      <?php 
						$ty=$this->db->query("select * from tbl_business_types where status='0' ORDER BY businesstype_name");
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
                          $query=$this->db->query("select DISTINCT project_type from business_data");
						  $query_res=$query->result_array();
                          foreach ($query_res as $get_users_list) {
					?>
					<tr class="odd gradeX mytr_city<?php //echo $get_users_list['pk_city_id'];?>">
						<td>
							<?php echo $get_users_list["project_type"]; ?>
						</td>
						<?php 
							  $total=0;
							  $ty=$this->db->query("select * from tbl_business_types where status='0' ORDER BY businesstype_name");
							  $ty=$this->db->query("select * from tbl_business_types where status='0' ");
							  $rt=$ty->result_array();
							  foreach ($rt as $category)
							  {
							?>
							<td> 
							  <?php 
								  $business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."'
								  AND `project_type` = '".$get_users_list['project_type']."' AND `priority`='0' AND `status`='0' AND `Sales Person`='".$this->session->userdata('userid')."'";
								  $projects_query=$this->db->query($business_data);
								  $projects=$projects_query->result_array();
								  if ($projects_query->num_rows()>0) {
								  echo '<span data-toggle="tooltip" data-html="true" title="';
								  
									foreach ($projects AS $project) {
										$ty=$this->db->query("select * from tbl_clients where pk_client_id='".$project["Customer"]."'");
										  if($ty->num_rows()>0)
										  {
											  $rt=$ty->result_array();
											  echo $rt[0]["client_name"]; 
										  }
										$ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$project["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
										  if($ty->num_rows()>0)
										  {
										  $rt=$ty->result_array();
										  echo "(";
										  echo date('d-M-Y', strtotime($rt[0]["date"])); 
										  echo "), ";
										  }
										  else echo '(), ';
									}
									
								  echo '">';
								  echo $projects_query->num_rows();
								  echo '</span>';
								}
								else echo '-';
								  $total=$total+$projects_query->num_rows();
								  
								  
								  ////////////// FOR priority
								  $business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."'
								  AND `project_type` = '".$get_users_list['project_type']."' AND `priority`='1' AND `status`='0' AND `Sales Person`='".$this->session->userdata('userid')."'";
								  $projects_query=$this->db->query($business_data);
								  $projects=$projects_query->result_array();
								  if ($projects_query->num_rows()>0) {
								  echo '<span data-toggle="tooltip" data-html="true" title="';
								  
									foreach ($projects AS $project) {
										$ty=$this->db->query("select * from tbl_clients where pk_client_id='".$project["Customer"]."'");
										  if($ty->num_rows()>0)
										  {
											  $rt=$ty->result_array();
											  echo $rt[0]["client_name"]; 
										  }
										$ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$project["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
										  if($ty->num_rows()>0)
										  {
										  $rt=$ty->result_array();
										  echo "(";
										  echo date('d-M-Y', strtotime($rt[0]["date"])); 
										  echo "), ";
										  }
										  else echo '(), ';
									}
									
								  echo '">';
								  
								  echo " + <span class='font-red'>".$projects_query->num_rows()."</span>";
								  echo '</span>';
								  }
								  $total=$total+$projects_query->num_rows();
							  ?> 
							</td>
						<?php }?>
							<th> 
							  <?php 
								  echo $total;
								  if($total==0)
								  {
									  ?>
									  <!--
									  <style>
										  .mytr_city<?php echo $get_users_list['pk_city_id'];?>
										  {
											  display:none !important;
										  }
									  </style>
									  -->
									  <?php
								  }
							  ?> 
							</th>
					</tr>
					<?php
					}
					?>
					
                  </tbody>
				  <footer>
					<tr class="odd gradeX">
						
						<td>
							<b>Category Total</b>
						</td>
						<?php 
							  $ty=$this->db->query("select * from tbl_business_types where status='0' ORDER BY businesstype_name");
							  $ty=$this->db->query("select * from tbl_business_types where status='0' ");
							  $rt=$ty->result_array();
							  $t = 0;
							  foreach ($rt as $category)
							  {
							?>
							<th> 
							  <?php 
								  $business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."' AND `status`='0' AND `Sales Person`='".$this->session->userdata('userid')."'";
								  //echo $business_data;
								  $projects_query=$this->db->query($business_data);
								  $projects=$projects_query->result_array();
								  //echo sizeof($projects_query);
								  echo $projects_query->num_rows();
								  $t += $projects_query->num_rows();
							  ?> 
							</th>
						<?php }?>
							<th> 
							  <?php 
								  echo $t;
							  ?> 
							</th>
					</tr>
					</footer>
                </table>
               </div>
              </div>
            </div>
			
			
			<!------------------------ ************** SAP Statistics NEW END ****************** -------------------->
					  
					  <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green-sharp">
              <div class="portlet-title">
                <div class="caption"> <i class="fa fa-users"></i>SAP Projects Statistics City</div>
                <div class="tools"> 
                    <a href="javascript:;" class="collapse"> </a> 
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
								  $business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."' AND `status`='0' AND `Sales Person`='".$this->session->userdata('userid')."'";
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
                        <!-- BEGIN EXAMPLE TABLE PORTLET All (displayed None)-->
<?php /*	
                        <div class="portlet box grey-cascade" style="display:none;">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>SAP Projects </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
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
                                  <th> Project Type				</th>
                                  <th> Business Project 		</th>
                                  <th> Project Description		</th>
                                  <th> Strategy Date 			</th>
                                  <th> Last Visit Date			</th>
                                  <th> Total No of Visits		</th>
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_sap_projects) == "0") {
										  
									  } else {
										  foreach ($get_sap_projects as $my_business_data) {
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
													  <?php echo $my_business_data["project_type"]; ?>
												  </td>
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
      
*/ ?>	  
                        <!-- BEGIN EXAMPLE TABLE PORTLET Active-->
                        <div class="portlet box green">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>SAP Projects</div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a> </div>
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
                             <table class="table table-striped table-bordered table-hover flip-content dataaTable" id="">
                              <thead>
							  
							  <tr>
								<!--<th >  		        </th>-->
								<th >   		</th>
								<th >  			</th>
								<th >  		</th>
								<th >   		</th>
								<th >  		</th>
								<th > 	</th>
								<th >  	</th>
								<th >  	</th>
								<th >  	</th>
								<th >  	</th>
								<th >  	</th>
								<th >  	</th>
								<th >  	</th>
								<th >  	</th>
								<th >  	</th>
								<th >  	</th>
								<th > 			</th>
							  </tr>
					  
                                <tr>
                                  <!--<th> Territory 				</th>-->
								  <th> Actions					</th>
								  <th> Status					</th>
                                  <th> City 					</th>
                                  <th> Customer 				</th>
                                  <th> Area 					</th>
                                  <!--<th> Department 				</th>
                                  <th> Sales Person 			</th>-->
								  <th> Project Type		</th>
                                  <th> Category		</th>
                                  <th> Project Description		</th>
                                  <th> Date 					</th>
                                  <th> Last Visit		</th>
                                  <th> Visits		</th>
								  <th> Strategy Date</th>
								  <th> Target Date </th>
								  <th> Strategy </th>
								  <th> Tactics		</th>
								  <th> Investment </th>
								  <th> Sales/Month </th>
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_sap_projects) == "0") {} else { //active inactive ignored
										  foreach ($get_sap_projects as $my_business_data) {
											  for ($i=0;$i<=2;$i++) {
											  if((in_array($my_business_data["pk_businessproject_id"],$active_projects_array) && $i==0) ||
													(in_array($my_business_data["pk_businessproject_id"],$inactive_projects_array) && $i==1) ||
													(in_array($my_business_data["pk_businessproject_id"],$ignored_projects_array) && $i==2))
											  {
											  ?>
											  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                                 
												  <td>
												  <div class="btn-group-vertical btn-group-solid">
												  <?php if ($my_business_data["strategy_status"] == '0' || $my_business_data["strategy_status"] != '0') { ?>
                                                  	<a class="btn btn-sm default green-meadow-stripe" 
                                                    href="<?php echo base_url();?>complaint/add_strategy/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                    	Strategy <i class="fa fa-edit"></i>
                                                    </a>
											  <?php } ?>
													<a class="btn btn-sm default blue-hoki-stripe" 
                                                    href="<?php echo base_url();?>complaint/details_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Details &nbsp;<i class="fa fa-eye"></i>
                                                      </a>
													  
													 <a class="btn btn-sm default yellow-gold-stripe" 
                                                    href="<?php echo base_url();?>complaint/sap_vs/?p=<?php echo $my_business_data["pk_businessproject_id"];?>" target="_blank">
                                                      	Add VS &nbsp;<i class="fa fa-eye"></i>
                                                      </a>
													 </div>
												  </td>
												  <td> <?php if ($i==0) echo 'Active'; elseif ($i==1) echo 'Inactive'; else echo 'Ignored'; ?> </td>
												  <td><?php echo $my_business_data["city_name"]; ?></td>
												  <td><?php echo $my_business_data["client_name"]; ?></td>
                                                  <td><?php echo $my_business_data["area"]; ?></td>
												  <td><?php echo $my_business_data["project_type"]; ?></td>
												  <td><?php echo $my_business_data["businesstype_name"]; ?></td>
                                                  <td><?php echo $my_business_data["Project Description"]; ?></td>
                                                  <?php $obj=new Complaint_model(); ?>
												  <td><?php echo $obj->nicetime($my_business_data["Date"]); ?></td>
                                                  <td><?php echo date('d-M-Y', strtotime($my_business_data["dvr_date"]));?></td>
                                                  <td><?php echo $my_business_data["total_visits"];?></td>
												  <!----- Below Four are for strategy --------->
												  <?php 
													$strategy_date = "";
													$strategy_target = "";
													if ($my_business_data["strategy_date"]!='')
														$strategy_date = date('d-M-Y',strtotime($my_business_data["strategy_date"]));
													if ($my_business_data["target_date"]!='')
														$strategy_target = date('d-M-Y',strtotime($my_business_data["target_date"]));
														$strategyy = urldecode($my_business_data['strategy']);
														$tactics = urldecode($my_business_data['tactics']);
														$investment = $my_business_data['investment'];
														$sales_per_month = $my_business_data['sales_per_month'];
														
												  ?>
												  <td>
                                                  	<?php echo $strategy_date; ?>
												  </td>
                                                  <td>
                                                  	<?php echo $strategy_target ; ?>
												  </td>
												  <td>
                                                  	<?php echo $strategyy; ?>
												  </td>
												  <td>
                                                  	<?php echo $tactics; ?>
												  </td>
												  <td>
                                                  	<?php echo $investment; ?>
												  </td>
												  <td>
                                                  	<?php echo $sales_per_month; ?>
												  </td>
												  
												  
												  
                                                  <!--<td>
													  <?php echo $my_business_data["Date"] ?>
												  </td>-->
                                                  
                                                  
											  </tr>
											  <?php
											  } // end of if
											  } // end of for loop
										  }
									  }
                              ?>
      <?php /*                         
                              </tbody>
                            </table>
                           </div>
                          </div>
                        </div>
                        
                        <!-- BEGIN EXAMPLE TABLE PORTLET ignored-->
                        <div class="portlet box grey-cascade">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>SAP Projects Ignored</div>
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
                                  <th> Date 					</th>
                                  <th> Last Visit Date			</th>
                                  <th> Total No of Visits		</th>
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                              </thead>
                              <tbody> */ ?>
                                <?php
									  if (sizeof($get_sap_projects) == "0" || $i>0) { //$i condition to make sure that the loop in else never runs as the code below will never be used. I have used loops to improve this code.
										  
									  } else { /*
										  foreach ($get_sap_projects as $my_business_data) {
											   if(in_array($my_business_data["pk_businessproject_id"],$ignored_projects_array))
											  {
											  ?>
											  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                                  <td> <!-- Actions -->
													<?php if ($my_business_data["strategy_status"] == '0' || $my_business_data["strategy_status"] != '0') { ?>
                                                  	<a class="btn btn-sm default green-meadow" 
                                                    href="<?php echo base_url();?>complaint/add_strategy/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                    	Strategy <i class="fa fa-edit"></i>
                                                    </a>
											  <?php } ?>
													<a class="btn btn-sm default blue-hoki" 
                                                    href="<?php echo base_url();?>complaint/details_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Details &nbsp;<i class="fa fa-eye"></i>
                                                      </a>
													  <a class="btn btn-sm default yellow-gold" 
                                                    href="<?php echo base_url();?>complaint/sap_vs/?p=<?php echo $my_business_data["pk_businessproject_id"];?>" target="_blank">
                                                      	Add VS &nbsp;<i class="fa fa-eye"></i>
                                                      </a>
												  </td>
												  
												  <!--<td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_offices where pk_office_id='".$my_business_data["Territory"]."'");
													  if($ty->num_rows()>0)
													  {
													  $rt=$ty->result_array();
													  echo $rt[0]["office_name"]; 
													  }?>
												  </td>-->
												  <td> Inactive </td>
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
													  <?php echo $my_business_data["project_type"]; ?>
												  </td>
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
												   <td> <?php echo $ty->num_rows(); ?></td>
												   
												   <!----- Below Four are for strategy --------->
												  <?php $strategy_date = "";
														$strategy_target = "";
														$strategyy = "";
														$tactics = "";
														$investment = "";
														$sales_per_month = "";
														$q = $this->db->query("SELECT * FROM tbl_project_strategy WHERE fk_project_id='".$my_business_data['pk_businessproject_id']."' AND strategy_status='1' ORDER BY `date` DESC");
														$strategies = $q->result_array();
														
														if (sizeof($strategies)>0) {
															if ($strategies[0]["date"]!="0000-00-00")
																$strategy_date = date('d-M-Y',strtotime($strategies[0]["date"]));
															if ($strategies[0]["target_date"]!="0000-00-00")
																$strategy_target = date('d-M-Y',strtotime($strategies[0]["target_date"]));
															$strategyy = urldecode($strategies[0]["strategy"]);
															$tactics = urldecode($strategies[0]["tactics"]);
															$investment = $strategies[0]["investment"];
															$sales_per_month = $strategies[0]["sales_per_month"];
														}
												  ?>
												  
											<!--	  <td >
                                                  	<?php 
														if (sizeof($strategies)>0) {
															echo '<table class="table-bordered table-condesnsed">';
															foreach($strategies AS $strategy) {
																echo '<tr>';
																echo '<td>'.date('d-M-Y',strtotime($strategy["date"])).'</td>'; 
																if ($strategy["target_date"] != '0000-00-00') 
																	echo '<td>'.date('d-M-Y',strtotime($strategy["target_date"])).'</td>'; 
																else echo '<td></td>';
																	echo '<td>'.urldecode($strategy["strategy"]).'</td>'; 
																	echo '<td>'.$strategy["investment"].'</td>'; 
																	echo '<td>'.$strategy["sales_per_month"].'</td>'; 
																echo '</tr>';
															}
															echo '</table>';
														}
													?>
												  </td>
												  -->
												  
												  <td>
                                                  	<?php echo $strategy_date; ?>
												  </td>
                                                  <td>
                                                  	<?php echo $strategy_target ; ?>
												  </td>
												  <td>
                                                  	<?php echo $strategyy; ?>
												  </td>
												  <td>
                                                  	<?php echo $tactics; ?>
												  </td>
												  <td>
                                                  	<?php echo $investment; ?>
												  </td>
												  <td>
                                                  	<?php echo $sales_per_month; ?>
												  </td>
												  
												  
                                                  <!--<td>
													  <?php echo $my_business_data["Date"] ?>
												  </td>-->
                                                  
                                                  
											  </tr>
											  <?php
											  }
										  }
									  */}
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
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 400,
	  'aaSorting': [],
	  "order": [[ 9, "desc" ]]
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
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
						]

		});
		
	var t = $('.dataaaTable').dataTable({
	  'iDisplayLength': 400,
	  'aaSorting': [],
	  "order": [[ 0, "asc" ]]
	});
});
</script>
<script>
$(document).ready(function(){ 
    $('[data-toggle="tooltip"]').tooltip({html: true}); 
});
</script>