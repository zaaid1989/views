<?php 
      $dbres = $this->db->query("SELECT * FROM user  WHERE `id` = '".$this->session->userdata('userid')."'");
	  $userdataheader=$dbres->result_array();
	  //to calculate Unread Messages
	  $inb_qu="SELECT * FROM messages  WHERE `read` = '0' AND `to` = '".$this->session->userdata('userid')."' AND trashed='0'";
	  //echo $inb_qu;exit;
	  $dbres2 = $this->db->query($inb_qu);
	  $unread=$dbres2->num_rows();
	  //echo $userdataheader[0]['id'];exit;
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>PMA | Pakistan Microbiological Associates </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>



<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PLUGIN STYLES -->
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>newtheme/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- END PLUGIN STYLES -->

<!-- BEGIN THEME GLOBAL STYLES -->
<link href="<?php echo base_url();?>newtheme/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>newtheme/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="<?php echo base_url();?>newtheme/assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>newtheme/assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="<?php echo base_url();?>newtheme/assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/layout/img/favicon.gif" type="image/gif"/>




<?php /*?>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo base_url();?>templates/admin/fonts/fonts_googleapi.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/admin/pages/css/inbox.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<!--adding datetables-->
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>

<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?php echo base_url();?>assets/global/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
<!--<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>-->
<link href="<?php echo base_url();?>assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->

<!--<link href="<?php echo base_url();?>assets/global/plugins/select2new/select2.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/global/plugins/select2new/select2-bootstrap.min.css" rel="stylesheet" type="text/css"/>-->

<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"/>

<!-- BEGIN PAGE STYLES -->
<link href="<?php echo base_url();?>assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url();?>assets/global/css/components.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/> <?php // For changing theme CSS ?>
<link href="<?php echo base_url();?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>

<!--File input in change avatar-->
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/global/plugins/pace/themes/pace-theme-flash.css" rel="stylesheet" type="text/css"/>
<!--select-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>-->



<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/layout/img/favicon.gif" type="image/gif"/>
<link href="<?php echo base_url(); ?>assets/admin/pages/css/timeline.css" rel="stylesheet" type="text/css"/><?php */?>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->


<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo" <?php //if ($this->session->userdata('userrole')!='Admin') echo 'oncontextmenu="return false;"'; ?>><!---***** oncontextmenu For disabling inspect element ******--->
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?php echo base_url();?>">
			<img src="<?php echo base_url();?>assets/admin/layout/img/logo3.png" alt="logo" class="logo-default custom-logo-class custom-mobile-class"/>
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
            
		</div>
        <style>
		.custom-logo-class{
		 width: 185px;
		 margin-top:21px !important;	
		}
		@media (max-width: 580px) {
		
		.custom-mobile-class{
		 max-width: 70% !important;
		}
		}
		</style>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU --> 
        <div class="page-top">
		<div class="top-menu">
            <ul class="nav navbar-nav pull-right">
            <li class="separator hide"> </li>
				<!-- BEGIN NOTIFICATION DROPDOWN -->
				
				<!-- END NOTIFICATION DROPDOWN -->
				<!-- BEGIN INBOX DROPDOWN -->
				<!--************** MESSAGES INBOX **************-->
				<!--<li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="icon-envelope-open"></i>
                    <?php if( $unread!=0){?>	
					<span class="badge badge-default message_noti_up_badge">
						<span class="message_noti_up"><?php echo $unread;?></span> 
                    </span>
                    <?php }?>
					</a>
					<ul class="dropdown-menu">
						<li>
							<p>
								 You have <?php echo $unread;?> new messages
							</p>
						</li>
						<li>
							<ul class="dropdown-menu-list scroller" style="height: 250px;">
								<?php
                                $inb_qu="SELECT * FROM messages  WHERE  `to` = '".$this->session->userdata('userid')."' AND trashed='0' limit 0, 5";
								//echo $inb_qu;exit;
								$dbres22 = $this->db->query($inb_qu);
								$notification_messages=$dbres22->result_array();
								foreach($notification_messages as $noti_msg)
								{
								?>
                                <li>
									<a href="<?php echo base_url();?>inbox/message/<?php echo $noti_msg['id']?>">
                                    <?php 
										  $dbres222 = $this->db->query("SELECT * FROM user  WHERE `id` = '".$noti_msg['from']."'");
										  $sender_info=$dbres222->result_array();
									?>
									<span class="photo">
                                    <?php
                                    	if(empty($sender_info[0]['image']))
										{
											$user_image="noimage.jpg";
										}
										else
										{
											$user_image	=	$sender_info[0]['id'].".".$sender_info[0]['image'];
										}
									?>
									<img src="<?php echo base_url();?>usersimages/<?php echo $user_image;?>" alt=""/>
									</span>
									<span class="subject">
									<span class="from">
									<?php echo $sender_info[0]['first_name']?>  </span>
									<span class="time">
									<?php echo date('h:i a', strtotime($noti_msg["time"]));?> </span>
									</span>
									<span class="message">
									<?php echo substr($noti_msg['text'],0,60);?>... </span>
									</a>
								</li>
                                <?php }?>
								
							</ul>
						</li>
						<li class="external">
							<a href="<?php echo base_url();?>inbox/index/0">
							See all messages <i class="m-icon-swapright"></i>
							</a>
						</li>
					</ul>
				</li>-->
				<!--************** MESSAGES INBOX **************-->
				<!-- END INBOX DROPDOWN -->
				<!-- BEGIN TODO DROPDOWN -->
				<!--<li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="icon-calendar"></i>
					<span class="badge badge-default">
					3 </span>
					</a>
					<ul class="dropdown-menu extended tasks">
						<li>
							<p>
								 You have 12 pending tasks
							</p>
						</li>
						<li>
							<ul class="dropdown-menu-list scroller" style="height: 250px;">
								<li>
									<a href="#">
									<span class="task">
									<span class="desc">
									New release v1.2 </span>
									<span class="percent">
									30% </span>
									</span>
									<span class="progress">
									<span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">
									40% Complete </span>
									</span>
									</span>
									</a>
								</li>
								<li>
									<a href="#">
									<span class="task">
									<span class="desc">
									Application deployment </span>
									<span class="percent">
									65% </span>
									</span>
									<span class="progress progress-striped">
									<span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">
									65% Complete </span>
									</span>
									</span>
									</a>
								</li>
								<li>
									<a href="#">
									<span class="task">
									<span class="desc">
									Mobile app release </span>
									<span class="percent">
									98% </span>
									</span>
									<span class="progress">
									<span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">
									98% Complete </span>
									</span>
									</span>
									</a>
								</li>
								<li>
									<a href="#">
									<span class="task">
									<span class="desc">
									Database migration </span>
									<span class="percent">
									10% </span>
									</span>
									<span class="progress progress-striped">
									<span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">
									10% Complete </span>
									</span>
									</span>
									</a>
								</li>
								<li>
									<a href="#">
									<span class="task">
									<span class="desc">
									Web server upgrade </span>
									<span class="percent">
									58% </span>
									</span>
									<span class="progress progress-striped">
									<span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">
									58% Complete </span>
									</span>
									</span>
									</a>
								</li>
								<li>
									<a href="#">
									<span class="task">
									<span class="desc">
									Mobile development </span>
									<span class="percent">
									85% </span>
									</span>
									<span class="progress progress-striped">
									<span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">
									85% Complete </span>
									</span>
									</span>
									</a>
								</li>
								<li>
									<a href="#">
									<span class="task">
									<span class="desc">
									New UI release </span>
									<span class="percent">
									18% </span>
									</span>
									<span class="progress progress-striped">
									<span style="width: 18%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">
									18% Complete </span>
									</span>
									</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="external">
							<a href="#">
							See all tasks <i class="m-icon-swapright"></i>
							</a>
						</li>
					</ul>
				</li>-->
				<!-- END TODO DROPDOWN -->
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown dropdown-user dropdown-dark">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <?php
						if(empty($userdataheader[0]['image']))
						{
							$user_image2="noimage.jpg";
						}
						else
						{
							$user_image2	=	$userdataheader[0]['id'].".".$userdataheader[0]['image'];
						}
					?>
                    <span class="username username-hide-on-mobile">
					<?php echo $userdataheader[0]['first_name'];?> </span>
					<img alt="" class="img-circle hide1" src="<?php echo base_url();?>usersimages/<?php echo $user_image2;?>"/>
					
					<!--<i class="fa fa-angle-down"></i>-->
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="<?php echo base_url();?>profile">
							<i class="icon-user"></i> My Profile </a>
						</li>
						<!--<li>
							<a href="page_calendar.html">
							<i class="icon-calendar"></i> My Calendar </a>
						</li>-->
						<!--
						<li>
							<a href="<?php echo base_url();?>inbox/index/0">
							<i class="icon-envelope-open"></i> My Inbox 
                            <?php if( $unread!=0){?>
                            <span class="badge badge-danger  message_noti_up_badge">
                                <span class="message_noti_up">
									<?php echo $unread;?>
                                </span> 
                            </span>
                            <?php }?>
							</a>
						</li>
						-->
						<!--<li>
							<a href="#">
							<i class="icon-rocket"></i> My Tasks <span class="badge badge-success">
							7 </span>
							</a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="extra_lock.html">
							<i class="icon-lock"></i> Lock Screen </a>
						</li>-->
						<li>
							<a href="<?php echo base_url();?>site/logout">
							<i class="icon-key"></i> Log Out </a>
						</li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
				
			</ul>
		</div>
        
		<!-- END TOP NAVIGATION MENU -->
        </div>
		<?php if($this->session->userdata('userid')=='15') {?>
        <div style="float:right; margin:5px 20px 0 0;">      
            <select class="form-control" onChange="change_session_and_user_office_in_db(this.value)">
            	<option value="2" <?php if($this->session->userdata('territory')=='2') {?> selected <?php }?>>Lahore Office</option>
                <option value="4" <?php if($this->session->userdata('territory')=='4') {?> selected <?php }?>>Multan Office</option>
            </select>
            <script>
			function change_session_and_user_office_in_db(office_id)
			{
				window.location.href='<?php echo site_url()?>login/delte_session/'+office_id+'';
			}
			</script>
        </div>
        <?php }?>
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<div class="sidebar-toggler">
					</div>
				</li>
				<li class="start  <?php if($this->uri->segment(1)=='' && $this->uri->segment(2)==''){ echo 'active open';}?>">
					<a href="<?php echo base_url();?>">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					<span class="arrow open"></span>
					</a>
				</li>
                 <?php 
