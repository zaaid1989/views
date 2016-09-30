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
<?php
$portlet_status_array		=		array('Pending','Pending Verification','Completed');
$portlet_color		=		array('red-intense','yellow-zed','green-meadow');
$portlet_title		=		array('All Pending PM Calls','All Pending Verification PM Calls','All Completed PM Calls');

for($i=0;$i<3;$i++) {
?>
                        <div class="portlet box <?php echo $portlet_color[$i]; ?>">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-globe"></i><?php echo $portlet_title[$i]; ?></div>
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
                           <table class="table table-striped table-bordered table-hover flip-content dataaTable" id="">
                              <thead>
								<tr>
                                    <th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									<th> </th>
									
                                </tr>
                                <tr>
                                    <th> TS number </th>
                                    <th> Date </th>
                                    <th> Time Elapsed </th>
                                    <th> City </th>
                                    <th> Customer </th>
                                    <th> Equipment </th>
                                    <th> S/NO </th>
									<th> Avergae PM Frequency </th>
                                    <th> Status </th>
                                    <th> FSE/SAP </th>
                                    <th> Actions </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
									$portlet_status = $portlet_status_array[$i];
									$dbres = "SELECT tbl_complaints.* ,
									COALESCE(tbl_clients.client_name) AS client_name,
									COALESCE(tbl_cities.city_name) AS city_name,
									COALESCE(tbl_instruments.serial_no) AS serial_no,
									COALESCE(tbl_products.product_name) AS product_name,
									COALESCE(user.first_name) AS first_name
									FROM tbl_complaints 
									LEFT JOIN tbl_clients ON tbl_complaints.fk_customer_id = tbl_clients.pk_client_id
									LEFT JOIN tbl_cities ON tbl_clients.fk_city_id = tbl_cities.pk_city_id
									LEFT JOIN tbl_instruments ON tbl_complaints.fk_instrument_id = tbl_instruments.pk_instrument_id
									LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
									LEFT JOIN user on tbl_complaints.assign_to = user.id
									WHERE  assign_to IN (SELECT id FROM user WHERE tbl_complaints.fk_office_id ='".$this->session->userdata('territory')."') AND complaint_nature='PM'  AND tbl_complaints.status IN ('$portlet_status') ";
									if ($i==2) $dbres .= " AND `date` BETWEEN '".date('Y-m-d', strtotime("-30 days"))."' 
										AND '".date('Y-m-d')."'";
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
												  
                                                  <td> <?php echo $complaint_list["ts_number"] ?> </td>
												  <td> <?php echo date("d-M-Y", strtotime($complaint_list["date"])); ?> </td>
                                                  <td> <?php if($complaint_list['status']!='Completed') echo nicetime($complaint_list["date"]);
															 else echo nicetime($complaint_list["finish_time"]);
														?> 
												  </td>
                                                  <td> <?php echo $complaint_list['city_name']; ?> </td>
												  <td> <?php echo $complaint_list['client_name']; ?> </td>
                                                  <td> <?php echo $complaint_list['product_name']; ?> </td>
												  <td> <?php echo $complaint_list['serial_no']; ?> </td>
                                <!-- Frequency -->                    
												  <td>
													  <?php
													  $tyz	=	$this->db->query("select * from tbl_complaints where fk_instrument_id='".$complaint_list["fk_instrument_id"]."' AND complaint_nature='PM' AND status='Completed' ORDER BY date DESC ");
														$rtz	= 	$tyz->result_array();
														pm_frequency($rtz);
													  ?>
												  </td>
								<!-- Status -->				  
												  <td>
													  <?php 
														$this->load->model("complaint_model");
														$obj=new Complaint_model();
														$obj->current_status($complaint_list['status']);
													  ?>
												  </td>											
                                <!-- FSE -->                  
                                                  <td> <?php echo $complaint_list['first_name']; ?> </td>
								<!-- Actions -->
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
<?php } ?> 
                      
                   
					  </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer');?>
<script>
$(document).ready(function() { 
			var table = $('.dataaTable').dataTable({
			  'iDisplayLength': 1000,
			  'aaSorting': [],
	  "order": [[ 1, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
				    	 		{ type: "text" },
								null
						]

		});
});

</script>