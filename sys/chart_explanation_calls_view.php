<?php 
$explanation_calls_pending = 0;
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
$fine_status_color = array('#EEB719','#26C281','#CB0909');
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
                text: 'Number of Explanation Calls',
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
                return '' + this.series.name + ': ' + this.point.myData ;
				}
            }
        },

        plotOptions: {
			 series: {
                    dataLabels: {
                        enabled: true,
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
		$j= 0; // will be used for office id, started from 1 as id of rawalpindi office is 1
		//for($j=0;$j<2;$j++) { // 1 for complaints stack 2nd for total number of products
		for($j=0;$j<1;$j++) { // changing above to present as they dont need total number of products in this graph
			$k=0;
			foreach ($fine_statuses AS $fine_status) {
				
				echo "{ name: '".$fine_status."',";
				echo "data: [";
				for ($i=0;$i<$months_to_show;$i++) { // Loops through months
					$comma_limit 		= 	$months_to_show - 1;
					$first_of_month 	= 	$monthss[$i].'-01';
					$number = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($monthss[$i])), date('Y', strtotime($monthss[$i])));
					$last_of_month		= 	$monthss[$i].'-'.$number;
					
					// Begin code to count complaints
					
						
						$cquery = $this->db->query("SELECT * FROM tbl_fine
						WHERE status = '$fine_status' AND fk_employee_id = '$fk_employee_id' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ORDER BY `date` ASC");
						$cresult = $cquery->result_array();
						
						//$string= "(".sizeof($productss)." units)<br/>Total = ".sizeof($cresult)."<br/>Pending = ".sizeof($cresultt);
						$string = sizeof($cresult);
						
						if ($j==0)
							echo "{y: ".sizeof($cresult).", myData: '$string'}";
						
					// End Code to count complaints

					if ($i<$comma_limit) echo ",";
				}
				echo "],";
				echo "color:'".$fine_status_color[$k]."',";
				echo "showInLegend: true,";
				echo "},";
				$k++;
			}
		} 
		?>
		]
    };
    
    $('#chart_explanation_calls').highcharts(options);
	});
</script>

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
                  <div class="caption font-yellow-zed">
								<i class="icon-globe font-yellow-zed"></i>
								<span class="caption-subject bold uppercase"> Explanation Calls Summary (Last 12 Months)</span>
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
							<thead class="bg-yellow-zed">
								
								<tr >
									<th style="width:120px;">Month</th>
									<th>Pending</th>
									<th>Charged</th>
									<th>Discarded</th>
									<th>Daily Allowance</th>
								</tr>
							</thead>
							<tbody>
								
								<?php
								function return_blank_as_zero($a) {
									if ($a=="") return 0;
									else return $a;
								}
									$CI =& get_instance(); /// FOR DA
									$month = time();
									$months_to_show = 12;
									for ($i=0;$i<$months_to_show;$i++) {
										$month_system 	= date('F Y', $month); // System Format
										$month_sql 		= date('Y-m', $month); // Sql format
										$first_of_month 	= 	$month_sql.'-01';
										$number = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($month_sql)), date('Y', strtotime($month_sql)));
										$last_of_month		= 	$month_sql.'-'.$number;
										//$last_of_month		= 	$month_sql.'-31';
										
										$fine_pending	=	"";
										$fine_charged	=	"";
										$fine_discarded	=	"";
										$da 			= 	$CI->calculate_da($fk_employee_id,$last_of_month);
										
										$cquery = $this->db->query("
											SELECT
											(SELECT COUNT(*) FROM tbl_fine WHERE status = 'Pending' AND fk_employee_id = '$fk_employee_id' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."') AS count_pending,
											(SELECT COUNT(*) FROM tbl_fine WHERE status = 'Charged' AND fk_employee_id = '$fk_employee_id' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."') AS count_charged,
											(SELECT COUNT(*) FROM tbl_fine WHERE status = 'Discarded' AND fk_employee_id = '$fk_employee_id' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."') AS count_discarded,
											sum( (status = 'Pending') * amount) as sum_pending,
											sum( (status = 'Charged') * amount) as sum_charged,
											sum( (status = 'Discarded') * amount) as sum_discarded 
											FROM tbl_fine
											WHERE fk_employee_id = '$fk_employee_id' AND CAST(`date` AS DATE) BETWEEN '".$first_of_month."' AND '".$last_of_month."' ORDER BY `date` ASC");
										$cresult = $cquery->result_array();
										if (sizeof($cresult)>0) {
											$fine_pending	=	$cresult[0]['count_pending'].", (".return_blank_as_zero($cresult[0]['sum_pending']).")";
											$fine_charged	=	$cresult[0]['count_charged'].", (".return_blank_as_zero($cresult[0]['sum_charged']).")";
											$fine_discarded	=	$cresult[0]['count_discarded'].", (".return_blank_as_zero($cresult[0]['sum_discarded']).")";
										}
										if ($cresult[0]['count_pending']!="" && $last_of_month == $end_date) 
											$explanation_calls_pending = $cresult[0]['count_pending'];
										echo '<tr style="background-color: white;">';
										echo "<td>".$month_system."</td>";
										echo "<td>".$fine_pending."</td>";
										echo "<td>".$fine_charged."</td>";
										echo "<td>".$fine_discarded."</td>";
										echo "<td>".$da."</td>";
										echo '</tr>';
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
<?php
$query="insert INTO `tbl_report_errors_temp` SET 	
				  `fk_user_id`						='".$fk_employee_id."',
				  `month`							='".$end_date."',
				  `explanation_calls_pending`		='".$explanation_calls_pending."'
				  ON DUPLICATE KEY UPDATE 
				  `explanation_calls_pending`		='".$explanation_calls_pending."'";
$this->db->query($query);
?>