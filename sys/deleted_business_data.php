
<?php $this->load->view('header.php');?>
<script>
$(window).load(function() {   
  $('#loader').hide();
  $('#sample_2').show('slow','linear');
});
</script>

<style>
thead select {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
		background-color:#ea4b4b !important;
		color:white !important;
		
		
    }
#sample_2 { display:none }

</style>
                    
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Deleted Projects <small> Business Projects that are not Active anymore </small></h3> 
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> <a href="<?php echo "site_url();"?>">Home</a> <i class="fa fa-angle-right"></i> </li>
                        <li> Deleted Projects </li>
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-briefcase"></i>Deleted Projects </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Business Project Added Successfully.  
											  </div>';
									  }
								  ?>
                                  <?php
                                  	if(isset($_GET['upt']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Business Project Updated Successfully.  
											  </div>';
									  }
								  ?>
                                  <?php
                                  	if(isset($_GET['restore']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Business Project Restored Successfully.  
											  </div>';
									  }
								  ?>
                              
                            </div>
                        <div class="portlet-body flip-scroll">
						
						<div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
						
                             <table class="table table-striped table-bordered table-hover flip-content" id="dataaTable">
                              <thead class="bg-red-thunderbird">
                                <tr>
                                  <!--<th> 	</th>-->
                                  <th>  					</th>
                                  <th>  				</th>
                                  <th>  				</th>
                                  <th> 			</th>
                                  <th>  	</th>
                                  <th> 			</th>
                                  <th> 		</th>
                                  <th> 			</th>
                                  <th> 		</th>
                                  <th> 	</th>
								  <th> 	</th>
								  <th> 	</th>
								  <th> 		</th>
                                  <th> 	</th>
								  <th> 	</th>
								  <th> 	</th>
								  <th> 	</th>
								  <th> 	</th>
								<!--  <th> 	</th>
								  <th> 	</th> -->
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                             
                                <tr>
                                  <!--<th> Territory 				</th>-->
                                  <th> City 					</th>
                                  <th> Customer 				</th>
                                  <th> Area 				</th>
                             <!--     <th> Department 			</th> -->
                                  <th> Sales Person 	</th>
                                  <th> Date 			</th>
                                  <th> Project Type		</th>
                                  <th> Category		</th>
                                  <th> Project Description			</th>
                                  
                                  <th> Last Visit </th>
                                  <th> Visits </th>
                                 <!-- <th> Strategy Date</th> -->
								  <th> Target Date </th>
								  <th> Strategy </th>
								  <th> Tactics </th>
								  <th> Investment </th>
								  <th> Sales/Month </th>
                                  <th> Result </th>
								  <th> Delete Date </th>
								  <th> Actions	</th>
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                              </thead>
                              <tbody>
                                <?php
								
								$dbres = $this->db->query("
								SELECT 
								business_data.*, 
								COALESCE(tbl_cities.city_name) AS city_name,
								COALESCE(tbl_clients.client_name) AS client_name,
								COALESCE(tbl_area.area) AS area,
								COALESCE(user.first_name) AS first_name,
								COALESCE(tbl_business_types.businesstype_name) AS businesstype_name 
								
								FROM business_data 
								
								LEFT JOIN tbl_cities ON business_data.City = tbl_cities.pk_city_id 
								LEFT JOIN tbl_area ON business_data.Area = tbl_area.pk_area_id 
								LEFT JOIN tbl_clients ON business_data.Customer = tbl_clients.pk_client_id 
								LEFT JOIN user ON business_data.`Sales Person` = user.id 
								LEFT JOIN tbl_business_types ON business_data.`Business Project`  = tbl_business_types.pk_businesstype_id 
								
								WHERE business_data.status='1'");
								$business_dataa	=	$dbres->result_array();
								
									  if (sizeof($business_dataa) == "0") {
										  
									  } else {
										  foreach ($business_dataa as $my_business_data) {
											  ?>
											  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                                  <!--
												  <td>
                                                      
												  </td>
												  -->
												  <td>
                                                      <?php 
													  echo $my_business_data["city_name"]; 
													  ?>
												  </td>
                                                  <td>
													  <?php 
													  echo $my_business_data["client_name"]; 
													  ?> 
												  </td>
												  
                                                  <td>
                                                      <?php 
													  echo $my_business_data["area"]; 
													  ?> 
												  </td>
                                         <!--         <td>
													  <?php echo $my_business_data["Department"] ?>
												  </td> -->
                                                   <td>
                                                      <?php 
													  echo $my_business_data["first_name"]; 
													  ?> 
												  </td>
												  <td>
													  <?php echo date('d-M-Y', strtotime($my_business_data["Date"])); ?>
												  </td>
												  <td>
													  <?php echo $my_business_data["project_type"]; ?>
												  </td>
                                                  <td> 
                                                       <?php 
													   echo $my_business_data["businesstype_name"];
													  ?>
												  </td>
												  
                                                  <td>
													  <?php echo $my_business_data["Project Description"] ?>
												  </td>
                                                  
                                                  
                                                  <td>
                                                  	<?php 
													  $ty=$this->db->query("select * from tbl_dvr 
													  where fk_business_id='".$my_business_data["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
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
												  <!--
												  <td >
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
												  
											<!--	  
												  <td>
                                                  	<?php echo $strategy_date; ?>
												  </td>
												  -->
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
												  
												  <td>
                                                  	<?php echo $my_business_data["result"]; ?>
												  </td>
												  <td>
													  <?php 
														if ($my_business_data["delete_date"]!="0000-00-00 00:00:00")
															echo date('d-M-Y', strtotime($my_business_data["delete_date"])); 
														?>
												  </td>
                                                  
                                                  <td>
												  <div class="btn-group-vertical btn-group-solid">
                                                  	<a class="btn btn-sm default green-meadow-stripe" 
                                                    href="<?php echo base_url();?>sys/update_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                    	Update <i class="fa fa-edit"></i>
                                                    </a>
													<a class="btn btn-sm default blue-hoki-stripe" 
                                                    href="<?php echo base_url();?>sys/details_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Details &nbsp;<i class="fa fa-eye"></i>
                                                      </a>
													  
                                                    <a class="btn btn-sm default red-thunderbird-stripe" onClick="return confirm('Are you sure you want to restore?')" 
                                                      href="<?php echo base_url();?>sys/restore_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Restore &nbsp;&nbsp;<i class="fa fa-trash-o"></i>
                                                      </a>  
													 </div>
                                                      
                                                  	
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
        
         <script>
$(document).ready(function() { 
			var table = $('#dataaTable').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 6, "desc" ]]
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
                                { type: "text" },
								{ type: "text" },
								null
						]

		});
});
</script>
		
