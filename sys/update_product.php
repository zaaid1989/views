<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Update <small>Product</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> Products <i class="fa fa-angle-right"></i> </li>

          <li> Update Product</li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

          <div class="tabbable tabbable-custom boxless tabbable-reversed">

            <ul class="nav nav-tabs">

              <li class="active"> <a href="#tab_0" data-toggle="tab"> Form Actions </a> </li>

            </ul>

            <div class="tab-content">

              <div class="tab-pane active" id="tab_0">

                <div class="portlet box green">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Products </div>

                    <div class="tools"> 
                        <a href="javascript:;" class="collapse"> </a> 
                        
                        <a href="javascript:;" class="remove"> </a> 
                    </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Product Updated Successfully.  
								</div>';
						}
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>sys/update_product_insert" class="form-horizontal" method="post">
                <div class="form-body">
                <?php
                 		$ty22=$this->db->query("select * from tbl_products where pk_product_id='".$this->uri->segment('3')."'");
                        $rt22=$ty22->result_array();
				 ?>
                 <div class="form-group">
                    <label class="col-md-3 control-label">Product Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="product_name" value="<?php echo $rt22[0]["product_name"] ?>">
                       
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Category</label>
                    <div class="col-md-4">
                       <select class="from_control" name="category_name" onchange="show_cities(this.value)">
                       <?php 
						  $ty=$this->db->query("select * from tbl_category  where status = '0'");
						  $rt=$ty->result_array();
						  foreach($rt as $result)
						  {
						   ?>
							<option value="<?php echo $result["pk_category_id"];?>" 
							<?php if($result["pk_category_id"]==$rt22[0]["fk_category_id"]){?> selected="selected"<?php }?>>
								<?php echo $result["category_name"];?>
                            </option>
							<?php
							  }
							?>
                       </select>
                    </div>
                </div>
                <script type="text/javascript">
					function show_cities(category)
					{
						var formdata =
						  {
							category: category,
							mutiple: 'multiple'
						  };
					  $.ajax({
						url: "<?php echo base_url();?>sys/vendors_based_on_category_ajax",
						type: 'POST',
						data: formdata,
						success: function(msg){
							//these two are inner ajax
							$(".type_vendors").html(msg);
							}
						})
						return false;
					}
				  </script>
                <div class="form-group">
                    <label class="col-md-3 control-label">Vendors</label>
                    <div class="col-md-4 type_vendors">
                       
                       <select name="vendors[]" required class="js-example-tags form-control select2-hidden-accessible" 
                                multiple="" tabindex="-1" aria-hidden="true">
                                  <?php
                                  		$ty=$this->db->query("select tbl_vendor_category_bridge.*, tbl_vendors.*
										from tbl_vendor_category_bridge 
										LEFT JOIN tbl_vendors ON tbl_vendor_category_bridge.fk_vendor_id = tbl_vendors.pk_vendor_id
										where fk_category_id='".$rt22[0]["fk_category_id"]."'");
										$my_vendors=$ty->result_array();
										
										foreach($my_vendors as $drt)
										{
											//
											// $rrr	=	"select * from tbl_vendors where pk_vendor_id ='". $drt["fk_vendor_id"]."' and status = '0'";
											// $nn=$this->db->query($rrr);
											//if($nn->num_rows()>0)
											if(isset($drt["vendor_name"])){
												//$nnm=$nn->result_array();
												//
												echo '<option value="';
												echo $drt["pk_vendor_id"];
												echo '"';
												$ty=$this->db->query("select * from tbl_vendor_product_bridge where 
												fk_vendor_id='".$drt['fk_vendor_id']."' AND fk_product_id='". $rt22[0]["pk_product_id"]."'");
												if($ty->num_rows()>0)
												{
													echo ' selected ';
												}
												echo '">';
												echo $drt["vendor_name"];
												echo '</option>';
											}
										}
								  ?>
                                </select>
                       
                    </div>
                </div>                    
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="hidden" name="pk_product_id" value="<?php echo $this->uri->segment(3); ?>">
                                    <button type="submit" class="btn green">Submit</button>
                               <!--     <button type="button" class="btn default">Cancel</button> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </form>

                    <!-- END FORM--> 

                  </div>

                </div>
            </div>

          </div>

        </div>

      </div>

      <!-- END PAGE CONTENT--> 

    </div>

  </div>

  <!-- END CONTENT --> 

  

</div>
<?php $this->load->view('footer');?>