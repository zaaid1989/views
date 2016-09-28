<?php $this->load->view('header');?>
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title">
      Leave Form
      </h3>
      <div class="page-bar">
          <ul class="page-breadcrumb">
              <li>
                  <i class="fa fa-home"></i>
                  Home 
                  <i class="fa fa-angle-right"></i>
              </li>
			  <li>
                  Leaves
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  Leave Form
              </li>
          </ul>
        
      </div>
      <!-- END PAGE HEADER--> 
      <!-- BEGIN PAGE CONTENT-->
      <div class="row">
        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		  <?php
            if(isset($_GET['msg'])) {
                if ($_GET['msg'] == 'success') {
                    echo '<div class="alert alert-success alert-dismissable">
                      <a class="close" data-dismiss="alert">×</a>  
                      Leave Updated Successfully.  
                    </div>';
                }
                if ($_GET['msg'] == 'already_exists') {
                    echo '<div class="alert alert-danger alert-dismissable">
                                  <a class="close" data-dismiss="alert">×</a>
                                  Another leave already exists for this date.
                                </div>';
                }
            }
          ?>
          <div class="portlet box blue">

            <div class="portlet-title">

              <div class="caption"> <i class="icon-screen-tablet"></i>Leave Form</div>

              <div class="tools"> 
                  <a href="javascript:;" class="collapse"> </a> 
                  
                  <a href="javascript:;" class="remove"> </a> 
              </div>

            </div>
			<?php
				  $data_query = $this->db->query("SELECT * FROM tbl_leaves where pk_leave_id='".$this->uri->segment(3)."'");
				  $data_result=$data_query->result_array();
			?>
		   <div class="portlet-body form">
           <form class="form-horizontal form-bordered form-row-stripped" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>complaint/update_leave">
            <div class="form-body">

                <div class="form-group">
                    <label class="col-md-3 control-label">Employee</label>
                    <div class="col-md-4">
                      <select class="form-control  " name="employee" id="employee" onchange="show_leaves_remaining(this.value)" required>
                        <option value="">--Choose--</option>
                        <?php $quw="SELECT * from user  where delete_status = '0' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
                          $ghw=$this->db->query($quw);
                          $rtw=$ghw->result_array();
                          foreach($rtw as $value)
                            {
                                ?>
                                <option value="<?php echo $value['id'];?>"
								<?php if($value['id']==$data_result[0]['fk_employee_id']){ echo 'selected="selected"';}?>>
								<?php echo $value['first_name'];?></option>
                                <?php
                            }?>
                      </select>
                    </div>
                    <label class="control-label"><span id="remaining_leaves"></span></label>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Leave Type</label>
                    <div class="col-md-4">
                      <select class="form-control" name="leave_type" id="leave_type" required>
                            <option value="0" <?php if($data_result[0]['leave_type']=="0"){ echo 'selected="selected"';}?>>Full Day</option>
                            <option value="1" <?php if($data_result[0]['leave_type']=="1"){ echo 'selected="selected"';}?>>Half Day</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Application Date</label>
                    <div class="col-md-4">
                        <input type="text" class="datepicker2 form-control" name="application_date" value="<?php echo date('d-M-Y', strtotime($data_result[0]['application_date'])); ?>" required/>
						<span class="help-block">Leave Application Submission Date</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Start Date</label>
                    <div class="col-md-4">
                        <input type="text" class="datepicker2 form-control start_date" name="start_date" value="<?php echo date('d-M-Y', strtotime($data_result[0]['start_date'])); ?>" required/>
						<span class="help-block">Leave Period Start Date</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">End Date</label>
                    <div class="col-md-4">
                        <input type="text" class="datepicker2 form-control end_date" name="end_date" value="<?php echo date('d-M-Y', strtotime($data_result[0]['end_date'])); ?>" required/>
						<span class="help-block">Leave Period End Date</span>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-md-3 control-label">Reason of Leave</label>

                    <div class="col-md-8">

                        <textarea name="reason_of_leave" class="input-xlarge" id="reason_of_leave" rows="5" required><?php echo urldecode($data_result[0]['reason_of_leave']);?></textarea>

                    </div>

                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Backup Person</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="backup_person" value="<?php echo $data_result[0]['back_up']; ?>" required/>
						<span class="help-block">Type the name of Person who will provide cover</span>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-md-3 control-label">Official Comments</label>

                    <div class="col-md-8">

                        <textarea name="official_comments" class="input-xlarge" id="official_comments" rows="5" required><?php echo urldecode($data_result[0]['official_comments']);?></textarea>

                    </div>

                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Fine Code</label>
                    <div class="col-md-8">
                       <select class="form-control" name="fine" id="fine" required onchange="show_amount(this.value)">
                        <option value="">--Choose--</option>
                        <?php $quw="SELECT * from tbl_fine_code";
                          $ghw=$this->db->query($quw);
                          $rtw=$ghw->result_array();
                          foreach($rtw as $value)
                            {
                                if($value['pk_fine_code_id']=='21' || $value['pk_fine_code_id']=='22' || $value['pk_fine_code_id']=='23')
								{
								?>
                                <option value="<?php echo $value['pk_fine_code_id'];?>" 
								<?php if($value['pk_fine_code_id']==$data_result[0]['fk_fine_code']){ echo 'selected="selected"';}?>>
								<?php echo substr($value['description'], 0, 80);?></option>
                                <?php
								}
                            }?>
                            	<option value="Leave is taken within limit of 21 days" <?php if($data_result[0]['fk_fine_code']=="Leave is taken within limit of 21 days"){ echo 'selected="selected"';}?>>Leave is taken within limit of 21 days</option>
                      </select>
					  <span class="help-block">Select Fine Code according to nature of Leave</span>
                    </div>
                </div>
                <script>
				function show_amount(fine_id)
				{
					if(fine_id=='Leave is taken within limit of 21 days')
					{
						$("#amount").val('0');
						return false;
					}
					var start_date=$('.start_date').val();
					var end_date=$('.end_date').val();
					var employee=$('#employee').val();
					var leave_type=$('#leave_type').val();
					var formdata =
					  {
						fine_id	 	 : fine_id,
						start_date	 : start_date,
						end_date	 : end_date,
						leave_type	 : leave_type,
						employee 	 : employee
					  };
				  $.ajax({
					url: "<?php echo base_url();?>complaint/select_fine_amount_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$("#amount").val(msg);
						}
					})
					return false;
				}
				function show_leaves_remaining(employee_id)
				{
					//alert(employee_id);
					var formdata =
					  {
						employee_id	 	 : employee_id
					  };
				  $.ajax({
					url: "<?php echo base_url();?>complaint/select_remaining_leaves_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$("#remaining_leaves").html(msg);
						}
					})
					return false;
				}
				function check_amount()
				{
					var test=document.getElementById("amount").value;
					//var test="zaaid";
					if (isNaN(test))
					{
						alert('Amount is not a numeric number.');
						return false;
					}
					else
						return true;										
				}
				
				</script>
                <div class="form-group">

                    <label class="col-md-3 control-label">Amount</label>

                    <div class="col-md-4">
                            <input class="form-control" name="amount" id="amount" value="<?php echo $data_result[0]['amount']; ?>" required>
							<span class="help-block">Amount that will be added as Fine</span>
                    </div>

                </div>
				<input type="hidden" name="leave_id" value="<?php echo $this->uri->segment(3);?> ">
				<input type="hidden" name="leave_fine_id" value="<?php echo $data_result[0]['fk_fine_id'];?> ">
                <div class="form-actions">
                  <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                      <button type="submit" class="btn default green" onclick="return check_amount();">Submit</button><!--onclick="return check_amount();"-->
                <!--      <a href="<?php echo base_url();?>complaint/all_leaves" class="btn default grey">Cancel</a> -->
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