
<?php $this->load->view('header.php');?>
<script>
$(window).load(function() {   
  $('#loader').hide();
  $('#dataaTable').show('slow','linear');
});
</script>

<style>
thead select {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
		background-color:#ea4b4b !important;
		color:white !important;
		
		
    }
#dataaTable { display:none }

</style>
                    
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Parts Status Against SPRF <small>This page display all parts that are Pending SPRF Form approval, once the SPRF form is approved the part is automatically removed from the list</small></h3>
					
					
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i>Home <i class="fa fa-angle-right"></i> </li>
                        <li> Parts Status Against SPRF </li>
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
					  <!--
					  <div class="note note-info">
								<h4 class="block">Bootstrap Growl</h4>
								<p>
									 This page display all parts that are Pending SPRF Form approval, once the SPRF form is approved the part is automatically removed from the list
								</p>
						</div>
						-->
						
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue-hoki">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-briefcase"></i>Parts Status Against SPRF </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Business Project Added Successfully.  
											  </div>';
									  }
								  ?>
                                  <?php
                                  	if(isset($_GET['upt']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Business Project Updated Successfully.  
											  </div>';
									  }
								  ?>
                                  <?php
                                  	if(isset($_GET['del']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												SPR entry deleted successfully.  
											  </div>';
									  }
								  ?>
                              
                            </div>
                        <div class="portlet-body flip-scroll">
						
						<div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
						
                             <table class="table table-striped table-bordered table-hover flip-content " id="dataaTable">
                              <thead class="bg-grey-cascade">
                                <tr>
                                  <th>	</th>
                                  <th>	</th>
                                  <th>	</th>
                                  <th>	</th>
                                  <th>	</th>
                                  <th>	</th>
                                  <th>	</th>
                                  <th>	</th>
                                  <th>	</th>
                                  <th> 	</th>
								  <th> 	</th>
								  <th> 	</th>
								 <!-- <th> 	</th> -->
                                </tr>
                             
                                <tr>
                                  <th>City	</th>
                                  <th>Customer	</th>
                                  <th>Equipment	</th>
                                  <th>Serial Number	</th>
                                  <th>TS Number	</th>
                                 <!-- <th>TS Status	</th> -->
                                  <th>Vendor	</th>
                                  <th>Part Number	</th>
                                  <th>Part Description	</th>
                                  <th>Quantity 	</th>
								  <th>Stock 	</th>
								  <th>Quantity Ordered 	</th>
								  <th>Actions 	</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
								
								$zquery = "	select tbl_sprf.*,tbl_complaints.ts_number,tbl_clients.client_name,tbl_cities.city_name,tbl_products.product_name,tbl_instruments.serial_no,tbl_instruments.pk_instrument_id,tbl_complaints.status AS `complaint_status`,tbl_vendors.vendor_name,tbl_parts.part_number,tbl_parts.description,tbl_parts.pk_part_id,tbl_complaints.pk_complaint_id, torders.order_quantity
											from tbl_sprf
											LEFT JOIN tbl_complaints ON tbl_sprf.fk_complaint_id = tbl_complaints.pk_complaint_id
											LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
											LEFT JOIN tbl_cities ON tbl_complaints.fk_city_id = tbl_cities.pk_city_id
											LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
											LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
											LEFT JOIN tbl_parts ON tbl_parts.pk_part_id = tbl_sprf.fk_part_id
											LEFT JOIN tbl_vendors ON tbl_parts.fk_vendor_id = tbl_vendors.pk_vendor_id
											LEFT JOIN (SELECT * FROM tbl_orders WHERE status='1') torders ON tbl_sprf.fk_part_id = torders.fk_part_id
											where tbl_sprf.`status`='0' AND tbl_complaints.status='Pending SPRF' ";
								
								$ty=$this->db->query($zquery);
								$rt=$ty->result_array();
									 if (sizeof($rt) == "0") {
									  } else {
											foreach ($rt as $spr) {
											  echo "<tr>";
											  echo "<td>".$spr['city_name']."</td>";
											  echo "<td>".$spr['client_name']."</td>";
											  echo "<td>".$spr['product_name']."</td>";
											  echo "<td>".$spr['serial_no']."</td>";
											  echo "<td>".$spr['ts_number']."</td>";
											//  echo "<td>".$spr['complaint_status']."</td>";
											  echo "<td>".$spr['vendor_name']."</td>";
											  echo "<td>".$spr['part_number']."</td>";
											  echo "<td>".urldecode($spr['description'])."</td>";
											  echo "<td>".$spr['quantity']."</td>";
											  echo "<td>";
												  $stock = $this->db->query("select * from tbl_stock where  fk_part_id='".$spr['fk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))");
													if($stock->num_rows()>0) {
														$stock_result = $stock->result_array();
														$stock_total=0;
														foreach($stock_result as $total_stock) {
															$stock_total= $stock_total + $total_stock['stock'];
														}
														echo $stock_total;
													}
													else
														echo '0';
											  echo "</td>";
											   echo "<td>".$spr['order_quantity']."</td>";
											  echo "<td>";
											   echo '<a class="btn btn-sm default purple-stripe" href="'.base_url().'sys/technical_service_pvr/'.$spr['pk_complaint_id'].'">TSR <i class="fa fa-eye"></i></a>';
											   echo '<a class="btn btn-sm default green-meadow-stripe" href="'.base_url().'products/supervisor_sprf/'.$spr['pk_complaint_id'].'">SPRF <i class="fa fa-eye"></i></a>';
											   echo '<a class="btn btn-sm default blue-stripe" href="'.base_url().'products/ledger?part='.$spr['pk_part_id'].'">Ledger <i class="fa fa-eye"></i></a>';
											   echo '<a class="btn btn-sm default yellow-stripe" href="'.base_url().'sys/equipment_audit?equipment='.$spr['pk_instrument_id'].'">Audit <i class="fa fa-eye"></i></a>';
											   echo '<a class="btn btn-sm default red-stripe" href="'.base_url().'products/delete_sprf/'.$spr['pk_sprf_id'].'" onClick="return confirm(\'Are you sure you want to delete?\')">Delete <i class="fa fa-trash"></i></a>';
											  echo "</td>";
											  echo "</tr>";
										  }
									  }
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
			var table = $('#dataaTable').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 6, "desc" ]]
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
								null
						]

		});
});

</script>
		