$this->load->model("complaint_model");
$obj=new Complaint_model();
$uri = $this->uri->segment(2);


$admin = false;
$secratery = false;
$supervisor = false;
$salesman = false;
$fse = false;
if ($this->session->userdata('userrole')=='Admin') $admin = true;
if ($this->session->userdata('userrole')=='secratery') $secratery = true;
if ($this->session->userdata('userrole')=='Supervisor') $supervisor = true;
if ($this->session->userdata('userrole')=='FSE') $fse = true;
if ($this->session->userdata('userrole')=='Salesman') $salesman = true;

$menu_badge = array();

$dc_new 			= false; /// dc visible to director supervisor 53 if condition for supervisor (with territory) 
$leave_new 			= false; /// all_leaves visible to fse supervisor salesman 1
$temp_leaves_red	= 0; // submitted_leaves, fse supervisor salesman 6
$temp_leaves_zed 	= 0; // submitted_leaves, fse supervisor salesman 6
$director_pc 		= 0; // director_view_complaints, admin stcoadmin 39
$director_sprfc 	= 0; // director_view_complaints, admin stcoadmin 39
$director_prc 		= 0; // view_half_complaints, admin stcoadmin 38
$engineer_pc 		= 0; // engineer_view_complaints, fse supervisor 35
$engineer_ppm 		= 0; // engineer_view_pm, fse supervisor 42
$engineer_pvpm 		= 0; // engineer_view_pm, fse supervisor 42
$supervisor_pc		= 0; // supervisor_view_complaints, supervisor 30
$supervisor_pvc 	= 0; // supervisor_view_complaints, supervisor 30
$supervisor_sprfc 	= 0; // pending_sprf, supervisor, admin 54 will require if condition for supervisor (with territory) 
$supervisor_ppm 	= 0; // supervisor_pm, supervisor 33
$supervisor_pvpm 	= 0; // supervisor_pm, supervisor 33
$leaves_pending 	= 0; // pending_leaves, admin stcoadmin 2
$fines_pending 		= 0; // all_fines, all users 62
$strategy_pending   = 0; // pending_business_data, admin 99

// initialize repeated menu_badge indexes with blank string so you can use concat, (used repeatedly in above comments eg 33)
$menu_badge[33] = '';
$menu_badge[30] = '';
$menu_badge[42] = '';
$menu_badge[39] = '';
$menu_badge[6] = '';


if ($admin || $supervisor) {
$query2 = $this->db->query("select * from tbl_sprf where dc_number !='0' AND dc_viewed ='0'");
$amount_count = $query2->result_array();
$pending_v	=	sizeof($amount_count);
if  ($pending_v>0) {
	$dc_new = true;
	$menu_badge[53] = '<span class="badge badge-roundless badge-warning bg-green">NEW</span>';
}}


if ($fse || $supervisor || $salesman) {
$query2 		 = $this->db->query("select * from tbl_leaves where fk_employee_id='".$this->session->userdata('userid')."' AND viewed ='0'");
$amount_count = $query2->result_array();
$pending_v	=	sizeof($amount_count);
if  ($pending_v>0) {
	$leave_new = true;
	$menu_badge[1] = '<span class="badge badge-roundless badge-warning bg-purple-seance">NEW</span>';
}}

if ($fse || $supervisor || $salesman) {
$query2 		 = $this->db->query("select * from tbl_temporary_leaves where `fk_employee_id`='".$this->session->userdata('userid')."' AND `status`='1' AND `viewed` ='0'");
$amount_count = $query2->result_array();
$pending_v	=	sizeof($amount_count);
if  ($pending_v>0) {
	$temp_leaves_zed = $pending_v;
	$menu_badge[6] .= '<span class="badge badge-roundless badge-warning bg-yellow-zed">'.$temp_leaves_zed.'</span>';
}}

if ($fse || $supervisor || $salesman) {
$query2 		 = $this->db->query("select * from tbl_temporary_leaves where `fk_employee_id`='".$this->session->userdata('userid')."' AND `status`='0'");
$amount_count = $query2->result_array();
$pending_v	=	sizeof($amount_count);
if  ($pending_v>0) {
	$temp_leaves_red = $pending_v;
	$menu_badge[6] .= '<span class="badge badge-roundless badge-warning bg-red-thunderbird">'.$temp_leaves_red.'</span>';
}}

if ($admin || $secratery) {
$query2 		 = $this->db->query("select * from tbl_complaints where status = 'Pending SPRF' AND complaint_nature='complaint'");
$amount_count = $query2->result_array();
$pending_v	=	sizeof($amount_count);
if  ($pending_v>0) {
	$director_sprfc = $pending_v;
	$menu_badge[39] .= '<span class="badge badge-roundless badge-warning bg-purple-seance">'.$director_sprfc.'</span>';
}}

if ($admin ) {
$query2 		 = $this->db->query("SELECT * FROM tbl_project_strategy where strategy_status='0'");
$amount_count = $query2->result_array();
$pending_v	=	sizeof($amount_count);
if  ($pending_v>0) {
	$strategy_pending = $pending_v;
	$menu_badge[99] = '<span class="badge badge-roundless badge-warning bg-purple-seance">'.$strategy_pending.'</span>';
}}

if ($admin || $secratery) {
$query2 		 = $this->db->query("select * from tbl_complaints where status != 'Pending Verification' AND status != 'Closed' AND status != 'Pending SPRF' AND status != 'Pending Registration' AND complaint_nature='complaint'");
$amount_count = $query2->result_array();
$pending_v	=	sizeof($amount_count);
if  ($pending_v>0) {
	$director_pc = $pending_v;
	$menu_badge[39] .= '<span class="badge badge-roundless badge-warning bg-red-thunderbird">'.$director_pc.'</span>';
}}

if ($admin || $secratery) {
$query2 		 = $this->db->query("select * from tbl_complaints where status = 'Pending Registration'");
$amount_count = $query2->result_array();
$pending_c	=	sizeof($amount_count);
if  ($pending_c>0) {
	$director_prc = $pending_c;
	$menu_badge[38] = '<span class="badge badge-roundless badge-warning bg-yellow">'.$director_prc.'</span>';
}}

if ($fse || $supervisor ) {
$query2 		 = $this->db->query("select * from tbl_complaints where status != 'Pending Verification' AND status != 'Closed'  AND complaint_nature='complaint' AND assign_to='".$this->session->userdata('userid')."'");
$amount_count = $query2->result_array();
$pending_v	=	sizeof($amount_count);
if  ($pending_v>0) {
	$engineer_pc = $pending_v;
	$menu_badge[35] = '<span class="badge badge-roundless badge-warning bg-red-thunderbird">'.$engineer_pc.'</span>';
}}

if ($fse || $supervisor ) {
$query2 		 = $this->db->query("select * from tbl_complaints where status != 'Pending Verification' AND status != 'Completed'  AND complaint_nature='PM' AND assign_to='".$this->session->userdata('userid')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0) {
								$engineer_ppm = $pending_v;
							$menu_badge[42] .= '<span class="badge badge-roundless badge-warning bg-red-thunderbird">'.$engineer_ppm.'</span>';
}}

if ($fse || $supervisor ) {
$query2 		 = $this->db->query("select * from tbl_complaints where status = 'Pending Verification'  AND complaint_nature='PM' AND assign_to='".$this->session->userdata('userid')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0) {
								$engineer_pvpm = $pending_v;
							$menu_badge[42] .= '<span class="badge badge-roundless badge-warning ">'.$engineer_pvpm.'</span>';
}}

if ($supervisor ) {							
$query2 		 = $this->db->query("select * from tbl_complaints where status != 'Pending Verification' AND status != 'Pending Registration' AND status != 'Closed'  AND complaint_nature='complaint' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0) {
								$supervisor_pc = $pending_v;
							$menu_badge[30] .= '<span class="badge badge-roundless badge-warning bg-red-thunderbird">'.$supervisor_pc.'</span>';
}}
							
if ($supervisor ) {								
$query2 		 = $this->db->query("select * from tbl_complaints where status = 'Pending Verification' AND complaint_nature='complaint' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0) {
								$supervisor_pvc = $pending_v;
							$menu_badge[30] .= '<span class="badge badge-roundless badge-warning">'.$supervisor_pvc.'</span>';
}}

if ($supervisor || $admin ) {								
$query 		 = "select * from tbl_complaints where status = 'Pending SPRF' AND complaint_nature='complaint'";
if ($supervisor)			$query 		 .=	" AND fk_office_id='".$this->session->userdata('territory')."'";
							$query2 		 = $this->db->query($query);
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0) {
								$supervisor_sprfc = $pending_v;
							$menu_badge[54] = '<span class="badge badge-roundless badge-warning bg-purple-seance">'.$supervisor_sprfc.'</span>';
}}

if ($supervisor ) {								
$query2 		 = $this->db->query("select * from tbl_complaints where status != 'Pending Verification' AND status != 'Completed'  AND complaint_nature='PM' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0) {
								$supervisor_ppm = $pending_v;
							$menu_badge[33] .= '<span class="badge badge-roundless badge-warning bg-red-thunderbird">'.$supervisor_ppm.'</span>';
}}

if ($supervisor ) {	
$query2 		 = $this->db->query("select * from tbl_complaints where status = 'Pending Verification'  AND complaint_nature='PM' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0) {
								$supervisor_pvpm = $pending_v;
								$menu_badge[33] .= '<span class="badge badge-roundless badge-warning ">'.$supervisor_pvpm.'</span>';
}}

if ($admin || $secratery) {							
$query2 		 = $this->db->query("select * from tbl_temporary_leaves WHERE `status`='0'");
							$amount_count = $query2->result_array();
							$pending_c	=	sizeof($amount_count);
							if  ($pending_c>0) {
								$leaves_pending = $pending_c;
							$menu_badge[2] = '<span class="badge badge-roundless badge-warning bg-blue">'.$leaves_pending.'</span>';
}}

