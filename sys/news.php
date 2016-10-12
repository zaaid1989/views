<?php $this->load->view('header.php');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> News <small>Manage the News</small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
                        <li> News </li>
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box yellow-zed">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>News Management</div>
                            <div class="tools"> 
                            	<a href="javascript:;" class="collapse"> </a> 
                                
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												News Added Successfully.  
											  </div>';
									  }
								  ?>
                                  <?php
                                  	if(isset($_GET['upt']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												News Updated Successfully.  
											  </div>';
									  }
								  ?>
                                  <?php
                                  	if(isset($_GET['msg_delete']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												News deleted Successfully.  
											  </div>';
									  }
								  ?>
                                  
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>sys/add_news" id="sample_editable_1_new" class="btn green-seagreen"> 
                                    	Add New News &nbsp;<i class="fa fa-plus"></i> 
                                    </a>
                                  </div>
                                </div>
                                
                              </div>
                            </div>
                        	<div class="portlet-body flip-scroll">
                             <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                  <th> News Title 				</th>
                                  <th> Description 				</th>
                                  <th> Territory 				</th>
                                  <th> Actions 				 	</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  $ty22=$this->db->query("select tbl_news.*,tbl_offices.office_name from tbl_news 
									  LEFT JOIN tbl_offices ON tbl_news.fk_office_id = tbl_offices.pk_office_id
									  order by pk_news_id DESC");
									  $rt22=$ty22->result_array();
									  if (sizeof($rt22) == "0") {
										  
									  } else {
										  foreach ($rt22 as $get_users_list) {
											  ?>
											  <tr class="odd gradeX">
												  
                                                  <td>
													  <?php echo urldecode($get_users_list["news_title"]); ?>
												  </td>
                                                  <td>
                                                      <?php echo urldecode($get_users_list["news_description"]); ?>
													  <input type="hidden" name="news_description" value="<?php echo $get_users_list["news_description"];?>">
												  </td>
												  
                                                  <td>
													  <?php 
													  		if($get_users_list["fk_office_id"]=='0')
															{
																echo "All";
															}
															else
															{
																// $ty44=$this->db->query("select * from tbl_offices where pk_office_id =  '".$get_users_list["fk_office_id"]."'");
																// $rt44=$ty44->result_array();
																echo $get_users_list["office_name"];//$rt44[0]["office_name"];
															}
													  ?>
												  </td>
												  <td>
													
													  <a class="btn btn-sm default yellow-zed-stripe"  
                                                      href="<?php echo base_url();?>sys/update_news/<?php echo $get_users_list["pk_news_id"];?>">
													  <i class="fa fa-edit"></i>
                                                      	Update
                                                      </a>
                                                      <a class="btn btn-sm default red-thunderbird"  
                                                      href="<?php echo base_url();?>sys/delete_news/<?php echo $get_users_list["pk_news_id"];?>"
                                                      onClick="return confirm('Are you sure you want to delete?')">
													  <i class="fa fa-trash-o"></i>
                                                      	Delete
                                                      </a>
													
                                                  </td>
												 
											  </tr>
											  <?php
										  }
									  }
                              ?>                               
                              </tbody>
                            </table>
                                      </div>
                          </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET--> 
                      </div>
                    </div>
      				<!-- END PAGE CONTENT-->
                    
                    
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer.php');?>
		
		<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>