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


							if($this->session->userdata('userrole')=="Supervisor")
							{
								$pending_sprf_query=" SELECT * FROM tbl_complaints  where fk_office_id='".$this->session->userdata('territory')."' 
													  AND status IN('Pending SPRF') 
													  AND complaint_nature='complaint'  
													  order by `pk_complaint_id` DESC";
							}
							else
							{
								$pending_sprf_query=" SELECT * FROM tbl_complaints  where  status IN('Pending SPRF') 
													  AND complaint_nature='complaint'  
													  order by `pk_complaint_id` DESC";
							}
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
                                              $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint_list["fk_city_id"]."'");
                                              $rt=$ty->result_array();
                                              echo $rt[0]["city_name"] ?>
                                          </td>
										  <td>
                                              <?php    
												$nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$complaint_list['fk_customer_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['client_name'];
												?>
                                          </td>
											
										  <td>
										  <?php 
												$nsql3=$this->db->query("select area from tbl_area where pk_area_id ='".$n2sql3[0]['fk_area_id']."'");
												$n2sql3=$nsql3->result_array();
												echo $n2sql3[0]['area'];
												?>
										  </td>

                                          <td>
                                              <?php 
                                              $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
                                              $rt=$ty->result_array();
                                              //echo $rt[0]["fk_brand_id"];
											  if($ty->num_rows()>0)
											  {
												  $ty2=$this->db->query("select * from tbl_products where pk_product_id='".$rt[0]["fk_product_id"]."'");
												  $rt2=$ty2->result_array();
												  echo $rt2[0]["product_name"];
											  }
                                              //echo $complaint_list["instrument_name"] ?>
                                          </td>
                                          <td>
                                              <?php 
											  if($ty->num_rows()>0)
											  {
											  	echo $rt[0]["serial_no"]; 
											  }
											  ?>
                                          </td>
                                          <td>
                                              <?php echo substr($complaint_list["problem_summary"], 0, 30); ?>
                                          </td>
                                          <td>
											  <?php 
                                              $ty=$this->db->query("select * from user where id ='".$complaint_list["assign_to"]."'");
                                              $rt=$ty->result_array();
                                              echo $rt[0]["first_name"];
                                              //echo $complaint_list["FSE_SAP"] ?>
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