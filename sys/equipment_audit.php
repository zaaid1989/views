<?php $this->load->view('header');

$equipment_id =	'0';

if(isset($_GET['equipment'])) {
	$equipment_id = $_GET['equipment'];
	$data['eid'] = $equipment_id;
}
/// serial number
$qserial = $this->db->query("SELECT serial_no,status,warranty_months,warranty_start_date,fk_category_id from tbl_instruments WHERE pk_instrument_id='".$equipment_id."'");
$rserial = $qserial->result_array();
if (sizeof($rserial>0) && $equipment_id !=	'0' ) {
$serial_number = $rserial[0]['serial_no'];
$equipment_status = $rserial[0]['status'];
$equipment_category = $rserial[0]['fk_category_id'];
$warranty_end_date = "";
if ($rserial[0]["warranty_months"]<0) $warranty_end_date = "Not Defined";
if ($rserial[0]["warranty_months"]==0) $warranty_end_date = "No Warranty";
if ($rserial[0]["warranty_months"]>0) {
 // echo date('d-M-Y', strtotime($get_users_list["warranty_start_date"]));
  $months_to_add = "+".$rserial[0]["warranty_months"]." months";
  $warranty_end_date = date('d-M-Y', strtotime($months_to_add, strtotime($rserial[0]["warranty_start_date"])));
}
}
else {
$serial_number = "N/A";
$equipment_status = "N/A";
$equipment_category = "N/A";
$warranty_end_date = "N/A";
}
// serial number end
///////////////// Average Time PM BEGIN
$average_time_pm =  "N / A";
$qu_int_sc	="select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='PM' AND status='Completed' ";
$qh_int_sc	=$this->db->query($qu_int_sc);
$res_int_sc = $qh_int_sc->result_array();
if(sizeof($res_int_sc)>0) {
	$average=0;
	$count=0;
	foreach($res_int_sc as $interval) {
		$count++;
		$to_time= strtotime($interval['solution_date']);
		$from_time = strtotime($interval['date']);
		$average = round(abs($to_time - $from_time) / 3600,2);//.', ';
	}
	$average_time_pm =  round($average/$count,2).' Hours';
}
else {
	$average_time_pm =   "N / A";
}
///////////////// Average Time PM End


//////////////////// Average Time TS Begin
$average_time_ts =  "N / A";
$qu_int_sc	="select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='complaint' AND status='Closed' ";
$qh_int_sc	=$this->db->query($qu_int_sc);
$res_int_sc = $qh_int_sc->result_array();
if(sizeof($res_int_sc)>0) {
	$average=0;
	$count=0;
	foreach($res_int_sc as $interval) {
		$count++;
		$to_time   = strtotime($interval['finish_time']);
		$from_time = strtotime($interval['date']);
		$average   = round(abs($to_time - $from_time) / 3600,2);//.', ';
	}
	$average_time_ts = round($average/$count,2).' Hours';
}
else {
	$average_time_ts =   "N / A";
}
/////////////////// Average Time TS End

// Average TS Frequency
$average_ts_frequency = "N/A";
//$days_since_last_pm = "N/A";
$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='complaint' ORDER BY date DESC ");
$rtz	= 	$tyz->result_array();
$total_pms_c	=	sizeof($rtz);

if ($total_pms_c > 1 ) {
		$max_pms_index		=	$total_pms_c - 1;
		$first_pm			=	strtotime($rtz[$max_pms_index]['date']);
		$last_pm			=	strtotime($rtz[0]['date']);
	//$current_date		=	time();
		$diff				=	$last_pm - $first_pm;
	//$interval		= 	$difference->format(%a);
		$total_days			=	floor($diff/(60*60*24));
		$pm_frequency		=	round($total_days/$max_pms_index,2);
		$average_ts_frequency =	$pm_frequency . " days";
		}
		elseif ($total_pms_c == 1 )
		{
			$current_date		=	time();
			$last_pm			=	strtotime($rtz[0]['finish_time']);
			$diff				=	$current_date - $last_pm;
			$total_days			=	floor($diff/(60*60*24));
			//echo $total_days . " day(s)";
			$average_ts_frequency = "N/A";
			
		}
		else $average_ts_frequency = "N/A";
/// Average TS frequency

