<?php $this->load->view('header');
if ($this->uri->segment('3'))
 echo "";
else show_404();
?>

<?php
	$project_id=$this->uri->segment('3');
	
	$last_visit_date = "";
	$total_visits = "";
	  $ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$this->uri->segment('3')."' ORDER BY  `pk_dvr_id` DESC ");
	  if($ty->num_rows()>0) {
		  $rt=$ty->result_array();
		  $last_visit_date = date('d-M-Y', strtotime($rt[0]["date"])); 
	  }
	  
	  $total_visits =  $ty->num_rows(); 
	  
	$zquery="select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_area.area,user.first_name,tbl_business_types.businesstype_name 
	from business_data 
	LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
	LEFT JOIN tbl_area ON tbl_area.pk_area_id = business_data.Area
	LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = business_data.City
	LEFT JOIN user ON user.id = business_data.`Sales Person`
	LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
	WHERE pk_businessproject_id='" .$project_id."'";
	$ty=$this->db->query($zquery);
    $rt=$ty->result_array();
	
	if ($this->session->userdata('userrole')=="Salesman" && $this->session->userdata('userid')!=$rt[0]['Sales Person']) show_404();
	/*
	$client_id=$rt[0]['fk_client_id']; //////// for client data
	$serial_no=$rt[0]['serial_no'];
	$category_id=$rt[0]['fk_category_id']; //////// for category name
	$product_id=$rt[0]['fk_product_id']; /////// for product name
	$office_id=$rt[0]['fk_office_id'];
	$details=$rt[0]['details'];
	$status=$rt[0]['status'];
	*/
	
	
													  
	
	$client_name=$rt[0]['client_name'];
	$client_area=$rt[0]['area'];
	$client_city=$rt[0]['city_name'];
	$date=date('d-M-Y',strtotime($rt[0]['Date']));
	$sap = $rt[0]['first_name'];
	$department = $rt[0]['Department'];
	$category=$rt[0]['businesstype_name'];
	$project_type=$rt[0]['project_type'];
	$description=urldecode($rt[0]['Project Description']);
	
