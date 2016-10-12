<?php $this->load->view('header');?>

<script>
$(window).load(function() {   
  $('#loader').hide();
  $('#sample_2').show();
});
</script>

                     <style>
#sample_2 { display:none }

</style>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Operator  <small>Pending for DC</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                 Pending for DC
                            </li>
                            
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red-thunderbird">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-magic-wand"></i>Pending for DC </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												'.$_GET['msg'].'  
											  </div>';
									  }
									  if(isset($_GET['msg_update']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												'.$_GET['msg_update'].'  
											  </div>';
									  }
									  
								  ?>
                              
                            </div>
							<div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
                            <div class="portlet-body flip-scroll">
                                 <table class="table table-striped table-bordered table-hover flip-content" id="sample_220">
                                    <thead class="bg-grey-gallery">
									<tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
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
                                    <th>
                                         DC# 
                                    </th>
                                    <th>
                                         DC Date
                                    </th>
                                    <th>
                                         TS Number
                                    </th>
                                    <th>
                                         Equipment
                                    </th>
                                    <th>
                                         S/No
                                    </th>
                                    <th>
                                         Part Description
                                    </th>
                                    
                                    <th>
                                         Part #
                                    </th>
                                    <th>
                                         Quantity
                                    </th>
                                    <th>
                                         Customer
                                    </th>
                                    
                                     <th>
                                         City
                                    </th>
                                    <td>
                                      	Print
                                    </td>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  $dbres 		= $this->db->query("
									  SELECT tbl_sprf.*, 
									  COALESCE(NULLIF(tbl_complaints.ts_number, ''), 'No record available') AS ts_number,
									  COALESCE(NULLIF(tbl_products.product_name, ''), 'No record available') AS product_name,
									  COALESCE(NULLIF(tbl_instruments.serial_no, ''), 'No record available') AS serial_no,
									  COALESCE(NULLIF(tbl_clients.client_name, ''), 'No record available') AS client_name,
									  COALESCE(NULLIF(tbl_cities.city_name, ''), 'No record available') AS city_name
									  FROM tbl_sprf 
									  LEFT JOIN tbl_complaints ON tbl_sprf.fk_complaint_id = tbl_complaints.pk_complaint_id
									  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									  LEFT JOIN tbl_instruments ON tbl_instruments.pk_instrument_id = tbl_complaints.fk_instrument_id
									  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
									  WHERE tbl_sprf.`dc_number` != '0' group by `dc_number`");
									  $dbresResult	= $dbres->result_array();
									  if (sizeof($dbresResult) == "0") 
									  {
										//do somthing  
									  } else {
										  foreach ($dbresResult as $customers_list) {
											 
											  ?>
											  <tr class=" odd gradeX">
												  <td>
													  <?php 
													  	echo $customers_list["dc_number"];
													  ?>
												  </td>
												  <td>
													   <?php 
													  	echo date('d-M-Y', strtotime($customers_list["approval_date"]));
													  ?>
												  </td>
                                                  <td>
													<?php /*
                                                    $complaint_qu=$this->db->query("select * from tbl_complaints where pk_complaint_id='".$customers_list["fk_complaint_id"]."'");
                                                    $complaint=$complaint_qu->result_array();
													if (sizeof($complaint)>0)
													if ($customers_list["ts_number"]!="")
                                                    echo $customers_list["ts_number"];
													else echo "No complaint record available";
													*/
													echo $customers_list["ts_number"];
                                                    ?>
												  </td>
                                                  <td>
												  <?php 
												  /*
												  if (sizeof($complaint)>0) {
													 $instrument_qu=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint[0]["fk_instrument_id"]."'");
                                                     $instrument=$instrument_qu->result_array();
													 //
													 if (sizeof($instrument)>0) {
													 $product_qu=$this->db->query("select * from tbl_products where pk_product_id='".$instrument[0]["fk_product_id"]."'");
                                                     $product=$product_qu->result_array();
                                                    echo $product[0]["product_name"];
													 }
													else echo "No equipment record available";
												  } 
												  if ($customers_list["product_name"]!="") echo $customers_list["product_name"];
												  else echo "No complaint record available";
												  */
												  echo $customers_list["product_name"];
                                                     
												  ?>
												  </td>
												  <td>
												  <?php 
												 /* if (isset($instrument[0]["serial_no"]))
													 echo $instrument[0]["serial_no"]; 
												 else echo "No equipment record available"; */
												  echo $customers_list["serial_no"];
												  ?>
												  </td>
                                                  <td>
													<?php 
													$dc_qu=$this->db->query("select * from tbl_sprf where dc_number='".$customers_list["dc_number"]."'");
                                                    $dc=$dc_qu->result_array();
													$des_count = 0;
													foreach($dc as $my_dc)
													{
														$part_qu=$this->db->query("select * from tbl_parts where pk_part_id='".$my_dc["fk_part_id"]."'");
														$part=$part_qu->result_array();
														if($des_count>0)
														{
															echo '<br>----<br>';
														}
														echo urldecode($part[0]["description"]);
														
														$des_count++;
													}
                                                    
                                                    ?>

												  </td>
                                                  <td>
													  <?php 
													  $part_count = 0;
													  foreach($dc as $my_dc)
													  {
														   // As this is now viewed, so make it as viewed in DB with below query.
											  			  $upd_vie 	= $this->db->query("UPDATE tbl_sprf SET dc_viewed='1' WHERE `pk_sprf_id` = '".$my_dc['pk_sprf_id']."'");
														  // As this is now viewed, so make it as viewed in DB with above query.
														  $part_qu=$this->db->query("select * from tbl_parts where pk_part_id='".$my_dc["fk_part_id"]."'");
														  $part=$part_qu->result_array();
														  if($part_count>0)
														  {
															  echo '<br>----<br>';
														  }
														  echo $part[0]["part_number"];
														  
														  $part_count++;
													  }
													  
													  ?>
												  </td>
                                                  <td>
													  <?php 
													  $qty_count = 0;
													  foreach($dc as $my_dc)
													  {
														  if($qty_count>0)
														  {
															  echo '<br>----<br>';
														  }
														  echo $my_dc["quantity"];
														  
														  $qty_count++;
													  }
													  
													  ?>
												  </td>
                                                  <td>
                                                    <?php 
													/*
													if (sizeof($complaint)>0) {
                                                    $client_qu=$this->db->query("select * from tbl_clients where pk_client_id='".$complaint[0]["fk_customer_id"]."'
													");
                                                    $client=$client_qu->result_array();
                                                    echo $client[0]["client_name"];
													}
													else echo "No complaint record available"; */
													echo $customers_list['client_name'];
                                                    ?>
												  </td>
                                                  <td>
                                                    <?php 
													/*
													if (sizeof($complaint)>0) {
                                                    $city_qu=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint[0]["fk_city_id"]."'");
                                                    $city=$city_qu->result_array();
                                                    echo $city[0]["city_name"];
													}
													else echo "No complaint record available";
													*/
													echo $customers_list['city_name'];
                                                    ?>
												  </td>
                                                  <td>
                                                    <a href="<?php echo base_url();?>sys/dc_print/<?php echo $customers_list["dc_number"];?>" class="btn btn-default" >
                                                    	Print
                                                    </a>
												  </td>
                                                   
											  </tr>
											  <?php
										  }
									  }
                              ?>
                              </tbody>
                            </table>
                           </div>
                         </div>
                       </div>
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
	var table = $('#sample_220').dataTable({
	  'iDisplayLength': 1000,
	  'order': [[ 1, "desc" ]]
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
});

</script>