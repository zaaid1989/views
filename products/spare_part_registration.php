<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Spare Part   <small>Registration</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> Spare Parts <i class="fa fa-angle-right"></i> </li>

          <li> Spare Part Registration  </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

                <div class="portlet box green-seagreen">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Spare Part Registration </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>products/part_insert" class="form-horizontal" method="post" id="target" enctype="multipart/form-data">
                <div class="form-body">
                 
                 <div class="form-group">
                    <label class="col-md-3 control-label">Vendor Name</label>
                    <div class="col-md-8">
                        <select class="form-control" name="vendor_name" onchange="select_products(this.value)">
                        	<option value="">---Choose---</option>
							<?php 
								  $query = $this->db->query("select * from tbl_vendors where status = '0'");
								  $result = $query->result_array();
								  foreach($result as $vendor)
								  {
							?>
                            		<option value="<?php echo $vendor['pk_vendor_id']?>"><?php echo $vendor['vendor_name']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-md-3 control-label">Product Name</label>
                    <div class="col-md-8 product_select">
                        <select class="form-control" name="products_name">
                        	<option value="">---Choose---</option>
							<?php 
								  $query = $this->db->query("select * from tbl_products where status = '0'");
								  $result = $query->result_array();
								  foreach($result as $vendor)
								  {
							?>
                            		<option value="<?php echo $vendor['pk_product_id']?>"><?php echo $vendor['product_name']?></option>
                            <?php }?>
                        </select>
                    </div>
                 </div>
                 <script>
				 function select_products(vendor_id)
				 {
					 var formdata =
					  {
						vendor_id: vendor_id
					  };
				  $.ajax({
					url: "<?php echo base_url();?>products/select_products",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".product_select").html(msg);
						
						}
					})
					return false;
				 }
				 </script>
                 <div class="form-group">
                    <label class="col-md-3 control-label">Part Number</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="part_no">
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Part Description</label>
                    <div class="col-md-8">
                       <textarea name="part_description" class="input-xlarge" id="part_description" rows="5" required></textarea>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Minimum Stock Quantiy</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="minimum_qty">
                       
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Unit Price</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="unit_price">
                       
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="col-md-3 control-label"> Stock Quantiy</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="stock_qty">
                       
                    </div>
                </div>
                -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Picture Of Part</label>
                    <div class="col-md-8">
                        <input type="file" name="image" id="i_file" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Comments</label>
                    <div class="col-md-8">
                       <textarea name="comments" class="input-xlarge" id="comments" rows="5" required></textarea>
                    </div>
                </div>
                
                
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6">
                                    <button type="submit" class="btn default yellow-zed">Submit</button>
							<!--		<a href="<?php echo site_url();?>" class="btn default">Cancel</a> -->
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

      <!-- END PAGE CONTENT--> 

    </div>

  </div>

  <!-- END CONTENT --> 

  

</div>

<script>
     $( "#target" ).submit(function( event ) {
          size = $('#i_file')[0].files[0].size;
          //max size 50kb => 50*1000
          if( size > 800*1000){
             alert('Please upload less than 800kb file');
             return false;
          }
		  else  return true;
     });
</script>
<?php $this->load->view('footer');?>