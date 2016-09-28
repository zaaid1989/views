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
      <p class="alert alert-danger" style="font-size:16px;">NOTE: Approval of any leave is mandatory. You cannot avail any leave until it is permitted by administration</p>
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

              <div class="caption"> <i class="icon-screen-tablet"></i>Leave Form </div>

              <div class="tools"> 
                  <a href="javascript:;" class="collapse"> </a> 
                
                  <a href="javascript:;" class="remove"> </a> 
              </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal form-bordered form-row-stripped" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>complaint/insert_temporary_leaves" onsubmit="return checkForm(this);">
		   <!--onSubmit="return confirm('Approval of any leave is mandatory.You can not avail any leave until it is permitted by administration');"-->
            <div class="form-body">

                      <input type="hidden" class="form-control" name="employee" id="employee" value="<?php echo $this->session->userdata('userid')?>">
                    <span id="remaining_leaves"></span>
                <div class="form-group">
                    <label class="col-md-3 control-label">Leave Type</label>
                    <div class="col-md-4">
                      <select class="form-control" name="leave_type" id="leave_type" onchange="show_amount(this.value)" required>
                            <option value="0">Full Day</option>
                            <option value="1">Half Day</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Application Date</label>
                    <div class="col-md-4">
                        <input type="text" class=" form-control application_date" name="application_date" value="<?php echo date('d-M-Y')?>" required readOnly />
						<span class="help-block">Leave Application Submission Date</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Start Date</label>
                    <div class="col-md-4">
                        <input type="text" class="datepicker2 form-control start_date" name="start_date" onchange="show_amount(this.value)" required/>
						<span class="help-block">Leave Period Start Date</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">End Date</label>
                    <div class="col-md-4">
                        <input type="text" class="datepicker2 form-control end_date" name="end_date" onchange="show_amount(this.value)" required/>
						<span class="help-block">Leave Period End Date</span>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-md-3 control-label">Reason of Leave</label>

                    <div class="col-md-8">

                        <textarea name="reason_of_leave" class="input-xlarge" id="reason_of_leave" rows="5" required></textarea>

                    </div>

                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Backup Person</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="backup_person" required/>
						<span class="help-block">Type the name of Person who will provide cover</span>
                    </div>
                </div>
				<div id = "amountt">
				<div class="form-group">
                    <label class="col-md-3 control-label">Leave Code</label>
                    <div class="col-md-8">
							<h3></h3>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-3 control-label">Amount</label>
                    <div class="col-md-8">
                            <h3></h3>
                    </div>
                </div>
                </div>
				
				<div class="form-group">
					<label class="control-label col-md-3"></label>
					<div class="col-md-9">
						<div class="checkbox">
							<label>
							<input type="checkbox" value="anc" id="terms"> By submitting the form I hereby confirm to accept the amount charged against leave code. </label>
						</div>
					</div>
				</div>
				<!--
				<div class="form-group">
					<label class="control-label col-md-3">By submitting the form I hereby confirm to accept the amount charged against leave code.</label>
					<div class="col-md-9">
						<input type="checkbox" id="terms" class="make-switch" data-on-text="Yes" data-off-text="No" data-on-value="Yes">
					</div>
				</div> -->
                <script>
				/*
				function checkForm(form)
				  {
					...
					if(!form.terms.checked) {
					  alert("Please indicate that you accept the Terms and Conditions");
					  form.terms.focus();
					  return false;
					}
					return true;
				  }*/
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
					if (!$('#terms').is(":checked")) {
					  alert("You must confirm to accept the leave code and charged amount before submitting the form.");
					  return false;
					}
					//alert('checked');
					return true;									
				}
				
				</script>
                
                <div class="form-actions">
                  <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                      <button type="submit" class="btn default green" onclick="return check_amount();">Submit</button><!--onclick="return check_amount();"-->
                     <!-- <a href="<?php echo base_url();?>complaint/all_leaves" class="btn default grey">Cancel</a> -->
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