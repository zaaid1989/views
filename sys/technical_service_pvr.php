<?php $this->load->view('header');?>
<?php
$query="SELECT `assign_to`,fk_office_id from tbl_complaints where `pk_complaint_id` ='".$this->uri->segment(3)."' AND `complaint_nature`='complaint'";
$query_db=$this->db->query($query);
$user_complaints=$query_db->result_array();			
$c =  array_intersect(explode(',',$user_complaints[0]['fk_office_id']), explode(',',$this->session->userdata('territory')));
if ($this->session->userdata('userrole')=="Supervisor" && sizeof($c)==0) show_404();
if ($this->session->userdata('userrole')=="FSE" && $user_complaints[0]['assign_to']!=$this->session->userdata('userid')) show_404();
if ($this->session->userdata('userrole')=="Salesman") show_404();

$assigned_to = FALSE;
if ($user_complaints[0]['assign_to']==$this->session->userdata('userid')) $assigned_to = TRUE;
?>
      <h3 class="page-title"> Technical Service Personal Visit Report <small></small> </h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                Home
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Complaints
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                TS Report
            </li>
        </ul>
      </div>
      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->
      <div class="row">
        <div class="col-md-12">
            <?php
			$complaint_id	=	$this->uri->segment(3);
				  $nsql="SELECT tbl_complaints.*,
				  COALESCE(tbl_cities.city_name) AS city_name,
				  COALESCE(tbl_clients.client_name) AS client_name,
				  COALESCE(tbl_area.area) AS area,
				  COALESCE(user.first_name) AS first_name,
				  COALESCE(tbl_instruments.serial_no) AS serial_no,
				  COALESCE(tbl_instruments.warranty_months) AS warranty_months,
				  COALESCE(tbl_instruments.warranty_start_date) AS warranty_start_date,
				  COALESCE(tbl_products.product_name) AS product_name 
				  
				  FROM tbl_complaints 
				  LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
				  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
				  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
				  LEFT JOIN user ON tbl_complaints.assign_to = user.id
				  LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
				  LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
				  
				  WHERE pk_complaint_id ='".$this->uri->segment(3)."'";
				  $n2sql=$this->db->query($nsql);
				  $get_compalaint_result=$n2sql->result_array();
				  
				  // For making the status of comments as read
				  $assign_to	=	$get_compalaint_result[0]['assign_to'];
				  $office_id	=	$get_compalaint_result[0]['fk_office_id'];
				  
				  $employee_territory	=	$this->session->userdata('territory');
				  $employee_id			=	$this->session->userdata('userid');
				  $employee_role		=	$this->session->userdata('userrole');
				  
				  if ($employee_role	==	"FSE" || $employee_role	==	"Salesman" ){
					$query="UPDATE tbl_comments SET `read_employee`='1' where `fk_complaint_id` ='".$complaint_id."'";
					$query_db=$this->db->query($query);
				
					}
					elseif ($employee_role	==	"Supervisor"){
							$query="UPDATE tbl_comments SET `read_supervisor`='1' where `fk_complaint_id` ='".$complaint_id."'";
							$query_db=$this->db->query($query);
							
							if ($assign_to == $employee_id) {
								$query="UPDATE tbl_comments SET `read_employee`='1' where `fk_complaint_id` ='".$complaint_id."'";
								$query_db=$this->db->query($query);
							}
					}
					elseif ($employee_role	==	"Admin"){
						$query="UPDATE tbl_comments SET `read_director`='1' where `fk_complaint_id` ='".$complaint_id."'";
						$query_db=$this->db->query($query);
					}
					elseif ($employee_role	==	"secratery"){
						$query="UPDATE tbl_comments SET `read_secratery`='1' where `fk_complaint_id` ='".$complaint_id."'";
						$query_db=$this->db->query($query);
					}
			?>
          
          <!-- BEGIN Complaint Summary TABLE PORTLET-->
          <div class="portlet box purple">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Complaint Information</div>
              <div class="tools">
                   <a href="javascript:;" class="collapse"> </a> 
                   <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
			
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">
                            <thead><tr><th>Attribute</th><th>Value</th></tr></thead>
                            <tbody>
                               <tr><td>TS Number</td><td> <?php echo $get_compalaint_result[0]['ts_number']; ?></td></tr>
							   <tr><td>Customer</td><td> <?php echo $get_compalaint_result[0]['client_name']; ?></td></tr>
							   <tr><td>City</td><td> <?php echo $get_compalaint_result[0]['city_name']; ?></td></tr>
                               <tr><td>Equipment</td><td> <?php echo $get_compalaint_result[0]['product_name']; ?></td></tr>
                               <tr><td>Serial No</td><td> <?php echo $get_compalaint_result[0]['serial_no']; ?></td></tr>
                               <tr><td>Warranty End Date</td><td>
									 	<?php if($get_compalaint_result[0]['warranty_months'] != "") {
											  if ($get_compalaint_result[0]["warranty_months"]<0) echo "Not Defined";
											  if ($get_compalaint_result[0]["warranty_months"]==0) echo "No Warranty";
											  if ($get_compalaint_result[0]["warranty_months"]>0) {
												  $months_to_add = "+".$get_compalaint_result[0]["warranty_months"]." months";
												  echo date('d-M-Y', strtotime($months_to_add, strtotime($get_compalaint_result[0]["warranty_start_date"])));
												} 
											}  ?>
                                     </td>
                               </tr>
                               <tr><td>Software Version</td><td> <?php echo $get_compalaint_result[0]['instrument_software_version']; ?></td></tr>
                            </tbody>
                       </table>
                </div>
               </div>
               
                <div class="col-md-4">
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">
                            <thead><tr><th>Attribute</th><th>Value</th></tr></thead>
                            <tbody>
								<tr><td>Caller Name</td><td> <?php echo $get_compalaint_result[0]['caller_name']; ?></td></tr>
								<tr><td>Caller Contact Number</td><td> <?php if ($get_compalaint_result[0]['phone']!="") echo $get_compalaint_result[0]['phone']; else echo $get_compalaint_result[0]['landline']; ?></td></tr>
							   <tr><td>FSE Name</td><td> <?php echo $get_compalaint_result[0]['first_name']; ?></td></tr>
							   <tr><td>Kit Name</td><td> <?php echo $get_compalaint_result[0]['kit_name']; ?></td></tr>
                               <tr><td>Kit Lot</td><td> <?php echo $get_compalaint_result[0]['kit_lot_no']; ?></td></tr>
							   <tr><td>Kit Pack Size</td><td> <?php echo $get_compalaint_result[0]['make_pack']; ?></td></tr>
                               <tr><td>Kit Expiry Date</td><td> <?php //echo $get_compalaint_result[0]['kit_name']; ?></td></tr>
                             </tbody>
                       </table>
                </div>
               </div>
               
                <div class="col-md-4">
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">
							<thead><tr><th>Attribute</th><th>Value</th></tr></thead>                         
							<tbody>
								<tr><td>Call Received Date</td><td> <?php echo date('d-M-Y', strtotime($get_compalaint_result[0]['date'])); ?></td></tr>
								<tr><td>Call Received Time</td><td> <?php echo date('H:i', strtotime($get_compalaint_result[0]['date'])); ?></td></tr>
								<tr><td>Reporting Date</td><td> <?php if($get_compalaint_result[0]['reporting_date']!='0000-00-00 00:00:00') echo date('d-M-Y',strtotime($get_compalaint_result[0]['reporting_date']));?></td></tr>
								<tr><td>Reporting Time</td><td> <?php echo $get_compalaint_result[0]['reporting_time']; ?></td></tr>
								<tr><td>Solution Date</td><td> <?php if($get_compalaint_result[0]['solution_date']!='0000-00-00 00:00:00') echo date('d-M-Y',strtotime($get_compalaint_result[0]['solution_date']));?></td></tr>
								<tr><td>Solution Time</td><td> <?php echo $get_compalaint_result[0]['solution_time']; ?></td></tr>
								<tr><td>Status</td><td> <?php $this->load->model("complaint_model");
															  $obj=new Complaint_model();
															  $obj->current_status($get_compalaint_result[0]['status']);
														?></td></tr>
                            </tbody>
                       </table>
                </div>
               </div>
			   
			   
			   <div class="col-md-12">
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">
							<tbody>
							<tr>
								<th class="col-md-2">Problem Summary</th>
								<td><?php  echo $get_compalaint_result[0]['problem_summary']; ?></td>
							</tr>
							</tbody>
                       </table>
                </div>
               </div>
			   
			   
              </div>
          </div>
        </div>
        
