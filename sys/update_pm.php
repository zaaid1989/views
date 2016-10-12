<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Update PM <small>edit PM details</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> PMs <i class="fa fa-angle-right"></i> </li>

          <li> Update PM </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

                <div class="portlet box purple-seance">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-edit"></i>Update PM </div>

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
								  PM Updated Successfully.  
								</div>';
						}
						
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>sys/update_pm_insert" class="form-horizontal" method="post">
                <div class="form-body">
                 <?php
                 		$ty22=$this->db->query("select * from tbl_complaints where pk_complaint_id='".$this->uri->segment('3')."'");
                        $rt22=$ty22->result_array();
				 ?>
                 <div class="form-group">
                    <label class="col-md-3 control-label">Date</label>
                    <div class="col-md-4">
                        <input type="text" onchange="calculate_time()" class="datepicker2 form-control pm_date" name="day" value="<?php echo date('d-M-Y', strtotime($rt22[0]["date"]));  ?>">
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Time</label>
                    <div class="col-md-4">
                        <input type="text" onchange="calculate_time()" class="form-control timepicker timepicker-24 pm_time" name="time" value="<?php echo date('H:i', strtotime($rt22[0]["date"]));  ?>">
                    </div>
                </div>

                <input type="hidden" name="date" value="<?php echo $rt22[0]["date"];?>" class="combine_date">
                
                <div class="form-group">
                    <label class="col-md-3 control-label">FSE</label>
                    <div class="col-md-4">
                       <select class="from_control" name="assign_to">
                       <?php 
						  $ty=$this->db->query("select * from user  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
						  $rt=$ty->result_array();
						  foreach($rt as $result)
						  {
						   ?>
							<option value="<?php echo $result["id"];?>" 
							<?php if($result["id"]==$rt22[0]["assign_to"]){?> selected="selected"<?php }?>
							>
								<?php echo $result["first_name"];?>
                            </option>
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
                                <div class="col-md-offset-6 col-md-6">
                                    <input type="hidden" name="pk_complaint_id" value="<?php echo $this->uri->segment(3); ?>">
                                    <button type="submit" onclick="calculate_time()" class="btn yellow">Submit</button>
                                  <!--  <a href="<?php echo site_url();?>sys/director_view_pm" class="btn default">Cancel </a> -->
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

      <!-- END PAGE CONTENT--> 

    </div>

  </div>

  <!-- END CONTENT --> 

      <script>
          function calculate_time()
      {
        var pm_date=$('.pm_date').val();
        var pm_time=$('.pm_time').val();
        var combine = pm_date+' '+pm_time;
        $('.combine_date').val(combine);
      }

        $(function() {
              
        $('.timepicker-24').timepicker({
                      autoclose: true,
                      minuteStep: 5,
                      showSeconds: false,
                      showMeridian: false
                  });
        });
          </script>

  

</div>
<?php $this->load->view('footer');?>