<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    DC
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                View DC
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
                            <div class="caption"> <i class="fa fa-globe"></i>Managed Table </div>
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
                                    <th>
                                         DC #
                                    </th>
                                    <th>
                                         DC Date
                                    </th>
                                    <th>
                                         TS number
                                    </th>
                                    <th>
                                         Equipment
                                    </th>
                                    <th>
                                         S/No
                                    </th>
                                    <th>
                                         Part #
                                    </th>
                                    <th>
                                         Part Description
                                    </th>
                                    <th>
                                         Customer
                                    </th>
                                    <th>
                                         Cleint
                                    </th>
                                    
                                    <th>
                                         Status
                                    </th>
                                    <th>
                                         Print
                                    </th>
                                    <th>
                                         Print Count 
                                    </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
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
											return "$difference $periods[$j] {$tense}";
										}

									  
									  if (sizeof($get_complaint_list) == "0") {
										  
									  } else {
										  foreach ($get_complaint_list as $complaint_list) {
											  ?>
											  <tr class="odd gradeX">
                                                  <td>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_direct_challans 
													  						where fk_ts_id='".$complaint_list["pk_complaint_id"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["pk_DC_Number"] ?>
												  </td>
                                                  <td>
													  <?php echo  date('d-M-Y', strtotime($rt[0]["DC_date"]));?>
												  </td>
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php  $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
													  $rt=$ty->result_array();
													  ?>
                                                      <?php echo $rt[0]["serial_no"]; ?>
												  </td>
                                                  <td>
                                                  	<?php 
													  $ty=$this->db->query("select * from tbl_instruments 
													  where serial_no='".$rt[0]["serial_no"]."'");
													  $rt=$ty->result_array();
													  //
													  $ty2=$this->db->query("select * from tbl_brand 
													  where pk_brand_id='".$rt[0]["fk_brand_id"]."'");
													  $rt2=$ty2->result_array();
													  echo $rt2[0]["brand_secondry_name"] 
													?>
                                                  </td>
												  <td>
													<?php $ty=$this->db->query("select * from tbl_sprf 
																				where fk_complaint_id='".$complaint_list["pk_complaint_id"]."'");
													  $rt=$ty->result_array();
													  foreach($rt as $sprf)
													  {
														   $ty2=$this->db->query("select * from tbl_parts 
														  							where pk_part_id='".$sprf["fk_part_id"]."'");
															$rt2=$ty2->result_array();
															echo $rt2[0]['part_number'].'<br>';
													  }
													  ?>
												  </td>
                                                  <td>
													<?php $ty=$this->db->query("select * from tbl_sprf 
																				where fk_complaint_id='".$complaint_list["pk_complaint_id"]."'");
													  $rt=$ty->result_array();
													  foreach($rt as $sprf)
													  {
														   $ty2=$this->db->query("select * from tbl_parts 
														  							where pk_part_id='".$sprf["fk_part_id"]."'");
															$rt2=$ty2->result_array();
															echo $rt2[0]['description'].'<br>';
													  }
													  ?>
												  </td>
                                                  <!--cutomer-->
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from tbl_instruments 
													  where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
													  $rt=$ty->result_array();
													  //
													  $ty2=$this->db->query("select * from tbl_clients 
													  where pk_client_id='".$rt[0]["fk_client_id"]."'");
													  $rt2=$ty2->result_array();
													  echo $rt2[0]["client_name"];
													  
													   ?>
												  </td>
                                                  <td>
                                                      <?php 
													  //
													  $ty3=$this->db->query("select * from tbl_cities 
													  where pk_city_id='".$rt2[0]["fk_city_id"]."'");
													  $rt3=$ty3->result_array();
													  echo $rt3[0]["city_name"]; ?>
												  </td>
												  <td>
													  <?php if( $complaint_list["status"]=="Pending"){ ?><span class="label label-sm label-success"> Pending </span><?php }?>
                                                      <?php if( $complaint_list["status"]=="Completed"){ ?><span class="label bg-blue"> completed </span><?php }?>
                                                      <?php if( $complaint_list["status"]=="Bounce Back"){ ?><span class="label label-sm label-warning"> Bounce Back </span><?php }?>
                                                      <?php if( $complaint_list["status"]=="Call Supervisor"){ ?><span class="label label-sm label-danger">Call Supervisor</span><?php }?>
                                                      <?php if( $complaint_list["status"]=="SPRF_Approved"){ ?><span class="label label-sm label-warning"> SPRF_Approved </span><?php }?>
												  </td>
                                                  <td>
													  <a class="btn btn-default" href="javascript:void()" onclick="PrintElem('.content')">Print</a>
												  </td>
                                                  <td>
										  <?php 
                                          $ty=$this->db->query("select * from tbl_direct_challans where fk_ts_id='".$complaint_list["pk_complaint_id"]."'");
                                          $rt=$ty->result_array();
                                          echo '<span id="print_count_span">'.$rt[0]["print_count"].'</span>' ?>
                                          <input type="hidden" id="print_count" value="<?php echo $rt[0]["print_count"]; ?>" />
                                          <input type="hidden" id="complaint_id" value="<?php echo $complaint_list["pk_complaint_id"]; ?>" />
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