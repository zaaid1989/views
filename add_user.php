<?php include('header.php');?>
            
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Add <small>User</small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
                        <li> Users <i class="fa fa-angle-right"></i> </li>
                        <li> Add User </li>
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="tabbable tabbable-custom boxless tabbable-reversed">
                          <ul class="nav nav-tabs">
                            <li class="active"> <a href="#tab_0" data-toggle="tab"> Form Actions </a> </li>
                          </ul>
                          <div class="tab-content">
                            <div class="tab-pane active" id="tab_0">
                              <div class="portlet box green">
                                <div class="portlet-title">
                                  <div class="caption"> <i class="fa fa-gift"></i>Form Actions On Bottom </div>
                                  <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                                </div>
                                <div class="portlet-body form"> 
                                  <!-- BEGIN FORM-->
                                  <?php if(isset($message))
									  { 
										echo '<div class="alert alert-danger alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												User Already Exist.  
											  </div>';
									  }
									  
								?>
                                    <!-- BEGIN FORM-->
                                    <form action="<?php echo base_url(); ?>profile/insert_user" id="form_sample_1" method="post" 
                                    class="form-horizontal" enctype="multipart/form-data" >
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button>
                                                You have some form errors. Please check below.
                                            </div>
                                            

                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-3">First Name <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="first_name" data-required="1" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Last Name <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="last_name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Username <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                <input type="text" name="username" class="form-control"><?php if(isset($message)){ echo '<p style="color:red;">'.$message.'</p>';}?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Email <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="email" name="email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Password <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Mobile <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="mobile" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Landline <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="landline" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Address <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="address" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Date Of Birth <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="DOB" class="form-control datepicker">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Designation<span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="designation" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Department <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="department" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">City <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="city" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Office <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="office" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">User Role <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="userrole" class="form-control">
                                                      <?php 
													  	$tbl_designations=$this->db->query("select * from tbl_designations");
														$dataa=$tbl_designations->result_array();
														foreach($dataa as $val)
														{
													  ?>
                                                      <option value="<?php echo $val['name']?>"><?php echo $val['name']?></option>
                                                      <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Image <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <span class="btn green fileinput-button">
                                                        <i class="fa fa-plus"></i>
                                                        <span>
                                                            Add files... </span>
                                                        <input type="file" name="uploadFile">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green">Add</button>
                                                    <!--<button type="reset" class="btn default">Cancel</button>-->
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                  <!-- END FORM--> 
                                </div>
                              </div>
                             </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- END PAGE CONTENT--> 
                </div>
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>

        </div>
        <!-- END CONTAINER -->
        
        <?php include('footer.php');?>