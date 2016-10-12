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
									- Each Business Type has a separate bar and number on top of each bar is the total number of projects of this Business Type.
<br/>- Different Colors in each Bar represent status of the project.
<br/>- Green = Active = Last visit ≤ 21 days 
<br/>- Yellow = InActive = Last visit  ≥ 22  and ≤ 48 days
<br/>- RED = Ignored = Last visit > 49 days
<br/>- Move the cursor on the bar to see further details of Customer Name – Product Category – (Last Date of visit). 
<br/>- Projects set on PRIORITY are displayed in RED Text.
<br/>
<br/>New Business = Customer not doing business with us.
<br/>Recurring = Occur again periodically or repeatedly, follow up for repeat orders.
<br/>Assay Addition = Addition of a new test in existing business.
<br/>Technical Support = Project assigned to the SAP for technical issues
<br/>Base Protection = Existing customer under attack from competitor
<br/>Others = Any other type of project such as Customer Info / Competitor Info etc..
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
                            	<form method="get" action="<?php echo base_url();?>sys/chart_sap_projects_review_biz">
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
							
						</div>
					</div>
		<!-- Search Form -->
<?php } ?>



					<div class="portlet solid bordered light bg-inverse ">
						<!-- Portlet Title -->
						<div class="portlet-title">
							<div class="caption font-purple-seance">
								<i class="icon-bar-chart font-purple-seance"></i>
								<span class="caption-subject bold uppercase"> SAP Projects Review - Business Type</span>
								
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

$months_to_show = 6;
for ($i=0;$i<$months_to_show;$i++) {
	//array_push($months,date('F Y', $month), PHP_EOL) ;
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-1 month", $month);
}

$user_color = array('#292421','#00CD66','#FFD700','#DC143C');
$user_color = array('#DC143C','#FFD700','#939393','#292421','#00CD66');
$pm_statuses = array('NO PM Data','Good Units','Due PM','PM Neglected');
$pm_statuses = array('PM Neglected','Due PM','Assigned','NO PM Data','Good Units');

/////////// ABOVE is irrelevant
$user_color = array('#DC143C','#FFD700','#00CD66');
$project_statuses = array('Ignored','Inactive','Active');


$categories = array('Tender','IDx','CIF','CDx','HDx','MDx','Manual Kits');
$category_ids = array('1','2','3','4','5','6','7');

$project_types = array('New Business','Recurring','Assay Addition','Technical Support','Base Protection','Others','Unknown');
//echo "unnus";
//print_r($product_ids);
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
            text: 'SAP Projects Review - Business Type'
        },

        xAxis: {
            //categories: ['Feb', 'Jan', 'Dec', 'Nov', 'Oct']
			//categories: [<?php echo  implode(',',$months);?>]
			//categories: [<?php echo  implode(',',$categories);?>]
			categories: ['New Business','Recurring','Assay Addition','Technical Support','Base Protection','Others','Unknown']
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
            align: 'left',
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
				//for ($i=0;$i<$months_to_show;$i++) { // Loops through months
				$i = 0;
				foreach ($project_types AS $project_type) {
					$comma_limit 		= 	sizeof($project_types) - 1;
					
					$ignored_projects = 0;
					$active_projects = 0;
					$inactive_projects = 0;
					
					$pt = $project_type;
					if ($project_type == "Unknown") $pt = "";
					
					$queryy = "select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_business_types.businesstype_name
					from business_data
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
					where `project_type`='".$pt ."' AND business_data.`status`=0 ";
					
					/*$queryy = "select business_data.*,tbl_clients.client_name,tbl_cities.city_name
					from business_data
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					LEFT JOIN (SELECT pk_dvr_id,fk_business_id,MAX(pk_dvr_id) max_dvr_id FROM tbl_dvr GROUP BY fk_business_id) d ON d.`fk_business_id` = business_data.`Business Project`
					where `Business Project`=".$category_id ." AND business_data.`status`=0 ORDER BY d.pk_dvr_id DESC"; */
					if ($territory!=0) {
						$queryy .= " AND `Territory`='".$territory."' ";
					}
					if ($sap!=0) {
						$queryy .= " AND `Sales Person`='".$sap."' ";
					}
					$queryy .= " ORDER BY tbl_clients.client_name ";
					$pq	=	$this->db->query($queryy);
					$pr =	$pq->result_array();
					
					$s_ignored = ""; // string ignored projects
					$s_inactive = ""; // string inactive projects
					$s_active = ""; // string active projects
					
					foreach ($pr as $project) {
						
						$ty=$this->db->query("select * from tbl_dvr where fk_business_id='".$project["pk_businessproject_id"]."' ORDER BY  `pk_dvr_id` DESC ");
						  $pc = $project['client_name'] . "-" . $project['businesstype_name']."-";
						  if($ty->num_rows()>0) {
							  
							  $rt=$ty->result_array();
							  $now 		 = time(); 
							  $your_date = strtotime($rt[0]["date"]);
							  $datediff  = $now - $your_date;
							  $mydiffrence = floor($datediff/(60*60*24));
							  
							  
							  if($mydiffrence>=49) {
								  $ignored_projects++;
								  $d = date('d-M-Y',strtotime($rt[0]['date']));
								  if ($project['priority']=='1') //echo "zaaid";
									$s_ignored .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_ignored .= $pc."(".$d."),<br/>";
								  array_push($ignored_projects_array,$project['pk_businessproject_id']);
							  }
							  
							  elseif($mydiffrence<49 && $mydiffrence>=22 ) {
								  $inactive_projects++;
								  $d = date('d-M-Y',strtotime($rt[0]['date']));
								  if ($project['priority']=='1') $s_inactive .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_inactive .= $pc."(".$d."),<br/>";
								  array_push($inactive_projects_array,$project['pk_businessproject_id']);
							  }
							  else {
								  $active_projects++;
								  $d = date('d-M-Y',strtotime($rt[0]['date']));
								  if ($project['priority']=='1') $s_active .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_active .= $pc."(".$d."),<br/>";
								  array_push($active_projects_array,$project['pk_businessproject_id']);
							  } 
							  
						  }
						  else {
							  
							  $ignored_projects++;
							  //$d = date('d-M-Y',strtotime($rt[0]['date']));
							  $d = "No Visits";
								  if ($project['priority']=='1') $s_ignored .= "<b style=\"color: #DC143C;\">".$pc."(".$d."),</b><br/>";
								  else $s_ignored .= $pc."(".$d."),<br/>";
							  array_push($ignored_projects_array,$project['pk_businessproject_id']);
							  
						  }
					} 
				
				//$pm_statuses = array('NO PM Data','Good Units','Due PM','PM Neglected');
				//$units = 0;
					// Begin code to count Units of respective PM status
				if ($project_status == "Ignored") {
					// code to calculate number of units
					echo "{y: ".$ignored_projects.", myData: '$s_ignored'}";
				}
				if ($project_status == "Inactive") {
					// code to calculate number of units
					echo "{y: ".$inactive_projects.", myData: '$s_inactive'}";
				}
				if ($project_status == "Active") {
					// code to calculate number of units
					echo "{y: ".$active_projects.", myData: '$s_active'}";
				}
						
					if ($i<$comma_limit) echo ",";
					$i++;
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