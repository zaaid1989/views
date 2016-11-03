
<?php
//echo "zaaid";
function nicetime($date)
{
	/*
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
		$tense         = "";
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
	return "$difference $periods[$j] {$tense}";*/
	$start_date = $date;
	$end_date = date('Y-m-d H:i:s');
	$time_difference = "";
	//if ($end_date<$start_date) $start_date = date('Y-m-d H:i:s', strtotime($start_date) - 12 * 3600);
	$diff = abs(strtotime($end_date) - strtotime($start_date));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
	$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ (60));
	$time_difference = (($years > 0) ? $years.' year'.(($years > 1 ? 's ' : '')) : '').(($months > 0) ? (($months == 1) ? ' '.$months.' month' : ' '.$months.' months' ) : '').(($days > 0) ? (($days == 1) ? ' '.$days.' day' : ' '.$days.' days' ) : '').(($hours > 0) ? (($hours == 1) ? ' '.$hours.' hour' : ' '.$hours.' hours' ) : '').(($minutes > 0) ? (($minutes == 1) ? ' '.$minutes.' minute' : ' '.$minutes.' minutes' ) : '');
	/*if ($time_difference == "") {
		$hours = 0;
		$minutes = 0;
		$dateDiff = intval((strtotime($end_date)-strtotime($start_date))/60);
		$hours = intval($dateDiff/60);
		$minutes = $dateDiff%60;
		if ($hours != 0) $time_difference = $hours.' Hours '. $minutes. ' Minutes';
		else $time_difference =  $minutes. ' Minutes';
	}*/
	return $time_difference;
}
//end nice time fucntion
function nicetime_two_parameters($start_date, $end_date)
{
	/*
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
	return "$difference $periods[$j] {$tense}"; */
	
	$time_difference = "";
	//if ($end_date<$start_date) $start_date = date('Y-m-d H:i:s', strtotime($start_date) - 12 * 3600);
	$diff = abs(strtotime($end_date) - strtotime($start_date));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
	$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ (60));
	$time_difference = (($years > 0) ? $years.' year'.(($years > 1 ? 's ' : '')) : '').(($months > 0) ? (($months == 1) ? ' '.$months.' month' : ' '.$months.' months' ) : '').(($days > 0) ? (($days == 1) ? ' '.$days.' day' : ' '.$days.' days' ) : '').(($hours > 0) ? (($hours == 1) ? ' '.$hours.' hour' : ' '.$hours.' hours' ) : '').(($minutes > 0) ? (($minutes == 1) ? ' '.$minutes.' minute' : ' '.$minutes.' minutes' ) : '');
	/*if ($time_difference == "") {
		$hours = 0;
		$minutes = 0;
		$dateDiff = intval((strtotime($end_date)-strtotime($start_date))/60);
		$hours = intval($dateDiff/60);
		$minutes = $dateDiff%60;
		if ($hours != 0) $time_difference = $hours.' Hours '. $minutes. ' Minutes';
		else $time_difference =  $minutes. ' Minutes';
	}*/
	return $time_difference;
	
}

function pm_frequency($rtz) {
$average_pm_frequency = "N/A";

$days_since_last_pm = "N/A";
//$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$e."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
//$rtz	= 	$tyz->result_array();
$total_pms_c	=	sizeof($rtz);

//echo $total_pms_c.'-';
if ($total_pms_c > 1 ) {
		$max_pms_index		=	$total_pms_c - 1;
		$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
		$last_pm			=	strtotime($rtz[0]['finish_time']);
		$diff				=	$last_pm - $first_pm;
		$total_days			=	floor($diff/(60*60*24));
		$pm_frequency		=	$total_days/$max_pms_index;
		$average_pm_frequency =	round($pm_frequency,2). " days";
		}
		elseif ($total_pms_c == 1 ) {
			$current_date		=	time();
			$last_pm			=	strtotime($rtz[0]['finish_time']);
			$diff				=	$current_date - $last_pm;
			$total_days			=	floor($diff/(60*60*24));
			$average_pm_frequency = "N/A";
		}
		else $average_pm_frequency = "N/A"; 
		echo $average_pm_frequency;
}


