<?php include('header.php');?>
<?php $redirect_customer="no";?>
            
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Assign Customer <small>to a SAP </small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> </li>
                        <li> <a href="<?php echo site_url(); ?>complaint/acs">ACS</a> <i class="fa fa-angle-right"></i> </li>
                        <li> Assign Customer </li>
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12">
                        
                              <div class="portlet box blue-steel">
                                <div class="portlet-title">
                                  <div class="caption"> <i class="fa fa-plus"></i>SAP Customer Assignment </div>
                                  <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                                </div>
                                <div class="portlet-body form"> 
                                  <!-- BEGIN FORM-->
                                  <?php if(isset($message))
									  { 
										echo '<div class="alert alert-danger alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												User Already Exist.  
											  </div>';
									  }
									  
								?>
                                    <!-- BEGIN FORM-->
                                    <form action="<?php echo base_url(); ?>complaint/insert_acs" id="form_sample_1" method="post" 
                                    class="form-horizontal" enctype="multipart/form-data" >
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button>
                                                You have some form errors. Please check below.
                                            </div>
                                            

                                            
                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Select SAP <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="user" class="form-control">
                                                      <?php 
													  	$tbl_designations=$this->db->query("select * from user where userrole='Salesman' AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
														$dataa=$tbl_designations->result_array();
														foreach($dataa as $val)
														{
													  ?>
                                                      <option value="<?php echo $val['id']?>"><?php echo $val['first_name']?></option>
                                                      <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="control-label col-md-3">Select Customer <span class="required">
                                                        * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="client" class="form-control">
                                                      <?php 
													  	if($this->uri->segment(3)!='')
														{
															$query="select * from tbl_clients where pk_client_id='".$this->uri->segment(3)."'";
															$redirect_customer="yes";
														}
														else
														{
															$query="select * from tbl_clients where delete_status = '0'";
														}
														$tbl_designations=$this->db->query($query);
														$dataa=$tbl_designations->result_array();
														foreach($dataa as $val)
														{
															$qu5="SELECT * FROM tbl_area  where pk_area_id =  '".$val['fk_area_id']."'";
															//echo $qu5;
															$gh5	=	$this->db->query($qu5);
															$rt5	=	$gh5->result_array();
															$qu7="SELECT * FROM tbl_cities  where pk_city_id =  '".$val['fk_city_id']."'";
															//echo $qu5;
															$gh7	=	$this->db->query($qu7);
															$rt7	=	$gh7->result_array();
													  ?>
                                                      <option value="<?php echo $val['pk_client_id']?>">
													  	<?php echo $val['client_name'].'--('.$rt7[0]['city_name'].'--('.$rt5[0]['area'].')'?>
                                                      </option>
                                                      <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
													<input type="hidden" name="redirect_customer" value="<?php echo $redirect_customer;?>" />
                                                    <button type="submit" class="btn yellow-casablanca">Add</button>
								<!--
													<?php if ($redirect_customer=="no"){  ?>
                                                    <a href="<?php echo site_url();?>complaint/acs" class="btn default">Cancel</a>
													<?php } else {?>
				   <a href="<?php echo site_url();?>complaint/edit_customer/<?php echo $this->uri->segment(3);?>" class="btn default">Cancel</a>
				    <?php }  ?>
					-->
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                  <!-- END FORM--> 
                                </div>
                              </div>
                             </div>
                          
                    </div>
                    <!-- END PAGE CONTENT--> 
                </div>
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>

        </div>
        <!-- END CONTAINER -->
        
        <?php include('footer.php');?>