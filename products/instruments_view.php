<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Instruments <small>Installation Details</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Instruments
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
                            <div class="caption"> <i class="fa fa-globe"></i>Instruments </div>
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
                                         Instrument  
                                    </th>
                                    <th>
                                         Serial No  
                                    </th>
                                    <th>
                                         Client Name 
                                    </th>
                                    <th>
                                         City
                                    </th>
                                    <th>
                                         Office  
                                    </th>
                                    <th>
                                         Install Date  
                                    </th>
                                    <th>
                                         Inspection Month 
                                    </th>
                                    <th>
                                         History  
                                    </th>
                                 </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_instruments_list) == "0") {
										  
									  } else {
										  foreach ($get_instruments_list as $instruments_list) {
											  ?>
											  <tr class="odd gradeX">
												  <th class="table-checkbox">
                                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                    </th>
                                                  <td>
                                                      <?php $ty5=$this->db->query("select * from tbl_brand where pk_brand_id='".$instruments_list["fk_brand_id"]."'");
													  $rt5=$ty5->result_array();
													  echo $rt5[0]["brand_secondry_name"] ?>
												  </td>
                                                  <td>
													   <?php echo $instruments_list["serial_no"] ?>
												  </td>
												  <td>
													  <?php $ty=$this->db->query("select * from tbl_clients where pk_client_id='".$instruments_list["fk_client_id"]."'");
													  $rt=$ty->result_array();
													  //print_r($rt);
													  echo $rt[0]["client_name"] ?>
												  </td>
                                                  <td>
													  <?php $ty2=$this->db->query("select * from tbl_cities where pk_city_id='".$rt[0]["fk_city_id"]."'");
													  $rt2=$ty2->result_array();
													  echo $rt2[0]["city_name"] ?>
												  </td>
                                                  <td>
													   <?php $ty23=$this->db->query("select * from tbl_offices where pk_office_id='".$instruments_list["fk_office_id"]."'");
													  $rt23=$ty23->result_array();
													  echo $rt23[0]["office_name"] ?>
												  </td>
												  <td>
													  <?php echo $instruments_list["install_date"] ?>
												  </td>
                                                  <td>
													  <?php echo $instruments_list["install_date"] ?>
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