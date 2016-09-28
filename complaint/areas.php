<?php $this->load->view('header.php');?>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Areas <small>View all Areas</small> </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li>
                  <i class="fa fa-home"></i>
                  Home 
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  Areas
              </li>
            </ul>
            
          </div>
          <!-- END PAGE HEADER--> 
          <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet box yellow">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-pointer"></i>Areas</div>
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
                                      Area Added Successfully.  
                                    </div>';
                            }
                        ?>
                        <?php
                          if(isset($_GET['upt']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Area Updated Successfully.  
                                    </div>';
                            }
                        ?>
                        <?php
                          if(isset($_GET['msg_delete']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Area Deleted Successfully.  
                                    </div>';
                            }
                        ?>
                        
                    <div class="row">
                      <div class="col-md-6">
                        <div class="btn-group">
                          <a href="<?php echo base_url();?>complaint/add_area" id="sample_editable_1_new" class="btn purple-seance"> 
                              Add New Area
                              <i class="fa fa-plus"></i> 
                          </a>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                 <div class="portlet-body flip-scroll">
                 <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                    <thead>
                      <tr>
                        
                        <th> Area 				</th>
                       <th> City 					</th>
                        <th> Actions 				</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                            $ty22=$this->db->query("select tbl_area.*,tbl_cities.city_name from tbl_area LEFT JOIN tbl_cities ON tbl_area.fk_city_id = tbl_cities.pk_city_id");
                            $rt22=$ty22->result_array();
                            if (sizeof($rt22) == "0") {
                                //do something
                            } else {
                                foreach ($rt22 as $get_city_list) {
                                    ?>
                                    <tr class="odd gradeX">
                                        
                                        <td>
                                            <?php echo $get_city_list["area"] ?>
                                        </td>
                                        <td>
                                            <?php 
                                           /* $ty=$this->db->query("select * from tbl_cities where 
                                            pk_city_id='".$get_city_list["fk_city_id"]."'");
                                            $rt=$ty->result_array();*/
                                            //echo $rt[0]["city_name"] ;
											echo $get_city_list["city_name"];
											?>
                                        </td>
                                        
                                        <td>
                                            <a class="btn btn-sm default yellow-stripe"  
                                            href="<?php echo base_url();?>complaint/update_area/<?php echo $get_city_list["pk_area_id"];?>">
											
                                              Update 
											  <i class="fa fa-edit"></i>
                                            </a>
											
											
											
                                            <!--<a class="btn btn-sm default red-thunderbird"  
                                            href="<?php echo base_url();?>complaint/delete_area/<?php echo $get_city_list["pk_area_id"];?>"
                                            onClick="return confirm('Are you sure you want to delete?')">
											
                                              Delete 
											  <i class="fa fa-trash-o"></i>
                                            </a> -->
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