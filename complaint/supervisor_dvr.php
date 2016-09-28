<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Superviser <small>DVR</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Superviser DVR
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">

        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		<form method="post" action="<?php echo base_url();?>complaint/insert_dvr">
          <div class="portlet box grey-cascade">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>View DVR </div>

              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
               
                <a href="javascript:;" class="remove"> </a> 
              </div>

            </div>

            <div class="portlet-body">

              <div class="table-toolbar">

                
              </div>
              
              
              			<div class="portlet-body flip-scroll">
                            <?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Complaint Added Successfully.  
											  </div>';
									  }
								  ?>
                            <div class="row">
                            	<div class="col-lg-4">
                            		<div class="form-group">
                            			<label>Select Engineer</label>
                                        <select name="engineer" id="engineer" class="form-control" onchange="get_egn_dvr(this.value)">
                                            <option value="">--Select Engineer</option>
											<?php 
											$maxqu2 = $this->db->query("SELECT * FROM user where id='".$this->session->userdata('userid')."' ");
											$maxval2=$maxqu2->result_array();
											
											//where userrole='FSE' OR userrole='Salesman'
											$maxqu = $this->db->query("SELECT * FROM user where userrole='FSE'  and fk_office_id='".$maxval2[0]['fk_office_id']."' AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['id'];?>"><?php echo $val['first_name'];?></option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>
                          		<div class="col-lg-4">
                            		<div class="form-group">
                            			<label>Start Date</label>
                                        <input type="text" name="start_mydate" class="form-control datepicker" id="start_mydate" value="<?php echo date('d-M-Y')?>"  />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                            		<div class="form-group">
                            			<label>End Date</label>
                                        <input type="text" name="end_mydate" class="form-control datepicker" id="end_mydate" value="<?php echo date('d-M-Y')?>"  />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                            		<div class="form-group">
                                        <a href="javascript:void()" onclick="get_current_date_values()" class="btn btn-default">Search</a>
                                    </div>
                                </div>
                          		
                                
                           </div>
                           <script>
						function get_current_date_values()
						{
							engineer=$('#engineer').val();
							start_mydate=$('#start_mydate').val();
							end_mydate=$('#end_mydate').val();
							var formdata =
							  {
								start_mydate: start_mydate,
								end_mydate: end_mydate,
								engineer:engineer
							  };
						  $.ajax({
							url: "<?php echo base_url();?>complaint/get_date_dvr",
							type: 'POST',
							data: formdata,
							success: function(msg){
								$(".engineer_dvrs").html(msg);
								//alert(msg);
								}
							})
							return false;
						}
						function get_egn_dvr(engineer_id)
						{
							var formdata =
							  {
								engineer_id: engineer_id
							  };
						  $.ajax({
							url: "<?php echo base_url();?>complaint/get_egn_dvr_ajax",
							type: 'POST',
							data: formdata,
							success: function(msg){
								$(".engineer_dvrs").html(msg);
								//alert(msg);
								}
							})
							return false;
						}
						</script>
                <table class="table table-striped table-bordered table-hover">

                <thead>

                  <tr>
                  
                    <th colspan="2"  style="padding-right:150px;"> Time </th>
                    
                    <th style="width:120px !important" > Area </th>

                    <th style="width:120px !important"> Customer</th>
                    <th style="width:120px !important"> Date</th>
                    
                    <th style="width:120px !important"> Business Project </th>

                    <th style="width:120px !important"> Project Description </th>
                    
                    <th style=" padding-right:100px"> Working Details/Discussion Summary </th>
                    
                   
                 

                  </tr>

                </thead>

                <tbody class="engineer_dvrs">
               

                </tbody>

              </table>

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