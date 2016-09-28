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
                                  <input type="text" class="form-control " name="caller_name" required>
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
                                  <input type="text" class="form-control " name="mobile" required>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">City</label>
                                <div class="col-md-4 city_content">
                                  <select  class="form-control" name="city" id="my_city" onchange="select_customer(this.value)" required>
                                      <option value="">---Select---</option>
                                      <?php 
                                      $newd=$this->db->query("select * from tbl_cities");
                                      $de=$newd->result_array();
                                      $neary=array();
                                      foreach($de as $value)
                                      {
                                  	  ?>
                                      <option value="<?php echo $value['pk_city_id'];?>">
                                        <?php echo $value['city_name'];?>			
                                      </option>
                                	  <?php }?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Customer</label>
                                <div class="col-md-4 cutomer_content">
                                 
                                 <select name="customer" class="form-control" id="client_name" required ><!--onchange="selectcity(this.value)"-->
                                      <option value="">---Select---</option>
									  
									  <?php 
                                     $newd=$this->db->query("select tbl_offices.*,COALESCE(tbl_cities.city_name) AS city_name,COALESCE(tbl_area.area) AS area from tbl_offices 
									  LEFT JOIN tbl_cities ON tbl_offices.fk_city_id=tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_offices.fk_area_id=tbl_area.pk_area_id"); 
									 // $newd=$this->db->query("SELECT * from tbl_offices");
                                      $de=$newd->result_array();
                                      $neary=array();
                                      foreach($de as $value)
                                      {
                                  ?>
                                      <option value="<?php echo $value['client_option'];?>">
                                        <?php echo $value['office_name'];
										/*
													$qu2="SELECT * from tbl_cities where pk_city_id = '".$value['fk_city_id']."' ";
													$gh2=$this->db->query($qu2);
													$rt2=$gh2->result_array();*/
													echo '--('.$value['city_name'].')';
													/*
													$qu3="SELECT * from tbl_area where pk_area_id = '".$value['fk_area_id']."' ";
													$gh3=$this->db->query($qu3);
													$rt3=$gh3->result_array(); */
													echo '--('.$value['area'].')';
											?>			
                                      </option>
                                <?php }?>
								
                                  <?php 
                                      $newd=$this->db->query("select tbl_clients.*,COALESCE(tbl_cities.city_name) AS city_name,COALESCE(tbl_area.area) AS area from tbl_clients 
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id=tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_clients.fk_area_id=tbl_area.pk_area_id 
									  WHERE tbl_clients.delete_status = '0'");
                                      $de=$newd->result_array();
                                      $neary=array();
                                      foreach($de as $value)
                                      {
                                  ?>
                                      <option value="<?php echo $value['pk_client_id'];?>">
                                        <?php echo $value['client_name'];
										/*
													$qu2="SELECT * from tbl_cities where pk_city_id = '".$value['fk_city_id']."' ";
													$gh2=$this->db->query($qu2);
													$rt2=$gh2->result_array();*/
													echo '--('.$value['city_name'].')';
													// 
													/*
													$qu3="SELECT * from tbl_area where pk_area_id = '".$value['fk_area_id']."' ";
													$gh3=$this->db->query($qu3);
													$rt3=$gh3->result_array();
													*/
													echo '--('.$value['area'].')';
											?>			
                                      </option>
                                <?php }?>
                                  </select>
                                </div>
                              </div>
                              <script>
                                 /*Ajax fucntion*/
								 function select_customer(va_nam)
								 {
									 //alert(va_nam);
									 var formdata =
                                        {
                                          var_name: va_nam,
                                          sec_var: 'second'
                                        };
                                    $.ajax({
                                      url: "<?php echo base_url();?>complaint/customer_list_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          //alert(msg);
										  $(".cutomer_content").html(msg);
										  $('select').select2();
                                          }
                                      });
								 }
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
										  $('select').select2();
                                          }
                                      })
									  $.ajax({
                                      url: "<?php echo base_url();?>complaint/select_engineer_2_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".select_engineer").html(msg);
										  $('select').select2();
                                          }
                                      })
                                      return false;
                                   }
                                   function select_contact_no(va_nam)
                                   {
                                    var city_id = $("#my_city").val();
									//alert(city_id);
									//alert(va_nam);
									var pk_client_id = va_nam;
									
									$("#client_id").val(pk_client_id);
									//alert(pk_client_id);
                                    var formdata =
                                        {
                                          city_id		: city_id,
                                          pk_client_id	: pk_client_id
                                        };
                                    $.ajax({
                                      url: "<?php echo base_url();?>complaint/client_contact_no_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $("#telephone").val(msg);
										  $('select').select2();
                                          }
                                      })
                                      //to add instrument list
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/client_instruments_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".instrument_name").html(msg);
										  $('select').select2();
                                          }
                                      })
                                      var formdata2 =
                                        {
                                          var_name: pk_client_id,
                                          sec_var: 'second'
                                        };
									  $.ajax({
                                      url: "<?php echo base_url();?>complaint/select_engineer_2_ajax",
                                      type: 'POST',
                                      data: formdata2,
                                      success: function(msg){
                                          $(".select_engineer").html(msg);
										  $('select').select2();
                                          }
                                      })
                                      return false;
                                   }
                                   function add_serial_no(product_id)
                                   {
                                       var client_id = $("#client_id").val();
									   //alert(client_id);
                                       
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
										  $('select').select2();
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
										  $('select').select2();
                                          }
                                      })
                                      
                                      return false;
                                   }
                                   function slect_office_ajax_and_related_engineers(instrument_id)
                                   {
                                       var problem_type=$('#problem_type').val();
									   var formdata =
                                        {
                                          instrument_id: instrument_id,
                                          var2: 'second',
										  problem_type:problem_type
                                        };
                                      //to add office name
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/slect_office_ajax_and_related_engineers",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".office_input").val(msg);
										  $('select').select2();
                                          }
                                      })
                                      //to add office id
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/slect_office_ajax_id",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".office_hidden_id").val(msg);
										  $('select').select2();
                                          }
                                      })
                                      //to add engneer list related to this office
                                      $.ajax({
                                      url: "<?php echo base_url();?>complaint/select_engineer_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".select_engineer").html(msg);
										  $('select').select2();
                                          }
                                      })
                                      return false;
                                   }
								   $(document).ready( function(){
									  //alert('sanaullah');
									  $('.timepicker-24').timepicker({
											autoclose: true,
											minuteStep: 5,
											showSeconds: false,
											showMeridian: false
										});
									});
                                 </script>
                              
                              <div class="form-group">
                                <label class="col-md-3 control-label">Call Date</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control datepicker" name="call_date" value="<?php echo date('d-M-Y');?>" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Call Time</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control timepicker timepicker-24 pm_time" name="call_time"  value="<?php echo date('H:i');?>" >
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-md-3 control-label">Problem Type</label>
                                <div class="col-md-4">
                                  <select id="problem_type" name="problem_type" class="form-control" required>
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
                                      <select name="instrument_name" class="form-control" onchange="selectcity(this.value)" id="equipment_name" >
                                          <option value="">---Select---</option>
                                      </select>
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Serial Number</label>
                                    <div class="col-md-4 instrument_serial_no">
                                      <select name="instrument_serial_no" class="form-control" onchange="selectcity(this.value)" id="instrument_serial_no" >
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
                                      <input type="text" readonly="readonly" name="office" class="form-control office_input" id="office" />
                                      <input type="hidden" name="office_hidden_id" class="office_hidden_id" />
                                    </div>
                                  </div>
                                  
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Problem described by the customer:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="instrument_prob" id="instrument_prob">
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
                                      <input type="text" class="form-control datepicker" name="last_ok_time" value="<?php echo date('d-M-Y');?>" >
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
                                    <label class="col-md-3 control-label">Kit Name</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="kit_name" id="kit_name" >
                                    </div>
                              </div>
					
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Kit Lot No</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="kit_lot_no" id="kit_lot_no" >
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Manufacturer</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="make_pack" id="make_pack" >
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
					
					$('#instrument_prob').removeAttr('required');
					$('#equipment_name').removeAttr('required');
                    $('#serial_no').removeAttr('required');
					$('#office').removeAttr('required');
					$('#instrument_serial').removeAttr('required');
					
					$('#kit_name').attr('required', 'required');
					$('#kit_lot_no').attr('required', 'required');
                    $('#make_pack').attr('required', 'required');
					//ajax
					 var client_name=$('#client_name').val();
					 formdata={client_name:client_name}
					 $.ajax({
					  url: "<?php echo base_url();?>complaint/select_engineer_kit_ajax",
					  type: 'POST',
					  data: formdata,
					  success: function(msg){
						  $(".select_engineer").html(msg);
						  $('select').select2();
						  }
					  })
					  return false;
                    }
                else if(locations=="equipment"){
					document.getElementById('instrument').style.display = 'block';
					document.getElementById('kit').style.display = 'none';
					
					$('#instrument_prob').attr('required', 'required');
					$('#equipment_name').attr('required', 'required');
					$('#instrument_serial_no').attr('required', 'required');
					$('#office').attr('required', 'required');
					
					$('#kit_name').removeAttr('required');
					$('#kit_lot_no').removeAttr('required');
                    $('#make_pack').removeAttr('required');
					//ajax
					 var client_name=$('#client_name').val();
					 formdata={client_name:client_name}
					 $.ajax({
					  url: "<?php echo base_url();?>complaint/select_engineer_equipment_ajax",
					  type: 'POST',
					  data: formdata,
					  success: function(msg){
						  $(".select_engineer").html(msg);
						  $('select').select2();
						  }
					  })
					  return false;
                }
                else{
                    document.getElementById('instrument').style.display = 'none';
                    document.getElementById('kit').style.display = 'none';
					
					$('#instrument_serial').removeAttr('required');
					$('#office').removeAttr('required');
					$('#equipment_name').removeAttr('required');
                    $('#serial_no').removeAttr('required');
					$('#instrument_prob').removeAttr('required');
					$('#kit_name').removeAttr('required');
					$('#kit_lot_no').removeAttr('required');
                    $('#make_pack').removeAttr('required');
                    }
                });
            });
</script>

</div>
<!-- END CONTAINER -->

<?php $this->load->view('footer');?>