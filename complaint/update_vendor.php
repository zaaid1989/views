<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Vendor <small>Update</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Vendors
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Update Vendor
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

              <div class="caption"> <i class="fa fa-globe"></i>Update vendor</div>

              <div class="tools"> 
                  <a href="javascript:;" class="collapse"> </a> 
                  
                  <a href="javascript:;" class="remove"> </a> 
              </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>complaint/update_vendor_insert">
        	<?php
					$ty22=$this->db->query("select * from tbl_vendors where pk_vendor_id='".$this->uri->segment('3')."'");
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
                                        Vendor Updated Successfully.  
                                      </div>';
                              }
                          ?>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Name</label>

                            <div class="col-md-8">

                                <input type="text"   name="vendor_name"  class="form-control vendor_name" id="vendor_name" 
                                value="<?php echo $rt22[0]["vendor_name"];?>" required>	        
                            </div>

                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Email</label>

                            <div class="col-md-8">

                                <input type="text"   name="email"  class="form-control address" id="email" value="<?php echo $rt22[0]["email"];?>" required>	        
                            </div>

                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Address</label>

                            <div class="col-md-8">

                                <input type="text"   name="address"  class="form-control address" id="address" 
                                value="<?php echo $rt22[0]["address"];?>" required>	        
                            </div>

                        </div>
                        
                        
                        

                        <div class="form-group">

                            <label class="col-md-3 control-label">Contact Person</label>

                            <div class="col-md-8">

                                <input type="text"   name="conatact_person"  class="form-control conatact_person" id="conatact_person" 
                                value="<?php echo $rt22[0]["conatact_person"];?>"  required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Contact Office</label>

                            <div class="col-md-8">

                                <input type="text"   name="contact_no_office"  class="form-control contact_no_office" id="contact_no_office" 
                                value="<?php echo $rt22[0]["contact_no_office"];?>"  required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Country</label>

                            <div class="col-md-8">

                                <input type="text"   name="country"  class="form-control country" id="country"  value="<?php echo $rt22[0]["country"];?>" required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Contact Mobile</label>

                            <div class="col-md-8">

                                <input type="text"   name="contact_no_Mobile"  value="<?php echo $rt22[0]["contact_no_Mobile"];?>" class="form-control contact_no_Mobile" id="contact_no_Mobile" required>	        
                            </div>

                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-3 control-label">Vendor Type</label>
                            <div class="col-md-8">
                              <select class="form-control  " name="fk_type_id" id="fk_type_id"  onchange="show_cities(this.value)">
                                <option value="">--Choose--</option>
                                <?php
                                  $qu="SELECT * from tbl_product_types ";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    {
                                        ?>
                                        <option value="<?php echo $value['pk_product_type_id'];?>">
											<?php echo $value['product_type'];?>					  
                                        </option>
                                        <?php
                                    }?>
                              </select>
                            </div>
                        </div>-->
                        <div class="form-group">

                            <label class="col-md-3 control-label">Categories</label>

                            <div class="col-md-8 sent_to_bridge type_products">

                                <select name="category[]" required class="js-example-tags form-control select2-hidden-accessible" 
                                multiple="" tabindex="-1" aria-hidden="true">
                                  <?php
                                  		$rrr	=	"select * from tbl_category where status ='0'";
										$nn=$this->db->query($rrr);
										$nnm=$nn->result_array();
										foreach($nnm as $drt)
										{
											echo '<option value="';
											echo $drt["pk_category_id"];
											echo '"';
											$ty=$this->db->query("select * from tbl_vendor_category_bridge where 
											fk_category_id='".$drt['pk_category_id']."' AND fk_vendor_id='".$rt22[0]['pk_vendor_id']."'");
                                      		if($ty->num_rows()>0)
											{
												echo ' selected ';
											}
											echo '">';
											echo $drt["category_name"];
											echo '</option>';
										}
								  ?>
                                </select>
                                

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">City</label>

                            <div class="col-md-8">

                                <input type="text"   name="city"  class="form-control city" id="city"  value="<?php echo $rt22[0]["city"];?>" required> 
							<!--
								<select name="city" id="city" class="form-control" required>
                                            <option value="">--Select Equipment--</option>
											<?php 
											$maxqu = $this->db->query("SELECT * FROM tbl_cities ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                ?>
                                                <option value="<?php echo $val['pk_instrument_id'];//pk_product_id?>" <?php if(isset($_GET['equipment']) && $_GET['equipment']==$val['pk_instrument_id']){ echo 'selected="selected"';}//pk_instrument_id?>>
													<?php echo $val['serial_no'].' - '.$val['client_name'].' ('.$val['city_name'].') - '.$val['product_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
								-->
                            </div>

                        </div>
                    </div>
                  </div>
			  <script type="text/javascript">
				function show_cities(product_type)
				{
					var formdata =
					  {
						product_type: product_type,
						mutiple: 'multiple'
					  };
				  $.ajax({
					url: "<?php echo base_url();?>complaint/category_based_on_vendortype_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$(".type_products").html(msg);
						}
					})
					return false;
				}
              </script>
              
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-5 col-md-9">
                  <input type="hidden" name="pk_vendor_id" value="<?php echo $this->uri->segment(3);?>">
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
<?php $this->load->view('footer');?>