<?php $this->load->view('header');
function Get_Date_Difference($start_date, $end_date)
    {
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        echo (($years > 0) ? $years.' year'.(($years > 1 ? 's ' : '')) : '').(($months > 0) ? (($months == 1) ? ' '.$months.' month' : ' '.$months.' months' ) : '').(($days > 0) ? (($days == 1) ? ' '.$days.' day' : ' '.$days.' days' ) : '');
    }

?>
            
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Update Customer <small>update customer's data</small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> Home  <i class="fa fa-angle-right"></i> </li>
                        <li> <a href="<?php echo base_url();?>sys/customers_view">Customers</a> <i class="fa fa-angle-right"></i> </li>
                        <li> Update Customer </li>
                      </ul>
                    </div>
                    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

                <div class="portlet box blue-ebonyclay">
                  <div class="portlet-title">
                    <div class="caption"> <i class="fa fa-edit"></i>Update Customer </div>
                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                  </div>

                  <div class="portlet-body form"> 
                    <!-- BEGIN FORM-->
                    <form action="<?php echo base_url(); ?>sys/update_customer/<?php echo $get_customers_list[0]['pk_client_id'];?>"  enctype="multipart/form-data" class="form-horizontal" method="post">

                      <div class="form-body">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Customer Name</label>
                          <div class="col-md-8">
                            <input type="text" class="form-control " name="client_name" value="<?php echo $get_customers_list[0]['client_name'];?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-3 control-label">City</label>
                          <div class="col-md-8">
                            <select class="form-control  " name="client_city" onchange="select_teritory(this.value)">
                              <option value="">--Choose--</option>
                              <?php
                              $maxqu = $this->db->query("SELECT * FROM tbl_cities ");
							  $maxval=$maxqu->result_array();
							  foreach($maxval as $cities){
							  ?>
                              <option value="<?php echo $cities['pk_city_id']?>" <?php if($get_customers_list[0]['fk_city_id']==$cities['pk_city_id']){ echo 'selected';}?>>
							  	<?php echo $cities['city_name']?>
                              </option>
                              <?php }?>
                            </select>
                          </div>

                        </div>
                        <script>
						function select_teritory(city_id)
						{
							var formdata =
							  {
								city_id: city_id,
								sec_var: 'second'
							  };
						  $.ajax({
							url: "<?php echo base_url();?>sys/teritory_list_ajax",
							type: 'POST',
							data: formdata,
							success: function(msg){
								$(".teritory_content").html(msg);
								}
							})
							return false;
						}
						</script>

                        <div class="form-group">
                          <label class="col-md-3 control-label">Territory</label>
                          <div class="col-md-8 teritory_content">
                            <select class="form-control  " name="territory">
                              <option value="">--Choose--</option>
                              <?php
                              $maxqu = $this->db->query("SELECT * FROM tbl_offices ");
							  $maxval=$maxqu->result_array();
							  foreach($maxval as $cities)
							  {
							  ?>
                              <option value="<?php echo $cities['pk_office_id']?>"  <?php if($get_customers_list[0]['fk_office_id']==$cities['pk_office_id']){ echo 'selected';}?>>
							  	<?php echo $cities['office_name']?>
                              </option>
                              <?php }?>
                            </select>
                          </div>
                        </div>
                       
                        <div class="form-group">
                          <label class="col-md-3 control-label">Area</label>
                          <div class="col-md-8">
                            <select class="form-control  " name="area">
                              <option value="">--Choose--</option>
                              <?php
                              $maxqu = $this->db->query("SELECT * FROM tbl_area");
							  $maxval=$maxqu->result_array();
							  foreach($maxval as $cities){
							  ?>
                              <option value="<?php echo $cities['pk_area_id']?>"  <?php if($get_customers_list[0]['fk_area_id']==$cities['pk_area_id']){ echo 'selected';}?>>
							  	<?php echo $cities['area']?>
                              </option>
                              <?php }?>
                            </select>
                          </div>
                        </div>
                         
                       <div class="form-group">
	                        <label class="col-md-3 control-label">Lab Contact Number</label>
                            <div class="col-md-8">
                            	<input type="text" class="form-control " name="contactno"  value="<?php echo $get_customers_list[0]['contact_no'];?>" >
                            </div>
                        </div>
                        
                        <div class="form-group">
	                        <label class="col-md-3 control-label">Website</label>
                            <div class="col-md-8">
                            	<input type="text" class="form-control " name="website"   value="<?php echo $get_customers_list[0]['website'];?>" >
                            </div>
                        </div>
                       
                        <div class="form-group">
	                        <label class="col-md-3 control-label">Address</label>
                            <div class="col-md-8">
                            	<textarea class="form-control " rows="3" name="address" ><?php echo $get_customers_list[0]['address'];?></textarea>
                            </div>
                        </div>
						
               <div class="portlet box blue-steel">
                       <div class="portlet-title">
                           <div class="caption"> <i class="fa fa-globe"></i>Pathologists </div>
                      </div>
                            <div class="portlet-body">
                                  <table class="table table-hover table-bordered">
                                    <thead>
                                      <tr>
                                        <th> Name</th>
                                        <th> Contact No </th>
                                        <th> Email </th>
                                        <th> Add row &nbsp; <a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a></th>
									</tr>
                                    </thead>
                                    <tbody class="append_tbody">

                                      <?php 
													  $ty=$this->db->query("select * from tbl_clients_pathologists
													   WHERE fk_client_id='".$get_customers_list[0]['pk_client_id']."'");
													  $rt=$ty->result_array();
													  $n=0;
													  foreach($rt as $education_records)
													  {?>
                                                     <tr>

                                                        <td> <input type="text" class="form-control" name="pathalogist_name[<?php echo $n;?>]" 
                                                        		value="<?php echo $education_records['name'];?>"> 
                                                        </td>
                
                                                        <td> <input type="text" class="form-control" name="pathalogist_contact_no[<?php echo $n;?>]"
                                                         value="<?php echo $education_records['contact_no'];?>"> </td>
                
                                                        <td> <input type="text" class="form-control" name="pathalogist_email[<?php echo $n;?>]" 
                                                        value="<?php echo $education_records['email'];?>"> </td>
                
                                                        <td> <a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a>
                                                        <br />
                                                            <a href="javascript:void()"><i class="fa fa-minus"></i></a> 
                                                       </td>
                                                
                                                    </tr>
                                                    <?php 
													$n++;
													}?>
                                    </tbody>
                                  </table>
                                </div>
                            <!-- END SAMPLE TABLE PORTLET--> 
                          </div>

				<script type="text/javascript">
                  function add_row()
                    {
                      var count1=Math.floor(Math.random()*101);
                      $('.append_tbody').append('<tr><td><input  name="pathalogist_name['+count1+']" type="text" class="form-control"></td><td><input type="text"  name="pathalogist_contact_no['+count1+']" class="form-control"></td><td><input name="pathalogist_email['+count1+']" type="text" class="form-control"> </td><td><a href="#"><i class="fa fa-plus"></i></a><br /><a href="javascript:void()"><i class="fa fa-minus"></i></a></td></tr>');
                      $('select').select2();
                      $( ".fa-minus" ).click(function(event) {
                            $(this).closest('tr').remove();
                        });
                     }
                     $( ".fa-minus" ).click(function(event) {
                        $(this).closest('tr').remove();
                    });
                </script>

						<div class="">
                        <div class="row">
                          <div class="col-md-offset-5 col-md-7">
                            <button type="submit" class="btn btn-lg default green">Save <i class="fa fa-check"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>
                        
               <div class="portlet light bg-inverse">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-link"></i>Assigned Customer List</div>
                            <div class="tools"> 
                                <a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url()?>sys/add_acs/<?php echo $this->uri->segment(3);?>"  class="btn btn-default green">
                            	Add ACS &nbsp;<i class="fa fa-plus" style="color:#fff;"></i> 
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <div class="portlet-body flip-scroll">
                             <table class="table table-bordered table-hover flip-content" id="sample_2">
                              <thead class="bg-blue">
                                <tr>
                                  <th> Sales Person 			</th>
                                  <th> Delete 					</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  $dbres = $this->db->query("SELECT tbl_customer_sap_bridge.*,user.first_name FROM tbl_customer_sap_bridge
									  LEFT JOIN user ON tbl_customer_sap_bridge.fk_user_id = user.id
									  where tbl_customer_sap_bridge.fk_client_id='".$this->uri->segment(3)."'");
            						  $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {} else {
										  foreach ($dbresResult as $get_acs_list) {
											  ?>
											  <tr>
                                                  <td><?php echo $get_acs_list["first_name"]; ?></td>
												  <td>
                                                  	  <a class="btn btn-default red" onClick="return confirm('Are you sure you want to delete?')" 
                                                      href='<?php echo base_url();?>sys/delete_asc/<?php echo $get_acs_list["pk_customer_sap_bridge_id"];?>?cust=<?php echo $get_acs_list["fk_client_id"];?>'>
                                                      	Delete
                                                      </a>
												  </td>
												 
											  </tr>
											  <?php
										  }
									  }
                              ?>
                                
                              </tbody>
                            </table>
                           </div>
                          </div>
                        </div>
               
               <div class="portlet light bg-inverse">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-briefcase"></i>Customer Projects </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url()?>sys/add_business_project/<?php echo $this->uri->segment(3);?>"  class="btn btn-default green">
                            				Add Business Project
                                        <i class="fa fa-plus blue" style="color:#fff;"></i> 
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <div class="portlet-body flip-scroll">
                             <table class="table table-striped table-bordered table-hover flip-content dataaTable" id="">
                              <thead class="bg-blue">
                             
                                <tr>
                                  <th> Date 			</th>
                                  <th> Department 			</th>
                                  <th> Sales Person 	</th>
								  <th> Project Type	</th>
                                  <th> Category 		</th>
                                  <th> Project Description			</th>
                                  <th> Last Visit </th>
                                  <th> No of Visits </th>
                                  <th> Actions			</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  $dbres = $this->db->query("
										SELECT business_data.*,
										COALESCE(user.first_name) AS first_name,
										COALESCE(tbl_business_types.businesstype_name) AS businesstype_name,
										DATE_FORMAT(MAX(tbl_dvr.date),'%d-%b-%Y') AS dvr_date,
										COUNT(tbl_dvr.date) AS total_visits 
										FROM business_data 

										LEFT JOIN user ON business_data.`Sales Person` = user.id 
										LEFT JOIN tbl_business_types ON business_data.`Business Project`  = tbl_business_types.pk_businesstype_id
										LEFT JOIN tbl_dvr ON business_data.pk_businessproject_id = tbl_dvr.fk_business_id
								
									  where business_data.status='0' and business_data.Customer='".$this->uri->segment(3)."'
									  GROUP BY pk_businessproject_id
									  ");
									  $dbresResult=$dbres->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $my_business_data) {
											  ?>
											  <tr class="odd gradeX">
												  <td><?php echo date('d-M-Y', strtotime($my_business_data["Date"])); ?></td>
                                                  <td><?php echo $my_business_data["Department"]; ?></td>
                                                   <td><?php echo $my_business_data["first_name"]; ?></td>
												   <td><?php echo $my_business_data["project_type"];?></td>
												   <td><?php echo $my_business_data["businesstype_name"]; ?></td>
												  <td><?php echo $my_business_data["Project Description"]; ?></td>
												  <td><?php echo $my_business_data["dvr_date"];//date('d-M-Y',strtotime($my_business_data["dvr_date"]));?></td>
												  <td><?php echo $my_business_data["total_visits"]; ?></td>
												  
                                                  <td>
												  <div class="btn-group-vertical btn-group-solid">
														<a class="btn btn-sm default green-meadow-stripe" 
														href="<?php echo base_url();?>sys/update_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>?cust=<?php echo $get_acs_list["fk_client_id"];?>">
															Update
														</a>
														
														<a class="btn btn-sm default blue-hoki-stripe" 
														href="<?php echo base_url();?>sys/details_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>">
															Details
														  </a>
														<a href="#" id="sample_editable_1_new" class="btn btn-sm default red-thunderbird-stripe" data-toggle="modal" data-target="#myModal<?php echo $my_business_data["pk_businessproject_id"];?>" > 
															Delete
															<i class="fa fa-trash-o"></i> 
														</a>
													</div>
													
													<!-- Modal -->
							<div id="myModal<?php echo $my_business_data["pk_businessproject_id"];?>" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Delete Project</h4>
								  </div>
								  <div class="modal-body">
								   <form action="<?php echo base_url();?>sys/delete_business_project/<?php echo $my_business_data["pk_businessproject_id"];?>?cust=<?php echo $get_acs_list["fk_client_id"];?>" class="form-horizontal" method="post">
								   
                                    <div class="form-group row">
									<label class="col-md-3 control-label">Result</label>
									<div class="col-md-9">
									<select id="result" name="result" class="form-control" required>
                                        <option value="">--Choose--</option>
                                        <option value="Won" >Won</option>
                                        <option value="Lost" >Lost</option>
                                        <option value="Discarded" >Discarded</option>
                                    </select> 
									</div>
									</div>
                                    
									<input type="hidden" name="fk_complaint_id" value="<?php //echo $this->uri->segment(3);?> ">
                    
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-offset-8 col-md-4">
                                                        <input type="hidden" name="complaint_id" value="<?php //echo $this->uri->segment(3);?>" />
                                                        <button type="submit" class="btn red-thunderbird" >
                                                        	Delete
                                                        </button>
                                                       <button type="button" class="btn default" data-dismiss="modal">Cancel</button> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                        </div>
                                    </div>
            					</form>
								  </div>
								</div>
							  </div>
							</div>
                        <!-- End Modal -->
													</td>
											  </tr>
											  <?php
										  }
									  }
                              ?>
                                
                              </tbody>
                            </table>
                                      </div>
                          </div>
                        </div>
						
						
						<!--------------  **************** Equipment *************** ---------------->
						
				<div class="portlet light bg-inverse">
                  <div class="portlet-title">
                    <div class="caption"> <i class="icon-flag"></i>Equipments Installed</div>
                  </div>
                  <div class="portlet-body">
              	   <div class="portlet-body flip-scroll">
                   <table class="table table-striped table-bordered table-hover flip-content dataaTable" id="">
                      <thead class="bg-grey-gallery">
					  
                        <tr>
						  <th> Installed Duration	</th>
                          <th> Vendor Name 			</th> 
                          <th> Equipment   			</th>
                          <th> Serial Number 		</th>
                          <th> Status  				</th>
                          <th> Actions  			</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                             $ty=$this->db->query("SELECT tbl_instruments.*,
							 COALESCE(tbl_products.product_name) AS product_name,
							 COALESCE(tbl_vendors.vendor_name) AS vendor_name
							 FROM tbl_instruments 
							 LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
							 LEFT JOIN tbl_vendors ON tbl_instruments.fk_vendor_id = tbl_vendors.pk_vendor_id
							 WHERE tbl_instruments.fk_category_id!=1 AND tbl_instruments.fk_client_id='".$this->uri->segment(3)."'");
                             $rt=$ty->result_array();
							  if (sizeof($rt) == "0") {
                                  
                              } else {
                                  foreach ($rt as $get_users_list) {
										$d1 = date('Y-m-d',strtotime($get_users_list["install_date"]));
										$d2 = date('Y-m-d');
                        ?>
										<tr>
											<td><?php echo Get_Date_Difference($d1,$d2);?></td>
											<td><?php echo $get_users_list["vendor_name"]; // ?></td>
											<td><?php echo $get_users_list["product_name"];// ?></td>
											<td><?php echo $get_users_list["serial_no"];?></td>
											<td>
											<?php 
												if($get_users_list["status"]=='1') echo "<label class='label bg-blue'>Active</label>";
												if($get_users_list["status"]=='2') echo "<label class='label bg-yellow-zed'>Inactive</label>";
												if($get_users_list["status"]=='3') echo "<label class='label bg-red'>Expired</label>";
											?> 
											</td>
											<td>
													<a class="btn default purple"
												  href="<?php echo base_url();?>sys/equipment_audit?equipment=<?php echo $get_users_list["pk_instrument_id"];?>">
													Audit <i class="fa fa-edit"></i>
													</a>
											</td>
                                      </tr>
                                      <?php
                                  }
                              }
                      ?>
                        
                      </tbody>
                    </table>
                   </div>
                  </div>
                </div>
						<!--------------  **************** Auxiliary Equipment *************** ---------------->
						
				<div class="portlet light bg-inverse">
                  <div class="portlet-title">
                    <div class="caption"> <i class="icon-flag"></i>Auxiliary Equipment Installed</div>
                  </div>
                  <div class="portlet-body">
              	   <div class="portlet-body flip-scroll">
                   <table class="table table-striped table-bordered table-hover flip-content dataaTable" id="">
                      <thead class="bg-grey-gallery">
					  
                        <tr>
						  <th> Installed Duration	</th>
                          <th> Vendor Name 			</th> 
                          <th> Equipment   			</th>
                          <th> Serial Number 		</th>
						 <th> Description  				</th>
						 <th> Price  				</th>
                          <th> Status  				</th>
                          <th> Actions  			</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                             $ty=$this->db->query("select * from tbl_instruments WHERE fk_category_id=1 AND fk_client_id='".$this->uri->segment(3)."'");
							 $ty=$this->db->query("SELECT tbl_instruments.*,
							 COALESCE(tbl_products.product_name) AS product_name,
							 COALESCE(tbl_vendors.vendor_name) AS vendor_name
							 FROM tbl_instruments 
							 LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
							 LEFT JOIN tbl_vendors ON tbl_instruments.fk_vendor_id = tbl_vendors.pk_vendor_id
							 WHERE tbl_instruments.fk_category_id=1 AND tbl_instruments.fk_client_id='".$this->uri->segment(3)."'");
                             $rt=$ty->result_array();
							  if (sizeof($rt) == "0") {} else {
                                  foreach ($rt as $get_users_list) {
										$d1 = date('Y-m-d',strtotime($get_users_list["install_date"]));
										$d2 = date('Y-m-d');
                                      ?>
											<tr>
												<td><?php echo Get_Date_Difference($d1,$d2);?></td>
												<td><?php echo $get_users_list["vendor_name"]; // ?></td>
												<td><?php echo $get_users_list["product_name"];// ?></td>
												<td><?php echo $get_users_list["serial_no"];?></td>
												<td><?php echo $get_users_list["details"];?></td>
												<td><?php echo $get_users_list["equipment_price"];?></td>
												<td>
													<?php 
													if($get_users_list["status"]=='1') echo "<label class='label bg-blue'>Active</label>";
													if($get_users_list["status"]=='2') echo "<label class='label bg-yellow-zed'>Inactive</label>";
													if($get_users_list["status"]=='3') echo "<label class='label bg-red'>Expired</label>";
													?> 
												</td>
										  
												<td>
												  <a class="btn default purple"
												  href="<?php echo base_url();?>sys/equipment_audit?equipment=<?php echo $get_users_list["pk_instrument_id"];?>">
													Audit <i class="fa fa-edit"></i>
												  </a>
												</td>
                                      </tr>
                                      <?php
                                  }
                              }
                      ?>
                        
                      </tbody>
                    </table>
                   </div>
                  </div>
                </div>
						
                      </div>
                  </div>
                </div>

					</div>
                </div>
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        
        <?php $this->load->view('footer');?>
<script>
$(document).ready(function() { 
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 100,
	  'aaSorting':[]
	});
	
	//new $.fn.dataTable.FixedColumns( table );
});
</script>