/// Code for Average PM Frequency and Days since last PM
$average_pm_frequency = "N/A";
$days_since_last_pm = "N/A";
$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
$rtz	= 	$tyz->result_array();
$total_pms_c	=	sizeof($rtz);

if ($total_pms_c > 1 ) {
		$max_pms_index		=	$total_pms_c - 1;
		$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
		$last_pm			=	strtotime($rtz[0]['finish_time']);
	//$current_date		=	time();
		$diff				=	$last_pm - $first_pm;
	//$interval		= 	$difference->format(%a);
		$total_days			=	floor($diff/(60*60*24));
		$pm_frequency		=	$total_days/$max_pms_index;
		$average_pm_frequency =	$pm_frequency . " days";
		}
		elseif ($total_pms_c == 1 )
		{
			$current_date		=	time();
			$last_pm			=	strtotime($rtz[0]['finish_time']);
			$diff				=	$current_date - $last_pm;
			$total_days			=	floor($diff/(60*60*24));
			//echo $total_days . " day(s)";
			$average_pm_frequency = "N/A";
			
		}
		else $average_pm_frequency = "N/A";
		
// Code for Days since last PM
$interval = 0;
$tyza	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC LIMIT 1");
$rtza	= 	$tyza->result_array(); 
$days_since_pm	=	'';
if (!empty($rtza)){
	$last_pm_date	=	strtotime($rtza[0]['finish_time']);
	$current_date	=	time();
	$difference		=	$current_date - $last_pm_date;
	//$interval		= 	$difference->format(%a);
	$interval		=	floor($difference/(60*60*24));
}
if (!empty($rtza))
		$days_since_last_pm = $interval . " day(s)";
	else
		$days_since_last_pm = "N/A";
								
/////////////// PM Frequency and Days Finish

function myDate($time){
  if($time == '0000-00-00 00:00:00')
     return "";
  if(substr($time,11)!= '00:00:00')
     return date("d-M-Y H:i:s", strtotime($time));
  return date("d-M-Y", strtotime($time));
}

function zerodisplay($val) {
	if($val==0) return '-';
	else return $val;
}

function Get_Date_Difference($start_date, $end_date)
    {
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        return (($years > 0) ? $years.' year'.(($years > 1 ? 's ' : '')) : '').(($months > 0) ? (($months == 1) ? ' '.$months.' month' : ' '.$months.' months' ) : '').(($days > 0) ? (($days == 1) ? ' '.$days.' day' : ' '.$days.' days' ) : '');
    }
?>
										
										
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Equipment Audit <small><?php //echo $average_visits_per_day; ?></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Equipment Audit
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
       <!-- BEGIN PAGE CONTENT-->
       <div class="row">
        <div class="col-md-12">
