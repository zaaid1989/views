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


<?php 

$month = time();
$months = array('');
$products = array('');
$product_ids = array('');
$monthss = array('');
$offices = array('Rawalpindi Office','Lahore Office','Karachi Office','Multan Office','Peshawar Office');
$complaint_types = array('complaint','PM');
$complaint_status = array('Shifted','Pending Verification','SPRF Approved','Pending SPRF','Pending','Pending Registration','Closed');
$user_color = array('#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281','#4b8df8','#ecbc29','#f3565d','#9a12b3','#d91e18','#ffb848','#26c281');
$months_to_show = 6;
for ($i=0;$i<$months_to_show;$i++) {
	//array_push($months,date('F Y', $month), PHP_EOL) ;
	$months[$i] = "'".date('F Y', $month)."'";
	$monthss[$i] = date('Y-m', $month);
	$month = strtotime("-1 month", $month);
}

if ($territory!=0){
//$q = $this->db->query("SELECT * FROM user WHERE fk_office_id='$territory' AND delete_status=0 AND userrole IN('FSE','Supervisor')");
$q = $this->db->query("SELECT * FROM user WHERE id IN (SELECT DISTINCT assign_to from tbl_complaints WHERE fk_office_id='$territory'  AND CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ) AND delete_status=0 AND userrole IN('FSE','Supervisor')");
}
else
	$q = $this->db->query("SELECT * FROM user WHERE id IN (SELECT DISTINCT assign_to from tbl_complaints WHERE CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."' ) AND userrole IN('FSE','Supervisor')");
$users = $q->result_array();

$m = 0;
foreach ($users AS $u)	{
		$s = substr(md5($u['first_name']), 25, 6);
		$result ="#".$s;
		$user_color[$m]=$result;//array_push($products,$t) ;
		$m++;
}




if ($territory==0)
$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_instruments.pk_instrument_id IN (SELECT DISTINCT fk_instrument_id from tbl_complaints WHERE tbl_complaints.status NOT IN ('Closed','Completed') AND CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."') AND tbl_products.fk_category_id >= 1 AND tbl_products.status=0");
else
$q = $this->db->query("SELECT DISTINCT tbl_products.product_name, pk_product_id
FROM `tbl_instruments`
LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
WHERE tbl_instruments.pk_instrument_id IN (SELECT DISTINCT fk_instrument_id from tbl_complaints WHERE tbl_complaints.status NOT IN ('Closed','Completed') AND CAST(`date` AS DATE) BETWEEN '".date('Y-m-d',strtotime('-30 days'))."' AND '".date('Y-m-d')."') AND tbl_products.fk_category_id >= 1 AND tbl_products.status=0 AND tbl_instruments.fk_office_id ='".$territory."'");
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
			marginBottom: 190,
			backgroundColor: null
        },

        title: {
            text: 'TS Department PENDING Task (Real Time)'
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
                text: 'Number of Pending Complaints and Assigned PM',
				margin:20
            },
            stackLabels: {
                enabled: true,
				shadow: false,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                },
				formatter: function() {
                    return  this.stack+"<br/>("+this.total+")";
                }
            }
        },
		legend: {
            align: 'center',
            x: -20,
            verticalAlign: 'bottom',
            y: 2,
            floating: false,
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
                //return '' + this.x +  '<br/><b>' + this.series.options.stack +  '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Total : ' + this.point.stackTotal;
				return '<b>' + this.series.name + '</b><br/><b style=\"color: #DC143C;\">Pending: ' + this.y + '</b><br/>'+ this.point.myData;
				}
            }
        },

        plotOptions: {
			"series": {
                events:{
                    legendItemClick:function(){
                        var name = this.name,
                            series = this.chart.series;
                        
                        $.each(series, function(i,serie){
                            if(serie.name == name) {
                                if(serie.visible)
                                    serie.hide();
                                else
                                    serie.show();
                            }
                        });
                        
                        return false;
                    }
			}},
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                }
            }
        },

        series: [
		<?php 
		$pending_complaints=0;
		$pending_pm=0;
		foreach ($complaint_types AS $complaint_nature) {
			$k=0;
			foreach ($users AS $user) {
				
				echo "{ name: '".$user['first_name']."',";
				echo "data: [";
				//for ($i=0;$i<$months_to_show;$i++) { // Loops through months
				$i=0;
				foreach ($product_ids AS $product_id) {
					$s="";
					$comma_limit 		= 	sizeof($product_ids) - 1;
					//$equipment_id		=	10;
					
					
					
					// Begin code to count complaints
					if ($territory!=0)
						$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status NOT IN ('Closed','Completed') AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_instruments`.fk_office_id = '".$territory."' AND `tbl_complaints`.assign_to='".$user['id']."'");
					else 
						$cquery = $this->db->query("SELECT `tbl_complaints`.*,`user`.first_name,`tbl_cities`.city_name,`tbl_clients`.client_name,`tbl_products`.product_name,`tbl_instruments`.serial_no,`tbl_area`.area
						FROM `tbl_complaints`
						LEFT JOIN tbl_cities ON `tbl_complaints`.fk_city_id = `tbl_cities`.pk_city_id
						LEFT JOIN tbl_clients ON `tbl_complaints`.fk_customer_id = `tbl_clients`.pk_client_id
						LEFT JOIN tbl_instruments ON `tbl_complaints`.fk_instrument_id = `tbl_instruments`.pk_instrument_id
						LEFT JOIN tbl_products ON `tbl_products`.pk_product_id = `tbl_instruments`.fk_product_id
						LEFT JOIN tbl_area ON `tbl_area`.pk_area_id = `tbl_clients`.fk_area_id
						LEFT JOIN user ON `user`.id = `tbl_complaints`.assign_to
						WHERE `tbl_complaints`.complaint_nature='".$complaint_nature."' AND `tbl_complaints`.status NOT IN ('Closed','Completed') AND `tbl_instruments`.fk_product_id = '".$product_id."' AND `tbl_complaints`.assign_to='".$user['id']."'");
						
						
						$cresult = $cquery->result_array();
						foreach ($cresult AS $comp)
								$s .= "<br/>".$comp['client_name'];
						
						if ($complaint_nature=='PM') $pending_pm += sizeof($cresult);
						else $pending_complaints += sizeof($cresult);
						
						echo "{y: ".sizeof($cresult).", myData: '$s'}";
					// End Code to count complaints

					if ($i<$comma_limit) echo ",";
					$i++;
				}
				//echo "3, 4, 4, 2, 5,6";
				echo "],";
				echo "color:'".$user_color[$k]."',";
				echo "showInLegend: true,";
				echo "stack: '".ucfirst($complaint_nature)."'";
				echo "},";
				$k++;
			}
		} 
		?>
	 ]
    };
    
    $('#container').highcharts(options);
	});
	
</script>	  
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
								<span class="caption-helper">Chart for Territory Complaints</span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>complaint/chart_real_time_territory_report">
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
								<div class="col-md-6">
                            		<p><b>Description of Graph</b><br/>
									- Number on the Top of each Bar is Total Pending(Complaints or Assigned PM) in selected Territory<br/>
									- Different Colors in each Bar represent Engineers<br/>
									- Move the cursor on the bar to see further details of Engineer Tasks such as Total and Pending<br/>
									</p>
                                </div>
                           </div>	
						   
						   <div class="row">
								<table class="table table-striped table-bordered table-hover hover">
									<tr>
										<th>Total Pending Complaints </th>
										<td><?php echo $pending_complaints; ?></td>
										<th>Total Pending Assigned PM </th>
										<td><?php echo $pending_pm; ?></td>
									</tr>
								</table>
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
								<span class="caption-subject bold uppercase"> TS Department PENDING Task (Real Time)</span>
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
								<div id="container" style="width: 100%; height:500px; margin-left:20px; "></div> 	 	 
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