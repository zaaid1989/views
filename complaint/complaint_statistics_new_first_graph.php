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
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Complaint Statistics </span>
								<span class="caption-helper">Complaint Statistics for Equipments</span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>complaint/complaint_statistics">
                                <div class="col-md-4">
                            		<div class="form-group">
                            			
                                        <select name="equipment" id="equipment" class="form-control" required>
                                            <option value="">--Select Equipment--</option>
											<?php 
											$maxqu = $this->db->query("SELECT tbl_instruments.* ,tbl_products.product_name FROM tbl_instruments 
											LEFT JOIN tbl_products ON tbl_instruments.fk_product_id = tbl_products.pk_product_id
											ORDER BY   `product_name`,`pk_instrument_id` ");
											
											$maxqu = $this->db->query("SELECT * FROM tbl_products 
											WHERE fk_type_id=1 AND status=0
											ORDER BY   `product_name` ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val)
                                            {
                                                
                                                ?>
                                                <option value="<?php echo $val['pk_product_id'];//pk_instrument_id?>" <?php if(isset($_GET['equipment']) && $_GET['equipment']==$val['pk_product_id']){ echo 'selected="selected"';}//pk_instrument_id?>>
													<?php echo $val['product_name'];//$val['serial_no'].' - '.$val['product_name']?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
                                        </select>
                            		</div>
                          		</div>
								
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


<?php if ($equipment_id!='0') { // Graph
?>
					<div class="portlet solid bordered light bg-inverse ">
						<!-- Portlet Title -->
						<div class="portlet-title">
							<div class="caption font-purple-seance">
								<i class="icon-bar-chart font-purple-seance"></i>
								<span class="caption-subject bold uppercase"> Last 6 Months</span>
								<span class="caption-helper">Overview</span>
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
								<div id="container" style="width: 100%; height: auto; margin-left:20px; "></div> 	 
						<!--	</div> -->
						</div>
						<!-- End Portlet Body -->
					</div>
<?php
}
?>

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

 <?php for ($k=0;$k<1;$k++) { ?>
		<!-- Assigned Total -->
		<div class="portlet light bg-inverse">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-grey-gallery<?php //echo $title_colors[$k]; ?>"></i>
								<span class="caption-subject bold font-grey-gallery<?php //echo $title_colors[$k]; ?> uppercase">
								<?php //echo $titles[$k]; ?> Assigned and Pending Summary </span>
								<span class="caption-helper"></span>
							</div>
						</div>
					<div class="portlet-body">
						  			
                <table class="table  table-hover dataaTable table-bordered" id="">
					<thead class="bg-grey-gallery<?php //echo $title_colors[$k]; ?>">
					<tr>
						<th> </th>
						<?php
						$q		= "SELECT * from tbl_offices";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						foreach ($result AS $office)
							echo "<th colspan='2'> ".$office['office_name']." </th>";
						?>
						<th colspan='2'> Total </th>
					</tr>
					<tr>
						<th> Months </th>
						<?php
						$q		= "SELECT * from tbl_offices";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						foreach ($result AS $office)
							echo "<th> Assigned </th> <th> Pending </th>";
						?>
						<th> Assigned </th> <th> Pending </th>
					</tr>
					</thead>
					<tbody> 
					
					<?php  // Current Pending Calls
							$start = $month = strtotime($start_date);
							$end = strtotime($end_date);
							$start = $month = strtotime('2015-08-01');
							$end = time();
							while($month < $end)
							{
								$total = 0;
								$total_p = 0;
								echo "<tr>";
								echo "<td class='bg-grey'>".date('F Y', $month), PHP_EOL ."</td>";
								$first_of_month = date('Y-m', $month).'-01';
								$last_of_month = date('Y-m', $month).'-31';
								foreach ($result AS $office) {
									//echo "<th> ".$office['office_name']." </th>";
									$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
									FROM `tbl_complaints`
									LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
									LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
									LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
									LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
									WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_instruments`.fk_product_id = '".$equipment_id."' AND `tbl_complaints`.fk_office_id='".$office['pk_office_id']."' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ORDER BY `date` ASC");
									
									$cresult = $cquery->result_array();
									$total = $total + sizeof($cresult);
									echo "<td class=''> ".zerodisplay(sizeof($cresult))." </td>";
									
									$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
									FROM `tbl_complaints`
									LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
									LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
									LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
									LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
									WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status!='Closed' AND `tbl_instruments`.fk_product_id = '".$equipment_id."' AND `tbl_complaints`.fk_office_id='".$office['pk_office_id']."' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ORDER BY `date` ASC");
									
									$cresult = $cquery->result_array();
									$total_p = $total_p + sizeof($cresult);
									echo "<td class='danger'> ".zerodisplay(sizeof($cresult))." </td>";
								}
								echo "<td class=''>". $total ."</td>";
								echo "<td class='danger'>". $total_p ."</td>";
								echo "</tr>";
								
								 $month = strtotime("+1 month", $month);
							}
					?>
					</tbody>
              </table>      
					</div>
		<!-- Assigned Total -->
		</div>
<?php } ?>
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bg-inverse<?php //echo $portlet_color[$k]; ?>">
            <div class="portlet-title">
              <div class="caption"> <i class="icon-pie-chart font-yellow-gold"></i><span class="caption-subject bold font-yellow-gold ">
						Service Calls - <?php echo $start_date_f.' to '.$end_date_f ?> </span></div>
              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
			
                <table class="table  table-hover " id="sample_225">
					<thead class="bg-yellow-gold">
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
					</tr>
					<tr>
						<th> TS Number </th>
						<th> Time Taken </th>
						<th> Territory </th>
						<th> City </th>
						<th> Customer </th>
						<th> Serial No </th>
						<th> Problem Summary </th>
						<th> FSE/SAP </th>
						<th> Status </th>
						<th> Actions </th>
						
					</tr>
					</thead>
					<tbody> 
					
					<?php  // Current Pending Calls
						$q		= "SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_offices`.office_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
									FROM `tbl_complaints`
									LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
									LEFT JOIN tbl_offices ON `tbl_complaints`.fk_office_id = `tbl_offices`.pk_office_id
									LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
									LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
									LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
									LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
									LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
									WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_instruments`.fk_product_id = '".$equipment_id."' ";
						if ($dates_set=="yes") {
							$temp_date = date('Y-m-d H:i:s',strtotime('2015-04-01 00:00:00'));
							$q		.=	"AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ";
						}
						$q		.=	"ORDER BY 'date' ASC";
						$query 	= $this->db->query($q);
						$result = $query->result_array();
						
						foreach ($result AS $pmc) {
							$temp_time_taken = "";
							if ($pmc['status']=='Closed')
								$temp_time_taken = Get_Date_Difference($pmc["date"],$pmc["finish_time"]);
							else
								$temp_time_taken = Get_Date_Difference($pmc["date"],date('Y-m-d H:i:s'));
							
							//$temp_status = "";
							
							echo '<tr> ';
							echo '<td>'.$pmc['ts_number'].'</td>';
							//echo '<td>'.date('d-M-Y',strtotime($pmc['date'])).'</td>';
							echo '<td>'.$temp_time_taken.'</td>';
							echo '<td>'.$pmc['office_name'].'</td>';
							echo '<td>'.$pmc['city_name'].'</td>';
							echo '<td>'.$pmc['client_name'].'</td>';
							echo '<td>'.$pmc['serial_no'].'</td>';
							echo '<td>'.urldecode($pmc['problem_summary']).'</td>';
							echo '<td>'.$pmc['first_name'].'</td>';
							echo '<td>';
								$this->load->model("complaint_model");
								$obj=new Complaint_model();
								$obj->current_status($pmc['status']);
							echo '</td>';
							echo '<td>';
								echo '<a class="btn btn-sm default purple-stripe" href="'.base_url().'complaint/ts_report_director/'.$pmc["pk_complaint_id"].'">';
								echo 'TSR <i class="fa fa-eye"></i></a>';
							echo '</td>';
							echo '</tr> ';
						}
					?>
					</tbody>
              </table>
            </div>
          </div>
		
          
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
$monthss = array('');
$offices = array('Rawalpindi Office','Lahore Office','Karachi Office','Multan Office','Peshawar Office');
$complaint_status = array('Shifted','Pending Verification','SPRF Approved','Pending SPRF','Pending','Pending Registration','Closed');
$status_color = array('#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281');
$months_to_show = 6;
for ($i=0;$i<$months_to_show;$i++) {
	//array_push($months,date('F Y', $month), PHP_EOL) ;
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-1 month", $month);
}
//print_r($months);
//echo implode(',',$offices);

?>


<script>
$(document).ready(function() {


	
	var options = {

        chart: {
            type: 'column',
			backgroundColor: null
        },

        title: {
            text: 'Complaints by Month'
        },

        xAxis: {
            //categories: ['Feb', 'Jan', 'Dec', 'Nov', 'Oct']
			categories: [<?php echo  implode(',',$months);?>]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of Complaints',
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
            align: 'right',
            x: -30,
            verticalAlign: 'top',
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
                return '' + this.x +  '<br/><b>' + this.series.options.stack +  '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total Assigned: ' + this.point.stackTotal;
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
		$j= 1; // will be used for office id, started from 1 as id of rawalpindi office is 1
		foreach ($offices AS $office) {
			$k=0;
			foreach ($complaint_status AS $status) {
				
				echo "{ name: '".$status."',";
				echo "data: [";
				for ($i=0;$i<$months_to_show;$i++) { // Loops through months
					$comma_limit 		= 	$months_to_show - 1;
					//$equipment_id		=	10;
					
					$first_of_month 	= 	$monthss[$i].'-01';
					$last_of_month		= 	$monthss[$i].'-31';
					
					// Begin code to count complaints
					$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status='".$status."' AND `tbl_instruments`.fk_product_id = '".$equipment_id."' AND `tbl_complaints`.fk_office_id='".$j."' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ORDER BY `date` ASC");
						
						$cresult = $cquery->result_array();
						echo sizeof($cresult);
					// End Code to count complaints

					if ($i<$comma_limit) echo ",";
				}
				//echo "3, 4, 4, 2, 5,6";
				echo "],";
				echo "color:'".$status_color[$k]."',";
				echo "showInLegend: false,";
				echo "stack: '".$office."'";
				echo "},";
				$k++;
			}
			$j++;
		} 
		?> /*
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
        },*/{
            type: 'pie',
            name: 'Aggregate',
            data: [
			<?php 
			$k=0;
			//$equipment_id = 10;
			foreach ($complaint_status AS $status) {
				echo "{name:'".$status."',";
				echo "y: ";
				// Begin code to count complaints
					$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status='".$status."' AND `tbl_instruments`.fk_product_id = '".$equipment_id."'  AND CAST(`date` AS DATE) BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY `date` ASC");
						
						$cresult = $cquery->result_array();
						echo sizeof($cresult);
					// End Code to count complaints
				echo ",";
				echo "color: '".$status_color[$k]."' ";
				echo "},";
				$k++;
			}
			?> /*
			{
                name: 'Jane',
                y: 13,
                color: Highcharts.getOptions().colors[0] // Jane's color
            }, {
                name: 'John',
                y: 23,
                color: Highcharts.getOptions().colors[1] // John's color
            }, {
                name: 'Joe',
                y: 19,
                color: Highcharts.getOptions().colors[2] // Joe's color
            }*/],
            center: [50, 0],
            size: 100,
            showInLegend: false,
			inside: true,
            dataLabels: {
                enabled: true,
				format: '{y}'
            },
			plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{y}'
                }
				}
			}
        }]
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