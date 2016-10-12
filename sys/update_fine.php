<?php $this->load->view('header');?>
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title">
      Explanation Call - Update
      </h3>
      <div class="page-bar">
          <ul class="page-breadcrumb">
              <li>
                  <i class="fa fa-home"></i>
                  Home 
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  Explanation Calls
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  Update
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

              <div class="caption"> <i class="fa fa-globe"></i>Explanation Call - Update</div>

             

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/update_fine_insert">
           <?php
            $quw="SELECT tbl_fine.*,user.first_name,tbl_fine_code.description 
				from tbl_fine
				LEFT JOIN user ON user.id = tbl_fine.fk_employee_id
				LEFT JOIN tbl_fine_code ON tbl_fine_code.pk_fine_code_id = tbl_fine.fk_fine_code_id
				where pk_fine_id='".$this->uri->segment('3')."'";
			$ghw=$this->db->query($quw);
			$value=$ghw->result_array();
		   ?>
            <div class="form-body">
				<div class="form-group">
                    <label class="col-md-3 control-label">Employee Name</label>
                    <div class="col-md-8">
                        <label class="control-label"><?php echo $value[0]['first_name']; ?></label>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-md-3 control-label">Code</label>
                    <div class="col-md-8">
                        <label class="control-label"><?php echo $value[0]['description']; ?></label>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-md-3 control-label">Date</label>
                    <div class="col-md-8">
                        <label class="control-label"><?php echo date('d-M-Y',strtotime($value[0]['date'])); ?></label>
                    </div>
                </div>
                
                <?php if($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin') {?>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Official Comments</label>
                    <div class="col-md-8">
                        <textarea name="comments" class="input-xlarge" id="comments" rows="5" required><?php echo urldecode($value[0]['comments']);?></textarea>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-3 control-label">Employee Comments</label>
                    <div class="col-md-8">
                        <textarea  class="input-xlarge" id="comments_employee" rows="5" readOnly><?php echo urldecode($value[0]['comments_employee']);?></textarea>
					   <!--<label class="control-label"><?php echo trim(urldecode($value[0]['comments_employee'])); ?></label>-->
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-3 control-label">Status</label>
                    <div class="col-md-8">
                       <select class="form-control  " name="status" id="status" required>
                        <option value="">--Choose--</option>
						
                        <option value="Pending" <?php if($value[0]['status']=='Pending'){ echo 'selected'; } ?>>Pending</option>
                        <option value="Charged" <?php if($value[0]['status']=='Charged'){ echo 'selected'; } ?>>Charged</option>
                        <option value="Discarded" <?php if($value[0]['status']=='Discarded'){ echo 'selected'; } ?>>Discarded</option>
                      </select>
                    </div>
                </div>
                <?php
				}
				else {
				?>
				<div class="form-group">
                    <label class="col-md-3 control-label">Official Comments</label>
                    <div class="col-md-8">
                        <label class=" control-label"><?php echo urldecode($value[0]['comments']);?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Employee Comments</label>
                    <div class="col-md-8">
                        <textarea name="comments_employee" class="input-xlarge" id="comments_employee" rows="5" required><?php echo urldecode($value[0]['comments_employee']);?></textarea>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-md-3 control-label">Status</label>
                    <div class="col-md-8">
                        <label class=" control-label"><?php echo $value[0]['status'];?></label>
                    </div>
                </div>
                <?php
				}
				?>
                <div class="form-actions">
                <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <input type="hidden" name="pk_fine_id" value="<?php echo $value[0]['pk_fine_id']; ?>" />
                    <button type="submit" class="btn btn-circle blue">Submit</button>
                <!--    <button type="button" class="btn btn-circle default">Cancel</button> -->
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