<?php if ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery'){ ?>		
		<!-- Search Form -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Equipment Statistics </span>
								<span class="caption-helper">Audit Statistics for Individual Equipment</span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>sys/equipment_audit">
                                <div class="col-md-6">
                            		<div class="form-group">
                            			
                                        <select name="equipment" id="equipment" class="form-control" required>
                                            <option value="">--Select Equipment--</option>
											<?php 
											$maxqu = $this->db->query("SELECT tbl_instruments.* ,tbl_products.product_name,tbl_clients.client_name,tbl_cities.city_name FROM tbl_instruments 
											LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
											LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
											LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
											ORDER BY   `product_name`,`pk_instrument_id` ");
										
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['pk_instrument_id'];//pk_product_id?>" <?php if(isset($_GET['equipment']) && $_GET['equipment']==$val['pk_instrument_id']){ echo 'selected="selected"';}//pk_instrument_id?>>
													<?php echo $val['serial_no'].' - '.$val['client_name'].' ('.$val['city_name'].') - '.$val['product_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>

                                <div class="col-md-2">
                            		<div class="form-group">
                                            <input type="submit"  class="btn btn-default purple-seance" value="Search" >
                                    </div>
                                </div>
                          		</form>
                           </div>	
							
						</div>
					</div>
		<!-- Search Form -->
<?php } ?>


<!------------------------------------- Begin 6 Table Portlets -------------------------------------------->
<?php
	$titles = array("Basic Information","Service Calls","Preventive Maintenance","Parts List","Warranty Claims","Location Log","Auxiliary Equipment");
	$title_colors = array("grey-gallery","green-seagreen","blue-steel","purple-seance","yellow-zed","yellow-gold","red-thunderbird");

 ?>
 <?php 

?> 
 <?php for ($k=0;$k<7;$k++) { 
 if ($k==1) {
		$data['table'] = 'equipment_audit';
		$data['data_access_role'] = 'Admin'; //FSE, Supervisor, Admin
		//if ($this->session->userdata('userrole')=='Supervisor') $data['data_access_role'] = 'Supervisor';
		$this->load->view('sys/complaints_table_view',$data);
		continue;
 }  if ($k==2) continue;
 ?>
		<!-- Assigned Total -->
		<div class="portlet light bg-inverse" <?php if ($k==6 && $equipment_category=="1") echo 'style="display:none;"'; ?>>
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-<?php echo $title_colors[$k]; ?>"></i>
								<span class="caption-subject bold font-<?php echo $title_colors[$k]; ?> uppercase">
								<?php echo $titles[$k]; ?> </span>
								<span class="caption-helper"></span>
							</div>
						</div>
					<div class="portlet-body">
		<?php if ($k==3) echo "<div class='table-scrollable'>"; ?>				  			
                <table class="table  table-hover <?php if ($k!=3) echo "dataaTable"; ?>" id="">
					<thead class="bg-<?php echo $title_colors[$k]; ?>">
					<tr>
					<?php if ($k==0) { ?>
						<th> Status </th>
						<th> Warranty End Date </th>
						<th> Average Time TO Resolve Complaint </th>
						<th> Average Complaint Frequency </th>
						<th> Average Time TO Resolve PM </th>
						<th> Average PM Frequency </th>
						<th> Days Since Last PM </th>
					<?php } ?>
					<?php if ($k==1 || $k==2) { ?>
						<th> TS Number </th>
				<!--		<th> Date </th> -->
						<th> Time Taken </th>
						<th> City </th>
						<th> Customer </th>
					<!--	<th> Area </th> -->
		<?php	if ($k==1) {	?>		<th> Problem Summary </th> <?php } ?>
						<th> FSE/SAP </th>
						<th> Status </th>
						<th> Actions </th>
					<?php } ?>
					
					<?php if ($k==3) { ?>
						
						<th> DC Number </th>
						<th> Date </th>
				<!--		<th> Vendor </th> -->
						<th> TS Number </th>
						<th> Part Number </th>
						<th> Part Description </th>
						<th> Type </th>
						<th> Quantity </th>
						<th> Office / Client </th>
					<?php } ?>
					
					<?php if ($k==5) { ?>
						
						<th> Date </th>
						<th> Old Location </th>
						<th> Updated Location </th>
						<th> Old Office </th>
						<th> Updated Office </th>
						<th> Old Status </th>
						<th> Updated Status </th>
						<th> Comments </th>
					<?php } ?>
					
					<?php if ($k==4) { ?>
						
						<th> Equipment Name </th>
						<th> Equipment Serial </th>
						<th> Part Number </th>
						<th> Part Description </th>
						<th> Invoice Number </th>
						<th> Invoice Date </th>
						<th> Stock In Date </th>
					<?php } ?>
					
					<?php if ($k==6) { ?>
						  <th> Equipment   			</th>
                          <th> Vendor Name 			</th>
						  <th> Invoice Date			</th>
                          <th> Price				</th>
                          <th> Warranty End Date 	</th>
                          <th> Description			</th>
					<?php } ?>
					
					</tr>
					</thead>
					<tbody> 
					
					<?php // Basic Data
					if ($k==0) {
						if ($equipment_status==1) echo '<td>Active</td>';
						else echo '<td>Inactive</td>';
						echo '<td>'.$warranty_end_date.'</td>';
						echo '<td>'.$average_time_ts.'</td>';
						echo '<td>'.$average_ts_frequency.'</td>';
						echo '<td>'.$average_time_pm.'</td>';
						echo '<td>'.$average_pm_frequency.'</td>';
						echo '<td>'.$days_since_last_pm.'</td>';
					}
					?>
					<?php  // Current Pending Calls
					if ($k==1 || $k==2) {
						$q		= "SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
									FROM `tbl_complaints`
									LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
									LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
									LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
									LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
									WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.fk_instrument_id = '".$equipment_id."' ";
						if ($k==2) {
							$q		= "SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
									FROM `tbl_complaints`
									LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
									LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
									LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
									LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
									WHERE `tbl_complaints`.complaint_nature='PM' AND `tbl_complaints`.fk_instrument_id = '".$equipment_id."' ";
						}
						$q		.=	"ORDER BY 'date' ASC";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $pmc) {
							$temp_time_taken = "";
							if ($pmc['status']=='Completed')
								$temp_time_taken = Get_Date_Difference($pmc["date"],$pmc["solution_date"]);
							else
								$temp_time_taken = Get_Date_Difference($pmc["date"],date('Y-m-d H:i:s'));
							
							echo '<tr> ';
							echo '<td>'.$pmc['ts_number'].'</td>';
						//	echo '<td>'.date('d-M-Y',strtotime($pmc['date'])).'</td>';
							echo '<td>'.$temp_time_taken.'</td>';
							echo '<td>'.$pmc['city_name'].'</td>';
							echo '<td>'.$pmc['client_name'].'</td>';
						//	echo '<td>'.$pmc['area'].'</td>';
			if ($k==1)				echo '<td>'.urldecode($pmc['problem_summary']).'</td>';
							echo '<td>'.$pmc['first_name'].'</td>';
							echo '<td>';
								$this->load->model("complaint_model");
								$obj=new Complaint_model();
								$obj->current_status($pmc['status']);
							echo '</td>';
							echo '<td>';
							if ($k==1) {
								echo '<a class="btn btn-sm default yellow-zed-stripe" href="'.base_url().'sys/technical_service_pvr/'.$pmc["pk_complaint_id"].'">';
								echo 'TSR <i class="fa fa-eye"></i></a>';
							} else {
								echo '<a class="btn btn-sm default yellow-zed-stripe" href="'.base_url().'sys/pm_form/'.$pmc["pk_complaint_id"].'">';
								echo 'PM form <i class="fa fa-eye"></i></a>';
							}
							echo '</td>';
							echo '</tr> ';
						}
					}
					?>
					
					<?php // query for fetching parts with pending dc and status as in
					if ($k==3) {
                          $query=$this->db->query("SELECT tbl_stock.*,tbl_parts.part_number,tbl_parts.description,tbl_vendors.vendor_name, tbl_offices.office_name
						  from tbl_stock
						  LEFT JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
						  LEFT JOIN tbl_vendors ON tbl_parts.fk_vendor_id=tbl_vendors.pk_vendor_id
						  LEFT JOIN tbl_offices ON tbl_stock.fk_office_id=tbl_offices.pk_office_id
						  WHERE equipment_serial='".$serial_number."'  AND (dc_type='out' OR (dc_type='in' AND in_status='approved') 
						  AND stock_type!='Warranty Claim' )
						  ORDER BY tbl_stock.dc_number");
						  // AND stock_type!='Warranty Claim'  this line added in above query because Mr. Yasir said that warranty claims should not be shown
						  // IF want to show incoming parts in stock then remove dc_type condition AND dc_type='out' 
						  $query_res=$query->result_array();
						  // For each loop of parts and echo them
						  $dc_number=-1;
						  $count=1;
						  
                          foreach ($query_res as $dc_entry) { 
							  $qdc=$this->db->query("SELECT * from tbl_stock WHERE dc_number='".$dc_entry['dc_number']."' AND equipment_serial='".$serial_number."'  ");
							  // IF want to show incoming parts in stock then remove dc_type condition AND dc_type='out' 
							  $rdc=$qdc->result_array();
							  $dc_count = sizeof($rdc);
							  if ($dc_number!=$dc_entry['dc_number']) {
								  $dc_number = $dc_entry['dc_number'];
								  $count=1;
							  }
                                  ?>
                                  <tr class="odd gradeX">
								  <?php if ($count==1) { ?>
									  <td rowspan="<?php echo $dc_count; ?>"> <?php echo $dc_entry['dc_number']; ?> </td>
								  <?php } ?>
									  <td> <?php echo myDate($dc_entry['date']); ?> </td>
                                   <!--   <td> <?php echo $dc_entry['vendor_name']; ?> </td> -->
									  <td> <?php echo zerodisplay($dc_entry['ts_number']); ?> </td>
									  <td> <?php echo $dc_entry['part_number']; ?> </td>
									  <td> <?php echo urldecode($dc_entry['description']); ?> </td>
									  <td> <?php echo $dc_entry['stock_type']; ?> </td>
									  <td> <?php echo $dc_entry['stock'] * -1; ?> </td>
									  <td> <?php echo $dc_entry['office_name']; ?> </td>
									  <?php if ($count==1) { ?>
									  <?php } ?>
                                  </tr>
                                  <?php
								  $count++; 
								  } // End of For each
								  /*
						  $query=$this->db->query("SELECT `tbl_sprf`.`dc_number`,`tbl_complaints`.`date`,`tbl_complaints`.`finish_time`,`tbl_parts`.`part_number`,`tbl_parts`.`description`,`tbl_sprf`.`quantity`,`tbl_clients`.`client_name`
							FROM `tbl_sprf` 
							LEFT JOIN tbl_parts ON tbl_sprf.fk_part_id=tbl_parts.pk_part_id
							LEFT JOIN tbl_complaints ON tbl_sprf.fk_complaint_id=tbl_complaints.pk_complaint_id
							LEFT JOIN tbl_clients ON tbl_sprf.source_id=tbl_clients.pk_client_id
							WHERE `tbl_sprf`.`part_source`='client' AND `tbl_complaints`.`fk_instrument_id`='".$equipment_id."'");
						  // IF want to show incoming parts in stock then remove dc_type condition
						  $query_res=$query->result_array();
						  foreach ($query_res as $dc_entry) {
							  echo '<tr>';
							  echo '<td>'.$dc_entry["dc_number"].'</td>';
							  echo '<td>'.myDate($dc_entry["date"]).'</td>'; //change to finish_time for exact date
							  echo '<td>'.$dc_entry["part_number"].'</td>';
							  echo '<td>'.urldecode($dc_entry["description"]).'</td>';
							  echo '<td>Issued</td>';
							  echo '<td>-'.$dc_entry["quantity"].'</td>';
							  echo '<td>'.$dc_entry["client_name"].'</td>';
							  echo '</tr>';
						  }*/
						}
					 			  ?>
								  
					<?php // query for fetching parts with pending dc and status as in
					if ($k==5) {
                          $query=$this->db->query("SELECT tbl_instruments_log.*,
												   oo.office_name updated_office, o1.office_name old_office,
												   co.client_name old_client, cn.client_name updated_client,
												   oc.office_name office_client_old,oc2.office_name office_client_new
												   from tbl_instruments_log
												  LEFT JOIN tbl_offices oo ON oo.pk_office_id = tbl_instruments_log.fk_office_id_new
                                                  LEFT JOIN tbl_offices o1 ON o1.pk_office_id = tbl_instruments_log.fk_office_id_old
                                                  LEFT JOIN tbl_clients co ON co.pk_client_id = tbl_instruments_log.fk_client_id_old
                                                  LEFT JOIN tbl_clients cn ON cn.pk_client_id = tbl_instruments_log.fk_client_id_new
												  LEFT JOIN tbl_offices oc ON oc.client_option = tbl_instruments_log.fk_client_id_old
                                                  LEFT JOIN tbl_offices oc2 ON oc2.client_option = tbl_instruments_log.fk_client_id_new
												  WHERE fk_instrument_id='".$equipment_id."' ORDER BY date,pk_instruments_log_id");
						  $query_res=$query->result_array();
						  foreach ($query_res AS $location_log) {
							  echo "<tr>";
									echo "<td>"; // date
										echo date('d-M-Y',strtotime($location_log['date']));
									echo "</td>";
									///////////////////////////////
									echo "<td>"; // Old Location
										if($location_log['old_client']!="") echo $location_log['old_client'];
										else echo $location_log['office_client_old'];
									echo "</td>";
									///////////////////
									echo "<td>"; // Updated Location
										if($location_log['updated_client']!="") echo $location_log['updated_client'];
										else echo $location_log['office_client_new'];
									echo "</td>";
									/////////////////////
									echo "<td>"; // Old Office
										echo $location_log['old_office'];
									echo "</td>";
									//////////////////
									echo "<td>"; // Updated Office
										echo $location_log['updated_office'];
									echo "</td>";
									/////////////////////////////////////////////
									echo "<td>"; // Old Status 
										if ($location_log['status_old'] ==1) echo 'Active';
										else echo 'Inctive';
									echo "</td>";
									/////////////////////////////////////
									echo "<td>"; // Updated Status 
										if ($location_log['status_new'] ==1) echo 'Active';
										else echo 'Inctive';
									echo "</td>";
									/////////////////////////////////////////
									echo "<td>"; // Comments
										echo urldecode($location_log['comments']);
									echo "</td>";
							  echo "</tr>";
						  }
						  
						}
					 	?>
					
					<?php 
				if ($k==4) {		  // Warranty Claims
						  
						  $query 			=	"SELECT tbl_stock.*, tbl_products.product_name, tbl_parts.part_number, tbl_parts.description
					  from tbl_stock
					  LEFT JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
					  LEFT JOIN tbl_instruments ON tbl_stock.equipment_serial=tbl_instruments.serial_no
					  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id=tbl_products.pk_product_id
					  WHERE tbl_stock.stock_type='Warranty Claim' AND tbl_instruments.pk_instrument_id=$equipment_id";
					  
					  $pq 			=	$this->db->query($query);
					  $pr			=	$pq->result_array();
						  $balance = 0;
                          foreach ($pr as $stock_entry) {
                                  ?>
                                  <tr class="odd gradeX">
									  <td> <?php echo $stock_entry['product_name']; ?> </td>
									  <td> <?php echo $stock_entry['equipment_serial']; ?> </td>
									  <td> <?php echo $stock_entry['part_number']; ?> </td>
									  <td> <?php echo urldecode($stock_entry['description']); ?> </td>
									  <td> <?php echo $stock_entry['invoice_number']; ?> </td>
									  <td> <?php echo myDate($stock_entry['invoice_date']); ?> </td>
									  <td> <?php echo myDate($stock_entry['date']); ?> </td>
                                  </tr>
                                  <?php
								  } // End of For each
				}	 // End of 5th Loop
					 			  ?>
								  
					<?php 
				if ($k==6) {		  // Warranty Claims
						  
						  $query 	=	"SELECT tbl_stock.*, tbl_products.product_name, tbl_vendors.vendor_name
					  from tbl_instruments
					  LEFT JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
					  LEFT JOIN tbl_instruments ON tbl_stock.equipment_serial=tbl_instruments.serial_no
					  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id=tbl_products.pk_product_id
					  WHERE tbl_stock.stock_type='Warranty Claim' AND tbl_instruments.pk_instrument_id=$equipment_id";
					  
					  $query 	=	"SELECT tbl_instruments.*, tbl_products.product_name, tbl_vendors.vendor_name
					  from tbl_instruments
					  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id=tbl_products.pk_product_id
					  LEFT JOIN tbl_vendors ON tbl_instruments.fk_vendor_id=tbl_vendors.pk_vendor_id
					  WHERE find_in_set('$equipment_id',tbl_instruments.main_equipment) <> 0";
					  
					  $pq 			=	$this->db->query($query);
					  $pr			=	$pq->result_array();
						  $balance = 0;
                          foreach ($pr as $aux_equipment) {
                                  ?>
                                  <tr class="odd gradeX">
									  <td> <?php echo $aux_equipment['product_name']; ?> </td>
									  <td> <?php echo $aux_equipment['vendor_name']; ?> </td>
									  <td> <?php echo myDate($aux_equipment['invoice_date']); ?> </td>
									  <td> <?php echo $aux_equipment['equipment_price']; ?> </td>
									  <td> <?php if ($aux_equipment["warranty_months"]<0) echo "Not Defined";
											  if ($aux_equipment["warranty_months"]==0) echo "No Warranty";
											  if ($aux_equipment["warranty_months"]>0) {
												  $months_to_add = "+".$aux_equipment["warranty_months"]." months";
												  echo date('d-M-Y', strtotime($months_to_add, strtotime($aux_equipment["warranty_start_date"])));
											  } ?></td>
									  <td> <?php echo urldecode($aux_equipment['details']); ?> </td>
                                  </tr>
                                  <?php
								  } // End of For each
				}	 // End of 6th Loop
					 			  ?>
					</tbody>
              </table>   
<?php if ($k==3) echo "</div>"; ?>					  
					</div>
		<!-- Assigned Total -->
		</div>
<?php } ?>
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		
          
<!-- END EXAMPLE TABLE PORTLET--> 
 
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
	  'iDisplayLength': 100,
	  'aaSorting':[]
	});
	
	//new $.fn.dataTable.FixedColumns( table );
});
</script>

<style>
textarea {
  width: 100%;
}
</style>