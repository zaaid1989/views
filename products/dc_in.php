<?php $this->load->view('header.php');
function myDate($time){
  if($time == '0000-00-00 00:00:00')
     return "";
  if(substr($time,11)!= '00:00:00')
     return date("d-M-Y H:i:s", strtotime($time));
  return date("d-M-Y", strtotime($time));
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
                    <h3 class="page-title"> Direct Challans - Incoming <small></small> </h3>
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
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box grey-gallery">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-anchor"></i>DC Table </div>
                            <div class="tools"> 
                                <a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
					  <div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
					  <div class="table-scrollable">
                           <table class="table table-striped table-bordered table-hover hover flip-content dataaTablee" id="">
                  <thead class="bg-grey">
					
					
                    <tr>
					  <th> DC Number </th>
					  <th> Date </th>
                      <th> Vendor Name	</th>
					  <th> Part Number	</th>
                      <th> Part Description </th>
					  <th> Stock Type </th>
					  <th> Invoice Number </th>
					  <th> Invoice Date </th>
					  <th> Equipment Serial </th>
					  <th> Stock Quantity </th>
					  <th> Stock Location </th>
					  <th> Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php // query for fetching parts with pending dc and status as in
                          $query=$this->db->query("SELECT tbl_stock.*,tbl_parts.part_number,tbl_parts.description,tbl_vendors.vendor_name, tbl_offices.office_name
						  from tbl_stock
						  LEFT JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
						  LEFT JOIN tbl_vendors ON tbl_parts.fk_vendor_id=tbl_vendors.pk_vendor_id
						  LEFT JOIN tbl_offices ON tbl_stock.fk_office_id=tbl_offices.pk_office_id
						  WHERE tbl_stock.in_status = 'approved' AND tbl_stock.dc_type = 'in' ORDER BY tbl_stock.dc_number");
						  $query_res=$query->result_array();
						  // For each loop of parts and echo them
						  $dc_number=-1;
						  $count=1;
                          foreach ($query_res as $dc_entry) {
							  $qdc=$this->db->query("SELECT * from tbl_stock WHERE tbl_stock.in_status = 'approved' AND tbl_stock.dc_type = 'in' AND dc_number='".$dc_entry['dc_number']."'");
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
                                      <td> <?php echo $dc_entry['vendor_name']; ?> </td>
									  <td> <?php echo $dc_entry['part_number']; ?> </td>
									  <td> <?php echo urldecode($dc_entry['description']); ?> </td>
									  <td> <?php echo $dc_entry['stock_type']; ?> </td>
									  <td> <?php echo $dc_entry['invoice_number']; ?> </td>
									  <td> <?php echo myDate($dc_entry['invoice_date']); ?> </td>
									  <td> <?php echo $dc_entry['equipment_serial']; ?> </td>
									  <td> <?php echo $dc_entry['stock']; ?> </td>
									  <td> <?php echo $dc_entry['office_name']; ?> </td>
									  <?php if ($count==1) { ?>
									  <td rowspan="<?php echo $dc_count; ?>">
										  <a class="btn btn default grey-gallery"  
										  href="<?php echo base_url();?>products/dc_print/<?php echo $dc_entry["dc_number"]; ?>">
											Print DC 
										  </a>
									  </td>
									  <?php } ?>
                                  </tr>
                                  <?php
								  $count++;
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
		