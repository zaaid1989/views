<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Add <small>Product</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">
          
          
          <li> <i class="fa fa-home"></i> Home  <i class="fa fa-angle-right"></i> </li>
          <li> <a href="<?php echo base_url() . 'sys/products'; ?>">Products</a> <i class="fa fa-angle-right"></i> </li>
          <li> Add Product </li>

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

                    <div class="caption"> <i class="fa fa-gift"></i>Add Product </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Product Entered Successfully.  
								</div>';
						}
						
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>sys/add_product_insert" class="form-horizontal" method="post">
                <div class="form-body">
                 <div class="form-group">
                    <label class="col-md-3 control-label">Product Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="product_name">
                       
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Category</label>
                    <div class="col-md-4">
                       <select class="from_control" name="category_name" onchange="show_cities(this.value)">
					   <option value="">Choose</option>
                       <?php 
						  $ty=$this->db->query("select * from tbl_category where status = '0'");
						  $rt=$ty->result_array();
						  foreach($rt as $result)
						  {
						   ?>
							<option value="<?php echo $result["pk_category_id"];?>"><?php echo $result["category_name"];?></option>
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
                       <select class="from_control" name="vendors[]">
							<option value="">--Select--</option>
                       </select>
                    </div>
                </div>                    
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">Submit</button>
                              <!--      <a href="<?php echo base_url() . 'sys/products'; ?>" class="btn default">Cancel</a> -->
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