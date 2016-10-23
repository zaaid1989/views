<?php $this->load->view('header');?>
<?php $redirect_customer="no";?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Add Business Project <small>Register a new project</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="<?php echo base_url();?>sys/business_data">Business Projects</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Add Business Project
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
                                        Business Project Entered Successfully.  
                                      </div>';
                              }
                          ?>
                    
		
          <div class="portlet box green-seagreen">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-plus"></i> Add Business Project </div>

              <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>sys/insert_business_project">
        	<input type="hidden" name="engineer_dvr_form" value="engineer_dvr_form" />
            <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
            <div class="form-body">

                <div class="row">
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Customer</label>

                            <div class="col-md-8">

                                
                                    <select class="form-control  " name="Customer" id="Customer" onchange="show_cities(this.value)"  required>

                                      
                                      
                                      <?php 
									  	//$quw="SELECT * from tbl_clients";
										if($this->uri->segment(3)!='')
										{
											$query="select tbl_clients.*, COALESCE(tbl_cities.city_name) AS city_name, tbl_cities.pk_city_id, tbl_area.pk_area_id, COALESCE(tbl_area.area) AS area, COALESCE(tbl_offices.pk_office_id) AS pk_office_id, COALESCE(tbl_offices.office_name) AS office_name
											from tbl_clients 
											LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
											LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
											LEFT JOIN tbl_offices ON tbl_clients.fk_office_id = tbl_offices.pk_office_id
											where pk_client_id='".$this->uri->segment(3)."'";
											$redirect_customer="yes";
										}
										else
										{
											$query="select tbl_clients.*, COALESCE(tbl_cities.city_name) AS city_name, tbl_cities.pk_city_id, tbl_area.pk_area_id, COALESCE(tbl_area.area) AS area, COALESCE(tbl_offices.pk_office_id) AS pk_office_id, COALESCE(tbl_offices.office_name) AS office_name 
											from tbl_clients 
											LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
											LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
											LEFT JOIN tbl_offices ON tbl_clients.fk_office_id = tbl_offices.pk_office_id
											WHERE delete_status = '0'";
											echo '<option value="">--Choose--</option>';
										}
                                        $ghw=$this->db->query($query);
                                        $rtw=$ghw->result_array();
                                        foreach($rtw as $value)
                                          {
                                              ?>
                                              <option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?>
											  <?php /*
													$quw2="SELECT * from tbl_cities where pk_city_id='".$value['fk_city_id']."'";
													$ghw2=$this->db->query($quw2);
													$rtw2=$ghw2->result_array();*/
													echo '--('.$value['city_name'].')';
													//for area
													/*$quw3="SELECT * from tbl_area where pk_area_id='".$value['fk_area_id']."'";
													$ghw3=$this->db->query($quw3);
													$rtw3=$ghw3->result_array();*/
													echo '--('.$value['area'].')';
													/*
													$quw4="SELECT * from tbl_offices where pk_office_id='".$value['fk_office_id']."'";
													$ghw4=$this->db->query($quw4);
													$rtw4=$ghw4->result_array();
													*/
													?>
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
                                      <?php 
										if($this->uri->segment(3)!='')
										{
											echo '<option value="'.$rtw[0]['pk_office_id'].'">'.$rtw[0]['office_name'].'</option>';
										}
										else
										{
											echo '<option value="">--Choose--</option>';
										}
										?>
        
                                    </select>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">City</label>

                            <div class="col-md-8 city_td">

                                
                                    <select class="form-control  " name="City" id="City" required>
                                    	<?php 
										if($this->uri->segment(3)!='')
										{
											echo '<option value="'.$rtw[0]['pk_city_id'].'">'.$rtw[0]['city_name'].'</option>';
										}
										else
										{
											echo '<option value="">--Choose--</option>';
										}
										?>
                                    </select>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Area</label>

                            <div class="col-md-8 area_td">
                                    <select class="form-control  " name="Area" id="Area" required>
										<?php 
										if($this->uri->segment(3)!='')
										{
											echo '<option value="'.$rtw[0]['pk_area_id'].'">'.$rtw[0]['area'].'</option>';
										}
										else
										{
											echo '<option value="">--Choose--</option>';
										}
										?>
        
                                    </select>

                            </div>

                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label">Department</label>

                            <div class="col-md-8">

                                
                                    <select class="form-control  " name="Department" id="Department" onchange="change_users(this.value)" required>

                                      		  <option value="">--Choose--</option>
                                              <option value="Sales">Sales</option>
                                              <option value="Technical">Technical</option>
                                    </select>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Sales Person</label>

                            <div class="col-md-8 sales_person">

                                
                                    <select class="form-control  " name="Sales_Person" id="Sales_Person" required>

                                      <option value="">--Choose--</option>
                                      
                                      <?php $quw="SELECT * from user where userrole IN('Salesman', 'FSE') AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ";
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
                            <label class="col-md-3 control-label">Project Type</label>
                            <div class="col-md-8">
                                <select class="form-control  " name="project_type" id="project_type" required>
										 <option value="">--Choose--</option>
										 <option value="New Business">New Business</option>
										 <option value="Assay Addition">Assay Addition</option>
										 <option value="Technical Support">Technical Support</option>
										 <option value="Base Protection">Base Protection</option>
										 <option value="Recurring">Recurring</option>
										 <option value="Others">Others</option>                                     
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
                                              <option value="<?php echo $value['pk_businesstype_id'];?>"><?php echo $value['businesstype_name'];?></option>
                                              <?php
                                          }?>
        
                                    </select>

                            </div>

                        </div>
                        
                        <div class="form-group">

                            <label class="col-md-3 control-label"> Project Description</label>

                            <div class="col-md-8">

                                <textarea name="Project_Description" class="input-xlarge" id="Project_Description" rows="5" required></textarea>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Date</label>

                            <div class="col-md-8">

                                
                                    <input type="text" class="datepicker2 form-control" name="date" value="<?php echo date('d-M-Y');?>" required/>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-md-3 control-label">Priority</label>

                            <div class="col-md-8">

                                
                                    <input type="checkbox" name="priority" />

                            </div>

                        </div>
                        
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
					//for saps
					$.ajax({
					url: "<?php echo base_url();?>sys/business_project_select_users",
					type: 'POST',
					data: formdata,
					success: function(msg){ $(".sales_person").html(msg);}
					})
					return false;
				}
				/*
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
				}*/
              </script>
              
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-3 col-md-9">
				<input type="hidden" name="redirect_customer" value="<?php echo $redirect_customer;?>" />
                  <button type="submit" class="btn default yellow-crusta">Submit</button>
				  <!--
				  <?php if ($redirect_customer=="no"){  ?>
                  <a href="<?php echo site_url();?>sys/business_data" class="btn default">Cancel</a>
				   <?php } else {?>
				   <a href="<?php echo site_url();?>sys/edit_customer/<?php echo $this->uri->segment(3);?>" class="btn default">Cancel</a>
				    <?php }  ?>
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