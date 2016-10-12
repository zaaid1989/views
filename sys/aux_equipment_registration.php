<?php $this->load->view('header');?>
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
        Auxiliary Equipment <small>Stock In</small>
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
                    Auxiliary Equipment Stock In
                </li>
            </ul>
                      
        </div>
        <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">

        <div class="col-md-12"> 
       
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box grey-cascade">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Enter Report</div>

              <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/insert_aux_equipment_registration">
        	<input type="hidden" name="engineer_dvr_form" value="engineer_dvr_form" />
            <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
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
						  <!--
						  <div class="form-group">
                            <label class="col-md-3 control-label">Category</label>
                            <div class="col-md-8 category_vendors">
                              <select class="form-control  " name="category" id="category"  required>
							  <option value="1">Aux</option>
                                
                              </select>
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label class="col-md-3 control-label">Vendor</label>
                            <div class="col-md-8">
                              <select class="form-control" name="vendor" id="vendor"  onchange="select_vendor(this.value)" required>
                                <option value="">--Choose--</option>
                                <?php
                                  $qu="SELECT * from tbl_vendors WHERE fk_type_id!='1' AND status!=1 ";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    {
                                        ?>
                                        <option value="<?php echo $value['pk_vendor_id'];?>">
											<?php echo $value['vendor_name'];?>					  
                                        </option>
                                        <?php
                                    }?>
                              </select>
                            </div>
                        </div>
						-->
                        <div class="form-group" style="display:none;">
                            <label class="col-md-3 control-label">Category</label>
                            <div class="col-md-8">
                              <select class="form-control" name="category" id="category" readonly required>
                                <option value="">--Choose--</option>
                                <?php
                                  $qu="SELECT * from tbl_category ";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    {
										if ($value['pk_category_id']!=1) continue;
                                        ?>
                                        <option value="<?php echo $value['pk_category_id'];?>" <?php if ($value['pk_category_id']==1) echo "selected='selected'";?> >
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
                                <option value="">--Choose--</option>
                                <?php
                                  $qu="SELECT * from tbl_products WHERE fk_category_id='1' AND status = '0' ";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    { ?>
                                        <option value="<?php echo $value['pk_product_id'];?>" >
											<?php echo $value['product_name'];?>					  
                                        </option>
                                        <?php
                                    }?>
                                 
                              </select>
                            </div>
                        </div> 
						
                        
                       	<div class="form-group">
                            <label class="col-md-3 control-label">Vendor</label>
                            <div class="col-md-8 category_vendors">
                              <select class="form-control  " name="vendor" id="vendor"  required>
                                <option value="">--Choose--</option>
                              </select>
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label class="col-md-3 control-label">Territory </label>
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
                                        <option value="<?php echo $value['pk_office_id'];?>">
											<?php echo $value['office_name'];?>					  
                                        </option>
                                        <?php
                                    }?>
                              </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Location</label>
                            <div class="col-md-8">
                              <select class="form-control  " name="cutomer" id="cutomer" onchange="show_main(this.value)" required>
                                <option value="">--Choose--</option>
                                <option value="officeoption_1">Rawalpindi Office (HO)</option>
                                <option value="officeoption_2">Lahore Office (LO)</option>
                                <option value="officeoption_3">Karachi Office (KO)</option>
                                <option value="officeoption_4">Multan Office (MO)</option>
                                <option value="officeoption_5">Peshawar (PO)</option>
                                <?php
                                  $qu="				SELECT tbl_clients.*,
													COALESCE(tbl_cities.city_name) AS city_name,
													COALESCE(tbl_area.area) AS area
													from tbl_clients  
													LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
													LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
													where tbl_clients.delete_status = '0'";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    {
                                        ?>
                                        <option value="<?php echo $value['pk_client_id'];?>">
											<?php echo $value['client_name'];
													
													echo '--('.$value['city_name'].')';
													//
													
													echo '--('.$value['area'].')';
											
											?>					  
                                        </option>
                                        <?php
                                    }?>
                              </select>
                            </div>
                        </div>
                        
                        
						
						<div class="form-group">
                            <label class="col-md-3 control-label">Main Equipment</label>
                            <div class="col-md-8 sent_to_bridge type_products equipments">
                                <select class="form-control "  name="main_equipment[]" required multiple="multiple"> 
                                  <?php /*
                                  		$rrr	=	"SELECT tbl_instruments.pk_instrument_id ,tbl_instruments.serial_no ,tbl_products.product_name
										FROM tbl_instruments
										JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
										WHERE tbl_instruments.fk_category_id!=1 AND tbl_products.status=0
										ORDER BY   `product_name`,`serial_no`";
										//echo $rrr;exit;
										$nn=$this->db->query($rrr);
										$nnm=$nn->result_array();
										foreach($nnm as $drt)
										{
											
											echo '<option value="';
											echo $drt["pk_instrument_id"];
											echo '">';
											echo $drt["product_name"].' - '.$drt["serial_no"];
											echo '</option>';
										} */
								  ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">

                            <label class="col-md-3 control-label">Invoice Number</label>

                            <div class="col-md-8">

                                <input type="text"   name="invoice_number"  class="form-control" id="invoice_number" >	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Invoice Date</label>

                            <div class="col-md-8">

                                <input type="text"   name="invoice_date"  class="form-control datepicker" id="invoice_date" required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Price</label>

                            <div class="col-md-8">

                                <input type="text"   name="equipment_price"  class="form-control" id="equipment_price" >	        
                            </div>

                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label">Auxiliary Equipment Serial Number</label>

                            <div class="col-md-8">

                                <input type="text"   name="serial_no"  class="form-control serial_no" id="serial_no" required>	        
                            </div>

                        </div>
						
                        <div class="form-group">

                            <label class="col-md-3 control-label">Warranty Start Date</label>

                            <div class="col-md-8">

                                <input type="text"   name="warranty_start_date"  class="form-control datepicker" id="warranty_start_date"  required>	        
                            </div>

                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label">Warranty Period (Months)</label>
                            <div class="col-md-8">
							<input class="form-control col-md-2" type="number" name="warranty_months" id="warranty_months" required>
                                <!--
								<select class="form-control" name="warranty_months" id="warranty_months" required>
                                <option value="-1">--Choose--</option>
                                <option value="0">No Warranty</option>
                                <option value="6">6 Months</option>
                                <option value="12">1 Year</option>
								<option value="24">2 Years</option>
								<option value="36">3 Years</option>
								<option value="48">4 Years</option>
                              </select>
							  -->
                            </div>
                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label"> Description</label>

                            <div class="col-md-8">

                                <textarea name="description" class="input-xlarge" id="textarea" rows="5"></textarea>

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Status </label>
                            <div class="col-md-8">
                              <select class="form-control" name="status" id="status" required>
                                <option value="">--Choose--</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                                <option value="3">Expired</option>
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
					url: "<?php echo base_url();?>sys/vendor_based_on_product_2_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$(".category_vendors").html(msg);
						$('select').select2();
						}
					})
					return false;
				}

				/*
				function select_vendorr(product_id)
				{
					<?php
					?>
					
					<?php
					$category			=	 "<script>document.write(product_id)</script>";
					$msg 				= 		"";
					$rrr				=	"select * from tbl_vendor_product_bridge where fk_product_id = '".$category."' ";
					//echo $rrr;exit;
					$nn=$this->db->query($rrr);
					$nnm=$nn->result_array();
					$msg.= '<select name="vendor';
					$msg.= '" class="form-control"';
					$msg.= ' required onchange="show_equipment(this.value)">';
					$msg.= '<option value="">---Select---</option>';
					foreach($nnm as $drt)
					{
						$rrr2=	"select * from tbl_vendors where pk_vendor_id = '".$drt["fk_vendor_id"]."' AND status = '0' ";
						//$msg.= $rrr2;
						$nn2=$this->db->query($rrr2);
						if($nn2->num_rows() > 0)
						{
							$msg.= '<option value="';
							$msg.= $drt["fk_vendor_id"];
							$msg.= '">';
							
							$nnm2=$nn2->result_array();
							$msg.= $nnm2[0]["vendor_name"];
							$msg.= '</option>';
						}
					}
					$msg.= '</select>';
					?>
					
					$(".category_vendors").html(<?php echo $msg; ?>);
				}
				*/
				
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
			</script>
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-5 col-md-9">
                  <button type="submit" class="btn btn-circle blue">Submit</button>
              <!--    <button type="button" class="btn btn-circle default">Cancel</button> -->
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

$("#warranty_monthss").ForceNumericOnly();
</script>
<?php $this->load->view('footer');?>