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
                    <h3 class="page-title"> Warranty Claims <?php //echo $part_number;?> <small></small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            Home 
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            Warranty Claims
                        </li> 
                      </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bg-inverse">
                          <div class="portlet-title">
                            <div class="caption font-grey-gallery"> <i class="icon-anchor font-grey-gallery"></i>Warranty Claims <?php //echo $part_number." (".$total_stock.")";?> </div>
                            <div class="tools"> 
                                <a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
						  
                            
					  <div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
                           <table class="table table-striped table-bordered table-hover flip-content dataaTablee " id="dataaTablee">
                              <thead class="bg-purple">
									<tr>
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
									  <th> Vendor Name </th>
                                      <th> Equipment Name </th>
									  <th> Equipment Serial </th>
									  <th> Part Number	</th>
									  <th> Part Description	</th>
									  <th> Invoice Number </th>
									  <th> Invoice Date </th>
									  <th> Stock In Date </th>
									  
                                    </tr>
                              </thead>
                              <tbody>
                                
                    <?php 
						  // For each loop of parts and echo them
						  
						  $query 			=	"SELECT tbl_stock.*, tbl_products.product_name, tbl_parts.part_number, tbl_parts.description,tbl_vendors.vendor_name
					  from tbl_stock
					  LEFT JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
					  LEFT JOIN tbl_vendors ON tbl_parts.fk_vendor_id=tbl_vendors.pk_vendor_id
					  LEFT JOIN tbl_instruments ON tbl_stock.equipment_serial=tbl_instruments.serial_no
					  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id=tbl_products.pk_product_id
					  WHERE tbl_stock.stock_type='Warranty Claim'
					  ORDER BY tbl_stock.date DESC, tbl_stock.pk_stock_id ASC";
					  
					  $pq 			=	$this->db->query($query);
					  $pr			=	$pq->result_array();
						  $balance = 0;
                          foreach ($pr as $stock_entry) {
                                  ?>
                                  <tr class="odd gradeX">
								  <td> <?php echo $stock_entry['vendor_name']; ?> </td>
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
					 			  ?>
                  
                              </tbody>
                            </table>
                                      
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
			var table = $('#dataaTablee').dataTable({
			  'iDisplayLength': 500,
			  'aaSorting':[]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 
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