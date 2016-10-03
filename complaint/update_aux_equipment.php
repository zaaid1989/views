<?php $this->load->view('header');?>
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
        AUX Equipment <small>Update</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    Home
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Auxiliary Equipment
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Update Auxiliary Equipment
                </li>
            </ul>
                      
        </div>
        <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">

        <div class="col-md-12"> 
       
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box purple">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Update AUX Equipment</div>

              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
                
                <a href="javascript:;" class="remove"> </a> 
              </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>complaint/update_aux_equipment_insert">
        	<?php
				  $ty22=$this->db->query("
				  SELECT 
					tbl_instruments.*, 
					COALESCE(tbl_products.product_name) AS product_name,
					COALESCE(tbl_vendors.vendor_name) AS vendor_name,
					COALESCE(tbl_cities.city_name) AS city_name,
					COALESCE(tbl_clients.client_name) AS client_name,
					COALESCE(tbl_category.category_name) AS category_name,
					COALESCE(tbl_offices.office_name) AS office_name,
					COALESCE(oc.office_name) AS office_client					
					
					FROM tbl_instruments 
					
					LEFT JOIN tbl_category ON tbl_instruments.fk_category_id = tbl_category.pk_category_id
					LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
					LEFT JOIN tbl_vendors ON tbl_instruments.fk_vendor_id = tbl_vendors.pk_vendor_id
					LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
					LEFT JOIN tbl_offices ON tbl_instruments.fk_office_id = tbl_offices.pk_office_id
					LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
					LEFT JOIN tbl_offices oc ON tbl_instruments.fk_client_id = oc.client_option
				  WHERE pk_instrument_id='".$this->uri->segment('3')."'");
				  $rt22=$ty22->result_array();
			?>
            <div class="form-body">

                <div class="row">
                <div class="col-md-12"> 
                 		<?php
                            if(isset($_GET['msg']))
                              { 
							  echo '<div class="alert alert-success alert-dismissable">  
									  <a class="close" data-dismiss="alert">×</a>  
									  Equipment Registered Successfully.  
									</div>';
                              }
                          ?>
                        <div class="form-group" style="display:none;">
                            <label class="col-md-3 control-label">Category</label>
                            <div class="col-md-8">
                              <select class="form-control" name="category" id="category"  onchange="select_vendor(this.value)" required>
                                <option value="">--Choose--</option>
                                <?php
                                  $qu="SELECT * from tbl_category ";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    {
                                        ?>
                                        <option value="<?php echo $value['pk_category_id'];?>"
                                        <?php if($value['pk_category_id']==$rt22[0]['fk_category_id']){ ?> selected="selected"<?php }?>>
											<?php echo $value['category_name'];?>					  
                                        </option>
                                        <?php
                                    }?>
                              </select>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label">Auxiliary Equipment </label>
                            <div class="col-md-8 equipmentss">
                              <select class="form-control  " onchange="select_vendor(this.value)" name="equipment" id="equipment" required>
                                <option value="<?php echo $rt22[0]['fk_product_id'];?>">
                               <?php 
								echo $rt22[0]['product_name'];
								?></option>
                                 
                              </select>
                            </div>
                        </div> 
                        
                       	<div class="form-group">
                            <label class="col-md-3 control-label">Vendor</label>
                            <div class="col-md-8 category_vendors">
                              <select class="form-control  " name="vendor" id="vendor"  required>
                                <option value="<?php echo $rt22[0]['fk_vendor_id'];?>">
								<?php echo $rt22[0]['vendor_name'];?>
								</option>
                              </select>
                            </div>
                        </div>
                        
                        
						
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
                                value="<?php if($rt22[0]['invoice_date']!='0000-00-00 00:00:00') echo date('d-M-Y', strtotime($rt22[0]['invoice_date']));?>" required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Price</label>

                            <div class="col-md-8">

                                <input type="text"   name="equipment_price"  class="form-control" id="equipment_price" 
                                value="<?php echo $rt22[0]['equipment_price'];?>" >	        
                            </div>

                        </div>
						
						<div class="form-group">

                            <label class="col-md-3 control-label">Auxiliary Equipment Serial Number</label>

                            <div class="col-md-8">

                                <input type="text"   name="serial_no"  class="form-control serial_no" id="serial_no" 
                                value="<?php echo $rt22[0]['serial_no'];?>" required>	        
                            </div>

                        </div>
						
                        <div class="form-group">

                            <label class="col-md-3 control-label">Warranty Start Date</label>

                            <div class="col-md-8">

                                <input type="text"   name="warranty_start_date"  class="form-control datepicker" 
                                value="<?php if($rt22[0]['warranty_start_date']!='0000-00-00 00:00:00') echo date('d-M-Y', strtotime($rt22[0]['warranty_start_date']));?>" id="warranty_start_date"  >	        
                            </div>

                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label">Warranty Period (Months)</label>
                            <div class="col-md-4">
							<input class="form-control col-md-2" type="number" name="warranty_months" id="warranty_months" value="<?php echo $rt22[0]['warranty_months'];?>" required>
                                <!--
								<select class="form-control" name="warranty_months" id="warranty_months" required>
                                <option value="-1">--Choose--</option>
                                <option value="0" <?php if($rt22[0]['warranty_months']=='0'){ ?> selected="selected" <?php } ?>>No Warranty</option>
                                <option value="6" <?php if($rt22[0]['warranty_months']=='6'){ ?> selected="selected" <?php } ?>>6 Months</option>
                                <option value="12" <?php if($rt22[0]['warranty_months']=='12'){ ?> selected="selected" <?php } ?>>1 Year</option>
								<option value="24" <?php if($rt22[0]['warranty_months']=='24'){ ?> selected="selected" <?php } ?>>2 Years</option>
								<option value="36" <?php if($rt22[0]['warranty_months']=='36'){ ?> selected="selected" <?php } ?>>3 Years</option>
								<option value="48" <?php if($rt22[0]['warranty_months']=='48'){ ?> selected="selected" <?php } ?>>4 Years</option>
                              </select>
							  -->
                            </div>
                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label"> Description</label>

                            <div class="col-md-8">

                                <textarea name="description" class="input-xlarge" id="textarea" rows="5"><?php echo $rt22[0]['details'];?></textarea>

                            </div>

                        </div>
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
				function select_vendor(category)
				{
					var formdata =
					  {
						category: category
					  };
				  $.ajax({
					url: "<?php echo base_url();?>complaint/vendor_based_on_product_ajax",
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
					url: "<?php echo base_url();?>complaint/equipment_based_on_vendor_ajax",
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
                  <input type="hidden" name="pk_instrument_id" value="<?php echo $this->uri->segment(3); ?>">
                  <button type="submit" class="btn btn-default blue">Submit</button>
         <!--         <button type="button" class="btn btn-circle default">Cancel</button>	-->
                </div>
              </div>
            </div>
           </div>
           </form>
           </div>
          </div>
        </div>
      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<script>
jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};

$("#warranty_months").ForceNumericOnly();
</script>
<?php $this->load->view('footer');?>