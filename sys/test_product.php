<?php $this->load->view('header');?>
 <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">Empty Page</h3>

					<!--
                    <div class="page-bar">
						<ul class="page-breadcrumb">
							<li>
								<i class="fa fa-home"></i>
								Home 
								<i class="fa fa-angle-right"></i>
							</li>
							<li>
								Empty Page
							</li>
						</ul>
                    </div>
					-->
                    <!-- END PAGE HEADER-->
                <!--    <div class="row" style="background:#F7F7F7; padding-top:5%;"> -->
				<div class="row">
                      <div class="col-md-12"> 
						<!-- Add Portlets etc -->
						
						
						
					<div class="col-md-12">
					<!-- BEGIN Portlet PORTLET-->
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
							</div>
						</div>
						<!-- End Portlet Body -->
					</div>
					<!-- END Portlet PORTLET-->
					</div>
						<!-- End Portlets etc -->
                      </div>
                    </div>
					
					<!-- Extra three divs -->
                </div>
            </div>
        </div>
	<!-- Extra three divs -->
	
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
					$equipment_id		=	10;
					
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
			$equipment_id = 10;
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
						WHERE `tbl_complaints`.complaint_nature='complaint' AND `tbl_complaints`.status='".$status."' AND `tbl_instruments`.fk_product_id = '".$equipment_id."'  ORDER BY `date` ASC");
						
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
            center: [100, 0],
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