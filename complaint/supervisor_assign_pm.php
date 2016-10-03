<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title"> Supervisor <small>Assign Preventive Maintenance</small> </h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
          <li> Preventive Maintenance </li><!--<span class="display_your_varibal_here"></span>-->
        </ul>
      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12"><?php if(isset($_GET['msg'])) { 
		echo '<div class="alert alert-success alert-dismissable">
		<a class="close" data-dismiss="alert">×</a>
		PM Added Successfully.
		</div>';
		}
		?>

          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		<?php for ($i = 0; $i <= 2; $i++) {	//echo 'Zaaid'; ?>
		
          <div class="portlet box <?php if ($i==0) echo "red-thunderbird";
			  elseif ($i==1) echo "yellow-zed";
			  elseif ($i==2) echo "green-meadow";
			  else {}
			  ?>">

				<div class="portlet-title">
					<div class="caption"> <i class="fa fa-globe"></i>
						<?php if ($i==0) echo "NEGLECTED DUE PM";
						  elseif ($i==1) echo "Due PM";
						  elseif ($i==2) echo "PM";
						  else {}
						 ?> 
					</div>
				</div>

            <div class="portlet-body">
              <div class="portlet-body flip-scroll">
                <table class="table table-striped table-bordered table-hover flip-content pmdatatable<?php echo $i; ?>" id="<?php if ($i==2) echo 'sample_2';?>">

                  <thead>
                    <tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					
					  <tr>
                      <th> City </th>
                      <th> Customer </th>
                      <th> Equipment </th>
                      <th> S/No </th>
					  <th> Average PM Frequency </th>
					  <th> Days Since Last PM </th>
                      <th> Assigned FSE </th>
					  <th> Assigned Date </th>					  					  					  					  
					  <th> Status </th>
                      <th> Assign PM </th>

                    </tr>

                  </thead>

                  <tbody>
					<?php

					$zquery="SELECT 
					tbl_instruments.*,
					COALESCE(tbl_clients.client_name) AS client_name,
					COALESCE(tbl_clients.fk_city_id) AS fk_city_idd,
					COALESCE(tbl_offices.office_name) AS office_name,
					COALESCE(tbl_cities.city_name) AS city_name,
					COALESCE(tbl_products.product_name) AS product_name
					
					FROM tbl_instruments 
					LEFT JOIN tbl_offices ON tbl_instruments.fk_client_id = tbl_offices.client_option
					LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
					LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
					LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
					
					WHERE tbl_instruments.status='1' AND tbl_instruments.fk_category_id!='1' ";
					if ($this->session->userdata('userrole') !='Admin') $zquery .= " AND tbl_instruments.fk_office_id='" .$this->session->userdata('territory')."'";
					
					$ty=$this->db->query($zquery);
                    $rt=$ty->result_array();
					if (sizeof($rt) == "0") {} else {
						foreach ($rt as $equipment_list) 
						  { 
							$tyza	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_list['pk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC LIMIT 1");
							$rtza	= 	$tyza->result_array(); 
							$days_since_pm	=	'';
							if (!empty($rtza)){
								$last_pm_date	=	strtotime($rtza[0]['finish_time']);
								$current_date	=	time();
								$difference		=	$current_date - $last_pm_date;
								$interval		=	floor($difference/(60*60*24));
							}
							else $interval		=	"N/A";
						
							switch ($i) {
								case 0:
									if 	($interval<40)	 continue 2; 
									break;							
								case 1:
									if 	($interval<30 || $interval>39)	 continue 2; 
									break;	
								case 2:
									if 	($interval>29)	 continue 2; 
									break;
							} 
							?>
                            <form  action="<?php echo base_url(); ?>complaint/insert_complaint_pm" method="post">
					 		<tr class="odd gradeX">
                               <?php
								if (!empty($rtza)) $days_since_pm	= $interval . " day(s)";
								else $days_since_pm	= $interval;
							  ?>
                              <input type="hidden" name="interval" value="<?php echo $interval;?>">
<!--City -->
							  <td> 
                              <?php
									if(substr($equipment_list['fk_client_id'],0,1)=='o') $myclient 		= 	$equipment_list['office_name'];
									else $myclient 		= 	$equipment_list['city_name'];

									echo $myclient;
							  ?>
                               </td>
<!-- Customer -->							   
                              <td> 
                               <?php
									if(substr($equipment_list['fk_client_id'],0,1)=='o') echo $equipment_list['office_name'];
									else echo $equipment_list['client_name'];
							  ?>
                               </td>
<!-- Equipment -->							   
                              <td> <?php echo $equipment_list['product_name']; ?> </td>
<!-- Serial Number -->
                              <td><?php echo $equipment_list['serial_no']; ?></td>
							   
						
                              <?php // Counting total PMs and PMs completed former is irrelevant
                              		$tyzb	=	$this->db->query("select tbl_complaints.*,user.first_name from tbl_complaints 
									LEFT JOIN user ON tbl_complaints.assign_to = user.id 
									where fk_instrument_id='".$equipment_list['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC ");
									$rtzb	= 	$tyzb->result_array();
									$total_pms	=	sizeof($rtzb);
									
									$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_list['pk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
									$rtz	= 	$tyz->result_array();
									$total_pms_c	=	sizeof($rtz);
							  ?>
                         
							 
<!-- Average PM Frequency -->							   
							   <td> 
                              <?php
									if ($total_pms_c > 1 ) {
									$max_pms_index		=	$total_pms_c - 1;
									$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
									$last_pm			=	strtotime($rtz[0]['finish_time']);
									$diff				=	$last_pm - $first_pm; 
									
									$total_days			=	floor($diff/(60*60*24));
									$pm_frequency		=	$total_days/$max_pms_index;
									echo	$pm_frequency . " days";
									}
									elseif ($total_pms_c == 1 ) {
										$current_date		=	time();
										$last_pm			=	strtotime($rtz[0]['finish_time']);
										$diff				=	$current_date - $last_pm;
										$total_days			=	floor($diff/(60*60*24));
										echo "N/A";
									}
									else echo "N/A";
							  ?>
                               </td>
<!-- Days Since Last PM -->							   
							   <td><?php echo $days_since_pm; ?></td>
<!-- Last PM FSE -->    
                              <td>  
                               <?php
									if (!empty($rtzb)) echo $rtzb[0]['first_name'];
									else echo "N/A";
							  ?>
                              </td>
 <!-- Last PM Date -->        
                              <td>
                              <?php 
									if (!empty($rtzb)) echo date('d-M-Y', strtotime($rtzb[0]['date']));
									else echo "N/A";
							  ?>
                              </td>
<!-- Last PM Status -->							  
							  <td class="cStatus"> 
							  <?php
							  if (!empty($rtzb))
								  $status = $rtzb[0]['status'];
							  else
								  $status = 'N/A';
							  
							  $this->load->model("complaint_model");
							  $obj=new Complaint_model();
							  $obj->current_status($status);
							  ?>
							  </td>
  <!-- Actions -->      
                              <td><a href="<?php  echo  base_url();?>complaint/assign_pm/<?php  echo $equipment_list['pk_instrument_id'];?>" class="btn btn-default cButton" id="cButton">Assign</a></td>
        
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
        <?php
			}	
		?>
		</div>

      </div>

      

      <!-- END PAGE CONTENT--> 

    </div>   

  </div>

  <!-- END CONTENT --> 

  <!-- BEGIN QUICK SIDEBAR --> 


  <!-- END QUICK SIDEBAR --> 

</div>



<!-- END CONTAINER --> 
<?php $this->load->view('footer');?>
<?php //$my_variable = '1400';?>
<!--<span class="display_this_in_top"><?php echo $my_variable;?></span>-->
<script>
/*$( document ).ready(function() {
	//get value inside span with class display_this_in_top
	var myvar = $('.display_this_in_top').html();
	//put this value 'myvar' in span at top of page with class display_your_varibal_here
	$('.display_your_varibal_here').html(myvar);
	});*/

$( document ).ready(function() {
	$( ".cButton" ).click(function() {
  var s=$(this).closest("tr").find('.cStatus').text();
  var t=$.trim(s);
  if (t!='Completed' && t!='N/A') {
	alert('You cannot assign a new PM before last PM is completed.');
	//alert(t);
	return false;
  }
  
});
});

</script>

         <script>
$(document).ready(function(){
     $('#sample_2').dataTable()
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
		
	$('.pmdatatable0').dataTable()
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
		
	$('.pmdatatable1').dataTable()
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