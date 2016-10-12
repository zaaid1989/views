<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title"> PM Statistics <small></small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> PM Statistics </li><!--<span class="display_your_varibal_here"></span>-->

          

        </ul>


      </div>
	  
	  <?php
		$pq	=	$this->db->query("select * from tbl_products where `fk_category_id` !=1 AND `status`=0");
		$pr =	$pq->result_array();

		$oq	=	$this->db->query("select * from tbl_offices");
		$or =	$oq->result_array(); 
	  
	  ?>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
			  <?php if ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') {
				  $total_equipments				=	0;
				  $total_total_pms				=	0;
				  $total_total_pms_pending 		=	0;
				  $total_total_pms_completed	=	0;
				  $total_avg_frq				=	0;
				  
				  ///////////////////////////////////
					$total_pm_within_thirty		=	0;
					$total_pm_thirty_forty		=	0;
					$total_pm_above_forty		=	0;
					$total_pm_never				=	0;
					$total_completed_within_thirty		=	0;
					$total_completed_thirty_forty		=	0;
					$total_completed_above_forty		=	0;
					$total_pending_within_thirty		=	0;
					$total_pending_thirty_forty		=	0;
					$total_pending_above_forty		=	0;
				  
				  ///////////////////////////////////
				  
				  /// 13 July
				  
					$no_pm_data_total		=	0;
					$good_units_total		=	0;
					$due_units_total		=	0;
					$past_due_total			=	0;
					$neglected_total		=	0;
					$pmc_assigned_total		=	0;
					$pmc_assigned_late_total	=	0;	
				  
				  // 13 July
				  
				  ?>
              <div class="portlet box grey-gallery">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-plane"></i>PM Statistics All Pakistan - Real Time</div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
                <div class="portlet-body">
                  
                  <div class="portlet-body flip-scroll">
                   <table class="table table-striped table-bordered table-hover flip-content " id="sample_2">
                    <thead> <!--
						<tr>
						
						<th class="bg-grey" colspan="4">  			</th>
						<th class="bg-blue-hoki text-center" colspan="4"> Assigned (Days)</th>
                        <th class="bg-grey">  			</th>
						</tr>
						-->
					
                      <tr>
                        
                        <th class="bg-blue-steel text-center bg-grey-border"> Equipment 			</th>
						<th class="bg-grey-gallery text-center bg-grey-border"> Total<br />Units 			</th>
                        <th class="bg-grey-steel text-center bg-grey-border">  No PM<br />Data			</th>
                        <th class="bg-green-meadow text-center bg-grey-border">  Good Units<br />Last PM < 30<br />Days		</th>
						<th class="bg-yellow-zed text-center bg-grey-border"> PM Due<br />Last PM > 30<br />Days 			</th>
					<!--	<th class="bg-yellow-gold text-center bg-grey-border"> PM Past Due<br />Last PM > 40<br />Days 			</th> -->
						<th class="bg-red-thunderbird text-center bg-grey-border"> PM Neglected<br />Last PM > 40<br />Days	</th>
						<th class="bg-grey-steel text-center bg-grey-border"> PMC Assigned		</th>
						<th class="bg-grey-steel text-center bg-grey-border"> <span class="font-red"> PMC Assigned<br />Late		</span></th>
                        <th class="bg-purple text-center bg-grey-border"> Average Time<br />Between PM </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
							
                             
                                foreach ($pr as $product) {
                                    ?>
									<?php
										$eq	=	$this->db->query("select * from tbl_instruments where `fk_product_id`=".$product['pk_product_id'] ." AND `status`=1");
										$er =	$eq->result_array();
										?>
										<?php if (sizeof($er)>0) {?>
										<?php
										$total = sizeof($er);	
										$myquery="select * from tbl_complaints where fk_instrument_id IN(";
										$n=0;
										$pm_frequency_sum	=	0;
										$total_pms_sum	=	0;
										$total_pms_completed	=	0;
										$total_pms_pending	=	0;
										/**************** *******************/
										$pm_within_thirty	=	0;
										$pm_thirty_forty	=	0;
										$pm_above_forty		=	0;
										$pm_never			=	0;
										$completed_within_thirty	=	0;
										$completed_thirty_forty		=	0;
										$completed_above_forty		=	0;
										$pending_within_thirty		=	0;
										$pending_thirty_forty		=	0;
										$pending_above_forty		=	0;
										/**************** *******************/
										
										// 13 JUly
										$no_pm_data		=	0;
										$good_units		=	0;
										$due_units		=	0;
										$past_due		=	0;
										$neglected		=	0;
										$pmc_assigned	=	0;
										$pmc_assigned_late	=	0;

										
										// 13 JUly
										
										$t1 = array("Frequency", "Sum");
										$t2 = array("PM", "Sum");
										 foreach ($er as $equipment) {
											
											$e_id	=	$equipment['pk_instrument_id'];
											
											$tyzb	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC ");
											$rtzb	= 	$tyzb->result_array();
											$total_pms	=	sizeof($rtzb);
											
											/************** Counting Neglected Due PMs ************************/
											if (!empty($rtzb)){
												$status			=	$rtzb[0]['status'];
												$last_pm_date	=	strtotime($rtzb[0]['date']);
												$current_date	=	time();
												$difference		=	$current_date - $last_pm_date;
												//$interval		= 	$difference->format(%a);
												$interval		=	floor($difference/(60*60*24));
												
												if 	($interval<29 )	{
													$pm_within_thirty	+=	1;
													if ($status	=='Completed') $completed_within_thirty +=1;
													else	$pending_within_thirty	+=1;
												}
												if	($interval>30 && $interval<39)	{
													$pm_thirty_forty	+=	1;
													if ($status	=='Completed') $completed_thirty_forty +=1;
													else	$pending_thirty_forty	+=1;
												}
												if 	($interval>40)	{
													$pm_above_forty		+=	1;
													if ($status	=='Completed') $completed_above_forty +=1;
													else	$pending_above_forty	+=1;
												}
											}
											else {
													$interval	=	"N/A";
													$pm_never	+=	1;
											}
											
											/************** Counting Neglected Due PMs ************************/
											
											
											$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
											$rtz	= 	$tyz->result_array();
											$total_pms_c	=	sizeof($rtz);
											
											
											$tyza	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC LIMIT 1");
											$rtza	= 	$tyza->result_array();
											//$rtza['status']	= 	$tyza->result();
											
											
											if (!empty($rtza)) {
												  if ($rtza[0]['status'] != 'Completed') { // Pending or Pending Verification
													$total_pms_pending+=1;
													/// 13 July
													//$status			=	$rtza[0]['status'];
													$last_pm_date	=	strtotime($rtza[0]['date']);
													$current_date	=	time();
													$difference		=	$current_date - $last_pm_date;
													$interval		=	floor($difference/(60*60*24));
													if	($interval>10)	$pmc_assigned_late	+=	1;	
													else $pmc_assigned	+=	1;
													/// 13 July
													
												  }
												  else { //// Completed
													  $total_pms_completed+=1;	
													/// 13 July
													//$status			=	$rtza[0]['status'];
													$last_pm_date	=	strtotime($rtza[0]['finish_time']);
													$current_date	=	time();
													$difference		=	$current_date - $last_pm_date;
													$interval		=	floor($difference/(60*60*24));
													if	($interval<31)	$good_units	+=	1;
													if	($interval>30 && $interval<41)	$due_units	+=	1;
													if	($interval>40 && $interval<51)	$past_due	+=	1;
													if	($interval>40)	$neglected	+=	1; // first it was 50 but then Yasir sb asked to make it 40
													/// 13 July
												  }													  
											}
											else {
												$total_pms_pending+=1;
												$no_pm_data	+=1;	// 13 July
											}
											
										
											
											if ($total_pms_c > 1 )
											{
																						
											$max_pms_index		=	$total_pms_c - 1;
											$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
											$last_pm			=	strtotime($rtz[0]['finish_time']);
										//$current_date		=	time();
											$diff				=	$last_pm - $first_pm;
										//$interval		= 	$difference->format(%a);
											$total_days			=	floor($diff/(60*60*24));
											$pm_frequency		=	$total_days/$max_pms_index;
											//echo	$pm_frequency . " days";
											}
											elseif ($total_pms_c == 1 )
											{
												$current_date		=	time();
												$last_pm			=	strtotime($rtz[0]['finish_time']);
												$diff				=	$current_date - $last_pm;
												$total_days			=	floor($diff/(60*60*24));
												//$pm_frequency		=	$total_days; // yasir sb said if PM=1 then don't calculate Average
												$pm_frequency		=	0;
												//echo $total_days . " day(s)";	
											}
											else $pm_frequency	=	0;
											$pm_frequency_sum += $pm_frequency;
											$total_pms_sum	+=	$total_pms;
											array_push($t1, $pm_frequency_sum );
											
											////////////////////////////////////////////////////////////////////////////////////
											
											if($n<$total-1)
											{
												$myquery.=$e_id.', ';
											}
											else
											{
												$myquery.=$e_id;
											}
											$n++;
										} 
										$myquery.=') AND `complaint_nature` = "PM" ';
										$myquery1 = $myquery;
										$myquery2 = $myquery;
										$myquery1.='AND status !="Completed" ORDER BY date DESC'; /// query for not completed PMs
										$myquery2.='AND status="Completed" ORDER BY date DESC'; //// query for completed PMs
										$cq	=	$this->db->query($myquery1);
										$cr	=	$cq->result_array();
										
										$cqq	=	$this->db->query($myquery2);
										$crr	=	$cqq->result_array();
										?>
									
                                    <tr class="odd gradeX">
                                        
                                        <th class="bg-blue-steel  bg-grey-border"> <!-- Equipment -->
                                            <?php 
												echo $product['product_name'];
											?>
                                        </th>
										
										<td class="bg-grey-gallery text-center bg-grey-border"> <!-- Total Units -->
                                            <?php 
												//echo $product['product_name'];
												$total_equipments	=	$total_equipments+$total;
												echo $total;
											?>
                                        </td>
										
                                        <td class="bg-grey-steel text-center bg-grey-border"> <!-- No PM Data -->
                                             <?php 
												//echo sizeof($cr);
												$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												//echo $total_pms_pending;
												$no_pm_data_total	=	$no_pm_data_total + $no_pm_data;
												if ($no_pm_data>0) echo $no_pm_data;
												else echo '-';
											?>
                                        </td >
                                        
                                        <td class="bg-green-meadow text-center bg-grey-border"> <!-- Good Units -->
                                            <?php 
												//echo sizeof($crr);
												$total_total_pms_completed	=	$total_total_pms_completed + $total_pms_completed;
												//echo $total_pms_completed;
												if ($good_units>0) echo $good_units;
												else echo '-';
												$good_units_total	=	$good_units_total	+	$good_units;
											?>
                                        </td>
										
										<td class="bg-yellow-zed text-center bg-grey-border"> <!-- PM Due -->
                                             <?php 
												//echo sizeof($cr);
												//$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												//echo $pm_within_thirty
												$total_pm_within_thirty	+=	$pm_within_thirty;
												$total_pending_within_thirty	+=	$pending_within_thirty;
												$total_completed_within_thirty	+=	$completed_within_thirty;
												//echo $pm_within_thirty.'<span class="pull-right"><em><span class="font-red-intense">'.$pending_within_thirty.'</span>,<span class="font-green-meadow">'.$completed_within_thirty.'</span></em></span>';
												if ($due_units>0) echo $due_units;
												else echo '-';
												$due_units_total	=	$due_units_total	+	$due_units;
											?>
                                        </td>
										
				<?php /*						<td class="bg-yellow-gold text-center bg-grey-border"> <!-- PM Past Due -->
                                             <?php 
												//echo sizeof($cr);
												//$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												//echo $pm_thirty_forty;
												$total_pm_thirty_forty	+=	$pm_thirty_forty;
												$total_pending_thirty_forty	+=	$pending_thirty_forty;
												$total_completed_thirty_forty	+=	$completed_thirty_forty;
												//echo $pm_thirty_forty.'<span class="pull-right"><em><span class="font-red-intense">'.$pending_thirty_forty.'</span>,<span class="font-green-meadow">'.$completed_thirty_forty.'</span></em></span>';
												if ($past_due>0) echo $past_due;
												else echo '-';
												$past_due_total	=	$past_due_total	+	$past_due;
											?>
                                        </td>    */ ?>
										
										<td class="bg-red-thunderbird text-center bg-grey-border"> <!-- PM Neglected -->
                                             <?php 
												//echo sizeof($cr);
												//$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												//echo $pm_above_forty;
												$total_pm_above_forty	+=	$pm_above_forty;
												$total_pending_above_forty	+=	$pending_above_forty;
												$total_completed_above_forty	+=	$completed_above_forty;
												//echo $pm_above_forty.'<span class="pull-right"><em><span class="font-red-intense">'.$pending_above_forty.'</span>,<span class="font-green-meadow">'.$completed_above_forty.'</span></em></span>';
												if ($neglected>0) echo $neglected;
												else echo '-';
												$neglected_total	=	$neglected_total	+	$neglected;
											?>
                                        </td>
										
										<td class="bg-grey-steel text-center bg-grey-border"> <!-- PM Assigned-->
                                             <?php 
												//echo sizeof($cr);
												//$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												$total_pm_never	+= $pm_never;
												//echo $pm_never;
												if ($pmc_assigned>0) echo $pmc_assigned;
												else echo '-';
												$pmc_assigned_total	=	$pmc_assigned_total	+	$pmc_assigned;
												
											?>
                                        </td>
										
										<td class="bg-grey-steel text-center bg-grey-border"> <!-- PM Assigned Late-->
                                             <?php 
												//echo sizeof($cr);
												//$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												$total_pm_never	+= $pm_never;
												//echo $pm_never;
												if ($pmc_assigned_late> 0) echo '<span class="font-red">' . $pmc_assigned_late . '</span>';
												else echo '<span class="font-red">-</span>';
												$pmc_assigned_late_total	=	$pmc_assigned_late_total	+	$pmc_assigned_late;
											?>
                                        </td>
                                        
                               
							   
							   <td class="bg-purple text-center bg-grey-border"> <!-- Average PM Frequency -->
                              <?php 
							  
									$total_avg_frq	=	$total_avg_frq + ($pm_frequency_sum/sizeof($er));
									//echo $pm_frequency_sum/sizeof($er);
									$pm_f_s	=	$pm_frequency_sum/sizeof($er);
									if ( $pm_f_s>0)	echo $pm_frequency_sum/sizeof($er);
									else echo '-';
									//echo sizeof($er);
									//print_r($t1);
									//echo $total_pms_sum;
							  ?>
                               </td>
                                        
                                        
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
							<th class="bg-grey-gallery text-center bg-grey-border">
								<?php echo $total_equipments; ?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $no_pm_data_total; ?>
							</th>
							<th class="bg-green-meadow text-center bg-grey-border">
								<?php echo $good_units_total; ?>
							</th>
							<th class="bg-yellow-zed text-center bg-grey-border">
								<?php //echo $total_pm_within_thirty.'<span class="pull-right"><em><span class="font-red-intense">'.$total_pending_within_thirty.'</span>,<span class="font-green-meadow">'.$total_completed_within_thirty .'</span></em></span>';
								echo $due_units_total;
								?>
							</th>
		<?php /*					<th class="bg-yellow-gold text-center bg-grey-border">
								<?php //echo $total_pm_thirty_forty.'<span class="pull-right"><em><span class="font-red-intense">'.$total_pending_thirty_forty.'</span>,<span class="font-green-meadow">'.$total_completed_thirty_forty.'</span></em></span>'; 
								echo $past_due_total;
								?>
							</th> */ ?>
							<th class="bg-red-thunderbird  text-center bg-grey-border">
								<?php //echo $total_pm_above_forty.'<span class="pull-right"><em><span class="font-red-intense">'.$total_pending_above_forty.'</span>,<span class="font-green-meadow">'.$total_completed_above_forty.'</span></em></span>'; 
								echo $neglected_total;
								?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $pmc_assigned_total; ?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border"> <span class="font-red">
								<?php echo $pmc_assigned_late_total; ?>
								</span>
							</th>
							<th class="bg-purple text-center bg-grey-border" >
								<?php echo $total_avg_frq; ?>
							</th>
						</tr>
					</tfoot>
                  </table>
                            </div>
                </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET--> 
			  <?php } ?>
		<?php
		$uq	=	$this->db->query("select `fk_office_id` from user where `id` ='".$this->session->userdata('userid')."'");
		$ur =	$uq->result_array();
			foreach ($or as $office) {
		?>
			  <!-- BEGIN EXAMPLE TABLE PORTLET-->
			  <?php  if ( ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') || $ur[0]['fk_office_id']==$office['pk_office_id'] ) { ?>
              <?php
				  $total_equipments				=	0;
				  $total_total_pms				=	0;
				  $total_total_pms_pending 		=	0;
				  $total_total_pms_completed	=	0;
				  $total_avg_frq				=	0;
				  
				  // 13 July
				  
					$no_pm_data_total		=	0;
					$good_units_total		=	0;
					$due_units_total		=	0;
					$past_due_total			=	0;
					$neglected_total		=	0;
					$pmc_assigned_total		=	0;
					$pmc_assigned_late_total	=	0;	
				  
				  // 13 July
				  
					$total_pm_within_thirty		=	0;
					$total_pm_thirty_forty		=	0;
					$total_pm_above_forty		=	0;
					$total_pm_never				=	0;
					$total_completed_within_thirty		=	0;
					$total_completed_thirty_forty		=	0;
					$total_completed_above_forty		=	0;
					$total_pending_within_thirty		=	0;
					$total_pending_thirty_forty		=	0;
					$total_pending_above_forty		=	0;
			  
			  ?>
			  
			  <div class="portlet box grey-gallery">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-plane"></i>PM Statistics <?php echo $office['office_name']; ?> - Real Time</div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
                <div class="portlet-body">
                  
                  <div class="portlet-body flip-scroll">
                   <table class="table table-striped table-bordered table-hover flip-content " id="sample_2">
                    <thead>
                      <tr>
                        <th class="bg-blue-steel text-center bg-grey-border"> Equipment 			</th>
						<th class="bg-grey-gallery text-center bg-grey-border"> Total<br />Units 			</th>
                        <th class="bg-grey-steel text-center bg-grey-border">  No PM<br />Data			</th>
                        <th class="bg-green-meadow text-center bg-grey-border">  Good Units<br />Last PM < 30<br />Days		</th>
						<th class="bg-yellow-zed text-center bg-grey-border"> PM Due<br />Last PM > 30<br />Days 			</th>
					<!--	<th class="bg-yellow-gold text-center bg-grey-border"> PM Past Due<br />Last PM > 40<br />Days 			</th> -->
						<th class="bg-red-thunderbird text-center bg-grey-border"> PM Neglected<br />Last PM > 40<br />Days	</th>
						<th class="bg-grey-steel text-center bg-grey-border"> PMC Assigned		</th>
						<th class="bg-grey-steel text-center bg-grey-border"> <span class="font-red"> PMC Assigned<br />Late		</span></th>
                        <th class="bg-purple text-center bg-grey-border"> Average Time<br />Between PM </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
							
                             
                                foreach ($pr as $product) {
                                    ?>
									<?php
										$eq	=	$this->db->query("select * from tbl_instruments where `fk_product_id`=".$product['pk_product_id'] ." AND `status`=1 AND `fk_office_id`='".$office['pk_office_id']."'");
										$er =	$eq->result_array();
										?>
										<?php if (sizeof($er)>0) {?>
										<?php
										$total = sizeof($er);	
										$myquery="select * from tbl_complaints where fk_instrument_id IN(";
										$n=0;
										$pm_frequency_sum	=	0;
										$total_pms_sum	=	0;
										$total_pms_completed	=	0;
										$total_pms_pending	=	0;
										
										/**************** *******************/
										$pm_within_thirty	=	0;
										$pm_thirty_forty	=	0;
										$pm_above_forty		=	0;
										$pm_never			=	0;
										$completed_within_thirty	=	0;
										$completed_thirty_forty		=	0;
										$completed_above_forty		=	0;
										$pending_within_thirty		=	0;
										$pending_thirty_forty		=	0;
										$pending_above_forty		=	0;
										/**************** *******************/
										
										// 13 JUly
										$no_pm_data		=	0;
										$good_units		=	0;
										$due_units		=	0;
										$past_due		=	0;
										$neglected		=	0;
										$pmc_assigned	=	0;
										$pmc_assigned_late	=	0;
										// 13 JUly
										
										$t1 = array("Frequency", "Sum");
										$t2 = array("PM", "Sum");
										 foreach ($er as $equipment) {
											
											$e_id	=	$equipment['pk_instrument_id'];
											
											$tyzb	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC ");
											$rtzb	= 	$tyzb->result_array();
											$total_pms	=	sizeof($rtzb);
											
											$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
											$rtz	= 	$tyz->result_array();
											$total_pms_c	=	sizeof($rtz);
											//$total_pms	=	sizeof($rtz);
											
											$tyza	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC LIMIT 1");
											$rtza	= 	$tyza->result_array();
											//$rtza['status']	= 	$tyza->result();
											
											
											if (!empty($rtza)) {
												  if ($rtza[0]['status'] != 'Completed') { // Pending or Pending Verification
													$total_pms_pending+=1;
													/// 13 July
													//$status			=	$rtza[0]['status'];
													$last_pm_date	=	strtotime($rtza[0]['date']);
													$current_date	=	time();
													$difference		=	$current_date - $last_pm_date;
													$interval		=	floor($difference/(60*60*24));
													if	($interval>10)	$pmc_assigned_late	+=	1;	
													else $pmc_assigned	+=	1;
													/// 13 July
													
												  }
												  else { //// Completed
													  $total_pms_completed+=1;	
													/// 13 July
													//$status			=	$rtza[0]['status'];
													$last_pm_date	=	strtotime($rtza[0]['finish_time']);
													$current_date	=	time();
													$difference		=	$current_date - $last_pm_date;
													$interval		=	floor($difference/(60*60*24));
													if	($interval<31)	$good_units	+=	1;
													if	($interval>30 && $interval<41)	$due_units	+=	1;
													if	($interval>40 && $interval<51)	$past_due	+=	1;
													if	($interval>40)	$neglected	+=	1; // first it was 50 but then Yasir sb asked to make it 40
													/// 13 July
												  }													  
											}
											else {
												$total_pms_pending+=1;
												$no_pm_data	+=1;	// 13 July
											}
											
											
											
											if ($total_pms_c > 1 )
											{
																						
											$max_pms_index		=	$total_pms_c - 1;
											/* Above was previously total_pms but on 19th October i changed it to total_pms_c because errors were being shown of undefined index.
											As total_pms would give the count of non completed ones as well meaning no finish time.
											*/
											
											$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
											$last_pm			=	strtotime($rtz[0]['finish_time']);
										//$current_date		=	time();
											$diff				=	$last_pm - $first_pm;
										//$interval		= 	$difference->format(%a);
											$total_days			=	floor($diff/(60*60*24));
											$pm_frequency		=	$total_days/$max_pms_index;
											//echo	$pm_frequency . " days";
											}
											elseif ($total_pms_c == 1 )
											{
												$current_date		=	time();
												$last_pm			=	strtotime($rtz[0]['finish_time']);
												$diff				=	$current_date - $last_pm;
												$total_days			=	floor($diff/(60*60*24));
												//$pm_frequency		=	$total_days;
												$pm_frequency		=	0;
												//echo $total_days . " day(s)";	
											}
											else $pm_frequency	=	0;
											$pm_frequency_sum += $pm_frequency;
											$total_pms_sum	+=	$total_pms;
											array_push($t1, $pm_frequency_sum );
											
											////////////////////////////////////////////////////////////////////////////////////
											
											if($n<$total-1)
											{
												$myquery.=$e_id.', ';
											}
											else
											{
												$myquery.=$e_id;
											}
											$n++;
										} 
										$myquery.=') AND `complaint_nature` = "PM" ';
										$myquery1 = $myquery;
										$myquery2 = $myquery;
										$myquery1.='AND status="Pending"'; /// query for pending PMs
										$myquery2.='AND status!="Pending"'; //// query for non pending PMs
										$cq	=	$this->db->query($myquery1);
										$cr	=	$cq->result_array();
										
										$cqq	=	$this->db->query($myquery2);
										$crr	=	$cqq->result_array();
										?>
									
                                    <tr class="odd gradeX ">
                                        
                                        <th class="bg-blue-steel  bg-grey-border"> <!-- Equipment -->
                                            <?php 
												echo $product['product_name'];
											?>
                                        </th>
										
										<td class="bg-grey-gallery text-center bg-grey-border"> <!-- Total Units -->
                                            <?php 
												//echo $product['product_name'];
												$total_equipments	=	$total_equipments+$total;
												echo $total;
											?>
                                        </td>
										
                                        <td class="bg-grey-steel text-center bg-grey-border"> <!-- No PM Data -->
                                             <?php 
												//echo sizeof($cr);
												$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												//echo $total_pms_pending;
												$no_pm_data_total	=	$no_pm_data_total + $no_pm_data;
												if ($no_pm_data>0) echo $no_pm_data;
												else echo '-';
											?>
                                        </td >
                                        
                                        <td class="bg-green-meadow text-center bg-grey-border"> <!-- Good Units -->
                                            <?php 
												//echo sizeof($crr);
												$total_total_pms_completed	=	$total_total_pms_completed + $total_pms_completed;
												//echo $total_pms_completed;
												if ($good_units>0) echo $good_units;
												else echo '-';
												$good_units_total	=	$good_units_total	+	$good_units;
											?>
                                        </td>
										
										<td class="bg-yellow-zed text-center bg-grey-border"> <!-- PM Due -->
                                             <?php 
												//echo sizeof($cr);
												//$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												//echo $pm_within_thirty
												$total_pm_within_thirty	+=	$pm_within_thirty;
												$total_pending_within_thirty	+=	$pending_within_thirty;
												$total_completed_within_thirty	+=	$completed_within_thirty;
												//echo $pm_within_thirty.'<span class="pull-right"><em><span class="font-red-intense">'.$pending_within_thirty.'</span>,<span class="font-green-meadow">'.$completed_within_thirty.'</span></em></span>';
												if ($due_units>0) echo $due_units;
												else echo '-';
												$due_units_total	=	$due_units_total	+	$due_units;
											?>
                                        </td>
										
										<td class="bg-red-thunderbird text-center bg-grey-border"> <!-- PM Neglected -->
                                             <?php 
												//echo sizeof($cr);
												//$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												//echo $pm_above_forty;
												$total_pm_above_forty	+=	$pm_above_forty;
												$total_pending_above_forty	+=	$pending_above_forty;
												$total_completed_above_forty	+=	$completed_above_forty;
												//echo $pm_above_forty.'<span class="pull-right"><em><span class="font-red-intense">'.$pending_above_forty.'</span>,<span class="font-green-meadow">'.$completed_above_forty.'</span></em></span>';
												if ($neglected>0) echo $neglected;
												else echo '-';
												$neglected_total	=	$neglected_total	+	$neglected;
											?>
                                        </td>
										
										<td class="bg-grey-steel text-center bg-grey-border"> <!-- PM Assigned-->
                                             <?php 
												//echo sizeof($cr);
												//$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												$total_pm_never	+= $pm_never;
												//echo $pm_never;
												if ($pmc_assigned>0) echo $pmc_assigned;
												else echo '-';
												$pmc_assigned_total	=	$pmc_assigned_total	+	$pmc_assigned;
												
											?>
                                        </td>
										
										<td class="bg-grey-steel text-center bg-grey-border"> <!-- PM Assigned Late-->
                                             <?php 
												//echo sizeof($cr);
												//$total_total_pms_pending	=	$total_total_pms_pending + $total_pms_pending;
												$total_pm_never	+= $pm_never;
												//echo $pm_never;
												if ($pmc_assigned_late> 0) echo '<span class="font-red">' . $pmc_assigned_late . '</span>';
												else echo '<span class="font-red">-</span>';
												$pmc_assigned_late_total	=	$pmc_assigned_late_total	+	$pmc_assigned_late;
											?>
                                        </td>
                                        
                               
							   
							   <td class="bg-purple text-center bg-grey-border"> <!-- Average PM Frequency -->
                              <?php 
							  
									$total_avg_frq	=	$total_avg_frq + ($pm_frequency_sum/sizeof($er));
									//echo $pm_frequency_sum/sizeof($er);
									$pm_f_s	=	$pm_frequency_sum/sizeof($er);
									if ( $pm_f_s>0)	echo $pm_frequency_sum/sizeof($er);
									else echo '-';
									//echo sizeof($er);
									//print_r($t1);
									//echo $total_pms_sum;
							  ?>
                               </td>
                                        
                                        
                                    </tr>
                                    <?php
										}
                                }
                    ?>
                      
                    </tbody>
					<tfoot class="bg-grey-silver">
						<tr>
							<th class="bg-blue-steel bg-grey-border" >
								Total
							</th>
							<th class="bg-grey-gallery text-center bg-grey-border">
								<?php echo $total_equipments; ?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $no_pm_data_total; ?>
							</th>
							<th class="bg-green-meadow text-center bg-grey-border">
								<?php echo $good_units_total; ?>
							</th>
							<th class="bg-yellow-zed text-center bg-grey-border">
								<?php //echo $total_pm_within_thirty.'<span class="pull-right"><em><span class="font-red-intense">'.$total_pending_within_thirty.'</span>,<span class="font-green-meadow">'.$total_completed_within_thirty .'</span></em></span>';
								echo $due_units_total;
								?>
							</th>
		<?php /*					<th class="bg-yellow-gold text-center bg-grey-border">
								<?php //echo $total_pm_thirty_forty.'<span class="pull-right"><em><span class="font-red-intense">'.$total_pending_thirty_forty.'</span>,<span class="font-green-meadow">'.$total_completed_thirty_forty.'</span></em></span>'; 
								echo $past_due_total;
								?>
							</th> */ ?>
							<th class="bg-red-thunderbird  text-center bg-grey-border">
								<?php //echo $total_pm_above_forty.'<span class="pull-right"><em><span class="font-red-intense">'.$total_pending_above_forty.'</span>,<span class="font-green-meadow">'.$total_completed_above_forty.'</span></em></span>'; 
								echo $neglected_total;
								?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border">
								<?php echo $pmc_assigned_total; ?>
							</th>
							<th class="bg-grey-steel text-center bg-grey-border"> <span class="font-red">
								<?php echo $pmc_assigned_late_total; ?>
								</span>
							</th>
							<th class="bg-purple text-center bg-grey-border" >
								<?php echo $total_avg_frq; ?>
							</th>
						</tr>
					</tfoot>
                  </table>
                            </div>
                </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET--> 
				<?php  } ?>
		<?php
			}
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

</script>

<style>
.bg-grey-border
{
	border-bottom:1px solid #dddddd !important;
	border-right:1px solid #dddddd !important;
}

</style>