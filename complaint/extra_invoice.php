<?php $this->load->view('header');?>
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Invoice <small>invoice sample</small>
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
							 #<?php 
									echo $customers_list[0]["dc_number"];
								  ?>	 / <?php echo date('d M Y');?> <span class="muted">
							TS # : <?php 
									$complaint_qu=$this->db->query("select * from tbl_complaints where pk_complaint_id='".$customers_list[0]["fk_complaint_id"]."'");
									$complaint=$complaint_qu->result_array();
									echo $complaint[0]["ts_number"];
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
								$client_qu=$this->db->query("select * from tbl_clients where pk_client_id='".$complaint[0]["fk_customer_id"]."'");
								$client=$client_qu->result_array();
								echo $client[0]["client_name"];
								?>
							</li>
						</ul>
					</div>
                    
                    
					<div class="col-xs-4">
                        <h3>Equipment:</h3>
						<ul class="list-unstyled">
							<li>
								 <?php 
									 $instrument_qu=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint[0]["fk_instrument_id"]."'");
									 $instrument=$instrument_qu->result_array();
									 //
									 $product_qu=$this->db->query("select * from tbl_products where pk_product_id='".$instrument[0]["fk_product_id"]."'");
									 $product=$product_qu->result_array();
									 echo $product[0]["product_name"];
								  ?>
							</li>
						</ul>
                        <h3>City:</h3>
						<ul class="list-unstyled">
							<li>
								 <?php 
									 
								$city_qu=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint[0]["fk_city_id"]."'");
								$city=$city_qu->result_array();
								echo $city[0]["city_name"];
								
								  ?>
							</li>
						</ul>
					</div>
					
					
                    
                    <div class="col-xs-4">
						<h3>S/No:</h3>
						<ul class="list-unstyled">
							<li>
								 <?php 
									 echo $instrument[0]["serial_no"]; 
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
								 Quantity
							</th>
						</tr>
						</thead>
						<tbody>
                        <?php 
							  $dc_qu=$this->db->query("select * from tbl_sprf where dc_number='".$customers_list[0]["dc_number"]."'");
							  $dc=$dc_qu->result_array();
							  $des_count = 1;
							  foreach($dc as $my_dc)
							  {?>
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
										   $part_qu=$this->db->query("select * from tbl_parts where pk_part_id='".$my_dc["fk_part_id"]."'");
											$part=$part_qu->result_array();
											echo $part[0]["part_number"];
										  ?>
                                    </td>
                                    <td class="hidden-480">
                                         <?php echo $my_dc["quantity"]; ?>
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