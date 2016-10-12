<?php 
////////////////////////// ******* IMPORTANT ************////////////////////////
////////////////////////// ******* IMPORTANT ************////////////////////////
////////////////////////// ******* IMPORTANT ************////////////////////////
////////////////////////// ******* IMPORTANT ************////////////////////////
/*
PMA have asked that they want pending verification calls on this page too. So i am changing every where spellings of Pending Verification TO Verificationn So that Pending Verification calls do appear here.
SAME for pending sprf. Changing its spellings to sprff
*/


$this->load->view('header');
$user_id =	$this->session->userdata('userid');
$dates_set = "yes";
$start_date_month = date('Y-m').'-01';
$start_date = date('Y-m-d',strtotime($start_date_month));
$end_date = date('Y-m-d');
$current_date = date('Y-m-d');
if(isset($_GET['start_mydate']) && isset($_GET['end_mydate'])) {
	//echo "zaaid";
	$dates_set = "yes";
	$start_date = date('Y-m-d',strtotime($_GET['start_mydate']));
	$end_date = date('Y-m-d',strtotime($_GET['end_mydate']));
	if ($start_date==$end_date && $start_date>$current_date)
		$dates_set = "no";
}
$maxqu = $this->db->query("SELECT * FROM user where id='".$user_id ."'");
$maxval=$maxqu->result_array();
if(isset($_GET['engineer'])) {
	$user_id = $_GET['engineer'];
	$maxqu = $this->db->query("SELECT * FROM user where id='".$user_id ."'");
	$maxval=$maxqu->result_array();
	if ($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Salesman' || $this->session->userdata('userrole')=='Supervisor') {
		if ($user_id !=$this->session->userdata('userid'))
			show_404();
	}
	if ($this->session->userdata('userrole')=='Supervisor') {
		if ($maxval[0]['userrole']=='Salesman') show_404();
		if ($maxval[0]['userrole']=='FSE' && $maxval[0]['fk_office_id']!=$this->session->userdata('territory')) show_404();
	}
}


$total_leaves = $maxval[0]['total_leaves'];
$user_name =	$maxval[0]['first_name'];
$user_role =	$maxval[0]['userrole'];

$previous_month = "";
$previous_m = date('m',strtotime($end_date));
$previous_y = date('Y',strtotime($end_date));
if ($previous_m == '01') {
	$previous_y = $previous_y-1;
	$previous_month = "December ".$previous_y;
}
else {
	$previous_m = $previous_m-1;
	$previous_month = date('F Y',strtotime('-1 months',strtotime($end_date)));
}

////////////// Leaves Balance //////////////
$start_month	=	7; // July
$available_leaves	=	21;
$leaves_per_month	=	$available_leaves/12;
$working_months_current_year	=	12; ////////////total months  for which leaves will be given
$current_month	=	date('m');
$current_year	=	date('Y');
$previous_year	=	date('Y')-1;
$join_date		= 	$maxval[0]["date_of_joining"];
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

$leaves_balance = $available_leaves - $maxval[0]['total_leaves'];

///////////////// Average Time PM BEGIN
$average_time_pm =  "N / A";
$qu_int_sc	="select * from tbl_complaints where assign_to='".$maxval[0]['id']."' AND complaint_nature='PM' AND status='Completed' ";
if ($dates_set=="yes")
{$qu_int_sc .=" AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";}
$qh_int_sc	=$this->db->query($qu_int_sc);
$res_int_sc = $qh_int_sc->result_array();
if(sizeof($res_int_sc)>0)
{
	$average=0;
	$count=0;
	foreach($res_int_sc as $interval)
	{
		//echo "zaaid";
	$count++;
	$to_time= strtotime($interval['solution_date']);
	$from_time = strtotime($interval['date']);
	$average = round(abs($to_time - $from_time) / 3600,2);//.', ';
	}
	$average_time_pm =  round($average/$count,2).' Hours';
}
else
{
	//echo "zaaid";
	$average_time_pm =   "N / A";
}
///////////////// Average Time PM End

//////////////////// PM Stats Begin
$pmcs_pending = 0;//
$pmcs_pending_total = 0;//
$pmcs_pending_verification = 0;
$pmcs_completed = 0;//
$pmcs_assigned = 0;//

$query	="select * from tbl_complaints where assign_to='".$maxval[0]['id']."' AND complaint_nature='PM' AND status='Completed' ";
if ($dates_set=="yes")
{$query .=" AND CAST(`solution_date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";}
$query_db	=$this->db->query($query);
$result = $query_db->result_array();
$pmcs_completed = sizeof($result);

$query	="select * from tbl_complaints where assign_to='".$maxval[0]['id']."' AND complaint_nature='PM' ";
if ($dates_set=="yes")
{$query .=" AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";}
$query_db	=$this->db->query($query);
$result = $query_db->result_array();
$pmcs_assigned = sizeof($result);

$query	="select * from tbl_complaints where assign_to='".$maxval[0]['id']."' AND complaint_nature='PM' AND status!='Completed' AND status!='Pending Verificationn' ";
$query_db	=$this->db->query($query);
$result = $query_db->result_array();
$pmcs_pending_total = sizeof($result);
if ($dates_set=="yes")
{$query .=" AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";}
$query_db	=$this->db->query($query);
$result = $query_db->result_array();
$pmcs_pending = sizeof($result);
/////////////////// PM Stats End


//////////////////// Average Time TS Begin
$average_time_ts =  "N / A";
$qu_int_sc	="select * from tbl_complaints where assign_to='".$maxval[0]['id']."' AND complaint_nature='complaint' AND status='Closed' ";
if ($dates_set=="yes")
{$qu_int_sc .=" AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";}
$qh_int_sc	=$this->db->query($qu_int_sc);
$res_int_sc = $qh_int_sc->result_array();
if(sizeof($res_int_sc)>0)
{
	
	$average=0;
	$count=0;
	foreach($res_int_sc as $interval)
	{
		$count++;
		$to_time   = strtotime($interval['finish_time']);
		$from_time = strtotime($interval['date']);
		$average   = round(abs($to_time - $from_time) / 3600,2);//.', ';
	}
	$average_time_ts = round($average/$count,2).' Hours';
}
else
{
	$average_time_ts =   "N / A";
}
/////////////////// Average Time TS End

//////////////////// TS Stats Begin
$complaints_pending = 0;//
$complaints_pending_total = 0;//
$complaints_pending_verification = 0;
$complaints_closed = 0;//
$complaints_assigned = 0;//
$complaints_pending_sprf = 0;
$query	="select * from tbl_complaints where assign_to='".$maxval[0]['id']."' AND complaint_nature='complaint' AND status='Closed' ";
if ($dates_set=="yes")
{$query .=" AND CAST(`finish_time` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";}
$query_db	=$this->db->query($query);
$result = $query_db->result_array();
$complaints_closed = sizeof($result);

$query	="select * from tbl_complaints where assign_to='".$maxval[0]['id']."' AND complaint_nature='complaint' ";
if ($dates_set=="yes")
{$query .=" AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";}
$query_db	=$this->db->query($query);
$result = $query_db->result_array();
$complaints_assigned = sizeof($result);

$query	="select * from tbl_complaints where assign_to='".$maxval[0]['id']."' AND complaint_nature='complaint' AND status!='Closed' AND status!='Pending Verificationn' AND status!='Pending SPRFF' ";
$query_db	=$this->db->query($query);
$result = $query_db->result_array();
$complaints_pending_total = sizeof($result);
if ($dates_set=="yes")
{$query .=" AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";}
$query_db	=$this->db->query($query);
$result = $query_db->result_array();
$complaints_pending = sizeof($result);
/////////////////// TS Stats End


//////////////////// FINE Begin
$fine_previous_month = 0;
$fine_previous_month_discarded = 0;
$fine_this_month = 0;
$fine_this_month_pending = 0;
$fine_this_month_discarded = 0;
if ($dates_set=="yes") $current_date = $end_date;
$month=date('m',strtotime($current_date))-1;
if( strlen($month)==1)
{ $month= '0'.$month; }
$year=date('Y',strtotime($current_date));
if ($month == '01') $year = $year - 1;
//echo $month;
$my_query = "select * from tbl_fine 
		   where status = 'Charged' AND fk_employee_id = '".$maxval[0]['id']."' 
		   AND date like '".$year.'-'.$month."%'";
