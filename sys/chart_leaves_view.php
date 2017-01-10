
<?php
$month = time();
$months = array('');
$monthss = array('');
$months_to_show = 12;
for ($i=0;$i<$months_to_show;$i++) {
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-1 months", $month); // might have to change this to -1 months or something
}
$months = array_reverse($months); // in application format
$monthss = array_reverse($monthss); // in sql format
?>
<div class="col-md-6">
<div class="portlet solid bordered light bg-inverse hClass">
                <div class="portlet-title">
                  <div class="caption font-red-thunderbird">
								<i class="icon-globe font-red-thunderbird"></i>
								<span class="caption-subject bold uppercase"> Leaves Summary (Last 12 Months)</span>
							</div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
				
            <div class="portlet-body">
					
			<div class="row">
                    <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
						<table class="table table-bordered " id="">
							<thead class="bg-red-thunderbird">
								
								<tr >
									<th style="width:120px;">Month</th>
									<th>Leaves Within Time Form Submission</th>
									<th>Leaves With Late Form Submission</th>
								</tr>
							</thead>
							<tbody>
								
								<?php
									$month_leaves = array('');
									$month = time();
									$months_to_show = 12;
									$temp = 11;
									for ($i=0;$i<$months_to_show;$i++) {
										// $ month is used in following as month is subtracted at the end of loop
										$month_system 	= date('F Y', $month); // System Format
										$month_sql 		= date('Y-m', $month); // Sql format
										$number = cal_days_in_month(CAL_GREGORIAN, date('m', $month), date('Y', $month)); // number of days in this month
										$first_of_month 	= 	$month_sql.'-01';
										$last_of_month		= 	$month_sql.'-' . $number;
										
										$leaves_timely	=	"";
										$leaves_late	=	"";
										
										$timely = 0;
										$late = 0;
										
										$cquery = $this->db->query("
											SELECT
											(SELECT COUNT(*) FROM tbl_leaves WHERE application_date < start_date AND fk_employee_id = '$fk_employee_id' AND CAST(`start_date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."') AS leaves_timely,
											(SELECT COUNT(*) FROM tbl_leaves WHERE application_date >= start_date AND fk_employee_id = '$fk_employee_id' AND CAST(`start_date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."') AS leaves_late
											FROM tbl_leaves
											WHERE fk_employee_id = '$fk_employee_id' AND CAST(`start_date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."'");
										$cresult = $cquery->result_array();
										
										//////////// Leaves Starting and Ending same Month
										$lq = $this->db->query("
											SELECT *
											FROM tbl_leaves
											WHERE fk_employee_id = '$fk_employee_id' AND CAST(`start_date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' AND CAST(`end_date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ");
										$lr = $lq->result_array();
										if (sizeof($lr)>0) {
											foreach ($lr AS $leave) {
												$t = 0;
												// Count Number of days in Each Leave Application
												if($leave['leave_type']=='1') $t = $t + 0.5;
												else {
													$countd = 0;
													$sd = strtotime($leave['start_date']);
													$ed = strtotime($leave['end_date']);
													while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
													  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
													  $sd = strtotime("+1 day", $sd);
													}
													$t = $t + $countd;
												}
												// $t is the Number of days in current leave application
												// Check if it's late or on time
												if ($leave['application_date'] < $leave['start_date']) $timely = $timely + $t;
												else $late = $late + $t;
											}
										}
										
										$lq_1 = $this->db->query("
											SELECT *
											FROM tbl_leaves
											WHERE fk_employee_id = '$fk_employee_id' AND `start_date` < '".$first_of_month."' AND CAST(`end_date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ");
										$lr_1 = $lq_1->result_array();
										if (sizeof($lr_1)>0) {
											foreach ($lr_1 AS $leave) {
												$t = 0;
												// Count Number of days in Each Leave Application
												if($leave['leave_type']=='1') $t = $t + 0.5; // will never go into this
												else {
													$countd = 0;
													//$sd = strtotime($leave['start_date']);
													$sd = strtotime($first_of_month);
													$ed = strtotime($leave['end_date']);
													while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
													  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
													  $sd = strtotime("+1 day", $sd);
													}
													$t = $t + $countd;
												}
												// $t is the Number of days in current leave application
												// Check if it's late or on time
												if ($leave['application_date'] < $leave['start_date']) $timely = $timely + $t;
												else $late = $late + $t;
											}
										}
										
										$lq_2 = $this->db->query("
											SELECT *
											FROM tbl_leaves
											WHERE fk_employee_id = '$fk_employee_id' AND CAST(`start_date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' AND `end_date` > '".$last_of_month."' ");
										$lr_2 = $lq_2->result_array();
										if (sizeof($lr_2)>0) {
											foreach ($lr_2 AS $leave) {
												$t = 0;
												// Count Number of days in Each Leave Application
												if($leave['leave_type']=='1') $t = $t + 0.5; // will never go into this
												else {
													$countd = 0;
													$sd = strtotime($leave['start_date']);
													//$ed = strtotime($leave['end_date']);
													$ed = strtotime($last_of_month);
													while(date('Y-m-d', $sd) <= date('Y-m-d', $ed)){ //<= rather < so that end date is inclusive
													  $countd += date('N', $sd) <= 6 ? 1 : 0; // <= rather only < so that saturday is counted as well
													  $sd = strtotime("+1 day", $sd);
													}
													$t = $t + $countd;
												}
												// $t is the Number of days in current leave application
												// Check if it's late or on time
												if ($leave['application_date'] < $leave['start_date']) $timely = $timely + $t;
												else $late = $late + $t;
											}
										}
										
										if (sizeof($lr)>0) {
											$leaves_timely	=	$cresult[0]['leaves_timely'];
											$leaves_late	=	$cresult[0]['leaves_late'];
										}
										echo '<tr style="background-color: white;">';
										echo "<td>".$month_system."</td>";
										echo "<td>".$timely."</td>";
										echo "<td>".$late."</td>";
										echo '</tr>';
										$month_leaves[$i] = $timely + $late;
										$month = strtotime("-1 months", $month); // Subtract month so that in next loop previous month data is shown
									}
								?>
								
							</tbody>
						</table>
                        
						
                      </div>
                    </div>
					
				</div>
				</div>	
				
</div>
<?php //print_r($month_leaves);?>
















<?php 
$month = time();
$months = array('');
$monthss = array('');
$months_to_show = 6;
for ($i=0;$i<$months_to_show;$i++) {
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-1 months", $month); // might have to change this to -1 months or something
}
$months = array_reverse($months); // in application format
$monthss = array_reverse($monthss); // in sql format

$fine_statuses = array("Discarded","Charged","Pending");
$fine_status_color = array('#4B77BE','#4B77BE','#CB0909');
?>


<script>
$(document).ready(function() {

	var options = {

        chart: {
            type: 'column',
			marginBottom: 50,
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
                text: 'Number of Leaves',
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
			enabled: true,
            x: 0,
            verticalAlign: 'top',
            y: 25,
            floating: false,
            backgroundColor: '#FFF',
            borderColor: '#CCC', 
            borderWidth: 1,
            shadow: false
        },

        tooltip: {
            formatter: function () {
				if (this.series.options.type === 'pie' || this.series.options.type === 'spline') { // the pie chart
                        return this.point.name + ': ('+this.point.myData+' units)' + this.y;
                    }
				else {
                return '' + this.series.name + ': ' + this.y ;
				}
            }
        },

        plotOptions: {
			 series: {
                    dataLabels: {
                        enabled: false,
						color: '#fff',
                        style: {fontWeight: 'bolder',textOutline: false  },
                    }
                },
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 0px black'
                    },
					formatter: function() {
						if (this.y != 0) {
						  return this.y +'';
						} else {
						  return null;
						}
					}
                }
            }
        },

        series: [
		<?php 
				$month_leaves = array_reverse($month_leaves); // so that values are from smaller month to greater month
				echo "{name: 'Leaves',
					data: [";
				for ($i=0;$i<$months_to_show;$i++) { // Loops through months
					$comma_limit 		= 	$months_to_show - 1;
					echo $month_leaves[$i+6]; // to show last 6 months
					if ($i<$comma_limit) echo ",";
				}
				echo "],";
				echo "color:'".$fine_status_color[0]."',";
				echo "showInLegend: true";
	echo "}";
		?>
		]
    };
    
    $('#chart_leaves').highcharts(options);
	});
</script>
