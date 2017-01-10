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
$user_id = 0;
if ($this->session->userdata('userrole') != 'Admin' && $this->session->userdata('userrole') != 'secratery') 
	$user_id = $this->session->userdata('userid');
else 
	if (isset($_GET['user'])) $user_id = $_GET['user'];

$query = "SELECT * FROM tbl_report_comments ORDER BY `pk_report_comments_id` DESC";
if ($user_id != 0)
	$query="select * from tbl_report_comments where `report_user` ='".$user_id."' AND fk_project_id = '0' ORDER BY `pk_report_comments_id` DESC";
	$query_db=$this->db->query($query);
	$user_comments=$query_db->result_array();
?>

			
				<h3 class="page-title">
				Report Comments
				<?php $inc = 1; 
                //echo $user_complaint[0]['ts_number'];
				?>
                
				
                </h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							Home
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							Employee Report
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							Report Comments
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

                                           <form action="<?php echo site_url('sys/add_report_comment'); // My Controller?>" method="post" class="form-horizontal form-bordered">

                                            <div class="modal-body">
                                                <div class="form-body">
                                                    <div class="form-group last">
                                                        <!--<label class="control-label col-md-3">CKEditor</label>-->
                                                        <div class="col-md-12">
                                                            <textarea class="ckeditor form-control" name="comment" rows="6"></textarea>
                                                            <input type="hidden" name="report_user" value="<?php echo $user_id;?>" />
															<input type="hidden" name = "redirect_url" value = "<?php echo current_url();
															if(isset($_GET['user']))
															echo '?'.$_SERVER['QUERY_STRING']; ?>" />
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
<?php
if ($this->session->userdata('userrole') == 'Admin' || $this->session->userdata('userrole') == 'secratery') {
?>
<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Report Comments </span>
								<span class="caption-helper">Monthly Report Comments of Individual</span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>sys/report_comments">
								<?php if ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery'){ ?>	
                                <div class="col-md-4">
                            		<div class="form-group">
                            			
                                        <select name="user" id="user" class="form-control" required>
                                            <option value="">--Select employee--</option>
											<?php 
											$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status = '0' AND userrole NOT IN ('Admin','secratery') ORDER BY  `fk_office_id` ,  `userrole` ASC ");
											if ($this->session->userdata('userrole')=="Supervisor")
												$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status = '0' AND userrole='FSE' AND fk_office_id='".$this->session->userdata('territory')."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['id'];?>" <?php if(isset($_GET['user']) && $_GET['user']==$val['id']){
												echo 'selected="selected"';}?>>
													<?php echo $val['first_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>
								<?php } ?>
								
                                <div class="col-md-1">
                            		<div class="form-group">
                                            <input type="submit"  class="btn btn-default purple-seance" value="Search" >
                                    </div>
                                </div>
                          		</form>
                           </div>	
						</div>
					</div>
<?php
} if ($user_id != 0) {
?>
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
					
					<?php
					$user_image2="noimage.jpg";
					$query="select * from user where `id` ='".$comment['fk_user_id']."'";
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
								<?php 
								$t = explode(",",$comment['report_comments']);
								if ($t[0]=="submitted") echo "I have saved my monthly report for ".$t[1].". <a target='_blank' href='".base_url()."sys/view_report?report=".$t[2]."'>Click Here</a> to view.";
								else echo urldecode($comment['report_comments']); ?> </span>
							</div>
						</div>
					</div>
					<?php } ?>
					<!-- END TIMELINE ITEM -->
					
				</div>
<?php } ?>
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