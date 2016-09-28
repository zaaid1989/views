<?php $this->load->view('header');
$product_id = '0';
if (isset($_GET['product']))
	$product_id = $_GET['product'];
$sdate_set = "no";
$edate_set = "no";
if(isset($_GET['start_mydate']) && $_GET['start_mydate']!="") {
	$sdate_set = "yes";
	$start_date = date('Y-m-d',strtotime($_GET['start_mydate']));
}
else $start_date = "2015-05-01";
if(isset($_GET['end_mydate']) && $_GET['end_mydate']!="") {
	$edate_set = "yes";
	$end_date = date('Y-m-d',strtotime($_GET['end_mydate']));
}
else $end_date = date('Y-m-d');
?>
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
        Product Audit <small></small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    Home 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Product Audit
                    <i class="fa fa-angle-right"></i>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
		<?php
			if(isset($_GET['msg_success']))
			  { 
			  echo '<div class="alert alert-success alert-dismissable">  
					  <a class="close" data-dismiss="alert">×</a>  
					  Equipment Location Log Updated Successfully.  
					</div>';
			  }
		  ?>
        <div class="row">
        <div class="col-md-12"> 
		
				<!-- Search Form -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Product </span>
								<span class="caption-helper">Select Product</span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>complaint/product_audit">
								<div class="col-md-4">
                            		<div class="form-group ">
                                        <select name="product" id="product" class="form-control" required>
                                            <option value="">--Select Product--</option>
											<?php 
											$maxqu = $this->db->query("SELECT * FROM tbl_products where fk_type_id!='2' AND status!=1 ORDER BY product_name");
											$maxval=$maxqu->result_array();
											
                                            foreach($maxval as $val)
                                            {
                                                ?>
                                                <option value="<?php echo $val['pk_product_id'];?>" 
												<?php if(isset($_GET['product']) && $_GET['product']==$val['pk_product_id']){ echo 'selected="selected"';}?>>
													<?php echo $val['product_name'];?>
                                                </option>
                                                <?php 
                                            }
											echo '<option value="-1" > ALL </option>';
                                            ?>
                                        </select>
										<span class="help-block">Product</span>
                            		</div>
                          		</div>
                                <div class="col-md-2">
                            		<div class="form-group">
                            			
                                        <input type="text" name="start_mydate" class="form-control datepicker" id="start_mydate" value="<?php if($sdate_set=="yes") echo date('d-M-Y',strtotime($start_date));?>"   />
										<span class="help-block">Start Date</span>
									</div>
                                </div>
                                <div class="col-md-2">
                            		<div class="form-group">
                            			
                                        <input type="text" name="end_mydate" class="form-control datepicker" id="end_mydate" value="<?php if($edate_set=="yes") echo date('d-M-Y',strtotime($end_date));?>"  />
										<span class="help-block">End Date</span>
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
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
<?php if($product_id != '0') { ?>
          <div class="portlet light bg-inverse">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-paper-plane font-grey-gallery"></i>
						<span class="caption-subject bold font-grey-gallery uppercase">
						Equipment Details </span>
						<span class="caption-helper"></span>
					</div>
				</div>
			<div class="portlet-body">
			<?php
			if ($product_id == -1) {	
			$query = $this->db->query("SELECT tbl_instruments.* ,tbl_products.product_name,tbl_clients.client_name,tbl_cities.city_name,tbl_offices.office_name
										FROM tbl_instruments 
										LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
										LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
										LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
										LEFT JOIN tbl_offices ON tbl_offices.pk_office_id = tbl_instruments.fk_office_id
										ORDER BY   `product_name`,`pk_instrument_id` ");
			} else {
			$query = $this->db->query("SELECT tbl_instruments.* ,tbl_products.product_name,tbl_clients.client_name,tbl_cities.city_name,tbl_offices.office_name
										FROM tbl_instruments 
										LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
										LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
										LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
										LEFT JOIN tbl_offices ON tbl_offices.pk_office_id = tbl_instruments.fk_office_id
										WHERE tbl_instruments.fk_product_id = '".$product_id."'
										ORDER BY   `product_name`,`pk_instrument_id` ");
			}							
			$result=$query->result_array();
			?>
			<table class="table  table-hover dataaTable" id="">
				<thead class="bg-grey-gallery">
					<tr>
						<th> Territory </th>
						<th> City </th>
						<th> Location </th>
						<th> Serial Number </th>
						<th> Status </th>
						<th> Warranty End<br/>Date </th>
						<th> Total<br/>Complaints</th>
						<th> Average Hours TO<br/> Resolve Complaint </th>
						<th> Average Complaint<br/> Frequency (Days) </th>
						<th> Total<br/>PM</th>
						<th> Average Hours TO<br/> Resolve PM </th>
						<th> Average PM<br/>Frequency (Days) </th>
						<th> Days Since<br/> Last PM </th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($result AS $equipment) { 
					echo '<tr>';
						echo '<td>'.$equipment["office_name"].'</td>';
						echo '<td>'.$equipment["city_name"].'</td>';
						echo '<td>'.$equipment["client_name"].'</td>';
						echo '<td>'.$equipment["serial_no"].'</td>';
						if ($equipment["status"]=='1') echo '<td><span class="bg-blue">Active</span></td>';
						else echo '<td><span class="bg-yellow-zed">Inactive</span></td>';
						///////////////////////////
						$equipment_id = $equipment["pk_instrument_id"];
						/////////////////////// Warranty
						$warranty_end_date = "";
						if ($equipment["warranty_months"]<0) $warranty_end_date = "Not Defined";
						if ($equipment["warranty_months"]==0) $warranty_end_date = "No Warranty";
						if ($equipment["warranty_months"]>0) {
						  $months_to_add = "+".$equipment["warranty_months"]." months";
						  $warranty_end_date = date('d-M-Y', strtotime($months_to_add, strtotime($equipment["warranty_start_date"])));
						}
						echo '<td>'.$warranty_end_date.'</td>';
						//////////////////////// Warranty
						/////////////// Total Complaints
						echo '<td>';
						$qu_int_sc	="select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='complaint' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";
						$qh_int_sc	=$this->db->query($qu_int_sc);
						$res_int_sc = $qh_int_sc->result_array();
						if(sizeof($res_int_sc)>0) echo sizeof($res_int_sc);
						else echo '-';
						echo '</td>';
						////////////// Total COmplaints
						/////////////////////// Average Time Complaint
						$average_time_ts =  "-";
						$qu_int_sc	="select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='complaint' AND status='Closed' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";
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
							$average_time_ts = round($average/$count,2);
						}
						else {
							$average_time_ts =   "-";
						}
						echo '<td>'.$average_time_ts.'</td>';
						/////////////////////// Average Time Complaint
						
						/////////////////////// Complaint Frequency
						$average_ts_frequency = "-";
						//$days_since_last_pm = "-";
						$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='complaint'  AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY date DESC ");
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
								$average_ts_frequency =	$pm_frequency;
								}
								elseif ($total_pms_c == 1 )
								{
									$current_date		=	time();
									$last_pm			=	strtotime($rtz[0]['finish_time']);
									$diff				=	$current_date - $last_pm;
									$total_days			=	floor($diff/(60*60*24));
									//echo $total_days . " day(s)";
									$average_ts_frequency = "-";
									
								}
								else $average_ts_frequency = "-";
						echo '<td>'.$average_ts_frequency.'</td>';
						//////////////////////// Complaint Frequency
						/////////////// Total PM
						echo '<td>';
						$qu_int_sc	="select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='PM' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";
						$qh_int_sc	=$this->db->query($qu_int_sc);
						$res_int_sc = $qh_int_sc->result_array();
						if(sizeof($res_int_sc)>0) echo sizeof($res_int_sc);
						else echo '-';
						echo '</td>';
						////////////// Total PM
						///////////////// Average Time PM BEGIN
						$average_time_pm =  "-";
						$qu_int_sc	="select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='PM' AND status='Completed' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";
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
							$average_time_pm =  round($average/$count,2);
						}
						else {
							$average_time_pm =   "-";
						}
						echo '<td>'.$average_time_pm.'</td>';
						///////////////// Average Time PM End
						
						/// Code for Average PM Frequency and Days since last PM
						$average_pm_frequency = "-";
						$days_since_last_pm = "-";
						$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='PM' AND status='Completed' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY date DESC ");
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
								$average_pm_frequency =	$pm_frequency;
								}
								elseif ($total_pms_c == 1 )
								{
									$current_date		=	time();
									$last_pm			=	strtotime($rtz[0]['finish_time']);
									$diff				=	$current_date - $last_pm;
									$total_days			=	floor($diff/(60*60*24));
									//echo $total_days . " day(s)";
									$average_pm_frequency = "-";
									
								}
								else $average_pm_frequency = "-";
								
						// Code for Days since last PM
						$interval = 0;
						$tyza	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='PM' AND status='Completed' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY date DESC LIMIT 1");
						$rtza	= 	$tyza->result_array(); 
						$days_since_pm	=	'';
						if (!empty($rtza)){
							$last_pm_date	=	strtotime($rtza[0]['finish_time']);
							$current_date	=	time();
							$difference		=	$current_date - $last_pm_date;
							//$interval		= 	$difference->format(%a);
							$interval		=	floor($difference/(60*60*24));
						}
						if (!empty($rtza)) {
								$days_since_last_pm = $interval . " day(s)";
								$days_since_last_pm = $interval;
						}
							else
								$days_since_last_pm = "-";
														
						/////////////// PM Frequency and Days Finish
						
						
						echo '<td>'.$average_pm_frequency.'</td>';
						echo '<td>'.$days_since_last_pm.'</td>';
					echo '</tr>';
				} ?>
				</tbody>
				</table>
           </div>
          </div>
		  
		<?php } ?>    
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
	  'iDisplayLength': 1000,
	  'aaSorting':[]
	});
	
	//new $.fn.dataTable.FixedColumns( table );
});
</script>