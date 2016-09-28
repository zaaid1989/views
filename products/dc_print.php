<?php $this->load->view('header');
function myDate($time){
  if($time == '0000-00-00 00:00:00')
     return "";
  if(substr($time,11)!= '00:00:00')
     return date("d-M-Y H:i:s", strtotime($time));
  return date("d-M-Y", strtotime($time));
}
?>
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Direct Challan - Incoming <small></small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						Home 
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						DC Incoming
					</li>
				</ul>
				<div class="page-toolbar">
					
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
            <?php
					$dbres 		= $this->db->query("SELECT * FROM tbl_sprf where `dc_number` = '".$this->uri->segment(3)."'");
					$customers_list	= $dbres->result_array();
					
				?>
			<div class="invoice">
				<div class="row invoice-logo">
					<div class="col-xs-6 invoice-logo-space">
						<img src="<?php echo base_url();?>assets/global/img/PMA23.png" style="width:200px;" alt="logo" class="img-responsive custom-mobile-class" />
					</div>
					<div class="col-xs-6">
						<p>
							 DC #: <?php echo $this->uri->segment(3);?>	 <br/> <?php echo "Print Date: ".date('d M Y');?>
						</p>
					</div>
				</div>
				<hr/>
                <style>
                .invoice .invoice-logo p {
					padding: 5px 0;
					font-size: 26px;
					line-height: 28px;
					text-align: right;
				}
				.invoice .invoice-logo p span {
					display: block;
					font-size: 14px;
				}
                </style>
                
                <div class="row">
					<div class="col-xs-12">
                    &nbsp;
                    <br>
                    &nbsp;
                    <br>
                    </div>
                </div>
                
				<div class="row">
					<div class="col-xs-12">
						<table class="table table-striped table-hover">
						<thead class="bg-grey">
                    <tr>
					  <th> # </th>
					  <th > Date </th>
                      <th > Vendor Name	</th>
					  <th > Part Number	</th>
                      <th > Part Description </th>
					  <th > Stock Type </th>
					  <th > Invoice Number </th>
					  <th > Invoice Date </th>
					  <th > Equipment Serial </th>
					  <th > Stock Quantity </th>
					  <th > Stock Location </th>
                    </tr>
                  </thead>
						<tbody>
						<?php // query for fetching parts with pending dc and status as in
                          $query=$this->db->query("SELECT tbl_stock.*,tbl_parts.part_number,tbl_parts.description,tbl_vendors.vendor_name, tbl_offices.office_name
						  from tbl_stock
						  LEFT JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
						  LEFT JOIN tbl_vendors ON tbl_parts.fk_vendor_id=tbl_vendors.pk_vendor_id
						  LEFT JOIN tbl_offices ON tbl_stock.fk_office_id=tbl_offices.pk_office_id
						  WHERE tbl_stock.in_status = 'approved' AND tbl_stock.dc_type = 'in' AND tbl_stock.dc_number ='".$this->uri->segment(3)."' ORDER BY tbl_stock.dc_number");
						  $query_res=$query->result_array();
						  // For each loop of parts and echo them
						  $count=1;
                          foreach ($query_res as $dc_entry) {
                                  ?>
                                  <tr class="odd gradeX">
									  <td> <?php echo $count; ?> </td>
									  <td> <?php echo myDate($dc_entry['date']); ?> </td>
                                      <td> <?php echo $dc_entry['vendor_name']; ?> </td>
									  <td style="width: 15px;"> <?php echo $dc_entry['part_number']; ?> </td>
									  <td style="width: 15px;"> <?php echo urldecode($dc_entry['description']); ?> </td>
									  <td> <?php echo $dc_entry['stock_type']; ?> </td>
									  <td> <?php echo $dc_entry['invoice_number']; ?> </td>
									  <td> <?php echo myDate($dc_entry['invoice_date']); ?> </td>
									  <td> <?php echo $dc_entry['equipment_serial']; ?> </td>
									  <td> <?php echo $dc_entry['stock']; ?> </td>
									  <td> <?php echo $dc_entry['office_name']; ?> </td>
                                  </tr>
                                  <?php
								  $count++;
								  } // End of For each
					 			  ?>
						</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					
					<div class="col-xs-8 invoice-block">
						
						<br/>
						<a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						Print <i class="fa fa-print"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>