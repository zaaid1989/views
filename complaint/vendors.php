<?php $this->load->view('header');?>
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title"> Vendors <small>Manage Vendors for Products</small> </h3>
            <div class="page-bar">
              <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
                <li> Vendors </li>
              </ul>
              
            </div>
            <!-- END PAGE HEADER--> 
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
              <div class="col-md-12"> 
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box red-intense">
                  <div class="portlet-title">
                    <div class="caption"> <i class="icon-eye"></i>Vendors </div>
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
                                        Vendor Added Successfully.  
                                      </div>';
                              }
                          ?>
                          <?php
                            if(isset($_GET['msg_upt']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        Vendor Updated Successfully.  
                                      </div>';
                              }
                          ?>
                          <?php
                            if(isset($_GET['msg_delete']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        Vendor Deleted Successfully.  
                                      </div>';
                              }
                          ?>
                          
                      <div class="row">
                        <div class="col-md-6">
                          <div class="btn-group">
                            <a href="<?php echo base_url();?>complaint/vendor_registration" id="sample_editable_1_new" class="btn light-blue"> 
                            	Register New Vendor
                                <i class="fa fa-plus"></i> 
                            </a>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                              <div class="portlet-body flip-scroll">
                                   <table class="table table-striped table-bordered table-hover flip-content" id="dataaTable">
                      <thead>
						<tr>
                          <th>  				</th>
                          <th>  				</th>
                          <th>  				</th>
                          <th>  				</th>
                          <th>  				</th>
                          <th>  				</th>
                          <th>  				</th>
                        </tr>
                        <tr>
                          <th> Category  				</th>
                          <th> Vendor Name 			</th>
                          <th> Address 				</th>
                          <th> Mobile  				</th>
                          <th> Email  				</th>
                          <th> City   				</th>
                          <th> Country  				</th>
                          <th> Actions  				</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
					   $ty=$this->db->query("select tbl_vendors.*,COALESCE(GROUP_CONCAT(tbl_category.category_name SEPARATOR ', ')) AS category_name
					   from tbl_vendors 
					   LEFT JOIN tbl_vendor_category_bridge ON tbl_vendors.pk_vendor_id = tbl_vendor_category_bridge.fk_vendor_id
					   LEFT JOIN tbl_category ON tbl_vendor_category_bridge.fk_category_id = tbl_category.pk_category_id
					   where tbl_vendors.status = '0' GROUP BY tbl_vendors.pk_vendor_id order by pk_vendor_id DESC");
					   $rt=$ty->result_array();
						if (sizeof($rt) == "0") {
							
						} else {
							foreach ($rt as $get_users_list) 
							{
							?>
							<tr class="odd gradeX">
								<td>
									<?php 
                                    // $ty=$this->db->query("select * from tbl_vendor_category_bridge
                                     // WHERE fk_vendor_id='".$get_users_list["pk_vendor_id"]."'");
                                    // $rt=$ty->result_array();
                                    // $n=0;
                                    // foreach($rt as $brand)
                                    // {
                                        // if($n>0)
                                        // {
                                            // echo ', ';
                                        // }
                                        // $ty5=$this->db->query("select * from tbl_category
                                        // WHERE pk_category_id	='".$brand["fk_category_id"]."'");
                                        // $rt5=$ty5->result_array();
                                        // echo $rt5[0]['category_name'];
                                        // $n++;
                                     // }
									 echo $get_users_list['category_name'];
                                     ?>
								</td>
								<td>
									<?php echo $get_users_list["vendor_name"] ?>
								</td>
								<td>
									<?php echo $get_users_list["address"] ?> 
								</td>
								
								<td>
									<?php echo $get_users_list["contact_no_Mobile"] ?>
								</td>
								<td>
									<?php echo $get_users_list["email"] ?>
								</td>
								<td>
									<?php echo $get_users_list["city"] ?>
								</td>
								<td>
									<?php echo $get_users_list["country"] ?>
								</td>
								<td>
									<a class="btn btn-sm default light-blue"  
									 href="<?php echo base_url();?>complaint/update_vendor/<?php echo $get_users_list["pk_vendor_id"];?>">
									 <i class="fa fa-edit"></i>
										Update
									 </a>
									<a  class="btn btn-sm default red-thunderbird"  
									href="<?php echo base_url();?>complaint/delete_vendor/<?php echo $get_users_list["pk_vendor_id"];?>"
									onClick="return confirm('Are you sure you want to delete?')">
									<i class="fa fa-trash-o"></i> &nbsp;&nbsp;Delete
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
<?php $this->load->view('footer');?>
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
								{ type: "text" }
						]

		});
});

</script>