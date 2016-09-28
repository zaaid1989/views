<?php $this->load->view('header');?>
      <h3 class="page-title"> Technical Service Personal Visit Report <small></small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        Complaints
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        TS Report
                    </li>
                </ul>

        <div class="page-toolbar">

         

        </div>

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">
            <?php
				  $nsql="select * from tbl_complaints where pk_complaint_id ='".$this->uri->segment(3)."'";
				  $n2sql=$this->db->query($nsql);
				  $get_compalaint_result=$n2sql->result_array();
			?>
          
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          
          <div class="portlet box purple">
            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Complaint Information</div>

              <div class="tools">
                   <a href="javascript:;" class="collapse"> </a> 
                   <a href="javascript:;" class="remove"> </a> 
              </div>

            </div>
            <div class="portlet-body">
            
              <div class="row">
                <div class="col-md-4">
                
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                              <tr><th>Attribute</th><th>Value</th></tr>
                            </thead>
                            <tbody>
                               <tr class="odd gradeX">
                                      <td>
                                      TS Number
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['ts_number'] ;  ?></td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      Customer
                                     </td>
                                     <td> 
                                     <?php    
                                        $nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$get_compalaint_result[0]['fk_customer_id']."'");
                                        $n2sql3=$nsql3->result_array();
                                        echo $n2sql3[0]['client_name'];
                                     ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      City
                                     </td>
                                     <td> 
                                     <?php    
                                        $nsql3=$this->db->query("select * from tbl_cities where pk_city_id ='".$get_compalaint_result[0]['fk_city_id']."'");
                                        $n2sql3=$nsql3->result_array();
                                        echo $n2sql3[0]['city_name'];
                                     ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">
                                    <td>
                              Equipment
                             </td>
                             <td>
                              <?php    
                                  $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
                                  $n2sql3=$nsql3->result_array();
								  if($nsql3->num_rows()>0)
								  {
								  $nsql4=$this->db->query("select * from tbl_products where pk_product_id ='".$n2sql3[0]['fk_product_id']."'");
                                  $n2sql4=$nsql4->result_array();
                                  echo $n2sql4[0]['product_name'];
								  }
                               ?>
                             </td>  
                               </tr> 
                               <tr class="odd gradeX">							   
									<td>
									  Serial No.
									 </td>
									 <td>
								   <?php    
									  $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
									  if($nsql3->num_rows()>0)
								  		{
									  $n2sql3=$nsql3->result_array();
									  echo $n2sql3[0]['serial_no'];
										}
								   ?>
									 </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                       Warranty Status
                                     </td>
                                     <td> 
									 	<?php //echo $get_compalaint_result[0]['warranty_status'];  ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">
									<td>
                                  Software Version
                                 </td>
                                 <td>
                                  <?php echo $get_compalaint_result[0]['instrument_software_version'];  ?>
                                 </td>
                               </tr>                                  
                            </tbody>
                       </table>
                </div>
                  
               </div>
               
                <div class="col-md-4">
                
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                              <tr><th>Attribute</th><th>Value</th></tr>
                            </thead>
                            <tbody>
                               <tr class="odd gradeX">
                                      <td>
                                      Caller Name
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['caller_name'];  ?>
                                     </td>
                               </tr>
							   <tr class="odd gradeX">
                                      <td>
                                      Caller Contact Number
                                     </td>
                                     <td> <?php if ($get_compalaint_result[0]['phone']!="") echo $get_compalaint_result[0]['phone'];
												//else echo $get_compalaint_result[0]['landline'];
									 ?>
                                     </td>
                               </tr>
							   <tr class="odd gradeX">
                                <td>
                                   FSE Name
                                 </td>
                                 <td>
                                  <?php    
                                  $nsql3=$this->db->query("select * from user where id ='".$get_compalaint_result[0]['assign_to']."'");
                                  $n2sql3=$nsql3->result_array();
                                  echo $n2sql3[0]['first_name'];
                               ?>
                                 </td>  
                           </tr>
                               
                               <tr class="odd gradeX">
                                      <td>
									  Kit Name
									 </td>
									 <td>
									  <?php echo $get_compalaint_result[0]['kit_name'];  ?>
									 </td>
                               </tr> 
                               <tr class="odd gradeX">
                                      <td>
                                      Kit Lot
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['kit_lot_no'];  ?>
                                                                                             </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                  Kit Pack Size
                                 </td>
                                 <td>
                                  <?php echo $get_compalaint_result[0]['make_pack'];  ?>
                                 </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      Kit Expiry Date
                                     </td>
                                     <td> <?php //echo $get_compalaint_result[0]['ts_number'];  ?>
                                     </td>
                               </tr>
                                                                               
                                   
                            </tbody>
                       </table>
                </div>
                  
               </div>
               
                <div class="col-md-4">
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                              <tr><th>Attribute</th><th>Value</th></tr>
                            </thead>
                         <tbody>
							<tr class="odd gradeX">
                                      <td>
									  Call Received Date
									 </td>
									 <td> 
									 <?php echo date('d-M-Y', strtotime($get_compalaint_result[0]['date']));  ?>
									 </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
									  Call Received Time
									 </td>
									 <td>
									  <?php echo date('H:i', strtotime($get_compalaint_result[0]['date']));  ?>
									 </td>
                               </tr>
                           
                           <tr class="odd gradeX">
                                  <td>
                                       Reporting Date
                                     </td>
                                     <td> <?php echo date('d-M-Y', strtotime($get_compalaint_result[0]['reporting_date']));  ?>
                                                                                             </td>
                           </tr>
						   
						   <tr class="odd gradeX">
                                      <td>
                                        Reporting Time
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['reporting_time'];  ?>
                                                                                             </td>
                               </tr>
							   <?php /*
                               <tr class="odd gradeX">
                                      <td>
                                       PS Name
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['ps_name'];  ?>
                                                                                             </td>
                               </tr> 
							   */ ?>
                        <tr class="odd gradeX">
                                  <td>
                                   Solution Date  
                                 </td>
                                 <td>
                                  <?php echo date('d-M-Y', strtotime($get_compalaint_result[0]['solution_date']));  ?>
                                 </td>
                           </tr>
						   
                           <tr class="odd gradeX">
                                  <td>
                                   Solution Time
                                 </td>
                                 <td>
                                  <?php echo $get_compalaint_result[0]['solution_time'];  ?>
                                 </td>
                           </tr>
						   
						   <tr class="odd gradeX">
								<td>
								Status
								</td>
								<td>
                                <?php 
								  $this->load->model("complaint_model");
								  $obj=new Complaint_model();
								  $obj->current_status($get_compalaint_result[0]['status']);
								?>
								</td>						   
						   </tr>
                                                                      
                            </tbody>
                       </table>
                </div>
               </div>
              </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
        
          <!-- END EXAMPLE TABLE PORTLET-->   

