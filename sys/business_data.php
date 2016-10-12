
<?php $this->load->view('header.php');?>
<script>
$(window).load(function() {   
  $('#loader').hide();
  $('#dataaTable').show('slow','linear');
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
#dataaTable { display:none }

</style>
                    
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Business Projects </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> <a href="<?php echo "site_url();"?>">Home</a> <i class="fa fa-angle-right"></i> </li>
                        <li> Business Projects </li>
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue-hoki">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-briefcase"></i>Business Projects </div>
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
                                  	if(isset($_GET['del']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Business Project Deleted Successfully.  
											  </div>';
									  }
								  ?>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>sys/add_business_project" id="sample_editable_1_new" class="btn green-meadow"> 
                                    	 New Business Project
                                        <i class="fa fa-plus"></i> 
                                    </a>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  
                                </div>
                              </div>
                            </div>
                        <div class="portlet-body flip-scroll">
						
						<div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
						
                             <table class="table table-striped table-bordered table-hover flip-content " id="dataaTable">
                              <thead class="bg-grey-cascade">
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
                                  
								  <th> Actions	</th>
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                              </thead>
                              <tbody>
                                <?php
								$this->db->query("SET SQL_BIG_SELECTS=1");
								$dbres = $this->db->query("
								SELECT 
								business_data.*, 
								COALESCE(tbl_cities.city_name) AS city_name,
								COALESCE(tbl_clients.client_name) AS client_name,
								COALESCE(tbl_area.area) AS area,
								COALESCE(user.first_name) AS first_name,
								COALESCE(s1.date) AS strategy_date,
								COALESCE(s1.target_date) AS target_date,
								COALESCE(s1.strategy) AS strategy,
								COALESCE(s1.tactics) AS tactics,
								COALESCE(s1.investment) AS investment,
								COALESCE(s1.sales_per_month) AS sales_per_month,
								MAX(tbl_dvr.date) AS dvr_date,
								COUNT(tbl_dvr.date) AS total_visits,
								COALESCE(tbl_business_types.businesstype_name) AS businesstype_name 
								
								FROM business_data 
								
								LEFT JOIN tbl_cities ON business_data.City = tbl_cities.pk_city_id 
								LEFT JOIN tbl_area ON business_data.Area = tbl_area.pk_area_id 
								LEFT JOIN tbl_clients ON business_data.Customer = tbl_clients.pk_client_id 
								LEFT JOIN user ON business_data.`Sales Person` = user.id 
								LEFT JOIN tbl_business_types ON business_data.`Business Project`  = tbl_business_types.pk_businesstype_id
								LEFT JOIN tbl_dvr ON business_data.pk_businessproject_id = tbl_dvr.fk_business_id
								LEFT JOIN (SELECT * from tbl_project_strategy WHERE strategy_status = 1) s1 ON business_data.pk_businessproject_id = s1.fk_project_id
								LEFT JOIN (SELECT * from tbl_project_strategy WHERE strategy_status = 1) s2 ON business_data.pk_businessproject_id = s2.fk_project_id AND s1.pk_project_strategy_id < s2.pk_project_strategy_id
								
								WHERE business_data.status='0' AND s2.pk_project_strategy_id IS NULL 
								GROUP BY pk_businessproject_id");
								$business_dataa	=	$dbres->result_array();
									  if (sizeof($business_dataa) == "0") { // $business_data if you want to fetch from model
										  
									  } else {
										  foreach ($business_dataa as $my_business_data) {
											  ?>
											  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                                  
												  <td> <?php echo $my_business_data["city_name"]; ?></td>
                                                  <td> <?php echo $my_business_data["client_name"]; ?> </td>
                                                  <td> <?php echo $my_business_data["area"]; ?> </td>
												  <td> <?php echo $my_business_data["first_name"]; ?> </td>
												  <td> <?php echo date('d-M-Y', strtotime($my_business_data["Date"])); ?></td>
												  <td> <?php echo $my_business_data["project_type"]; ?></td>
                                                  <td> <?php echo $my_business_data["businesstype_name"]; ?></td>
                                                  <td> <?php echo $my_business_data["Project Description"] ?></td>
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
												  
                                                  <td><?php echo $strategy_target ; ?></td>
												  <td><?php echo $strategyy; ?></td>
												  <td><?php echo $tactics; ?></td>
												  <td><?php echo $investment; ?></td>
												  <td><?php echo $sales_per_month; ?></td>
                                                  <td>
												  <div class="btn-group-vertical btn-group-solid">
                                                  	<a class="btn btn-sm default green-meadow-stripe" 
                                                    href="<?php echo base_url();?>sys/update_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                    	Update <i class="fa fa-edit"></i>
                                                    </a>
													<a class="btn btn-sm default purple-stripe" 
                                                    href="<?php echo base_url();?>sys/add_strategy/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Strategy &nbsp;<i class="fa fa-eye"></i>
                                                    </a>
													<a class="btn btn-sm default blue-stripe" 
                                                    href="<?php echo base_url();?>sys/strategy_history/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Strategy History &nbsp;<i class="fa fa-eye"></i>
                                                    </a>
													<a class="btn btn-sm default blue-hoki-stripe" 
                                                    href="<?php echo base_url();?>sys/details_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Details &nbsp;<i class="fa fa-eye"></i>
                                                      </a>
													<!--  
                                                    <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')" 
                                                      href="<?php echo base_url();?>sys/delete_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Delete &nbsp;&nbsp;<i class="fa fa-trash-o"></i>
                                                      </a>
													 --> 
													<a href="#" id="sample_editable_1_new" class="btn btn-sm default red-thunderbird-stripe" data-toggle="modal" data-target="#myModal<?php echo $my_business_data["pk_businessproject_id"];?>" > 
														Delete
														<i class="fa fa-trash-o"></i> 
													</a>
													</div>
													
													<!-- Modal -->
							<div id="myModal<?php echo $my_business_data["pk_businessproject_id"];?>" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Delete Project</h4>
								  </div>
								  <div class="modal-body">
								  <!-- Modal from Metronics -->
								   <form action="<?php echo base_url();?>sys/delete_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>" class="form-horizontal" method="post">
								   
                                    <div class="form-group row">
									<label class="col-md-3 control-label">Result</label>
									<div class="col-md-9">
									<select id="result" name="result" class="form-control" required>
                                        <option value="">--Choose--</option>
                                        <option value="Won" >Won</option>
                                        <option value="Lost" >Lost</option>
                                        <option value="Discarded" >Discarded</option>
                                    </select> 
									</div>
									</div>
                                    
									<input type="hidden" name="fk_complaint_id" value="<?php //echo $this->uri->segment(3);?> ">
                    
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-offset-8 col-md-4">
                                                        <input type="hidden" name="complaint_id" value="<?php //echo $this->uri->segment(3);?>" />
                                                        <button type="submit" class="btn red-thunderbird" >
                                                        	Delete
                                                        </button>
                                                <!--        <button type="button" class="btn default" data-dismiss="modal">Cancel</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                        </div>
                                    </div>
            					</form>
								  <!-- Form End -->
						
								  </div>
								  
								</div>

							  </div>
							</div>
                        <!-- End Modal -->
                                                      
                                                  	
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
								null
						]

		});
});
/*
$(document).ready(function(){
     $('#dataaTable').dataTable()
		  .columnFilter({ sPlaceHolder: "head:before",
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
								null
						]

		});
});
*/
</script>
		
