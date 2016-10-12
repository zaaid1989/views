<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complaint extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	function __construct() 
	{
        parent::__construct();
		$this->is_logged_in();
    }
	function is_logged_in()
	{
	  $is_logged_in = $this->session->userdata('is_logged_in');
	  if(!isset($is_logged_in) || $is_logged_in != true)
		{
			 //$this->load->view('login');
			 redirect(site_url() . 'login');
		}
	}
	
	
	public function index()
	{
		redirect('sys/operator_view_complaints');
	}
	
	public function test_cron()
	{
		echo "zaaid";
		$query = "INSERT INTO tbl_tagg SET x=0.1,y=0.2,text='cron'";
		$dbres = $this->db->query($query);
	}
	
	public function chart_territory_complaints()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/chart_territory_complaints');
	}
	
	public function chart_territory_task_distribution()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/chart_territory_task_distribution');
	}
	
	public function chart_real_time_territory_pm()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/chart_real_time_territory_pm');
	}
	
	public function chart_real_time_territory_report()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/chart_real_time_territory_report');
	}
	
	public function chart_sap_projects_review_prod()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/chart_sap_projects_review_prod');
	}
	public function chart_sap_projects_review_biz()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/chart_sap_projects_review_biz');
	}
	public function chart_sap_territory_visit_review()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/chart_sap_territory_visit_review');
	}
	public function chart_ongoing_projects_target_date()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/chart_ongoing_projects_target_date');
	}
	/*Zohaib*/
	public function leaves_overview_all()
	{ 
	     if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
				$this->load->view('sys/leaves_overview_all');
	}
	
	public function strategy_history()
	{ 
	     if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
				$this->load->view('sys/strategy_history');
	}
	
	public function mainpage_z()
	{ 
	
	     if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		
		$this->load->view('sys/mainpage_z');
	}
	/*Zohaib*/
	
	public function fine()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->view('sys/fine');
	}
	public function warning_letter()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/warning_letter');
	}
	public function leaves_statistics()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/leaves_statistics');
	}
	
	public function leaves_summary()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/leaves_summary');
	}
	
	public function pending_sprf()
	{
		if($this->session->userdata('userrole')=='Supervisor' || $this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/pending_sprf');
		}
		else
		{
			show_404();
		}
		
	}
	
	public function complaint_varification()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->view('sys/complaint_varification');
	}
	
	public function ts_report_supervisor()
	{
		$query="select `fk_office_id` from user where `id` ='".$this->session->userdata('userid')."'";
		$query_db=$this->db->query($query);
		$result=$query_db->result_array();
		////////////////////////////////////
		$query="select `fk_office_id` from tbl_complaints where `pk_complaint_id` ='".$this->uri->segment(3)."'
		AND `complaint_nature`='complaint'";
		$query_db=$this->db->query($query);
		$user_complaints=$query_db->result_array();			
		if ($user_complaints[0]['fk_office_id']!=$result[0]['fk_office_id'])
		{
			show_404();
		}
		/*
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}*/
		$this->load->view('sys/ts_report_supervisor');
	}
	
	public function sub_menu()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/sub_menu');
	}
	
	public function edit_sub_menu()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/edit_sub_menu');
	}
	
	public function add_sub_menu()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/add_sub_menu');
	}
	
	public function main_menu()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/main_menu');
	}
	
	public function edit_main_menu()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/edit_main_menu');
	}
	
	public function add_main_menu()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/add_main_menu');
	}
	
	public function ts_report_director()
	{
		if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Supervisor' && $this->session->userdata('userrole')!='FSE')
		{
			show_404();
		}
		$this->load->view('sys/ts_report_director');
	}
	public function pm_form() {
		$query="select `fk_office_id` from user where `id` ='".$this->session->userdata('userid')."'";
		$query_db=$this->db->query($query);
		$result=$query_db->result_array();
		$supervisor_office	=	$result[0]['fk_office_id'];
		
		$query="select `assign_to` from tbl_complaints where `pk_complaint_id` ='".$this->uri->segment(3)."'
		AND `complaint_nature`='PM'";
		$query_db=$this->db->query($query);
		$user_complaints=$query_db->result_array();	

		$query="select `fk_office_id` from tbl_complaints where `pk_complaint_id` ='".$this->uri->segment(3)."'
		AND `complaint_nature`='PM'";
		$query_db=$this->db->query($query);
		$user_complaintss=$query_db->result_array();
		$complaint_office	=	$user_complaintss[0]['fk_office_id'];
		
		if ($this->session->userdata('userrole')=='FSE' && $user_complaints[0]['assign_to']!=$this->session->userdata('userid'))
		{
			show_404();
		}
		
		if ($this->session->userdata('userrole')=='Supervisor' && $complaint_office != $supervisor_office)
		{
			show_404();
		}
		
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor' || $this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin')
		{	
			$this->load->view('sys/pm_form');
		}
		else
		{
			show_404();
		}
    }
	public function s_pm_form() {
		
		$query="select `assign_to` from tbl_complaints where `pk_complaint_id` ='".$this->uri->segment(3)."'
		AND `complaint_nature`='PM'";
		$query_db=$this->db->query($query);
		$user_complaints=$query_db->result_array();			
		if ($user_complaints[0]['assign_to']!=$this->session->userdata('userid'))
		{
			show_404();
		}/*
		if($this->session->userdata('userrole')=='Supervisor')
		{	
			$this->load->view('sys/s_pm_form');
		}
		else
		{
			show_404();
		}*/
		$this->load->view('sys/s_pm_form');
    }
	public function projects_statistics()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/projects_statistics');
	}
	public function territory_statistics()
	{
		if($this->session->userdata('userrole')=='')
		{
			show_404();
		}
		$this->load->view('sys/territory_statistics');
	}
	
	public function technical_service_pvr()
	{
		/*
		$query="select `assign_to` from tbl_complaints where `pk_complaint_id` ='".$this->uri->segment(3)."'
		AND `complaint_nature`='complaint'";
		$query_db=$this->db->query($query);
		$user_complaints=$query_db->result_array();			
		if ($user_complaints[0]['assign_to']!=$this->session->userdata('userid'))
		{
			show_404();
		}
		else*/if($this->session->userdata('userrole')=='Salesman')
		{
			show_404();
		}
		$this->load->view('sys/technical_service_pvr');
	}
	
	public function supervisor_assign_pm()
	{
		if($this->session->userdata('userrole')!='Supervisor' && $this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
		$this->load->view('sys/supervisor_assign_pm');
	}
	
	public function pm_statistics()
	{
		if($this->session->userdata('userrole')!='Supervisor' && $this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
		$this->load->view('sys/pm_statistics');
	}
	
	public function employee_asc()
	{
		
		//$get_eng_dvr = $this->complaint_model->get_eng_asc_model();
		//$this->load->view('sys/sap_asc', array("get_eng_dvr" => $get_eng_dvr));
		
			$engineer = $this->session->userdata('userid');
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d', strtotime('-30 days'));
			if(isset($_POST['engineer'])){
				$engineer = $_POST['engineer'];
			}
				$dbres = $this->db->query("SELECT tbl_dvr.*,
				COALESCE(tbl_offices.office_name) AS office_name,
				COALESCE(tbl_clients.client_name) AS client_name,
				COALESCE(tbl_area.area) AS area
				FROM tbl_dvr 
				LEFT JOIN tbl_offices ON tbl_dvr.fk_customer_id = tbl_offices.client_option
				LEFT JOIN tbl_clients ON tbl_dvr.fk_customer_id=tbl_clients.pk_client_id 
				LEFT JOIN tbl_area ON tbl_clients.fk_area_id=tbl_area.pk_area_id 
				where tbl_dvr.fk_engineer_id = '".$engineer."' AND CAST(tbl_dvr.`date` AS DATE) between '".$end_date."' AND '".$start_date."' 
				order by tbl_dvr.date DESC");
				$dbresResult=$dbres->result_array();
				$dbres2 = $this->db->query("SELECT * FROM user where id = '".$engineer."' ");
				$dbresResult2=$dbres2->result_array();
				
				$this->load->view('sys/employee_asc', array("get_eng_dvr" => $dbresResult,
																"eng_id" 	 => $engineer,
																"userrole"   => $dbresResult2['0']['userrole']));
			
			
	}
	public function products()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/products');
	}
	public function categories()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/categories');
	}
	public function add_product()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/add_product');
	}
	public function add_category()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/add_category');
	}
	
	public function delete_strategy($id)
	{
		$dbres = $this->db->query("DELETE FROM tbl_project_strategy WHERE pk_project_strategy_id = $id");
		if (isset($_GET['proj']))
			redirect(site_url() . 'sys/strategy_history/'. $_GET['proj']);
		else
			redirect(site_url() . 'sys/business_data');
	}
	
	public function delete_asc($id)
	{
		$dbres = $this->db->query("DELETE FROM tbl_customer_sap_bridge WHERE pk_customer_sap_bridge_id = $id");
		if (isset($_GET['cust']))
			redirect(site_url() . 'sys/edit_customer/'. $_GET['cust']);
		else
		redirect(site_url() . 'sys/acs?msg_del=success');
	}
	
	// Retive All Sent Messages
	
	public function acs() {
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{	
			$this->load->model("complaint_model");
			$get_acs_lists = $this->complaint_model->get_acs_model();
			$this->load->view('acs', array("get_acs_lists" => $get_acs_lists));
		}
		else
		{
			show_404();
		}
    }
	public function news() {
        if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery' )
		{
			show_404();
		}
        $this->load->view('sys/news_z');
    }
	public function add_news() {
        if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
        $this->load->view('sys/add_news');
    }
	
	public function cities() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/cities');
    }
	public function areas() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/areas');
    }
	public function add_city() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/add_city');
    }
	public function add_area() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/add_area');
    }
	public function update_city() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/update_city');
    }
	public function update_area() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/update_area');
    }
	
	public function update_city_insert() {
		$query="update  `tbl_cities` SET 	
			  `city_name`						='".$_POST['city_name']."' ,
			  `fk_office_id`							='".$_POST['office_name']."'
			   where pk_city_id ='".$_POST['pk_city_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/update_city/'.$_POST['pk_city_id'].'?msg=success');
    }
	public function update_area_insert() {
		$query="update  `tbl_area` SET 	
			  `area`						='".$_POST['area_name']."' ,
			  `fk_city_id`							='".$_POST['city_name']."'
			   where pk_area_id ='".$_POST['pk_area_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/update_area/'.$_POST['pk_area_id'].'?msg=success');
    }
	
	public function add_strategy() {
        if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
        $this->load->view('sys/add_strategy');
    }
	
	public function edit_strategy() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/edit_strategy');
    }
	
	public function update_submenu() {
		$admin = 0;
		$secratery=0;
		$supervisor=0;
		$fse=0;
		$salesman=0;
		if (isset($_POST['Admin'])) $admin=1;
		if (isset($_POST['secratery'])) $secratery=1;
		if (isset($_POST['Supervisor'])) $supervisor=1;
		if (isset($_POST['FSE'])) $fse=1;
		if (isset($_POST['Salesman'])) $salesman=1;
		$query="update  `tbl_sub_menu` SET 	
			  `fk_main_menu_id`					='".$_POST['fk_main_menu_id']."' ,
			  `sub_menu`						='".$_POST['sub_menu']."' ,
			  `pre`								='".$_POST['pre']."' ,
			  `post`							='".$_POST['post']."' ,
			  `icon`							='".$_POST['icon']."' ,
			  `order`							='".$_POST['order']."' ,
			  `Admin`							='".$admin."' ,
			  `secratery`						='".$secratery."' ,
			  `Supervisor`						='".$supervisor."' ,
			  `FSE`								='".$fse."' ,
			  `Salesman`						='".$salesman."'
			   where pk_sub_menu_id ='".$_POST['pk_sub_menu_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/edit_sub_menu/'.$_POST['pk_sub_menu_id'].'?msg=success');
    }
	
	public function insert_submenu() {
		$admin = 0;
		$secratery=0;
		$supervisor=0;
		$fse=0;
		$salesman=0;
		if (isset($_POST['Admin'])) $admin=1;
		if (isset($_POST['secratery'])) $secratery=1;
		if (isset($_POST['Supervisor'])) $supervisor=1;
		if (isset($_POST['FSE'])) $fse=1;
		if (isset($_POST['Salesman'])) $salesman=1;
		$query="INSERT into  `tbl_sub_menu` SET 	
			  `fk_main_menu_id`					='".$_POST['fk_main_menu_id']."' ,
			  `sub_menu`						='".$_POST['sub_menu']."' ,
			  `pre`								='".$_POST['pre']."' ,
			  `post`							='".$_POST['post']."' ,
			  `icon`							='".$_POST['icon']."' ,
			  `order`							='".$_POST['order']."' ,
			  `Admin`							='".$admin."' ,
			  `secratery`						='".$secratery."' ,
			  `Supervisor`						='".$supervisor."' ,
			  `FSE`								='".$fse."' ,
			  `Salesman`						='".$salesman."'";
			  $dbres = $this->db->query($query);
			  if (isset($_POST['re_id']) && $_POST['re_id']>0)
				  redirect(site_url() . 'sys/edit_main_menu/'.$_POST['re_id'].'?msg=added');
			  else
				  redirect(site_url() . 'sys/sub_menu?msg=success');
    }
	
	public function update_mainmenu() {
		
		$query="update  `tbl_main_menu` SET 	
			  `order`							='".$_POST['order']."' ,
			  `main_menu`						='".$_POST['main_menu']."' ,
			  `icon`							='".$_POST['icon']."'
			   where pk_main_menu_id ='".$_POST['pk_main_menu_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/edit_main_menu/'.$_POST['pk_main_menu_id'].'?msg=success');
    }
	
	public function insert_mainmenu() {
		
		$query="INSERT into  `tbl_main_menu` SET 
			  `main_menu`						='".$_POST['main_menu']."' ,
			  `icon`							='".$_POST['icon']."' ,
			  `order`							='".$_POST['order']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/main_menu?msg=success');
    }
	public function add_news_insert() {
		$query="insert  `tbl_news` SET 	
			  `news_title`				='".urlencode($_POST['news_title'])."',
			  `fk_office_id`				='".$_POST['office']."',
			  `news_description`		='".urlencode($_POST['news_description'])."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/news?msg=success');
    }
	
	public function add_policy_insert() {
		$query="insert INTO `tbl_policies` SET 	
			  `policy_title`				='".addslashes($_POST['policy_title'])."',
			  `order`				='".$_POST['order']."',
			  `policy`		='".$_POST['policy']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/add_policy?msg=success');
    }
	
	public function update_policy() {
		$query="UPDATE `tbl_policies` SET 	
			  `policy_title`		='".urlencode($_POST['policy_title'])."',
			  `order`				='".$_POST['order']."',
			  `policy`				='".$_POST['policy']."'
			  WHERE `pk_policy_id`	='".$_POST['pk_policy_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/policies?update_msg=success');
    }
	
	public function delete_policy($policy_id) {
		
			  $dbres = $this->db->query("DELETE FROM tbl_policies WHERE pk_policy_id='".$policy_id."'");
              redirect(site_url() . 'sys/policies?delete_msg=success');
    }
	
	public function insert_strategy() {
		$this->load->model("profile_model");
		$query ="INSERT INTO tbl_project_strategy SET 				  
								`target_date`				=	'".$this->profile_model->change_date_to_mysql_style($_POST['target_date'])."',
								`investment`				=	'".$_POST['investment']."',
								`sales_per_month`			=	'".$_POST['sales_per_month']."',
								`strategy`					=	'".urlencode($_POST['strategy'])."',
								`tactics`					=	'".urlencode($_POST['tactics'])."',
								`date`						=	'".date('Y-m-d H:i:s')."',
								`strategy_status`			=	'".$_POST['strategy_status']."',
								`fk_employee_id`			=	'".$this->session->userdata('userid')."',
					   			`fk_project_id`				= 	'".$_POST['fk_project_id']."'";
			
			  $dbres = $this->db->query($query);
			  if ($this->session->userdata('userrole')!= "Salesman")
				redirect(site_url() . 'sys/business_data');
			  else
				redirect(site_url() . 'sys/sap_projects');
    }
	
	public function update_strategy() {
		$this->load->model("profile_model");
				$query ="UPDATE tbl_project_strategy SET 				  
								`target_date`				=	'".$this->profile_model->change_date_to_mysql_style($_POST['target_date'])."',
								`investment`				=	'".$_POST['investment']."',
								`sales_per_month`			=	'".$_POST['sales_per_month']."',
								`strategy`					=	'".urlencode($_POST['strategy'])."',
								`tactics`					=	'".urlencode($_POST['tactics'])."',
								`strategy_status`			=	'1',
					   			`fk_project_id`				= 	'".$_POST['fk_project_id']."'
						WHERE 	`pk_project_strategy_id`	=	'".$_POST['pk_project_strategy_id']."'";
				$dbres = $this->db->query($query);
				
				if ($_POST['proj']==0)
              redirect(site_url() . 'sys/pending_business_data');
				else
					redirect(site_url() . 'sys/details_business_project/'.$_POST['fk_project_id']);
				//redirect(site_url() . 'sys/strategy_history/'.$_POST['fk_project_id']);
    }
	
	public function disapprove_strategy($id) {
		$this->load->model("profile_model");
				$query ="UPDATE tbl_project_strategy SET 
								`strategy_status`			=	'4'
						WHERE 	`pk_project_strategy_id`	=	'".$id."'";
				$dbres = $this->db->query($query);
				redirect(site_url() . 'sys/pending_business_data');
    }
	
	public function insert_warning_letter() {
		$this->load->model("profile_model");
		$query="insert  into `tbl_warning_letters` SET 	
			  `fk_employee_id`				='".$_POST['employee']."',
			  `official_comments`			='".urlencode($_POST['official_comments'])."',
			  `employee_comments`			='".urlencode($_POST['employee_comments'])."',
			  `date`						='".$this->profile_model->change_date_to_mysql_style($_POST['date'])."'";
			  $dbres = $this->db->query($query);
			  redirect(site_url() . 'sys/all_warning_letters?msg=success');
	}
	public function insert_fine() {
		$this->load->model("profile_model");
		$query="insert  into `tbl_fine` SET 	
			  `fk_employee_id`				='".$_POST['employee']."',
			  `fk_fine_code_id`				='".$_POST['fine']."',
			  `amount`						='".$_POST['amount']."',
			  `comments`					='".urlencode($_POST['comments'])."',
			  `status`						='Pending',
			  `date`						='".$this->profile_model->change_date_to_mysql_style($_POST['date'])."'";
			  $dbres = $this->db->query($query);
			  
			  //
			  $dbres = $this->db->query("select * from user where id ='".$_POST['employee']."'");
			  $res = $dbres->result_array();
			  $name = $res[0]['first_name'];
			  
			  $email		=	'info@mypmaonline.com';
			  
			  $dbres2 = $this->db->query("select * from tbl_fine_code where pk_fine_code_id ='".$_POST['fine']."'");
			  $res2 = $dbres2->result_array();
			  $fine = $res2[0]['description'];
			
			  $amount		=	$_POST['amount'];
			  $comments		=	$_POST['comments'];
			  $to 			=   $res[0]['company_email'];
			  //$to = 'zaaid@rozesolutions.com';
			  //$cc = 'sajjad.j@medialinkers.com';
				
			
			$subject ="Explanation Call";
			
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers.="From: $email \r\n";
			//$headers .= "CC: $cc\r\n";
			//$headers .= "BCC: hidden@special.com\r\n";
			$headers.="Return-Path: $email \r\n";
			
			$body = '<table width="650" border="0">
					   <tr bgcolor="#BDD5DF">
						<td colspan="2">New Explanation Call Added. Details are below:</td>
					  </tr>				  
					  <tr bgcolor="#D5D5D5">
						<td width="110">Employee Name:</td>
						<td width="265">'.$name.'</td>
					  </tr>
					   <tr bgcolor="#D5D5D5">
						<td>Explanation:</td>
						<td>'.$fine.'</td>
					  </tr>
					  <tr bgcolor="#D5D5D5">
						<td>Amount:</td>
						<td>'.$amount.'</td>
					  </tr>				 
					  <tr bgcolor="#D5D5D5">
						<td valign="top">Comments:</td>
						<td valign="top">'.$comments.'</td>
					  </tr>				  
					</table>';
			mail($to, $subject, $body, $headers);
			  //
			  
              redirect(site_url() . 'sys/all_fines?msg=success');
    }

    public function delete_leave($id) {

        $this->load->model("profile_model");
        $delete_allowed = '0';
        $lq 			= $this->db->query("select * from tbl_leaves where pk_leave_id ='".$id."'");
        $lr 				= $lq->result_array();

        $current_month	=	date('m');
        $current_year	=	date('Y');
        $leave_date = strtotime($lr[0]['start_date']);
		
		$leave_fine_id	=	$lr[0]['fk_fine_id'];
		
		if ($leave_fine_id!=0) {
			// Delete Fine
			$query="delete from tbl_fine where pk_fine_id = '".$leave_fine_id."'";
			$dbres = $this->db->query($query);
		}

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

        ///////////////////////////////////////////////////////////////

        if($delete_allowed == '1') {

			$dbres = $this->db->query("select * from user where id ='" . $lr[0]['fk_employee_id'] . "'");
            $res = $dbres->result_array();
            $total_leaves = $res[0]['total_leaves'];
			
			if($lr[0]['leave_type']=='1')
			{
				$leaves_total = $total_leaves - 0.5;
				//echo $leaves_total;exit;
			}
			else
			{
				$start_date = strtotime($lr[0]['start_date']);
				$end_date = strtotime($lr[0]['end_date']);
				///////////// Old Code /////////////////
				$datediff = $end_date - $start_date;
				$mydiffrence = floor($datediff / (60 * 60 * 24));
				$sub_leaves = $mydiffrence + 1;
				///////////// Old Code /////////////////
				///////////// New Code ////////////////
				
				$countd = 0;
				$sd = $start_date;
				$ed	= $end_date;
				while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
				  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
				  $sd = strtotime("+1 day", $sd);
				}
				$sub_leaves = $countd;
				
				//////////// New Code /////////////////
				$leaves_total = $total_leaves - $sub_leaves;
				//echo 'sanullah';exit;
			}
            $dbres_upt = $this->db->query("update user set total_leaves = $leaves_total where id ='" . $lr[0]['fk_employee_id'] . "'");
            //$res_upt = $dbres_upt->result_array();
        }

        //////////////////////////////////////////////////////////////

        $query="delete from  tbl_leaves  where `pk_leave_id` =$id";
        $dbres = $this->db->query($query);

        redirect(site_url() . 'sys/all_leaves?msg_delete=success');
    }
	
	public function delete_temporary_leave($id) {


        $query="delete from  tbl_temporary_leaves  where `pk_temporary_leave_id` =$id";
        $dbres = $this->db->query($query);

        redirect(site_url() . 'sys/pending_leaves?msg_delete=success');
    }
	
	
	public function insert_temporary_leaves()
	{
            $this->load->model("profile_model");
			$query = "insert  into `tbl_temporary_leaves` SET
				  `fk_employee_id`					='" . $_POST['employee'] . "',
				  `application_date`				='" . $this->profile_model->change_date_to_mysql_style($_POST['application_date']) . "',
				  `start_date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['start_date']) . "',
				  `end_date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['end_date']) . "',
				  `back_up`							='" . $_POST['backup_person'] . "',
				  `reason_of_leave`					='" . urlencode($_POST['reason_of_leave']) . "',
				  `fine_amount`						='" . $_POST['fine_amount'] . "',
				  `leave_code`						='" . $_POST['leave_code'] . "',
				  `fk_fine_code_id`					='" . $_POST['fk_fine_code_id'] . "',
				  `leave_type`					    ='" . $_POST['leave_type'] . "'
				  ";
            $dbres = $this->db->query($query);

            redirect(site_url() . 'sys/leave_form_t?msg=success');
	}
    public function insert_leave() {
        //check if temperary leave is filled then delete it
				if(isset($_POST['temprary_id']))
				{
				$query7 = "delete from   `tbl_temporary_leaves` where pk_temporary_leave_id = '".$_POST['temprary_id']."'";
                $dbres7 = $this->db->query($query7);
				}
		$this->load->model("profile_model");
        $lq 			= $this->db->query("select * from tbl_leaves where fk_employee_id ='".$_POST['employee']."' AND start_date='".$this->profile_model->change_date_to_mysql_style($_POST['start_date'])."'");
        $lr 				= $lq->result_array();
		$fineid		=	0;
        if(sizeof($lr)>=1) {
            redirect(site_url() . 'sys/leave_form?msg=already_exists');
        }
        else {
            if ($_POST['fine'] != 'Leave is taken within limit of 21 days') {
                $this->load->model("profile_model");
                $query = "insert  into `tbl_fine` SET
				  `fk_employee_id`				='" . $_POST['employee'] . "',
				  `date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['application_date']) . "',
				  `fk_fine_code_id`				='" . $_POST['fine'] . "',
				  `amount`						='" . $_POST['amount'] . "',
				  `comments`					='" . urlencode($_POST['official_comments']) . "',
				  `status`						='Pending'
				  ";
                $dbres = $this->db->query($query);
				
				
				
				//Get Fine Id of the Fine inserted above
				$fquery = "Select * from `tbl_fine` WHERE
					  `fk_employee_id`				='" . $_POST['employee'] . "' AND 
					  `date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['application_date']) . "  00:00:00' AND 
					  `fk_fine_code_id`				='" . $_POST['fine'] . "' AND 
					  `amount`						='" . $_POST['amount'] . "' AND 
					  `comments`					='" . urlencode($_POST['official_comments']) . "' AND 
					  `status`						='Pending'
					  ";
				$fq = $this->db->query($fquery);
				$fr = $fq->result_array();
				$fineid		=	$fr[0]['pk_fine_id'];
            }
			
			
			
			
            //Update total leavs in user table
            $dbres = $this->db->query("select * from user where id ='" . $_POST['employee'] . "'");
            $res = $dbres->result_array();
            $total_leaves = $res[0]['total_leaves'];
			if($_POST['leave_type']=='1')
			{
				$leaves_total = $total_leaves + 0.5;
			}
			else
			{
				$start_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['start_date']));
				$end_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['end_date']));
				$datediff = $end_date - $start_date;
				$mydiffrence = floor($datediff / (60 * 60 * 24));
				///////////// New Code ////////////////
				
				$countd = 0;
				$sd = $start_date;
				$ed	= $end_date;
				while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
				  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
				  $sd = strtotime("+1 day", $sd);
				}
				$sub_leaves = $countd;
				
				//////////// New Code ///////////////// 
				$leaves_total = $total_leaves + $countd;
				//$leaves_total = $total_leaves + $mydiffrence + 1;
			}
			
            $dbres_upt = $this->db->query("update user set total_leaves = $leaves_total where id ='" . $_POST['employee'] . "'");
            //$res_upt = $dbres_upt->result_array();

            //insert Leaves record in tbl_leave
            $query = "insert  into `tbl_leaves` SET
				  `fk_employee_id`					='" . $_POST['employee'] . "',
				  `application_date`				='" . $this->profile_model->change_date_to_mysql_style($_POST['application_date']) . "',
				  `start_date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['start_date']) . "',
				  `end_date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['end_date']) . "',
				  `back_up`							='" . $_POST['backup_person'] . "',
				  `official_comments`				='" . urlencode($_POST['official_comments']) . "',
				  `reason_of_leave`					='" . urlencode($_POST['reason_of_leave']) . "',
				  `fk_fine_code`					='" . $_POST['fine'] . "',
				  `amount`							='" . $_POST['amount'] . "',
				  `leave_type`					    ='" . $_POST['leave_type'] . "'
				  ";
				  
			if ($fineid != 0) $query.= ",`fk_fine_id` = '" . $fineid . "'";
            $dbres = $this->db->query($query);

            redirect(site_url() . 'sys/leave_form?msg=success');
        }
    }

    public function update_leave() {
		$fine_status	=	"Pending"; // Pending on Default
		$leave_id		=	$_POST['leave_id'];
		$leave_fine_id	=	$_POST['leave_fine_id'];
		
		$this->load->model("profile_model");
        $lq 			= $this->db->query("select * from tbl_leaves where pk_leave_id!='".$leave_id."' AND fk_employee_id ='".$_POST['employee']."' AND start_date='".$this->profile_model->change_date_to_mysql_style($_POST['start_date'])."'");
        $lr 				= $lq->result_array();
		$fineid		=	0;
        if(sizeof($lr)>=1) {
            redirect(site_url() . 'sys/update_leave_form/'.$leave_id.'?msg=already_exists');
        }
        else {
		
		if ($leave_fine_id!=0) {
			// Update Fine Status
			$sq=$this->db->query("select * from tbl_fine where pk_fine_id =  '".$leave_fine_id."'");
			$sr=$sq->result_array();
			$fine_status	=	$sr[0]["status"];
			// Delete Fine
			$query="delete from tbl_fine where pk_fine_id = '".$leave_fine_id."'";
			$dbres = $this->db->query($query);
		}
		
		//////////////////////////////////// Delete Leave ////////////////////////////////////////////////////
		$delete_allowed = '0';
        $lq 			= $this->db->query("select * from tbl_leaves where pk_leave_id ='".$leave_id."'");
        $lr 				= $lq->result_array();

        $current_month	=	date('m');
        $current_year	=	date('Y');
        $leave_date = strtotime($lr[0]['start_date']);

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

        ///////////////////////////////////////////////////////////////

        if($delete_allowed == '1') {

			$dbres = $this->db->query("select * from user where id ='" . $lr[0]['fk_employee_id'] . "'");
            $res = $dbres->result_array();
            $total_leaves = $res[0]['total_leaves'];
			
			if($lr[0]['leave_type']=='1')
			{
				$leaves_total = $total_leaves - 0.5;
				//echo $leaves_total;exit;
			}
			else
			{
				$start_date = strtotime($lr[0]['start_date']);
				$end_date = strtotime($lr[0]['end_date']);
				$datediff = $end_date - $start_date;
				$mydiffrence = floor($datediff / (60 * 60 * 24));
				///////////// New Code ////////////////
				
				$countd = 0;
				$sd = $start_date;
				$ed	= $end_date;
				while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
				  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
				  $sd = strtotime("+1 day", $sd);
				}
				$sub_leaves = $countd;
				
				//////////// New Code /////////////////
	
				//$sub_leaves = $mydiffrence + 1;
				$leaves_total = $total_leaves - $sub_leaves;
				//echo 'sanullah';exit;
			}
            $dbres_upt = $this->db->query("update user set total_leaves = $leaves_total where id ='" . $lr[0]['fk_employee_id'] . "'");
            //$res_upt = $dbres_upt->result_array();
        }

        //////////////////////////////////////////////////////////////

        $query="delete from  tbl_leaves  where `pk_leave_id` =$leave_id";
        $dbres = $this->db->query($query);
		
		//////////////////////////////////////////////// Delete Leave /////////////////////////////////////////////////////////
		
        
            if ($_POST['fine'] != 'Leave is taken within limit of 21 days') {
                $this->load->model("profile_model");
                $query = "insert  into `tbl_fine` SET
				  `fk_employee_id`				='" . $_POST['employee'] . "',
				  `date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['application_date']) . "',
				  `fk_fine_code_id`				='" . $_POST['fine'] . "',
				  `amount`						='" . $_POST['amount'] . "',
				  `comments`					='" . urlencode($_POST['official_comments']) . "',
				  `status`						='Pending'
				  ";
                $dbres = $this->db->query($query);
				
				//Get Fine Id of the Fine inserted above
				$fquery = "Select * from `tbl_fine` WHERE
					  `fk_employee_id`				='" . $_POST['employee'] . "' AND 
					  `date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['application_date']) . "  00:00:00' AND 
					  `fk_fine_code_id`				='" . $_POST['fine'] . "' AND 
					  `amount`						='" . $_POST['amount'] . "' AND 
					  `comments`					='" . urlencode($_POST['official_comments']) . "' AND 
					  `status`						='"	. $fine_status ."'
					  ";
				$fq = $this->db->query($fquery);
				$fr = $fq->result_array();
				$fineid		=	$fr[0]['pk_fine_id'];
            }
			
			
			
			
            //Update total leavs in user table
            $dbres = $this->db->query("select * from user where id ='" . $_POST['employee'] . "'");
            $res = $dbres->result_array();
            $total_leaves = $res[0]['total_leaves'];
			if($_POST['leave_type']=='1')
			{
				$leaves_total = $total_leaves + 0.5;
			}
			else
			{
				$start_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['start_date']));
				$end_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['end_date']));
				$datediff = $end_date - $start_date;
				$mydiffrence = floor($datediff / (60 * 60 * 24));
				///////////// New Code ////////////////
				
				$countd = 0;
				$sd = $start_date;
				$ed	= $end_date;
				while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
				  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
				  $sd = strtotime("+1 day", $sd);
				}
				$sub_leaves = $countd;
				
				//////////// New Code ///////////////// 
				$leaves_total = $total_leaves + $countd;
				//$leaves_total = $total_leaves + $mydiffrence + 1;
			}
			
            $dbres_upt = $this->db->query("update user set total_leaves = $leaves_total where id ='" . $_POST['employee'] . "'");
            //$res_upt = $dbres_upt->result_array();

            //insert Leaves record in tbl_leave
            $query = "insert  into `tbl_leaves` SET
				  `fk_employee_id`					='" . $_POST['employee'] . "',
				  `application_date`				='" . $this->profile_model->change_date_to_mysql_style($_POST['application_date']) . "',
				  `start_date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['start_date']) . "',
				  `end_date`						='" . $this->profile_model->change_date_to_mysql_style($_POST['end_date']) . "',
				  `back_up`							='" . $_POST['backup_person'] . "',
				  `official_comments`				='" . urlencode($_POST['official_comments']) . "',
				  `reason_of_leave`					='" . urlencode($_POST['reason_of_leave']) . "',
				  `fk_fine_code`					='" . $_POST['fine'] . "',
				  `amount`							='" . $_POST['amount'] . "',
				  `leave_type`					    ='" . $_POST['leave_type'] . "'
				  ";
				  
			if ($fineid != 0) $query.= ",`fk_fine_id` = '" . $fineid . "'";
            $dbres = $this->db->query($query);

            redirect(site_url() . 'sys/all_leaves?msg_update=success');
        }
    }

    public function update_fine_insert() {
		if(isset($_POST['comments_employee']))
		{
			$query="update `tbl_fine` SET 	
			  `comments_employee`					='".urlencode($_POST['comments_employee'])."'
			  where pk_fine_id = '".$_POST['pk_fine_id']."'";
		}
		else
		{
			$query="update `tbl_fine` SET 	
			  `comments`					='".urlencode($_POST['comments'])."',
			  `status`						='".$_POST['status']."'
			  where pk_fine_id = '".$_POST['pk_fine_id']."'";
		}
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/all_fines?msg_update=success');
    }
	public function update_warning_letter_insert() {
		if(isset($_POST['employee_comments']))
		{
			$query="update `tbl_warning_letters` SET 	
			  `employee_comments`					='".urlencode($_POST['employee_comments'])."'
			  where pk_warning_letter_id = '".$_POST['pk_warning_letter_id']."'";
		}
		else
		{
			$query="update `tbl_warning_letters` SET 	
			  `official_comments`					='".urlencode($_POST['official_comments'])."',
			  `status`						='".$_POST['status']."'
			  where pk_warning_letter_id = '".$_POST['pk_warning_letter_id']."'";
		}
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/all_warning_letters?msg_update=success');
    }
	public function select_fine_amount_ajax() {
		if ($this->input->post('fine_id')!='')
		{
			if($this->input->post('fine_id')=='21')
			{
				$query1="select * from user WHERE `id`=".$this->input->post('employee');
				$dbres1 = $this->db->query($query1);
				$res = $dbres1->result_array();
				$salery = $res[0]['salary'];
				$per_day_salary = $salery/30;
				//
				if($this->input->post('leave_type')=='1')
				{
					$per_day_salary = $per_day_salary/2;
					echo round($per_day_salary,0);
				}
				else
				{
					$this->load->model('profile_model');
					$start_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['start_date']));
					$end_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['end_date']));
					$datediff = $end_date - $start_date;
					$mydiffrence = floor($datediff / (60 * 60 * 24));
					$mydiffrence = $mydiffrence + 1;
					///////////// New Code ////////////////
				
				$countd = 0;
				$sd = $start_date;
				$ed	= $end_date;
				while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
				  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
				  $sd = strtotime("+1 day", $sd);
				}
				$sub_leaves = $countd;
				
				//////////// New Code /////////////////
				$mydifference =  $countd;
					$these_days_salary = $per_day_salary*$mydiffrence;
					echo round($these_days_salary,0);
				}
			}
			elseif($this->input->post('fine_id')=='22')
			{
				$query1="select * from user WHERE `id`=".$this->input->post('employee');
				$dbres1 = $this->db->query($query1);
				$res = $dbres1->result_array();
				$salery = $res[0]['salary'];
				$per_day_salary = $salery/30;
				//
				if($this->input->post('leave_type')=='1')
				{
					$per_day_salary = $per_day_salary/2;
					echo round($per_day_salary,0);
				}
				else
				{
					$this->load->model('profile_model');
					$start_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['start_date']));
					$end_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['end_date']));
					$datediff = $end_date - $start_date;
					$mydiffrence = floor($datediff / (60 * 60 * 24));
					$mydiffrence = $mydiffrence + 1;
					///////////// New Code ////////////////
				
				$countd = 0;
				$sd = $start_date;
				$ed	= $end_date;
				while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
				  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
				  $sd = strtotime("+1 day", $sd);
				}
				$sub_leaves = $countd;
				
				//////////// New Code /////////////////
				$mydifference = $countd;
					$these_days_salary = $per_day_salary*$mydiffrence;
					$these_days_salary_plus_500 =  round($these_days_salary,0) + 500;
					echo $these_days_salary_plus_500;
				}
			}
			else
			{
				$query="select * from tbl_fine_code where pk_fine_code_id='".$this->input->post('fine_id')."'";
				$dbres = $this->db->query($query);
				$nns=$dbres->result_array();
				echo $nns[0]['amount'];
			}
		}
    }
	
	public function select_leave_code_amount_ajax() {
			$these_days_salary = 0;
			$fine_without_form = 0;
			$fine_amount = 0;
			$total_leaves = 0;
			$available_leaves = 0;
			$remaining_leaves = 0;
			$leaves_applied = 0;
			$leaves_chargable = 0;
			$form_submission = 0;
			$leave_code = "";
			$today = date('Y-m-d');
			$show_code_amount = 0;
			$fk_fine_code_id = 0;
			/// Without form fine value
			$query="select * from tbl_fine_code where pk_fine_code_id='23'";
			$dbres = $this->db->query($query);
			$nns=$dbres->result_array();
			$fine_without_form = $nns[0]['amount']; // Without prior approval and submit form fine value i.e. 500
			
			////////////////// Per Day Salary
			$query1="select * from user WHERE `id`=".$this->input->post('employee');
			$dbres1 = $this->db->query($query1);
			$res = $dbres1->result_array();
			$salery = $res[0]['salary'];
			$per_day_salary = $salery/30; ////// Per day salary of respective user Important Value
			
			
											$total_leaves = $res[0]["total_leaves"];
			////////////////////////////// Calculating available Leaves
											
											$start_month	=	7; // July
											 $available_leaves	=	21;
											 $leaves_per_month	=	$available_leaves/12;
											 $working_months_current_year	=	12; ////////////total months  for which leaves will be given
											 $current_month	=	date('m');
											 $current_year	=	date('Y');
											 $previous_year	=	date('Y')-1;
											 $join_date		= 	$res[0]["date_of_joining"];
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
											 
					/// Finding leaves_applied
				if($this->input->post('leave_type')=='1')
				{
					////////////////// Finding form submission as a side activity 
					/*
								$today = date('Y-m-d');
								if ( ($_POST['start_date']!="")&& (date('Y-m-d', strtotime($_POST['start_date'])) >= $today) ) $form_submission = 1;
					$leaves_applied = 0.5;
					$show_code_amount = 1;
					*/
					$per_day_salary = $per_day_salary * 0.5;
				}
				//else {
					$this->load->model('profile_model');
					
					if ($_POST['start_date'] != "" && $_POST['end_date']!="") {
						$show_code_amount = 1;
						$start_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['start_date']));
						$end_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['end_date']));
					}
					else {
					$start_date = strtotime($this->profile_model->change_date_to_mysql_style(date('Y-m-d')));
					$end_date = strtotime($this->profile_model->change_date_to_mysql_style(date('Y-m-d')));
					}
								////////////////// Finding form submission as a side activity
								$today = date('Y-m-d');
								if ($_POST['application_date'] != "") $today = date('Y-m-d',strtotime($_POST['application_date']));
								if (date('Y-m-d', $start_date) >= $today) $form_submission = 1;
					$datediff = $end_date - $start_date;
					$mydiffrence = floor($datediff / (60 * 60 * 24));
					$mydiffrence = $mydiffrence + 1;
					///////////// New Code ////////////////
				
					$countd = 0;
					$sd = $start_date;
					$ed	= $end_date;
					while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
					  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
					  $sd = strtotime("+1 day", $sd);
					}
					$sub_leaves = $countd;
					$leaves_applied = $countd;
			//	}
				
				///// Finding Chargable Leaves
				if ($remaining_leaves <=0) $leaves_chargable = $leaves_applied;
				else if ($remaining_leaves > 0 && $leaves_applied <= $remaining_leaves) $leaves_chargable = 0;
				else if ($remaining_leaves > 0 && $leaves_applied > $remaining_leaves) $leaves_chargable = $leaves_applied - $remaining_leaves;
				
				/// Finding Leave Code
				if ( $leaves_chargable == 0 && $form_submission == 1) {
					$leave_code = "Leave is taken within limit of 21 days";
					$fine_amount = 0;
					$fk_fine_code_id = 0;
				}
				if ( $leaves_chargable == 0 && $form_submission==0) {
					$leave_code = "Leave is taken within limit of 21 days(without Form Submission & Prior approval)";
					$fine_amount = $fine_without_form;
					$fk_fine_code_id = 23;
				}
				if ( $leaves_chargable > 0 && $form_submission==0) {
					$leave_code = "Leave is taken above limit of 21 days(without Form Submission & Prior approval)";
					$these_days_salary = $per_day_salary*$leaves_chargable;
					$fine_amount = round($these_days_salary,0)+ $fine_without_form;
					$fk_fine_code_id = 22;
				}
				if ( $leaves_chargable > 0 && $form_submission == 1) {
					$leave_code = "Leave is taken above limit of 21 days(with Form Submission)";
					$these_days_salary = $per_day_salary*$leaves_chargable;
					$fine_amount = round($these_days_salary,0);
					$fk_fine_code_id = 21;
				}
				//$start_date = strtotime($this->profile_model->change_date_to_mysql_style($_POST['start_date']));
				
				//if ($show_code_amount == 1 && date('Y-m-d',$_POST['start_date']) < date('Y-m-d',$_POST['end_date']))  {
				if ($show_code_amount == 1)  { 
					echo '
						
					<div class="form-group">
						<label class="col-md-3 control-label">Leave Code</label>
						<div class="col-md-9" style="padding:20px;">
								'.$leave_code.'
						</div>';
						if ($fk_fine_code_id != 0) echo '<input type="hidden" class="form-control" name="fine" id="fine" value="'.$fk_fine_code_id.'">';
						else echo '<input type="hidden" name="fine" id="fine" value="Leave is taken within limit of 21 days">';
					echo	'<input type="hidden" name="leave_code" id="leave_code" value="'.$leave_code.'" >
						<input type="hidden" name="fk_fine_code_id" id="fk_fine_code_id" value="'.$fk_fine_code_id.'" >
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" >Amount</label>
						<div class="col-md-8" style="padding:20px;">
								<p>'.$fine_amount.'</p>
								<table class="table table-condensed table-striped table-bordered table-hover">
									<thead>
										<tr class="bg-grey">
											<td>Leaves Available</td>
											<td>Leaves Taken</td>
											<td>Leaves Balance</td>
											<td>Leaves Applied</td>
											<td>Leaves Above Available Quota</td>
											<td>Salary (/day)</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>'.$available_leaves.'</td>
											<td>'.$total_leaves.'</td>
											<td>'.$remaining_leaves.'</td>
											<td>'.$leaves_applied.'</td>
											<td>'.$leaves_chargable.'</td>
											<td>'.$per_day_salary.'</td>
										</tr>
									</tbody>
								</table>
						</div>
						<input type="hidden" name="fine_amount" id="fine_amount" value="'.$fine_amount.'" >
						<input type="hidden" name="amount" id="amount" value="'.$fine_amount.'">
					</div>'; 
				}
				else {
					echo '<div class="form-group">
						<label class="col-md-3 control-label">Leave Code</label>
						<div class="col-md-8">
								<h3></h3>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Amount</label>
						<div class="col-md-8">
								<h3></h3>
						</div>
					</div>';
				}
				
				
		
    }
	
	
	public function select_remaining_leaves_ajax() {
				$query1="select * from user WHERE `id`=".$this->input->post('employee_id');
				$dbres1 = $this->db->query($query1);
				$res = $dbres1->result_array();
				$leaves = $res[0]['total_leaves'];
				$remaining_leaves = 21 - $leaves;
				echo "Total Leaves = ".round($leaves,1);
    }
	public function status_pending_sv_ajax() {
	
		$query1="select * from tbl_complaints WHERE `pk_complaint_id`=".$this->input->post('complaint_id');
		$dbres1 = $this->db->query($query1);
		$dbresult= $dbres1->result_array();
		if($dbresult[0]['status']=='Pending (BB)')
		{
			//$com_status='Pending Verification (BB)';
			$com_status='Pending Verification';
		}
		else
		{
			$com_status='Pending Verification';
		}
		
		$query="update tbl_complaints SET status='".$com_status."' where pk_complaint_id='".$this->input->post('complaint_id')."'";
		//$query="update tbl_complaints SET status='Pending Verification' where pk_complaint_id='".$this->input->post('complaint_id')."'";
		$dbres = $this->db->query($query);
		//echo 'Status Updated to Pending SV';
		redirect(site_url() . 'sys/technical_service_pvr/'.$this->input->post('complaint_id'));
    }
	
	public function all_fines() {
		
		$this->load->view("sys/all_fines");
    }
	public function all_warning_letters() {
		
		$this->load->view("sys/all_warning_letters");
    }
	public function assign_pm() {
		
		$query="select `fk_office_id` from user where `id` ='".$this->session->userdata('userid')."'";
		$query_db=$this->db->query($query);
		$result=$query_db->result_array();
		////////////////////////////////////
		$query="select `fk_office_id` from tbl_instruments where `pk_instrument_id` ='".$this->uri->segment(3)."'";
		$query_db=$this->db->query($query);
		$user_complaints=$query_db->result_array();
		if (sizeof($user_complaints)>0) {
			if ($user_complaints[0]['fk_office_id']!=$result[0]['fk_office_id'] && $this->session->userdata('userrole')=='Supervisor')
			{
				show_404();
			}
		}
		if($this->session->userdata('userrole')!='Supervisor' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view("sys/assign_pm");
    }
	public function update_fine($id) {
		if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			$query="select `fk_employee_id` from tbl_fine where `pk_fine_id` ='".$this->uri->segment(3)."'";
			$query_db=$this->db->query($query);
			$user_fine=$query_db->result_array();			
			if ($user_fine[0]['fk_employee_id']!=$this->session->userdata('userid'))
			{
				show_404();
			}
		}
		$this->load->view("sys/update_fine");
    }
	public function update_warning_letter($id) {
		$this->load->view("sys/update_warning_letter");
    }
	
	public function update_news() {
        if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
        $this->load->view('sys/update_news');
    }
	public function sap_statistics() {
        if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
        $this->load->view('sys/sap_statistics');
    }
	
	public function update_product() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/update_product');
    }
	public function update_category() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/update_categories');
    }
	
	public function update_category_insert() {
		$query="update  `tbl_category` SET 	
			  `category_name`						='".$_POST['category_name']."'
			   where pk_category_id ='".$_POST['pk_category_id']."'";
			  //`fk_type_id`							='".$_POST['type_name']."'
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/update_category/'.$_POST['pk_category_id'].'?msg=success');
    }
	public function update_news_insert() {
		$query="update  `tbl_news` SET 	
			  `news_title`				='".urlencode($_POST['news_title'])."',
			  `news_description`		='".urlencode($_POST['news_description'])."',
			  `fk_office_id`		='".$_POST['office']."'
			  
			  where `pk_news_id` ='".$_POST['pk_news_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/update_news/'.$_POST['pk_news_id'].'?msg=success');
    }
	public function delete_news($id) {
		$query="delete from  tbl_news  where `pk_news_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/news?msg_delete=success');
    }
	public function delete_vendor($id) {
		//$query="delete from  tbl_vendors  where `pk_vendor_id` =$id";
		$query="update  tbl_vendors SET `status`='1' where `pk_vendor_id` =$id";
		$dbres = $this->db->query($query);
		//
		$query2="delete from  tbl_vendor_category_bridge  where `fk_vendor_id` =$id";
		$dbres2 = $this->db->query($query2);
		//
		$query3="delete from  tbl_vendor_product_bridge  where `fk_vendor_id` =$id";
		$dbres3 = $this->db->query($query3);
		//
		redirect(site_url() . 'sys/vendors?msg_delete=success');
    }
	
	public function delete_category($id) {
		$query="update  tbl_category  
				SET 	
			   `status`				='1'
				where `pk_category_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/categories?msg_delete=success');
    }
	
	public function delete_city($id) {
		$query="update  tbl_cities  
				SET 	
			   `status`				='1'
				where `pk_city_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/cities?msg_delete=success');
    }
	public function delete_area($id) {
		$query="delete from  tbl_area 
				where `pk_area_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/areas?msg_delete=success');
    }
	
	public function delete_product($id) {
		$query="update  tbl_products 
				SET 	
			   `status`				='1'
				where `pk_product_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/products?msg_delete=success');
    }
	
	public function delete_complaint($id) {
		$query="delete from  tbl_complaints  where `pk_complaint_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/director_view_complaints?msg_delete=success');
    }
	
	public function delete_pm($id) {
		$query="delete from  tbl_complaints  where `pk_complaint_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/director_view_pm?msg_delete=success');
    }
	
	public function business_data() {
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->model("complaint_model");
			$business_data = $this->complaint_model->get_business_data_model();
			$this->load->view('/sys/business_data', array("business_data" => $business_data));
		}
		else
		{
		show_404();
		}
    }
	
	public function deleted_business_data() {
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->model("complaint_model");
			$business_data = $this->complaint_model->get_deleted_business_data_model();
			$this->load->view('/sys/deleted_business_data', array("business_data" => $business_data));
		}
		else
		{
		show_404();
		}
    }
	
	public function pending_business_data() {
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->model("complaint_model");
			$business_data = $this->complaint_model->get_pending_business_data_model();
			$this->load->view('/sys/pending_business_data', array("business_data" => $business_data));
		}
		else
		{
		show_404();
		}
    }
	
	public function add_acs() {
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('add_acs');
    }
	
	public function vendor_registration() {
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/vendor_registration');
    }
	
	public function equipment_registration() {
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/equipment_registration');
    }
	
	public function policies() {
        $this->load->view('policies');
    }
	public function forms() {
        $this->load->view('forms');
    }
	public function forms_pm() {
        $this->load->view('forms_pm');
    }
	public function tssop() {
		if($this->session->userdata('userrole')=='Salesman')
		{
			show_404();
		}
        $this->load->view('tssop');
    }
	public function salessop() {
		if($this->session->userdata('userrole')=='FSE')
		{
			show_404();
		}
        $this->load->view('salessop');
    }
	
	public function insert_acs() {
        $sad=$this->db->query("insert into tbl_customer_sap_bridge set fk_user_id='".$_POST['user']."', fk_client_id='".$_POST['client']."'");
		if ($_POST['redirect_customer']=="yes")
			redirect(site_url() . 'sys/edit_customer/'.$_POST['client']);
		else
		redirect(site_url() . 'sys/acs?msg=success');
    }
	
	// Delete Compose Message.
	public function add_complaint()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/add_complaint');
	}
	public function add_complaint_half()
	{
        $this->load->view('sys/add_complaint_half');
	}
	
	public function comments() {
		
		if ($this->uri->segment(3) == "") show_404(); 
		$complaint_id	=	$this->uri->segment(3);
		if ($this->session->userdata('userid')!=""){
			
			$employee_territory		=	$this->session->userdata('territory');
			$employee_id			=	$this->session->userdata('userid');
			$employee_role			=	$this->session->userdata('userrole');
		}
		else show_404();
		/*
		$query="select `fk_office_id` from user where `id` ='".$this->session->userdata('userid')."'";
		$query_db=$this->db->query($query);
		$result=$query_db->result_array(); */
		////////////////////////////////////
		
		$query="select `fk_office_id`,`assign_to` from tbl_complaints where `pk_complaint_id` ='".$complaint_id."'";
		$query_db=$this->db->query($query);
		$user_complaint=$query_db->result_array();	
		
		if (sizeof($user_complaint)==0) show_404();
		else { 
			$assign_to	=	$user_complaint[0]['assign_to'];
			$office_id	=	$user_complaint[0]['fk_office_id'];
			if ($employee_role	==	"FSE" || $employee_role	==	"Salesman" ){
				if ($assign_to != $employee_id) show_404();
				else {
					$query="UPDATE tbl_comments SET `read_employee`='1' where `fk_complaint_id` ='".$complaint_id."'";
					$query_db=$this->db->query($query);
				}
			}
			elseif ($employee_role	==	"Supervisor"){
				if ($office_id != $employee_territory) show_404();
				else {
					$query="UPDATE tbl_comments SET `read_supervisor`='1' where `fk_complaint_id` ='".$complaint_id."'";
					$query_db=$this->db->query($query);
					if ($assign_to == $employee_id) {
						$query="UPDATE tbl_comments SET `read_employee`='1' where `fk_complaint_id` ='".$complaint_id."'";
						$query_db=$this->db->query($query);
					}
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
		} 
		$this->load->view('sys/comments');
	}
	
	public function add_comment() {
		$current_date	= 	date('Y-m-d H:i:s');
		$employee_id	=	$this->session->userdata('userid');
		$comment  		=	$_POST['comment'];
		$complaint_id	=	$_POST['fk_complaint_id'];
		
		$query="insert into tbl_comments SET 				
								`date`						=	'".$current_date."',
								`fk_employee_id`  			=	'".$employee_id."',
								`fk_complaint_id`  			=	'".$complaint_id."',
								`comment`					=	'".urlencode($comment)."'
							  ";
		$dbres = $this->db->query($query);
		redirect(site_url() . 'sys/comments/'.$_POST['fk_complaint_id']);
	}
	
	public function add_comment_2() {
		$current_date	= 	date('Y-m-d H:i:s');
		$employee_id	=	$this->session->userdata('userid');
		$comment  		=	$_POST['comment'];
		$complaint_id	=	$_POST['fk_complaint_id'];
		
		$query="insert into tbl_comments SET 				
								`date`						=	'".$current_date."',
								`fk_employee_id`  			=	'".$employee_id."',
								`fk_complaint_id`  			=	'".$complaint_id."',
								`comment`					=	'".urlencode($comment)."'
							  ";
		$dbres = $this->db->query($query);
		redirect(site_url() . 'sys/'.$_POST['page_name'].'/'.$_POST['fk_complaint_id']."#messages");
	}
	public function add_customer()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('sys/add_customer');
	}
	
	public function director_view_complaints()
	{
        if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_complaint_model();
		$this->load->view('sys/director_view_complaints', array("get_complaint_list" => $get_complaint_list));
	}
	public function director_view_pm()
	{
        if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
		$this->load->view('sys/director_view_pm');
	}

	public function update_pm()
	{
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/update_pm');
	} 

	public function update_pm_insert() {
		$new_date	=	date("Y-m-d H:i",strtotime($_POST['date']));
		$query="update  `tbl_complaints` SET 	
			  `date`						='".$new_date."' ,
			  `assign_to`							='".$_POST['assign_to']."'
			   where pk_complaint_id ='".$_POST['pk_complaint_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'sys/update_pm/'.$_POST['pk_complaint_id'].'?msg=success');
    }
	
	public function operator_view_complaints()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_complaint_model();
		if ($this->session->userdata('userrole')=='Admin')
			$this->load->view('sys/director_view_complaints', array("get_complaint_list" => $get_complaint_list));
		else
			$this->load->view('sys/operator_view_complaints', array("get_complaint_list" => $get_complaint_list));
	}
	public function view_half_complaints()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/view_half_complaints');
	}
	public function add_complaint_registration()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/add_complaint_registration');
	}
	
	public function supervisor_dvr()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_sup_dvr = $this->complaint_model->get_sup_dvr_model();
		$this->load->view('sys/supervisor_dvr', array("get_sup_dvr" => $get_sup_dvr));
	}
	public function supervisor_vs()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->view('sys/supervisor_vs');
	}
	public function engineer_dvr()
	{
		$this->load->model("complaint_model");
        $get_eng_dvr = $this->complaint_model->get_eng_dvr_model();
		$this->load->view('sys/engineer_dvr', array("get_eng_dvr" => $get_eng_dvr));
	}
	
	public function admin_dvr_form()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/admin_dvr_form');
		}
		else
		{
		show_404();
		}
	}
	
	public function create_pef()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/create_pef');
	}
	public function pef_schedule_insert()
	{
			 //echo "sana";exit;
			 $this->load->model("profile_model");
			 $prevoios_pef=$this->db->query("select MAX(due_date) as maxdate from tbl_pef_schedule");
			 $prvoios_result = $prevoios_pef->result_array();
			 //
			 //echo $prvoios_result['maxdate'];exit;
			 $maxdate = date('Ymd',strtotime($prvoios_result[0]['maxdate']));
			 $expiry_date = $this->profile_model->change_date_to_mysql_style($_POST['expiry_date']);
			 $expiry_date = date('Ymd',strtotime($expiry_date));
			 //echo "maxdate=".$maxdate."    expiry_date=".$expiry_date;exit;
			 $today_date = date('Ymd');
			 if($maxdate > $today_date)
			 {
				 redirect(site_url() . 'sys/create_pef?msg=failure');
			 }
			 elseif($maxdate >= $expiry_date)
			 {
				 $maxdate2 = date('d-M-Y',strtotime($prvoios_result[0]['maxdate']));
				 redirect(site_url() . "sys/create_pef?msg=failure2&maxdat=$maxdate2");
			 }
			 elseif($today_date == $expiry_date)
			 {
				 redirect(site_url() . "sys/create_pef?msg=failure3");
			 }
			 else
			 {
			  $employees = implode(",",$_POST['employees']);
			  $query="insert  `tbl_pef_schedule` SET 	
			  `duration`		='".$_POST['duration']."',
			  `due_date`		='".$this->profile_model->change_date_to_mysql_style($_POST['expiry_date'])."',
			   user_ids          ='$employees'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  foreach($_POST['employees'] as $myemployee)
			  {
				  $query="update user   SET 	
				  `pef_expriy_date`		='".$this->profile_model->change_date_to_mysql_style($_POST['expiry_date'])."'
				   where id             ='$myemployee'";
				  //echo $query;exit;
				  $dbres = $this->db->query($query);
			  }
              redirect(site_url() . 'sys/create_pef?msg=success');
			 }
	}
	public function employee_view_pef()
	{
		$this->load->view('sys/employee_view_pef');
	}
	public function pef_employee()
	{
		$this->load->view('sys/pef_employee');
	}
	public function director_view_pef()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/director_view_pef');
	}
	
	public function engineer_dvr_form()
	{
		//echo $this->session->userdata('userrole');exit;
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor'  || $this->session->userdata('userrole')=='Salesman')
		{
			$this->load->model("complaint_model");
        $get_eng_dvr = $this->complaint_model->get_eng_dvr_model();
		$this->load->view('sys/engineer_dvr_form', array("get_eng_dvr" => $get_eng_dvr));
		}
		else
		{
		show_404();
		}
	}
	public function leave_form()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/leave_form');
		}
		else
		{
		show_404();
		}
	}
	public function leave_form_t()
	{
		$this->load->view('sys/leave_form_t');
		/*if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			
		}
		else
		{
		show_404();
		}*/
	}
	
	public function update_leave_form()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/update_leave_form');
		}
		else
		{
		show_404();
		}
	}
	
	public function all_leaves()
	{
		//if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		if($this->session->userdata('userrole')!='')
		{
			$this->load->view('sys/all_leaves');
		}
		else
		{
		show_404();
		}
	}
	
	public function submitted_leaves()
	{
		//if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		if($this->session->userdata('userrole')!='')
		{
			$this->load->view('sys/submitted_leaves');
		}
		else
		{
		show_404();
		}
	}
	
	public function disapprove_leave($id)
	{
		//if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		$myquery=" UPDATE tbl_temporary_leaves SET `status`='1' WHERE `pk_temporary_leave_id` =  '".$id."'";
		$ty22=$this->db->query($myquery);
		redirect(site_url() . 'sys/pending_leaves?msg_disapproved=success');
	}
	
	public function pending_leaves()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/pending_leaves');
		}
		else
		{
		show_404();
		}
	}
	
	public function resset_all_employees_leaves()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$year = date('Y');
			$year = $year - 1;
			$q = $this->db->query("SELECT * FROM user");
			$r = $q->result_array();
			
			foreach ($r AS $user) {
				$this->db->query("INSERT INTO tbl_leaves_sum (`fk_user_id`,`year`,`total_leaves`) VALUES ('".$user['id']."','".$year."','".$user['total_leaves']."')");
			}
			///////////// ABOVE is NEW code for saving previous year employee data
			$maxqu = $this->db->query("update user SET total_leaves='0'");
			redirect(site_url() . 'sys/all_leaves?msg_set_total=success');
		}
		else
		{
		show_404();
		}
	}
	
	
	public function sap_dvr()
	{
		$this->load->model("complaint_model");
        $get_eng_dvr = $this->complaint_model->get_eng_dvr_model();
		$this->load->view('sys/sap_dvr', array("get_eng_dvr" => $get_eng_dvr));
	}
	public function sap_dvr_form()
	{
		if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_eng_dvr = $this->complaint_model->get_eng_dvr_model();
		$this->load->view('sys/sap_dvr_form', array("get_eng_dvr" => $get_eng_dvr));
	}
	public function sap_asc()
	{
		if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_eng_dvr = $this->complaint_model->get_eng_asc_model();
		$this->load->view('sys/sap_asc', array("get_eng_dvr" => $get_eng_dvr));
	}
	//
	public function all_employee_dvr_vs_y()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/all_employee_dvr_vs_y');
		}
		else
		{
		show_404();
		}
	}
	public function all_employee_dvr_vs()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/all_employee_dvr_vs');
		}
		else
		{
		show_404();
		}
	}
	
	public function all_employee_dvr()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/all_employee_dvr');
		}
		else
		{
		show_404();
		}
	}
	//
	//
	public function all_employee_vs()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/all_employee_vs');
		}
		else
		{
		show_404();
		}
	}
	public function dc()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/dc');
		}
		else
		{
		show_404();
		}
	}
	public function dc_print()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/dc_print');
		}
		else
		{
		show_404();
		}
	}
	
	//
	public function engineer_asc()
	{
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor')
		{
			$this->load->model("complaint_model");
        	$get_eng_dvr = $this->complaint_model->get_eng_asc_model();
			$this->load->view('sys/engineer_asc', array("get_eng_dvr" => $get_eng_dvr));
		}
		else
		{
			show_404();
		}
	}
	public function engineer_statistics() {
		
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor')
		{
			$this->load->model("complaint_model");
        	$get_eng_dvr = $this->complaint_model->get_eng_asc_model();
			$this->load->view('sys/engineer_statistics', array("get_eng_dvr" => $get_eng_dvr));
		}
		else
		{
		show_404();
		}
    }
	public function director_statistics() {
		
		if($this->session->userdata('userrole')=='Admin')
		{
			$this->load->view('sys/director_statistics');
		}
		else
		{
			show_404();
		}
    }
	public function engineer_vs()
	{
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor')
		{
			// $this->load->model("complaint_model");
        	// $get_eng_vs = $this->complaint_model->get_eng_vs_model();
			// $this->load->view('sys/engineer_vs', array("get_eng_vs" => $get_eng_vs));
			
			$engineer = $this->session->userdata('userid');
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d', strtotime('-30 days'));
			if(isset($_POST['engineer'])){
				$engineer = $_POST['engineer'];
			}
				$dbres = $this->db->query("SELECT tbl_dvr.*,
				COALESCE(tbl_offices.office_name) AS office_name,
				COALESCE(tbl_clients.client_name) AS client_name,
				COALESCE(tbl_area.area) AS area
				FROM tbl_dvr 
				LEFT JOIN tbl_offices ON tbl_dvr.fk_customer_id = tbl_offices.client_option
				LEFT JOIN tbl_clients ON tbl_dvr.fk_customer_id=tbl_clients.pk_client_id 
				LEFT JOIN tbl_area ON tbl_clients.fk_area_id=tbl_area.pk_area_id 
				where tbl_dvr.fk_engineer_id = '".$engineer."' AND CAST(tbl_dvr.`date` AS DATE) between '".$end_date."' AND '".$start_date."' 
				order by tbl_dvr.date DESC");
				$dbresResult=$dbres->result_array();
				$dbres2 = $this->db->query("SELECT * FROM user where id = '".$engineer."' ");
				$dbresResult2=$dbres2->result_array();
				
				$this->load->view('sys/engineer_vs', array("get_eng_dvr" => $dbresResult,
																"eng_id" 	 => $engineer,
																"userrole"   => $dbresResult2['0']['userrole']));
		}
		else
		{
			show_404();
		}
	}
	
	public function engineer_vs_new()
	{
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor' || $this->session->userdata('userrole')=='Admin' )
		{
			$this->load->model("complaint_model");
        	$get_eng_vs = $this->complaint_model->get_eng_vs_model();
			$this->load->view('sys/engineer_vs_new', array("get_eng_vs" => $get_eng_vs));
		}
		else
		{
			show_404();
		}
	}
	
	public function sap_vs()
	{
		if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_eng_vs = $this->complaint_model->get_eng_vs_model();
		$this->load->view('sys/sap_vs', array("get_eng_vs" => $get_eng_vs));
	}
	public function sap_dvr_history()
	{
		if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
		$this->load->view('sys/sap_dvr_history');
	}
	public function engineer_dvr_history()
	{
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor')
		{
			$this->load->view('sys/engineer_dvr_history');
		}
		else
		{
			show_404();
		}
	}
	public function get_date_dvr()
	{
		$start_mydate=$this->input->post('start_mydate');
		$end_mydate=$this->input->post('end_mydate');
		$engineer=$this->input->post('engineer');
		$this->load->model("complaint_model");
		//
        $get_sup_dvr = $this->complaint_model->get_date_dvr_model($start_mydate,$end_mydate,$engineer, 'tbl_dvr');
		 if (sizeof($get_sup_dvr) == "0") 
		  {
			echo "<tr class='odd grade'><td colspan='7' align='center'>No Results Found.</td></tr>";
		  }
		   else 
		  {
				foreach($get_sup_dvr as $sup_dvr)
				{
					 echo '<tr class="odd gradeX">
												<td>';
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
												 $ts_number 	= $this->db->query("SELECT * FROM tbl_complaints where pk_complaint_id='".$sup_dvr['fk_complaint_id']."' ");
												 $qu_ts_number	= $ts_number->result_array();
												 $business		= $qu_ts_number[0]['ts_number'];
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
					echo'</td>
												<td>';
													 
					 
					echo $myclient;
					echo '</td> ';  
					echo '<td>';
													 
					 
					echo date('d-M-Y', strtotime($sup_dvr['date']));
					echo '</td>  ';	
					echo '						<td>';
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
						echo urldecode($sup_dvr['priority']);
					}
					echo '</textarea> </td>';
					
					echo '<td> <textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
					echo urldecode($sup_dvr['summery']);
					echo '</textarea> </td>
				   </tr>';
				}
		  }
	
	}
	
	public function get_date_dvr_from_form_sbumit()
	{
		$start_mydate=$this->input->post('start_mydate');
		$end_mydate=$this->input->post('end_mydate');
		$engineer=$this->input->post('engineer');
		$this->load->model("complaint_model");
		//
        $get_sup_dvr = $this->complaint_model->get_date_dvr_model($start_mydate,$end_mydate,$engineer, 'tbl_dvr');
		$this->load->view('sys/sap_dvr_history', array("get_sup_dvr" => $get_sup_dvr,
		 												"mystartdate" => $start_mydate,
														"myenddate" => $end_mydate,
														"myengineer" => $engineer
														));
	
	}
	
	// Date VS for Admin
	public function get_date_vs_for_admin()
	{
		$start_mydate=$this->input->post('start_mydate');
		$end_mydate=$this->input->post('end_mydate');
		$engineer=$this->input->post('engineer');
		$this->load->model("complaint_model");
		//
        $get_sup_dvr = $this->complaint_model->get_date_dvr_model($start_mydate,$end_mydate,$engineer, 'tbl_vs');
		 $this->load->view('sys/admin_vs', array("get_sup_dvr" => $get_sup_dvr,
		 												"mystartdate" => $start_mydate,
														"myenddate" => $end_mydate,
														"myengineer" => $engineer
														));
	
	}
	
	//Engineer Vs for Admin
	public function get_egn_vs_ajax_for_admin()
	{
		$engineer_id	=	$this->input->post('engineer_id');
		$this->load->model("complaint_model");
        $get_sup_dvr = $this->complaint_model->get_single_eng_dvr_model($engineer_id, 'tbl_vs');
		if (sizeof($get_sup_dvr) == "0") 
		  {
			echo "<tr class='odd grade'><td colspan='10' align='center'>No Results Found.</td></tr>";
		  }
		   else 
		  {
				foreach($get_sup_dvr as $sup_dvr)
				{
					 echo '<tr class="odd gradeX">
												<td>';
					echo date('h:i A', strtotime($sup_dvr['start_time']));
					
					echo '</td><td>';
					
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
								 $business		=   'Others';
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
					echo '</td>';  
					echo '<td>';
													 
					 
					echo date('d-M-Y', strtotime($sup_dvr['date']));
					echo '</td>';	
					echo '<td>';
					echo $business;
					echo '</td>';
					echo '<td><textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
					//
					if($sup_dvr['fk_business_id']!='0'){
					$maxqu3 = $this->db->query("SELECT * FROM business_data where pk_businessproject_id='".$sup_dvr['fk_business_id']."' ");
				    $maxval3=$maxqu3->result_array();
				    echo $maxval3[0]['Project Description'];
					}
					else
					{
						//echo $sup_dvr['priority'];
						echo "Not Available";
					}
					echo '</textarea> </td>';
					
					echo '<td> <textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
					echo urldecode($sup_dvr['summery']);
					echo '</textarea> </td>';
					echo '<td>
								<a class="btn btn-default" href="'. base_url() .'sys/update_vs_project/'.$sup_dvr['pk_vs_id'].'">
									Update
								</a>
							  </td>';
				   echo '</tr>';
				}
		  }
	}
	//
	// Date DVR for admin
	public function get_date_dvr_for_admin()
	{
		$start_mydate=$this->input->post('start_mydate');
		$end_mydate=$this->input->post('end_mydate');
		$engineer=$this->input->post('engineer');
		$this->load->model("complaint_model");
		//
        $get_sup_dvr = $this->complaint_model->get_date_dvr_model($start_mydate,$end_mydate,$engineer, 'tbl_dvr');
		 $this->load->view('sys/admin_dvr', array("get_sup_dvr" => $get_sup_dvr,
		 												"mystartdate" => $start_mydate,
														"myenddate" => $end_mydate,
														"myengineer" => $engineer
														));
	
	}
	//
	public function get_egn_dvr_ajax()
	{
		$engineer_id	=	$this->input->post('engineer_id');
		$this->load->model("complaint_model");
        $get_sup_dvr = $this->complaint_model->get_single_eng_dvr_model($engineer_id, 'tbl_dvr');
		if (sizeof($get_sup_dvr) == "0") 
		  {
			echo "<tr class='odd grade'><td colspan='8' align='center'>No Results Found.</td></tr>";
		  }
		   else 
		  {
				foreach($get_sup_dvr as $sup_dvr)
				{
					 echo '<tr class="odd gradeX">
												<td>';
					echo date('h:i A', strtotime($sup_dvr['start_time']));
					
					echo '</td><td>';
					
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
								 $business		=   'Others';
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
					echo'</td>
						 <td>';
													 
					 
					echo $myclient;
					echo '</td>';  
					echo '<td>';
													 
					 
					echo date('d-M-Y', strtotime($sup_dvr['date']));
					echo '</td>';	
					echo '<td>';
					echo $business;
					echo '</td>';
					echo '<td><textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
					//
					if($sup_dvr['fk_business_id']!='0'){
					$maxqu3 = $this->db->query("SELECT * FROM business_data where pk_businessproject_id='".$sup_dvr['fk_business_id']."' ");
				    $maxval3=$maxqu3->result_array();
				    echo $maxval3[0]['Project Description'];
					}
					else
					{
						echo urldecode($sup_dvr['priority']);
					}
					echo '</textarea> </td>';
					
					echo '<td> <textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
					echo urldecode($sup_dvr['summery']);
					echo '</textarea> </td>
				   </tr>';
				}
		  }
	}
	
	//single engineer DVR for admin
	public function get_egn_dvr_ajax_for_admin()
	{
		$engineer_id	=	$this->input->post('engineer_id');
		$this->load->model("complaint_model");
        $get_sup_dvr = $this->complaint_model->get_single_eng_dvr_model($engineer_id, 'tbl_dvr');
		if (sizeof($get_sup_dvr) == "0") 
		  {
			echo "<tr class='odd grade'><td colspan='10' align='center'>No Results Found.</td></tr>";
		  }
		   else 
		  {
				foreach($get_sup_dvr as $sup_dvr)
				{
					 echo '<tr class="odd gradeX">
												<td>';
					echo date('h:i A', strtotime($sup_dvr['start_time']));
					
					echo '</td><td>';
					
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
								 $business		=   'Others';
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
					echo '</td>';  
					echo '<td>';
													 
					 
					echo date('d-M-Y', strtotime($sup_dvr['date']));
					echo '</td>';	
					echo '<td>';
					echo $business;
					echo '</td>';
					echo '<td><textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
					//
					if($sup_dvr['fk_business_id']!='0'){
					$maxqu3 = $this->db->query("SELECT * FROM business_data where pk_businessproject_id='".$sup_dvr['fk_business_id']."' ");
				    $maxval3=$maxqu3->result_array();
				    echo $maxval3[0]['Project Description'];
					}
					else
					{
						echo urldecode($sup_dvr['priority']);
					}
					echo '</textarea> </td>';
					
					echo '<td> <textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
					echo urldecode($sup_dvr['summery']);
					echo '</textarea> </td>';
					echo '<td>
												<a class="btn btn-default" href="'. base_url() .'sys/update_dvr_project/'.$sup_dvr['pk_dvr_id'].'">
													Update
												</a>
											  </td>';
				   echo '</tr>';
				}
		  }
	}
	//
	public function supervisor_my_complaints()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
        $this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_supervisor_complaint_model();
		$this->load->view('sys/supervisor_my_complaints', array("get_complaint_list" => $get_complaint_list));
	}
	public function supervisor_pm()
	{
		if($this->session->userdata('userrole')=='Supervisor' || $this->session->userdata('userrole')=='secratery')
		{
			//$this->load->model("complaint_model");
			//$get_complaint_list = $this->complaint_model->get_supervisor_pm_model();
			//$this->load->view('sys/supervisor_pm', array("get_complaint_list" => $get_complaint_list));
			$this->load->view('sys/supervisor_pm');
		}
		else
		{
			show_404();
		}
        
	}
	public function supervisor_pm_completed()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->view('sys/supervisor_pm_completed');
	}
	public function sap_projects()
	{
        if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_sap_projects = $this->complaint_model->get_sap_projects();
		$this->load->view('sys/sap_projects', array("get_sap_projects" => $get_sap_projects));
	}
	public function engineer_projects()
	{
        if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor')
		{
			$this->load->model("complaint_model");
        	$get_engineer_projects = $this->complaint_model->get_sap_projects();
			$this->load->view('sys/engineer_projects', array("get_engineer_projects" => $get_engineer_projects));
		}
		else
		{
			show_404();
		}
	}
	
	public function engineer_view_complaints()
	{
		if($this->session->userdata('userrole')!='FSE' && $this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
        $this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_engineer_complaints_model();
		$this->load->view('sys/engineer_view_complaints', array("get_complaint_list" => $get_complaint_list));
	}
	public function customers_view()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->model("complaint_model");
			$get_customers_list = $this->complaint_model->get_customer_view_model();
			$this->load->view('sys/customers_view', array("get_customers_list" => $get_customers_list));
		}
		else
		{
			show_404();
		}
	}
	public function edit_customer($client_id)
	{
		if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
        $this->load->model("complaint_model");
        $get_customers_list = $this->complaint_model->get_customer_edit_model($client_id);
		$this->load->view('sys/edit_customer', array("get_customers_list" => $get_customers_list));
	}
	
	public function engineer_view_pm()
	{
		if($this->session->userdata('userrole')!='FSE' && $this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
        $this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_engineer_pm_model();
		$this->load->view('sys/engineer_view_pm', array("get_complaint_list" => $get_complaint_list));
	}
	public function insert_customer()
	{
		$data = array(
						'client_name' 					=> 	$_POST['client_name'],
						'fk_city_id'  					=> 	$_POST['client_city'],
						'fk_office_id'					=> 	$_POST['territory'],
						'fk_area_id'					=> 	$_POST['area'],
						'contact_no'		 			=> 	$_POST['contactno'],
						'website'						=>  $_POST['website'],
						'address'		 				=> 	$_POST['address']
            		);
			//print_r($data);exit;
            $this->load->model("complaint_model");
            $result = $this->complaint_model->insert_customer($data);
            $ins_id =$this->db->insert_id();
            redirect(site_url() . 'sys/customers_view?msg=success');
	}
	public function update_customer($client_id)
	{
		$data = array(
						'client_name' 					=> 	$_POST['client_name'],
						'fk_city_id'  					=> 	$_POST['client_city'],
						'fk_office_id'					=> 	$_POST['territory'],
						'fk_area_id'					=> 	$_POST['area'],
						'contact_no'		 			=> 	$_POST['contactno'],
						'website'						=>  $_POST['website'],
						'address'		 				=> 	$_POST['address']
            		);
			//print_r($data);exit;
			// delete previous phatalogist of this user
			$dbres2 = $this->db->query("delete from tbl_clients_pathologists where fk_client_id='".$client_id."'");
			//add all documents here
			if(isset($_POST['pathalogist_name']))
			{
				foreach($_POST['pathalogist_name'] as $key=>$value)
				{
					$query="insert into tbl_clients_pathologists SET 				
								`name`						=	'".$_POST['pathalogist_name'][$key]."',
								`contact_no`  				=	'".$_POST['pathalogist_contact_no'][$key]."',
								`email`						=	'".$_POST['pathalogist_email'][$key]."',
								`fk_client_id`				=	'".$client_id."'
							  ";
							  $dbres = $this->db->query($query);
				}
			}
            $this->load->model("complaint_model");
            $result = $this->complaint_model->update_my_customer($data,$client_id);
            redirect(site_url() . 'sys/customers_view?msg_update=updated successfully');
	}
	public function add_business_project()
	{
		if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
			$this->load->view('sys/add_business_project');
	}
	
	public function add_policy()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/add_policy');
	}
	
	public function edit_policy()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/edit_policy');
	}
	
	public function vendors()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/vendors');
	}
	
	public function equipments()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/equipments');
	}
	
	public function kits()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/kits');
	}
	
	/* Changes by Zohaib */
	/*public function order_entry()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		
			$this->load->view('sys/order_entry');
	}
	
	public function order_view()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/order_view');
	}
	
	public function create_invoice()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/create_invoice');
	}
	
	public function view_invoice()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/view_invoice');
	}
	
	public function add_kitprice()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/add_kitprice');
	}*/
	
	
	public function aux_equipments()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/aux_equipments');
	}
	
	public function aux_equipment_registration()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/aux_equipment_registration');
	}
	
	public function aux_equipment_registration_new()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/aux_equipment_registration_new');
	}
	
	public function equipments_under_warranty()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('sys/equipments_under_warranty');
	}
	
	public function equipments_statistics()
	{
		if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
			$this->load->view('sys/equipments_statistics');
	}
	
	public function admin_dvr()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/admin_dvr');
		}
		else
		{
		show_404();
		}
	}
	
	public function admin_dvr_new()
	{
		
			$this->load->view('sys/admin_dvr_new');
		
	}
	
	public function sap_dvr_history_new()
	{
		if($this->session->userdata('userrole')=='Salesman')
		{
			$this->load->view('sys/sap_dvr_history_new');
		}
		else
		{
		show_404();
		}
	}
	
	public function monthly_report()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor' || $this->session->userdata('userrole')=='Salesman')
		{
			$this->load->view('sys/monthly_report');
		}
		else
		{
		show_404();
		}
	}
	
	public function equipment_audit()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' )
		{
			$this->load->view('sys/equipment_audit');
		}
		else
		{
		show_404();
		}
	}
	
	public function product_audit()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' )
		{
			$this->load->view('sys/product_audit');
		}
		else
		{
		show_404();
		}
	}
	
	public function complaint_statistics()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' )
		{
			$this->load->view('sys/complaint_statistics');
		}
		else
		{
		show_404();
		}
	}
	
	public function spare_parts_changed_report()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' )
		{
			$this->load->view('sys/spare_parts_changed_report');
		}
		else
		{
		show_404();
		}
	}
	
	public function parts_received_report()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' )
		{
			$this->load->view('sys/parts_received_report');
		}
		else
		{
		show_404();
		}
	}
	
	public function spare_parts_swap_report()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' )
		{
			$this->load->view('sys/spare_parts_swap_report');
		}
		else
		{
		show_404();
		}
	}
	
	public function complaint_statistics_new()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' )
		{
			$this->load->view('sys/complaint_statistics_new');
		}
		else
		{
		show_404();
		}
	}
	
	public function admin_vs()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('sys/admin_vs');
		}
		else
		{
		show_404();
		}
	}
	public function update_business_project($business_project_id)
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Salesman')
		{
        $this->load->model("complaint_model");
        $get_business_projects_list = $this->complaint_model->get_update_business_project_model($business_project_id);
		$this->load->view('sys/update_business_project', array("get_business_projects_list" => $get_business_projects_list));
		}
		else
		{
		show_404();
		}
	}
	
	public function update_equipment()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/update_equipment');
	}
	
	public function update_aux_equipment()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/update_aux_equipment');
	}
	
	public function update_equipment_location()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/update_equipment_location');
	}

    public function delete_equipment($id) {
        $query="delete from  tbl_instruments  where `pk_instrument_id` =$id";
        $dbres = $this->db->query($query);
        redirect(site_url() . 'sys/equipments?msg_delete=success');
    }
	
	public function delete_aux_equipment($id) {
        $query="delete from  tbl_instruments  where `pk_instrument_id` =$id";
        $dbres = $this->db->query($query);
        redirect(site_url() . 'sys/aux_equipments?msg_delete=success');
    }
	
	public function update_equipment_insert()
	{
			 $this->load->model("profile_model");
			$query="update tbl_instruments SET 				  
								`serial_no`				=	'".$_POST['serial_no']."',
								
								`fk_vendor_id`			=	'".$_POST['vendor']."',
								`fk_category_id`		=	'".$_POST['category']."',
								
								`install_date`			=	'".date('Y-m-d')."',
								`fk_product_id`			=	'".$_POST['equipment']."',
								
								`invoice_number`		=	'".$_POST['invoice_number']."',
								`invoice_date`			=	'".$this->profile_model->change_date_to_mysql_style($_POST['invoice_date'])."',
								`equipment_price`		=	'".$_POST['equipment_price']."',
								`warranty_months`		=	'".$_POST['warranty_months']."',
								`warranty_start_date`	=	'".$this->profile_model->change_date_to_mysql_style($_POST['warranty_start_date'])."',
								`status`				=	'".$_POST['status']."',
								`details`				=	'".$_POST['description']."'
								 where pk_instrument_id = '".$_POST['pk_instrument_id']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			  
            redirect(site_url() . 'sys/equipments?msg_update=success');
	}
	
	public function update_aux_equipment_insert()
	{
		
		$main_equipment_string = "";
		/*
		foreach($_POST['main_equipment'] as $main_equipment)
		  {
			  $main_equipment_string .= ",".$main_equipment;
		  }
		  */
		  // removing this line after serial_no line in the query below -> `main_equipment`		=	'".ltrim($main_equipment_string, ',')."',
		  //												`fk_client_id`			=	'".$_POST['cutomer']."',
		  //												`fk_office_id`			=	'".$_POST['office']."',
			 $this->load->model("profile_model");
			$query="update tbl_instruments SET 				  
								`serial_no`				=	'".$_POST['serial_no']."',
								
								`fk_vendor_id`			=	'".$_POST['vendor']."',
								`fk_category_id`		=	'".$_POST['category']."',
								
								`install_date`			=	'".date('Y-m-d')."',
								`fk_product_id`			=	'".$_POST['equipment']."',
								
								`invoice_number`		=	'".$_POST['invoice_number']."',
								`invoice_date`			=	'".$this->profile_model->change_date_to_mysql_style($_POST['invoice_date'])."',
								`equipment_price`		=	'".$_POST['equipment_price']."',
								`warranty_months`		=	'".$_POST['warranty_months']."',
								`warranty_start_date`	=	'".$this->profile_model->change_date_to_mysql_style($_POST['warranty_start_date'])."',
								`status`				=	'".$_POST['status']."',
								`details`				=	'".$_POST['description']."'
								
								 where pk_instrument_id = '".$_POST['pk_instrument_id']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			  
            redirect(site_url() . 'sys/aux_equipments?msg_update=success');
	}
	
	public function update_equipment_location_insert()
	{
			$main_equipment_string = "";
			if (isset ($_POST['main_equipment'])){
			foreach($_POST['main_equipment'] as $main_equipment){
					  $main_equipment_string .= ",".$main_equipment;
				  }
			}
			 $dbres = $this->db->query("select * from tbl_instruments where pk_instrument_id='".$_POST['pk_instrument_id']."'");
			 $instrument = $dbres->result_array();
			 $customer_old = $instrument[0]['fk_client_id'];
			 $status_old = $instrument[0]['status'];
			 $office_old = $instrument[0]['fk_office_id'];
			 $main_equipment_old = $instrument[0]['main_equipment'];
			 $this->load->model("profile_model");
			 // Insert
			 $query="INSERT INTO tbl_instruments_log SET 				  
								`fk_client_id_old`		=	'".$customer_old."',
								`fk_client_id_new`		=	'".$_POST['cutomer']."',
								`date`					=	'".date('Y-m-d',strtotime($_POST['update_date']))."', 
								`fk_office_id_old`		=	'".$office_old."',
								`fk_office_id_new`		=	'".$_POST['office']."',
								`main_equipment_old`	=	'".$main_equipment_old."',
								`main_equipment_new`	=	'".ltrim($main_equipment_string, ',')."',
								`status_old`			=	'".$status_old."',
								`status_new`			=	'".$_POST['status']."',
								`comments`				=	'".urlencode($_POST['description'])."',
								`fk_instrument_id` 		= 	'".$_POST['pk_instrument_id']."'";
			  $dbres = $this->db->query($query);
			 // Update
			$query="update tbl_instruments SET 				  
								`fk_client_id`			=	'".$_POST['cutomer']."',
								`fk_office_id`			=	'".$_POST['office']."',
								`main_equipment`		=	'".ltrim($main_equipment_string, ',')."',
								`status`				=	'".$_POST['status']."'
								 where pk_instrument_id = '".$_POST['pk_instrument_id']."'";
			  $dbres = $this->db->query($query);
			 
			  
            redirect(site_url() . 'sys/update_equipment_location?msg_success=success&equipment='.$_POST["pk_instrument_id"]);
	}
	
	public function details_business_project($business_project_id)
	{
		if($this->session->userdata('userrole')!='')
		{
		$this->load->view('sys/details_business_project');
		}
		else
		{
			show_404();
		}
	}
	public function update_vs_project($vs_id)
	{
		if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery' )
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_update_vs_project_list = $this->complaint_model->get_update_vs_project($vs_id);
		$this->load->view('sys/update_vs_project', array("get_update_vs_project_list" => $get_update_vs_project_list));
	}
	public function update_dvr_project($vs_id)
	{
		if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery' )
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_update_dvr_project_list = $this->complaint_model->get_update_dvr_project($vs_id);
		$this->load->view('sys/update_dvr_project', array("get_update_dvr_project_list" => $get_update_dvr_project_list));
	}
	public function insert_business_project()
	{
			
			$this->load->model("profile_model");
			 $this->load->model("profile_model");
			 $query="insert into business_data SET 				  
								`Territory`							=	'".$_POST['Territory']."',
								`City`								=	'".$_POST['City']."',
								`Customer`							=	'".$_POST['Customer']."',
								`Area`  							=	'".$_POST['Area']."',
								`Department`						=	'".$_POST['Department']."',
								`Sales Person`						=	'".$_POST['Sales_Person']."',
								`Date`								=	'".$this->profile_model->change_date_to_mysql_style($_POST['date'])."',";
			  if(isset($_POST['priority']))
			  {
				  $query.="`priority`			=	'1',";
			  }
			  $query.="`Business Project`					=	'".$_POST['Business_Project']."',
						`project_type`						=	'".$_POST['project_type']."',
					   `Project Description`				=	'".$_POST['Project_Description']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			if ($_POST['redirect_customer']=="yes")
				redirect(site_url() . 'sys/edit_customer/'.$_POST['Customer']);
			else
				redirect(site_url() . 'sys/business_data?msg=success');//redirect(site_url() . 'sys/add_business_project?msg=success');
			
	}
	public function pef_insert()
	{
			
			$this->load->model("profile_model");
			 $query="insert  `tbl_pef` SET 	
			  `fk_engineer_id`							='".$_POST['fk_engineer_id']."',
			  `fk_evaluater_id`							='".$_POST['fk_evaluater_id']."',
			  `evaluater_role`							='".$_POST['evaluater_role']."',
			  `schedule_id`								='".$_POST['schedule_id']."',
			  `know_AP_SOP`								='".$_POST['know_AP_SOP']."',
			  `complies_change_SOAP_adaptation`			='".$_POST['complies_change_SOAP_adaptation']."',
			  `write_dailyvisitreport`					='".$_POST['write_dailyvisitreport']."',
			  `comuniation_with_manager`				='".$_POST['comuniation_with_manager']."',
			  `regular_meeting_with_subordinate`		='".$_POST['regular_meeting_with_subordinate']."',
			  `response_to_questions`					='".$_POST['response_to_questions']."',
			  `response_to_calls`						='".$_POST['response_to_calls']."',
			  `intiat_without_direction`				='".$_POST['intiat_without_direction']."',
			  `proiritize_own_assignments`				='".$_POST['proiritize_own_assignments']."',
			  `attendence_and_punctuality`				='".$_POST['attendence_and_punctuality']."',
			  `meet_deadlines_of_projects`				='".$_POST['meet_deadlines_of_projects']."',
			  `attend_meetings`							='".$_POST['attend_meetings']."',
			  `submetting_of_forms`						='".$_POST['submetting_of_forms']."',
			  `timely_submission_of_ALS`				='".$_POST['timely_submission_of_ALS']."',
			  `value_commitment_with_company`			='".$_POST['value_commitment_with_company']."',
			  `offer_assistance_and_cooperate`			='".$_POST['offer_assistance_and_cooperate']."',
			  `contribut_built_userfriendly_envirnment`	='".$_POST['contribut_built_userfriendly_envirnment']."',
			  `facilitate_group_discusion`				='".$_POST['facilitate_group_discusion']."',
			  `follow_leadership_appropriately`			='".$_POST['follow_leadership_appropriately']."',
			  `lead_example_for_colleague`				='".$_POST['lead_example_for_colleague']."',
			  `able_to_coach_train_mentor`				='".$_POST['able_to_coach_train_mentor']."',
			  `has_ability_to_get_job_done`				='".$_POST['has_ability_to_get_job_done']."',
			  `motivate_towords_company_goals`			='".$_POST['motivate_towords_company_goals']."',
			  `utilize_ALS_PM_foam`						='".$_POST['utilize_ALS_PM_foam']."',
			  `adapt_new_methods`						='".$_POST['adapt_new_methods']."',
			  `keep_documents_ready`					='".$_POST['keep_documents_ready']."',
			  `follow_department_procedures`			='".$_POST['follow_department_procedures']."',
			  `take_responsibility_for_results`			='".$_POST['take_responsibility_for_results']."',
			  `finish_task_without_repetition`			='".$_POST['finish_task_without_repetition']."',
			  `monitor_own_work`						='".$_POST['monitor_own_work']."',
			  `prioritize_work_activities`				='".$_POST['prioritize_work_activities']."',
			  `write_visit_schedule`					='".$_POST['write_visit_schedule']."',
			  `adapt_to_changes`						='".$_POST['adapt_to_changes']."',
			  `schedule_appointment_with_customer`		='".$_POST['schedule_appointment_with_customer']."',
			  `build_approches_from_experience`			='".$_POST['build_approches_from_experience']."',
			  `press_beyond_the_surface`				='".$_POST['press_beyond_the_surface']."',
			  `research_new_methods_for_improvment`		='".$_POST['research_new_methods_for_improvment']."',
			  `is_willing_to_learn_new_skills`			='".$_POST['is_willing_to_learn_new_skills']."',
			  `evaluate_problems_quickly`				='".$_POST['evaluate_problems_quickly']."',
			  `fully_complete_assigned_projects`		='".$_POST['fully_complete_assigned_projects']."',
			  `meet_expectation`						='".$_POST['meet_expectation']."',
			  `ensure_work_responsibility`				='".$_POST['ensure_work_responsibility']."',
			  `perform_duty_acurately`					='".$_POST['perform_duty_acurately']."',
			  `protect_confidential_info`				='".$_POST['protect_confidential_info']."',
			  `bring_notice_harmful_information`		='".$_POST['bring_notice_harmful_information']."',
			  `comments`								='".$_POST['comments']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
     redirect(site_url().'sys/pef_employee/'.$_POST['fk_engineer_id'].'/'.$_POST['schedule_id'].'/'.$_POST['evaluater_role'].'/'.$_POST['fk_evaluater_id'].'?msg=success');
	}
	
	public function add_category_insert()
	{
			 $query="insert  `tbl_category` SET 	
			  `category_name`						='".$_POST['category_name']."'";
			  //`fk_type_id`							='".$_POST['type_name']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  redirect(site_url().'sys/categories/?msg=success');
	}
	
	public function add_city_insert()
	{
			 $query="insert  `tbl_cities` SET 	
			  `city_name`						='".$_POST['city_name']."', 
			  `fk_office_id`							='".$_POST['office_name']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  redirect(site_url().'sys/cities/?msg=success');
	}
	public function add_area_insert()
	{
			 $query="insert  `tbl_area` SET 	
			  `area`						='".$_POST['area_name']."', 
			  `fk_city_id`					='".$_POST['city_name']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  redirect(site_url().'sys/areas/?msg=success');
	}
	
	public function add_tagg_insert()
	{
		
		$x = $_POST['tagg'];
		if ($x!="") {
			$dbres = $this->db->query('DELETE FROM `tbl_tagg`');
			$obj = json_decode($x, true);
			foreach ($obj AS $tag) {
				if ($tag['text']=="") continue;
				$query="insert  `tbl_tagg` SET 	
				  `x`		='".$tag['x']."', 
				  `y`		='".$tag['y']."', 
				  `text`		='".$tag['text']."'";
				  $dbres = $this->db->query($query);
			}
		}
		redirect(site_url().'sys/mainpage_z?msg=success');
	}
	
	public function add_product_insert()
	{
			 $query="insert  `tbl_products` SET 	
			  `product_name`						='".$_POST['product_name']."',
			  `fk_category_id`						='".$_POST['category_name']."'
			  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			  $query2="select * from `tbl_products` ORDER BY pk_product_id DESC LIMIT 0,1";
			  $dbres2 = $this->db->query($query2);
			  $hhh = $dbres2->result_array();
			  $insert_id=$hhh[0]['pk_product_id'];
			  foreach($_POST['vendors'] as $vendor)
			  {
				  $query="insert into tbl_vendor_product_bridge SET 				  
								`fk_vendor_id`				=	'".$vendor."',
								`fk_product_id`				=	'".$insert_id."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  }
			  redirect(site_url().'sys/products/?msg=success');
	}
	public function update_product_insert()
	{
			 $query="update  `tbl_products` SET 	
			  `product_name`						='".$_POST['product_name']."',
			  `fk_category_id`						='".$_POST['category_name']."'
			  where pk_product_id					='".$_POST['pk_product_id']."'
			  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			  $query="delete from  `tbl_vendor_product_bridge` where fk_product_id	='".$_POST['pk_product_id']."'";
			  $dbres = $this->db->query($query);
			  //
			  $insert_id=$_POST['pk_product_id'];
			  foreach($_POST['vendors'] as $vendor)
			  {
				  $query="insert into tbl_vendor_product_bridge SET 				  
								`fk_vendor_id`		=	'".$vendor."',
								`fk_product_id`		=	'".$insert_id."'";
				  $dbres = $this->db->query($query);
			  }
			  redirect(site_url().'sys/products/?msg=success');
	}
	public function delete_business_project($id)
	{
		$query="update business_data SET 
								`result`							= 	'".$_POST['result']."',
								`delete_date`						= 	'".date('Y-m-d H:i:s')."',
								`status`							=	'1'
								where pk_businessproject_id			= 	'".$id."'
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
		if (isset($_GET['cust']))
			redirect(site_url() . 'sys/edit_customer/'. $_GET['cust']);
		else
		redirect(site_url() . 'sys/business_data?del=success');
	}
	
	public function restore_business_project($id)
	{
		$query="update business_data SET `status` = '0' where pk_businessproject_id	= '".$id."'";
		$dbres = $this->db->query($query);
		redirect(site_url() . 'sys/deleted_business_data?restore=success');
	}
	
	public function edit_business_project()
	{
			$this->load->model("profile_model");
			 $query="update business_data SET 				  
								`Territory`							=	'".$_POST['Territory']."',
								`City`								=	'".$_POST['City']."',
								`Customer`							=	'".$_POST['Customer']."',
								`Area`  							=	'".$_POST['Area']."',
								`Department`						=	'".$_POST['Department']."',
								`Sales Person`						=	'".$_POST['Sales_Person']."',
								`Date`								=	'".$this->profile_model->change_date_to_mysql_style($_POST['date'])."',";
			  if(isset($_POST['priority']))
			  {
				  $query.="`priority`			=	'1',";
			  }
			  else
			  {
				  $query.="`priority`			=	'0',";
			  }
			  $query.="`Business Project`					=	'".$_POST['Business_Project']."',
						`project_type`						=	'".$_POST['project_type']."',
					   `Project Description`				=	'".$_POST['Project_Description']."'
					   where pk_businessproject_id			= 	'".$_POST['businessproject_hidden_id']."'";
			
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  $project_id = $_POST['businessproject_hidden_id'];

			
			if ($_POST['redirect_customer']=="yes")
				redirect(site_url() . 'sys/edit_customer/'.$_POST['customer_id']);
			else
				redirect(site_url() . 'sys/business_data?upt=success');//redirect(site_url() . 'sys/update_business_project/'.$_POST["businessproject_hidden_id"].'?upt=success');
			
	}
	public function insert_dvr_sap()
	{
			foreach($_POST['starttime'] as $key=> $value)
			{
			
				//echo 'start time'.$_POST['starttime'][$key].'<br> end time='.$_POST['endtime'][$key].'<br>';
			 $start_ampm=explode(' ',$_POST['starttime'][$key]);
			 $start_ampm_minut=explode(':',$start_ampm[0]);
			 $start_hour=explode(':',$_POST['starttime'][$key]);
			 //if($start_ampm[1]=='AM'){ $start_nhour=$start_hour[0]; }else{ $start_nhour=$start_hour[0]+12; } zaaid
			 if($start_ampm[1]=='PM' && $start_hour[0]<12){ $start_nhour=$start_hour[0]+12; }else{ $start_nhour=$start_hour[0]; }
			 if($start_ampm[1]=='AM' && $start_nhour==12 ){ $start_nhour-=12;}
			 $re_start_hour=$start_nhour.':'.$start_ampm_minut[1].':00';
			 //
			 $end_ampm=explode(' ',$_POST['endtime'][$key]);
			 $end_ampm_minut=explode(':',$end_ampm[0]);
			 $end_hour=explode(':',$_POST['endtime'][$key]);
			 //if($end_ampm[1]=='AM'){ $end_nhour=$end_hour[0]; }else{ $end_nhour=$end_hour[0]+12; } zaaid
			 if($end_ampm[1]=='PM' && $end_hour[0]<12){ $end_nhour=$end_hour[0]+12; }else{ $end_nhour=$end_hour[0]; }
			 if($end_ampm[1]=='AM' && $end_nhour==12 ){ $end_nhour-=12;}
			 $re_end_hour=$end_nhour.':'.$end_ampm_minut[1].':00';
			 //echo 'start time'.$re_start_hour.'<br> end time='.$re_end_hour;exit;
			 //
			 //echo $_POST['city'][$key];exit;
			 
			 //////////////////////zaaid
			 $current_date=date('Y-m-d');
			 $current_time=date('H');
			 if ($current_time<8) {$current_date = date('Y-m-d H:i:s',(strtotime ( '-1 day' , strtotime ( $current_date) ) ));}
			///////////////////// zaaid
			
			// outstation scenario added in july
			$outstation	=	0;
			if (isset($_POST['outstation'][$key])) $outstation	=	'1';
			//// outstation scenario
			$dvr_date = date('Y-m-d',strtotime($current_date));
			 $dvr_date = $dvr_date.' '.$re_start_hour;
			
			 $query="insert into tbl_dvr SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`fk_city_id`			=	'".$_POST['city'][$key]."',
								`fk_engineer_id`  		=	'".$_POST['engineer']."',
								`fk_customer_id`		=	'".$_POST['customer'][$key]."',";
			if(substr($_POST['business'][$key],0,1)=='t')
			{ 
				$compalintid = explode('_',$_POST['business'][$key]);
				$query.="`fk_business_id`		=	'0',
						 `fk_complaint_id`		=	'".$compalintid[1]."',";
			}
			else
			{
				$query.="`fk_business_id`		=	'".$_POST['business'][$key]."',
						 `fk_complaint_id`		=	'0',";
			}
			$query.="
								`outstation`			=	'".$outstation."',
								`priority`				=	'".urlencode($_POST['business_description'][$key])."',
								`timeline`				=	'".$_POST['time_elaped'][$key]."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`next_plan`				=	'".urlencode($_POST['next_plan'][$key])."',
								`date`					=	'".$current_date."'
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			}
			
			/////////////////////////// For entering strategy ////////////////////////////////
			if (isset($_POST['strategy'])){
				$this->load->model("profile_model");
				$query ="INSERT INTO tbl_project_strategy SET 				  
										`target_date`				=	'".$this->profile_model->change_date_to_mysql_style($_POST['target_date'])."',
										`investment`				=	'".$_POST['investment']."',
										`sales_per_month`			=	'".$_POST['sales_per_month']."',
										`strategy`					=	'".urlencode($_POST['strategy'])."',
										`tactics`					=	'".urlencode($_POST['tactics'])."',
										`date`						=	'".date('Y-m-d H:i:s')."',
										`strategy_status`			=	'".$_POST['strategy_status']."',
										`fk_employee_id`			=	'".$this->session->userdata('userid')."',
										`fk_project_id`				= 	'".$_POST['fk_project_id']."'";
			
			  $dbres = $this->db->query($query);
			}
			
			//////////////////////////  End For entering Stratgey ////////////////////////////
			if(isset($_POST['form_name']))
			{
				if($_POST['form_name']=='sap_dvr_form')
				{
					redirect(site_url() . 'sys/sap_dvr_form?msg=success');
				}
				else
				{
					redirect(site_url() . 'sys/sap_dvr?msg=success');
				}
			}
			else
			{
            redirect(site_url() . 'sys/engineer_dvr_form?msg=success');
			}
	}
	
	public function edit_dvr_business($dvr_id)
	{
			$this->load->model("profile_model");
			foreach($_POST['starttime'] as $key=> $value)
			{
			
				//echo 'start time'.$_POST['starttime'][$key].'<br> end time='.$_POST['endtime'][$key].'<br>';
			 $start_ampm=explode(' ',$_POST['starttime'][$key]);
			 $start_ampm_minut=explode(':',$start_ampm[0]);
			 $start_hour=explode(':',$_POST['starttime'][$key]);
			 //if($start_ampm[1]=='AM'){ $start_nhour=$start_hour[0]; }else{ $start_nhour=$start_hour[0]+12; } zaaid
			 if($start_ampm[1]=='PM' && $start_hour[0]<12){ $start_nhour=$start_hour[0]+12; }else{ $start_nhour=$start_hour[0]; }
			 if($start_ampm[1]=='AM' && $start_nhour==12 ){ $start_nhour-=12;}
			 $re_start_hour=$start_nhour.':'.$start_ampm_minut[1].':00';
			 //
			 $end_ampm=explode(' ',$_POST['endtime'][$key]);
			 $end_ampm_minut=explode(':',$end_ampm[0]);
			 $end_hour=explode(':',$_POST['endtime'][$key]);
			 //if($end_ampm[1]=='AM'){ $end_nhour=$end_hour[0]; }else{ $end_nhour=$end_hour[0]+12; } zaaid
			 if($end_ampm[1]=='PM' && $end_hour[0]<12){ $end_nhour=$end_hour[0]+12; }else{ $end_nhour=$end_hour[0]; }
			 if($end_ampm[1]=='AM' && $end_nhour==12 ){ $end_nhour-=12;}
			 $re_end_hour=$end_nhour.':'.$end_ampm_minut[1].':00';
			 //echo 'start time'.$re_start_hour.'<br> end time='.$re_end_hour;exit;
			 //
			 //echo $_POST['city'][$key];exit;
			 
			 //////////////////////zaaid
			 $current_date=date('Y-m-d');
			 $current_time=date('H');
			 if ($current_time<8) {$current_date = date('Y-m-d H:i:s',(strtotime ( '-1 day' , strtotime ( $current_date) ) ));}
			///////////////////// zaaid
			
			 $query="update tbl_dvr SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`date`					=	'".$this->profile_model->change_date_to_mysql_style($_POST['date'])."',
								`fk_customer_id`		=	'".$_POST['customer'][$key]."',
								`fk_city_id`			=	'".$_POST['city'][$key]."',";
			if(substr($_POST['business'][$key],0,1)=='t')
			{ 
				$compalintid = explode('_',$_POST['business'][$key]);
				$query.="`fk_business_id`		=	'0',
						 `fk_complaint_id`		=	'".$compalintid[1]."',";
			}
			else
			{
				$query.="`fk_business_id`		=	'".$_POST['business'][$key]."',
						 `fk_complaint_id`		=	'0',";
			}
				$query.="
								`priority`				=	'".urlencode($_POST['business_description'][$key])."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`next_plan`				=	'".urlencode($_POST['next_plan'][$key])."'
								where pk_dvr_id			=	'".$dvr_id."'
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			}
            if(isset($_POST['engineer']) && isset($_POST['start_mydate']) && isset($_POST['end_mydate'])) {
				redirect(site_url() . 'sys/admin_dvr_new?msg=success&engineer='.$_POST['engineer'].'&start_mydate='.$_POST['start_mydate'].'&end_mydate='.$_POST['end_mydate']);
			}
			else {
            redirect(site_url() . 'sys/update_dvr_project/'.$dvr_id.'?msg=success');
			}
	}
	
	public function delete_dvr($id)
	{
		$dbres = $this->db->query("DELETE FROM tbl_dvr WHERE pk_dvr_id = $id");
		if(isset($_GET['engineer']) && isset($_GET['start_mydate']) && isset($_GET['end_mydate'])) {
				redirect(site_url() . 'sys/admin_dvr_new?delete_msg=success&engineer='.$_GET['engineer'].'&start_mydate='.$_GET['start_mydate'].'&end_mydate='.$_GET['end_mydate']);
			}
			else {
            redirect(site_url() . 'sys/update_dvr_project/'.$id.'?delete_msg=success');
			}
	}
	
	public function delete_vs($id)
	{
		$dbres = $this->db->query("DELETE FROM tbl_vs WHERE pk_vs_id = $id");
		if(isset($_GET['engineer']) && isset($_GET['start_mydate']) && isset($_GET['end_mydate'])) {
				redirect(site_url() . 'sys/admin_dvr_new?delete_msgvs=success&engineer='.$_GET['engineer'].'&start_mydate='.$_GET['start_mydate'].'&end_mydate='.$_GET['end_mydate']);
			}
			else {
            redirect(site_url() . 'sys/update_vs_project/'.$id.'?delete_msgvs=success');
			}
	}
	public function edit_vs_business($vs_id)
	{
			foreach($_POST['starttime'] as $key=> $value)
			{
			
				//echo 'start time'.$_POST['starttime'][$key].'<br> end time='.$_POST['endtime'][$key].'<br>';
			 $start_ampm=explode(' ',$_POST['starttime'][$key]);
			 $start_ampm_minut=explode(':',$start_ampm[0]);
			 $start_hour=explode(':',$_POST['starttime'][$key]);
			 //if($start_ampm[1]=='AM'){ $start_nhour=$start_hour[0]; }else{ $start_nhour=$start_hour[0]+12; } zaaid
			 if($start_ampm[1]=='PM' && $start_hour[0]<12){ $start_nhour=$start_hour[0]+12; }else{ $start_nhour=$start_hour[0]; }
			 if($start_ampm[1]=='AM' && $start_nhour==12 ){ $start_nhour-=12;}
			 $re_start_hour=$start_nhour.':'.$start_ampm_minut[1].':00';
			 //
			 $end_ampm=explode(' ',$_POST['endtime'][$key]);
			 $end_ampm_minut=explode(':',$end_ampm[0]);
			 $end_hour=explode(':',$_POST['endtime'][$key]);
			 //if($end_ampm[1]=='AM'){ $end_nhour=$end_hour[0]; }else{ $end_nhour=$end_hour[0]+12; } zaaid
			 if($end_ampm[1]=='PM' && $end_hour[0]<12){ $end_nhour=$end_hour[0]+12; }else{ $end_nhour=$end_hour[0]; }
			 if($end_ampm[1]=='AM' && $end_nhour==12 ){ $end_nhour-=12;}
			 $re_end_hour=$end_nhour.':'.$end_ampm_minut[1].':00';
			 //echo 'start time'.$re_start_hour.'<br> end time='.$re_end_hour;exit;
			 //
			 //echo $_POST['city'][$key];exit;
			 
			 //////////////////////zaaid
			 $current_date=date('Y-m-d');
			 $current_time=date('H');
			 if ($current_time<8) {$current_date = date('Y-m-d H:i:s',(strtotime ( '-1 day' , strtotime ( $current_date) ) ));}
			///////////////////// zaaid
			
			 $query="update tbl_vs SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."'
								where pk_vs_id			=	'".$vs_id."'
							  ";
			  /*`fk_business_id`		=	'".$_POST['business'][$key]."',*/
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			}
            if(isset($_POST['engineer']) && isset($_POST['start_mydate']) && isset($_POST['end_mydate'])) {
				redirect(site_url() . 'sys/admin_dvr_new?msgvs=success&engineer='.$_POST['engineer'].'&start_mydate='.$_POST['start_mydate'].'&end_mydate='.$_POST['end_mydate']);
			}
			else {
            redirect(site_url() . 'sys/update_vs_project/'.$vs_id.'?msg=success');
			}
	}
	
	public function insert_dvr_engineer()
	{
			foreach($_POST['starttime'] as $key=> $value)
			{
			//echo 'start time'.$_POST['starttime'][$key].'<br> end time='.$_POST['endtime'][$key].'<br>';
			 $start_ampm=explode(' ',$_POST['starttime'][$key]);
			 $start_ampm_minut=explode(':',$start_ampm[0]);
			 $start_hour=explode(':',$_POST['starttime'][$key]);
			 //if($start_ampm[1]=='AM'){ $start_nhour=$start_hour[0]; }else{ $start_nhour=$start_hour[0]+12; } zaaid
			 if($start_ampm[1]=='PM' && $start_hour[0]<12){ $start_nhour=$start_hour[0]+12; }else{ $start_nhour=$start_hour[0]; }
			 if($start_ampm[1]=='AM' && $start_nhour==12 ){ $start_nhour-=12;}
			 $re_start_hour=$start_nhour.':'.$start_ampm_minut[1].':00';
			 //
			 $end_ampm=explode(' ',$_POST['endtime'][$key]);
			 $end_ampm_minut=explode(':',$end_ampm[0]);
			 $end_hour=explode(':',$_POST['endtime'][$key]);
			 //if($end_ampm[1]=='AM'){ $end_nhour=$end_hour[0]; }else{ $end_nhour=$end_hour[0]+12; } zaaid
			 if($end_ampm[1]=='PM' && $end_hour[0]<12){ $end_nhour=$end_hour[0]+12; }else{ $end_nhour=$end_hour[0]; }
			 if($end_ampm[1]=='AM' && $end_nhour==12 ){ $end_nhour-=12;}
			 $re_end_hour=$end_nhour.':'.$end_ampm_minut[1].':00';
			 
			 $current_date=date('Y-m-d');
			 $current_time=date('H');
			 if ($current_time<8) {$current_date = date('Y-m-d H:i:s',(strtotime ( '-1 day' , strtotime ( $current_date) ) ));}
			///////////////////// zaaid
			
			// outstation scenario added in july
			$outstation	=	0;
			if (isset($_POST['outstation'][$key])) $outstation	=	'1';
			//// outstation scenario
			$dvr_date = date('Y-m-d',strtotime($current_date));
			$dvr_date = $dvr_date.' '.$re_start_hour;
			 $query="insert into tbl_dvr SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`fk_city_id`			=	'".$_POST['city'][$key]."',
								`fk_engineer_id`  		=	'".$_POST['engineer']."',
								`fk_customer_id`		=	'".$_POST['customer'][$key]."',";
			if(substr($_POST['business'][$key],0,1)=='t')
			{ 
				$compalintid = explode('_',$_POST['business'][$key]);
				$query.="`fk_business_id`		=	'0',
						 `fk_complaint_id`		=	'".$compalintid[1]."',";
			}
			else
			{
				$query.="`fk_business_id`		=	'".$_POST['business'][$key]."',
						 `fk_complaint_id`		=	'0',";
			}
			$query.="
								`outstation`			=	'".$outstation."',
								`priority`				=	'".urlencode($_POST['business_description'][$key])."',
								`timeline`				=	'".$_POST['time_elaped'][$key]."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`next_plan`				=	'".urlencode($_POST['next_plan'][$key])."',
								`date`					=	'".$current_date."'
								
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			}
			
			/////////////////////////// For entering strategy ////////////////////////////////
			if (isset($_POST['strategy'])){
				$this->load->model("profile_model");
				$query ="INSERT INTO tbl_project_strategy SET 				  
										`target_date`				=	'".$this->profile_model->change_date_to_mysql_style($_POST['target_date'])."',
										`investment`				=	'".$_POST['investment']."',
										`sales_per_month`			=	'".$_POST['sales_per_month']."',
										`strategy`					=	'".urlencode($_POST['strategy'])."',
										`tactics`					=	'".urlencode($_POST['tactics'])."',
										`date`						=	'".date('Y-m-d H:i:s')."',
										`strategy_status`			=	'".$_POST['strategy_status']."',
										`fk_employee_id`			=	'".$this->session->userdata('userid')."',
										`fk_project_id`				= 	'".$_POST['fk_project_id']."'";
			
			  $dbres = $this->db->query($query);
			}
			
			//////////////////////////  End For entering Stratgey ////////////////////////////
			if(isset($_POST['engineer_dvr_form']))
			{
				redirect(site_url() . 'sys/engineer_dvr_form?msg=success');
			}
			else
			{
            redirect(site_url() . 'sys/engineer_dvr_form?msg=success');
			}
	}
	
	public function insert_vendor_registration()
	{
			$query="insert into tbl_vendors SET 				  
								`vendor_name`				=	'".$_POST['vendor_name']."',
								`email`						=	'".$_POST['email']."',
								`address`					=	'".$_POST['address']."',
								`country`					=	'".$_POST['country']."',
								`conatact_person`			=	'".$_POST['conatact_person']."',
								`contact_no_office`			=	'".$_POST['contact_no_office']."',
								`contact_no_Mobile`  		=	'".$_POST['contact_no_Mobile']."',
								`city`						=	'".$_POST['city']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			  $query2="select * from tbl_vendors ORDER BY pk_vendor_id DESC LIMIT 0,1";
			  $dbres2 = $this->db->query($query2);
			  $hhh = $dbres2->result_array();
			  $insert_id=$hhh[0]['pk_vendor_id'];
			  foreach($_POST['category'] as $category)
			  {
				  $query="insert into tbl_vendor_category_bridge SET 				  
								`fk_vendor_id`				=	'".$insert_id."',
								`fk_category_id`				=	'".$category."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  }
            redirect(site_url() . 'sys/vendor_registration?msg=success');
	}
	
	public function update_vendor_insert()
	{
			$query="update tbl_vendors SET 				  
								`vendor_name`				=	'".$_POST['vendor_name']."',
								`email`						=	'".$_POST['email']."',
								`address`					=	'".$_POST['address']."',
								`country`					=	'".$_POST['country']."',
								`conatact_person`			=	'".$_POST['conatact_person']."',
								`contact_no_office`			=	'".$_POST['contact_no_office']."',
								`contact_no_Mobile`  		=	'".$_POST['contact_no_Mobile']."',
								`city`						=	'".$_POST['city']."'
								 where pk_vendor_id = '".$_POST['pk_vendor_id']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			  $insert_id=$_POST['pk_vendor_id'];
			  //
			  $query="delete from tbl_vendor_category_bridge where fk_vendor_id = '".$_POST['pk_vendor_id']."'";
			  $dbres = $this->db->query($query);
			  //
			  $insert_id=$_POST['pk_vendor_id'];
			  //
			  foreach($_POST['category'] as $category)
			  {
				  $query="insert into tbl_vendor_category_bridge SET 				  
								`fk_vendor_id`				=	'".$insert_id."',
								`fk_category_id`			=	'".$category."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  }
            redirect(site_url() . 'sys/vendors?msg_upt=success');
	}
	
	public function insert_equipment_registration()
	{
			 $this->load->model("profile_model");
			$query="insert into tbl_instruments SET 				  
								`serial_no`				=	'".$_POST['serial_no']."',
								`fk_client_id`			=	'".$_POST['cutomer']."',
								`fk_vendor_id`			=	'".$_POST['vendor']."',
								`fk_category_id`		=	'".$_POST['category']."',
								
								`install_date`			=	'".date('Y-m-d')."',
								`fk_product_id`			=	'".$_POST['equipment']."',
								`fk_office_id`			=	'".$_POST['office']."',
								`invoice_number`		=	'".$_POST['invoice_number']."',
								`invoice_date`			=	'".$this->profile_model->change_date_to_mysql_style($_POST['invoice_date'])."',
								`equipment_price`		=	'".$_POST['equipment_price']."',
								`warranty_months`		=	'".$_POST['warranty_months']."',
								`warranty_start_date`	=	'".$this->profile_model->change_date_to_mysql_style($_POST['warranty_start_date'])."',
								`status`				=	'".$_POST['status']."',
								`details`				=	'".$_POST['description']."'
								";
			  //echo $query;exit; $this->profile_model->change_date_to_mysql_style for dates important missing in above  by zaaid
			  $dbres = $this->db->query($query);
			  //
			  
            redirect(site_url() . 'sys/equipment_registration?msg=success');
	}
	
	public function insert_aux_equipment_registration()
	{
		$main_equipment_string = "";
		foreach($_POST['main_equipment'] as $main_equipment)
			  {
				  $main_equipment_string .= ",".$main_equipment;
			  }
			  
			 $this->load->model("profile_model");
			$query="insert into tbl_instruments SET 				  
								`serial_no`				=	'".$_POST['serial_no']."',
								`main_equipment`		=	'".ltrim($main_equipment_string, ',')."',
								`fk_client_id`			=	'".$_POST['cutomer']."',
								`fk_vendor_id`			=	'".$_POST['vendor']."',
								`fk_category_id`		=	'".$_POST['category']."',
								
								`install_date`			=	'".date('Y-m-d')."',
								`fk_product_id`			=	'".$_POST['equipment']."',
								`fk_office_id`			=	'".$_POST['office']."',
								`invoice_number`		=	'".$_POST['invoice_number']."',
								`invoice_date`			=	'".$this->profile_model->change_date_to_mysql_style($_POST['invoice_date'])."',
								`equipment_price`		=	'".$_POST['equipment_price']."',
								`warranty_months`		=	'".$_POST['warranty_months']."',
								`warranty_start_date`	=	'".$this->profile_model->change_date_to_mysql_style($_POST['warranty_start_date'])."',
								`status`				=	'".$_POST['status']."',
								`details`				=	'".$_POST['description']."'
								";
			  //echo $query;exit; $this->profile_model->change_date_to_mysql_style for dates important missing in above  by zaaid
			  $dbres = $this->db->query($query);
			  //
			  
            redirect(site_url() . 'sys/aux_equipment_registration?msg=success');
	}
	
	public function add_working_details_insert()
	{
			$fk_complaint_id=$_POST['fk_complaint_id'];
			$fk_complaint_id=trim($fk_complaint_id);
			 $this->load->model("profile_model");
			$query="insert into tbl_working_details SET 				  
								`fk_complaint_id`		=	'".$fk_complaint_id."',
								`date`					=	'".$this->profile_model->change_date_to_mysql_style($_POST['wd_date'])."',
								`time`					=	'".$_POST['wd_time']."',
								`action_taken`			=	'".urlencode($_POST['action_taken'])."',
								`result`				=	'".urlencode($_POST['result'])."',
								`user_id`				=	'".$this->session->userdata('userid')."',
								`entry_date`			=	'".date('Y-m-d H:i:s')."',
								`analysis`				=	'".urlencode($_POST['analysis'])."'
								";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			 //echo site_url() . 'sys/technical_service_pvr/'.$fk_complaint_id."#working_details";
            redirect(site_url() . 'sys/technical_service_pvr/'.$fk_complaint_id."#working_details");
			
	}
	
	public function add_qc_data_insert()
	{
			$fk_complaint_id=$_POST['fk_complaint_id'];
			//$fk_complaint_id=24;
			 $this->load->model("profile_model");
			$query="insert into tbl_qc_data SET 				  
								`fk_complaint_id`		=	'".$_POST['fk_complaint_id']."',								
								`calibration_data`		=	'".urlencode($_POST['calibration_data'])."',
								`user_id`				=	'".$this->session->userdata('userid')."',
								`entry_date`			=	'".date('Y-m-d H:i:s')."',
								`qc_data`				=	'".urlencode($_POST['qc_data'])."'
								";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			  
            redirect(site_url() . 'sys/technical_service_pvr/'.trim($fk_complaint_id)."#qc_dataa");
	}
	
	public function update_ts_report_supervisor()
	{
			 $this->load->model("profile_model");
			 
			 
			 
			 $query="UPDATE tbl_complaints SET ";		
								
								
			if(isset($_POST['status']) && $_POST['status']=='Pending (BB)')
			{
				$query.=		"`status`							=	'".$_POST['status']."',
								`assign_to`							=	'".$_POST['problem_type2']."',
								`supervisor_findings`				=	'".$_POST['supervisor_findings']."'";
					///////////////////// Bounce Back Comments Codes			
				$current_date	= 	date('Y-m-d H:i:s');
			$employee_id	=	$this->session->userdata('userid');
			$comment  		=	"Bounce Back - " . $_POST['bb_comments'];
			$complaint_id	=	$_POST['complaint_id'];
			
			$q="insert into tbl_comments SET 				
									`date`						=	'".$current_date."',
									`fk_employee_id`  			=	'".$employee_id."',
									`fk_complaint_id`  			=	'".$complaint_id."',
									`comment`					=	'".urlencode($comment)."'
								  ";
			$dbres = $this->db->query($q);
			/////////////////////////// Bounce Back Comments Code
			}
			elseif(isset($_POST['status']) && $_POST['status']=='Closed')
			{
				$query.=	   "`status`							=	'".$_POST['status']."',
								`verification_method`				=	'".$_POST['optionsRadios']."',
								`supervisor_comments`				=	'".$_POST['remarks']."',
								`supervisor_findings`				=	'".$_POST['supervisor_findings']."',
								`contact_person_verification`		=	'".$_POST['contact_person_verification']."',
								`contact_number_verification`		=	'".$_POST['contact_number_verification']."',
								`finish_time` 						=	'".date('Y-m-d H:i:s')."'";
			}
			elseif(isset($_POST['status']) && $_POST['status']=='')
			{
								if($_POST['remarks']!='')
								{
									"`supervisor_comments`				=	'".$_POST['remarks']."',";
								}
								if($_POST['contact_person_verification']!='')
								{
									"`contact_person_verification`		=	'".$_POST['contact_person_verification']."',";
								}
								if($_POST['remarks']!='')
								{
									"`contact_number_verification`		=	'".$_POST['contact_number_verification']."',";
								}
								"`supervisor_findings`							=	'".$_POST['supervisor_findings']."'";
			}
			$query.="
								WHERE
								`pk_complaint_id`					=	'".$_POST['complaint_id']."'
								";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			redirect(site_url() . 'sys/technical_service_pvr/'.$_POST['complaint_id']);
	}
	public function supervisor_view_complaints()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->view('sys/supervisor_view_complaints');
	}
	public function update_ts_report()
	{
			 $this->load->model("profile_model");
			 
			 $query="UPDATE tbl_complaints SET ";
			 if ($_POST['reporting_date']!=""){				  
						$query.="`reporting_date`								=	'".$this->profile_model->change_date_to_mysql_style($_POST['reporting_date'])."',";
			 }
			 if ($_POST['solution_date']!=""){				  
						$query.="`solution_date`								=	'".$this->profile_model->change_date_to_mysql_style($_POST['solution_date'])."',";
			 }
				$query.="		`reporting_time`								=	'".$_POST['reporting_time']."',
								`ps_name`										=	'".$_POST['ps_name']."',
								`customer_signing_complaint_form`				=	'".urlencode($_POST['customer_signing_complaint_form'])."',
								`customer_mobile_signing_complaint_form`		=	'".urlencode($_POST['customer_mobile_signing_complaint_form'])."',
								`customer_designation_signing_complaint_form`	=	'".urlencode($_POST['customer_designation_signing_complaint_form'])."',
								`solution_time`									=	'".$_POST['solution_time']."',
								`problem_cause`									=	'".$_POST['problem_cause']."',
								`customer_feedback`								=	'".urlencode($_POST['customer_feedback'])."'
								WHERE
								`pk_complaint_id`								=	'".$_POST['complaint_id']."'
								";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			  
			  
			  
			  if (@$_FILES["uploadFile"]["tmp_name"][0] == "") {
            //echo "sanaullah";exit;
        } else {
			
			$dbres = $this->db->query("select * from tbl_complaints where pk_complaint_id ='".$_POST['complaint_id']."'");
			$get_users_lists=$dbres->result_array();
			if($get_users_lists[0]["image"]!="")
			{
            	unlink('usersimages/complaint_images/' . $get_users_lists[0]["pk_complaint_id"] . '.' . $get_users_lists[0]["image"]);
			}
            /*             * * ** */
            $target_dir = "usersimages/complaint_images/";
            $fileData = pathinfo(basename($_FILES["uploadFile"]["name"]));
            $ext = "";
            $fileName = $get_users_lists[0]["pk_complaint_id"] . '.' . $fileData['extension'];
            $ext = $fileData['extension'];
            $target_dir = $target_dir . $fileName;
            if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_dir)) {
                //echo "The file " . basename($_FILES["uploadFile"]["name"]) . " has been uploaded.";
            } else {
                //echo "Sorry, there was an error uploading your file.";
            }
            //update column Image_url
            mysql_query("UPDATE tbl_complaints SET image='" . $ext . "' WHERE pk_complaint_id='" . $get_users_lists[0]["pk_complaint_id"] . "' ");
        }
			  
			redirect(site_url() . 'sys/technical_service_pvr/'.$_POST['complaint_id']);
	}
	
	
	
	public function insert_dvr_admin()
	{
			foreach($_POST['starttime'] as $key=> $value)
			{
			 //echo 'start time'.$_POST['starttime'][$key].'<br> end time='.$_POST['endtime'][$key].'<br>';
			 $start_ampm=explode(' ',$_POST['starttime'][$key]);
			 $start_ampm_minut=explode(':',$start_ampm[0]);
			 $start_hour=explode(':',$_POST['starttime'][$key]);
			 // if($start_ampm[1]=='AM'){ $start_nhour=$start_hour[0]; }else{ $start_nhour=$start_hour[0]+12; } zaaid
			 if($start_ampm[1]=='PM' && $start_hour[0]<12){ $start_nhour=$start_hour[0]+12; }else{ $start_nhour=$start_hour[0]; }
			 if($start_ampm[1]=='AM' && $start_nhour==12 ){ $start_nhour-=12;}
			 $re_start_hour=$start_nhour.':'.$start_ampm_minut[1].':00';
			 //
			 $end_ampm=explode(' ',$_POST['endtime'][$key]);
			 $end_ampm_minut=explode(':',$end_ampm[0]);
			 $end_hour=explode(':',$_POST['endtime'][$key]);
			 //if($end_ampm[1]=='AM'){ $end_nhour=$end_hour[0]; }else{ $end_nhour=$end_hour[0]+12; }  zaaid
			 if($end_ampm[1]=='PM' && $end_hour[0]<12){ $end_nhour=$end_hour[0]+12; }else{ $end_nhour=$end_hour[0]; }
			 if($end_ampm[1]=='AM' && $end_nhour==12 ){ $end_nhour-=12;}
			 $re_end_hour=$end_nhour.':'.$end_ampm_minut[1].':00';
			 //echo 'start time'.$re_start_hour.'<br> end time='.$re_end_hour;exit;
			 //
			 //echo $_POST['city'][$key];exit;
			 $this->load->model("profile_model");
			 $dvr_date = date('Y-m-d',strtotime($_POST['date'][$key]));
			 $dvr_date = $dvr_date.' '.$re_start_hour;
			 $query="insert into tbl_dvr SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`fk_city_id`			=	'".$_POST['city'][$key]."',
								`fk_engineer_id`  		=	'".$_POST['engineer'][$key]."',
								`fk_customer_id`		=	'".$_POST['customer'][$key]."',";
			if(substr($_POST['business'][$key],0,1)=='t')
			{ 
				$compalintid = explode('_',$_POST['business'][$key]);
				$query.="`fk_business_id`		=	'0',
						 `fk_complaint_id`		=	'".$compalintid[1]."',";
			}
			else
			{
				$query.="`fk_business_id`		=	'".$_POST['business'][$key]."',
						 `fk_complaint_id`		=	'0',";
			}
				$query.="
								`priority`				=	'".urlencode($_POST['business_description'][$key])."',
								`timeline`				=	'".$_POST['time_elaped'][$key]."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`next_plan`				=	'".urlencode($_POST['next_plan'][$key])."',
								`date`					=	'".$this->profile_model->change_date_to_mysql_style($_POST['date'][$key])."'
								
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
				redirect(site_url() . 'sys/admin_dvr_form?msg=success');
			}
	}
	public function insert_vs()
	{
			foreach($_POST['starttime'] as $key=> $value)
			{
			 //echo 'start time'.$_POST['starttime'][$key].'<br> end time='.$_POST['endtime'][$key].'<br>';
			 $start_ampm=explode(' ',$_POST['starttime'][$key]);
			 $start_ampm_minut=explode(':',$start_ampm[0]);
			 $start_hour=explode(':',$_POST['starttime'][$key]);
			// if($start_ampm[1]=='AM'){ $start_nhour=$start_hour[0]; }else{ $start_nhour=$start_hour[0]+12; } zaaid
			if($start_ampm[1]=='PM' && $start_hour[0]<12){ $start_nhour=$start_hour[0]+12; }else{ $start_nhour=$start_hour[0]; }
			 if($start_ampm[1]=='AM' && $start_nhour==12 ){ $start_nhour-=12;}
			 $re_start_hour=$start_nhour.':'.$start_ampm_minut[1].':00';
			 //
			 $end_ampm=explode(' ',$_POST['endtime'][$key]);
			 $end_ampm_minut=explode(':',$end_ampm[0]);
			 $end_hour=explode(':',$_POST['endtime'][$key]);
			 //if($end_ampm[1]=='AM'){ $end_nhour=$end_hour[0]; }else{ $end_nhour=$end_hour[0]+12; } zaaid
			 if($end_ampm[1]=='PM' && $end_hour[0]<12){ $end_nhour=$end_hour[0]+12; }else{ $end_nhour=$end_hour[0]; }
			 if($end_ampm[1]=='AM' && $end_nhour==12 ){ $end_nhour-=12;}
			 $re_end_hour=$end_nhour.':'.$end_ampm_minut[1].':00';
			 //echo 'start time'.$re_start_hour.'<br> end time='.$re_end_hour;exit;
			 //
			 
			 //////////////////////zaaid
			 $current_date=date('Y-m-d');
			 $current_time=date('H');
			 if ($current_time<8) {$current_date = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $current_date) ) ));}
			 $current_date = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $current_date) ) ));
			 if (date('l', strtotime($current_date)) == 'Sunday'){
				 $current_date = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $current_date) ) ));
				}
			///////////////////// zaaid
			 $query="insert into tbl_vs SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`fk_city_id`			=	'".$_POST['city'][$key]."',
								`fk_engineer_id`  		=	'".$this->session->userdata('userid')."',
								`fk_customer_id`		=	'".$_POST['customer'][$key]."',
								`fk_business_id`		=	'".$_POST['business'][$key]."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`date`					=	'".$current_date."'
								
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			}
			if(isset($_POST['redirect_project'])) redirect(site_url() . 'sys/sap_vs?msg=success&p='.$_POST['redirect_project']);
            else redirect(site_url() . 'sys/sap_vs?msg=success');
	}
	
	
	public function insert_vs_engineer()
	{
			foreach($_POST['starttime'] as $key=> $value)
			{
			 //echo 'start time'.$_POST['starttime'][$key].'<br> end time='.$_POST['endtime'][$key].'<br>';
			 $start_ampm=explode(' ',$_POST['starttime'][$key]);
			 $start_ampm_minut=explode(':',$start_ampm[0]);
			 $start_hour=explode(':',$_POST['starttime'][$key]);
			 //if($start_ampm[1]=='AM'){ $start_nhour=$start_hour[0]; }else{ $start_nhour=$start_hour[0]+12; } zaaid
			 if($start_ampm[1]=='PM' && $start_hour[0]<12){ $start_nhour=$start_hour[0]+12; }else{ $start_nhour=$start_hour[0]; }
			 if($start_ampm[1]=='AM' && $start_nhour==12 ){ $start_nhour-=12;}
			 $re_start_hour=$start_nhour.':'.$start_ampm_minut[1].':00';
			 //
			 $end_ampm=explode(' ',$_POST['endtime'][$key]);
			 $end_ampm_minut=explode(':',$end_ampm[0]);
			 $end_hour=explode(':',$_POST['endtime'][$key]);
			// if($end_ampm[1]=='AM'){ $end_nhour=$end_hour[0]; }else{ $end_nhour=$end_hour[0]+12; } zaaid
			if($end_ampm[1]=='PM' && $end_hour[0]<12){ $end_nhour=$end_hour[0]+12; }else{ $end_nhour=$end_hour[0]; }
			if($end_ampm[1]=='AM' && $end_nhour==12 ){ $end_nhour-=12;}
			$re_end_hour=$end_nhour.':'.$end_ampm_minut[1].':00';
			 //echo 'start time'.$re_start_hour.'<br> end time='.$re_end_hour;exit;
			 //
			 //////////////////////zaaid
			 $current_date=date('Y-m-d');
			 $current_time=date('H');
			 if ($current_time<8) {$current_date = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $current_date) ) ));}
			 $current_date = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $current_date) ) ));
			 if (date('l', strtotime($current_date)) == 'Sunday'){
				 $current_date = date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $current_date) ) ));
				}
			///////////////////// zaaid
			
			 $query="insert into tbl_vs SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`fk_city_id`			=	'".$_POST['city'][$key]."',
								`fk_engineer_id`  		=	'".$this->session->userdata('userid')."',
								`fk_customer_id`		=	'".$_POST['customer'][$key]."',
								`fk_business_id`		=	'".$_POST['business'][$key]."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`date`					=	'".$current_date."'
								
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			}
            redirect(site_url() . 'sys/engineer_vs?msg=success');
	}
	public function insert_complaint() {
		$this->load->model("profile_model");
		$problem_summery=$_POST['instrument_prob'].' '.$_POST['kit_prob_des_cus'];
		if(!empty($_POST['call_date']))
		{
			$newdelevrydate = $this->profile_model->change_date_to_mysql_style($_POST['call_date']);
		}
		
		$client_temp = '';
		if (substr($_POST['customer'],0,1)=='o') {
			$temp_office = explode('_',$_POST['customer']);
			$client_temp = '-'.$temp_office[1];
		}
		else $client_temp = $_POST['customer'];
		 //$dbres2 = $this->db->query("select * from tbl_cities where pk_city_id = '".$_POST['city']."'");
		 $dbres2 = $this->db->query("select * from user where id = '".$_POST['assign_to']."'");
		 $office = $dbres2->result_array();
		$data = array(
						'ts_number' 					=> 	$_POST['ts_number'],
						'caller_name'  					=> 	$_POST['caller_name'],
						'date'							=> 	$newdelevrydate.' '.$_POST['call_time'],
						'fk_customer_id'				=> 	$client_temp,
						'fk_city_id'		 			=> 	$_POST['city'],
						'fk_office_id'		 			=> 	$office[0]['fk_office_id'],
						'problem_summary'				=>  $problem_summery,
						'status'						=> 	"Pending",
						'FSE_SAP'						=> 	$client_temp,
						'phone'							=>  $_POST['mobile'],
						'problem_type'					=> 	$_POST['problem_type'],
						'assign_to' 					=> 	$_POST['assign_to'],
						'created_by' 					=> 	$this->session->userdata('userid'),
						
						
						'instrument_prob'				=> 	$_POST['instrument_prob'],
						'instrument_error_msg'			=> 	$_POST['instrument_error_msg'],
						'error_no'						=> 	$_POST['error_no'],
						'last_ok_time'					=> 	$this->profile_model->change_date_to_mysql_style($_POST['last_ok_time']),
						'action_after_problem'			=> 	$_POST['action_after_problem'],
						'is_done_before'				=> 	$_POST['is_done_before'],
						
						
						'kit_name'						=> 	$_POST['kit_name'],
						'kit_lot_no'					=> 	$_POST['kit_lot_no'],
						'make_pack'						=> 	$_POST['make_pack'],
						'kit_prob_des_cus'				=> 	$_POST['kit_prob_des_cus'],
						'is_colb_ok_rec'				=> 	$_POST['is_colb_ok_rec'],
						'cont_run_after'				=> 	$_POST['cont_run_after'],
						'instrument_software_version'	=>  $_POST['instrument_software_version'],
						'complaint_nature'				=>	'complaint'
            		);
			if(isset($_POST['urgent_priority']))
			{
				$data['urgent_priority']=	"1";
			}
			if(isset($_POST['instrument']))
			{
				$data['fk_instrument_id']=	$_POST['instrument'];
			}
			
					
			//print_r($data);exit;
            $this->load->model("complaint_model");
            $result = $this->complaint_model->insert_complaint($data);
            //echo $this->db->insert_id();
			
			$name		=	$_POST['caller_name'];
			$email		=	'info@mypmaonline.com';
			$phone		=	$_POST['mobile'];
			$comments	=	$problem_summery;
			
	
			$to = 'zaaid@rozesolutions.com';
			//$cc = 'sajjad.j@medialinkers.com';
				
			
			$subject ="Complaint Added to MYPMAONLINE.COM";
			
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers.="From: $email \r\n";
			//$headers .= "CC: $cc\r\n";
			//$headers .= "BCC: hidden@special.com\r\n";
			$headers.="Return-Path: $email \r\n";
			
			$body = '<table width="650" border="0">
					   <tr bgcolor="#BDD5DF">
						<td colspan="2">New Complaint Added. Details are below:</td>
					  </tr>				  
					  <tr bgcolor="#D5D5D5">
						<td width="110">Name:</td>
						<td width="265">'.$name.'</td>
					  </tr>
					   <tr bgcolor="#D5D5D5">
						<td>Phone:</td>
						<td>'.$phone.'</td>
					  </tr>
					  <tr bgcolor="#D5D5D5">
						<td>Email:</td>
						<td>'.$email.'</td>
					  </tr>				 
					  <tr bgcolor="#D5D5D5">
						<td valign="top">Comments:</td>
						<td valign="top">'.$comments.'</td>
					  </tr>				  
					</table>';
			mail($to, $subject, $body, $headers);
            redirect(site_url() . 'sys/operator_view_complaints?msg=success');
	  }
	//complete complaint registration
	public function complete_complaint_resgistration() {
		$this->load->model("profile_model");
		$problem_summery=$_POST['instrument_prob'].' '.$_POST['kit_prob_des_cus'];
		if(!empty($_POST['call_date']))
		{
			$newdelevrydate = $this->profile_model->change_date_to_mysql_style($_POST['call_date']);
		}
		
		$client_temp = '';
		if (substr($_POST['customer'],0,1)=='o') {
			$temp_office = explode('_',$_POST['customer']);
			$client_temp = '-'.$temp_office[1];
		}
		else $client_temp = $_POST['customer'];
		 //$dbres2 = $this->db->query("select * from tbl_cities where pk_city_id = '".$_POST['city']."'");
		 //$dbres2 = $this->db->query("select * from user where id = '".$_POST['assign_to']."'");
		 //$office = $dbres2->result_array();
		 // I am adding these below after a long time as office should be according to the user complaint being assigned, adding office at the end of first block of query too
		 $dbres2 = $this->db->query("select * from user where id = '".$_POST['assign_to']."'");
		 $office = $dbres2->result_array();
		$data = array(
						'ts_number' 					=> 	$_POST['ts_number'],
						'caller_name'  					=> 	$_POST['caller_name'],
						'date'							=> 	$newdelevrydate.' '.$_POST['call_time'],
						'fk_customer_id'				=> 	$client_temp,
						'fk_city_id'		 			=> 	$_POST['city'],
						'problem_summary'				=>  $problem_summery,
						'status'						=> 	$_POST['complaint_hidden_status'],
						'FSE_SAP'						=> 	$client_temp,
						'phone'							=>  $_POST['mobile'],
						'problem_type'					=> 	$_POST['problem_type'],
						'assign_to' 					=> 	$_POST['assign_to'],
						'fk_office_id'		 			=> 	$office[0]['fk_office_id'],
						
						
						'instrument_prob'				=> 	$_POST['instrument_prob'],
						'instrument_error_msg'			=> 	$_POST['instrument_error_msg'],
						'error_no'						=> 	$_POST['error_no'],
						'last_ok_time'					=> 	$this->profile_model->change_date_to_mysql_style($_POST['last_ok_time']),
						'action_after_problem'			=> 	$_POST['action_after_problem'],
						'is_done_before'				=> 	$_POST['is_done_before'],
						
						
						'kit_name'						=> 	$_POST['kit_name'],
						'kit_lot_no'					=> 	$_POST['kit_lot_no'],
						'make_pack'						=> 	$_POST['make_pack'],
						'kit_prob_des_cus'				=> 	$_POST['kit_prob_des_cus'],
						'is_colb_ok_rec'				=> 	$_POST['is_colb_ok_rec'],
						'cont_run_after'				=> 	$_POST['cont_run_after'],
						'instrument_software_version'	=>  $_POST['instrument_software_version'],
						'complaint_nature'				=>	'complaint'
            		);
			if(isset($_POST['urgent_priority']))
			{
				$data['urgent_priority']=	"1";
			}
			if(isset($_POST['instrument']))
			{
				$data['fk_instrument_id']=	$_POST['instrument'];
			}
			
					
			//print_r($data);exit;
            $this->load->model("complaint_model");
            $result = $this->complaint_model->complete_complaint($data,$_POST['complaint_hidden_id']);
            //echo $this->db->insert_id();
			
            redirect(site_url() . 'sys/director_view_complaints?msg_update=success');
	  }
	//half insert
	public function insert_complaint_half() {
		$this->load->model("profile_model");
		$problem_summery=$_POST['instrument_prob'].' '.$_POST['kit_prob_des_cus'];
		if(!empty($_POST['call_date']))
		{
			$newdelevrydate = $this->profile_model->change_date_to_mysql_style($_POST['call_date']);
		}
		 //$dbres2 = $this->db->query("select * from tbl_cities where pk_city_id = '".$_POST['city']."'");
		$data = array(
						'ts_number' 					=> 	$_POST['ts_number'],
						'caller_name'  					=> 	$_POST['caller_name'],
						'date'							=> 	$newdelevrydate.' '.$_POST['call_time'],
						'fk_customer_id'				=> 	$_POST['customer'],
						'fk_city_id'		 			=> 	$_POST['city'],
						'problem_summary'				=>  $problem_summery,
						'status'						=> 	"Pending Registration",
						'FSE_SAP'						=> 	$_POST['customer'],
						'phone'							=>  $_POST['mobile'],
						'landline'						=>  $_POST['telephone'],
						'problem_type'					=> 	$_POST['problem_type'],
						'created_by' 					=> 	$this->session->userdata('userid'),
						
						
						'instrument_prob'				=> 	$_POST['instrument_prob'],
						'instrument_error_msg'			=> 	$_POST['instrument_error_msg'],
						'error_no'						=> 	$_POST['error_no'],
						'last_ok_time'					=> 	$this->profile_model->change_date_to_mysql_style($_POST['last_ok_time']),
						'action_after_problem'			=> 	$_POST['action_after_problem'],
						'is_done_before'				=> 	$_POST['is_done_before'],
						
						
						'kit_name'						=> 	$_POST['kit_name'],
						'kit_lot_no'					=> 	$_POST['kit_lot_no'],
						'make_pack'						=> 	$_POST['make_pack'],
						'kit_prob_des_cus'				=> 	$_POST['kit_prob_des_cus'],
						'is_colb_ok_rec'				=> 	$_POST['is_colb_ok_rec'],
						'cont_run_after'				=> 	$_POST['cont_run_after'],
						'instrument_software_version'	=>  $_POST['instrument_software_version'],
						'complaint_nature'				=>	'complaint'
            		);
			if(isset($_POST['urgent_priority']))
			{
				$data['urgent_priority']=	"1";
			}
			if(isset($_POST['instrument']))
			{
				$data['fk_instrument_id']=	$_POST['instrument'];
			}
			if(isset($_POST['problem_type']) && $_POST['problem_type']=='kit')
			{
				$qu = $this->db->query("select * from tbl_clients where pk_client_id = '".$_POST['customer']."'");
				$re =$qu->result_array();
				$data['fk_office_id']=	$re[0]['fk_office_id'];
			}
			if(isset($_POST['problem_type']) && $_POST['problem_type']=='equipment')
			{
				$qu = $this->db->query("select * from tbl_instruments where pk_instrument_id = '".$_POST['instrument']."'");
				$re =$qu->result_array();
				$data['fk_office_id']=	$re[0]['fk_office_id'];
			}
			
					
			//print_r($data);exit;
            $this->load->model("complaint_model");
            $result = $this->complaint_model->insert_complaint($data);
            //echo $this->db->insert_id();
            redirect(site_url() . 'sys/add_complaint_half?msg=Complaint Added Successfully');
	  }
	// Delete Single Message.
	
		public function shift_complaint() {
        if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
        $this->load->view('sys/shift_complaint');
    }

    public function shift_complaint_update() {
    	
    	$assign_to = $this->input->post('assign_to');
    	//echo "hi ".$this->input->post('complaint_id') . "\n";

    	$q 	=	"select fk_office_id from user WHERE id='" . $assign_to ."'";	
    	$r 	=		$this->db->query($q);
    	$result = 	$r->result_array();
    	$s 		=	$result[0]['fk_office_id'];

    	

    	$query="update tbl_complaints SET status='Shifted', assign_to='".$this->input->post('assign_to')."', fk_office_id='".$s."' where pk_complaint_id='".$this->input->post('complaint_id')."'";
		$dbres = $this->db->query($query);
		redirect(site_url() . 'sys/shift_sys/'.$this->input->post('complaint_id')."?msg=success");
        
    }

	public function insert_complaint_pm() {
	
		 $maxqu = $this->db->query("SELECT MAX(ts_number) as mazz FROM tbl_complaints ");
		 $maxval=$maxqu->result_array();
		 //print_r($maxval);exit;
		 //echo $maxval[0]['mazz'];exit;
		 $cur_no=substr($maxval[0]['mazz'],6,10);//echo $cur_no.'sana';exit;
		 $exceded_no=$cur_no+1;
		 $cur_date=date("ymd");
		 $disp_no=$cur_date.$exceded_no;

                                 
		$this->load->model("profile_model");		
		$date = explode(' ',$_POST['date']);
		$date_date= $date[0];
		$date_time = $date[1];
		$new_date = $this->profile_model->change_date_to_mysql_style($date_date).' '.$date_time.':0';	 			 
		$data = "insert into tbl_complaints SET
								`fk_city_id`			=	'".$_POST['fk_city_id']."',
								`fk_customer_id`		=	'".$_POST['fk_customer_id']."',
								`fk_instrument_id`		=	'".$_POST['fk_instrument_id']."',
								`fk_office_id`			=	'".$_POST['fk_office_id']."',
								`ts_number`  			=	'".$disp_no."',
								`assign_to`				=	'".$_POST['assign_to']."',
								`date`					=	'".$new_date."',
								`status`				= 	'Pending',
								`complaint_nature`		=	'PM'
								
			";
			 $dbres = $this->db->query($data);
            redirect(site_url() . 'sys/supervisor_assign_pm?msg=success');
	  }
	public function city_list_ajax()
	{
        $client_id=$this->input->post('var_name');
		//$this->load->model("complaint_model");
        //$get_complaint_list = $this->complaint_model->get_related_cities($client_name);
		//
		$dbres = $this->db->query("SELECT * FROM tbl_clients where pk_client_id = '".$client_id."'");
        $dbresResult=$dbres->result_array();
		//
		echo '<select name="city" class="form-control" onchange="select_contact_no(this.value)" required>';
		echo '<option value="">---Select---</option>';
		$nn=$this->db->query("select * from tbl_cities where pk_city_id = '".$dbresResult[0]['fk_city_id']."'");
		$nnm=$nn->result_array();
		foreach($nnm as $drt)
		{
			echo '<option value="';
			echo $drt["pk_city_id"];
			echo '">';
			echo $drt["city_name"];
			echo '</option>';
		}
        echo '</select>';
	}
	
	public function equipment_list_ajax()
	{
        $product_id = $this->input->post('product_id');
		$maxqu = $this->db->query("SELECT tbl_instruments.* ,tbl_products.product_name,tbl_clients.client_name,tbl_cities.city_name FROM tbl_instruments 
									LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
									LEFT JOIN tbl_clients ON tbl_instruments.fk_client_id = tbl_clients.pk_client_id
									LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
									WHERE fk_product_id = '".$product_id."'
									ORDER BY   `product_name`,`pk_instrument_id` ");
								
		$maxval=$maxqu->result_array();
		//
		echo '<select name="equipment" id="equipment" class="form-control" required>';
        echo '<option value="">--Select Equipment--</option>';
		foreach($maxval as $val) {
			$client_name = (isset($val["client_name"])) ? $val["client_name"] : 'N/A' ;
			$city_name = (isset($val["city_name"])) ? $val["city_name"] : 'N/A' ;
			echo '<option value="'.$val["pk_instrument_id"].'">'.$val["serial_no"].' - '.$client_name .' ('.$city_name .') </option>';
		}
        echo '</select>';
	}
	
	public function customer_list_ajax()
	{
        $city_id=$this->input->post('var_name');		//
		$dbres = $this->db->query("SELECT * FROM tbl_clients where fk_city_id = '".$city_id."' AND delete_status='0'");
        $dbresResult=$dbres->result_array();
		
		$dbress = $this->db->query("SELECT * FROM tbl_offices where fk_city_id = '".$city_id."' ");
        $dbressResult=$dbress->result_array();
		//
		echo '<select name="customer" class="form-control" id="client_name" onchange="select_contact_no(this.value)" required>';
		echo '<option value="">---Select---</option>';
		
		foreach($dbressResult as $value)
		{
			?>
            <option value="<?php echo $value['client_option'];?>">
			  <?php echo $value['office_name'];
                  ?>			
            </option>
            <?php
		}
		
		foreach($dbresResult as $value)
		{
			?>
            <option value="<?php echo $value['pk_client_id'];?>">
			  <?php echo $value['client_name'];
                          $qu2="SELECT * from tbl_cities where pk_city_id = '".$value['fk_city_id']."' ";
                          $gh2=$this->db->query($qu2);
                          $rt2=$gh2->result_array();
                          echo '--('.$rt2[0]['city_name'].')';
                          //
                          $qu3="SELECT * from tbl_area where pk_area_id = '".$value['fk_area_id']."' ";
                          $gh3=$this->db->query($qu3);
                          $rt3=$gh3->result_array();
                          echo '--('.$rt3[0]['area'].')';
                  ?>			
            </option>
            <?php
		}
        echo '</select>';
	}
	public function teritory_list_ajax()
	{
		$city_id=$this->input->post('city_id');
		$this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_related_teritory($city_id);
		echo '<select class="form-control" name="territory">';
		foreach($get_complaint_list as $drt)
		{
			echo '<option value="';
			echo $drt["fk_office_id"];
			echo '">';
			$nn=$this->db->query("select * from tbl_offices where pk_office_id = '".$drt["fk_office_id"]."'");
			$nnm=$nn->result_array();
			echo $nnm[0]["office_name"];
			echo '</option>';
		}
        echo '</select>';
	}
	//
	public function vendor_based_on_product_ajax()
	{
		$category			=	$this->input->post('category');
		$rrr				=	"select * from tbl_vendor_category_bridge where fk_category_id = '".$category."' ";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		echo '<select name="vendor';
		echo '" class="form-control"';
		echo ' required onchange="show_equipment(this.value)">';
		echo '<option value="">---Select---</option>';
		foreach($nnm as $drt)
		{
			$rrr2=	"select * from tbl_vendors where pk_vendor_id = '".$drt["fk_vendor_id"]."' AND status = '0' ";
			//echo $rrr2;
			$nn2=$this->db->query($rrr2);
			if($nn2->num_rows() > 0)
			{
				echo '<option value="';
				echo $drt["fk_vendor_id"];
				echo '">';
				
				$nnm2=$nn2->result_array();
				echo $nnm2[0]["vendor_name"];
				echo '</option>';
			}
		}
        echo '</select>';
	}
	
	public function vendor_based_on_product_2_ajax()
	{
		$category			=	$this->input->post('category');
		$rrr				=	"select * from tbl_vendor_product_bridge where fk_product_id = '".$category."' ";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		echo '<select name="vendor';
		echo '" class="form-control"';
		echo ' required >';
		echo '<option value="">---Select---</option>';
		foreach($nnm as $drt)
		{
			$rrr2=	"select * from tbl_vendors where pk_vendor_id = '".$drt["fk_vendor_id"]."' AND status = '0' ";
			//echo $rrr2;
			$nn2=$this->db->query($rrr2);
			if($nn2->num_rows() > 0)
			{
				echo '<option value="';
				echo $drt["fk_vendor_id"];
				echo '">';
				
				$nnm2=$nn2->result_array();
				echo $nnm2[0]["vendor_name"];
				echo '</option>';
			}
		}
        echo '</select>';
	}
	//
	
	public function category_based_on_vendortype_ajax()
	{
		$product_type			=	$this->input->post('product_type');
		$rrr				=	"select * from tbl_category where fk_type_id = '".$product_type."' ";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		echo '<select name="fk_product_id';
		if(isset($_POST['mutiple'])){echo'[]';}
		echo '" class="form-control"';
		if(isset($_POST['mutiple'])){echo ' multiple="multiple"';}
		if(!isset($_POST['mutiple'])){echo ' onchange="select_vendor(this.value)"';}
		echo ' required>';
		echo '<option value="">---Select---</option>';
		foreach($nnm as $drt)
		{
			echo '<option value="';
			echo $drt["pk_category_id"];
			echo '">';
			echo $drt["category_name"];
			echo '</option>';
		}
        echo '</select>';
	}
	//
	public function vendors_based_on_category_ajax()
	{
		$category			=	$this->input->post('category');
		$rrr				=	"select * from tbl_vendor_category_bridge where fk_category_id = '".$category."' ";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		echo '<select name="vendors';
		if(isset($_POST['mutiple'])){echo'[]';}
		echo '" class="form-control"';
		if(isset($_POST['mutiple'])){echo ' multiple="multiple"';}
		echo ' required>';
		//echo '<option value="">---Select---</option>';
		foreach($nnm as $drt)
		{
			//
			$rrr2	=	"select * from tbl_vendors where pk_vendor_id = '".$drt["fk_vendor_id"]."' AND status = '0'";
			//echo $rrr;exit;
			$nn2=$this->db->query($rrr2);
			if($nn2->num_rows()>0)
			{
			  $nnm2=$nn2->result_array();
			  echo '<option value="';
			  echo $drt["fk_vendor_id"];
			  echo '">';
			  echo $nnm2[0]["vendor_name"];
			  echo '</option>';
			}
		}
        echo '</select>';
	}
	//
	
	
	public function main_based_on_customer_ajax()
	{
		$customer_id	   =	$this->input->post('customer_id');
		echo '<select class="form-control "  name="main_equipment[]" multiple="multiple"> ';
		$rrr	=	"SELECT tbl_instruments.pk_instrument_id ,tbl_instruments.serial_no ,tbl_products.product_name
										FROM tbl_instruments
										JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
										WHERE tbl_instruments.fk_category_id!=1 AND tbl_products.status=0 And 
										tbl_instruments.fk_client_id='".$customer_id."'
										ORDER BY   `product_name`,`serial_no`";
										//echo $rrr;exit;
										$nn=$this->db->query($rrr);
										$nnm=$nn->result_array();
										foreach($nnm as $drt)
										{
											
											echo '<option value="';
											echo $drt["pk_instrument_id"];
											echo '">';
											echo $drt["product_name"].' - '.$drt["serial_no"];
											echo '</option>';
										}
		echo '</select>';
	}
	
	public function equipment_based_on_vendor_ajax()
	{
		$category_id	=   $this->input->post('category_id');
		//$category_id	=   3;
		$vendor_id	   =	$this->input->post('vendor_id');
		$rrr			 =	"select * from tbl_vendor_product_bridge where fk_vendor_id = '".$vendor_id."' AND 
		fk_product_id IN (SELECT pk_product_id from tbl_products WHERE fk_category_id='".$category_id."')";
		//$rrr			 =	"select * from tbl_vendor_product_bridge where fk_vendor_id = '".$vendor_id."'";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		echo '<select name="equipment';
		echo '" class="form-control"';
		echo ' required>';
		echo '<option value="">---Select---</option>';
		foreach($nnm as $drt)
		{
			//
			$rrr2	=	"select * from tbl_products where pk_product_id = '".$drt["fk_product_id"]."' AND status = '0' ";
			$nn2=$this->db->query($rrr2);
			if($nn2->num_rows()>0)
			{
				$nnm2=$nn2->result_array();
				//
				echo '<option value="';
				echo $nnm2[0]["pk_product_id"];
				echo '">';
				echo $nnm2[0]["product_name"];
				echo '</option>';
			}
		}
        echo '</select>';
	}
	//
	public function product_based_on_vendortype_ajax()
	{
		$product_type			=	$this->input->post('product_type');
		$rrr				=	"select * from tbl_products where fk_type_id = '".$product_type."' ";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		echo '<select name="fk_product_id';
		if(isset($_POST['mutiple'])){echo'[]';}
		echo '" class="form-control"';
		if(isset($_POST['mutiple'])){echo ' multiple="multiple"';}
		if(!isset($_POST['mutiple'])){echo ' onchange="select_vendor(this.value)"';}
		echo ' required>';
		echo '<option value="">---Select---</option>';
		foreach($nnm as $drt)
		{
			echo '<option value="';
			echo $drt["pk_product_id"];
			echo '">';
			echo $drt["product_name"];
			echo '</option>';
		}
        echo '</select>';
	}
	public function select_engineer_ajax()
	{
		$instrument_id			=	$this->input->post('instrument_id');
		$rrr				=	"select * from tbl_instruments where pk_instrument_id = '".$instrument_id."' ";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		if($this->input->post('problem_type')=='equipment')
		{
        	$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$nnm[0]['fk_office_id']."' AND userrole IN ('FSE','Supervisor') AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
		}
		else
		{
			$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$nnm[0]['fk_office_id']."' AND userrole IN ('FSE','Salesman','Supervisor') AND delete_status='0'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
		}
		$yu=$get_complaint_list->result_array();
		echo '<select name="assign_to" class="form-control nnn input-xlarge" required>';
		echo '<option value="">---Select---</option>';
		foreach($yu as $drt)
		{
			echo '<option value="';
			echo $drt["id"];
			echo '">';
			echo $drt["first_name"];
			echo '</option>';
		}
        echo '</select>';
		
		echo '<div class="col-md-12"><br />';
		//mryasirtable				  
		echo '<table class="table table-condensed table-striped table-bordered table-hover flip-content">';
		echo '<thead>';
		//echo '<tr><th>Name</th><th>Pending TS</th><th>Pending PM</th><th>TS (30 Days)</th><th>PM (30 Days)</th></tr>';
		echo '<tr>
					  <th class="bg-blue-steel text-center bg-grey-border"> FSE </th>
                      <th class="bg-grey-steel text-center bg-grey-border"> Complaints<br />Assigned </th>
					  <th class="bg-grey-cararra text-center bg-grey-border"> Complaints<br />Solved </th>
					  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">Complaints<br />Pending </span></th>
                      <th class="bg-grey-steel text-center bg-grey-border"> PMC<br />Assigned </th>
                      <th class="bg-grey-cararra text-center bg-grey-border"> PMC<br />Completed </th>
					  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">  PMC<br />Pending </span> </th>
                    </tr>';
		echo '</thead>';
		echo '<tbody>';	
		foreach($yu as $pma_user)
		{
		/*
			$userid			 =	$pma_user['id'];
			//$complaint_id	 =	$this->input->post('complaint_id');


			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND status!='Closed'";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$pending_ts = sizeof($result); 

			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND status!='Completed'";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$pending_pm = sizeof($result);

			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$month_ts = sizeof($result);

			//WHERE   create_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
			//$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND MONTH(`date`) = MONTH(CURRENT_DATE) AND YEAR(`date`) = YEAR(CURRENT_DATE)";
			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$month_pm = sizeof($result);
			//echo "Pending TS: ".$pending_ts;

			echo "<tr><th>".$pma_user['first_name']."</th><td> <span class='label bg-red'>".$pending_ts."</span></td> <td><span class='label bg-yellow'>".$pending_pm."</span></td> <td><span class='label bg-green'>".$month_ts."</span></td><td> <span class='label bg-blue'>".$month_pm."</span></td></tr>";								
		*/
		$complaints_assigned	=	0;
		$complaints_solved	=	0;
		$complaints_pending	=	0;
		$pmc_assigned			=	0;
		$pmc_completed		=	0;
		$pmc_pending			=	0;

		$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status='Closed'");
		$rt10	=	$ty10->result_array();
		$complaints_solved	=	sizeof($rt10);

		$ty11	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status!='Closed'");
		$rt11	=	$ty11->result_array();
		$complaints_pending	=	sizeof($rt11);

		$ty12	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND status='Completed'");
		$rt12	=	$ty12->result_array();
		$pmc_completed	=	sizeof($rt12);

		$ty13	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND status!='Completed'");
		$rt13	=	$ty13->result_array();
		$pmc_pending	=	sizeof($rt13);
		
		/*echo '<tr class="odd gradeX">
                <td class="bg-blue-steel bg-grey-border"> '. $pma_user['first_name'] .'</td><td class="bg-grey-steel text-center bg-grey-border">'.dashForZero($complaints_solved+$complaints_pending).'</td>
				<td class="bg-grey-cararra text-center bg-grey-border">'.dashForZero($complaints_solved).'</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.dashForZero($complaints_pending).'</td><td class="bg-grey-steel text-center bg-grey-border">' .dashForZero($pmc_completed+$pmc_pending).'</td>	 
				<td class="bg-grey-cararra text-center bg-grey-border">'.dashForZero($pmc_completed).'</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.dashForZero($pmc_pending).'</td>';
		*/echo '<tr class="odd gradeX">';
         echo  '<td class="bg-blue-steel"> '. $pma_user["first_name"].'</td>';
		 echo  '<td class="bg-grey-steel text-center bg-grey-border">'.($complaints_solved+$complaints_pending);
		 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border">'.$complaints_solved;
		 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.$complaints_pending.'</td>';
		 echo  '<td class="bg-grey-steel text-center bg-grey-border">' .($pmc_completed+$pmc_pending).'</td>';
		 echo  '<td class="bg-grey-cararra text-center bg-grey-border">'.$pmc_completed;
		 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.$pmc_pending.'</td>';
		echo '</tr>';
		}
		//mryasirtable
		echo '</tbody>';
		echo '</table>';
	   
	   echo '</div>';
                           
	}
	public function select_engineer_2_ajax()
	{
		$client_id=$this->input->post('var_name');
		$office_id ='';
		//
		$dbres = $this->db->query("SELECT * FROM tbl_clients where pk_client_id = '".$client_id."'");
        $dbresResult=$dbres->result_array();
		if (sizeof($dbresResult)>0)
			$office_id = $dbresResult[0]['fk_office_id'];
		else {
			$temp_office = explode('_',$client_id);
			$office_id = $temp_office[1];
		}
		//
		
			
		
		
		$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$office_id."' AND userrole IN ('FSE','Salesman','Supervisor')  AND delete_status='0' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
		$yu=$get_complaint_list->result_array();
		echo '<select name="assign_to" class="form-control nnn" required>';
		echo '<option value="">---Select---</option>';
		foreach($yu as $drt)
		{
			echo '<option value="';
			echo $drt["id"];
			echo '">';
			echo $drt["first_name"];
			echo '</option>';
		}
        echo '</select>';
	}
	public function select_engineer_equipment_ajax()
	{
		$client_id=$this->input->post('client_name');
		//
		$dbres = $this->db->query("SELECT * FROM tbl_clients where pk_client_id = '".$client_id."'");
        $dbresResult=$dbres->result_array();
		//
		
		
		$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$dbresResult[0]['fk_office_id']."' AND userrole IN ('FSE','Supervisor')  AND delete_status='0' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
		$yu=$get_complaint_list->result_array();
		echo '<select name="assign_to" class="form-control nnn" required>';
		echo '<option value="">---Select---</option>';
		
		foreach($yu as $drt)
		{
			echo '<option value="';
			echo $drt["id"];
			echo '">';
			echo $drt["first_name"];
			echo '</option>';
		}
        echo '</select>';
		echo '<div class="col-md-12"><br />';
		//mryasirtable				  
		echo '<table class="table table-condensed table-striped table-bordered table-hover flip-content">';
		echo '<thead>';
		//echo '<tr><th>Name</th><th>Pending TS</th><th>Pending PM</th><th>TS (30 Days)</th><th>PM (30 Days)</th></tr>';
		echo '<tr>
					  <th class="bg-blue-steel text-center bg-grey-border"> FSE </th>
                      <th class="bg-grey-steel text-center bg-grey-border"> Complaints<br />Assigned </th>
					  <th class="bg-grey-cararra text-center bg-grey-border"> Complaints<br />Solved </th>
					  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">Complaints<br />Pending </span></th>
                      <th class="bg-grey-steel text-center bg-grey-border"> PMC<br />Assigned </th>
                      <th class="bg-grey-cararra text-center bg-grey-border"> PMC<br />Completed </th>
					  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">  PMC<br />Pending </span> </th>
                    </tr>';
		echo '</thead>';
		echo '<tbody>';	
		foreach($yu as $pma_user)
		{
		/*
			$userid			 =	$pma_user['id'];
			//$complaint_id	 =	$this->input->post('complaint_id');


			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND status!='Closed'";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$pending_ts = sizeof($result); 

			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND status!='Completed'";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$pending_pm = sizeof($result);

			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$month_ts = sizeof($result);

			//WHERE   create_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
			//$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND MONTH(`date`) = MONTH(CURRENT_DATE) AND YEAR(`date`) = YEAR(CURRENT_DATE)";
			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$month_pm = sizeof($result);
			//echo "Pending TS: ".$pending_ts;

			echo "<tr><th>".$pma_user['first_name']."</th><td> <span class='label bg-red'>".$pending_ts."</span></td> <td><span class='label bg-yellow'>".$pending_pm."</span></td> <td><span class='label bg-green'>".$month_ts."</span></td><td> <span class='label bg-blue'>".$month_pm."</span></td></tr>";								
		*/
		$complaints_assigned	=	0;
		$complaints_solved	=	0;
		$complaints_pending	=	0;
		$pmc_assigned			=	0;
		$pmc_completed		=	0;
		$pmc_pending			=	0;

		$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status='Closed'");
		$rt10	=	$ty10->result_array();
		$complaints_solved	=	sizeof($rt10);

		$ty11	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status!='Closed'");
		$rt11	=	$ty11->result_array();
		$complaints_pending	=	sizeof($rt11);

		$ty12	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND status='Completed'");
		$rt12	=	$ty12->result_array();
		$pmc_completed	=	sizeof($rt12);

		$ty13	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND status!='Completed'");
		$rt13	=	$ty13->result_array();
		$pmc_pending	=	sizeof($rt13);
		
		/*echo '<tr class="odd gradeX">
                <td class="bg-blue-steel bg-grey-border"> '. $pma_user['first_name'] .'</td><td class="bg-grey-steel text-center bg-grey-border">'.dashForZero($complaints_solved+$complaints_pending).'</td>
				<td class="bg-grey-cararra text-center bg-grey-border">'.dashForZero($complaints_solved).'</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.dashForZero($complaints_pending).'</td><td class="bg-grey-steel text-center bg-grey-border">' .dashForZero($pmc_completed+$pmc_pending).'</td>	 
				<td class="bg-grey-cararra text-center bg-grey-border">'.dashForZero($pmc_completed).'</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.dashForZero($pmc_pending).'</td>';
		*/echo '<tr class="odd gradeX">';
         echo  '<td class="bg-blue-steel"> '. $pma_user["first_name"].'</td>';
		 echo  '<td class="bg-grey-steel text-center bg-grey-border">'.($complaints_solved+$complaints_pending);
		 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border">'.$complaints_solved;
		 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.$complaints_pending.'</td>';
		 echo  '<td class="bg-grey-steel text-center bg-grey-border">' .($pmc_completed+$pmc_pending).'</td>';
		 echo  '<td class="bg-grey-cararra text-center bg-grey-border">'.$pmc_completed;
		 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.$pmc_pending.'</td>';
		echo '</tr>';
		}
		//mryasirtable
		echo '</tbody>';
		echo '</table>';
	   
	   echo '</div>';
	}
	public function select_engineer_kit_ajax()
	{
		$client_id=$this->input->post('client_name');
		//
		$dbres = $this->db->query("SELECT * FROM tbl_clients where pk_client_id = '".$client_id."'");
        $dbresResult=$dbres->result_array();
		//
		
		
		$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$dbresResult[0]['fk_office_id']."' AND userrole IN ('FSE','Salesman','Supervisor')  AND delete_status='0' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
		$yu=$get_complaint_list->result_array();
		echo '<select name="assign_to" class="form-control nnn" required>';
		echo '<option value="">---Select---</option>';
		foreach($yu as $drt)
		{
			echo '<option value="';
			echo $drt["id"];
			echo '">';
			echo $drt["first_name"];
			echo '</option>';
		}
        echo '</select>';
		echo '<div class="col-md-12"><br />';
		
		//mryasirtable				  
		echo '<table class="table table-condensed table-striped table-bordered table-hover flip-content">';
		echo '<thead>';
		//echo '<tr><th>Name</th><th>Pending TS</th><th>Pending PM</th><th>TS (30 Days)</th><th>PM (30 Days)</th></tr>';
		echo '<tr>
					  <th class="bg-blue-steel text-center bg-grey-border"> FSE </th>
                      <th class="bg-grey-steel text-center bg-grey-border"> Complaints<br />Assigned </th>
					  <th class="bg-grey-cararra text-center bg-grey-border"> Complaints<br />Solved </th>
					  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">Complaints<br />Pending </span></th>
                      <th class="bg-grey-steel text-center bg-grey-border"> PMC<br />Assigned </th>
                      <th class="bg-grey-cararra text-center bg-grey-border"> PMC<br />Completed </th>
					  <th class="bg-grey-cararra text-center bg-grey-border"> <span class="font-red">  PMC<br />Pending </span> </th>
                    </tr>';
		echo '</thead>';
		echo '<tbody>';	
		foreach($yu as $pma_user)
		{
		/*
			$userid			 =	$pma_user['id'];
			//$complaint_id	 =	$this->input->post('complaint_id');


			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND status!='Closed'";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$pending_ts = sizeof($result); 

			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND status!='Completed'";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$pending_pm = sizeof($result);

			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$month_ts = sizeof($result);

			//WHERE   create_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
			//$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND MONTH(`date`) = MONTH(CURRENT_DATE) AND YEAR(`date`) = YEAR(CURRENT_DATE)";
			$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
			$gh=$this->db->query($qu);
			$result = $gh->result_array();
			$month_pm = sizeof($result);
			//echo "Pending TS: ".$pending_ts;

			echo "<tr><th>".$pma_user['first_name']."</th><td> <span class='label bg-red'>".$pending_ts."</span></td> <td><span class='label bg-yellow'>".$pending_pm."</span></td> <td><span class='label bg-green'>".$month_ts."</span></td><td> <span class='label bg-blue'>".$month_pm."</span></td></tr>";								
		*/
		$complaints_assigned	=	0;
		$complaints_solved	=	0;
		$complaints_pending	=	0;
		$pmc_assigned			=	0;
		$pmc_completed		=	0;
		$pmc_pending			=	0;

		$ty10	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status='Closed'");
		$rt10	=	$ty10->result_array();
		$complaints_solved	=	sizeof($rt10);

		$ty11	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='complaint' AND status!='Closed'");
		$rt11	=	$ty11->result_array();
		$complaints_pending	=	sizeof($rt11);

		$ty12	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND status='Completed'");
		$rt12	=	$ty12->result_array();
		$pmc_completed	=	sizeof($rt12);

		$ty13	=	$this->db->query("select * from tbl_complaints where assign_to='".$pma_user['id']."' AND complaint_nature='PM' AND status!='Completed'");
		$rt13	=	$ty13->result_array();
		$pmc_pending	=	sizeof($rt13);
		
		/*echo '<tr class="odd gradeX">
                <td class="bg-blue-steel bg-grey-border"> '. $pma_user['first_name'] .'</td><td class="bg-grey-steel text-center bg-grey-border">'.dashForZero($complaints_solved+$complaints_pending).'</td>
				<td class="bg-grey-cararra text-center bg-grey-border">'.dashForZero($complaints_solved).'</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.dashForZero($complaints_pending).'</td><td class="bg-grey-steel text-center bg-grey-border">' .dashForZero($pmc_completed+$pmc_pending).'</td>	 
				<td class="bg-grey-cararra text-center bg-grey-border">'.dashForZero($pmc_completed).'</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.dashForZero($pmc_pending).'</td>';
		*/echo '<tr class="odd gradeX">';
         echo  '<td class="bg-blue-steel"> '. $pma_user["first_name"].'</td>';
		 echo  '<td class="bg-grey-steel text-center bg-grey-border">'.($complaints_solved+$complaints_pending);
		 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border">'.$complaints_solved;
		 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.$complaints_pending.'</td>';
		 echo  '<td class="bg-grey-steel text-center bg-grey-border">' .($pmc_completed+$pmc_pending).'</td>';
		 echo  '<td class="bg-grey-cararra text-center bg-grey-border">'.$pmc_completed;
		 echo  '</td><td class="bg-grey-cararra text-center bg-grey-border font-red">'.$pmc_pending.'</td>';
		echo '</tr>';
		}
		//mryasirtable
		echo '</tbody>';
		echo '</table>';
	   
	   echo '</div>';
	}
	
	function dashForZero($x) {
			if ($x==0) echo '-';
			else echo $x;
		}
	
	public function client_contact_no_ajax()
	{
		$city_id			=$this->input->post('city_id');
		$pk_client_id		=$this->input->post('pk_client_id');
		$this->load->model("complaint_model");
        $get_contact_no = $this->complaint_model->get_contact_no($pk_client_id);
		if (sizeof($get_contact_no) == "0") 
		{                   
		} 
		else 
		{
			echo $get_contact_no[0]['contact_no'];
		}
	}
	public function client_hidden_id_ajax()
	{
		$city_id			=$this->input->post('city_id');
		$client_name		=$this->input->post('client_name');
		$this->load->model("complaint_model");
        $get_contact_no = $this->complaint_model->get_contact_no($city_id,$client_name);
		$clinet_id = $get_contact_no[0]['pk_client_id'];
		echo $clinet_id;
	}
	public function client_instruments_ajax()
	{
		$city_id			=$this->input->post('city_id');
		$pk_client_id		=$this->input->post('pk_client_id');
		/*$this->load->model("complaint_model");
        $get_contact_no = $this->complaint_model->get_contact_no($city_id,$pk_client_id);
		$clinet_id = $get_contact_no[0]['pk_client_id'];*/
		//
		$nn=$this->db->query("select * from tbl_instruments where fk_client_id = '".$pk_client_id."'");
		$nnm_1=$nn->result_array();
		echo '<select name="instrument_name" class="form-control" onchange="add_serial_no(this.value)" >';
		echo '<option value="">---Select---</option>';
		//print_r($neary_ids);
		$product_array=array();
		foreach($nnm_1 as $productids)
		{
			if(!in_array($productids['fk_product_id'], $product_array))
			{
				array_push($product_array, $productids['fk_product_id']);
			}
		}
		foreach($product_array as $drt)
		{
			echo '<option value="';
			echo $drt;
			echo '">';
			$nn=$this->db->query("select * from tbl_products where pk_product_id = '".$drt."' ");
			$nnm=$nn->result_array();
			echo $nnm[0]["product_name"];
			echo '</option>';
		}
        echo '</select>';
	}
	public function client_instruments_serial_no_ajax()
	{
		$product_id			=	$this->input->post('product_id');
		$client_id				=	$this->input->post('client_id');
		$rrr="select * from tbl_instruments where fk_product_id = '".$product_id."' AND fk_client_id= '".$client_id."'";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		//
		echo '<select name="instrument" class="form-control" onchange="slect_office_ajax_and_related_engineers(this.value)" id="instrument_serial" required="required" >';
		echo '<option value="">---Select---</option>';
		foreach($nnm as $drt)
		{
			echo '<option value="';
			echo $drt["pk_instrument_id"];
			echo '">';
			echo $drt["serial_no"];
			echo '</option>';
		}
        echo '</select>';
	}
	public function slect_office_ajax_and_related_engineers()
	{
		$instrument_id			=	$this->input->post('instrument_id');
		$rrr				=	"select * from tbl_instruments where pk_instrument_id = '".$instrument_id."' ";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		$rrr2				=	"select * from tbl_offices where pk_office_id = '".$nnm[0]['fk_office_id']."' ";
		$nn2=$this->db->query($rrr2);
		$nnm2=$nn2->result_array();
		//
		echo $nnm2[0]['office_name'];
	}
	public function slect_office_ajax_id()
	{
		$instrument_id			=	$this->input->post('instrument_id');
		$rrr				=	"select * from tbl_instruments where pk_instrument_id = '".$instrument_id."' ";
		//echo $rrr;exit;
		$nn=$this->db->query($rrr);
		$nnm=$nn->result_array();
		$rrr2				=	"select * from tbl_offices where pk_office_id = '".$nnm[0]['fk_office_id']."' ";
		$nn2=$this->db->query($rrr2);
		$nnm2=$nn2->result_array();
		//
		echo $nnm2[0]['pk_office_id'];
	}
	public function submit_sprf()
	{
		foreach($_POST['part'] as $name => $part)
		{
			$qu="insert into tbl_sprf set fk_complaint_id = 	'".$_POST['complaint_id']."',
										  fk_part_id	  = 	'".$_POST['part'][$name]."',
										  quantity	  	  = 	'".$_POST['quantity'][$name]."',
										  total		 	  = 	'".$_POST['Total'][$name]."',
										  purpose	  	  = 	'".urlencode($_POST['purpose'][$name])."',
										  billing	  	  = 	'".$_POST['problem_type'][$name]."',
										  creation_time	  = 	'".date('Y-m-d H:i:s')."'
										  ";
			$gh=$this->db->query($qu);
			//$qu="update tbl_complaints set status = 	'Pending SPRF' where pk_complaint_id='".$_POST['complaint_id']."'";
			//$gh=$this->db->query($qu);
		}
		redirect(site_url() . 'products/sprf/'.$_POST['complaint_id'].'?msg=SPRF Added Successfully');
	}
	public function submit_sprf_approve()
	{
		$status = '1'; // For DC of SPRF
		$date	=	date('Y-m-d H:i:s');// Will be used in different queries
		
		
		///////////////////////// *************************** GET highest DC Number
		$dc_number	=	0; 
		$maxqu = $this->db->query("SELECT MAX(dc_number) as mazz FROM tbl_sprf ");
		$maxval=$maxqu->result_array();
		$cur_no=$maxval[0]['mazz'];//echo $cur_no.'sana';exit;
		$dc_number=$cur_no+1;
		
		//////////////////////// ****************************** DC In number
		$dc_in_number = '';
		$current_dc_number = 0;
		$query_chek = $this->db->query("select MAX(dc_number) AS dc_number from tbl_stock where dc_type='in' AND in_status= 'approved'");
		  $result 	 =     $query_chek->result_array();
		  $dc_number_prefix = date('Ym');
		  if (strlen($result[0]['dc_number'])<6 )
			$current_dc_number = 1;//$result[0]['dc_number'];
		  else
			  $current_dc_number = substr($result[0]['dc_number'],6);
		  $new_dc_number = $current_dc_number+1;
		  $dc_in_number = $dc_number_prefix.$new_dc_number;
		  
		  $stock_in_customer = '';
		  $stock_in_serial = '';
		  $stock_in_office = '';
		  $stock_in_city = '';
		
		///////////////////////////***************** Begin Getting Values for tbl_stock if part source is stock
		$qc = $this->db->query("SELECT tbl_cities.city_name, tbl_complaints.ts_number,tbl_complaints.fk_office_id, tbl_instruments.serial_no, tbl_clients.client_name FROM `tbl_complaints`
			JOIN tbl_cities ON tbl_complaints.fk_city_id =tbl_cities.pk_city_id
			JOIN tbl_instruments ON tbl_complaints.fk_instrument_id =tbl_instruments.pk_instrument_id
			JOIN tbl_clients ON tbl_complaints.fk_customer_id =tbl_clients.pk_client_id
			WHERE pk_complaint_id='".$_POST['complaint_id']."'");
		$cr = $qc->result_array();
		$office_id = $cr[0]['fk_office_id'];
		$office_id_revert = $cr[0]['fk_office_id'];
		$city_name = $cr[0]['city_name'];
		$customer_name = $cr[0]['client_name'];
		$equipment_serial = $cr[0]['serial_no'];
		$ts_number = $cr[0]['ts_number'];
		$complaint_id = $_POST['complaint_id'];
		$office_sub_stock = '1';
		$complaint_idd = 0;
		$disp_no = '';
		///////////////////////////***************** End Getting Values for tbl_stock if part source is stock
		//echo $qu;exit;
		////////////////////////////************** For each loop for each parts demand
		foreach($_POST['this_sprf_id'] as $name => $part)
		{
			$office_sub_stock = $_POST['office_id'][$name];
		//create complaint automaticaly if part source is client
	   $userq = $this->db->query("SELECT * from user where id='".$_POST['engineer_id']."'");
	   $userdata=$userq->result_array();
			 if($_POST['part_source'][$name]=='client')
			  {	
				/////////********* FOR TS NUMBER *******/////////////////
				 $maxqu = $this->db->query("SELECT MAX(ts_number) as mazz FROM tbl_complaints ");
				 $maxval=$maxqu->result_array();
				 $cur_no=substr($maxval[0]['mazz'],6,10);//echo $cur_no.'sana';exit;
				 $exceded_no=$cur_no+1;
				 $cur_date=date("ymd");
				 $disp_no=$cur_date.$exceded_no;
				 /////////********* FOR TS NUMBER END *******/////////////////
				 ///////////// part source client id and equipment
				 $client_plus_instrument=explode('#',$_POST['source_id'][$name]);
				 
				 $maxqu = $this->db->query("SELECT client_name,fk_city_id FROM tbl_clients WHERE pk_client_id='".$client_plus_instrument[0]."' ");
				 $maxval=$maxqu->result_array();
				 if (sizeof($maxval)==0) {
					 $maxqu = $this->db->query("SELECT office_name,fk_city_id FROM tbl_offices WHERE client_option='".$client_plus_instrument[0]."' ");
					 $maxval=$maxqu->result_array();
					 $stock_in_customer = $maxval[0]['office_name'];
				 }
				 else $stock_in_customer = $maxval[0]['client_name']; // customer
				 $maxqu = $this->db->query("SELECT city_name FROM tbl_cities WHERE pk_city_id='".$maxval[0]['fk_city_id']."' ");
				 $maxval=$maxqu->result_array();
				 $stock_in_city = $maxval[0]['city_name']; //city
				 $maxqu = $this->db->query("SELECT serial_no, fk_office_id FROM tbl_instruments WHERE pk_instrument_id='".$client_plus_instrument[1]."' ");
				 $maxval=$maxqu->result_array();
				 $stock_in_serial = $maxval[0]['serial_no']; // serial
				 $stock_in_office = $maxval[0]['fk_office_id']; // office
				 
				 $maxqu = $this->db->query("SELECT * FROM tbl_parts WHERE pk_part_id='".$_POST['part_hidden_id'][$name]."' ");
				 $maxval=$maxqu->result_array();
				 $part_description = urldecode($maxval[0]['description']); // description
				 $part_number = $maxval[0]['part_number']; // number
				 //new code by zaaid for correct city id in insert query. previously it was $userdata[0]['fk_city_id'] that is the city of signed in user. It shoud be city of client
				 $maxqu = $this->db->query("SELECT fk_city_id FROM tbl_clients WHERE pk_client_id='".$client_plus_instrument[0]."' ");
				 $maxval=$maxqu->result_array();
				 
				 // Declaring two variables so can be used for insertion of customer in complaint
				 $complaint_customer = '';
				 $office_plus_id = '';
				 if (sizeof($maxval)==0) { // if client id like -> officeoption_1 etc
					 $maxqu = $this->db->query("SELECT fk_city_id FROM tbl_offices WHERE client_option='".$client_plus_instrument[0]."' ");
					 $maxval=$maxqu->result_array();
					// $stock_in_customer = $maxval[0]['office_name'];
					$office_plus_id = explode('_',$client_plus_instrument[0]);
					$complaint_customer = '-'.$office_plus_id[1];
				 }
				 else $complaint_customer = $client_plus_instrument[0];
				 /*$office_plus_id = explode('_',$client_plus_instrument[0]);
				$data = "insert into tbl_complaints SET
										`fk_city_id`			=	'".$maxval[0]['fk_city_id']."',
										`fk_customer_id`		=	'-".$office_plus_id[1]."',
										`FSE_SAP`				=	'-".$office_plus_id[1]."',
										`fk_instrument_id`		=	'".$client_plus_instrument[1]."',
										`problem_summary`		=	'Install back ($part_description) <br/> Part Number: $part_number',
										`problem_type`			=	'equipment',
										`created_by` 			= 	'".$this->session->userdata('userid')."',
										`fk_office_id`			=	'".$stock_in_office."',
										`ts_number`  			=	'".$disp_no."',
										`date`					=	'".date('Y-m-d H:i:s')."',
										`last_ok_time`			=	'".date('Y-m-d H:i:s')."',
										`status`				= 	'Pending Registration',
										`software_generated`	= 	'1',
										`complaint_nature`		=	'complaint'
										
					"; */
					$data = "insert into tbl_complaints SET
										`fk_city_id`			=	'".$maxval[0]['fk_city_id']."',
										`fk_customer_id`		=	'".$complaint_customer."',
										`FSE_SAP`				=	'".$complaint_customer."',
										`fk_instrument_id`		=	'".$client_plus_instrument[1]."',
										`problem_summary`		=	'Install back ($part_description) <br/> Part Number: $part_number',
										`problem_type`			=	'equipment',
										`created_by` 			= 	'".$this->session->userdata('userid')."',
										`fk_office_id`			=	'".$stock_in_office."',
										`ts_number`  			=	'".$disp_no."',
										`date`					=	'".date('Y-m-d H:i:s')."',
										`last_ok_time`			=	'".date('Y-m-d H:i:s')."',
										`status`				= 	'Pending Registration',
										`software_generated`	= 	'1',
										`complaint_nature`		=	'complaint'
										
					";
					//echo $data;exit;
					 $dbres = $this->db->query($data);
					 $complaint_idd = $this->db->insert_id();
					 
					 $qu="insert into tbl_sprf set fk_complaint_id = 	'".$complaint_idd."',
										  fk_part_id	  = 	'".$_POST['part_hidden_id'][$name]."',
										  quantity	  	  = 	'".$_POST['quantity'][$name]."',
										  total		 	  = 	'".$_POST['Total'][$name]."',
										  purpose	  	  = 	'Replacement',
										  billing	  	  = 	'FOC',
										  creation_time	  = 	'".$date."'
										  ";
			$gh=$this->db->query($qu);
			}
		//creat complaint automaticaly if client End //date('Y-m-d H:i:s') for creation time incase $date doesn't work
			
			
		//*****************************if client than insert in tbl_stock with positive quantity once then remove
			if($_POST['part_source'][$name]=='client')
			  {	  
					$stock_in_office = $office_sub_stock; // making it same as eventually it will be transferred to this office. If don't keep these same then office balance will appear ambiguous
				  //$stock_office_id = $_POST['stock_office_id'][$name];
				  $required_quantity = $_POST['quantity'][$name];
				  $last_q= "INSERT INTO tbl_stock SET dc_type			= 'in',
													  stock_type		= 'Part Swap',
													  fk_complaint_id	= '".$_POST['complaint_id']."',
													  source_complaint_id	= '".$complaint_idd."',
													  source_ts			= '".$disp_no."',
													  ts_number			= '".$ts_number."',
													  equipment_serial	= '".$stock_in_serial."',
													  customer_name 	= '".$stock_in_customer."',
													  city_name  		= '".$stock_in_city."',
													  date				= '".$date."',
													  dc_number			= '".$dc_in_number."',
													  stock 			= '".$required_quantity."', 
				  									  fk_office_id 		= '".$office_id."', 
													  in_status 		= 'approved', 
													  fk_part_id 		= '".$_POST['part_hidden_id'][$name]."',
													  fk_sprf_id 		= '".$_POST['this_sprf_id'][$name]."'";
				  $this->db->query($last_q);
			  }
			  
			//  if($_POST['part_source'][$name]=='stock') Commenting condition because whether stock or client, this entry will be made
			//  {	  
				  //$stock_office_id = $_POST['stock_office_id'][$name];
				  if($_POST['part_source'][$name]=='stock') $office_id = $office_sub_stock; // so that office goes as the office chosen from the drop down at sprf approve. 
				  $required_quantity = 0 - $_POST['quantity'][$name];
				  $last_q= "INSERT INTO tbl_stock SET dc_type			= 'out',
													  stock_type		= 'TS',
													  fk_complaint_id	= '".$_POST['complaint_id']."',
													  ts_number			= '".$ts_number."',
													  equipment_serial	= '".$equipment_serial."',
													  customer_name 	= '".$customer_name."',
													  city_name  		= '".$city_name."',
													  date				= '".$date."',
													  dc_number			= '".$dc_number."',
													  stock 			= '".$required_quantity."', 
				  									  fk_office_id 		= '".$office_id."', 
													  fk_part_id 		= '".$_POST['part_hidden_id'][$name]."',
													  fk_sprf_id 		= '".$_POST['this_sprf_id'][$name]."'";
				  $this->db->query($last_q);
			//  }
			///////////////////////// REVERT THE OFFICE ID VARIABLE AFTER ABOVE INSERTION ..Otherwise it will effect the loop as office id is being used in the loop
			$office_id = $office_id_revert;
			  
		// UPDATE SPRF Table for DC view
			$qu="UPDATE tbl_sprf SET  status 			= 	'".$status."',
									  part_source	  	= 	'".$_POST['part_source'][$name]."',
									  dc_number	  	    = 	'".$dc_number."', ";
									  
			if($_POST['part_source'][$name]=='client')
			{							  
				  $qu.="source_id	  	  	= 	'".$_POST['source_id'][$name]."', ";
			}
	
			$qu.= "approval_date	  	= 	'".$date."'
			WHERE  
			pk_sprf_id 		=	'".$part."'";
			//echo $qu;exit;
			$gh=$this->db->query($qu);
			
		}

		// Make complaint status SPRF approved
		$qu="update tbl_complaints set status = 'SPRF Approved', sprf_approve_date = '$date' where pk_complaint_id='".$_POST['complaint_id']."'";
		$gh=$this->db->query($qu);
		//redirect(site_url() . 'products/supervisor_sprf/'.$_POST['complaint_id'].'?msgapprove=success'); //sys/pending_sprf
		redirect( site_url() . 'sys/pending_sprf?msgapprove=success');
	}
	
	public function submit_sprf_pending()
	{
		$date	=	date('Y-m-d H:i:s');
		// make complaint sprf approved
		$qu="update tbl_complaints set status = 'Pending SPRF', sprf_date = '$date' where pk_complaint_id='".$_POST['complaint_id']."'";
		$gh=$this->db->query($qu);
		redirect(site_url() . 'products/sprf/'.$_POST['complaint_id'].'?msgsprf=success');
	}
	
	public function submit_sprf_complaint_pending()
	{
		//$date	=	date('Y-m-d H:i:s');
		// make complaint sprf approved
		$qu="update tbl_complaints set status = 'Pending' where pk_complaint_id='".$_POST['complaint_id']."'";
		$gh=$this->db->query($qu);
		redirect(site_url() . 'products/supervisor_sprf/'.$_POST['complaint_id'].'?msgcp=success');
	}
	
	public function operator_view_dc()
	{
		$this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_operator_view_dc_model();
		$this->load->view('sys/operator_view_dc', array("get_complaint_list" => $get_complaint_list));
	}
	public function update_vendor()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('sys/update_vendor');
	}
	
	public function update_print_count_ajax()
	{
		$complaint_id	=	$this->input->post('complaint_id');
		$print_count	 =	$this->input->post('print_count');
		$inc_print_count = $print_count+1;
		$qu="update tbl_direct_challans set print_count = $inc_print_count, status='Printed'	 where fk_ts_id='".$complaint_id."'";
		$gh=$this->db->query($qu);
		echo $inc_print_count ;
	}
	public function select_user_complaint_ajax()
	{
		$userid			 =	$this->input->post('userid');
		$complaint_id	 =	$this->input->post('complaint_id');


		$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND status!='Closed'";
		$gh=$this->db->query($qu);
		$result = $gh->result_array();
		$pending_ts = sizeof($result); 

		$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND status!='Completed'";
		$gh=$this->db->query($qu);
		$result = $gh->result_array();
		$pending_pm = sizeof($result);

		$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
		$gh=$this->db->query($qu);
		$result = $gh->result_array();
		$month_ts = sizeof($result);

		//WHERE   create_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
		//$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND MONTH(`date`) = MONTH(CURRENT_DATE) AND YEAR(`date`) = YEAR(CURRENT_DATE)";
		$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() + INTERVAL 1 DAY";
		$gh=$this->db->query($qu);
		$result = $gh->result_array();
		$month_pm = sizeof($result);
		//echo "Pending TS: ".$pending_ts;

		echo "<span class='label bg-red'>Pending TS: ".$pending_ts."</span>, <span class='label bg-yellow'>Pending PM: ".$pending_pm."</span>, <span class='label bg-green'>TS (30 Days): ".$month_ts."</span>, <span class='label bg-blue'>PM (30 Days): ".$month_pm;

		//echo 'My Status='.$result[0]['status'].'<br> compalint_id='.$this->input->post('complaint_id');
	}
	// this is for getting city id for new form to do both work at a time
	public function form_client_select_ajax_for_cityid()
	{
		if(substr($this->input->post('client_id'),0,1)=='o')
		{ 
			$office_id		=	substr($this->input->post('client_id'),13,1);
			$rowid			=	$this->input->post('rowid');
			
			 $qu2="SELECT * from tbl_cities where fk_office_id =  '".$office_id."'";
			$gh2=$this->db->query($qu2);
			$rt2=$gh2->result_array();
			echo $rt2[0]['pk_city_id'];
		}
		else
		{
			$client_id	=	$this->input->post('client_id');
			$rowid	=	$this->input->post('rowid');
			
			$qu="SELECT * from tbl_clients where pk_client_id =  '".$client_id."'";
			$gh=$this->db->query($qu);
			$rt=$gh->result_array();
			$qu2="SELECT * from tbl_cities where pk_city_id =  '".$rt[0]['fk_city_id']."'";
			$gh2=$this->db->query($qu2);
			$rt2=$gh2->result_array();
			echo $rt2[0]['pk_city_id'];
		}
	}
	// this is for new dvr form page
	public function form_client_select_ajax()
	{
		
		if(substr($this->input->post('client_id'),0,1)=='o')
		{ 
			$office_id		=	substr($this->input->post('client_id'),13,1);
			$rowid			=	$this->input->post('rowid');
			
			 $qu2="SELECT * from tbl_cities where fk_office_id =  '".$office_id."'";
			$gh2=$this->db->query($qu2);
			$rt2=$gh2->result_array();
			echo '<select class="form-control  " name="city['.$rowid.']" onchange="show_business(this.value,'.$rowid.')"  id="city'.$rowid.'"  >';
			foreach($rt2 as $value)
			{
				echo '<option value="';
				echo $value['pk_city_id'];
				echo '">';
				echo $value['city_name'];
				echo '</option>';
			}
			echo '</select>';
		}
		else
		{
			$client_id	=	$this->input->post('client_id');
			$rowid	=	$this->input->post('rowid');
			$qu="SELECT * from tbl_clients where pk_client_id =  '".$client_id."'";
			$gh=$this->db->query($qu);
			$rt=$gh->result_array();
			$qu2="SELECT * from tbl_cities where pk_city_id =  '".$rt[0]['fk_city_id']."'";
			$gh2=$this->db->query($qu2);
			$rt2=$gh2->result_array();
			echo '<select class="form-control  " name="city['.$rowid.']" onchange="show_business(this.value,'.$rowid.')"  id="city'.$rowid.'"  >';
			foreach($rt2 as $value)
			{
				echo '<option value="';
				echo $value['pk_city_id'];
				echo '">';
				echo $value['city_name'];
				echo '</option>';
			}
			echo '</select>';
		}
		//
		
	}
	
	// this is for old dvr page
	public function client_select_ajax()
	{
		
		if(substr($this->input->post('client_id'),0,1)=='o')
		{ 
			$office_id		=	substr($this->input->post('client_id'),13,1);
			$rowid			=	$this->input->post('rowid');
			
			 $qu2="SELECT * from tbl_cities where fk_office_id =  '".$office_id."'";
			$gh2=$this->db->query($qu2);
			$rt2=$gh2->result_array();
			echo '<select class="form-control  " name="city['.$rowid.']" onchange="show_business(this.value,'.$rowid.')"  id="city'.$rowid.'"  >';
			foreach($rt2 as $value)
			{
				echo '<option value="';
				echo $value['pk_city_id'];
				echo '">';
				echo $value['city_name'];
				echo '</option>';
			}
			echo '</select>';
		}
		else
		{
			$client_id	=	$this->input->post('client_id');
			$rowid	=	$this->input->post('rowid');
			$qu="SELECT * from tbl_clients where pk_client_id =  '".$client_id."'";
			$gh=$this->db->query($qu);
			$rt=$gh->result_array();
			$qu2="SELECT * from tbl_cities where pk_city_id =  '".$rt[0]['fk_city_id']."'";
			$gh2=$this->db->query($qu2);
			$rt2=$gh2->result_array();
			echo '<select class="form-control  " name="city['.$rowid.']" onchange="show_business(this.value,'.$rowid.')"  id="city'.$rowid.'"  >';
			foreach($rt2 as $value)
			{
				echo '<option value="';
				echo $value['pk_city_id'];
				echo '">';
				echo $value['city_name'];
				echo '</option>';
			}
			echo '</select>';
		}
		//
		
	}
	// this is for business date select city
	public function business_project_select_city()
	{
		
			$client_id	=	$this->input->post('client_id');
			$qu="SELECT * from tbl_clients where pk_client_id =  '".$client_id."'";
			$gh=$this->db->query($qu);
			$rt=$gh->result_array();
			$qu2="SELECT * from tbl_cities where pk_city_id =  '".$rt[0]['fk_city_id']."'";
			$gh2=$this->db->query($qu2);
			$rt2=$gh2->result_array();
			echo '<select class="form-control  " name="City"   id="City"  >';
			foreach($rt2 as $value)
			{
				echo '<option value="';
				echo $value['pk_city_id'];
				echo '">';
				echo $value['city_name'];
				echo '</option>';
			}
			echo '</select>';
		//
		
	}
	// this is for business data select Territory
	public function business_project_select_territory()
	{
		
			$client_id	=	$this->input->post('client_id');
			$qu="SELECT * from tbl_clients where pk_client_id =  '".$client_id."'";
			$gh=$this->db->query($qu);
			$rt=$gh->result_array();
			$qu2="SELECT * from tbl_offices where pk_office_id =  '".$rt[0]['fk_office_id']."'";
			$gh2=$this->db->query($qu2);
			$rt2=$gh2->result_array();
			echo '<select class="form-control" name="Territory"   id="Territory"  >';
			foreach($rt2 as $value)
			{
				echo '<option value="';
				echo $value['pk_office_id'];
				echo '">';
				echo $value['office_name'];
				echo '</option>';
			}
			echo '</select>';
	}
	// this is for business data select Area
	public function business_project_select_area()
	{
		
			$client_id	=	$this->input->post('client_id');
			$qu="SELECT * from tbl_clients where pk_client_id =  '".$client_id."'";
			$gh=$this->db->query($qu);
			$rt=$gh->result_array();
			$qu2="SELECT * from tbl_area where pk_area_id =  '".$rt[0]['fk_area_id']."'";
			$gh2=$this->db->query($qu2);
			$rt2=$gh2->result_array();
			echo '<select class="form-control" name="Area"   id="Area"  >';
			foreach($rt2 as $value)
			{
				echo '<option value="';
				echo $value['pk_area_id'];
				echo '">';
				echo $value['area'];
				echo '</option>';
			}
			echo '</select>';
	}
	public function business_project_select_users()
	{
		
			//$department	=	$this->input->post('department');
			$client	=	$this->input->post('client_id');
			//if($department=='Sales')
				$qu="SELECT * from user where delete_status='0' AND id IN (SELECT fk_user_id FROM tbl_customer_sap_bridge WHERE fk_client_id='$client') ";
			//else
			//	$qu="SELECT * from user where userrole =  'FSE'  AND delete_status='0' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
			
			$gh=$this->db->query($qu);
			$rt=$gh->result_array();
			echo '<select class="form-control" name="Sales_Person"   id="Sales_Person"  >';
			foreach($rt as $value)
			{
				echo '<option value="';
				echo $value['id'];
				echo '">';
				echo $value['first_name'];
				echo '</option>';
			}
			echo '</select>';
	}
	
	
	//for new form sap dvr page
	public function form_business_select_ajax()
	{
		$cutomer_id	=	$this->input->post('cutomer_id');	
		$city_id	=	$this->input->post('city_id');
		$rowid	=	$this->input->post('rowid');
		 //echo 'cutomer='.$cutomer_id.'city='.$city_id.'rowid='.$rowid;exit;
		// this if statment is used if admin is assigning dvr
		if(isset($_POST['sales_person']))
		{
			$qu6="select * from user where id='".$_POST['sales_person']."'";
		}
		else
		{
			$qu6="select * from user where id='".$this->session->userdata('userid')."'";
		}
		$gh6=$this->db->query($qu6);
		$rt6=$gh6->result_array();

		$qu="select * from business_data where Customer='".$cutomer_id."' AND City='".$city_id."' and status='0' 
		AND Department='".$rt6[0]['department']."' And `Sales Person`='".$rt6[0]['id']."'";
		//echo $qu;exit;
		$gh=$this->db->query($qu);
		$rt=$gh->result_array();
		//
		
		$ts_umber_quer="select * from tbl_complaints where fk_customer_id='".$cutomer_id."' AND assign_to='".$rt6[0]['id']."' 
		AND status NOT IN ('Closed', 'Completed','Pending Verification','Pending Registration','Pending Verification (BB)','Pending SPRF')";
		// New Query Above query is irrelevant.
		$ts_umber_quer="select * from tbl_complaints where fk_customer_id='".$cutomer_id."' 
		AND status NOT IN ('Closed', 'Completed','Pending Registration')";
		
		if (substr($cutomer_id,0,1)=='o')
			$ts_umber_quer="select * from tbl_complaints where fk_customer_id IN (SELECT fk_client_id from tbl_offices WHERE client_option='".$cutomer_id."' )
							AND status NOT IN ('Closed', 'Completed','Pending Registration')"; 
		//echo $ts_umber_quer;exit;
		$gh_tsnumber=$this->db->query($ts_umber_quer);
		$rt_ts_number=$gh_tsnumber->result_array();
		//
		echo '<select class="form-control" name="business['.$rowid.']" onchange="fill_business_dec_and_timeelapsed(this.value,'.$rowid.')" id="business'.$rowid.'" required>
                  <option value="">--Choose--</option>';
		foreach($rt as $value)
		{
			echo '<option value="';
			echo $value['pk_businessproject_id'];
			echo '">';
			$qu5="select * from tbl_business_types where pk_businesstype_id='".$value['Business Project']."'";
			$gh5=$this->db->query($qu5);
			$rt5=$gh5->result_array();
			
			echo $rt5[0]['businesstype_name'];
			echo '</option>';
		}
		//
		foreach($rt_ts_number as $value)
		{
			echo '<option value="';
			echo 'tsnumber_'.$value['pk_complaint_id'];
			echo '">';
			$cn = "TS";
			if ($value['complaint_nature']=='PM') $cn = "PM";
			$q = $this->db->query("SELECT first_name from user where id = '".$value['assign_to']."'");
			$u = $q->result_array();
			$q = $this->db->query("SELECT fk_product_id,serial_no from tbl_instruments where pk_instrument_id = '".$value['fk_instrument_id']."'");
			$i = $q->result_array();
			$q = $this->db->query("SELECT product_name from tbl_products where pk_product_id = '".$i[0]['fk_product_id']."'");
			$p = $q->result_array();
			echo $value['ts_number'].' - '.$cn.' - '.$p[0]['product_name'].' ('.$i[0]['serial_no'].') - '.$value['problem_summary'];//.$u[0]['first_name'];//.' - '//Removed first name and displayed problem_summary (Done by Zohaib)
			echo '</option>';
		}
		
		// Count Active Equipments at respective client
		$gh5=$this->db->query("select * from tbl_instruments where fk_client_id='".$cutomer_id."' AND status='1' AND fk_category_id!='1'");
		$rt5=$gh5->result_array();
		if (sizeof($rt5)==0 || substr($cutomer_id,0,1)=='o')
		    echo '<option value="others">Others</option>';
   		echo '</select>';
		if (sizeof($rt5)>0 && sizeof($rt_ts_number)==0 ) echo "No TS number available. Please generate a TS number first.";
	}
	// for old dvr page
	public function business_select_ajax()
	{
		$cutomer_id	=	$this->input->post('client_id');
		$rowid	=	$this->input->post('rowid');
		$user_id = $this->session->userdata('userid');
		if(isset($_POST['user_id'])) $user_id = $this->input->post('user_id');
		 //echo 'cutomer='.$cutomer_id.'city='.$city_id.'rowid='.$rowid;exit;

		$qu="select * from business_data where Customer='".$cutomer_id."'  And `Sales Person`='".$user_id."'  and status='0'";
		//echo $qu;exit;
		$gh=$this->db->query($qu);
		$rt=$gh->result_array();
		echo '<select class="form-control  " name="business['.$rowid.']" onchange="fill_business_dec_and_timeelapsed(this.value,'.$rowid.')" id="business" required>
                              <option value="">--Choose--</option>';
		foreach($rt as $value)
		{
			echo '<option value="';
			echo $value['pk_businessproject_id'];
			echo '">';
			$qu5="select * from tbl_business_types where pk_businesstype_id='".$value['Business Project']."'";
			$gh5=$this->db->query($qu5);
			$rt5=$gh5->result_array();
			
			echo $rt5[0]['businesstype_name'];
			echo '</option>';
		}
		    echo '<option value="others">Others</option>';
   		echo '</select>';
	}
	
	public function business_dec_ajax()
	{
		$business_id	=	$this->input->post('business_id');
		$customer_id	=	$this->input->post('customer_id');
		
		$rowid	 		=	$this->input->post('rowid');
		$qu="select * from business_data where `pk_businessproject_id`='".$business_id."' and Customer='".$customer_id."'  ";
		//echo $qu;exit;
		$gh=$this->db->query($qu);
		if($gh->num_rows()>0)
		{
		$rt=$gh->result_array();
		echo $rt[0]['Project Description'];
		}
	}
	public function business_dec_ajax_against_tsnumber()
	{
		$complaint_id	=	$this->input->post('complaint_id');
		
		$rowid	 		=	$this->input->post('rowid');
		$qu="select * from tbl_complaints where `pk_complaint_id`='".$complaint_id."'";
		//echo $qu;exit;
		$gh=$this->db->query($qu);
		if($gh->num_rows()>0)
		{
		$rt=$gh->result_array();
		echo $rt[0]['problem_summary'];
		}
	}
	public function business_time_elapsed_ajax()
	{
		$business_id	=	$this->input->post('business_id');
		$customer_id	=	$this->input->post('customer_id');
		$rowid	 		=	$this->input->post('rowid');
		$qu="select * from business_data where `pk_businessproject_id`='".$business_id."' and Customer='".$customer_id."'";
		//echo $qu;exit;
		$gh=$this->db->query($qu);
		$rt=$gh->result_array();
		
		$this->load->model("complaint_model");
		if (sizeof($rt)>0) {
			if ( $rt[0]['Date']!="") {
				$nicetimevr = $this->complaint_model->nicetime($rt[0]['Date']);
				echo $nicetimevr ;
			}
		}
	}
	public function business_time_elapsed_ajax_against_tsnumber()
	{
		$complaint_id	=	$this->input->post('complaint_id');
		$rowid	 		=	$this->input->post('rowid');
		$qu="select * from tbl_complaints where `pk_complaint_id`='".$complaint_id."'";
		//echo $qu;exit;
		$gh=$this->db->query($qu);
		$rt=$gh->result_array();
		
		$this->load->model("complaint_model");
        $nicetimevr = $this->complaint_model->nicetime($rt[0]['date']);
		
		echo $nicetimevr ;
	}
	
	public function business_tactics_ajax()
	{
		$business_id	=	$this->input->post('business_id');
		$customer_id	=	$this->input->post('customer_id');
		$rowid	 		=	$this->input->post('rowid');
		$qu="select * from tbl_project_strategy where `fk_project_id`='".$business_id."' order by pk_project_strategy_id DESC";
		//echo $qu;exit;
		$gh=$this->db->query($qu);
		$rt=$gh->result_array();
		
		$this->load->model("complaint_model");
		if (sizeof($rt)>0) {
			//echo urldecode($rt[0]['tactics']);
			echo '<div class="form-group"><label class="col-md-3 control-label">Tactics / Actions</label><div class="col-md-8"><input type="text"   name="tactics[0]" value="'.urldecode($rt[0]["tactics"]).'" class="form-control tactics0 readonly" required></div></div><div class="form-group"><label class="col-md-3 control-label">Target Date</label><div class="col-md-8"><input type="text"   name="target_date[0]" value="'.date('d-M-Y',strtotime($rt[0]["target_date"])).'"  class="form-control target_date0 readonly" id="target_date0" required>	</div></div>';
		}
	}
	
	public function business_target_date_ajax()
	{
		$business_id	=	$this->input->post('business_id');
		$customer_id	=	$this->input->post('customer_id');
		$rowid	 		=	$this->input->post('rowid');
		$qu="select * from tbl_project_strategy where `fk_project_id`='".$business_id."' order by pk_project_strategy_id DESC";
		//echo $qu;exit;
		$gh=$this->db->query($qu);
		$rt=$gh->result_array();
		
		$this->load->model("complaint_model");
		if (sizeof($rt)>0) {
			//echo date('d-M-Y',strtotime($rt[0]["target_date"]));
			echo '<div class="bg-warning" style="padding-top: 10px;padding-bottom: 2px;margin-bottom: 2px;">
				<div class="form-group">
					<label class="col-md-3 control-label">Tactics / Actions</label>
					<div class="col-md-8"> <textarea readonly rows="5" class="input-xlarge">'.trim(urldecode($rt[0]["tactics"])).'</textarea></div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Target Date</label>
					<div class="col-md-8"><label class="control-label">'.date('d-M-Y',strtotime($rt[0]["target_date"])).'</label></div>
				</div>
				</div>';
		}
		else {
			echo '	<div class="bg-danger" style="padding-top: 10px;padding-bottom: 2px;margin-bottom: 2px;">
						<div class="form-group ">
                            <label class="col-md-3 control-label"> Strategy</label>
                            <div class="col-md-8">
                                <textarea name="strategy" class="input-xlarge" id="strategy" rows="5" required></textarea>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-md-3 control-label"> Tactics / Actions</label>
                            <div class="col-md-8">
                                <textarea name="tactics" class="input-xlarge" id="tactics" rows="5" required></textarea>
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label class="col-md-3 control-label">Target Date</label>
                            <div class="col-md-4">
                                    <input type="text" class="datepicker2 form-control" name="target_date" required/>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label">Investment</label>
                            <div class="col-md-4">
                                    <input type="number" class="form-control" name="investment" required/>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label">Sales / Month</label>
                            <div class="col-md-4">
                                    <input type="number" class="form-control" name="sales_per_month" required/>
                            </div>
                        </div>
						<input type="hidden" name="strategy_status" value="0">
						<input type="hidden" name="fk_project_id" value="'.$business_id.'">
					</div>';
		}
	}
	
}

/* End of file complaint.php */
/* Location: ./application/controllers/inbox.php */