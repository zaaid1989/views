<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Parts <small>View</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Parts
                                <i class="fa fa-angle-right"></i>
                            </li>
                            
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box grey-cascade">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Parts </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Complaint Added Successfully.  
											  </div>';
									  }
								  ?>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>sys/add_complaint" id="sample_editable_1_new" class="btn green"> Add New <i class="fa fa-plus"></i> </a>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="btn-group pull-right">
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i> </button>
                                    <ul class="dropdown-menu pull-right">
                                      <li> <a href="#"> Print </a> </li>
                                      <li> <a href="#"> Save as PDF </a> </li>
                                      <li> <a href="#"> Export to Excel </a> </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                                      <div class="portlet-body flip-scroll">
                                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                    <th class="table-checkbox">
                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                    </th>
                                    <th>
                                          Part Name   
                                    </th>
                                    <th>
                                         Part #   
                                    </th>
                                    <th>
                                         Quantity 
                                    </th>
                                    <th>
                                         Update   
                                    </th>
                                 </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_parts_list) == "0") {
										  
									  } else {
										  foreach ($get_parts_list as $parts_list) {
											  ?>
											  <tr class="odd gradeX">
												  <th class="table-checkbox">
                                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                    </th>
                                                  <td>
													  <?php echo $parts_list["part_name"] ?>
												  </td>
                                                  <td>
													   <?php echo $parts_list["part_number"] ?>
												  </td>
                                                  <td>
													  <?php echo $parts_list["stock_quantity"] ?>
												  </td>
                                                  
                                                  <td>
													  <a class="btn btn-default" href="technical_service_pvr.php">View</a>
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
                      </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer');?>