if ($admin || $secratery) {							
$query2 		 = $this->db->query("select * from tbl_stock WHERE in_status = 'pending_approval' AND dc_type = 'in'");
							$amount_count = $query2->result_array();
							$pending_c	=	sizeof($amount_count);
							if  ($pending_c>0) {
								//$leaves_pending = $pending_c;
							$menu_badge[56] = '<span class="badge badge-roundless badge-warning bg-green">'.$pending_c.'</span>';
}}

							
$query2 		 = $this->db->query("select * from tbl_fine where status = 'Pending' AND fk_employee_id = '".$this->session->userdata('userid')."' AND date like '".date('Y-m')."%'");
						$amount_count = $query2->result_array();
						$pending_fines	=	sizeof($amount_count);
						if  ($pending_fines>0) {
							$fines_pending = $pending_fines;
						$menu_badge[62] = '<span class="badge badge-roundless badge-warning bg-yellow-gold">'.$fines_pending.'</span>';
}
/*
*/
	
/*
$new_menu = false;
if ($new_menu)	{
	//////////////////////////////////////////////////////
	/////////////////////// Important For Menu
	
	
	$pending_leaves = 0; // for director
	$menu_all 					= 	false;
	$menu_all_except_salesman	=	false;
	$menu_admin_secratery		=	false;
	$menu_fse_supervisor		=	false;
	$menu_admin					=	false;
	$menu_salesman				=	false;
	$menu_supervisor			=	false;
	$menu_supervisor_fse_sap	=	false;
	
	$admin 	= false;
	$secratery 	= false;
	$supervisor 	= false;
	$fse 	= false;
	$sap 	= false;
	
	if($obj->is_allowed('Admin'))
		$admin	= true;
	if($obj->is_allowed('secratery'))
		$secratery	= true;
	if($obj->is_allowed('Supervisor'))
		$Supervisor	= true;
	if($obj->is_allowed('FSE'))
		$fse	= true;
	if($obj->is_allowed('Salesman'))
		$sap	= true;
	
	if($obj->is_allowed('Admin') || $obj->is_allowed('secratery') || $obj->is_allowed('Supervisor') || $obj->is_allowed('FSE') || $obj->is_allowed('Salesman'))
		$menu_all					=	true;
	if($obj->is_allowed('Admin') || $obj->is_allowed('secratery') || $obj->is_allowed('Supervisor') || $obj->is_allowed('FSE'))
		$menu_all_except_salesman	=	true;
	if($obj->is_allowed('Admin') || $obj->is_allowed('secratery'))
		$menu_admin_secratery		=	true;
	if($obj->is_allowed('FSE') || $obj->is_allowed('Supervisor'))
		$menu_fse_supervisor		=	true;
	if($obj->is_allowed('FSE') || $obj->is_allowed('Supervisor') || $obj->is_allowed('Salesman'))
		$menu_supervisor_fse_sap		=	true;
	if($obj->is_allowed('Supervisor'))
		$menu_supervisor			=	true;
	if($obj->is_allowed('Admin'))
		$menu_admin					=	true;
	if($obj->is_allowed('Salesman'))
		$menu_salesman				=	true;
	
	$complaint_menu 	= array('add_complaint','add_complaint_half','engineer_view_complaints','view_half_complaints','director_view_complaints');
	$customers_menu 	= array('add_area','add_city','areas','acs','add_acs','cities','customers_view','add_customer');
	$daily_reports_menu = array('employee_asc','sap_dvr_form','engineer_dvr_form','engineer_dvr_history','sap_dvr_history','admin_dvr_new','all_employee_dvr_vs','admin_dvr_form','engineer_vs','sap_vs');
	$employees_menu 	= array('get_employees','get_users','add_employee');
	$explanation_calls_menu 	= array('fine','all_fines');
	$fse_mis_menu		= array('engineer_asc');
	$leaves_menu		= array('leave_form','leave_form_t','leaves_statistics','all_leaves','pending_leaves','submitted_leaves');
	$material_management_menu	= array('categories','add_category','equipments','equipment_registration','add_product','products','vendors','vendor_registration');
	$news_menu 			= array('news','add_news');
	$pef_menu 			= array('employee_view_pef','create_pef');
	$policies_forms_menu= array('forms','forms_pm','policies','salessop','tssop');
	$preventive_maintenance_menu= array('supervisor_assign_pm','supervisor_pm_completed','engineer_view_pm','director_view_pm');
	$projects_menu		= array('deleted_business_data','business_data','engineer_projects','add_business_project');
	$sap_mis_menu		= array('sap_asc','sap_projects');
	$spare_parts_menu	= array('dc','pending_sprf','spare_parts','spare_part_stock_entry','spare_part_registration');
	$statistics_menu	= array('director_statistics','equipment_statistics','engineer_statistics','pm_statistics','projects_statistics','sap_statistics','territory_statistics');
	$territory_mis_menu	= array('supervisor_dvr','supervisor_vs','supervisor_pm','supervisor_view_complaints');
?>	

	<?php if ($menu_all) { /////////////////// Daily Reports Menu	?>
		<li class="start  <?php if (in_array($uri,$daily_reports_menu)) echo 'active open'; ?>"> 
                	<a href="javascript:;">
						<i class="icon-plane"></i>
						<span class="title">Daily Reports</span> 
						<?php if (in_array($uri,$daily_reports_menu)) echo '<span class="selected"></span>'; ?>
						<span class="arrow <?php if (in_array($uri,$daily_reports_menu)) echo 'open'; ?>"></span> 
                    </a>
                  <ul class="sub-menu">
				 <?php if ($menu_admin_secratery) { ?>
					 <li class="<?php if($uri=='employee_asc') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/employee_asc"> <i class="icon-reload"></i> ACS Individual </a> 
                    </li>
					<li class="<?php if($uri=='admin_dvr_new') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/admin_dvr_new"> <i class="icon-reload"></i> DR History </a> 
                    </li>
					<li class="<?php if($uri=='all_employee_dvr_vs') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/all_employee_dvr_vs"> <i class="icon-reload"></i> DR Overview All </a> 
                    </li>
					<li class="<?php if($uri=='admin_dvr_form') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/admin_dvr_form"> <i class="icon-reload"></i> DR Previous Entry </a> 
                    </li>
				<?php } ?>
				<?php if ($menu_fse_supervisor) { ?>
					 <li class="<?php if($uri=='engineer_dvr_form') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_dvr_form"> <i class="icon-reload"></i> DR Form </a> 
                    </li>
					<li class="<?php if($uri=='engineer_vs') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_vs"> <i class="icon-reload"></i> VS Form </a> 
                    </li>
					<li class="<?php if($uri=='engineer_dvr_history') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_dvr_history"> <i class="icon-reload"></i> DR History </a> 
                    </li>
				<?php } ?>
				<?php if ($sap) { ?>
					<li class="<?php if($uri=='sap_dvr_form') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/sap_dvr_form"> <i class="icon-reload"></i> DR Form </a> 
                    </li>
					<li class="<?php if($uri=='sap_vs') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/sap_vs"> <i class="icon-reload"></i> VS Form </a> 
                    </li>
					 <li class="<?php if($uri=='sap_dvr_history') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/sap_dvr_history"> <i class="icon-reload"></i> DR History </a> 
                    </li>
				<?php } ?>
				 </ul>
        </li>
	<?php }	?>



	<?php if ($menu_all) { /////////////////// LEAVES MENU	?>
		<li class="start  <?php if (in_array($uri,$leaves_menu)) echo 'active open'; ?>"> 
                	<a href="javascript:;">
						<i class="icon-plane"></i>
						<span class="title">Leaves</span> 
						<?php if (in_array($uri,$leaves_menu)) echo '<span class="selected"></span>'; ?>
						<span class="arrow <?php if (in_array($uri,$leaves_menu)) echo 'open'; ?>"></span> 
                    </a>
                  <ul class="sub-menu">
					<li class="<?php if($uri=='all_leaves') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/all_leaves"> <i class="icon-reload"></i> Leaves Data </a> 
                    </li>
				 <?php if ($menu_admin_secratery) { ?>
					 <li class="<?php if($uri=='leave_statistics') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/leaves_statistics"> <i class="icon-reload"></i> Leave Statistics </a> 
                    </li>
					<li class="<?php if($uri=='leave_form') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/leave_form"> <i class="icon-reload"></i> Leave Form </a> 
                    </li>
					<li class="<?php if($uri=='pending_leaves') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/pending_leaves"> <i class="icon-reload"></i> 
                        <?php
							$query2 		 = $this->db->query("select * from tbl_temporary_leaves WHERE `status`='0'");
							$amount_count = $query2->result_array();
							$pending_c	=	sizeof($amount_count);
							if  ($pending_c>0)
							echo '<span class="badge badge-roundless badge-info">'.$pending_c.'</span>';
					   ?> Pending Leaves</a>
                    </li>
				<?php } ?>
				<?php if ($menu_supervisor_fse_sap) { ?>
					<li class="<?php if($uri=='submitted_leaves') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/submitted_leaves"> <i class="icon-reload"></i> 
						<?php
							$query2 		 = $this->db->query("select * from tbl_temporary_leaves 
											 where `fk_employee_id`='".$this->session->userdata('userid')."' AND `status`='1' AND `viewed` ='0'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning bg-yellow-zed">'.$pending_v.'</span>';
						
							$query2 		 = $this->db->query("select * from tbl_temporary_leaves 
											 where `fk_employee_id`='".$this->session->userdata('userid')."' AND `status`='0'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning bg-red">'.$pending_v.'</span>';
						
					   ?>
						Submitted</a> 
                    </li>
					<li class="<?php if($uri=='leave_form_t') echo 'active'; ?>"> 
                    	<a href="<?php echo base_url();?>sys/leave_form_t"> <i class="icon-reload"></i> Leave Form </a> 
                    </li>
					
				<?php } ?>
                  </ul>
        </li>
	<?php }	?>

<?php } */ // End New Menu	?>		
		
		
		<?php /////////// Dynamic Menu 
		$dynamic_menu = true;
