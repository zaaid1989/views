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

        <div class="col-md-12"> 								 <?php					if(isset($_GET['msg']))					  { 						echo '<div class="alert alert-success alert-dismissable">  								<a class="close" data-dismiss="alert">×</a>  								PM Added Successfully.  							  </div>';					  }				  ?>

          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		<?php
			for ($i = 0; $i <= 2; $i++) {	//echo 'Zaaid';
		?>
		<?php
		//	}	
		?>
          <div class="portlet box <?php if ($i==0) echo "red-thunderbird";
			  elseif ($i==1) echo "yellow-zed";
			  elseif ($i==2) echo "green-meadow";
			  else {}
			  ?>">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i><?php if ($i==0) echo "NEGLECTED DUE PM";
			  elseif ($i==1) echo "Due PM";
			  elseif ($i==2) echo "PM";
			  else {}
			  ?> </div>

            </div>

            <div class="portlet-body">

              

              <div class="portlet-body flip-scroll">

                <table class="table table-striped table-bordered table-hover flip-content pmdatatable<?php echo $i; ?>" id="<?php if ($i==2) echo 'sample_2';?>">

                  <thead>

                    <tr>

                      <!--<th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>

                      </th>-->
					  <!--<th> Days Since Last PM </th>-->
					  
					  <?php /*?><?php
						if ($i==2)
						{ ?><?php */?>
					
						<th>  </th>
                      
                      <th>  </th>

                      <th>  </th>

                      <th>  </th>
					  
				<!--	  <th> Total PMs </th> -->
					  
					  <th>  </th>
					  
					  <th>  </th>
                      
                      <th>  </th>

                      <th>  </th>					  					  					  					  <th>  </th>

                      <th>  </th>
					</tr>
					<?php /*?>
					  <?php	
						}
					  ?><?php */?>
					  <tr>
                      <th> City </th>
                      
                      <th> Customer </th>

                      <th> Equipment </th>

                      <th> S/No </th>
					  
				<!--	  <th> Total PMs </th> -->
					  
					  <th> Average PM Frequency </th>
					  
					  <th> Days Since Last PM </th>
                      
                      <th> Assigned FSE </th>

                      <th> Assigned Date </th>					  					  					  					  <th> Status </th>

                      <th> Assign PM </th>

                    </tr>

                  </thead>

                  <tbody>
					<?php
					$ty1=$this->db->query("select * from user where id='".$this->session->userdata('userid')."'");
                    $rt1=$ty1->result_array();
					//
					$ty2=$this->db->query("select * from tbl_cities where fk_office_id='".$rt1[0]['fk_office_id']."'");
                    $rt2=$ty2->result_array();
					$total = sizeof($rt2);										if ($this->session->userdata('userrole') =='Admin')						$zquery="select * from tbl_instruments where status='1' AND fk_category_id!='1'";					else
						$zquery="select * from tbl_instruments where status='1' AND fk_category_id!='1' AND fk_office_id='" .$rt1[0]['fk_office_id']."'";
					$myquery="select * from tbl_complaints where fk_city_id IN(";
					$n=0;
					foreach($rt2 as $citi_id)
					{
						if($n<$total-1)
						{
							$myquery.=$citi_id['pk_city_id'].', ';
						}
						else
						{
							$myquery.=$citi_id['pk_city_id'];
						}
						$n++;
					}
					$myquery.=')';
					//echo $myquery;
					//$ty=$this->db->query($myquery); commented by zaaid
					$ty=$this->db->query($zquery);
                    $rt=$ty->result_array();
					if (sizeof($rt) == "0") 
					{
					  //do somthing  
					} else {
						foreach ($rt as $equipment_list) 
						  { 
							$tyza	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_list['pk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC LIMIT 1");
							$rtza	= 	$tyza->result_array(); 
							$days_since_pm	=	'';
							if (!empty($rtza)){
								$last_pm_date	=	strtotime($rtza[0]['finish_time']);
								$current_date	=	time();
								$difference		=	$current_date - $last_pm_date;
								//$interval		= 	$difference->format(%a);
								$interval		=	floor($difference/(60*60*24));
							}
							else $interval		=	"N/A";
						//	$i = 0; 
							switch ($i) {
								case 0:
									if 	($interval<40)	 continue 2; ////// only greater than 39
									break;							
								case 1:
									if 	($interval<30 || $interval>39)	 continue 2; //// only between 30 to 39
									break;	
								case 2:
									if 	($interval>29)	 continue 2; ////////////////// only less than 30
									break;
									
							} 
				//			$i 		=	3;
				//			if 		($i==1)
				//				if 	($interval>29)	 continue; ////////////////// only less than 30
				//			elseif 	($i==2)
				//				if 	($interval<30 || $interval>39)	 continue; //// only between 30 to 39
				//			else
				//				if 	($interval<40)	 continue; ////// only greater than 39
							?>
                             <form  action="<?php echo base_url(); ?>complaint/insert_complaint_pm" method="post">
					 		<tr class="odd gradeX">
						<!--	  <td>  Interval -->
                               <?php
							  // if ($interval ==	"N/A") 
								if (!empty($rtza))
									$days_since_pm	= $interval . " day(s)";
								else
									$days_since_pm	= $interval;
									
									//echo "test";
							  ?>
                              <input type="hidden" name="interval" value="<?php echo $interval;?>">
                      <!--        </td> -->
                              <td> <!--City -->
                              <?php
									//echo $equipment_list['fk_client_id'];
									
									if(substr($equipment_list['fk_client_id'],0,1)=='o')
										{
											//$office_id		=	substr($sup_dvr['fk_customer_id'],13,1);
											$office_id		= 	$equipment_list['fk_client_id'];
											$qu2			=	"SELECT * from tbl_offices where client_option =  '".$office_id."'";
											$gh2			=	$this->db->query($qu2);
											$rz2			=	$gh2->result_array();
											$myclient 		= 	$rz2[0]['office_name'];
											//$business		=   '';
											//for area
											$area			= $myclient;
											echo $myclient;
										}
									else
										{
									$tyz	=	$this->db->query("select * from tbl_clients where pk_client_id='".$equipment_list['fk_client_id']."'");
									$rtz	= 	$tyz->result_array();
                              		$ty4	=	$this->db->query("select * from tbl_cities where pk_city_id='".$rtz[0]['fk_city_id']."'");
                    				$rt4	=	$ty4->result_array();
									$myclient 		= 	$rt4[0]['city_name'];
									echo $myclient;
										}
							  ?>
                              <input type="hidden" name="fk_city_id" value="<?php echo $myclient;//$equipment_list['fk_city_id'];?>">
                               </td>
                              <td> <!-- Customer -->
                               <?php
									if(substr($equipment_list['fk_client_id'],0,1)=='o')
									echo	$myclient;
									else
									{
                              		$ty4	=	$this->db->query("select * from tbl_clients where pk_client_id='".$equipment_list['fk_client_id']."'");
                    				$rt4	=	$ty4->result_array();
									echo $rt4[0]['client_name'];
									}
							  ?>
                              <input type="hidden" name="fk_customer_id" value="<?php echo $equipment_list['fk_client_id'];?>">
                               </td>
                              <td> <!-- Equipment -->
                               <?php
                              		$ty4	=	$this->db->query("select * from tbl_products where pk_product_id='".$equipment_list['fk_product_id']."'");
                    				$rt4	=	$ty4->result_array();
									echo $rt4[0]['product_name']
							  ?>
                              <input type="hidden" name="fk_instrument_id" value="<?php echo $equipment_list['fk_product_id'];?>">
                              </td>
        
                              <td> <!-- Serial Number -->
                              <?php
                              		echo $equipment_list['serial_no'];
							  ?>
                              <input type="hidden" name="ts_number" value="<?php echo $equipment_list['serial_no'];?>">
                               </td>
							   
						<!-- 	   <td> Total PMs -->
                              <?php
                              		$tyzb	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_list['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC ");
									$rtzb	= 	$tyzb->result_array();
									$total_pms	=	sizeof($rtzb);
									
									$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_list['pk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
									$rtz	= 	$tyz->result_array();
									$total_pms_c	=	sizeof($rtz);
									//echo 	$total_pms;
							  ?>
                         <!--      </td> -->
							 
							   
							   <td> <!-- Average PM Frequency -->
                              <?php
                              		
									if ($total_pms_c > 1 )
									{
                              		//$ty4	=	$this->db->query("select * from user where id='".$rtz[0]['assign_to']."'");
                    				//$rt4	=	$ty4->result_array();
									//echo $rt4[0]['first_name'];
									
									$max_pms_index		=	$total_pms_c - 1;
									$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
									$last_pm			=	strtotime($rtz[0]['finish_time']);
								//$current_date		=	time();
									$diff				=	$last_pm - $first_pm;
								//$interval		= 	$difference->format(%a);
									$total_days			=	floor($diff/(60*60*24));
									$pm_frequency		=	$total_days/$max_pms_index;
									echo	$pm_frequency . " days";
									}
									elseif ($total_pms_c == 1 )
									{
										$current_date		=	time();
										$last_pm			=	strtotime($rtz[0]['finish_time']);
										$diff				=	$current_date - $last_pm;
										$total_days			=	floor($diff/(60*60*24));
										//echo $total_days . " day(s)";
										echo "N/A";
										
									}
									else echo "N/A";
							  ?>
                               </td>
							   
							   <td>
							   
							   <?php 
									echo $days_since_pm;
							   ?>
							   
							   </td>
        
                              <td>  <!-- Last PM FSE -->
                               <?php
							   
									//$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment_list['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC LIMIT 1");
									//$rtz	= 	$tyz->result_array();
									if (!empty($rtzb))
									{
                              		$ty4	=	$this->db->query("select * from user where id='".$rtzb[0]['assign_to']."'");
                    				$rt4	=	$ty4->result_array();
									echo $rt4[0]['first_name'];}
									else echo "N/A";
                              		//$ty4	=	$this->db->query("select * from user where id='".$equipment_list['assign_to']."'");
                    				//$rt4	=	$ty4->result_array();
									//echo $rt4[0]['first_name']
									
							  ?>
                              <input type="hidden" name="assign_to" value="<?php echo 1;//echo $equipment_list['assign_to'];?>">
                              </td>
        
                              <td> <!-- Last PM Date -->
                              
                              <?php
                              		//echo date('d-M-Y', strtotime($equipment_list['date']));
									if (!empty($rtzb)) echo date('d-M-Y', strtotime($rtzb[0]['date']));
									else echo "N/A";
							  ?>
                              <input type="hidden" name="date" value="<?php echo date('Y-m-d');?>">
                              </td>
							  
							  <td class="cStatus"> <!-- Last PM Status -->
							  <?php
							  if (!empty($rtzb))
								  $status = $rtzb[0]['status'];
							  else
								  $status = 'N/A';
							  //echo $status;
							  
							  $this->load->model("complaint_model");
							  $obj=new Complaint_model();
							  $obj->current_status($status);
												
							  ?>
							  <input type="hidden" name="status" value="<?php echo $status; ?>" class="">
							  </td>
        
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