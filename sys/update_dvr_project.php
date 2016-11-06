<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
						Update DVR <small>Edit report data </small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li><i class="fa fa-home"></i>Home<i class="fa fa-angle-right"></i></li>
                            <li>Update DVR</li>                           
                        </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">

        <div class="col-md-12"> 
		<?php
          if(isset($_GET['msg']))
            { 
              echo '<div class="alert alert-success alert-dismissable">  
                      <a class="close" data-dismiss="alert">×</a>  
                      DVR Updated Successfully.  
                    </div>';
            }
         ?>
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		<form method="post" action="<?php echo base_url();?>sys/edit_dvr_business/<?php echo $get_update_dvr_project_list[0]['pk_dvr_id']?>">
        <input type="hidden" name="form_name" value="sap_dvr" />
		<?php
		if(isset($_GET['engineer']) && isset($_GET['start_mydate']) && isset($_GET['end_mydate'])) {
			?>
			<input type="hidden" name="engineer" value="<?php echo $_GET['engineer']; ?>" />
			<input type="hidden" name="start_mydate" value="<?php echo $_GET['start_mydate']; ?>" />
			<input type="hidden" name="end_mydate" value="<?php echo $_GET['end_mydate']; ?>" />
			<?php }
			?>
          
          <div class="portlet box red">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-edit"></i>Update DVR</div>
              <div class="tools"> 
                  <a href="javascript:;" class="collapse"> </a> 
                  <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>

            <div class="portlet-body">
              <div class="table-scrollable">       
               <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
					<th > Date	</th>
                    <th colspan="2"> Time </th>
                    <th> Customer</th>
                    <th> City </th>
                    <th> Business Project </th>
                    <th> Description </th>
                    <th> Working Details/ Discussion Summary </th>
                    <th> Next Plan  </th>
                  </tr>
				</thead>
                

                <tbody class="append_tbody">
                  <tr>
				  
					  <td>
					  <input type="text" class="datepicker2 form-control " name="date" value="<?php echo date('d-M-Y', strtotime($get_update_dvr_project_list[0]['date'])); ?>" required/>
					  </td>

                    <td> <input  name="starttime[0]" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds" 
                    		value="<?php echo date('h:i A', strtotime($get_update_dvr_project_list[0]['start_time']));?>" required>
                            <input type="hidden" name="engineer" value="<?php echo $get_update_dvr_project_list[0]['fk_engineer_id'];?>" />
                    </td>
                    
                    <td> <input   name="endtime[0]" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"  
                   		 value="<?php echo date('h:i A', strtotime($get_update_dvr_project_list[0]['end_time']));?>" required>						
                    </td>
                   
                    <td> 
                            <select class="form-control  " name="customer[0]" id="customer0"  onchange="show_cities(this.value,0)">
                              <option value="">--Choose--</option>
							  <?php 
							  if($get_update_dvr_project_list[0]['userrole']=='Salesman'){
								  $qu="
									SELECT tbl_clients.pk_client_id, tbl_clients.client_name, tbl_cities.city_name, tbl_area.area
									 FROM tbl_customer_sap_bridge 
									 INNER JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_customer_sap_bridge.fk_client_id 
									 LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									 LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
									 WHERE tbl_clients.delete_status = '0'";
							  }
							  else $qu = "
									SELECT tbl_clients.*, tbl_cities.city_name, tbl_area.area
									from tbl_clients 
									LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
									where tbl_clients.delete_status = '0' AND tbl_clients.fk_office_id IN (".$get_update_vs_project_list[0]['user_office'].")";
							  
							if(substr($get_update_dvr_project_list[0]['fk_customer_id'],0,1)=='o') { 
								?>
								<option value="<?php echo $get_update_vs_project_list[0]['client_option'];?>" selected="selected" >
								  <?php echo $get_update_vs_project_list[0]['office_name'];?>
                                </option>
								<?php
								// below is new code added to show all customers if user want to update customer
								$gh=$this->db->query($qu);
								$rt=$gh->result_array();
								foreach($rt as $value)
								{
								  ?>
								  <option value="<?php echo $value['pk_client_id'];?>"  >
								  	<?php 	echo $value['client_name'];
											echo '--('.$value['city_name'].')';
											echo '--('.$value['area'].')';?>
                                  </option>
                             <?php
								}
								//end foreach
							}
							else {
							  $gh=$this->db->query($qu);
							  $rt=$gh->result_array();
							  foreach($rt as $value) {
								  ?>
								  <option value="<?php echo $value['pk_client_id'];?>" 
								  	<?php if($value['pk_client_id']==$get_update_dvr_project_list[0]['fk_customer_id']){ ?> selected="selected"<?php }?> >
								  	<?php 	echo $value['client_name'];
											echo '--('.$value['city_name'].')';
											echo '--('.$value['area'].')';?>
                                  </option>
								  <?php
							  }
							}?>
                            </select>
                    </td>
                    <td class="citiestd0"> 
                    <select class="form-control  " name="city[0]">
                                <option value="<?php echo $get_update_dvr_project_list[0]['pk_city_id']?>" selected="selected"><?php echo $get_update_dvr_project_list[0]['city_name']?></option>
                              </select>
                    </td>

                    <td class="businessestd0">
                    <?php
                    	$cutomer_id	=	$get_update_dvr_project_list[0]['fk_customer_id'];		
						$city_id	=	$get_update_dvr_project_list[0]['fk_city_id'];
						$rowid	=	0;
						
						$qu6="select * from user where id='".$get_update_dvr_project_list[0]['fk_engineer_id']."'";
						$gh6=$this->db->query($qu6);
						$rt6=$gh6->result_array();
						 //for business project
						 echo '<select class="form-control  " name="business['.$rowid.']" onchange="fill_business_dec_and_timeelapsed(this.value,'.$rowid.')" 
							  id="business'.$rowid.'" required>';
						   if($get_update_dvr_project_list[0]['fk_business_id']=='0') {
							  //////////////// Query for complaints
						   $ts_umber_quer="
							SELECT tbl_complaints.*, user.first_name, tbl_instruments.serial_no,tbl_products.product_name 
							FROM tbl_complaints 
							LEFT JOIN user ON tbl_complaints.assign_to = user.id
							LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
							LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
							WHERE tbl_complaints.fk_customer_id='".$cutomer_id."' AND tbl_complaints.status NOT IN ('Closed', 'Completed','Pending Registration')";
							
							$gh_tsnumber=$this->db->query($ts_umber_quer);
							$rt_ts_number=$gh_tsnumber->result_array();
							foreach($rt_ts_number as $value)
							{
								echo '<option value="tsnumber_' . $value['pk_complaint_id'] . '"';
								if($value['pk_complaint_id']==$get_update_dvr_project_list[0]['fk_complaint_id']) echo ' selected="selected"';
								echo '>';
								$cn = "TS";
								if ($value['complaint_nature']=='PM') $cn = "PM";
								echo $value['ts_number'].' - '.$cn.' - '.$value['product_name'].' ('.$value['serial_no'].') - '.$value['first_name'];//.' - '.$value['problem_summary'];
								echo '</option>';
							}
						   }
						   else
						   {
						   $maxqu3 = $this->db->query("
							SELECT business_data.*, tbl_business_types.businesstype_name
							FROM business_data 
							LEFT JOIN tbl_business_types ON business_data.`Business Project` = tbl_business_types.pk_businesstype_id
							WHERE Customer='".$get_update_dvr_project_list[0]['fk_customer_id']."' AND business_data.status='0' And `Sales Person`='".$get_update_dvr_project_list[0]['id']."'");
						   $maxval3=$maxqu3->result_array();
							
						   foreach($maxval3 as $business) {
							echo '<option value="';
							echo $business['pk_businessproject_id'];
							echo '"';
							if($business['pk_businessproject_id']==$get_update_dvr_project_list[0]['fk_business_id']) echo ' selected="selected"';
							echo '>';
							echo $business['businesstype_name'];
							echo '</option>';
						    }
						   }
			
							echo '<option value="others">Others</option>';
						echo '</select>';
					?>
                    </td>
                    <td>
                    <textarea readonly  name="business_description[0]" id="textarea" class="input-medium business_description0" required="" rows="4"><?php echo urldecode($get_update_dvr_project_list[0]['priority']);?></textarea>
                    </td>
                    <td> 
                    <textarea  name="summery[0]" id="textarea" class="input-medium" required="" rows="4"><?php echo urldecode($get_update_dvr_project_list[0]['summery']);?></textarea>
                    </td>
                    <td> 
                    <textarea  name="next_plan[0]" id="textarea" class="input-medium" required="" rows="4"><?php echo urldecode($get_update_dvr_project_list[0]['next_plan']);?></textarea>
                    </td>
                  </tr>
                </tbody>

              </table>
			  <script type="text/javascript">
				/*function show_cities(client_id,rowid)
				{
					alert(client_id);
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
						$(".businessestd"+rowid).html('<select class="form-control  "  name="business['+rowid+']"><option value="">--Choose--</option></select>');
						
						}
					})
					return false;
				}*/
				function show_cities(client_id,rowid)
				{
					var myengineer = <?php echo $get_update_dvr_project_list[0]['fk_engineer_id'];?>;
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
							var sales_person = <?php echo $get_update_dvr_project_list[0]['fk_engineer_id'];?>;
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
                <div class="col-md-offset-5 col-md-7">
                  <button type="submit" class="btn btn-lg default red">Update <i class="fa fa-check"></i></button>
                  
                </div>
              </div>
            </div>
           </div>
          </div>
          </form>
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
    <!-- END CONTENT -->
</div>
<style>
input.form-control {
  width: auto;
}
</style>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>