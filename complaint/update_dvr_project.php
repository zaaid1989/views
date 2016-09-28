<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Update DVR <small>Edit report data </small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Update DVR
                            </li>                           
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
		<form method="post" action="<?php echo base_url();?>complaint/edit_dvr_business/<?php echo $get_update_dvr_project_list[0]['pk_dvr_id']?>">
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
					<th style="padding-right:100px;"> Date	</th>
                    
                    <th colspan="2" style="padding-right:160px;"> Time </th>

                    <th style="padding-right:150px;"> Customer</th>
                    
                    <th style="padding-right:100px;"> City </th>
                    
                    <th> Business Project </th>
                    <th style="padding-right:100px;"> Description </th>

                    <th> Working Details/ Discussion Summary </th>
                    
                    <th> Next Plan  </th>
                  </tr>


                </thead>
                

                <tbody class="append_tbody">

                  <tr class="odd gradeX">
				  
				  <td>
				  <input type="text" class="datepicker2 form-control" name="date" value="<?php echo date('d-M-Y', strtotime($get_update_dvr_project_list[0]['date'])); ?>" required/>
				  </td>

                    <td> <input  name="starttime[0]" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds" 
                    		value="<?php echo date('h:i A', strtotime($get_update_dvr_project_list[0]['start_time']));?>" required>
                            <input type="hidden" name="engineer" value="<?php echo $get_update_dvr_project_list[0]['fk_engineer_id'];?>" />
 				
                    </td>
                    
                    <td> <input   name="endtime[0]" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"  
                   		 value="<?php echo date('h:i A', strtotime($get_update_dvr_project_list[0]['end_time']));?>" required>						
                    </td>
                   
                    <td> 
                    		
                            <?php
                            $nsql="select * from user where id ='".$get_update_dvr_project_list[0]['fk_engineer_id']."'";
							  $n2sql=$this->db->query($nsql);
							  $n3sql=$n2sql->result_array();
							  //echo $qu;exit;
							?>
                            <select class="form-control  " name="customer[0]" id="customer0"  onchange="show_cities(this.value,0)">

                              <option value="">--Choose--</option>
							  <?php 
							  
							  if($n3sql[0]['userrole']=='Salesman')
							  {
								  $qu="SELECT 
												tbl_clients.pk_client_id, tbl_clients.client_name, tbl_clients.fk_city_id, tbl_clients.fk_area_id
												 FROM 
												 tbl_customer_sap_bridge 
												 INNER JOIN
												 tbl_clients
												 ON
												 tbl_clients.pk_client_id 	=	tbl_customer_sap_bridge.fk_client_id";
								
							  }
							  else
							  {
								  // get all client of this this office id
								  $qu="SELECT * from tbl_clients where fk_office_id =  '".$n3sql[0]['fk_office_id']."'";
							  }
							if(substr($get_update_dvr_project_list[0]['fk_customer_id'],0,1)=='o')
							{ 
								$office_id		=	substr($get_update_dvr_project_list[0]['fk_customer_id'],13,1);
								
								$qu2="SELECT * from tbl_offices where pk_office_id =  '".$office_id."'";
								$gh2=$this->db->query($qu2);
								$rt2=$gh2->result_array();
								?>
								<option value="<?php echo $rt2[0]['client_option'];?>" selected="selected" >
								  <?php echo $rt2[0]['office_name'];?>
                                </option>
								<?php
								// below is new code added to show all customers if user want to update customer
								$gh=$this->db->query($qu);
								$rt=$gh->result_array();
								foreach($rt as $value)
								{
								  ?>
								  <option value="<?php echo $value['pk_client_id'];?>"  >
								  	<?php echo $value['client_name'];?>
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
							  }
								//end foreach
							}
							else
							{
							  $gh=$this->db->query($qu);
							  $rt=$gh->result_array();
							  foreach($rt as $value)
							  {
								  ?>
								  <option value="<?php echo $value['pk_client_id'];?>" 
								  	<?php if($value['pk_client_id']==$get_update_dvr_project_list[0]['fk_customer_id']){ ?>selected="selected"<?php }?> >
								  	<?php echo $value['client_name'];?>
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
							  }
							}?>
                            </select>
                    </td>
                    <td class="citiestd0"> 
                    <select class="form-control  " name="city[0]">
                              <?php $qu8="SELECT * from tbl_cities where pk_city_id ='".$get_update_dvr_project_list[0]['fk_city_id']."'";
									$gh8=$this->db->query($qu8);
									$rt8=$gh8->result_array(); 
								?>
                                <option value="<?php echo $rt8[0]['pk_city_id']?>" selected="selected"><?php echo $rt8[0]['city_name']?></option>
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
						   if($get_update_dvr_project_list[0]['fk_business_id']=='0')
						   {
							  //////////////// Query for complaints
						   $ts_umber_quer="select * from tbl_complaints where fk_customer_id='".$cutomer_id."' 
							AND status NOT IN ('Closed', 'Completed','Pending Registration')";
							//echo $ts_umber_quer;exit;
							$gh_tsnumber=$this->db->query($ts_umber_quer);
							$rt_ts_number=$gh_tsnumber->result_array();
							foreach($rt_ts_number as $value)
							{
								echo '<option value="';
								echo 'tsnumber_'.$value['pk_complaint_id'];
								echo '"';
								if($value['pk_complaint_id']==$get_update_dvr_project_list[0]['fk_complaint_id'])
								{
									echo ' selected="selected"';
								}
								echo '>';
								$cn = "TS";
								if ($value['complaint_nature']=='PM') $cn = "PM";
								$q = $this->db->query("SELECT first_name from user where id = '".$value['assign_to']."'");
								$u = $q->result_array();
								$q = $this->db->query("SELECT fk_product_id,serial_no from tbl_instruments where pk_instrument_id = '".$value['fk_instrument_id']."'");
								$i = $q->result_array();
								$q = $this->db->query("SELECT product_name from tbl_products where pk_product_id = '".$i[0]['fk_product_id']."'");
								$p = $q->result_array();
								echo $value['ts_number'].' - '.$cn.' - '.$p[0]['product_name'].' ('.$i[0]['serial_no'].') - '.$u[0]['first_name'];//.' - '.$value['problem_summary'];
								echo '</option>';
							}
						   }
						   else
						   {
						   $maxqu3 = $this->db->query("select * from business_data where 
						   Customer='".$get_update_dvr_project_list[0]['fk_customer_id']."' AND City='".$rt8[0]['pk_city_id']."'
						    and status='0' 
							AND Department='".$rt6[0]['department']."' And `Sales Person`='".$rt6[0]['id']."'");
						   //echo "SELECT * FROM business_data where pk_businessproject_id='".$get_update_dvr_project_list[0]['fk_business_id']."' ";
						   $maxval3=$maxqu3->result_array();
						   
							
						   foreach($maxval3 as $business)
						   {
						   //
						   echo '<option value="';
							echo $business['pk_businessproject_id'];
							echo '"';
							if($business['pk_businessproject_id']==$get_update_dvr_project_list[0]['fk_business_id'])
							{
								echo ' selected="selected"';
							}
							echo '>';
							$qu5="select * from tbl_business_types where pk_businesstype_id='".$business['Business Project']."'";
							$gh5=$this->db->query($qu5);
							$rt5=$gh5->result_array();
							
							echo $rt5[0]['businesstype_name'];
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
					url: "<?php echo base_url();?>complaint/client_select_ajax",
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
					url: "<?php echo base_url();?>complaint/form_client_select_ajax_for_cityid",
					type: 'POST',
					data: formdata,
					success: function(msg){
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
							var sales_person = <?php echo $get_update_dvr_project_list[0]['fk_engineer_id'];?>;
							var formdata_for_business =
							  {
								cutomer_id: client_id,// taken fron fuction parameter
								city_id: msg,// this value is from first ajax call
								rowid: rowid,
								sales_person:sales_person
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
					url: "<?php echo base_url();?>complaint/business_select_ajax",
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
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>