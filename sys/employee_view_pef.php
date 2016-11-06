<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title"> PEF <small>View</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li>
              <i class="fa fa-home"></i>
              Home 
              <i class="fa fa-angle-right"></i>
          </li>
          <li>
              PEF
          </li> 

        </ul>

        <div class="page-toolbar">

          

        </div>

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12"> 

          <!-- BEGIN EXAMPLE TABLE PORTLET-->

          <div class="portlet box grey-cascade">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Managed Table </div>

              <div class="tools"> 
              	 <a href="javascript:;" class="collapse"> </a>
                 
                 <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
              <div class="table-toolbar">
              </div>
            <div class="portlet-body flip-scroll">
             <table class="table table-striped table-bordered table-hover flip-content">

                <thead>
				
                  <tr>
                    <th> Employee Name </th>
                  
                    <th> Last PEF Date </th>
                    
                    <th> PEF Final Marks </th>

                    <th> Next PEF Due Date</th>
                    
                    <th> Status </th>
                    
                    <th> Open Form </th>
                  </tr>
				
                </thead>

                <tbody>
				<?php
					//
				  /*$rty="select * from user where id='".$this->session->userdata('userid')."' AND id IN ( ";
				  $ee = explode(',', $result3[0]['user_ids']);
					$n=0;
					foreach($ee as $pp)
					{
						$n++;
					}
					$n2=0;					

					foreach($ee as $ss)
					{
						if($n-1 > $n2)
						{
							$rty.="$ss, ";
							$n2++;
						}
						else
						{
							$rty.="$ss";
						}
					}
					$rty.=")";*/
				  $rty="select * from user where id='".$this->session->userdata('userid')."'";
				  $myquery=$this->db->query($rty);
				  $result=$myquery->result_array();
				  
				  if($result[0]['userrole']=="FSE" || $result[0]['userrole']=="Salesman")
				  {
				?>
                  <tr class="odd gradeX">
                  
                    <td> <?php echo $result[0]['first_name'];?> </td>

                    <td> <?php //echo date('d-M-Y', strtotime($result3[1]['due_date']));?>
                    <?php 
					  			$rty3="select * from tbl_pef_schedule where due_date != '".$result[0]['pef_expriy_date']."' order by pk_pef_schedule_id DESC ";
								$myquery3=$this->db->query($rty3);
								$result3=$myquery3->result_array();
								//
								foreach($result3 as $sechdule_entries)
								{
									$userids= explode(',', $sechdule_entries['user_ids']);
									//echo $sechdule_entries['pk_pef_schedule_id'];exit;
									if( in_array($result[0]['id'], $userids))
									{
										echo date('d-M-Y', strtotime($sechdule_entries['due_date']));
										$my_schedule_id = $sechdule_entries['pk_pef_schedule_id'];
										break;
									}
								}
								$rty3="select * from tbl_pef_schedule where due_date = '".$result[0]['pef_expriy_date']."'";
								$myquery3=$this->db->query($rty3);
								$result3=$myquery3->result_array();
								//
								
						   ?> 
                     </td>
                    <?php
                    	// for Engineer
						$enginerr_pef=" select * from tbl_pef where fk_engineer_id='".$this->session->userdata['userid']."' and schedule_id='".$result3[0]['pk_pef_schedule_id']."' 
						AND evaluater_role IN ( 'FSE', 'Salesman')";
						$enginerr_pef_query=$this->db->query($enginerr_pef);
						$enginerr_pef_num_rows=$enginerr_pef_query->num_rows();
						// for Supervisor
						$supervisor_pef=" select * from tbl_pef where fk_engineer_id='".$this->session->userdata['userid']."' and schedule_id='".$result3[0]['pk_pef_schedule_id']."' 
						AND evaluater_role='Supervisor'";
						$supervisor_pef_query=$this->db->query($supervisor_pef);
						$supervisor_pef_num_rows=$supervisor_pef_query->num_rows();
						// for admin
						$admin_pef=" select * from tbl_pef where fk_engineer_id='".$this->session->userdata['userid']."' and schedule_id='".$result3[0]['pk_pef_schedule_id']."' 
						AND evaluater_role='Admin'";
						$admin_pef_query=$this->db->query($admin_pef);
						$admin_pef_num_rows=$admin_pef_query->num_rows();
						//initialize varibles
						$pef_final_marks_enginerr=0;
						$pef_final_marks_supervisor=0;
						$pef_final_marks_admin=0;
						if($enginerr_pef_num_rows=='0' || $supervisor_pef_num_rows=='0' || $admin_pef_num_rows=='0')
						{
							$pef_final_marks="Not filled";
						}
						else
						{
							if($enginerr_pef_num_rows!='0')
							{
							$enginerr_pef_result=$enginerr_pef_query->result_array();
							$pef_final_marks_enginerr	=	$enginerr_pef_result[0]['know_AP_SOP'] + $enginerr_pef_result[0]['complies_change_SOAP_adaptation'] + $enginerr_pef_result[0]['write_dailyvisitreport'] + $enginerr_pef_result[0]['comuniation_with_manager'] + $enginerr_pef_result[0]['regular_meeting_with_subordinate'] + $enginerr_pef_result[0]['response_to_questions'] + $enginerr_pef_result[0]['response_to_calls'] + $enginerr_pef_result[0]['intiat_without_direction'] + $enginerr_pef_result[0]['proiritize_own_assignments'] + $enginerr_pef_result[0]['attendence_and_punctuality'] + $enginerr_pef_result[0]['meet_deadlines_of_projects'] + $enginerr_pef_result[0]['attend_meetings'] + $enginerr_pef_result[0]['submetting_of_forms'] + $enginerr_pef_result[0]['timely_submission_of_ALS'] + $enginerr_pef_result[0]['value_commitment_with_company'] + $enginerr_pef_result[0]['offer_assistance_and_cooperate'] + $enginerr_pef_result[0]['contribut_built_userfriendly_envirnment'] + $enginerr_pef_result[0]['facilitate_group_discusion'] + $enginerr_pef_result[0]['follow_leadership_appropriately'] + $enginerr_pef_result[0]['lead_example_for_colleague'] + $enginerr_pef_result[0]['able_to_coach_train_mentor'] + $enginerr_pef_result[0]['has_ability_to_get_job_done'] + $enginerr_pef_result[0]['motivate_towords_company_goals'] + $enginerr_pef_result[0]['utilize_ALS_PM_foam'] + $enginerr_pef_result[0]['adapt_new_methods'] + $enginerr_pef_result[0]['keep_documents_ready'] + $enginerr_pef_result[0]['follow_department_procedures'] + $enginerr_pef_result[0]['take_responsibility_for_results'] + $enginerr_pef_result[0]['finish_task_without_repetition'] + $enginerr_pef_result[0]['monitor_own_work'] + $enginerr_pef_result[0]['prioritize_work_activities'] + $enginerr_pef_result[0]['write_visit_schedule'] + $enginerr_pef_result[0]['adapt_to_changes'] + $enginerr_pef_result[0]['schedule_appointment_with_customer'] + $enginerr_pef_result[0]['build_approches_from_experience'] + $enginerr_pef_result[0]['press_beyond_the_surface'] + $enginerr_pef_result[0]['research_new_methods_for_improvment'] + $enginerr_pef_result[0]['is_willing_to_learn_new_skills'] + $enginerr_pef_result[0]['evaluate_problems_quickly'] + $enginerr_pef_result[0]['fully_complete_assigned_projects'] + $enginerr_pef_result[0]['meet_expectation'] + $enginerr_pef_result[0]['ensure_work_responsibility'] + $enginerr_pef_result[0]['perform_duty_acurately'] + $enginerr_pef_result[0]['protect_confidential_info'] + $enginerr_pef_result[0]['bring_notice_harmful_information'];
							}
							if($supervisor_pef_num_rows!='0')
							{
							//calculation for supervisor sum
							$supervisor_pef_result=$supervisor_pef_query->result_array();
							$pef_final_marks_supervisor	=	$supervisor_pef_result[0]['know_AP_SOP'] + $supervisor_pef_result[0]['complies_change_SOAP_adaptation'] + $supervisor_pef_result[0]['write_dailyvisitreport'] + $supervisor_pef_result[0]['comuniation_with_manager'] + $supervisor_pef_result[0]['regular_meeting_with_subordinate'] + $supervisor_pef_result[0]['response_to_questions'] + $supervisor_pef_result[0]['response_to_calls'] + $supervisor_pef_result[0]['intiat_without_direction'] + $supervisor_pef_result[0]['proiritize_own_assignments'] + $supervisor_pef_result[0]['attendence_and_punctuality'] + $supervisor_pef_result[0]['meet_deadlines_of_projects'] + $supervisor_pef_result[0]['attend_meetings'] + $supervisor_pef_result[0]['submetting_of_forms'] + $supervisor_pef_result[0]['timely_submission_of_ALS'] + $supervisor_pef_result[0]['value_commitment_with_company'] + $supervisor_pef_result[0]['offer_assistance_and_cooperate'] + $supervisor_pef_result[0]['contribut_built_userfriendly_envirnment'] + $supervisor_pef_result[0]['facilitate_group_discusion'] + $supervisor_pef_result[0]['follow_leadership_appropriately'] + $supervisor_pef_result[0]['lead_example_for_colleague'] + $supervisor_pef_result[0]['able_to_coach_train_mentor'] + $supervisor_pef_result[0]['has_ability_to_get_job_done'] + $supervisor_pef_result[0]['motivate_towords_company_goals'] + $supervisor_pef_result[0]['utilize_ALS_PM_foam'] + $supervisor_pef_result[0]['adapt_new_methods'] + $supervisor_pef_result[0]['keep_documents_ready'] + $supervisor_pef_result[0]['follow_department_procedures'] + $supervisor_pef_result[0]['take_responsibility_for_results'] + $supervisor_pef_result[0]['finish_task_without_repetition'] + $supervisor_pef_result[0]['monitor_own_work'] + $supervisor_pef_result[0]['prioritize_work_activities'] + $supervisor_pef_result[0]['write_visit_schedule'] + $supervisor_pef_result[0]['adapt_to_changes'] + $supervisor_pef_result[0]['schedule_appointment_with_customer'] + $supervisor_pef_result[0]['build_approches_from_experience'] + $supervisor_pef_result[0]['press_beyond_the_surface'] + $supervisor_pef_result[0]['research_new_methods_for_improvment'] + $supervisor_pef_result[0]['is_willing_to_learn_new_skills'] + $supervisor_pef_result[0]['evaluate_problems_quickly'] + $supervisor_pef_result[0]['fully_complete_assigned_projects'] + $supervisor_pef_result[0]['meet_expectation'] + $supervisor_pef_result[0]['ensure_work_responsibility'] + $supervisor_pef_result[0]['perform_duty_acurately'] + $supervisor_pef_result[0]['protect_confidential_info'] + $supervisor_pef_result[0]['bring_notice_harmful_information'];
							}
							if($admin_pef_num_rows!='0')
							{
							//calculation for Admin sum
							$admin_pef_result=$admin_pef_query->result_array();
							$pef_final_marks_admin	=	$admin_pef_result[0]['know_AP_SOP'] + $admin_pef_result[0]['complies_change_SOAP_adaptation'] + $admin_pef_result[0]['write_dailyvisitreport'] + $admin_pef_result[0]['comuniation_with_manager'] + $admin_pef_result[0]['regular_meeting_with_subordinate'] + $admin_pef_result[0]['response_to_questions'] + $admin_pef_result[0]['response_to_calls'] + $admin_pef_result[0]['intiat_without_direction'] + $admin_pef_result[0]['proiritize_own_assignments'] + $admin_pef_result[0]['attendence_and_punctuality'] + $admin_pef_result[0]['meet_deadlines_of_projects'] + $admin_pef_result[0]['attend_meetings'] + $admin_pef_result[0]['submetting_of_forms'] + $admin_pef_result[0]['timely_submission_of_ALS'] + $admin_pef_result[0]['value_commitment_with_company'] + $admin_pef_result[0]['offer_assistance_and_cooperate'] + $admin_pef_result[0]['contribut_built_userfriendly_envirnment'] + $admin_pef_result[0]['facilitate_group_discusion'] + $admin_pef_result[0]['follow_leadership_appropriately'] + $admin_pef_result[0]['lead_example_for_colleague'] + $admin_pef_result[0]['able_to_coach_train_mentor'] + $admin_pef_result[0]['has_ability_to_get_job_done'] + $admin_pef_result[0]['motivate_towords_company_goals'] + $admin_pef_result[0]['utilize_ALS_PM_foam'] + $admin_pef_result[0]['adapt_new_methods'] + $admin_pef_result[0]['keep_documents_ready'] + $admin_pef_result[0]['follow_department_procedures'] + $admin_pef_result[0]['take_responsibility_for_results'] + $admin_pef_result[0]['finish_task_without_repetition'] + $admin_pef_result[0]['monitor_own_work'] + $admin_pef_result[0]['prioritize_work_activities'] + $admin_pef_result[0]['write_visit_schedule'] + $admin_pef_result[0]['adapt_to_changes'] + $admin_pef_result[0]['schedule_appointment_with_customer'] + $admin_pef_result[0]['build_approches_from_experience'] + $admin_pef_result[0]['press_beyond_the_surface'] + $admin_pef_result[0]['research_new_methods_for_improvment'] + $admin_pef_result[0]['is_willing_to_learn_new_skills'] + $admin_pef_result[0]['evaluate_problems_quickly'] + $admin_pef_result[0]['fully_complete_assigned_projects'] + $admin_pef_result[0]['meet_expectation'] + $admin_pef_result[0]['ensure_work_responsibility'] + $admin_pef_result[0]['perform_duty_acurately'] + $admin_pef_result[0]['protect_confidential_info'] + $admin_pef_result[0]['bring_notice_harmful_information'];
							}
							$pef_final_marks_total=$pef_final_marks_enginerr+$pef_final_marks_supervisor+$pef_final_marks_admin;
							$pef_final_marks = round($pef_final_marks_total/675*100,2);
							$pef_final_marks=$pef_final_marks.'%';
						}
					?>
                    <td> <?php echo $pef_final_marks;?> </td>
                   
                    <td> <?php //echo date('d-M-Y', strtotime($result3[0]['due_date']));?>
                    	 <?php echo date('d-M-Y', strtotime($result[0]['pef_expriy_date']));?>
                     </td>
                    
                    <td>
						<?php if($enginerr_pef_num_rows=='0' && $supervisor_pef_num_rows=='0' && $admin_pef_num_rows=='0'){?><span class="label label-sm label-danger"> Pending for SAP/FSE </span><?php }?>
                        <?php if($enginerr_pef_num_rows=='1' && $supervisor_pef_num_rows=='0' && $admin_pef_num_rows=='0'){?><span class="label label-sm label-info"> Pending for Supervisor </span><?php }?>
                        <?php if($enginerr_pef_num_rows=='1' && $supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='0'){?><span class="label label-sm label-warning"> Pending for Director </span><?php }?>
                        <?php if($enginerr_pef_num_rows=='1' && $supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='1'){?><span class="label label-sm label-success"> Completed  </span><?php }?>
                    </td>
					<?php
                            	$schedule=" select * from tbl_pef_schedule where due_date='".$result[0]['pef_expriy_date']."'";
								$schedule2=$this->db->query($schedule);
								$schedule3= $schedule2->result_array();
								//echo $schedule3[0]['pk_pef_schedule_id'];
							?>
                    <td> <a href="<?php echo base_url();?>sys/pef_employee/<?php echo $result[0]['id'];?>/<?php echo $schedule3[0]['pk_pef_schedule_id']?>/<?php echo $result[0]['userrole']?>/<?php echo  $result[0]['id']?>" class="btn btn-default">PEF Form</a> </td>

                  </tr>
          <?php }
		  
		  
		  
		  
		  
		  
		  
				  else if($result[0]['userrole']=="Supervisor")
				  {
					  $rty="select * from user where FIND_IN_SET_X('".$result[0]['fk_office_id']."',fk_office_id) AND userrole IN ( 'FSE', 'Salesman')
					   OR id= '".$this->session->userdata('userid')."' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
					  /* $rty.= " And id IN (";
					$ee = explode(',', $result3[0]['user_ids']);
					  $n=0;
					  foreach($ee as $pp)
					  {
						  $n++;
					  }
					  $n2=0;					
  
					  foreach($ee as $ss)
					  {
						  if($n-1 > $n2)
						  {
							  $rty.="$ss, ";
							  $n2++;
						  }
						  else
						  {
							  $rty.="$ss";
						  }
					  }
					  $rty.=")";*/
					$myquery=$this->db->query($rty);
					   
					  //echo $rty;
					  $myquery2=$this->db->query($rty);
					  $result2=$myquery2->result_array();
					  foreach($result2 as $engineer)
					  {
					  ?>
					  <tr class="odd gradeX">
					
					  <td> <?php echo $engineer['first_name'];?> </td>
  
					  <td> <?php //echo date('d-M-Y', strtotime($result3[1]['due_date']));?> 
                      <?php 
					  			$rty3="select * from tbl_pef_schedule where due_date != '".$engineer['pef_expriy_date']."' order by pk_pef_schedule_id DESC ";
								$myquery3=$this->db->query($rty3);
								$result3=$myquery3->result_array();
								//
								foreach($result3 as $sechdule_entries)
								{
									$userids= explode(',', $sechdule_entries['user_ids']);
									//echo $sechdule_entries['pk_pef_schedule_id'];exit;
									if( in_array($engineer['id'], $userids))
									{
										echo date('d-M-Y', strtotime($sechdule_entries['due_date']));
										break;
									}
								}
								$rty3="select * from tbl_pef_schedule where due_date = '".$engineer['pef_expriy_date']."'";
								$myquery3=$this->db->query($rty3);
								$result3=$myquery3->result_array();
						   ?> 
                      </td>
					  
					  <?php
						  // for Engineer
						  $enginerr_pef=" select * from tbl_pef where fk_engineer_id='".$engineer['id']."' and schedule_id='".$result3[0]['pk_pef_schedule_id']."' 
						   AND evaluater_role IN ( 'FSE', 'Salesman')";
						  $enginerr_pef_query=$this->db->query($enginerr_pef);
						  $enginerr_pef_num_rows=$enginerr_pef_query->num_rows();
						  // for Supervisor
						  $supervisor_pef=" select * from tbl_pef where fk_engineer_id='".$engineer['id']."' and schedule_id='".$result3[0]['pk_pef_schedule_id']."' 
						  AND evaluater_role='Supervisor'";
						  $supervisor_pef_query=$this->db->query($supervisor_pef);
						  $supervisor_pef_num_rows=$supervisor_pef_query->num_rows();
						  // for admin
						  $admin_pef=" select * from tbl_pef where fk_engineer_id='".$engineer['id']."' and schedule_id='".$result3[0]['pk_pef_schedule_id']."' 
						  AND evaluater_role='Admin'";
						  $admin_pef_query=$this->db->query($admin_pef);
						  $admin_pef_num_rows=$admin_pef_query->num_rows();
						  //initialize varibles
						  $pef_final_marks_enginerr=0;
						  $pef_final_marks_supervisor=0;
						  $pef_final_marks_admin=0;
						  if($enginerr_pef_num_rows=='0' || $supervisor_pef_num_rows=='0' || $admin_pef_num_rows=='0')
						  {
							  $pef_final_marks="Not filled";
						  }
						  else
						  {
							  if($enginerr_pef_num_rows!='0')
							  {
							  $enginerr_pef_result=$enginerr_pef_query->result_array();
							  $pef_final_marks_enginerr	=	$enginerr_pef_result[0]['know_AP_SOP'] + $enginerr_pef_result[0]['complies_change_SOAP_adaptation'] + $enginerr_pef_result[0]['write_dailyvisitreport'] + $enginerr_pef_result[0]['comuniation_with_manager'] + $enginerr_pef_result[0]['regular_meeting_with_subordinate'] + $enginerr_pef_result[0]['response_to_questions'] + $enginerr_pef_result[0]['response_to_calls'] + $enginerr_pef_result[0]['intiat_without_direction'] + $enginerr_pef_result[0]['proiritize_own_assignments'] + $enginerr_pef_result[0]['attendence_and_punctuality'] + $enginerr_pef_result[0]['meet_deadlines_of_projects'] + $enginerr_pef_result[0]['attend_meetings'] + $enginerr_pef_result[0]['submetting_of_forms'] + $enginerr_pef_result[0]['timely_submission_of_ALS'] + $enginerr_pef_result[0]['value_commitment_with_company'] + $enginerr_pef_result[0]['offer_assistance_and_cooperate'] + $enginerr_pef_result[0]['contribut_built_userfriendly_envirnment'] + $enginerr_pef_result[0]['facilitate_group_discusion'] + $enginerr_pef_result[0]['follow_leadership_appropriately'] + $enginerr_pef_result[0]['lead_example_for_colleague'] + $enginerr_pef_result[0]['able_to_coach_train_mentor'] + $enginerr_pef_result[0]['has_ability_to_get_job_done'] + $enginerr_pef_result[0]['motivate_towords_company_goals'] + $enginerr_pef_result[0]['utilize_ALS_PM_foam'] + $enginerr_pef_result[0]['adapt_new_methods'] + $enginerr_pef_result[0]['keep_documents_ready'] + $enginerr_pef_result[0]['follow_department_procedures'] + $enginerr_pef_result[0]['take_responsibility_for_results'] + $enginerr_pef_result[0]['finish_task_without_repetition'] + $enginerr_pef_result[0]['monitor_own_work'] + $enginerr_pef_result[0]['prioritize_work_activities'] + $enginerr_pef_result[0]['write_visit_schedule'] + $enginerr_pef_result[0]['adapt_to_changes'] + $enginerr_pef_result[0]['schedule_appointment_with_customer'] + $enginerr_pef_result[0]['build_approches_from_experience'] + $enginerr_pef_result[0]['press_beyond_the_surface'] + $enginerr_pef_result[0]['research_new_methods_for_improvment'] + $enginerr_pef_result[0]['is_willing_to_learn_new_skills'] + $enginerr_pef_result[0]['evaluate_problems_quickly'] + $enginerr_pef_result[0]['fully_complete_assigned_projects'] + $enginerr_pef_result[0]['meet_expectation'] + $enginerr_pef_result[0]['ensure_work_responsibility'] + $enginerr_pef_result[0]['perform_duty_acurately'] + $enginerr_pef_result[0]['protect_confidential_info'] + $enginerr_pef_result[0]['bring_notice_harmful_information'];
							  }
							  if($supervisor_pef_num_rows!='0')
							  {
							  //calculation for supervisor sum
							  $supervisor_pef_result=$supervisor_pef_query->result_array();
							  $pef_final_marks_supervisor	=	$supervisor_pef_result[0]['know_AP_SOP'] + $supervisor_pef_result[0]['complies_change_SOAP_adaptation'] + $supervisor_pef_result[0]['write_dailyvisitreport'] + $supervisor_pef_result[0]['comuniation_with_manager'] + $supervisor_pef_result[0]['regular_meeting_with_subordinate'] + $supervisor_pef_result[0]['response_to_questions'] + $supervisor_pef_result[0]['response_to_calls'] + $supervisor_pef_result[0]['intiat_without_direction'] + $supervisor_pef_result[0]['proiritize_own_assignments'] + $supervisor_pef_result[0]['attendence_and_punctuality'] + $supervisor_pef_result[0]['meet_deadlines_of_projects'] + $supervisor_pef_result[0]['attend_meetings'] + $supervisor_pef_result[0]['submetting_of_forms'] + $supervisor_pef_result[0]['timely_submission_of_ALS'] + $supervisor_pef_result[0]['value_commitment_with_company'] + $supervisor_pef_result[0]['offer_assistance_and_cooperate'] + $supervisor_pef_result[0]['contribut_built_userfriendly_envirnment'] + $supervisor_pef_result[0]['facilitate_group_discusion'] + $supervisor_pef_result[0]['follow_leadership_appropriately'] + $supervisor_pef_result[0]['lead_example_for_colleague'] + $supervisor_pef_result[0]['able_to_coach_train_mentor'] + $supervisor_pef_result[0]['has_ability_to_get_job_done'] + $supervisor_pef_result[0]['motivate_towords_company_goals'] + $supervisor_pef_result[0]['utilize_ALS_PM_foam'] + $supervisor_pef_result[0]['adapt_new_methods'] + $supervisor_pef_result[0]['keep_documents_ready'] + $supervisor_pef_result[0]['follow_department_procedures'] + $supervisor_pef_result[0]['take_responsibility_for_results'] + $supervisor_pef_result[0]['finish_task_without_repetition'] + $supervisor_pef_result[0]['monitor_own_work'] + $supervisor_pef_result[0]['prioritize_work_activities'] + $supervisor_pef_result[0]['write_visit_schedule'] + $supervisor_pef_result[0]['adapt_to_changes'] + $supervisor_pef_result[0]['schedule_appointment_with_customer'] + $supervisor_pef_result[0]['build_approches_from_experience'] + $supervisor_pef_result[0]['press_beyond_the_surface'] + $supervisor_pef_result[0]['research_new_methods_for_improvment'] + $supervisor_pef_result[0]['is_willing_to_learn_new_skills'] + $supervisor_pef_result[0]['evaluate_problems_quickly'] + $supervisor_pef_result[0]['fully_complete_assigned_projects'] + $supervisor_pef_result[0]['meet_expectation'] + $supervisor_pef_result[0]['ensure_work_responsibility'] + $supervisor_pef_result[0]['perform_duty_acurately'] + $supervisor_pef_result[0]['protect_confidential_info'] + $supervisor_pef_result[0]['bring_notice_harmful_information'];
							  }
							  if($admin_pef_num_rows!='0')
							  {
							  //calculation for Admin sum
							  $admin_pef_result=$admin_pef_query->result_array();
							  $pef_final_marks_admin	=	$admin_pef_result[0]['know_AP_SOP'] + $admin_pef_result[0]['complies_change_SOAP_adaptation'] + $admin_pef_result[0]['write_dailyvisitreport'] + $admin_pef_result[0]['comuniation_with_manager'] + $admin_pef_result[0]['regular_meeting_with_subordinate'] + $admin_pef_result[0]['response_to_questions'] + $admin_pef_result[0]['response_to_calls'] + $admin_pef_result[0]['intiat_without_direction'] + $admin_pef_result[0]['proiritize_own_assignments'] + $admin_pef_result[0]['attendence_and_punctuality'] + $admin_pef_result[0]['meet_deadlines_of_projects'] + $admin_pef_result[0]['attend_meetings'] + $admin_pef_result[0]['submetting_of_forms'] + $admin_pef_result[0]['timely_submission_of_ALS'] + $admin_pef_result[0]['value_commitment_with_company'] + $admin_pef_result[0]['offer_assistance_and_cooperate'] + $admin_pef_result[0]['contribut_built_userfriendly_envirnment'] + $admin_pef_result[0]['facilitate_group_discusion'] + $admin_pef_result[0]['follow_leadership_appropriately'] + $admin_pef_result[0]['lead_example_for_colleague'] + $admin_pef_result[0]['able_to_coach_train_mentor'] + $admin_pef_result[0]['has_ability_to_get_job_done'] + $admin_pef_result[0]['motivate_towords_company_goals'] + $admin_pef_result[0]['utilize_ALS_PM_foam'] + $admin_pef_result[0]['adapt_new_methods'] + $admin_pef_result[0]['keep_documents_ready'] + $admin_pef_result[0]['follow_department_procedures'] + $admin_pef_result[0]['take_responsibility_for_results'] + $admin_pef_result[0]['finish_task_without_repetition'] + $admin_pef_result[0]['monitor_own_work'] + $admin_pef_result[0]['prioritize_work_activities'] + $admin_pef_result[0]['write_visit_schedule'] + $admin_pef_result[0]['adapt_to_changes'] + $admin_pef_result[0]['schedule_appointment_with_customer'] + $admin_pef_result[0]['build_approches_from_experience'] + $admin_pef_result[0]['press_beyond_the_surface'] + $admin_pef_result[0]['research_new_methods_for_improvment'] + $admin_pef_result[0]['is_willing_to_learn_new_skills'] + $admin_pef_result[0]['evaluate_problems_quickly'] + $admin_pef_result[0]['fully_complete_assigned_projects'] + $admin_pef_result[0]['meet_expectation'] + $admin_pef_result[0]['ensure_work_responsibility'] + $admin_pef_result[0]['perform_duty_acurately'] + $admin_pef_result[0]['protect_confidential_info'] + $admin_pef_result[0]['bring_notice_harmful_information'];
							  }
							  $pef_final_marks_total=$pef_final_marks_enginerr+$pef_final_marks_supervisor+$pef_final_marks_admin;
							  $pef_final_marks = round($pef_final_marks_total/675*100,2);
							  $pef_final_marks=$pef_final_marks.'%';
						  }
					  ?>
					  <td> <?php echo $pef_final_marks;?> </td>
					 
					  <td> 
					  <?php echo date('d-M-Y', strtotime($engineer['pef_expriy_date']));?>
					  <?php //echo date('d-M-Y', strtotime($result3[0]['due_date']));?> </td>
					  
					  <td>
						  <?php if($enginerr_pef_num_rows=='0' && $supervisor_pef_num_rows=='0' && $admin_pef_num_rows=='0'  && $this->session->userdata('userrole')=='Supervisor'  && $engineer['id']!=$this->session->userdata('userid') )
								{
							  ?>
								  <span class="label label-sm label-danger"> Pending for SAP/FSE </span>
						  <?php }?>
						  
						  <?php if($enginerr_pef_num_rows=='0' && $supervisor_pef_num_rows=='0' && $admin_pef_num_rows=='0'  && $this->session->userdata('userrole')=='Supervisor'  && $engineer['id']==$this->session->userdata('userid') )
								{
							  ?>
								  <span class="label label-sm label-info"> Pending for Supervisor </span>
						  <?php }?>
						  
						  <?php if($supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='0'  && $this->session->userdata('userrole')=='Supervisor'  && $engineer['id']==$this->session->userdata('userid') )
								{
							  ?>
								  <span class="label label-sm label-warning"> Pending for Director </span>
						  <?php }?>
						  
						  <?php if($enginerr_pef_num_rows=='1' && $supervisor_pef_num_rows=='0' && $admin_pef_num_rows=='0')
								{?>
								  <span class="label label-sm label-info"> Pending for Supervisor </span>
						  <?php }?>
						  <?php if($enginerr_pef_num_rows=='1' && $supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='0')
								{
							  ?>
								 <span class="label label-sm label-warning"> Pending for Director </span>
						  <?php }?>
						  <?php if($enginerr_pef_num_rows=='1' && $supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='1')
								{?>
								<span class="label label-sm label-success"> Completed  </span>
						  <?php }?>
						  <?php if($supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='1'  && $engineer['userrole']== 'Supervisor')
								{?>
								<span class="label label-sm label-success"> Completed  </span>
						  <?php }?>
					  </td>
                      
                      
					  <td> 
                      <?php
                            	$schedule=" select * from tbl_pef_schedule where due_date='".$engineer['pef_expriy_date']."'";
								$schedule2=$this->db->query($schedule);
								$schedule3= $schedule2->result_array();
								//echo $schedule3[0]['pk_pef_schedule_id'];
							?>
                          <a href="<?php echo base_url();?>sys/pef_employee/<?php echo $engineer['id'];?>/<?php echo $schedule3[0]['pk_pef_schedule_id'];?>/<?php echo $result[0]['userrole']?>/<?php echo $result[0]['id']?>" class="btn btn-default">
                            PEF Form
                          </a> 
                      </td>
  
					</tr>
			<?php 
					  }
				  }
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  else if($result[0]['userrole']=="Admin")
				  {
					  
					  $rty="select * from user where pef_expriy_date!='0000-00-00 00:00:00' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
					  /*$rty.=" where id IN ( ";
					  $ee = explode(',', $result3[0]['user_ids']);
					  $n=0;
					  foreach($ee as $pp)
					  {
						  $n++;
					  }
					  $n2=0;					
  
					  foreach($ee as $ss)
					  {
						  if($n-1 > $n2)
						  {
							  $rty.="$ss, ";
							  $n2++;
						  }
						  else
						  {
							  $rty.="$ss";
						  }
					  }
					  $rty.=")";*/
					  $myquery2=$this->db->query($rty);
					  $result2=$myquery2->result_array();
					  foreach($result2 as $engineer)
					  {
					  ?>
					  <tr class="odd gradeX">
					
					  <td> <?php echo $engineer['first_name'];?> </td>
  
					  <td>  <?php 
					  			$rty3="select * from tbl_pef_schedule where due_date != '".$engineer['pef_expriy_date']."' order by pk_pef_schedule_id DESC ";
								$myquery3=$this->db->query($rty3);
								$result3=$myquery3->result_array();
								//
								foreach($result3 as $sechdule_entries)
								{
									$userids= explode(',', $sechdule_entries['user_ids']);
									//echo $sechdule_entries['pk_pef_schedule_id'];exit;
									if( in_array($engineer['id'], $userids))
									{
										echo date('d-M-Y', strtotime($sechdule_entries['due_date']));
										break;
									}
								}
								$rty3="select * from tbl_pef_schedule where due_date = '".$engineer['pef_expriy_date']."'";
								//echo $rty3;
								$myquery3=$this->db->query($rty3);
								$result3=$myquery3->result_array();
								//echo "sana_".$result3[0]['pk_pef_schedule_id'];
						   ?> </td>
					  <?php
                            	$schedule=" select * from tbl_pef_schedule where due_date='".$engineer['pef_expriy_date']."'";
								$schedule2=$this->db->query($schedule);
								$schedule3= $schedule2->result_array();
								//echo $result3[0]['pk_pef_schedule_id'];
							?>
					  <?php
						  // for Engineer
						  //echo "sana_".$result3[0]['pk_pef_schedule_id'];
						  $enginerr_pef=" select * from tbl_pef where fk_engineer_id='".$engineer['id']."' and schedule_id='".$result3[0]['pk_pef_schedule_id']."' 
						  AND evaluater_role IN ( 'FSE', 'Salesman')";
						  $enginerr_pef_query=$this->db->query($enginerr_pef);
						  $enginerr_pef_num_rows=$enginerr_pef_query->num_rows();
						  // for Supervisor
						  $supervisor_pef=" select * from tbl_pef where fk_engineer_id='".$engineer['id']."' and schedule_id='".$result3[0]['pk_pef_schedule_id']."' 
						  AND evaluater_role='Supervisor'";
						  $supervisor_pef_query=$this->db->query($supervisor_pef);
						  $supervisor_pef_num_rows=$supervisor_pef_query->num_rows();
						  // for admin
						  $admin_pef=" select * from tbl_pef where fk_engineer_id='".$engineer['id']."' and schedule_id='".$result3[0]['pk_pef_schedule_id']."' 
						  AND evaluater_role='Admin'";
						  $admin_pef_query=$this->db->query($admin_pef);
						  $admin_pef_num_rows=$admin_pef_query->num_rows();
						  //initialize varibles
						  $pef_final_marks_enginerr=0;
						  $pef_final_marks_supervisor=0;
						  $pef_final_marks_admin=0;
						  if($enginerr_pef_num_rows=='0' || $supervisor_pef_num_rows=='0' || $admin_pef_num_rows=='0')
						  {
							  $pef_final_marks="Not filled";
						  }
						  else
						  {
							  if($enginerr_pef_num_rows!='0')
							  {
							  $enginerr_pef_result=$enginerr_pef_query->result_array();
							  $pef_final_marks_enginerr	=	$enginerr_pef_result[0]['know_AP_SOP'] + $enginerr_pef_result[0]['complies_change_SOAP_adaptation'] + $enginerr_pef_result[0]['write_dailyvisitreport'] + $enginerr_pef_result[0]['comuniation_with_manager'] + $enginerr_pef_result[0]['regular_meeting_with_subordinate'] + $enginerr_pef_result[0]['response_to_questions'] + $enginerr_pef_result[0]['response_to_calls'] + $enginerr_pef_result[0]['intiat_without_direction'] + $enginerr_pef_result[0]['proiritize_own_assignments'] + $enginerr_pef_result[0]['attendence_and_punctuality'] + $enginerr_pef_result[0]['meet_deadlines_of_projects'] + $enginerr_pef_result[0]['attend_meetings'] + $enginerr_pef_result[0]['submetting_of_forms'] + $enginerr_pef_result[0]['timely_submission_of_ALS'] + $enginerr_pef_result[0]['value_commitment_with_company'] + $enginerr_pef_result[0]['offer_assistance_and_cooperate'] + $enginerr_pef_result[0]['contribut_built_userfriendly_envirnment'] + $enginerr_pef_result[0]['facilitate_group_discusion'] + $enginerr_pef_result[0]['follow_leadership_appropriately'] + $enginerr_pef_result[0]['lead_example_for_colleague'] + $enginerr_pef_result[0]['able_to_coach_train_mentor'] + $enginerr_pef_result[0]['has_ability_to_get_job_done'] + $enginerr_pef_result[0]['motivate_towords_company_goals'] + $enginerr_pef_result[0]['utilize_ALS_PM_foam'] + $enginerr_pef_result[0]['adapt_new_methods'] + $enginerr_pef_result[0]['keep_documents_ready'] + $enginerr_pef_result[0]['follow_department_procedures'] + $enginerr_pef_result[0]['take_responsibility_for_results'] + $enginerr_pef_result[0]['finish_task_without_repetition'] + $enginerr_pef_result[0]['monitor_own_work'] + $enginerr_pef_result[0]['prioritize_work_activities'] + $enginerr_pef_result[0]['write_visit_schedule'] + $enginerr_pef_result[0]['adapt_to_changes'] + $enginerr_pef_result[0]['schedule_appointment_with_customer'] + $enginerr_pef_result[0]['build_approches_from_experience'] + $enginerr_pef_result[0]['press_beyond_the_surface'] + $enginerr_pef_result[0]['research_new_methods_for_improvment'] + $enginerr_pef_result[0]['is_willing_to_learn_new_skills'] + $enginerr_pef_result[0]['evaluate_problems_quickly'] + $enginerr_pef_result[0]['fully_complete_assigned_projects'] + $enginerr_pef_result[0]['meet_expectation'] + $enginerr_pef_result[0]['ensure_work_responsibility'] + $enginerr_pef_result[0]['perform_duty_acurately'] + $enginerr_pef_result[0]['protect_confidential_info'] + $enginerr_pef_result[0]['bring_notice_harmful_information'];
							  }
							  if($supervisor_pef_num_rows!='0')
							  {
							  //calculation for supervisor sum
							  $supervisor_pef_result=$supervisor_pef_query->result_array();
							  $pef_final_marks_supervisor	=	$supervisor_pef_result[0]['know_AP_SOP'] + $supervisor_pef_result[0]['complies_change_SOAP_adaptation'] + $supervisor_pef_result[0]['write_dailyvisitreport'] + $supervisor_pef_result[0]['comuniation_with_manager'] + $supervisor_pef_result[0]['regular_meeting_with_subordinate'] + $supervisor_pef_result[0]['response_to_questions'] + $supervisor_pef_result[0]['response_to_calls'] + $supervisor_pef_result[0]['intiat_without_direction'] + $supervisor_pef_result[0]['proiritize_own_assignments'] + $supervisor_pef_result[0]['attendence_and_punctuality'] + $supervisor_pef_result[0]['meet_deadlines_of_projects'] + $supervisor_pef_result[0]['attend_meetings'] + $supervisor_pef_result[0]['submetting_of_forms'] + $supervisor_pef_result[0]['timely_submission_of_ALS'] + $supervisor_pef_result[0]['value_commitment_with_company'] + $supervisor_pef_result[0]['offer_assistance_and_cooperate'] + $supervisor_pef_result[0]['contribut_built_userfriendly_envirnment'] + $supervisor_pef_result[0]['facilitate_group_discusion'] + $supervisor_pef_result[0]['follow_leadership_appropriately'] + $supervisor_pef_result[0]['lead_example_for_colleague'] + $supervisor_pef_result[0]['able_to_coach_train_mentor'] + $supervisor_pef_result[0]['has_ability_to_get_job_done'] + $supervisor_pef_result[0]['motivate_towords_company_goals'] + $supervisor_pef_result[0]['utilize_ALS_PM_foam'] + $supervisor_pef_result[0]['adapt_new_methods'] + $supervisor_pef_result[0]['keep_documents_ready'] + $supervisor_pef_result[0]['follow_department_procedures'] + $supervisor_pef_result[0]['take_responsibility_for_results'] + $supervisor_pef_result[0]['finish_task_without_repetition'] + $supervisor_pef_result[0]['monitor_own_work'] + $supervisor_pef_result[0]['prioritize_work_activities'] + $supervisor_pef_result[0]['write_visit_schedule'] + $supervisor_pef_result[0]['adapt_to_changes'] + $supervisor_pef_result[0]['schedule_appointment_with_customer'] + $supervisor_pef_result[0]['build_approches_from_experience'] + $supervisor_pef_result[0]['press_beyond_the_surface'] + $supervisor_pef_result[0]['research_new_methods_for_improvment'] + $supervisor_pef_result[0]['is_willing_to_learn_new_skills'] + $supervisor_pef_result[0]['evaluate_problems_quickly'] + $supervisor_pef_result[0]['fully_complete_assigned_projects'] + $supervisor_pef_result[0]['meet_expectation'] + $supervisor_pef_result[0]['ensure_work_responsibility'] + $supervisor_pef_result[0]['perform_duty_acurately'] + $supervisor_pef_result[0]['protect_confidential_info'] + $supervisor_pef_result[0]['bring_notice_harmful_information'];
							  }
							  if($admin_pef_num_rows!='0')
							  {
							  //calculation for Admin sum
							  $admin_pef_result=$admin_pef_query->result_array();
							  $pef_final_marks_admin	=	$admin_pef_result[0]['know_AP_SOP'] + $admin_pef_result[0]['complies_change_SOAP_adaptation'] + $admin_pef_result[0]['write_dailyvisitreport'] + $admin_pef_result[0]['comuniation_with_manager'] + $admin_pef_result[0]['regular_meeting_with_subordinate'] + $admin_pef_result[0]['response_to_questions'] + $admin_pef_result[0]['response_to_calls'] + $admin_pef_result[0]['intiat_without_direction'] + $admin_pef_result[0]['proiritize_own_assignments'] + $admin_pef_result[0]['attendence_and_punctuality'] + $admin_pef_result[0]['meet_deadlines_of_projects'] + $admin_pef_result[0]['attend_meetings'] + $admin_pef_result[0]['submetting_of_forms'] + $admin_pef_result[0]['timely_submission_of_ALS'] + $admin_pef_result[0]['value_commitment_with_company'] + $admin_pef_result[0]['offer_assistance_and_cooperate'] + $admin_pef_result[0]['contribut_built_userfriendly_envirnment'] + $admin_pef_result[0]['facilitate_group_discusion'] + $admin_pef_result[0]['follow_leadership_appropriately'] + $admin_pef_result[0]['lead_example_for_colleague'] + $admin_pef_result[0]['able_to_coach_train_mentor'] + $admin_pef_result[0]['has_ability_to_get_job_done'] + $admin_pef_result[0]['motivate_towords_company_goals'] + $admin_pef_result[0]['utilize_ALS_PM_foam'] + $admin_pef_result[0]['adapt_new_methods'] + $admin_pef_result[0]['keep_documents_ready'] + $admin_pef_result[0]['follow_department_procedures'] + $admin_pef_result[0]['take_responsibility_for_results'] + $admin_pef_result[0]['finish_task_without_repetition'] + $admin_pef_result[0]['monitor_own_work'] + $admin_pef_result[0]['prioritize_work_activities'] + $admin_pef_result[0]['write_visit_schedule'] + $admin_pef_result[0]['adapt_to_changes'] + $admin_pef_result[0]['schedule_appointment_with_customer'] + $admin_pef_result[0]['build_approches_from_experience'] + $admin_pef_result[0]['press_beyond_the_surface'] + $admin_pef_result[0]['research_new_methods_for_improvment'] + $admin_pef_result[0]['is_willing_to_learn_new_skills'] + $admin_pef_result[0]['evaluate_problems_quickly'] + $admin_pef_result[0]['fully_complete_assigned_projects'] + $admin_pef_result[0]['meet_expectation'] + $admin_pef_result[0]['ensure_work_responsibility'] + $admin_pef_result[0]['perform_duty_acurately'] + $admin_pef_result[0]['protect_confidential_info'] + $admin_pef_result[0]['bring_notice_harmful_information'];
							  }
							  $pef_final_marks_total=$pef_final_marks_enginerr+$pef_final_marks_supervisor+$pef_final_marks_admin;
							  $pef_final_marks = round($pef_final_marks_total/675*100,2);
							  $pef_final_marks=$pef_final_marks.'%';
						  }
					  ?>
					  <td> <?php echo $pef_final_marks;?> </td>
					 
					  <td> 
					  		<?php echo date('d-M-Y', strtotime($engineer['pef_expriy_date']));?>
                      </td>
					  <td>
						  <?php if($enginerr_pef_num_rows=='0' && $supervisor_pef_num_rows=='0' && $admin_pef_num_rows=='0' && $this->session->userdata('userrole')=='Admin'  && $engineer['id']!=$this->session->userdata('userid') )
								{
									if($engineer['userrole']== 'Supervisor')
									{
								  ?>
									  <span class="label label-sm label-info"> Pending for Supervisor </span>
							  <?php }else {?>
								  <span class="label label-sm label-danger"> Pending for SAP/FSE </span>
							  <?php }
							  }?>
						  
						  <?php if($enginerr_pef_num_rows=='0' && $supervisor_pef_num_rows=='0' && $admin_pef_num_rows=='0'  && $this->session->userdata('userrole')=='Admin'  && $engineer['id']==$this->session->userdata('userid') )
								{
							  ?>
								  <span class="label label-sm label-warning"> Pending for Director </span>
						  <?php }?>
						  
						  <?php if($supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='0'  && $this->session->userdata('userrole')=='Admin'  && $engineer['id']==$this->session->userdata('userid') )
								{
							  ?>
								  <span class="label label-sm label-warning"> Pending for Director </span>
						  <?php }?>
						  
						 
						  
						  <?php if($enginerr_pef_num_rows=='1' && $supervisor_pef_num_rows=='0' && $admin_pef_num_rows=='0')
								{?>
								  <span class="label label-sm label-info"> Pending for Supervisor </span>
						  <?php }?>
						  <?php if($enginerr_pef_num_rows=='1' && $supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='0')
								{
							  ?>
								 <span class="label label-sm label-warning"> Pending for Director </span>
						  <?php }?>
						  <?php if($supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='0' && $engineer['userrole']== 'Supervisor')
								{
							  ?>
								  <span class="label label-sm label-warning"> Pending for Director </span>
						  <?php }?>
						  
						  
						  <?php if($enginerr_pef_num_rows=='1' && $supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='1')
								{?>
								<span class="label label-sm label-success"> Completed  </span>
						  <?php }?>
						  <?php if($supervisor_pef_num_rows=='1' && $admin_pef_num_rows=='1'  && $engineer['userrole']== 'Supervisor')
								{?>
								<span class="label label-sm label-success"> Completed  </span>
						  <?php }?>
                          <?php if($admin_pef_num_rows=='1'  && $engineer['userrole']== 'Admin')
								{?>
								<span class="label label-sm label-success"> Completed  </span>
						  <?php }?>
					  </td>
					  <td> 
                            
                          <a href="<?php echo base_url();?>sys/pef_employee/<?php echo $engineer['id'];?>/<?php echo $schedule3[0]['pk_pef_schedule_id'];?>/<?php echo $result[0]['userrole']?>/<?php echo $result[0]['id']?>" class="btn btn-default">
                            PEF Form
                          </a> 
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

          <!-- END EXAMPLE TABLE PORTLET--> 

        </div>

      </div>

      

      <!-- END PAGE CONTENT--> 

    </div>

  </div>

  <!-- END CONTENT --> 

  <!-- BEGIN QUICK SIDEBAR --> 


  

  <!-- END QUICK SIDEBAR --> 

</div>

<!-- END CONTAINER --> 
<?php $this->load->view('footer');?>