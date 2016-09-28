<?php $this->load->view('header');
$user_id =	$this->session->userdata('userid');
$equipment_id =	'0';
$dates_set = "no";
$start_date_month = date('Y-m').'-01';
$start_date = date('Y-m-d',strtotime($start_date_month));
$end_date = date('Y-m-d');
$current_date = date('Y-m-d');

// Assign Start End Dates
if(isset($_GET['start_mydate']) && isset($_GET['end_mydate'])) {
	
	$dates_set = "yes";
	$start_date = date('Y-m-d',strtotime($_GET['start_mydate']));
	$end_date = date('Y-m-d',strtotime($_GET['end_mydate']));
	if ($start_date==$end_date && $start_date>$current_date)
		$dates_set = "no";
}
// Assign Equipment ID

if(isset($_GET['equipment'])) {
	$equipment_id = $_GET['equipment'];
}

$maxqu = $this->db->query("SELECT * FROM user where id='".$user_id ."'");
$maxval=$maxqu->result_array();

function zerodisplay($val) {
	if($val==0) return '-';
	else return $val;
}

function Get_Date_Difference($start_date, $end_date)
    {
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        return (($years > 0) ? $years.' year'.(($years > 1 ? 's ' : '')) : '').(($months > 0) ? (($months == 1) ? ' '.$months.' month' : ' '.$months.' months' ) : '').(($days > 0) ? (($days == 1) ? ' '.$days.' day' : ' '.$days.' days' ) : '');
    }
	
	
$territory = 0;
$sap = 0;
if ($this->session->userdata('userrole') != 'Admin' && $this->session->userdata('userrole') != 'secratery') {
	$territory = $this->session->userdata('territory');
	$sap = $this->session->userdata('userid');
}
else {
	if (isset($_GET['territory'])) $territory = $_GET['territory'];
	if (isset($_GET['sap'])) $sap = $_GET['sap'];
}

if ($sap != 0) $territory = 0;
?>
										
<script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>										
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    SAP Statistics <small><?php //echo $average_visits_per_day; ?></small>
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
	   <!-- Graph Description -->
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bg-inverse" >
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Graph Description </span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
									<div class="col-md-12">
									<p>
									- Each Project is displayed in the respective month depending on the Target Date.
<br/>- Different Colors in each Bar represent status of the project.
<br/>- Green = Projects with Original Target Date 
<br/>- Yellow = Projects with 1st Extension.
<br/>- RED = Projects with 2nd Extension
<br/>- Brown = Projects with 3rd and Final Extension
<br/>- Move the cursor on the bar to see further details of Customer Name – Product Category – (Last Date of visit). 
<br/>- Projects set on PRIORITY are displayed in RED Text.
									</p>
									</div>
								</div>	
						</div>
				</div>
			</div>
		</div>
	   <!-- END Graph Description -->
       <div class="row">
        <div class="col-md-12"> 
