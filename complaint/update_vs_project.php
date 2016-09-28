<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Update VS <small>edit schedule details</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Update VS
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
                                    VS Updated Successfully.  
                                  </div>';
                          }
                       ?>
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                      <form method="post" action="<?php echo base_url();?>complaint/edit_vs_business/<?php echo $get_update_vs_project_list[0]['pk_vs_id']?>">
                      <input type="hidden" name="form_name" value="sap_dvr" />
					  <?php
		if(isset($_GET['engineer']) && isset($_GET['start_mydate']) && isset($_GET['end_mydate'])) {
			?>
			<input type="hidden" name="engineer" value="<?php echo $_GET['engineer']; ?>" />
			<input type="hidden" name="start_mydate" value="<?php echo $_GET['start_mydate']; ?>" />
			<input type="hidden" name="end_mydate" value="<?php echo $_GET['end_mydate']; ?>" />
			<?php }
			?>
                        
                      
                        <div class="portlet box blue">
              
                          <div class="portlet-title">
              
                            <div class="caption"> <i class="fa fa-edit"></i>Update VS</div>
              
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
                                  
                                  <th colspan="2" style="padding-right:160px;"> Time </th>
              
                                  <th style="padding-right:150px;"> Customer</th>
                                  
                                  <th style="padding-right:100px;"> City </th>
                                  
                                  <th> Business Project </th>
              
                                  <th> Working Details/ Discussion Summary </th>
                                </tr>
              
              
                              </thead>
                              
              
                              <tbody class="append_tbody">
              
                                <tr class="odd gradeX">
              
                                  <td> <input  name="starttime[0]" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds" 
                                          value="<?php echo date('h:i A', strtotime($get_update_vs_project_list[0]['start_time']));?>" required>
                                          <input type="hidden" name="engineer" value="<?php echo $get_update_vs_project_list[0]['fk_engineer_id'];?>" />
                              
                                  </td>
                                  
                                  <td> <input   name="endtime[0]" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"  
                                       value="<?php echo date('h:i A', strtotime($get_update_vs_project_list[0]['end_time']));?>" required>						
                                  </td>
                                 
                                  <td> 
                                          <?php
											$nsql="select * from user where id ='".$get_update_vs_project_list[0]['fk_engineer_id']."'";
											  $n2sql=$this->db->query($nsql);
											  $n3sql=$n2sql->result_array();
											  //echo $qu;exit;
											?>
                                          <select class="form-control  " name="customer[0]" id="customer0"  onchange="show_cities(this.value,0)">
              
                                            <?php 
							  
											  if($n3sql[0]['userrole']=='Salesman')
											  {
												  $qu="SELECT 
																tbl_clients.pk_client_id, tbl_clients.client_name
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
										//
										if(substr($get_update_vs_project_list[0]['fk_customer_id'],0,1)=='o')
										{ 
											$office_id		=	substr($get_update_vs_project_list[0]['fk_customer_id'],13,1);
											
											$qu2="SELECT * from tbl_offices where pk_office_id =  '".$office_id."'";
											$gh2=$this->db->query($qu2);
											$rt2=$gh2->result_array();
											?>
											<option value="<?php echo $rt2[0]['pk_office_id'];?>" selected="selected" >
                                                  <?php echo $rt2[0]['office_name'];?>
                                                </option>
											<?php
										}
										else
										{
                                          $gh=$this->db->query($qu);
                                          $rt=$gh->result_array();
                                          foreach($rt as $value)
                                            {
                                                ?>
                                                <?php if($value['pk_client_id']==$get_update_vs_project_list[0]['fk_customer_id'])
													  { ?>
                                                        <option value="<?php echo $value['pk_client_id'];?>" selected="selected" >
                                                          <?php echo $value['client_name'];?>
                                                        </option>
                                                <?php }
                                            }
										}?>
              
                                          </select>
                                  </td>
                                  <td class="citiestd0"> 
                                  <select class="form-control  " name="city[0]">
                                            <?php $qu8="SELECT * from tbl_cities where pk_city_id ='".$get_update_vs_project_list[0]['fk_city_id']."'";
                                                  $gh8=$this->db->query($qu8);
                                                  $rt8=$gh8->result_array(); 
                                              ?>
                                              <option value="<?php echo $rt8[0]['pk_city_id']?>" selected="selected"><?php echo $rt8[0]['city_name']?></option>
                                            </select>
                                  </td>
              
                                  <td class="businessestd0">
                                  <?php
                                      $cutomer_id	=	$get_update_vs_project_list[0]['fk_customer_id'];		
                                      $city_id	=	$get_update_vs_project_list[0]['fk_city_id'];
                                      $rowid	=	0;
                                       //for business project
                                       echo '<select class="form-control  " name="business['.$rowid.']" onchange="fill_business_dec_and_timeelapsed(this.value,'.$rowid.')" 
                                            id="business'.$rowid.'" required>';
                                         if($get_update_vs_project_list[0]['fk_business_id']=='0')
                                         {
                                            //
                                         }
                                         else
                                         {
                                         $maxqu3 = $this->db->query("SELECT * FROM business_data where pk_businessproject_id='".$get_update_vs_project_list[0]['fk_business_id']."' ");
                                         $maxval3=$maxqu3->result_array();
                                         //
                                         echo '<option value="';
                                          echo $maxval3[0]['pk_businessproject_id'];
                                          echo '" selected="selected">';
                                          $qu5="select * from tbl_business_types where pk_businesstype_id='".$maxval3[0]['Business Project']."'";
                                          $gh5=$this->db->query($qu5);
                                          $rt5=$gh5->result_array();
                                          
                                          echo $rt5[0]['businesstype_name'];
                                          echo '</option>';
                                         }
                          
                                          
                                          echo '<option value="others">Others</option>';
                                      echo '</select>';
                                  ?>
                                  </td>
                                  
                                  
                                  
                                  <td> 
                                  <textarea  name="summery[0]" id="textarea" class="input-medium" required="" rows="4"><?php echo urldecode($get_update_vs_project_list[0]['summery']);?></textarea>
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
                                  url: "<?php echo base_url();?>complaint/client_select_ajax",
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
                                <button type="submit" class="btn btn-lg default blue">Update <i class="fa fa-check"></i></button>
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