if ($dynamic_menu) {
		$query 			=	"SELECT * from tbl_main_menu ORDER BY tbl_main_menu.order";
		  $mmq 			=	$this->db->query($query);
		  $mmr			=	$mmq->result_array();
		  
		  foreach ($mmr AS $main_menu) {
			  $query 			=	"SELECT * from tbl_sub_menu WHERE fk_main_menu_id='".$main_menu['pk_main_menu_id']."' 
			  AND `".$this->session->userdata('userrole')."` = 1 
			  ORDER BY tbl_sub_menu.order";
				$smq 			=	$this->db->query($query);
				$smr			=	$smq->result_array();
				
				if (sizeof($smr)==0) continue;
				else {
					$temp_list = array();
					foreach ($smr AS $sub_menu) {
						array_push($temp_list,$sub_menu['post']);
					}
					?>
				<li class="start  <?php if (in_array($uri,$temp_list)) echo 'active open'; ?>"> 
                	<a href="javascript:;">
						<i class="<?php echo $main_menu['icon']; ?>"></i>
						<span class="title"><?php echo $main_menu['main_menu']; ?></span> 
						<?php if (in_array($uri,$temp_list)) echo '<span class="selected"></span>'; ?>
						<span class="arrow <?php if (in_array($uri,$temp_list)) echo 'open'; ?>"></span> 
                    </a>
                  <ul class="sub-menu">
				  <?php foreach ($smr AS $sub_menu) { ?>
						<li class="<?php if($uri==$sub_menu['post']) echo 'active'; ?>"> 
                    	<a href="<?php echo base_url().$sub_menu['pre']."/".$sub_menu['post'];?>"> <i class="<?php echo $sub_menu['icon']; ?>"></i><?php  echo (isset($menu_badge[$sub_menu['pk_sub_menu_id']])) ? $menu_badge[$sub_menu['pk_sub_menu_id']] : ''; ?> <?php echo $sub_menu['sub_menu']; ?> </a> 
                    </li>
				  <?php } ?>
				  </ul>
        </li>
					
		<?php
				}
		  }
}// End Dynamic Menu
		?>
		
