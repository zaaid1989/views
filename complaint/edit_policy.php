<?php $this->load->view('header');?>
<?php 
	$pk_policy_id = 0;
	if (!(isset($_GET['policy']))) show_404();
	else $pk_policy_id = $_GET['policy'];
	
	$pq = $this->db->query("SELECT * FROM tbl_policies WHERE `pk_policy_id`='".$pk_policy_id."'");
	$pr = $pq->result_array();
	if (sizeof($pr)==0) show_404();
	
?>
<script src="//cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  Edit Policy <small>Update policy details</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home  <i class="fa fa-angle-right"></i> </li>

          <li> <a href="<?php echo site_url();?>complaint/policies">Policies</a> <i class="fa fa-angle-right"></i> </li>

          <li> Edit Policy </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

                <div class="portlet box green-seagreen">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Edit Policy </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Policy Updated Successfully.  
								</div>';
						}
						if(isset($_GET['msg']) && $_GET['msg']=='failure')
						{ 
						  echo '<div class="alert alert-danger alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  A PEF Date Already Exist.  
								</div>';
						}
						if(isset($_GET['msg']) && $_GET['msg']=='failure2')
						{ 
						  echo '<div class="alert alert-danger alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Date Should Be Greater Than Current Date.  
								</div>';
						}
						if(isset($_GET['msg']) && $_GET['msg']=='failure3')
						{ 
						  echo '<div class="alert alert-danger alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Date Should Be Greater Than Current Date.  
								</div>';
						}
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>complaint/update_policy" class="form-horizontal" method="post">
                <div class="form-body">
                 <div class="form-group">
                    <label class="col-md-3 control-label">Policy Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="policy_title" value="<?php echo urldecode($pr[0]['policy_title']); ?>" required>
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Policy </label>
                    <div class="col-md-8">
                       <textarea name="policy" class="input-xlarge" id="policy" rows="10" required>
					   <?php echo urldecode($pr[0]['policy']); ?> 
					   </textarea>

            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'policy' );
            </script>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Order</label>
                    <div class="col-md-8">
                     <input type="text" class="form-control" name="order" value="<?php echo $pr[0]['order']; ?>">
                    </div>
                </div>
                
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6">
								<input type="hidden"  name="pk_policy_id" value="<?php echo $pk_policy_id; ?>">
                                    <button type="submit" class="btn default yellow-zed">Submit</button>
							<!--		<a href="<?php echo site_url();?>complaint/policies" class="btn default">Cancel</a> -->
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