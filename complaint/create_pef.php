<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Performance Evaluation Form <small>Create</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li>
              <i class="fa fa-home"></i>
              Home 
              <i class="fa fa-angle-right"></i>
          </li>
          <li>
              Create PEF
          </li> 

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

          <div class="tabbable tabbable-custom boxless tabbable-reversed">

            <ul class="nav nav-tabs">

              <li class="active"> <a href="#tab_0" data-toggle="tab"> Form Actions </a> </li>

            </ul>

            <div class="tab-content">

              <div class="tab-pane active" id="tab_0">

                <div class="portlet box green">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Form Actions On Bottom </div>

                    <div class="tools"> 
                    	<a href="javascript:;" class="collapse"> </a> 
                        
                        <a href="javascript:;" class="remove"> </a> 
                    </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  PEF Entered Successfully.  
								</div>';
						}
						if(isset($_GET['msg']) && $_GET['msg']=='failure')
						{ 
						  echo '<div class="alert alert-danger alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  A PEF Date Already Exist.  
								</div>';
						}
						if(isset($_GET['msg']) && $_GET['msg']=='failure2')
						{ 
						  echo '<div class="alert alert-danger alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Date Should Be Greater Than Current Date.  
								</div>';
						}
						if(isset($_GET['msg']) && $_GET['msg']=='failure3')
						{ 
						  echo '<div class="alert alert-danger alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Date Should Be Greater Than Current Date.  
								</div>';
						}
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>complaint/pef_schedule_insert" class="form-horizontal" method="post">
                <div class="form-body">
                 <div class="form-group">
                    <label class="col-md-3 control-label">Duration</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="duration">
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Expiry Date</label>
                    <div class="col-md-4">
                       <input type="text" class="datepicker2 form-control" name="expiry_date" required/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Employees</label>
                    <div class="col-md-4">
                       <select class="form-control" name="employees[]" multiple="multiple">
							<?php 
								$qu6="SELECT * from user WHERE delete_status = '0' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
								$gh6=$this->db->query($qu6);
								$rt6=$gh6->result_array();
								foreach($rt6 as $value)
								{
                            ?>
                                <option value="<?php echo $value['id']?>"><?php echo $value['first_name']?></option>
                            <?php 
								}
                            ?>
                       </select>
                    </div>
                </div>
                    
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">Submit</button>
                                <!--    <button type="button" class="btn default">Cancel</button> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </form>
                    <!-- END FORM--> 
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END PAGE CONTENT--> 
    </div>
  </div>
  <!-- END CONTENT --> 
</div>
<?php $this->load->view('footer');?>