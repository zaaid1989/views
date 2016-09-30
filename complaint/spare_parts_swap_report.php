<?php $this->load->view('header');
$user_id =	$this->session->userdata('userid');
$equipment_id =	'0';
$dates_set = "no";
$start_date_month = date('Y-m').'-01';
$start_date_month = date('2015-04-01');
$start_date = date('Y-m-d',strtotime($start_date_month));
$end_date = date('Y-m-d');
$current_date = date('Y-m-d');

// Assign Start End Dates
if(isset($_GET['start_mydate']) && isset($_GET['end_mydate'])) {
	
	$dates_set = "yes";
	$start_date = date('Y-m-d',strtotime($_GET['start_mydate']));
	$end_date = date('Y-m-d',strtotime($_GET['end_mydate']));
	if ($start_date==$end_date && $start_date>$current_date)
		$dates_set = "no";
}
// Assign Equipment ID

if(isset($_GET['equipment'])) {
	$equipment_id = $_GET['equipment'];
}

$maxqu = $this->db->query("SELECT * FROM user where id='".$user_id ."'");
$maxval=$maxqu->result_array();

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
                    Spare Parts Swap Report <small><?php //echo $average_visits_per_day; ?></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Spare Parts Swap Report
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
								Spare Parts Swap Report </span>
								<span class="caption-helper">All Parts Swapped</span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>complaint/spare_parts_swap_report">
								<?php /*
                                <div class="col-md-4">
                            		<div class="form-group">
                            			
                                        <select name="equipment" id="equipment" class="form-control" required>
                                            <option value="">--Select Equipment--</option>
											<?php 
											$maxqu = $this->db->query("SELECT tbl_instruments.* ,tbl_products.product_name FROM tbl_instruments 
											LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
											ORDER BY   `product_name`,`pk_instrument_id` ");
											
											$maxqu = $this->db->query("SELECT * FROM tbl_products 
											WHERE fk_type_id=1 AND status=0
											ORDER BY   `product_name` ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['pk_product_id'];//pk_instrument_id?>" <?php if(isset($_GET['equipment']) && $_GET['equipment']==$val['pk_product_id']){ echo 'selected="selected"';}//pk_instrument_id?>>
													<?php echo $val['product_name'];//$val['serial_no'].' - '.$val['product_name']?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>
								*/ ?>
								
                          		<div class="col-md-3">
                            		<div class="form-group">
                            			
                                        <input type="text" name="start_mydate" class="form-control datepicker" id="start_mydate" value="<?php if(isset($_GET['start_mydate'])){ echo $_GET['start_mydate']; } else { echo '01-'.date('M-Y');}?>" required  />
										<span class="help-block">Start Date</span>
									</div>
                                </div>
                                <div class="col-md-3">
                            		<div class="form-group">
                            			
                                        <input type="text" name="end_mydate" class="form-control datepicker" id="end_mydate" value="<?php if(isset($_GET['end_mydate'])){ echo $_GET['end_mydate']; } else { echo date('d-M-Y');}?>" required />
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
<?php } ?>

