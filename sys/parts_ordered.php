<?php $this->load->view('header.php');
function zerodisp($val) {
	if ($val==0) return '-';
	else return 'Yes';
}
function dispzero($val) {
	if ($val=="" || $val==0) return '-';
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
                    <h3 class="page-title"> Parts Ordered <small></small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            Home 
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            Parts Ordered
                        </li> 
                      </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
					  <?php
						  if(isset($_GET['delete']) && $_GET['delete']=='success') { 
							  echo '<div class="alert alert-success alert-dismissable">  
									  <a class="close" data-dismiss="alert">×</a>  
									  Order Deleted Successfully.  
									</div>';
							}
							
							if(isset($_GET['msg']) && $_GET['msg']=='success_update') { 
							  echo '<div class="alert alert-success alert-dismissable">  
									  <a class="close" data-dismiss="alert">×</a>  
									  Order Updated Successfully.  
									</div>';
							}
						  ?>
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bg-inverse">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-anchor"></i>Order Details </div>
                            <div class="tools"> 
                                <a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
						  
						  <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>sys/add_order" class="btn green"> Add Order <i class="fa fa-plus"></i> </a>
                                  </div>
                                </div>
							</div>
                      
					  <div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
					  <table class="table table-hover hover flip-content  dataaTable" id="">
                      <thead class="bg-blue">
						<tr>
						  <th> 	</th>
						  <th> 	</th>
						  <th>  	</th>
                          <th>    		</th>
                          <th> 		</th>
                          <th> 		</th>
                          <th>    			</th>
						  <th> 	</th>
						  <th>  </th>
						  <th>  </th>
						  <th>  </th>
						  <th>   		</th>
						  <th> 		</th>
						  <th> </th> 
                        </tr>
                        <tr>
						  <th> Order Date	</th>
						  <th> Order Reference	</th>
						  <th> Vendor Name   	</th>
                          <th> Product   		</th>
                          <th> Part Number		</th>
                          <th> Description		</th>
                          <th> MSQ   			</th>
						  <th> Balance	</th>
						  <th> Requisition - MSQ </th>
						  <th> Requisition - SPRF </th>
						  <th> Quantity Ordered </th>
						  <th> Comments  		</th>
						  <th> Unit Price  		</th>
						  <th> Actions	</th> 
                        </tr>
                      </thead>
                      <tbody>
                        <?php
						$query = $this->db->query("SELECT tbl_orders.pk_order_id,tbl_orders.fk_part_id,tbl_orders.order_number,tbl_orders.order_quantity,tbl_orders.date AS order_date,tbl_orders.comments AS order_comments,tbl_parts.*,tbl_vendors.vendor_name,tbl_products.product_name
						FROM tbl_orders
						LEFT JOIN tbl_parts ON tbl_parts.pk_part_id = tbl_orders.fk_part_id 
						LEFT JOIN tbl_vendors ON tbl_parts.fk_vendor_id = tbl_vendors.pk_vendor_id 
						LEFT JOIN tbl_products ON tbl_parts.fk_product_id = tbl_products.pk_product_id
						WHERE tbl_orders.status=1
						");
						$result = $query->result_array();
						foreach ($result AS $order) {
							/////////////////////////////////////////////////////////////////////////// Requisitions BEGIN
										$stock_total=0;
										$stock_demand=0;
										$stock_demand_aggregate=0;
										$stock = $this->db->query("select * from tbl_stock where  fk_part_id='".$order['fk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))");
										  if($stock->num_rows()>0)
										  {
											  $stock_result = $stock->result_array();
											  foreach($stock_result as $total_stock)
											  {
												  $stock_total= $stock_total + $total_stock['stock'];
											  }
										  }
										  
										  
										  $qd = $this->db->query("SELECT fk_part_id, SUM(quantity) AS demand FROM `tbl_sprf` WHERE status=0 AND fk_part_id = '".$order['fk_part_id']."' GROUP BY fk_part_id");
										  // Adding below on 14th march 2016 As in orders.php to collect the SPRF only of 'Pending SPRF' Complaints 
										  $qd = $this->db->query("SELECT fk_part_id, SUM(quantity) AS demand FROM `tbl_sprf` 
										  LEFT JOIN tbl_complaints ON `tbl_sprf`.fk_complaint_id = `tbl_complaints`.pk_complaint_id
										  WHERE `tbl_complaints`.status='Pending SPRF' AND `tbl_sprf`.status=0 AND `tbl_sprf`.fk_part_id = '".$order['fk_part_id']."' GROUP BY fk_part_id");
                                          $rd = $qd->result_array();
										  if (sizeof($rd)>0)
												$stock_demand = $rd[0]['demand'];
										  if ($stock_demand>0) 
												$stock_demand_aggregate=$stock_demand - $stock_total;
											
											///////////////// I have added the if condition below after their was an error when stock demand aggregate shoould have been 3 but system was showing it to be 4. The reason was that due to SPRF demands the stock was already in negative quantity and when above condition implemented the negative quantity is added into the aggregate wheras there is no need of it. The reason is when the stock total is negative, it means the demand has already been added by system for the respective part.
											if ($stock_total<0) 
												$stock_demand_aggregate+=$stock_total;
										  
										//  if($stock_total>=$order['minimum_quantity'] && $stock_demand_aggregate<=0) continue;
										  
										  
										  $demand_detail = "";
										  $qd = $this->db->query("SELECT `tbl_sprf`.fk_complaint_id,`tbl_sprf`.quantity, `tbl_clients`.client_name,`tbl_complaints`.ts_number
											FROM `tbl_sprf` 
											LEFT JOIN tbl_complaints ON `tbl_sprf`.fk_complaint_id = `tbl_complaints`.pk_complaint_id
											LEFT JOIN tbl_clients ON `tbl_clients`.pk_client_id = `tbl_complaints`.fk_customer_id
											WHERE `tbl_sprf`.status=0 AND `tbl_complaints`.status='Pending SPRF' AND `tbl_sprf`.fk_part_id = '".$order['fk_part_id']."'");
                                          $rd = $qd->result_array();
										  if (sizeof($rd)>0)
												foreach ($rd AS $dd) {
													$demand_detail .= $dd['quantity'].' ('.$dd['client_name'].' - '.$dd['ts_number'].'), ';
												}
										$order_quantity = "";		
										$qd = $this->db->query("SELECT * from tbl_orders
											WHERE status=1 AND fk_part_id = '".$order['fk_part_id']."' ORDER BY date ASC");
                                          $rd = $qd->result_array();
										  if (sizeof($rd)>0)
												foreach ($rd AS $dd) {
													$order_quantity .= '<span title="'.$dd['order_number'].' - '.date('d-M-Y',strtotime($dd['date'])).'">'.$dd['order_quantity'].'</span> + ';
												}
							//////////////////////////////////////////////////////////////////////////// Requisitions END
							echo '<tr>';
							echo '<td>'.date('d-M-Y',strtotime($order['order_date'])).'</td>';
							echo '<td>'.$order['order_number'].'</td>';
							echo '<td>'.$order['vendor_name'].'</td>';
							echo '<td>'.$order['product_name'].'</td>';
							echo '<td>'.$order['part_number'].'</td>';
							echo '<td>'.urldecode($order['description']).'</td>';
							echo '<td class="font-red" align="center">'.dispzero($order['minimum_quantity']).'</td>';
							///////////////// TOTAL STOCK /////////////////////
							$stock_total=0;
							$stock = $this->db->query("select * from tbl_stock where  fk_part_id='".$order['pk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))");
							  if($stock->num_rows()>0) {
								  $stock_result = $stock->result_array();
								  foreach($stock_result as $total_stock) {
									  $stock_total= $stock_total + $total_stock['stock'];
								  }
							  }
							///////////////// TOTAL STOCK END /////////////////////			 
							echo '<td style="font-weight:bold;" align="center">'.dispzero($stock_total).'</td>';
							?>
							<td align="center"> <!-- Requisition MSQ -->
								<?php 
									echo dispzero($order["minimum_quantity"]-$stock_total);
								?>
							</td>
										
							<td align="center"> <!-- Requisition SPRF -->
							<?php if ($stock_demand_aggregate>0) echo '<span title="'.$demand_detail.'">'.$stock_demand_aggregate.'</span>'; 
							else echo '-';
							?>
							</td>
							<?php
							echo '<td align="center">'.$order['order_quantity'].'</td>'; // Quantity Ordered
							echo '<td>'.urldecode($order['order_comments']).'</td>';
							echo '<td>'.urldecode($order['unit_price']).'</td>';
							//echo '<td>'.zerodisp($submenu['Salesman']).'</td>';
							echo '<td>';
							?>
							<div class="btn-group-vertical btn-group-solid">
							<a class="btn btn-sm default green-jungle"  
											href="<?php echo base_url();?>sys/spare_part_stock_entry/<?php echo $order["fk_part_id"];?>">
											  Stock Entry <i class="fa fa-cog"></i>
							</a>
							<a class="btn btn-sm default blue"   
											href="<?php echo base_url();?>sys/update_order/<?php echo $order["pk_order_id"];?>">
											  Update Order <i class="fa fa-edit"></i>
											</a>
							<a class="btn btn-sm default purple-seance" 
											href="<?php echo base_url();?>sys/ledger?part=<?php echo $order["fk_part_id"];?>">
											  Ledger 
											</a>
							  <a class="btn btn-sm red-thunderbird"  
							  href="<?php echo base_url();?>sys/delete_order/<?php echo $order["pk_order_id"]; ?>"
							  onClick="return confirm('Are you sure you want to delete?')">
							 Delete	<i class="fa fa-trash-o"></i>
							  </a>
							  </div>
							<?php
							echo '</td>';
							echo '</tr>';
						}
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
			var table = $('.dataaTable').dataTable({
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
								{ type: "text" }
						]

		});
	});
		</script>