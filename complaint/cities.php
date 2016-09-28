<?php $this->load->view('header.php');?>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Cities <small>View all cities</small> </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li>
                  <i class="fa fa-home"></i>
                  Home 
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  Cities
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
                  <div class="caption"> <i class="icon-pointer"></i>Cities</div>
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
                                      City Added Successfully.  
                                    </div>';
                            }
                        ?>
                        <?php
                          if(isset($_GET['upt']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      City Updated Successfully.  
                                    </div>';
                            }
                        ?>
                        <?php
                          if(isset($_GET['msg_delete']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      City Deleted Successfully.  
                                    </div>';
                            }
                        ?>
                        
                    <div class="row">
                      <div class="col-md-6">
                        <div class="btn-group">
                          <a href="<?php echo base_url();?>complaint/add_city" id="sample_editable_1_new" class="btn purple-seance"> 
                              Add New City
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
                        
                        <th> City 				</th>
                       <th> Office 					</th>
                        <th> Actions 				</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                            $ty22=$this->db->query("select tbl_cities.*, tbl_offices.office_name from tbl_cities 
							LEFT JOIN tbl_offices ON tbl_cities.fk_office_id = tbl_offices.pk_office_id
							where tbl_cities.status='0'");
                            $rt22=$ty22->result_array();
                            if (sizeof($rt22) == "0") {
                                //do something
                            } else {
                                foreach ($rt22 as $get_city_list) {
                                    ?>
                                    <tr class="odd gradeX">
                                        
                                        <td>
                                            <?php echo $get_city_list["city_name"] ?>
                                        </td>
                                        <td>
                                            <?php 
                                           /* $ty=$this->db->query("select * from tbl_offices where 
                                            pk_office_id='".$get_city_list["fk_office_id"]."'");
                                            $rt=$ty->result_array(); */
                                            echo $get_city_list["office_name"] ?>
                                        </td>
                                        
                                        <td>
                                            <a class="btn btn-sm default yellow-stripe"  
                                            href="<?php echo base_url();?>complaint/update_city/<?php echo $get_city_list["pk_city_id"];?>">
											
                                              Update 
											  <i class="fa fa-edit"></i>
                                            </a>
											
											
											
                                            <a class="btn btn-sm default red-thunderbird"  
                                            href="<?php echo base_url();?>complaint/delete_city/<?php echo $get_city_list["pk_city_id"];?>"
                                            onClick="return confirm('Are you sure you want to delete?')">
											
                                              Delete 
											  <i class="fa fa-trash-o"></i>
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