<!------------------------------------- Begin 6 Table Portlets -------------------------------------------->
<?php
	//$titles = array("Assigned Total","Pending Total");
	//$title_colors = array("green-seagreen","red-thunderbird");
	
	$start_date_f			=	date('jS F Y',strtotime($start_date));
	$end_date_f				=	date('jS F Y',strtotime($end_date));
	/*
	$start = $month = strtotime($start_date);
	//$end = time();
	$end = strtotime($end_date);
while($month < $end)
{
    ////////////////// echo date('F Y', $month), PHP_EOL;
     $month = strtotime("+1 month", $month);
}*/
 ?>

          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bg-inverse<?php //echo $portlet_color[$k]; ?>">
            <div class="portlet-title">
              <div class="caption"> <i class="icon-pie-chart font-green"></i><span class="caption-subject bold font-green ">
						Spare Parts Swapped - <?php echo $start_date_f.' to '.$end_date_f ?> </span></div>
              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
			<div class="row">
				<div class="col-md-6">
                            		<p>
									Destination         = It’s the Equipment where the Swap Part is Installed.<br/>
									Source              = It’s the Equipment where the Swap Part is Taken From.<br/>
									</p>
                                </div>
			</div>
			
                <table class="table  table-hover " id="sample_225">
					<thead class="bg-green">
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
						<th> </th>
					</tr>
					<tr>
						
						<th> Date </th>
						<th> Territory </th>
						<th> City </th>
						<th> Customer </th>
						<th> Vendor </th>
						<th> Equipment Source </th>
						<th> Serial No </th>
						<th> Part Number </th>
						<th> Part Description </th>
						<th> Quantity </th>
						<th> TSR Source </th>
						<th> Status TSR Source </th>
						<th> Balance </th>
						<th> Actions </th>
						
					</tr>
					</thead>
					<tbody> 
					
					<?php  // Current Pending Calls
						$q		= "SELECT tbl_stock.*, tbl_offices.office_name,tbl_stock.`date` AS 'stock_date',tbl_clients.client_name,tbl_vendors.vendor_name,tbl_products.product_name,tbl_instruments.serial_no,tbl_parts.part_number, tbl_parts.description, tbl_parts.unit_price, user.first_name, tbl_complaints.pk_complaint_id, tbl_sprf.part_source, tbl_instruments.pk_instrument_id,tbl_parts.pk_part_id, tbl_sprf.dc_number, `tbl_stock`.`fk_complaint_id` AS 'd', `tbl_sprf`.`fk_complaint_id` AS 's', tbl_complaints.ts_number, tbl_complaints.status, tbl_complaints.date AS 'complaint_date', tbl_parts.pk_part_id
								  from tbl_stock
								  LEFT JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
								  LEFT JOIN tbl_vendors ON tbl_parts.fk_vendor_id=tbl_vendors.pk_vendor_id
								  LEFT JOIN tbl_sprf ON (tbl_stock.date=tbl_sprf.creation_time) AND (`tbl_stock`.`fk_part_id`=`tbl_sprf`.`fk_part_id`)
								  LEFT JOIN tbl_complaints ON tbl_sprf.fk_complaint_id=tbl_complaints.pk_complaint_id
								  LEFT JOIN user ON tbl_complaints.assign_to=user.id
								  LEFT JOIN tbl_offices ON tbl_complaints.fk_office_id=tbl_offices.pk_office_id
								  LEFT JOIN tbl_cities ON tbl_complaints.fk_city_id = tbl_cities.pk_city_id
								  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
								  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
								  LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
								  WHERE `tbl_stock`.`stock_type`='Part Swap'";
						if ($dates_set=="yes") {
							$temp_date = date('Y-m-d H:i:s',strtotime('2015-04-01 00:00:00'));
							$q		.=	"AND CAST(tbl_stock.`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ";
						}
						$q		.=	"ORDER BY 'date' DESC";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $pmc) {
							/*
							$temp_time_taken = "";
							if ($pmc['status']=='Closed')
								$temp_time_taken = Get_Date_Difference($pmc["date"],$pmc["finish_time"]);
							else
								$temp_time_taken = Get_Date_Difference($pmc["date"],date('Y-m-d H:i:s'));*/
							
							//$temp_status = "";
							
							echo '<tr> ';
							echo '<td>'.date('d-M-Y',strtotime($pmc['complaint_date'])).'</td>';
							echo '<td>'.$pmc['office_name'].'</td>';
							echo '<td>'.$pmc['city_name'].'</td>';
							echo '<td>'.$pmc['client_name'].'</td>';
							echo '<td>'.$pmc['vendor_name'].'</td>';
							echo '<td>'.$pmc['product_name'].'</td>';
							echo '<td>'.$pmc['serial_no'].'</td>';
							echo '<td>'.$pmc['part_number'].'</td>';
							echo '<td>'.urldecode($pmc['description']).'</td>';
							echo '<td>'.$pmc['stock'].'</td>';
							echo '<td>'.$pmc['ts_number'].'</td>';
							echo '<td>'.$pmc['status'].'</td>';
							//echo '<td>'.$pmc["d"].'-'.$pmc["pk_complaint_id"].'</td>';
							
							$query			=	"SELECT SUM(stock) AS total_stock from tbl_stock WHERE fk_part_id='".$pmc['pk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))";
							$pq 			=	$this->db->query($query);
							$pr				=	$pq->result_array();
							$total_stock 	= 	$pr[0]['total_stock'];
							
							echo '<td>'.$total_stock.'</td>';
							//echo '<td>'.$pmc['pk_stock_id'].'</td>';
							echo '<td>';
								echo '<a class="btn btn-sm default purple-stripe" href="'.base_url().'complaint/technical_service_pvr/'.$pmc["pk_complaint_id"].'">TSR Source <i class="fa fa-eye"></i></a>';
								echo '<a class="btn btn-sm default yellow-stripe" href="'.base_url().'complaint/technical_service_pvr/'.$pmc["d"].'">TSR Destination<i class="fa fa-eye"></i></a>';
								echo '<a class="btn btn-sm default red-stripe" href="'.base_url().'products/ledger?part='.$pmc["pk_part_id"].'">Ledger <i class="fa fa-eye"></i></a>';
							echo '</td>';
							echo '</tr> ';
						}
					?>
					</tbody>
              </table>
            </div>
          </div>
		
          
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
	  'iDisplayLength': 500,
	  'aaSorting':[]
	});
	var table4 = $('#sample_225').dataTable({
			  'iDisplayLength': 500,
			   'aaSorting':[]
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
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
	
	//new $.fn.dataTable.FixedColumns( table );
});
</script>

<style>
textarea {
  width: 100%;
}
</style>