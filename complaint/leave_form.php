<?php $this->load->view('header');
	  if($this->uri->segment(3)!='')
	  {
		  $query = $this->db->query("SELECT * FROM tbl_temporary_leaves WHERE pk_temporary_leave_id='".$this->uri->segment(3)."'");
		  $res   = $query->result_array();
	  }
?>
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
                  <a href="<?php echo base_url();?>complaint/all_leaves">All Leaves</a>
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  Leave Form
              </li>
          </ul>
        
      </div>
       <p class="alert alert-danger" style="font-size:16px;">NOTE: Approval of any leave is mandatory.You can not avail any leave until it is permitted by administration</p>
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
                      Leave Entered Successfully.  
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
		   <div class="portlet-body form">
           <form class="form-horizontal form-bordered form-row-stripped" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>complaint/insert_leave" onSubmit="return confirm('Approval of any leave is mandatory.You can not avail any leave until it is permitted by administration');">
            <div class="form-body">

                <div class="form-group">
                    <label class="col-md-3 control-label">Employee</label>
                    <div class="col-md-4">
                      <select class="form-control" name="employee" id="employee" onchange="show_amount(this.value)" required <?php  if(isset($res[0]['pk_temporary_leave_id'])){?> disabled <?php }?>> <!-- onchange="show_leaves_remaining(this.value)" -->
                        <option value="">--Choose--</option>
                        <?php $quw="SELECT * from user  where delete_status = '0' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
                          $ghw=$this->db->query($quw);
                          $rtw=$ghw->result_array();
                          foreach($rtw as $value)
                            {
                                ?>
                                <option value="<?php echo $value['id'];?>" <?php if(isset($res[0]['pk_temporary_leave_id'])){ if($value['id']==$res[0]['fk_employee_id']) { echo "selected";} }?>>
									<?php echo $value['first_name'];?>
                                </option>
                                <?php
                            }?>
                      </select>
                       <?php  if(isset($res[0]['pk_temporary_leave_id'])){?> 
                       <input type="hidden" name="employee" value="<?php echo $res[0]['fk_employee_id'];?>" />
                       <input type="hidden" name="temprary_id" value="<?php echo $this->uri->segment(3);?>" />
                        <?php }?>
                    </div>
                    <label class="control-label">
                    <span id="remaining_leaves">
                    	<?php if(isset($res[0]['pk_temporary_leave_id'])){
									$query2 = $this->db->query("SELECT * FROM user WHERE id='".$res[0]['fk_employee_id']."'");
		  							$res2   = $query2->result_array();
									$tot_leaves = $res2[0]['total_leaves'];
									echo "Total Leaves = ".$tot_leaves; 
								  }?>
                    </span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Leave Type</label>
                    <div class="col-md-4">
                      <select class="form-control" name="leave_type" id="leave_type" required onchange="show_amount(this.value)">
                            <option value="0" <?php if(isset($res[0]['pk_temporary_leave_id'])){ if('0'==$res[0]['leave_type']) { echo "selected";} }?>>
                            	Full Day
                            </option>
                            <option value="1" <?php if(isset($res[0]['pk_temporary_leave_id'])){ if('1'==$res[0]['leave_type']) { echo "selected";} }?>>
                            	Half Day
                            </option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Application Date</label>
                    <div class="col-md-4">
                        <input type="text" class="datepicker2 form-control application_date" name="application_date" value="<?php if(isset($res[0]['pk_temporary_leave_id'])){ echo date('d-M-Y', strtotime($res[0]['application_date'])); }?>" required onchange="show_amount(this.value)" />
						<span class="help-block">Leave Application Submission Date</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Start Date</label>
                    <div class="col-md-4">
                        <input type="text" class="datepicker2 form-control start_date" name="start_date" value="<?php if(isset($res[0]['pk_temporary_leave_id'])){ echo date('d-M-Y', strtotime($res[0]['start_date'])); }?>" required onchange="show_amount(this.value)" />
						<span class="help-block">Leave Period Start Date</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">End Date</label>
                    <div class="col-md-4">
                        <input type="text" class="datepicker2 form-control end_date" name="end_date" value="<?php if(isset($res[0]['pk_temporary_leave_id'])){ echo date('d-M-Y', strtotime($res[0]['end_date'])); }?>" required onchange="show_amount(this.value)" />
						<span class="help-block">Leave Period End Date</span>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-md-3 control-label">Reason of Leave</label>

                    <div class="col-md-8">

                        <textarea name="reason_of_leave" class="input-xlarge" id="reason_of_leave" rows="5" required><?php if(isset($res[0]['pk_temporary_leave_id'])){ echo urldecode($res[0]['reason_of_leave']); }?></textarea>

                    </div>

                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Backup Person</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="backup_person" value="<?php if(isset($res[0]['pk_temporary_leave_id'])){ echo $res[0]['back_up']; }?>" required/>
						<span class="help-block">Type the name of Person who will provide cover</span>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-md-3 control-label">Official Comments</label>

                    <div class="col-md-8">

                        <textarea name="official_comments" class="input-xlarge" id="official_comments" rows="5" required></textarea>

                    </div>

                </div>
				
				<div id = "amountt">
                <div class="form-group">
                    <label class="col-md-3 control-label">Leave Code</label>
                    <div class="col-md-8">
					<?php if(isset($res[0]['leave_code']))echo $res[0]['leave_code']; ?>
                       <select class="form-control" name="fine" id="fine" required onchange="show_amount(this.value)" style="display:none;">
                        <option value="">--Choose--</option>
                        <?php $quw="SELECT * from tbl_fine_code";
                          $ghw=$this->db->query($quw);
                          $rtw=$ghw->result_array();
                          foreach($rtw as $value)
                            {
                                if($value['pk_fine_code_id']=='21' || $value['pk_fine_code_id']=='22' || $value['pk_fine_code_id']=='23')
								{
								?>
                                <option value="<?php echo $value['pk_fine_code_id'];?>" <?php if(isset($res[0]['fk_fine_code_id']) && ($res[0]['fk_fine_code_id']==$value['pk_fine_code_id'])){ echo "selected='selected'"; }?> >
								<?php echo substr($value['description'], 0, 80);?>
								</option>
                                <?php
								}
                            }?>
                            	<option value="Leave is taken within limit of 21 days" <?php if(isset($res[0]['fk_fine_code_id']) && ($res[0]['fk_fine_code_id']==0)){ echo "selected='selected'"; }?>>Leave is taken within limit of 21 days</option>
                      </select>
					  <!--<span class="help-block">Select Leave Code according to nature of Leave</span>-->
                    </div>
                </div>
				
				<div class="form-group">

                    <label class="col-md-3 control-label">Amount</label>

                    <div class="col-md-4">
                            <input class="form-control" name="amount" id="amount" value="<?php if(isset($res[0]['fine_amount'])){ echo $res[0]['fine_amount']; }?>" required readOnly>
							<span class="help-block">Amount that will be added as Exaplanation Call Charges</span>
                    </div>

                </div>
				</div>
                <script>
				function show_amount(fine_id)
				{
					$("#amountt").html("Loading .....");
					if(fine_id=='Leave is taken within limit of 21 days')
					{
						$("#amount").val('0');
						return false;
					}
					var application_date = $('.application_date').val();
					var start_date=$('.start_date').val();
					var end_date=$('.end_date').val();
					var employee=$('#employee').val();
					var leave_type=$('#leave_type').val();
					var formdata =
					  {
						application_date	 	 : application_date,
						fine_id	 	 : fine_id,
						start_date	 : start_date,
						end_date	 : end_date,
						leave_type	 : leave_type,
						employee 	 : employee
					  };
				  $.ajax({
					url: "<?php echo base_url();?>complaint/select_leave_code_amount_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$("#amountt").html(msg);
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
                
                <div class="form-actions">
                  <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                      <button type="submit" class="btn default green" onclick="return check_amount();">Approve</button><!--onclick="return check_amount();"-->
                   <!--   <a href="<?php echo base_url();?>complaint/all_leaves" class="btn default grey">Cancel</a> -->
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