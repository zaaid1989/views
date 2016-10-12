<?php $this->load->view('header');?>
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title"> Equipments - Under Warranty<small></small> </h3>
            <div class="page-bar">
              <ul class="page-breadcrumb">
                   <li>
                      <i class="fa fa-home"></i>
                      Home 
                      <i class="fa fa-angle-right"></i>
                  </li>
                  <li>
                      Equipments Under Warranty
                  </li> 
              </ul>
              
            </div>
            <!-- END PAGE HEADER--> 
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
              <div class="col-md-12"> 
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box green-seagreen">
                  <div class="portlet-title">
                    <div class="caption"> <i class="icon-flag"></i>Equipments </div>
                    <div class="tools"> 
                    	<a href="javascript:;" class="collapse"> </a> 
                        <a href="javascript:;" class="remove"> </a> 
                    </div>
                  </div>
                  <div class="portlet-body">
                    
              	   
                   <table class="table table-striped table-bordered table-hover flip-content" id="dataaTable">
                      <thead class="bg-grey-gallery">
					  <tr>
<!--                          <th> Category   			</th>-->
                          <th>  			</th>
                          <th>  			    </th>
                          <th>   			</th>
                          <th>    			</th>
                          <th>    			</th>
                          <th>  		</th>
                          <th>  </th>
                          <th>   				</th>
                       
                        </tr>
                        <tr>
<!--                          <th> Category   			</th>-->
                          <th> Territory 			</th>
                          <th> City 			    </th>
                          <th> Vendor Name 			</th>
                          <th> Equipment   			</th>
                          <th> Location   			</th>
                          <th> Serial Number 		</th>
                          <th> Warranty End Date </th>
                          <th> Status  				</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            // $ty=$this->db->query("select * from tbl_instruments");
							 
							 $ty=$this->db->query("
													SELECT 
													tbl_instruments.*, 
													COALESCE(tbl_products.product_name) AS product_name,
													COALESCE(tbl_vendors.vendor_name) AS vendor_name,
													COALESCE(tbl_cities.city_name) AS city_name,
													COALESCE(tbl_clients.client_name) AS client_name,
													COALESCE(tbl_offices.office_name) AS office_name,
													COALESCE(oc.office_name) AS office_client 													
													
													FROM tbl_instruments 
													
													LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
													LEFT JOIN tbl_vendors ON tbl_instruments.fk_vendor_id = tbl_vendors.pk_vendor_id
													LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
													LEFT JOIN tbl_offices ON tbl_instruments.fk_office_id = tbl_offices.pk_office_id
													LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
													LEFT JOIN tbl_offices oc ON tbl_instruments.fk_client_id = oc.client_option
													
													WHERE tbl_instruments.fk_category_id!=1");
													
                             $rt=$ty->result_array();
							  if (sizeof($rt) == "0") {
                                  
                              } else {
                                  foreach ($rt as $get_users_list) {
									  $warranty_end_date = 0;
									  if ($get_users_list["warranty_months"]>0) {
												  $months_to_add = "+".$get_users_list["warranty_months"]." months";
												  $warranty_end_date =  strtotime($months_to_add, strtotime($get_users_list["warranty_start_date"]));
											}
										if ($warranty_end_date<time()) continue;
                                      ?>
                                      <tr class="odd gradeX">
                                          <td>
                                              <?php
													echo $get_users_list["office_name"];
                                              ?>
                                          </td>
                                          <td>
                                              <?php
                                                    if(substr($get_users_list['fk_client_id'],0,1)=='o')
                                                    {
                                                        // $office_id		=	substr($get_users_list['fk_client_id'],13,1);
                                                        // $qu2			=	"SELECT * from tbl_offices where pk_office_id =  '".$office_id."'";
                                                        // $gh2			=	$this->db->query($qu2);
                                                        // $rt2			=	$gh2->result_array();
                                                        $myclient 		= 	$get_users_list['office_client'];
                                                        $city 			= 	$get_users_list['office_client'];
                                                    }
                                                    else
                                                    {
                                                         // $maxqu = $this->db->query("SELECT * FROM tbl_clients where pk_client_id='".$get_users_list['fk_client_id']."' ");
                                                         // $maxval=$maxqu->result_array();
                                                         $myclient = $get_users_list["client_name"];
                                                         //for area
                                                         // $maxqu7 = $this->db->query("SELECT * FROM tbl_cities where pk_city_id='".$maxval[0]['fk_city_id']."' ");
                                                         // $maxval7=$maxqu7->result_array();
                                                         $city = $get_users_list["city_name"];
                                                    }
													echo $city;
                                               ?>
                                          </td>
                                          <td>
                                              <?php 
											  		echo $get_users_list["vendor_name"];
													?> 
                                                    
                                          </td>
                                          
                                          <td>
                                              <?php 
											  		
													echo $get_users_list["product_name"]; ?> 
                                          </td>
                                          <td>
                                              
											  <?php
													echo $myclient;
											  ?> 
                                          </td>
                                          <td>
                                              <?php echo $get_users_list["serial_no"]; ?>
                                          </td>
                                          <td>
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
                                          <td>
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
                                          
                                      </tr>
                                      <?php
                                  }
                              }
                      ?>
                        
                      </tbody>
                    </table>
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
								{ type: "text" }
						]

		});
});

</script>