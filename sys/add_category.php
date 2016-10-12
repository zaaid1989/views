<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Add Category <small>Create</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home  <i class="fa fa-angle-right"></i> </li>

          <li> <a href="<?php echo base_url();echo $this->uri->segment(1);?>/categories">Category</a> <i class="fa fa-angle-right"></i> </li>

          <li> Add Category </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

          <div class="tabbable tabbable-custom boxless tabbable-reversed">

            <ul class="nav nav-tabs">

              <li class="active"> <a href="#tab_0" data-toggle="tab"> Form Actions </a> </li>

            </ul>

            <div class="tab-content">

              <div class="tab-pane active" id="tab_0">

                <div class="portlet box green">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Form Actions On Bottom </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Category Entered Successfully.  
								</div>';
						}
						
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>sys/add_category_insert" class="form-horizontal" method="post">
                <div class="form-body">
                 <div class="form-group">
                    <label class="col-md-3 control-label">Category Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="category_name">
                       
                    </div>
                </div>
                
                <!--<div class="form-group">
                    <label class="col-md-3 control-label">Category Type</label>
                    <div class="col-md-4">
                       <select class="from_control" name="type_name">
                       <?php 
						  $ty=$this->db->query("select * from tbl_product_types ");
						  $rt=$ty->result_array();
						  foreach($rt as $result)
						  {
						   ?>
							<option value="<?php echo $result["pk_product_type_id"];?>"><?php echo $result["product_type"];?></option>
							<?php
							  }
							?>
                       </select>
                    </div>
                </div>-->
                    
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">Submit</button>
                                  <!--  <a href="<?php echo base_url() . 'sys/categories'; ?>" class="btn default">Cancel</a> -->
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

          </div>

        </div>

      </div>

      <!-- END PAGE CONTENT--> 

    </div>

  </div>

  <!-- END CONTENT --> 

  

</div>
<?php $this->load->view('footer');?>