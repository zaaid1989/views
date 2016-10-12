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
if ($this->session->userdata('userrole') != 'Admin' && $this->session->userdata('userrole') != 'secratery') {
	$territory = $this->session->userdata('territory');
}
else {
	if (isset($_GET['territory'])) $territory = $_GET['territory'];
}
?>
										
<script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>										
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Complaint Statistics <small><?php //echo $average_visits_per_day; ?></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Complaint Statistics
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
       <!-- BEGIN PAGE CONTENT-->
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
                            	<form method="get" action="<?php echo base_url();?>sys/chart_real_time_territory_pm">
                                <div class="col-md-4">
                            		<div class="form-group">
                            			<select name="territory" id="territory" class="form-control" required>
                                            <option value="">--Select Territory--</option>
											<?php 
											$maxqu = $this->db->query("SELECT tbl_instruments.* ,tbl_products.product_name FROM tbl_instruments 
											LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
											ORDER BY   `product_name`,`pk_instrument_id` ");
											
											$maxqu = $this->db->query("SELECT * FROM tbl_offices ORDER BY `pk_office_id` ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['pk_office_id'];//pk_instrument_id?>" <?php if(isset($_GET['territory']) && $_GET['territory']==$val['pk_office_id']){ echo 'selected="selected"';}//pk_instrument_id?>>
													<?php echo $val['office_name'];//$val['serial_no'].' - '.$val['product_name']?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
											<option value="0"<?php if(isset($_GET['territory']) && $_GET['territory']==0){ echo 'selected="selected"';}?>>ALL</option>
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
								<span class="caption-subject bold uppercase"> PM Status - (Real Time)</span>
								
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
								<div id="container" style="width: 100%; height: 500px; margin-left:20px; "></div> 	 
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
$products = array('');
$product_ids = array('');
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

$q = $this->db->query("SELECT * FROM user");
$users = $q->result_array();

$m = 0;
foreach ($users AS $u)	{
		$s = substr(md5($u['first_name']), 25, 6);
		$result ="#".$s;
		$user_color[$m]=$result;//array_push($products,$t) ;
		$m++;
}
$user_color = array('#292421','#00CD66','#FFD700','#DC143C');
$user_color = array('#DC143C','#FFD700','#939393','#292421','#00CD66');
$pm_statuses = array('NO PM Data','Good Units','Due PM','PM Neglected');
$pm_statuses = array('PM Neglected','Due PM','Assigned','NO PM Data','Good Units');





$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_products.fk_category_id > 1 AND tbl_products.status=0 AND tbl_instruments.status=1");
if ($territory != 0)
	$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
	FROM `tbl_instruments`
	LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
	WHERE tbl_products.fk_category_id > 1 AND tbl_products.status=0 AND tbl_instruments.status=1 AND tbl_instruments.fk_office_id='".$territory."'");
$product_results = $q->result_array();
$n = 0;
foreach ($product_results AS $p)	{
	if ($p['product_name']!=""){
		$t ="'".$p['product_name']."'";
		$products[$n]=$t;//array_push($products,$t) ;
		$product_ids[$n]=$p['pk_product_id'];//array_push($product_ids,$p['pk_product_id']) ;
	}
	$n++;
}
//echo "unnus";
//print_r($product_ids);
//echo implode(',',$offices);



?>


<script>

$(document).ready(function() {


	
	var options = {

        chart: {
            type: 'column',
			marginBottom: 100,
			backgroundColor: null
        },

        title: {
            text: 'PM Status - (Real Time)'
        },

        xAxis: {
            //categories: ['Feb', 'Jan', 'Dec', 'Nov', 'Oct']
			//categories: [<?php echo  implode(',',$months);?>]
			categories: [<?php echo  implode(',',$products);?>]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of Units',
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
            verticalAlign: 'bottom',
            y: 25,
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
                return '' + this.x +  '<br/><b>' 
				+ 'PM'+  '</b><br/>' 
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
			foreach ($pm_statuses AS $pm_status) {
				
				echo "{ name: '".$pm_status."',";
				echo "data: [";
				//for ($i=0;$i<$months_to_show;$i++) { // Loops through months
				$i = 0;
				foreach ($product_ids AS $product_id) {
					$comma_limit 		= 	sizeof($product_ids) - 1;
					
					
					////////////////////////////// ************* Code for PM Graph *************** \\\\\\\\\\\\\\\\\\\\\\\\\\\\\
					$total_pms_completed	=	0; // Needed in PM graph
					$total_pms_pending	=	0; // Needed in PM graph
										
					$no_pm_data		=	0; // Needed in PM graph
					$good_units		=	0; // Needed in PM graph
					$due_units		=	0; // Needed in PM graph
					$past_due		=	0; // Needed in PM graph
					$neglected		=	0; // Needed in PM graph
					$pmc_assigned	=	0; // Needed in PM graph
					$pmc_assigned_late	=	0; // Needed in PM graph
					
					
					$eq	=	$this->db->query("select tbl_instruments.*,tbl_clients.client_name,tbl_cities.city_name
					from tbl_instruments
					LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_instruments.fk_client_id
					LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
					where `fk_product_id`=".$product_id ." AND tbl_instruments.`status`=1");
					if ($territory!=0)
						$eq	=	$this->db->query("select tbl_instruments.*,tbl_clients.client_name,tbl_cities.city_name
						from tbl_instruments
						LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_instruments.fk_client_id
						LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = tbl_clients.fk_city_id
						where `fk_product_id`=".$product_id ." AND tbl_instruments.`status`=1 AND tbl_instruments.fk_office_id='".$territory."'");
					$er =	$eq->result_array();
					
					$sgu = "";
					$sdp = "";
					$spn = "";
					$snp = "";
					$sap = "";
					
					foreach ($er as $equipment) {
						if ($territory==0)
							$tyza	=	$this->db->query("select tbl_complaints.*,tbl_clients.client_name, tbl_instruments.serial_no
							from tbl_complaints
							LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_complaints.fk_customer_id
							LEFT JOIN tbl_instruments ON tbl_instruments.pk_instrument_id = tbl_complaints.fk_instrument_id
							where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC LIMIT 1");
						else
							$tyza	=	$this->db->query("select tbl_complaints.*,tbl_clients.client_name, tbl_instruments.serial_no
							from tbl_complaints
							LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = tbl_complaints.fk_customer_id
							LEFT JOIN tbl_instruments ON tbl_instruments.pk_instrument_id = tbl_complaints.fk_instrument_id
							where fk_instrument_id='".$equipment['pk_instrument_id']."' AND complaint_nature='PM' ORDER BY date DESC LIMIT 1");
						$rtza	= 	$tyza->result_array();
						
						if (!empty($rtza)) {
							  if ($rtza[0]['status'] != 'Completed') { // Pending or Pending Verification
								$total_pms_pending+=1;
								/// 13 July
								//$status			=	$rtza[0]['status'];
								$last_pm_date	=	strtotime($rtza[0]['date']);
								$current_date	=	time();
								$difference		=	$current_date - $last_pm_date;
								$interval		=	floor($difference/(60*60*24));
								if	($interval>10)	$pmc_assigned_late	+=	1;	
								else $pmc_assigned	+=	1;
								/// 13 July
								$sap .= $rtza[0]['client_name']."(".$rtza[0]['serial_no']."),<br/>";
								
							  }
							  else { //// Completed
								  $total_pms_completed+=1;	
								/// 13 July
								//$status			=	$rtza[0]['status'];
								$last_pm_date	=	strtotime($rtza[0]['finish_time']);
								$current_date	=	time();
								$difference		=	$current_date - $last_pm_date;
								$interval		=	floor($difference/(60*60*24));
								if	($interval<31)	{
									$good_units	+=	1; // Needed in PM graph Good Units
									$sgu .= $rtza[0]['client_name']."(".$rtza[0]['serial_no']."),<br/>";
								}
								if	($interval>30 && $interval<41)	{
									$due_units	+=	1; //needed in PM graph Due PM
									$sdp .= $rtza[0]['client_name']."(".$rtza[0]['serial_no']."),<br/>";
								}
								if	($interval>40 && $interval<51)	$past_due	+=	1;
								if	($interval>40)	{ // first it was 50 but then Yasir sb asked to make it 40
									$neglected	+=	1;
									$spn .= $rtza[0]['client_name']."(".$rtza[0]['serial_no']."),<br/>";
								}								
								
							  }													  
						}
						else {
							$total_pms_pending+=1;
							$no_pm_data	+=1;	// 13 July //Needed in PM graph No PM Data
							$snp .= $equipment['client_name']."(".$equipment['serial_no']."),<br/>";
						}
					}
				
				//$pm_statuses = array('NO PM Data','Good Units','Due PM','PM Neglected');
				//$units = 0;
					// Begin code to count Units of respective PM status
				if ($pm_status == "NO PM Data") {
					// code to calculate number of units
					echo "{y: ".$no_pm_data.", myData: '$snp'}";
				}
				if ($pm_status == "Good Units") {
					// code to calculate number of units
					echo "{y: ".$good_units.", myData: '$sgu'}";
				}
				if ($pm_status == "Assigned") {
					// code to calculate number of units
					$t = $pmc_assigned+$pmc_assigned_late;
					echo "{y: ".$t.", myData: '$sap'}";
				}
				if ($pm_status == "Due PM") {
					// code to calculate number of units
					echo "{y: ".$due_units.", myData: '$sdp'}";
				}
				if ($pm_status == "PM Neglected") {
					// code to calculate number of units
					echo "{y: ".$neglected.", myData: '$spn'}";
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