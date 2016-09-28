<?php $this->load->view('header');?>

<?php

$engineer_id = 0;
if (isset($_GET['engineer'])) {
$engineer_id = $_GET['engineer'];
$maxqu = $this->db->query("SELECT * FROM user WHERE id='".$_GET['engineer']."'");
$maxval=$maxqu->result_array();
if ($this->session->userdata('territory')!='1' && $this->session->userdata('territory')!='5') { // when not rawalpindi
	if ($maxval[0]['fk_office_id']!=$this->session->userdata('territory') || $maxval[0]['userrole']!='Salesman') show_404();
}
else {// if rawalpindi or peshawar
	if (($maxval[0]['fk_office_id']!='1' && $maxval[0]['fk_office_id']!='5' )|| $maxval[0]['userrole']!='Salesman') show_404();
}
}
else $engineer_id = $this->session->userdata('userid');
$maxqu = $this->db->query("SELECT * FROM user WHERE id='".$this->session->userdata('userid')."'");
$maxval=$maxqu->result_array();
$sap_supervisor = $maxval[0]['sap_supervisor'];
if ($sap_supervisor !='1' && $engineer_id!=$this->session->userdata('userid')) show_404();

$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status = '0' AND userrole='Salesman' AND fk_office_id='".$this->session->userdata('territory')."'");
if ($this->session->userdata('territory')=='1')
	$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status = '0' AND userrole='Salesman' AND fk_office_id IN ('1','5')");
$maxval=$maxqu->result_array();


