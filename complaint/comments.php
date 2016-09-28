<?php $this->load->view('header');?>
<style type="text/css">
.cke_dialog{
	left: 528.5px;
    position: absolute !important;
    top: 47.5px;
    z-index: 50000 !important;
	}
</style>
<?php
	$complaint_id	=	$this->uri->segment(3);
	$query="select * from tbl_complaints where `pk_complaint_id` ='".$complaint_id."'";
	$query_db=$this->db->query($query);
	$user_complaint=$query_db->result_array();
	$query="select * from tbl_comments where `fk_complaint_id` ='".$complaint_id."' ORDER BY `pk_comment_id` DESC";
	$query_db=$this->db->query($query);
	$user_comments=$query_db->result_array();
?>

			
				<h3 class="page-title">
				<?php $inc = 1; 
                echo $user_complaint[0]['ts_number'];
				?>
                
				
                </h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo site_url(); // Home ?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="<?php echo "#" // Complaints or PMs According to userrole ?>">Complaints</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							Comments
						</li>
					</ul>
				<div class="page-toolbar">
						<div class="btn-group pull-right">
							<a class="btn btn-fit-height blue" data-toggle="modal" href="#basic"> Add New Comment </a>
                            <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Add New Comment</h4>
											</div>

                                           <form action="<?php echo site_url('complaint/add_comment'); // My Controller?>" method="post" class="form-horizontal form-bordered">

                                            <div class="modal-body">
                                                <div class="form-body">
                                                    <div class="form-group last">
                                                        <!--<label class="control-label col-md-3">CKEditor</label>-->
                                                        <div class="col-md-12">
                                                            <textarea class="ckeditor form-control" name="comment" rows="6"></textarea>
                                                            <input type="hidden" name="fk_complaint_id" value="<?php echo $this->uri->segment(3); //complaint id?>" />
                                                        </div>
                                                    </div>
                                                </div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn default" data-dismiss="modal">Close</button>
												<button type="submit" name="submit" class="btn blue">Post Comment</button>
											</div>
                                            </form>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
							
                            
						</div>
					</div>	
                    
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="timeline">
					<!-- TIMELINE ITEM -->
					
					<!-- 9th November BEGIN -->
					<?php  // Adding on 9th November
								$old_date = '2015-04-01 00:00:00';
								$old_date = date('Y-m-d');
								$dvrs = array(1,2);
					?>
                    <!-- 9th November End -->
					
                    <?php  // FETCH comments
					
					foreach($user_comments as $comment){
					//print_r($comments);
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
									
									<div class="timeline-item">
						<div class="timeline-badge">
							<img style="height:80px !important" class="timeline-badge-userpic" src="<?php echo base_url();?>usersimages/<?php echo $user_image2;?>">
						</div>
						<div class="timeline-body">
							<div class="timeline-body-arrow">
							</div>
							<div class="timeline-body-head">
								<div class="timeline-body-head-caption">
									<a href="javascript:;" class="timeline-body-title <?php 
									if($userdataa[0]['userrole'] == 'Admin' ){ echo "font-green-meadow"; } 
									if($userdataa[0]['userrole'] == 'Supervisor' ){ echo "font-blue"; } 
									if($userdataa[0]['userrole'] == 'FSE' || $userdataa[0]['userrole'] == 'Salesman'){ echo "font-yellow"; } 
									?>">
									
                                    
                                    
									<?php echo $poster_name; //Poster Name?>
                                    
                                    
                                    </a>
									<span class="timeline-body-time font-grey-cascade">said at 
									 <?php date_default_timezone_set('Asia/Karachi'); ?>
									 <?php echo date('h:i a', strtotime($commentt['start_time'])); //Time ?>, <?php echo date('d-M-Y', strtotime($commentt['date'])); //Date ?>
									</span>
								</div>
								
							</div>
							<div class="timeline-body-content">
								<span class="font-grey-cascade">
								<?php echo 'FROM DVR ('.date('h:i a', strtotime($commentt['start_time'])).' to '.date('h:i a', strtotime($commentt['end_time'])).'): '.urldecode($commentt['summery']); ?> </span>
							</div>
						</div>
					</div>
					
									
									<?php array_push($dvrs,$commentt['pk_dvr_id']); } ?>
					
					
					<!-- NEW FOR SHOWING DVR END -->
					
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
					<div class="timeline-item">
						<div class="timeline-badge">
							<img style="height:80px !important" class="timeline-badge-userpic" src="<?php echo base_url();?>usersimages/<?php echo $user_image2;?>">
						</div>
						<div class="timeline-body">
							<div class="timeline-body-arrow">
							</div>
							<div class="timeline-body-head">
								<div class="timeline-body-head-caption">
									<a href="javascript:;" class="timeline-body-title <?php 
									if($userdataa[0]['userrole'] == 'Admin' ){ echo "font-green-meadow"; } 
									if($userdataa[0]['userrole'] == 'Supervisor' ){ echo "font-blue"; } 
									if($userdataa[0]['userrole'] == 'FSE' || $userdataa[0]['userrole'] == 'Salesman'){ echo "font-yellow"; } 
									?>">
									
                                    
                                    
									<?php echo $poster_name; //Poster Name?>
                                    
                                    
                                    </a>
									<span class="timeline-body-time font-grey-cascade">said at 
									 <?php date_default_timezone_set('Asia/Karachi'); ?>
									 <?php echo date('h:i a', strtotime($comment['date'])); //Time ?>, <?php echo date('d-M-Y', strtotime($comment['date'])); //Date ?>
									</span>
								</div>
								
							</div>
							<div class="timeline-body-content">
								<span class="font-grey-cascade">
								<?php echo urldecode($comment['comment']); ?> </span>
							</div>
						</div>
					</div>
					<?php } ?>
					<!-- END TIMELINE ITEM -->
					
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
								<div class="timeline-item">
						<div class="timeline-badge">
							<img style="height:80px !important" class="timeline-badge-userpic" src="<?php echo base_url();?>usersimages/<?php echo $user_image2;?>">
						</div>
						<div class="timeline-body">
							<div class="timeline-body-arrow">
							</div>
							<div class="timeline-body-head">
								<div class="timeline-body-head-caption">
									<a href="javascript:;" class="timeline-body-title <?php 
									if($userdataa[0]['userrole'] == 'Admin' ){ echo "font-green-meadow"; } 
									if($userdataa[0]['userrole'] == 'Supervisor' ){ echo "font-blue"; } 
									if($userdataa[0]['userrole'] == 'FSE' || $userdataa[0]['userrole'] == 'Salesman'){ echo "font-yellow"; } 
									?>">
									
                                    
                                    
									<?php echo $poster_name; //Poster Name?>
                                    
                                    
                                    </a>
									<span class="timeline-body-time font-grey-cascade">said at 
									 <?php date_default_timezone_set('Asia/Karachi'); ?>
									 <?php echo date('h:i a', strtotime($comment['start_time'])); //Time ?>, <?php echo date('d-M-Y', strtotime($comment['date'])); //Date ?>
									</span>
								</div>
								
							</div>
							<div class="timeline-body-content">
								<span class="font-grey-cascade">
								<?php echo 'FROM DVR ('.date('h:i a', strtotime($comment['start_time'])).' to '.date('h:i a', strtotime($comment['end_time'])).'): '.urldecode($comment['summery']); ?> </span>
							</div>
						</div>
					</div>	
									
									
									<?php array_push($dvrs,$comment['pk_dvr_id']); }} ?>
									<!-- NEW FOR SHOWING DVR END -->
				</div>
				<!-- END PAGE CONTENT-->
			</div>
		</div>	

<?php $this->load->view('footer');?>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/timeline.js" type="text/javascript"></script>

<script>
jQuery(document).ready(function() {       
Timeline.init(); // init timeline page
});

</script>