<!-- Begin Messages Portlet -->
<?php
	$query="select tbl_comments.*,user.first_name,user.image,user.id 
	from tbl_comments 
	LEFT JOIN user ON tbl_comments.fk_employee_id = user.id
	WHERE `fk_complaint_id` ='".$complaint_id."' ORDER BY `pk_comment_id` DESC";
	$query_db=$this->db->query($query);
	$user_comments=$query_db->result_array();
	$comments_number=sizeof($user_comments);
	$comments_height="240px";
	if ($comments_number==2) $comments_height="240px";
	if ($comments_number>2) $comments_height="240px";
?>

					<!-- BEGIN PORTLET-->
					<div class="portlet light bordered" id="messages">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-bubble font-red-sunglo"></i>
								<span class="caption-subject font-red-sunglo ">Messages</span>
							</div>
							
						</div>
						<div class="portlet-body" id="chats">
						<form action="<?php echo site_url('sys/add_comment_2'); // My Controller?>" method="post" class="form-horizontal form-bordered">
							<div class="chat-form">
								<div class="input-cont">
									<input class="form-control" type="text" name="comment" placeholder="Type a message here...">
									<input type="hidden" name="fk_complaint_id" value="<?php echo $this->uri->segment(3); //complaint id?>" />
									<input type="hidden" name="page_name" value="<?php echo $this->uri->segment(2); //Page Name?>" />
								</div>
								<div class="btn-cont">
									<span class="arrow">
									</span>
									<button type="submit" class="btn blue icn-only"><i class="fa fa-check icon-white"></i></button>
								</div>
							</div>
							</form>
							
							<div class="scroller" style="height: <?php echo $comments_height; ?>;" data-always-visible="1" data-rail-visible1="1">
							<?php  
									$old_date = '2015-04-01 00:00:00';
									$old_date = date('Y-m-d');
									$dvrs = array(1,2);
								
									foreach($user_comments as $comment){
									$previous_dvrs = rtrim(implode(',', $dvrs), ',');
									$new_date = date('Y-m-d H:i:s', strtotime($comment['date']));;
									$dvrq = $this->db->query("SELECT tbl_dvr.*,user.first_name,user.image,user.id FROM tbl_dvr
									LEFT JOIN user ON tbl_dvr.fk_engineer_id = user.id
									WHERE tbl_dvr.fk_complaint_id=$complaint_id AND CAST(tbl_dvr.date AS DATE) BETWEEN '$new_date' AND '$old_date'
									AND tbl_dvr.pk_dvr_id NOT IN (".$previous_dvrs.")
									ORDER BY tbl_dvr.date DESC, tbl_dvr.start_time DESC");
									$user_comments_dvr=$dvrq->result_array();
									foreach($user_comments_dvr as $commentt){
										// Loop for Showing DVR Comments
										$user_image2="noimage.jpg";
										$poster_name=$commentt['first_name'];
										if(!empty($commentt['image'])){ $user_image2	=	$commentt['id'].".".$commentt['image']; }
											
										$message_class	=	"in";
										if ($this->session->userdata('userid')==$commentt['id']) $message_class	= "out"; 
										echo 	'<ul class="chats">
												<li class="'.$message_class.'">
												<img class="avatar" alt="" src="'.base_url().'usersimages/'.$user_image2.'">
												<div class="message">
												<span class="arrow"></span>
												<a href="javascript:;" class="name">'.$poster_name.'</a>
												<span class="datetime"> at
												';
										date_default_timezone_set('Asia/Karachi');
										echo date('h:i a', strtotime($commentt['start_time'])).",".date('d-M-Y', strtotime($commentt['date'])); 
										echo 	'</span>
												<span class="body">
												FROM DVR ('.date('h:i a', strtotime($commentt["start_time"])).' to '.date('h:i a', strtotime($commentt["end_time"])).'): '.urldecode($commentt["summery"]).'</span>
												</div>
												</li>
												</ul>
											';
										array_push($dvrs,$commentt['pk_dvr_id']); 
									}
									// DVR Comments Loop END
									// Fetch Main Comments
									$user_image2="noimage.jpg";
									$poster_name=$comment['first_name'];
									if(!empty($comment['image'])){ $user_image2	=	$comment['id'].".".$comment['image']; }
											
									$message_class	=	"in";
									if ($this->session->userdata('userid')==$comment['id']) $message_class	= "out"; 
									echo 	'<ul class="chats">
												<li class="'.$message_class.'">
												<img class="avatar" alt="" src="'.base_url().'usersimages/'.$user_image2.'">
												<div class="message">
												<span class="arrow"></span>
												<a href="javascript:;" class="name">'.$poster_name.'</a>
												<span class="datetime"> at
												';
										date_default_timezone_set('Asia/Karachi');
										echo date('h:i a', strtotime($comment['date'])).",".date('d-M-Y', strtotime($comment['date'])); 
										echo 	'</span>
												<span class="body">'.urldecode($comment["comment"]).'</span>
												</div>
												</li>
												</ul>
											';
									}// End Comments Loop
									
									if (sizeof($user_comments)>=0) {
									$previous_dvrs = rtrim(implode(',', $dvrs), ',');
									$dvrq = $this->db->query("SELECT tbl_dvr.*,user.first_name,user.image,user.id FROM tbl_dvr
									LEFT JOIN user ON tbl_dvr.fk_engineer_id = user.id
									WHERE tbl_dvr.fk_complaint_id=$complaint_id
									AND tbl_dvr.pk_dvr_id NOT IN (".$previous_dvrs.")
									ORDER BY tbl_dvr.date DESC, tbl_dvr.start_time DESC");
									$user_comments_dvr=$dvrq->result_array();
									
									foreach($user_comments_dvr as $comment){
										$user_image2="noimage.jpg";
										$poster_name=$comment['first_name'];
										if(!empty($comment['image'])){ $user_image2	=	$comment['id'].".".$comment['image']; }
												
										$message_class	=	"in";
										if ($this->session->userdata('userid')==$comment['id']) $message_class	= "out"; 
										echo 	'<ul class="chats">
													<li class="'.$message_class.'">
													<img class="avatar" alt="" src="'.base_url().'usersimages/'.$user_image2.'">
													<div class="message">
													<span class="arrow"></span>
													<a href="javascript:;" class="name">'.$poster_name.'</a>
													<span class="datetime"> at
													';
											date_default_timezone_set('Asia/Karachi');
											echo date('h:i a', strtotime($comment['start_time'])).",".date('d-M-Y', strtotime($comment['date'])); 
										echo 	'</span>
												<span class="body">
												FROM DVR ('.date('h:i a', strtotime($comment["start_time"])).' to '.date('h:i a', strtotime($comment["end_time"])).'): '.urldecode($comment["summery"]).'</span>
												</div>
												</li>
												</ul>
											';
											array_push($dvrs,$comment['pk_dvr_id']); }
									}
									?>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
<!-- End Messages Portlet -->		  
<!-- Begin Portlet Troubleshooting Details -->
						  <div class="portlet box green-seagreen" id="working_details">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs"></i>Troubleshooting / Working Details
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							
							<div class="portlet-body">
							<div class="row">
							  <div class="col-md-6">
								<div class="btn-group">
								  <!-- button for Modal -->
								  <?php if($assigned_to && ($get_compalaint_result[0]['status']!="Pending Verification" && $get_compalaint_result[0]['status']!="Closed")) { ?>
								  <a href="#" id="sample_editable_1_new" class="btn green-seagreen" data-toggle="modal" data-target="#myModal"> 
									  Add Working / Troubleshooting Details
									  <i class="fa fa-plus"></i> 
								  </a>
								  <?php } ?>
							<!-- Modal Form Begin (z)-->
							<!-- Modal -->
							<div id="myModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Working Trouble Shooting Details</h4>
								  </div>
								  <div class="modal-body">
								  <!-- Modal from Metronics -->
								   <form action="<?php echo base_url();?>sys/add_working_details_insert" class="form-horizontal" method="post">
                
									<div class="form-group row">
										<label class="col-md-3 control-label">Date</label>
										<div class="col-md-9">
											<input type="text" class="datepicker2 form-control" name="wd_date">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-md-3 control-label">Time</label>
										<div class="col-md-9">
											<input type="text" class="form-control timepicker1 timepicker timepicker-no-seconds" name="wd_time" placeholder="Enter time">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-md-3 control-label">Action Taken</label>
										<div class="col-md-9">
											<textarea class="form-control" name="action_taken" placeholder="Enter your action details" rows="3"></textarea>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-3 control-label">Result</label>
										<div class="col-md-9">
											<textarea class="form-control" name="result" placeholder="Enter the result of your action" rows="3"></textarea>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-md-3 control-label">Analysis</label>
										<div class="col-md-9">
											<textarea class="form-control" name="analysis" placeholder="Enter your analysis of result" rows="3"></textarea>
										</div>
									</div>
									<input type="hidden" name="fk_complaint_id" value="<?php echo $this->uri->segment(3);?> ">
                
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-offset-8 col-md-4">
                                    <button type="submit" class="btn green-seagreen" 
									<?php if($assigned_to) { ?>
									onclick="return check_status('<?php echo $get_compalaint_result[0]['status'];  ?>')"
									<?php } ?>
									>Submit</button>
                                    <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </form>
								  <!-- Form End -->
						
								  </div>
								</div>
							  </div>
							</div>

							
								</div>
							  </div>   
							</div>

<!-- Information in Table -->
							<div class="portlet-body flip-scroll">					
								<div class="row">
								  <div class="col-md-12"> 
									<div class="table-scrollable">
									
								<table class="table table-bordered table-striped table-condensed flip-content">
								<thead class="flip-content">
								<tr>
									<th class="date">Date</th>
									<th class="time">Time</th>
									<th>Action Taken</th>
									<th>Result</th>
									<th>Analysis</th>
								</tr>
								</thead>
								<tbody>
								
								<?php
								$ty22=$this->db->query("select * from tbl_working_details WHERE fk_complaint_id='" . $this->uri->segment(3)."'");
								$rt22=$ty22->result_array();
								$count_working_details = sizeof($rt22);
								if (sizeof($rt22) == "0") {} 
								else {
									foreach ($rt22 as $get_working_details) {
										?>
										<tr>											
											<td><?php echo date('d-M-Y', strtotime($get_working_details["date"])); ?></td>
											<td><?php echo $get_working_details["time"] ?></td>
											<td><?php echo urldecode($get_working_details["action_taken"]); ?></td>
											<td><?php echo urldecode($get_working_details["result"]); ?></td>
											<td><?php echo urldecode($get_working_details["analysis"]); ?></td>
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
							</div>
							</div>
						</div>
<!-- End Portlet Troubleshooting Details -->

<!-- Begin Portlet QC Data -->
						  <div class="portlet box yellow-gold" id="qc_dataa">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs"></i>Calibration / Quality Control Data
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove">
									</a>
								</div>
							</div>
							
							<div class="portlet-body">
							
							<div class="row">
							  <div class="col-md-6">
								<div class="btn-group">
								
								  <!-- button for Modal -->
								  <?php if($assigned_to && ($get_compalaint_result[0]['status']!="Pending Verification" && $get_compalaint_result[0]['status']!="Closed")) { ?>
								  <a href="#" id="sample_editable_1_new" class="btn yellow-gold" data-toggle="modal" data-target="#myModal2"> 
									  Add Calibration / Quality Control Data
									  <i class="fa fa-plus"></i> 
								  </a>
								  <?php } ?>
								</div>
															
							<!-- Modal -->
							<div id="myModal2" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Calibration / QC Data</h4>
								  </div>
								  <div class="modal-body">
								  <!-- Modal from Metronics -->
								   <form action="<?php echo base_url();?>sys/add_qc_data_insert" class="form-horizontal" method="post">

									
									<div class="form-group row">
									<label class="col-md-3 control-label">Calibration Data</label>
									<div class="col-md-9">
									<textarea class="form-control" name="calibration_data" placeholder="Enter text" rows="3"></textarea>
									</div>
									</div>

									<div class="form-group row">
									<label class="col-md-3 control-label">QC Data</label>
									<div class="col-md-9">
									<textarea class="form-control" name="qc_data" placeholder="Enter text" rows="3"></textarea>
									</div>
									</div>
									<input type="hidden" name="fk_complaint_id" value="<?php echo $this->uri->segment(3);?> ">
 
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-offset-8 col-md-4">
                                    <button type="submit" class="btn yellow-gold" 
									<?php if($assigned_to) { ?>
									onclick="return check_status('<?php echo $get_compalaint_result[0]['status'];  ?>')"
									<?php } ?>
									>Submit</button>
                                    <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </form>
								  
						
								  </div>
								</div>
							  </div>
							</div>

	<!--  MODAL END  -->
							  </div>   
							</div>
							
							<!-- SHOWING QC DATA -->
							<div class="portlet-body flip-scroll">					
								<div class="row">
								  <div class="col-md-12"> 
									<div class="table-scrollable">
									
								<table class="table table-bordered table-striped table-condensed flip-content">
								<thead class="flip-content">
								<tr>
									<th>Calibration Data</th>
									<th>QC Data</th>
								</tr>
								</thead>
								<tbody>
								
								<?php
								$ty22=$this->db->query("select * from tbl_qc_data WHERE fk_complaint_id='" . $this->uri->segment(3)."'");
								$rt22=$ty22->result_array();
								if (sizeof($rt22) == "0") {} 
								else {
									foreach ($rt22 as $get_qc_data) {
										?>
										<tr>											
											<td><?php echo urldecode($get_qc_data["calibration_data"]); ?></td>
											<td><?php echo urldecode($get_qc_data["qc_data"]); ?></td>
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
							</div>
							</div>
						</div>
<!-- END SAMPLE TABLE PORTLET-->        
         
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		<?php if($assigned_to && ($get_compalaint_result[0]['status']!="Pending Verification" && $get_compalaint_result[0]['status']!="Closed")) { ?>
        <form action="<?php echo base_url();?>sys/update_ts_report" class="form-horizontal" method="post" enctype="multipart/form-data"> 
		<?php } ?>		
          <div class="portlet box red">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Other Details</div>
            </div>
            <div class="portlet-body">
              <div class="portlet-body flip-scroll">
                <div class="row">
                          <div class="col-md-12 form-horizontal">
							<div class="form-group">
							<label class="col-md-4 control-label">Reporting Date*</label>
								<div class="col-md-4">
									<input type="text" class="datepicker2 form-control" name="reporting_date" value="<?php 
									 	if($get_compalaint_result[0]['reporting_date']!='0000-00-00 00:00:00')
										 {
										 	echo date('d-M-Y', strtotime($get_compalaint_result[0]['reporting_date']));
										 }  
									 ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Reporting Time*</label>
								<div class="col-md-4">
									<input type="text" class="form-control <?php if($assigned_to) echo 'timepicker1 timepicker timepicker-no-seconds'; ?>" name="reporting_time" value="<?php echo $get_compalaint_result[0]['reporting_time'] ; ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Solution Date*</label>
								<div class="col-md-4">
									<input type="text" class="datepicker2 form-control" name="solution_date" value="<?php 
									if($get_compalaint_result[0]['solution_date']!='0000-00-00 00:00:00') echo trim(date('d-M-Y', strtotime($get_compalaint_result[0]['solution_date'])) ); 
									?>
									 ">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Solution Time*</label>
								<div class="col-md-4">
									<input type="text" class="form-control <?php if($assigned_to) echo 'timepicker1 timepicker timepicker-no-seconds'; ?>" name="solution_time" value="<?php echo $get_compalaint_result[0]['solution_time'] ; ?>">
								</div>
							</div>
							
                            <div class="form-group">
							<label class="col-md-4 control-label">Actual Cause of Problem*</label>							
								<div class="col-md-4">								
                                    <input type="text" class="form-control" name="problem_cause" value="<?php echo $get_compalaint_result[0]['problem_cause'] ; ?>">								
								</div>
                            </div>
							
							<div class="form-group">
							<label class="col-md-4 control-label ">Name of Customer Signing Complaint Form*</label>
								<div class="col-md-4">
									<input type="text" class="form-control customer_signing_complaint_form" name="customer_signing_complaint_form" value="<?php echo urldecode($get_compalaint_result[0]['customer_signing_complaint_form']) ; ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label ">Mobile of Customer Signing Complaint Form*</label>
								<div class="col-md-4">
									<input type="text" class="form-control customer_mobile_signing_complaint_form" name="customer_mobile_signing_complaint_form" value="<?php echo urldecode($get_compalaint_result[0]['customer_mobile_signing_complaint_form']) ; ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label ">Designation of Customer Signing Complaint Form*</label>
								<div class="col-md-4">
									<input type="text" class="form-control customer_designation_signing_complaint_form" name="customer_designation_signing_complaint_form" value="<?php echo urldecode($get_compalaint_result[0]['customer_designation_signing_complaint_form']) ; ?>">
								</div>
							</div>
							
                          </div>
                    </div>
				</div>
            </div>
          </div>

          <!-- END EXAMPLE TABLE PORTLET-->
          
           <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box blue-chambray">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Replacement Details (if any)</div>
            </div>

            <div class="portlet-body">
              <div class="portlet-body flip-scroll">
                <div class="row">
                          <div class="col-md-12"> 
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="table-scrollable">
                                  <table class="table table-hover table-bordered">
                                    <thead>
                                      <tr>
                                        <th> Cat. / Part #</th>
                                        <th> Kit / part Description </th>
                                        <th> DC Number </th>
                                        <th> Qty </th>
                                        <th> Price </th>
                                        <th> Source </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php
									  $sprf_qu 		= $this->db->query("
									  SELECT tbl_sprf.*,tbl_parts.description AS part_description,tbl_parts.unit_price,tbl_parts.part_number, tbl_clients.client_name,tbl_cities.city_name 
									  FROM tbl_sprf 
									  LEFT JOIN tbl_parts ON tbl_sprf.fk_part_id = tbl_parts.pk_part_id
									  LEFT JOIN tbl_clients ON tbl_sprf.source_id = tbl_clients.pk_client_id
									  LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									  WHERE `fk_complaint_id` = '".$this->uri->segment(3)."' AND `dc_number` != '0'");
									  $sprf	= $sprf_qu->result_array();
									  if (sizeof($sprf) == "0") {} 
									  else {
										  foreach ($sprf as $customers_list) {
									?>
                                      <tr>
                                        <td><?php echo $customers_list["part_number"];?></td>
                                        <td><?php  echo urldecode($customers_list["part_description"]);?></td>
                                        <td><?php echo $customers_list["dc_number"];?></td>
                                        <td><?php echo $customers_list["quantity"]; ?></td>
                                        <td><?php echo $customers_list["quantity"]*$customers_list["unit_price"]; ?></td>
                                        <td>
                                        <?php 
										if($customers_list["part_source"]=='stock') { echo 'Stock'; } else {
											if (substr( $customers_list["source_id"], 0,1) == 'o') {
												$temp = explode('#',$customers_list["source_id"]);
												$client_qu=$this->db->query("select * from tbl_offices where client_option='".$temp[0]."'");
												$client=$client_qu->result_array();
												echo $client[0]["office_name"];
											}
											else {
												echo $customers_list["client_name"].' - ';
												echo $customers_list["city_name"];
											}
										} ?>
                                        </td>
                                      </tr>
                                      <?php }
									  }
									  ?>
                                    </tbody>
                                  </table>
                                </div>
                            <!-- END SAMPLE TABLE PORTLET--> 
                          </div>
                        </div>
              </div>
            </div>
          </div>

          <!-- END EXAMPLE TABLE PORTLET-->
          
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Customer Feedback</div>
            </div>

            <div class="portlet-body">
			 <div class="portlet-body flip-scroll">
                <div class="row">
				
				<div class="col-md-12 ">
					<div class="form-group">
						<div class="col-md-12">
                              <textarea class="form-control" name="customer_feedback"><?php echo urldecode($get_compalaint_result[0]['customer_feedback']);?></textarea>
                        </div>
					</div>
					
					<div class="form-group">
					<div class="col-md-12">
                            <?php if($assigned_to){
									if($get_compalaint_result[0]['status']=='Pending' || 
									$get_compalaint_result[0]['status']=='Shifted' || 
									$get_compalaint_result[0]['status']=='SPRF Approved' || 
									$get_compalaint_result[0]['status']=='Pending (BB)' ) { ?>
										<span class="btn blue fileinput-button">
											<input type="file" name="uploadFile" multiple="" id="upload_file">
										</span>
								<?php } 
							}
							?>
                            <p>
                            <?php
								if($get_compalaint_result[0]['image']=="") $user_image3="noimage.jpg";
								else $user_image3	=	$get_compalaint_result[0]['pk_complaint_id'].'.'.$get_compalaint_result[0]['image'];
							?>
							<a data-toggle="modal" data-target="#myModal3" style="cursor:pointer;"><img src="<?php echo base_url();?>usersimages/complaint_images/<?php echo $user_image3;?>" alt="" style="width:200px;"/></a>
								
							<div id="myModal3" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><?php echo $user_image3; ?></h4>
								  </div>
								  <div class="modal-body">
								  <!-- Modal from Metronics -->
								  <div class="row">
								  <img src="<?php echo base_url();?>usersimages/complaint_images/<?php echo $user_image3;?>" alt="" class="img-responsive"/>
								  </div>
							  </div>
								</div>
							  </div>
							</div>
						</p>
                    </div>
					</div>
				</div>	
                </div>
			
			<input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?> ">
			
                <div class="form-actions right">
				<div class="row">
                        <div class="col-md-12">
                            <div class="row">
					<div class="col-md-offset-10 col-md-2">
					<?php if ($assigned_to && ($get_compalaint_result[0]['status']!="Pending Verification" && $get_compalaint_result[0]['status']!="Closed")) { ?>
                    <!-- <button type="button" class="btn default">Cancel</button> -->
                        <button type="submit" class="btn blue" onclick="return check_status('<?php echo $get_compalaint_result[0]['status'];  ?>')">
                        <input type="hidden" id="complaint_status" value="<?php echo $get_compalaint_result[0]['status'];?>" />
                        	<i class="fa fa-check"></i> Save
                        </button>
                        <p id="show_message"><?php if(isset($_GET['status'])){ echo "Report has been submitted for Verification";}?></p>
						<?php if($count_working_details==0) {?>
						<?php echo "You cannot submit for approval without entering any working details. Please enter working details for Submit button to appear here.";
						} else {
						?>
                        <button type="button" class="btn blue" onclick="return status_pending_sv(<?php echo $this->uri->segment(3).",'".$get_compalaint_result[0]['status']."'";?>)">
                        	Submit For Approval
                        </button>
						<?php } ?>
                        
                        <script>
						function check_status(status)
						{
							if(status!='Pending' && status!='Pending (BB)' && status!='Shifted' && status!='SPRF Approved')
							{
								alert('You are not allowed to edit the TS report after it has been submitted for approval');
								return false;
							}
							else
							{
								return true;
							}
						}
						function status_pending_sv(complaint_id,status)
						{
						
							var upload_file 								= '<?php echo $get_compalaint_result[0]['image'];?>';
							var customer_signing_complaint_form 			= $('.customer_signing_complaint_form').val();
							var customer_mobile_signing_complaint_form 		= $('.customer_mobile_signing_complaint_form').val();
							var customer_designation_signing_complaint_form = $('.customer_designation_signing_complaint_form').val();
							if(upload_file=='') {
								alert('No file Uploaded for TS Report.');
								return false;
							}
							if(customer_signing_complaint_form=='') {
								alert('Fill Customer Signing in Complaint form.');
								return false;
							}
							if(customer_mobile_signing_complaint_form=='') {
								alert('Fill Customer Mobile Signing in Complaint form.');
								return false;
							}
							if(customer_designation_signing_complaint_form=='') {
								alert('Fill Customer Designation Signing in Complaint form.');
								return false;
							}
							var problem_cause = '<?php echo $get_compalaint_result[0]['problem_cause'];?>';
							if(problem_cause=='') {
								alert('Actual cause of the problem must be saved.');
								return false;
							}
							///////////// status check
							if(status!='Pending' && status!='Pending (BB)' && status!='Shifted'  && status!='SPRF Approved') {
								alert('Report has already been submitted');
								return false;
							}
							//var upload_file = $('#upload_file').val();
							
							else {
							var response = confirm('Want to submit your report for approval? You will no longer be able make changes to this report. Please make sure that you have saved the report before submitting. No changes will be saved if you will submit it without saving.');
							if(response==false) {
								return false;
							}
							else {
								formdata = {
									complaint_id:complaint_id
								}
								$.ajax({
									data:formdata,
									url:"<?php echo base_url();?>sys/status_pending_sv_ajax",
									type:'POST',
									success:function(msg)
									{
										$('#show_message').html(msg);
										$('#complaint_status').html('Pending SV');
										
									}
									});
									window.location.replace('<?php echo base_url();?>sys/technical_service_pvr/<?php echo $get_compalaint_result[0]['pk_complaint_id'];?>');
									return false;
							}
							}
						}
						</script>   
                    <?php } ?>
					</div>
					</div>
					</div>
					</div>
                 </div>
			  </div>
            </div>
          </div>
		  <?php if ($assigned_to && ($get_compalaint_result[0]['status']!="Pending Verification" && $get_compalaint_result[0]['status']!="Closed")) echo "</form>"; ?>
          <!-- END EXAMPLE TABLE PORTLET-->
          <!---->
		  
		<?php if($this->session->userdata('userrole')=="Admin" || $this->session->userdata('userrole')=="secratery" || 
		(($this->session->userdata('userrole')=="Supervisor" || $this->session->userdata('userrole')=="") && $get_compalaint_result[0]['status']=='Closed' )) { ?>  
		            <div class="portlet box purple-plum">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Supervisor Feedback</div>
              <div class="tools">
                   <a href="javascript:;" class="collapse"> </a> 
                   <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                               <tr>
                                    <td><b>Verification Method</b></td>
                                    <td> <?php if ($get_compalaint_result[0]['verification_method'] == '1') echo "Customer Callback";
									 elseif ($get_compalaint_result[0]['verification_method'] == '2') echo "Phone Verification";
									 else echo "Not Available";
									 ?></td>
                               </tr>
							   <tr>
                                    <td><b>Supervisor Comments</b></td>
									<td> <?php echo $get_compalaint_result[0]['supervisor_findings'];?></td>
                               </tr>
                               <tr>
                                    <td><b>Customer Comments</b></td>
									<td> <?php echo $get_compalaint_result[0]['supervisor_comments'];?></td>
                               </tr>
                               <tr>
                                    <td><b>Contact Person</b></td>
									<td> <?php echo $get_compalaint_result[0]['contact_person_verification'];?></td>
                               </tr>
                               <tr>
                                    <td><b>Contact Number</b></td>
									<td><?php echo $get_compalaint_result[0]['contact_number_verification'];?></td>  
								</tr> 
                                                          
                            </tbody>
                       </table>

                </div>
                   <?php if($obj->is_allowed('Admin')){ ?>
                        <button class="btn btn-success" data-toggle="modal" data-target="#ModalContinue" >Change Status</button>
                        <!-- Modal Order Id -->
                        <div id="ModalContinue" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><h1>Change Status</h1></h4>
                              </div>
                              <form method="post" action="<?php echo base_url();?>sys/director_change_status">
                              <div class="modal-body">
                                  <div class="row">
                                   <div class="col-md-10">
                                            <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?>" />
                                            <div class="form-group">
                                            <select class="form-controle" name="status" style="width:100%">
                                                <option value="Pending" <?php if($get_compalaint_result[0]['status']=="Pending") { echo "Selected";}?>>
                                                    Pending
                                                </option>
                                                <option value="SPRF Approved" <?php if($get_compalaint_result[0]['status']=="SPRF Approved") { echo "Selected";}?>>
                                                    SPRF Approved
                                                </option>
                                                <option value="Pending Registration" <?php if($get_compalaint_result[0]['status']=="Pending Registration") { echo "Selected";}?>>
                                                    Pending Registration
                                                </option>
                                                <option value="Pending Verification" <?php if($get_compalaint_result[0]['status']=="Pending Verification") { echo "Selected";}?>>
                                                    Pending Verification
                                                </option>
                                                <option value="Closed" <?php if($get_compalaint_result[0]['status']=="Closed") { echo "Selected";}?>>
                                                    Closed
                                                </option>
                                                
                                            </select>
                                            </div>
											
                                            <div class="form-group">
												<label>Comments</label>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" name="comment"></textarea>
                                            </div>
                                            <div class="form-group">
												<input name="ts_report_director" type="hidden" />
                                            </div>
                                      
                                  </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <input type="submit" value="Submit"  class="btn btn-success" />
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>       
                        <?php }?> 
               </div>
    
              </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
		<?php } //end if condition Admin ?>
        
<?php if($this->session->userdata('userrole')=="Supervisor" && $get_compalaint_result[0]['status']=="Pending Verification") { ?>  		
          <form action="<?php echo base_url();?>sys/update_ts_report_supervisor" class="form-horizontal" method="post" enctype="multipart/form-data">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box blue">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Update status</div>

            </div>

            <div class="portlet-body">
			 <div class="portlet-body flip-scroll">
                <div class="row">
                    <div class="col-md-12 ">
                    	<div class="form-group">
                        <label class="col-md-4 control-label">TSS Comments and Findings</label>							
                            <div class="col-md-4">								
                                <textarea rows="3" class="form-control" name="supervisor_findings" id="supervisor_findings"><?php echo $get_compalaint_result[0]['supervisor_findings']?></textarea>						
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                    	<div class="form-group">
                        <label class="col-md-4 control-label">Update status</label>							
                            <div class="col-md-4">								
                                <select id="problem_cause" name="status" class="form-control" onchange="problem_cause_change(this.value)" >
                                    <option value="">--Choose--</option>
                                    <option value="Closed">Close</option>
                                    <option value="Pending (BB)">Pending (BB)</option>
                                </select>								
                            </div>
                        </div>
                    </div>	
                </div>
                <div class="row">
                    <div  id="bounceback"  class="col-md-12" style="display:none">
					
					<div class="form-group">
                        <label class="col-md-4 control-label">Bounce Back Comments</label>							
                            <div class="col-md-4">								
                                <textarea rows="3" class="form-control" name="bb_comments" id="bb_comments"></textarea>						
                            </div>
                    </div>
                   
                        <div class="form-group">
                          <label class="col-md-4 control-label">Assign to</label>
                          <div class="col-md-4">
						   <select id="problem_type2" name="problem_type2" class="form-control" >
                                <option value="<?php echo $get_compalaint_result[0]['assign_to'] ?>">--Choose--</option>
                                <?php 
                                      $ty21=$this->db->query("select * from user WHERE id='" . $this->session->userdata('userid')."'");
                                      $rt21=$ty21->result_array();
                                      $ty22=$this->db->query("select * from user WHERE FIND_IN_SET_X('" . $rt21[0]['fk_office_id']."',fk_office_id) AND userrole IN('FSE','Supervisor') ORDER BY  `fk_office_id` ,  `userrole` ASC ");
                                      $rt22=$ty22->result_array();
                                      if (sizeof($rt22) == "0") {} 
									  else {
                                          foreach($rt22 as $engineer){
                                          ?>
                                          <option value="<?php echo $engineer['id'];?>" ><?php echo $engineer['first_name'];?></option>
                                      <?php }
                                      }
                                      ?>
                           </select>
						   </div>
						   <div class="col-md-12">
						   <br />
						   <table class="table table-striped table-condensed table-bordered table-hover flip-content">
						   <thead>
						   <tr>
								<th>FSE/SAP</th>
								<th>Total Complaints (30 Days)</th>
								<th>Pending Complaints</th>
								<th>Total PM Calls (30 Days)</th>
								<th>Pending PM Calls</th>
						   </tr>
						   </thead>
						   <?php
						   
						   $qua="SELECT * from user where FIND_IN_SET_X('". $rt21[0]['fk_office_id'] ."',fk_office_id) AND userrole IN('FSE','Salesman','Supervisor') AND user.delete_status=0 ORDER BY  `fk_office_id` ,  `userrole` ASC ";
							
							$gha=$this->db->query($qua);
							$rta=$gha->result_array();
							
							foreach($rta as $valuea)
							{
								$userid			 =	$valuea['id'];
								
								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND status!='Closed'";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$pending_ts = sizeof($result); 

								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND status!='Completed' ";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$pending_pm = sizeof($result);

								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$month_ts = sizeof($result);

								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$month_pm = sizeof($result);
								
								echo '<tr>';
								echo "<td>".$valuea['first_name']." </td> <td> ".$month_ts." </td> <td> ".$pending_ts."</td> <td>".$month_pm."</td> <td> ".$pending_pm."</td>";								
								echo '</tr>';
								
							}
						   ?>
						   </table>
						   </div>
                           <script>
						   function pendingtsshow(userid)
						   {
							   var formdata =
								  {
									userid: userid,
									complaint_id: <?php echo $this->uri->segment(3);?>
								  };
							  $.ajax({
								url: "<?php echo base_url();?>sys/select_user_complaint_ajax",
								type: 'POST',
								data: formdata,
								success: function(msg){
									$("#pendingtsshow").html(msg);
									}
								})
								return false;
						   }
						   </script>

                    <!--      </div> -->
                        </div>
                        <div class="form-group">
                          <label class="col-md-4 control-label">&nbsp;</label>
                          <div class="col-md-4">
                            <p id="pendingtsshow"></p>
                          </div>
                        </div>
                      </div>
                </div>
                
                <div id="completed" style="display:block">
                       <div class="row" style="margin:0 0 0 0;">
                          <div class="col-md-6">

                           <div class="form-group">

                              <label class="control-label">Verification <span class="bg-red">(NOTE: Do NOT write your own name and contact details in the following fields)</span></label>
                                    <div class="radio-list">

                                      <label class="radio-inline">

                                      <input type="radio"  name="optionsRadios"id="optionsRadios1" 
									  <?php if($get_compalaint_result[0]['verification_method']=='1' || $get_compalaint_result[0]['verification_method']==''){?>
                                      checked="checked"
									  <?php }?> 
                                      value="1"> Customer Call Back </label>

                                      <label class="radio-inline">

                                      <input type="radio"  name="optionsRadios"id="optionsRadios1" 
									  <?php if($get_compalaint_result[0]['verification_method']=='2'){?>checked="checked"<?php }?> value="2"> Personal Visit </label>
                                    </div>

                                 </div>

                            </div>

                       </div>
                       <div class="row" style="margin:0 0 0 0;">
                           <div class="col-md-6">
                            <div class="form-group">

                               <label class="control-label">Customer Comments (Regarding Service Call)</label>
                                    <textarea class="form-control " rows="3" name="remarks"  id="supervisor_comments"><?php echo $get_compalaint_result[0]['supervisor_comments']?></textarea>

                                  </div>

                            </div>

                          </div>
                       <div class="row" style="margin:0 0 0 0;">

                               <div class="col-md-6">

                            <div class="form-group">

                              <label class="control-label">Customer Name (who was contacted for verification)</label>

                          <input type="text" class="form-control" name="contact_person_verification" id="contact_person_verification" value="<?php echo $get_compalaint_result[0]['contact_person_verification']?>" >

                            </div>

                            </div>

                          </div>
                       <div class="row" style="margin:0 0 0 0;">

                             <div class="col-md-6">

                            <div class="form-group">

                              <label class="control-label">Customer Mobile Number (who was contacted for verification)</label>

                          <input type="text" class="form-control" name="contact_number_verification" id="contact_number_verification" value="<?php echo $get_compalaint_result[0]['contact_number_verification']?>"  >

                            </div>
                            </div>
                          </div>
                </div>
			<script type="text/javascript">
				function problem_cause_change(locations)
				{
						//alert('hello world');
		
						if(locations=="Pending (BB)"){
		
							document.getElementById('bounceback').style.display = 'block';
		
							document.getElementById('completed').style.display = 'none';
							$('#supervisor_findings').removeAttr('required');
							$('#supervisor_comments').removeAttr('required');
							$('#contact_person_verification').removeAttr('required');
							$('#contact_number_verification').removeAttr('required');
							
							$('#bb_comments').attr('required', 'required');
		
							}
						else if (locations=="Closed"){
		
							document.getElementById('completed').style.display = 'block';
		
							document.getElementById('bounceback').style.display = 'none';
							$('#supervisor_findings').attr('required', 'required');
							$('#supervisor_comments').attr('required', 'required');
							$('#contact_person_verification').attr('required', 'required');
							$('#contact_number_verification').attr('required', 'required');
							
							$('#bb_comments').removeAttr('required');
		
						}
		
						else{
		
							document.getElementById('completed').style.display = 'block';
		
							document.getElementById('bounceback').style.display = 'none';
							$('#supervisor_findings').removeAttr('required');
							$('#supervisor_comments').removeAttr('required');
							$('#contact_person_verification').removeAttr('required');
							$('#contact_number_verification').removeAttr('required');
							$('#bb_comments').removeAttr('required');
		
							}
		
				}
		
		</script>
			<input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?> ">
			
              <div class="form-actions right">
				<div class="row">
                  <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-offset-10 col-md-2">
                          <!--  <button type="button" class="btn default">Cancel</button> -->
                        	<button type="submit" class="btn blue" onclick="return check_status('<?php echo $get_compalaint_result[0]['status'];  ?>')">Submit</button>
                          <script>
                          function check_status(status)
                          {
                            //if(status!='Pending Verification' && status!='Pending Verification (BB)' && status!='Shifted')
                            if(status!='Pending Verification' && status!='Pending Verification (BB)')
                            {
                              alert('You are not allowed to update the TS report with current status');
                              return false;
                            }
                            else
                            {
                              return true;
                            }
                          }
                          </script>

                        </div>
					</div>
				</div>
			</div>
                 </div>
			  </div>
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET--> 
          </form>
<?php } // supervisor condition if ?>		  
		
		</div>
      </div>
      <!-- END PAGE CONTENT--> 

  <!-- END CONTENT --> 

</div>

<!-- END CONTAINER --> 
<?php $this->load->view('footer');?>