<!-- Begin Portlet -->
						  <div class="portlet box green-seagreen" id="working_details">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs"></i>Troubleshooting / Working Details
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
									
									<a href="javascript:;" class="remove">
									</a>
								</div>
							</div>
							
							
							
							<div class="portlet-body">
							
							<!-- add new details button-->
							<div class="row">
							  <div class="col-md-6">
								<div class="btn-group">
								<?php /* Button for opening page
								  <a href="<?php echo base_url();?>complaint/add_working_details/<?php echo $this->uri->segment(3); ?>" id="sample_editable_1_new" class="btn green-seagreen"> 
									  Add Working / Troubleshooting Details
									  <i class="fa fa-plus"></i> 
								  </a>
								  */ ?>
								  <!-- button for Modal -->
								 <!-- <a href="#" id="sample_editable_1_new" class="btn green-seagreen" data-toggle="modal" data-target="#myModal"> 
									  Add Working / Troubleshooting Details
									  <i class="fa fa-plus"></i> 
								  </a>-->
							<!-- Modal Form Begin (z)-->
							<!-- Modal -->
							<div id="myModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Working Trouble Shooting Details</h4>
								  </div>
								  <div class="modal-body">
								  <!-- Modal from Metronics -->
								   <form action="<?php echo base_url();?>complaint/add_working_details_insert" class="form-horizontal" method="post">
                
									
				
                 
									<div class="form-group row">
									<label class="col-md-3 control-label">Date</label>
									<div class="col-md-9">
									<input type="text" class="datepicker2 form-control" name="wd_date">
									</div>
									</div>

									<div class="form-group row">
									<label class="col-md-3 control-label">Time</label>
									<div class="col-md-9">
									<input type="text" class="form-control timepicker timepicker-no-seconds" name="wd_time" placeholder="Enter time">
									</div>
									</div>

									<div class="form-group row">
									<label class="col-md-3 control-label">Action Taken</label>
									<div class="col-md-9">
									<textarea class="form-control" name="action_taken" placeholder="Enter your action details" rows="3"></textarea>
									</div>
									</div>
									
									<div class="form-group row">
									<label class="col-md-3 control-label">Result</label>
									<div class="col-md-9">
									<textarea class="form-control" name="result" placeholder="Enter the result of your action" rows="3"></textarea>
									</div>
									</div>

									<div class="form-group row">
									<label class="col-md-3 control-label">Analysis</label>
									<div class="col-md-9">
									<textarea class="form-control" name="analysis" placeholder="Enter your analysis of result" rows="3"></textarea>
									</div>
									</div>
									
									<input type="hidden" name="fk_complaint_id" value="<?php echo $this->uri->segment(3);?> ">
                

                    
                
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-offset-8 col-md-4">
                                    <button type="submit" class="btn green-seagreen" >Submit</button>
                                    <button type="button" class="btn default" data-dismiss="modal">Cancel</button>

                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </form>
								  <!-- Form End -->
						
								  </div>
								  
								</div>

							  </div>
							</div>

							
								</div>
							  </div>   
							</div>
							
							
							<!-- add new details -->
							
							<div class="portlet-body flip-scroll">					
								<div class="row">
								  <div class="col-md-12"> 
									<div class="table-scrollable">
									
								<table class="table table-bordered table-striped table-condensed flip-content">
								<thead class="flip-content">
								<tr>
									<th class="date">
										 Date
									</th>
									<th class="time">
										 Time
									</th>
									<th>
										 Action Taken
									</th>
									<th>
										 Result
									</th>
									<th>
										 Analysis
									</th>
								</tr>
								</thead>
								<tbody>
								
								<?php
								$ty22=$this->db->query("select * from tbl_working_details WHERE fk_complaint_id='" . $this->uri->segment(3)."'");
								$rt22=$ty22->result_array();
								if (sizeof($rt22) == "0") {
									//do something
								} else {
									foreach ($rt22 as $get_working_details) {
										?>
										<tr>											
											<td>
												<?php echo date('d-M-Y', strtotime($get_working_details["date"])); ?>
												<?php //echo $get_working_details["date"] ?>
											</td>
											
											<td>
												<?php echo $get_working_details["time"] ?>
											</td>
											
											<td>
												<?php echo urldecode($get_working_details["action_taken"]); ?>
											</td>
											
											<td>
												<?php echo urldecode($get_working_details["result"]); ?>
											</td>
											
											<td>
												<?php echo urldecode($get_working_details["analysis"]); ?>
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
							</div>
							</div>
						</div>
<!-- END SAMPLE TABLE PORTLET-->	  


<!-- Begin Portlet -->
						  <div class="portlet box yellow-gold" id="qc_dataa">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs"></i>Calibration / Quality Control Data
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
									
									<a href="javascript:;" class="remove">
									</a>
								</div>
							</div>
							
							
							
							<div class="portlet-body">
							
							<!-- add new details button-->
							<div class="row">
							  <div class="col-md-6">
								<div class="btn-group">
								<?php /*
								  <a href="<?php echo base_url();?>complaint/add_qc_data/<?php echo $this->uri->segment(3); ?>" id="sample_editable_1_new" class="btn yellow-gold"> 
									  Add Calibration / Quality Control Data
									  <i class="fa fa-plus"></i> 
								  </a> */ ?>
								  
								  <!-- button for Modal -->
								  <!--<a href="#" id="sample_editable_1_new" class="btn yellow-gold" data-toggle="modal" data-target="#myModal2"> 
									  Add Calibration / Quality Control Data
									  <i class="fa fa-plus"></i> 
								  </a>-->
								</div>
								
															<!-- Modal Form Begin (z)-->
							<!-- Modal -->
							<div id="myModal2" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Calibration / QC Data</h4>
								  </div>
								  <div class="modal-body">
								  <!-- Modal from Metronics -->
								   <form action="<?php echo base_url();?>complaint/add_qc_data_insert" class="form-horizontal" method="post">

									
									<div class="form-group row">
									<label class="col-md-3 control-label">Calibration Data</label>
									<div class="col-md-9">
									<textarea class="form-control" name="calibration_data" placeholder="Enter text" rows="3"></textarea>
									</div>
									</div>

									<div class="form-group row">
									<label class="col-md-3 control-label">QC Data</label>
									<div class="col-md-9">
									<textarea class="form-control" name="qc_data" placeholder="Enter text" rows="3"></textarea>
									</div>
									</div>
									
									<input type="hidden" name="fk_complaint_id" value="<?php echo $this->uri->segment(3);?> ">
                

                    
                
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-offset-8 col-md-4">
                                    <button type="submit" class="btn yellow-gold">Submit</button>
                                    <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </form>
								  <!-- Form End -->
						
								  </div>
								  
								</div>

							  </div>
							</div>

	<!--  enddddddddddddddddddddddddddddddddddddddd modallllllllllll-->
							  </div>   
							</div>
							<!-- add new details -->
							
							<div class="portlet-body flip-scroll">					
								<div class="row">
								  <div class="col-md-12"> 
									<div class="table-scrollable">
									
								<table class="table table-bordered table-striped table-condensed flip-content">
								<thead class="flip-content">
								<tr>
									<th>
										 Calibration Data
									</th>
									<th>
										 QC Data
									</th>
								</tr>
								</thead>
								<tbody>
								
								<?php
								$ty22=$this->db->query("select * from tbl_qc_data WHERE fk_complaint_id='" . $this->uri->segment(3)."'");
								$rt22=$ty22->result_array();
								if (sizeof($rt22) == "0") {
									//do something
								} else {
									foreach ($rt22 as $get_qc_data) {
										?>
										<tr>											
											<td>
												<?php echo urldecode($get_qc_data["calibration_data"]); ?>
											</td>
											
											<td>
												<?php echo urldecode($get_qc_data["qc_data"]); ?>
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
							</div>
							</div>
						</div>
<!-- END SAMPLE TABLE PORTLET-->        
         
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
            
          <div class="portlet box red">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Other Details</div>

            </div>

            <div class="portlet-body">

              <div class="portlet-body flip-scroll">
                <div class="row">
                          <div class="col-md-12 form-horizontal">
						  
							
							<div class="form-group">
							<label class="col-md-4 control-label">Reporting Date</label>
								<div class="col-md-4">
									<input type="text" class="datepicker2 form-control" name="reporting_date" value="<?php echo 
									date('d-M-Y', strtotime($get_compalaint_result[0]['reporting_date']));
									?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Reporting Time</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="reporting_time" value="<?php echo $get_compalaint_result[0]['reporting_time'] ; ?>">
								</div>
							</div>
							<?php /*
							<div class="form-group">
							
							<label class="col-md-4 control-label">PS Name</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="ps_name" value="<?php echo $get_compalaint_result[0]['ps_name'] ; ?>">
								</div>
								
							</div>*/ ?>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Solution Date</label>
								<div class="col-md-4">
									<input type="text" class="datepicker2 form-control" name="solution_date" value="<?php echo 
									date('d-M-Y', strtotime($get_compalaint_result[0]['solution_date']));
									?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Solution Time</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="solution_time" value="<?php echo $get_compalaint_result[0]['solution_time'] ; ?>">
								</div>
							</div>
							
                            <div class="form-group">
							<label class="col-md-4 control-label">Actual Cause of Problem</label>							
								<div class="col-md-4">								
									<!--<select id="problem_cause" name="problem_cause" class="form-control  ">
									<option value="">--Choose--</option>
									<option value="Probe Problem"
									<?php if($get_compalaint_result[0]['problem_cause']=="Probe Problem"){?> selected="selected"<?php }?>
									>Probe Problem</option>
									<option value="Calibration Problem"
									<?php if($get_compalaint_result[0]['problem_cause']=="Calibration Problem"){?> selected="selected"<?php }?>
									>Calibration Problem</option>
									</select>-->
                                    <input type="text" class="form-control" name="problem_cause" value="<?php echo $get_compalaint_result[0]['problem_cause'] ; ?>">								
								</div>
                            </div>
							
							
							
                          </div>
                        </div>

				</div>
				
            </div>

          </div>

          <!-- END EXAMPLE TABLE PORTLET-->
          
          
           <!-- BEGIN EXAMPLE TABLE PORTLET-->
            
          <div class="portlet box blue-chambray">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Replacement Details (if any)</div>

            </div>

            <div class="portlet-body">

              <div class="portlet-body flip-scroll">
                <div class="row">

                          <div class="col-md-12"> 

                            <!-- BEGIN SAMPLE TABLE PORTLET-->

                            <div class="table-scrollable">

                                  <table class="table table-hover table-bordered">

                                    <thead>

                                      <tr>

                                        <th> Cat. / Part #</th>

                                        <th> Kit / part Description </th>

                                        <th> DC Number </th>

                                        <th> Qty </th>

                                        <th> Price </th>

                                        

                                      </tr>

                                    </thead>

                                    <tbody>

                                      <tr>

                                        <td>  <input type="text" class="form-control" value="" readonly name="part_no"> </td>

                                        <td>  <input type="text" class="form-control" value="" readonly name="part_description"> </td>

                                        <td>  <input type="text" class="form-control" value="" readonly name="dc_no"> </td>

                                        <td>  <input type="text" class="form-control" value="" readonly name="quantity"> </td>

                                        <td>  <input type="text" class="form-control" value="" readonly name="price"> </td>

                                        

                                      </tr>

                                    </tbody>

                                  </table>

                                </div>

                            <!-- END SAMPLE TABLE PORTLET--> 

                          </div>

                        </div>

              </div>

            </div>

          </div>

          <!-- END EXAMPLE TABLE PORTLET-->
          
          
          
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box blue">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Customer Feedback</div>

            </div>

            <div class="portlet-body">
			 <div class="portlet-body flip-scroll">
                <div class="row">
				
				<div class="col-md-12 ">
					<div class="form-group">
						<div class="col-md-12">
                              <textarea class="form-control" name="customer_feedback"><?php echo $get_compalaint_result[0]['customer_feedback'] ;?></textarea>
                        </div>
					</div>
					
					<div class="form-group">
					<div class="col-md-12">
							<?php /* if($get_compalaint_result[0]['status']=='Pending' || $get_compalaint_result[0]['status']=='Shifted' || $get_compalaint_result[0]['status']=='Pending (BB)') { ?>
                            <span class="btn blue fileinput-button">
								<input type="file" name="uploadFile" multiple="">
							</span>
							<?php } */ ?>
                            <p>
                            <?php
								if($get_compalaint_result[0]['image']=="")
								{
									$user_image3="noimage.jpg";
								}
								else
								{
									$user_image3	=	$get_compalaint_result[0]['pk_complaint_id'].'.'.$get_compalaint_result[0]['image'];
								}
							?>
							<?php /*	<img src="<?php echo base_url();?>usersimages/complaint_images/<?php echo $user_image3;?>" alt="" style="width:200px;"/>*/ ?>
							<a data-toggle="modal" data-target="#myModal3" style="cursor:pointer;"><img src="<?php echo base_url();?>usersimages/complaint_images/<?php echo $user_image3;?>" alt="" style="width:200px;"/></a>
								
							<div id="myModal3" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><?php echo $user_image3; ?></h4>
								  </div>
								  <div class="modal-body">
								  <!-- Modal from Metronics -->
								  <div class="row">
								  <img src="<?php echo base_url();?>usersimages/complaint_images/<?php echo $user_image3;?>" alt="" class="img-responsive"/>
								  </div>
							  </div>
								  
								</div>

							  </div>
							</div>
                            </p>
                    </div>
					</div>
				</div>	
                </div>
			
			<input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?> ">
			
                <div class="form-actions right">
				<div class="row">
                        <div class="col-md-12">
                            <div class="row">
					<div class="col-md-offset-10 col-md-2">
                        
                        
                        
					</div>
					</div>
					</div>
					</div>
                 </div>
			  </div>
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET-->
          <form action="<?php echo base_url();?>complaint/update_ts_report_supervisor" class="form-horizontal" method="post" enctype="multipart/form-data">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box blue">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Update status</div>

            </div>

            <div class="portlet-body">
			 <div class="portlet-body flip-scroll">
                <div class="row">
                    <div class="col-md-12 ">
                    	<div class="form-group">
                        <label class="col-md-4 control-label">Update status</label>							
                            <div class="col-md-4">								
                                <select id="problem_cause" name="status" class="form-control" onchange="problem_cause_change(this.value)" required>
                                    <option value="">--Choose--</option>
                                    <option value="Closed"
                                        <?php /* if($get_compalaint_result[0]['status']=="Closed"){?> selected="selected"<?php } */?>>
                                            Close
                                    </option>
                                    <option value="Pending (BB)"
                                        <?php  /* if($get_compalaint_result[0]['status']=="Pending (BB)"){?> selected="selected"<?php } */?>>
                                            Pending (BB)
                                    </option>
                                </select>								
                            </div>
                        </div>
                    </div>	
                </div>
                <div class="row">
                    <div  id="bounceback"  class="col-md-12" style="display:none">
                   
                        <div class="form-group">
                          <label class="col-md-4 control-label">Assign to</label>

                          <div class="col-md-4">

                           <!-- <select id="problem_type2" name="problem_type2" class="form-control" onchange="pendingtsshow(this.value)"> -->
						   <select id="problem_type2" name="problem_type2" class="form-control" >
                                <option value="<?php echo $get_compalaint_result[0]['assign_to'] ?>">--Choose--</option>
                                <?php 
                                      $ty21=$this->db->query("select * from user WHERE id='" . $this->session->userdata('userid')."'");
                                      $rt21=$ty21->result_array();
                                      $ty22=$this->db->query("select * from user WHERE fk_office_id='" . $rt21[0]['fk_office_id']."' AND userrole IN('FSE','Supervisor') ORDER BY  `fk_office_id` ,  `userrole` ASC ");
                                      $rt22=$ty22->result_array();
                                      if (sizeof($rt22) == "0") {
                                          //do something
                                      } else {
                                          foreach($rt22 as $engineer)
                                          {
                                          ?>
                                          <option value="<?php echo $engineer['id'];?>" ><?php echo $engineer['first_name'];?></option>
                                      <?php }
                                      }
                                      ?>
                           </select>
						   </div>
						   <div class="col-md-12">
						   <br />
						   <table class="table table-striped table-condensed table-bordered table-hover flip-content">
						   <thead>
						   <tr>
						   <th>FSE/SAP</th><th>Total Complaints (30 Days)</th><th>Pending Complaints</th><th>Total PM Calls (30 Days)</th><th>Pending PM Calls</th>
						   </tr>
						   </thead>
						   <?php
						   
						   $qua="SELECT * from user where fk_office_id =  '". $rt21[0]['fk_office_id'] ."' AND userrole IN('FSE','Salesman','Supervisor') ORDER BY  `fk_office_id` ,  `userrole` ASC ";
							
							$gha=$this->db->query($qua);
							$rta=$gha->result_array();
							
							foreach($rta as $valuea)
							{
								$userid			 =	$valuea['id'];
								//$complaint_id	 =	$this->input->post('complaint_id');


								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='complaint' AND status!='Closed'";
								$gh=$this->db->query($qu);
								$result = $gh->result_array();
								$pending_ts = sizeof($result); 

								$qu="select * from tbl_complaints where assign_to='".$userid."' AND complaint_nature='PM' AND status!='Completed' ";
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
								
								//echo '<table class="table table-striped table-bordered table-hover flip-content">';
								echo '<tr>';
								echo "<td>".$valuea['first_name']." </td> <td> ".$month_ts." </td> <td> ".$pending_ts."</td> <td>".$month_pm."</td> <td> ".$pending_pm."</td>";								
								echo '</tr>';
								
							}
						   ?>
						   </table>
						   </div>
                           <script>
						   function pendingtsshow(userid)
						   {
							   var formdata =
								  {
									userid: userid,
									complaint_id: <?php echo $this->uri->segment(3);?>
								  };
							  $.ajax({
								url: "<?php echo base_url();?>complaint/select_user_complaint_ajax",
								type: 'POST',
								data: formdata,
								success: function(msg){
									$("#pendingtsshow").html(msg);
									}
								})
								return false;
						   }
						   </script>

                    <!--      </div> -->
                        </div>
                        <div class="form-group">
                          <label class="col-md-4 control-label">&nbsp;</label>
                          <div class="col-md-4">
                            <p id="pendingtsshow"></p>
                          </div>
                        </div>
                      </div>
                </div>
                
                <div id="completed" style="display:none">
                       <div class="row" style="margin:0 0 0 0;">
                          <div class="col-md-6">

                           <div class="form-group">

                              <label class="control-label">Verification</label>
                                    <div class="radio-list">

                                      <label class="radio-inline">

                                      <input type="radio"  name="optionsRadios"id="optionsRadios1" 
									  <?php if($get_compalaint_result[0]['verification_method']=='1' || $get_compalaint_result[0]['verification_method']==''){?>
                                      checked="checked"
									  <?php }?> 
                                      value="1"> Customer Call Back </label>

                                      <label class="radio-inline">

                                      <input type="radio"  name="optionsRadios"id="optionsRadios1" 
									  <?php if($get_compalaint_result[0]['verification_method']=='2'){?>checked="checked"<?php }?> value="2"> Personal Visit </label>
                                    </div>

                                 </div>

                            </div>

                       </div>
                       <div class="row" style="margin:0 0 0 0;">
                           <div class="col-md-6">
                            <div class="form-group">

                               <label class="control-label">Comments</label>
                                    <textarea class="form-control " rows="3" name="remarks" ><?php echo $get_compalaint_result[0]['supervisor_comments']?></textarea>

                                  </div>

                            </div>

                          </div>
                       <div class="row" style="margin:0 0 0 0;">

                               <div class="col-md-6">

                            <div class="form-group">

                              <label class="control-label">Name of the Person Verifying</label>

                          <input type="text" class="form-control" name="contact_person_verification" value="<?php echo $get_compalaint_result[0]['contact_person_verification']?>" >

                            </div>

                            </div>

                          </div>
                       <div class="row" style="margin:0 0 0 0;">

                             <div class="col-md-6">

                            <div class="form-group">

                              <label class="control-label">Mobile Number of the Person Verifying</label>

                          <input type="text" class="form-control" name="contact_number_verification" value="<?php echo $get_compalaint_result[0]['contact_number_verification']?>"  >

                            </div>

                            </div>

                          </div>
                </div>
			<script type="text/javascript">
				function problem_cause_change(locations)
				{
						//alert('hello world');
		
						if(locations=="Pending (BB)"){
		
							document.getElementById('bounceback').style.display = 'block';
		
							document.getElementById('completed').style.display = 'none';
		
							}
						else if (locations=="Closed"){
		
							document.getElementById('completed').style.display = 'block';
		
							document.getElementById('bounceback').style.display = 'none';
		
						}
		
						else{
		
							document.getElementById('bounceback').style.display = 'none';
		
							document.getElementById('completed').style.display = 'none';
		
							}
		
				}
		
		</script>
			<input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?> ">
			
              <div class="form-actions right">
				<div class="row">
                  <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-offset-10 col-md-2">
                          <!--  <button type="button" class="btn default">Cancel</button> -->
                        	<button type="submit" class="btn blue" onclick="return check_status('<?php echo $get_compalaint_result[0]['status'];  ?>')">Submit</button>
                          <script>
                          function check_status(status)
                          {
                            //if(status!='Pending Verification' && status!='Pending Verification (BB)' && status!='Shifted')
                            if(status!='Pending Verification' && status!='Pending Verification (BB)')
                            {
                              alert('You are not allowed to update the TS report with current status');
                              return false;
                            }
                            else
                            {
                              return true;
                            }
                          }
                          </script>

                        </div>
					</div>
				</div>
			</div>
                 </div>
			  </div>
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET--> 
          </form>
        </div>
      </div>
      <!-- END PAGE CONTENT--> 

  <!-- END CONTENT --> 

</div>

<!-- END CONTAINER --> 
<?php $this->load->view('footer');?>