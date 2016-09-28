
<?php


$this->load->view('header');

if ($this->uri->segment('3'))
 echo "";
else show_404();

?>

<?php
	$project_id=$this->uri->segment('3');
	$zquery="select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_area.area,user.first_name,tbl_business_types.businesstype_name 
	from business_data 
	LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
	LEFT JOIN tbl_area ON tbl_area.pk_area_id = business_data.Area
	LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = business_data.City
	LEFT JOIN user ON user.id = business_data.`Sales Person`
	LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
	WHERE pk_businessproject_id='" .$project_id."'";
	$ty=$this->db->query($zquery);
    $rt=$ty->result_array();
	
	if ($this->session->userdata('userrole')=="Salesman" && $this->session->userdata('userid')!=$rt[0]['Sales Person']) show_404();
	/*
	$client_id=$rt[0]['fk_client_id']; //////// for client data
	$serial_no=$rt[0]['serial_no'];
	$category_id=$rt[0]['fk_category_id']; //////// for category name
	$product_id=$rt[0]['fk_product_id']; /////// for product name
	$office_id=$rt[0]['fk_office_id'];
	$details=$rt[0]['details'];
	$status=$rt[0]['status'];
	*/
	
	$client_name=$rt[0]['client_name'];
	$client_area=$rt[0]['area'];
	$client_city=$rt[0]['city_name'];
	$date=date('d-M-Y',strtotime($rt[0]['Date']));
	$sap = $rt[0]['first_name'];
	$department = $rt[0]['Department'];
	$category=$rt[0]['businesstype_name'];
	$project_type=$rt[0]['project_type'];
	$description=urldecode($rt[0]['Project Description']);
	
?>

      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title"> Strategy History</h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
          <li> Projects <i class="fa fa-angle-right"></i> </li>
          <li> Strategy History</li>
        </ul>
      </div>

      <!-- END PAGE HEADER--> 
      <!-- BEGIN PAGE CONTENT-->

      <div class="row">
        <div class="col-md-12"> 
	  <?php /////////////////////////////////////////////////// Extra Information /////////////////////// ?>	  
<div class="portlet box purple">
              
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Project Information</div>
                            <div class="tools">
                                 <a href="javascript:;" class="collapse"> </a> 
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
                                                       <td>Customer</td>
                                                       <td><?php echo $client_name ;  ?></td>
                                                 </tr>
												 
                                                 <tr class="odd gradeX">
                                                    <td>City</td>
                                                    <td> <?php echo $client_city;  ?></td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                       <td>Area</td>
                                                       <td><?php  echo $client_area ;  ?></td>
                                                 </tr>
                                                 
                                                 <tr class="odd gradeX">
                                                        <td>Department</td>
													   <td> <?php echo $department;  ?></td>
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
                                                    <td>Project Date</td>
                                                    <td> <?php echo $date;  ?></td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                       <td>Project Type</td>
                                                       <td><?php echo $project_type;  ?></td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                       <td>Category</td>
                                                       <td><?php echo $category;  ?></td>
                                                 </tr>
												 <!--
												 <tr class="odd gradeX">
                                                       <td>Sales Person</td>
                                                       <td><?php echo $sap; ?></td>
                                                 </tr>
                                                 -->
                                                 <tr class="odd gradeX">
                                                        <td>Description</td>
													   <td> <?php echo $description;  ?></td>
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

              <div class="caption"> <i class="fa fa-globe"></i>Strategy History </div>

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
					  <th> Strategy Status </th>
					  <th> Strategy Date </th>
                      <th> Target Date </th>
					  <th> Employee </th>
                      <th> Strategy </th>
                      <th> Tactics </th>
                      <th> Investment </th>
                      <th> Sales / Month </th>
					  <?php if ($this->session->userdata('userrole')=="Admin") {?>
					  <th> Actions </th>
					  <?php }?>
                    </tr>
                  </thead>

                  <tbody>
					<?php
					
					$ty=$this->db->query("SELECT tbl_project_strategy.*, user.first_name FROM tbl_project_strategy 
					LEFT JOIN user ON user.id = tbl_project_strategy.fk_employee_id
					WHERE fk_project_id = '".$project_id."' AND strategy_status='1' ORDER BY date DESC");
					
					//without strategy_status as Mr. Yasir asked for it to be shown
					$ty=$this->db->query("SELECT tbl_project_strategy.*, user.first_name FROM tbl_project_strategy 
					LEFT JOIN user ON user.id = tbl_project_strategy.fk_employee_id
					WHERE fk_project_id = '".$project_id."' ORDER BY date DESC");
                    $rt=$ty->result_array();
	
					if (sizeof($rt) == "0") 
					{
					  //do somthing  
					} else {
						foreach ($rt as $project_strategy) 
						  {
							  
							?>
					 		<tr class="odd gradeX">
							  <td> <!-- Strategy Status -->
								<?php 
								if ($project_strategy["strategy_status"]=='0')
									echo '<span class="label label-sm  bg-yellow-gold"> Pending </span>'; 
								if ($project_strategy["strategy_status"]=='1')
									echo '<span class="label label-sm  bg-blue"> Approved </span>'; 
								if ($project_strategy["strategy_status"]=='4')
									echo '<span class="label label-sm bg-red"> Disapproved </span>'; 
								
								?>
                              </td>
                              <td> <!-- Date -->
								<?php echo date('d-M-Y',strtotime($project_strategy['date'])); ?>
                              </td>
							  <td> <!-- Target Date -->
								<?php echo date('d-M-Y',strtotime($project_strategy['target_date'])); ?>
                              </td>	 
							  <td> <!-- Employee -->
								<?php echo $project_strategy['first_name']; ?>
                              </td>
                              <td> <!-- Strategy -->
								<?php echo urldecode($project_strategy["strategy"]); ?>
                              </td>
							  <td> <!-- Strategy -->
								<?php echo urldecode($project_strategy["tactics"]); ?>
                              </td>	 

								<td> <!-- Investment -->
								<?php echo $project_strategy["investment"]; ?>
                              </td>
							  
							  <td> <!-- Sales / Month -->
								<?php echo $project_strategy["sales_per_month"]; ?>
                              </td>
							  <?php if ($this->session->userdata('userrole')=="Admin") {?>
                              <td class="bg-grey-cararra text-center bg-grey-border">
							  <a class="btn btn-sm default blue" href="<?php echo base_url();?>complaint/edit_strategy/<?php echo $project_strategy["pk_project_strategy_id"].'?proj='.$project_id;?>" >
                                    Edit &nbsp;<i class="fa fa-eye"></i>
							  </a>
							  
							  <a class="btn btn-sm default red" href="<?php echo base_url();?>complaint/delete_strategy/<?php echo $project_strategy["pk_project_strategy_id"].'?proj='.$project_id;?>" onClick="return confirm('Are you sure you want to delete?')">
                                    Delete &nbsp;<i class="fa fa-trash-o"></i>
							  </a>
							  </td>
							  <?php } ?>
        
                            </tr>
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