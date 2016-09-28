<?php $this->load->view('header');?>
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title"> Auxiliary Equipments <small>Statistics and List of Auxiliary Equipments</small> </h3>
            <div class="page-bar">
              <ul class="page-breadcrumb">
                   <li>
                      <i class="fa fa-home"></i>
                      Home 
                      <i class="fa fa-angle-right"></i>
                  </li>
                  <li>
                     Auxiliary Equipments
                  </li> 
              </ul>
              
            </div>
            <!-- END PAGE HEADER--> 
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
              <div class="col-md-12"> 
              
              	<!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bg-inverse" style="display:none;">
                  <div class="portlet-title">
                    <div class="caption font-green-seagreen"> <i class="fa fa-bar-chart-o font-green-seagreen"></i>Equipments Statistics </div>
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
                                        Equipment Added Successfully.  
                                      </div>';
                              }
							  if(isset($_GET['msg_update']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        Equipment Updated Successfully.  
                                      </div>';
                              }
                            if(isset($_GET['msg_delete']))
                              {
                                echo '<div class="alert alert-success alert-dismissable">
                                        <a class="close" data-dismiss="alert">×</a>
                                        Equipment Deleted Successfully.
                                      </div>';
                              }
							  
                          ?>
				<?php /*		  <!--
                      <div class="row">
                        <div class="col-md-6">
                          <div class="btn-group">
                            <a href="<?php echo base_url();?>complaint/equipment_registration" id="sample_editable_1_new" class="btn green"> 
                            	Register New Equipment
                                <i class="fa fa-plus"></i> 
                            </a>
                          </div>
                        </div>
                        
                      </div>
					  --> */ ?>
                    </div>
              	   <div class="portlet-body flip-scroll">
                   <table class="table table-hover hover flip-content " id="sample_4">
                      <thead class="bg-grey-gallery">
                        <tr>
                          <th> Product Name   		</th>
                          <th> Total 				</th>
                          <th> Active   			</th>
                          <th> Inactive   			</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                             $ty=$this->db->query("SELECT * FROM  `tbl_products` WHERE  `fk_category_id` =  '1'");
                             $rt=$ty->result_array();
							  if (sizeof($rt) == "0") {
                                  
                              } else {
                                  foreach ($rt as $get_users_list) {
                                      
                                      
									  $query=$this->db->query("select * from tbl_instruments where 
									  fk_product_id='".$get_users_list["pk_product_id"]."'");
									  if($query->num_rows()>0)
									  {
									  ?>
                                      <tr class="odd gradeX">
                                          <td>
                                              <?php 
													echo $get_users_list["product_name"]; ?>
                                          </td>
                                          <td>
                                              <?php 
											  		$ty2=$this->db->query("select * from tbl_instruments where 
													fk_product_id='".$get_users_list["pk_product_id"]."'");
													if($ty2->num_rows()>0)

													{
                             						$rt2=$ty2->result_array();
													echo $ty2->num_rows(); 
													}
											  ?>  
                                          </td>
                                          
                                          <td>
                                               <?php 
											  		$ty2=$this->db->query("select * from tbl_instruments where 
													fk_product_id='".$get_users_list["pk_product_id"]."' AND status='1'");
													if($ty2->num_rows()>0)

													{
                             						$rt2=$ty2->result_array();
													echo $ty2->num_rows(); 
													}
											  ?> 
                                          </td>
                                          <td>
                                          	 <?php 
											  		$ty2=$this->db->query("select * from tbl_instruments where 
													fk_product_id='".$get_users_list["pk_product_id"]."' AND status='2'");
													if($ty2->num_rows()>0)

													{
                             						$rt2=$ty2->result_array();
													echo $ty2->num_rows(); 
													}
													else
													{
														echo $ty2->num_rows(); 
													}
											  ?> 
                                          </td>
                                          
                                      </tr>
                                      <?php
									  }
                                  }
                              }
                      ?>
                        
                      </tbody>
                    </table>
                   </div>
                  </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET--> 
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box green-seagreen">
                  <div class="portlet-title">
                    <div class="caption"> <i class="icon-flag"></i>Auxiliary Equipments </div>
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
                                        Equipment Added Successfully.  
                                      </div>';
                              }
							  if(isset($_GET['msg_update']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        Equipment Updated Successfully.  
                                      </div>';
                              }
							  
                          ?>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="btn-group">
                            <a href="<?php echo base_url();?>complaint/aux_equipment_registration" id="sample_editable_1_new" class="btn light-blue"> 
                            	Register New Auxiliary Equipment
                                <i class="fa fa-plus"></i> 
                            </a>
                          </div>
                        </div>
                        
                      </div>
                    </div>
              	   <div class="portlet-body flip-scroll">
                   <table class="table table-striped table-bordered table-hover flip-content" id="dataaTable">
                      <thead class="bg-grey-gallery">
					  <tr>
<!--                          <th> Category   			</th>-->
                          <th>  </th>
                          <th>  </th>
                          <th>  </th>
                          <th>  </th>
                          <th>  </th>
                          <th>  </th>
                          <th>  </th>
						  <th>  </th>
                          <th>  </th>
						  <th>  </th>
                          <th>  </th>
                          <th>  </th>
                        </tr>
                        <tr>
<!--                          <th> Category   			</th>-->
                          <th> Equipment   			</th>
						 <!-- <th> Territory 			</th> -->
                          <th> City 			    </th>
                          <th> Location   			</th>
                          <th> Vendor Name 			</th>
						  <th> Invoice Date			</th>
                          <th> Serial Number of AUX		</th>
                          <th> Warranty End Date 	</th>
						  <th> Price of Aux	</th>
						  <th> Main Equipment		</th>
                          <th> Description			</th>
                          <th> Status  				</th>
                          <th> Actions  			</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
							// city name, client name, product name, office name, vendor name
                             $ty=$this->db->query("
													SELECT 
													tbl_instruments.*, 
													COALESCE(tbl_products.product_name) AS product_name,
													COALESCE(tbl_vendors.vendor_name) AS vendor_name,
													COALESCE(tbl_cities.city_name) AS city_name,
													COALESCE(tbl_clients.client_name) AS client_name,
													COALESCE(tbl_offices.office_name) AS office_name 
													
													FROM tbl_instruments 
													
													LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
													LEFT JOIN tbl_vendors ON tbl_instruments.fk_vendor_id = tbl_vendors.pk_vendor_id
													LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
													LEFT JOIN tbl_offices ON tbl_instruments.fk_office_id = tbl_offices.pk_office_id
													LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
													
													WHERE tbl_instruments.fk_category_id=1");
                             $rt=$ty->result_array();
							  if (sizeof($rt) == "0") {
                                  
                              } else {
                                  foreach ($rt as $get_users_list) {
                                      ?>
                                      <tr class="odd gradeX">
									  
										  <td> <!-- Equipment -->
                                              <?php 
											  		/*$ty=$this->db->query("select * from tbl_products where pk_product_id='".$get_users_list["fk_product_id"]."'");
                             						$rt=$ty->result_array();*/
													echo $get_users_list["product_name"]; ?> 
                                          </td>
										  
                              <!--            <td> <!-- Territory 
                                              <?php
											  		/*$ty=$this->db->query("select * from tbl_category where
													pk_category_id='".$get_users_list["fk_category_id"]."'");
                             						$rt=$ty->result_array();
													echo $rt[0]["category_name"];*/
                                                   /* $ty=$this->db->query("select * from tbl_offices where
													pk_office_id='".$get_users_list["fk_office_id"]."'");
                             						$rt=$ty->result_array();*/
													echo $get_users_list["office_name"];
                                              ?>
                                          </td> -->
										  
                                          <td> <!-- City -->
                                              <?php
                                                    if(substr($get_users_list['fk_client_id'],0,1)=='o')
                                                    {
                                                        $office_id		=	substr($get_users_list['fk_client_id'],13,1);
                                                        $qu2			=	"SELECT * from tbl_offices where pk_office_id =  '".$office_id."'";
                                                        $gh2			=	$this->db->query($qu2);
                                                        $rt2			=	$gh2->result_array();
                                                        $myclient 		= 	$rt2[0]['office_name'];
                                                        $city 			= 	$rt2[0]['office_name'];
                                                    }
                                                    else
                                                    {
                                                       /*  $maxqu = $this->db->query("SELECT * FROM tbl_clients where pk_client_id='".$get_users_list['fk_client_id']."' ");
                                                         $maxval=$maxqu->result_array();*/
                                                         $myclient = $get_users_list['client_name'];
                                                         //for area
                                                        /* $maxqu7 = $this->db->query("SELECT * FROM tbl_cities where pk_city_id='".$maxval[0]['fk_city_id']."' ");
                                                         $maxval7=$maxqu7->result_array(); */
                                                         $city = $get_users_list['city_name'];
                                                    }
													echo $city;
                                               ?>
                                          </td>
										  
                                          <td> <!-- Location -->
                                              
											  <?php
                                              if(substr($get_users_list['fk_client_id'],0,1)=='o')
                                                    {
                                                        $office_id		=	substr($get_users_list['fk_client_id'],13,1);
                                                        $qu2			=	"SELECT * from tbl_offices where pk_office_id =  '".$office_id."'";
                                                        $gh2			=	$this->db->query($qu2);
                                                        $rt2			=	$gh2->result_array();
                                                        $myclient 		= 	$rt2[0]['office_name'];
                                                        $city 			= 	$rt2[0]['office_name'];
                                                    }
                                                    else
                                                    {
                                                       /*  $maxqu = $this->db->query("SELECT * FROM tbl_clients where pk_client_id='".$get_users_list['fk_client_id']."' ");
                                                         $maxval=$maxqu->result_array(); */
                                                         $myclient = $get_users_list['client_name'];
                                                    }
													echo $myclient;
											  ?> 
                                          </td>
										  
                                          <td> <!-- Vendor Name -->
                                              <?php 
											  		/*$ty2=$this->db->query("select * from tbl_vendors where 
													pk_vendor_id='".$get_users_list["fk_vendor_id"]."'");
													if($ty2->num_rows()>0)
													{
                             						$rt2=$ty2->result_array();
													echo $rt2[0]["vendor_name"]; 
													}*/
													echo $get_users_list['vendor_name'];
													?> 
                                                    
                                          </td>
                                          
                                          <td> <!-- Invoice Date -->
                                              <?php  echo date('d-M-Y', strtotime($get_users_list["invoice_date"]));?>
                                          </td>
                                          <td> <!-- Serial No -->
                                              <?php echo $get_users_list["serial_no"]; ?>
                                          </td>
                                          <td> <!-- Warranty End Date -->
                                              <?php
											  if ($get_users_list["warranty_months"]<0) echo "Not Defined";
											  if ($get_users_list["warranty_months"]==0) echo "No Warranty";
											  if ($get_users_list["warranty_months"]>0) {
												 // echo date('d-M-Y', strtotime($get_users_list["warranty_start_date"]));
												  $months_to_add = "+".$get_users_list["warranty_months"]." months";
												  echo date('d-M-Y', strtotime($months_to_add, strtotime($get_users_list["warranty_start_date"])));
											  }
                                                    
                                                    /*$difference		=	strtotime($get_users_list["warranty_start_date"]) - time();
								                    $interval		=	floor($difference/(60*60*24));
                                                    echo $interval." days";*/
                                              ?>
                                          </td>
										  <td> <!-- Price of Aux -->
                                              <?php echo $get_users_list["equipment_price"]; ?>
                                          </td>
										  <td> <!-- Main Equipment --><?php 
										  // Main Equipment
										  $main_equipment_list= explode(",",$get_users_list["main_equipment"]);
										  foreach ($main_equipment_list AS $me) {
											  $meq = $this->db->query("SELECT tbl_instruments.pk_instrument_id ,tbl_instruments.serial_no ,tbl_products.product_name
										FROM tbl_instruments
										JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
										WHERE tbl_instruments.fk_category_id!=1 AND tbl_products.status=0 AND tbl_instruments.pk_instrument_id='$me'");
										  
										  $meqr =$meq->result_array();
										  if (sizeof($meqr)>0)
										  echo $meqr[0]['product_name'].' - '.$meqr[0]['serial_no'].'<br/>';
										  }
										  ?></td>
										  
										  <td> <!-- Description -->
                                              <?php echo urldecode($get_users_list["details"]); ?>
                                          </td>
										  
                                          <td> <!-- Status -->
                                              <?php if($get_users_list["status"]=='1')
													  {
														  echo "<label class='label bg-blue'>Active</label>";
													  }
													  if($get_users_list["status"]=='2')
													  {
														  echo "<label class='label bg-yellow-zed'>Inactive</label>";
													  }
													  if($get_users_list["status"]=='3')
													  {
														  echo "<label class='label bg-red'>Expired</label>";
													  }
											  ?> 
                                          </td>
                                          <td> <!-- Actions -->
                                              <a class="btn default green-seagreen"
                                              href="<?php echo base_url();?>complaint/update_aux_equipment/<?php echo $get_users_list["pk_instrument_id"];?>">
                                                Update <i class="fa fa-edit"></i>
                                              </a>
											  
											  <a class="btn default purple"
                                              href="<?php echo base_url();?>complaint/equipment_audit?equipment=<?php echo $get_users_list["pk_instrument_id"];?>">
                                                Audit <i class="fa fa-edit"></i>
                                              </a>
											  
											  
                                              <a class="btn default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')"
                                                 href="<?php echo base_url();?>complaint/delete_aux_equipment/<?php echo $get_users_list["pk_instrument_id"];?>">
                                                  Delete &nbsp;<i class="fa fa-trash-o"></i>
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
<?php $this->load->view('footer');?>
<script>
		 
		 $(document).ready(function() { 
			var table = $('#dataaTable').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 0, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
				    	 		{ type: "text" },
								{ type: "text" }
						]

		});
});

</script>