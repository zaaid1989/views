<?php $this->load->view('header');?>
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title">
      Update <small>Warning Letter</small>
      </h3>
      <div class="page-bar">
          <ul class="page-breadcrumb">
              <li>
                  <i class="fa fa-home"></i>
                  Home
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  Warning Letter
                  <i class="fa fa-angle-right"></i>
              </li>
          </ul>
        
      </div>
      <!-- END PAGE HEADER--> 
      <!-- BEGIN PAGE CONTENT-->
      <div class="row">
        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box grey-cascade">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Warning Letter</div>

              <div class="tools"> 
                  <a href="javascript:;" class="collapse"> </a> 
                  
                  <a href="javascript:;" class="remove"> </a> 
              </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/update_warning_letter_insert">
           <?php
            $quw="SELECT * from tbl_warning_letters where pk_warning_letter_id='".$this->uri->segment('3')."'";
			$ghw=$this->db->query($quw);
			$value=$ghw->result_array();
		   ?>
            <div class="form-body">
                
                <?php if($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin') {?>
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
                <div class="form-group">
                    <label class="col-md-3 control-label">Official Comments</label>
                    <div class="col-md-8">
                        <textarea name="official_comments" class="input-xlarge" id="official_comments" rows="5" required><?php echo urldecode($value[0]['official_comments']);?></textarea>
                    </div>
                </div>
                <?php
				}
				else
				{
				?>
                <div class="form-group">
                    <label class="col-md-3 control-label">Employee Comments</label>
                    <div class="col-md-8">
                        <textarea name="employee_comments" class="input-xlarge" id="employee_comments" rows="5" required><?php echo urldecode($value[0]['employee_comments']);?></textarea>
                    </div>
                </div>
                <?php
				}
				?>
                <div class="form-actions">
                <div class="row">
                  <div class="col-md-offset-5 col-md-9">
                    <input type="hidden" name="pk_warning_letter_id" value="<?php echo $value[0]['pk_warning_letter_id']; ?>" />
                    <button type="submit" class="btn btn-circle blue">Submit</button>
                 <!--   <button type="button" class="btn btn-circle default">Cancel</button> -->
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