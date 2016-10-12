<?php $this->load->view('header');?>

<script>
$(window).load(function() {   
  $('#loader').hide();
  $('#roww').show();
});
</script>
<style>
#roww { display:none }

</style>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title"> FSE Tasks Statistics <small></small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> FSE Tasks Statistics </li><!--<span class="display_your_varibal_here"></span>-->

          

        </ul>


      </div>
	  
	  <?php
		$pq	=	$this->db->query("select * from tbl_products where `fk_category_id` !=1 AND `status`=0");
		$pr =	$pq->result_array();

		$oq	=	$this->db->query("select * from tbl_offices");
		$or =	$oq->result_array();

		$color_class 	= array("grey-gallery","green-seagreen", "red-flamingo","yellow-zed","purple-wisteria","blue-hoki","blue-ebonyclay","green-jungle","red");
		$column_color	= array("success","success","danger","active","warning","success","danger","active","warning","success","danger","active","warning","success","danger","active","warning","success","danger","active","warning","success","danger","active","warning");
		function dashForZero($x) {
			if ($x==0) echo '-';
			else echo $x;
		}
		
		function dashForZeroValue($x) {
			if ($x==0) return '-';
			else return $x;
		}
	  
	  ?>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->
	  <div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
          <div class="row" id="roww">
            <div class="col-md-12"> 
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
<?php ////////////////////////************************** Main Loop******************************//////////////////////////
for($j=1;$j<=2;$j++) { 
?>
			  <?php if ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') {
								
								if ($j==1) $complaint_nature 	= 	'complaint';
								if ($j==2) $complaint_nature 	= 	'PM';
								
								if (isset($office))	{
									$office_id	=	$office['pk_office_id'];
									$statisticts_territory	=	$office['office_name'];
								}
								else {
									$office_id	=	0;
									$statisticts_territory	=	'All Pakistan';
								}
								$total_equipments	=	0;
								
								if ($complaint_nature 	!= 	'PM') {
									$complaint_type		=	'Complaints';
									$complaint_status	=	'Solved';
								}
								else {
									$complaint_type		=	'PMC';
									$complaint_status	=	'Completed';
								}
								
								$c_sd	=	'sd'.$office_id.'0'; //sd00
								$c_ed	=	'ed'.$office_id.'0'; //ed00
								$p_sd	=	'sd'.$office_id.'1'; //sd01
								$p_ed	=	'ed'.$office_id.'1'; //ed01
								
								///// The syntax of the query string will be something like ?sd01='2015-07-01'&ed01='2015-04-01'
								if($j==1 && isset($_GET[$c_sd]) && strlen($_GET[$c_sd])>6 ) // when complaint
								{ 
									//$start_date			=	str_replace("'","",$_GET[$c_sd]);
									$start_date_a	=	$_GET[$c_sd];
									$start_date		= 	date('Y-m-d', strtotime($start_date_a));
								}
								elseif ($j==2 && isset($_GET[$p_sd]) && strlen($_GET[$p_sd])>6 ) // when complaint
								{ 
									//$start_date			=	str_replace("'","",$_GET[$p_sd]);
									$start_date_a	=	$_GET[$p_sd];
									$start_date		= 	date('Y-m-d', strtotime($start_date_a));
								}
								else {
									$start_date_a			=	date('d-M-Y');
									$start_date			=	'2015-04-01';
								}
								
								if($j==1 && isset($_GET[$c_ed]) && strlen($_GET[$c_ed])>6 ) // when complaint
								{ 
									//$end_date			=	str_replace("'","",$_GET[$c_ed]);
									$end_date_a		=	$_GET[$c_ed];
									$end_date		= 	date('Y-m-d', strtotime($end_date_a));
								}
								elseif ($j==2 && isset($_GET[$p_ed]) && strlen($_GET[$p_ed])>6 ) // when complaint
								{ 
									//$end_date			=	str_replace("'","",$_GET[$p_ed]);
									$end_date_a		=	$_GET[$p_ed];
									$end_date		= 	date('Y-m-d', strtotime($end_date_a));
								}
								else {
									$end_date_a			=	date('d-M-Y');
									$end_date			=	date('Y-m-d');
								}
								
				  ?>
              <div class="portlet box <?php echo $color_class[$office_id]; ?>" id="<?php echo 'of'.$office_id.$j; ?>">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-plane"></i><?php echo 'FSE '.$complaint_type. ' Statistics -'. $statisticts_territory.' ';  ?> - Real Time</div>
                <div class="actions">
								<div class="btn-group">
									<a class="btn default" href="javascript:;" data-toggle="dropdown">
									<!--Columns-->Employees <i class="fa fa-angle-down"></i>
									</a>
									<div id="example_column_toggler" class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
									<?php
									$uq	=	$this->db->query("select * from user where `userrole` IN ('FSE','Supervisor') AND delete_status=0  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
									$ur	=	$uq->result_array();
									$table_id	=	'#oft'.$office_id.$j;
									$m=4;
									foreach ($ur as $employee) {
										$q  =	$m+1;
										echo '<label><input type="checkbox" checked onchange="fnShowHide2('.$m.','.$q.',\''.$table_id.'\');" >'.$employee['first_name'].'</label>';
										$m+=2;
									}
									?>
									</div>
								</div>
							</div>
				</div>
                <div class="portlet-body">
                  
                  
					<?php
					//$complaint_nature 	= 	'PM';
					//$finish_status		=	'Completed';
					//$start_date			=	'2015-04-01';
					//$end_date			=	date('Y-m-d');
					//show_statistics(0,$complaint_nature,$finish_status,$start_date,$end_date,$pr);
					?>
					
					<?php ////////////////////////////////////////////// ?>
					<div class="row">
                        <form method="get" action="<?php echo base_url();?>sys/territory_statistics#of<?php echo $office_id.$j; ?>">
						<?php 
								foreach ($_GET as $k => $v) 
 								 {
									  $$k = $v;
									   ?>
                                       <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>" />
									   <?php
								 }
							?>
                            <div class="col-md-3">
                                <div class="form-group">
								<?php if ($j==1) {$sd_control = $c_sd;} else {$sd_control = $p_sd;} ?>
                                    <input type="text" name="<?php echo $sd_control; ?>" class="form-control datepicker" value="<?php echo $start_date_a; //if(isset($_GET[$sd_control])){ echo $_GET[$sd_control]; } else { echo date('d-M-Y');} ?>" required  />
                                    <span class="help-block">Start Date</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
								<?php if ($j==1) {$ed_control = $c_ed;} else {$ed_control = $p_ed;} ?>
                                    <input type="text" name="<?php echo $ed_control; ?>" class="form-control datepicker" value="<?php echo $end_date_a; //if(isset($_GET[$ed_control])){ echo $_GET[$ed_control]; } else { echo date('d-M-Y');} ?>" required />
                                    <span class="help-block">End Date</span>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                        <input type="submit"  class="btn btn-default blue-madison" value="Search" >
                                </div>
                            </div>
                        </form>
                    </div>
<div class="table-responsive">					
					<table class="table table-striped table-bordered table-hover flip-content dataaTable " id="<?php echo 'oft'.$office_id.$j; ?>">
                    <thead> <!-- Headings -->
						<tr>
						<th class="bg-blue-steel">  			</th>
						<th class="bg-grey-steel text-center">  <?php echo $complaint_type; ?>			</th>
						<th class="bg-grey-steel text-center"> <?php echo $complaint_type; ?></th>
						<th class="bg-grey-steel text-center"> <span class="font-red"><?php echo $complaint_type; ?></span></th>
						<?php
						if ($office_id!=0)
							$uq	=	$this->db->query("select * from user where `fk_office_id`='".$office_id ."' AND `userrole` IN ('FSE','Supervisor')  AND delete_status='0' ORDER BY fk_office_id, userrole");
                        else
							$uq	=	$this->db->query("select * from user where `userrole` IN ('FSE','Supervisor')  AND delete_status='0'  ORDER BY fk_office_id, userrole");
						$ur	=	$uq->result_array();
						$m=1;
						foreach ($ur as $employee) {
							echo '<th class="text-center '.$column_color[$m].'" colspan="2"> ' . $employee['first_name'].'</th>';
							$m++;
						}
						?>
						</tr>
						
                      <tr>
						<th class="bg-blue-steel text-center bg-grey-border">Equipment	</th>
						<th class="bg-grey-steel text-center bg-grey-border">  Assigned			</th>
						<th class="bg-grey-steel text-center bg-grey-border">  <?php echo $complaint_status; ?>			</th>
						<th class="bg-grey-steel text-center bg-grey-border"> <span class="font-red"> Pending		</span></th>
						<?php
						$loop	=	2 * sizeof($ur);
						$m = 1;
						for($i=1;$i<=$loop;$i++) {
							if ($i%2==0) {$m++; echo '<th class="text-center '.$column_color[$m-1].'"> <span class="font-red">Pending</span></th>';}
							else echo '<th class="text-center '.$column_color[$m].'">' .$complaint_status. '</th>';
						}
						?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
								$sum_assigned	=	0;
								$sum_finished	=	0;
								$sum_pending	=	0;
                                foreach ($pr as $product) {
									
                                    ?>
									<?php
									
										if ($office_id!=0)	{
											//echo "Zaaid";
											$eq	=	$this->db->query("select * from tbl_instruments where `fk_product_id`=".$product['pk_product_id'] ." AND `status`=1 AND `fk_office_id`='".$office_id."'");
											$er =	$eq->result_array();
											
										}
										else	{
											//echo "Ahmed";
											//$eq	=	$this->db->query("select * from tbl_instruments where `fk_product_id`=".$product['pk_product_id'] ." AND `status`=1");
											$eq	=	$this->db->query("select * from tbl_instruments where `fk_product_id`=".$product['pk_product_id'] ." ");
											$er =	$eq->result_array();
											
										}
											
										?>
										<?php if (sizeof($er)>0) {?>
										<?php
										$total = sizeof($er);
										$n=0;
										$product_euipments	=	"-10,";
										$r1	=	'<span class="font-red">';
										$r2	=	'</span>';
										$finish_status		=	'Completed';
										
										
										if ($complaint_nature 	== 	'PM') {
											$finish_status	=	'Completed';
										}
										else {
											$finish_status	=	'Closed';
										}
										
										/*
										$complaint_nature 	= 	$c_n;
										
										$finish_status		=	$f_s;
										
										$start_date			=	$s_d;
										
										$end_date			=	$e_d; */
										//////// *****************************//////////////////////
										 foreach ($er as $equipment) {
											$e_id	=	$equipment['pk_instrument_id'];
											if($n<$total-1)
											{
												$product_euipments.=$e_id.', ';
											}
											else
											{
												$product_euipments.=$e_id;
											}
											$n++;
										}
										// Total Completed
										$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND status='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
										//$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND status='".$finish_status."'");
										$rtz	= 	$tyz->result_array();
										$total_finished	=	sizeof($rtz);
										
										
										// Total Pending
										$tyzb	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND status!='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
										//$tyzb	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND status!='".$finish_status."'");
										$rtzb	= 	$tyzb->result_array();
										$total_pending	=	sizeof($rtzb);
										
										$total_assigned	=	$total_finished + $total_pending;
										
										?>
									
                                    <tr class="odd gradeX">
                                        
                                        <th class="bg-blue-steel  bg-grey-border"> <!-- Equipment -->
                                            <?php 
												echo $product['product_name'];
											?>
                                        </th>
										
										<td class="bg-grey-steel text-center bg-grey-border"> <!-- Assigned -->
                                            <?php 
												$sum_assigned	+=	$total_assigned;
												dashForZero($total_assigned);
											?>
                                        </td>
										
										<td class="bg-grey-steel text-center bg-grey-border"> <!-- Completed -->
                                            <?php 
												$sum_finished	+=	$total_finished;
												dashForZero($total_finished);
											?>
                                        </td>
										
                                        <td class="bg-grey-steel text-center bg-grey-border"> <!-- Pending -->
                                             <?php 
											 $sum_pending	+=	$total_pending;
											 echo $r1;//////// for red font
												dashForZero($total_pending);
											echo $r2;
											?>
                                        </td >
										
										<?php
										
										foreach ($ur as $employee) {
											//Total Finished
											$tyzc	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
											$rtzc	= 	$tyzc->result_array();
											$total_finished	=	sizeof($rtzc);
											
											// Total Pending
											$tyzd	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status!='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
											$rtzd	= 	$tyzd->result_array();
											$total_pending	=	sizeof($rtzd);
											
											$test	= "select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status!='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";
											echo '<td class="text-center"> ' . dashForZeroValue($total_finished) .'</td>';
											echo '<td class="text-center"><span class="font-red">' . dashForZeroValue($total_pending) .'</span></td>';
										}
										?>
                                        
                                        
                                    </tr>
                                    <?php
										}
                                }
                    ?>
                      
                    </tbody>
					<tfoot  >
						<tr >
							<th class="bg-blue-steel bg-grey-border" >
								Total
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $sum_assigned; ?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $sum_finished; ?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $sum_pending; ?>
							</th>
							<?php
										
										foreach ($ur as $employee) {
											//Total Finished
											$tyze	=	$this->db->query("select * from tbl_complaints where complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
											$rtze	= 	$tyze->result_array();
											$total_finished	=	sizeof($rtze);
											
											// Total Pending
											$tyzf	=	$this->db->query("select * from tbl_complaints where complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status!='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
											$rtzf	= 	$tyzf->result_array();
											$total_pending	=	sizeof($rtzf);
											
											
											echo '<th class="text-center bg-grey-border"> ' . $total_finished .'</th>';
											echo '<th class="text-center bg-grey-border"><span class="font-red">' . $total_pending .'</span></th>';
										}
										?>
						</tr>
					</tfoot>
                  </table>

</div>					
					<?php ////////////////////////////////////////////// ?>
                           
                </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET--> 
			  <?php } ?>
			  
			  
<?php ////////////////////////************************** Main Loop******************************//////////////////////////
}
?>	
		<?php
		$uq	=	$this->db->query("select `fk_office_id` from user where `id` ='".$this->session->userdata('userid')."'");
		$ur =	$uq->result_array();
			foreach ($or as $office) {
		?>
		
		<?php  if ( ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') || $ur[0]['fk_office_id']==$office['pk_office_id'] ) { ?>
<?php ////////////////////////************************** Main Loop******************************//////////////////////////
for($j=1;$j<=2;$j++) { 
?>
			  <?php // if ($this->session->userdata('userrole')=='Admin') {
								
								if ($j==1) $complaint_nature 	= 	'complaint';
								if ($j==2) $complaint_nature 	= 	'PM';
								
								if (isset($office))	{
									$office_id	=	$office['pk_office_id'];
									$statisticts_territory	=	$office['office_name'];
								}
								else {
									$office_id	=	0;
									$statisticts_territory	=	'All Pakistan';
								}
								$total_equipments	=	0;
								
								if ($complaint_nature 	!= 	'PM') {
									$complaint_type		=	'Complaints';
									$complaint_status	=	'Solved';
								}
								else {
									$complaint_type		=	'PMC';
									$complaint_status	=	'Completed';
								}
								
								$c_sd	=	'sd'.$office_id.'0'; //sd00
								$c_ed	=	'ed'.$office_id.'0'; //ed00
								$p_sd	=	'sd'.$office_id.'1'; //sd01
								$p_ed	=	'ed'.$office_id.'1'; //ed01
								
								///// The syntax of the query string will be something like ?sd01='2015-07-01'&ed01='2015-04-01'
								if($j==1 && isset($_GET[$c_sd]) && strlen($_GET[$c_sd])>6 ) // when complaint
								{ 
									//$start_date			=	str_replace("'","",$_GET[$c_sd]);
									$start_date_a	=	$_GET[$c_sd];
									$start_date		= 	date('Y-m-d', strtotime($start_date_a));
								}
								elseif ($j==2 && isset($_GET[$p_sd]) && strlen($_GET[$p_sd])>6 ) // when complaint
								{ 
									//$start_date			=	str_replace("'","",$_GET[$p_sd]);
									$start_date_a	=	$_GET[$p_sd];
									$start_date		= 	date('Y-m-d', strtotime($start_date_a));
								}
								else {
									$start_date_a			=	date('d-M-Y');
									$start_date			=	'2015-04-01';
								}
								
								if($j==1 && isset($_GET[$c_ed]) && strlen($_GET[$c_ed])>6 ) // when complaint
								{ 
									//$end_date			=	str_replace("'","",$_GET[$c_ed]);
									$end_date_a		=	$_GET[$c_ed];
									$end_date		= 	date('Y-m-d', strtotime($end_date_a));
								}
								elseif ($j==2 && isset($_GET[$p_ed]) && strlen($_GET[$p_ed])>6 ) // when complaint
								{ 
									//$end_date			=	str_replace("'","",$_GET[$p_ed]);
									$end_date_a		=	$_GET[$p_ed];
									$end_date		= 	date('Y-m-d', strtotime($end_date_a));
								}
								else {
									$end_date_a			=	date('d-M-Y');
									$end_date			=	date('Y-m-d');
								}
								
				  ?>
              <div class="portlet box <?php echo $color_class[$office_id]; ?>" id="<?php echo 'of'.$office_id.$j; ?>">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-plane"></i><?php echo 'FSE '. $complaint_type. ' Statistics -'. $statisticts_territory.' ';  ?> - Real Time</div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
                <div class="portlet-body">
                  
                  
					<?php
					//$complaint_nature 	= 	'PM';
					//$finish_status		=	'Completed';
					//$start_date			=	'2015-04-01';
					//$end_date			=	date('Y-m-d');
					//show_statistics(0,$complaint_nature,$finish_status,$start_date,$end_date,$pr);
					?>
					
					<?php ////////////////////////////////////////////// ?>
					<div class="row">
                        <form method="get" action="<?php echo base_url();?>sys/territory_statistics#of<?php echo $office_id.$j; ?>">
						<?php 
								foreach ($_GET as $k => $v) 
 								 {
									  $$k = $v;
									   ?>
                                       <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>" />
									   <?php
								 }
						?>
                            <div class="col-md-3">
                                <div class="form-group">
								<?php if ($j==1) {$sd_control = $c_sd;} else {$sd_control = $p_sd;} ?>
                                    <input type="text" name="<?php echo $sd_control; ?>" class="form-control datepicker" value="<?php echo $start_date_a; //if(isset($_GET[$sd_control])){ echo $_GET[$sd_control]; } else { echo date('d-M-Y');}?>" required  />
                                    <span class="help-block">Start Date</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
								<?php if ($j==1) {$ed_control = $c_ed;} else {$ed_control = $p_ed;} ?>
                                    <input type="text" name="<?php echo $ed_control; ?>" class="form-control datepicker" value="<?php echo $end_date_a; //if(isset($_GET[$ed_control])){ echo $_GET[$ed_control]; } else { echo date('d-M-Y');}?>" required />
                                    <span class="help-block">End Date</span>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    
                                        <input type="submit"  class="btn btn-default blue-madison" value="Search" >
                                </div>
                            </div>
                        </form>
                    </div>
					<table class="table table-striped table-bordered table-hover flip-content dataaTable">
                    <thead> <!-- Headings -->
						<tr>
						<th class="bg-blue-steel">  			</th>
						<th class="bg-grey-steel text-center">  <?php echo $complaint_type; ?>			</th>
						<th class="bg-grey-steel text-center"> <?php echo $complaint_type; ?></th>
						<th class="bg-grey-steel text-center"> <span class="font-red"><?php echo $complaint_type; ?></span></th>
						<?php
						if ($office_id!=0)
							$uq	=	$this->db->query("select * from user where `fk_office_id`='".$office_id ."' AND `userrole` IN ('FSE','Supervisor') AND delete_status='0'  ORDER BY fk_office_id, userrole");
                        else
							$uq	=	$this->db->query("select * from user where `userrole` IN ('FSE','Supervisor') AND delete_status='0'  ORDER BY fk_office_id, userrole");
						$ur	=	$uq->result_array();
						
						$m=1;
						foreach ($ur as $employee) {
							echo '<th class="text-center '.$column_color[$m].'" colspan="2"> ' . $employee['first_name'].'</th>';
							$m++;
						}
						?>
						</tr>
						
                      <tr>
						<th class="bg-blue-steel text-center bg-grey-border">Equipment	</th>
						<th class="bg-grey-steel text-center bg-grey-border">  Assigned			</th>
						<th class="bg-grey-steel text-center bg-grey-border">  <?php echo $complaint_status; ?>			</th>
						<th class="bg-grey-steel text-center bg-grey-border"> <span class="font-red"> Pending		</span></th>
						<?php
						$loop	=	2 * sizeof($ur);
						$m=1;
						for($i=1;$i<=$loop;$i++) {
							if ($i%2==0) {$m++; echo '<th class="text-center '.$column_color[$m-1].'"> <span class="font-red">Pending</span></th>';}
							else echo '<th class="text-center '.$column_color[$m].'">' .$complaint_status. '</th>';
						}
						?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
								$sum_assigned	=	0;
								$sum_finished	=	0;
								$sum_pending	=	0;
                                foreach ($pr as $product) {
									
                                    ?>
									<?php
									
										if ($office_id!=0)	{
											//echo "Zaaid";
											$eq	=	$this->db->query("select * from tbl_instruments where `fk_product_id`=".$product['pk_product_id'] ." AND `status`=1 AND `fk_office_id`='".$office_id."'");
											$er =	$eq->result_array();
											
										}
										else	{
											//echo "Ahmed";
											//$eq	=	$this->db->query("select * from tbl_instruments where `fk_product_id`=".$product['pk_product_id'] ." AND `status`=1");
											$eq	=	$this->db->query("select * from tbl_instruments where `fk_product_id`=".$product['pk_product_id'] ." ");
											$er =	$eq->result_array();
											
										}
											
										?>
										<?php if (sizeof($er)>0) {?>
										<?php
										$total = sizeof($er);
										$n=0;
										$product_euipments	=	"-10,";
										$r1	=	'<span class="font-red">';
										$r2	=	'</span>';
										$finish_status		=	'Completed';
										
										
										if ($complaint_nature 	== 	'PM') {
											$finish_status	=	'Completed';
										}
										else {
											$finish_status	=	'Closed';
										}
										
										/*
										$complaint_nature 	= 	$c_n;
										
										$finish_status		=	$f_s;
										
										$start_date			=	$s_d;
										
										$end_date			=	$e_d; */
										//////// *****************************//////////////////////
										 foreach ($er as $equipment) {
											$e_id	=	$equipment['pk_instrument_id'];
											if($n<$total-1)
											{
												$product_euipments.=$e_id.', ';
											}
											else
											{
												$product_euipments.=$e_id;
											}
											$n++;
										}
										// Total Completed
										$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND status='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
										//$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND status='".$finish_status."'");
										$rtz	= 	$tyz->result_array();
										$total_finished	=	sizeof($rtz);
										
										
										// Total Pending
										$tyzb	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND status!='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
										//$tyzb	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND status!='".$finish_status."'");
										$rtzb	= 	$tyzb->result_array();
										$total_pending	=	sizeof($rtzb);
										
										$total_assigned	=	$total_finished + $total_pending;
										
										?>
									
                                    <tr class="odd gradeX">
                                        
                                        <th class="bg-blue-steel  bg-grey-border"> <!-- Equipment -->
                                            <?php 
												echo $product['product_name'];
											?>
                                        </th>
										
										<td class="bg-grey-steel text-center bg-grey-border"> <!-- Assigned -->
                                            <?php 
												$sum_assigned	+=	$total_assigned;
												dashForZero($total_assigned);
											?>
                                        </td>
										
										<td class="bg-grey-steel text-center bg-grey-border"> <!-- Completed -->
                                            <?php 
												$sum_finished	+=	$total_finished;
												dashForZero($total_finished);
											?>
                                        </td>
										
                                        <td class="bg-grey-steel text-center bg-grey-border"> <!-- Pending -->
                                             <?php 
											 $sum_pending	+=	$total_pending;
											 echo $r1;//////// for red font
												dashForZero($total_pending);
											echo $r2;
											?>
                                        </td >
										
										<?php
										
										foreach ($ur as $employee) {
											//Total Finished
											$tyzc	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
											$rtzc	= 	$tyzc->result_array();
											$total_finished	=	sizeof($rtzc);
											
											// Total Pending
											$tyzd	=	$this->db->query("select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status!='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
											$rtzd	= 	$tyzd->result_array();
											$total_pending	=	sizeof($rtzd);
											
											$test	= "select * from tbl_complaints where fk_instrument_id IN(".$product_euipments.") AND complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status!='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";
											echo '<td class="text-center"> ' . dashForZeroValue($total_finished) .'</td>';
											echo '<td class="text-center"><span class="font-red">' . dashForZeroValue($total_pending) .'</span></td>';
										}
										?>
                                        
                                        
                                    </tr>
                                    <?php
										}
                                }
                    ?>
                      
                    </tbody>
					<tfoot  >
						<tr >
							<th class="bg-blue-steel bg-grey-border" >
								Total
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $sum_assigned; ?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $sum_finished; ?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $sum_pending; ?>
							</th>
							<?php
										
										foreach ($ur as $employee) {
											//Total Finished
											$tyze	=	$this->db->query("select * from tbl_complaints where complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
											$rtze	= 	$tyze->result_array();
											$total_finished	=	sizeof($rtze);
											
											// Total Pending
											$tyzf	=	$this->db->query("select * from tbl_complaints where complaint_nature='".$complaint_nature."' AND `assign_to`='".$employee['id']."' AND status!='".$finish_status."' AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
											$rtzf	= 	$tyzf->result_array();
											$total_pending	=	sizeof($rtzf);
											
											
											echo '<th class="text-center bg-grey-border"> ' . $total_finished .'</th>';
											echo '<th class="text-center bg-grey-border"><span class="font-red">' . $total_pending .'</span></th>';
										}
										?>
						</tr>
					</tfoot>
                  </table>

					
					<?php ////////////////////////////////////////////// ?>
                           
                </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET--> 
			  <?php //} ?>
			  
			  
<?php ////////////////////////************************** Main Loop******************************//////////////////////////
}
?>		
		
		
		
			<?php  } //If Condition ?>
		<?php
			} // End of Foreach
		?>
			
			
			
			
			

			
			
			
			</div>
          </div>
          <!-- END PAGE CONTENT-->
 

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

$(document).ready(function() { 
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 100
	});
	
	//new $.fn.dataTable.FixedColumns( table );
});


function fnShowHide( iCol , t)
{
    /* Get the DataTables object again - this is not a recreation, just a get of the object */
	var test	=	'#oft01';
    var oTable = $(t).dataTable();
     
    var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
    oTable.fnSetColumnVis( iCol, bVis ? false : true );
}

function fnShowHide2(iCol1,iCol2,z)
{
	fnShowHide( iCol1, z);
	fnShowHide( iCol2, z );
}

function fnShowHide3(iCol)
{
	var test	=	'#oft01';
	var table = $('#oft01').dataTable();
	var column = table.column( iCol );
	column.visible( ! column.visible() );
}

var tableColumnToggler = $('#example_column_toggler');
//var oTable = $('#oft01').dataTable();

$('input[type="checkbox"]', tableColumnToggler).change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
        });
</script>

<style>
.bg-grey-border
{
	border-bottom:1px solid #dddddd !important;
	border-right:1px solid #dddddd !important;
}

</style>