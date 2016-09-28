<?php $this->load->view('header');?>

<?php
			/*

			$query="select `pk_complaint_id` from tbl_complaints where `assign_to` ='".$this->session->userdata('userid')."'
			AND `complaint_nature`='complaint'";
			$query_db=$this->db->query($query);
			$user_complaints=$query_db->result_array();
			//$user_complaints = array_map('current', $user_complaints[0]);
			//$oneDimensionalArray = call_user_func_array('array_merge', $user_complaints);
			$check=false;
			
			foreach ($user_complaints as $user_complaint)
			{
				if ($user_complaint['pk_complaint_id']==$this->uri->segment(3))
				{
					$check=true;
				}
			}
			
			if (! $check)
			show_404();
		*/
		
		$query="select `assign_to` from tbl_complaints where `pk_complaint_id` ='".$this->uri->segment(3)."'
			AND `complaint_nature`='complaint'";
			$query_db=$this->db->query($query);
			$user_complaints=$query_db->result_array();			
			if ($user_complaints[0]['assign_to']!=$this->session->userdata('userid'))
			show_404();
$count_working_details	=	0;
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

        <div class="page-toolbar">

         

        </div>

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">
            <?php
				$complaint_id	=	$this->uri->segment(3);
				  $nsql="select * from tbl_complaints where pk_complaint_id ='".$this->uri->segment(3)."'";
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
          
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          
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

                            <thead>
                              <tr><th>Attribute</th><th>Value</th></tr>
                            </thead>
                            <tbody>
                               <tr class="odd gradeX">
                                      <td>
                                      TS Number
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['ts_number'] ;  ?></td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      Customer
                                     </td>
                                     <td> 
                                     <?php    
                                        $nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$get_compalaint_result[0]['fk_customer_id']."'");
                                        $n2sql3=$nsql3->result_array();
                                        echo $n2sql3[0]['client_name'];
                                     ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      City
                                     </td>
                                     <td> 
                                     <?php    
                                        $nsql3=$this->db->query("select * from tbl_cities where pk_city_id ='".$get_compalaint_result[0]['fk_city_id']."'");
                                        $n2sql3=$nsql3->result_array();
                                        echo $n2sql3[0]['city_name'];
                                     ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">
                                    <td>
                              Equipment
                             </td>
                             <td>
                              <?php    
                                  $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
								  if($nsql3->num_rows()>0)
								  {
                                  $n2sql3=$nsql3->result_array();
								  
								  $nsql4=$this->db->query("select * from tbl_products where pk_product_id ='".$n2sql3[0]['fk_product_id']."'");
                                  $n2sql4=$nsql4->result_array();
                                  echo $n2sql4[0]['product_name'];
								  }
                               ?>
                             </td>  
                               </tr> 
                               <tr class="odd gradeX">							   
									<td>
									  Serial No.
									 </td>
									 <td>
								   <?php    
									  $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
									  if($nsql3->num_rows()>0)
								  		{
									  $n2sql3=$nsql3->result_array();
									  echo $n2sql3[0]['serial_no'];
										}
								   ?>
									 </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                       Warranty Status
                                     </td>
                                     <td> 
									 	<?php if($nsql3->num_rows()>0)
								  		{
											  $n2sql3=$nsql3->result_array();
											  if ($n2sql3[0]["warranty_months"]<0) echo "Not Defined";
											  if ($n2sql3[0]["warranty_months"]==0) echo "No Warranty";
											  if ($n2sql3[0]["warranty_months"]>0) {
												 // echo date('d-M-Y', strtotime($get_users_list["warranty_start_date"]));
												  $months_to_add = "+".$n2sql3[0]["warranty_months"]." months";
												  echo date('d-M-Y', strtotime($months_to_add, strtotime($n2sql3[0]["warranty_start_date"])));
										} }  ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">
									<td>
                                  Software Version
                                 </td>
                                 <td>
                                  <?php echo $get_compalaint_result[0]['instrument_software_version'];  ?>
                                 </td>
                               </tr>                                  
                            </tbody>
                       </table>
                </div>
                  
               </div>
               
                <div class="col-md-4">
                
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                              <tr><th>Attribute</th><th>Value</th></tr>
                            </thead>
                            <tbody>
                               <tr class="odd gradeX">
                                      <td>
                                      Caller Name
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['caller_name'];  ?>
                                     </td>
                               </tr>
							   <tr class="odd gradeX">
                                      <td>
                                      Caller Contact Number
                                     </td>
                                     <td> 
									 <?php if ($get_compalaint_result[0]['phone']!="") echo $get_compalaint_result[0]['phone'];
												else echo $get_compalaint_result[0]['landline'];
									 ?>
                                     </td>
                               </tr>
							   <tr class="odd gradeX">
                                <td>
                                   FSE Name
                                 </td>
                                 <td>
                                  <?php    
                                  $nsql3=$this->db->query("select * from user where id ='".$get_compalaint_result[0]['assign_to']."'");
                                  $n2sql3=$nsql3->result_array();
                                  echo $n2sql3[0]['first_name'];
                               ?>
                                 </td>  
                           </tr>
                               
                               <tr class="odd gradeX">
                                      <td>
									  Kit Name
									 </td>
									 <td>
									  <?php echo $get_compalaint_result[0]['kit_name'];  ?>
									 </td>
                               </tr> 
                               <tr class="odd gradeX">
                                      <td>
                                      Kit Lot
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['kit_lot_no'];  ?>
                                                                                             </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                  Kit Pack Size
                                 </td>
                                 <td>
                                  <?php echo $get_compalaint_result[0]['make_pack'];  ?>
                                 </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      Kit Expiry Date
                                     </td>
                                     <td> <?php //echo $get_compalaint_result[0]['ts_number'];  ?>
                                     </td>
                               </tr>
                                                                               
                                   
                            </tbody>
                       </table>
                </div>
                  
               </div>
               
                <div class="col-md-4">
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                              <tr><th>Attribute</th><th>Value</th></tr>
                            </thead>
                         <tbody>
                           <tr class="odd gradeX">
                                      <td>
									  Call Received Date
									 </td>
									 <td> 
									 <?php echo date('d-M-Y', strtotime($get_compalaint_result[0]['date']));  ?>
									 </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
									  Call Received Time
									 </td>
									 <td>
									  <?php echo date('H:i', strtotime($get_compalaint_result[0]['date']));  ?>
									 </td>
                               </tr>
                           <tr class="odd gradeX">
                                  <td>
                                       Reporting Date
                                     </td>
                                     <td> <?php 
									 	if($get_compalaint_result[0]['reporting_date']!='0000-00-00 00:00:00')
										 {
										 	echo date('d-M-Y', strtotime($get_compalaint_result[0]['reporting_date']));
										 }  
									 ?>
                                                                                             </td>
                           </tr>
						   
						   <tr class="odd gradeX">
                                      <td>
                                        Reporting Time
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['reporting_time'];  ?>
                                                                                             </td>
                               </tr>
                               <tr class="odd gradeX" style="display:none;">
                                      <td>
                                       PS Name
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['ps_name'];  ?>
                                                                                             </td>
                               </tr> 
							   
                        <tr class="odd gradeX">
                                  <td>
                                   Solution Date  
                                 </td>
                                 <td>
                                  <?php 
									 	if($get_compalaint_result[0]['solution_date']!='0000-00-00 00:00:00')
										 {
										 	echo date('d-M-Y', strtotime($get_compalaint_result[0]['solution_date']));
										 }  
									 ?>
                                 </td>
                           </tr>
						   
                           <tr class="odd gradeX">
                                  <td>
                                   Solution Time
                                 </td>
                                 <td>
                                  <?php echo $get_compalaint_result[0]['solution_time'];  ?>
                                 </td>
                           </tr>
						   
						   <tr class="odd gradeX">
								<td>
								Status
								</td>
								<td>
                                <?php 
								  $this->load->model("complaint_model");
								  $obj=new Complaint_model();
								  $obj->current_status($get_compalaint_result[0]['status']);
								?>
								
								</td>						   
						   </tr>
                                                                      
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
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
        
          <!-- END EXAMPLE TABLE PORTLET-->   
