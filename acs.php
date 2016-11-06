<?php include('header.php');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> ACS <small>Assigned Customer Sheet</small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> </li>
                        <li> ACS </li>
                        
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue-steel">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-link"></i>Assigned Customer Sheet </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	
                                  <?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												SAP Assinged Successfully.  
											  </div>';
									  }
									  if(isset($_GET['msg_del']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Deleted Successfully.  
											  </div>';
									  }
								  ?>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>sys/add_acs" id="sample_editable_1_new" class="btn green"> Assign New Customer&nbsp;<i class="fa fa-plus"></i> </a>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  
                                </div>
                              </div>
                            </div>
                                      <div class="portlet-body flip-scroll">
                                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_225">
                              <thead>
							  <tr>
                                  <th>  					</th>
                                  <th>  					</th>
                                  <th>  					</th>
                                  <th>  					</th>
                                  <th> 			</th>
                                  <th>  					</th>
                                </tr>
                                <tr>
                                  <th> Teritory 					</th>
                                  <th> City 					</th>
                                  <th> Client 					</th>
                                  <th> Area 					</th>
                                  <th> Sales Person 			</th>
                                  <th> Delete 					</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_acs_lists) == "0") {
										  
									  } else {
										  foreach ($get_acs_lists as $get_acs_list) {
											  ?>
											  <tr class="odd gradeX">
												   <?php 
													  $ty=$this->db->query("select * from tbl_clients where pk_client_id='".$get_acs_list["fk_client_id"]."'");
													  $rt=$ty->result_array(); ?>
                                                  <td>
                                                      <?php 
													  $ty2=$this->db->query("select * from tbl_offices where pk_office_id='".$rt[0]["fk_office_id"]."'");
													  $rt2=$ty2->result_array();
													  foreach($rt2 AS $office) { echo $office["office_name"]; } ?>
												  </td>
                                                  <td>
                                                      <?php 
													  $ty3=$this->db->query("select * from tbl_cities where pk_city_id='".$rt[0]["fk_city_id"]."'");
													  $rt3=$ty3->result_array();
													  echo $rt3[0]["city_name"] ?>
												  </td>
                                                  <td>
                                                      <?php 
													  echo $rt[0]["client_name"] ?>
												  </td>
                                                  <td>
                                                      <?php 
													  $ty4=$this->db->query("select * from tbl_area where pk_area_id='".$rt[0]["fk_area_id"]."'");
													  $rt4=$ty4->result_array();
													  echo $rt4[0]["area"] ?>
												  </td>
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from user where id='".$get_acs_list["fk_user_id"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"] ?>
												  </td>
												  <td>
                                                  	  <a class="btn default btn-sm red-thunderbird" onClick="return confirm('Are you sure you want to delete?')" 
                                                      href="<?php echo base_url();?>sys/delete_asc/<?php echo $get_acs_list["pk_customer_sap_bridge_id"];?>">
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
			var table = $('#sample_220').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
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
		var table2 = $('#sample_221').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
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
		var table3 = $('#sample_222').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
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
		var table4 = $('#sample_225').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 0, "asc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
});

</script>