<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title"> Performance Evaluation Form <small>Employee</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> PEF <i class="fa fa-angle-right"></i> </li>

          

        </ul>

        

      </div>
	  <?php
          if(isset($_GET['msg']))
            { 
              echo '<div class="alert alert-success alert-dismissable">  
                      <a class="close" data-dismiss="alert">×</a>  
                      Form Added Successfully.  
                    </div>';
            }
        ?>
      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

          <div class="tabbable tabbable-custom boxless tabbable-reversed">

            <ul class="nav nav-tabs">

              <li class="active"> <a href="#tab_0" data-toggle="tab"> Form Actions </a> </li>

            </ul>

            <div class="tab-content">

              <div class="tab-pane active" id="tab_0">

                <div class="portlet box green">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Form Actions On Bottom </div>

                    <div class="tools"> 
                    	<a href="javascript:;" class="collapse"> </a> 
                        
                        <a href="javascript:;" class="remove"> </a> 
                   </div>

                  </div>
					
                  <div class="portlet-body form"> 
					
                    <!-- BEGIN FORM-->

                   <!-- BEGIN FORM-->
            <form  class="horizontal-form" action="<?php echo base_url();?>sys/pef_insert" method="post">
                <div class="form-body">
                    
                   		<?php
                        	$myquery=$this->db->query("select * from user where id='".$this->uri->segment('3')."'");
							$result=$myquery->result_array();
						?>
                        <!--row-->
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Evaluation Period</label>
                                <?php
								  //
									$rty3="select * from tbl_pef_schedule where pk_pef_schedule_id='".$this->uri->segment('4')."'";
									$myquery3=$this->db->query($rty3);
									$result3=$myquery3->result_array();
									$due_date = date('Ymd', strtotime($result3[0]['due_date']));
									$current_date=date('Ymd');
									//
								?>
                                <input type="text" class="form-control" readonly name="evaluationperiod" value="<?php echo $result3[0]['duration'];?>">
                                <input type="hidden" name="fk_engineer_id" value="<?php echo $this->uri->segment('3');?>">
                                <input type="hidden" name="fk_evaluater_id" value="<?php echo $this->session->userdata('userid');?>">
                                <input type="hidden" name="schedule_id" value="<?php echo $this->uri->segment('4');?>">
                                <input type="hidden" name="evaluater_role" value="<?php echo $this->uri->segment('5');?>">
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Complete Name</label>
                                <input type="text" class="form-control" readonly name="name" value="<?php echo $result[0]['first_name'];?>">
                            </div>
                        </div>
                        
                    </div>
                    <!--/row-->
                    
                    <!--row-->
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Title/Desgination</label>
                                <input type="text" class="form-control" readonly name="title" value="<?php echo $result[0]['userrole'];?>">
                                
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Department</label>
                                <input type="text" class="form-control" readonly name="department" value="<?php echo $result[0]['department'];?>">
                                
                            </div>
                        </div>
                      
                    </div>
                    <!--/row-->
                    <?php
                        	$mycity=$this->db->query("select * from tbl_cities where pk_city_id='".$result[0]['fk_city_id']."'");
							$resultcity=$mycity->result_array();
						?>
                     <!--row-->
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">City</label>
                                <input type="text" class="form-control" readonly name="rawalpindi" value="<?php echo $resultcity[0]['city_name'];?>">
                                
                            </div>
                        </div>
                    </div>
                    <!--/row-->

                   <h3 class="form-section">Factors Rating</h3> 
                    <!--row-->
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-6">Rarely meets standards set for the assignments =</label>
                                <div class="col-md-1">
                                <input type="text" class="form-control" readonly name="one" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                    
                    <!--row-->
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-6">Partially meets standards =</label>
                                <div class="col-md-1">
                                <input type="text" class="form-control" readonly name="two" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                    
                    <!--row-->
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-6">Meets most standards of the responsibility acceptably =</label>
                                <div class="col-md-1">
                                <input type="text" class="form-control" readonly name="three" value="3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                    
                    <!--row-->
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-6">Exceeds most standards, consistently =</label>
                                <div class="col-md-1">
                                <input type="text" class="form-control" readonly name="four" value="4">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                    
                    <!--row-->
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-6">Exceeds all expectations, consistently =</label>
                                <div class="col-md-1">
                                <input type="text" class="form-control" readonly name="five" value="5">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                   
                   
                   
         
                    <h3 class="form-section">Definition of Factors</h3>
                 <!--/row-->
                    <div class="row">
                        <div class="col-md-12">
                        <div class="table-scrollable">
						<?php
                        $pef=" select * from tbl_pef where fk_engineer_id='".$this->uri->segment('3')."' and fk_evaluater_id='".$this->uri->segment('3')."'
						 and schedule_id='".$this->uri->segment('4')."'";
						$pef_query=$this->db->query($pef);
						$pef_num_rows=$pef_query->num_rows();
						$pef_result=$pef_query->result_array();
						// supervisor
						$pef2=" select * from tbl_pef where fk_engineer_id='".$this->uri->segment('3')."' and fk_evaluater_id='".$this->uri->segment('6')."'  
						and schedule_id='".$this->uri->segment('4')."'";
						$pef_query2=$this->db->query($pef2);
						$pef_num_rows_supervisor=$pef_query2->num_rows();
						$pef_result2=$pef_query2->result_array();
						//
						?>
                       <table class="table table-hover table-bordered">

                        <thead>

                          <tr>

                            <th> Question</th>
                            
                            <th style="width:80px"> SAP/FSE</th>
                            
                            <th style="width:80px"> Supervisor </th>

                            <th style="width:80px"> Director  </th>
                        </tr>
                        
                        <tr>
                        
                          <th>Knowledge of Policies, SOP and Plans</th>
                          
                        </tr>

                       
                      </thead>
					
                      <tbody>
						
                        <tr>
                        
                          <td>01) Knows Administrative Policies and SOP</td>

                          <td>
                          <?php
                                $obj=new Complaint_model();
								$obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'know_AP_SOP');
                            ?>

                         

                        </tr>
                        
                        <tr>
                        
                          <td>02) Complies with the changes in SOP or adaptation new procedures / policies</td>

                          
                          
                          <td>
							<?php
                              
                              $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                              $this->uri->segment('6'), 'complies_change_SOAP_adaptation');
                            ?>
                          

                         

                        </tr>

                      </tbody>
                      <thead>
                       <tr>
                        <th>Communication</th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>03) Writes the Daily Visit Reports clearly, edits work for spelling and grammar</td>
                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'write_dailyvisitreport');
                            ?>
                         

                        </tr>
                        
                      <tr>
                        
                          <td>04) Inquire / discuss with the TSS / Manager in written using email or sms</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'comuniation_with_manager');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>05) Conduct regular meetings with team/subordinates and put up reports to the TSS /Manager</td>
                          
                         <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'regular_meeting_with_subordinate');
                            ?>

                        </tr>
                        
                      <tr>
                        
                          <td>06) Responds accurately and promptly to questions / inquires via email or sms</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'response_to_questions');
                            ?>


                         

                        </tr>
                        
                      <tr>
                        
                          <td>07) Responds to the Mobile phone calls</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'response_to_calls');
                            ?>


                         

                        </tr>
                      
                      </tbody>
                      <thead>
                      <tr>
                        <th>Initiative/Timeliness</th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>08) Initiate, without specific direction, actions, activities</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'intiat_without_direction');
                            ?>


                         

                        </tr>
                        
                      <tr>
                        
                          <td>09) Prioritize own assignments and follow priorities till completion</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'proiritize_own_assignments');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>10) Attendance and punctuality (daily office reporting at time)</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'attendence_and_punctuality');
                            ?>


                         

                        </tr>
                        
                      <tr>
                        
                          <td>11) Meet deadlines of the projects assigned by the manager / directors</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'meet_deadlines_of_projects');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>12) Attend / reach to the customer / departmental meetings in time</td>

                              <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'attend_meetings');
                            ?>
                         

                        </tr>
                        
                        <tr>
                        
                          <td>13) Submitting of forms such as TS Visit/ Pre-Demo/ VXB/ etc... to all concerns</td>

                              <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'submetting_of_forms');
                            ?>

                         

                        </tr>
                        
                        <tr>
                        
                          <td>14) Timely submission of the ALS, TS Monthly Reports, Forecast sheets etc...</td>

                              <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'timely_submission_of_ALS');
                            ?>

                         

                        </tr>
                      
                      </tbody>
                      
                      <thead>
                      <tr>
                        <th>Relationships / Teamwork</th>
                       </tr>
                      </thead>
                      <tbody>
                     
                      <tr>
                        
                          <td>15) Value harmony / agreements / commitments with the company</td>

                              <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'value_commitment_with_company');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>16) Offer assistance and Cooperate with others within and outside the department</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'offer_assistance_and_cooperate');
                            ?>

                         

                        </tr>
                        
                        <tr>
                        
                          <td>17) Contributes to building "user-friendly environment"</td>

                              <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'contribut_built_userfriendly_envirnment');
                            ?>

                         

                        </tr>
                        
                        <tr>
                        
                          <td>18) Facilitates group discussion in decision making process to solve customer issues</td>
						
                    		<td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'facilitate_group_discusion');
                            ?>

                         

                        </tr>
                      
                      </tbody>
                      
                      <thead>
                      <tr>
                        <th>Leadership</th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>19) Follow the Leadership of others appropriately</td>
							
                        <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'follow_leadership_appropriately');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>20) Lead/supervise and set good example for his colleague or subordinates</td>

							<td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'lead_example_for_colleague');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>21) Has ability to coach, train and mentor</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'able_to_coach_train_mentor');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>22) Has ability to get job done by subordinates or co-workers within or outside department</td>
							<td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'has_ability_to_get_job_done');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>23) Motivates others towards the company goals</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'motivate_towords_company_goals');
                            ?>

                         

                        </tr>
                       
                      
                      </tbody>
                      
                      <thead>
                      <tr>
                        <th>Use of Tools/Resources</th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>24) Utilize forms such as ALS, PM Form, Leave Application etc... to improve his work</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'utilize_ALS_PM_foam');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>25) Adapt to new methods or new versions of the above mentioned forms</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'adapt_new_methods');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>26) Keep all the literature Brochure / Complete Tool Kit / Technical Documents ready</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'keep_documents_ready');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>27) Follows department procedures for use of Leave Application Form</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'follow_department_procedures');
                            ?>

                         

                        </tr>
                        
                      
                      
                      </tbody>
                      
                      <thead>
                      <tr>
                        <th>Accuracy/Completeness/Quality</th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>28) Takes Responsibility of output of results for any assigned task</td>

							<td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'take_responsibility_for_results');
                            ?>
                        </tr>
                        
                      <tr>
                        
                          <td>29) Finishes the task / service call with no repeat visit for same task / service call</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'finish_task_without_repetition');
                            ?>

                         

                        </tr>
                        
                      <tr>
                        
                          <td>30) Monitors own work to ensure quality</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'monitor_own_work');
                            ?>

                         

                        </tr>
                        
                     
                      
                      </tbody>
                      
                      <thead>
                      <tr>
                        <th>Planning </th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>31) Prioritizes and plans work activities to meet the goals mainain TTD List</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'prioritize_work_activities');
                            ?>

                        </tr>
                        
                      <tr>
                        
                          <td>32) Writes the visit schedule /plan his next day activities</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'write_visit_schedule');
                            ?>

                        </tr>
                        
                      <tr>
                        
                          <td>33) Adapts to changing priorities, situations and demands; integrates changes</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'adapt_to_changes');
                            ?>

                        </tr>
                        
                      <tr>
                        
                          <td>34) Schedule appointments with customers</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'schedule_appointment_with_customer');
                            ?>
                        </tr>
                        
                      
                      
                      </tbody>
                      
                      <thead>
                      <tr>
                        <th>Creativity</th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>35) Build new approaches from prior experience</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'build_approches_from_experience');
                            ?>
                        </tr>
                        
                      <tr>
                        
                          <td>36) Press beyond the surface to key elements and root causes</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'press_beyond_the_surface');
                            ?>
                        </tr>
                        
                      <tr>
                        
                          <td>37) Research new methods/documentation & apply to problems for improvement</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'research_new_methods_for_improvment');
                            ?>

                        </tr>
                        
                      <tr>
                        
                          <td>38) Is willing to learn new skills (Application / Engineering / Sales)</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'is_willing_to_learn_new_skills');
                            ?>

                        </tr>
                        
                      <tr>
                        
                          <td>39) Evaluate, diagnose, and overcome problems of the task quickly</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'evaluate_problems_quickly');
                            ?>

                        </tr>
                      
                      
                      
                      </tbody>
                      
                      <thead>
                      <tr>
                        <th>Quantity/Volume</th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>40) Fully completes assigned projects / service calls without leaving the task in half way</td>

                          
                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'fully_complete_assigned_projects');
                            ?>

                        </tr>
                        
                      <tr>
                        
                          <td>41) Meet or exceed expectations / targets (PM = 100%, OMR = 100%, Sales Target etc..)</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'meet_expectation');
                            ?>

                        </tr>
                     
                      
                      </tbody>
                      
                      <thead>
                      <tr>
                        <th>Job Responsibility</th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>42) Ensures work responsibilities are covered when absent or on leave</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'ensure_work_responsibility');
                            ?>

                        </tr>
                        
                      <tr>
                        
                          <td>43) Perform his duties accurately according to the SOP and other polices of the company</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'perform_duty_acurately');
                            ?>

                        </tr>
                      
                      </tbody>
                      
                      <thead>
                      <tr>
                        <th>Loyalty and Sincerity  </th>
                       </tr>
                      </thead>
                      <tbody>
                      <tr>
                        
                          <td>44) Protects confidential info, ensures departmental process to protect confidential info</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'protect_confidential_info');
                            ?>

                        </tr>
                        
                      <tr>
                        
                          <td>45) Bring into the notice of the directors any observation harmful to the organization</td>

                          <td>
							<?php
                                $obj->create_pefemployee_html($this->uri->segment('3'), $this->uri->segment('4'), $this->uri->segment('5'), 
                                $this->uri->segment('6'), 'bring_notice_harmful_information');
                            ?>

                        </tr>
                      
                      </tbody>

                            </table>

                          </div>
                        
                        
                        </div>
                    </div>	
                     <!--/row-->
                  
                        <h3 class="form-section">Comments</h3>
                        <!--row-->
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
										<label>List below the reasons for every evaluation marked 1 or 2</label>
										<textarea class="form-control" rows="3" name="comments" id="comments"></textarea>
							</div>

                        </div>
                       
                        
                        
                    </div>
                    <!--/row-->
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <?php //echo 'due_date = '.$due_date.' and current_date='.$current_date; ?>
                                    <button  <?php if($due_date > $current_date){?>type="submit"<?php  } else {?>type="button"  onclick="alert('Date expired')"<?php  }?> 
                                    class="btn green ifemptyselect">Save</button>
                             <!--       <button type="button" class="btn default">Cancel</button> -->
                                    <script>
									$(document).ready( function(){
										$('.ifemptyselect').click( function() {
											var selectlenght = $('select').length;
											//alert(selectlenght);
											if(selectlenght<40)
											{
											alert('NO data filled');
											return false;
											}
										});
									});
									
									</script>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </form>

                    <!-- END FORM--> 

                  </div>

                </div>

               

            </div>

          </div>

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