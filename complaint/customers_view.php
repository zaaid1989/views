<?php $this->load->view('header');?>

<script>
$(window).load(function() {   
  $('#loader').hide();
  $('#sample_y').show();
});
</script>

                     <style>
#sample_y { display:none }

</style>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Cutomers <small>List of customers</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Customers
                            </li>
                            
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red-thunderbird">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-magic-wand"></i>Customers List </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												'.$_GET['msg'].'  
											  </div>';
									  }
									  if(isset($_GET['msg_update']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												'.$_GET['msg_update'].'  
											  </div>';
									  }
									  
								  ?>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>complaint/add_customer" id="sample_editable_1_new" class="btn green"> Register New Customer <i class="fa fa-plus"></i> </a>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  
                                </div>
                              </div>
                            </div>
							<div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
                            <div class="portlet-body flip-scroll">
                                 <table class="table table-striped table-bordered table-hover flip-content" id="sample_y">
                                    <thead>
									<tr>
                                    <th>
                                          
                                    </th>
                                    <th>
                                         
                                    </th>
                                    <th>
                                         
                                    </th>
                                    <th>
                                         
                                    </th>
                                    <th>
                                         
                                    </th>
                                    <th>
                                         
                                    </th>
                                    
                                    <th>
                                         
                                    </th>
                                    
                                    <th>
                                         
                                    </th>
									
									<th>
                                         
                                    </th>
                                    
                                    <th>
                                         
                                    </th>
                                    
                                </tr>
                                    <tr>
                                    <th>
                                         Territory 
                                    </th>
                                    <th>
                                         City
                                    </th>
                                    <th>
                                         Customer
                                    </th>
                                    <th>
                                         Area
                                    </th>
                                    <th>
                                         Address
                                    </th>
                                    <th>
                                         Equipment
                                    </th>
									<th>
                                         Auxiliary Equipment
                                    </th>
                                    
                                    <th>
                                         Assigned SAP (Customer)
                                    </th>
									<th>
                                         Assigned SAP (Project)
                                    </th>
									<th>
                                         Total Projects
                                    </th>
                                    
                                    <th>
                                         Update
                                    </th>
                                    
                                </tr>
                              </thead>
                              <tbody>
                                <?php
								// office name, city_name, area,
							/*
								SET sql_big_selects = 1;
								SELECT `tbl_clients`.`client_name`, tbl_offices.office_name,tbl_area.area, tbl_cities.city_name,GROUP_CONCAT(mp.product_name SEPARATOR ', ') AS main_equipment, GROUP_CONCAT(ap.product_name SEPARATOR ', ') AS aux_equipment,  GROUP_CONCAT(DISTINCT cu.first_name SEPARATOR ', ') AS customer_sap
								FROM `tbl_clients`
								LEFT JOIN tbl_offices ON tbl_clients.fk_office_id = tbl_offices.pk_office_id
								LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
								LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id

								LEFT JOIN tbl_customer_sap_bridge ON tbl_clients.pk_client_id = tbl_customer_sap_bridge.fk_client_id
								LEFT JOIN user cu ON tbl_customer_sap_bridge.fk_user_id = cu.id

								LEFT JOIN tbl_instruments mi ON mi.fk_client_id = tbl_clients.pk_client_id
								LEFT JOIN (SELECT * FROM tbl_products WHERE tbl_products.fk_type_id='1') mp ON mi.fk_product_id = mp.pk_product_id
								LEFT JOIN (SELECT * FROM tbl_products WHERE tbl_products.fk_type_id='2') ap ON mi.fk_product_id = ap.pk_product_id

								WHERE  tbl_clients.delete_status = '0' 
								GROUP BY tbl_clients.pk_client_id
								ORDER BY tbl_clients.client_name
							*/
								$dbres = $this->db->query("
SELECT tbl_clients.*, COALESCE(tbl_offices.office_name) AS office_name,COALESCE(tbl_area.area) AS area, COALESCE(tbl_cities.city_name) AS city_name,COALESCE(GROUP_CONCAT(mp.product_name SEPARATOR ', ')) AS main_equipment, COALESCE(GROUP_CONCAT(ap.product_name SEPARATOR ', ')) AS aux_equipment
FROM `tbl_clients`
LEFT JOIN tbl_offices ON tbl_clients.fk_office_id = tbl_offices.pk_office_id
LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
LEFT JOIN tbl_instruments mi ON mi.fk_client_id = tbl_clients.pk_client_id
LEFT JOIN (SELECT * FROM tbl_products WHERE tbl_products.fk_type_id='1') mp ON mi.fk_product_id = mp.pk_product_id
LEFT JOIN (SELECT * FROM tbl_products WHERE tbl_products.fk_type_id='2') ap ON mi.fk_product_id = ap.pk_product_id
WHERE  tbl_clients.delete_status = '0' 
GROUP BY tbl_clients.pk_client_id");
								$get_customers_listt = $dbres->result_array();
									  if (sizeof($get_customers_listt) == "0") // get_customers_list for fetching from model
									  {
										//do somthing  
									  } else {
										  foreach ($get_customers_listt as $customers_list) {
											  ?>
											  <tr class=" odd gradeX">
												  <td>
													  <?php 
													  echo $customers_list["office_name"] ?>
												  </td>
												  <td>
													  <?php 
													  echo $customers_list["city_name"] ?>
												  </td>
                                                  <td>
													  <?php 
													  echo $customers_list["client_name"] ?>
												  </td>
                                                  <td>
													  <?php 
													  echo $customers_list["area"] ?>
												  </td>
												  <td>
													  <?php 
													  echo $customers_list["address"] ?>
												  </td>
                                                  <td> <!-- All main equipment -->
													  <?php  /*
													  $ty=$this->db->query("select tbl_clients.pk_client_id,
													  							   tbl_instruments.fk_client_id,
													  							   tbl_instruments.fk_vendor_id,
																				   tbl_products.pk_product_id,
																				   tbl_products.product_name
													   from tbl_instruments 
													   INNER JOIN tbl_clients
													   ON tbl_clients.pk_client_id=tbl_instruments.fk_client_id
													   INNER JOIN tbl_products
													   ON tbl_products.pk_product_id=tbl_instruments.fk_product_id
													   WHERE tbl_products.fk_type_id = '1' AND tbl_instruments.fk_client_id='".$customers_list["pk_client_id"]."'");
													  $rt=$ty->result_array();
													  $n=0;
													  foreach($rt as $brand)
													  {
														  if($n>0)
														  {
															  echo ', ';
														  }
														  echo $brand["product_name"];
														  
														  $n++;
													  } */
													  if (isset($customers_list["main_equipment"])) echo $customers_list["main_equipment"];
													   ?>
												  </td>
												  
												  <td> <!-- All Auxiliary Equipment -->
													  <?php /*
													  $ty=$this->db->query("select tbl_clients.pk_client_id,
													  							   tbl_instruments.fk_client_id,
													  							   tbl_instruments.fk_vendor_id,
																				   tbl_products.pk_product_id,
																				   tbl_products.product_name
													   from tbl_instruments 
													   INNER JOIN tbl_clients
													   ON tbl_clients.pk_client_id=tbl_instruments.fk_client_id
													   INNER JOIN tbl_products
													   ON tbl_products.pk_product_id=tbl_instruments.fk_product_id
													   WHERE tbl_products.fk_type_id = '2' AND tbl_instruments.fk_client_id='".$customers_list["pk_client_id"]."'");
													  $rt=$ty->result_array();
													  $n=0;
													  foreach($rt as $brand)
													  {
														  if($n>0)
														  {
															  echo ', ';
														  }
														  echo $brand["product_name"];
														  
														  $n++;
													  } */
													  if (isset($customers_list["aux_equipment"])) echo $customers_list["aux_equipment"];
													   ?>
												  </td>
												  
                                                  <td> <!-- All assigned SAP Customer-->
													  <?php 
													  $ty2=$this->db->query("select * from tbl_customer_sap_bridge where fk_client_id='".$customers_list["pk_client_id"]."'");
													  
													  if ($ty2->num_rows() > 0)
													  {
													  $rt2=$ty2->result_array();
													  $n=0;
													  foreach($rt2 as $salman)
														  {
															  if($n>0)
															  { echo ', ';}
															  $n++;
															  $ty23=$this->db->query("select * from user where id='".$salman["fk_user_id"]."'");
															  $rt23=$ty23->result_array();
															  echo $rt23[0]["first_name"];
															  
														  }
													  }
													  //echo $customers_list["instrument_name"] ?>
												  </td>
												  <td> <!-- All assigned SAP Project-->
													  <?php 
													  $ty2=$this->db->query("select DISTINCT `Sales Person` from business_data where status='0' AND Customer='".$customers_list["pk_client_id"]."'");
													  
													  if ($ty2->num_rows() > 0)
													  {
													  $rt2=$ty2->result_array();
													  $n=0;
													  foreach($rt2 as $salman)
														  {
															  if($n>0)
															  { echo ', ';}
															  $n++;
															  $ty23=$this->db->query("select * from user where id='".$salman["Sales Person"]."'");
															  $rt23=$ty23->result_array();
															  echo $rt23[0]["first_name"];
															  
														  }
													  }
													  //echo $customers_list["instrument_name"] ?>
												  </td>
                                                  <td> <?php
															$q = $this->db->query("SELECT * FROM business_data WHERE status='0' AND Customer = '".$customers_list['pk_client_id']."' ");
															$projects = $q->result_array();
															echo sizeof($projects);
												  ?>
												  </td>
                                                  <td>
                                                     <a class="btn btn-sm default blue" href="<?php echo base_url();?>complaint/edit_customer/<?php echo $customers_list['pk_client_id'];?>">
                                                        Update <i class="fa fa-edit"></i>
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
                      </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer');?>
		
		<script>
		
		
			/////////////////////////////////////// For Table Tools
$(document).ready(function(){	
	$.extend(true, $.fn.DataTable.TableTools.classes, {
            "container": "btn-group tabletools-dropdown-on-portlet",
            "buttons": {
                "normal": "btn btn-sm default",
                "disabled": "btn btn-sm default disabled"
            },
            "collection": {
                "container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
            }
        });
	////////////////////////////////////// End /////////////////
		$('#sample_y').dataTable( {
			
			"language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },
			"lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
		  "pageLength": 1000,
		  "order": [
                [0, 'asc']
            ],
			
			"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

			"tableTools": {
                "sSwfPath": "<?php echo base_url();//http://mypmaonline.com/ ?>assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [{
                    "sExtends": "copy",
                    "sButtonText": "Copy",
					"fnClick": function( nButton, oConfig, flash ) {
						this.fnSetText( flash, this.fnGetTableData(oConfig) );
					},
					"fnComplete": function ( nButton, oConfig, flash, text ) {
                        
						var lines = text.split('\n').length;
						if (oConfig.bHeader) lines--;
						if (this.s.dt.nTFoot !== null && oConfig.bFooter) lines--;
						var plural = (lines==1) ? "" : "s";
						alert('Copied '+lines+' row'+plural+' to the clipboard.');
						//this.fnInfo( 'zaaid', 3000 );
						/*
						this.fnInfo( '<h6>Table copied</h6>'+
							'<p>Copied '+lines+' row'+plural+' to the clipboard.</p>',
							1500
						);*/
                    },
					"mColumns": [0,1,2,3,4,5,6],
					"oSelectorOpts": { filter: "applied", order: "current" }
                },{
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
					"mColumns": [0,1,2,3,4,5,6],
					"oSelectorOpts": { filter: "applied", order: "current" }
                }, {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
					"mColumns": [0,1,2,3,4,5,6],
					"oSelectorOpts": { filter: "applied", order: "current" }
                }, {
                    "sExtends": "xls",
                    "sButtonText": "Excel",
					"sFileName": "*.xls",
					"mColumns": [0,1,2,3,4,5,6],
					"oSelectorOpts": { filter: "applied", order: "current" }
                }, {
                    "sExtends": "print",
                    "sButtonText": "Print",
                    "sInfo": 'Please press "CTR+P" to print or "ESC" to quit',
					"mColumns": [0,1,2,3,4,5,6],
					"oSelectorOpts": { filter: "applied", order: "current" }
                }]
            }
		} );  
		// End of Table Tools enable script
});		
$(document).ready(function(){
     $('#sample_y').dataTable()
		  .columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
                                null
						]

		});
});
</script>
<style>
div.DTTT_Print_Info {
 display: block;
 z-index: 2147483647 !important; 
 }
</style>