<?php $this->load->view('header.php');?>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Leaves Summary<small> Overview of Yearly Employee Leaves</small> </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
              <li> Leaves Summary </li>
            </ul>
            
          </div>
          <!-- END PAGE HEADER--> 
          <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet box blue">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-eyeglasses"></i>Leaves Summary </div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
                <div class="portlet-body">
                  <div class="table-toolbar">
                    <div class="row">
                      <form method="get" action="<?php echo base_url();?>complaint/leaves_summary">
                                <div class="col-md-4">
                            		<div class="form-group">
                            			
                                        <select name="year" id="year" class="form-control" required>
                                            <option value="">--Select Year--</option>
                                            
											<?php 
											//$start_year = 2015;
											$current_year = date('Y');
                                            for($year=2015;$year<$current_year; $year++)
                                            {
                                                ?>
                                                <option value="<?php echo $year;?>" 
												<?php if(isset($_GET['year']) && $_GET['year']==$year){ echo 'selected="selected"';}?>>
													<?php echo $year;?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>
								
                                <div class="col-md-2">
                            		<div class="form-group">
                                        
                                            <input type="submit"  class="btn btn-default blue-madison" value="Search" >
                                    </div>
                                </div>
                          		</form>
                      
                    </div>
                  </div>
                  <div class="portlet-body flip-scroll">
				  <?php if(isset($_GET['year'])) { ?>
                   <table class="table table-bordered table-hover flip-content bg-grey" id="sample_2">
                    <thead>
                      <tr>
                        <th class="bg-grey-gallery"> Employee Name 		</th>
						<th class="bg-grey-gallery"> Join Date 		</th>
						<th class="bg-grey-gallery"> Work Months 		</th>
						<th class="bg-grey-gallery"> Leaves Available 		</th>
                        <th class="bg-grey-gallery"> Total Leaves Taken			</th>
						<th class="bg-grey-gallery"> Leaves Balance 			</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                            $myquery="select user.*,tbl_leaves_sum.total_leaves AS 'leaves_sum' from user
							LEFT JOIN tbl_leaves_sum ON user.id = tbl_leaves_sum.fk_user_id
							WHERE `delete_status`='0' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
							
							if(isset($_GET['year'])) {
								 $myquery="	select user.*,tbl_leaves_sum.total_leaves AS 'leaves_sum' from user
											LEFT JOIN tbl_leaves_sum ON user.id = tbl_leaves_sum.fk_user_id
											WHERE `delete_status`='0' AND `year`='".$_GET['year']."' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
							}
							$ty22=$this->db->query($myquery);
                            $rt22=$ty22->result_array();
                                foreach ($rt22 as $get_users_list) {
									
									$start_month	=	7; // July
											 $available_leaves	=	21;
											 $leaves_per_month	=	$available_leaves/12;
											 $working_months_current_year	=	12; ////////////total months  for which leaves will be given
											 $current_month	=	date('m');
											 $current_year	=	date('Y');
											 $previous_year	=	date('Y')-1;
											 $join_date		= 	$get_users_list["date_of_joining"];
											 $join_month	=	date('m',strtotime($join_date));
											 $join_year		=	date('Y',strtotime($join_date));
											 
											 
											 if(isset($_GET['year'])) {
												$previous_year	=	$_GET['year'];
												$current_month	=	6;
												$current_year	=	$previous_year+1;
											 
											 }
											 
											 
											 if ($current_month>$start_month && $join_month>$start_month && $join_year == $current_year ){
												 $working_months_current_year	= 12 + $start_month - $join_month;
											 }
											 elseif ($current_month<$start_month && $join_month>$start_month && $join_year == $previous_year){
												 $working_months_current_year	= 12 + $start_month - $join_month;
											 }
											 elseif ($current_month<$start_month && $join_month<$start_month && $join_year == $current_year) {
												 $working_months_current_year	= $start_month - $join_month;
											 }
											 else $working_months_current_year = 12;
											 $available_leaves	=	$working_months_current_year * $leaves_per_month;
                                    ?>
                                    <tr class="odd gradeX">
                                        
                                        <td>
                                            <?php 
											echo $get_users_list["first_name"];
											?>
                                        </td>
										<td>
                                            <?php 
											echo date('d-M-Y',strtotime($get_users_list["date_of_joining"]));
											?>
                                        </td>
										<td>
                                            <?php 
											echo $working_months_current_year;
											?>
                                        </td>
										<td style="text-align:center;">
                                             <?php
											echo $available_leaves;
											 ?>                                           
                                        </td>
                                        <td style="text-align:center;">
                                             <?php 
												if($get_users_list["leaves_sum"] > $available_leaves)
												{
													?>
														<div class="pulsate-regular" style="margin:0 30px;"><?php  echo $get_users_list["leaves_sum"];?></div>
													<?php
												}
												else
												{
													echo $get_users_list["leaves_sum"];
												}
											 ?>
                                             
                                        </td>
										<td style="text-align:center;">
                                             <?php
											if($get_users_list["leaves_sum"] > $available_leaves)
												{
													?>
														<div class="pulsate-regular" style="margin:0 30px;"><?php  echo $available_leaves - $get_users_list["leaves_sum"];?></div>
													<?php
												}
												else
												{
													echo $available_leaves - $get_users_list["leaves_sum"];
												}
											 ?>                                           
                                        </td>
                                    </tr>
                                    <?php
                                }
                    ?>
                      
                    </tbody>
                  </table>
				  <?php } ?>
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
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer.php');?>