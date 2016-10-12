<?php include('/../header.php');//$this->load->view('header');
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
		  //return "$difference $periods[$j] {$tense}";
		  return "$difference $periods[$j]";
	  }

function nicetimee($date,$date2)
	  {
		  if(empty($date)) {
			  return "No date provided";
		  }
		  $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		  $lengths         = array("60","60","24","7","4.35","12","10");
		  $now             = strtotime($date2);
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
		  //return "$difference $periods[$j] {$tense}";
		  return "$difference $periods[$j]";
	  }
	  
function Get_Date_Difference($start_date, $end_date)
    {
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        echo (($years > 0) ? $years.' year'.(($years > 1 ? 's ' : '')) : '').(($months > 0) ? (($months == 1) ? ' '.$months.' month' : ' '.$months.' months' ) : '').(($days > 0) ? (($days == 1) ? ' '.$days.' day' : ' '.$days.' days' ) : '');
    }
	
function _date_diff($one, $two)
{
    $invert = false;
    if ($one > $two) {
        list($one, $two) = array($two, $one);
        $invert = true;
    }

    $key = array("y", "m", "d", "h", "i", "s");
    $a = array_combine($key, array_map("intval", explode(" ", date("Y m d H i s", $one))));
    $b = array_combine($key, array_map("intval", explode(" ", date("Y m d H i s", $two))));

    $result = array();
    $result["y"] = $b["y"] - $a["y"];
    $result["m"] = $b["m"] - $a["m"];
    $result["d"] = $b["d"] - $a["d"];
    $result["h"] = $b["h"] - $a["h"];
    $result["i"] = $b["i"] - $a["i"];
    $result["s"] = $b["s"] - $a["s"];
    $result["invert"] = $invert ? 1 : 0;
    $result["days"] = intval(abs(($one - $two)/86400));

    if ($invert) {
        _date_normalize(&$a, &$result);
    } else {
        _date_normalize(&$b, &$result);
    }

    return $result;
}

?>
                    
                    
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Users <small>View</small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
                        <li> Users <i class="fa fa-angle-right"></i> </li>
                        
                      </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box grey-cascade">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i>Users </div>
                            <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
                          </div>
                          <div class="portlet-body">
                            <div class="table-toolbar">
                            	<?php
                                  	if(isset($_GET['msg']))
									  { 
										echo '<div class="alert alert-success alert-dismissable">  
												<a class="close" data-dismiss="alert">×</a>  
												User Added Successfully.  
											  </div>';
									  }
								  ?>
                              
                            </div>
                                      <div class="portlet-body flip-scroll">
                                           <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                              <thead>
                                <tr>
                                  <th> User Name </th>
                                  <th> Designation </th>
                                  <th> Department </th>
                                  <th> City </th>
                                  <th> Office </th>
								  <th> Termination Date		</th>
								  <th> Employment Duration		</th>
                                  <th> Contact No </th>
                                  <th> Update </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									  if (sizeof($get_users_lists) == "0") {
										  
									  } else {
										  foreach ($get_users_lists as $get_users_list) {
											  ?>
											  <tr class="odd gradeX">
												  <td>
													  <?php echo $get_users_list["first_name"] ?> 
												  </td>
												  <td>
													  <?php echo $get_users_list["userrole"] ?>
												  </td>
												  <td>
													  <?php echo $get_users_list["department"] ?>
												  </td>
                                                  
                                                  <td>
													  <?php 
													  $ty=$this->db->query("select * from tbl_cities where pk_city_id='".$get_users_list["fk_city_id"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["city_name"] ?>
												  </td>
                                                  <td>
													  <?php //echo $get_users_list["fk_office_id"] ?>
                                                      <?php 
													  $ty=$this->db->query("select * from tbl_offices where pk_office_id='".$get_users_list["fk_office_id"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["office_name"] ?>
												  </td>
												  <td> <!-- Termination Date -->
													  <?php echo date('d-M-Y',strtotime($get_users_list["termination_date"])); ?>
												  </td>
												  <td> <!-- Employment Duration -->
													  <?php //echo nicetime($get_users_list["termination_date"]); //date('d-M-Y',strtotime($get_users_list["date_of_joining"]));
														//$date_a = new DateTime($get_users_list["termination_date"]);
														//$date_b = new DateTime($get_users_list["date_of_joining"]);
														
														//$interval = date_diff($date_a,$date_b);
														//echo $interval->format('%R%a days');
														
														$seconds = strtotime($get_users_list["termination_date"]) - strtotime($get_users_list["date_of_joining"]);

														$days    = floor($seconds / 86400);
														$hours   = floor(($seconds - ($days * 86400)) / 3600);
														$minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
														$seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
														//echo $days;
														//echo nicetimee($get_users_list["date_of_joining"],$get_users_list["termination_date"]);
													  //echo 'Current PHP version: ' . phpversion();
													  echo Get_Date_Difference($get_users_list["date_of_joining"],$get_users_list["termination_date"]);
													  //echo _date_diff(strtotime($get_users_list["date_of_joining"]),strtotime($get_users_list["termination_date"]));
														
													  ?>
												  </td>
                                                  <td>
													  <?php echo $get_users_list["mobile"] ?>
												  </td>
												  <td>
													  <a class="btn green" onClick="return confirm('Are you sure you want to recover?')" href="<?php echo base_url();?>sys/recover_user/<?php echo $get_users_list["id"];?>">Recover</a>
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
        </div>
        <!-- END CONTAINER -->
        <?php include('/../footer.php');?>