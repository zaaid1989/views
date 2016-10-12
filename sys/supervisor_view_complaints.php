<?php $this->load->view('header');?>
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
//end nice time fucntion
function nicetime_two_parameters($start_date, $end_date)
{
	
	if(empty($start_date)) {
		return "No date provided";
	}
	$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths         = array("60","60","24","7","4.35","12","10");
	$unix_start_date         = strtotime($start_date);
	$unix_end_date   = strtotime($end_date);
	   // check validity of date
	if(empty($unix_start_date)) {   
		return "Bad date";
	}
	// is it future date or past date
	if($unix_end_date > $unix_start_date) {   
		$difference     = $unix_end_date - $unix_start_date;
		$tense         = "";
	} else {
		$difference     = $unix_start_date - $unix_end_date;
		$tense         = "";
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
//
function time_elapsed_string3($start_dat, $end_date, $full) {
	$from_timezone = 'America/New_York';
	$tz1 = new DateTimezone($from_timezone);
	$now = new DateTime($end_date, $tz1);
	$ago = new DateTime($start_dat, $tz1);
	$diff = $now->diff($ago);
	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . '' : '';
}
?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Complaints List <small></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home 
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        Complaints List                        
                    </li> 
                    
                </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
					  <?php
						  if(isset($_GET['msg']))
							{ 
							  echo '<div class="alert alert-success alert-dismissable">  
									  <a class="close" data-dismiss="alert">×</a>  
									  Complaint Added Successfully.  
									</div>';
							}
							
							if(isset($_GET['msg_update']))
							{ 
							  echo '<div class="alert alert-success alert-dismissable">  
									  <a class="close" data-dismiss="alert">×</a>  
									  Complaint Updated Successfully.  
									</div>';
							}
							
							if(isset($_GET['msg_delete']))
							  { 
								echo '<div class="alert alert-success alert-dismissable">  
										<a class="close" data-dismiss="alert">×</a>  
										Complaint Deleted Successfully.  
									  </div>';
							  }
						?>
					  <?php /*
						 $m	=	1;
						for ($m=1;$m<4;$m++)  {
							echo $m; */
					  ?>
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
<?php
$portlet_status_array		=		array("NOT IN ('Pending Verification','Pending SPRF', 'Closed','Pending Registration')","IN ('Pending Verification')","IN ('Pending SPRF')","IN ('Closed')");
$portlet_color		=		array('red-intense','yellow-zed','purple','green-meadow');
$portlet_title		=		array('Complaints | Pending','Complaints | Pending Verification','Complaints | Pending SPRF','Complaints | Closed');

for($i=0;$i<4;$i++) {
?>
                        <div class="portlet box <?php echo $portlet_color[$i]; ?>">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa icon-book-open"></i><?php echo $portlet_title[$i]; ?></div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                         
							<?php if($i==0 && $this->session->userdata('userrole')=='Admin') { ?>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>sys/add_sys/d" id="sample_editable_1_new" class="btn purple"> Add New <i class="fa fa-plus"></i> </a>
                                  </div>
                                </div>
                                
                              </div>
							<?php } ?>
                            </div>
                          <div class="portlet-body flip-scroll">
                          <table class="table table-striped table-bordered table-hover flip-content <?php  echo "table_3";?>" id="<?php //echo "table_".$i;?>">
                              <thead class="bg-grey-cascade">
								<tr>
                                    <th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<?php if($i==2) echo '<th> </th>'; ?>
                                </tr>
                                <tr>
                                    <th>TS number </th>
									<th>Date </th>
									<th>Time Elapsed </th>
									<th>Time Taken </th>
									<th>City </th>
									<th>Customer </th>
									<th>Equipment </th>
									<th>S/No </th>
									<th>Problem Summary </th>
									<th>FSE/SAP </th>
									<th>Status </th>
									<th>Actions </th>
									<th>Comments </th>
									<?php if($i==2) echo '<th>SPRF Time </th>'; ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  
									  $status_variable = $portlet_status_array[$i];
									  $supervisor_condition = "";
									  if ($this->session->userdata('userrole')=="Supervisor") $supervisor_condition = "AND tbl_complaints.fk_office_id='".$this->session->userdata('territory')."'";
									  $dbres = $this->db->query("SELECT tbl_complaints.*, 
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
									  
									  WHERE tbl_complaints.complaint_nature='complaint' AND tbl_complaints.status $status_variable $supervisor_condition
									  
									  order by `pk_complaint_id` DESC");
           							  $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											  // Time Taken
											$time_taken = "N/A";
											$sprf_time = "N/A";
											if($complaint_list["status"]=='Closed')
												$time_taken = nicetime_two_parameters($complaint_list["date"],$complaint_list["solution_date"]);
											// Closed Since or Time Elapsed
											$time_elapsed = "";
											if($complaint_list["status"]=='Closed') $time_elapsed = "Closed ". nicetime($complaint_list["solution_date"]); 
											else $time_elapsed =  nicetime($complaint_list["date"]);
											// SPRF Time
											if($complaint_list['sprf_date']!='0000-00-00 00:00:00') $sprf_time = nicetime($complaint_list['sprf_date']);
											
													  
											  ?>
											  <tr class=" <?php if($complaint_list['urgent_priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
                                                  
												<td><?php echo $complaint_list["ts_number"] ?></td>
												<td><?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?></td>
												<td><?php echo $time_elapsed; ?></td> 
												<td><?php echo $time_taken; ?></td>                                             
												<td><?php echo $complaint_list["city_name"]; ?></td>
												<td><?php echo $complaint_list["client_name"];?></td>
												<td><?php echo $complaint_list["product_name"]; ?></td>
												<td><?php echo $complaint_list["serial_no"];?></td>
												<td><?php echo $complaint_list["problem_summary"]; ?></td>
												<td><?php echo $complaint_list["first_name"];?></td>
												<td>
															  <?php 
																	  $this->load->model("complaint_model");
																	  $obj=new Complaint_model();
																	  $obj->current_status($complaint_list['status']);
																?>
														  </td>
												<td>
										  <div class="btn-group-vertical btn-group-solid">
										  <?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') {?>
                                          <a class="btn btn-sm default purple-stripe" 
                                          href="<?php echo base_url();?>sys/technical_service_pvr/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	TSR 
											<i class="fa fa-eye"></i>
                                          </a>
                                          <?php if($this->session->userdata('userrole')=='Admin'){?>
                                          <a class="btn btn-sm default red-thunderbird-stripe" onClick="return confirm('Are you sure you want to delete?')" 
                                            href="<?php echo base_url();?>sys/delete_sys/<?php echo $complaint_list["pk_complaint_id"];?>">
                                              Delete <i class="fa fa-trash-o"></i>
                                            </a>
											
											<?php if ($i!=3) { ?>
											<a class="btn btn-sm default blue-stripe" onClick="return confirm('Are you sure you want to edit?')" 
                                            href="<?php echo base_url();?>sys/add_complaint_registration/<?php echo $complaint_list["pk_complaint_id"];?>">
                                              Edit <i class="fa fa-edit"></i>
                                            </a>
												<?php }?>
											<?php }?>
                                            <?php if ($i!=3) { ?>
											<a class="btn btn-sm default yellow-zed-stripe" 
                                          href="<?php echo base_url();?>sys/shift_sys/<?php echo $complaint_list["pk_complaint_id"] ?>">
											Shift 
											<i class="fa fa-share"></i>
                                          </a>
										  <?php }?>
										   <?php if($i==1 || $i==0) {?>
                                          <a class="btn btn-sm default green-haze-stripe" 
                                              href="<?php echo base_url();?>sys/sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                              	SPRF
                                          </a>
                                          <?php }?>
										  <?php if($i==2) {?>
                                          <a class="btn btn-sm default green-haze-stripe" 
                                              href="<?php echo base_url();?>sys/supervisor_sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                              	SPRF
                                          </a>
                                          <?php }?>
										  <?php }?>
										  
										 <!-- Actions for Supervisor -->
										  <?php if($this->session->userdata('userrole')=='Supervisor' ) {?>
                                          <a class="btn btn-sm default purple-stripe" 
                                          href="<?php echo base_url();?>sys/technical_service_pvr/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	TSR 
											<i class="fa fa-eye"></i>
                                          </a>
										  <?php if($i==2) {?>
                                          <a class="btn btn-sm default green-haze-stripe" 
                                              href="<?php echo base_url();?>sys/supervisor_sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                              	SPRF
                                          </a>
                                          <?php }?>
										  
										  <?php }?>
										  </div>
                                          </td>
										  
										  <?php
												$userid		=	$this->session->userdata('userid');
												$userrole	=	$this->session->userdata('userrole');
												$complaint_id =	$complaint_list["pk_complaint_id"];
												$count_msgs	=	0;
												$count_msgs_r	=	0;
												$countfield	=	'read_director';
												
												if($userrole=='Admin') $countfield = 'read_director';
												if($userrole=='secratery') $countfield = 'read_secratery';
												if($userrole=='Supervisor') $countfield = 'read_supervisor';
												if($userrole=='FSE' || $userrole=='Salesman') $countfield = 'read_employee';
												
												$cq			=	"select * from tbl_comments where `fk_complaint_id`='".$complaint_id."' AND `".$countfield."`=0";
												$cr			=	$this->db->query($cq);
												$count_msgs	=	sizeof($cr->result_array());
												
												$cq			=	"select * from tbl_comments where `fk_complaint_id`='".$complaint_id."'";
												$cr			=	$this->db->query($cq);
												$count_msgs_r	=	sizeof($cr->result_array());
												
												$cq			=	"select * from tbl_dvr where `fk_complaint_id`='".$complaint_id."'";
												$cr			=	$this->db->query($cq);
												$count_msgs_r	+=	sizeof($cr->result_array());
											?>	
										  <td>
												<a class="icon-btn" 
													  href="<?php echo base_url();?>sys/comments/<?php echo $complaint_list["pk_complaint_id"] ?>">                                         	
														<i class="fa fa-comments-o"></i>
														<div>Comments</div>
														<?php if ($count_msgs>0) {?>
															<span class="badge bg-blue">
															<?php echo $count_msgs; ?>
															</span>
														<?php } ?>
														<?php if ($count_msgs==0 && $count_msgs_r>0) {?>
															<span class="badge bg-grey-cascade">
															<?php echo $count_msgs_r; ?>
															</span>
														<?php } ?>
												</a>
										  </td>
										  <?php if($i==2) echo '<td>'.$sprf_time.'</td>'; ?>

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
<?php } ?>
                        
                        
                        
						<?php //} ?>
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
			var table = $('.table_1').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
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
		var table2 = $('.table_2').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
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
		var table3 = $('.table_3').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
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
		var table4 = $('.table_4').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
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
