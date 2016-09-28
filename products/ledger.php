<?php $this->load->view('header.php');
//if($this->uri->segment(3)=='') show_404();

$part_id = 0;
if(isset($_GET['part'])) {
	$part_id = $_GET['part'];
}

//$part_id		=	$this->uri->segment(3);

$pq 			=	$this->db->query("SELECT fk_product_id,part_number,description,fk_vendor_id from tbl_parts WHERE pk_part_id='".$part_id."'");
$pr				=	$pq->result_array();
if (sizeof($pr)>0) {
$product_id 	= 	$pr[0]['fk_product_id'];
$part_number 	=	$pr[0]['part_number'];
$vendor_id	 	=	$pr[0]['fk_vendor_id'];
$part_description 	=	urldecode($pr[0]['description']);
}
else {
$product_id 	= 	"";
$part_number 	=	"";
$vendor_id	 	=	"";
$part_description 	=	"";
}

$pq 			=	$this->db->query("SELECT vendor_name from tbl_vendors WHERE pk_vendor_id='".$vendor_id."'");
$pr				=	$pq->result_array();
if (sizeof($pr)>0)
$vendor_name 	= 	$pr[0]['vendor_name'];
else $vendor_name 	= 	"-";

$pq 			=	$this->db->query("SELECT product_name from tbl_products WHERE pk_product_id='".$product_id."'");
$pr				=	$pq->result_array();
if (sizeof($pr)>0)
$product_name 	= 	$pr[0]['product_name'];
else $product_name 	= 	"-";

$query			=	"SELECT SUM(stock) AS total_stock from tbl_stock WHERE fk_part_id='".$part_id."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))";
//
if(isset($_GET['office']) && $_GET['office']>0) {$query .=	" AND fk_office_id='".$_GET['office']."'";}
if(isset($_GET['stock_type']) && $_GET['stock_type']!="") {$query .= " AND stock_type='".$_GET['stock_type']."'";}
$pq 			=	$this->db->query($query);
$pr				=	$pq->result_array();
$total_stock 	= 	$pr[0]['total_stock'];

$query 			=	"SELECT tbl_stock.*, tbl_offices.office_name,tbl_sprf.part_source, tbl_sprf.fk_complaint_id AS 'sprf_complaint'
					  from tbl_stock
					  JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
					  JOIN tbl_vendors ON tbl_parts.fk_vendor_id=tbl_vendors.pk_vendor_id
					  JOIN tbl_offices ON tbl_stock.fk_office_id=tbl_offices.pk_office_id
					  LEFT JOIN tbl_sprf ON tbl_stock.fk_sprf_id=tbl_sprf.pk_sprf_id
					  WHERE tbl_stock.fk_part_id='".$part_id."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))";
if(isset($_GET['office']) && $_GET['office']>0) {$query .=	" AND tbl_stock.fk_office_id='".$_GET['office']."'";}
if(isset($_GET['stock_type']) && $_GET['stock_type']!="") {$query .= " AND stock_type='".$_GET['stock_type']."'";}
//
if(isset($_GET['order']) && $_GET['order'] == "date_descending") {$query .=	" ORDER BY tbl_stock.date DESC";}
elseif(isset($_GET['order']) && $_GET['order'] == "invoice_ascending") {$query .=	" ORDER BY tbl_stock.invoice_date ASC";}
elseif(isset($_GET['order']) && $_GET['order'] == "invoice_descending") {$query .=	" ORDER BY tbl_stock.invoice_date DESC";}
elseif(isset($_GET['order']) && $_GET['order'] == "dc_ascending") {$query .=	" ORDER BY tbl_stock.dc_number ASC";}
elseif(isset($_GET['order']) && $_GET['order'] == "dc_descending") {$query .=	" ORDER BY tbl_stock.dc_number DESC";}
elseif(isset($_GET['order']) && $_GET['order'] == "office") {$query .=	" ORDER BY tbl_stock.fk_office_id ASC";}
elseif(isset($_GET['order']) && $_GET['order'] == "stock_type") {$query .=	" ORDER BY tbl_stock.stock_type ASC";}
elseif(isset($_GET['order']) && $_GET['order'] == "stock_out") {$query .=	" ORDER BY CAST(`stock` AS SIGNED) ASC";}
elseif(isset($_GET['order']) && $_GET['order'] == "stock_in") {$query .=	" ORDER BY CAST(`stock` AS SIGNED) DESC";} //CAST(thecolumn AS int)
else {$query   .=	" ORDER BY tbl_stock.date ASC";}
$pq 			=	$this->db->query($query);
$pr				=	$pq->result_array();

