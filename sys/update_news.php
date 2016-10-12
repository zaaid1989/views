<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title"> Update News <small>Edit the details of News</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> News <i class="fa fa-angle-right"></i> </li>

          <li> Update News </li>

        </ul>

        

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

          

                <div class="portlet box green-seagreen">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Update News </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body form"> 
                  
                  <?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  News Updated Successfully.  
								</div>';
						}
						
					?>

                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form action="<?php echo base_url();?>sys/update_news_insert" class="form-horizontal" method="post">
                <div class="form-body">
                 <div class="form-group">
                    <?php
						$ty22=$this->db->query("select * from tbl_news where pk_news_id = '".$this->uri->segment(3)."'");
						$rt22=$ty22->result_array();
					?>
                    <label class="col-md-3 control-label">News Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="news_title" value="<?php echo urldecode($rt22[0]["news_title"]); ?>">
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">News Description</label>
                    <div class="col-md-8">
                      <textarea name="news_description" class="input-xlarge" id="news_description" rows="5" required><?php echo urldecode($rt22[0]["news_description"]);?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Territory</label>
                    <div class="col-md-8">
                     <select class="form-control" name="office">
                              <option value="0"
                              <?php if($rt22[0]["fk_office_id"]=='0'){ echo "selected";}?>>
                                    All
                              </option>
						<?php 
                                $tbl_designations=$this->db->query("select * from tbl_offices");
                                $dataa=$tbl_designations->result_array();
                                foreach($dataa as $val)
                                {
                              ?>
                              <option value="<?php echo $val['pk_office_id']?>"
                              <?php if($val['pk_office_id']==$rt22[0]["fk_office_id"]){ echo "selected";}?>>
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
                                    <input type="hidden" name="pk_news_id" value="<?php echo $this->uri->segment(3); ?>">
                                    <button type="submit" class="btn yellow-zed">Submit</button>
							<!--		<a href="<?php echo site_url();?>sys/news" class="btn default">Cancel</a> -->
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