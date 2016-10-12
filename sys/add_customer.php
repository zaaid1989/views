<?php $this->load->view('header');?>
            
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Add Customer <small>Register a new Customer</small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> Home  <i class="fa fa-angle-right"></i> </li>
                        <li> <a href="<?php echo base_url();?>sys/customers_view">Customers</a> <i class="fa fa-angle-right"></i> </li>
                        <li> Add Customer </li>
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">

        <div class="col-md-12">


                <div class="portlet box blue-ebonyclay">

                  <div class="portlet-title">

                    <div class="caption"> <i class="icon-magic-wand"></i>New Customer </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form"> 

                    <!-- BEGIN FORM-->

                    <form action="<?php echo base_url(); ?>sys/insert_customer"  enctype="multipart/form-data" class="form-horizontal" method="post">

                      <div class="form-body">

                        <div class="form-group">

                          <label class="col-md-3 control-label">Client Name</label>

                          <div class="col-md-4">

                            <input type="text" class="form-control " name="client_name" >

                          </div>

                        </div>

                       

                        <div class="form-group">

                          <label class="col-md-3 control-label">City</label>

                          <div class="col-md-4">

                            <select class="form-control  " name="client_city" onchange="select_teritory(this.value)">

                              <option value="">--Choose--</option>
                              <?php
                              $maxqu = $this->db->query("SELECT * FROM tbl_cities ");
							  $maxval=$maxqu->result_array();
							  foreach($maxval as $cities)
							  {
							  ?>

                              <option value="<?php echo $cities['pk_city_id']?>"><?php echo $cities['city_name']?></option>

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

                          <div class="col-md-4 teritory_content">

                            <select class="form-control  " name="territory">

                              <option value="">--Choose--</option>

                              <?php
                              $maxqu = $this->db->query("SELECT * FROM tbl_offices ");
							  $maxval=$maxqu->result_array();
							  foreach($maxval as $cities)
							  {
							  ?>

                              <option value="<?php echo $cities['pk_office_id']?>"><?php echo $cities['office_name']?></option>

                              <?php }?>

                            </select>

                          </div>

                        </div>
                         
                         
                       <div class="form-group">

	                        <label class="col-md-3 control-label">Lab Contact Number</label>

                            <div class="col-md-4">

                            	<input type="text" class="form-control " name="contactno" >

                            </div>

                        </div>
                        
                        <div class="form-group">

                          <label class="col-md-3 control-label">Area</label>

                          <div class="col-md-4">

                            <select class="form-control  " name="area">

                              <option value="">--Choose--</option>

                              <?php
                              $maxqu = $this->db->query("SELECT * FROM tbl_area");
							  $maxval=$maxqu->result_array();
							  foreach($maxval as $cities)
							  {
							  ?>

                              <option value="<?php echo $cities['pk_area_id']?>">
							  	<?php echo $cities['area']?>
                              </option>

                              <?php }?>

                            </select>

                          </div>

                        </div>
                        
                        <div class="form-group">

	                        <label class="col-md-3 control-label">Website</label>

                            <div class="col-md-4">

                            	<input type="text" class="form-control " name="website" >

                            </div>

                        </div>
                       
                        

                        <div class="form-group">

	                        <label class="col-md-3 control-label">Address</label>

                            <div class="col-md-4">

                            	<textarea class="form-control " rows="3" name="address"></textarea>

                            </div>

                        </div>

                        
                        
          
               <div class="portlet box blue-steel">

                       <div class="portlet-title">

                           <div class="caption"> <i class="fa fa-globe"></i>Pathologists </div>

                      </div>

                        

                          

                            <!-- BEGIN SAMPLE TABLE PORTLET-->

                            <div class="portlet-body">

                                  <table class="table table-hover table-bordered">

                                    <thead>

                                      <tr>

                                        <th> Name</th>

                                        <th> Contact No </th>

                                        <th> Email </th>

                                        <th> Add row </th>

                                        

                                        

                                      </tr>

                                    </thead>

                                    <tbody class="append_tbody">

                                      <tr>

                                        <td> <input type="text" class="form-control" name="pathalogist_name[0]"> </td>

                                        <td> <input type="text" class="form-control" name="pathalogist_contact_no[0]"> </td>

                                        <td> <input type="text" class="form-control" name="pathalogist_email[0]"> </td>

                                        <td> <a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a>
                                        <br />
                                			<a href="#"><i class="fa fa-minus"></i></a> 
                                       </td>
                                
									</tr>

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
								</script>

                     

                      </div>

                      <div class="form-actions">

                        <div class="row">

                          <div class="col-md-offset-5 col-md-7">

                            
							<button type="submit" class="btn btn-lg default green">Save <i class="fa fa-check"></i></button>

                      <!--      <a href="<?php echo site_url();?>sys/customers_view" class="btn btn-lg default">Cancel <i class="fa fa-times"></i></a> -->

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
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
           

        </div>
        <!-- END CONTAINER -->
        
        <?php $this->load->view('footer');?>