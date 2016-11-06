<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Shift Complaint <small>Shift the complaint to another engineer</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> Complaints <i class="fa fa-angle-right"></i> </li>

          <li> Shift Complaint </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

                <div class="portlet box yellow-zed">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-share"></i>Shift Complaint </div>

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
								  Complaint shifted successfully.  
								</div>';
						}
						
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>sys/shift_complaint_update" class="form-horizontal" method="post">
                <div class="form-body">
                 <?php
                 		$ty22=$this->db->query("select * from tbl_complaints where pk_complaint_id='".$this->uri->segment('3')."'");
                        $rt22=$ty22->result_array();
						
				 ?>
                 
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Assign To</label>
                    <div class="col-md-6">
                       <select class="from_control col-md-6 left" name="assign_to" onchange="selectterritory(this.value)">
                       <?php 
						  $ty=$this->db->query("select * from user WHERE userrole IN ('FSE','Salesman','Supervisor') AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
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
				
					<div class="form-group">
							<div class="territory_div">
							</div>
					</div>
				
				<?php /*
				<div class="form-group">
                    <label class="col-md-3 control-label">Office</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="city_name" value="<?php echo $rt22[0]["city_name"] ?>">
                       
                    </div>
                </div>
				*/ ?>
                    
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-7 col-md-5">
                                <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment('3'); ?>">
                                    <button type="submit" class="btn purple">Submit</button>
							<!--		<a href="<?php echo site_url();?>sys/director_view_complaints" class="btn default">Cancel</a> -->
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

  

</div>
<script>
function selectterritory(i) {
var formdata = {
	  userid: i
	};
$.ajax({
  url: "<?php echo base_url();?>sys/teritory_based_on_engineer_ajax",
  type: 'POST',
  data: formdata,
  success: function(msg){
	  $(".territory_div").html(msg);
	  $('select').select2();
	  }
  })
  //return false;
}
</script>
<?php $this->load->view('footer');?>