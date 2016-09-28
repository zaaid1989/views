<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Update Category <small>Create</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> Categories <i class="fa fa-angle-right"></i> </li>

          <li> Update Category </li>

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

                    <div class="caption"> <i class="fa fa-gift"></i>Update Categories </div>

                    <div class="tools"> 
                    	<a href="javascript:;" class="collapse"> </a> 
                        
                        <a href="javascript:;" class="remove"> </a> 
                    </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Category Updated Successfully.  
								</div>';
						}
						
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>complaint/update_category_insert" class="form-horizontal" method="post">
                <div class="form-body">
                 <?php
                 		$ty22=$this->db->query("select * from tbl_category where pk_category_id='".$this->uri->segment('3')."'");
                        $rt22=$ty22->result_array();
				 ?>
                 <div class="form-group">
                    <label class="col-md-3 control-label">Category Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="category_name" value="<?php echo $rt22[0]["category_name"] ?>">
                       
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
							<option value="<?php echo $result["pk_product_type_id"];?>" 
							<?php if($result["pk_product_type_id"]==$rt22[0]["fk_type_id"]){?> selected="selected"<?php }?>>
								<?php echo $result["product_type"];?>
                            </option>
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
                                    <input type="hidden" name="pk_category_id" value="<?php echo $this->uri->segment(3); ?>">
                                    <button type="submit" class="btn green">Submit</button>
                                <!--    <button type="button" class="btn default">Cancel</button>	 -->
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