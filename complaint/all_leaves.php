<?php $this->load->view('header.php');?>
<?php /*
<script src="<?php echo base_url();?>assets/global/plugins/colResizable-1.5.min.js" type="text/javascript"></script>

/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
					VERY IMPORTANT
					
					In order to enable the column resize function, remove the filters,
					extra row in head and correct the class name in datatable creation
					function at the bottom. Right now its been changed to id. Need to
					make it a class
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

*/ ?>

<?php
$maxqu = $this->db->query("SELECT * FROM user WHERE id='".$this->session->userdata('userid')."'");
$maxval=$maxqu->result_array();
$sap_supervisor = $maxval[0]['sap_supervisor'];
if ($sap_supervisor=="1" && $this->session->userdata('territory') =="1") //For Peshawar Office
	$sap_supervisor = "2";
?>
<script src="<?php echo base_url();?>assets/global/plugins/colResizable-1.5.min.js" type="text/javascript"></script>


          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Leaves <small>A summary of all Leave forms Submitted</small> </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li> <i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> </li>
              <li> Leaves </li>
            </ul>
            
          </div>
          <!-- END PAGE HEADER--> 
          <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet box grey-gallery">
                <div class="portlet-title">
                  <div class="caption"> <i class="icon-plane"></i>Leaves Data </div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      
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
							
                        ?>
                    <div class="row">
                      <div class="col-md-12">
                        
                         <div class="btn-group">
						 <?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') { ?>
                          <a href="<?php echo base_url();?>complaint/leave_form" id="sample_editable_1_new" class="btn blue"> 
                              Add New Leave &nbsp;<i class="fa fa-plus"></i>
                          </a>
						  <?php } ?>
                        </div> <?php if ($this->session->userdata('userrole')=='Admin')
						{
							?>
						<div class="btn-group pull-right">
                          <a href="javascript:void" onclick="show_confirm()" id="sample_editable_1_new" class="btn red-thunderbird"> 
                              Reset All Employee Leaves &nbsp;<i class="fa fa-exclamation-triangle"></i>
                          </a>
                        </div>
						<?php } ?>
                      </div>
                      
                    </div>
                  </div>
                  <script>
				  function show_confirm()
				  {
					  var yesno = confirm('Do you want to reset all leaves to zero? You won\'t be able to reverse your action.');
					  if(yesno == true)
					  {
						  window.location='<?php echo base_url();?>complaint/resset_all_employees_leaves';
					  }
				  }
				  
				  </script>
                  <div class="portlet-body flip-scroll">
                   <table width="100%" class="table table-striped table-bordered table-hover flip-content dataaTable " id="">
                    <thead class="bg-grey-cascade">
					<tr>
                        <th >  		        </th>
                        <th >   		</th>
                        <th >  			</th>
                        <th >  		</th>
                        <th >   		</th>
                        <th >  		</th>
                        <th > 	</th>
						<th >  	</th>
                        <th > 			</th>
                        <?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') { ?>
						<th >   			</th>
						<?php } ?>
                      </tr>
                      <tr>
                        <th > City 		        </th>
                        <th > Employee Name 		</th>
                        <th > Leave Code 			</th>
                        <th > Explanation Call Status 		</th>
                        <th > Start Date 		</th>
						 
                        <th > Leave Days 		</th>
                        <th > Reason of Leave	</th>
						<th > Official Comments	</th>
                        <th > Back Up			</th>
                        <?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') { ?>
						<th > Actions  			</th>
						<?php } ?>
                      </tr>
                    </thead>
                    <tbody>
					<?php
							$myquery=" UPDATE tbl_leaves SET `viewed`='1' WHERE `viewed`='0' AND fk_employee_id =  '".$this->session->userdata('userid')."'";
							$ty22=$this->db->query($myquery);
					?>
                      <?php
                            $myquery="select * from tbl_leaves";
							if($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin' )
							{
								$myquery.="";
							}
							elseif ($sap_supervisor=="1")
							{
								$myquery.="  WHERE fk_employee_id IN (SELECT id FROM user WHERE delete_status=0 AND userrole='Salesman' AND fk_office_id='".$this->session->userdata('territory')."')";
							}
							elseif ($sap_supervisor=="2")
							{
								$myquery.="  WHERE fk_employee_id IN (SELECT id FROM user WHERE delete_status=0 AND userrole='Salesman' AND fk_office_id IN ('1','5'))";
							}
							else
							{
								$myquery.="  where fk_employee_id =  '".$this->session->userdata('userid')."'";
							}
							$myquery.=" order by pk_leave_id DESC";
							$ty22=$this->db->query($myquery);
                            $rt22=$ty22->result_array();
                            if (sizeof($rt22) == "0") {
                                
                            } else {
                                foreach ($rt22 as $get_users_list) {
                                    ?>
                                    <tr class="odd gradeX">

                                        <td style="padding:10px !important;"> <!-- City user to tbl_cities city_name-->
                                            <?php
                                            $ty44=$this->db->query("select tbl_offices.office_name,COALESCE(user.first_name) AS first_name,COALESCE(tbl_fine_code.description) AS code_description,COALESCE(tbl_cities.city_name) AS city_name, COALESCE(tbl_fine.status) AS fine_status
											from tbl_leaves 
											LEFT JOIN user ON user.id = tbl_leaves.fk_employee_id
											LEFT JOIN tbl_cities ON user.fk_city_id = tbl_cities.pk_city_id
											LEFT JOIN tbl_offices ON user.fk_office_id = tbl_offices.pk_office_id
											LEFT JOIN tbl_fine_code ON tbl_leaves.fk_fine_code = tbl_fine_code.pk_fine_code_id
											LEFT JOIN tbl_fine ON tbl_leaves.fk_fine_id = tbl_fine.pk_fine_id
											where pk_leave_id =  '".$get_users_list["pk_leave_id"]."' ");
											$rt44=$ty44->result_array();
                                            echo $rt44[0]["city_name"];
                                            ?>
                                        </td>
                                        <td style="padding:10px !important;">  <!-- Employee user first_name -->
                                            <?php 
                                          //  $ty44=$this->db->query("select * from user where id =  '".$get_users_list["fk_employee_id"]."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
										//	$rt44=$ty44->result_array();
											echo $rt44[0]["first_name"];
											?>
                                        </td>
                                        <td style="padding:10px !important;">  <!-- Leave Code tbl_fine_code description -->
                                             <?php 
											 if($get_users_list["fk_fine_code"]!='Leave is taken within limit of 21 days')
											 {
											//	$ty44=$this->db->query("select * from tbl_fine_code where pk_fine_code_id =  '".$get_users_list["fk_fine_code"]."'");
											//	$rt44=$ty44->result_array();
												echo substr($rt44[0]["code_description"], 0, 80);
											 }
											 else
											 {
												 echo 'Leave is taken within limit of 21 days';
											 }
											?>
                                        </td>
                                        
                                        <td style="padding:10px !important;">  <!-- Amount/Fine Status tbl_fine status -->
                                            <?php //echo $get_users_list["amount"];
											if($get_users_list["fk_fine_id"]!=0)
											 {
												//$ty44=$this->db->query("select * from tbl_fine where pk_fine_id =  '".$get_users_list["fk_fine_id"]."'");
												//$rt44=$ty44->result_array();
												if (sizeof($rt44)>0)
													echo $rt44[0]["fine_status"];
											 }
											 else
											 {
												 echo 'N/A';
											 }
											
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
                                            <?php echo urldecode(urldecode($get_users_list["reason_of_leave"]));?>
                                        </td>
										<td style="padding:10px !important;">  <!-- Official Comments -->
                                            <?php echo urldecode($get_users_list["official_comments"]);?>
                                        </td>
                                        <td style="padding:10px !important;">  <!-- Back Up -->
                                            <?php echo $get_users_list["back_up"];?>
                                        </td>
										<?php if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery') { ?>
                                        <td style="padding:10px !important;">  <!-- Actions -->
										
											<a class="btn btn-sm default blue"
                                               href="<?php echo base_url();?>complaint/update_leave_form/<?php echo $get_users_list["pk_leave_id"];?>">
                                                Edit &nbsp;<i class="fa fa-edit"></i>
                                            </a>
											
                                            <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')"
                                               href="<?php echo base_url();?>complaint/delete_leave/<?php echo $get_users_list["pk_leave_id"];?>">
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
			$('#dataaTable').colResizable({liveDrag:true,fixed:false,minWidth:65}); //http://www.bacubacu.com/colresizable/ ////////////////// In order to enable it correct the class name
    }
	}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
						]

		});
});
</script>
