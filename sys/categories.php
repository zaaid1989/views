<?php $this->load->view('header.php');?>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Categories <small>Manage categories for Vendors and Products</small> </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> </li>
              <li> Categories </li>
            </ul>
            
          </div>
          <!-- END PAGE HEADER--> 
          <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet box purple">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-shuffle"></i>Categories </div>
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
                                      Category Added Successfully.  
                                    </div>';
                            }
                        ?>
                        <?php
                          if(isset($_GET['upt']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Category Updated Successfully.  
                                    </div>';
                            }
                        ?>
                        <?php
                          if(isset($_GET['msg_delete']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Category Deleted Successfully.  
                                    </div>';
                            }
                        ?>
                        
                    <div class="row">
                      <div class="col-md-6">
                        <div class="btn-group">
                          <a href="<?php echo base_url();?>sys/add_category" id="sample_editable_1_new" class="btn light-blue"> 
                              Add New Category
                              <i class="fa fa-plus"></i> 
                          </a>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                 <div class="portlet-body flip-scroll">
                 <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                    <thead>
                      <tr>
                        
                        <th> Category 				</th>
                       <!-- <th> Type 					</th>-->
                        <th> Actions 				</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                            $ty22=$this->db->query("select * from tbl_category where status='0'");
                            $rt22=$ty22->result_array();
                            if (sizeof($rt22) == "0") {
                                
                            } else {
                                foreach ($rt22 as $get_users_list) {
                                    ?>
                                    <tr class="odd gradeX">
                                        
                                        <td>
                                            <?php echo $get_users_list["category_name"] ?>
                                        </td>
                                        <td>
													<a class="btn btn-sm default purple-stripe"  
                                                     href="<?php echo base_url();?>sys/update_category/<?php echo $get_users_list["pk_category_id"];?>">
													 <i class="fa fa-edit"></i>
                                                      	Update
                                                     </a>

													<a class="btn btn-sm default red-thunderbird"  
													href="<?php echo base_url();?>sys/delete_category/<?php echo $get_users_list["pk_category_id"];?>"
													onClick="return confirm('Are you sure you want to delete?')">
													<i class="fa fa-trash-o"></i>
														Delete
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