<!-- Begin Messages Portlet -->
<?php
	
	//$query="select * from tbl_complaints where `pk_complaint_id` ='".$complaint_id."'";
	//$query_db=$this->db->query($query);
	//$user_complaint=$query_db->result_array();
	$query="select * from tbl_comments where `fk_complaint_id` ='".$complaint_id."' ORDER BY `pk_comment_id` DESC";
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
						
						<form action="<?php echo site_url('complaint/add_comment_2'); // My Controller?>" method="post" class="form-horizontal form-bordered">
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
									<!--<a href="" type="submit" class="btn blue icn-only">-->
									
									<!--</a>-->
								</div>
							</div>
							</form>
							
							<div class="scroller" style="height: <?php echo $comments_height; ?>;" data-always-visible="1" data-rail-visible1="1">
							<?php  // FETCH comments
								$old_date = '2015-04-01 00:00:00';
								$old_date = date('Y-m-d');
								$dvrs = array(1,2);
								?>
								
								<?php  // FETCH comments
									foreach($user_comments as $comment){
									?>
									
									<!-- NEW FOR SHOWING DVR Begin -->
									<?php 
									//$complaint_id =;
									$previous_dvrs = rtrim(implode(',', $dvrs), ',');
									$new_date = date('Y-m-d H:i:s', strtotime($comment['date']));;
									$dvrq = $this->db->query("SELECT tbl_dvr.*,user.first_name,user.image FROM tbl_dvr
									LEFT JOIN user ON tbl_dvr.fk_engineer_id = user.id
									WHERE tbl_dvr.fk_complaint_id=$complaint_id AND CAST(tbl_dvr.date AS DATE) BETWEEN '$new_date' AND '$old_date'
									AND tbl_dvr.pk_dvr_id NOT IN (".$previous_dvrs.")
									ORDER BY tbl_dvr.date DESC, tbl_dvr.start_time DESC");
									$user_comments_dvr=$dvrq->result_array();
									?>
									<?php  // FETCH comments
									foreach($user_comments_dvr as $commentt){
									?>
									<?php
									$user_image2="noimage.jpg";
									$query="select * from user where `id` ='".$commentt['fk_engineer_id']."'";
									$query_db=$this->db->query($query);
									$userdataa=$query_db->result_array();
									$poster_name=$userdataa[0]['first_name'];
										if(empty($userdataa[0]['image'])){ $user_image2="noimage.jpg"; }
										else { $user_image2	=	$userdataa[0]['id'].".".$userdataa[0]['image'];}
									?>
								
								<ul class="chats">
									<li class="<?php if ($this->session->userdata('userid')==$userdataa[0]['id']) echo "out"; else echo "in"; ?>">
										<img class="avatar" alt="" src="<?php echo base_url();?>usersimages/<?php echo $user_image2;?>">
										<div class="message">
											<span class="arrow">
											</span>
											<a href="javascript:;" class="name">
											<?php echo $poster_name; //Poster Name?> </a>
											<span class="datetime">
											at <?php date_default_timezone_set('Asia/Karachi'); ?>
									 <?php echo date('h:i a', strtotime($commentt['start_time'])); //Time ?>, <?php echo date('d-M-Y', strtotime($commentt['date'])); //Date ?> </span>
											<span class="body">
											<?php echo 'FROM DVR ('.date('h:i a', strtotime($commentt['start_time'])).' to '.date('h:i a', strtotime($commentt['end_time'])).'): '.urldecode($commentt['summery']); ?> </span>
										</div>
									</li>
									</ul>
									<?php array_push($dvrs,$commentt['pk_dvr_id']); } ?>	
									
									<!-- NEW FOR SHOWING DVR ENd -->
									
									
									<?php
									$user_image2="noimage.jpg";
									$query="select * from user where `id` ='".$comment['fk_employee_id']."'";
									$query_db=$this->db->query($query);
									$userdataa=$query_db->result_array();
									$poster_name=$userdataa[0]['first_name'];
										if(empty($userdataa[0]['image']))
										{
											$user_image2="noimage.jpg";
										}
										else
										{
											$user_image2	=	$userdataa[0]['id'].".".$userdataa[0]['image'];
										}
									?>
								
								<ul class="chats">
									<li class="<?php if ($this->session->userdata('userid')==$userdataa[0]['id']) echo "out"; else echo "in"; ?>">
										<img class="avatar" alt="" src="<?php echo base_url();?>usersimages/<?php echo $user_image2;?>">
										<div class="message">
											<span class="arrow">
											</span>
											<a href="javascript:;" class="name">
											<?php echo $poster_name; //Poster Name?> </a>
											<span class="datetime">
											at <?php date_default_timezone_set('Asia/Karachi'); ?>
									 <?php echo date('h:i a', strtotime($comment['date'])); //Time ?>, <?php echo date('d-M-Y', strtotime($comment['date'])); //Date ?> </span>
											<span class="body">
											<?php echo urldecode($comment['comment']); ?> </span>
										</div>
									</li>
									</ul>
									<?php } ?>

									<!-- NEW FOR SHOWING DVR Begin -->
									<?php if (sizeof($user_comments)>=0) {
									//$complaint_id =;
									$previous_dvrs = rtrim(implode(',', $dvrs), ',');
									//$new_date = date('Y-m-d H:i:s', strtotime($comment['date']));;
									$dvrq = $this->db->query("SELECT tbl_dvr.*,user.first_name,user.image FROM tbl_dvr
									LEFT JOIN user ON tbl_dvr.fk_engineer_id = user.id
									WHERE tbl_dvr.fk_complaint_id=$complaint_id
									AND tbl_dvr.pk_dvr_id NOT IN (".$previous_dvrs.")
									ORDER BY tbl_dvr.date DESC, tbl_dvr.start_time DESC");
									$user_comments_dvr=$dvrq->result_array();
									?>
									<?php  // FETCH comments
									foreach($user_comments_dvr as $comment){
									?>
									<?php
									$user_image2="noimage.jpg";
									$query="select * from user where `id` ='".$comment['fk_engineer_id']."'";
									$query_db=$this->db->query($query);
									$userdataa=$query_db->result_array();
									$poster_name=$userdataa[0]['first_name'];
										if(empty($userdataa[0]['image'])){ $user_image2="noimage.jpg"; }
										else { $user_image2	=	$userdataa[0]['id'].".".$userdataa[0]['image'];}
									?>
								
								<ul class="chats">
									<li class="<?php if ($this->session->userdata('userid')==$userdataa[0]['id']) echo "out"; else echo "in"; ?>">
										<img class="avatar" alt="" src="<?php echo base_url();?>usersimages/<?php echo $user_image2;?>">
										<div class="message">
											<span class="arrow">
											</span>
											<a href="javascript:;" class="name">
											<?php echo $poster_name; //Poster Name?> </a>
											<span class="datetime">
											at <?php date_default_timezone_set('Asia/Karachi'); ?>
									 <?php echo date('h:i a', strtotime($comment['start_time'])); //Time ?>, <?php echo date('d-M-Y', strtotime($comment['date'])); //Date ?> </span>
											<span class="body">
											<?php echo 'FROM DVR ('.date('h:i a', strtotime($comment['start_time'])).' to '.date('h:i a', strtotime($comment['end_time'])).'): '.urldecode($comment['summery']); ?> </span>
										</div>
									</li>
									</ul>
									<?php array_push($dvrs,$comment['pk_dvr_id']); }} ?>	
									
									<!-- NEW FOR SHOWING DVR ENd -->
									
								</div>
							
							
							
						</div>
					</div>
					<!-- END PORTLET-->
				

<!-- End Messages Portlet -->	
<!-- Begin Portlet -->
						  <div class="portlet box green-seagreen" id="working_details">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs"></i>Troubleshooting / Working Details
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
									
									<a href="javascript:;" class="remove">
									</a>
								</div>
							</div>
							
							
							
							<div class="portlet-body">
							
							<!-- add new details button-->
							<div class="row">
							  <div class="col-md-6">
								<div class="btn-group">
								<?php /* Button for opening page
								  <a href="<?php echo base_url();?>complaint/add_working_details/<?php echo $this->uri->segment(3); ?>" id="sample_editable_1_new" class="btn green-seagreen"> 
									  Add Working / Troubleshooting Details
									  <i class="fa fa-plus"></i> 
								  </a>
								  */ ?>
								  <!-- button for Modal -->
								  <a href="#" id="sample_editable_1_new" class="btn green-seagreen" data-toggle="modal" data-target="#myModal" > 
									  Add Working / Troubleshooting Details
									  <i class="fa fa-plus"></i> 
								  </a>
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
								   <form action="<?php echo base_url();?>complaint/add_working_details_insert" class="form-horizontal" method="post">
                
									
				
                 
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
                                    <button type="submit" class="btn green-seagreen" onclick="return check_status('<?php echo $get_compalaint_result[0]['status'];  ?>')">Submit</button>
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
							
							
							<!-- add new details -->
							
							<div class="portlet-body flip-scroll">					
								<div class="row">
								  <div class="col-md-12"> 
									<div class="table-scrollable">
									
								<table class="table table-bordered table-striped table-condensed flip-content">
								<thead class="flip-content">
								<tr>
									<th class="date">
										 Date
									</th>
									<th class="time">
										 Time
									</th>
									<th>
										 Action Taken
									</th>
									<th>
										 Result
									</th>
									<th>
										 Analysis
									</th>
								</tr>
								</thead>
								<tbody>
								
								<?php
								$ty22=$this->db->query("select * from tbl_working_details WHERE fk_complaint_id='" . $this->uri->segment(3)."'");
								$rt22=$ty22->result_array();
								$count_working_details = sizeof($rt22);
								if (sizeof($rt22) == "0") {
									//do something
								} else {
									foreach ($rt22 as $get_working_details) {
										?>
										<tr>											
											<td>
												<?php echo date('d-M-Y', strtotime($get_working_details["date"])); ?>
												<?php //echo $get_working_details["date"] ?>
											</td>
											
											<td>
												<?php echo $get_working_details["time"] ?>
											</td>
											
											<td>
												<?php echo urldecode($get_working_details["action_taken"]); ?>
											</td>
											
											<td>
												<?php echo urldecode($get_working_details["result"]); ?>
											</td>
											
											<td>
												<?php echo urldecode($get_working_details["analysis"]); ?>
											</td>
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


<!-- Begin Portlet -->
						  <div class="portlet box yellow-gold" id="qc_dataa">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs"></i>Calibration / Quality Control Data
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
									
									<a href="javascript:;" class="remove">
									</a>
								</div>
							</div>
							
							
							
							<div class="portlet-body">
							
							<!-- add new details button-->
							<div class="row">
							  <div class="col-md-6">
								<div class="btn-group">
								<?php /*
								  <a href="<?php echo base_url();?>complaint/add_qc_data/<?php echo $this->uri->segment(3); ?>" id="sample_editable_1_new" class="btn yellow-gold"> 
									  Add Calibration / Quality Control Data
									  <i class="fa fa-plus"></i> 
								  </a> */ ?>
								  
								  <!-- button for Modal -->
								  <a href="#" id="sample_editable_1_new" class="btn yellow-gold" data-toggle="modal" data-target="#myModal2"> 
									  Add Calibration / Quality Control Data
									  <i class="fa fa-plus"></i> 
								  </a>
								</div>
								
															<!-- Modal Form Begin (z)-->
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
								   <form action="<?php echo base_url();?>complaint/add_qc_data_insert" class="form-horizontal" method="post">

									
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
                                    <button type="submit" class="btn yellow-gold" onclick="return check_status('<?php echo $get_compalaint_result[0]['status'];  ?>')">Submit</button>
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

	<!--  enddddddddddddddddddddddddddddddddddddddd modallllllllllll-->
							  </div>   
							</div>
							<!-- add new details -->
							
							<div class="portlet-body flip-scroll">					
								<div class="row">
								  <div class="col-md-12"> 
									<div class="table-scrollable">
									
								<table class="table table-bordered table-striped table-condensed flip-content">
								<thead class="flip-content">
								<tr>
									<th>
										 Calibration Data
									</th>
									<th>
										 QC Data
									</th>
								</tr>
								</thead>
								<tbody>
								
								<?php
								$ty22=$this->db->query("select * from tbl_qc_data WHERE fk_complaint_id='" . $this->uri->segment(3)."'");
								$rt22=$ty22->result_array();
								if (sizeof($rt22) == "0") {
									//do something
								} else {
									foreach ($rt22 as $get_qc_data) {
										?>
										<tr>											
											<td>
												<?php echo urldecode($get_qc_data["calibration_data"]); ?>
											</td>
											
											<td>
												<?php echo urldecode($get_qc_data["qc_data"]); ?>
											</td>
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
									  $sprf_qu 		= $this->db->query("SELECT * FROM tbl_sprf where `fk_complaint_id` = '".$this->uri->segment(3)."' AND `dc_number` != '0'");
									  $sprf	= $sprf_qu->result_array();
									  if (sizeof($sprf) == "0") 
									  {
										//do somthing  
									  } else {
										  foreach ($sprf as $customers_list) {
											 
											  ?>
                                      <tr>

                                        <td>
                                        <?php  
										 $part_qu=$this->db->query("select * from tbl_parts where pk_part_id='".$customers_list["fk_part_id"]."'");
										  $part=$part_qu->result_array();
										  echo $part[0]["part_number"];
										 ?>
                                         </td>

                                        <td>
                                        <?php  
										  echo urldecode($part[0]["description"]);
										 ?>
                                        </td>

                                        <td>
                                        <?php 
											echo $customers_list["dc_number"];
										?>
                                        </td>

                                        <td>
                                        <?php echo $customers_list["quantity"]; ?>
                                        </td>

                                        <td>
                                        <?php echo $customers_list["quantity"]*$part[0]["unit_price"]; ?>
                                        </td>

                                        <td>
                                        <?php if($customers_list["part_source"]=='stock') { echo 'Stock'; } else {
											 	$client_qu=$this->db->query("select * from tbl_clients where pk_client_id='".$customers_list["source_id"]."'");
												$client=$client_qu->result_array();
												echo $client[0]["client_name"].' - ';
												// for client city
												$city_qu=$this->db->query("select * from tbl_cities where pk_city_id='".$client[0]["fk_city_id"]."'");
												$city=$city_qu->result_array();
												echo $city[0]["city_name"];
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
          
      <form action="<?php echo base_url();?>complaint/update_ts_report" class="form-horizontal" method="post" enctype="multipart/form-data">     
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
            
          <div class="portlet box red">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Other Details</div>

            </div>

            <div class="portlet-body">

              <div class="portlet-body flip-scroll">
                <div class="row">
                          <div class="col-md-12 ">
						  
							
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
									<input type="text" class="form-control timepicker1 timepicker timepicker-no-seconds" name="reporting_time" value="<?php echo $get_compalaint_result[0]['reporting_time'] ; ?>">
								</div>
							</div>
							
							<div class="form-group" style="display:none;">
							<label class="col-md-4 control-label">PS Name*</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="ps_name" value="<?php echo $get_compalaint_result[0]['ps_name'] ; ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Solution Date*</label>
							
								<div class="col-md-4">
									<input type="text" class="datepicker2 form-control" name="solution_date" value="<?php 
									 	if($get_compalaint_result[0]['solution_date']!='0000-00-00 00:00:00')
										 {
										 	echo date('d-M-Y', strtotime($get_compalaint_result[0]['solution_date']));  
										 }
										 
									 ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label ">Solution Time*</label>
								<div class="col-md-4">
									<input type="text" class="form-control timepicker1 timepicker timepicker-no-seconds" name="solution_time" value="<?php echo $get_compalaint_result[0]['solution_time'] ; ?>">
								</div>
							</div>
							
                            <div class="form-group">
							<label class="col-md-4 control-label">Actual Cause of Problem*</label>
														
								<div class="col-md-4">								
									<!--<select id="problem_cause" name="problem_cause" class="form-control  ">
									<option value="">--Choose--</option>
									<option value="Probe Problem"
									<?php if($get_compalaint_result[0]['problem_cause']=="Probe Problem"){?> selected="selected"<?php }?>
									>Probe Problem</option>
									<option value="Calibration Problem"
									<?php if($get_compalaint_result[0]['problem_cause']=="Calibration Problem"){?> selected="selected"<?php }?>
									>Calibration Problem</option>
									</select>-->
                                    <input type="text" class="form-control" name="problem_cause" value="<?php echo $get_compalaint_result[0]['problem_cause'] ; ?>">								
								</div>
                            </div>
							
							<div class="form-group">
							<label class="col-md-4 control-label ">Name of Customer Signing Complaint Form*</label>
								<div class="col-md-4">
									<input type="text" class="form-control customer_signing_complaint_form" name="customer_signing_complaint_form" 
                                    value="<?php echo urldecode($get_compalaint_result[0]['customer_signing_complaint_form']) ; ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label ">Mobile of Customer Signing Complaint Form*</label>
								<div class="col-md-4">
									<input type="text" class="form-control customer_mobile_signing_complaint_form" name="customer_mobile_signing_complaint_form" 
                                    value="<?php echo urldecode($get_compalaint_result[0]['customer_mobile_signing_complaint_form']) ; ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label ">Designation of Customer Signing Complaint Form*</label>
								<div class="col-md-4">
									<input type="text" class="form-control customer_designation_signing_complaint_form" name="customer_designation_signing_complaint_form" 
                                    value="<?php echo urldecode($get_compalaint_result[0]['customer_designation_signing_complaint_form']) ; ?>">
								</div>
							</div>
							
							
							
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
                            <?php if($get_compalaint_result[0]['status']=='Pending' || $get_compalaint_result[0]['status']=='Shifted' || $get_compalaint_result[0]['status']=='SPRF Approved' || $get_compalaint_result[0]['status']=='Pending (BB)' ) { ?>
                            <span class="btn blue fileinput-button">
								<input type="file" name="uploadFile" multiple="" id="upload_file">
							</span>
							<?php } ?>
                            <p>
                            <?php
								if($get_compalaint_result[0]['image']=="")
								{
									$user_image3="noimage.jpg";
								}
								else
								{
									$user_image3	=	$get_compalaint_result[0]['pk_complaint_id'].'.'.$get_compalaint_result[0]['image'];
								}
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
							if(upload_file=='')
							{
								alert('No file Uploaded for TS Report.');
								return false;
							}
							if(customer_signing_complaint_form=='')
							{
								alert('Fill Customer Signing in Complaint form.');
								return false;
							}
							if(customer_mobile_signing_complaint_form=='')
							{
								alert('Fill Customer Mobile Signing in Complaint form.');
								return false;
							}
							if(customer_designation_signing_complaint_form=='')
							{
								alert('Fill Customer Designation Signing in Complaint form.');
								return false;
							}
							var problem_cause = '<?php echo $get_compalaint_result[0]['problem_cause'];?>';
							if(problem_cause=='')
							{
								alert('Actual cause of the problem must be saved.');
								return false;
							}
							///////////// status check
							if(status!='Pending' && status!='Pending (BB)' && status!='Shifted'  && status!='SPRF Approved')
							{
								alert('Report has already been submitted');
								return false;
							}
							//var upload_file = $('#upload_file').val();
							
							else
							{
							var response = confirm('Want to submit your report for approval? You will no longer be able make changes to this report. Please make sure that you have saved the report before submitting. No changes will be saved if you will submit it without saving.');
							if(response==false)
							{
								return false;
							}
							else
							{
								formdata =
								{
									complaint_id:complaint_id
								}
								$.ajax({
									data:formdata,
									url:"<?php echo base_url();?>complaint/status_pending_sv_ajax",
									type:'POST',
									success:function(msg)
									{
										$('#show_message').html(msg);
										$('#complaint_status').html('Pending SV');
										
									}
									});
									//window.location.href('<?php echo base_url();?>complaint/technical_service_pvr?status=Pending');
									window.location.replace('<?php echo base_url();?>complaint/technical_service_pvr/<?php echo $get_compalaint_result[0]['pk_complaint_id'];?>');
									return false;
							}
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
        </div>
      </div>
      <!-- END PAGE CONTENT--> 

  <!-- END CONTENT --> 

</div>
<script type="text/javascript">
                $('.timepicker1').timepicker({
                    minuteStep: 5,
                    showInputs: false,
                    disableFocus: true,
                    defaultTime:false
                });
                
                $('.timepicker2').timepicker({
                    minuteStep: 5,
                    showInputs: false,
                    disableFocus: true,
                    defaultTime:false
                });
              </script>

<!-- END CONTAINER --> 
<?php $this->load->view('footer');?>