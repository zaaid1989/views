<?php 
	  include('header.php');
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
		  //return "$difference $periods[$j] {$tense}";
		  return "$difference $periods[$j]";
	  }
?>
                    
                    
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Employees <small>Manage Employees </small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
                        <li> Employees </li>
                        
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box green-sharp">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-users"></i>Employees </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
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
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>profile/add_employee" id="sample_editable_1_new" class="btn yellow-gold"> Register New Employee <i class="fa fa-plus"></i> </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="portlet-body flip-scroll">
                             <table class="table table-striped table-bordered table-hover flip-content " id="dataaTable">
                              <thead>
								<tr>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                  <th>				 			</th>
                                </tr>
                                <tr>
                                  <th> Territory 				</th>
                                  <th> City 					</th>
                                  <th> Department 				</th>
                                  <th> Full Name 				</th>
								  <th> System Role				</th>
								  <th> Username					</th>
                                  <th> Password 				</th>
                                  <th> Company Mobile 			</th>
                                  <th> Company Email Address 	</th>
                                  <th> Employment Duration		</th>
                                  <th> Training Equipment 		</th>
                                  <th> Update 					</th>
                                  <th> Delete 					</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_users_lists) == "0") {
										  
									  } else {
										  foreach ($get_users_lists as $get_users_list) {
											  ?>
											  <tr class="odd gradeX">

												  
                                                  <td>
													  <?php //echo $get_users_list["fk_office_id"] ?>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_offices where pk_office_id='".$get_users_list["fk_office_id"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["office_name"] ?>
												  </td>
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$get_users_list["fk_city_id"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["city_name"] ?>
												  </td>
												  <td>
													  <?php echo $get_users_list["department"] ?>
												  </td>
                                                  <td>
													  <?php echo $get_users_list["first_name"] ?> 
												  </td>
												  <td>
													  <?php echo $get_users_list["userrole"]; ?> 
												  </td>
												  <td>
													  <?php echo $get_users_list["username"] ?> 
												  </td>
												  <td>
													  <?php echo $get_users_list["password"] ?> 
												  </td>
                                                  <td>
													  <?php echo $get_users_list["company_mobile"] ?>
												  </td>
                                                  <td>
													  <?php echo $get_users_list["company_email"] ?>
												  </td>
                                                  
                                                  <td>
													  <?php echo nicetime($get_users_list["date_of_joining"]); //date('d-M-Y',strtotime($get_users_list["date_of_joining"])); ?>
												  </td>
                                                  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_trainings
													   WHERE fk_engineer_id='".$get_users_list["id"]."'");
													  $rt=$ty->result_array();
													  $n=0;
													  foreach($rt as $brand)
													  {
														  if($n>0)
														  {
															  echo ', ';
														  }
														  $ty5=$this->db->query("select * from tbl_products
														  WHERE pk_product_id='".$brand["fk_brand_id"]."'");
														  $rt5=$ty5->result_array();
														  echo $rt5[0]['product_name'];
														  $n++;
													  }
													   ?>
												  </td>
												  <td>
													  <a class="btn btn-sm default yellow-gold-stripe"  href="<?php echo base_url();?>profile/update_employee/<?php echo $get_users_list["id"];?>">
                                                      	Update <i class="fa fa-edit"></i>
                                                      </a>
                                                  </td>
                                                  <td>
                                                  	  <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')" 
                                                      href="<?php echo base_url();?>profile/delete_user/<?php echo $get_users_list["id"];?>">
                                                      	Delete 
														<i class="fa fa-trash-o"></i>
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
                        <!-- END EXAMPLE TABLE PORTLET--> 
                      </div>
                    </div>
      				<!-- END PAGE CONTENT-->
                    
                    
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php include('footer.php');?>
<script>
		 $(document).ready(function() { 
			var table = $('#dataaTable').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 0, "desc" ]]
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
								{ type: "text" }
						]

		});
});

</script>