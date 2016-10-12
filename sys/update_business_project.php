<?php $this->load->view('header');?>
<?php
	$redirect_customer	=	"no";
	$customer_id		=	0;
	if (isset($_GET['cust'])) {
		$redirect_customer="yes";
		$customer_id=$_GET['cust'];
	}

if (isset($_GET['approve_strategy'])) {
		$as="yes"; //approve strategy
	}		
?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Update Business Project <small>Edit details of business project</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Business Projects
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Update Business Project
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">

        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <?php
                            if(isset($_GET['upt']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        Business Project Updated Successfully.  
                                      </div>';
                              }
                          ?>
                    
		
          <div class="portlet box green-seagreen">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-edit"></i>Update Business Project</div>

              <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/edit_business_project">
            <input type="hidden" name="businessproject_hidden_id" value="<?php echo $get_business_projects_list[0]['pk_businessproject_id']; ?>" />
            <div class="form-body">

                <div class="row">
<?php if ($this->session->userdata('userrole')!='Salesman' ) { ?>  

<div <?php if (isset($_GET['approve_strategy'])) echo 'style="display:none;"'; ?>>                     
                        <div class="form-group">

                            <label class="col-md-3 control-label">Customer</label>

                            <div class="col-md-8">

                                
                                    <select class="form-control  " name="Customer" id="Customer" onchange="show_cities(this.value)"  required>

                                      <option value="">--Choose--</option>
                                      
                                      <?php 
										$quw="
											SELECT tbl_clients.*,tbl_cities.city_name,tbl_area.area from tbl_clients
											LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
											LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
											WHERE tbl_clients.delete_status=0 ";
                                        $ghw=$this->db->query($quw);
                                        $rtw=$ghw->result_array();
                                        foreach($rtw as $value)
                                          {
                                              ?>
                                              <option value="<?php echo $value['pk_client_id'];?>" 
											  <?php if($get_business_projects_list[0]['Customer']==$value['pk_client_id']){ echo 'selected';}?>>
											  <?php echo $value['client_name'];?>
											  <?php 
													echo '--('.$value['city_name'].')';
													
													echo '--('.$value['area'].')';?>
                                                    </option>
                                              <?php
                                          }?>
        
                                    </select>

                            </div>

                        </div>
                        <!--<section class="territory_td"></section>
                        <section class="city_td"></section>
                        <section class="area_td"></section>-->
                        <div class="form-group">

                            <label class="col-md-3 control-label">Territory</label>

                            <div class="col-md-8 territory_td">

                                
                                    <select class="form-control  " name="Territory" id="Territory" required>
                                      <option value="">--Choose--</option>
                                       <option value="<?php echo $get_business_projects_list[0]['Territory']?>" selected><?php echo $get_business_projects_list[0]['office_name']?></option>
                                    </select>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">City</label>

                            <div class="col-md-8 city_td">

                                    <select class="form-control  " name="City" id="City" required>
                                      <option value="<?php echo $get_business_projects_list[0]['City'];?>" selected><?php echo $get_business_projects_list[0]['city_name'];?></option>
                                    </select>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Area</label>

                            <div class="col-md-8 area_td">

                                
                                    <select class="form-control  " name="Area" id="Area" required>
										
                                      <option value="<?php echo $get_business_projects_list[0]['Area'];?>" selected><?php echo $get_business_projects_list[0]['area'];?></option>
        
                                    </select>

                            </div>

                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Department</label>

                            <div class="col-md-8">

                                
                                    <select class="form-control  " name="Department" id="Department" onchange="change_users(this.value)" required>

                                      		  <option value="">--Choose--</option>
                                              <option value="Sales" <?php if($get_business_projects_list[0]['Department']=='Sales'){ echo 'selected';}?>>Sales</option>
                                              <option value="Technical"  <?php if($get_business_projects_list[0]['Department']=='Technical'){ echo 'selected';}?>>Technical</option>
                                    </select>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Sales Person</label>

                            <div class="col-md-8 sales_person">

                                
                                    <select class="form-control  " name="Sales_Person" id="Sales_Person" required>

                                      <option value="">--Choose--</option>
                                      
                                      <?php $quw="SELECT * from user where userrole='Salesman' OR userrole='FSE' AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ";
                                        $ghw=$this->db->query($quw);
                                        $rtw=$ghw->result_array();
                                        foreach($rtw as $value)
                                          {
                                              ?>
                                              <option value="<?php echo $value['id'];?>" <?php if($get_business_projects_list[0]['Sales Person']==$value['id']){ echo 'selected';}?>>
											  		<?php echo $value['first_name'];?>
                                              </option>
                                              <?php
                                          }?>
        
                                    </select>

                            </div>

                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label">Project Type</label>
                            <div class="col-md-8">
							<?php 
								$project_type = $get_business_projects_list[0]['project_type'];
							?>
                                <select class="form-control  " name="project_type" id="project_type" required>
									 <option value="">--Choose--</option>
									 <option value="New Business" <?php if($project_type=="New Business"){ echo 'selected';}?>>New Business</option>
									 <option value="Assay Addition" <?php if($project_type=="Assay Addition"){ echo 'selected';}?>>Assay Addition</option>
									 <option value="Technical Support" <?php if($project_type=="Technical Support"){ echo 'selected';}?>>Technical Support</option>
									 <option value="Base Protection" <?php if($project_type=="Base Protection"){ echo 'selected';}?>>Base Protection</option>
									 <option value="Recurring" <?php if($project_type=="Recurring"){ echo 'selected';}?>>Recurring</option>
									 <option value="Others" <?php if($project_type=="Others"){ echo 'selected';}?>>Others</option>                                     
                                </select>
                            </div>
                        </div>
						
                        <div class="form-group">

                            <label class="col-md-3 control-label">Business Project</label>

                            <div class="col-md-8">

                                <select class="form-control  " name="Business_Project" id="Business_Project" required>

                                      <option value="">--Choose--</option>
                                      
                                      <?php $quw="SELECT * from tbl_business_types";
                                        $ghw=$this->db->query($quw);
                                        $rtw=$ghw->result_array();
                                        foreach($rtw as $value)
                                          {
                                              ?>
                                              <option value="<?php echo $value['pk_businesstype_id'];?>" 
                                               <?php if($get_business_projects_list[0]['Business Project']==$value['pk_businesstype_id']){ echo 'selected';}?>>
											  		<?php echo $value['businesstype_name'];?>
                                              </option>
                                              <?php
                                          }?>
        
                                    </select>

                            </div>

                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label"> Project Description</label>

                            <div class="col-md-8">

                                <textarea name="Project_Description" class="input-xlarge" id="Project_Description" rows="5" required><?php echo $get_business_projects_list[0]['Project Description'];?></textarea>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Date</label>

                            <div class="col-md-8">

                                
                                    <input type="text" class="datepicker2 form-control" name="date" 
                                    value="<?php echo date('d-M-Y',strtotime($get_business_projects_list[0]['Date']));?>" required/>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Priority</label>

                            <div class="col-md-8">

                                
                                    <input type="checkbox" name="priority" <?php if($get_business_projects_list[0]['priority']=='1'){?> checked="checked" <?php }?> />

                            </div>

                        </div>
						
</div>						
<?php } ?>						
                </div>
              
			  <script type="text/javascript">
				function show_cities(client_id)
				{
					var formdata =
					  {
						client_id: client_id,
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/business_project_select_city",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".city_td").html(msg);
						//these two are inner ajax
						}
					})
					//for teritory
					$.ajax({
					url: "<?php echo base_url();?>sys/business_project_select_territory",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".territory_td").html(msg);
						//these two are inner ajax
						}
					})
					//for area
					$.ajax({
					url: "<?php echo base_url();?>sys/business_project_select_area",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".area_td").html(msg);
						//these two are inner ajax
						}
					})
					return false;
				}
				function change_users(department)
				{
					var formdata =
					  {
						department: department
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/business_project_select_users",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".sales_person").html(msg);
						//these two are inner ajax
						}
					})
				}
              </script>
              
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-3 col-md-9">
				<input type="hidden" name="redirect_customer" value="<?php echo $redirect_customer;?>" />
				<input type="hidden" name="customer_id" value="<?php echo $customer_id;?>" />
				<?php if ($this->session->userdata('userrole')!="Salesman") {
							echo '<button type="submit" class="btn default yellow-crusta">';
								echo 'Submit</button>';
				}
				?>
				  
				  <!--
				  <?php if ($this->session->userdata('userrole')!="Salesman" && !isset($_GET['approve_strategy'])) { if ($redirect_customer=="no"){  ?>
                  <a href="<?php echo site_url();?>sys/business_data" class="btn default">Cancel</a>
				  <?php } else {?>
				   <a href="<?php echo site_url();?>sys/edit_customer/<?php echo $customer_id;?>" class="btn default">Cancel</a>
				  <?php }  } ?>
				  -->
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