$complaint_nature = 'complaint';
//if (isset($cn) && $cn == "PM") $complaint_nature = "PM";

$start_date = '';
$end_date = '';
$product_id = '';
$equipment_id = '';
$access_privilege = $this->session->userdata('userrole');
if(isset($sd)) $start_date = $sd;
if(isset($ed)) $end_date = $ed;
if(isset($pid)) $product_id = $pid;
if(isset($eid)) $equipment_id = $eid;
if(isset($data_access_role)) $access_privilege = $data_access_role;
$start_date_f			=	date('jS F Y',strtotime($start_date));
$end_date_f				=	date('jS F Y',strtotime($end_date));

$portlet_status_array		=		array("NOT IN ('Pending Verification','Pending SPRF', 'Closed','Pending Registration')","IN ('Pending Verification')","IN ('Pending SPRF')","IN ('Closed')","NOT IN('Completed','Pending Verification')","IN ('Pending Verification')","IN ('Completed')","NOT IN('Pending Registration')","NOT IN('Pending Registration')","LIKE '%'","IN('Pending SPRF')","IN('Pending Registration')");
$portlet_color		=		array('red-intense','yellow-gold','purple','green-meadow','red-intense','yellow-gold','blue-steel','yellow-gold','green-seagreen','blue-steel','purple','yellow-zed');
$portlet_title		=		array('Complaints | Pending','Complaints | Pending Verification','Complaints | Pending SPRF','Complaints | Closed',
									'PM | Pending','PM | Pending Verification','PM | Completed',
									'Service Calls - '.$start_date_f.' to '.$end_date_f, 'Service Calls','Preventive Maintenance','Complaints | Pending SPRF','Complaints | Pending Registration');
// 0 Complaints Pending
// 1 Complaints Pending Verification
// 2 Complaints Pending SPRF
// 3 Complaints Closed
// 4 PM Pending
// 5 PM Pending Verification
// 6 PM Completed
// 7 Complaints (all) on Complaint Statistics Page according to product_id
// 8 Complaints (all) on Equipment Audit Page according to equipment_id
// 9 PM on Equipment Audit Page according to equipment_id
// 10 Pending SPRF
// 11 Pending Registration

$j = 0;
$k = 3;
//echo $table;
if ($table == "closed_complaints") {
	$j = 3;
	$k = 4;
}
if ($table == "pm_not_completed") {
	$j = 4;
	$k = 7;
}
if ($table == "complaint_statistics") {
	$j = 7;
	$k = 8;
}
if ($table == "equipment_audit") {
	$j = 8;
	$k = 10;
}
if ($table == "pending_sprf") {
	$j = 10;
	$k = 11;
}
if ($table == "pending_registration") {
	$j = 11;
	$k = 12;
}

