<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title">  New News <small>Add new news for employees</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home  <i class="fa fa-angle-right"></i> </li>

          <li> <a href="<?php echo site_url();?>complaint/news">News</a> <i class="fa fa-angle-right"></i> </li>

          <li> Add News </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

                <div class="portlet box green-seagreen">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>New News </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  PEF Entered Successfully.  
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
            <form action="<?php echo base_url();?>complaint/add_news_insert" class="form-horizontal" method="post">
                <div class="form-body">
                 <div class="form-group">
                    <label class="col-md-3 control-label">News Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="news_title">
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">News Description</label>
                    <div class="col-md-8">
                       <textarea name="news_description" class="input-xlarge" id="news_description" rows="5" required></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Territory</label>
                    <div class="col-md-8">
                     <select class="form-control" name="office">
                              <option value="0">
                                    All
                              </option>
						<?php 
                                $tbl_designations=$this->db->query("select * from tbl_offices");
                                $dataa=$tbl_designations->result_array();
                                foreach($dataa as $val)
                                {
                              ?>
                              <option value="<?php echo $val['pk_office_id']?>">
                                    <?php echo $val['office_name']?>
                              </option>
                              <?php }?>
                      </select>
                    </div>
                </div>
                
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6">
                                    <button type="submit" class="btn default yellow-zed">Submit</button>
							<!--		<a href="<?php echo site_url();?>complaint/news" class="btn default">Cancel</a> -->
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