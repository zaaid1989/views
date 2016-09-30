
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
                        <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
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
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
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
								  <th> 	</th>
								  <th> 		</th>
								  <th> 	</th>
                               <!--   <th> 	</th>
								  <th> 	</th>
								  <th> 	</th> -->
								  
                                  <!--<th> Dead Line 					</th>-->
                                </tr>
                             
                                <tr>
                                  <!--<th> Territory 				</th>-->
                                  <th> City 					</th>
                                  <th> Customer 				</th>
                                  <th> Area 				</th>
                                  <th> Department 			</th>
                                  <th> Sales Person 	</th>
                                <!--  <th> Date 			</th> -->
                                  <th> Project Type		</th>
                                  <th> Category		</th>
                                  <th> Project Description			</th>
                                  
                              <!--    <th> Last Visit </th>
                                  <th> Visits </th> -->
								  <th> Strategy Date</th>
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
								
	$zquery="select business_data.*,tbl_project_strategy.*,COALESCE(tbl_clients.client_name) AS client_name,
	COALESCE(tbl_cities.city_name) AS city_name,COALESCE(tbl_area.area) AS area,COALESCE(user.first_name) AS first_name,COALESCE(tbl_business_types.businesstype_name) AS businesstype_name 
	from tbl_project_strategy
	LEFT JOIN business_data ON business_data.pk_businessproject_id = tbl_project_strategy.fk_project_id
	LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
	LEFT JOIN tbl_area ON tbl_area.pk_area_id = business_data.Area
	LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = business_data.City
	LEFT JOIN user ON user.id = business_data.`Sales Person`
	LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
	WHERE tbl_project_strategy.strategy_status='0'";
								
								/*
								$zquery="select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_area.area,user.first_name,tbl_business_types.businesstype_name
								from business_data 
								LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
								LEFT JOIN tbl_area ON tbl_area.pk_area_id = business_data.Area
								LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = business_data.City
								LEFT JOIN user ON user.id = business_data.`Sales Person`
								LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
								WHERE pk_businessproject_id IN (SELECT fk_project_id FROM tbl_project_strategy WHERE strategy_status=0)";*/
								$ty=$this->db->query($zquery);
								$rt=$ty->result_array();
									  //if (sizeof($business_data) == "0") {
										  if (sizeof($rt) == "0") {
									  } else {
										  //foreach ($business_data as $my_business_data) {
											foreach ($rt as $my_business_data) {
											  ?>
											  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                                  <!--<td>
                                                      <?php 
													  // $ty=$this->db->query("select * from tbl_offices where pk_office_id='".$my_business_data["Territory"]."'");
													  // if($ty->num_rows()>0)
													  // {
													  // $rt=$ty->result_array();
													  // echo $rt[0]["office_name"]; 
													  // }?>
												  </td>-->
												  <td>
                                                      <?php 
													  // $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$my_business_data["City"]."'");
													  // if($ty->num_rows()>0)
													  // {
													  // $rt=$ty->result_array();
													  // echo $rt[0]["city_name"]; 
													  // }
													  echo $my_business_data["city_name"];
													  ?>
												  </td>
                                                  <td>
													  <?php 
													  // $ty=$this->db->query("select * from tbl_clients where pk_client_id='".$my_business_data["Customer"]."'");
													  // if($ty->num_rows()>0)
													  // {
													  // $rt=$ty->result_array();
													  // echo $rt[0]["client_name"]; 
													  // }
													  echo $my_business_data["client_name"];
													  ?> 
												  </td>
												  
                                                  <td>
                                                      <?php 
													  // $ty=$this->db->query("select * from tbl_area where pk_area_id='".$my_business_data["Area"]."'");
													  // if($ty->num_rows()>0)
													  // {
													  // $rt=$ty->result_array();
													  // echo $rt[0]["area"]; 
													  // }
													  echo $my_business_data["area"];
													  ?> 
												  </td>
                                                  <td>
													  <?php echo $my_business_data["Department"] ?>
												  </td>
                                                   <td>
                                                      <?php 
													  // $ty=$this->db->query("select * from user where id='".$my_business_data["Sales Person"]."'");
													  // if($ty->num_rows()>0)
													  // {
													  // $rt=$ty->result_array();
													  // echo $rt[0]["first_name"]; 
													  // }
													  echo $my_business_data["first_name"];
													  ?> 
												  </td>
											<!--	  <td>
													  <?php echo date('d-M-Y', strtotime($my_business_data["Date"])); ?>
												  </td> -->
												  <td>
													  <?php echo $my_business_data["project_type"]; ?>
												  </td>
                                                  <td> 
                                                       <?php 
													  // $ty=$this->db->query("select * from tbl_business_types where pk_businesstype_id='".$my_business_data["Business Project"]."'");
													  // if($ty->num_rows()>0)
													  // {
													  // $rt=$ty->result_array();
													  // echo $rt[0]["businesstype_name"]; 
													  // }
													  echo $my_business_data["businesstype_name"];
													  ?>
												  </td>
												  
                                                  <td>
													  <?php echo $my_business_data["Project Description"] ?>
												  </td>
                                                  
                                                  
                                              <!--    <td>
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
												  </td> -->
												  
												  <!----- Below Four are for strategy --------->
												  
												  <?php $strategy_date = "";
														$strategy_target = "";
														$strategyy = "";
														$tactics = "";
														$investment = "";
														$sales_per_month = "";
														$strategy_id = 0;
														
														/*
														if ($my_business_data["date"]!="0000-00-00")
																$strategy_date = date('d-M-Y',strtotime($my_business_data["date"]));
															if ($my_business_data["target_date"]!="0000-00-00")
																$strategy_target = date('d-M-Y',strtotime($my_business_data["target_date"]));
															$strategy = urldecode($my_business_data["strategy"]);
															$investment = $my_business_data["investment"];
															$sales_per_month = $my_business_data["sales_per_month"];
															$strategy_id = $my_business_data["pk_project_strategy_id"];
															*/
															
														$q = $this->db->query("SELECT * FROM tbl_project_strategy WHERE fk_project_id='".$my_business_data['pk_businessproject_id']."' ORDER BY `date` DESC");
														$q = $this->db->query("SELECT * FROM tbl_project_strategy WHERE pk_project_strategy_id='".$my_business_data['pk_project_strategy_id']."' ORDER BY `date` DESC");
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
															$strategy_id = $strategies[0]["pk_project_strategy_id"];
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
                                                  
                                                  <td>
                                                  	<a class="btn btn-sm default red" href="<?php echo base_url();?>complaint/edit_strategy/<?php echo $strategy_id;?>" >
														Edit &nbsp;<i class="fa fa-eye"></i>
												  </a>
													<a class="btn btn-sm default blue" 
                                                    href="<?php echo base_url();?>complaint/strategy_history/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Strategy History &nbsp;<i class="fa fa-eye"></i>
                                                    </a>
													<a class="btn btn-sm default blue-hoki" 
                                                    href="<?php echo base_url();?>complaint/details_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Details &nbsp;<i class="fa fa-eye"></i>
                                                      </a>
													  <!--
                                                    <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')" 
                                                      href="<?php echo base_url();?>complaint/delete_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
                                                      	Delete &nbsp;&nbsp;<i class="fa fa-trash-o"></i>
                                                      </a>
                                                      -->
                                                  	
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
		
