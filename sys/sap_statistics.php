<?php $this->load->view('header');
 
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
		$c =  array_intersect(explode(',',$maxval[0]['fk_office_id']), explode(',',$this->session->userdata('territory')));
		if ($maxval[0]['userrole']=='FSE' && sizeof($c)==0) show_404();
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
						 
						  AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$')
						  OR `outstation` = '1' 
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
							  AND  `fk_customer_id` REGEXP  '^[0-9]+\\.?[0-9]*$')
							  OR `outstation` = '1' 
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
                    SAP Statistics  <?php //echo $user_name; ?>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                SAP Statistics
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
       <!-- BEGIN PAGE CONTENT-->
       <div class="row" >

        <div class="col-md-12"> 
<?php if ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery' ){ ?>		
		<!-- Search Form -->
		<div class="portlet light bg-inverse" style="display:none;">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								SAP Statistics </span>
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
												$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status = '0' AND userrole='FSE' AND FIND_IN_SET_X('".$this->session->userdata('territory')."',fk_office_id) ORDER BY  `fk_office_id` ,  `userrole` ASC ");
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
		<div class="portlet light bg-inverse" style="display:none">
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
						        <div class="row" style="display:none;">
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
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>