<?php /*

Controller makes insertions in tbl_stock twice for ledger
Also it makes an entry in tbl_sprf for dc_out
WIll display in dc_in automatically
Won't ask for approval
*/
?>
<?php $this->load->view('header');
function myDate($time){
  if($time == '0000-00-00 00:00:00')
     return "";
  return date("d-M-Y", strtotime($time));
}
?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Spare Part   <small>Transfer to Office </small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> Spare Parts <i class="fa fa-angle-right"></i> </li>

          <li> Part Transfer   </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->
	  <?php
	  if(isset($_GET['msg']) && $_GET['msg']=='success')
		{ 
		  echo '<div class="alert alert-success alert-dismissable">  
				  <a class="close" data-dismiss="alert">×</a>  
				  Stock Updated Successfully.  
				</div>';
		}
	  
	  ?>

      <div class="row">

        <div class="col-md-12">

                <div class="portlet box green-seagreen">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Spare Part Stock Transfer</div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                  </div>

                  <div class="portlet-body form">
			  
                  
                  <?php
					  
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>products/part_transfer_office_insert" class="form-horizontal" method="post"  enctype="multipart/form-data">
                <div class="form-body">
				<div class="">
				<!--
	  <h3>
	  <label class="label bg-red">Work is being done on this page. Kindly don't make any entries as long as this message appears.</label>
	  </h3>
	  -->
	</div>	
	
				
                 
                 <div class="form-group">
                    <label class="col-md-3 control-label">Vendor Name</label>
                    <div class="col-md-4">
                        <select class="form-control" id="vendor_name" name="vendor_name" onchange="part_number_select(this.value)">
                        	<option value="">---Choose---</option>
							<?php 
								  if($this->uri->segment(3)!='')
								  {
									  $query1 = $this->db->query("select * from tbl_parts where pk_part_id= '".$this->uri->segment(3)."'");
									  $result1 = $query1->result_array();
								  }
								  //
								  $query = $this->db->query("select * from tbl_vendors where status = '0'");
								  $result = $query->result_array();
								  foreach($result as $vendor)
								  {
							?>
                            		<option value="<?php echo $vendor['pk_vendor_id']?>" <?php if($this->uri->segment(3)!=''){if($vendor['pk_vendor_id']==$result1[0]['fk_vendor_id']){ echo ' selected="selected"';}}?>>
										<?php echo $vendor['vendor_name']?>
                                    </option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-md-3 control-label">Part Number</label>
                    <div class="col-md-4 part_number_select">
                        <?php if($this->uri->segment(3)!=''){?>
                            <!--<input type="text" class="form-control" value="<?php echo $result1[0]['part_number'];?>">
                            <input type="hidden"  name="part_number" value="<?php echo $result1[0]['pk_part_id'];?>">-->
                            
                            <select class="form-control"  name="part_number" onchange="select_description(this.value)" required>
                                <option>---Choose---</option>
                                <?php
                                $you="select * from tbl_parts where fk_vendor_id = '".$result1[0]['fk_vendor_id']."'";
                                $query = $this->db->query($you);
                                $result = $query->result_array();
                                foreach($result as $part)
                                {
                                    ?>
                                    <option value="<?php echo $part['pk_part_id'];?>" <?php if ($part['pk_part_id']==$result1[0]['pk_part_id']){ echo 'selected="selected"';}?>>
                                        <?php echo $part['part_number'];?>
                                    </option>
                                    <?php 
                                }?>
                            </select>
                        <?php } else {?>
                            <select class="form-control">
                                <option>---Choose---</option>
                            </select>
                        <?php }?>
                    </div>
                 </div>
                 <script>
				 function part_number_select(vendor_id)
				 {
					 var formdata =
					  {
						vendor_id: vendor_id
					  };
				  $.ajax({
					url: "<?php echo base_url();?>products/part_number_select",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".part_number_select").html(msg);
						$('select').select2();
						}
					})
					return false;
					
				 }
				 function select_description(part_id)
				 {
					 var vendor_id = $('#vendor_name').val();
					 //alert(vendor_id);
					 var formdata2 =
					  {
						vendor_id: vendor_id,
						part_id: part_id
					  };
					$.ajax({
					url: "<?php echo base_url();?>products/select_description",
					type: 'POST',
					data: formdata2,
					success: function(msg){
						$("#part_description").val(msg);
						$('select').select2();
						}
					})
					$.ajax({
					url: "<?php echo base_url();?>products/order_reference_ajax",
					type: 'POST',
					data: formdata2,
					success: function(msg){
						$("#order_number").html(msg);
						}
					})
					$.ajax({
					url: "<?php echo base_url();?>products/office_table_ajax",
					type: 'POST',
					data: formdata2,
					success: function(msg){
						$(".office_table").html(msg);
						}
					})
					return false;
				 }
				 </script>
                 
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Part Description</label>
                    <div class="col-md-4">
                       <textarea name="part_description" class="input-xlarge" id="part_description" rows="5" required><?php if($this->uri->segment(3)!=''){ echo urldecode($result1[0]['description']);}?></textarea>
                    </div>
                </div>
				
				
				<div class="form-group">
                  <div class="col-md-4  col-md-offset-3 office_table">
                   	<table class="table table-striped table-bordered table-hover flip-content">
                	<tr>
                <?php 
					  $query = $this->db->query("select * from tbl_offices");
					  $result = $query->result_array();
					  foreach($result as $office)
					  {
					?>
						<th><?php echo $office['office_name']?></th>
					<?php }?>
                    </tr>
                    <!---->
                    <tr>
                    <?php 
					$zero_stock_office = array();
					  //The data for blow table will be fetched form tbl_stock according to the part selected from the second drop-down in above form
					  $query = $this->db->query("select * from tbl_offices");
					  $result = $query->result_array();
					  foreach($result as $office)
					  {
						echo '<td>';
						if($this->uri->segment(3)!=''){
						echo '<input type="hidden"  name="ur_id" id="ur_id" value="'.$this->uri->segment(3).'">';
						  $stock = $this->db->query("select SUM(stock) AS stock from tbl_stock where fk_office_id = '".$office['pk_office_id']."' AND fk_part_id='".$result1[0]['pk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))");
						 $stock_result = $stock->result_array();
						  if ($stock_result[0]['stock']!=0)
							echo $stock_result[0]['stock'];
						  else {
							  echo '0';
							  array_push($zero_stock_office,$office['pk_office_id']);
						  }
						}
						else echo '<input type="hidden"  name="ur_id" id="ur_id" value="z">';
                      echo '</td>';
					 }?>
                    </tr>
                </table>
                    </div>
                  </div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Date</label>
					<div class="col-md-4">
					  <input type="text" class="form-control datepicker" name="date" id="date" value="<?php echo date('d-M-Y');?>" required>
					</div>
				  </div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Stock Source</label>
					<div class="col-md-4">
					  <select id="stock_source" name="stock_source" class="form-control" required>
						<option value="">--Choose--</option>
						<?php 
								  $query = $this->db->query("select * from tbl_offices");
								  $result = $query->result_array();
								  foreach($result as $vendor)
								  {
									  if (in_array($vendor['pk_office_id'],$zero_stock_office)) continue;
							?>
                            		<option value="<?php echo $vendor['pk_office_id']?>"><?php echo $vendor['office_name']?></option>
                            <?php }?>
					  </select>
					</div>
				  </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Stock Quantity to Transfer</label>
                    <div class="col-md-4">
                        <input type="number" class="form-control" name="stock_quantity" id="stock_quantity" required>
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Stock Destination</label>
                    <div class="col-md-4">
                        <select class="form-control" name="stock_destination" required>
                        	<option value="">---Choose---</option>
							<?php 
								  $query = $this->db->query("select * from tbl_offices");
								  $result = $query->result_array();
								  foreach($result as $vendor)
								  {
							?>
                            		<option value="<?php echo $vendor['pk_office_id']?>"><?php echo $vendor['office_name']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                
                
                
                
				
				<div class="form-group">
                    <label class="col-md-3 control-label">Comments</label>
                    <div class="col-md-4">
                       <textarea name="comments" class="input-xlarge" id="comments" rows="5" ></textarea>
                    </div>
                </div>
				
				
				</div>
				
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6">
                                    <button type="submit" class="btn default yellow-zed">Update Stock</button>
									
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
				<?php 
				if($this->uri->segment(3)!='')
						echo '<input type="hidden"  name="ur_id" id="ur_id" value="'.$this->uri->segment(3).'">';
				else echo '<input type="hidden"  name="ur_id" id="ur_id" value="z">';
						?>
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
<?php $this->load->view('footer');?>

<script>
$('input[name=stock_in_quantity]').change(function() { 
	//alert($('#stock_in_quantity').val());
	var i	=	$('#stock_in_quantity').val();
	if (i<0) {
		$('#comments').prop('required',true);
	}
	else {
		$('#comments').prop('required',false);
	}
});


$('#order_number').on('change', function() {
  //alert( this.value ); // or $(this).val()
  var on = this.value;
  var temp = on.split(',');
  /*
  if (temp[1]>0)
	$('#stock_in_quantity').attr('readonly','readonly');
  else 
	$('#stock_in_quantity').removeAttr('readonly');
  $('#stock_in_quantity').val(temp[1]);
  $('#order_numberr').val(temp[0]);*/
});

$('#stock_type').on("change",function(){
                var locations = $(this).val();
                if(locations=="Import"){
                    document.getElementById('import_warranty').style.display = 'block';
                    document.getElementById('description').style.display = 'none';
					document.getElementById('equipment_serial_div').style.display = 'none';
					
					$('#old_inventory_description').removeAttr('required');
					$('#equipment_serial').removeAttr('required');
					
					$('#invoice_date').attr('required', 'required');
					$('#invoice_number').attr('required', 'required');
					$('#order_number').attr('required', 'required');
                    
                    }
				else if(locations=="Warranty Claim"){
					document.getElementById('import_warranty').style.display = 'block';
					document.getElementById('equipment_serial_div').style.display = 'block';
                    document.getElementById('description').style.display = 'none';
					
					$('#old_inventory_description').removeAttr('required');
					
					$('#invoice_date').attr('required', 'required');
					$('#invoice_number').attr('required', 'required');
					$('#order_number').attr('required', 'required');
					$('#equipment_serial').attr('required', 'required');
		
                }
                else if(locations=="Old Inventory"){
					document.getElementById('description').style.display = 'block';
					document.getElementById('import_warranty').style.display = 'none';
					document.getElementById('equipment_serial_div').style.display = 'none';
					
					$('#invoice_date').removeAttr('required');
					$('#invoice_number').removeAttr('required');
					$('#order_number').removeAttr('required');
					$('#equipment_serial').removeAttr('required');
					
					$('#old_inventory_description').attr('required', 'required');
		
                }
                else{
                    document.getElementById('description').style.display = 'none';
                    document.getElementById('import_warranty').style.display = 'none';
					document.getElementById('equipment_serial_div').style.display = 'none';
					
					$('#equipment_serial').removeAttr('required');
					$('#invoice_date').removeAttr('required');
					$('#invoice_number').removeAttr('required');
					$('#order_number').removeAttr('required');
					$('#old_inventory_description').removeAttr('required');
					
                    }
                });
</script>