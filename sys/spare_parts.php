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

<style>/*
#sample_z { display:none }
*/
</style>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Spare Parts <small></small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            Home
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            Spare Parts
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
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']) && $_GET['msg']=='success')
									{ 
									  echo '<div class="alert alert-success alert-dismissable">  
											  <a class="close" data-dismiss="alert">×</a>  
											  Spare Part Registred Successfully.  
											</div>';
									}
									if(isset($_GET['msg']) && $_GET['msg']=='del')
									{ 
									  echo '<div class="alert alert-success alert-dismissable">  
											  <a class="close" data-dismiss="alert">×</a>  
											  Spare Part Deleted Successfully.  
											</div>';
									}
									if(isset($_GET['msg']) && $_GET['msg']=='upt')
									{ 
									  echo '<div class="alert alert-success alert-dismissable">  
											  <a class="close" data-dismiss="alert">×</a>  
											  Spare Part Updated Successfully.  
											</div>';
									}
									if(isset($_GET['msg']) && $_GET['msg']=='stock')
									{ 
									  echo '<div class="alert alert-success alert-dismissable">  
											  <a class="close" data-dismiss="alert">×</a>  
											  Stock Entry done Successfully.  
											</div>';
									}
									if($this->session->userdata('userrole')!='FSE' && $this->session->userdata('userrole')!='Supervisor')
									{
								  ?>
                                  
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="btn-group">
                                        <a href="<?php echo base_url();?>sys/spare_part_registration" id="sample_editable_1_new" class="btn blue"> 
                                            Add New Spare Part <i class="fa fa-plus"></i> 
                                        </a>
                                      </div>
                                    </div>
                                    
                                  </div>
                                  
                                  <?php 
									}
								  ?>
                              <div class="row">
                              	<div class="col-md-12"><p>&nbsp;</p></div>
                              </div>
                              <!-- This is Block for Searching with Product. -->
                              <div class="row">
                            	<form method="get" action="<?php echo base_url();?>sys/spare_parts">
                                <div class="col-md-4">
                            		<div class="form-group">
                            			
                                        <select name="product" id="product" class="form-control" required>
                                            <option value="">--Select Any Product--</option>
                                            <option value="ALL" 
											<?php if(isset($_GET['product']) && $_GET['product']=='ALL'){ echo 'selected="selected"';}?>>
                                            	--ALL--
                                            </option>
											<?php 
											$maxqu = $this->db->query("SELECT * FROM tbl_products where fk_type_id!='2' AND status!=1");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                
                                                <option value="<?php echo $val['pk_product_id'];?>" 
												<?php if(isset($_GET['product']) && $_GET['product']==$val['pk_product_id']){ echo 'selected="selected"';}?>>
													<?php echo $val['product_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>
								
                                <div class="col-md-2">
                            		<div class="form-group">
                                        
                                            <input type="submit"  class="btn btn-default blue-madison" value="Search" >
                                    </div>
                                </div>
                          		</form>
                           </div>
                      <!--     		-->
                            </div>
                      
					  <div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
                           <table class="table table-striped table-bordered table-hover flip-content dataaTable" id="sample_z">
                              <thead class="bg-grey">
                                    <tr>
                                      <th> Vendor<br />Name				</th>
                                      <th> Product				</th>
                                      <th> Part # 				</th>
                                      <th> Description 		</th>
                                      <th> MSQ 	</th>
                                      <th> Balance	</th>
                                      <?php 
										$query = $this->db->query("select * from tbl_offices");
										$result = $query->result_array();
										foreach($result as $office)
										{
									  ?>
									  <th><?php echo $office['office_code']?></th>
									  <?php }?>
                                      <th> Unit<br />Price 				</th>
                                      <th> Picture<br />of Part 			</th>
                                      <th> Comments 				</th>
                                      <?php
									  if($this->session->userdata('userrole')!='FSE' && $this->session->userdata('userrole')!='Supervisor')
										{?>
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
								$parts_query="SELECT `pk_part_id`, `fk_instrument_id`, `fk_vendor_id`, `fk_product_id`, `part_name`, `part_number`, `description`, `stock_quantity`, `minimum_quantity`, `unit_price`, `comments`, `image`, vendor_name, product_name FROM `tbl_parts` 
								INNER JOIN tbl_vendors ON tbl_parts.fk_vendor_id = tbl_vendors.pk_vendor_id 
								INNER JOIN tbl_products ON tbl_parts.fk_product_id = tbl_products.pk_product_id
								where tbl_parts.delete_status='0'";
								
								
								/* */
								//This is code for searching, this will change the query.
								if(isset($_GET['product']) && $_GET['product']=='ALL') 
								{
									
								}
								else
								{
									$parts_query.=" AND tbl_products.pk_product_id='".$product_id."'";
								} /* */
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
									?>
									<tr class="odd gradeX">
										
										<td>
										  <?php 
                                          	echo $get_users_list["vendor_name"];
                                          ?>
										</td>
										<td>
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
                                        <td style="font-weight:bold;" align="center">
										  <?php 
										  $stock_entries =0;
                                          	$stock = $this->db->query("select * from tbl_stock where  fk_part_id='".$get_users_list['pk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved') )");
                                                  if($stock->num_rows()>0)
                                                  {
													  $stock_entries =1;
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
												  							 AND fk_part_id='".$get_users_list['pk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))");
                                                  $stock_result = $stock->result_array();
												  if ($stock_result[0]['stock']!=0)
													echo dispzero($stock_result[0]['stock']);
												  else
													  echo '-';
                                              echo '</td>';
                                             }?>
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
												<a href="<?php echo $src ;?>" target="_blank"><img src="<?php echo $src ;?>" class="img-responsive" width="10" height="auto" /></a>
												  <!--  -->
										<?php 
											  }
										?>
                                           
                                                  
                                           <!--Model here-->
                                            
										</td>
                                        <td>
										  <?php 
                                          	echo urldecode($get_users_list["comments"]);
                                          ?>
										</td>
										<?php
                                        if($this->session->userdata('userrole')!='FSE' && $this->session->userdata('userrole')!='Supervisor')
										{?>
										<td>
										<div class="btn-group-vertical btn-group-solid">
											<a class="btn btn-sm default green-jungle"  
											href="<?php echo base_url();?>sys/spare_part_stock_entry/<?php echo $get_users_list["pk_part_id"];?>">
											  Stock Entry <i class="fa fa-cog"></i>
											</a>
											
											<a class="btn btn-sm default blue"  
											href="<?php echo base_url();?>sys/update_part/<?php echo $get_users_list["pk_part_id"];?>">
											  Update <i class="fa fa-edit"></i>
											</a>
										<?php if($stock_entries>0) { ?>	
											<a class="btn btn-sm default purple"  
											  href="<?php echo base_url();?>sys/ledger?part=<?php echo $get_users_list["pk_part_id"];?>">
											  
												Ledger 
											  </a>
										<?php }?>
										<?php if($stock_entries==0) { ?>	
											<a class="btn btn-sm default grey-cascade" href="#">
											  
												No Ledger 
											  </a>
										<?php }?>
										
										
											<a class="btn btn-sm default red-thunderbird"  
											  href="<?php echo base_url();?>sys/delete_part/<?php echo $get_users_list["pk_part_id"];?>"
											  onClick="return confirm('Are you sure you want to delete?')">
												Delete <i class="fa fa-trash-o"></i>
											  </a>
										
										</div>
										</td>
									   <?php }?>
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
$("img").one("load", function() {
  //$('#spinner').remove();
}).each(function() {
  if(this.complete) $(this).load();
});
		$(document).ready(function() { 
			var table = $('.dataaTable').dataTable({
			  'iDisplayLength': 800
			});
			
			//new $.fn.dataTable.FixedColumns( table );
		});
		</script>