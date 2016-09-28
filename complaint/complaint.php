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
		redirect('complaint/operator_view_complaints');
	}
	
	public function fine()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/fine');
	}
	public function leaves_statistics()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/leaves_statistics');
	}
	
	public function complaint_varification()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->view('complaint/complaint_varification');
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
		$this->load->view('complaint/ts_report_supervisor');
	}
	public function ts_report_director()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/ts_report_director');
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
		
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor' || $this->session->userdata('userrole')=='Admin')
		{	
			$this->load->view('complaint/pm_form');
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
			$this->load->view('complaint/s_pm_form');
		}
		else
		{
			show_404();
		}*/
		$this->load->view('complaint/s_pm_form');
    }
	public function projects_statistics()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/projects_statistics');
	}
	public function territory_statistics()
	{
		if($this->session->userdata('userrole')=='')
		{
			show_404();
		}
		$this->load->view('complaint/territory_statistics');
	}
	
	public function technical_service_pvr()
	{
		$query="select `assign_to` from tbl_complaints where `pk_complaint_id` ='".$this->uri->segment(3)."'
		AND `complaint_nature`='complaint'";
		$query_db=$this->db->query($query);
		$user_complaints=$query_db->result_array();			
		if ($user_complaints[0]['assign_to']!=$this->session->userdata('userid'))
		{
			show_404();
		}/*
		elseif($this->session->userdata('userrole')!='FSE' &&  $this->session->userdata('userrole')!='Supervisor' && $this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}*/
		$this->load->view('complaint/technical_service_pvr');
	}
	
	public function supervisor_assign_pm()
	{
		if($this->session->userdata('userrole')!='Supervisor' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/supervisor_assign_pm');
	}
	
	public function pm_statistics()
	{
		if($this->session->userdata('userrole')!='Supervisor' && $this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery')
		{
			show_404();
		}
		$this->load->view('complaint/pm_statistics');
	}
	
	public function employee_asc()
	{
		
		
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->model("complaint_model");
			$dbresResult=array();
			if(isset($_POST['engineer']))
			{
				$dbres = $this->db->query("SELECT * FROM tbl_dvr where fk_engineer_id = '".$_POST['engineer']."' order by date DESC");
				$dbresResult=$dbres->result_array();
				
				$dbres2 = $this->db->query("SELECT * FROM user where id = '".$_POST['engineer']."' ");
				$dbresResult2=$dbres2->result_array();
				
				$this->load->view('complaint/employee_asc', array("get_eng_dvr" => $dbresResult,
																"eng_id" 	 => $_POST['engineer'],
																"userrole"   => $dbresResult2['0']['userrole']));
			}
			else
			{
				$this->load->view('complaint/employee_asc', array("get_eng_dvr" => $dbresResult));
			}
		}
		else
		{
			show_404();
		}
		
	}
	public function products()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/products');
	}
	public function categories()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/categories');
	}
	public function add_product()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/add_product');
	}
	public function add_category()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/add_category');
	}
	public function delete_asc($id)
	{
		$dbres = $this->db->query("DELETE FROM tbl_customer_sap_bridge WHERE pk_customer_sap_bridge_id = $id");
		redirect(site_url() . 'complaint/acs?msg_del=success');
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
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/news');
    }
	public function add_news() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/add_news');
    }
	
	public function cities() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/cities');
    }
	
	public function add_city() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/add_city');
    }
	
	public function update_city() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/update_city');
    }
	
	public function update_city_insert() {
		$query="update  `tbl_cities` SET 	
			  `city_name`						='".$_POST['city_name']."' ,
			  `fk_office_id`							='".$_POST['office_name']."'
			   where pk_city_id ='".$_POST['pk_city_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/update_city/'.$_POST['pk_city_id'].'?msg=success');
    }
	
	
	public function add_news_insert() {
		$query="insert  `tbl_news` SET 	
			  `news_title`				='".urlencode($_POST['news_title'])."',
			  `fk_office_id`				='".$_POST['office']."',
			  `news_description`		='".urlencode($_POST['news_description'])."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/news?msg=success');
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
				
			
			$subject ="Fine Added to MYPMAONLINE.COM";
			
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers.="From: $email \r\n";
			//$headers .= "CC: $cc\r\n";
			//$headers .= "BCC: hidden@special.com\r\n";
			$headers.="Return-Path: $email \r\n";
			
			$body = '<table width="650" border="0">
					   <tr bgcolor="#BDD5DF">
						<td colspan="2">New Fine Added. Details are below:</td>
					  </tr>				  
					  <tr bgcolor="#D5D5D5">
						<td width="110">Employee Name:</td>
						<td width="265">'.$name.'</td>
					  </tr>
					   <tr bgcolor="#D5D5D5">
						<td>Fine:</td>
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
			  
              redirect(site_url() . 'complaint/all_fines?msg=success');
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
				$start_date = strtotime($this->profile_model->change_date_to_mysql_style($lr[0]['start_date']));
				$end_date = strtotime($this->profile_model->change_date_to_mysql_style($lr[0]['end_date']));
				$datediff = $end_date - $start_date;
				$mydiffrence = floor($datediff / (60 * 60 * 24));
	
				$sub_leaves = $mydiffrence + 1;
				$leaves_total = $total_leaves - $sub_leaves;
				//echo 'sanullah';exit;
			}
            $dbres_upt = $this->db->query("update user set total_leaves = $leaves_total where id ='" . $lr[0]['fk_employee_id'] . "'");
            //$res_upt = $dbres_upt->result_array();
        }

        //////////////////////////////////////////////////////////////

        $query="delete from  tbl_leaves  where `pk_leave_id` =$id";
        $dbres = $this->db->query($query);

        redirect(site_url() . 'complaint/all_leaves?msg_delete=success');
    }

    public function insert_leave() {
        $this->load->model("profile_model");
        $lq 			= $this->db->query("select * from tbl_leaves where fk_employee_id ='".$_POST['employee']."' AND start_date='".$this->profile_model->change_date_to_mysql_style($_POST['start_date'])."'");
        $lr 				= $lq->result_array();
		$fineid		=	0;
        if(sizeof($lr)>=1) {
            redirect(site_url() . 'complaint/leave_form?msg=already_exists');
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
				$leaves_total = $total_leaves + $mydiffrence + 1;
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

            redirect(site_url() . 'complaint/leave_form?msg=success');
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
            redirect(site_url() . 'complaint/update_leave_form/'.$leave_id.'?msg=already_exists');
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
				$start_date = strtotime($this->profile_model->change_date_to_mysql_style($lr[0]['start_date']));
				$end_date = strtotime($this->profile_model->change_date_to_mysql_style($lr[0]['end_date']));
				$datediff = $end_date - $start_date;
				$mydiffrence = floor($datediff / (60 * 60 * 24));
	
				$sub_leaves = $mydiffrence + 1;
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
				$leaves_total = $total_leaves + $mydiffrence + 1;
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

            redirect(site_url() . 'complaint/all_leaves?msg_update=success');
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
              redirect(site_url() . 'complaint/all_fines?msg_update=success');
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
	public function select_remaining_leaves_ajax() {
				$query1="select * from user WHERE `id`=".$this->input->post('employee_id');
				$dbres1 = $this->db->query($query1);
				$res = $dbres1->result_array();
				$leaves = $res[0]['total_leaves'];
				$remaining_leaves = 21 - $leaves;
				echo "Tatal Leaves = ".round($leaves,1);
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
		redirect(site_url() . 'complaint/technical_service_pvr/'.$this->input->post('complaint_id'));
    }
	
	public function all_fines() {
		
		$this->load->view("complaint/all_fines");
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
		$this->load->view("complaint/assign_pm");
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
		$this->load->view("complaint/update_fine");
    }
	
	public function update_news() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/update_news');
    }
	public function sap_statistics() {
        if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
        $this->load->view('complaint/sap_statistics');
    }
	
	public function update_product() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/update_product');
    }
	public function update_category() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/update_categories');
    }
	
	public function update_category_insert() {
		$query="update  `tbl_category` SET 	
			  `category_name`						='".$_POST['category_name']."'
			   where pk_category_id ='".$_POST['pk_category_id']."'";
			  //`fk_type_id`							='".$_POST['type_name']."'
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/update_category/'.$_POST['pk_category_id'].'?msg=success');
    }
	public function update_news_insert() {
		$query="update  `tbl_news` SET 	
			  `news_title`				='".urlencode($_POST['news_title'])."',
			  `news_description`		='".urlencode($_POST['news_description'])."',
			  `fk_office_id`		='".$_POST['office']."'
			  
			  where `pk_news_id` ='".$_POST['pk_news_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/update_news/'.$_POST['pk_news_id'].'?msg=success');
    }
	public function delete_news($id) {
		$query="delete from  tbl_news  where `pk_news_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/news?msg_delete=success');
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
		redirect(site_url() . 'complaint/vendors?msg_delete=success');
    }
	
	public function delete_category($id) {
		$query="update  tbl_category  
				SET 	
			   `status`				='1'
				where `pk_category_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/categories?msg_delete=success');
    }
	
	public function delete_city($id) {
		$query="update  tbl_cities  
				SET 	
			   `status`				='1'
				where `pk_city_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/cities?msg_delete=success');
    }
	
	public function delete_product($id) {
		$query="update  tbl_products 
				SET 	
			   `status`				='1'
				where `pk_product_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/products?msg_delete=success');
    }
	
	public function delete_complaint($id) {
		$query="delete from  tbl_complaints  where `pk_complaint_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/director_view_complaints?msg_delete=success');
    }
	
	public function delete_pm($id) {
		$query="delete from  tbl_complaints  where `pk_complaint_id` =$id";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/director_view_pm?msg_delete=success');
    }
	
	public function business_data() {
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->model("complaint_model");
			$business_data = $this->complaint_model->get_business_data_model();
			$this->load->view('/complaint/business_data', array("business_data" => $business_data));
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
			$this->load->view('/complaint/deleted_business_data', array("business_data" => $business_data));
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
        $this->load->view('complaint/vendor_registration');
    }
	
	public function equipment_registration() {
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/equipment_registration');
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
		redirect(site_url() . 'complaint/acs?msg=success');
    }
	
	// Delete Compose Message.
	public function add_complaint()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/add_complaint');
	}
	public function add_complaint_half()
	{
        $this->load->view('complaint/add_complaint_half');
	}
	public function add_customer()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/add_customer');
	}
	
	public function director_view_complaints()
	{
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_complaint_model();
		$this->load->view('complaint/director_view_complaints', array("get_complaint_list" => $get_complaint_list));
	}
	public function director_view_pm()
	{
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/director_view_pm');
	}

	public function update_pm()
	{
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/update_pm');
	}

	public function update_pm_insert() {
		$new_date	=	date("Y-m-d H:i",strtotime($_POST['date']));
		$query="update  `tbl_complaints` SET 	
			  `date`						='".$new_date."' ,
			  `assign_to`							='".$_POST['assign_to']."'
			   where pk_complaint_id ='".$_POST['pk_complaint_id']."'";
			  $dbres = $this->db->query($query);
              redirect(site_url() . 'complaint/update_pm/'.$_POST['pk_complaint_id'].'?msg=success');
    }
	
	public function operator_view_complaints()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_complaint_model();
		$this->load->view('complaint/operator_view_complaints', array("get_complaint_list" => $get_complaint_list));
	}
	public function view_half_complaints()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/view_half_complaints');
	}
	public function add_complaint_registration()
	{
		if($this->session->userdata('userrole')!='secratery' && $this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/add_complaint_registration');
	}
	
	public function supervisor_dvr()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_sup_dvr = $this->complaint_model->get_sup_dvr_model();
		$this->load->view('complaint/supervisor_dvr', array("get_sup_dvr" => $get_sup_dvr));
	}
	public function supervisor_vs()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->view('complaint/supervisor_vs');
	}
	public function engineer_dvr()
	{
		$this->load->model("complaint_model");
        $get_eng_dvr = $this->complaint_model->get_eng_dvr_model();
		$this->load->view('complaint/engineer_dvr', array("get_eng_dvr" => $get_eng_dvr));
	}
	
	public function admin_dvr_form()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('complaint/admin_dvr_form');
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
		$this->load->view('complaint/create_pef');
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
				 redirect(site_url() . 'complaint/create_pef?msg=failure');
			 }
			 elseif($maxdate >= $expiry_date)
			 {
				 $maxdate2 = date('d-M-Y',strtotime($prvoios_result[0]['maxdate']));
				 redirect(site_url() . "complaint/create_pef?msg=failure2&maxdat=$maxdate2");
			 }
			 elseif($today_date == $expiry_date)
			 {
				 redirect(site_url() . "complaint/create_pef?msg=failure3");
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
              redirect(site_url() . 'complaint/create_pef?msg=success');
			 }
	}
	public function employee_view_pef()
	{
		$this->load->view('complaint/employee_view_pef');
	}
	public function pef_employee()
	{
		$this->load->view('complaint/pef_employee');
	}
	public function director_view_pef()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/director_view_pef');
	}
	
	public function engineer_dvr_form()
	{
		//echo $this->session->userdata('userrole');exit;
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor')
		{
			$this->load->model("complaint_model");
        $get_eng_dvr = $this->complaint_model->get_eng_dvr_model();
		$this->load->view('complaint/engineer_dvr_form', array("get_eng_dvr" => $get_eng_dvr));
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
			$this->load->view('complaint/leave_form');
		}
		else
		{
		show_404();
		}
	}
	
	public function update_leave_form()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('complaint/update_leave_form');
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
			$this->load->view('complaint/all_leaves');
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
			$maxqu = $this->db->query("update user SET total_leaves='0'");
			redirect(site_url() . 'complaint/all_leaves?msg_set_total=success');
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
		$this->load->view('complaint/sap_dvr', array("get_eng_dvr" => $get_eng_dvr));
	}
	public function sap_dvr_form()
	{
		if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_eng_dvr = $this->complaint_model->get_eng_dvr_model();
		$this->load->view('complaint/sap_dvr_form', array("get_eng_dvr" => $get_eng_dvr));
	}
	public function sap_asc()
	{
		if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_eng_dvr = $this->complaint_model->get_eng_asc_model();
		$this->load->view('complaint/sap_asc', array("get_eng_dvr" => $get_eng_dvr));
	}
	//
	public function all_employee_dvr()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('complaint/all_employee_dvr');
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
			$this->load->view('complaint/all_employee_vs');
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
			$this->load->view('complaint/engineer_asc', array("get_eng_dvr" => $get_eng_dvr));
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
			$this->load->view('complaint/engineer_statistics', array("get_eng_dvr" => $get_eng_dvr));
		}
		else
		{
		show_404();
		}
    }
	public function director_statistics() {
		
		if($this->session->userdata('userrole')=='Admin')
		{
			$this->load->view('complaint/director_statistics');
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
			$this->load->model("complaint_model");
        	$get_eng_vs = $this->complaint_model->get_eng_vs_model();
			$this->load->view('complaint/engineer_vs', array("get_eng_vs" => $get_eng_vs));
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
		$this->load->view('complaint/sap_vs', array("get_eng_vs" => $get_eng_vs));
	}
	public function sap_dvr_history()
	{
		if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
		$this->load->view('complaint/sap_dvr_history');
	}
	public function engineer_dvr_history()
	{
		if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor')
		{
			$this->load->view('complaint/engineer_dvr_history');
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
						echo $sup_dvr['priority'];
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
		$this->load->view('complaint/sap_dvr_history', array("get_sup_dvr" => $get_sup_dvr,
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
		 $this->load->view('complaint/admin_vs', array("get_sup_dvr" => $get_sup_dvr,
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
								<a class="btn btn-default" href="'. base_url() .'complaint/update_vs_project/'.$sup_dvr['pk_vs_id'].'">
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
		 $this->load->view('complaint/admin_dvr', array("get_sup_dvr" => $get_sup_dvr,
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
						echo $sup_dvr['priority'];
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
						echo $sup_dvr['priority'];
					}
					echo '</textarea> </td>';
					
					echo '<td> <textarea readonly name="summery" id="textarea" class="input-medium" required="" rows="4">';
					echo urldecode($sup_dvr['summery']);
					echo '</textarea> </td>';
					echo '<td>
												<a class="btn btn-default" href="'. base_url() .'complaint/update_dvr_project/'.$sup_dvr['pk_dvr_id'].'">
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
		$this->load->view('complaint/supervisor_my_complaints', array("get_complaint_list" => $get_complaint_list));
	}
	public function supervisor_pm()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
        //$this->load->model("complaint_model");
        //$get_complaint_list = $this->complaint_model->get_supervisor_pm_model();
		//$this->load->view('complaint/supervisor_pm', array("get_complaint_list" => $get_complaint_list));
		$this->load->view('complaint/supervisor_pm');
	}
	public function supervisor_pm_completed()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->view('complaint/supervisor_pm_completed');
	}
	public function sap_projects()
	{
        if($this->session->userdata('userrole')!='Salesman')
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_sap_projects = $this->complaint_model->get_sap_projects();
		$this->load->view('complaint/sap_projects', array("get_sap_projects" => $get_sap_projects));
	}
	public function engineer_projects()
	{
        if($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Supervisor')
		{
			$this->load->model("complaint_model");
        	$get_engineer_projects = $this->complaint_model->get_sap_projects();
			$this->load->view('complaint/engineer_projects', array("get_engineer_projects" => $get_engineer_projects));
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
		$this->load->view('complaint/engineer_view_complaints', array("get_complaint_list" => $get_complaint_list));
	}
	public function customers_view()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->model("complaint_model");
			$get_customers_list = $this->complaint_model->get_customer_view_model();
			$this->load->view('complaint/customers_view', array("get_customers_list" => $get_customers_list));
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
		$this->load->view('complaint/edit_customer', array("get_customers_list" => $get_customers_list));
	}
	
	public function engineer_view_pm()
	{
		if($this->session->userdata('userrole')!='FSE' && $this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
        $this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_engineer_pm_model();
		$this->load->view('complaint/engineer_view_pm', array("get_complaint_list" => $get_complaint_list));
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
            redirect(site_url() . 'complaint/customers_view?msg=success');
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
            redirect(site_url() . 'complaint/customers_view?msg_update=updated successfully');
	}
	public function add_business_project()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('complaint/add_business_project');
	}
	public function vendors()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('complaint/vendors');
	}
	
	public function equipments()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
			$this->load->view('complaint/equipments');
	}
	
	public function admin_dvr()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('complaint/admin_dvr');
		}
		else
		{
		show_404();
		}
	}
	
	public function admin_dvr_new()
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
			$this->load->view('complaint/admin_dvr_new');
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
			$this->load->view('complaint/admin_vs');
		}
		else
		{
		show_404();
		}
	}
	public function update_business_project($business_project_id)
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
        $this->load->model("complaint_model");
        $get_business_projects_list = $this->complaint_model->get_update_business_project_model($business_project_id);
		$this->load->view('complaint/update_business_project', array("get_business_projects_list" => $get_business_projects_list));
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
		$this->load->view('complaint/update_equipment');
	}

    public function delete_equipment($id) {
        $query="delete from  tbl_instruments  where `pk_instrument_id` =$id";
        $dbres = $this->db->query($query);
        redirect(site_url() . 'complaint/equipments?msg_delete=success');
    }
	
	public function update_equipment_insert()
	{
			 $this->load->model("profile_model");
			$query="update tbl_instruments SET 				  
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
								`warranty_start_date`	=	'".$this->profile_model->change_date_to_mysql_style($_POST['warranty_start_date'])."',
								`status`				=	'".$_POST['status']."',
								`details`				=	'".$_POST['description']."'
								 where pk_instrument_id = '".$_POST['pk_instrument_id']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  //
			  
            redirect(site_url() . 'complaint/equipments?msg_update=success');
	}
	public function details_business_project($business_project_id)
	{
		if($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery')
		{
		$this->load->view('complaint/details_business_project');
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
		$this->load->view('complaint/update_vs_project', array("get_update_vs_project_list" => $get_update_vs_project_list));
	}
	public function update_dvr_project($vs_id)
	{
		if($this->session->userdata('userrole')!='Admin' && $this->session->userdata('userrole')!='secratery' )
		{
			show_404();
		}
		$this->load->model("complaint_model");
        $get_update_dvr_project_list = $this->complaint_model->get_update_dvr_project($vs_id);
		$this->load->view('complaint/update_dvr_project', array("get_update_dvr_project_list" => $get_update_dvr_project_list));
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
					   `Project Description`				=	'".$_POST['Project_Description']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			
            redirect(site_url() . 'complaint/add_business_project?msg=success');
			
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
     redirect(site_url().'complaint/pef_employee/'.$_POST['fk_engineer_id'].'/'.$_POST['schedule_id'].'/'.$_POST['evaluater_role'].'/'.$_POST['fk_evaluater_id'].'?msg=success');
	}
	
	public function add_category_insert()
	{
			 $query="insert  `tbl_category` SET 	
			  `category_name`						='".$_POST['category_name']."'";
			  //`fk_type_id`							='".$_POST['type_name']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  redirect(site_url().'complaint/categories/?msg=success');
	}
	
	public function add_city_insert()
	{
			 $query="insert  `tbl_cities` SET 	
			  `city_name`						='".$_POST['city_name']."', 
			  `fk_office_id`							='".$_POST['office_name']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			  redirect(site_url().'complaint/cities/?msg=success');
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
			  redirect(site_url().'complaint/products/?msg=success');
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
			  redirect(site_url().'complaint/products/?msg=success');
	}
	public function delete_business_project($id)
	{
		$query="update business_data SET 				  
								`status`							=	'1'
								where pk_businessproject_id			= 	'".$id."'
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
		redirect(site_url() . 'complaint/business_data?del=success');
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
					   `Project Description`				=	'".$_POST['Project_Description']."'
					   where pk_businessproject_id			= 	'".$_POST['businessproject_hidden_id']."'";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			
            redirect(site_url() . 'complaint/business_data?upt=success');
			
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
			
			 $query="insert into tbl_dvr SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`fk_city_id`			=	'".$_POST['city'][$key]."',
								`fk_engineer_id`  		=	'".$_POST['engineer']."',
								`fk_customer_id`		=	'".$_POST['customer'][$key]."',
								`fk_business_id`		=	'".$_POST['business'][$key]."',
								`priority`				=	'".urlencode($_POST['business_description'][$key])."',
								`timeline`				=	'".$_POST['time_elaped'][$key]."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`next_plan`				=	'".urlencode($_POST['next_plan'][$key])."',
								`date`					=	'".$current_date."'
								
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			}
			if(isset($_POST['form_name']))
			{
				if($_POST['form_name']=='sap_dvr_form')
				{
					redirect(site_url() . 'complaint/sap_dvr_form?msg=success');
				}
				else
				{
					redirect(site_url() . 'complaint/sap_dvr?msg=success');
				}
			}
			else
			{
            redirect(site_url() . 'complaint/engineer_dvr?msg=success');
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
								`fk_city_id`			=	'".$_POST['city'][$key]."',
								`fk_business_id`		=	'".$_POST['business'][$key]."',
								
								`priority`				=	'".urlencode($_POST['business_description'][$key])."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`next_plan`				=	'".urlencode($_POST['next_plan'][$key])."'
								where pk_dvr_id			=	'".$dvr_id."'
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			}
			$b="zaaid";
			$e=$_POST['engineer'];
			$sd=$_POST['start_mydate'];
			$ed=$_POST['end_mydate'];
			if(isset($_POST['engineer']) && isset($_POST['start_mydate']) && isset($_POST['end_mydate'])) {
				redirect(site_url() . 'complaint/admin_dvr_new?engineer='.$_POST['engineer'].'start_mydate='.$_POST['start_mydate'].'end_mydate='.$_POST['end_mydate']);
			}
			else {
            redirect(site_url() . 'complaint/update_dvr_project/'.$dvr_id.'?msg=a');
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
            redirect(site_url() . 'complaint/update_vs_project/'.$vs_id.'?msg=success');
	}
	
	public function insert_dvr_engineer()
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
			 // if($end_ampm[1]=='AM'){ $end_nhour=$end_hour[0]; }else{ $end_nhour=$end_hour[0]+12; } zaaid
			 if($end_ampm[1]=='PM' && $end_hour[0]<12){ $end_nhour=$end_hour[0]+12; }else{ $end_nhour=$end_hour[0]; }
			 if($end_ampm[1]=='AM' && $end_nhour==12 ){ $end_nhour-=12;}
			 $re_end_hour=$end_nhour.':'.$end_ampm_minut[1].':00';
			 //echo 'start time'.$re_start_hour.'<br> end time='.$re_end_hour;exit;
			 //
			 //
			 //////////////////////zaaid
			 $current_date=date('Y-m-d');
			 $current_time=date('H');
			 if ($current_time<8) {$current_date = date('Y-m-d H:i:s',(strtotime ( '-1 day' , strtotime ( $current_date) ) ));}
			///////////////////// zaaid
			 $query="insert into tbl_dvr SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`fk_city_id`			=	'".$_POST['city'][$key]."',
								`fk_engineer_id`  		=	'".$_POST['engineer']."',
								`fk_customer_id`		=	'".$_POST['customer'][$key]."',
								`fk_business_id`		=	'".$_POST['business'][$key]."',
								
								`priority`				=	'".$_POST['business_description'][$key]."',
								`timeline`				=	'".$_POST['time_elaped'][$key]."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`next_plan`				=	'".urlencode($_POST['next_plan'][$key])."',
								`date`					=	'".$current_date."'
								
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
			}
			if(isset($_POST['engineer_dvr_form']))
			{
				redirect(site_url() . 'complaint/engineer_dvr_form?msg=success');
			}
			else
			{
            redirect(site_url() . 'complaint/engineer_dvr?msg=success');
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
            redirect(site_url() . 'complaint/vendor_registration?msg=success');
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
            redirect(site_url() . 'complaint/vendors?msg_upt=success');
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
								`warranty_start_date`	=	'".$this->profile_model->change_date_to_mysql_style($_POST['warranty_start_date'])."',
								`status`				=	'".$_POST['status']."',
								`details`				=	'".$_POST['description']."'
								";
			  //echo $query;exit; $this->profile_model->change_date_to_mysql_style for dates important missing in above  by zaaid
			  $dbres = $this->db->query($query);
			  //
			  
            redirect(site_url() . 'complaint/equipment_registration?msg=success');
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
			 //echo site_url() . 'complaint/technical_service_pvr/'.$fk_complaint_id."#working_details";
            redirect(site_url() . 'complaint/technical_service_pvr/'.$fk_complaint_id."#working_details");
			
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
			  
            redirect(site_url() . 'complaint/technical_service_pvr/'.trim($fk_complaint_id)."#qc_dataa");
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
			redirect(site_url() . 'complaint/ts_report_supervisor/'.$_POST['complaint_id']);
	}
	public function supervisor_view_complaints()
	{
		if($this->session->userdata('userrole')!='Supervisor')
		{
			show_404();
		}
		$this->load->view('complaint/supervisor_view_complaints');
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
								`customer_signing_complaint_form`				=	'".$_POST['customer_signing_complaint_form']."',
								`customer_mobile_signing_complaint_form`		=	'".$_POST['customer_mobile_signing_complaint_form']."',
								`customer_designation_signing_complaint_form`	=	'".$_POST['customer_designation_signing_complaint_form']."',
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
			  
			redirect(site_url() . 'complaint/technical_service_pvr/'.$_POST['complaint_id']);
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
			 $query="insert into tbl_dvr SET 				  
								`start_time`			=	'".$re_start_hour."',
								`end_time`				=	'".$re_end_hour."',
								`fk_city_id`			=	'".$_POST['city'][$key]."',
								`fk_engineer_id`  		=	'".$_POST['engineer'][$key]."',
								`fk_customer_id`		=	'".$_POST['customer'][$key]."',
								`fk_business_id`		=	'".$_POST['business'][$key]."',
								
								`priority`				=	'".$_POST['business_description'][$key]."',
								`timeline`				=	'".$_POST['time_elaped'][$key]."',
								`summery`				=	'".urlencode($_POST['summery'][$key])."',
								`next_plan`				=	'".urlencode($_POST['next_plan'][$key])."',
								`date`					=	'".$this->profile_model->change_date_to_mysql_style($_POST['date'][$key])."'
								
							  ";
			  //echo $query;exit;
			  $dbres = $this->db->query($query);
				redirect(site_url() . 'complaint/admin_dvr_form?msg=success');
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
            redirect(site_url() . 'complaint/sap_vs?msg=success');
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
            redirect(site_url() . 'complaint/engineer_vs?msg=success');
	}
	
	
	public function insert_complaint() {
		$this->load->model("profile_model");
		$problem_summery=$_POST['instrument_prob'].' '.$_POST['kit_prob_des_cus'];
		if(!empty($_POST['call_date']))
		{
			$newdelevrydate = $this->profile_model->change_date_to_mysql_style($_POST['call_date']);
		}
		 //$dbres2 = $this->db->query("select * from tbl_cities where pk_city_id = '".$_POST['city']."'");
		 $dbres2 = $this->db->query("select * from user where id = '".$_POST['assign_to']."'");
		 $office = $dbres2->result_array();
		$data = array(
						'ts_number' 					=> 	$_POST['ts_number'],
						'caller_name'  					=> 	$_POST['caller_name'],
						'date'							=> 	$newdelevrydate.' '.$_POST['call_time'],
						'fk_customer_id'				=> 	$_POST['customer'],
						'fk_city_id'		 			=> 	$_POST['city'],
						'fk_office_id'		 			=> 	$office[0]['fk_office_id'],
						'problem_summary'				=>  $problem_summery,
						'status'						=> 	"Pending",
						'FSE_SAP'						=> 	$_POST['customer'],
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
            redirect(site_url() . 'complaint/operator_view_complaints?msg=success');
	  }
	//complete complaint registration
	public function complete_complaint_resgistration() {
		$this->load->model("profile_model");
		$problem_summery=$_POST['instrument_prob'].' '.$_POST['kit_prob_des_cus'];
		if(!empty($_POST['call_date']))
		{
			$newdelevrydate = $this->profile_model->change_date_to_mysql_style($_POST['call_date']);
		}
		 //$dbres2 = $this->db->query("select * from tbl_cities where pk_city_id = '".$_POST['city']."'");
		 //$dbres2 = $this->db->query("select * from user where id = '".$_POST['assign_to']."'");
		 //$office = $dbres2->result_array();
		$data = array(
						'ts_number' 					=> 	$_POST['ts_number'],
						'caller_name'  					=> 	$_POST['caller_name'],
						'date'							=> 	$newdelevrydate.' '.$_POST['call_time'],
						'fk_customer_id'				=> 	$_POST['customer'],
						'fk_city_id'		 			=> 	$_POST['city'],
						'problem_summary'				=>  $problem_summery,
						'status'						=> 	"Pending",
						'FSE_SAP'						=> 	$_POST['customer'],
						'phone'							=>  $_POST['mobile'],
						'problem_type'					=> 	$_POST['problem_type'],
						'assign_to' 					=> 	$_POST['assign_to'],
						
						
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
			
            redirect(site_url() . 'complaint/operator_view_complaints?msg=success');
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
            redirect(site_url() . 'complaint/add_complaint_half?msg=Complaint Added Successfully');
	  }
	// Delete Single Message.
	
		public function shift_complaint() {
        if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
        $this->load->view('complaint/shift_complaint');
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
		redirect(site_url() . 'complaint/shift_complaint/'.$this->input->post('complaint_id')."?msg=success");
        
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
            redirect(site_url() . 'complaint/supervisor_assign_pm?msg=success');
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
	public function customer_list_ajax()
	{
        $city_id=$this->input->post('var_name');		//
		$dbres = $this->db->query("SELECT * FROM tbl_clients where fk_city_id = '".$city_id."'");
        $dbresResult=$dbres->result_array();
		//
		echo '<select name="customer" class="form-control" id="client_name" onchange="select_contact_no(this.value)" required>';
		echo '<option value="">---Select---</option>';
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
	
	public function equipment_based_on_vendor_ajax()
	{
		$vendor_id	   =	$this->input->post('vendor_id');
		$rrr			 =	"select * from tbl_vendor_product_bridge where fk_vendor_id = '".$vendor_id."' ";
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
        	$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$nnm[0]['fk_office_id']."' AND userrole IN ('FSE','Supervisor')");
		}
		else
		{
			$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$nnm[0]['fk_office_id']."' AND userrole IN ('FSE','Salesman','Supervisor')");
		}
		$yu=$get_complaint_list->result_array();
		echo '<select name="assign_to" class="form-control nnn input-xlarge" >';
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
		//
		$dbres = $this->db->query("SELECT * FROM tbl_clients where pk_client_id = '".$client_id."'");
        $dbresResult=$dbres->result_array();
		//
		
		
		$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$dbresResult[0]['fk_office_id']."' AND userrole IN ('FSE','Salesman','Supervisor')");
		$yu=$get_complaint_list->result_array();
		echo '<select name="assign_to" class="form-control nnn" >';
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
		
		
		$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$dbresResult[0]['fk_office_id']."' AND userrole IN ('FSE','Supervisor')");
		$yu=$get_complaint_list->result_array();
		echo '<select name="assign_to" class="form-control nnn" >';
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
		
		
		$get_complaint_list = $this->db->query("select * from user where fk_office_id='".$dbresResult[0]['fk_office_id']."' AND userrole IN ('FSE','Salesman','Supervisor')");
		$yu=$get_complaint_list->result_array();
		echo '<select name="assign_to" class="form-control nnn" >';
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
		echo '<select name="instrument" class="form-control" onchange="slect_office_ajax_and_related_engineers(this.value)" >';
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
										  billing	 	  = 	'".$_POST['Total'][$name]."',
										  purpose	  	  = 	'".urlencode($_POST['purpose'][$name])."',
										  status	  	  = 	'".$_POST['problem_type'][$name]."',
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
		$qu="insert into tbl_direct_challans set    fk_ts_id = 	'".$_POST['complaint_id']."',
										  			status	  	  = 	'New',
										  			print_count	  = 	0,
										 			DC_date	 	  = 	'".date('Y-m-d H:i:s')."'
										 			 ";
		$gh=$this->db->query($qu);
		// make complaint sprf approved
		$qu="update tbl_complaints set status = 	'SPRF_Approved' where pk_complaint_id='".$_POST['complaint_id']."'";
		$gh=$this->db->query($qu);
		redirect(site_url() . 'complaint/operator_view_complaints?msg=success');
	}
	public function operator_view_dc()
	{
		$this->load->model("complaint_model");
        $get_complaint_list = $this->complaint_model->get_operator_view_dc_model();
		$this->load->view('complaint/operator_view_dc', array("get_complaint_list" => $get_complaint_list));
	}
	public function update_vendor()
	{
		if($this->session->userdata('userrole')!='Admin')
		{
			show_404();
		}
		$this->load->view('complaint/update_vendor');
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
		
			$department	=	$this->input->post('department');
			if($department=='Sales')
			{
				$qu="SELECT * from user where userrole =  'Salesman'";
			}
			else
			{
				$qu="SELECT * from user where userrole =  'FSE'";
			}
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
		echo '<select class="form-control  " name="business['.$rowid.']" onchange="fill_business_dec_and_timeelapsed(this.value,'.$rowid.')" id="business'.$rowid.'" required>
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
	// for old dvr page
	public function business_select_ajax()
	{
		$cutomer_id	=	$this->input->post('client_id');
		$rowid	=	$this->input->post('rowid');
		 //echo 'cutomer='.$cutomer_id.'city='.$city_id.'rowid='.$rowid;exit;

		$qu="select * from business_data where Customer='".$cutomer_id."'  And `Sales Person`='".$this->session->userdata('userid')."'  and status='0'";
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
        $nicetimevr = $this->complaint_model->nicetime($rt[0]['Date']);
		
		echo $nicetimevr ;
	}
	
}

/* End of file complaint.php */
/* Location: ./application/controllers/inbox.php */