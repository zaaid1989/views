<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Sap <small>DVR FORM</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                SAP DVR Form
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

              <div class="caption"> <i class="fa fa-globe"></i>Enter Report</div>

              <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

            </div>
		    <div class="portlet-body form">
			<div class="note note-info">
								<h4 class="block">Note: TS/SAP Department can submit their DVRs from 8:00 AM to 8:00 AM of next day. After 8:00 AM, that DVR will be considered of the next day.</h4>
								<p>
								</p>
							</div>
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>complaint/insert_dvr_sap">
        	<input type="hidden" name="form_name" value="sap_dvr_form" />
            <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
            <?php
				  if(isset($_GET['msg']))
					{ 
					  echo '<div class="alert alert-success alert-dismissable">  
							  <a class="close" data-dismiss="alert">×</a>  
							  DVR Updated Successfully.  
							</div>';
					}
             ?>
            <div class="form-body">

                <div class="row">
                	<div class="col-md-12">
                        <div class="form-group">

                            <label class="col-md-3 control-label">Start Time</label>

                            <div class="col-md-8">

                                <input  name="starttime[0]" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds"  required>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">End Time</label>

                            <div class="col-md-8">

                                <input   name="endtime[0]" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"   required>	

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Customer</label>

                            <div class="col-md-8">

                                <select class="form-control  " name="customer[0]" id="customer0"  onchange="show_cities(this.value,0)" required>

                                      <option value="">--Choose--</option>
                                      <option value="officeoption_1">Rawalpindi Office (HO)</option>
                                      <option value="officeoption_2">Lahore Office (LO)</option>
                                      <option value="officeoption_3">Karachi Office (KO)</option>
                                      <option value="officeoption_4">Multan Office (MO)</option>
                                      <option value="officeoption_5">Peshawar (PO)</option>
                                      <?php $qu="SELECT 
                                                    tbl_clients.pk_client_id, COALESCE(tbl_clients.client_name) AS client_name,COALESCE(tbl_area.area) AS area
                                                     FROM 
                                                     tbl_customer_sap_bridge 
                                                     INNER JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_customer_sap_bridge.fk_client_id
													 LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
                                                     WHERE
                                                     tbl_customer_sap_bridge.fk_user_id =  '".$this->session->userdata('userid')."' AND tbl_clients.delete_status ='0'  ";
                                    
                                    $gh=$this->db->query($qu);
                                    $rt=$gh->result_array();
                                    foreach($rt as $value)
                                      {
                                          // $qu5="SELECT * FROM tbl_area  where pk_area_id =  '".$value['fk_area_id']."'";
										 // echo $qu5;
										  // $gh5	=	$this->db->query($qu5);
										  // $rt5	=	$gh5->result_array();
										  ?>
                                          <option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'].'--('.$value['area'].')';?>
										  <?php ///////////////////////////////////////////////////////// **** Zaaid *******/////////////////////////
												/*	$quw2="SELECT * from tbl_cities where pk_city_id='".$value['fk_city_id']."'";
													$ghw2=$this->db->query($quw2);
													$rtw2=$ghw2->result_array();
													//echo '--('.$rtw2[0]['city_name'].')';
													//for area
													$quw3="SELECT * from tbl_area where pk_area_id='".$value['fk_area_id']."'";
													$ghw3=$this->db->query($quw3);
													$rtw3=$ghw3->result_array();
													echo '--('.$rtw3[0]['area'].')'; */
													///////////////////////////////////////////////////////// **** Zaaid *******/////////////////////////
													?>	
										  
										  </option>
                                          <?php
                                      }?>
        
                                    </select>

                            </div>

                        </div>
                        <?php //echo $qu;exit; ?>
                        <div class="form-group">

                            <label class="col-md-3 control-label">City</label>

                            <div class="col-md-8 citiestd0">

                                 <select class="form-control  " name="city[0]" required>
                                     <option value="">--Choose--</option>
                                 </select>
                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Business Project</label>

                            <div class="col-md-8 businessestd0">

                                <select class="form-control  "  name="business[0]" required>
    
                                  <option value="">--Choose--</option>
    
                                </select>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Description</label>

                            <div class="col-md-8">

                                <input type="text"  readonly name="business_description[0]"  class="form-control business_description0" required>

                            </div>

                        </div>
						
						
						
                        <div class="form-group">

                            <label class="col-md-3 control-label">Time Elapsed</label>

                            <div class="col-md-8">

                                <input type="text"  readonly name="time_elaped[0]"  class="form-control time_elaped0" id="time_elaped0" required>	        
                            </div>

                        </div>
					<div id="strategy_div">
						<div class="form-group">

                            <label class="col-md-3 control-label">Tactics / Actions</label>

                            <div class="col-md-8">

                                <input type="text"   name="tactics[0]"  class="form-control tactics0 readonly" required>

                            </div>

                        </div>
						
						 <div class="form-group">

                            <label class="col-md-3 control-label">Target Date</label>

                            <div class="col-md-8">

                                <input type="text"   name="target_date[0]"  class="form-control target_date0 readonly" id="target_date0" required>	        
                            </div>

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
					
						if(timepicker1_ampm=='PM' && timepicker1_hr<12 )
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
						alert("End time must be greater than start time");
						return false;
					}
				}
				function show_cities(client_id,rowid)
				{
					var formdata =
					  {
						client_id: client_id,
						rowid: rowid
					  };
				  $.ajax({
					url: "<?php echo base_url();?>complaint/form_client_select_ajax_for_cityid",
					type: 'POST',
					data: formdata,
					success: function(msg){
						
						//$(".citiestd"+rowid).html(msg);
						//these two are inner ajax
						$.ajax({
							url: "<?php echo base_url();?>complaint/form_client_select_ajax",
							type: 'POST',
							data: formdata,
							success: function(msg2){
								$(".citiestd"+rowid).html(msg2);
								//alert(msg);
								}
							})
							
							var formdata_for_business =
							  {
								cutomer_id: client_id,// taken fron fuction parameter
								city_id: msg,// this value is from first ajax call
								rowid: rowid
							  };
						$.ajax({
							url: "<?php echo base_url();?>complaint/form_business_select_ajax",
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
					 if(business_id=='others' || business_id=='')
				  {
					  $(".business_description"+rowid).prop("readonly",false);
					  $(".time_elaped"+rowid).prop("readonly",false);
					 // $(".target_date"+rowid).prop("readonly",false);
					 // $(".tactics"+rowid).prop("readonly",false);
					  $(".time_elaped"+rowid).val('');
					  $(".business_description"+rowid).val('');
					  $("#strategy_div").html('');
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
					url: "<?php echo base_url();?>complaint/business_dec_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".business_description"+rowid).val(msg);
						//alert(msg);
						}
					})
					$.ajax({
					url: "<?php echo base_url();?>complaint/business_time_elapsed_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".time_elaped"+rowid).val(msg);
						//alert(msg);
						}
					})
					$.ajax({
					url: "<?php echo base_url();?>complaint/business_target_date_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
							$("#strategy_div").html(msg);
							$('.datepicker2').datepicker({
								dateFormat: 'dd-M-yy'
								});
						}
					})
					/*
					$.ajax({
					url: "<?php echo base_url();?>complaint/business_tactics_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
							if (msg!="") {
								//$(".tactics"+rowid).val(msg);
								//alert(msg);
							}
						}
					})*/
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
                <div class="col-md-offset-5 col-md-9">
                  <button type="submit" class="btn btn-circle blue" onclick="return check_range()">Submit</button>
           <!--       <button type="button" class="btn btn-circle default">Cancel</button>	-->
                </div>
              </div>
            </div>
           </div>
           </form>
           </div>
          </div>
          <div class="portlet box grey-cascade">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>View DVR </div>

              <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

            </div>

            <div class="portlet-body">
              <div class="row">
              <div class="col-md-12">
                <div class="table-scrollable">
                <table class="table table-hover table-bordered">

                <thead>

                   <tr>
                  
                    <th colspan="2" style="padding-right:150px;"> Time </th>
                    
                    <th style="padding-right:100px;"> City </th>

                    <th style="padding-right:150px;"> Customer</th>
                    
                    <th> Business Project </th>
                    <th style="padding-right:100px;"> Description </th>
                    <th style="padding-right:100px;"> Timeline  </th>

                    <th style="padding-right:100px;"> Working Details/ Discussion Summary </th>
                    
                    <th> Next Plan  </th>
                 

                  </tr>


                </thead>
				
                <tbody>
                <?php 
				$dbres = $this->db->query("SELECT * FROM tbl_dvr where fk_engineer_id = '".$this->session->userdata('userid')."' AND date like '".date('Y-m-d')."%'");
						$table 		= "tbl_dvr";
						$engineer	= $this->session->userdata('userid');
						$dbres 			= 	$this->db->query("
						SELECT 
						$table.* ,
						COALESCE(NULLIF(tbl_complaints.ts_number, ''), '') AS ts_number,
						COALESCE(NULLIF(tbl_complaints.problem_summary, ''), '') AS problem_summary,
						COALESCE(tbl_area.area) AS area,
						COALESCE(tbl_cities.city_name) AS city_name,
						COALESCE(tbl_clients.client_name) AS client_name,
						COALESCE(tbl_offices.office_name) AS office_name,
						COALESCE(user.first_name) AS first_name,
						COALESCE(business_data.`Project Description`) AS `Project Description`,
						COALESCE(tbl_business_types.businesstype_name) AS businesstype_name 
						
						FROM $table 
						LEFT JOIN tbl_offices ON $table.fk_customer_id = tbl_offices.client_option
						LEFT JOIN tbl_clients ON $table.fk_customer_id = tbl_clients.pk_client_id
						LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
						LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
						LEFT JOIN business_data ON $table.fk_business_id = business_data.pk_businessproject_id
						LEFT JOIN tbl_business_types ON business_data.`Business Project` = tbl_business_types.pk_businesstype_id
						LEFT JOIN tbl_complaints ON $table.fk_complaint_id = tbl_complaints.pk_complaint_id
						LEFT JOIN user ON $table.fk_engineer_id = user.id
						
						WHERE  
						$table.date like '".date('Y-m-d')."%' AND $table.fk_engineer_id = '".$engineer."'");
						$get_eng_dvrr	=	$dbres->result_array();
				
				if (sizeof($get_eng_dvrr) == "0") 
				{
										  
				} 
				else 
				{
							  function nicetime($date)
										{
											if(empty($date)) {
												return "No date provided";
											}
											$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
											$lengths         = array("60","60","24","7","4.35","12","10");
											$now             = time();
											$unix_date         = strtotime($date);
											   // check validity of date
											if(empty($unix_date)) {   
												return "Bad date";
											}
											// is it future date or past date
											if($now > $unix_date) {   
												$difference     = $now - $unix_date;
												$tense         = "ago";
											} else {
												$difference     = $unix_date - $now;
												$tense         = "from now";
											}
											for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
												$difference /= $lengths[$j];
											}
											$difference = round($difference);
											if($difference != 1) {
												$periods[$j].= "s";
											}
											return "$difference $periods[$j] {$tense}";
										}
										//end nice time fucntion
							  foreach ($get_eng_dvrr as $eng_dvr) 
							  {
								  ?>
								 <tr class="odd gradeX">
                                        <td> 
                                        	<?php echo date('h:i A', strtotime($eng_dvr['start_time']))?>
                                        </td>
                                        
                                        <td> 
                                        	<?php echo date('h:i A', strtotime($eng_dvr['end_time']))?>			
                                        </td>
                                       <?php
                                        	// to check whether office id is stored or customer id is stored. office can be customer too.
										if(substr($eng_dvr['fk_customer_id'],0,1)=='o')
										{
											// $office_id		=	substr($eng_dvr['fk_customer_id'],13,1);
											// $qu2			=	"SELECT * from tbl_offices where pk_office_id =  '".$office_id."'";
											// $gh2			=	$this->db->query($qu2);
											// $rt2			=	$gh2->result_array();
											$myclient 		= 	$eng_dvr['office_name'];
											$city_n			=   $eng_dvr['office_name'];
										}
										else
										{
											 // $maxqu = $this->db->query("SELECT * FROM tbl_clients where pk_client_id='".$eng_dvr['fk_customer_id']."' ");
											 // $maxval=$maxqu->result_array();
											 $myclient = $eng_dvr['client_name'];
											 $city_n	=   $eng_dvr['city_name'];
										}
										?>
                                        <td> 
                                        	<input type="text"  readonly 
                                            value="<?php 
											// $maxqu = $this->db->query("SELECT * FROM tbl_cities where pk_city_id='".$eng_dvr['fk_city_id']."' ");
											// $maxval=$maxqu->result_array();
											echo $city_n;?>" class="form-control">  
                                        </td>
                                        
                                        <td>
                                        	 <input type="text"  readonly
                                             value="<?php echo $myclient;?>" class="form-control"> 
                                        </td>   
                    
                                        
                                        <td>
                                        <?php /* $maxqu = $this->db->query("SELECT * FROM business_data where `Business Project`='".$eng_dvr['fk_business_id']."'  and Customer='".$eng_dvr['fk_customer_id']."' ");
											if($maxqu->num_rows()>0)
											 { 
												 $maxval=$maxqu->result_array();
												 $maxqu2 = $this->db->query("SELECT * FROM tbl_business_types where pk_businesstype_id='".$maxval[0]['Business Project']."' ");
											 
												 $maxval2			=	$maxqu2->result_array();
												 $businesstype_name	=	$maxval2[0]['businesstype_name'];
												 $description=$maxval[0]['Project Description'];
												 $timeline=  nicetime($maxval[0]["Date"]);
											 }
											 else
											 {
												 $businesstype_name	=	'';
												 $description='';
												 $timeline=  '';
											 } */
											 ?>
											 <?php //////////////////// zaaid /////////////////////////////////
										/*
										$maxqu = $this->db->query("SELECT * FROM business_data where pk_businessproject_id='".$eng_dvr['fk_business_id']."' ");
											if($maxqu->num_rows()>0)
											 { 
												 // $maxval			=	$maxqu->result_array();
												 // $maxqu2 			= 	$this->db->query("SELECT * FROM tbl_business_types where pk_businesstype_id='".$maxval[0]['Business Project']."' ");
												 // $maxval2			=	$maxqu2->result_array();
												 $businesstype_name	=	$eng_dvr['businesstype_name'];
												 // $description=$maxval[0]['Project Description'];
												 $description		=	$eng_dvr['priority'];
												 $timeline			=  $eng_dvr['timeline'];
											 }
											 else
											 {
												 $businesstype_name	=	'Others';
												 $description		=	$eng_dvr['priority'];
												 $timeline			=  	$eng_dvr['timeline'];
											 }*/
											 $description		=	$eng_dvr['priority'];
											$timeline			=  	$eng_dvr['timeline'];
											 if(substr($eng_dvr['fk_customer_id'],0,1)=='o') $businesstype_name		=   '';
											 else {
												 //for business project
												 if($eng_dvr['fk_business_id']=='0') {
													 if($eng_dvr['fk_complaint_id']=='0') $businesstype_name		=   'Others';
													 else {
														 $businesstype_name			= $eng_dvr['ts_number'];
														 $description				= $eng_dvr['problem_summary'];
													 }
												 }
												 else $businesstype_name = $eng_dvr['businesstype_name'];
												 
											}
											 ////////////////////////// zaaid ////////////////////////////////
											?>
											
                                        <input type="text"  readonly  value="<?php echo $businesstype_name;?>" class="form-control">  </td> 
                                             
                                         <td><input type="text"  readonly   value="<?php echo urldecode($description); ?>" 
                                            class="form-control timepicker timepicker-no-seconds">	</td> 
                                            
                                         <td><input type="text"  readonly   value="<?php echo $timeline;?>" 
                                            class="form-control timepicker timepicker-no-seconds">	</td> 
                                        <td> <input type="text" class="form-control" readonly value="<?php echo urldecode($eng_dvr['summery']);?>"> </td>
                                        <td> <input type="text" class="form-control" readonly  value="<?php echo urldecode($eng_dvr['next_plan']);?>"> </td>
                                 </tr>
						<?php }
                          
                }?>
                          

                </tbody>

              </table>
              </div>
            </div>
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
<script>
    $(".readonly").keydown(function(e){
        e.preventDefault();
    });
</script>