<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Sap <small>DVR</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                DVR
                                <i class="fa fa-angle-right"></i>
                            </li>
                            
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">

        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		<form method="post" action="<?php echo base_url();?>sys/insert_dvr_sap">
        <input type="hidden" name="form_name" value="sap_dvr" />
          <div class="portlet box grey-cascade">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>View DVR </div>

              <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

            </div>

            <div class="portlet-body  flip-scroll">

                <div class="table-scrollable">
                    <?php
                            if(isset($_GET['msg']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        DVR Updated Successfully.  
                                      </div>';
                              }
                          ?>
                    <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
                    
                <table class="table table-striped table-bordered table-hover">

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
                <?php if (sizeof($get_eng_dvr) == "0") 
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
							  foreach ($get_eng_dvr as $eng_dvr) 
							  {
								  ?>
								 <tr class="odd gradeX">
                                        <td> 
                                        	<?php echo date('h:i A', strtotime($eng_dvr['start_time']))?>
                                        </td>
                                        
                                        <td> 
                                        	<?php echo date('h:i A', strtotime($eng_dvr['end_time']))?>			
                                        </td>
                                       
                                        <td> 
                                        	<input type="text"  readonly 
                                            value="<?php $maxqu = $this->db->query("SELECT * FROM tbl_cities where pk_city_id='".$eng_dvr['fk_city_id']."' ");
											$maxval=$maxqu->result_array();echo $maxval[0]['city_name'];?>" class="form-control">  
                                        </td>
                                        <td>
                                        	 <input type="text"  readonly
                                             value="<?php $maxqu = $this->db->query("SELECT * FROM tbl_clients where pk_client_id='".$eng_dvr['fk_customer_id']."' ");
											 $maxval=$maxqu->result_array();echo $maxval[0]['client_name'];?>" class="form-control"> 
                                        </td>   
                    
                                        
                                        <td>
                                        <?php $maxqu = $this->db->query("SELECT * FROM business_data where pk_businessproject_id='".$eng_dvr['fk_business_id']."' ");
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
											 }
											?>
                                        <input type="text"  readonly  value="<?php echo $businesstype_name;?>" class="form-control">  </td> 
                                             
                                         <td><input type="text"  readonly   value="<?php echo $description; ?>" 
                                            class="form-control timepicker timepicker-no-seconds">	</td> 
                                            
                                         <td><input type="text"  readonly   value="<?php echo $timeline;?>" 
                                            class="form-control timepicker timepicker-no-seconds">	</td> 
                                               
                                        <td> <input type="text" class="form-control" readonly value="<?php echo $eng_dvr['summery'];?>"> </td>
                                        <td> <input type="text" class="form-control" readonly  value="<?php echo $eng_dvr['next_plan'];?>"> </td>
                                 </tr>
						<?php }
                          
                }?>
                          

                </tbody>

              </table>

              </div>
                        
                 
                

            </div>

          </div>
		
          <div class="portlet box grey-cascade">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Enter Report</div>

              <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

            </div>

            <div class="portlet-body">

              
              
              			<div class="table-scrollable">
                            
                            
                <table class="table table-striped table-bordered table-hover">

                <thead>

                  <tr>
                    
                    <th colspan="2" style="padding-right:160px;"> Time </th>

                    <th style="padding-right:150px;"> Customer</th>
                    
                    <th style="padding-right:100px;"> City </th>
                    
                    <th> Business Project </th>
                    <th style="padding-right:100px;"> Description </th>
                    <th style="padding-right:100px;"> Timeline  </th>

                    <th> Working Details/ Discussion Summary </th>
                    
                    <th> Next Plan  </th>
                    <th> <a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a> </th>
                  </tr>


                </thead>
                

                <tbody class="append_tbody">

                  <tr class="odd gradeX">

                    <td> <input  name="starttime[0]" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds"  required>
 				
                    </td>
                    
                    <td> <input   name="endtime[0]" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"   required>						
                    </td>
                   
                    <td> 
                    		
                            <select class="form-control  " name="customer[0]" id="customer0"  onchange="show_cities(this.value,0)">

                              <option value="">--Choose--</option>
							  <?php $qu="SELECT 
											tbl_clients.pk_client_id, tbl_clients.client_name
											 FROM 
											 tbl_customer_sap_bridge 
											 INNER JOIN
											 tbl_clients
											 ON
											 tbl_clients.pk_client_id 	=	tbl_customer_sap_bridge.fk_client_id
											 where
											 tbl_customer_sap_bridge.fk_user_id =  '".$this->session->userdata('userid')."'";
							//echo $qu;exit;
							$gh=$this->db->query($qu);
							$rt=$gh->result_array();
                            foreach($rt as $value)
							  {
								  ?>
								  <option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?></option>
								  <?php
							  }?>

                            </select>
                    </td>
                    <td class="citiestd0"> 
                    <select class="form-control  " name="city[0]">
                              <option value="">--Choose--</option>
                              </select>
                    </td>

                    <td class="businessestd0">
                    <select class="form-control  "  name="business[0]">

                              <option value="0">--Choose--</option>

                            </select>
                    </td>
                    
                    
                    
                    
                    <td><input type="text"  readonly name="business_description[0]"  class="form-control business_description0">	</td> 
                                            
                    <td><input type="text"  readonly name="time_elaped[0]"  class="form-control time_elaped0" id="time_elaped0">	</td> 
                    <td> <input type="text" class="form-control" name="summery[0]"></td>
                    <td> <input type="text" class="form-control"  name="next_plan[0]" > </td>

                    <td> 
                    		<a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a>
                                        <br />
                            <a href="javascript:void()"><i class="fa fa-minus"></i></a> 
                     </td>

                  </tr>

                  
                </tbody>

              </table>
			  <script type="text/javascript">
				function show_cities(client_id,rowid)
				{
					var formdata =
					  {
						client_id: client_id,
						rowid: rowid
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/client_select_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".citiestd"+rowid).html(msg);
						$(".businessestd"+rowid).html('<select class="form-control  "  name="business['+rowid+']"><option value="2">--Choose--</option></select>');
						//alert(msg);
						}
					})
					return false;
				}
				function show_business(city_id,rowid)
				{
					
					var cutomer_id= $("#customer"+rowid).val();
					//alert(cutomer_id);
					var formdata =
					  {
						cutomer_id: cutomer_id,
						city_id: city_id,
						rowid: rowid
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/business_select_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".businessestd"+rowid).html(msg);
						//alert(msg);
						}
					})
					return false;
				}
				function fill_business_dec_and_timeelapsed(business_id,rowid)
				{
					 if(business_id=='others')
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
				}
				
                function add_row()
                  {
                    var count1=Math.floor(Math.random()*101);
                    $('.append_tbody').append('<tr class="odd gradeX"><td> <input  name="starttime['+count1+']" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds"   required></td><td> <input   name="endtime['+count1+']" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"   required></td><td><select class="form-control  " name="customer['+count1+']"  onchange="show_cities(this.value,'+count1+')"  id="customer'+count1+'" ><option value="">--Choose--</option><?php $qu="SELECT tbl_clients.pk_client_id, tbl_clients.client_name FROM tbl_customer_sap_bridge INNER JOIN tbl_clients ON tbl_clients.pk_client_id 	=	tbl_customer_sap_bridge.fk_client_id where tbl_customer_sap_bridge.fk_user_id =  '".$this->session->userdata('userid')."' AND tbl_clients.delete_status = '0'"; $gh=$this->db->query($qu); $rt=$gh->result_array(); foreach($rt as $value){ ?> <option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?></option> <?php }?></select></td><td class="citiestd'+count1+'"> <select class="form-control  " name="city['+count1+']"><option value="">--Choose--</option></td><td class="businessestd'+count1+'"><select class="form-control  "  name="business['+count1+']"><option value="">--Choose--</option><option value="MD">MDx Business</option><option value="ID">IDx Business</option></select></td><td><input type="text"  readonly name="business_description['+count1+']"  class="form-control business_description'+count1+'">	</td> <td><input type="text"  readonly name="time_elaped['+count1+']"  class="form-control time_elaped'+count1+'" id="time_elaped'+count1+'">	</td> <td> <input type="text" class="form-control" name="summery['+count1+']"></td><td> <input type="text" class="form-control"  name="next_plan['+count1+']" > </td><td><a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a><br /><a href="javascript:void()"><i class="fa fa-minus"></i></a></td></tr>');
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
            </div>
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-5 col-md-9">
                  <button type="submit" class="btn btn-circle blue">Submit</button>
             <!--     <button type="button" class="btn btn-circle default">Cancel</button>	-->
                </div>
              </div>
            </div>
           </div>
          </div>
          </form>
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>