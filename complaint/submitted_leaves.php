<?php $this->load->view('header.php');?>
<?php /*
<script src="<?php echo base_url();?>assets/global/plugins/colResizable-1.5.min.js" type="text/javascript"></script>
*/ ?>
<script src="<?php echo base_url();?>assets/global/plugins/colResizable-1.5.min.js" type="text/javascript"></script>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Submitted Leaves </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li> <i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> </li>
              <li>Submitted Leaves </li>
            </ul>
            
          </div>
          <!-- END PAGE HEADER--> 
          <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
		<?php for ($k=0;$k<2;$k++)  {?>
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet box <?php if ($k==0) echo "red"; else echo "yellow-zed";  ?>">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-plane"></i>Submitted Leaves Data (<?php if ($k==0) echo "Pending"; else echo "Disapproved";  ?>) </div>
                </div>
                <div class="portlet-body">
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
                        <?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') { ?>
						<th class="bg-grey"> Actions  			</th>
						<?php } ?>
                      </tr>
                    </thead>
                    <tbody>
					<?php
							$myquery=" UPDATE tbl_temporary_leaves SET `viewed`='1' WHERE `viewed`='0' AND `status`='1' AND fk_employee_id =  '".$this->session->userdata('userid')."'";
							$ty22=$this->db->query($myquery);
					?>
                      <?php
                            $myquery="
							select tbl_temporary_leaves.*,
							COALESCE(user.first_name) AS first_name, 
							COALESCE(tbl_cities.city_name) AS city_name							
							
							from tbl_temporary_leaves 
							
							LEFT JOIN user ON tbl_temporary_leaves.fk_employee_id = user.id
							LEFT JOIN tbl_cities ON user.fk_city_id = tbl_cities.pk_city_id
							
							WHERE tbl_temporary_leaves.`status`='".$k."' ";
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
										<?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') { ?>
                                        <td style="padding:10px !important;">  <!-- Actions -->
										
											<a class="btn btn-sm default blue"
                                               href="<?php echo base_url();?>complaint/leave_form/<?php echo $get_users_list["pk_temporary_leave_id"];?>">
                                                Open &nbsp;<i class="fa fa-edit"></i>
                                            </a>
                                            
                                            <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')"
                                               href="<?php echo base_url();?>complaint/delete_temporary_leave/<?php echo $get_users_list["pk_temporary_leave_id"];?>">
                                                Delete &nbsp;<i class="fa fa-trash-o"></i>
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
		<?php } ?>
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
