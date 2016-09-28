<?php $this->load->view('header');
?>
										
										
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Kits <small><?php //echo $average_visits_per_day; ?></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Kits
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
              <div class="caption"> <i class="icon-pie-chart font-blue-chambray"></i><span class="caption-subject bold font-blue-chambray ">
						Manufacture Wise Product List </span></div>
              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
			
                <table class="table  table-hover " id="sample_225">
					<thead class="bg-blue-chambray">
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
						
						<th> Vendor </th>
						<th> Country </th>
						<th> Cat # </th>
						<th> Category </th>
						<th> Product </th>
						<th> Kit </th>
						<th> Pack Size </th>
						<th> Storage Temp Before Use/Opening </th>
						<th> Hazardous Material </th>
						<th> Tests/Pack (Manual) </th>
						<th> Tests/Pack (Automated Tested) </th>
						<th> MSQ </th>
						<th> Currency </th>
						<th> Unit Price </th>
						
					</tr>
					</thead>
					<tbody> 
					
					<?php  // Current Pending Calls
						$q		= "SELECT  `tbl_kits`.`pk_kit_id`,COALESCE(GROUP_CONCAT(tbl_products.product_name SEPARATOR ', '), '') AS `product_name`,`tbl_kits`.`kit_name`, `tbl_kits`.`cat_number`, `tbl_category`.`category_name`, `tbl_vendors`.`vendor_name`, `tbl_vendors`.`country`, `tbl_kits`.`pack_size`, `tbl_kits`.`temp_before_use`, `tbl_kits`.`hazardous`, `tbl_kits`.`tests_pack_manual`, `tbl_kits`.`tests_pack_auto`, `tbl_kits`.`msq`, `tbl_kits`.`unit_price`, `tbl_kits`.`currency` 
						FROM `tbl_kits`
						LEFT JOIN tbl_category ON tbl_kits.fk_category_id=tbl_category.pk_category_id
						LEFT JOIN tbl_vendors ON tbl_kits.fk_vendor_id=tbl_vendors.pk_vendor_id
						LEFT JOIN tbl_kit_product_bridge ON tbl_kits.pk_kit_id=tbl_kit_product_bridge.fk_kit_id
						LEFT JOIN tbl_products ON tbl_kit_product_bridge.fk_product_id=tbl_products.pk_product_id
						WHERE tbl_kits.deleted=0
						GROUP BY tbl_kits.pk_kit_id";
						
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $kit) {
							
							echo '<tr> ';
							echo '<td>'.$kit['vendor_name'].'</td>';
							echo '<td>'.$kit['country'].'</td>';
							echo '<td>'.$kit['cat_number'].'</td>';
							echo '<td>'.$kit['category_name'].'</td>';
							echo '<td>'.$kit['product_name'].'</td>';
							echo '<td>'.$kit['kit_name'].'</td>';
							echo '<td>'.$kit['pack_size'].'</td>';
							echo '<td>'.$kit['temp_before_use'].'</td>';
							echo '<td>'.$kit['hazardous'].'</td>';
							echo '<td>'.$kit['tests_pack_manual'].'</td>';
							echo '<td>'.$kit['tests_pack_auto'].'</td>';
							if ($kit['msq']!='0')
								echo '<td>'.$kit['msq'].'</td>';
							else echo '<td></td>';
							echo '<td>'.$kit['currency'].'</td>';
							echo '<td>'.$kit['unit_price'].'</td>';
							
							/*
							echo '<td>';
								echo '<a class="btn btn-sm default purple-stripe" href="'.base_url().'complaint/ts_report_director/'.$kit["pk_complaint_id"].'">TSR <i class="fa fa-eye"></i></a>';
								echo '<a class="btn btn-sm default yellow-stripe" href="'.base_url().'complaint/equipment_audit?equipment='.$kit["pk_instrument_id"].'">Audit <i class="fa fa-eye"></i></a>';
								echo '<a class="btn btn-sm default red-stripe" href="'.base_url().'products/ledger?part='.$kit["pk_part_id"].'">Ledger <i class="fa fa-eye"></i></a>';
								
							echo '</td>';
							*/
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