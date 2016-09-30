<?php $this->load->view('header.php');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Products <small>List of Product Range</small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            Home 
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            Products
                        </li> 
                      </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue-chambray">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-anchor"></i>Products </div>
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
												Product Added Successfully.  
											  </div>';
									  }
								  ?>
                                  <?php
                                  	if(isset($_GET['upt']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Products Updated Successfully.  
											  </div>';
									  }
								  ?>
                                  <?php
                                  	if(isset($_GET['msg_delete']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Products Deleted Successfully.  
											  </div>';
									  }
								  ?>
                                  
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>complaint/add_product" id="sample_editable_1_new" class="btn light-blue"> 
                                    	Add New Product <i class="fa fa-plus"></i> 
                                    </a>
                                  </div>
                                </div>
                                
                              </div>
                            </div>
                                      <div class="portlet-body flip-scroll">
                                           <table class="table table-striped table-bordered table-hover flip-content" id="dataaTable">
                              <thead class="bg-grey">
							  <tr>
                                  <th> 		 			</th>
                                  <th> 					</th>
                                  <th>  				</th>
                                  <th>  				</th>
                                </tr>
                                <tr>
                                  <th> Product Name 				</th>
                                  <th> Vendors 					</th>
                                  <th> Category 				</th>
                                  <th> Action 				</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  $ty22=$this->db->query("select tbl_products.*,COALESCE(tbl_category.category_name) AS category_name, COALESCE(GROUP_CONCAT(tbl_vendors.vendor_name SEPARATOR ', ')) AS vendor_name 
									  from tbl_products 
									  LEFT JOIN tbl_category ON tbl_products.fk_category_id = tbl_category.pk_category_id
									  LEFT JOIN tbl_vendor_product_bridge ON tbl_products.pk_product_id = tbl_vendor_product_bridge.fk_product_id
									  LEFT JOIN tbl_vendors ON tbl_vendor_product_bridge.fk_vendor_id = tbl_vendors.pk_vendor_id
									  where tbl_products.status='0' GROUP BY tbl_products.pk_product_id");
									  $rt22=$ty22->result_array();
									  if (sizeof($rt22) == "0") {
										  
									  } else {
										  foreach ($rt22 as $get_users_list) {
											  ?>
											  <tr class="odd gradeX">
												  
                                                  <td>
													  <?php echo $get_users_list["product_name"] ?>
												  </td>
                                                  <td>
													  <?php 
													  // $ty=$this->db->query("select * from tbl_vendor_product_bridge
													   // WHERE fk_product_id='".$get_users_list["pk_product_id"]."'");
													  // $rt=$ty->result_array();
													  // $n=0;
													  // foreach($rt as $brand)
													  // {
														  // if($n>0)
														  // {
															  // echo ', ';
														  // }
														  // $ty5=$this->db->query("select * from tbl_vendors
														  // WHERE pk_vendor_id	='".$brand["fk_vendor_id"]."'");
														  // $rt5=$ty5->result_array();
														  // if($ty5->num_rows()>0)
														  // {
															  // echo $rt5[0]['vendor_name'];
															  // $n++;
														  // }
													  // }
													  echo $get_users_list["vendor_name"];
											   ?>
												  </td>
												  <td>
													  <?php 
													  // $ty=$this->db->query("select * from tbl_category where 
													  // pk_category_id='".$get_users_list["fk_category_id"]."'");
													  // $rt=$ty->result_array();
													  // echo $rt[0]["category_name"] 
													  echo $get_users_list["category_name"];
													  ?>
												  </td>
                                                  
												  <td>
													  <a class="btn btn default blue-chambray"  
                                                      href="<?php echo base_url();?>complaint/update_product/<?php echo $get_users_list["pk_product_id"];?>">
                                                      	Update <i class="fa fa-edit"></i>
                                                      </a>
                                                      <a class="btn btn default red-thunderbird"  
                                                        href="<?php echo base_url();?>complaint/delete_product/<?php echo $get_users_list["pk_product_id"];?>"
                                                        onClick="return confirm('Are you sure you want to delete?')">
                                                          Delete <i class="fa fa-trash-o"></i>
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
        <?php $this->load->view('footer.php');?>
		
<script>
		 $(document).ready(function() { 
			var table = $('#dataaTable').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 0, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" }
						]

		});
});

</script>