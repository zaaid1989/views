<?php $this->load->view('header.php');?>
<?php /*
<script src="<?php echo base_url();?>assets/global/plugins/colResizable-1.5.min.js" type="text/javascript"></script>
*/ ?>
<script src="<?php echo base_url();?>assets/global/plugins/colResizable-1.5.min.js" type="text/javascript"></script>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Pending Leaves </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
              <li>Pending Leaves </li>
            </ul>
			<ul class="page-breadcrumb pull-right">
			  <li title="Help"> <i class="icon-question"></i> </li>
            </ul>
           <!-- <span class="pull-right" title="Help"><i class="icon-question"></i></span> -->
          </div>
          <!-- END PAGE HEADER--> 
          <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet box grey-gallery">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-plane"></i>Pending Leaves Data </div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      <a href="javascript:;" class="fullscreen"> </a>
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
                <div class="portlet-body">
                  <div class="table-toolbar">
                      <?php
                          if(isset($_GET['msg']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Leave Added Successfully.  
                                    </div>';
                            }
						if(isset($_GET['msg_set_total']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Total Leaves SET to 0 Successfully.  
                                    </div>';
                            }
                        if(isset($_GET['msg_delete']))
                        {
                            echo '<div class="alert alert-success alert-dismissable">
									<a class="close" data-dismiss="alert">×</a>
									Leave Deleted Successfully.
								  </div>';
                        }
						
						if(isset($_GET['msg_update']))
                        {
                            echo '<div class="alert alert-success alert-dismissable">
									<a class="close" data-dismiss="alert">×</a>
									Leave Updated Successfully.
								  </div>';
                        }
						
						if(isset($_GET['msg_disapproved']))
                        {
                            echo '<div class="alert alert-success alert-dismissable">
									<a class="close" data-dismiss="alert">×</a>
									Leave disapproved successfully.
								  </div>';
                        }
							
                        ?>
                    <div class="row">
                      
                    </div>
                  </div>
                  <script>
				  function show_confirm()
				  {
					  var yesno = confirm('Do you want to reset all leaves to zero? You won\'t be able to reverse your reaction.');
					  if(yesno == true)
					  {
						  window.location='<?php echo base_url();?>sys/resset_all_employees_leaves';
					  }
				  }
				  
				  </script>
                  <div class="portlet-body flip-scroll">
                   <table width="100%" class="table table-striped table-bordered table-hover flip-content dataaTable " id="">
                    <thead>
                      <tr>
                        <th class="bg-grey"> City 		        </th>
                        <th class="bg-grey"> Employee Name 		</th>
                        <th class="bg-grey"> Start Date 		</th>
                        <th class="bg-grey"> Leave Days 		</th>
                        <th class="bg-grey"> Reason of Leave	</th>
                        <th class="bg-grey"> Back Up			</th>
						<th class="bg-grey"> Balance Leaves			</th>
						<th class="bg-grey"> Leave Code			</th>
                        <?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') { ?>
						<th class="bg-grey"> Actions  			</th>
						<?php } ?>
                      </tr>
                    </thead>
                    <tbody>
					<?php
							$myquery=" UPDATE tbl_temporary_leaves SET `viewed`='1' WHERE `status`='1' AND fk_employee_id =  '".$this->session->userdata('userid')."'";
							$ty22=$this->db->query($myquery);
					?>
                      <?php
                            $myquery="select tbl_temporary_leaves.*, user.first_name,tbl_cities.city_name,user.total_leaves,user.date_of_joining
							from tbl_temporary_leaves 
							LEFT JOIN user ON tbl_temporary_leaves.fk_employee_id = user.id
							LEFT JOIN tbl_cities ON user.fk_city_id = tbl_cities.pk_city_id
							WHERE tbl_temporary_leaves.`status`='0' ";
							if($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin' )
							{
								$myquery.="";
							}
							else
							{
								$myquery.="  AND fk_employee_id =  '".$this->session->userdata('userid')."'";
							}
							$myquery.=" order by pk_temporary_leave_id DESC";
							$ty22=$this->db->query($myquery);
                            $rt22=$ty22->result_array();
                            if (sizeof($rt22) == "0") {
                                
                            } else {
                                foreach ($rt22 as $get_users_list) {
                                    ?>
                                    <tr class="odd gradeX">

                                        <td style="padding:10px !important;"> <!-- City -->
                                            <?php
                                            
                                            echo $get_users_list["city_name"];
                                            ?>
                                        </td>
                                        <td style="padding:10px !important;">  <!-- Employee -->
                                            <?php 
                                            
											echo $get_users_list["first_name"];
											?>
                                        </td>
                                        
                                        <td style="padding:10px !important;">  <!-- Start Date -->
                                            <?php echo date('d-M-Y', strtotime($get_users_list["start_date"]));?>
                                        </td>
                                        <td style="padding:10px !important;">  <!-- Days -->
                                            <?php
                                                if($get_users_list["leave_type"]=='1')
												{
													echo 'Half Day';
												}
												else
												{
													$datediff  		 = strtotime($get_users_list["end_date"]) - strtotime($get_users_list["start_date"]);
													$mydiffrence 		 = floor($datediff/(60*60*24)) + 1;
													///////////////// New Code /////////////////
													
													$sd = strtotime($get_users_list["start_date"]);//strtotime('2012-08-06');
													$ed = strtotime($get_users_list["end_date"]);//strtotime('2012-09-06');

													$count = 0;

													while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
													  $count += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
													  $sd = strtotime("+1 day", $sd);
													}
													
													///////////////// New Code /////////////////
													$mydiffrence	=	$count;
													if ($mydiffrence>1)
													echo $mydiffrence.' days';
													else echo $mydiffrence.' day';
												}
                                            ?>
                                        </td>
                                       <td style="padding:10px !important;">  <!-- Official Comments -->
                                            <?php echo urldecode($get_users_list["reason_of_leave"]);?>
                                        </td>
										
                                        <td style="padding:10px !important;">  <!-- Back Up -->
                                            <?php echo $get_users_list["back_up"];?>
                                        </td>
										
										<td style="padding:10px !important;">  <!-- Balance Leaves -->
                                            <?php 
												$total_leaves = $get_users_list["total_leaves"];
			////////////////////////////// Calculating available Leaves
											
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
											 
											 $remaining_leaves = $available_leaves - $total_leaves; ////// Important value
											 echo $remaining_leaves;
											?>
                                        </td>
										
										<td style="padding:10px !important;">  <!-- Leave Code -->
                                            <?php echo $get_users_list["leave_code"];?>
                                        </td>
										
										<?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') { ?>
                                        <td style="padding:10px !important;">  <!-- Actions -->
										
											<a class="btn btn-sm default blue"
                                               href="<?php echo base_url();?>sys/leave_form/<?php echo $get_users_list["pk_temporary_leave_id"];?>">
                                                Open &nbsp;<i class="fa fa-edit"></i>
                                            </a>
                                            
                                            <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')"
                                               href="<?php echo base_url();?>sys/delete_temporary_leave/<?php echo $get_users_list["pk_temporary_leave_id"];?>">
                                                Delete &nbsp;<i class="fa fa-trash-o"></i>
                                            </a>
											
											<a class="btn btn-sm default yellow-zed" onClick="return confirm('Are you sure you want to disapprove?')"
                                               href="<?php echo base_url();?>sys/disapprove_leave/<?php echo $get_users_list["pk_temporary_leave_id"];?>">
                                                Disapprove &nbsp;<i class="fa fa-thumbs-o-down"></i>
                                            </a>
                                            <?php

                                                //////////////////////////////////////////////////////

                                                /*
                                                $current_month	=	date('m');
                                                $current_year	=	date('Y');
                                                $delete_allowed = '0';
                                                $leave_date = strtotime($get_users_list['start_date']);

                                                if($current_month < 7)
                                                {

                                                $last_year = $current_year - 1;
                                                $start_date = strtotime($last_year.'-07-01');
                                                $end_date = strtotime($current_year.'-06-30');
                                                if($leave_date >= $start_date && $leave_date <= $end_date)
                                                    $delete_allowed = '1';

                                                } else {

                                                $next_year = $current_year + 1;
                                                $start_date = strtotime($current_year.'-07-01');
                                                $end_date = strtotime($next_year.'-06-30');
                                                if($leave_date >= $start_date && $leave_date <= $end_date)
                                                    $delete_allowed = '1';

                                                }
                                                echo $delete_allowed;

                                                */
                                                //////////////////////////////////////////////////////
                                            ?>
                                        </td>
										<?php } ?>
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
<script>
$(document).ready(function() { 
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 100,
	  'aaSorting': [],
	 // "order": [[ 4, "desc" ]],
		'customProp': 'Hello World',
		'initComplete': function(settings) { 
			$('.dataaTable').colResizable({liveDrag:true,fixed:false,minWidth:65}); //http://www.bacubacu.com/colresizable/
    }
	});
});
</script>
