<?php $this->load->view('header');?>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Add Complaint <small>Register a new complaint</small> </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

              <li> Complaints <i class="fa fa-angle-right"></i> </li>
    
              <li> Add Complaint </li>
              
            </ul>
            
          </div>
          <!-- END PAGE HEADER-->
          <div class="row">
              <div class="col-md-12">
                
                      <div class="portlet box red-intense">
                        <div class="portlet-title">
                          <div class="caption"> <i class="fa fa-plus"></i>New Complaint </div>
                          <div class="tools"> 
                              <a href="javascript:;" class="collapse"> </a> 
                              
                              <a href="javascript:;" class="remove"> </a> 
                          </div>
                        </div>
                        <div class="portlet-body form"> 
                          <!-- BEGIN FORM-->
                          <form  action="<?php echo base_url(); ?>complaint/insert_complaint"  enctype="multipart/form-data" class="form-horizontal" method="post">
                            <div class="form-body">
                              <div class="form-group">
                                <label class="col-md-3 control-label">TS Number</label>
                                <div class="col-md-4">
                                  <?php
									  $maxqu = $this->db->query("SELECT MAX(ts_number) as mazz FROM tbl_complaints ");
									  $maxval=$maxqu->result_array();
									  //print_r($maxval);exit;
									  //echo $maxval[0]['mazz'];exit;
									  $cur_no=substr($maxval[0]['mazz'],6,10);//echo $cur_no.'sana';exit;
									  $exceded_no=$cur_no+1;
									  $cur_date=date("ymd");
									  $disp_no=$cur_date.$exceded_no;
                                  ?>
                                  <input type="text" class="form-control " value="<?php echo $disp_no;?>" readonly name="ts_number" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Caller Name</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control " name="caller_name" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Telephone</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control " name="telephone" id="telephone_1" >
                                  <input type="hidden"  name="client_id" id="client_id" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Mobile</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control " name="mobile" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Customer</label>
                                <div class="col-md-4">
                                 <script>
                                 /*Ajax fucntion*/
                                   function selectcity(va_nam)
                                   {
									   //alert(va_nam);
                                    var formdata =
                                        {
                                          var_name: va_nam,
                                          sec_var: 'second'
                                        };
                                    $.ajax({
                                      url: "<?php echo base_url();?>complaint/city_list_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".city_content").html(msg);
                                          }
                                      })
									  $.ajax({
                                      url: "<?php echo base_url();?>complaint/select_engineer_2_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".select_engineer").html(msg);
                                          }
                                      })
                                      return false;
                                   }
                                   function select_contact_no(va_nam)
                                   {
                                    var pk_client_id = $("#client_name").val();
									$("#client_id").val(pk_client_id);
									//alert(pk_client_id);
                                    var formdata =
                                        {
                                          city_id		: va_nam,
                                          pk_client_id	: pk_client_id
                                        };
                                    $.ajax({
                                      url: "<?php echo base_url();?>complaint/client_contact_no_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $("#telephone").val(msg);
                                          }
                                      })
                                      //to add instrument list
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/client_instruments_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".instrument_name").html(msg);
                                          }
                                      })
                                      //to add client id in hidden input
                                      /*$.ajax({
                                      url: "<?php echo base_url();?>complaint/client_hidden_id_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $("#client_id").val(msg);
                                          }
                                      })*/
                                      
                                      return false;
                                   }
                                   function add_serial_no(product_id)
                                   {
                                       var client_id = $("#client_id").val();
									   //alert(product_id);
                                       
                                       var formdata =
                                        {
                                          product_id: product_id,
                                          client_id: client_id
                                        };
                                      //to add instrument list
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/client_instruments_serial_no_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".instrument_serial_no").html(msg);
                                          }
                                      })
                                      
                                      return false;
                                   }
                                   //this fucntion no longer used
                                   function select_engineer(office_id)
                                   {
                                       var formdata =
                                        {
                                          office_id: office_id,
                                          var2: 'second'
                                        };
                                      //to add instrument list
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/select_engineer_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".select_engineer").html(msg);
                                          }
                                      })
                                      
                                      return false;
                                   }
                                   function slect_office_ajax_and_related_engineers(instrument_id)
                                   {
                                       var formdata =
                                        {
                                          instrument_id: instrument_id,
                                          var2: 'second'
                                        };
                                      //to add office name
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/slect_office_ajax_and_related_engineers",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".office_input").val(msg);
                                          }
                                      })
                                      //to add office id
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/slect_office_ajax_id",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".office_hidden_id").val(msg);
                                          }
                                      })
                                      //to add engneer list related to this office
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/select_engineer_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".select_engineer").html(msg);
                                          }
                                      })
                                      
                                      return false;
                                   }
                                 </script>
                                 <select name="customer" class="form-control" id="client_name" onchange="selectcity(this.value)">
                                      <option value="">---Select---</option>
                                  <?php 
                                      $newd=$this->db->query("select * from tbl_clients WHERE delete_status = '0'");
                                      $de=$newd->result_array();
                                      $neary=array();
                                      foreach($de as $value)
                                      {
                                  ?>
                                      <option value="<?php echo $value['pk_client_id'];?>">
                                        <?php echo $value['client_name'];
													$qu2="SELECT * from tbl_cities where pk_city_id = '".$value['fk_city_id']."' ";
													$gh2=$this->db->query($qu2);
													$rt2=$gh2->result_array();
													echo '--('.$rt2[0]['city_name'].')';
													//
													$qu3="SELECT * from tbl_area where pk_area_id = '".$value['fk_area_id']."' ";
													$gh3=$this->db->query($qu3);
													$rt3=$gh3->result_array();
													echo '--('.$rt3[0]['area'].')';
											
											?>			
                                      </option>
                                <?php }?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">City</label>
                                <div class="col-md-4 city_content">
                                  <select  class="form-control" name="city">
                                      <option value="">---Select---</option>
                                  </select>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-md-3 control-label">Call Date</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control datepicker" name="call_date" value="<?php echo date('d-M-Y');?>" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Call Time</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control " name="call_time"  value="<?php echo date('H:i');?>" >
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-md-3 control-label">Problem Type</label>
                                <div class="col-md-4">
                                  <select id="problem_type" name="problem_type" class="form-control">
                                    <option value="">--Choose--</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="kit">Kit</option>
                                  </select>
                                </div>
                              </div>
                              
                              <!--instrument start-->
      
                              <div id="instrument" style="display:none">
      
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Equipment</label>
                                    <div class="col-md-4 instrument_name">
                                      <select name="instrument_name" class="form-control" onchange="selectcity(this.value)">
                                          <option value="">---Select---</option>
                                      </select>
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Serial Number</label>
                                    <div class="col-md-4 instrument_serial_no">
                                      <select name="instrument_serial_no" class="form-control" onchange="selectcity(this.value)">
                                          <option value="">---Select---</option>
                                      </select>
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Software Version:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="instrument_software_version" >
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Office</label>
                                    <div class="col-md-4">
                                      <input type="text" readonly="readonly" name="office" class="form-control office_input" />
                                      <input type="hidden" name="office_hidden_id" class="office_hidden_id" />
                                    </div>
                                  </div>
                                  
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Problem described by the customer:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="instrument_prob" >
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Error Message Displayed on Equipment / Printed by the Equipment:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="instrument_error_msg" >
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Error Number:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="error_no" >
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">When was the last time, Equipment worked without any problems?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="last_ok_time" >
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">When the problem occurred did you troubleshoot or leave the instrument as it is?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="action_after_problem" >
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Have you encountered this type of problem before?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="is_done_before" >
                                    </div>
                                  </div>
                                  
                                 
                              </div>
                              <!--instrument end-->
                              
                              <!--Kit End-->    
      
                              <div id="kit" style="display:none">
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Kit</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="kit_name" >
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Kit Lot No</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="kit_lot_no" >
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Make & Pack</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="make_pack" >
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Problem described by the customer:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="kit_prob_des_cus" >
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Was the kit calibration OK when received?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="is_colb_ok_rec" >
                                    </div>
                              </div>
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Was the control run after calibration and was it within limits?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="cont_run_after" >
                                    </div>
                              </div>
                              </div>
                              <!--Kit End-->
                              <!--<div class="form-group">
                                <label class="col-md-3 control-label">Assign Service Call</label>
                                <div class="col-md-4">
                                  <select class="form-control  " name="assign_service_call">
                                    <option value="">--Choose--</option>
                                    <option value="fse">FSE</option>
                                    <option value="sap">SAP</option>
                                  </select>
                                </div>
                              </div>-->
                              
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Assign To</label>
									
                                    <div class="col-md-8 select_engineer">
                                      <select class="form-control input-xlarge" name="assginto" >
                                          <option value="">---Select---</option>
                                      </select>
                                    
									</div>
                                  </div>
								  
                              <div class="form-group">
                                <label class="col-md-3 control-label">Urgent Priority</label>
                                <div class="col-md-4">
                                  <input type="checkbox" name="urgent_priority" />
                                </div>
                              </div>
                            </div>
                            <div class="form-actions">
                              <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                  <button type="submit" class="btn green-seagreen">Submit</button>
								  <!--
								  <a href="<?php echo site_url();?><?php
								  if ($this->uri->segment('3')=='o')
									echo "complaint/operator_view_complaints";
								  elseif ($this->uri->segment('3')=='d')
									echo "complaint/director_view_complaints";
								  else
									  echo "";
								  ?>
								  " 
								  class="btn default">Cancel</a>
								  -->
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
  <!-- END CONTENT -->
  <!-- BEGIN QUICK SIDEBAR -->
  <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
  <script type="text/javascript">
        $(document).ready(function(){
            
            $('#problem_type').on("change",function(){
                var locations = $(this).val();
                if(locations=="kit"){
                    document.getElementById('kit').style.display = 'block';
                    document.getElementById('instrument').style.display = 'none';
                    }
                else if(locations=="equipment"){
                document.getElementById('instrument').style.display = 'block';
                document.getElementById('kit').style.display = 'none';
                }
                else{
                    document.getElementById('instrument').style.display = 'none';
                    document.getElementById('kit').style.display = 'none';
                    }
                });
            });
</script>

</div>
<!-- END CONTAINER -->

<?php $this->load->view('footer');?>