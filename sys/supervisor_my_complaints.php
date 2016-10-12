<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Supervisor <small>My Complaints</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Supervisor Complaints
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
                            <div class="caption"> <i class="fa fa-globe"></i>Supervisor Complaints </div>
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
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
                                    <th>
                                         Customer
                                    </th>
                                    <th>
                                         City
                                    </th>
                                    <th>
                                         Problem Summary
                                    </th>
                                    <th>
                                         Time Elapsed
                                    </th>
                                    <th>
                                         Status
                                    </th>
                                    
                                    <th>
                                         TS Report
                                    </th>
                                    <th>
                                         SPRF 
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
												  <th class="table-checkbox">
                                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                                    </th>
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php echo date('d-M-Y', strtotime($complaint_list["date"])); ?>
												  </td>
												  <td>
													  <?php echo $complaint_list["caller_name"] ?>
												  </td>
                                                  <td>
													  <?php //echo $complaint_list["city"] ?>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint_list["fk_city_id"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["city_name"] ?>
												  </td>
                                                  <td>
													  <?php echo $complaint_list["problem_summary"] ?>
												  </td>
                                                  <td>
													  <?php echo nicetime($complaint_list["date"]); ?>
												  </td>
												  <td>
													  <?php if( $complaint_list["status"]=="Pending"){ ?><span class="label label-sm label-success"> Pending </span><?php }?>
                                                      <?php if( $complaint_list["status"]=="Completed"){ ?><span class="label bg-blue"> completed </span><?php }?>
                                                      <?php if( $complaint_list["status"]=="Bounce Back"){ ?><span class="label label-sm label-warning"> Bounce Back </span><?php }?>
                                                      <?php if( $complaint_list["status"]=="Call Supervisor"){ ?><span class="label label-sm label-danger">Call Supervisor</span><?php }?>
												  </td>
                                                  <td>
													  <a class="btn btn-default" href="technical_service_pvr.php">Open Form</a>
												  </td>
                                                  <td>
													  <a class="btn btn-default" href="<?php echo base_url();?>products/supervisor_sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">Open Form</a>
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