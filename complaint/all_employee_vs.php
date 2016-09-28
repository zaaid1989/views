<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    VS Overview <small>All Employees</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                VS Overview All
                            </li>                          
                        </ul>
                      <div class="page-toolbar">
                        
                      </div>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                     <div class="col-md-12">
                      <!-- BEGIN EXAMPLE TABLE PORTLET-->
                      <form method="post" action="<?php echo base_url();?>complaint/insert_dvr">
                      <div class="portlet box green-seagreen">
              
                          <div class="portlet-title">
              
                            <div class="caption"> <i class="fa fa-files-o"></i>Visit Schedule Overview</div>
              
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
              
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
                                <div class="portlet-body flip-scroll table-responsive">
                                         
                                      <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
                                          
                                      <table class="table table-striped table-bordered table-hover flip-content sample_z" id="sample_4" >
              
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
										  $dbres = $this->db->query("SELECT * FROM user where userrole IN('Salesman','FSE','Supervisor') ORDER BY  `fk_office_id` ,  `userrole` ASC ");
										  $dbresResult=$dbres->result_array();
										  if (sizeof($dbresResult) == "0") 
                                          {
                                                                    
                                          } 
                                          else 
                                          {
											  foreach ($dbresResult as $eng_name) 
                                              {
											  /////////////////////////// zaaid
											  $dbres3 = $this->db->query("SELECT * FROM tbl_vs where fk_engineer_id = '".$eng_name['id']."'");
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
															 $dbres2 = $this->db->query("SELECT * FROM tbl_vs where fk_engineer_id = '".$eng_name['id']."'");
										  					 $dbresResult2=$dbres2->result_array();
															foreach ($dbresResult2 as $eng_dvrr) {
															if( $myndate==date('Y-m-d',strtotime($eng_dvrr['date'])) )
															{ 
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
															if( $zaaid>0)
															{ 
																echo '<td class="blackbackgroundclass ';
																 echo $myndate;
																 echo'"><strong>B</strong></td>';
															}
															else
															{
																 echo '<td class="zclass ';
																//
																if($week_day=="Sun")
																{
																	echo "sundayclass";
																}
																echo '"><strong>A</strong></td>';
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
			background:#3598dc !important; 
			color:#3598dc; 
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

