<?php $this->load->view('header');?>
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
            Complaint <small>Pending SPRF</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        Complaints (Pending SPRF)                     
                    </li>                    
                </ul>
            </div>
            <!-- END PAGE HEADER--> 
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
              <div class="col-md-12"> 
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box yellow-crusta">
                  <div class="portlet-title">
                    <div class="caption"> <i class="fa fa-globe"></i>Complaints Pending SPRF</div>
                    <div class="tools"> <a href="javascript:;" class="collapse"> </a> 
                    
                    <a href="javascript:;" class="remove"> </a> </div>
                  </div>
                  <div class="portlet-body">
                    <div class="table-toolbar">
                        <?php
                            if(isset($_GET['msg']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        '.$_GET['msg'].'  
                                      </div>';
                              }
                          ?>
                      <div class="row">
                        
                        
                      </div>
                    </div>
               		<div class="portlet-body flip-scroll">
                     <table class="table table-striped table-bordered table-hover flip-content dataaTable" id="">
                      <thead>
						<tr>
						<th class="table-checkbox"></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
							<th></th>
							<th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
						</tr>
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
                                 Time Elapsed
                            </th>
							
                            <th>
                                 City
                            </th>
                            <th>
                                 Customer
                            </th>
                            <th>
                                 Area
                            </th>
                            
							<th>
                                 Equipment
                            </th>
                            
                            <th>
                                 S/No
                            </th>
                            <th>
                                 Problem Summary
                            </th>
                            <th>
                                 FSE/SAP
                            </th>
                            <th>
                                 Status
                            </th>
                            
                            <th>
                                 SPRF Form
                            </th>
                            <th>
                                 SPRF Time
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

							$pending_sprf_query=" SELECT tbl_complaints.*, 
									  COALESCE(tbl_cities.city_name) AS city_name,
									  COALESCE(tbl_clients.client_name) AS client_name,
									  COALESCE(tbl_area.area) AS area,
									  COALESCE(user.first_name) AS first_name,
									  COALESCE(tbl_instruments.serial_no) AS serial_no,
									  COALESCE(tbl_products.product_name) AS product_name 
									  
									  FROM tbl_complaints 
									  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
									  LEFT JOIN user ON tbl_complaints.assign_to = user.id
									  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
									  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id 
							
							WHERE  tbl_complaints.status IN('Pending SPRF') AND complaint_nature='complaint'  ";
							if($this->session->userdata('userrole')=="Supervisor") {
								$pending_sprf_query .= " AND tbl_complaints.fk_office_id='".$this->session->userdata('territory')."'";
							}
							
							$pending_sprf_query  .= " order by `pk_complaint_id` DESC";
							$dbres = $this->db->query($pending_sprf_query);
							$dbresResult=$dbres->result_array();



                              if (sizeof($dbresResult) == "0") 
                              {
                                //do somthing  
                              } else {
                                  foreach ($dbresResult as $complaint_list) {
                                      ?>
                                      <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                          <th class="table-checkbox">
                                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
                                            </th>
                                          <td>
                                              <?php echo $complaint_list["ts_number"] ?>
                                          </td>
                                          <td>
                                              <?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?>
                                          </td>
                                          <td>
                                              <?php 
                                                //$nowtime = strtotime(date('Y-m-d H:i:s'));
                                                echo nicetime($complaint_list["date"]);
                                                //echo time_elapsed_B($nowtime - strtotime($complaint_list["date"]));
                                              //echo $complaint_list["date"] ?>
                                          </td>
                                                                                   
                                          <td>
                                              <?php 
                                              
                                              echo $complaint_list["city_name"]; ?>
                                          </td>
										  <td>
                                              <?php    
												
												echo $complaint_list["client_name"];
												?>
                                          </td>
											
										  <td>
										  <?php 
												
												echo $complaint_list["area"];
												?>
										  </td> 
										  
										  <td>
                                              <?php 
                                              echo $complaint_list["product_name"]; ?>
                                          </td>
                                          <td>
                                              <?php 
											  echo $complaint_list["serial_no"];
											  ?>
                                          </td>
										  
                                          <td>
                                              <?php echo substr($complaint_list["problem_summary"], 0, 30); ?>
                                          </td>
                                          <td>
													  <?php 
													  echo $complaint_list["first_name"]; ?>
										</td>

                                          <td>
                                          <?php 
											$this->load->model("complaint_model");
											$obj=new Complaint_model();
											$obj->current_status($complaint_list['status']);
										  ?>
                                          </td>
                                          <td>
                                          <a class="btn btn-default" href="<?php echo base_url();?>products/supervisor_sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	Open Form
                                          </a>
                                          </td>
                                          <td>
                                          	<?php 
                                                if($complaint_list['sprf_date']!='0000-00-00 00:00:00')
												{
													echo nicetime($complaint_list['sprf_date']);
												}
												else
												{
													echo "N/A";
												}
											 ?>
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
<script>
		$(document).ready(function() { 
			var table = $('.dataaTable').dataTable({
			  'iDisplayLength': 500,
			  'aaSorting':[]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	null,
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
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
	});
</script>