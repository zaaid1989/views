<?php $this->load->view('header');
function myDate($time){
  if($time == '0000-00-00 00:00:00')
     return "";
  return date("d-M-Y", strtotime($time));
}
$p = "";
$t = "";
$on = "";
$id = "";
$in = "";
$d = "";
$es = "";
$o 	= "";
$v	=	"";
$pn	=	"";
$pd	=	"";
$off = "";

if (isset($_GET['p']))	$p	=	$_GET['p'];
if (isset($_GET['t']))	$t	=	$_GET['t'];
if (isset($_GET['on']))	$on	=	$_GET['on'];
if (isset($_GET['id'])) $id	=	$_GET['id'];
if (isset($_GET['in'])) $in	=	$_GET['in'];
if (isset($_GET['d']))	$d	=	$_GET['d'];
if (isset($_GET['es'])) $es	=	$_GET['es'];
if (isset($_GET['off']))	$off	=	$_GET['off'];

if ($p != "") {
	$query=$this->db->query("SELECT tbl_parts.part_number,tbl_parts.description,tbl_vendors.vendor_name
						  from tbl_parts
						  JOIN tbl_vendors ON tbl_parts.fk_vendor_id=tbl_vendors.pk_vendor_id
						  WHERE tbl_parts.pk_part_id=$p");
  $query_res=$query->result_array();
  $v	=	$query_res[0]['vendor_name'];
  $pn	=	$query_res[0]['part_number'];
  $pd	=	urldecode($query_res[0]['description']);
  //echo "zaaid";
  
}
/*
echo "Zaaid";
print_r($_GET);

//echo "<input type='text' value='".$_GET['t']."' />";
echo "<br/><br/>";
*/
?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Spare Part   <small>Stock Entry </small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> Spare Parts <i class="fa fa-angle-right"></i> </li>

          <li> Stock Entry   </li>

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
<?php if($this->uri->segment(3)=='' || $this->uri->segment(3)>=0) { ?>
<div class="row">
          <div class="col-md-12"> 
            <!-- BEGIN CURRENT DC TABLE PORTLET-->
        <!--    <div class="portlet box green-sharp">-->
			<div class="portlet light bg-inverse">
              <div class="portlet-title">
                <div class="caption font-red-thunderbird"> <span class="caption-subject bold font-red-thunderbird uppercase">
								<i class="icon-bar-chart font-red-thunderbird"></i> Current DC</span>
								<span class="caption-helper bg-red-thunderbird">NOTE: A common DC Number will be assigned to the parts listed below on approval.</span>
				</div>
                <div class="tools"> <a href="javascript:;" class="collapse"> </a> </a> <a href="javascript:;" class="remove"> </a> </div>
              </div>
              <div class="portlet-body">
            	<div class="portlet-body flip-scroll">
                 <table class="table table-striped table-bordered table-hover hover flip-content" id="">
                  <thead class="bg-grey">
                    <tr>
					  <th> Date </th>
                      <th> Vendor Name	</th>
					  <th> Part Number	</th>
                      <th> Part Description </th>
					  <th> Stock Type </th>
					  <th> Old Inventory Description </th>
					  <th> Invoice Number </th>
					  <th> Invoice Date </th>
					  <th> Equipment Serial </th>
					  <th> Stock Quantity </th>
					  <th> Stock Location </th>
					  <th> Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php // query for fetching parts with pending dc and status as in
                          $query=$this->db->query("SELECT tbl_stock.*,tbl_parts.part_number,tbl_parts.description,tbl_vendors.vendor_name, tbl_offices.office_name
						  from tbl_stock
						  JOIN tbl_parts ON tbl_stock.fk_part_id=tbl_parts.pk_part_id
						  JOIN tbl_vendors ON tbl_parts.fk_vendor_id=tbl_vendors.pk_vendor_id
						  JOIN tbl_offices ON tbl_stock.fk_office_id=tbl_offices.pk_office_id
						  WHERE tbl_stock.in_status = 'pending_approval' AND tbl_stock.dc_type = 'in' ORDER BY tbl_stock.pk_stock_id DESC");
						  $query_res=$query->result_array();
						  // For each loop of parts and echo them
                          foreach ($query_res as $dc_entry) {
                                  ?>
                                  <tr class="odd gradeX">
									  <td> <?php echo myDate($dc_entry['date']); ?> </td>
                                      <td> <?php echo $dc_entry['vendor_name']; ?> </td>
									  <td> <?php echo $dc_entry['part_number']; ?> </td>
									  <td> <?php echo urldecode($dc_entry['description']); ?> </td>
									  <td> <?php echo $dc_entry['stock_type']; ?> </td>
									  <td> <?php echo $dc_entry['old_inventory_description']; ?> </td>
									  <td> <?php echo $dc_entry['invoice_number']; ?> </td>
									  <td> <?php echo myDate($dc_entry['invoice_date']); ?> </td>
									  <td> <?php echo $dc_entry['equipment_serial']; ?> </td>
									  <td> <?php echo $dc_entry['stock']; ?> </td>
									  <td> <?php echo $dc_entry['office_name']; ?> </td>
									  <td>
										  <a class="btn btn default red-thunderbird"  
										  href="<?php echo base_url();?>products/delete_stock/<?php echo $dc_entry["pk_stock_id"]; ?>"
										  onClick="return confirm('Are you sure you want to delete?')">
											Delete <i class="fa fa-trash-o"></i>
										  </a>
									  </td>
                                  </tr>
                                  <?php
								  } // End of For each
					 			  ?>
                  </tbody>
                </table>
				
               </div>
              
			  <!-- Submit Button -->
			  <div class="form-actions">
						<div class="row">
                          <div class="col-md-offset-5 col-md-7">
						  <a class="btn btn-lg green"  
						  href="<?php echo base_url();?>products/approve_dc/"
						  onClick="return confirm('Are you sure you want to approve?')">
							Approve and Submit 
						  </a>
                          </div>
						  </div>
                      </div>
			  <!-- Submit Button -->
			  
			  </div>
            </div>
            <!-- END CURRENT DC TABLE PORTLET-->     
          </div>
        </div>
<?php } ?>	  

      <div class="row">
        <div class="col-md-12">
                <div class="portlet box grey-gallery">
                  <div class="portlet-title">
                    <div class="caption"> <i class="fa fa-gift"></i>Spare Part Stock Entry</div>
                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                  </div>
                  <div class="portlet-body form">
                  <?php	?>
                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>products/spare_part_stock_entry_insert" class="horizontal-form" method="post"  enctype="multipart/form-data">
                <div class="form-body">
				<div class="">
				<!--
	  <h3>
	  <label class="label bg-red">Work is being done on this page. Kindly don't make any entries as long as this message appears.</label>
	  </h3>
	  -->
	</div>
	
	<div class="row bg-red-intense" id="vv">
			<div class="col-md-6">
                 <div class="form-group">
                    <label class="control-label">Vendor Name</label>
                    
                        <select class="form-control" id="vendor_name" name="vendor_name" onchange="part_number_select(this.value)">
                        	<option value="">---Choose---</option>
							<?php 
								  if($this->uri->segment(3)!='')
								  {
									  $query1 = $this->db->query("select * from tbl_parts where pk_part_id= '".$this->uri->segment(3)."'");
									  $result1 = $query1->result_array();
								  }
								  if($p != '')
								  {
									 // echo "Zaaid";
									  $query1 = $this->db->query("select * from tbl_parts where pk_part_id= '".$p."'");
									  $result1 = $query1->result_array();
								  }
								  //
								  $query = $this->db->query("select * from tbl_vendors where status = '0'");
								  $result = $query->result_array();
								  foreach($result as $vendor)
								  {
							?>
                            		<option value="<?php echo $vendor['pk_vendor_id']?>" <?php if($this->uri->segment(3)!='' || $p != ''){if($vendor['pk_vendor_id']==$result1[0]['fk_vendor_id']){ echo ' selected="selected"';}}?>>
										<?php echo $vendor['vendor_name']?>
                                    </option>
                            <?php }?>
                        </select>
                    </div>
                </div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Date of Data Entry</label>
					  <input type="text" class="form-control datepicker" name="date" id="date" value="<?php if ($d != "") echo date('d-M-Y',strtotime($d)); else echo date('d-M-Y');?>" required>
					</div>
				  </div>
	</div> <!-- end of row -->
	
		<div class="row bg-green-meadow" >
	
			<div class="col-md-6">
                 <div class="form-group">
                    <label class="control-label">Part Number</label>
						<div class="part_number_select">
                        <?php if($this->uri->segment(3)!='' || $p != ""){?>
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
                 </div>
				 
                <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Part Description</label> <br/>
                       <textarea name="part_description" class="input-xlarge" id="part_description" rows="2" required><?php if($this->uri->segment(3)!='' || $p != ""){ echo urldecode($result1[0]['description']);}?></textarea>
                    </div>
                </div>
				
				
	</div> <!-- end of row -->
	
		<div class="row bg-yellow-zed">			
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Stock Type</label>
					  <select id="stock_type" name="stock_type" class="form-control" required>
						<option value="">--Choose--</option>
						<option value="Import" <?php if ($t != "" && $t=="Import") echo "selected='selected'"; ?>>Import</option>
						<option value="Warranty Claim" <?php if ($t != "" && $t=="Warranty Claim") echo "selected='selected'"; ?>>Warranty Claim</option>
						<option value="Old Inventory" <?php if ($t != "" && $t=="Old Inventory") echo "selected='selected'"; ?>>Old Inventory</option>
					  </select>
					</div>
				  </div>
				  
				  <div class="col-md-6">
					<div class="form-group" id="description" <?php if ($t != "" && $t=="Old Inventory") echo ''; else echo 'style="display:none"'; ?>>
					<label class="control-label">Description</label> <br/>
					  <textarea name="old_inventory_description" class="input-xlarge" id="old_inventory_description" rows="2" ></textarea>
					</div>
				  </div>
	</div> <!-- end of row -->

	
			<div id="import_warranty" <?php if ($t != "" && $t!="Old Inventory") echo ''; else echo 'style="display:none"'; ?>>
	<div class="row bg-yellow-zed">			
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Order Reference</label>
					  <select name="order_number" id="order_number" class="form-control">
                                            <option value="">--Select Order Reference--</option>
											<?php 
											$maxqu = $this->db->query("SELECT * from tbl_orders WHERE status=1 AND fk_part_id='".$this->uri->segment(3)."' ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val) { ?>
                                                <option value="<?php echo $val['order_number'].','.$val['order_quantity'];?>"
												<?php if ($on != "" && $on==$val['order_number']) echo "selected='selected';" ?>>
													<?php echo $val['order_number'].' - '.date('d-M-Y',strtotime($val['date'])).' - Qty = '.$val['order_quantity'];?>
                                                </option>
                                            <?php } ?>
											<option value="Other" <? if ($on != "" && $on=='Other') echo "selected='selected'"; ?>>Other</option>
                      </select>
					  <input type="hidden"  name="order_numberr" id="order_numberr" value="">
					</div>
				  </div>
      
				  <div class="col-md-4">
				  <div class="form-group">
					<label class="control-label">Invoice Number</label>
					  <input type="text" class="form-control" name="invoice_number" id="invoice_number" <? if ($in != "") echo "value='$in'"; ?>>
					</div>
				  </div>
				  
				  <div class="col-md-4">
				  <div class="form-group">
					<label class="control-label">Invoice Date</label>
					  <input type="text" class="form-control datepicker" name="invoice_date" id="invoice_date" <? if ($id != "") echo "value='".date('d-M-Y',strtotime($id))."'";?> >
					</div>
				  </div>
	</div> <!-- end of row -->
			</div>
	
	<div class="row bg-yellow-zed">
			<div class="col-md-6">
			<div class="form-group" id="equipment_serial_div" <?php if ($t != "" && $t=="Warranty Claim") echo ''; else echo 'style="display:none"'; ?>>
					<label class="control-label">Equipment Serial No</label>
					 <!-- <input type="text" class="form-control" name="equipment_serial" id="equipment_serial"> -->
					  <select name="equipment_serial" id="equipment_serial" class="form-control" >
                                            <option value="">--Select Equipment--</option>
											<?php 
											$maxqu = $this->db->query("SELECT tbl_instruments.* ,tbl_products.product_name,tbl_clients.client_name,tbl_cities.city_name FROM tbl_instruments 
											LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
											LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
											LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
											ORDER BY   `product_name`,`pk_instrument_id` ");
										
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['serial_no'];//pk_product_id?>" <?php //if(isset($_GET['equipment']) && $_GET['equipment']==$val['pk_instrument_id']){ echo 'selected="selected"';}//pk_instrument_id?>
												<?php if ($es != "" && $es==$val['serial_no']) echo "selected='selected';" ?>
												>
													<?php echo $val['serial_no'].' - '.$val['client_name'].' ('.$val['city_name'].') - '.$val['product_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
					</div>
				  </div>
	</div> <!-- end of row -->
	
	
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
    

	

	
	<div class="row bg-blue-steel">
                <div class="col-md-6">
				<div class="form-group">
                    <label class="control-label">Stock in Quantity</label>
                        <input type="number" class="form-control" name="stock_in_quantity" id="stock_in_quantity" <?php if ($p != "") echo 'autofocus'; ?> required>
                    </div>
                </div>
				
				<div class="col-md-6">
                <div class="form-group bg-grey">
					<label class="control-label">Office Stocks</label>
					<div class="office_table">
                   	<table class="table table-striped table-bordered table-hover flip-content table-condensed">
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
					  //The data for blow table will be fetched form tbl_stock according to the part selected from the second drop-down in above form
					  $query = $this->db->query("select * from tbl_offices");
					  $result = $query->result_array();
					  foreach($result as $office)
					  {
						echo '<td>';
						if($this->uri->segment(3)!='' || $p!=""){
						if($this->uri->segment(3)!='') echo '<input type="hidden"  name="ur_id" id="ur_id" value="'.$this->uri->segment(3).'">';
						  $stock = $this->db->query("select SUM(stock) AS stock from tbl_stock where fk_office_id = '".$office['pk_office_id']."' AND fk_part_id='".$result1[0]['pk_part_id']."' AND (dc_type='out' OR (dc_type='in' AND in_status='approved'))");
						 $stock_result = $stock->result_array();
						  if ($stock_result[0]['stock']!=0)
							echo $stock_result[0]['stock'];
						  else
							  echo '0';
						}
						else echo '<input type="hidden"  name="ur_id" id="ur_id" value="z">';
                      echo '</td>';
					 }?>
                    </tr>
                </table>
						</div>
                    </div>
                  </div>
     </div> <!-- end of row -->
	<div class="row bg-blue-steel">           
				<div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Stock Location</label>
                        <select class="form-control" name="stock_location" required>
                        	<option value="">---Choose---</option>
							<?php 
								  $query = $this->db->query("select * from tbl_offices");
								  $result = $query->result_array();
								  foreach($result as $vendor)
								  {
							?>
                            		<option value="<?php echo $vendor['pk_office_id']?>" <?php if ($off != "" && $off==$vendor['pk_office_id']) echo 'selected="selected"'; ?>><?php echo $vendor['office_name']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
	</div> <!-- end of row -->
	<div class="row bg-yellow-gold">

				<div class="col-md-6">
				<div class="form-group">
                    <label class="control-label">Comments</label> <br/>
                       <textarea name="comments" class="input-xlarge" id="comments" rows="4" ></textarea>
                    </div>
                </div>
				
				
		
				
	</div>			
				</div> <!-- end of form -->
				
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
					
					$('#old_inventory_description').val('');
					$('#equipment_serial').val('').change();
					/*
					$('#invoice_date').val('');
					$('#invoice_number').val('');
					$('#order_number').val('').change();
					*/
					
					$('#invoice_date').attr('required', 'required');
					$('#invoice_number').attr('required', 'required');
					$('#order_number').attr('required', 'required');
                    
                    }
				else if(locations=="Warranty Claim"){
					document.getElementById('import_warranty').style.display = 'block';
					document.getElementById('equipment_serial_div').style.display = 'block';
                    document.getElementById('description').style.display = 'none';
					
					$('#old_inventory_description').removeAttr('required');
					$('#old_inventory_description').val('');
					/*
					$('#invoice_date').val('');
					$('#invoice_number').val('');
					$('#order_number').val('').change();
					*/
					
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
					
					$('#invoice_date').val('');
					$('#invoice_number').val('');
					$('#order_number').val('').change();
					$('#equipment_serial').val('').change();
					
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
<style>
textarea {
	color:black; 
}
</style>