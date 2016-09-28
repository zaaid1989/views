<?php $this->load->view('header.php');?>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Warning Letters <small>View</small> </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li>
                  <i class="fa fa-home"></i>
                  Home 
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  All Warning Letters
              </li>
            </ul>
          </div>
          <!-- END PAGE HEADER--> 
          <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet box grey-cascade">
                <div class="portlet-title">
                  <div class="caption"> <i class="fa fa-globe"></i>Warning Letters </div>
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
                                      Warning Letter Added Successfully.  
                                    </div>';
                            }
						if(isset($_GET['msg_update']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Warning Letter Updated Successfully.  
                                    </div>';
                            }
						if(isset($_GET['del']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Warning Letter Deleted Successfully.  
                                    </div>';
                            }
							
                        ?>
						<?php
						if($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin' )
							{ ?>
								<div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>complaint/warning_letter" id="sample_editable_1_new" class="btn green"> 
                              			Add New Warning Letter 
                                        &nbsp;
                                        <i class="fa fa-plus"></i> 
									</a>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  
                                </div>
                              </div>
						<?php	}
							else {  ?>
							<div class="note note-active">
							<h3>
							<label class="label bg-blue">Note: Enter your comments/ justification against your pending Warning Letter</label>
							</h3>
							</div>
								
						<?php	}

						?>
							
						
                    <!--<div class="row">
                      <div class="col-md-6">
                        <div class="btn-group">
                          <a href="<?php echo base_url();?>complaint/fine" id="sample_editable_1_new" class="btn green"> 
                              Add New Fine &nbsp;<i class="fa fa-plus"></i> 
                          </a>
                        </div>
                      </div>
                      
                    </div>-->
                  </div>
                  <div class="portlet-body flip-scroll">
                   <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                    <thead>
                      <tr>
                        <th> Employee  		    </th>
                        <th> Official Comment 	</th>
                        <th> Employee Comment	</th>
                        <th> Viewed 			</th>
                        <th> Status			 	</th>
                        <th> Date 				</th>
                        <th> Actions			</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                            // is warning is seen make viewed ad 1
							if($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin' )
							{
								//do nothing
							}
							else
							{
								$update_viewed="update tbl_warning_letters SET viewed='1'  where fk_employee_id =  '".$this->session->userdata('userid')."'";
								$update_viewed_query=$this->db->query($update_viewed);
							}
							// is warning is seen make viewed ad 1 ended
							 
							 
							$myquery="select * from tbl_warning_letters";
							if($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin' )
							{
								$myquery.="";
							}
							else
							{
								$myquery.="  where fk_employee_id =  '".$this->session->userdata('userid')."'";
							}
							$myquery.=" order by pk_warning_letter_id DESC";
							$ty22=$this->db->query($myquery);
                            $rt22=$ty22->result_array();
                            if (sizeof($rt22) == "0") {
                                
                            } else {
                                foreach ($rt22 as $get_users_list) {
                                    ?>
                                    <tr class="odd gradeX">
                                        
                                        <td>
                                            <?php 
                                            $ty44=$this->db->query("select * from user where id =  '".$get_users_list["fk_employee_id"]."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
											$rt44=$ty44->result_array();
											echo $rt44[0]["first_name"];
											?>
                                        </td>
                                        
                                        <td>
                                            <?php echo urldecode($get_users_list["official_comments"]);?>
                                        </td>
                                        <td>
                                            <?php echo urldecode($get_users_list["employee_comments"]);?>
                                        </td>
                                        <td>
                                            <?php if($get_users_list['viewed']=='0'){ echo 'NO'; } ?>
                                            <?php if($get_users_list['viewed']=='1'){ echo 'YES'; } ?>
                                        </td>
                                        <td>
                                            <?php echo urldecode($get_users_list["status"]);?>
                                        </td>
                                        <td>
                                            <?php echo date('d-M-Y', strtotime($get_users_list["date"]));?>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm default green-meadow"  
                                            href="<?php echo base_url();?>complaint/update_warning_letter/<?php echo $get_users_list["pk_warning_letter_id"];?>">
                                              Update <i class="fa fa-edit"></i>
                                            </a>
											<?php 
												if ($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin')
												{
											?>
                                            <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')" 
                                            href="<?php echo base_url();?>products/delete_warning_letter/<?php echo $get_users_list["pk_warning_letter_id"];?>">
                                              Delete &nbsp;&nbsp;<i class="fa fa-trash-o"></i>
                                            </a>
												<?php } ?>
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