<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    DVR Overview <small>All Employees</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                DVR Overview All
                            </li>                        
                        </ul>
                      <div class="page-toolbar">
                        
                      </div>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
					<!-- Color Key -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-green-seagreen"></i>
								<span class="caption-subject bold font-green-seagreen uppercase">
								Color KEY </span>
								<span class="caption-helper">Explains the meaning of Each Color used in Table Below</span>
							</div>
						</div>
						<div class="portlet-body">
								<div class="row">
									<div class="col-md-6">
									  <table class=" table table-striped table-bordered table-hover flip-content">
									  <thead>
										<tr>
											<th>Color</th>
											<th>Explanation</th>
										</tr>
									  </thead>
									  <tbody>
										
										<tr>
											<td class="redbackgrounclass"></td>
											<td>Sunday</td>
										</tr>
										<tr>
											<td class="weekbackgrounclass"></td>
											<td>Week Day</td>
										</tr>
										
										<tr>
											<td class="outstationbackgroundclass"></td>
											<td>Outstation, VS Entered</td>
										</tr>
										<tr>
											<td class="novsoutstationbackgroundclass"></td>
											<td>Outstation, VS not Entered</td>
										</tr>
									  </tbody>
									  </table>
                                     </div>
										<div class="col-md-6">
									  <table class=" table table-striped table-bordered table-hover flip-content">
									  <thead>
										<tr>
											<th>Color</th>
											<th>Explanation</th>
										</tr>
									  </thead>
									  <tbody>
										<tr>
											<td class="blackbackgroundclass"></td>
											<td>Only DVR</td>
										</tr>
										<tr>
											<td class="vsbackgroundclass"></td>
											<td>Only VS</td>
										</tr>
										<tr>
											<td class="zclass"></td>
											<td>Neither VS nor DVR Entered</td>
										</tr>
										<tr>
											<td class="dvrvsbackgroundclass"></td>
											<td>Both DVR and VS entered</td>
										</tr>
									  </tbody>
									  </table>
                                     </div> 
								</div>
							
						</div>
					</div>
		<!-- Color Key -->
								
                    <div class="row">
                     <div class="col-md-12">
                      <!-- BEGIN EXAMPLE TABLE PORTLET-->
                      <form method="post" action="<?php echo base_url();?>complaint/insert_dvr">
                      <div class="portlet box green-seagreen">
              
                          <div class="portlet-title">
              
                            <div class="caption"> <i class="icon-layers"></i>Daily Visit Reports Overview</div>
              
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
              
                          </div>
              
                          <div class="portlet-body">
                               <div class="table-toolbar">
                            	 <?php
									$visits=0;
									$mas_hour_result=0;
									$offices_mas_hour_result=0;
									if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												ACS Updated Successfully.  
											  </div>';
									  }
								  ?>
                            	</div>
                                <div class="portlet-body">
                                         
                                      <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
								   
                                      <table class="table table-striped table-bordered table-hover flip-content dataaTable" >
              
                                          <thead>
                          
                                            <tr>
                                              <th style="padding-right:70px;" class="bg-grey-cascade"><strong> Employee&nbsp;Name </strong></th>
                                              <?php $i=0;
											  while( $i<=30)
                                              { 
												 
												  if($i==0)
												  { 
												    $myndate=date('d-M-Y');
													//date to put in th class
													$myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i);
													$week_day = date('D');
												  }
												 else 
												  {
													$myndate=date('d-M-Y', time() - 60 * 60 * 24 * $i);
													$week_day = date('D', time() - 60 * 60 * 24 * $i);
													//date to put in th class
													$myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i);
												  }
													$timeexploded=explode('-',$myndate);
													echo '<td';
													echo ' class="';
													echo $myndateclass.'Parent';
													if($week_day=="Sun")
													{
														echo " redbackgrounclass blue";
													}
													else echo " weekbackgrounclass";
													echo '" >'.$timeexploded[0].' '.$timeexploded[1].' '.$timeexploded[2];?>
                                                  </td>
                                                  <?php
                                              $i++;
											   }?>
                                              
                                             
                                           
                          
                                            </tr>
                          
                                          </thead>
              
                                          <tbody>
                                          <?php 
										  $no_of_total_records=0;
										  
                                              
										  $size_of_total_rows=0;
										  $visited_client_array= array();
										  $dbres = $this->db->query("SELECT * FROM user where userrole IN('Salesman','FSE','Supervisor') AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
										  $dbresResult=$dbres->result_array();
										  if (sizeof($dbresResult) == "0") 
                                          {
                                                                    
                                          } 
                                          else 
                                          {
											  foreach ($dbresResult as $eng_name) 
                                              {
											  /////////////////////////// zaaid
											  $dbres3 = $this->db->query("SELECT * FROM tbl_dvr where fk_engineer_id = '".$eng_name['id']."'");
										  	  $eng_dvr=$dbres3->result_array();
											  if (sizeof($eng_dvr) != "0" && in_array($eng_dvr[0]['fk_customer_id'], $visited_client_array)) 
                                          	  {
													continue;
											  } 
													$myclient 		= 	$eng_name['first_name'];
                                                  ?>
                                                 <tr class="odd gradeX" >
                                                        <td class="bg-grey-border"  >
														<?php 
                                                            echo $myclient;
                                                        ?> 
                                                        </td>  
                                                        <?php 
														$i=0;
														while( $i<=30 )
                                                        { 
															if($i==0)
															{ 
															$myndate=date('Y-m-d');
															$week_day = date('D');
															} 
															else 
															{
																$myndate=date('Y-m-d', time() - 60 * 60 * 24 * $i);
																$week_day = date('D', time() - 60 * 60 * 24 * $i);
															}
															// above row is generating dates for last 30 days
															//if( $myndate==$eng_dvr[0]['date'])															
															////// ///////////// Zaaid Edited these
															/*
															if( $myndate==date('Y-m-d',strtotime($eng_dvr[0]['date'])))
															{ 
																echo '<td style="background:#000; color:#fff; text-align:center;">1</td>';
																array_push($visited_client_array, $eng_dvr[0]['fk_customer_id']);
															}
															else
															{
																 echo '<td></td>';
															}
															*/
															////////////////// Zaaid Edited this
															$zaaid=0;
															$vs=0;
															/////////////// COUNT DVR //////////////////
															 $dbres2 = $this->db->query("SELECT * FROM tbl_dvr where fk_engineer_id = '".$eng_name['id']."'");
										  					 $dbresResult2=$dbres2->result_array();
															foreach ($dbresResult2 as $eng_dvrr) {
																if( $myndate==date('Y-m-d',strtotime($eng_dvrr['date'])) )
																{ 
																	if ($eng_dvrr['outstation']=='1') $zaaid = -1000; //// For Outstation Scenario
																	//echo '1';
																	$zaaid=$zaaid+1;
																	//array_push($visited_client_array, $eng_dvr[0]['fk_customer_id']);
																}
																else
																{
																	 $zaaid=$zaaid+0;
																	 //echo '0';
																}															
															}
															///////////////////// COUNT DVR //////////////////
															/////////////// COUNT VS //////////////////
															 $dbres4 = $this->db->query("SELECT * FROM tbl_vs where fk_engineer_id = '".$eng_name['id']."'");
										  					 $dbresResult4=$dbres4->result_array();
															foreach ($dbresResult4 as $eng_dvrr) {
																if( $myndate==date('Y-m-d',strtotime($eng_dvrr['date'])) )
																{ 
																	//echo '1';
																	$vs=$vs+1;
																	//array_push($visited_client_array, $eng_dvr[0]['fk_customer_id']);
																}
																else
																{
																	 $vs=$vs+0;
																	 //echo '0';
																}															
															}
															///////////////////// COUNT VS //////////////////
															if( $zaaid>0 && $vs==0) // DVR Exists But VS Doesn't
															{ 
																echo '<td class="blackbackgroundclass ';
																 echo $myndate;
																 echo'"><strong>B</strong></td>';
															}
															elseif( $zaaid==0 && $vs>0) // VS Exists But DVR Doesn't
															{ 
																echo '<td class="vsbackgroundclass ';
																 echo $myndate;
																 echo'"><strong>C</strong></td>';
															}
															elseif( $zaaid>0 && $vs>0) // Both Exist
															{ 
																echo '<td class="dvrvsbackgroundclass ';
																 echo $myndate;
																 echo'"><strong>D</strong></td>';
															}
															elseif($zaaid==0 && $vs==0) //NO DVR NO VS
															{
																 echo '<td class="zclass ';
																//
																if($week_day=="Sun")
																{
																	echo "sundayclass";
																}
																echo '"><strong>A</strong></td>';
															}
															elseif ($zaaid<0 && $vs==0)
															{ 
																echo '<td class="novsoutstationbackgroundclass ';
																 echo $myndate;
																 echo'"><strong>E</strong></td>';
															}
															else
															{
																echo '<td class="outstationbackgroundclass ';
																 echo $myndate;
																 echo'"><strong>F</strong></td>';
															}
																
															// there was error on below line, so i commented it
															//array_push($visited_client_array, $eng_dvr[0]['fk_customer_id']);
														$i++;
                                                        }
														?>  
                                                 </tr>
                                        <?php
													$no_of_total_records++; 
													}
                                                  
                                                  }?>
                                          </tbody>
                                     </table>
                                     
									 <input type="hidden" name="no_of_total_records" value="<?php echo $no_of_total_records;?>" id="no_of_total_records" />
                                 
                             		 
                              </div>
                            </div>
              			 </div>
                        
                      </form>
                      
                      <!--Enter data of visit schedual here-->
                      
                    </div><!--end of row-->
                   </div><!--end of col-md-12-->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
		<style>
		.weekbackgrounclass
        {
            background-color:#2c3e50 !important;
			color: #FFF;
        }
        .redbackgrounclass
        {
            background-color:#cb5a5e !important;
			color: #FFF;
        }
        .redbackgrounclass.greenbackgrounclass
        {
            background-color:#cb5a5e !important;
        }
        .greenbackgrounclass
        {
            background-color:#26c281 !important;
			color: #FFF;
        }
		.blackbackgroundclass
		{
			background:#4b77be !important; 
			color:#4b77be; 
			text-align:center;
		}
		.vsbackgroundclass
		{
			background:#c49f47 !important; 
			color:#c49f47; 
			text-align:center;
		}
		.dvrvsbackgroundclass
		{
			background:#26c281 !important; 
			color:#26c281; 
			text-align:center;
		}
		.outstationbackgroundclass
		{
			background:#9a12b3 !important; 
			color:#9a12b3; 
			text-align:center;
		}
		.novsoutstationbackgroundclass
		{
			background:#bf55ec !important; 
			color:#bf55ec; 
			text-align:center;
		}
		.zclass
		{
			background:#fafafa !important; 
			color:#fff; 
			text-align:center;
		}
		.bg-grey-border
		{
			background:#eeeeee !important; 
			border-bottom:1px solid #dddddd !important;
			border-right:1px solid #dddddd !important;
		}
        </style>
		
<?php $this->load->view('footer');?>

<script>
$(document).ready(function() { 
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 100
	});
	
	//new $.fn.dataTable.FixedColumns( table );
});
</script>