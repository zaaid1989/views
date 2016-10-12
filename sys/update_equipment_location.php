<?php $this->load->view('header');
$equipment_id = '0';
if (isset($_GET['equipment']))
	$equipment_id = $_GET['equipment'];
?>
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
        Equipment <small>Update Location</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    Home 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Equipment
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Update Equipment Location
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
		<?php
			if(isset($_GET['msg_success']))
			  { 
			  echo '<div class="alert alert-success alert-dismissable">  
					  <a class="close" data-dismiss="alert">×</a>  
					  Equipment Location Log Updated Successfully.  
					</div>';
			  }
		  ?>
        <div class="row">
        <div class="col-md-12"> 
		
				<!-- Search Form -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Equipment </span>
								<span class="caption-helper">Select Equipment to change Location</span>
								<span class="caption-helper bg-grey-cascade">Displaying previous location in the drop-down at the moment</span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>sys/update_equipment_location">
								<div class="col-md-4">
                            		<div class="form-group ">
                                        <select name="product" id="product" onchange="selectequipment(this.value)" class="form-control" required>
                                            <option value="">--Select Product--</option>
											<?php 
											//$maxqu = $this->db->query("SELECT * FROM tbl_products where fk_type_id!='2' AND status!=1");
											$maxqu = $this->db->query("SELECT * FROM tbl_products where status!=1 ORDER BY fk_category_id");
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
                                <div class="col-md-4">
                            		<div class="form-group equipment_div">
                                        <select name="equipment" id="equipment" class="form-control" required>
                                            <option value="">--Select Equipment--</option>
											<?php 
											$maxqu = $this->db->query("SELECT tbl_instruments.* ,tbl_products.product_name,tbl_clients.client_name,tbl_cities.city_name,tbl_offices.office_name 
											FROM tbl_instruments 
											LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
											LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
											LEFT JOIN tbl_offices ON tbl_instruments.fk_client_id = tbl_offices.client_option
											LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
											ORDER BY   `product_name`,`pk_instrument_id` ");
										
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                if(isset($_GET['equipment'])) {
                                                ?>
                                                <option value="<?php echo $val['pk_instrument_id'];//pk_product_id?>" <?php if(isset($_GET['equipment']) && $_GET['equipment']==$val['pk_instrument_id']){ echo 'selected="selected"';}//pk_instrument_id?>>
													<?php if ($val['client_name']!="")
															echo $val['serial_no'].' - '.$val['client_name'].' ('.$val['city_name'].')';
														else 
															echo $val['serial_no'].' - '.$val['office_name'];
													?>
                                                </option>
                                                <?php 
												}
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>

                                <div class="col-md-2">
                            		<div class="form-group">
                                            <input type="submit"  class="btn btn-default purple-seance" value="Search" >
                                    </div>
                                </div>
                          		</form>
                           </div>	
							
						</div>
					</div>
		<!-- Search Form -->
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
<?php if($equipment_id != '0') { ?>
          <div class="portlet box purple-seance">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Update Equipment Location</div>
              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/update_equipment_location_insert">
        	<?php
				  $ty22=$this->db->query("
				  
					SELECT 
					tbl_instruments.*, 
					COALESCE(tbl_products.product_name) AS product_name,
					COALESCE(tbl_vendors.vendor_name) AS vendor_name,
					COALESCE(tbl_cities.city_name) AS city_name,
					COALESCE(tbl_clients.client_name) AS client_name,
					COALESCE(tbl_category.category_name) AS category_name,
					COALESCE(tbl_offices.office_name) AS office_name 
					
					FROM tbl_instruments 
					
					LEFT JOIN tbl_category ON tbl_instruments.fk_category_id = tbl_category.pk_category_id
					LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
					LEFT JOIN tbl_vendors ON tbl_instruments.fk_vendor_id = tbl_vendors.pk_vendor_id
					LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
					LEFT JOIN tbl_offices ON tbl_instruments.fk_office_id = tbl_offices.pk_office_id
					LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
													
				  where pk_instrument_id='".$equipment_id."'");
				  $rt22=$ty22->result_array();
			?>
            <div class="form-body">

                <div class="row">
                <div class="col-md-12"> 
                 		
                        <div class="form-group">
                            <label class="col-md-3 control-label">Category</label>
                            <div class="col-md-8">
							<!--
                              <select class="form-control" name="category" id="category"  onchange="select_vendor(this.value)" style="display:none;" required>
                                <option value="">--Choose--</option>
                                <?php
								/*
                                  $qu="SELECT * from tbl_category ";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    {
                                        ?>
                                        <option value="<?php echo $value['pk_category_id'];?>"
                                        <?php if($value['pk_category_id']==$rt22[0]['fk_category_id']){ $categoryy=$value['category_name']; ?> selected="selected"<?php }?>>
											<?php echo $value['category_name'];?>					  
                                        </option>
                                        <?php
                                    } */ ?>
                              </select>
							  -->
							  <input type="text"     class="form-control" readonly value="<?php echo $rt22[0]['category_name'];?>" >	
                            </div>
                        </div>
                        
                       	<div class="form-group">
                            <label class="col-md-3 control-label">Vendor</label>
                            <div class="col-md-8 category_vendors">
							<!--
                              <select class="form-control  " name="vendor" id="vendor" style="display:none;"  required>
                                <option value="<?php echo $rt22[0]['fk_vendor_id'];?>">
								<?php 
								// $qu6="SELECT * from tbl_vendors where pk_vendor_id='".$rt22[0]['fk_vendor_id']."'";
                                // $gh6=$this->db->query($qu6);
                                // $rt6=$gh6->result_array();
								// echo $rt6[0]['vendor_name'];?></option>
                              </select>
							  -->
							  <input type="text" class="form-control" readonly value="<?php echo $rt22[0]['vendor_name'];?>" >	
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product </label>
                            <div class="col-md-8 ">
							<!--
                              <select class="form-control  " name="equipment" id="equipment" style="display:none;" required>
                                <option value="<?php echo $rt22[0]['fk_product_id'];?>">
								<?php 
								
								$category_check = 0;
								if ($rt22[0]['product_name']!="")		$category_check = $rt22[0]['fk_category_id'];
								// $qu6="SELECT * from tbl_products where pk_product_id='".$rt22[0]['fk_product_id']."'";
                                // $gh6=$this->db->query($qu6);
                                // $rt6=$gh6->result_array();
								// if($gh6->num_rows()>0)
								// {
								// echo $rt6[0]['product_name'];
								// $category_check = $rt6[0]['fk_category_id'];
								// }
								?></option>
                              </select>
							  -->
							  <input type="text" class="form-control" readonly value="<?php echo $rt22[0]['product_name'];?>" >	
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label">Serial Number</label>
                            <div class="col-md-8">
                                <input type="text"   name="serial_no"  class="form-control serial_no" id="serial_no" readonly
                                value="<?php echo $rt22[0]['serial_no'];?>" required>	        
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label class="col-md-3 control-label">New Location</label>
                            <div class="col-md-8">
                              <select class="form-control  " name="cutomer" id="cutomer" <?php if ($category_check == 1) echo 'onchange="show_main(this.value)"'; // for showing parent of aux equipment ?> required>
                                <option value="">--Choose--</option>
                                <option value="officeoption_1" <?php if($rt22[0]['fk_client_id']=='officeoption_1'){ ?> selected="selected"<?php }?>>Rawalpindi Office (HO)</option>
                                <option value="officeoption_2" <?php if($rt22[0]['fk_client_id']=='officeoption_2'){ ?> selected="selected"<?php }?>>Lahore Office (LO)</option>
                                <option value="officeoption_3" <?php if($rt22[0]['fk_client_id']=='officeoption_3'){ ?> selected="selected"<?php }?>>Karachi Office (KO)</option>
                                <option value="officeoption_4" <?php if($rt22[0]['fk_client_id']=='officeoption_4'){ ?> selected="selected"<?php }?>>Multan Office (MO)</option>
                                <option value="officeoption_5" <?php if($rt22[0]['fk_client_id']=='officeoption_5'){ ?> selected="selected"<?php }?>>Peshawar (PO)</option>
                                <?php
                                  $qu="SELECT tbl_clients.*,tbl_cities.city_name,tbl_area.area from tbl_clients
								  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
								  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
								  WHERE tbl_clients.delete_status=0 ";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    {
                                        ?>
                                        <option value="<?php echo $value['pk_client_id'];?>"
                                        <?php if($value['pk_client_id']==$rt22[0]['fk_client_id']){ ?> selected="selected"<?php }?>>
											<?php echo $value['client_name'];
													
													echo '--('.$value['city_name'].')';
													
													echo '--('.$value['area'].')';
											?>					  
                                        </option>
                                        <?php
                                    }?>
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Territory</label>
                            <div class="col-md-8">
                              <select class="form-control" name="office" id="office" required>
                                <option value="">--Choose--</option>
                                <?php
                                  $qu="SELECT * from tbl_offices ";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    {
                                        ?>
                                        <option value="<?php echo $value['pk_office_id'];?>"
                                        <?php if($value['pk_office_id']==$rt22[0]['fk_office_id']){ ?> selected="selected"<?php }?>>
											<?php echo $value['office_name'];?>					  
                                        </option>
                                        <?php
                                    }?>
                              </select>
							  	
                            </div>
							<div class="col-md-1" style="margin-top: 6px;">
												<i class="fa fa-info-circle " title="Not selected automatically because Equipment is independent of Office"></i>
												
									</div>	
                        </div>
						
					<?php if ($category_check == 1) { ?>	
						<div class="form-group">
                            <label class="col-md-3 control-label">Main Equipment</label>
                            <div class="col-md-8 sent_to_bridge type_products equipments">
                                <select class="form-control "  name="main_equipment[]" required multiple="multiple"> 
                                  <?php $rrr	=	"SELECT tbl_instruments.pk_instrument_id ,tbl_instruments.serial_no ,tbl_instruments.main_equipment,tbl_products.product_name
										FROM tbl_instruments
										JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
										WHERE tbl_instruments.fk_category_id!=1 AND tbl_products.status=0 AND tbl_instruments.fk_client_id='".$rt22[0]['fk_client_id']."'
										ORDER BY   `product_name`,`serial_no`";
										//echo $rrr;exit;
										$nn=$this->db->query($rrr);
										$nnm=$nn->result_array();
										foreach($nnm as $drt)
										{
											echo '<option value="';
											echo $drt["pk_instrument_id"];
											echo '"';
											$main_equipment_list= explode(",",$rt22[0]['main_equipment']);
                                      		if (in_array($drt["pk_instrument_id"], $main_equipment_list)) {
												echo ' selected ';
											}
											echo '">';
											echo $drt["product_name"].' - '.$drt["serial_no"];
											echo '</option>';
										}
								  ?>
                                </select>
                            </div>
                        </div>
					<?php } ?>
                        
					<div class="form-group">
                            <label class="col-md-3 control-label">Date</label>
                            <div class="col-md-8">
                                <input type="text"   name="update_date"  class="form-control datepicker" id="update_date"  
                                value="<?php echo date('d-M-Y');?>" required>	        
                            </div>
                    </div>
						
					<!--	
                        <div class="form-group">

                            <label class="col-md-3 control-label">Invoice Number</label>

                            <div class="col-md-8">

                                <input type="text"   name="invoice_number"  class="form-control" id="invoice_number" 
                                value="<?php echo $rt22[0]['invoice_number'];?>"  required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Invoice Date</label>

                            <div class="col-md-8">

                                <input type="text"   name="invoice_date"  class="form-control datepicker" id="invoice_date"  
                                value="<?php echo date('d-M-Y', strtotime($rt22[0]['invoice_date']));?>" required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Equipment Price</label>

                            <div class="col-md-8">

                                <input type="text"   name="equipment_price"  class="form-control" id="equipment_price" 
                                value="<?php echo $rt22[0]['equipment_price'];?>" required>	        
                            </div>

                        </div>
						
                        <div class="form-group">
                            <label class="col-md-3 control-label">Warranty Start Date</label>
                            <div class="col-md-8">
                                <input type="text"   name="warranty_start_date"  class="form-control datepicker" 
                                value="<?php echo date('d-M-Y', strtotime($rt22[0]['warranty_start_date']));?>" id="warranty_start_date" required>	        
                            </div>
                        </div>
					-->
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label"> Comments </label>
                            <div class="col-md-8">
                                <textarea name="description" class="input-xlarge" id="textarea" rows="5" required></textarea>
                            </div>
                        </div>
					<!--	
						<div class="form-group">
                            <label class="col-md-3 control-label"> Description </label>
                            <div class="col-md-8">
                                <textarea class="input-xlarge"  rows="5" readonly><?php echo $rt22[0]['details'];?></textarea>
                            </div>
                        </div>
					-->
						
                        <div class="form-group">
                            <label class="col-md-3 control-label">Status </label>
                            <div class="col-md-8">
                              <select class="form-control" name="status" id="status" required>
                                <option value="">--Choose--</option>
                                <option value="1" <?php if($rt22[0]['status']=='1'){ ?> selected="selected" <?php } ?> >Active</option>
                                <option value="2" <?php if($rt22[0]['status']=='2'){ ?> selected="selected" <?php } ?> >Inactive</option>
                                <option value="3" <?php if($rt22[0]['status']=='3'){ ?> selected="selected" <?php } ?> >Expired</option>
                              </select>
                            </div>
                        </div>
                    </div>
                  </div>
			  <script type="text/javascript">
			  
			  function show_main(customer_id)
				{
					var formdata =
					  {
						customer_id: customer_id
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/main_based_on_customer_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$(".equipments").html(msg);
						$('select').select2();
						}
					})
					return false;
				}
			
				function select_vendor(category)
				{
					var formdata =
					  {
						category: category
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/vendor_based_on_product_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$(".category_vendors").html(msg);
						}
					})
					return false;
				}

				function show_equipment(vendor_id)
				{
					var formdata =
					  {
						vendor_id: vendor_id
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/equipment_based_on_vendor_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$(".equipments").html(msg);
						}
					})
					return false;
				}
			</script>
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-5 col-md-9">
                  <input type="hidden" name="pk_instrument_id" value="<?php echo $equipment_id; ?>">
                  <button type="submit" class="btn btn-circle blue">Submit</button>
               <!--   <button type="button" class="btn btn-circle default">Cancel</button> -->
                </div>
              </div>
            </div>
           </div>
           </form>
           </div>
          </div>
		<?php } ?>    
		</div>
      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<script>
function selectequipment(i) {
var formdata = {
	  product_id: i,
	  sec_var: 'second'
	};
$.ajax({
  url: "<?php echo base_url();?>sys/equipment_list_ajax",
  type: 'POST',
  data: formdata,
  success: function(msg){
	  $(".equipment_div").html(msg);
	  $('select').select2();
	  }
  })
  //return false;
}
</script>
<?php $this->load->view('footer');?>