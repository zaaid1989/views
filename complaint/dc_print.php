<?php $this->load->view('header');?>
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Direct Challan <small></small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						Home 
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						Invoice
					</li>
				</ul>
				<div class="page-toolbar">
					
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
            <?php
					//$dbres 		= $this->db->query("SELECT * FROM tbl_sprf where `dc_number` = '".$this->uri->segment(3)."'");
					$dbres 		= 	  $this->db->query("
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
									  WHERE tbl_sprf.`dc_number` = '".$this->uri->segment(3)."' ");
					$customers_list	= $dbres->result_array();
					
				?>
			<div class="invoice">
				<div class="row invoice-logo">
					<div class="col-xs-6 invoice-logo-space">
						<img src="<?php echo base_url();?>assets/global/img/PMA23.png" style="width:200px;" alt="logo" class="img-responsive custom-mobile-class" />
					</div>
					<div class="col-xs-6">
						<p>
							 #<?php 
									echo $customers_list[0]["dc_number"];
								  ?>	 / <?php echo date('d M Y');?> <span class="muted">
							TS # : <?php 
							/*
									$complaint_qu=$this->db->query("select * from tbl_complaints where pk_complaint_id='".$customers_list[0]["fk_complaint_id"]."'");
									$complaint=$complaint_qu->result_array();
									if (sizeof($complaint)>0)
									echo $complaint[0]["ts_number"];
								else echo "N/A"; */
								$customers_list[0]["ts_number"];
									?> </span>
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
                	<div class="col-xs-4">
                        <h3>DC Date</h3>
						<ul class="list-unstyled">
							<li>
								 <?php 
									echo date('d-M-Y', strtotime($customers_list[0]["approval_date"]));
								  ?>
							</li>
						</ul>
                        <h3>Cutomer:
								</h3>
						<ul class="list-unstyled">
							<li>
								 <?php 
								 /*
								 if (sizeof($complaint)>0) {
								$client_qu=$this->db->query("select * from tbl_clients where pk_client_id='".$complaint[0]["fk_customer_id"]."'");
								$client=$client_qu->result_array();
								echo $client[0]["client_name"];
								 }
								 else echo "N/A"; */
								 echo $customers_list[0]["client_name"];
								?>
							</li>
						</ul>
					</div>
                    
                    
					<div class="col-xs-4">
                        <h3>Equipment:</h3>
						<ul class="list-unstyled">
							<li>
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
									 else echo "N/A";
									 }
								else echo "N/A";
								*/
								echo $customers_list[0]["product_name"];
								  ?>
							</li>
						</ul>
                        <h3>City:</h3>
						<ul class="list-unstyled">
							<li>
								 <?php 
								 /*
								if (sizeof($complaint)>0) { 
								$city_qu=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint[0]["fk_city_id"]."'");
								$city=$city_qu->result_array();
								echo $city[0]["city_name"];
								}
								else echo "N/A"; */
								echo $customers_list[0]["city_name"];
								
								  ?>
							</li>
						</ul>
					</div>
					
					
                    
                    <div class="col-xs-4">
						<h3>S/No:</h3>
						<ul class="list-unstyled">
							<li>
								 <?php 
								 /*
								 if (isset($instrument[0]["serial_no"]))
									 echo $instrument[0]["serial_no"]; 
								 else echo "N/A";
								 */
								 echo $customers_list[0]["serial_no"];
								  ?>
							</li>
						</ul>
					</div>
				</div>
                
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
						<thead>
						<tr>
							<th>
								 #
							</th>
							<th>
								 Part Description
							</th>
							<th class="hidden-480">
								 Part #
							</th>
                            <th class="hidden-480">
								 Source
							</th>
							<th class="hidden-480">
								 Quantity
							</th>
                            <th class="hidden-480">
								 Unit Price
							</th>
                            <th class="hidden-480">
								 Total
							</th>
						</tr>
						</thead>
						<tbody>
                        <?php 
							  $dc_qu=$this->db->query("select * from tbl_sprf where dc_number='".$customers_list[0]["dc_number"]."'");
							  $dc=$dc_qu->result_array();
							  $des_count = 1;
							  foreach($dc as $my_dc)
							  {
								  ?>
                                <tr>
                                    <td>
                                         <?php echo $des_count;?>
                                    </td>
                                    <td>
                                         <?php  
										 $part_qu=$this->db->query("select * from tbl_parts where pk_part_id='".$my_dc["fk_part_id"]."'");
										  $part=$part_qu->result_array();
										  echo urldecode($part[0]["description"]);
										 ?>
                                    </td>
                                    <td class="hidden-480">
                                         <?php 
											echo $part[0]["part_number"];
										  ?>
                                    </td>
                                    <td class="hidden-480">
                                         <?php if($my_dc["part_source"]=='stock') 
										 		{ echo 'Stock'; } 
							  					elseif($my_dc["part_source"]=='old inventory') 
												{ echo 'old inventory'; }
												else 
												{
												$client_plus_instrument = explode('#',$my_dc["source_id"]);
											 	$client_qu=$this->db->query("select * from tbl_clients where pk_client_id='".$client_plus_instrument[0]."'");
												$client=$client_qu->result_array();
												if (sizeof($client)==0) {
													$client_qu=$this->db->query("SELECT office_name,fk_city_id FROM tbl_offices WHERE client_option='".$client_plus_instrument[0]."' ");
													$client=$client_qu->result_array();
													echo $client[0]["office_name"].' - ';
												}
												else 
													echo $client[0]["client_name"].' - ';
												// for client city
												$city_qu=$this->db->query("select * from tbl_cities where pk_city_id='".$client[0]["fk_city_id"]."'");
												$city=$city_qu->result_array();
												echo $city[0]["city_name"];
											  	} 
										 ?>
                                    </td>
                                    <td class="hidden-480">
                                         <?php echo $my_dc["quantity"]; ?>
                                    </td>
                                     <td class="hidden-480">
                                         <?php if( $part[0]["unit_price"]=='') { echo 'N/A';} else { echo $part[0]['unit_price']; } ?>
                                    </td>
                                     <td class="hidden-480">
                                         <?php echo $my_dc["quantity"]*$part[0]["unit_price"]; ?>
                                    </td>
                                </tr>
							  <?php 
							  $des_count++;
                              }
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