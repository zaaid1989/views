<?php $this->load->view('header.php');
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
                    <h3 class="page-title"> Stock List <small></small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            Home 
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            Stock List
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
                            <div class="caption"> <i class="icon-anchor"></i>Spare Parts </div>
                            <div class="tools"> 
                                <a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
                            
					  <div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
                           <table class="table table-striped table-bordered table-hover flip-content dataaTable" id="sample_z">
                              <thead class="bg-grey">
                                    <tr>
                                      <th> Vendor<br />Name				</th>
                                      <th> Product				</th>
                                      <th> Part # 				</th>
                                      <th> Description 		</th>
                                      <th> MSQ 	</th>
                                      <th> Stock<br />Total 	</th>
                                      <?php 
										$query = $this->db->query("select * from tbl_offices");
										$result = $query->result_array();
										foreach($result as $office)
										{
									  ?>
									  <th><?php echo $office['office_code']?></th>
									  <?php } ?>
									  
                                      <th> Unit<br />Price 				</th>
                                      <th> Picture<br />of Part 			</th>
                                      <th> Comments 				</th>
                                      <?php
									  if($this->session->userdata('userrole')=='Admin')
										{ ?>
                                      <th> Actions					</th>
                                      <?php }?>
                                    </tr>
                              </thead>
                              <tbody>
                                <?php
								if(isset($_GET['product']))
								{
									$product_id = $_GET['product'];
								}
								else
								{
									$product_id=0;
								}
								$parts_query="SELECT `pk_part_id`, `fk_instrument_id`, `fk_vendor_id`, `fk_product_id`, `part_name`, `part_number`, `order_status`, `description`, `stock_quantity`, `minimum_quantity`, `unit_price`, `comments`, `image`, vendor_name, product_name FROM `tbl_parts` 
								INNER JOIN tbl_vendors ON tbl_parts.fk_vendor_id = tbl_vendors.pk_vendor_id 
								INNER JOIN tbl_products ON tbl_parts.fk_product_id = tbl_products.pk_product_id ";
								
								
								/*
								This is code for searching, this will change the query.
								if(isset($_GET['product']) && $_GET['product']=='ALL') 
								{
									
								}
								else
								{
									$parts_query.=" where tbl_products.pk_product_id='".$product_id."'";
								}*/
								$ty22=$this->db->query($parts_query);
								$rt22=$ty22->result_array();
								if (sizeof($rt22) == "0") 
								{
									//
								} 
								else 
								{
								  foreach ($rt22 as $get_users_list) 
								  {
									  // for finding total stock
										$stock_total=0;
										$stock = $this->db->query("select * from tbl_stock where  fk_part_id='".$get_users_list['pk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))");
										  if($stock->num_rows()>0)
										  {
											  $stock_result = $stock->result_array();
											  foreach($stock_result as $total_stock)
											  {
												  $stock_total= $stock_total + $total_stock['stock'];
											  }
										  }
										  if($stock_total<=0) continue;
                                                  
                                          
									?>
									<tr class="odd gradeX">
										
										<td>
										  <?php 
                                          	echo $get_users_list["vendor_name"];
                                          ?>
										</td>
										<td >
										  <?php 
                                          	echo $get_users_list["product_name"];
                                          ?>
										</td>
                                        <td>
										  <?php 
                                          	echo $get_users_list["part_number"];
                                          ?>
										</td>
                                        <td>
										  <?php 
                                          	echo urldecode($get_users_list["description"]);
                                          ?>
										</td>
                                        <td class="font-red" align="center">
										  <?php 
                                          	echo dispzero($get_users_list["minimum_quantity"]);
                                          ?>
										</td>
                                        <td style="font-weight:bold;" align="center"> <!-- Stock -->
										  <?php // for finding total stock
                                          	$stock = $this->db->query("select * from tbl_stock where  fk_part_id='".$get_users_list['pk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))");
                                                  if($stock->num_rows()>0)
                                                  {
                                                      $stock_result = $stock->result_array();
													  $stock_total=0;
													  foreach($stock_result as $total_stock)
													  {
														  $stock_total= $stock_total + $total_stock['stock'];
													  }
                                                      echo dispzero($stock_total);
                                                  }
                                                  else
                                                  {
                                                      echo '-';
                                                  }
                                          ?>
										</td>
                                            <?php 
                                              //The data for blow table will be fetched form tbl_stock according to the part selected from the second drop-down in above form
                                              $query = $this->db->query("select * from tbl_offices");
                                              $result = $query->result_array();
                                              foreach($result as $office)
                                              {
                                                echo '<td align="center">';
                                                  $stock = $this->db->query("select SUM(stock) AS stock from tbl_stock where fk_office_id = '".$office['pk_office_id']."' 
												  							 AND fk_part_id='".$get_users_list['pk_part_id']."'");
                                                  $stock_result = $stock->result_array();
												  if ($stock_result[0]['stock']!=0)
													echo dispzero($stock_result[0]['stock']);
												  else
													  echo '-';
                                              echo '</td>';
                                             }  ?>
										
										
                                        <td>
										  <?php 
                                          	echo $get_users_list["unit_price"];
                                          ?>
										</td>
                                        <td>
                                        <?php 
          
											  if($get_users_list["image"]=='')
											  {
												  //$src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
												  echo "No image available";
											  }
											  else
											  {
												  $src = base_url().'usersimages/parts_images/'. $get_users_list["pk_part_id"].'/'.$get_users_list["image"];
												  ?>
												  
												<!-- Code for showing button
												  <a href="<?php echo $src ;?>" class="icon-btn bg-grey" target="_blank" >
                                                  <i class="fa fa-picture-o"></i>
                                                  <div>View Image</div>
												</a>
												-->
												<!-- Code for showing thumbnail -->
												<a href="<?php echo $src ;?>" target="_blank"><img src="<?php echo $src ;?>" class="img-responsive" width="5px" height="auto" /></a>
												  <!--  -->
										<?php 
											  }
										?>
                                            
										</td>
                                        <td>
										  <?php 
                                          	echo urldecode($get_users_list["comments"]);
                                          ?>
										</td>
										<?php
                                        if($this->session->userdata('userrole')== 'Admin')
										{  ?>
										<td>
										<div class="btn-group-vertical btn-group-solid">
											<a class="btn btn-sm default green-jungle"  
											href="<?php echo base_url();?>sys/spare_part_stock_entry/<?php echo $get_users_list["pk_part_id"];?>">
											  Stock Entry <i class="fa fa-cog"></i>
											</a>
										<!--	
											<a class="btn btn-sm default blue"  
											href="<?php echo base_url();?>sys/update_part/<?php echo $get_users_list["pk_part_id"];?>">
											  Update <i class="fa fa-edit"></i>
											</a>
										
											
											<a class="btn btn-sm default blue"  
											  href="<?php echo base_url();?>sys/order_booked/<?php echo $get_users_list["pk_part_id"];?>"
											  onClick="return confirm('Are you sure you want to update status to Order Booked?')">
												Mark Booked <i class="fa fa-bookmark"></i>
											  </a>
										-->  
											  <a class="btn btn-sm default purple"  
											  href="<?php echo base_url();?>sys/ledger?part=<?php echo $get_users_list["pk_part_id"];?>">
											  
												Ledger 
											  </a>
										</div>
										</td>
									   <?php  }?>
									</tr>
									<?php
								}
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
			  'iDisplayLength': 200
			});
			
			//new $.fn.dataTable.FixedColumns( table );
		});
		</script>