$pm_loop = array(4,5,6,9); /*********************** SPECIFY i value for PM Loops ***********************/
for($i=$j;$i<$k;$i++) {
	//$complaint_nature =  in_array($i,$pm_loop) ? 'complaint' : 'PM';
	if (in_array($i,$pm_loop)) $complaint_nature = 'PM'; else $complaint_nature = 'complaint';
	if ($i==0 && $this->session->userdata('userrole') == 'Admin') $show_add_complaint_button = TRUE; else $show_add_complaint_button = FALSE;
	if ($i==4 || $i==6) $show_pm_note = TRUE; else $show_pm_note = FALSE;
?>
                        <div class="portlet light bg-inverse <?php // echo $portlet_color[$i]; ?>">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa icon-book-open font-<?php echo $portlet_color[$i]; ?>"></i>
							<span class="caption-subject bold font-<?php echo $portlet_color[$i]; ?> ">
							<?php echo $portlet_title[$i]; ?>
							</span>
							</div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                             </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                         
							<?php if($show_add_complaint_button) { //only show in admin pending complaints ?>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>sys/add_sys/d" id="sample_editable_1_new" class="btn purple"> Add New <i class="fa fa-plus"></i> </a>
                                  </div>
                                </div>
                                
                              </div>
							<?php } ?>
							<?php if($show_pm_note) { ?>
								<div class="note note-active">
								  <h3>
								  <label class="label bg-blue">Note: PM Calls in red indicate the calls that are delayed for over 3 days</label>
								  </h3>
								</div>
							<?php } ?>
                            </div>
                          <div class="portlet-body flip-scroll">
                          <table class="table   table-hover flip-content <?php  //echo "table_3";?>" id="<?php echo "table_".$i;?>">
                              <thead class="bg-<?php echo $portlet_color[$i]; ?>">
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
									<?php if ($i!=8 && $i!=9 && $i!=11) { ?>
									<th> </th>
									<th> </th>
									<?php } if($i==2 || $i==10) echo '<th> </th>'; ?>
									<?php if($i==11) echo '<th></th>'; ?>
                                </tr>
                                <tr>
									<?php if($i==11) echo '<th>Created By </th>'; ?>
                                    <th>TS number </th>
									<th>Date </th>
									<?php 	if($i==3 || $i==6 || $i==7 || $i==8 || $i==9) echo '<th>Time Taken </th>'; 
											else echo '<th>Time Elapsed </th>'; 
									?>
									<?php 	if($i==7 || $i==8 || $i==9) echo '<th>Territory </th>'; ?>
									<th>City </th>
									<th>Customer </th>
									<?php if ($i!=8 && $i!=9) { ?>
									<th>Equipment </th>
									<th>S/No </th>
									<?php } echo ($complaint_nature == 'complaint') ? '<th>Problem Summary </th>' : '<th>Average PM Frequency </th>';?>
									<?php if($i!=11) echo '<th>FSE/SAP </th>'; ?>
									<th>Status </th>
									<th>Actions </th>
									<?php 	if($i!=7 && $i!=8 && $i!=9 && $i!=11) echo '<th>Comments </th>'; ?>
									<?php if($i==2 || $i==10) echo '<th>SPRF Time </th>'; ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  
									  $status_variable = $portlet_status_array[$i];
									  $role_condition = "";
									  $product_condition = "";
									  $equipment_condition = "";
									  $date_condition = "";
									  if ($access_privilege=="Supervisor") $role_condition = "AND tbl_complaints.fk_office_id='".$this->session->userdata('territory')."'";
									  if ($access_privilege=="FSE") $role_condition = "AND tbl_complaints.assign_to='".$this->session->userdata('userid')."'";
									  if ($product_id != "") $product_condition = "AND `tbl_instruments`.fk_product_id ='".$product_id."'";
									  if ($equipment_id != "") $equipment_condition = "AND `tbl_complaints`.fk_instrument_id ='".$equipment_id."'";
									  if ($start_date != "") $date_condition = "AND CAST(tbl_complaints.`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";
									  $dbres = $this->db->query("SELECT tbl_complaints.*, 
									  COALESCE(tbl_offices.office_name) AS office_name,
									  COALESCE(tbl_cities.city_name) AS city_name,
									  COALESCE(tbl_clients.client_name) AS client_name,
									  COALESCE(tbl_area.area) AS area,
									  COALESCE(user.first_name) AS first_name,
									  COALESCE(u.first_name) AS created_by_name,
									  COALESCE(tbl_instruments.serial_no) AS serial_no,
									  COALESCE(tbl_products.product_name) AS product_name 
									  
									  FROM tbl_complaints 
									  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
									  LEFT JOIN user ON tbl_complaints.assign_to = user.id
									  LEFT JOIN user u ON tbl_complaints.created_by = u.id
									  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
									  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
									  LEFT JOIN tbl_offices ON tbl_complaints.fk_office_id = tbl_offices.pk_office_id
									  
									  WHERE tbl_complaints.complaint_nature='$complaint_nature' AND tbl_complaints.status $status_variable $role_condition $product_condition $equipment_condition $date_condition
									  
									  order by `pk_complaint_id` DESC");
           							  $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											$show_time_taken = FALSE;
											if( $complaint_list['status']=='Closed' || $complaint_list['status']=='Completed') $show_time_taken = TRUE;
											  // Calculations for PM
											$date1 = $complaint_list['date'];
											$date2 = date('Y-m-d');
											$diff = abs(strtotime($date2) - strtotime($date1));
											  // Time Taken
											$time_taken = "N/A";
											$sprf_time = "N/A";
											if ($complaint_nature == 'complaint')
												$solution_date = date('Y-m-d',strtotime($complaint_list["solution_date"])).' '.date('H:i:s',strtotime($complaint_list["solution_time"]));
											else $solution_date = date('Y-m-d H:i:s',strtotime($complaint_list["solution_date"]));
											if($show_time_taken) $time_taken = nicetime_two_parameters($complaint_list["date"],$solution_date);
											
											// Closed Since or Time Elapsed
											$time_elapsed = "Closed ";
											if ($complaint_nature == 'PM') $time_elapsed = "Completed ";
											if($complaint_list["status"]=='Closed' || $complaint_list["status"]=='Completed') {
												$time_elapsed .=  ' since'; 
												$time_elapsed .=  nicetime($solution_date); 
											}
											else $time_elapsed =  nicetime($complaint_list["date"]);
											
											// SPRF Time
											if($complaint_list['sprf_date']!='0000-00-00 00:00:00') $sprf_time = nicetime($complaint_list['sprf_date']);
											
											$rtzp = "";
											if ($complaint_nature == "PM")	{
												 $tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$complaint_list["fk_instrument_id"]."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
													$rtzp	= 	$tyz->result_array();
											}
												
											$this->load->model("complaint_model");
											$obj	=	new Complaint_model(); // for status
											  ?>
											  <tr class=" 
												<?php if	( ($complaint_list['urgent_priority']==1 && $complaint_nature=='complaint') || 
														($diff>86400*3 && $complaint_list['status']!='Completed' && $complaint_nature=='PM') ) echo "danger ";
												?>
											  ">
                                                <?php if($i==11) echo '<td>'.$complaint_list["created_by_name"].' </td>'; ?>
												<td><?php echo $complaint_list["ts_number"]; ?></td>
												<td><?php echo date('d-M-Y',strtotime($complaint_list["date"])); ?></td>
												<td><?php echo ($show_time_taken) ? $time_taken : $time_elapsed; ?></td>
												<?php 	if($i==7  || $i==8 || $i==9) echo '<td>'.$complaint_list["office_name"].' </td>'; ?>
												<td><?php echo $complaint_list["city_name"]; ?></td>
												<td><?php echo $complaint_list["client_name"];?></td>
												<?php if ($i!=8 && $i!=9) { ?>
												<td><?php echo $complaint_list["product_name"]; ?></td>
												<td><?php echo $complaint_list["serial_no"];?></td>
												<?php } ?>
												<td><?php echo ($complaint_nature == 'complaint') ? $complaint_list["problem_summary"] : pm_frequency($rtzp);?></td>
												<?php if($i!=11) echo '<td>'.$complaint_list["first_name"].' </td>'; ?>
												<td><?php $obj->current_status($complaint_list['status']);?></td>
												<td>
										  <div class="btn-group-vertical btn-group-solid">
<?php 
$show_tsr_button					=	FALSE;
$show_delete_button					=	FALSE;
$show_shift_button					=	FALSE;
$show_edit_button					=	FALSE;
$show_sprf_button					=	FALSE;
$show_supervisor_sprf_button		=	FALSE;
if ($complaint_nature == 'complaint' ) { 
if ($i!=11) $show_tsr_button					=	TRUE;
if ( ($i==2 || $i==10) && ($access_privilege == "Admin" ||  $access_privilege == "Supervisor" || $access_privilege == "secratery") ) $show_supervisor_sprf_button	=	TRUE;
if ( $i==0 ) $show_sprf_button	=	TRUE;
if ($access_privilege == 'Admin' || $access_privilege == 'secratery') {
	if ($access_privilege == 'Admin' && $i<4) {
		$show_delete_button			= 	TRUE;
		$show_edit_button			= 	TRUE;
	}
	if ($i==11) $show_delete_button			= 	TRUE;
	if ($i<3) $show_shift_button	=	TRUE;
}
?>
										  <?php if($show_tsr_button) {?>
												  <a class="btn btn-sm default purple-stripe" 
												  href="<?php echo base_url();?>sys/technical_service_pvr/<?php echo $complaint_list["pk_complaint_id"] ?>">
													TSR <i class="fa fa-eye"></i>
												  </a>
										  <?php } if($show_delete_button) { ?>
												<a class="btn btn-sm default red-thunderbird-stripe" onClick="return confirm('Are you sure you want to delete?')" 
												href="<?php echo base_url();?>sys/delete_complaint/<?php echo $complaint_list["pk_complaint_id"].'?redirect='.$this->uri->segment(2);?>">
												  Delete <i class="fa fa-trash-o"></i>
												</a>
										  <?php } if($show_edit_button) { ?>
												<a class="btn btn-sm default blue-stripe" onClick="return confirm('Are you sure you want to edit?')" 
													href="<?php echo base_url();?>sys/add_complaint_registration/<?php echo $complaint_list["pk_complaint_id"];?>">
														  Edit <i class="fa fa-edit"></i>
												</a>
										  <?php } if($show_shift_button) { ?>
												<a 	class="btn btn-sm default yellow-zed-stripe" 
														href="<?php echo base_url();?>sys/shift_complaint/<?php echo $complaint_list["pk_complaint_id"] ?>">
													Shift <i class="fa fa-share"></i>
												 </a>
										  <?php } if($show_sprf_button) { ?>
												<a class="btn btn-sm default green-haze-stripe" 
														  href="<?php echo base_url();?>sys/sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
															SPRF
												</a>
										  <?php } if($show_supervisor_sprf_button) { ?>
												<a class="btn btn-sm default green-haze-stripe" 
														  href="<?php echo base_url();?>sys/supervisor_sprf/<?php echo $complaint_list["pk_complaint_id"] ?>">
															SPRF
												</a>
										  <?php } if($i==11) { ?>
												<a class="btn btn-sm default yellow-zed-stripe" 
														  href="<?php echo base_url();?>sys/add_complaint_registration/<?php echo $complaint_list["pk_complaint_id"] ?>">
															Register
												</a>
										  <?php } ?>
<?php } else { // FOR PM ?>
										<a class="btn btn-sm default blue-stripe" 
                                          href="<?php echo base_url();?>sys/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>">
                                          	PM Form 
											<i class="fa fa-eye"></i>
                                          </a>
									<?php if($access_privilege=='Admin' && $i!=9) {?>
                                          <a class="btn btn-sm default purple-stripe"  
                                            href="<?php echo base_url();?>sys/update_pm/<?php echo $complaint_list["pk_complaint_id"];?>">
                                              Update <i class="fa fa-edit"></i>
                                            </a>
										  
										  <a class="btn btn-sm default red-thunderbird-stripe" onClick="return confirm('Are you sure you want to delete?')" 
                                            href="<?php echo base_url();?>sys/delete_complaint/<?php echo $complaint_list["pk_complaint_id"].'?redirect='.$this->uri->segment(2);?>">
                                              Delete <i class="fa fa-trash-o"></i>
                                            </a>
									<?php } ?>
<?php }?>
										  </div>
                                          </td>
										  
										  <?php if ($i!=7 && $i!=8 && $i!=9 && $i!=11) {
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
										  <?php } ?>
										  <?php if($i==2 || $i==10) echo '<td>'.$sprf_time.'</td>'; ?>

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

         <script>
		 
		 $(document).ready(function() { 
			var table1 = $('#table_1').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		var table2 = $('#table_2').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		var table3 = $('#table_3').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		var table0 = $('#table_0').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		var table4 = $('#table_4').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		var table5 = $('#table_5').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		var table6 = $('#table_6').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		
		var table7 = $('#table_7').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		
		var table8 = $('#table_8').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		
		var table9 = $('#table_9').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]],
			  "columnDefs": [
					{
						"targets": [ 6 ],
						"visible": false,
						"searchable": true
					}
				]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		
		var table10 = $('#table_10').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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
		
		var table10 = $('#table_11').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	
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