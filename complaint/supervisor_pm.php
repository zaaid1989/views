<?php $this->load->view('header');

function pm_frequency($rtz) {
$average_pm_frequency = "N/A";

$days_since_last_pm = "N/A";
//$tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$e."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
//$rtz	= 	$tyz->result_array();
$total_pms_c	=	sizeof($rtz);

if ($total_pms_c > 1 ) {
		$max_pms_index		=	$total_pms_c - 1;
		$first_pm			=	strtotime($rtz[$max_pms_index]['finish_time']);
		$last_pm			=	strtotime($rtz[0]['finish_time']);
		$diff				=	$last_pm - $first_pm;
		$total_days			=	floor($diff/(60*60*24));
		$pm_frequency		=	$total_days/$max_pms_index;
		$average_pm_frequency =	$pm_frequency . " days";
		}
		elseif ($total_pms_c == 1 ) {
			$current_date		=	time();
			$last_pm			=	strtotime($rtz[0]['finish_time']);
			$diff				=	$current_date - $last_pm;
			$total_days			=	floor($diff/(60*60*24));
			$average_pm_frequency = "N/A";
		}
		else $average_pm_frequency = "N/A"; 
		echo $average_pm_frequency;
}

	function nicetime($date)
	{
		if(empty($date)) {
			return "No date provided";
		}
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
		$now             = time();
		$unix_date         = strtotime($date);
		   // check validity of date
		if(empty($unix_date)) {   
			return "Bad date";
		}
		// is it future date or past date
		if($now > $unix_date) {   
			$difference     = $now - $unix_date;
			$tense         = "ago";
		} else {
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		$difference = round($difference);
		if($difference != 1) {
			$periods[$j].= "s";
		}
		return "$difference $periods[$j] {$tense}";
	}
	//
	function nicetime2($date, $end_time)
	{
		if(empty($date)) {
			return "No date provided";
		}
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
		$now             = strtotime($end_time);
		$unix_date         = strtotime($date);
		   // check validity of date
		if(empty($unix_date)) {   
			return "Bad date";
		}
		// is it future date or past date
		if($now > $unix_date) {   
			$difference     = $now - $unix_date;
			$tense         = "ago";
		} else {
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		$difference = round($difference);
		if($difference != 1) {
			$periods[$j].= "s";
		}
		return "$difference $periods[$j] ";//{$tense}
	}
?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Supervisor <small>Preventive Maintenance</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Supervisor PM
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red-intense">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>All Pending PM Calls</div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												Complaint Added Successfully.  
											  </div>';
									  }
								  ?>
                                  <div class="note note-active">
                                        <h3>
                                       		 <label class="label bg-blue">Note: PM Calls in red indicate the calls that are delayed for over 3 days</label>
                                        </h3>
                                 </div>
                              
                            </div>
                           <div class="portlet-body flip-scroll">
                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                    
                                    <th>
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
                                    <th>
                                         Time Elapsed
                                    </th>
                                    <th>
                                         City
                                    </th>
                                    <th>
                                         Customer
                                    </th>
                            <!--        <th>
                                         Area
                                    </th> -->
                                    <th>
                                         Equipment
                                    </th>
                                    
                                    <th>
                                         S/NO
                                    </th>
									<th>
										 Avergae PM Frequency
									</th>
                                    <th>
                                         Status
                                    </th>
                                    <th>
                                         FSE/SAP
                                    </th>
                                    <th>
                                         Actions
                                    </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  if($this->session->userdata('userrole')=='Supervisor')
									  {
										  $dbres2 = $this->db->query("SELECT * FROM user  where fk_office_id='".$this->session->userdata('territory')."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
										  $dbresResult2=$dbres2->result_array();
									  }
									  else
									  {
										  $dbres2 = $this->db->query("SELECT * FROM user ORDER BY  `fk_office_id` ,  `userrole` ASC ");
										  $dbresResult2=$dbres2->result_array();

									  }
									  $dbres="select * from tbl_complaints where  assign_to IN (";
										$n=0;
										foreach($dbresResult2 as $pp)
										{
											$n++;
										}
										$n2=0;					
					
										foreach($dbresResult2 as $ss)
										{
											if($n-1 > $n2)
											{
												$dbres.=$ss['id'].", ";
												$n2++;
											}
											else
											{
												$dbres.=$ss['id'];
											}
										}
										$dbres.=")";
										$dbres.=" AND complaint_nature='PM'  AND status IN ('Pending') order by `pk_complaint_id` DESC";
										//echo $dbres;exit;
										
									  //$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to IN '".$this->session->userdata('userid')."'
									  // AND complaint_nature='PM'  order by `pk_complaint_id` DESC");
									$my_results = $this->db->query($dbres);
									$dbresResult=$my_results->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											  ?>
                                              <?php
                                              	$date1 = $complaint_list['date'];
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
											  ?>
											  <tr class="<?php if($diff>86400*3 && $complaint_list['status']!='Completed'){ echo "danger even";} else { echo "odd gradeX";}?>">
												  
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php echo date("Y-m-d", strtotime($complaint_list["date"])); ?>
												  </td>
                                                  
                                                  <td>
                                                      <?php 
													  echo nicetime($complaint_list["date"]); ?>
												  </td>
                                                  
                                                  
                                                  
                                                   <td>
													  <?php 
                                                      $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint_list["fk_city_id"]."'");
                                                      $rt=$ty->result_array();
                                                      echo $rt[0]["city_name"] ?>
                                                  </td>
                                                  <td>
                                                      <?php    
                                                        $nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$complaint_list['fk_customer_id']."'");
                                                        $n2sql3=$nsql3->result_array();
                                                        echo $n2sql3[0]['client_name'];
                                                        ?>
                                                  </td>
                                                    
                                       <!--           <td>
                                                  <?php 
                                                        $nsql3=$this->db->query("select area from tbl_area where pk_area_id ='".$n2sql3[0]['fk_area_id']."'");
                                                        $n2sql3=$nsql3->result_array();
                                                        echo $n2sql3[0]['area'];
                                                        ?>
                                                  </td> -->
                                                  <td>
													  <?php  $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
													  $rt=$ty->result_array();
													  $ty2=$this->db->query("select * from tbl_products where pk_product_id='".$rt[0]["fk_product_id"]."'");
													  $rt2=$ty2->result_array();
													  echo $rt2[0]["product_name"];
													  ?>
                                      
												  </td>
												  
												   <td>
													  <?php  $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
													  $rt=$ty->result_array();
													  ?>
                                                      <?php echo $rt[0]["serial_no"]; ?>
												  </td>
												  <td>
												  <?php
												  $tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$complaint_list["fk_instrument_id"]."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
													$rtz	= 	$tyz->result_array();
													pm_frequency($rtz);
												  ?>
												  </td>
												  <td>
												  <?php 
													$this->load->model("complaint_model");
													$obj=new Complaint_model();
													$obj->current_status($complaint_list['status']);
												  ?>
												  </td>											
                                                  
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from user where id ='".$complaint_list["assign_to"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"];
													  //echo $complaint_list["FSE_SAP"] ?>
												  </td>
                                                  <td>
													  <a class="btn btn-default" href="<?php echo base_url();?>complaint/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>">PM Form</a>
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
                        
						
						<div class="portlet box yellow-zed">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>All Pending Verification PM Calls</div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                              
                            </div>
                        <div class="portlet-body flip-scroll">
                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_20">
                              <thead>
                                <tr>
                                    
                                    <th>
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
                                    <th>
                                         Time Elapsed
                                    </th>
                                    <th>
                                         City
                                    </th>
                                    <th>
                                         Customer
                                    </th>
                             <!--       <th>
                                         Area
                                    </th> -->
                                    <th>
                                         Equipment
                                    </th>
                                    
                                    <th>
                                         S/NO
                                    </th>
									<th>
										 Avergae PM Frequency
									</th>
                                    <th>
                                         Status
                                    </th>
                                    <th>
                                         FSE/SAP
                                    </th>
                                    <th>
                                         Actions
                                    </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  
									  $dbres1 = $this->db->query("SELECT * FROM user  where id='".$this->session->userdata('userid')."'");
									  $dbresResult1=$dbres1->result_array();
									  $dbres2 = $this->db->query("SELECT * FROM user  where fk_office_id='".$dbresResult1[0]['fk_office_id']."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
									  $dbresResult2=$dbres2->result_array();
									  $dbres="select * from tbl_complaints where  assign_to IN (";
										$n=0;
										foreach($dbresResult2 as $pp)
										{
											$n++;
										}
										$n2=0;					
					
										foreach($dbresResult2 as $ss)
										{
											if($n-1 > $n2)
											{
												$dbres.=$ss['id'].", ";
												$n2++;
											}
											else
											{
												$dbres.=$ss['id'];
											}
										}
										$dbres.=")";
										$dbres.=" AND complaint_nature='PM'  AND status IN ('Pending Verification') order by `pk_complaint_id` DESC";
										//echo $dbres;exit;
										
									  //$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to IN '".$this->session->userdata('userid')."'
									  // AND complaint_nature='PM'  order by `pk_complaint_id` DESC");
									$my_results = $this->db->query($dbres);
									$dbresResult=$my_results->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											  ?>
                                              <?php
                                              	$date1 = $complaint_list['date'];
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
											  ?>
											  <tr class="<?php if($diff>86400*3 && $complaint_list['status']!='Completed'){ echo "danger even";} else { echo "odd gradeX";}?>">
												  
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php echo date("Y-m-d", strtotime($complaint_list["date"])); ?>
												  </td>
                                                  
                                                  <td>
                                                      <?php 
													  echo nicetime($complaint_list["date"]); ?>
												  </td>
                                                  
                                                  
                                                  
                                                   <td>
													  <?php 
                                                      $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint_list["fk_city_id"]."'");
                                                      $rt=$ty->result_array();
                                                      echo $rt[0]["city_name"] ?>
                                                  </td>
                                                  <td>
                                                      <?php    
                                                        $nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$complaint_list['fk_customer_id']."'");
                                                        $n2sql3=$nsql3->result_array();
                                                        echo $n2sql3[0]['client_name'];
                                                        ?>
                                                  </td>
                                                    
                                 <!--                 <td>
                                                  <?php 
                                                        $nsql3=$this->db->query("select area from tbl_area where pk_area_id ='".$n2sql3[0]['fk_area_id']."'");
                                                        $n2sql3=$nsql3->result_array();
                                                        echo $n2sql3[0]['area'];
                                                        ?>
                                                  </td> -->
                                                  <td>
													  <?php  $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
													  $rt=$ty->result_array();
													  $ty2=$this->db->query("select * from tbl_products where pk_product_id='".$rt[0]["fk_product_id"]."'");
													  $rt2=$ty2->result_array();
													  echo $rt2[0]["product_name"];
													  ?>
                                      
												  </td>
												  
												   <td>
													  <?php  $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
													  $rt=$ty->result_array();
													  ?>
                                                      <?php echo $rt[0]["serial_no"]; ?>
												  </td>
												  <td>
												  <?php
												  $tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$complaint_list["fk_instrument_id"]."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
													$rtz	= 	$tyz->result_array();
													pm_frequency($rtz);
												  ?>
												  </td>
												  <td>
												  <?php 
													$this->load->model("complaint_model");
													$obj=new Complaint_model();
													$obj->current_status($complaint_list['status']);
												  ?>
												  </td>											
                                                  
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from user where id ='".$complaint_list["assign_to"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"];
													  //echo $complaint_list["FSE_SAP"] ?>
												  </td>
                                                  <td>
													  <a class="btn btn-default" href="<?php echo base_url();?>complaint/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>">PM Form</a>
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
                        
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box green-meadow">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>All Completed PM Calls (30 Days)</div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                              
                            </div>
                        	<div class="portlet-body flip-scroll">
                             <table class="table table-striped table-bordered table-hover flip-content" id="sample_21">
                              <thead>
                                <tr>
                                    
                                    <th>
                                         TS number
                                    </th>
                                    <th>
                                         Date
                                    </th>
                                    <th>
                                         Time Elapsed
                                    </th>
                                    <th>
                                         Time Taken
                                    </th>
                                    <th>
                                         City
                                    </th>
                                    <th>
                                         Customer
                                    </th>
                             <!--       <th>
                                         Area
                                    </th> -->
                                    <th>
                                         Equipment
                                    </th>
                                    
                                    <th>
                                         S/NO
                                    </th>
									<th>
										 Avergae PM Frequency
									</th>
                                    <th>
                                         Status
                                    </th>
                                    <th>
                                         FSE/SAP
                                    </th>
                                    <th>
                                         Actions
                                    </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  $dbres1 = $this->db->query("SELECT * FROM user  where id='".$this->session->userdata('userid')."'");
									  $dbresResult1=$dbres1->result_array();
									  $dbres2 = $this->db->query("SELECT * FROM user  where fk_office_id='".$dbresResult1[0]['fk_office_id']."' 
									  ORDER BY  `fk_office_id` ,  `userrole` ASC ");
									  $dbresResult2=$dbres2->result_array();
									  $dbres="select * from tbl_complaints where  assign_to IN (";
										$n=0;
										foreach($dbresResult2 as $pp)
										{
											$n++;
										}
										$n2=0;					
					
										foreach($dbresResult2 as $ss)
										{
											if($n-1 > $n2)
											{
												$dbres.=$ss['id'].", ";
												$n2++;
											}
											else
											{
												$dbres.=$ss['id'];
											}
										}
										$dbres.=")";
										$dbres.=" AND complaint_nature='PM' AND status IN ('Completed')  AND `date` BETWEEN '".date('Y-m-d', strtotime("-30 days"))."' 
										AND '".date('Y-m-d')."'";
										//echo $dbres;exit;
										
									  //$dbres = $this->db->query("SELECT * FROM tbl_complaints  where assign_to IN '".$this->session->userdata('userid')."'
									  // AND complaint_nature='PM'  order by `pk_complaint_id` DESC");
									$my_results = $this->db->query($dbres);
									$dbresResult=$my_results->result_array();
									  if (sizeof($dbresResult) == "0") {
										  
									  } else {
										  foreach ($dbresResult as $complaint_list) {
											  ?>
                                              <?php
                                              	$date1 = $complaint_list['date'];
												$date2 = date('Y-m-d');
												$diff = abs(strtotime($date2) - strtotime($date1));
											  ?>
											  <tr class="<?php if($diff>86400*3 && $complaint_list['status']!='Completed'){ echo "danger even";} else { echo "odd gradeX";}?>">
												  
                                                  <td>
													  <?php echo $complaint_list["ts_number"] ?>
												  </td>
												  <td>
													  <?php echo date("Y-m-d", strtotime($complaint_list["date"])); ?>
												  </td>
                                                  <td> 
													  <?php  
													  	if($complaint_list["status"]=='Completed')
														{
															echo "Completed ". nicetime($complaint_list["finish_time"]); 
														}
														else
														{
															echo nicetime($complaint_list["date"]);
														}
													  ?> 
												  </td> 
                                                  <td>
                                                      <?php 
													  echo nicetime2($complaint_list["date"],$complaint_list["finish_time"]); ?>
												  </td>
                                                  
                                                  
                                                  
                                                   <td>
													  <?php 
                                                      $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$complaint_list["fk_city_id"]."'");
                                                      $rt=$ty->result_array();
                                                      echo $rt[0]["city_name"] ?>
                                                  </td>
                                                  <td>
                                                      <?php    
                                                        $nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$complaint_list['fk_customer_id']."'");
                                                        $n2sql3=$nsql3->result_array();
                                                        echo $n2sql3[0]['client_name'];
                                                        ?>
                                                  </td>
                                                    
                                       <!--           <td>
                                                  <?php 
                                                        $nsql3=$this->db->query("select area from tbl_area where pk_area_id ='".$n2sql3[0]['fk_area_id']."'");
                                                        $n2sql3=$nsql3->result_array();
                                                        echo $n2sql3[0]['area'];
                                                        ?>
                                                  </td> -->
                                                  <td>
													  <?php  $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
													  $rt=$ty->result_array();
													  $ty2=$this->db->query("select * from tbl_products where pk_product_id='".$rt[0]["fk_product_id"]."'");
													  $rt2=$ty2->result_array();
													  echo $rt2[0]["product_name"];
													  ?>
                                      
												  </td>
												  
												   <td>
													  <?php  $ty=$this->db->query("select * from tbl_instruments where pk_instrument_id='".$complaint_list["fk_instrument_id"]."'");
													  $rt=$ty->result_array();
													  ?>
                                                      <?php echo $rt[0]["serial_no"]; ?>
												  </td>
												  <td>
												  <?php
												  $tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$complaint_list["fk_instrument_id"]."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
													$rtz	= 	$tyz->result_array();
													pm_frequency($rtz);
												  ?>
												  </td>
												  <td>
												  <?php 
													$this->load->model("complaint_model");
													$obj=new Complaint_model();
													$obj->current_status($complaint_list['status']);
												  ?>
												  </td>											
                                                  
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from user where id ='".$complaint_list["assign_to"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["first_name"];
													  //echo $complaint_list["FSE_SAP"] ?>
												  </td>
                                                  <td>
													  <a class="btn btn-default" href="<?php echo base_url();?>complaint/pm_form/<?php echo $complaint_list["pk_complaint_id"] ?>">PM Form</a>
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
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer');?>