?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Business Project Details  <small>DVR and VS details of project</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="<?php echo base_url();?>sys/business_data">Business Projects</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Business Project Details
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
					  
					  
					  
					  <div class="portlet box purple">
              
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Project Information</div>
                            <div class="tools">
                                 <a href="javascript:;" class="collapse"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="table-scrollable">
                                      <table class="table table-striped table-bordered table-hover">
                                          <thead>
                                          	<tr><th>Attribute</th><th>Value</th></tr>
                                          </thead>
                                          <tbody>
												<tr class="odd gradeX">
                                                       <td>Customer</td>
                                                       <td><?php echo $client_name ;  ?></td>
                                                 </tr>
												 
                                                 <tr class="odd gradeX">
                                                    <td>City</td>
                                                    <td> <?php echo $client_city;  ?></td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                       <td>Area</td>
                                                       <td><?php  echo $client_area ;  ?></td>
                                                 </tr>
                                                 
                                                 <tr class="odd gradeX">
                                                        <td>Department</td>
													   <td> <?php echo $department;  ?></td>
                                                 </tr>  
												 <tr class="odd gradeX">
                                                        <td>Description</td>
													   <td> <?php echo $description;  ?></td>
                                                 </tr>  
                                          </tbody>
                                     </table>
                              </div>
                             </div>
                              <div class="col-md-6">
                                <div class="table-scrollable">
                                      <table class="table table-striped table-bordered table-hover">
              
                                          <thead>
                                          	<tr><th>Attribute</th><th>Value</th></tr>
                                          </thead>
										  <tbody>
                                                 <tr class="odd gradeX">
                                                    <td>Project Date</td>
                                                    <td> <?php echo $date;  ?></td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                       <td>Project Type</td>
                                                       <td><?php echo $project_type;  ?></td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                       <td>Category</td>
                                                       <td><?php echo $category;  ?></td>
                                                 </tr>
												<!-- 
												 <tr class="odd gradeX">
                                                       <td>Sales Person</td>
                                                       <td><?php echo $sap; ?></td>
                                                 </tr>
												 -->
                                                 
                                                 <tr class="odd gradeX">
                                                        <td>Total Visits</td>
													   <td> <?php echo $total_visits;  ?></td>
                                                 </tr>  
												 <tr class="odd gradeX">
                                                        <td>Last Visit Date</td>
													   <td> <?php echo $last_visit_date;  ?></td>
                                                 </tr>  
                                          </tbody>
                                        </table>
                              </div>
                             </div>
                            </div>
                        
						</div>
                        <!-- END EXAMPLE TABLE PORTLET--> 
                      </div>
		
		
		
		<div class="portlet box green-jungle">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Strategy History </div>
            </div>
            <div class="portlet-body">
              <div class="portlet-body flip-scroll">
				 
                <table class="table table-striped table-bordered table-hover flip-content">
                  <thead>
                    <tr>
					  <th> Strategy Status </th>
					  <th> Strategy Date </th>
                      <th> Target Date </th>
					  <th> Employee </th>
                      <th> Strategy </th>
                      <th> Tactics </th>
                      <th> Investment </th>
                      <th> Sales / Month </th>
					  <?php if ($this->session->userdata('userrole')=="Admin") {?>
					  <th> Actions </th>
					  <?php }?>
                    </tr>
                  </thead>

                  <tbody>
					<?php
					
					$ty=$this->db->query("SELECT tbl_project_strategy.*, user.first_name FROM tbl_project_strategy 
					LEFT JOIN user ON user.id = tbl_project_strategy.fk_employee_id
					WHERE fk_project_id = '".$project_id."' AND strategy_status='1' ORDER BY date DESC");
					
					//without strategy_status as Mr. Yasir asked for it to be shown
					$ty=$this->db->query("SELECT tbl_project_strategy.*, user.first_name FROM tbl_project_strategy 
					LEFT JOIN user ON user.id = tbl_project_strategy.fk_employee_id
					WHERE fk_project_id = '".$project_id."' ORDER BY date DESC");
                    $rt=$ty->result_array();
	
					if (sizeof($rt) == "0") 
					{
					  //do somthing  
					} else {
						foreach ($rt as $project_strategy) 
						  {
							  
							?>
					 		<tr class="odd gradeX">
							  <td> <!-- Strategy Status -->
								<?php 
								if ($project_strategy["strategy_status"]=='0')
									echo '<span class="label label-sm  bg-yellow-gold"> Pending </span>'; 
								if ($project_strategy["strategy_status"]=='1')
									echo '<span class="label label-sm  bg-blue"> Approved </span>'; 
								if ($project_strategy["strategy_status"]=='4')
									echo '<span class="label label-sm bg-red"> Disapproved </span>'; 
								
								?>
                              </td>
                              <td> <!-- Date -->
								<?php echo date('d-M-Y',strtotime($project_strategy['date'])); ?>
                              </td>
							  <td> <!-- Target Date -->
								<?php echo date('d-M-Y',strtotime($project_strategy['target_date'])); ?>
                              </td>	 
							  <td> <!-- Employee -->
								<?php echo $project_strategy['first_name']; ?>
                              </td>
                              <td> <!-- Strategy -->
								<?php echo urldecode($project_strategy["strategy"]); ?>
                              </td>
							  <td> <!-- Strategy -->
								<?php echo urldecode($project_strategy["tactics"]); ?>
                              </td>	 

								<td> <!-- Investment -->
								<?php echo $project_strategy["investment"]; ?>
                              </td>
							  
							  <td> <!-- Sales / Month -->
								<?php echo $project_strategy["sales_per_month"]; ?>
                              </td>
							  <?php if ($this->session->userdata('userrole')=="Admin") {?>
                              <td class="bg-grey-cararra text-center bg-grey-border">
							  <a class="btn btn-sm default blue" href="<?php echo base_url();?>sys/edit_strategy/<?php echo $project_strategy["pk_project_strategy_id"].'?proj='.$project_id;?>" >
                                    Edit &nbsp;<i class="fa fa-eye"></i>
							  </a>
							  
							  <a class="btn btn-sm default red" href="<?php echo base_url();?>sys/delete_strategy/<?php echo $project_strategy["pk_project_strategy_id"].'?proj='.$project_id;?>" onClick="return confirm('Are you sure you want to delete?')">
                                    Delete &nbsp;<i class="fa fa-trash-o"></i>
							  </a>
							  </td>
							  <?php } ?>
        
                            </tr>
					<?php } 
					}
					?>
                  </tbody>

                </table>

              </div>

            </div>

          </div>

          <!-- END EXAMPLE TABLE PORTLET--> 
					  
					  
					  
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-files-o"></i> Daily Visit Reports (DVRs) </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												User Added Successfully.  
											  </div>';
									  }
								  ?>
                                  <?php
                                  	if(isset($_GET['upt']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												User Updated Successfully.  
											  </div>';
									  }
								  ?>
                              
                            </div>
                        	<div class="portlet-body flip-scroll">
                             <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                  <th> Date</th>
                                  <th colspan="2"  style="padding-right:150px;"> Time </th>
              					  <th> Employee</th>
                                  <th> Working Details/Discussion Summary </th>
								  <?php
									if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' )	
										echo '<th> Update			</th>';
								  ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
								  $dbres = $this->db->query("SELECT * FROM tbl_dvr  where fk_business_id='".$this->uri->segment('3')."'  order by pk_dvr_id DESC");
								 $dbresResult=$dbres->result_array();
								  if (sizeof($dbresResult) == "0") {
									  echo "<tr class='odd grade'><td colspan='9' align='center'>No Results Found.</td></tr>";
								  } else {
									  foreach($dbresResult as $sup_dvr)
										  {
											   echo '<tr class="odd gradeX">';
											   
											  echo '<td>';
											  echo date('d-M-Y', strtotime($sup_dvr['date']));
											  echo '</td><td>';
											  echo date('h:i A', strtotime($sup_dvr['start_time']));
											  echo '</td><td>';
											  echo date('h:i A', strtotime($sup_dvr['end_time']));
											  echo '</td>';
											echo '<td>';
													$maxqu_eng = $this->db->query("SELECT * FROM user where id='".$sup_dvr['fk_engineer_id']."' ");
													$maxval_eng=$maxqu_eng->result_array();
												  echo $maxval_eng[0]['first_name'];
											  echo'</td>';
											  echo '<td>';
											  echo urldecode($sup_dvr['summery']);
											  echo '</td>';
											  ?>
                                            <?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') {?>      
											  <td>
												<a class="btn default red-stripe" 
												href="<?php echo base_url();?>sys/update_dvr_project/<?php echo $sup_dvr["pk_dvr_id"];?>">
													Update <i class="fa fa-edit"></i>
												</a>
											  </td>
											<?php }
											 echo '</tr>';
										  }
								  }
                              ?>
                                
                              </tbody>
                            </table>
                           </div>
                          </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET--> 
                        
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-files-o"></i>Visit Schedules (VS) </div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                              
                            
                        	<div class="portlet-body flip-scroll">
                             <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                  <th style="width:120px !important"> Date</th>
                                  <th colspan="2"  style="padding-right:150px;"> Time </th>
              					  <th> Employee</th> 
                                  <th> Working Details/Discussion Summary </th>
                               
                                  <?php
									if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' )	
										echo '<th> Update			</th>';
								  ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  $dbres = $this->db->query("SELECT * FROM tbl_vs where fk_business_id='".$this->uri->segment('3')."' order by pk_vs_id DESC");
           							 $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  echo "<tr class='odd grade'><td colspan='8' align='center'>No Results Found.</td></tr>";
									  } else {
										  
											  foreach($dbresResult as $sup_dvr)
											  {
												  echo '<tr class="odd gradeX">';
												  echo '<td>';
												  echo date('d-M-Y', strtotime($sup_dvr['date']));
												  echo '</td><td>';
												  echo date('h:i A', strtotime($sup_dvr['start_time']));
												  echo '</td><td>';
												  echo date('h:i A', strtotime($sup_dvr['end_time']));
												  echo '</td>';echo '<td>';
													$maxqu_eng = $this->db->query("SELECT * FROM user where id='".$sup_dvr['fk_engineer_id']."' ");
													$maxval_eng=$maxqu_eng->result_array();
												  echo $maxval_eng[0]['first_name'];
												  echo'</td>';
												  
												  echo '<td>';
												  echo urldecode($sup_dvr['summery']);
												  echo ' </td>';
												  ?>
                                                  <?php
													if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery'){ ?>
												  <td>
                                                  	<a class="btn default blue-stripe" 
                                                    href="<?php echo base_url();?>sys/update_vs_project/<?php echo $sup_dvr["pk_vs_id"];?>">
                                                    	Update <i class="fa fa-edit"></i>
                                                    </a>
												  </td>
													<?php }
												 echo '</tr>';
											  }
										
									  }
                              ?>
                                
                              </tbody>
                            </table>
                                      </div>
                          </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
						
						
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box grey-gallery">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-files-o"></i>Monthly Report Comments </div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                        	<div class="portlet-body flip-scroll">
                             <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                  <th> Date</th>
                                  <th> Monthly Report </th>
              					  <th> Employee</th> 
                                  <th> Comments </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  $dbres = $this->db->query("SELECT * FROM tbl_report_comments where ts='0' AND fk_project_id='".$this->uri->segment('3')."' order by pk_report_comments_id DESC");
           							 $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  echo "<tr class='odd grade'><td colspan='8' align='center'>No Results Found.</td></tr>";
									  } else {
										  
											  foreach($dbresResult as $sup_dvr)
											  {
												echo '<tr>';
												  echo '<td>'.date('d-M-Y', strtotime($sup_dvr['date'])).'</td>';
												  echo '<td>'.date('F Y', strtotime($sup_dvr['month'])).'</td>';
												  echo '<td>';
													$maxqu_eng = $this->db->query("SELECT * FROM user where id='".$sup_dvr['fk_user_id']."' ");
													$maxval_eng=$maxqu_eng->result_array();
												  echo $maxval_eng[0]['first_name'];
												  echo'</td>';
												  echo '<td>'.urldecode($sup_dvr['report_comments']).'</td>';
												echo '</tr>';
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
                 </div>
                </div>
                <!-- END CONTENT -->
            </div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>