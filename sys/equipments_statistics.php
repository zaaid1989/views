<?php $this->load->view('header');
function echozero($var) {
	$val = $var;
	if ($var == 0) $val ="-";
	else $val = $var;
	return $val;
}
?>
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title"> Equipments <small>Statistics </small> </h3>
            <div class="page-bar">
              <ul class="page-breadcrumb">
                   <li>
                      <i class="fa fa-home"></i>
                      Home 
                      <i class="fa fa-angle-right"></i>
                  </li>
                  <li>
                      Equipments Statistics
                  </li> 
              </ul>
              
            </div>
            <!-- END PAGE HEADER--> 
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
              <div class="col-md-12"> 
              
              	<!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bg-inverse">
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
                            <a href="<?php echo base_url();?>sys/equipment_registration" id="sample_editable_1_new" class="btn green"> 
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
                             $ty=$this->db->query("SELECT * FROM  `tbl_products` WHERE  `fk_category_id` !=  '1'");
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
                                          <td>  <!-- Product Names -->
                                              <?php 
													echo $get_users_list["product_name"]; ?>
                                          </td>
                                          <td>  <!-- Total Equipments -->
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
                                          
                                          <td> <!-- Active -->
                                               <?php 
											  		$ty2=$this->db->query("select * from tbl_instruments where 
													fk_product_id='".$get_users_list["pk_product_id"]."' AND status='1'");
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
                                          <td> <!-- Inactive -->
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
                
              </div>
            </div>
			
		<?php for ($i=1;$i<=2;$i++) { ?>	
			<div class="row">
              <div class="col-md-12"> 
              
              	<!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bg-inverse">
                  <div class="portlet-title">
                    <div class="caption <?php if ($i==1) echo "font-blue"; else echo "font-red"; ?>"> <i class="fa fa-bar-chart-o <?php if ($i==1) echo "font-blue"; else echo "font-red"; ?>"></i> <?php if ($i==1) echo "Active"; else echo "Inactive"; ?> Equipments Statistics </div>
                    <div class="tools"> 
                    	<a href="javascript:;" class="collapse"> </a> 
                        <a href="javascript:;" class="remove"> </a> 
                    </div>
                  </div>
				  
                  <div class="portlet-body">
              	   <div class="portlet-body flip-scroll">
                   <table class="table table-hover hover flip-content " id="sample_4">
                      <thead class="bg-grey-gallery">
					  <?php
                             $ty3=$this->db->query("SELECT DISTINCT tbl_instruments.fk_product_id, tbl_products.product_name FROM `tbl_instruments`
								INNER JOIN tbl_products
								ON tbl_instruments.fk_product_id=tbl_products.pk_product_id
								WHERE tbl_instruments.fk_category_id!=1 AND tbl_instruments.status=$i ORDER BY fk_product_id");
                             $rt3=$ty3->result_array();
						?>
                        <tr>
                          
						  <th> Territory			</th>
						  <th> City 				</th>
						  <?php
						  foreach ($rt3 as $product) {
							 echo "<th>".$product['product_name']."</th>";
						  }
							 ?>
                          <th> Total 				</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
							$ty4=$this->db->query("SELECT DISTINCT tbl_instruments.fk_office_id, tbl_offices.office_name, tbl_offices.client_option FROM `tbl_instruments`
								INNER JOIN tbl_offices
								ON tbl_instruments.fk_office_id=tbl_offices.pk_office_id
								WHERE tbl_instruments.fk_category_id!=1 AND tbl_instruments.status=$i ORDER BY fk_office_id");
                             $rt4=$ty4->result_array();
						?>
						
							<?php
						  foreach ($rt4 as $territory) {
							 //echo "<td>".$territory['office_name']."</td>";
							 
							 $ty5=$this->db->query("SELECT distinct(fk_city_id), tbl_cities.fk_office_id,tbl_cities.city_name FROM `tbl_instruments` 
							 JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id 
							 JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
							 WHERE tbl_instruments.fk_category_id!=1 AND tbl_instruments.status=$i AND tbl_instruments.fk_office_id='".$territory['fk_office_id']."'
							 ");
                             $rt5=$ty5->result_array();
							 
							 // There will be one hardcoded line if there are any instruments in this office at the end
							 foreach ($rt5 as $city) {
								 $total = 0;
								 
								 echo '<tr class="odd gradeX">';
								 echo "<td>".$territory['office_name']."</td>";
								 echo "<td>".$city['city_name']."</td>";
									/************************** Dynamically Generate Product Counts for each product type *******************************/
									foreach ($rt3 as $product) {
										$equipment_string = "";
										$ty6=$this->db->query("SELECT count(*) AS product_count FROM `tbl_instruments` 
										 JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id 
										 JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
										 WHERE tbl_instruments.fk_category_id!=1 AND tbl_instruments.status=$i AND tbl_cities.city_name='".$city['city_name']."' 
										 AND tbl_instruments.fk_product_id='".$product['fk_product_id']."'
										 ");
										 $rt6=$ty6->result_array();
										 $total += $rt6[0]['product_count'];
										 
										 //////////////// **************** MAKING STRING FOR EQUIPMENTS BEGIN ************/////////////////////
										 $ty10=$this->db->query("SELECT tbl_clients.client_name,tbl_instruments.serial_no FROM `tbl_instruments` 
										 JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id 
										 JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
										 WHERE tbl_instruments.fk_category_id!=1 AND tbl_instruments.status=$i AND tbl_cities.city_name='".$city['city_name']."' 
										 AND tbl_instruments.fk_product_id='".$product['fk_product_id']."'
										 ");
										 $rt10=$ty10->result_array();
										 foreach ($rt10 as $e) {
											 //$equipment_string = $equipment_string.$e['client_name']." (".$e['serial_no']."), ";
											 $equipment_string = $equipment_string.$e['client_name'].", ";
										 }
										 //////////////// **************** MAKING STRING FOR EQUIPMENTS END ************/////////////////////
										 //echo "<td>".echozero($rt6[0]['product_count'])."</td>";
										 echo '<td><span title="'.$equipment_string.'">'.echozero($rt6[0]['product_count']).'</span></td>';
									  }
									
								 echo "<td>".$total."</td>";
								 echo '</tr>';
							 } // End of City for each
							 ?>
							 <?php /////************** IF THERE IS ANY ACTIVE/INACTIVE EQUIPMENT IN OFFICE BEGIN ****************/ ?>
							 <?php 
								$ty9=$this->db->query("SELECT count(*) AS product_count FROM `tbl_instruments` 
								 WHERE fk_category_id!=1 AND status=$i 
								 AND fk_client_id='".$territory['client_option']."' 
								 ");
								 $rt9=$ty9->result_array();
								 if ($rt9[0]['product_count']>0) {
							 ?>
							 <tr>
							  <th> <?php echo $territory['office_name']; ?>			</th>
							  <th> IN-OFFICE				</th>
							  <?php
							  $total=0;
							  foreach ($rt3 as $product) {
								$ty8=$this->db->query("SELECT count(*) AS product_count FROM `tbl_instruments` 
								 WHERE fk_category_id!=1 AND status=$i 
								 AND fk_product_id='".$product['fk_product_id']."' 
								 AND fk_client_id='".$territory['client_option']."' 
								 ");
								 $rt8=$ty8->result_array();
								 echo "<th>".echozero($rt8[0]['product_count'])."</th>";
								 $total += $rt8[0]['product_count'];
							  }
								 ?>
							  <th> <?php echo $total; ?> 				</th>
							</tr>
								 <?php } /////************** IF THERE IS ANY ACTIVE/INACTIVE EQUIPMENT IN OFFICE END ****************/ ?>
								 
								 
								 <?php /////************** OFFICE TOTAL ****************/ ?>
							 <?php /*
								$ty9=$this->db->query("SELECT count(*) AS product_count FROM `tbl_instruments` 
								 WHERE fk_category_id!=1 AND status=$i 
								 AND fk_client_id='".$territory['client_option']."' 
								 ");
								 $rt9=$ty9->result_array();
								 if ($rt9[0]['product_count']>0) {  */
							 ?>
							 <tr class="<?php if ($i==1) echo "bg-blue"; else echo "bg-red"; ?>">
							  <th> <?php echo $territory['office_name']; ?>			</th>
							  <th> Total				</th>
							  <?php
							  $total=0;
							  foreach ($rt3 as $product) {
								$ty8=$this->db->query("SELECT count(*) AS product_count FROM `tbl_instruments` 
								 WHERE fk_category_id!=1 AND status=$i 
								 AND fk_product_id='".$product['fk_product_id']."' 
								 AND fk_office_id='".$territory['fk_office_id']."' 
								 ");
								 $rt8=$ty8->result_array();
								 echo "<th>".echozero($rt8[0]['product_count'])."</th>";
								 $total += $rt8[0]['product_count'];
							  }
								 ?>
							  <th> <?php echo $total; ?> 				</th>
							</tr>
								 <?php // } /////************** OFFICE TOTAL ****************/ ?>
							 
							 <?php
						  } // End of territory foreach
							 ?>
						<tr class="bg-grey-cascade">
                          
						  <th> All Territories			</th>
						  <th> All Cities				</th>
						  <?php
						  $total=0;
						  foreach ($rt3 as $product) {
							$ty7=$this->db->query("SELECT count(*) AS product_count FROM `tbl_instruments` 
							 WHERE fk_category_id!=1 AND status=$i 
							 AND fk_product_id='".$product['fk_product_id']."'
							 ");
							 $rt7=$ty7->result_array();
							 echo "<th>".echozero($rt7[0]['product_count'])."</th>";
							 $total += $rt7[0]['product_count'];
						  }
							 ?>
                          <th> <?php echo $total; ?> 				</th>
                        </tr>
						
                      </tbody>
                    </table>
                   </div>
                  </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET--> 
                
              </div>
            </div>
            <!-- END PAGE CONTENT-->
        <?php } ?>
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