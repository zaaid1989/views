<?php $this->load->view('header');
if ($this->uri->segment('3'))
 echo "";
else show_404();
?>
<?php

/* 
7 values will be posted from this form
=====================================
stock location, receiver name, part condition and comments will be entered by user

part id, equipment serial and fk_complaint_id will be automatically picked based on the stock id in uri segment 3

for display purposes we need to show product name and part number
Important: Parts Received with No in status are the ones faulty or doubtful

Update (8th Sept 2016):
Another entry will be done through this form, it will be the stock id against which the part received back is being entered
*/ 

?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Add Part Received
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Parts Changed Report
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Add Part Received
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">

        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <?php
                            if(isset($_GET['upt']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        Business Project Updated Successfully.  
                                      </div>';
                              }
                          ?>
                    
		
          <div class="portlet box green-seagreen">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-edit"></i>Add Part Received</div>
              <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/add_part_received">
            <div class="form-body">
			<?php 
				$stock_id=$this->uri->segment('3');
				$zquery="select tbl_stock.*,tbl_products.product_name,tbl_instruments.*, tbl_parts.part_number,tbl_sprf.part_source,tbl_complaints.ts_number,tbl_clients.client_name
						from tbl_stock
						LEFT JOIN tbl_parts ON tbl_stock.fk_part_id = tbl_parts.pk_part_id
						LEFT JOIN tbl_instruments ON tbl_stock.equipment_serial = tbl_instruments.serial_no
						LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
						LEFT JOIN tbl_sprf ON tbl_stock.fk_sprf_id=tbl_sprf.pk_sprf_id
						LEFT JOIN tbl_complaints ON tbl_stock.fk_complaint_id=tbl_complaints.pk_complaint_id
						LEFT JOIN tbl_clients ON tbl_clients.pk_client_id=tbl_complaints.fk_customer_id
						WHERE pk_stock_id='" .$stock_id."' ";
						$ty=$this->db->query($zquery);
						$rt=$ty->result_array();
				$part_number=$rt[0]['part_number'];
				$fk_part_id=$rt[0]['fk_part_id'];
				$equipment=$rt[0]['product_name'];
				//$date=date('d-M-Y',strtotime($rt[0]['Date']));
				$equipment_serial = $rt[0]['equipment_serial'];
				$fk_complaint_id = $rt[0]['fk_complaint_id'];
				$ts_number = $rt[0]['ts_number'];
				$client_name = $rt[0]['client_name'];								$installed_part_source = $rt[0]['part_source'];
			
			?>
				<input type="hidden" name="fk_part_id" value="<?php echo $fk_part_id;?>" />
				<input type="hidden" name="equipment_serial" value="<?php echo $equipment_serial;?>" />
				<input type="hidden" name="fk_complaint_id" value="<?php echo $fk_complaint_id;?>" />
				<input type="hidden" name="fk_stock_id" value="<?php echo $stock_id;?>" />
                <div class="row">	
						
						<div class="form-group">
                            <label class="col-md-3 control-label"> TS Number </label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $ts_number; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Client Name </label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $client_name; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Equipment</label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $equipment.' - '.$equipment_serial; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Part Number</label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $part_number; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Installed Part Source </label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $installed_part_source; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Condition of Received Part</label>
                            <div class="col-md-8">
								<select id="part_condition" name="part_condition" class="form-control" required>						<option value="">--Choose--</option>						<option value="Functional" <?php //if ($t != "" && $t=="Import") echo "selected='selected'"; ?>>Functional</option>						<option value="Faulty" <?php //if ($t != "" && $t=="Warranty Claim") echo "selected='selected'"; ?>>Faulty</option>						<option value="Doubtful" <?php //if ($t != "" && $t=="Old Inventory") echo "selected='selected'"; ?>>Doubtful</option>					  </select>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Stock Location</label>
                            <div class="col-md-8">								<select id="stock_location" name="stock_location" class="form-control" required>
								<option value="">---Choose---</option>							<?php 								  $query = $this->db->query("select * from tbl_offices");								  $result = $query->result_array();								  foreach($result as $vendor)								  {							?>                            		<option value="<?php echo $vendor['pk_office_id']?>" <?php //if ($off != "" && $off==$vendor['pk_office_id']) echo 'selected="selected"'; ?>><?php echo $vendor['office_name']?></option>                            <?php }?>								</select>
                            </div>
                        </div>

						<div class="form-group">
                            <label class="col-md-3 control-label">Receiver Name</label>
                            <div class="col-md-4">
                                    <input type="text" class="form-control" name="receiver_name" required/>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label"> Comments</label>
                            <div class="col-md-8">
                                <textarea name="comments" class="input-xlarge" id="tactics" rows="5" ></textarea>
                            </div>
                        </div>
						
                </div>
              
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-3 col-md-9">
				<input type="hidden" name="strategy_status" value="<?php if ($this->session->userdata('userrole')=="Admin") echo "1"; else echo "0";?>" />
				<input type="hidden" name="fk_project_id" value="<?php echo $this->uri->segment('3'); ?>" />
				<?php
						echo '<input type="hidden" name="redirect_edit_strategy" value="'.$this->uri->segment('2').'" />';
						echo '<button type="submit" class="btn default yellow-crusta">';
						echo 'Submit </button>';
								
				?>
                </div>
              </div>
            </div>
           </div>
           </form>
           </div>
          </div>
          
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>