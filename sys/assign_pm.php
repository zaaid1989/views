<?php $this->load->view('header');?>

<?php
	$equipment_id=$this->uri->segment('3');
	$zquery="select tbl_instruments.*,COALESCE(tbl_products.product_name) AS product_name,tbl_category.category_name 
	from tbl_instruments 
	LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
	LEFT JOIN tbl_category ON tbl_instruments.fk_category_id = tbl_category.pk_category_id
	where pk_instrument_id='" .$equipment_id."'";
	$ty=$this->db->query($zquery);
    $rt=$ty->result_array();
	$client_id=$rt[0]['fk_client_id']; //////// for client data
	$serial_no=$rt[0]['serial_no'];
	$category_name=$rt[0]['category_name']; //////// for category name
	$product_name=$rt[0]['product_name']; /////// for product name
	$office_id=$rt[0]['fk_office_id'];
	$details=$rt[0]['details'];
	$status=$rt[0]['status'];
	
	$client_name="";
	$client_area="";
	$client_city="";
	$last_fse="";
	$last_date="";
	$client_city_id="";
	
	///////////////////// Retrieving Client DATA //////////////////////
	
	if(substr($client_id,0,1)=='o')
		{
			$qu2			=	"SELECT * from tbl_offices where client_option =  '".$client_id."'";
			$gh2			=	$this->db->query($qu2);
			$rz2			=	$gh2->result_array();
			$client_name	= 	$rz2[0]['office_name'];
			$client_city	= 	$client_name;
			$client_area	=	$client_name;
		}
	else
		{
			$tyz	=	$this->db->query("select tbl_clients.*,COALESCE(tbl_cities.city_name) AS city_name,COALESCE(tbl_area.area) AS area 
			from tbl_clients 
			LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
			LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
			where pk_client_id='".$client_id."'");
			$rtz	= 	$tyz->result_array();
			$client_city_id	=	$rtz[0]['fk_city_id'];
			//$ty4	=	$this->db->query("select * from tbl_cities where pk_city_id='".$rtz[0]['fk_city_id']."'");
			//$rt4	=	$ty4->result_array();
			//$ty5	=	$this->db->query("select * from tbl_area where pk_area_id='".$rtz[0]['fk_area_id']."'");
			//$rt5	=	$ty5->result_array();
			$client_name	= 	$rtz[0]['client_name'];
			$client_city	= 	$rtz[0]['city_name'];
			$client_area	=	$rtz[0]['area'];
		}
	////////////////////////////////	Retrieving Product Info		//////////////////////////////
	
	//$ty6	=	$this->db->query("select * from tbl_products where pk_product_id='".$product_id."'");
	//$rt6	=	$ty6->result_array();
	//$product_name	=	$rt6[0]['product_name'];
	
	////////////////////////////////	Retrieving Category Info		//////////////////////////////
	
	//$ty7	=	$this->db->query("select * from tbl_category where pk_category_id='".$category_id."'");
	//$rt7	=	$ty7->result_array();
	//$category_name	=	$rt7[0]['category_name'];
	
	////////////////////////////////	Last PM FSE & Date			/////////////////////
	
	$ty8	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_id."' AND complaint_nature='PM' ORDER BY date DESC LIMIT 1");
	$rt8	= 	$ty8->result_array();
	if (!empty($rt8))
	{
		$ty9	=	$this->db->query("select * from user where id='".$rt8[0]['assign_to']."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
		$rt9	=	$ty9->result_array();
		$last_fse = $rt9[0]['first_name'];
		$last_date = date('d-M-Y', strtotime($rt8[0]['date']));
	}
	else
	{
		$last_fse = "No PMs Yet";
		$last_date = "No PMs Yet";
	}
?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title"> Supervisor <small>Assign Preventive Maintenance to FSE</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> <a href="<?php echo base_url();?>sys/supervisor_assign_pm">Preventive Maintenance</a> <i class="fa fa-angle-right"></i> </li>

          <li> <a href="#">Choose FSE</a> </li>

        </ul>


      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12"> 
		
	  <?php /////////////////////////////////////////////////// Extra Information /////////////////////// ?>	  
<div class="portlet box purple">
              
                          <div class="portlet-title">
              
                            <div class="caption"> <i class="fa fa-globe"></i>Equipment Information</div>
              
                            <div class="tools">
                                 <a href="javascript:;" class="collapse"> </a> 
                                 <a href="javascript:;" class="remove"> </a> 
                            </div>
              
                          </div>
              
                          <div class="portlet-body">
                          
                            <div class="row">
                              <div class="col-md-6">
                                <div class="table-scrollable">
                                      <table class="table table-striped table-bordered table-hover">
              
                                          <thead>
                                          	<tr><th>Attribute</th><th>Value</th></tr>
                                          </thead>
                                          <tbody>
                                                 <tr class="odd gradeX">
                                                        <td>
                                                        Equipment
                                                       </td>
                                                       <td> <?php echo $product_name . " (" . $category_name . ")";  ?>
                                                                                                               </td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                        <td>
                                                        Serial No
                                                       </td>
                                                       <td>
                                                        <?php echo $serial_no;  ?>
                                                       </td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                        <td>
                                                        Status
                                                       </td>
                                                       <td>
                                                        <?php 
														if($status =='1')
														  {
															  echo "<label class='label bg-blue'>Active</label>";
														  }
														  elseif($status =='2')
														  {
															  echo "<label class='label bg-yellow-zed'>Inactive</label>";
														  }
														  elseif($status =='3')
														  {
															  echo "<label class='label bg-red'>Expired</label>";
														  }
														  else echo "";

														?>
                                                       </td>
                                                 </tr>
                                                 
                                                 
                                                 <tr class="odd gradeX">
                                                        <td>
                                                        Last PM FSE
                                                       </td>
                                                       <td> <?php echo $last_fse;  ?>
                                                                                                               </td>
                                                 </tr>                                        
                                                 
                                          </tbody>
                                     </table>
                              </div>
                             </div>
                              <div class="col-md-6">
                                <div class="table-scrollable">
                                      <table class="table table-striped table-bordered table-hover">
              
                                          <thead>
                                          	<tr><th>Attribute</th><th>Value</th></tr>
                                          </thead>
                                          <tbody>
												<tr class="odd gradeX">
                                                        <td>
                                                        Customer
                                                       </td>
                                                       <td> <?php echo $client_name;  ?>
                                                                                                               </td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                        <td>
                                                        Area
                                                       </td>
                                                       <td> <?php echo $client_area;  ?>
                                                                                                               </td>
                                                 </tr>
                                                 
                                                 <tr class="odd gradeX">
                                                        <td>
                                                        City
                                                       </td>
                                                       <td>
                                                        <?php echo $client_city;  ?>
                                                       </td>
                                                 </tr>
                                                 
                                                <tr class="odd gradeX">
                                                        <td>
                                                        Last PM Date
                                                       </td>
                                                       <td>
                                                        <?php echo $last_date;  ?>
                                                       </td>
                                                 </tr>                                              
                                          </tbody>
                                     </table>
                              </div>
                             </div>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET--> 
                      </div>

<?php //////////////////////////////////////////// Original Page //////////////////////////////// ?>	

								<div class="row">
								<div class="col-md-6"> 
									
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">PM Date:</label>
                                            <div class="col-md-4">
                                                <input type="text" class="datepicker2 form-control pm_date" name="date" 
                                                value="<?php echo date('d-M-Y');?>" onchange="calculate_time()">
												<span class="help-block">
											Select Date </span>
                                            </div>
                                     </div>
                               </div>
                               <div class="col-md-6"> 
                                    <div class="form-group">
                                    <label class="col-md-4 control-label">PM Time:</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control timepicker timepicker-24 pm_time" name="time"  onchange="calculate_time()"
                                            value="<?php echo date('H:i');?>">
											<span class="help-block">
											Select time (24 Hour Format) </span>
                                        </div>
                                    </div>
								</div>
							</div>
									
									<div class="row">
                                    <p>&nbsp;</p>
									</div> 
		<script>
        function calculate_time()
		{
			var pm_date=$('.pm_date').val();
			var pm_time=$('.pm_time').val();
			var combine = pm_date+' '+pm_time;
			$('.combine_date').val(combine);
		}
        </script>
		
		<?php
		
		function dashForZero($x) {
			if ($x==0) echo '-';
			else echo $x;
		}
		
		?>
          <!-- BEGIN EXAMPLE TABLE PORTLET-->

          <div class="portlet box green-jungle">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Available Engineers </div>

            </div>

            <div class="portlet-body">

              

              <div class="portlet-body flip-scroll">
				 <?php
					if(isset($_GET['msg']))
					  { 
						echo '<div class="alert alert-success alert-dismissable">  
								<a class="close" data-dismiss="alert">×</a>  
								PM Added Successfully.  
							  </div>';
					  }
				  ?>
                <table class="table table-striped table-bordered table-hover flip-content">

                  <thead>

                    <tr>

                      <!--<th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>

                      </th>-->
					  <th class="bg-blue-steel text-center bg-grey-border"> FSE </th>
                      
                      <th class="bg-grey-steel text-center bg-grey-border"> Complaints<br />Assigned </th>
					  
					  <th class="bg-grey-cararra text-center bg-grey-border"> Complaints<br />Solved </th>
					  
					  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">Complaints<br />Pending </span></th>

                      <th class="bg-grey-steel text-center bg-grey-border"> PMC<br />Assigned </th>

                      <th class="bg-grey-cararra text-center bg-grey-border"> PMC<br />Completed </th>
					  
					  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">  PMC<br />Pending </span> </th>

                      <th class="bg-grey-cararra text-center bg-grey-border"> Assign<br />PM </th>

                    </tr>

                  </thead>

                  <tbody>
					<?php
					//$userid	=	$this->session->userdata('userid');
					$ty1=$this->db->query("select * from user where id='".$this->session->userdata('userid')."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
                    $rt1=$ty1->result_array();
					//
					//$ty=$this->db->query("select * from user where fk_office_id='".$rt1[0]['fk_office_id']."' AND userrole IN ('FSE','Supervisor')");
					$ty=$this->db->query("select * from user where FIND_IN_SET_X('".$office_id."','fk_office_id') AND userrole IN ('FSE','Supervisor') AND delete_status='0' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
                    $rt=$ty->result_array();
	
					if (sizeof($rt) == "0") 
					{
					  //do somthing  
					} else {
						foreach ($rt as $pma_user) 
						  {
							  $complaints_assigned	=	0;
							  $complaints_solved	=	0;
							  $complaints_pending	=	0;
							  $pmc_assigned			=	0;
							  $pmc_completed		=	0;
							  $pmc_pending			=	0;
							  
								$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status='Closed'");
								$rt10	=	$ty10->result_array();
								$complaints_solved	=	sizeof($rt10);
								
								$ty11	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status!='Closed'");
								$rt11	=	$ty11->result_array();
								$complaints_pending	=	sizeof($rt11);
								
								$ty12	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND status='Completed'");
								$rt12	=	$ty12->result_array();
								$pmc_completed	=	sizeof($rt12);
								
								$ty13	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND status!='Completed'");
								$rt13	=	$ty13->result_array();
								$pmc_pending	=	sizeof($rt13);
							  
							?>
                             <form  action="<?php echo base_url(); ?>sys/insert_complaint_pm" method="post">
					 		<tr class="odd gradeX">
                              <td class="bg-blue-steel bg-grey-border"> 
                              <?php
									echo $pma_user['first_name'];									
							  ?>
                              
                               </td>
							   
							   <td class="bg-grey-steel text-center bg-grey-border"> <!-- complaints assigned -->
								<?php
									//$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY");
									//$rt10	=	$ty10->result_array();
									//echo sizeof($rt10);
									dashForZero($complaints_solved+$complaints_pending);
								
								?>
                              </td>
 
                              <td class="bg-grey-cararra text-center bg-grey-border"> <!-- complaints solved -->
								<?php
									//$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status!='Closed'");
									//$rt10	=	$ty10->result_array();
									//echo sizeof($rt10);
									dashForZero($complaints_solved);
								?>
                              </td>
							  
							  <td class="bg-grey-cararra text-center bg-grey-border"> <!-- complaints pending -->
								<?php
									//$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY");
									//$rt10	=	$ty10->result_array();
									//echo sizeof($rt10);
									echo '<span class="font-red">';
									dashForZero($complaints_pending);
									echo '</span>';
								?>
                              </td>
        
                              <td class="bg-grey-steel text-center bg-grey-border"> <!-- pmc assigned -->
								<?php
									//$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND status!='Completed'");
									//$rt10	=	$ty10->result_array();
									//echo sizeof($rt10);
									dashForZero($pmc_completed+$pmc_pending);
								?>
                              </td>	 

								<td class="bg-grey-cararra text-center bg-grey-border"> <!-- pmc solved -->
								<?php
									//$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status!='Closed'");
									//$rt10	=	$ty10->result_array();
									//echo sizeof($rt10);
									dashForZero($pmc_completed);
								?>
                              </td>
							  
							  <td class="bg-grey-cararra text-center bg-grey-border"> <!-- pmc pending -->
								<?php
									//$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY");
									//$rt10	=	$ty10->result_array();
									//echo sizeof($rt10);
									echo '<span class="font-red">';
									dashForZero($pmc_pending);
									echo '</span>';
								?>
                              </td>
							  
							  
        
                              <td class="bg-grey-cararra text-center bg-grey-border">
							  <input type="hidden" name="assign_to" value="<?php echo $pma_user['id'];?>">
							  <input type="hidden" name="fk_city_id" value="<?php echo $client_city_id;?>">
							  <input type="hidden" name="fk_customer_id" value="<?php echo $client_id;?>">
							  <input type="hidden" name="fk_instrument_id" value="<?php echo $equipment_id;?>">
							  <input type="hidden" name="fk_office_id" value="<?php echo $office_id;?>">
							  <input type="hidden" name="date" value="<?php echo date("Y-m-d H:i");?>" class="combine_date">
							  <input type="submit" value="Assign" onclick="calculate_time()"  class="btn btn-default yellow-casablanca">
							  </td>
        
                            </tr>
                            </form>
					<?php } 
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

  <!-- BEGIN QUICK SIDEBAR --> 


  <!-- END QUICK SIDEBAR --> 

</div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker();
	/*
	$('.timepicker1').timepicker({
                    minuteStep: 5,
                    showInputs: false,
                    disableFocus: true,
                    defaultTime:false
                });*/
				
	$('.timepicker-24').timepicker({
                autoclose: true,
                minuteStep: 5,
                showSeconds: false,
                showMeridian: false
            });
  });
  
  
</script>
<!-- END CONTAINER --> 
<?php $this->load->view('footer');?>

<style>
.bg-grey-border
{
	border-bottom:1px solid #dddddd !important;
	border-right:1px solid #dddddd !important;
}

</style>