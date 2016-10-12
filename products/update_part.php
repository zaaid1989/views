<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Update Spare Part   <small>Registration</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> Spare Parts <i class="fa fa-angle-right"></i> </li>

          <li> Update Part </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

                <div class="portlet box green-seagreen">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Update Spare Part </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form"> 
                  
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
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>products/part_update_insert" class="form-horizontal" method="post" id="target" enctype="multipart/form-data">
                <div class="form-body">
                 
                 <div class="form-group">
                    <label class="col-md-3 control-label">Vendor Name</label>
                    <div class="col-md-8">
                        <select class="form-control" name="vendor_name" onchange="select_products(this.value)">
                        	<option value="">---Choose---</option>
							<?php 
								  $query1 = $this->db->query("select * from tbl_parts where pk_part_id= '".$this->uri->segment(3)."'");
								  $result1 = $query1->result_array();
								  //
								  $query = $this->db->query("select * from tbl_vendors where status = '0'");
								  $result = $query->result_array();
								  foreach($result as $vendor)
								  {
							?>
                            		<option value="<?php echo $vendor['pk_vendor_id']?>" <?php if($vendor['pk_vendor_id']==$result1[0]['fk_vendor_id']){ echo ' selected="selected"';}?>>
										<?php echo $vendor['vendor_name']?>
                                    </option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-md-3 control-label">Product Name</label>
                    <div class="col-md-8 product_select">
                        <select class="form-control" name="product_name">
                        	<option value="">---Choose---</option>
							<?php 
								  $query = $this->db->query("select * from tbl_products where status = '0'");
								  $result = $query->result_array();
								  foreach($result as $vendor)
								  {
							?>
                            		<option value="<?php echo $vendor['pk_product_id']?>" <?php if($vendor['pk_product_id']==$result1[0]['fk_product_id']){ echo ' selected="selected"';}?>>
										<?php echo $vendor['product_name']?>
                                    </option>
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
                        <input type="text" class="form-control" name="part_no" value="<?php echo $result1[0]['part_number'];?>">
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Part Description</label>
                    <div class="col-md-8">
                       <textarea name="part_description" class="input-xlarge" id="part_description" rows="5" required><?php echo urldecode($result1[0]['description']);?></textarea>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Minimum Stock Quantiy</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="minimum_qty" value="<?php echo $result1[0]['minimum_quantity'];?>">
                       
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Unit Price</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="unit_price" value="<?php echo $result1[0]['unit_price'];?>">
                       
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-md-3 control-label">Image (Status)</label>
                    <div class="col-md-8">
                        <?php if($result1[0]['image']!=''){?>
                        	<img src="<?php echo base_url();?>usersimages/parts_images/<?php echo $result1[0]['pk_part_id'];?>/<?php echo $result1[0]['image'];?>" 
                            class="img-responsive" style="width:300px;" />
                        <?php } else echo '<label class="control-label">Not Uploaded</label>'; ?>
					   </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Upload Image</label>
                    <div class="col-md-8">
                        <input type="file" name="image" id="i_file">
                        <?php if($result1[0]['unit_price']!=''){?>
                        	<img src="<?php echo base_url();?>usersimages/parts_images/<?php echo $result1[0]['pk_part_id'];?>/<?php echo $result1[0]['image'];?>" 
                            class="img-responsive" style="width:300px;" />
                        <?php }?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Comments</label>
                    <div class="col-md-8">
                       <textarea name="comments" class="input-xlarge" id="comments" rows="5" required><?php echo urldecode($result1[0]['comments']);?></textarea>
                    </div>
                </div>
                
                
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6">
                                    <input type="hidden" name="part_hidden_id" value="<?php echo $this->uri->segment(3);?>" />
                                    <button type="submit" class="btn default yellow-zed">Update</button>
								<!--	<a href="<?php echo site_url();?>sys/news" class="btn default">Cancel</a>  -->
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