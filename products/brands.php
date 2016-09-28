<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Brands <small>View</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#">Data Tables</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#">Managed Datatables</a>
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
                            <div class="caption"> <i class="fa fa-globe"></i>Managed Table </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
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
                                    <a href="<?php echo base_url();?>complaint/add_complaint" id="sample_editable_1_new" class="btn green"> Add New <i class="fa fa-plus"></i> </a>
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
                                         Manufacturer
                                    </th>
                                    <th>
                                         Equipment 
                                    </th>
                                    <th>
                                         Category 
                                    </th>
                                    <th>
                                         Inspection Month 
                                    </th>
                                    
                                    <th>
                                         Total active 
                                    </th>
                                    <th>
                                         Total Inactive
                                    </th>
                                    <th>
                                         Installation pending 
                                    </th>
                                    <th>
                                         Stock 
                                    </th>
                                    <th>
                                         Edit 
                                    </th>
                                 </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_brands_list) == "0") {
										  
									  } else {
										  foreach ($get_brands_list as $brands_list) {
											  ?>
											  <tr class="odd gradeX">
												  <th class="table-checkbox">
                                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                    </th>
                                                  <td>
													  <?php echo $brands_list["brand_primry_name"] ?>
												  </td>
                                                  <td>
													  <?php echo $brands_list["brand_secondry_name"] ?>
												  </td>
                                                  <td>
													  <?php echo $brands_list["category"] ?>
												  </td>
                                                  <td>
													  <?php $rt = $this->db->query("SELECT * FROM tbl_inspection_months  where fk_brand_id='".$brands_list["pk_brand_id"]."'") ;
													  		$newe=$rt->result_array();
															foreach($newe as $serial_nos)
															{
																echo date('F',strtotime('2000-'.$serial_nos['month'].'-01')).', ';
															}
													  ?>
												  </td>
                                                  <td>
													  <?php $rt = $this->db->query("SELECT * FROM tbl_instruments  where fk_brand_id='".$brands_list["pk_brand_id"]."'") ;
													  		$newe=$rt->result_array();
															$ncount=0;
															foreach($newe as $serial_nos)
															{
																//echo $serial_nos['serial_no'].'<br>';
																$ncount++;
															}
															echo $ncount;
													  ?>
												  </td>
												  <td>
													  <?php 
													  		$rt = $this->db->query("SELECT * FROM tbl_instruments  where fk_brand_id='".$brands_list["pk_brand_id"]."'") ;
													  		$newe=$rt->result_array();
															foreach($newe as $serial_nos)
															{
																$rt2 = $this->db->query("SELECT * FROM tbl_clients  where pk_client_id='".$serial_nos["fk_client_id"]."'") ;
													  			$newe2=$rt2->result_array();
																//echo $newe2[0]['client_name'].'<br>';
															}
															echo '4';
															 ?>
												  </td>
                                                  <td>
													  10
												  </td>
                                                  <td>
													  7
												  </td>
                                                  <td>
													  <a class="btn btn-default" href="technical_service_pvr.php">Edit</a>
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