<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Vendor <small>Registration FORM</small>
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
                                Vendor Registration
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
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/insert_vendor_registration">
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
                                        Vendor Registered Successfully.  
                                      </div>';
                              }
                          ?>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Vendor Name</label>

                            <div class="col-md-8">

                                <input type="text"   name="vendor_name"  class="form-control vendor_name" id="vendor_name" required>	        
                            </div>

                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Email</label>

                            <div class="col-md-8">

                                <input type="text"   name="email"  class="form-control address" id="email" required>	        
                            </div>

                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Address</label>

                            <div class="col-md-8">

                                <input type="text"   name="address"  class="form-control address" id="address" required>	        
                            </div>

                        </div>
                        
                        
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Contact Person Name</label>

                            <div class="col-md-8">

                                <input type="text"   name="conatact_person"  class="form-control conatact_person" id="conatact_person" required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Contact Office</label>

                            <div class="col-md-8">

                                <input type="text"   name="contact_no_office"  class="form-control contact_no_office" id="contact_no_office" required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Country</label>

                            <div class="col-md-8">

                                <input type="text"   name="country"  class="form-control country" id="country" required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Contact Mobile</label>

                            <div class="col-md-8">

                                <input type="text"   name="contact_no_Mobile"  class="form-control contact_no_Mobile" id="contact_no_Mobile" required>	        
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

                                <select class="form-control"  name="category[]" required multiple="multiple">
    
                                  <?php
                                  		$rrr	=	"select * from tbl_category where status ='0'";
										//echo $rrr;exit;
										$nn=$this->db->query($rrr);
										$nnm=$nn->result_array();
										foreach($nnm as $drt)
										{
											echo '<option value="';
											echo $drt["pk_category_id"];
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

                                <input type="text"   name="city"  class="form-control city" id="city" required>	        
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
					url: "<?php echo base_url();?>sys/category_based_on_vendortype_ajax",
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
                  <button type="submit" class="btn btn-circle blue">Submit</button>
               <!--   <button type="button" class="btn btn-circle default">Cancel</button> -->
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