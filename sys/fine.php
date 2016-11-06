<?php $this->load->view('header');?>
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title">
      Fine <small>Fine Codes</small>
      </h3>
      <div class="page-bar">
          <ul class="page-breadcrumb">
              <li>
                  <i class="fa fa-home"></i>
                  Home
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  Fines
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  Fine Codes
              </li>
          </ul>
        
      </div>
      <!-- END PAGE HEADER--> 
      <!-- BEGIN PAGE CONTENT-->
      <div class="row">
        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		  <?php
          if(isset($_GET['msg']))
            { 
              echo '<div class="alert alert-success alert-dismissable">  
                      <a class="close" data-dismiss="alert">×</a>  
                      DVR Entered Successfully.  
                    </div>';
            }
          ?>
          <div class="portlet box grey-cascade">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Fines</div>

              <div class="tools"> 
                  <a href="javascript:;" class="collapse"> </a> 
                  
                  <a href="javascript:;" class="remove"> </a> 
              </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/insert_fine">
        	<input type="hidden" name="engineer_dvr_form" value="engineer_dvr_form" />
            <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
            <div class="form-body">

                <div class="form-group">
                    <label class="col-md-3 control-label">Date</label>
                    <div class="col-md-8">
                        <input type="text" class="datepicker2 form-control" name="date" required/>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-md-3 control-label">Employee</label>

                    <div class="col-md-8">
                      <select class="form-control  " name="employee" id="employee" required>
                        <option value="">--Choose--</option>
                        <?php $quw="SELECT * from user  where delete_status = '0' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
						if ( $this->session->userdata('userrole')=='Supervisor')
							$quw="SELECT * from user  where delete_status = '0' AND FIND_IN_SET_X('".$this->session->userdata('territory')."',fk_office_id) AND userrole='FSE' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
                          $ghw=$this->db->query($quw);
                          $rtw=$ghw->result_array();
                          foreach($rtw as $value)
                            {
                                ?>
                                <option value="<?php echo $value['id'];?>"><?php echo $value['first_name'];?></option>
                                <?php
                            }?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Fine</label>
                    <div class="col-md-8">
                       <select class="form-control  " name="fine" id="fine" required onchange="show_amount(this.value)">
                        <option value="">--Choose--</option>
                        <?php $quw="SELECT * from tbl_fine_code ORDER BY `fine_code` ASC ";
                          $ghw=$this->db->query($quw);
                          $rtw=$ghw->result_array();
                          foreach($rtw as $value)
                            {
                                ?>
                                <option value="<?php echo $value['pk_fine_code_id'];?>"><?php echo substr($value['description'], 0, 80);?></option>
                                <?php
                            }?>
                      </select>
                    </div>
                </div>
                <script>
				function show_amount(fine_id)
				{
					var formdata =
					  {
						fine_id: fine_id
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/select_fine_amount_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$("#amount").val(msg);
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

                    <div class="col-md-8">
                            <input class="form-control" name="amount" id="amount" required>
                    </div>

                </div>
                
                <div class="form-group">

                    <label class="col-md-3 control-label">Comments</label>

                    <div class="col-md-8">

                        <textarea name="comments" class="input-xlarge" id="comments" rows="5" required></textarea>

                    </div>

                </div>
                <div class="form-actions">
      <div class="row">
        <div class="col-md-offset-5 col-md-9">
          <button type="submit" class="btn btn-circle blue" onclick="return check_amount();">Submit</button>
     <!--     <button type="button" class="btn btn-circle default">Cancel</button>	-->
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