<?php 
$static_menu = false;
if ($static_menu) {
?>		
	<?php			if($obj->is_allowed('Admin') || $obj->is_allowed('secratery') ){ ?>
                <li class="start  <?php if($this->uri->segment(2)=='news'){ echo 'active open';}?>">
                 <a href="<?php echo base_url();?>sys/news"> 
                   <i class="icon-feed"></i> 
                   <span class="title">
                      News
                   </span>
                   <span class="selected"></span> 
                 </a> 
                </li>
                <?php }?>
				
				<?php
				if($obj->is_allowed('Admin')){ ?>
                <li class="start  <?php if($this->uri->segment(2)=='dc'){ echo 'active open';}?>">
                 <a href="<?php echo base_url();?>sys/dc"> 
                   <i class="icon-feed"></i> 
                   <span class="title">
                      Direct Challan
                   </span>
                   <span class="selected"></span> 
				   
				   <?php
							$query2 		 = $this->db->query("select * from tbl_sprf 
											 where dc_number !='0' AND dc_viewed ='0'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							//echo '<span class="badge badge-roundless badge-warning bg-purple">'.$pending_v.'</span>';
						echo '<span class="badge badge-roundless badge-warning bg-purple">NEW</span>';
					   ?>
                 </a> 
                </li>
                <?php }?>
				
				
				
				<?php 
				if($obj->is_allowed('FSE') || $obj->is_allowed('Salesman') || $obj->is_allowed('Supervisor')){ ?>
                <li class="start  <?php if( $this->uri->segment(2)=='all_leaves' || $this->uri->segment(2)=='leave_form_t' || $this->uri->segment(2)=='submitted_leaves'  ){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-plane"></i> <span class="title">Leaves</span> 
                    <span class="arrow <?php if( $this->uri->segment(2)=='all_leaves' || $this->uri->segment(2)=='leave_form_t' || $this->uri->segment(2)=='submitted_leaves' ){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='all_leaves'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/all_leaves"> <i class="icon-reload"></i> 
						<?php
							$query2 		 = $this->db->query("select * from tbl_leaves 
											 where fk_employee_id='".$this->session->userdata('userid')."' AND viewed ='0'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							//echo '<span class="badge badge-roundless badge-warning bg-purple">'.$pending_v.'</span>';
						echo '<span class="badge badge-roundless badge-warning bg-purple">NEW</span>';
					   ?>
						Leaves</a> 
                    </li>
					
					<li class="<?php if( $this->uri->segment(2)=='submitted_leaves'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/submitted_leaves"> <i class="icon-reload"></i> 
						<?php
							$query2 		 = $this->db->query("select * from tbl_temporary_leaves 
											 where `fk_employee_id`='".$this->session->userdata('userid')."' AND `status`='1' AND `viewed` ='0'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning bg-yellow-zed">'.$pending_v.'</span>';
						
							$query2 		 = $this->db->query("select * from tbl_temporary_leaves 
											 where `fk_employee_id`='".$this->session->userdata('userid')."' AND `status`='0'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning bg-red">'.$pending_v.'</span>';
						
					   ?>
						Submitted</a> 
                    </li>
					
                    <li class="<?php if( $this->uri->segment(2)=='leave_form_t'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/leave_form_t"> <i class="icon-reload"></i> Leave Form</a> 
                    </li>
                   </ul>
                 </li>
                <?php }?>
				
                <?php
                if($obj->is_allowed('Admin')){ ?>
               <!-- <li  class="start <?php if($this->uri->segment(2)=='add_user' || $this->uri->segment(2)=='get_users'){ echo 'active open';}?>">
					<a href="javascript:;">
					<i class="icon-diamond"></i>
					<span class="title">Users Manager</span>
					<span class="arrow <?php if($this->uri->segment(2)=='add_user' || $this->uri->segment(2)=='get_users'){ echo 'open';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>profile/add_user">
                            <i class="icon-home"></i>
							Add User</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>profile/get_users">
                            <i class="icon-home"></i>
							All User</a>
						</li>
					</ul>
				</li>-->
                <?php }?>
                <!--For admin Only-->
                
                <?php 
				if($obj->is_allowed('Admin')){ ?>
                <li class="start <?php if($this->uri->segment(2)=='director_statistics' || $this->uri->segment(2)=='pending_sprf' ||$this->uri->segment(2)=='director_view_pm' || $this->uri->segment(2)=='director_view_complaints'  || $this->uri->segment(2)=='view_half_complaints' || $this->uri->segment(2)=='add_complaint'  || $this->uri->segment(2)=='pm_statistics' || $this->uri->segment(2)=='supervisor_assign_pm' || $this->uri->segment(2)=='territory_statistics'){ echo 'active open';} ?> "> 
                	<a href="javascript:;"> <i class="icon-earphones-alt"></i> <span class="title">Technical Support</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='director_statistics' || $this->uri->segment(2)=='pending_sprf' || $this->uri->segment(2)=='director_view_pm' || $this->uri->segment(2)=='director_view_complaints'  || $this->uri->segment(2)=='view_half_complaints'  || $this->uri->segment(2)=='add_complaint'  || $this->uri->segment(2)=='pm_statistics' || $this->uri->segment(2)=='supervisor_assign_pm' || $this->uri->segment(2)=='territory_statistics'){ echo 'open';} ?>"></span> </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='director_view_pm' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/director_view_pm"> <i class="icon-bulb"></i> View PMs</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='add_complaint' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/add_sys/d"> <i class="icon-plus"></i> Create New Complaint</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='director_view_complaints' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/director_view_complaints"> <i class="icon-book-open"></i>
						<?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending SPRF' AND complaint_nature='complaint'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning bg-purple">'.$pending_v.'</span>';
					   ?>
					   <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status != 'Pending Verification' AND status != 'Closed' AND status != 'Pending SPRF' AND status != 'Pending Registration' AND complaint_nature='complaint'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-danger">'.$pending_v.'</span>';
					   ?>
						View Complaints</a> 
                    </li>
				<!--
					<li class=" <?php if($this->uri->segment(2)=='pending_sprf'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/pending_sprf"> 
                        	 <i class="icon-bar-chart"></i>
							 <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending SPRF' AND complaint_nature='complaint'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning bg-purple">'.$pending_v.'</span>';
					   ?>
                        	 Pending SPRF
                        </a> 
                    </li>
				-->
                    <li class="<?php if( $this->uri->segment(2)=='view_half_complaints' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/view_half_complaints"> <i class="icon-book-open"></i> 
                        <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending Registration'");
							$amount_count = $query2->result_array();
							$pending_c	=	sizeof($amount_count);
							if  ($pending_c>0)
							echo '<span class="badge badge-roundless badge-warning">'.$pending_c.'</span>';
					   ?>
                        Register Complaints</a> 
                    </li>
					<li class="<?php if( $this->uri->segment(2)=='pm_statistics' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/pm_statistics"> <i class="icon-bulb"></i> PM Statistics</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='supervisor_assign_pm' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/supervisor_assign_pm"> <i class="icon-bulb"></i> Assign PM</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='director_statistics' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/director_statistics"> <i class="icon-bulb"></i> Director Statistics</a> 
                    </li>
					<li class="<?php if( $this->uri->segment(2)=='territory_statistics' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/territory_statistics"> <i class="icon-graph"></i> Territory Statistics</a>
                    </li>
                  </ul>
                </li>
                <?php }?>
                <!-- Operator ViewFor admin Only-->
                
                
                <?php 
				if($obj->is_allowed('FSE')){ ?>
				  <li class="start <?php if($this->uri->segment(2)=='engineer_dvr_form' || $this->uri->segment(2)=='engineer_vs'
				 || $this->uri->segment(2)=='engineer_dvr_history' ){ echo 'active open';}?>">
                   <a href="javascript:;"> 
                   
                   <i class="icon-home"></i> <span class="title">Daily Reporting</span> 
                   
                   	<span class="arrow <?php if($this->uri->segment(2)=='engineer_dvr_form' || $this->uri->segment(2)=='engineer_vs'
					 || $this->uri->segment(2)=='engineer_dvr_history'){ echo 'open';}?>">
                    </span> 
                   </a>
                  <ul class="sub-menu">
        			<li class=" <?php if($this->uri->segment(2)=='engineer_dvr_form'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_dvr_form"> 
                        	 <i class="icon-bar-chart"></i>
                        	 DVR Form
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='engineer_vs'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_vs"> 
                        	 <i class="icon-bar-chart"></i>
                        	 VS Form
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='engineer_dvr_history'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_dvr_history"> 
                        	 <i class="icon-bar-chart"></i>
                        	 DVR History
                        </a> 
                    </li>
                    
                  </ul>
                </li>
				
				<li class="start  <?php if($this->uri->segment(2)=='spare_parts'){ echo 'active open';}?>">
                 <a href="<?php echo base_url();?>products/spare_parts"> 
                   <i class="icon-star"></i> 
                   <span class="title">
                      Spare Parts List
                   </span>
                   <span class="selected"></span> 
                 </a> 
                </li>
                <!--
                     <li class="<?php if( $this->uri->segment(2)=='spare_parts'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>products/spare_parts"> <i class="icon-star"></i> Spare Parts List </a> 
                    </li>
				-->
				<?php }?>
                
                <?php 
				if($obj->is_allowed('FSE')){ ?>
                <li class="start  <?php if($this->uri->segment(2)=='territory_statistics' || $this->uri->segment(2)=='engineer_view_complaints' || $this->uri->segment(2)=='engineer_view_pm' || $this->uri->segment(2)=='engineer_dvr' || $this->uri->segment(2)=='engineer_asc' ||  $this->uri->segment(2)=='engineer_projects' ||  $this->uri->segment(2)=='engineer_statistics'){ echo 'active open';}?>"> 
                     
                	<a href="javascript:;"> <i class="icon-home"></i> <span class="title">Engineer</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='territory_statistics' || $this->uri->segment(2)=='engineer_view_complaints' || $this->uri->segment(2)=='engineer_view_pm' || $this->uri->segment(2)=='engineer_dvr' ||  $this->uri->segment(2)=='engineer_projects'  ||  $this->uri->segment(2)=='engineer_statistics'){ echo 'open';}?>"></span> </a>
                     
                  <ul class="sub-menu">
                            <li class="<?php if( $this->uri->segment(2)=='engineer_asc'){ echo 'active';}?>"> 
                                <a href="<?php echo base_url();?>sys/engineer_asc"> 
                                    <i class="icon-link"></i> 
                                    ACS 
                                </a> 
                             </li>
                             <li class="<?php if( $this->uri->segment(2)=='engineer_projects'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/engineer_projects"> <i class="icon-briefcase"></i> Projects </a> </li>
                             <li class="<?php if( $this->uri->segment(2)=='engineer_statistics'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/engineer_statistics"> <i class="icon-bar-chart"></i> Statistics </a> </li>
                            <li class="<?php if( $this->uri->segment(2)=='engineer_view_complaints'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/engineer_view_complaints"> <i class="icon-bar-chart"></i>
							<?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status != 'Pending Verification' AND status != 'Closed'  AND complaint_nature='complaint' AND assign_to='".$this->session->userdata('userid')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-danger">'.$pending_v.'</span>';
							?>
							Complaints</a> </li>
                            <li class="<?php if( $this->uri->segment(2)=='engineer_view_pm'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/engineer_view_pm"> <i class="icon-bar-chart"></i>
							<?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status != 'Pending Verification' AND status != 'Completed'  AND complaint_nature='PM' AND assign_to='".$this->session->userdata('userid')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-danger">'.$pending_v.'</span>';
							?>
							<?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending Verification'  AND complaint_nature='PM' AND assign_to='".$this->session->userdata('userid')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning">'.$pending_v.'</span>';
							?>
							PM</a> </li>
                     		<li class="<?php if( $this->uri->segment(2)=='territory_statistics' ){ echo 'active';}?>"> 
                                <a href="<?php echo base_url();?>sys/territory_statistics"> <i class="icon-graph"></i> Territory Statistics</a>
                            </li>
                     
                    <!--<li class="<?php if( $this->uri->segment(2)=='engineer_dvr'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/engineer_dvr"> <i class="icon-bar-chart"></i> View DVR</a> </li>-->
                     
                    
                    
                    
                  </ul>
                </li>
                <?php }?>
                <!--For admin And Engineer Only-->
                
                <?php 
				if($obj->is_allowed('Salesman')){ ?>
                <li class="start  <?php if( $this->uri->segment(2)=='sap_dvr_form' || $this->uri->segment(2)=='sap_dvr' || $this->uri->segment(2)=='sap_asc' || $this->uri->segment(2)=='sap_vs' ||  $this->uri->segment(2)=='sap_dvr_history' || $this->uri->segment(2)=='sap_projects' || $this->uri->segment(2)=='sap_statistics'){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-home"></i> <span class="title">Sap</span> 
                    <span class="arrow <?php if( $this->uri->segment(2)=='sap_dvr_form' || $this->uri->segment(2)=='sap_dvr' || $this->uri->segment(2)=='sap_asc' || $this->uri->segment(2)=='sap_vs' ||  $this->uri->segment(2)=='sap_dvr_history' ||  $this->uri->segment(2)=='sap_projects' || $this->uri->segment(2)=='sap_statistics'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    
                    <li class="<?php if( $this->uri->segment(2)=='sap_dvr_form'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/sap_dvr_form"> <i class="icon-bar-chart"></i> View DVR FORM</a> </li>
                    <!--<li class="<?php if( $this->uri->segment(2)=='sap_dvr'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/sap_dvr"> <i class="icon-bar-chart"></i> View DVR</a> </li>-->
                    <li class="<?php if( $this->uri->segment(2)=='sap_asc'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/sap_asc"> <i class="icon-bar-chart"></i> ACS </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='sap_vs'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/sap_vs"> <i class="icon-bar-chart"></i> VS </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='sap_dvr_history'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/sap_dvr_history"> <i class="icon-bar-chart"></i> DVR History </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='sap_projects'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/sap_projects"> <i class="icon-bar-chart"></i> Projects </a> </li>
                    
                    <li class="<?php if( $this->uri->segment(2)=='sap_statistics'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/sap_statistics"> <i class="icon-bar-chart"></i> SAP Statistics </a> </li>
                  </ul>
                </li>
                 <?php }?>
                 <!--For admin And SlesMan Only-->
                 
                 
                 <!--For admin And Supervisor Only-->
                 
                 <?php 
				if($obj->is_allowed('Supervisor')){ ?>
				  <li class="start <?php if($this->uri->segment(2)=='engineer_dvr_form' || $this->uri->segment(2)=='engineer_vs'
				 || $this->uri->segment(2)=='engineer_dvr_history' || $this->uri->segment(2)=='supervisor_dvr' || $this->uri->segment(2)=='supervisor_vs'){ echo 'active open';}?>">
                   <a href="javascript:;"> 
                   
                   <i class="icon-home"></i> <span class="title">Daily Reporting</span> 
                   
                   	<span class="arrow <?php if($this->uri->segment(2)=='engineer_dvr_form' || $this->uri->segment(2)=='engineer_vs'
					 || $this->uri->segment(2)=='engineer_dvr_history' || $this->uri->segment(2)=='supervisor_dvr' || $this->uri->segment(2)=='supervisor_vs'){ echo 'open';}?>">
                    </span> 
                   </a>
                  <ul class="sub-menu">
        			<li class=" <?php if($this->uri->segment(2)=='engineer_dvr_form'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_dvr_form"> 
                        	 <i class="icon-bar-chart"></i>
                        	 DVR Form
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='engineer_vs'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_vs"> 
                        	 <i class="icon-bar-chart"></i>
                        	 VS Form
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='engineer_dvr_history'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_dvr_history"> 
                        	 <i class="icon-bar-chart"></i>
                        	 DVR History
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='supervisor_dvr'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/supervisor_dvr"> 
                        	 <i class="icon-bar-chart"></i>
                        	 View DVR
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='supervisor_vs'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/supervisor_vs"> 
                        	 <i class="icon-bar-chart"></i>
                        	 View VS
                        </a> 
                    </li>
                    
                  </ul>
                </li>
				
				<li class="start  <?php if($this->uri->segment(2)=='spare_parts'){ echo 'active open';}?>">
                 <a href="<?php echo base_url();?>products/spare_parts"> 
                   <i class="icon-star"></i> 
                   <span class="title">
                      Spare Parts List
                   </span>
                   <span class="selected"></span> 
                 </a> 
                </li>
				<!--
                <li class="<?php if( $this->uri->segment(2)=='spare_parts'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>products/spare_parts"> <i class="icon-star"></i> Spare Parts List </a> 
                    </li>
				-->
				<?php }?>
                
                
                <?php 
				if($obj->is_allowed('Supervisor')){ ?>
				  <li class="start <?php if($this->uri->segment(2)=='engineer_asc' || $this->uri->segment(2)=='engineer_projects'
				 || $this->uri->segment(2)=='engineer_statistics' || $this->uri->segment(2)=='engineer_view_complaints' || $this->uri->segment(2)=='engineer_view_pm'){ echo 'active open';}?>">
                   <a href="javascript:;"> 
                   
                   <i class="icon-home"></i> <span class="title">TSS</span> 
                   
                   	<span class="arrow <?php if($this->uri->segment(2)=='engineer_asc' || $this->uri->segment(2)=='engineer_projects'
					 || $this->uri->segment(2)=='engineer_statistics' || $this->uri->segment(2)=='engineer_view_complaints' || $this->uri->segment(2)=='engineer_view_pm'){ echo 'open';}?>">
                    </span> 
                   </a>
                  <ul class="sub-menu">
        			<li class=" <?php if($this->uri->segment(2)=='engineer_asc'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_asc"> 
                        	 <i class="icon-bar-chart"></i>
                        	 ACS
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='engineer_projects'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_projects"> 
                        	 <i class="icon-bar-chart"></i>
                        	 Projects
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='engineer_statistics'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_statistics"> 
                        	 <i class="icon-bar-chart"></i>
                        	 Statistics
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='engineer_view_complaints'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_view_complaints"> 
                        	 <i class="icon-bar-chart"></i>
							 <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status != 'Pending Verification' AND status != 'Closed'  AND complaint_nature='complaint' AND assign_to='".$this->session->userdata('userid')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-danger">'.$pending_v.'</span>';
							?>
                        	 Complaints
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='engineer_view_pm'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/engineer_view_pm"> 
                        	 <i class="icon-bar-chart"></i>
							 <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status != 'Pending Verification' AND status != 'Completed'  AND complaint_nature='PM' AND assign_to='".$this->session->userdata('userid')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-danger">'.$pending_v.'</span>';
							?>
							<?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending Verification'  AND complaint_nature='PM' AND assign_to='".$this->session->userdata('userid')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning">'.$pending_v.'</span>';
							?>
                        	 PM
                        </a> 
                    </li>
					
                    
                  </ul>
                </li>
				<?php }?>
                
                <?php 
				if($obj->is_allowed('Supervisor')){ ?>
				  <li class="start <?php if($this->uri->segment(2)=='complaint_varification' || $this->uri->segment(2)=='pending_sprf' || $this->uri->segment(2)=='supervisor_view_complaints'
				 || $this->uri->segment(2)=='supervisor_pm' || $this->uri->segment(2)=='supervisor_assign_pm' || $this->uri->segment(2)=='supervisor_pm_completed' || $this->uri->segment(2)=='territory_statistics' ){ echo 'active open';}?>">
                   <a href="javascript:;"> 
                   
                   <i class="icon-home"></i> <span class="title">Territory</span> 
                   
                   	<span class="arrow <?php if($this->uri->segment(2)=='complaint_varification' || $this->uri->segment(2)=='pending_sprf' || $this->uri->segment(2)=='supervisor_view_complaints'
					 || $this->uri->segment(2)=='supervisor_pm' || $this->uri->segment(2)=='supervisor_assign_pm' || $this->uri->segment(2)=='supervisor_pm_completed' || $this->uri->segment(2)=='territory_statistics' ){ echo 'open';}?>">
                    </span> 
                   </a>
                  <ul class="sub-menu">
				  <?php /* ?>
        			<li class=" <?php if($this->uri->segment(2)=='complaint_varification'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/complaint_varification"> 
                        	 <i class="icon-bar-chart"></i>
							 <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending Verification' AND complaint_nature='complaint' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning">'.$pending_v.'</span>';
					   ?>
                        	 Verification
                        </a> 
                    </li> <?php */ ?>
					<li class=" <?php if($this->uri->segment(2)=='supervisor_view_complaints'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/supervisor_view_complaints"> 
                        	 <i class="icon-bar-chart"></i>
							  <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status != 'Pending Verification' AND status != 'Closed'  AND complaint_nature='complaint' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-danger">'.$pending_v.'</span>';
					   ?>
					   <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending Verification' AND complaint_nature='complaint' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning">'.$pending_v.'</span>';
					   ?>
                        	 Complaints
                        </a> 
                    </li>
					<li class=" <?php if($this->uri->segment(2)=='pending_sprf'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/pending_sprf"> 
                        	 <i class="icon-bar-chart"></i>
							 <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending SPRF' AND complaint_nature='complaint' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning bg-purple">'.$pending_v.'</span>';
					   ?>
                        	 Pending SPRF
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='supervisor_pm'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/supervisor_pm"> 
                        	 <i class="icon-bar-chart"></i>
							 <?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status != 'Pending Verification' AND status != 'Completed'  AND complaint_nature='PM' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-danger">'.$pending_v.'</span>';
							?>
							<?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending Verification'  AND complaint_nature='PM' AND fk_office_id='".$this->session->userdata('territory')."'");
							$amount_count = $query2->result_array();
							$pending_v	=	sizeof($amount_count);
							if  ($pending_v>0)
							echo '<span class="badge badge-roundless badge-warning">'.$pending_v.'</span>';
							?>
                        	 PM Calls
                        </a> 
                    </li>
					<li class=" <?php if($this->uri->segment(2)=='supervisor_pm_completed'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/supervisor_pm_completed"> 
                        	 <i class="icon-bar-chart"></i>
                        	 Completed PM Calls
                        </a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='supervisor_assign_pm'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/supervisor_assign_pm"> 
                        	 <i class="icon-bar-chart"></i>
                        	 Assign PM Calls
                        </a> 
                    </li>
					<li class="<?php if( $this->uri->segment(2)=='pm_statistics' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/pm_statistics"> <i class="icon-bulb"></i> PM Statistics</a> 
                    </li>
                    <li class=" <?php if($this->uri->segment(2)=='territory_statistics'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/territory_statistics"> 
                        	 <i class="icon-bar-chart"></i>
                        	 Territory Statistics
                        </a> 
                    </li>
                    
                  </ul>
                </li>
				<?php }?>
                
                 
                 <?php 
				if($obj->is_allowed('Admin')){ ?>
                <!--<li class="start "> <a href="javascript:;"> <i class="icon-home"></i> <span class="title">DC</span> <span class="arrow "></span> </a>
                  <ul class="sub-menu">
                    <li> <a href="<?php echo base_url();?>sys/operator_view_dc"> <i class="icon-graph"></i> View DC</a> </li>
                  </ul>
                </li>-->
                <?php }?>
                 <!--For admin Only-->
                 
                 <!--For admin Only-->
                 
                 <?php 
				if($obj->is_allowed('Admin')){ ?>
                <!--<li class="start <?php if($this->uri->segment(2)=='brands'){ echo 'active open';}?>"> 
                	<a href="<?php echo base_url();?>products/brands"> 
                        <i class="icon-bar-chart"></i> 
                        <span class="title">
                        	Products
                        </span> 
                        <span class="selected"></span> 
                    </a> 
                </li>-->
                <?php }?>
                 <!--For admin Only-->
                 
                 <?php 
				if($obj->is_allowed('Admin')){ ?>
               <!-- <li class="start <?php if($this->uri->segment(2)=='instruments_view'){ echo 'active open';}?>"> 
                	<a href="<?php echo base_url();?>products/instruments_view"> 
                        <i class="icon-bar-chart"></i> 
                          <span class="title">
                              Instruments
                          </span> 
                        <span class="selected"></span> 
                     </a> 
                </li>-->
                <?php }?>
                 <!--For admin Only-->
                 
                 <?php 
				if($obj->is_allowed('Admin')){ ?>
                <!--<li class="start <?php if($this->uri->segment(2)=='parts_view'){ echo 'active open';}?>"> 
                  <a href="<?php echo base_url();?>products/parts_view"> 
                  	<i class="icon-bar-chart"></i> 
                    <span class="title">
                      Parts
                    </span>
                    <span class="selected"></span> 
                  </a> 
                </li>-->
                <?php }?>
                 <!--For admin Only-->
                 
                 <?php 
				if($obj->is_allowed('Admin')){ ?>
                <!--<li class="start  <?php if($this->uri->segment(2)=='get_employees'){ echo 'active open';}?>">
                 <a href="<?php echo base_url();?>profile/get_employees"> 
                   <i class="icon-users"></i> 
                   <span class="title">
                      Employees
                   </span>
                   <span class="selected"></span> 
                 </a> 
                </li>-->
                <?php }?>
                
                <?php 
				if($obj->is_allowed('Admin')){ ?>
                 <li class="start <?php if($this->uri->segment(2)=='get_employees' || $this->uri->segment(2)=='get_users'){ echo 'active open';}?> "> 
                        <a href="javascript:;"> <i class="icon-users"></i> <span class="title">Employees</span> 
                        	<span class="arrow <?php if($this->uri->segment(2)=='get_employees' || $this->uri->segment(2)=='get_users'){ echo 'open';}?>"></span> 
                        </a>
                        <ul class="sub-menu">
                          <li class="<?php if( $this->uri->segment(2)=='get_employees' ){ echo 'active';}?>"> 
                              <a href="<?php echo base_url();?>profile/get_employees"> <i class="icon-users"></i>All Employees</a> 
                          </li>
                          <li class="<?php if( $this->uri->segment(2)=='get_users' ){ echo 'active';}?>"> 
                              <a href="<?php echo base_url();?>profile/get_users"> <i class="icon-users"></i>X-Employees</a> 
                          </li>
                        </ul>
                 </li>
			<?php } ?>
                
                <?php 
				if($obj->is_allowed('FSE') || $obj->is_allowed('Salesman') || $obj->is_allowed('Supervisor')){ ?>
                <li class="start  <?php if($this->uri->segment(2)=='add_complaint_half'){ echo 'active open';}?>">
                 <a href="<?php echo base_url();?>sys/add_complaint_half"> 
                   <i class="icon-users"></i> 
                   <span class="title">
                      Add Complaint
                   </span>
                   <span class="selected"></span> 
                 </a> 
                </li>
                <?php }?>
                 <!--For admin Only-->
                 
                 <!--For admin Only-->
                 
                 
                
                <?php 
				if($obj->is_allowed('Admin')){ ?>
                <li class="start  <?php if( $this->uri->segment(2)=='acs' || $this->uri->segment(2)=='business_data' || $this->uri->segment(2)=='customers_view' || $this->uri->segment(2)=='cities'  || $this->uri->segment(2)=='projects_statistics'|| $this->uri->segment(2)=='deleted_business_data' || $this->uri->segment(2)=='areas'){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-grid"></i> <span class="title">Customers</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='acs' || $this->uri->segment(2)=='business_data' || $this->uri->segment(2)=='customers_view' || $this->uri->segment(2)=='cities'  || $this->uri->segment(2)=='projects_statistics' || $this->uri->segment(2)=='deleted_business_data' || $this->uri->segment(2)=='areas'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='acs'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/acs"> <i class="icon-link"></i> Assigned Sheet</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='business_data'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/business_data"> <i class="icon-briefcase"></i> Projects</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='projects_statistics'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/projects_statistics"> <i class="icon-bar-chart"></i> Projects Statistics</a> 
                    </li>
					<li class="<?php if( $this->uri->segment(2)=='deleted_business_data'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/deleted_business_data"> <i class="icon-briefcase"></i> Deleted Projects</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='customers_view'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/customers_view"> <i class="icon-magic-wand"></i> Customer List</a> 
                    </li>
                    <li class="start  <?php if($this->uri->segment(2)=='cities'){ echo 'active open';}?>">
                     <a href="<?php echo base_url();?>sys/cities"> 
                       <i class="icon-pointer"></i> 
                       <span class="title">
                          Cities
                       </span>
                       <span class="selected"></span> 
                     </a> 
                    </li>
                    <li class="start  <?php if($this->uri->segment(2)=='areas'){ echo 'active open';}?>">
                     <a href="<?php echo base_url();?>sys/areas"> 
                       <i class="icon-pointer"></i> 
                       <span class="title">
                          Areas
                       </span>
                       <span class="selected"></span> 
                     </a> 
                    </li>
                  </ul>
                </li>
                 <?php }
				?>
                
                
                
				
                
                
                
                  <?php 
				if($obj->is_allowed('Admin') || $obj->is_allowed('secratery')){ ?>
                <li class="start  <?php if( $this->uri->segment(2)=='all_leaves' || $this->uri->segment(2)=='pending_leaves' || $this->uri->segment(2)=='leave_form' || $this->uri->segment(2)=='leaves_statistics' ){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-plane"></i> <span class="title">Leaves</span> 
                    <span class="arrow <?php if( $this->uri->segment(2)=='all_leaves' || $this->uri->segment(2)=='pending_leaves'  || $this->uri->segment(2)=='leave_form' || $this->uri->segment(2)=='leaves_statistics'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='all_leaves'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/all_leaves"> <i class="icon-reload"></i> All Leaves</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='pending_leaves'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/pending_leaves"> <i class="icon-reload"></i> 
                        <?php
							$query2 		 = $this->db->query("select * from tbl_temporary_leaves WHERE `status`='0'");
							$amount_count = $query2->result_array();
							$pending_c	=	sizeof($amount_count);
							if  ($pending_c>0)
							echo '<span class="badge badge-roundless badge-info">'.$pending_c.'</span>';
					   ?> Pending Leaves</a>
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='leave_form'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/leave_form"> <i class="icon-screen-tablet"></i> Leave Form</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='leaves_statistics'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/leaves_statistics"> <i class="icon-eyeglasses"></i> Leaves Statistics</a> 
                    </li>
                    
                  </ul>
                </li>
                 <?php }
				?>
                
                <?php 
				if($obj->is_allowed('Admin')){ ?>
                <li class="start  <?php if( $this->uri->segment(2)=='admin_dvr_new' || $this->uri->segment(2)=='admin_vs' || $this->uri->segment(2)=='all_employee_dvr_vs'  || $this->uri->segment(2)=='all_employee_vs'  || $this->uri->segment(2)=='admin_dvr_form'  || $this->uri->segment(2)=='employee_asc'){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-moustache"></i> <span class="title">Daily Reports</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='admin_dvr_new' || $this->uri->segment(2)=='admin_vs' || $this->uri->segment(2)=='all_employee_dvr_vs'  || $this->uri->segment(2)=='all_employee_vs' || $this->uri->segment(2)=='admin_dvr_form'   || $this->uri->segment(2)=='employee_asc'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='admin_dvr_form'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/admin_dvr_form"> <i class="icon-action-undo"></i> DVR Previous Entry </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='admin_dvr_new'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/admin_dvr_new"> <i class="icon-pie-chart"></i> DVR/VS Individual</a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='all_employee_dvr_vs'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/all_employee_dvr_vs"> <i class="icon-layers"></i> DVR/VS Overview All </a> </li>
					<?php /*
                    <li class="<?php if( $this->uri->segment(2)=='admin_vs'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/admin_vs"> <i class="icon-doc"></i> VS History Individual</a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='all_employee_vs'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/all_employee_vs"> <i class="icon-docs"></i> VS Overview All </a> </li>
					*/ ?>
                    <li class="<?php if( $this->uri->segment(2)=='employee_asc'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/employee_asc"> <i class="icon-badge"></i> ACS Individual </a> </li> 
                    
                  </ul>
                </li>
                 <?php }
				 ?>
                
                <?php 
				if($obj->is_allowed('Admin')){ ?>
                <!--<li class="start  <?php if( $this->uri->segment(2)=='director_view_complaints' || $this->uri->segment(2)=='director_view_pms' ){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-moustache"></i> <span class="title">Technical Support</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='director_view_complaints' || $this->uri->segment(2)=='director_view_pms'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='director_view_complaints'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/director_view_complaints"> <i class="icon-action-undo"></i> View Complaints </a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='director_view_pms'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/director_view_pms"> <i class="icon-pie-chart"></i> View PMs</a> 
                    </li>
                  </ul>
                </li>-->
                 <?php }
				 ?>
                 
                 <?php 
				if($obj->is_allowed('Admin')){ ?>
                <li class="start  <?php if($this->uri->segment(2)=='spare_parts'  || $this->uri->segment(2)=='spare_part_registration'  || $this->uri->segment(2)=='vendors' || $this->uri->segment(2)=='products' || $this->uri->segment(2)=='categories' || $this->uri->segment(2)=='equipments'){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-calculator"></i> <span class="title">Materials Management</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='spare_parts'  ||  $this->uri->segment(2)=='spare_part_registration'  ||  $this->uri->segment(2)=='vendors' || $this->uri->segment(2)=='products' || $this->uri->segment(2)=='categories'  || $this->uri->segment(2)=='equipments'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='categories'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/categories"> <i class="icon-shuffle"></i>  Categories </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='vendors'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/vendors"> <i class="icon-eye"></i>  Vendors </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='products'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/products"> <i class="icon-anchor"></i>  Products </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='equipments'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/equipments"> <i class="icon-flag"></i>  Equipments </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='spare_part_registration'){ echo 'active';}?>"> <a href="<?php echo base_url();?>products/spare_part_registration"> <i class="icon-flag"></i>  Spare Part Registration  </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='spare_parts'){ echo 'active';}?>"> <a href="<?php echo base_url();?>products/spare_parts"> <i class="icon-flag"></i>  Spare Parts  </a> </li>
                  </ul>
                </li>
                 <?php }?>
                 
                 <?php 
				if($obj->is_allowed('Admin')){ ?>
                <li class="start  <?php if($this->uri->segment(2)=='create_pef' || $this->uri->segment(2)=='employee_view_pef'){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-like"></i> <span class="title">Evaluation</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='create_pef' || $this->uri->segment(2)=='employee_view_pef'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='create_pef'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/create_pef"> <i class="icon-note"></i></i>  Create PEF </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='employee_view_pef'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/employee_view_pef"> <i class="icon-speedometer"></i>  PEF </a> </li>
                  </ul>
                </li>
                 <?php }?>
                
                
                
                <?php 
				if($obj->is_allowed('secratery')){ ?>
                <li class="start  <?php if($this->uri->segment(2)=='admin_dvr_new' || $this->uri->segment(2)=='admin_vs' || $this->uri->segment(2)=='all_employee_dvr_vs'  || $this->uri->segment(2)=='all_employee_vs'  || $this->uri->segment(2)=='admin_dvr_form'  || $this->uri->segment(2)=='employee_asc' || $this->uri->segment(2)=='business_data'){ echo 'active open';}?>"> 
                
                	<a href="javascript:;"> <i class="icon-home"></i> <span class="title">Daily Reports</span> 
                    
                    <span class="arrow <?php if($this->uri->segment(2)=='admin_dvr_new' || $this->uri->segment(2)=='admin_vs' || $this->uri->segment(2)=='all_employee_dvr_vs'  || $this->uri->segment(2)=='all_employee_vs' || $this->uri->segment(2)=='admin_dvr_form'   || $this->uri->segment(2)=='employee_asc' || $this->uri->segment(2)=='business_data'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='admin_dvr_form'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/admin_dvr_form"> <i class="icon-bar-chart"></i> DVR Previous Entry</a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='admin_dvr_new'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/admin_dvr_new"> <i class="icon-bar-chart"></i> DVR/VS Individual</a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='all_employee_dvr_vs'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/all_employee_dvr_vs"> <i class="icon-bar-chart"></i> DVR/VS Overview All</a> </li>
					<?php /*
                    <li class="<?php if( $this->uri->segment(2)=='admin_vs'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/admin_vs"> <i class="icon-bar-chart"></i> VS History Individual </a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='all_employee_vs'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/all_employee_vs"> <i class="icon-bar-chart"></i> VS Overview All</a> </li>
                    */ ?>
					<li class="<?php if( $this->uri->segment(2)=='employee_asc'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/employee_asc"> <i class="icon-bar-chart"></i> ACS Individual</a> </li>
                    <li class="<?php if( $this->uri->segment(2)=='business_data'){ echo 'active';}?>"> <a href="<?php echo base_url();?>sys/business_data"> <i class="icon-bar-chart"></i> Business Projects </a> </li>
                    
                    <!--<li class="<?php if( $this->uri->segment(2)=='fine'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/fine"> <i class="icon-bar-chart"></i> Add fine </a> 
                    </li>-->
                  </ul>
                </li>
                 <?php }
				?>
                <?php 
				if($obj->is_allowed('secratery')){ ?>
                <li class="start  <?php if( $this->uri->segment(2)=='spare_parts'  || $this->uri->segment(2)=='spare_part_registration'){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-calculator"></i> <span class="title">Materials Management</span> 
                    <span class="arrow <?php if( $this->uri->segment(2)=='spare_parts'  ||  $this->uri->segment(2)=='spare_part_registration'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='spare_part_registration'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>products/spare_part_registration"> <i class="icon-flag"></i>  Spare Part Registration  </a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='spare_parts'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>products/spare_parts"> <i class="icon-flag"></i>  Spare Parts  </a> 
                    </li>
                    
                  </ul>
                </li>
                 <?php }?>
                <?php 
				if($obj->is_allowed('secratery')){ ?>
                <!--<li class="start  <?php if( $this->uri->segment(2)=='operator_view_complaints' ||$this->uri->segment(2)=='director_view_pm'  || $this->uri->segment(2)=='operator_view_pms' ){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-moustache"></i> <span class="title">Technical Support</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='operator_view_complaints' ||$this->uri->segment(2)=='director_view_pm'  || $this->uri->segment(2)=='operator_view_pms'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='operator_view_complaints'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/director_view_complaints"> <i class="icon-action-undo"></i> View Complaints </a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='operator_view_pms'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/operator_view_pms"> <i class="icon-pie-chart"></i> View PMs</a> 
                    </li>
                  </ul>
                </li>-->
                
                <li class="start <?php if($this->uri->segment(2)=='pm_statistics' || $this->uri->segment(2)=='pending_sprf' || $this->uri->segment(2)=='director_view_pm'  || $this->uri->segment(2)=='territory_statistics' || $this->uri->segment(2)=='view_half_complaints' || $this->uri->segment(2)=='add_complaint' || $this->uri->segment(2)=='director_view_complaints'){ echo 'active open';}?> "> 
                
                	<a href="javascript:;"> <i class="icon-earphones-alt"></i> <span class="title">Technical Support</span> 
                    
                    <span class="arrow <?php if($this->uri->segment(2)=='pm_statistics' || $this->uri->segment(2)=='pending_sprf' ||  $this->uri->segment(2)=='director_view_pm'  || $this->uri->segment(2)=='territory_statistics' || $this->uri->segment(2)=='view_half_complaints' || $this->uri->segment(2)=='add_complaint' || $this->uri->segment(2)=='director_view_complaints'){ echo 'open';}?>"></span> </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='add_complaint' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/add_complaint"> <i class="icon-plus"></i> Create New Complaint</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='director_view_complaints' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/director_view_complaints"> <i class="icon-book-open"></i> View Complaints</a> 
                    </li>
					
                    <li class="<?php if( $this->uri->segment(2)=='view_half_complaints' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/view_half_complaints"> <i class="icon-book-open"></i>
						<?php
							$query2 		 = $this->db->query("select * from tbl_complaints 
											 where status = 'Pending Registration'");
							$amount_count = $query2->result_array();
							$pending_c	=	sizeof($amount_count);
							if  ($pending_c>0)
							echo '<span class="badge badge-roundless badge-warning">'.$pending_c.'</span>';
					   ?>
						Register Complaints</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='territory_statistics' ){ echo 'active';}?>"> 
                        <a href="<?php echo base_url();?>sys/territory_statistics"> <i class="icon-graph"></i> Territory Statistics</a>
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='director_view_pm'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/director_view_pm"> <i class="icon-flag"></i>  PM  </a> 
                    </li>        
					<li class="<?php if( $this->uri->segment(2)=='pm_statistics' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/pm_statistics"> <i class="icon-bulb"></i> PM Statistics</a> 
                    </li>
                  </ul>
                </li>
                 <?php }
				 ?>
                
                <?php 
				if($obj->is_allowed('secratery')){ ?>
                <li class="start  <?php if( $this->uri->segment(2)=='acs' || $this->uri->segment(2)=='business_data' || $this->uri->segment(2)=='customers_view' ){ echo 'active open';}?>"> 
                	<a href="javascript:;"> <i class="icon-home"></i> <span class="title">Customers</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='acs' || $this->uri->segment(2)=='business_data' || $this->uri->segment(2)=='customers_view'){ echo 'open';}?>">
                    </span> 
                    </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='acs'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/acs"> <i class="icon-bar-chart"></i> Assigned Sheet</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='business_data'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/business_data"> <i class="icon-bar-chart"></i> Projects</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='customers_view'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/customers_view"> <i class="icon-bar-chart"></i> Customer List</a> 
                    </li>
                  </ul>
                </li>
                 <?php }
				?>
                
                <?php 
				if($obj->is_allowed('Admin')==false){ ?>
                <li class="start  <?php if($this->uri->segment(2)=='employee_view_pef'){ echo 'active open';}?>">
                 <a href="<?php echo base_url();?>sys/employee_view_pef"> 
                   <i class="icon-rocket"></i> 
                   <span class="title">
                      PEF
                   </span>
                   <span class="selected"></span> 
                 </a> 
                </li>
                <?php }?>
                
                <li class="start <?php if($this->uri->segment(2)=='policies' || $this->uri->segment(2)=='forms' || $this->uri->segment(2)=='forms_pm' || $this->uri->segment(2)=='salessop' || $this->uri->segment(2)=='tssop'){ echo 'active open';}?> "> 
                	<a href="javascript:;"> <i class="icon-info"></i> <span class="title">Policies & Forms</span> 
                    <span class="arrow <?php if($this->uri->segment(2)=='policies' || $this->uri->segment(2)=='forms' || $this->uri->segment(2)=='forms_pm' || $this->uri->segment(2)=='salessop' || $this->uri->segment(2)=='tssop'){ echo 'open';}?>"></span> </a>
                  <ul class="sub-menu">
                    <li class="<?php if( $this->uri->segment(2)=='policies' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/policies"> <i class="icon-diamond"></i> Policies</a> 
                    </li>
                    <li class="<?php if( $this->uri->segment(2)=='forms' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/forms"> <i class="fa fa-download"></i> Forms</a> 
                    </li>
                    <?php if($obj->is_allowed('Salesman') || $obj->is_allowed('Admin')){ ?>
                    <li class="<?php if( $this->uri->segment(2)=='salessop'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/salessop"> <i class="icon-compass"></i> Sales SOP </a>
                    </li>
                    <?php }?>
                    <?php if($obj->is_allowed('FSE') || $obj->is_allowed('Supervisor') || $obj->is_allowed('Admin')){ ?>
                    <li class="<?php if( $this->uri->segment(2)=='tssop'){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/tssop"> <i class="icon-star"></i> TS SOP </a> 
                    </li>
                    <?php }?>
                    <li class="<?php if( $this->uri->segment(2)=='forms_pm' ){ echo 'active';}?>"> 
                    	<a href="<?php echo base_url();?>sys/forms_pm"> <i class="fa fa-download"></i>PM Forms</a> 
                    </li>
                  </ul>
                </li>
                <?php 
				if($obj->is_allowed('secratery')==false){ ?>
                <li class="start  <?php if($this->uri->segment(2)=='all_fines'){ echo 'active open';}?>">
                 <a href="<?php echo base_url();?>sys/all_fines"> 
                   <i class="icon-ghost"></i> 
				   <?php
						$query2 		 = $this->db->query("select * from tbl_fine 
										 where status = 'Pending' AND fk_employee_id = '".$this->session->userdata('userid')."' 
										 AND date like '".date('Y-m')."%'");
						$amount_count = $query2->result_array();
						$pending_fines	=	sizeof($amount_count);
						if  ($pending_fines>0)
						echo '<span class="badge badge-roundless badge-danger">'.$pending_fines.'</span>';
				   ?>
				   
                   <span class="title">
                      Explanation Calls
                   </span>
                   <span class="selected"></span> 
                 </a> 
                </li>
                <?php }?>
                <?php 
				if($obj->is_allowed('secratery')){ ?>
                 <li class="start <?php if($this->uri->segment(2)=='all_fines' || $this->uri->segment(2)=='fine'){ echo 'active open';}?> "> 
                        <a href="javascript:;"> <i class="icon-earphones-alt"></i> <span class="title">Explanation Calls</span> 
                        	<span class="arrow <?php if($this->uri->segment(2)=='all_fines' || $this->uri->segment(2)=='fine'){ echo 'open';}?>"></span> 
                        </a>
                        <ul class="sub-menu">
                          <li class="<?php if( $this->uri->segment(2)=='fine' ){ echo 'active';}?>"> 
                              <a href="<?php echo base_url();?>sys/fine"> <i class="icon-plus"></i>Add Explanation Call</a> 
                          </li>
                          <li class="<?php if( $this->uri->segment(2)=='all_fines' ){ echo 'active';}?>"> 
                              <a href="<?php echo base_url();?>sys/all_fines"> <i class="icon-book-open"></i>All Explanation Calls</a> 
                          </li>
                        </ul>
                 </li>
			<?php } ?>
<?php } // End Static Menu ?>
			<li>
				<center>
					<!--<a href="http://rozesolutions.com">
					<img src="<?php echo base_url();?>assets/admin/layout/img/logo5.png" alt="logo" class="img-responsive" style="width:200px;height:auto;"/>
					</a>-->
				</center>
			</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
      <!-- BEGIN CONTENT BODY -->
		<div class="page-content">
			
			<?php /*
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			*/ ?>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN STYLE CUSTOMIZER -->
			
			<!-- END STYLE CUSTOMIZER -->
            <script>
			/*Notifications stoped temprarily*/
			/*$(document).ready(function(){
				setInterval(function(){
				  dataObj='';
				  $.post('<?php echo base_url();?>inbox/message_notification',dataObj,function(data){
					// ajax callback
					// here is where you would update the user with any new notifications.
					var current_value= $(".message_noti_up").html();
					if(data > current_value)
					{
						$(".message_noti_up").html(data);
						var audio = new Audio('<?php echo base_url();?>Facebook_Notification_Sound.mp3');
						audio.play();
				  	}
					if(data > 0)
					{
						$(".message_noti_up_badge").show()
				  	}
					else
					{
						$(".message_noti_up_badge").hide()
				  	}
					 
				  });
				},5000);
			});*/
			function PrintElem(elem)
			{
				Popup($(elem).html());
				//
				var print_count=$("#print_count").val();
				var complaint_id=$("#complaint_id").val();
				var formdata =
					  {
						print_count: print_count,
						complaint_id: complaint_id
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/update_print_count_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$("#print_count").val(msg);
						$("#print_count_span").html(msg);
						
						}
					})
					return false;
			}
			function Popup(data) 
			{
				var mywindow = window.open('', 'Print div', 'height=600,width=900');
				mywindow.document.write('<html><head><title>Print Preview</title>');
				/*optional stylesheet*/ 
				mywindow.document.write('<link rel="stylesheet" href="<?php  echo base_url();?>css/reveal.css" type="text/css" />');
				mywindow.document.write('<link rel="stylesheet" href="<?php  echo base_url();?>css/style.css" type="text/css" />');
				mywindow.document.write('</head><body >');
				mywindow.document.write(data);
				mywindow.document.write('</body></html>');
		
				mywindow.print();
				$( ".popupprintdiv" ).hide();
				mywindow.close();
		
				return true;
			}
			</script>