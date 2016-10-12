<?php $this->load->view('header');
function myDate($time){
  if($time == '0000-00-00 00:00:00')
     return "";
  return date("d-M-Y", strtotime($time));
}
function dispzero($val) {
	if ($val=="" || $val==0) return '-';
	else return $val;
}
?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Spare Part   <small>Order </small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home  <i class="fa fa-angle-right"></i> </li>

          <li> Spare Parts <i class="fa fa-angle-right"></i> </li>

          <li> Create Order   </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->
	  <?php
	  if(isset($_GET['msg']) && $_GET['msg']=='success')
		{ 
		  echo '<div class="alert alert-success alert-dismissable">  
				  <a class="close" data-dismiss="alert">×</a>  
				  Order saved.  
				</div>';
		}
		
		if(isset($_GET['msg']) && $_GET['msg']=='order')
		{ 
		  echo '<div class="alert alert-success alert-dismissable">  
				  <a class="close" data-dismiss="alert">×</a>  
				  Order saved.  
				</div>';
		}
	  
	  ?>
	  
	  

      <div class="row">

        <div class="col-md-12">

                <div class="portlet box green-seagreen">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Spare Part Order</div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form">
			  
                  
                  <?php
					  
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>sys/spare_part_order_insert" class="form-horizontal" method="post"  enctype="multipart/form-data">
                <div class="form-body">
				<div class="">
				<!--
	  <h3>
	  <label class="label bg-red">Work is being done on this page. Kindly don't make any entries as long as this message appears.</label>
	  </h3>
	  -->
	</div>	
				<div class="form-group">
                  <div class="col-md-4  col-md-offset-3 office_table">
                   	<table class="table table-striped table-bordered table-hover flip-content">
                	<tr>
						<th> MSQ </th>
						<th> Balance </th>
						<th> Requisition - MSQ </th>
						<th> Requisition - SPRF </th>
						<th> Quantity Ordered Already </th>
                    </tr>
                    <!---->
					<?php 
					$stock_total=0;
					$stock_demand=0;
					$stock_demand_aggregate=0;
					$demand_detail = "";
					$parts_query="SELECT `pk_part_id`, `fk_instrument_id`, `fk_vendor_id`, `fk_product_id`, `part_name`, `part_number`, `order_status`, `description`, `stock_quantity`, `minimum_quantity`, `unit_price`, `comments`, `image`, vendor_name, product_name FROM `tbl_parts` 
								INNER JOIN tbl_vendors ON tbl_parts.fk_vendor_id = tbl_vendors.pk_vendor_id 
								INNER JOIN tbl_products ON tbl_parts.fk_product_id = tbl_products.pk_product_id WHERE pk_part_id='".$this->uri->segment(3)."'";
								
								$ty22=$this->db->query($parts_query);
								$rt22=$ty22->result_array();
								if (sizeof($rt22) == "0") {} 
								else {
								  foreach ($rt22 as $get_users_list) {
									  // for finding total stock
										$stock_total=0;
										$stock_demand=0;
										$stock_demand_aggregate=0;
										
										//*********total stock */
										$stock = $this->db->query("select SUM(stock) AS stock_sum from tbl_stock where  fk_part_id='".$get_users_list['pk_part_id']."'");
										  if($stock->num_rows()>0) {
											  $stock_result = $stock->result_array();
											  $stock_total = $stock_result[0]['stock_sum'];
										  }
										  
										  $qd = $this->db->query("SELECT fk_part_id, SUM(quantity) AS demand FROM `tbl_sprf` WHERE status=0 AND fk_part_id = '".$get_users_list['pk_part_id']."' GROUP BY fk_part_id");
                                          $rd = $qd->result_array();
										  if (sizeof($rd)>0)
												$stock_demand = $rd[0]['demand'];
										  if ($stock_demand>0) 
												$stock_demand_aggregate=$stock_demand - $stock_total;
										  
										  if($stock_total>=$get_users_list["minimum_quantity"] && $stock_demand_aggregate<=0) continue;
										  
										//demand detail string  
										  $demand_detail = "";
										  $qd = $this->db->query("SELECT `tbl_sprf`.fk_complaint_id,`tbl_sprf`.quantity, `tbl_clients`.client_name,`tbl_complaints`.ts_number
											FROM `tbl_sprf` 
											LEFT JOIN tbl_complaints ON `tbl_sprf`.fk_complaint_id = `tbl_complaints`.pk_complaint_id
											LEFT JOIN tbl_clients ON `tbl_clients`.pk_client_id = `tbl_complaints`.fk_customer_id
											WHERE `tbl_sprf`.status=0 AND `tbl_sprf`.fk_part_id = '".$get_users_list['pk_part_id']."'");
                                          $rd = $qd->result_array();
										  if (sizeof($rd)>0) foreach ($rd AS $dd) {
													$demand_detail .= $dd['quantity'].' ('.$dd['client_name'].' - '.$dd['ts_number'].'), ';
												}
										//Quantity Ordered
										$order_quantity = "";		
										$qd = $this->db->query("SELECT * from tbl_orders
											WHERE status=1 AND fk_part_id = '".$get_users_list['pk_part_id']."' ORDER BY date ASC");
                                          $rd = $qd->result_array();
										  if (sizeof($rd)>0)
												foreach ($rd AS $dd) {
													$order_quantity .= '<span title="'.$dd['order_number'].' - '.date('d-M-Y',strtotime($dd['date'])).'">'.$dd['order_quantity'].'</span> + ';
												}
										?>
										<tr>
											<td class="font-red" align="center">
											  <?php echo dispzero($get_users_list["minimum_quantity"]);?>
											</td>
											
											<td style="font-weight:bold;" align="center"> <!-- Stock -->
											  <?php echo dispzero($stock_total);?>
											</td>
											
											<td align="center"> <!-- Orders -->
												<?php echo dispzero($get_users_list["minimum_quantity"]-$stock_total);?>
											</td>
											
											<td align="center">
											<?php if ($stock_demand_aggregate>0) echo '<span title="'.$demand_detail.'">'.$stock_demand_aggregate.'</span>'; 
											else echo '-';?>
											</td>
											
											<td align="center"> <!-- Order Status -->
												<?php if ($order_quantity != "") echo substr($order_quantity,0,-2); else echo '-';?>
											</td>
									</tr>
<?php										
/*  */                                     } 
								}  
									?>
                </table>
                    </div>
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
					url: "<?php echo base_url();?>sys/part_number_select",
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
					url: "<?php echo base_url();?>sys/select_description",
					type: 'POST',
					data: formdata2,
					success: function(msg){
						$("#part_description").val(msg);
						$('select').select2();
						}
					})
					$.ajax({
					url: "<?php echo base_url();?>sys/office_table_ajax_two",
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
					<label class="col-md-3 control-label">Date</label>
					<div class="col-md-4">
					  <input type="text" class="form-control datepicker" name="date" id="date" value="<?php echo date('d-M-Y');?>" required>
					</div>
				  </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Order Number</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="order_number" id="order_number" required>
                       
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-md-3 control-label">Order Quantity</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="order_quantity" id="order_quantity" required>
                       
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
                                    <button type="submit" class="btn default yellow-zed">Add Order</button>
									
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

 

<?php if($this->uri->segment(3)=='') { /* ?>
<div class="row">
          <div class="col-md-12"> 
            <!-- BEGIN CURRENT DC TABLE PORTLET-->
        <!--    <div class="portlet box green-sharp">-->
			<div class="portlet light bg-inverse">
              <div class="portlet-title">
                <div class="caption font-red-intense"> <i class="icon-bar-chart font-red-intense"></i>Current DC</div>
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
						  WHERE tbl_stock.in_status = 'pending_approval' AND tbl_stock.dc_type = 'in' ORDER BY tbl_stock.pk_stock_id");
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
									  <td> <?php echo $dc_entry['invoice_number']; ?> </td>
									  <td> <?php echo myDate($dc_entry['invoice_date']); ?> </td>
									  <td> <?php echo $dc_entry['equipment_serial']; ?> </td>
									  <td> <?php echo $dc_entry['stock']; ?> </td>
									  <td> <?php echo $dc_entry['office_name']; ?> </td>
									  <td>
										  <a class="btn btn default red-thunderbird"  
										  href="<?php echo base_url();?>sys/delete_stock/<?php echo $dc_entry["pk_stock_id"]; ?>"
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
						  href="<?php echo base_url();?>sys/approve_dc/"
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
        





 </div>
<?php */ } ?>
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


$('#stock_type').on("change",function(){
                var locations = $(this).val();
                if(locations=="Import"){
                    document.getElementById('import_warranty').style.display = 'block';
                    document.getElementById('description').style.display = 'none';
					
					$('#old_inventory_description').removeAttr('required');
					
					$('#invoice_date').attr('required', 'required');
					$('#invoice_number').attr('required', 'required');
                    
                    }
				else if(locations=="Warranty Claim"){
					document.getElementById('import_warranty').style.display = 'block';
					document.getElementById('equipment_serial_div').style.display = 'block';
                    document.getElementById('description').style.display = 'none';
					
					$('#old_inventory_description').removeAttr('required');
					
					$('#invoice_date').attr('required', 'required');
					$('#invoice_number').attr('required', 'required');
					$('#equipment_serial').attr('required', 'required');
		
                }
                else if(locations=="Old Inventory"){
					document.getElementById('description').style.display = 'block';
					document.getElementById('import_warranty').style.display = 'none';
					
					$('#invoice_date').removeAttr('required');
					$('#invoice_number').removeAttr('required');
					
					$('#old_inventory_description').attr('required', 'required');
		
                }
                else{
                    document.getElementById('description').style.display = 'none';
                    document.getElementById('import_warranty').style.display = 'none';
					
					$('#invoice_date').removeAttr('required');
					$('#invoice_number').removeAttr('required');
					$('#old_inventory_description').removeAttr('required');
					
                    }
                });
</script>