?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    DVR <small>Individual History</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                DVR History Individual
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
       <!-- BEGIN PAGE CONTENT-->
       <div class="row">

        <div class="col-md-12"> 
		
		<!-- Search Form -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-blue-madison"></i>
								<span class="caption-subject bold font-blue-madison uppercase">
								Individual DVR </span>
								<span class="caption-helper">Search DVR and VS of Individuals</span>
							</div>
						</div>
						<div class="portlet-body">
						<?php
								if(isset($_GET['msg']))
								{ 
								  echo '<div class="alert alert-success alert-dismissable">  
										  <a class="close" data-dismiss="alert">×</a>  
										  DVR Updated Successfully.  
										</div>';
								}
								if(isset($_GET['delete_msg']))
								{ 
								  echo '<div class="alert alert-success alert-dismissable">  
										  <a class="close" data-dismiss="alert">×</a>  
										  DVR Deleted Successfully.  
										</div>';
								}
								if(isset($_GET['msgvs']))
								{ 
								  echo '<div class="alert alert-success alert-dismissable">  
										  <a class="close" data-dismiss="alert">×</a>  
										  VS Updated Successfully.  
										</div>';
								}
								if(isset($_GET['delete_msgvs']))
								{ 
								  echo '<div class="alert alert-success alert-dismissable">  
										  <a class="close" data-dismiss="alert">×</a>  
										  VS Deleted Successfully.  
										</div>';
								}
							  ?>
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>complaint/sap_dvr_history_new">
								<?php if ($sap_supervisor=='1') { ?>
                                <div class="col-md-4">
                            		<div class="form-group">
                            			
                                        <select name="engineer" id="engineer" class="form-control" required>
                                            <option value="">--Select employee--</option>
											<?php 
											
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['id'];?>" <?php if(isset($_GET['engineer']) && $_GET['engineer']==$val['id']){ echo 'selected="selected"';}?>>
													<?php echo $val['first_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>
								<?php } else echo '<input type="hidden" name="engineer" value="'.$this->session->userdata("userid").'">'?>
								
								
                          		<div class="col-md-3">
                            		<div class="form-group">
                            			
                                        <input type="text" name="start_mydate" class="form-control datepicker" id="start_mydate" value="<?php if(isset($_GET['start_mydate'])){ echo $_GET['start_mydate']; } else { echo date('d-M-Y');}?>" required  />
										<span class="help-block">Start Date</span>
									</div>
                                </div>
                                <div class="col-md-3">
                            		<div class="form-group">
                            			
                                        <input type="text" name="end_mydate" class="form-control datepicker" id="end_mydate" value="<?php if(isset($_GET['end_mydate'])){ echo $_GET['end_mydate']; } else { echo date('d-M-Y');}?>" required />
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
							
						</div>
					</div>
		<!-- Search Form -->
		<?php for ($k=1; $k<=2; $k++) { ?>
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box <?php if ($k==1) echo "yellow-gold"; else echo "blue-madison"; ?>">

            <div class="portlet-title">

              <div class="caption"> <i class="icon-pie-chart"></i><?php if ($k==1) echo "DVR Results"; else echo "VS Results"; ?> </div>

              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
               
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
              <div class="table-toolbar">
              </div>
              		<div class="portlet-body ">
                            
				
                <table class="table table-striped  table-hover flip-content dataaTable" id="">

                <thead>

                  <tr>
                    <th class="bg-grey-gallery"> Date</th>
                    <th class="bg-grey-gallery"> StartTime </th>
                    <th class="bg-grey-gallery"> EndTime </th>
                    <th class="bg-grey-gallery"> Area </th>
					<th class="bg-grey-gallery"> Employee</th>
                    <th class="bg-grey-gallery"> Customer</th>
                    
                    <th class="bg-grey-gallery"> Business Project </th>

                    <th class="bg-grey-gallery"> Project Description </th>
                    
                    <th class="bg-grey-gallery"> WD / DS</th>
      <!--              <th class="bg-grey-gallery"> Actions </th> -->
                    
                   
                 

                  </tr>

                </thead>

                <tbody class="engineer_dvrs">
               		<?php
					$start_mydate_2	=	date("Y-m-d");
					$end_mydate_2	=	date("Y-m-d");
					$engineer		=	'*';
					if(isset($_GET['engineer']) && isset($_GET['start_mydate']) && isset($_GET['end_mydate'])) {
						
						$start_mydate_2	=	date("Y-m-d", strtotime($_GET['start_mydate']) );
						$end_mydate_2	=	date("Y-m-d", strtotime($_GET['end_mydate']) );
						$engineer		=	$_GET['engineer'];
						if ($k==1) {
							$id				=	"pk_dvr_id";
							$table			=	"tbl_dvr";
						}
						else {
							$id				=	"pk_vs_id";
							$table			=	"tbl_vs";
						}
						$dbres 			= 	$this->db->query("SELECT * FROM $table where  date between '".$start_mydate_2."' AND '".$end_mydate_2."' AND fk_engineer_id = '".$engineer."' ORDER BY $id ASC");
						$get_sup_dvr	=	$dbres->result_array();
					}
					if (isset($get_sup_dvr) && sizeof($get_sup_dvr) == "0") 
					  {
						//echo "<tr class='odd grade'><td colspan='10' align='center'>No Results Found.</td></tr>";
					  }
					   elseif(isset($get_sup_dvr) && sizeof($get_sup_dvr) != "0") 
					  {
							foreach($get_sup_dvr as $sup_dvr)
							{
								 echo '<tr class="odd gradeX">
															<td>';
								echo date('d-M-Y', strtotime($sup_dvr['date']));
								echo '</td>  ';	
								echo '						<td>';
								echo date('h:i A', strtotime($sup_dvr['start_time']));
								echo '</td>
															
															<td>';
								echo date('h:i A', strtotime($sup_dvr['end_time']));
								
								echo '</td>
														   
															<td>';
								//for are and customer calculation
								if(substr($sup_dvr['fk_customer_id'],0,1)=='o')
									{
										$office_id		=	substr($sup_dvr['fk_customer_id'],13,1);
										$qu2			=	"SELECT * from tbl_offices where pk_office_id =  '".$office_id."'";
										$gh2			=	$this->db->query($qu2);
										$rt2			=	$gh2->result_array();
										$myclient 		= 	$rt2[0]['office_name'];
										$business		=   '';
										//for area
										$area			= $myclient;
									}
									else
									{
										 $maxqu = $this->db->query("SELECT * FROM tbl_clients where pk_client_id='".$sup_dvr['fk_customer_id']."' ");
										 $maxval=$maxqu->result_array();
										 $myclient = $maxval[0]['client_name'];
										 //for area
										$maxqu_area 	= $this->db->query("SELECT * FROM tbl_area where pk_area_id='".$maxval[0]['fk_area_id']."' ");
										$maxval_area	=$maxqu_area->result_array();
										$area			= $maxval_area[0]['area'];
										 //for business project
										 if($sup_dvr['fk_business_id']=='0')
										 {
											 if($sup_dvr['fk_complaint_id']=='0')
											 {
												 $business		=   'Others';
											 }
											 else
											 {
												 $ts_number 		= $this->db->query("SELECT * FROM tbl_complaints where pk_complaint_id='".$sup_dvr['fk_complaint_id']."' ");
												 $qu_ts_number		= $ts_number->result_array();
												 $business			= $qu_ts_number[0]['ts_number'];
											 }
										 }
										 else
										 {
										 $maxqu3 = $this->db->query("SELECT * FROM business_data where pk_businessproject_id='".$sup_dvr['fk_business_id']."' ");
										 $maxval3=$maxqu3->result_array();
										 $maxqu4 = $this->db->query("SELECT * FROM tbl_business_types where pk_businesstype_id='".$maxval3[0]['Business Project']."' ");
										 $maxval4=$maxqu4->result_array();
										 $business = $maxval4[0]['businesstype_name'];
										 }
									}
								//
																
								echo $area;
								echo '</td>
															
															<td>';
								$maxqu_eng = $this->db->query("SELECT * FROM user where id='".$sup_dvr['fk_engineer_id']."' ");
								$maxval_eng=$maxqu_eng->result_array();
								echo $maxval_eng[0]['first_name'];
								echo'</td>
															<td>';
																 
								 
								echo $myclient;
								echo '</td> ';  
								echo '<td>';
																 
								 
								
								echo $business;
								echo '</td>';
								echo '<td> <textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
								//
								if($sup_dvr['fk_business_id']!='0'){
								$maxqu3 = $this->db->query("SELECT * FROM business_data where pk_businessproject_id='".$sup_dvr['fk_business_id']."' ");
								$maxval3=$maxqu3->result_array();
								echo $maxval3[0]['Project Description'];
								}
								else
								{
									if($sup_dvr['fk_complaint_id']=='0')
									{
										echo $sup_dvr['priority'];
									}
									else
									{
										echo $qu_ts_number[0]['problem_summary'];
									}
									
								}
								echo '</textarea> </td>';
								
								echo '<td> <textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
								echo urldecode($sup_dvr['summery']);
								echo '</textarea> </td>';
								if ($k==1) 	$record_id 	= 	$sup_dvr['pk_dvr_id'];
								else		$record_id	=	$sup_dvr['pk_vs_id'];
								/*
								if ($k==1)
									echo '<td>
															<a class="btn btn default yellow-gold" href="'. base_url() .'complaint/update_dvr_project/'.$record_id.'?engineer='.$engineer.'&start_mydate='.$_GET['start_mydate'].'&end_mydate='.$_GET['end_mydate'].'">
																Edit
																<i class="fa fa-edit"></i>
															</a>
															
															<a class="btn btn default red-thunderbird" onClick="return confirm(\'Are you sure you want to delete?\')"  href="'. base_url() .'complaint/delete_dvr/'.$record_id.'?engineer='.$engineer.'&start_mydate='.$_GET['start_mydate'].'&end_mydate='.$_GET['end_mydate'].'"  >
																Delete
																<i class="fa fa-trash-o"></i>
															</a>
														  </td>';
								else
									echo '<td>
															<a class="btn btn default yellow-gold" href="'. base_url() .'complaint/update_vs_project/'.$record_id.'?engineer='.$engineer.'&start_mydate='.$_GET['start_mydate'].'&end_mydate='.$_GET['end_mydate'].'">
																Edit
																<i class="fa fa-edit"></i>
															</a>
															
															<a class="btn btn default red-thunderbird" onClick="return confirm(\'Are you sure you want to delete?\')" href="'. base_url() .'complaint/delete_vs/'.$record_id.'?engineer='.$engineer.'&start_mydate='.$_GET['start_mydate'].'&end_mydate='.$_GET['end_mydate'].'">
																Delete
																<i class="fa fa-trash-o"></i>
															</a>
														  </td>'; */
									
							   echo '</tr>';
							}
					  }
					?>

                </tbody>

              </table>

             </div>
            </div>

          </div>
		
          
        <?php } ?>  <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>

<script>
$(document).ready(function() { 
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 100
	});
	
	//new $.fn.dataTable.FixedColumns( table );
});
</script>