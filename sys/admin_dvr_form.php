<?php $this->load->view('header');?>
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title">
      DVR <small>Previous Entry</small>
      </h3>
      <div class="page-bar">
          <ul class="page-breadcrumb">
              <li>
                  <i class="fa fa-home"></i>
                  Home 
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  DVR Previous Entry
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
          <div class="portlet box blue-chambray">
            <div class="portlet-title">
              <div class="caption"> <i class="icon-action-undo"></i>Admin DVR Form</div>
              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
               
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/insert_dvr_admin">
        	<input type="hidden" name="engineer_dvr_form" value="engineer_dvr_form" />
            <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
            <div class="form-body">
                <div class="row">
                	<div class="col-md-12"> 
                        <div class="form-group">
                            <label class="col-md-3 control-label">Start Time</label>
                            <div class="col-md-5">
                                <input  name="starttime[0]" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds"  required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">End Time</label>
                            <div class="col-md-5">
                                <input   name="endtime[0]" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds" required>	
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date</label>
                            <div class="col-md-5">
                                <input type="text" class="datepicker2 form-control" name="date[0]" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee</label>
                            <div class="col-md-5">
                                    <select class="form-control  " name="engineer[0]" id="engineer0" onchange="empty_city_and_business()" required>
                                      <option value="">--Choose--</option>
                                      <?php $quw="SELECT * from user  where delete_status = '0' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
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
                         <?php /* $quw="SELECT * from tbl_clients";
                                        $ghw=$this->db->query($quw);
                                        $rtw=$ghw->result_array();
                                        foreach($rtw as $value)
                                          {
                                               echo 'client_id= '.$value['pk_client_id'];
											   
											   $quw2="SELECT * from tbl_cities where pk_city_id='".$value['fk_city_id']."'";
													$ghw2=$this->db->query($quw2);
													$rtw2=$ghw2->result_array();
													
													echo '    citi_id='.$rtw2[0]['pk_city_id'].'';
													
													//for area
													$quw3="SELECT * from tbl_area where pk_area_id='".$value['fk_area_id']."'";
													$ghw3=$this->db->query($quw3);
													$rtw3=$ghw3->result_array();
													
													echo '   Area_id= --('.$rtw3[0]['pk_area_id'].')<br>';
                                          }*/ ?>

                            <label class="col-md-3 control-label">Customer</label>
                            <div class="col-md-5">
                                    <select class="form-control  " name="customer[0]" id="customer0"  onchange="show_cities(this.value,0)" required>
                                      <option value="">--Choose--</option>
                                      <option value="officeoption_1">Rawalpindi Office (HO)</option>
                                      <option value="officeoption_2">Lahore Office (LO)</option>
                                      <option value="officeoption_3">Karachi Office (KO)</option>
                                      <option value="officeoption_4">Multan Office (MO)</option>
                                      <option value="officeoption_5">Peshawar (PO)</option>
                                      <?php $quw="SELECT * from tbl_clients WHERE delete_status = '0' OR pk_client_id<0";
                                        $ghw=$this->db->query($quw);
                                        $rtw=$ghw->result_array();
                                        foreach($rtw as $value)
                                          {
                                              ?>
                                              <option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?>
											  <?php $quw2="SELECT * from tbl_cities where pk_city_id='".$value['fk_city_id']."'";
													$ghw2=$this->db->query($quw2);
													$rtw2=$ghw2->result_array();
													echo '--('.$rtw2[0]['city_name'].')';
													//for area
													$quw3="SELECT * from tbl_area where pk_area_id='".$value['fk_area_id']."'";
													$ghw3=$this->db->query($quw3);
													$rtw3=$ghw3->result_array();
													echo '--('.$rtw3[0]['area'].')';?>
                                                    </option>
                                              <?php
                                          }?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">City</label>
                            <div class="col-md-5 citiestd0">
                                 <select class="form-control  " name="city[0]" required>
                                     <option value="">--Choose--</option>
                                 </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Business Project</label>
                            <div class="col-md-5 businessestd0">
                                <select class="form-control  "  name="business[0]" required>
                                  <option value="">--Choose--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-5">
                                <input type="text"  readonly name="business_description[0]"  class="form-control business_description0" required>
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Time Elapsed</label>

                            <div class="col-md-5">

                                <input type="text"  readonly name="time_elaped[0]"  class="form-control time_elaped0" id="time_elaped0" required>	        
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label"> Working Details/ Discussion Summary</label>

                            <div class="col-md-8">

                                <textarea name="summery[0]" class="input-xlarge" id="textarea" rows="5" required></textarea>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Next Plan</label>

                            <div class="col-md-8">

                                <textarea name="next_plan[0]" class="input-xlarge" id="textarea" rows="3" required></textarea>

                        </div>
                      </div>
                    </div>
                </div>
              
			  <script type="text/javascript">
			  	function check_range()
				{
					var timepicker1 = $(".timepicker1").val();
					timepicker1_array=timepicker1.split(' ');
					var timepicker1_ampm =timepicker1_array[1]
					
					timepicker1_array_hrmn=timepicker1_array[0].split(':');
					var timepicker1_hr =timepicker1_array_hrmn[0];
					var timepicker1_mn = timepicker1_array_hrmn[1];
					if(timepicker1_ampm=='AM' && timepicker1_hr==12 ) { timepicker1_hr-=12; }
					
						if(timepicker1_ampm=='PM' && timepicker1_hr<12)
						{
							timepicker1_hr=12+(+timepicker1_hr);
							timepicker1_hr_con= timepicker1_hr*60;
							//alert('timepicker1_hr_con = '+timepicker1_hr_con);
							timepicker1_newvalue=(+timepicker1_hr_con)+(+timepicker1_mn);
						}
						else
						{
							timepicker1_hr_con= timepicker1_hr*60;
							timepicker1_newvalue=(+timepicker1_hr_con)+(+timepicker1_mn);
						}
					// timepicker 2 calculations
					var timepicker2 = $(".timepicker2").val();
					timepicker2_array=timepicker2.split(' ');
					var timepicker2_ampm =timepicker2_array[1]
					
					timepicker2_array_hrmn=timepicker2_array[0].split(':');
					var timepicker2_hr =timepicker2_array_hrmn[0];
					var timepicker2_mn = timepicker2_array_hrmn[1];
					if(timepicker2_ampm=='AM' && timepicker2_hr==12 ) { timepicker2_hr-=12; }
						if(timepicker2_ampm=='PM' && timepicker2_hr<12)
						{
							timepicker2_hr=12+(+timepicker2_hr);
							timepicker2_hr_con= timepicker2_hr*60;
							//alert('timepicker2_hr_con = '+timepicker2_hr_con);
							timepicker2_newvalue=(+timepicker2_hr_con)+(+timepicker2_mn);
						}
						else
						{
							timepicker2_hr_con= timepicker2_hr*60;
							timepicker2_newvalue=(+timepicker2_hr_con)+(+timepicker2_mn);
						}
					/*alert('timepicker1 = '+timepicker1);
					alert('timepicker1_ampm = '+timepicker1_ampm);
					alert('timepicker1_hr = '+timepicker1_hr);
					alert('timepicker1_mn = '+timepicker1_mn);
					
					alert('timepicker2 = '+timepicker2);
					alert('timepicker2_ampm = '+timepicker2_ampm);
					alert('timepicker2_hr = '+timepicker2_hr);
					alert('timepicker2_mn = '+timepicker2_mn);
					
					alert('timepicker2 = '+timepicker2_newvalue);
					alert('timepicker1 = '+timepicker1_newvalue);*/
					if(timepicker2_newvalue<timepicker1_newvalue)
					{
						alert("End time must be greater than start time ");
						return false;
					}
				}
				//this fucntion is used only in admin
				function empty_city_and_business()
				{
					$(".citiestd0").html('<select class="form-control  " name="city[0]" required><option value="">--Choose--</option></select>');
					$(".businessestd0").html('<select class="form-control  "  name="business[0]" required><option value="">--Choose--</option></select>');
				}
				function show_cities(client_id,rowid)
				{
					var myengineer = $("#engineer0").val();
					if(myengineer=='')
					  {
						  alert('Select Engineer first');
						  return false;
					  }
					var formdata =
					  {
						client_id: client_id,
						rowid: rowid
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/form_client_select_ajax_for_cityid",
					type: 'POST',
					data: formdata,
					success: function(msg){
						//these two are inner ajax
						$.ajax({
							url: "<?php echo base_url();?>sys/form_client_select_ajax",
							type: 'POST',
							data: formdata,
							success: function(msg2){
								$(".citiestd"+rowid).html(msg2);
								//alert(msg);
								}
							})
							var sales_person = $('#engineer0').val();
							//alert(sales_person);
							var formdata_for_business =
							  {
								cutomer_id: client_id,// taken fron fuction parameter
								city_id: msg,// this value is from first ajax call
								rowid: rowid,
								sales_person:sales_person
							  };
							 $.ajax({
							url: "<?php echo base_url();?>sys/form_business_select_ajax",
							type: 'POST',
							data: formdata_for_business,
							success: function(msg3){
								$(".businessestd"+rowid).html(msg3);
								//alert(msg);
								}
							})
							return false;
							
						}
					})
					return false;
				}
				function fill_business_dec_and_timeelapsed(business_id,rowid)
				{
				  //alert(business_id);
				  var res = business_id.substring(0, 8);
				  if(business_id=='others' || business_id=='' || res=='tsnumber')
				  {
					  $(".business_description"+rowid).prop("readonly",false);
					  $(".time_elaped"+rowid).prop("readonly",false);
					  $(".time_elaped"+rowid).val('');
					  $(".business_description"+rowid).val('');
				  }
				  else
				  {
					$(".business_description"+rowid).prop("readonly",true);
					$(".time_elaped"+rowid).prop("readonly",true);
					  
					var customer_id=$("#customer"+rowid).val();
					var formdata =
					  {
						business_id: business_id,
						customer_id:customer_id,
						rowid: rowid
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/business_dec_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".business_description"+rowid).val(msg);
						//alert(msg);
						}
					})
					$.ajax({
					url: "<?php echo base_url();?>sys/business_time_elapsed_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".time_elaped"+rowid).val(msg);
						//alert(msg);
						}
					})
					return false;
				  }
				  if(res=='tsnumber')
				  {
					$(".business_description"+rowid).prop("readonly",true);
					$(".time_elaped"+rowid).prop("readonly",true);
					var customer_id=$("#customer"+rowid).val();
					var formdata =
					  {
						complaint_id: business_id.substring(9, 15),
						rowid: rowid
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/business_dec_ajax_against_tsnumber",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".business_description"+rowid).val(msg);
						//alert(msg);
						}
					})
					$.ajax({
					url: "<?php echo base_url();?>sys/business_time_elapsed_ajax_against_tsnumber",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".time_elaped"+rowid).val(msg);
						//alert(msg);
						}
					})
					return false;
				  }
				}
				
                function add_row()
                  {
                    var count1=Math.floor(Math.random()*101);
                    $('.append_tbody').append('<tr class="odd gradeX"><td> <input  name="starttime['+count1+']" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds"   required></td><td> <input   name="endtime['+count1+']" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"   required></td><td><select class="form-control  " name="customer['+count1+']"  onchange="show_cities(this.value,'+count1+')"  id="customer'+count1+'" ><option value="">--Choose--</option><?php $qu="SELECT tbl_clients.pk_client_id, tbl_clients.client_name FROM tbl_customer_sap_bridge INNER JOIN tbl_clients ON tbl_clients.pk_client_id 	=	tbl_customer_sap_bridge.fk_client_id where tbl_customer_sap_bridge.fk_user_id =  '".$this->session->userdata('userid')."' AND tbl_clients.delete_status = '0'"; $gh=$this->db->query($qu); $rt=$gh->result_array(); foreach($rt as $value){ ?> <option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?></option> <?php }?></select></td><td class="citiestd'+count1+'"> <select class="form-control  " name="city['+count1+']"><option value="">--Choose--</option></td><td class="businessestd'+count1+'"><select class="form-control  "  name="business['+count1+']"><option value="">--Choose--</option><option value="MD">MDx Business</option><option value="ID">IDx Business</option></select></td><td><input type="text"  readonly name="business_description['+count1+']"  class="form-control business_description'+count1+'">	</td> <td><input type="text"  readonly name="time_elaped['+count1+']"  class="form-control time_elaped'+count1+'" id="time_elaped'+count1+'">	</td> <td><textarea name="summery['+count1+']" class="input-xlarge" id="textarea" rows="5"></textarea></td><td><textarea name="next_plan['+count1+']" class="input-xlarge" id="textarea" rows="3"></textarea></td><td><a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a><br /><a href="javascript:void()"><i class="fa fa-minus"></i></a></td></tr>');
                    $('select').select2();
                    $( ".fa-minus" ).click(function(event) {
                          $(this).closest('tr').remove();
                      });
					
					$('.timepicker1').timepicker({
						minuteStep: 5,
						showInputs: false,
						disableFocus: true,
						defaultTime:false
					});
					
					$('.timepicker2').timepicker({
						minuteStep: 5,
						showInputs: false,
						disableFocus: true,
						defaultTime:false
					});
                   }
              </script>
              
              <script type="text/javascript">
                $('.timepicker1').timepicker({
                    minuteStep: 5,
                    showInputs: false,
                    disableFocus: true,
                    defaultTime:false
                });
                
                $('.timepicker2').timepicker({
                    minuteStep: 5,
                    showInputs: false,
                    disableFocus: true,
                    defaultTime:false
                });
              </script>
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn blue" onclick="return check_range()">Submit</button>
                <!--  <a href="<?php echo base_url(); ?>" class="btn default">Cancel</a> -->
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