//echo $my_query;
$query2 		 = $this->db->query($my_query);
$amount_count = $query2->result_array();
$total=0;
foreach($amount_count as $value1)
{
  $total= $total + $value1['amount'];
}
$fine_previous_month = $total;

// fine_previous_month_discarded
$my_query = "select * from tbl_fine 
		   where status = 'Discarded' AND fk_employee_id = '".$maxval[0]['id']."' 
		   AND date like '".$year.'-'.$month."%'";
//echo $my_query;
$query2 		 = $this->db->query($my_query);
$amount_count = $query2->result_array();
$total=0;
foreach($amount_count as $value1)
{
  $total= $total + $value1['amount'];
}
$fine_previous_month_discarded = $total;
//////////////////////////////////////////////////////// this month fine
/*
$query2 = $this->db->query("select * from tbl_fine 
						 where status = 'Charged' AND fk_employee_id = '".$maxval[0]['id']."' 
						 AND date like '".date('Y-m',strtotime($current_date))."%'"); */
$query2 = $this->db->query("select * from tbl_fine 
						 where status = 'Charged' AND fk_employee_id = '".$maxval[0]['id']."' 
						 AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
if ($dates_set == "no")
{
	$query2 = $this->db->query("select * from tbl_fine 
						 where status = 'Charged' AND fk_employee_id = '".$maxval[0]['id']."'");
}
$amount_count = $query2->result_array();
$total=0;
foreach($amount_count as $value2)
{
  $total= $total + $value2['amount'];
}
$fine_this_month = $total;
//////////////////// FINE End

/////////////////// Fine Pending and Discarded
$query2 = $this->db->query("select * from tbl_fine 
						 where status = 'Pending' AND fk_employee_id = '".$maxval[0]['id']."' 
						 AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
if ($dates_set == "no")
{
	$query2 = $this->db->query("select * from tbl_fine 
						 where status = 'Pending' AND fk_employee_id = '".$maxval[0]['id']."'");
}
$amount_count = $query2->result_array();
$total=0;
foreach($amount_count as $value2)
{
  $total= $total + $value2['amount'];
}
$fine_this_month_pending = $total;

$query2 = $this->db->query("select * from tbl_fine 
						 where status = 'Discarded' AND fk_employee_id = '".$maxval[0]['id']."' 
						 AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'");
if ($dates_set == "no")
{
	$query2 = $this->db->query("select * from tbl_fine 
						 where status = 'Discarded' AND fk_employee_id = '".$maxval[0]['id']."'");
}
$amount_count = $query2->result_array();
$total=0;
foreach($amount_count as $value2)
{
  $total= $total + $value2['amount'];
}
$fine_this_month_discarded = $total;

////////////////////// End Fine Pending and Discarded

//////////////////////////////////// Daily Allowance Previous Month BEGIN
$allowance_previous_month = "N/A";
		 $m = date('n',strtotime($current_date)); 
		 //$m=1;
		  $lastmonth_start = date('Y-m-d',mktime(1,1,1,$m-1,1,date('Y',strtotime($current_date)))); 
		  $lastmonth_end = date('Y-m-d',mktime(1,1,1,$m,0,date('Y',strtotime($current_date)))); 
		  //echo $lastmonth_start;
		 $dbres_query = "SELECT * FROM tbl_dvr where (fk_engineer_id = '".$maxval[0]['id']."' 
						 AND date 
						 between '".$lastmonth_start."' 
						 AND 
						 '".$lastmonth_end."'
						 
						  AND  (`fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$'
						  OR `outstation` = '1') )
						  GROUP BY DATE
						 ";
		 $dbres = $this->db->query($dbres_query);
		 $dbresResult=$dbres->result_array();
		 //
		 $sunday_visits_this_month=0;
		 $non_sunday_visits_this_month=0;
		 //
		 foreach ($dbresResult as $eng_dvr ) 
		 {
			$mynewdate = date('D',strtotime($eng_dvr['date']));
			  if($mynewdate=='Sun')
			  {
				  $sunday_visits_this_month++;
			  }
			  elseif($mynewdate!='Sun')
			  {
				  $non_sunday_visits_this_month++;
			  }					   
		 }
	   $maxqu = $this->db->query("SELECT * FROM user where id='".$maxval[0]['id']."'  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
	   $maxvall=$maxqu->result_array();
	   $specific_amount_1 = $maxvall[0]['specific_amount'];
	   
	  $daily_allownce_of_this_month 	= ($non_sunday_visits_this_month* $specific_amount_1)+($sunday_visits_this_month 
	  * $specific_amount_1); 											
	  $allowance_previous_month = ' ('.$non_sunday_visits_this_month.', '.$sunday_visits_this_month.') ';
	  //
	  $allowance_previous_month .= $daily_allownce_of_this_month;
//////////////////////////////////// Daily Allowance Previous Month End

///////////////////////////////////// Daily Allowance of Present Month begin
// this is seperate calculation for  visits  calculation from first of this month.
$daily_allowance_present_month = "";
			 $today_date = date('d', time() - 60 * 60 * 24);
			 $dbres_query = "SELECT * FROM tbl_dvr where (fk_engineer_id = '".$maxval[0]['id']."' 
							 AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'
							  AND  (`fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$'
							  OR `outstation` = '1') )
							  GROUP BY DATE
							 ";
if ($dates_set == "no")
{
	$dbres_query = "SELECT * FROM tbl_dvr where (fk_engineer_id = '".$maxval[0]['id']."' 
							  AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$')
							  OR `outstation` = '1' 
							  GROUP BY DATE
							 ";
}
			 $dbres = $this->db->query($dbres_query);
			 $dbresResult=$dbres->result_array();
			 //
			 $sunday_visits_this_month=0;
			 $non_sunday_visits_this_month=0;
			 //
			 foreach ($dbresResult as $eng_dvr ) 
			 {
				$mynewdate = date('D',strtotime($eng_dvr['date']));
				  if($mynewdate=='Sun')
				  {
					  $sunday_visits_this_month++;
				  }
				  elseif($mynewdate!='Sun')
				  {
					  $non_sunday_visits_this_month++;
				  }					   
			 }
		   $maxqu = $this->db->query("SELECT * FROM user where id='".$maxval[0]['id']."' ");
		   $maxvall=$maxqu->result_array();
		   $specific_amount_1 = $maxvall[0]['specific_amount'];
		   
		  $daily_allownce_of_this_month 	= ($non_sunday_visits_this_month* $specific_amount_1)+($sunday_visits_this_month 
		  * $specific_amount_1); 											
		  $daily_allowance_present_month = ' ('.$non_sunday_visits_this_month.', '.$sunday_visits_this_month.') ';
		  $daily_allowance_present_month .=  $daily_allownce_of_this_month;
////////////////////////////////////// Daily Allowance of Present Month end





//////////////// VISITS per day BEGIN
$average_visits_per_day = "N/A";
											$today_date = date('d', time() - 60 * 60 * 24);
											   $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$maxval[0]['id']."' 
															   AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' order by date DESC";
									if ($dates_set=="no") {
												$dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$maxval[0]['id']."' 
															    order by date DESC";
									}
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
											   //$divider = $dbres->num_rows();
											   //echo $divider.' ';
           									   $dbresResult=$dbres->result_array();
											   //
											   $count_total_this_month=0;
											   $count_office_this_month=0;
											   $sunday_visits_this_month=0;
											   $non_sunday_visits_this_month=0;
											   //
											   $offices_mas_hour_result=0;
											   $mas_hour_result=0;
											   $count_total=0;
											   $count_office=0;
											   //
											   foreach ($dbresResult as $eng_dvr ) 
											   {
												  $count_total_this_month	= $count_total_this_month+1;
												  $mynewdate = date('D',strtotime($eng_dvr['date']));
															  if($mynewdate=='Sun')
															  {
																  $sunday_visits_this_month++;
																  //echo $sunday_visits_this_month;
															  }
															  elseif($mynewdate!='Sun')// && substr($eng_dvr['fk_customer_id'],0,1)!='o'
															  {
																  $non_sunday_visits_this_month++;
																  //echo $non_sunday_visits_this_month;
															  }
															  
												   if(substr($eng_dvr['fk_customer_id'],0,1)=='o')
													  {
														  $count_office_this_month = $count_office_this_month+1;								
													  }	
													  
													  /*calculating hours*/
													   		$str_tim=explode(':',$eng_dvr['start_time']);
																	$str_hour=$str_tim[0]*60;
																	$str_mint=$str_hour + $str_tim[1];
																	//
																	$end_tim=explode(':',$eng_dvr['end_time']);
																	$end_hour=$end_tim[0]*60;
																	$end_mint=$end_hour + $end_tim[1];
																	//
																	$hours_mi=$str_mint- $end_mint;
																	$hours= $hours_mi/60;
																	$positive_hours=abs($hours);
																	//echo $positive_hours . ", ";
																	$mas_hour_result=$mas_hour_result + $positive_hours;
																	$count_total= $count_total+1;
																	
																	
													   		if(substr($eng_dvr['fk_customer_id'],0,1)=='o')
																	{
																		$str_tim=explode(':',$eng_dvr['start_time']);
																		$str_hour=$str_tim[0]*60;
																		$str_mint=$str_hour + $str_tim[1];
																		//
																		$end_tim=explode(':',$eng_dvr['end_time']);
																		$end_hour=$end_tim[0]*60;
																		$end_mint=$end_hour + $end_tim[1];
																		//
																		$hours_mi=$str_mint- $end_mint;
																		$hours_offices= $hours_mi/60;
																		$offices_positive_hours		=abs($hours_offices);
																		//echo $offices_positive_hours . ", ";
																		$offices_mas_hour_result	=$offices_mas_hour_result + $offices_positive_hours;
																		$count_office = $count_office+1;								
																	}
																		   
											   
													  /*calculating hours*/
													  
													  			   
											   }
											   $count_visits=$count_total - $count_office;	
											   //print_r($date_array);
											   $count_visits_this_month	=	$count_total_this_month - $count_office_this_month;	
											   //calculate open days using group by query as it will return only unique Dates.
											   // AND fk_customer_id REGEXP '^[0-9]+\\.?[0-9]*$' 
											   $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$maxval[0]['id']."' 
															   AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' group by date order by date DESC";
										if ($dates_set=="no") {
											 $dbres_query = "SELECT * FROM tbl_dvr where fk_engineer_id = '".$maxval[0]['id']."' 
															    group by date order by date DESC";
										}	   
											   
											   //echo $dbres_query;exit;
											   $dbres = $this->db->query($dbres_query);
           									   $divider = $dbres->num_rows();
											   //echo $divider.' ';
											   //echo $count_visits_this_month . '----' . $divider . '----'; //zaaid
											   if($divider>0)
											   {
											   	$average_visits_per_day = round($count_visits_this_month/$divider, 2) . ' Visits/Day';
											   }
											   else $average_visits_per_day = "N/A";
//////////////// VISITS per day END

//// Hours per day begin
$average_hours_per_day = "N/A";
										if($divider>0)
											   {
											   	$office_plus_filed_hours = round($mas_hour_result/$divider, 2);
												$average_hours_per_day = $office_plus_filed_hours . " Hours";
											   }
//// Hours per day End
//// Hours per day field begin
$average_hours_per_day_field = "N/A";
if($divider>0)
											   {
											   	$offices_hours=  round($offices_mas_hour_result/$divider, 2);
												//
												$field_hours = $office_plus_filed_hours-$offices_hours;
												$average_hours_per_day_field = $field_hours . " Hours";
											   }
//// Hours per day field End
//// Hours per day office begin
$average_hours_per_day_office = "N/A";
if($divider>0)
											   {
											   	$average_hours_per_day_office = $offices_hours . " Hours";
											   }
//// Hours per day Office End

/* variables: $total_leaves, $leaves_balance, $average_time_pm, $average_time_ts, daily_allowance_present_month, fine_this_month, allowance_previous_month, fine_previous_month
$pmcs_pending, $pmcs_pending_total, $pmcs_assigned, $pmcs_completed, $complaints_pending, $complaints_pending_total, $complaints_assigned, $complaints_closed
$average_visits_per_day, $average_hours_per_day, $average_hours_per_day_field, $average_hours_per_day_office

For SAP $customers_assigned, $count_of_customers_not_visited_in_last_30_days, $customer_visited_in_last_30_days

there wont be any TS PM stats for SAPs

if date assigned yes then given date range,
if date assigned no, i.e. blank, or same date of next day, complete statistics

previous month fine, daily allowance -> takes current month = the month of end date or just current month when dates not set
pending total means overall pending
pending means assigned this month and pending
*/
?>


<?php ///////////////////// FOR SAP ///////////////////////////////
											  $nq="select * from tbl_customer_sap_bridge where fk_user_id='".$maxval[0]['id']."'";
											  $nq6 = $this->db->query($nq);
											  $customers_assigned = $nq6->num_rows();
										?>
                                 	 	<!--Customers Visited in Last 30 Days-->
                                        <?php 
											 $count_of_customers_not_visited_in_last_30_days=0;
											$myquery="SELECT 
											tbl_customer_sap_bridge.fk_client_id, tbl_customer_sap_bridge.fk_user_id, 
											tbl_clients.client_name, tbl_clients.fk_city_id, tbl_clients.fk_area_id
											 FROM 
											 tbl_customer_sap_bridge 
											 INNER JOIN
											 tbl_clients
											 ON
											 tbl_clients.pk_client_id 	=	tbl_customer_sap_bridge.fk_client_id
											 where
											 tbl_clients.pk_client_id !=  '0' 
											 AND  tbl_customer_sap_bridge.fk_user_id =  '".$maxval[0]['id']."'";
											if(!empty($visited_client_array))
											{
											foreach($visited_client_array as $visited)
												{
													$myquery.=" AND tbl_clients.pk_client_id !=  '".$visited."'";
												}
											}
											$maxqu6 = $this->db->query($myquery); 
											if($maxqu6->num_rows()>0)
											{
											$maxval6=$maxqu6->result_array();
											foreach ($maxval6 as $not_visited) 
											{
												$nq="select * from
													 tbl_dvr
													 WHERE
													 fk_engineer_id 	=	'".$not_visited['fk_user_id']."'
													 AND
													 fk_customer_id= '".$not_visited['fk_client_id']."'
													 AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."'";
													 
													 if ($dates_set=="no") {
														 $nq="select * from
													 tbl_dvr
													 WHERE
													 fk_engineer_id 	=	'".$not_visited['fk_user_id']."'
													 AND
													 fk_customer_id= '".$not_visited['fk_client_id']."'";
													 }
													 //echo $nq;exit;
											 $nq7 = $this->db->query($nq);
											 if ($nq7->num_rows() == 0){
												$count_of_customers_not_visited_in_last_30_days++;
												}
											}
										  }
										  ?>
										<?php 
											  $customer_visited_in_last_30_days = $nq6->num_rows() - $count_of_customers_not_visited_in_last_30_days;
                                             // echo $customer_visited_in_last_30_days;
                                        ?>
        
										
										<!--Customers Not Visited in Last 30 Days-->
<?php

function Get_Date_Difference($start_date, $end_date)
    {
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        return (($years > 0) ? $years.' year'.(($years > 1 ? 's ' : '')) : '').(($months > 0) ? (($months == 1) ? ' '.$months.' month' : ' '.$months.' months' ) : '').(($days > 0) ? (($days == 1) ? ' '.$days.' day' : ' '.$days.' days' ) : '');
    }
function zerodisplay($value) {
	if ($value==0) return '-';
	else return $value;
}
	  //echo $count_of_customers_not_visited_in_last_30_days;
	  
	  /* variables: $total_leaves, $leaves_balance, $average_time_pm, $average_time_ts, daily_allowance_present_month, fine_this_month, allowance_previous_month, fine_previous_month
$pmcs_pending, $pmcs_pending_total, $pmcs_assigned, $pmcs_completed, $complaints_pending, $complaints_pending_total, $complaints_assigned, $complaints_closed
$average_visits_per_day, $average_hours_per_day, $average_hours_per_day_field, $average_hours_per_day_office

For SAP $customers_assigned, $count_of_customers_not_visited_in_last_30_days, $customer_visited_in_last_30_days

there wont be any TS PM stats for SAPs

if date assigned yes then given date range,
if date assigned no, i.e. blank, or same date of next day, complete statistics

previous month fine, daily allowance -> takes current month = the month of end date or just current month when dates not set
pending total means overall pending
pending means assigned this month and pending

Different from director statistics because that is for last 30 days running
*/
?>
										
										
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Employee Report - <?php echo $user_name; ?>
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
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
       <!-- BEGIN PAGE CONTENT-->
       <div class="row">

        <div class="col-md-12"> 
<?php if ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' ){ ?>		
		<!-- Search Form -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Employee Report </span>
								<span class="caption-helper">Monthly Report of Individual</span>
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
                            	<form method="get" action="<?php echo base_url();?>sys/monthly_report">
                                <div class="col-md-3">
                            		<div class="form-group">
                            			
                                        <select name="engineer" id="engineer" class="form-control" required>
                                            <option value="">--Select employee--</option>
											<?php 
											$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status = '0' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
											if ($this->session->userdata('userrole')=="Supervisor")
												$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status = '0' AND userrole='FSE' AND fk_office_id='".$this->session->userdata('territory')."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
											$maxval=$maxqu->result_array();
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
								
                          		<div class="col-md-2">
                            		<div class="form-group">
                            			
                                        <input type="text" name="start_mydate" class="form-control datepicker" id="start_mydate" value="<?php if(isset($_GET['start_mydate'])){ echo $_GET['start_mydate']; } else { echo '01-'.date('M-Y');}?>" required  />
										<span class="help-block">Start Date</span>
									</div>
                                </div>
                                <div class="col-md-2">
                            		<div class="form-group">
                            			
                                        <input type="text" name="end_mydate" class="form-control datepicker" id="end_mydate" value="<?php if(isset($_GET['end_mydate'])){ echo $_GET['end_mydate']; } else { echo date('d-M-Y');}?>" required />
										<span class="help-block">End Date</span>
									</div>
                                </div>
                                <div class="col-md-1">
                            		<div class="form-group">
                                        
                                            <input type="submit"  class="btn btn-default purple-seance" value="Search" >
                                    </div>
									
                                </div>
								<div class="col-md-1">
								<div class="form-group">
									<a class="btn btn-default green-seagreen " onclick="javascript:window.print();">
										Print <i class="fa fa-print font-grey-cararra"></i>
										</a>
								</div>
								</div>
								<div class="col-md-3">
								Note: Adjust your margins before printing to ensure that complete contents are printed. Or use the landscape mode from settings.
								</div>
                          		</form>
                           </div>	
							
						</div>
					</div>
		<!-- Search Form -->
<?php } ?>

<?php if ($this->session->userdata('userrole')=='FSE' || $this->session->userdata('userrole')=='Salesman' || $this->session->userdata('userrole')=='Supervisor' ){ ?>		
		<!-- Search Form -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Monthly Report </span>
								<span class="caption-helper">Search Monthly Report of Individuals</span>
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
                            	<form method="get" action="<?php echo base_url();?>sys/monthly_report">
                          		<div class="col-md-3">
                            		<div class="form-group">
                            			
                                        <input type="text" name="start_mydate" class="form-control datepicker" id="start_mydate" value="<?php if(isset($_GET['start_mydate'])){ echo $_GET['start_mydate']; } else { echo '01-'.date('M-Y');}?>" required  />
										<span class="help-block">Start Date</span>
									</div>
                                </div>
                                <div class="col-md-3">
                            		<div class="form-group">
                            			
                                        <input type="text" name="end_mydate" class="form-control datepicker" id="end_mydate" value="<?php if(isset($_GET['end_mydate'])){ echo $_GET['end_mydate']; } else { echo date('d-M-Y');}?>" required />
										<span class="help-block">End Date</span>
									</div>
                                </div>
                                <div class="col-md-1">
                            		<div class="form-group">
                                        
                                            <input type="submit"  class="btn btn-default purple-seance" value="Search" >
                                    </div>
									
                                </div>
								<div class="col-md-1">
								<div class="form-group">
									<a class="btn btn-default green-seagreen " onclick="javascript:window.print();">
										Print <i class="fa fa-print font-grey-cararra"></i>
										</a>
								</div>
								</div>
								<div class="col-md-4">
								Note: Adjust your margins before printing to ensure that complete contents are printed. Or use the landscape mode from settings.
								</div>
                          		</form>
                           </div>	
							
						</div>
					</div>
		<!-- Search Form -->
<?php } ?>



<?php if ($user_id != 3 ) { ?>
<!------------------------------------- Start Statistics -------------------------------------------->
<div class="portlet light bg-inverse">
              
                          <div class="portlet-title">
              
                            <div class="caption font-green-seagreen"> <i class="fa fa-gears font-green-seagreen"></i><span class="caption-subject bold font-green-seagreen "><?php echo $user_name; ?> Statistics - <?php echo date('jS F Y',strtotime($start_date)).' to '.date('jS F Y',strtotime($end_date)); ?></span></div>
              
                            <div class="tools">
                                 <a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
              
                          </div>
              
                          <div class="portlet-body ">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="table-scrollable">
                                      <table class="table table-hover">
              
                                          <thead class="bg-green-seagreen">
                                          	<tr><th>Statistic Name</th><th>Statistic Value</th></tr>
                                          </thead>
                                          <tbody class="bg-grey-cararra">
									<?php if ($user_role == "Salesman") { ?>
												<tr class="odd gradeX">
                                                        <td>Total Customers Assigned</td>
                                                       <td><?php echo $customers_assigned; ?></td>
                                                 </tr>
												 <tr class="odd gradeX">
                                                        <td>Customers Visited</td>
                                                       <td><?php echo $customer_visited_in_last_30_days; ?></td>
                                                 </tr>
												 <tr class="odd gradeX">
                                                        <td>Customers not Visited</td>
                                                       <td><?php echo $count_of_customers_not_visited_in_last_30_days; ?></td>
                                                 </tr>
										<?php } else { ?>
												<tr class="odd gradeX">
                                                        <td>Average time to resolve Service Call</td>
                                                       <td><?php echo $average_time_ts; ?></td>
                                                 </tr>
                                                 <tr class="odd gradeX">
                                                        <td>Average time to resolve PM</td>
                                                       <td><?php echo $average_time_pm; ?></td>
                                                 </tr>
												 <tr class="odd gradeX">
                                                        <td>Complaints Assigned</td>
                                                       <td><?php echo $complaints_assigned; ?></td>
                                                 </tr>
                                                 <tr class="odd gradeX">
                                                        <td>Complaints Pending (total)</td>
                                                       <td><?php echo $complaints_pending_total; ?></td>
                                                 </tr>
                                                 <tr class="odd gradeX">
                                                        <td>Complaints Closed</td>
                                                       <td><?php echo $complaints_closed; ?></td>
                                                 </tr>
                                                 <tr class="odd gradeX">
                                                        <td>PM Assigned</td>
                                                       <td><?php echo $pmcs_assigned; ?></td>
                                                 </tr>
                                                 <tr class="odd gradeX">
                                                        <td>PM Pending (total)</td>
                                                       <td><?php echo $pmcs_pending_total; ?></td>
                                                 </tr>
                                                 <tr class="odd gradeX">
                                                        <td>PM Completed</td>
                                                       <td><?php echo $pmcs_completed; ?></td>
                                                 </tr>
												 
										<?php } ?>
												 <tr class="odd gradeX">
                                                        <td>Total Leaves</td>
                                                       <td><?php echo $total_leaves; ?></td>
                                                 </tr>
												 <tr class="odd gradeX">
                                                        <td>Remaining Leaves </td>
                                                       <td><?php echo $leaves_balance; ?></td>
                                                 </tr>
                                          </tbody>
                                     </table>
                              </div>
							  
							  <div class="table-scrollable">
                                      <table class="table table-hover">
              
                                          <thead class="bg-green-seagreen">
                                          	<tr><th>Statistic Name</th><th>Statistic Value</th></tr>
                                          </thead>
                                          <tbody class="bg-grey-cararra">
                                                 
												 <?php
													$tstring = $year.'-'.$month.'-01';
												 ?>
                                                 <tr class="odd gradeX">
                                                        <td>Daily Allowance of <?php echo date('M-Y',strtotime($tstring));//$month.$year;//$previous_month; ?></td>
                                                       <td><?php echo $allowance_previous_month; ?></td>
                                                 </tr>
                                                 
												 <tr class="odd gradeX">
                                                        <td>Explanation Calls Amount Charged <?php echo date('M-Y',strtotime($tstring));//$previous_month; ?></td>
                                                       <td><?php echo $fine_previous_month; ?></td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                        <td>Explanation Calls Amount Discarded <?php echo date('M-Y',strtotime($tstring));//$previous_month; ?></td>
                                                       <td><?php echo $fine_previous_month_discarded; ?></td>
                                                 </tr>
												 
                                          </tbody>
                                     </table>
                              </div>
                             </div>
                              <div class="col-md-6">
                                <div class="table-scrollable">
                                      <table class="table table-hover">
              
                                          <thead class="bg-green-seagreen">
                                          	<tr><th>Statistic Name</th><th>Statistic Value</th></tr>
                                          </thead>
                                          <tbody class="bg-grey-cararra">
                                                 <tr class="odd gradeX">
                                                        <td>Average Visits Per Day</td>
                                                       <td><?php echo $average_visits_per_day; ?></td>
                                                 </tr>
                                                 <tr class="odd gradeX">
                                                        <td>Average Hours Per Day</td>
                                                       <td><?php echo $average_hours_per_day; ?></td>
                                                 </tr>
                                                 <tr class="odd gradeX">
                                                        <td>Average Hours Per Day in Field</td>
                                                       <td><?php echo $average_hours_per_day_field; ?></td>
                                                 </tr>
                                                <tr class="odd gradeX">
                                                        <td>Average Hours Per Day in Office</td>
                                                       <td><?php echo $average_hours_per_day_office; ?></td>
                                                 </tr>
												 <?php
													$tstring = $year.'-'.$month.'-01';
												 ?>
                                                 
                                                 <tr class="odd gradeX">
                                                        <td>Daily Allowance </td>
                                                       <td><?php echo $daily_allowance_present_month; ?></td>
                                                 </tr>
												 <tr class="odd gradeX">
                                                        <td>Explanation Calls Amount Charged </td>
                                                       <td><?php echo $fine_this_month; ?></td>
                                                 </tr>
												 
												 <tr class="odd gradeX">
                                                        <td>Explanation Calls Amount Pending </td>
                                                       <td><?php echo $fine_this_month_pending; ?></td>
                                                 </tr>
												 <tr class="odd gradeX">
                                                        <td>Explanation Calls Amount Discarded </td>
                                                       <td><?php echo $fine_this_month_discarded; ?></td>
                                                 </tr>
                                          </tbody>
                                     </table>
                              </div>
                             </div>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET--> 
                      </div>

<!------------------------------------- End Statistics -------------------------------------------->
<!------------------------------------- Begin 6 Table Portlets -------------------------------------------->
<?php // I am removing area from all fields below so that it can be printed in portrait mode
	${"headings_" . "0"}		=   array('TS<br/>Number', 'Time<br/>Elapsed', 'City', 'Customer',  'Equipment', 'Serial<br/>Number', 'Problem<br/>Summary', 'Status','Actions');
	${"headings_" . "1"}		=   array('TS<br/>Number', 'Time<br/>Elapsed', 'City', 'Customer',  'Equipment', 'Serial<br/>Number', 'Problem<br/>Summary', 'Status','Actions');
	${"headings_" . "2"}		=   array('TS<br/>Number', 'Time<br/>Elapsed', 'City', 'Customer', 'Equipment', 'Serial<br/>Number', 'Average PM<br/>Frequency', 'Days Since<br/>Last PM','Actions');
	${"headings_" . "3"}		=   array('TS<br/>Number', 'Time<br/>Elapsed', 'City', 'Customer', 'Equipment', 'Serial<br/>Number', 'Average PM<br/>Frequency', 'Days Since<br/>Last PM','Actions');
	${"headings_" . "4"}		=   array('Leave<br/>Code', 'Explanation Call<br/>Status', 'Start<br/>Date', 'Leave<br/>Days', 'Reason<br/>of Leave', 'Official<br/>Comments', 'Back<br/>Up');
	${"headings_" . "5"}		=   array('Code', 'Amount', 'Date', 'Official<br/>Comments', 'Employee<br/>Comments', 'Status');
	

	
	if ($user_role=="Salesman") {
		${"headings_" . "0"}		=   array('City',  'Customer Name', 'Installed Equipment', 'Other Assigned SAP', 'Total Projects', 'Total Visits', 'Last Visit Date');
		${"headings_" . "1"}		=   array('City',  'Customer<br/>Name','Business<br/>Project','Project<br/>Details','Last Visit<br/>Date','Total<br/>Visits','Comments');
		${"headings_" . "2"}		=   array('City',  'Customer<br/>Name','Business<br/>Project','Project<br/>Details','Last Visit<br/>Date','Total<br/>Visits','Comments');
	}
	
		$active_projects_array = array();
	$ignored_projects_array = array();
	
	////////// for sap
	if ($user_role=="Salesman") {
		$this->db->query("SET SQL_BIG_SELECTS=1");
		$dbres = $this->db->query("SELECT 
								business_data.*, 
								COALESCE(tbl_cities.city_name) AS city_name,
								COALESCE(tbl_clients.client_name) AS client_name,
								COALESCE(tbl_area.area) AS area,
								COALESCE(user.first_name) AS first_name,
								COALESCE(s1.date) AS strategy_date,
								COALESCE(s1.target_date) AS target_date,
								COALESCE(s1.strategy) AS strategy,
								COALESCE(s1.tactics) AS tactics,
								COALESCE(s1.investment) AS investment,
								COALESCE(s1.sales_per_month) AS sales_per_month,
								MAX(tbl_dvr.date) AS dvr_date,
								COUNT(tbl_dvr.date) AS total_visits,
								COALESCE(tbl_business_types.businesstype_name) AS businesstype_name 
								
								FROM business_data 
								
								LEFT JOIN tbl_cities ON business_data.City = tbl_cities.pk_city_id 
								LEFT JOIN tbl_area ON business_data.Area = tbl_area.pk_area_id 
								LEFT JOIN tbl_clients ON business_data.Customer = tbl_clients.pk_client_id 
								LEFT JOIN user ON business_data.`Sales Person` = user.id 
								LEFT JOIN tbl_business_types ON business_data.`Business Project`  = tbl_business_types.pk_businesstype_id
								LEFT JOIN tbl_dvr ON business_data.pk_businessproject_id = tbl_dvr.fk_business_id
								LEFT JOIN (SELECT * from tbl_project_strategy WHERE strategy_status = 1) s1 ON business_data.pk_businessproject_id = s1.fk_project_id
								LEFT JOIN (SELECT * from tbl_project_strategy WHERE strategy_status = 1) s2 ON business_data.pk_businessproject_id = s2.fk_project_id AND s1.pk_project_strategy_id < s2.pk_project_strategy_id
			
			WHERE `Sales Person` = '".$user_id."' AND business_data.status='0' AND s2.pk_project_strategy_id IS NULL 
			GROUP BY pk_businessproject_id
			");
		$get_sap_projects=$dbres->result_array();
						
		foreach ($get_sap_projects as $my_business_data) {
				  $ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$my_business_data["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
				  if($ty->num_rows()>0) {
					  $rt=$ty->result_array();
					  $now 		 = time(); 
					  $your_date = strtotime($rt[0]["date"]);
					  $your_date2 = strtotime($rt[0]["date"]);
					  if ($dates_set=="yes") {
						  $now 		 = strtotime($end_date); 
						 $your_date2 = strtotime($start_date);
					  }
					  $datediff  = $now - $your_date;
					  $datediff2  = $now - $your_date2;
					  $mydiffrence = floor($datediff/(60*60*24));
					  $mydiffrence2 = floor($datediff2/(60*60*24));
					  $mydiffrence_comp = 30;
					  if ($dates_set=="yes") { $mydiffrence_comp = $mydiffrence2;}
					  if($mydiffrence>$mydiffrence_comp) {
						  array_push($ignored_projects_array,$my_business_data['pk_businessproject_id']);
					  }
					  else {
						  array_push($active_projects_array,$my_business_data['pk_businessproject_id']);
					  } 
				  }
				  else {
					  array_push($ignored_projects_array,$my_business_data['pk_businessproject_id']);
				  }
			}
	}
	
	$start_date_f			=	date('jS F Y',strtotime($start_date));
	$end_date_f				=	date('jS F Y',strtotime($end_date));
	$portlet_color			=	array("red-thunderbird","red-intense","blue-steel","blue-hoki","yellow-gold","yellow-zed");
	$portlet_title			=	array("Pending Calls - ".$start_date_f." to ".$end_date_f,"Old Pending Calls - Before ".$start_date_f,"Pending PMs - ".$start_date_f." to ".$end_date_f,"Old Pending PMs - Before ".$start_date_f,"Leaves Taken - ".$start_date_f." to ".$end_date_f,"Explanation Calls - ".$start_date_f." to ".$end_date_f);
	
	if ($user_role=="Salesman") {
		$portlet_title[0]	=	"Customers List";
		$portlet_title[1]	=	"Active Projects";
		$portlet_title[2]	=	"Ignored Projects";
		
		$portlet_color[0]	=	"blue-steel";
		$portlet_color[1]	=	"green";
		$portlet_color[2]	=	"red";
	}
	//echo "zaaid";
	$start = $month = strtotime($start_date);
	//$end = time();
	$end = strtotime($end_date);
while($month < $end)
{
    ////////////////// echo date('F Y', $month), PHP_EOL;
     $month = strtotime("+1 month", $month);
}
 ?>
		<?php for ($k=0; $k<=5; $k++) { if($user_role=="Salesman" && $k==3) continue; ?>
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bg-inverse<?php //echo $portlet_color[$k]; ?>">
            <div class="portlet-title">
              <div class="caption"> <i class="icon-pie-chart font-<?php echo $portlet_color[$k]; ?>"></i><span class="caption-subject bold font-<?php echo $portlet_color[$k]; ?> ">
								 <?php echo $portlet_title[$k]; ?> </span></div>
              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
			<?php if ($k==5) {  // Explanation Calls
				echo '<p class="alert alert-danger" style="font-size:16px;">NOTE: Please enter your comments against your explanation calls. If there are any pending explanation calls your salary will be put on hold.</p>';
			}
			?>
                <table class="table  table-hover dataaTable" id="">
					<thead class="<?php echo 'bg-'.$portlet_color[$k]; ?>">
					<tr>
					<?php  foreach (${"headings_" . $k} AS $tHead) echo '<th>'.$tHead.'</th>'; ?>
					</tr>
					</thead>
					<tbody>
					<?php if ($k==0 && $user_role=="Salesman") { // Assigned Customers
						$q		= "SELECT `tbl_customer_sap_bridge`.*,`tbl_cities`.city_name,`tbl_clients`.pk_client_id,`tbl_clients`.client_name,`tbl_area`.area,`tbl_offices`.pk_office_id
									FROM `tbl_customer_sap_bridge`
									LEFT JOIN tbl_clients ON `tbl_customer_sap_bridge`.fk_client_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_cities ON `tbl_clients`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
									LEFT JOIN tbl_offices ON `tbl_offices`.pk_office_id = `tbl_clients`.fk_office_id
									LEFT JOIN user ON `user`.id = `tbl_customer_sap_bridge`.fk_user_id
									WHERE `tbl_customer_sap_bridge`.fk_user_id = '".$user_id."' ";
						if ($dates_set=="yes") {
							//$temp_date = date('Y-m-d H:i:s',strtotime('2015-04-01 00:00:00'));
							//$q		.=	"AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ";
						}
						$q		.=	"ORDER BY pk_office_id,city_name,client_name ASC";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $pmc) {
							echo '<tr> ';
							
							echo '<td>'.$pmc['city_name'].'</td>';
							//echo '<td>'.$pmc['area'].'</td>';
							echo '<td>'.$pmc['client_name'].'</td>';
							
							// finding equipment
							$q2		= "SELECT `tbl_instruments`.serial_no,`tbl_products`.product_name
									FROM `tbl_instruments`
									LEFT JOIN tbl_products ON `tbl_instruments`.fk_product_id = `tbl_products`.pk_product_id
									WHERE `tbl_instruments`.fk_client_id = '".$pmc['pk_client_id']."' AND tbl_products.fk_type_id=1";
							$query2 	= $this->db->query($q2);
							$result2 = $query2->result_array();
							echo '<td>';
							foreach ($result2 AS $eq) echo $eq['product_name'].' ('.$eq['serial_no'].')<br/>';
							echo '</td>';
							///// finding Equipment End
							
							//// Other Assigned SAP Begin
							$qu		= "SELECT `tbl_customer_sap_bridge`.*,`user`.*
									FROM `tbl_customer_sap_bridge`
									JOIN user ON `user`.id = `tbl_customer_sap_bridge`.fk_user_id
									WHERE `tbl_customer_sap_bridge`.fk_user_id != '".$user_id."' AND fk_client_id='".$pmc['pk_client_id']."'";
							$qu 	= $this->db->query($qu);
							$qr		= $qu->result_array();
							echo '<td>';
								foreach ($qr AS $usr)
									echo $usr['first_name'].'<br/>';
							echo '</td>';
							///// Other Assigned SAP End
							
							/////////////// Total Projects Begin
							echo '<td>';
							$qu		= "SELECT *
									FROM `business_data`
									WHERE status=0 AND Customer='".$pmc['pk_client_id']."'";
							$qu 	= $this->db->query($qu);
							$qr		= $qu->result_array();
							echo zerodisplay(sizeof($qr));
							echo '</td>';
							///////////////// Total Projects END
							///// finding Total Visits to customer by this user
							$q2		= "SELECT DISTINCT date
									FROM `tbl_dvr`
									WHERE fk_customer_id = '".$pmc['pk_client_id']."' AND fk_engineer_id='".$user_id."' ";
							if ($dates_set=="yes") {
							//$temp_date = date('Y-m-d H:i:s',strtotime('2015-04-01 00:00:00'));
							$q2		.=	"AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ";
							}
							$query2 	= $this->db->query($q2);
							$result2 = $query2->result_array();
							echo '<td>'.zerodisplay(sizeof($result2)).'</td>';
							
							/////////////// Last Visit Date
							echo '<td>';
							$qu		= "SELECT *
									FROM `tbl_dvr`
									WHERE fk_customer_id='".$pmc['pk_client_id']."' AND fk_engineer_id='".$user_id."'
									ORDER BY DATE DESC";
							$qu 	= $this->db->query($qu);
							$qr		= $qu->result_array();
							if (sizeof($qr)>0) echo date('d-M-Y',strtotime($qr[0]['date']));
							echo '</td>';
							///////////////// Last VISIT Date
							
							echo '</tr> ';
						}
					}?>
					
					<?php if ($k==1 && $user_role=="Salesman") { // Active Projects
						
						foreach ($get_sap_projects as $my_business_data) {
						  if(in_array($my_business_data["pk_businessproject_id"],$active_projects_array))
						  {
						  ?>
						  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
						  <!--	<td><?php echo $my_business_data["office_name"]; ?></td>-->
								<td><?php echo $my_business_data["city_name"]; ?></td>
						<!--	<td><?php echo $my_business_data["area"]; ?></td>-->
								<td><?php echo $my_business_data["client_name"]; ?></td>
								<td><?php echo $my_business_data["businesstype_name"]; ?></td>
								<td><?php echo $my_business_data["Project Description"]; ?></td>
								<td><?php if($my_business_data["dvr_date"]!="") echo date('d-M-Y',strtotime($my_business_data["dvr_date"])); ?></td>
								<td><?php echo $my_business_data["total_visits"]; ?></td>
						<!--	<td><?php echo $my_business_data["Department"]; ?></td>-->
							  
							  <td><textarea rows="3"></textarea></td>
							  
						  </tr>
						  <?php
						  }
					  }
						
						
					}?>
					
					<?php if ($k==2 && $user_role=="Salesman") { // Ignored Projects
						foreach ($get_sap_projects as $my_business_data) {
						  if(in_array($my_business_data["pk_businessproject_id"],$ignored_projects_array))
						  {
						  ?>
						  <tr class="<?php if($my_business_data['priority']==1){ echo "danger even";} else { echo "odd gradeX";}?>">
						  <!--	<td><?php echo $my_business_data["office_name"]; ?></td>-->
								<td><?php echo $my_business_data["city_name"]; ?></td>
						<!--	<td><?php echo $my_business_data["area"]; ?></td>-->
								<td><?php echo $my_business_data["client_name"]; ?></td>
								<td><?php echo $my_business_data["businesstype_name"]; ?></td>
								<td><?php echo $my_business_data["Project Description"]; ?></td>
								<td><?php if($my_business_data["dvr_date"]!="") echo date('d-M-Y',strtotime($my_business_data["dvr_date"])); ?></td>
								<td><?php echo $my_business_data["total_visits"]; ?></td>
						<!--	<td><?php echo $my_business_data["Department"]; ?></td>-->
							  <td><textarea rows="3"></textarea></td>
						  </tr>
						  <?php
						  }
					  }
						
					}?>
					
					
					<?php if ($k==0 && ($user_role=="FSE" || $user_role=="Supervisor" )) { // Current Pending Calls
						$q		= "SELECT `tbl_complaints`.*,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
									FROM `tbl_complaints`
									LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
									LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
									LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
									WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status NOT IN ('Closed','Pending Verificationn','Pending SPRFF') AND assign_to = '".$user_id."' ";
						if ($dates_set=="yes") {
							$temp_date = date('Y-m-d H:i:s',strtotime('2015-04-01 00:00:00'));
							$q		.=	"AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ";
						}
						$q		.=	"ORDER BY 'date' ASC";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $pmc) {
							echo '<tr> ';
							echo '<td>'.$pmc['ts_number'].'</td>';
							//echo '<td>'.date('d-M-Y',strtotime($pmc['date'])).'</td>';
							echo '<td>'.Get_Date_Difference($pmc["date"],date('Y-m-d H:i:s')).'</td>';
							echo '<td>'.$pmc['city_name'].'</td>';
							echo '<td>'.$pmc['client_name'].'</td>';
							//echo '<td>'.$pmc['area'].'</td>';
							echo '<td>'.$pmc['product_name'].'</td>';
							echo '<td>'.$pmc['serial_no'].'</td>';
							echo '<td>'.urldecode($pmc['problem_summary']).'</td>';
							echo '<td>';
								$this->load->model("complaint_model");
								$obj=new Complaint_model();
								$obj->current_status($pmc['status']);
							echo '</td>';
							echo '<td>'; ?>
							<a class="btn btn-sm default purple-stripe" href="<?php echo base_url();?>sys/technical_service_pvr/<?php echo $pmc["pk_complaint_id"] ?>">
								TSR 
								<i class="fa fa-eye"></i>
							  </a>
						<?php
							echo '</td>';
							echo '</tr> ';
						}
					}?>
					
					<?php if ($k==1 && ($user_role=="FSE" || $user_role=="Supervisor" )) { // Old Pending Calls
						$q		= "SELECT `tbl_complaints`.*,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
									FROM `tbl_complaints`
									LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
									LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
									LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
									WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status NOT IN ('Closed','Pending Verificationn','Pending SPRFF') AND assign_to = '".$user_id."' ";
						if ($dates_set=="yes") {
							$temp_date = date('Y-m-d H:i:s',strtotime('2015-04-01 00:00:00'));
							$temp_date2= date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
							$q		.=	"AND `date` BETWEEN '".$temp_date."' AND '".$start_date."' ";
						}
						$q		.=	"ORDER BY 'date' ASC";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $pmc) {
							echo '<tr> ';
							echo '<td>'.$pmc['ts_number'].'</td>';
							//echo '<td>'.date('d-M-Y',strtotime($pmc['date'])).'</td>';
							echo '<td>'.Get_Date_Difference($pmc["date"],date('Y-m-d H:i:s')).'</td>'; //echo Get_Date_Difference($get_users_list["date_of_joining"],$get_users_list["termination_date"]);
							echo '<td>'.$pmc['city_name'].'</td>';
							echo '<td>'.$pmc['client_name'].'</td>';
							//echo '<td>'.$pmc['area'].'</td>';
							echo '<td>'.$pmc['product_name'].'</td>';
							echo '<td>'.$pmc['serial_no'].'</td>';
							echo '<td>'.urldecode($pmc['problem_summary']).'</td>';
							echo '<td>';
								$this->load->model("complaint_model");
								$obj=new Complaint_model();
								$obj->current_status($pmc['status']);
							echo '</td>';
							echo '<td>'; ?>
							<a class="btn btn-sm default purple-stripe" href="<?php echo base_url();?>sys/technical_service_pvr/<?php echo $pmc["pk_complaint_id"] ?>">
								TSR 
								<i class="fa fa-eye"></i>
							  </a>
						<?php
							echo '</td>';
							echo '</tr> ';
						}
					}?>
					
					<?php if ($k==2 && ($user_role=="FSE" || $user_role=="Supervisor" )) { // Current Pending PMs
						$q		= "SELECT `tbl_complaints`.*,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no
									FROM `tbl_complaints`
									LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
									LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
									WHERE `tbl_complaints`.complaint_nature='PM' AND `tbl_complaints`.status='Pending' AND assign_to = '".$user_id."' ";
						if ($dates_set=="yes") {
							$temp_date = date('Y-m-d H:i:s',strtotime('2015-04-01 00:00:00'));
							$q		.=	"AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ";
						}
						$q		.=	"ORDER BY 'date' ASC";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $pmc) {
							echo '<tr> ';
							echo '<td>'.$pmc['ts_number'].'</td>';
							echo '<td>'.Get_Date_Difference($pmc["date"],date('Y-m-d H:i:s')).'</td>';
							echo '<td>'.$pmc['city_name'].'</td>';
							echo '<td>'.$pmc['client_name'].'</td>';
							echo '<td>'.$pmc['product_name'].'</td>';
							echo '<td>'.$pmc['serial_no'].'</td>';
							
							/// Code for Average PM Frequency and Days since last PM
							echo '<td>';
							$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$pmc['fk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
							$rtz	= 	$tyz->result_array();
							$total_pms_c	=	sizeof($rtz);
							
							if ($total_pms_c > 1 )
									{
                              		//$ty4	=	$this->db->query("select * from user where id='".$rtz[0]['assign_to']."'");
                    				//$rt4	=	$ty4->result_array();
									//echo $rt4[0]['first_name'];
									
									$max_pms_index		=	$total_pms_c - 1;
									$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
									$last_pm			=	strtotime($rtz[0]['finish_time']);
								//$current_date		=	time();
									$diff				=	$last_pm - $first_pm;
								//$interval		= 	$difference->format(%a);
									$total_days			=	floor($diff/(60*60*24));
									$pm_frequency		=	$total_days/$max_pms_index;
									echo	$pm_frequency . " days";
									}
									elseif ($total_pms_c == 1 )
									{
										$current_date		=	time();
										$last_pm			=	strtotime($rtz[0]['finish_time']);
										$diff				=	$current_date - $last_pm;
										$total_days			=	floor($diff/(60*60*24));
										//echo $total_days . " day(s)";
										echo "N/A";
										
									}
									else echo "N/A";
									
							echo '</td>';
							// Code for Days since last PM
							echo '<td>';
							$interval = 0;
							$tyza	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$pmc['fk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC LIMIT 1");
							$rtza	= 	$tyza->result_array(); 
							$days_since_pm	=	'';
							if (!empty($rtza)){
								$last_pm_date	=	strtotime($rtza[0]['finish_time']);
								$current_date	=	time();
								$difference		=	$current_date - $last_pm_date;
								//$interval		= 	$difference->format(%a);
								$interval		=	floor($difference/(60*60*24));
							}
							if (!empty($rtza))
									echo $interval . " day(s)";
								else
									echo "N/A";
							echo '</td>';
							
							echo '<td>'; ?>
							<a class="btn btn-sm default purple-stripe" href="<?php echo base_url();?>sys/pm_form/<?php echo $pmc["pk_complaint_id"] ?>">
								PM Form 
								<i class="fa fa-eye"></i>
							  </a>
						<?php
							echo '</td>';
							echo '</tr> ';
						}
					}?>
					
					<?php if ($k==3 && ($user_role=="FSE" || $user_role=="Supervisor" )) { // Old Pending PMs
						$q		= "SELECT `tbl_complaints`.*,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no
									FROM `tbl_complaints`
									LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
									LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
									WHERE `tbl_complaints`.complaint_nature='PM' AND `tbl_complaints`.status='Pending' AND assign_to = '".$user_id."' ";
						if ($dates_set=="yes") {
							$temp_date = date('Y-m-d H:i:s',strtotime('2015-04-01 00:00:00'));
							$temp_date2= date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
							$q		.=	"AND `date` BETWEEN '".$temp_date."' AND '".$start_date."' ";
						}
						$q		.=	"ORDER BY 'date' ASC";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $pmc) {
							echo '<tr> ';
							echo '<td>'.$pmc['ts_number'].'</td>';
							echo '<td>'.Get_Date_Difference($pmc["date"],date('Y-m-d H:i:s')).'</td>';
							echo '<td>'.$pmc['city_name'].'</td>';
							echo '<td>'.$pmc['client_name'].'</td>';
							echo '<td>'.$pmc['product_name'].'</td>';
							echo '<td>'.$pmc['serial_no'].'</td>';
							
							/// Code for Average PM Frequency and Days since last PM
							echo '<td>';
							$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$pmc['fk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
							$rtz	= 	$tyz->result_array();
							$total_pms_c	=	sizeof($rtz);
							
							if ($total_pms_c > 1 )
									{
                              		//$ty4	=	$this->db->query("select * from user where id='".$rtz[0]['assign_to']."'");
                    				//$rt4	=	$ty4->result_array();
									//echo $rt4[0]['first_name'];
									
									$max_pms_index		=	$total_pms_c - 1;
									$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
									$last_pm			=	strtotime($rtz[0]['finish_time']);
								//$current_date		=	time();
									$diff				=	$last_pm - $first_pm;
								//$interval		= 	$difference->format(%a);
									$total_days			=	floor($diff/(60*60*24));
									$pm_frequency		=	$total_days/$max_pms_index;
									echo	$pm_frequency . " days";
									}
									elseif ($total_pms_c == 1 )
									{
										$current_date		=	time();
										$last_pm			=	strtotime($rtz[0]['finish_time']);
										$diff				=	$current_date - $last_pm;
										$total_days			=	floor($diff/(60*60*24));
										//echo $total_days . " day(s)";
										echo "N/A";
										
									}
									else echo "N/A";
									
							echo '</td>';
							// Code for Days since last PM
							echo '<td>';
							$interval = 0;
							$tyza	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$pmc['fk_instrument_id']."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC LIMIT 1");
							$rtza	= 	$tyza->result_array(); 
							$days_since_pm	=	'';
							if (!empty($rtza)){
								$last_pm_date	=	strtotime($rtza[0]['finish_time']);
								$current_date	=	time();
								$difference		=	$current_date - $last_pm_date;
								//$interval		= 	$difference->format(%a);
								$interval		=	floor($difference/(60*60*24));
							}
							if (!empty($rtza))
									echo $interval . " day(s)";
								else
									echo "N/A";
							echo '</td>';
							echo '<td>'; ?>
							<a class="btn btn-sm default purple-stripe" href="<?php echo base_url();?>sys/pm_form/<?php echo $pmc["pk_complaint_id"] ?>">
								PM Form 
								<i class="fa fa-eye"></i>
							  </a>
						<?php
							echo '</td>';
							echo '</tr> ';
						}
					}?>
					<?php if ($k==5) { //// FINEs Table
						
						$q		= "SELECT `tbl_fine`.*,`tbl_fine_code`.description
									FROM `tbl_fine`
									LEFT JOIN tbl_fine_code ON `tbl_fine`.fk_fine_code_id = `tbl_fine_code`.pk_fine_code_id
									WHERE fk_employee_id = '".$user_id."' ";
						if ($dates_set=="yes")
							$q		.=	"AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ";
						$q		.=	"ORDER BY 'date' ASC";
						$query 	= $this->db->query($q);
						$result = $query->result_array(); 
						
						foreach ($result AS $fine) {
							echo '<tr> ';
							echo '<td>'.$fine['description'].'</td>';
							echo '<td>'.$fine['amount'].'</td>';
							echo '<td>'.date('d-M-Y',strtotime($fine['date'])).'</td>';
							echo '<td>'.urldecode($fine['comments']).'</td>';
							echo '<td>'.urldecode($fine['comments_employee']).'</td>';
							echo '<td>'.urldecode($fine['status']).'</td>';
							echo '</tr> ';
						}
					} ?>
					
					
					<?php if ($k==4) { // LEaves Table
						
						$q		= "SELECT *
									FROM `tbl_leaves`
									WHERE fk_employee_id = '".$user_id."' ";
						if ($dates_set=="yes")
							$q		.=	"AND CAST(`application_date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ";
						$q		.=	"ORDER BY 'application_date' ASC";
						$query 	= $this->db->query($q);
						$result = $query->result_array(); 
						
						foreach ($result AS $leave) {
							echo '<tr> ';
							?>
							
							<?php 			echo '<td>'; // fine code
											 if($leave["fk_fine_code"]!='Leave is taken within limit of 21 days')
											 {
												$ty44=$this->db->query("select * from tbl_fine_code where pk_fine_code_id =  '".$leave["fk_fine_code"]."'");
												$rt44=$ty44->result_array();
												echo substr($rt44[0]["description"], 0, 80);
											 }
											 else
											 {
												 echo 'Leave is taken within limit of 21 days';
											 }
											 echo '</td>';
							?>
							
							
							
                                            <?php echo '<td>';//fine status
											if($leave["fk_fine_id"]!=0)
											 {
												$ty44=$this->db->query("select * from tbl_fine where pk_fine_id =  '".$leave["fk_fine_id"]."'");
												$rt44=$ty44->result_array();
												echo $rt44[0]["status"];
											 }
											 else
											 {
												 echo 'N/A';
											 }
											echo '</td>';
											?>
                             
							<td style="padding:10px !important;">  <!-- Start Date -->
                                            <?php echo date('d-M-Y', strtotime($leave["start_date"]));?>
                                        </td>
										
                                        <td style="padding:10px !important;">  <!-- Days -->
                                            <?php
                                                if($leave["leave_type"]=='1')
												{
													echo 'Half Day';
												}
												else
												{
													
													$datediff  		 = strtotime($leave["end_date"]) - strtotime($leave["start_date"]);
													$mydiffrence 		 = floor($datediff/(60*60*24)) + 1;
													///////////////// New Code /////////////////
													
													$sd = strtotime($leave["start_date"]);//strtotime('2012-08-06');
													$ed = strtotime($leave["end_date"]);//strtotime('2012-09-06');

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
                                            <?php echo urldecode($leave["reason_of_leave"]);?>
                                        </td>
										<td style="padding:10px !important;">  <!-- Official Comments -->
                                            <?php echo urldecode($leave["official_comments"]);?>
                                        </td>
                                        <td style="padding:10px !important;">  <!-- Back Up -->
                                            <?php echo $leave["back_up"];?>			
										
							<?php
							echo '</tr> ';
						}
					} ?>
					
					
						 
					</tbody>
              </table>
            </div>
          </div>
		
          
        <?php } ?>  <!-- END EXAMPLE TABLE PORTLET--> 
        
		
		<!-- Comments Form -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Comments </span>
								<span class="caption-helper">Enter your comments in the given field</span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                                <div class="col-md-12">
									<div class="form-group">
										<div class="col-md-12">
										   <textarea  rows="5"></textarea>
										   
									</div>
                                </div>
                           </div>	
							
						</div>
					</div>
		<!-- Comments Form -->
		
		
		</div>
      </div>
     
<?php } // End check if Admin or Secratery ?>	 
	 </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>

<script>
$(document).ready(function() { 
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 100,
	  'bSort':true,
	  'aaSorting': [] 
	});
	
	//new $.fn.dataTable.FixedColumns( table );
});
</script>


<style>
textarea {
  width: 100%;
}
</style>