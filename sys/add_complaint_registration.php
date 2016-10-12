<?php $this->load->view('header');?>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Update/Assign Complaint <small></small> </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

              <li> Complaints <i class="fa fa-angle-right"></i> </li>
    
              <li> Update/Assign Complaint </li>
              
            </ul>
            
          </div>
          <!-- END PAGE HEADER-->
          <div class="row">
              <div class="col-md-12">
                
                      <div class="portlet box red-intense">
                        <div class="portlet-title">
                          <div class="caption"> <i class="fa fa-plus"></i>Update/Assign Complaint </div>
                          <div class="tools"> 
                              <a href="javascript:;" class="collapse"> </a> 
                              
                              <a href="javascript:;" class="remove"> </a> 
                          </div>
                        </div>
                        <div class="portlet-body form"> 
                          <!-- BEGIN FORM-->
                          <form  action="<?php echo base_url(); ?>sys/complete_complaint_resgistration"  enctype="multipart/form-data" class="form-horizontal" method="post">
                            <input type="hidden" name="complaint_hidden_id" value="<?php echo $this->uri->segment(3);?>" />
                            <div class="form-body">
                              <div class="form-group">
                                <label class="col-md-3 control-label">TS Number</label>
                                <div class="col-md-4">
                                  <?php
									  $data_query = $this->db->query("SELECT tbl_complaints.*,
									  COALESCE(tbl_products.product_name) AS product_name,
									  COALESCE(tbl_instruments.serial_no) AS instrument_serial,
									  COALESCE(tbl_offices.office_name) AS office_name 
									  FROM tbl_complaints 
									  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
									  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
									  LEFT JOIN tbl_offices ON tbl_complaints.fk_office_id = tbl_offices.pk_office_id
									  WHERE pk_complaint_id='".$this->uri->segment(3)."'");
									  $data_result=$data_query->result_array();
									  //
									  $maxqu = $this->db->query("SELECT MAX(ts_number) as mazz FROM tbl_complaints ");
									  $maxval=$maxqu->result_array();
									  //print_r($maxval);exit;
									  //echo $maxval[0]['mazz'];exit;
									  $cur_no=substr($maxval[0]['mazz'],6,10);//echo $cur_no.'sana';exit;
									  $exceded_no=$cur_no+1;
									  $cur_date=date("ymd");
									  $disp_no=$cur_date.$exceded_no;
                                  ?>
                                  <input type="text" class="form-control " value="<?php echo $data_result[0]['ts_number'];?>" readonly name="ts_number" >
								  <?php
								  $hidden_status = "Pending";
								  if ($data_result[0]['software_generated']==1) $hidden_status = "Pending SPRF";
								  ?>
								  <input type="hidden" name="complaint_hidden_status" value="<?php echo $hidden_status;?>" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Caller Name</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control " name="caller_name"  value="<?php echo $data_result[0]['caller_name'];?>" required>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Telephone</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control " name="telephone"  value="<?php echo $data_result[0]['landline'];?>" id="telephone_1" >
                                  <input type="hidden"  name="client_id" id="client_id" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Mobile</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control" name="mobile"  value="<?php echo $data_result[0]['phone'];?>" required>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">City</label>
                                <div class="col-md-4 city_content">
                                  <select  class="form-control" name="city" id="my_city" onchange="select_customer(this.value)" requried>
                                      <option value="">---Select---</option>
                                      <?php 
                                      $newd=$this->db->query("select * from tbl_cities");
                                      $de=$newd->result_array();
                                      $neary=array();
                                      foreach($de as $value)
                                      {
                                  	  ?>
                                      <option value="<?php echo $value['pk_city_id'];?>" 
									  <?php if($value['pk_city_id']==$data_result[0]['fk_city_id']){ echo 'selected="selected"';}?>>
                                        <?php echo $value['city_name'];?>			
                                      </option>
                                	  <?php }?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Customer</label>
                                <div class="col-md-4 cutomer_content">
                                 
                                 <select name="customer" class="form-control" id="client_name" onchange="select_contact_no(this.value)"><!--onchange="selectcity(this.value)"-->
                                      <option value="">---Select---</option>
									  
									  <?php 
                                      $newd=$this->db->query("select tbl_offices.*,COALESCE(tbl_cities.city_name) AS city_name,COALESCE(tbl_area.area) AS area from tbl_offices 
									  LEFT JOIN tbl_cities ON tbl_offices.fk_city_id=tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_offices.fk_area_id=tbl_area.pk_area_id"); 
                                      $de=$newd->result_array();
                                      $neary=array();
                                      foreach($de as $value)
                                      {
                                  ?>
                                      <option value="<?php echo $value['client_option'];?>" 
									  <?php if($value['fk_client_id']==$data_result[0]['fk_customer_id']){ echo 'selected="selected"';}?>>
                                        <?php echo $value['office_name'];
										/*
													$qu2="SELECT * from tbl_cities where pk_city_id = '".$value['fk_city_id']."' ";
													$gh2=$this->db->query($qu2);
													$rt2=$gh2->result_array();	*/
													echo '--('.$value['city_name'].')';
													//
											/*		$qu3="SELECT * from tbl_area where pk_area_id = '".$value['fk_area_id']."' ";
													$gh3=$this->db->query($qu3);
													$rt3=$gh3->result_array();	*/
													echo '--('.$value['area'].')';
											?>			
                                      </option>
                                <?php }?>
								
								
                                  <?php 
                                      //$newd=$this->db->query("select * from tbl_clients WHERE delete_status = '0'");
									  // commenting above and adding below query to accomodate office clients
                                      $newd=$this->db->query("select tbl_clients.*,COALESCE(tbl_cities.city_name) AS city_name,COALESCE(tbl_area.area) AS area from tbl_clients 
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id=tbl_cities.pk_city_id
									  LEFT JOIN tbl_area ON tbl_clients.fk_area_id=tbl_area.pk_area_id 
									  WHERE tbl_clients.delete_status = '0'");
                                      $de=$newd->result_array();
                                      $neary=array();
									  /*
									  if ($data_result[0]['fk_customer_id']<0){
											  echo '<option value="officeoption_'.$data_result[0]['fk_office_id'].'" selected="selected">x</option>';
										  }*/
                                      foreach($de as $value)
                                      {
                                  ?>
								  
                                      <option value="<?php echo $value['pk_client_id'];?>"
                                      <?php if($value['pk_client_id']==$data_result[0]['fk_customer_id']){ echo 'selected="selected"';}?>>
                                        <?php echo $value['client_name'];
												/*	$qu2="SELECT * from tbl_cities where pk_city_id = '".$value['fk_city_id']."' ";
													$gh2=$this->db->query($qu2);
													$rt2=$gh2->result_array(); */
													echo '--('.$value['city_name'].')';
													//
											/*		$qu3="SELECT * from tbl_area where pk_area_id = '".$value['fk_area_id']."' ";
													$gh3=$this->db->query($qu3);
													$rt3=$gh3->result_array(); */
													echo '--('.$value['area'].')';
											?>			
                                      </option>
										  <?php 
								}?>
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
                                      url: "<?php echo base_url();?>sys/customer_list_ajax",
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
                                      url: "<?php echo base_url();?>sys/city_list_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".city_content").html(msg);
										  $('select').select2();
                                          }
                                      })
									  $.ajax({
                                      url: "<?php echo base_url();?>sys/select_engineer_2_ajax",
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
                                      url: "<?php echo base_url();?>sys/client_contact_no_ajax",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $("#telephone").val(msg);
										  $('select').select2();
                                          }
                                      })
                                      //to add instrument list
                                      $.ajax({
                                      url: "<?php echo base_url();?>sys/client_instruments_ajax",
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
                                      url: "<?php echo base_url();?>sys/select_engineer_2_ajax",
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
                                       var client_id = $("#client_name").val();
									   //alert(product_id);
                                       
                                       var formdata =
                                        {
                                          product_id: product_id,
                                          client_id: client_id
                                        };
                                      //to add instrument list
                                      $.ajax({
                                      url: "<?php echo base_url();?>sys/client_instruments_serial_no_ajax",
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
                                      url: "<?php echo base_url();?>sys/select_engineer_ajax",
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
                                      url: "<?php echo base_url();?>sys/slect_office_ajax_and_related_engineers",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".office_input").val(msg);
										  $('select').select2();
                                          }
                                      })
                                      //to add office id
                                      $.ajax({
                                      url: "<?php echo base_url();?>sys/slect_office_ajax_id",
                                      type: 'POST',
                                      data: formdata,
                                      success: function(msg){
                                          $(".office_hidden_id").val(msg);
										  $('select').select2();
                                          }
                                      })
                                      //to add engneer list related to this office
                                      $.ajax({
                                      url: "<?php echo base_url();?>sys/select_engineer_ajax",
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
                                  <input type="text" class="form-control datepicker" name="call_date" value="<?php echo date('d-M-Y', strtotime($data_result[0]['date']));?>" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label">Call Time</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control timepicker timepicker-24 pm_time" name="call_time"  
                                  value="<?php echo date('H:i', strtotime($data_result[0]['date']));?>" >
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-md-3 control-label">Problem Type</label>
                                <div class="col-md-4">
                                  <select id="problem_type" name="problem_type" class="form-control">
                                    <option value="">--Choose--</option>
                                    <option value="equipment" <?php if($data_result[0]['problem_type']=='equipment'){ echo 'selected="selected"';}?>>Equipment</option>
                                    <option value="kit" <?php if($data_result[0]['problem_type']=='kit'){ echo 'selected="selected"';}?>>Kit</option>
                                  </select>
                                </div>
                              </div>
                              
                              <!--instrument start-->
      
                              <div id="instrument" <?php if($data_result[0]['problem_type']!='equipment'){ echo 'style="display:none"';}?>>
      
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Equipment</label>
                                    <div class="col-md-4 instrument_name">
                                      <select name="instrument_name" class="form-control" onchange="add_serial_no(this.value)">
                                          <option value="">---Select---</option>
                                          <?php /*$query = $this->db->query("select * from tbl_instruments where pk_instrument_id ='".$data_result[0]['fk_instrument_id']."'"); 
										  if($query->num_rows()>0)
										  {
											  $new_result = $query->result_array();
											  $query_procut = $this->db->query("select * from tbl_products where pk_product_id ='".$new_result[0]['fk_product_id']."'");
											  $new_product = $query_procut->result_array(); */
										  ?>
                                          <option value="<?php echo $data_result[0]['fk_instrument_id']?>" selected="selected"><?php echo $data_result[0]['product_name']?></option>
                                          <?php //}?>
                                      </select>
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Serial Number</label>
                                    <div class="col-md-4 instrument_serial_no">
                                      <?php
                                    /*  $rrr="select * from tbl_instruments where fk_product_id = '".$new_result[0]['fk_product_id']."' 
									  		AND fk_client_id= '".$data_result[0]['fk_customer_id']."'"; */
											// Sanaullah was using above query, i am using the one below 24 june 2016
									  $rrr="select * from tbl_instruments where pk_instrument_id = '".$data_result[0]['fk_instrument_id']."'";
									  //echo $rrr;exit;
									  $nn=$this->db->query($rrr);
									  $nnm=$nn->result_array();
									  //
									  echo '<select name="instrument" class="form-control" onchange="slect_office_ajax_and_related_engineers(this.value)" >';
									  echo '<option value="">---Select---</option>';
									  foreach($nnm as $drt)
									  {
										  echo '<option value="';
										  echo $drt["pk_instrument_id"];
										  if ($drt["pk_instrument_id"]==$data_result[0]['fk_instrument_id'])
											echo '" selected="selected">';
										  else 
											echo '">';
										  echo $drt["serial_no"];
										  echo '</option>';
									  }
									  ?>
                                      </select>
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Software Version:</label>
                                    <div class="col-md-4">
                                     <input type="text" class="form-control" name="instrument_software_version" value="<?php echo $data_result[0]['instrument_software_version'];?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Office</label>
                                    <div class="col-md-4">
                                      <?php
                                     /* $qu="select * from tbl_offices where pk_office_id = '".$data_result[0]['fk_office_id']."' ";
									  $quer=$this->db->query($qu);
									  $resul=$quer->result_array();*/
									  ?>
                                      <input type="text" readonly="readonly" name="office" class="form-control office_input"  
                                      value="<?php if (sizeof($data_result)>0){echo $data_result[0]['office_name'];}?>"/>
                                      <input type="hidden" name="office_hidden_id" class="office_hidden_id"  
                                      value="<?php  if (sizeof($data_result)>0){ echo $data_result[0]['fk_office_id'];}?>"/>
                                    </div>
                                  </div>
                                  
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Problem described by the customer:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control" name="instrument_prob" id="instrument_prob" value="<?php //echo $data_result[0]['instrument_prob'];
									  echo $data_result[0]['problem_summary'];
									  ?>">
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Error Message Displayed on Equipment / Printed by the Equipment:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control" name="instrument_error_msg"  value="<?php echo $data_result[0]['instrument_error_msg'];?>">
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Error Number:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control" name="error_no"  value="<?php echo $data_result[0]['error_no'];?>">
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">When was the last time, Equipment worked without any problems?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control datepicker"  name="last_ok_time"  
                                      value="<?php echo date('d-M-Y',strtotime($data_result[0]['last_ok_time']));?>">
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">When the problem occurred did you troubleshoot or leave the instrument as it is?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control" name="action_after_problem"  value="<?php echo $data_result[0]['action_after_problem'];?>">
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Have you encountered this type of problem before?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control" name="is_done_before"  value="<?php echo $data_result[0]['is_done_before'];?>">
                                    </div>
                                  </div>
                                  
                                 
                              </div>
                              <!--instrument end-->
                             
                              <!--Kit End-->    
      
                              <div id="kit" <?php if($data_result[0]['problem_type']!='kit'){ echo 'style="display:none"';}?>>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Kit Name</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="kit_name" id="kit_name"  value="<?php echo $data_result[0]['kit_name'];?>">
                                    </div>
                              </div>
					
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Kit Lot No</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control" name="kit_lot_no" id="kit_lot_no"  value="<?php echo $data_result[0]['kit_lot_no'];?>">
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Manufacturer</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control" name="make_pack" id="make_pack"  value="<?php echo $data_result[0]['make_pack'];?>">
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Problem described by the customer:</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="kit_prob_des_cus"  value="<?php echo $data_result[0]['kit_prob_des_cus'];?>">
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Was the kit calibration OK when received?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="is_colb_ok_rec"  value="<?php echo $data_result[0]['is_colb_ok_rec'];?>">
                                    </div>
                              </div>
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Was the control run after calibration and was it within limits?</label>
                                    <div class="col-md-4">
                                      <input type="text" class="form-control " name="cont_run_after"  value="<?php echo $data_result[0]['cont_run_after'];?>">
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
                                      <select class="form-control input-xlarge" name="assign_to" required>
                                          <option value="">---Select---</option>
                                          <?php 
										  if($data_result[0]['problem_type']=='kit')
										  { 
										  		 $newd=$this->db->query("select * from user where fk_office_id = '".$data_result[0]['fk_office_id']."' 
										  						  		 AND userrole IN ('FSE','Salesman','Supervisor') AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
										  }
										  if($data_result[0]['problem_type']=='equipment')
										  { 
										  		 $newd=$this->db->query("select * from user where fk_office_id = '".$data_result[0]['fk_office_id']."' 
										  						  		 AND userrole IN ('FSE','Supervisor') AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
										  }
										 
										  $de=$newd->result_array();
										  foreach($de as $value)
										  {
										  ?>
										  <option value="<?php echo $value['id'];?>" <?php if($data_result[0]['assign_to']==$value['id']) echo "selected='selected'";?>>
											<?php echo $value['first_name'];?>			
										  </option>
										  <?php }?>
										</select>
                                        <?php
                                        	echo '<div class="col-md-12"><br />';
		
											//mryasirtable				  
											echo '<table class="table table-condensed table-striped table-bordered table-hover flip-content">';
											echo '<thead>';
											//echo '<tr><th>Name</th><th>Pending TS</th><th>Pending PM</th><th>TS (30 Days)</th><th>PM (30 Days)</th></tr>';
											echo '<tr>
														  <th class="bg-blue-steel text-center bg-grey-border"> FSE </th>
														  <th class="bg-grey-steel text-center bg-grey-border"> Complaints<br />Assigned </th>
														  <th class="bg-grey-cararra text-center bg-grey-border"> Complaints<br />Solved </th>
														  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">Complaints<br />Pending </span></th>
														  <th class="bg-grey-steel text-center bg-grey-border"> PMC<br />Assigned </th>
														  <th class="bg-grey-cararra text-center bg-grey-border"> PMC<br />Completed </th>
														  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">  PMC<br />Pending </span> </th>
														</tr>';
											echo '</thead>';
											echo '<tbody>';	
											foreach($de as $pma_user)
											{
											
											$complaints_assigned	=	0;
											$complaints_solved	=	0;
											$complaints_pending	=	0;
											$pmc_assigned			=	0;
											$pmc_completed		=	0;
											$pmc_pending			=	0;
									
											$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' 
											AND status='Closed'");
											$rt10	=	$ty10->result_array();
											$complaints_solved	=	sizeof($rt10);
									
											$ty11	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint'
											 AND status!='Closed'");
											$rt11	=	$ty11->result_array();
											$complaints_pending	=	sizeof($rt11);
									
											$ty12	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' 
											AND status='Completed'");
											$rt12	=	$ty12->result_array();
											$pmc_completed	=	sizeof($rt12);
									
											$ty13	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' 
											AND status!='Completed'");
											$rt13	=	$ty13->result_array();
											$pmc_pending	=	sizeof($rt13);
											
											echo '<tr class="odd gradeX">';
											 echo  '<td class="bg-blue-steel"> '. $pma_user["first_name"].'</td>';
											 echo  '<td class="bg-grey-steel text-center bg-grey-border">'.($complaints_solved+$complaints_pending);
											 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border">'.$complaints_solved;
											 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.$complaints_pending.'</td>';
											 echo  '<td class="bg-grey-steel text-center bg-grey-border">' .($pmc_completed+$pmc_pending).'</td>';
											 echo  '<td class="bg-grey-cararra text-center bg-grey-border">'.$pmc_completed;
											 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.$pmc_pending.'</td>';
											echo '</tr>';
											}
											//mryasirtable
											echo '</tbody>';
											echo '</table>';
										   
										   echo '</div>';
	
										?>
                                    
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
									echo "sys/operator_view_complaints";
								  elseif ($this->uri->segment('3')=='d')
									echo "sys/director_view_complaints";
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
					
					$('#kit_name').attr('required', 'required');
					$('#kit_lot_no').attr('required', 'required');
                    $('#make_pack').attr('required', 'required');
					//ajax
					 var client_name=$('#client_name').val();
					 formdata={client_name:client_name}
					 $.ajax({
					  url: "<?php echo base_url();?>sys/select_engineer_kit_ajax",
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
					
					$('#kit_name').removeAttr('required');
					$('#kit_lot_no').removeAttr('required');
                    $('#make_pack').removeAttr('required');
					//ajax
					 var client_name=$('#client_name').val();
					 formdata={client_name:client_name}
					 $.ajax({
					  url: "<?php echo base_url();?>sys/select_engineer_equipment_ajax",
					  type: 'POST',
					  data: formdata,
					  success: function(msg){
						  $(".select_engineer").html(msg);
						  $('select').select2();
						  }
					  })
					  return false;
                }
                /*else{
                    document.getElementById('instrument').style.display = 'none';
                    document.getElementById('kit').style.display = 'none';
					
					$('#instrument_prob').removeAttr('required');
					$('#kit_name').removeAttr('required');
					$('#kit_lot_no').removeAttr('required');
                    $('#make_pack').removeAttr('required');
                    }*/
                });
            });
</script>

</div>
<!-- END CONTAINER -->

<?php $this->load->view('footer');?>