function myDate($time){
  if($time == '0000-00-00 00:00:00')
     return "";
  if(substr($time,11)!= '00:00:00')
     return date("d-M-Y H:i:s", strtotime($time));
  return date("d-M-Y", strtotime($time));
}
function echozero($val) {
	if ($val==0) return '';
	else return $val;
}

?>
<script>
$(window).load(function() {   
  $('#loader').hide();
  $('#sample_z').show('slow');
});
</script>

<style>
#sample_zz { display:none }
</style>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Ledger  <?php //echo $part_number;?> <small></small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            Home 
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            Ledger
                        </li> 
                      </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
						<?php
						  if(isset($_GET['delete']) && $_GET['delete']=='success') { 
							  echo '<div class="alert alert-success alert-dismissable">  
									  <a class="close" data-dismiss="alert">×</a>  
									  Stock Entry Deleted Successfully.  
									</div>';
							}
						  ?>
                        <div class="portlet light bg-inverse">
                          <div class="portlet-title">
                            <div class="caption font-grey-gallery"> 
								<span class="caption-subject bold font-purple-seance uppercase">
								<i class="icon-anchor"></i>
								Ledger - <?php echo $part_number." (".$total_stock.")";?> </span>
								<span class="caption-helper font-grey-gallery"><?php echo $part_description; ?></span>
							</div>
							<div class="tools"> 
                                <a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
						  
					<form method="get" action="<?php echo base_url();?>products/ledger<?php //echo $part_id; ?>">
					
					<div class="col-md-4">
                            		<div class="form-group">
                                        <select name="part" id="part" class="form-control" required>
                                            <option value="">--Select Part--</option>
											<?php 
											$maxqu = $this->db->query("SELECT DISTINCT tbl_stock.fk_part_id ,tbl_parts.*,tbl_products.product_name 
											FROM tbl_stock 
											LEFT JOIN tbl_parts ON tbl_parts.pk_part_id = tbl_stock.fk_part_id
											LEFT JOIN tbl_products ON tbl_parts.fk_product_id = tbl_products.pk_product_id
											WHERE tbl_parts.fk_product_id!='0' ");
										
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['pk_part_id'];//pk_product_id?>" <?php if(isset($_GET['part']) && $_GET['part']==$val['pk_part_id']){ echo 'selected="selected"';}//pk_instrument_id?>>
													<?php echo $val['part_number'].' - '.$val['product_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
										<span class="help-block">Part</span>
                            		</div>
                          		</div>
						
                            <div class="col-md-2">
                                <div class="form-group">
									<select class="form-control" id="office" name="office" >
									<option value="">---Choose---</option>
									<option value="">All</option>
									<?php
									$query = $this->db->query("select * from tbl_offices");
									$result = $query->result_array();
										  foreach($result as $office)
										  {
									?>
											<option value="<?php echo $office['pk_office_id']?>" <?php if(isset($_GET['office']) && $_GET['office']==$office['pk_office_id']){ echo ' selected="selected"';}?>>
												<?php echo $office['office_name']?>
											</option>
									<?php }?>
									</select>
                                    <span class="help-block">Office</span>
                                </div>
                            </div>
							
							<div class="col-md-2">
                                <div class="form-group">
									<select class="form-control" id="stock_type" name="stock_type" >
									<option value="">---Choose---</option>
									<option value="">All</option>
									<?php
									$query = $this->db->query("select DISTINCT stock_type from tbl_stock");
									$result = $query->result_array();
										  foreach($result as $stock_type)
										  { if ($stock_type['stock_type']!="") {
									?>
											<option value="<?php echo $stock_type['stock_type']?>" <?php if(isset($_GET['stock_type']) && $_GET['stock_type']==$stock_type['stock_type']){ echo ' selected="selected"';}?>>
												<?php echo $stock_type['stock_type']?>
											</option>
									 <?php }}?>
									</select>
                                    <span class="help-block">Stock Type</span>
                                </div>
                            </div>
							
							<div class="col-md-2">
                                <div class="form-group">
									<select class="form-control" id="order" name="order" >
									<option value="">---Choose---</option>
									<option value="date_ascending" <?php if(isset($_GET['order']) && $_GET['order']=='date_ascending'){ echo ' selected="selected"';}?>>Date Ascending</option>
									<option value="date_descending" <?php if(isset($_GET['order']) && $_GET['order']=='date_descending'){ echo ' selected="selected"';}?>>Date Descending</option>
									<option value="invoice_ascending" <?php if(isset($_GET['order']) && $_GET['order']=='invoice_ascending'){ echo ' selected="selected"';}?>>Invoice Ascending</option>
									<option value="invoice_descending" <?php if(isset($_GET['order']) && $_GET['order']=='invoice_descending'){ echo ' selected="selected"';}?>>Invoice Descending</option>
									<option value="dc_ascending" <?php if(isset($_GET['order']) && $_GET['order']=='dc_ascending'){ echo ' selected="selected"';}?>>DC Number Ascending</option>
									<option value="dc_descending" <?php if(isset($_GET['order']) && $_GET['order']=='dc_descending'){ echo ' selected="selected"';}?>>DC Number Descending</option>
									<option value="office" <?php if(isset($_GET['order']) && $_GET['order']=='office'){ echo ' selected="selected"';}?>>Office</option>
									<option value="stock_type" <?php if(isset($_GET['order']) && $_GET['order']=='stock_type'){ echo ' selected="selected"';}?>>Stock Type</option>
									<option value="stock_in" <?php if(isset($_GET['order']) && $_GET['order']=='stock_in'){ echo ' selected="selected"';}?>>Stock In</option>
									<option value="stock_out" <?php if(isset($_GET['order']) && $_GET['order']=='stock_out'){ echo ' selected="selected"';}?>>Stock Out</option>
									</select>
                                    <span class="help-block">Sorting Order</span>
                                </div>
                            </div>
							<!-- For date picker
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="end_date" class="form-control datepicker" value=""  />
                                    <span class="help-block">End Date</span>
                                </div>
                            </div>
							-->
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                        <input type="submit"  class="btn btn-default yellow-gold" value="Search" >
                                </div>
                            </div>
                        </form>
                            
					  <div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
					  <div class="table-scrollable">
                           <table class="table table-striped table-bordered table-hover flip-content   " id="">
                              <thead class="bg-purple">
                                    <tr>
                                      <th> Date </th>
									  <th> Stock<br/>Type	</th>
									  <th> Invoice<br/>Number	</th>
									  <th> Invoice<br/>Date </th>
									  <th> <?php echo $product_name;?><br/>Serial </th>
									  <th> Old Inventory<br/>Description </th>
									  <th> TS<br/>Destination </th>
									  <th> Customer<br/>Name </th>
									  <th> City </th>
									  <th> Office </th>
									  <th> DC Number </th>
									  <th> Stock In </th>
									  <th> Stock Out </th>
									  <th> Balance </th>
									  <th> Comments </th>
									  <th> Actions </th>
                                    </tr>
                              </thead>
                              
                                <tbody>
                    <?php 
						  // For each loop of parts and echo them
						  $balance = 0;
                          foreach ($pr as $stock_entry) {
							  $balance = $balance + $stock_entry['stock'];
                                  ?>
                                  <tr class="odd gradeX">
									  <td> <?php echo myDate($stock_entry['date']); ?> </td>
									  <td> <?php 
												if ($stock_entry['stock_type']=='TS' AND $stock_entry['part_source']=='client')
													echo 'Swap Destination';//$stock_entry['stock_type']; 
												elseif ($stock_entry['stock_type']=='Part Swap')
													echo 'Swap Source';
												else echo $stock_entry['stock_type'];
											?> 
										</td>
									  <td> <?php echo $stock_entry['invoice_number']; ?> </td>
									  <td> <?php echo myDate($stock_entry['invoice_date']); ?> </td>
									  <td> <?php echo $stock_entry['equipment_serial']; ?> </td>
									  <td> <?php echo urldecode($stock_entry['old_inventory_description']); ?> </td>
                                      <td> <?php 
												if ($stock_entry['stock_type']=='Part Swap') {
													$source_ts = '';
													/*
													$tq = $this->db->query("SELECT ts_number from tbl_complaints WHERE pk_complaint_id='".$stock_entry['sprf_complaint']."'");
													$tr = $tq->result_array();
													if (sizeof($tr)>0)
														echo echozero($tr[0]['ts_number']);
													*/
													if ($stock_entry["source_complaint_id"]== '0') echo "Complaint not found";
													else {
														if ($stock_entry['source_ts']=='') {
															$q=$this->db->query("SELECT ts_number from tbl_complaints WHERE pk_complaint_id='".$stock_entry['source_complaint_id']."'");
															$r=$q->result_array();
															if (sizeof($r)>0) $source_ts = $r[0]['ts_number'];
														}
														else $source_ts = echozero($stock_entry['source_ts']);
														
														//echozero($stock_entry['source_ts']);
														if ($source_ts!='')
															echo '<a  href="'.base_url().'complaint/ts_report_director/'.$stock_entry["source_complaint_id"].'">'.$source_ts.'</a>';
														else
															echo "Complaint not found";
													}
													
												}
												else
													echo '<a  href="'.base_url().'complaint/ts_report_director/'.$stock_entry["fk_complaint_id"].'">'.echozero($stock_entry['ts_number']).'</a>';//echo echozero($stock_entry['ts_number']);
											?> 
									  </td>
									  <td> <?php echo $stock_entry['customer_name']; ?> </td>
									  <td> <?php echo $stock_entry['city_name']; ?> </td>
									  <td> <?php echo $stock_entry['office_name']; ?> </td>
									  <td> <?php echo echozero($stock_entry['dc_number']); ?> </td>
									  <td> <?php if($stock_entry['stock']>0) echo $stock_entry['stock']; ?></td> <!-- stock in -->
									  <td> <?php if($stock_entry['stock']<0) echo $stock_entry['stock']; ?></td> <!-- stock out -->
									  <td> <?php echo $balance; ?> </td> <!-- balance -->
									  <td> <?php echo urldecode($stock_entry['comments']); ?> </td>
									  <td> <center>
										  <a class="btn btn-sm red-thunderbird"  
										  href="<?php echo base_url();?>products/delete_stock/<?php echo $stock_entry["pk_stock_id"]; ?>?part=<?php echo $part_id; ?>"
										  onClick="return confirm('Are you sure you want to delete?')">
											<i class="fa fa-trash-o"></i>
										  </a>
										  </center>
									  </td>
                                  </tr>
                                  <?php
								  } // End of For each
					 			  ?>
                  </tbody>
                              
                            </table>
                       </div>               
                          </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET--> 
                      </div>
                    </div>
      				<!-- END PAGE CONTENT-->
                    
                    
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer.php');?>
		<script>
		$(document).ready(function() { 
			var table = $('.dataaTable').dataTable({
			  'iDisplayLength': 200,
			  'bSort':false,
			  'bFilter':false,
			  'bPaginate':false,
			  'bAutoWidth':false
			});
			
			//new $.fn.dataTable.FixedColumns( table );
		});
		</script>