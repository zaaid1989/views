<?php $this->load->view('header');
?>
<script src="//cdn.ckeditor.com/4.5.11/basic/ckeditor.js"></script>
										
										
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Parts Received Report <small><?php //echo $average_visits_per_day; ?></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Parts Received Report
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
       <!-- BEGIN PAGE CONTENT-->
       <div class="row">
        <div class="col-md-12"> 



          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bg-inverse<?php //echo $portlet_color[$k]; ?>">
            <div class="portlet-title">
              <div class="caption"> <i class="icon-pie-chart font-purple"></i><span class="caption-subject bold font-purple ">
						Spare Parts Received Back </span></div>
              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
			<!--
			<textarea name="editor1" id="editor1" rows="10" cols="80">
                This is my textarea to be replaced with CKEditor.
            </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
			-->
			
                <table class="table  table-hover " id="sample_225">
					<thead class="bg-purple">
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
					</tr>
					<tr>
						
						<th> Vendor </th>
						<th> Equipment </th>
						<th> Serial Number </th>
						<th> Customer </th>
						<th> Part Number </th>
						<th> Part Description </th>
						<th> Condition </th>
						<th> Received Part Location </th>
						<th> Receiver Name </th>
						<th> Comments </th>
						<th> Actions </th>
						
					</tr>
					</thead>
					<tbody> 
					
					<?php  // Current Pending Calls
						$q		= "SELECT tbl_stock.*, tbl_offices.office_name,tbl_stock.`date` AS 'stock_date',tbl_clients.client_name,tbl_vendors.vendor_name,tbl_products.product_name,tbl_instruments.serial_no,tbl_parts.part_number, tbl_parts.description, tbl_parts.unit_price, user.first_name, tbl_complaints.pk_complaint_id, tbl_sprf.part_source, tbl_instruments.pk_instrument_id,tbl_parts.pk_part_id, tbl_sprf.dc_number
								  from tbl_stock
								  LEFT JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
								  LEFT JOIN tbl_vendors ON tbl_parts.fk_vendor_id=tbl_vendors.pk_vendor_id
								  LEFT JOIN tbl_sprf ON tbl_stock.fk_sprf_id=tbl_sprf.pk_sprf_id
								  LEFT JOIN tbl_complaints ON tbl_stock.fk_complaint_id=tbl_complaints.pk_complaint_id
								  LEFT JOIN user ON tbl_complaints.assign_to=user.id
								  LEFT JOIN tbl_offices ON tbl_complaints.fk_office_id=tbl_offices.pk_office_id
								  LEFT JOIN tbl_cities ON tbl_complaints.fk_city_id = tbl_cities.pk_city_id
								  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
								  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
								  LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
								  WHERE stock_type='Received Back'";
						
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $pmc) {
							
							echo '<tr> ';
							echo '<td>'.$pmc['vendor_name'].'</td>';
							echo '<td>'.$pmc['product_name'].'</td>';
							echo '<td>'.$pmc['serial_no'].'</td>';
							echo '<td>'.$pmc['client_name'].'</td>';
							echo '<td>'.$pmc['part_number'].'</td>';
							echo '<td>'.urldecode($pmc['description']).'</td>';
							echo '<td>'.$pmc['old_inventory_description'].'</td>';
							echo '<td>'.$pmc['office_name'].'</td>';
							echo '<td>'.$pmc['receiver_name'].'</td>';
							echo '<td>'.urldecode($pmc['comments']).'</td>';
							$rq 	= $this->db->query("SELECT * FROM tbl_stock WHERE fk_stock_id='".$pmc['pk_stock_id']."'");
							$rb		= $rq->result_array();
							
							echo '<td>';
								echo '<a class="btn btn-sm default purple-stripe" href="'.base_url().'complaint/technical_service_pvr/'.$pmc["pk_complaint_id"].'">TSR <i class="fa fa-eye"></i></a>';
								echo '<a class="btn btn-sm default yellow-stripe" href="'.base_url().'complaint/equipment_audit?equipment='.$pmc["pk_instrument_id"].'">Audit <i class="fa fa-eye"></i></a>';
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