<?php if ($this->session->userdata('userrole')=='Admin' || $this->session->userdata('userrole')=='secratery'){ ?>		
		<!-- Search Form -->
		<div class="portlet light bg-inverse" >
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Territory </span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>complaint/chart_ongoing_projects_target_date">
                                <div class="col-md-4">
                            		<div class="form-group">
                            			<select name="territory" id="territory" onchange="territory_changed()" class="form-control" >
                                            <option value="">--Select Territory--</option>
											<?php 
											
											$maxqu = $this->db->query("SELECT * FROM tbl_offices ORDER BY `pk_office_id` ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['pk_office_id'];//pk_instrument_id?>" <?php if($territory==$val['pk_office_id']){ echo 'selected="selected"';}//pk_instrument_id?>>
													<?php echo $val['office_name'];//$val['serial_no'].' - '.$val['product_name']?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
											<option value="0"<?php if($territory==0){ echo 'selected="selected"';}?>>ALL</option>
                                        </select>
                            		</div>
                          		</div>
								<div class="col-md-4">
                            		<div class="form-group">
                            			<select name="sap" id="sap" onchange="sap_changed()" class="form-control" >
                                            <option value="">--Select SAP--</option>
											<option value="0"<?php if(isset($_GET['sap']) && $_GET['sap']==0){ echo 'selected="selected"';}?>>ALL</option>
											<?php 
											
											$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status='0' AND userrole='Salesman' ORDER BY `fk_office_id` ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['id'];//pk_instrument_id?>" <?php if(isset($_GET['sap']) && $_GET['sap']==$val['id']){ echo 'selected="selected"';}//pk_instrument_id?>>
													<?php echo $val['first_name'];//$val['serial_no'].' - '.$val['product_name']?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
											
                                        </select>
                            		</div>
                          		</div>
								<!--
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
								-->
                                <div class="col-md-2">
                            		<div class="form-group">
                                        
                                            <input type="submit"  class="btn btn-default purple-seance" value="Search" >
                                    </div>
                                </div>
                          		</form>
                           </div>
							
							<div class="row">
							<div class="col-md-12">
							<?php
							$pc=0;
							$pcn=0;
							$queryyy = "select * FROM business_data where  business_data.`status`=0  ";
							
							if ($territory!=0) $queryyy .= " AND `Territory`='".$territory."' ";
							if ($sap!=0) $queryyy .= " AND `Sales Person`='".$sap."' ";
							
							$pcq = $this->db->query($queryyy);
							$pcqr = $pcq->result_array();
							$pc = sizeof($pcqr); //total project count
							
							$queryyy = "select * FROM business_data where  business_data.`status`=0 AND pk_businessproject_id NOT IN (SELECT fk_project_id from tbl_project_strategy WHERE strategy_status='1')  ";
							
							if ($territory!=0) $queryyy .= " AND `Territory`='".$territory."' ";
							if ($sap!=0) $queryyy .= " AND `Sales Person`='".$sap."' ";
							
							$pcnq = $this->db->query($queryyy);
							$pcnqr = $pcnq->result_array();
							$pcn = sizeof($pcnqr); //total project count no strategy
							
							?>
							<table class="table table-striped table-bordered table-hover hover">
									<tbody>
										<tr>
											<th>Total Projects</th>
											<td><?php echo $pc; ?></td>
											<th>Projects with No Strategy/Tactics/Target Date</th>
											<td><?php echo $pcn; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
							</div>
							
						</div>
					</div>
		<!-- Search Form -->
<?php } ?>



					<div class="portlet solid bordered light bg-inverse ">
						<!-- Portlet Title -->
						<div class="portlet-title">
							<div class="caption font-purple-seance">
								<i class="icon-bar-chart font-purple-seance"></i>
								<span class="caption-subject bold uppercase"> Ongoing Projects - Target Date</span>
								
							</div>
							
							<div class="tools">
								<a href="" class="collapse" data-original-title="" title="">
								</a>
								
								<a href="" class="fullscreen">
								</a>
								<a href="" class="remove" data-original-title="" title="">
								</a>
							</div>
							
							<div class="actions">
							</div>
						</div>
						<!-- End Portlet Title -->
						<!-- Begin Portlet Body -->
						
						<div class="portlet-body" style="margin-left:3%; margin-right:3%; ">
						<!--
						<div class="scroller" style="height:400px" data-always-visible="1" data-rail-visible="1" data-rail-color="blue" data-handle-color="red"> -->
								<div id="container" style="width: 100%; height: 1200px; margin-left:20px; "></div> 	 
						<!--	</div> -->
						</div>
						<!-- End Portlet Body -->
					</div>


<!------------------------------------- Begin 6 Table Portlets -------------------------------------------->
<?php
	$titles = array("Assigned Total","Pending Total");
	$title_colors = array("green-seagreen","red-thunderbird");
	
	$start_date_f			=	date('jS F Y',strtotime($start_date));
	$end_date_f				=	date('jS F Y',strtotime($end_date));
	$start = $month = strtotime($start_date);
	//$end = time();
	$end = strtotime($end_date);
while($month < $end)
{
    ////////////////// echo date('F Y', $month), PHP_EOL;
     $month = strtotime("+1 month", $month);
}
 ?>


          
<!-- END EXAMPLE TABLE PORTLET--> 

      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->





<?php 

$month = time();
$months = array('');
$categories = array('');
$category_ids = array('');
$active_projects_array = array('');
$inactive_projects_array = array('');
$ignored_projects_array = array('');
$monthss = array('');
$offices = array('Rawalpindi Office','Lahore Office','Karachi Office','Multan Office','Peshawar Office');
$complaint_types = array('complaint','PM');
$complaint_status = array('Shifted','Pending Verification','SPRF Approved','Pending SPRF','Pending','Pending Registration','Closed');

$months[1] = "'".date('F Y', strtotime("-1 months", $month))."'";
$monthss[1] = date('Y-m', strtotime("-1 months", $month));
$months[0] = "'".date('F Y', strtotime("-2 months", $month))."'";
$monthss[0] = date('Y-m', strtotime("-2 months", $month));
$months_to_show = 12;
for ($i=2;$i<$months_to_show;$i++) {
	//array_push($months,date('F Y', $month), PHP_EOL) ;
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("+1 month", $month);
}

$user_color = array('#292421','#00CD66','#FFD700','#DC143C');
$user_color = array('#DC143C','#FFD700','#939393','#292421','#00CD66');
$pm_statuses = array('NO PM Data','Good Units','Due PM','PM Neglected');
$pm_statuses = array('PM Neglected','Due PM','Assigned','NO PM Data','Good Units');

/////////// ABOVE is irrelevant
$user_color = array('#AD0606','#FF6D41','#FFD700','#00CD66','#606062','#d2d3d5');
$project_statuses = array('Final Extension','Extension 2','Extension 1','Valid','Expired');


$categories = array('Tender','IDx','CIF','CDx','HDx','MDx','Manual Kits');
$category_ids = array('1','2','3','4','5','6','7');

$project_types = array('New Business','Recurring','Assay Addition','Techincal Support','Base Protection','Others','Unknown');
//echo "unnus";
//print_r($months);
//echo "<br/>zaaid<br/>";
//print_r($monthss);
//echo implode(',',$offices);



?>


<script>

$(document).ready(function() {


	
	var options = {

        chart: {
			
            type: 'column',
			marginBottom: 800,
			backgroundColor: null
        },

        title: {
            text: ''
        },

        xAxis: {
            
			categories: [<?php echo  implode(',',$months);?>]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Projects',
				margin:20
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }
        },
		legend: {
            align: 'center',
            x: -30,
            verticalAlign: 'top',
            y: 0,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },

        tooltip: {
            formatter: function () {
				if (this.series.options.type === 'pie' || this.series.options.type === 'spline') { // the pie chart
                        return this.point.name + ': ' + this.y;
                    }
				else {
                return '<b>' + this.x +  '' 
				+ ''+  '</b><br/>' 
				+ this.series.name + ': ' + this.y + '<br/>'
				+ '<b>Details:</b>' + this.point.myData + '<br/>';
				}
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 0px black'
                    }
                }
            }
        },

        series: [
		<?php 
		
			$k=0;
			foreach ($project_statuses AS $project_status) {
				
				echo "{ name: '".$project_status."',";
				echo "data: [";
				for ($i=0;$i<12;$i++) { // Loops through months
				//$i = 0;
				//foreach ($project_types AS $project_type) {
					$comma_limit 		= 	11;
					
					$first_of_month 	= 	$monthss[$i].'-01';
					$last_of_month		= 	$monthss[$i].'-31';
					
					$valid_projects = 0;
					$extension_projects = 0; // renamed to extension 1
					$extension_1_projects = 0; // renamed to extension 2
					$final_extension_projects = 0;
					$expired_projects = 0;
					$no_td_projects = 0;
					
					$queryy = "select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_business_types.businesstype_name,tbl_project_strategy.fk_project_id, max(tbl_project_strategy.target_date) AS `target_date_recent`
					from tbl_project_strategy
					JOIN business_data ON business_data.pk_businessproject_id = tbl_project_strategy.fk_project_id
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
					where  CAST(tbl_project_strategy.`target_date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."'  AND business_data.`status`=0 AND tbl_project_strategy.`strategy_status`='1' ";
					
					if ($territory!=0) {
						$queryy .= " AND `Territory`='".$territory."' ";
					}
					if ($sap!=0) {
						$queryy .= " AND `Sales Person`='".$sap."' ";
					}
					$queryy .= " Group By tbl_project_strategy.fk_project_id ";
					$queryy .= " ORDER BY tbl_clients.client_name ";
					$pq	=	$this->db->query($queryy);
					$pr =	$pq->result_array();
					
					$s_valid = ""; // string ignored projects
					$s_extension = ""; // string inactive projects // renamed to extension 1
					$s_extension_1 = ""; // string inactive projects // renamed to extension 2
					$s_final_extension = ""; // string inactive projects
					$s_expired = ""; // string inactive projects
					$s_no_td = ""; // string inactive projects
					
					foreach ($pr as $project) {
						
						$ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$project["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
						  $rt=$ty->result_array();
						  $pc = $project['client_name'] . "-" . $project['businesstype_name']."-";
						  if($ty->num_rows()>0)  //at least one visit
							$d = date('d-M-Y',strtotime($rt[0]['date']));
						  else 
							   $d = "No Visits";
							  
							  
							  $now 		 = time(); 
							  $your_date = strtotime($project["target_date_recent"]);
							  $datediff  = $now - $your_date;
							  $mydiffrence = floor($datediff/(60*60*24));
							  //$mydiffrence = $datediff;
							  
							  $qc =$this->db->query("select * from tbl_project_strategy where fk_project_id='".$project["pk_businessproject_id"]."' AND strategy_status='1' ORDER BY target_date DESC ");
							  $rc = $qc->result_array();
							  
							  $target_date_count = sizeof($rc);
							  
							  if ($target_date_count>0 && $project['target_date_recent']!=$rc[0]['target_date']) {
								  // WHEN more than one strategies AND current project record is not the latest
								  continue;
							  }
							  
							  if($mydiffrence>0) { // expired
								  $expired_projects++;
								  if ($project['priority']=='1') //echo "zaaid";
									$s_expired .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_expired .= $pc."(".$d."),<br/>";
							  }
							  
							  elseif($mydiffrence<0 && $target_date_count == 1 ) { // valid
								  $valid_projects++;
								  if ($project['priority']=='1') $s_valid .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_valid .= $pc."(".$d."),<br/>";
							  }
							  elseif($mydiffrence<0 && $target_date_count == 2 ) { // extension 1
								  $extension_projects++; // renamed to extension 1
								  if ($project['priority']=='1') $s_extension .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_extension .= $pc."(".$d."),<br/>";
							  }
							  elseif($mydiffrence<0 && $target_date_count == 3 ) { // extension 2
								  $extension_1_projects++; // renamed to extension 2
								  if ($project['priority']=='1') $s_extension_1 .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_extension_1 .= $pc."(".$d."),<br/>";
							  }
							  elseif($mydiffrence<0 && $target_date_count >= 4 ) { // final extension
								  $final_extension_projects++;
								  if ($project['priority']=='1') $s_final_extension .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_final_extension .= $pc."(".$d."),<br/>";
							  }
							/*  else {
								  $no_td_projects++;
								  if ($project['priority']=='1') $s_no_td .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_no_td .= $pc."(".$d."),<br/>";
							  } */
					} 
				
				//$pm_statuses = array('NO PM Data','Good Units','Due PM','PM Neglected');
				//$units = 0;
					// Begin code to count Units of respective PM status ('Final Extension','Extension 1','Extension','Valid','Expired',"No Target Date");
			/*	if ($project_status == "No Target Date") {
					echo "{y: ".$no_td_projects.", myData: '$s_no_td'}";
				}*/
				if ($project_status == "Extension 2") {
					echo "{y: ".$extension_1_projects.", myData: '$s_extension_1'}";
				}
				if ($project_status == "Final Extension") {
					echo "{y: ".$final_extension_projects.", myData: '$s_final_extension'}";
				}
				if ($project_status == "Extension 1") {
					echo "{y: ".$extension_projects.", myData: '$s_extension'}";
				}
				if ($project_status == "Expired") {
					echo "{y: ".$expired_projects.", myData: '$s_expired'}";
				}
				if ($project_status == "Valid") {
					echo "{y: ".$valid_projects.", myData: '$s_valid'}";
				}
						
					if ($i<$comma_limit) echo ",";
					//$i++;
				}
				//echo "3, 4, 4, 2, 5,6";
				echo "],";
				echo "color:'".$user_color[$k]."',";
				echo "showInLegend: true,";
				//echo "stack: '".$complaint_nature."'";
				echo "},";
				$k++;
			}
		
		?>
		/*
		{
            name: 'John',
            data: [5, 3, 4, 7, 2],
            stack: 'complaint'
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5],
            stack: 'complaint'
        }, {
            name: 'Jane',
            data: [2, 5, 6, 2, 1],
            stack: 'PM'
        }, {
            name: 'Janet',
            data: [3, 0, 4, 4, 3],
            stack: 'PM'
        }
		 
		{
            name: 'Completed',
            data: [5, 3, 4, 7, 2],
            color:'#26c281',
            showInLegend: false,
            stack: 'HO'
        }, {
            name: 'Pending',
            color:'#d91e18',
            data: [3, 4, 4, 2, 5],
            showInLegend: false,
            stack: 'HO'
        },{
            name: 'Completed',
            color:'#26c281',
            data: [5, 3, 4, 7, 2],
            showInLegend: false,
            stack: 'LO'
        }, {
            name: 'Pending',
            color:'#d91e18',
            data: [3, 4, 4, 2, 5],
            showInLegend: false,
            stack: 'LO'
        }, {
            name: 'Completed',
            color:'#26c281',
            data: [2, 5, 6, 2, 1],
            showInLegend: false,
            stack: 'MO'
        }, {
            name: 'Pending',
            color:'#d91e18',
            data: [3, 0, 4, 4, 3],
            showInLegend: false,
            stack: 'MO'
        }, {
            type: 'spline',
            name: 'Average',
            data: [3, 2.67, 3, 6.33, 3.33],
            marker: {
                lineWidth: 4
            }
        },*/ ]
    };
    
    $('#container').highcharts(options);
	});
	
</script>	




<?php $this->load->view('footer');?>

<script>
function territory_changed() {
	$("#sap").select2().select2('val','0');
}
function sap_changed() {
	
	$("#territory").select2().select2('val','0');
}
$(document).ready(function() { 
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 100,
	  'aaSorting':[]
	});
	var table4 = $('#sample_225').dataTable({
			  'iDisplayLength': 100,
			   'aaSorting':[]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
				    	 		{ type: "text" },
								{ type: "text" },
								{ type: "text" }
								
						]

		});
	
	//new $.fn.dataTable.FixedColumns( table );
});
</script>

<style>
textarea {
  width: 100%;
}
</style>