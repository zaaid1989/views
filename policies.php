<?php $this->load->view('header');?>
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Policies <small>Company Detail Policies</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						Home
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						Policies
						<i class="fa fa-angle-right"></i>
					</li>
					
				</ul>
				<div class="page-toolbar">
					
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
			  <div class="col-md-12">
              <div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Policies
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
						<?php
					  if(isset($_GET['update_msg']) && $_GET['update_msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Policy Updated Successfully.  
								</div>';
						}
					if(isset($_GET['delete_msg']) && $_GET['delete_msg']=='success')
						{ 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Policy Deleted Successfully.  
								</div>';
						}
						
					?>
						
						<?php if ($this->session->userdata('userrole')=='Admin') { ?>
						<div class="row">
                        <div class="col-md-6">
                          <div class="btn-group">
                            <a href="<?php echo base_url();?>sys/add_policy" id="sample_editable_1_new" class="btn red-flamingo"> 
                            	Add New Policy
                                <i class="fa fa-plus"></i> 
                            </a>
                          </div>
                        </div>
                      </div>
					  <?php } ?>
					  
							<div class="panel-group accordion" id="accordion3">
							
							<?php
								$pq = $this->db->query("SELECT * FROM tbl_policies ORDER BY `order`");
								$pr = $pq->result_array();
								$i = 1;
								foreach ($pr AS $policy) {
									echo '<div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_'.$i.'">';
									echo urldecode($policy['policy_title']);
									
									echo '</a>
                                                </h4>
												
											
											
                                            </div>
											
                                            <div id="collapse_3_'.$i.'" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">';
									
									if ($this->session->userdata('userrole')=='Admin') {
										echo '<div class="row">
														<a href="'. base_url().'sys/edit_policy?policy='.$policy['pk_policy_id'].'"  class="pull-right btn blue"> 
															Edit Policy
														</a>
														<a href="'. base_url().'sys/delete_policy/'.$policy['pk_policy_id'].'"  class="pull-right btn red"> 
															Delete Policy
														</a>
												</div>';
									}
									echo $policy['policy'];
									
									echo '</div>
                                            </div>
                                        </div>';
							
									$i++;
								}
							?>
							<!--
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">
                                                Daily Allowance </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_1" class="panel-collapse in">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    
        <ul>
        <li> It covers the cost of petrol / CNG / Maintenance of vehicle and any snacks you take during the day. </li>
        <li>	Your expense to come to office is not generally considered as part of the daily allowance.</li>
        <li>	Daily Allowance is paid to the employees for their travelling within the day starting from Office to customers and back to office.</li>
        <li>	DA is paid per Working Day. </li>
        <li>	Working day: it's a day when you do customer visits on normal week days or weekend or any public holiday. No calculation required for the special DA on non-week days.</li>
        <li>	If you spend all day at the office the DA for such days will not be given DA, do not forget DA is to cover your travelling expense and you also get Salary.</li>
        <li>	If FSE/SAP will be at training at STCO, DA will be given considering a working day during the training without any further extra amount.</li>
        <br>
        </ul>
        <strong>DA for the FSE / SAP</strong><br>
        <ul>
        <li>	We have harmonized the DA for both departments. The New DA will be Rs. 250 per working day only on submission of DVR & VS. </li>
        <li>	The new DA Policy is based on your estimated travelling of 150 to 170 kilometers per day within city this is equivalent to approx. 4500 km per month. </li>
        </ul>
        
        <strong>DA for the TSS</strong><br>
        <ul>
        <li>	The New DA will be Rs. 275 per working day only on submission of DVR & VS. </li>
        <li>	The new DA Policy is based on your estimated within CITY travelling of approx. 5000 km per month. </li>
        </ul>
        
        
        <strong>Fixed DA</strong><br>
        <ul>
        <li>	There is no Fixed DA anymore. Employees who has Fixed DA the same amount has been divided by 26 (considering 4 Sundays) and that per day amount will be paid on submission of DVR & VS. </li>
        <li>	The new DA Policy is based on your estimated within CITY travelling of approx. 5000 km per month. </li>
        </ul>
        <strong>NOTE: </strong><br>
        <ul>
        <li>	The DA issue is not in the hands of the company, it is very much dependent on the Government Policy. For example if the Government decide to increase the petrol prices every month company cannot do so unless the company profits are also increasing with the same percentage. </li>
        
        <li>We all suffer due to financial instability in the Pakistan currency and increase in cost of living and fuel prices. </li>
        
        <li>	In future the DA will be reviewed annually at the end of financial year. We have provided the task to another company (third party auditors) to calculate the Daily travelling kilometer based on current and last 2 years DVRs of employee, which will further determine the increase/decrease of Daily Allowance.  </li></ul>
             
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2">
                                                Daily Reporting and Attendance </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_2" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    
        
        <strong>Visit Schedule (VS)</strong>
        <ul>
            <li>All Persons will enter their Online VS one day before with the consensus of their Immediate Boss.</li>
            <li>VS must be comprehensive, detailed and progressive.</li>
        </ul>
        <strong>Daily Visit Report (DVR)</strong>
        <ul>
            <li>All Persons of SAP and TS Department must type their visit (progress/ working) report on daily bases.</li>
            <li>Do not type any false statement because if caught company will strictly penalize for such action.</li>
            <li>In the DVR, write in detail your discussion with the costumer; don't just write "Routine Visits" "Product Discussion" etc….. Always write correct / accurate time of meeting, name of the person you met, purpose of visit and visit out come.</li>
            <li>Based on your discussion also write your next action plan.</li>
            <li>Please note that either Director or Manager SAP or someone on their behalf may be calling the costumers on random basis to check if the information in the DVR is true or not.</li>
            </ul>
        <strong>Working Hours & Reporting Time</strong>
        <ul>
            <li>Employees must report to the respective office at 9:00 AM unless you have a pre-planned visit in the morning as mentioned in VS and approved by immediate Boss following management hierarchy and in case of change in VS, inform via sms to the person taking attendance in respective office.</li>
            <li>There is a relaxation of Up to 9:30 AM for office reporting time considering any delay due to Traffic or any valid reason. If reporting late a fine will be issued.</li>
            <li>Working hours are not defined and dependent on completion of your task. There may be a case when you don't have much to do whole day but you receive a service call and you have to report at customer sight at Mid Night or Your customer gives you meeting time at 9:00 PM.</li>
            <li>In case of any urgency at any customer site, You may be called 24/7 and you have to response and reach to that task in time on demand of your TSS,TSA or Director</li>
        </ul>
            
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3">
                                                Fine Codes </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_3" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                <table class="table table-striped table-bordered table-hover flip-content">
                                
                                                <thead>
                                
                                                  <tr>
                                
                                
                                                    <th> Code  </th>
                                
                                                    <th> Description</th>
                                
                                                    <th> Amount (Rs) </th>
                                                 </tr>
                                
                                                </thead>
                                
                                                <tbody>
                                
                                                  <tr>
                                                    <td> 01 </td>
                                                    <td>Visit Schedule / DVR NOT submitted Online</td>
                                                    <td> 200 </td>
                                                 </tr>
                                
                                                  <tr>
                                                    <td> 02 </td>
                                                    <td>Didn't report Office up to 9:30 AM & had no approved direct customer visit or did not inform via SMS to the person taking attendance.</td>
                                                    <td> 200 </td>
                                                  </tr>
                                
                                                  <tr>
                                                    <td> 03 </td>
                                                    <td> Not Dressed as per SOP </td>
                                                     <td> 200 </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td> 04 </td>
                                                    <td> Document / Forms Submitted without Customer Signature. </td>
                                                    <td> 200 </td>
                                                 </tr>
                                
                                                  <tr>
                                                    <td> 05 </td>
                                                    <td> Mobile Phone not responding (Because of any reason) </td>
                                                    <td> 200 </td>
                                                  </tr>
                                
                                                  <tr>
                                                    <td> 06 </td>
                                                    <td> Email not responded (Because of any reason) </td>
                                                     <td> 200 </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td> 07 </td>
                                                    <td> No SMS to TSS for Information / Approval after reaching / leaving the customer site. </td>
                                                    <td> 200 </td>
                                                 </tr>
                                
                                                  <tr>
                                                    <td>08</td>
                                                    <td> SAP Visiting less than 5 customer </td>
                                                    <td> 200 for each visit not done</td>
                                                  </tr>
                                
                                                  <tr>
                                                    <td> 09 </td>
                                                    <td> No Progress on more than 50% projects mentioned in Sales and Marketing Projects. </td>
                                                     <td> 200 per project without progress </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td>10 </td>
                                                    <td> Tender Missed due to any reason </td>
                                                    <td> 3000 </td>
                                                 </tr>
                                
                                                  <tr>
                                                    <td> 11 </td>
                                                    <td> Incomplete Tool Kit</td>
                                                    <td> 400 </td>
                                                  </tr>
                                
                                                  <tr>
                                                    <td> 12 </td>
                                                    <td> TS Report Late Submission </td>
                                                     <td> 200 </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td> 13 </td>
                                                    <td> Instrument Training Completion Certificate is not filled at the end of training within 1 month of installation </td>
                                                    <td> 200 / Operator </td>
                                                 </tr>
                                
                                                  <tr>
                                                    <td> 14 </td>
                                                    <td> Instrument Installation Form not submitted within 1 week after installation of instrument. </td>
                                                    <td> 500 </td>
                                                  </tr>
                                
                                                  <tr>
                                                    <td> 15 </td>
                                                    <td> 0800 Sticker not pasted on the instrument </td>
                                                     <td> 200 </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td>16 </td>
                                                    <td> PM not performed or attachments missing with the PM Form. / Pending PM in your Territory </td>
                                                    <td> Rs. 200  each Instrument </td>
                                                 </tr>
                                
                                                  <tr>
                                                    <td> 17 </td>
                                                    <td>OM not performed or Log not Maintained or Sheet not collected </td>
                                                    <td> Rs. 200  each Instrument </td>
                                                  </tr>
                                
                                                  <tr>
                                                    <td> 18 </td>
                                                    <td> Spare Part / Kits replaced without prior permission of TSS / SAP and Spare Part Requisition Form Not Filled. </td>
                                                     <td> 1000 </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td> 19 </td>
                                                    <td> Unused or Replaced or Faulty parts or Receiving copy of the DC, any of this is not send back to HO within the 7 days of the date of issue of DC / Spare Parts </td>
                                                    <td> 200 per Part per day </td>
                                                 </tr>
                                
                                                  <tr>
                                                    <td> 20 </td>
                                                    <td> kit is authorized to be replaced / compensated without prior permission of TSS, TSA and SAP </td>
                                                    <td> 1000 </td>
                                                  </tr>
                                
                                                  <tr>
                                                    <td> 21 </td>
                                                    <td> Leave is taken above limit of 21 days (with Form Submission) </td>
                                                     <td> Salary of these days </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td> 22 </td>
                                                    <td>Leave is taken above limit of 21 days (without Form Submission & Prior approval)</td>
                                                     <td> Salary will not be paid for such period + Rs. 500 </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td> 23 </td>
                                                    <td> Leave is taken within limit of 21 days (without Form Submission & Prior approval) </td>
                                                     <td> Rs. 500 </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                    <td> 24 </td>
                                                    <td> If person does not take any leave during the year </td>
                                                     <td> A Bonus Salary of 21 days will be paid </td>
                                                  </tr>
												  
												  <tr>
                                                    <td> 25 </td>
                                                    <td> Not taking service call </td>
                                                     <td> Rs. 1000 </td>
                                                  </tr>
                                
                                                </tbody>
                                
                                              </table>
                                                </div>
                                            </div>
                                        </div>
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_4">
                                                FOC Product Requisition </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_4" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    
        <ul>
        <li> FOC Form will be filled by the SAP and TSS for any of the following issues:
        <ul>
        <li>Evaluation / DEMO – SAP.</li>
        <li>Training (Customer or TS Person) – SAP / TSS</li>
        <li>Technical Issues such as Less # of Tests / Pack – SAP / TSS.</li>
        <li>QC or Calibration Material Wasted in troubleshooting and customer claims the wastage. SAP / TSS</li>
        <li>Bill after Approval / Customer want Product FOC and if satisfied will purchase – SAP.</li>
        <li>FOC as per Sales Department Contract – SAP.</li>
        </ul>
        
        </li>
        <li>	Whenever a sampling is required; SAP or TS Person will fill the "FOC Product Requisition Form" and after signature of Manager or TSS and email to Concern Director for approval.</li>
        <li>	Products are issued to SAP / TSS after approval of “FOC Products Requisition Form” from Manager and Director Sales and Technical Services</li>
        <li>	Correct and detailed information must be provided in the FOC Product Requisition Form. </li>
        <li>	SAP / TSS must get TS Number from TS Coordinator maintaining database against this Form; enter the service call in the TS Database & write this TS Number on the FOC Form.</li>
        <li>	It is responsibility of SAP / TSS to get written report with customer signature and stamp on the Laboratory / hospital letter head that the product quality is acceptable and results are satisfactory.</li>
        <li>	SAP / TSS will give a copy of this written report to the Manager and original will be submitted to Director.</li>
        
        </ul>
             
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_5">
                                                General Office Discipline & Policies </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_5" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    Discipline in the workplace is the means by which supervisory personnel correct behavioral deficiencies and ensure adherence to established company rules. 
                                                    The purpose of discipline is correct behavior, it is not designed to punish or embarrass an employee.</p>
                                                    <p>
                                                    <strong>Office Safety </strong>
        <ul>
        
        <li>Whoever enter the office, it’s his responsibility to lock the main door and main gate </li> 
        
        <li>Get help to move heavy objects.</li>
        <li>Know location of emergency exits and keep aisles clear to them</li>
        </ul>
        </p>
        <p>
        <strong>Housekeeping</strong><br>
        Good housekeeping contributes to efficient performance. When tools, equipment and materials are return to the proper place after use, they are easier to find and inspect for damage and wear.
        The following suggestions are offered for good housekeeping.
        <ul>
        <li>Wipe up spills and pick up all objects that should not be on floor. </li>
        <li>Keep work areas and storage facilities clean, neat and orderly.</li>
        <li>All aisles, stairways, exits and access ways should be kept clear. </li>
        <li>Do not place supplies on top of lockers, boxes or other movable containers </li>
        <li>All packing material should be disposed of immediately. </li
        ><li>Whole office indoor facilities are strictly NO-SMOKING Area</li>
        <li>Wipe the Washrooms after using it</li>
        </ul>
        </p>
        <p>
        <strong>Dress Code</strong><br>
        During office hours, all SAP must wear Dress Trouser, Dress Shirt with Tie and Polished Shoes. (Jeans, T shirt, Joggers or Open Shoes are not allowed). 
        </p>
        <p>
        <strong>Your Desk / Workstation</strong>
        <ul>
        <li>Sort all papers, stationary, tool etc on your workstation before leaving office. </li>
        <li>Keep desk and file drawers closed when not in use. </li>
        <li>Do not open file or desk drawers above or behind someone without their permission</li>
        <li>Push chairs up to desk or under counter when not in use.</li>
        <li>Whenever you want to leave office or you are going away from your workstation for long time make sure that AC, Fan, Computers and all tube lights switched off. </li>
        <li>No gathering at any workstations or Tables unless or until required.
        
        </li>
        </ul>
        </p>
        <p>
        <strong>Personal Harassment</strong><br>
        As an employer, it is the Company’s responsibility to protect its employees from bullying, harassment, intimidation and threatening or aggressive behavior.  Any incidences of such will be reported to the management and the Company’s BOD will take strict appropriate actions.  If you are the victim of minor or more serious incidents of harassment, whilst on Company premises, or whilst 
        involved in Company activities, it is your right to bring it to the direct attention of the Directors. </p>
        <p>
        <strong>Confidentiality</strong><br>
        Employees, customer and colleague information is private and confidential.  Under no circumstances should contact information be given to any third parties 
        without the express permission of the person concerned.  
        </p>
        <p>
        <strong>Kitchen</strong>
        <ul>
        <li>The company will offer Two Cups of Tea per employee during office hours.</li>
        <li>No Eating and Drinking on the Table or workstations is allowed. It is STRICTLY prohibited. For Breakfast, lunch, etc... Only eating in Kitchen or Designated place is allowed.</li>
        <li>Do not leave the empty cups on your Table or workstations, if peon is not around or busy in some other work, leave the cups to the kitchen on your own.</li>
        <li>The Fridge and Microwave is available in the kitchen for use.</li>
        </ul>
        </p>
        <p>
        <strong>Office Keys and Closing</strong>
        <ul>
        <li>Office Keys will only be with Office Managers (LO = Mr. Qureshi, KO = Mr. Khalid, STCO = Executive Secretary)</li>
        <li>If for some reason any employee has to work late, he must get prior permission from the immediate boss and office managers.</li>
        <li>The person leaving in the end Must Ensure that this Door is Locked and the Main Gate is also locked with China Lock.</li>
        <li>The person leaving the office will also sign in the register before leaving. He must inform Immediate Boss and Office Manager at the time of closing/leaving office</li>
        </ul>
        </p>
        <p>
        <strong>Check before leaving the office</strong>
        <ul>
        <li>Please ensure that all electricity points, lights, Fan and ACs switched off. </li>
        <li>Please make sure that there is no water and gas leakage. </li>
        <li>Ensure that all doors especially main door locked properly. </li>
        
        </ul>
        </p>
                                                </div>
                                            </div>
                                        </div>
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_6">
                                                Laptop - Loan </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_6" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    <ul>
                                                    <li>Employee is eligible to apply for the laptop loan after 3 months of Job or completion of training.</li>
                                                    <li>The laptop price will be actual (not more than Rs. 30,000/-) with 50% sharing of company. </li>
                                                    <li>The 50% amount will be deducted in installments per month from basic salary.</li>
                                                    <li>If the employee leaves the job before the contract time, the laptop will be returned to the company 
                                                    and no refund/return of the amount paid by the employee in installments.</li>
                                                    <li>To apply for the loan employee must submit Requisition Form after approval payment will be made to the Employee however bill will be required for accounts.</li>
                                                    </ul>
        
        
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_7">
                                                Mobile SIM </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_7" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    <ul>
                                                    <li>Company will provide you the Post paid mobile SIM as per Quote decided by the management. The same SIM also have Internet Facility activated on it.</li>
                                                    <li>It is responsibility of all SAP and TS personnel to keep their phone set in proper working condition all the time. If for some reason your phone set is lost / not functioning buy new one so that you are always in contact with the office & customers. Keep it charged</li>
                                                    <li>If you are busy anywhere in a meeting or road, you have to response back as early as possible</li>
                                                    <li>Your mobile must always be responding.</li>
                                                    
                                                    </ul>
        
        
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_8">
                                                Outstation Visit Expense Claim Policy </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_8" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    <strong>Visit Expenditure Bill</strong><br>
                                                    Visit Expenditure Bills are claimed when an employee visits the customer on the instruction of the Manager / TSS. 
                                                    Please note the following basic things before proceeding for the tour.
                                                    <ul>
                                                    <li>All the pre-requisites for the tour are done i.e. things required for the tour are arranged.</li>
                                                    <li>The tour has to be <strong>productive</strong> in order to justify the expense done during the trip.</li>
                                                    <li>The permission of the Manager / TSS will be required to move back from the destination, without <strong>approval and satisfaction of the customer </strong>the person must not return because this will generate a non productive visit and in such case VXB will not be paid by the company.</li>
                                                    <li>The company will pay up to Rs. 700.oo per night hotel room rent at outstation for TS and SAP Department personals and up to Rs. 1000.oo for the Managers. Make sure you do not claim any false hotel bills. </li>
                                                    <li>In case more than one employee are on the same tour they will share hotel room. In such case the room rent must not exceed the allocated limit and will be paid at actual. The combined bill will be attached with the VXB of any one of the employee, no need to have separate bills for each employee</li>
                                                    <li>In case a person stays a night at outstation the company will pay Rs. 300.oo in addition to the DA to accommodate any extra expense for his meal at night / Breakfast. Note this payment is only in case of Hotel Stay.</li>
                                                    <li><strong>The amount required for traveling from home, office to the Bus Terminal or any Local travelling is included in your DA, regardless of the time of travelling.</strong></li>
                                                    <li>The travelling will be through buses on normal cabins (no VIP travelling is allowed). Daewoo travel is only with the pre-approval from the TSS / Manager and for long distances only.</li>
                                                    
                                                    </ul>
                                                    <strong>Verification of Claims / Bills</strong>
                                                    <ul>
                                                    <li>All the bills (VXB, Tickets, Hotel Bills and Petrol / Fuel Station Bills) will be verified by the accounts department.</li>
                                                    <li><strong>One must not claim any false amount in the bill, if found and proven, fine will charged and fine amount will be the sole decision of Finance Department</strong> this is in addition to the Disciplinary action against this person. </li>
                                                    <li>If any inquire the amount will be paid minus the disputed claim, an email will be generated to the person submitting the bill from the Finance Department. All such inquiry must be resolved within 7 days.</li>
                                                    <li>Each such email will be an inquiry number, in case the claim is proven right the amount will be paid and in case a false claim is proven fine will be charged.</li>
                                                    </ul>
                                                    
                                                    <strong>Procedure to Submit Bill</strong>
                                                    <ul>
                                                    <li>The bill along with documents must be submitted to the accounts within 7 days of tour.</li>
                                                    <li>The VXB will be prepared by the person doing tour and will be submitted to the TSS / Manager of department following the management hierarchy, once the TSS / Manager receives bill he will submit to STCO after verification and his signature.</li>
                                                    <li>Each VXB will be must be accompanied by the following documents:
                                                    <ul>
                                                    <li>VXB Bill Form</li>
                                                    <li>Travel Tickets (in case of ticket loss the amount will not be paid, so do not write or claim because this will delay your VXB Payment process).</li>
                                                    <li>Hotel Bills (in case a night stay is done)</li>
                                                    <li>Toll Plaza Tickets</li>
                                                    <li>Visit Report</li>
                                                    </ul>
                                                    </li>
                                                    <li>For Technical Tour: TS Report having signature / contact number of the Pathologist.</li>
                                                    <li>Each VXB received at accounts (if no quires) will be cleared in 2 weeks from the date of receipt at Accounts Department HO.</li>
                                                    </ul>
        
        
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_9">
                                                Performance Evaluation </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_9" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    <strong>Performance Evaluation Form (PEF)</strong><br>
                                                    
                                                    <ul>
                                                    <li>All TSS will have to fill PE Form Online Quarterly basis as per PEF Policy Document</li>
                                                    <li>You are not liable to any promotion or clearance of probation period until you have submitted your original set of educational documents and passport.</li>
                                                    <li>You may get promoted to next grade and get increased Basic salary provided you meet the following criteria.</li>
                                                    <li>A case for Promotion + salary increment will be forwarded to BOD only when an employee gets
                                                    
                                                       <ul>
                                                       <li>More than 90% marks in two consecutive PEF.</li>
                                                       <li>No major violation of SOP in that period</li>
                                                       <li>Satisfactory STATISTICS</li>
                                                       <li>Regular growth in sale figures in monthly Target reports</li>
                                                       <li>If you’re Red File, don’t have any violation note in terms of Punctuality, obedience, honesty, discipline etc. </li>
                                                       <li>No fine issued during this period</li>
                                                       </ul>
                                                    </li>
                                                    </ul>
                                                    
                                                    <strong>FSE Promotion ladder</strong>
                                                    <ul>
                                                    <li>Field Service Engineer (FSE)</li>
                                                    <li>Senior FSE – 1 </li>
                                                    <li>Senior FSE – 2</li>
                                                    <li>Technical Support Supervisor (TSS)</li>
                                                    <li>Assistant Manager TS</li>
                                                    <li>Deputy Manager TS</li>
                                                    <li>Manager TS</li>
                                                    </ul>
                                                    
                                                    <strong>SAP Promotion ladder</strong>
                                                    <ul>
                                                    <li>Sales & Application Representatives (SAP</li>
                                                    <li>Senior Sales & Application Representatives (SAP-1) </li>
                                                    <li>Sales & Application Executive (SAP-2)</li>
                                                    <li>Senior Sales & Application Executive  (SAP-3)</li>
                                                    <li>Assistant Manager SAP (SAP-AM)</li>
                                                    <li>Deputy Manager Sales SAP (SAP-DM)</li>
                                                    <li>Manager SAP (SAP-Manager)</li>
                                                    </ul>
                                                    
                                                    
        
        
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_10">
                                                PMA Leave Policy </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_10" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    <strong>Annual Leave</strong><br>
                                                    
                                                    <ul>
                                                    <li>All employees are entitled to paid annual leave as twenty (21) working days per year. Leave is provided for the purpose of rest and recreation and employees are encouraged to avail this facility strictly according to the leave approval procedure.</li>
                                                    <li>Leave balance did not carry forward to the next year. If employee did not take it shall elapse at the completion of the calendar year. </li>
                                                    <li>Weekends and public holidays falling during the course of annual leave will not be counted as earned annual leave’s calculation is based on working days.</li>
                                                    <li><strong>21 annual leave commence from July 01 and conclude at the end of the June of the next year.</strong> Earned leave shall accrue on monthly basis and its entitlement will be counted from the date of employment, i.e. it will be inclusive of the probationary period.
                                                    </li>
                                                    <li>Person cannot take more than 7 day’s off at a time without 2 weeks prior notice. Employee can avail one leave in a month during the probationary period. </li>
                                                    </ul>
                                                    <strong>Hospitalization Leave </strong>
                                                    <ul>
                                                    <li>Sick leaves considered as annual leaves. All applications for sick leave for a period of three or more days must be supported by a medical certificate / Prescription or Record from a doctor.</li>
                                                    <li>Up to 60 days paid maternity leave is allowed to all confirmed female employees. </li>
                                                    </ul>
                                                    
                                                    <strong>Leave without Pay </strong>
                                                    <ul>
                                                    <li>Leave without pay can only be granted for exceptional circumstances. It can be availed only on prior approval of the Director.</li>
                                                    <li>Maximum leave without pay that can be allowed is ten (10) working days at any one time and will be allowed only once in Two years, which will be granted by the Competent Authority on a case-to-case basis. This does not apply to education leave without pay, which will be granted by the Competent Authority on a case-to-case basis. </li>
                                                    </ul>
                                                    
                                                    <strong>Public Holidays</strong>
                                                    <p>The employee shall be entitled to public holidays as per the official list issued every year by the Government of Pakistan, or by the Provincial Government. No leave application form need be completed for availing public holidays.</p>
                                                    
                                                    <strong>Fine Code</strong><br>
                                                 <table class="table table-striped table-bordered table-hover flip-content">
                                                <tbody>
                                
                                                  <tr>
                                                    <td> Leave is taken above limit of 21 days (with Form Submission) </td>
                                                    <td>Salary will not be paid for such period</td>
                                                    
                                                 </tr>
                                
                                                  <tr>
                                                    <td> Leave is taken above limit of 21 days (without Form Submission & Prior approval) </td>
                                                    <td> Salary will not be paid for such period + Rs. 500 </td>
                                                   
                                                  </tr>
                                
                                                  <tr>
                                                    <td> Leave is taken within limit of 21 days (without Form Submission & Prior approval)</td>
                                                    <td> Rs. 500</td>
                                                 
                                                  </tr>
                                                  
                                                   <tr><td>If person does not take any leave during the year</td>
                                                    <td> A Bonus Salary of 21 days will be paid</td>
                                                 
                                                  </tr>
                                                  </tbody>
                                                </table>	
        
        
                                                    </p>
                                                
                                                </div>
                                            </div>
                                </div>
                                
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_11">
                                                Product Demonstration Procedure </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_11" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    <strong>Instrument Demonstration Procedure</strong><br>
                                                    
                                                    <ul>
                                                    <li>SAP will schedule Instrument demonstration with customer and will inform concern Managers and TSS preferably a week before.</li>
                                                    <li>For Instrument Demonstration SAP will prepare the proposed DEMO Program and get approval from Manager.</li>
                                                    <li>SAP will inform TSS the main aim of the DEMO, what comments are required on the final report? Lab inside News and Competitor activities etc…</li>
                                                    <li>SAP along with TSS will visit the customer to do Pre-DEMO Survey and prepare Program. TSS will make everything ready according to the list one day before the Demonstration.</li>
                                                    <li>For Instrument Demonstration TSS will prepare the List of Items required for Demonstration and will prepare the “FOC Products Requisition Form” for any consumable / kit / Accessories required along with Instrument and send for approval as mentioned on the form.</li>
                                                    <li>TS Person is fully responsible for all the Items he takes for the Demonstration of Instruments. All the Items should be returned to office is the perfect working condition and packing.</li>
                                                    <li>The movement of all Items for Demonstration from office to the customer and back to the office after Demonstration is responsibility of TSS or his assigned TS Persons. </li>
                                                    <li>It is duty of TS Person to update SAP on demonstration progress on daily basis. SAP must be involved in the complete Demonstration Process. </li>
                                                    <li>However it is complete responsibility of TSS or his assigned TS Person to give the best demonstration.</li>
                                                    <li>TSS will fill the "Product Demonstration" form and get satisfactory signature from the customers. Final copy should be given to the Manager and original should be submitted to Director Sales & Technical Support</li>
                                                    </ul>
                                                    <strong>Kits Demonstration Procedure </strong>
                                                    <ul>
                                                    <li>SAP will schedule kit demonstration with customer and with the consent of Manager.</li>
                                                    <li>For kit Demonstration / Evaluation SAP will prepare the proposed DEMO Program and get approval from Manager.</li>
                                                    <li>SAP will visit the customer to do Pre-DEMO Survey and prepare Program. SAP will make everything ready according to the list one day before the Demonstration.</li>
                                                    <li>For Demonstration, SAP will prepare the List of Items required for Demonstration and will fill the “FOC Products Requisition Form” for any consumable / kit / Accessories required along with Instrument and send for approval to concern Manager and Director.</li>
                                                    <li>SAP is fully responsible for all the Items, he takes for the Demonstration. All un-used material should be returned to office is the perfect working condition and packing.</li>
                                                    <li>The movement of all Items for Demonstration from office to the customer and back to the office after Demonstration is responsibility of SAP.</li>
                                                    <li>TSS will fill the "Product Demonstration" form and get satisfactory signature from the customers. Final copy should be given to the Manager and original should be submitted to Director Sales & Technical Support
        
        </li>
                                                    </ul>
                                                    
                                                    
                                                    </p>
                                                
                                                </div>
                                            </div>
                                </div>
                                <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_12">
                                                Products Return </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_12" class="panel-collapse collapse">
                                                <div class="panel-body" style="height:200px; overflow-y:auto;">
                                                    <p>
                                                    
                                                    
                                                    <ul>
                                                    <li>PRF Form is filled for any product returned / exchanged due to failure.</li>
                                                    <li>This is usually related to kits and Reagents. On a service call, SAP Person will first troubleshoot the problem, if the problem is not solvable than make a decision about the product return. </li>
                                                    <li>SAP will not authorize to allow return of product without permission of Manager.</li>
                                                    <li>Once the product replacement is allowed by the Manager, SAP will complete the PRF Form get it signed from customer and submit to the Manager.</li>
                                                    
                                                    </ul>
                                                    
                                                    
                                                    
                                                    </p>
                                                
                                                </div>
                                            </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_13">
                                        Visiting Card </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_3_13" class="panel-collapse collapse">
                                        <div class="panel-body" style="height:200px; overflow-y:auto;">
                                            <p>
                                            
                                            
                                            <ul>
                                            <li>Each Employee <u>can print their own visiting cards</u> for the quantity they wish to print.</li>
                                            <li>The format of the Card must be STRICKTLY as per attached file. Only edit your name, designation and contact details with the approval of your BOD.</li>
                                            <li>PMA will pay Rs. 1.00 for each card i.e. Rs. 500/. In total for the 500 cards.</li>
                                            <li>It is the responsibility of the employee to negotiate the price with the vendor.</li>
                                            <li>The payment to the employee will be made after submission of bill along with two visiting cards.</li>
                                            </ul>
                                            <img class="img-responsive" style="width:600px;height:auto;" src="<?php echo base_url();?>assets/global/img/PMA Visiting Card - Front Side.jpg" />
                                            <p>&nbsp;</p>
                                            <img class="img-responsive" style="width:600px;height:auto;" src="<?php echo base_url();?>assets/global/img/PMA Visiting Card-Backside.jpg" />
                                            
                                            
                                            </p>
                                        
                                        </div>
                                    </div>
                        		</div>
								-->
                            </div>
                       </div>
			  </div>
			 </div>
            </div>
            </div>	
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>
