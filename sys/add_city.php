<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Add City <small>insert city in database</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> </li>

          <li> <a href="<?php echo base_url() . 'sys/cities'; ?>">Cities</a> <i class="fa fa-angle-right"></i> </li>

          <li> Add City </li>
          
          

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">


                <div class="portlet box purple-seance">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-plus"></i>Add City </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  City inserted in database successfully.  
								</div>';
						}
						
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>sys/add_city_insert" class="form-horizontal" method="post">
                <div class="form-body">
                 <div class="form-group">
                    <label class="col-md-3 control-label">City Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="city_name">
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Office</label>
                    <div class="col-md-4">
                       <select class="from_control" name="office_name">
                       <?php 
						  $ty=$this->db->query("select * from tbl_offices ");
						  $rt=$ty->result_array();
						  foreach($rt as $result)
						  {
						   ?>
							<option value="<?php echo $result["pk_office_id"];?>"><?php echo $result["office_name"];?></option>
							<?php
							  }
							?>
                       </select>
                    </div>
                </div>
                    
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6">
                                    <button type="submit" class="btn yellow">Submit</button>
                                 <!--   <a href="<?php echo base_url() . 'sys/cities'; ?>" class="btn default">Cancel</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </form>

                    <!-- END FORM--> 

                  </div>

                </div>

      </div>

      <!-- END PAGE CONTENT--> 

    </div>

  </div>

  <!-- END CONTENT --> 

  

</div>
<?php $this->load->view('footer');?>