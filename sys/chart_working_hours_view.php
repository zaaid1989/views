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

$working_hours_field = array('');
$working_hours_office = array('');
$visits_per_day = array('');
$average_pm_hours_submit = array('');
$average_pm_hours_finish = array('');
$average_ts_hours_submit = array('');
$average_ts_hours_finish = array('');
$CI =& get_instance();

for ($i=0;$i<$months_to_show;$i++) {
	$average_visits_hours_work = $CI->average_visits_hours_work($fk_employee_id,$monthss[$i]); 
	$average_ts_pm_hours = $CI->average_ts_pm_hours($fk_employee_id,$monthss[$i]); 

	$visits_per_day[$i] =	$average_visits_hours_work[0]; //$average_visits_per_day;
	$working_hours_office[$i] = $average_visits_hours_work[1];//$offices_hours;
	$working_hours_field[$i] = $average_visits_hours_work[2];
	
	$average_pm_hours_submit[$i] = $average_ts_pm_hours[0];
	$average_pm_hours_finish[$i] = $average_ts_pm_hours[1];
	$average_ts_hours_submit[$i] = $average_ts_pm_hours[2];
	$average_ts_hours_finish[$i] = $average_ts_pm_hours[3];
}

?>
<script>
$(document).ready(function() {

	var options = {
		chart: {
			backgroundColor: null
        },
        title: {
            text: '',
           // x: -20 //center
        },
        subtitle: {
           // text: 'Source: WorldClimate.com',
           // x: -20
        },
        xAxis: {
            categories: [<?php echo  implode(',',$months);?>]
        },
        yAxis: {
            title: {
                text: 'Average Working Hours'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' Hours'
        },
        legend: {
            layout: 'vertical',
            align: 'center',
            verticalAlign: 'top',
            borderWidth: 0
        },

        series: [{
            name: 'Working Hours Office',
            data: [<?php echo  implode(',',$working_hours_office);?>]
        }, {
            name: 'Working Hours Field',
            data: [<?php echo  implode(',',$working_hours_field);?>]
        }]
    };
    
    $('#chart_working_hours').highcharts(options);
	});
</script>


<script>
///////////////////*********************** VISITS PER DAY CHART ***********************\\\\\\\\\\\\\\\\\\\\
$(document).ready(function() {

	var options = {
		chart: {
			backgroundColor: null
        },
        title: {
            text: '',
           // x: -20 //center
        },
        subtitle: {
           // text: 'Source: WorldClimate.com',
           // x: -20
        },
        xAxis: {
            categories: [<?php echo  implode(',',$months);?>]
        },
        yAxis: {
            title: {
                text: 'Average Visits'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' Visits'
        },
        legend: {
            layout: 'vertical',
            align: 'center',
            verticalAlign: 'top',
            borderWidth: 0
        },

        series: [{
            name: 'Average Visits Per Day',
            data: [<?php echo  implode(',',$visits_per_day);?>]
        }]
    };
    
    $('#chart_average_visits_per_day').highcharts(options);
	});
</script>

<script>
///////////////////*********************** VISITS PER DAY CHART ***********************\\\\\\\\\\\\\\\\\\\\
$(document).ready(function() {

	var options = {
		chart: {
			backgroundColor: null
        },
        title: {
            text: '',
           // x: -20 //center
        },
        subtitle: {
           // text: 'Source: WorldClimate.com',
           // x: -20
        },
        xAxis: {
            categories: [<?php echo  implode(',',$months);?>]
        },
        yAxis: {
            title: {
                text: 'Average Visits'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' Visits'
        },
        legend: {
            layout: 'vertical',
            align: 'center',
            verticalAlign: 'top',
            borderWidth: 0
        },

        series: [{
            name: 'Average Visits Per Day',
            data: [<?php echo  implode(',',$visits_per_day);?>]
        }]
    };
    
    $('#chart_average_visits_per_day').highcharts(options);
	});
</script>

<script>
//////////////////////// *********** PM Completed Verification Time ***********\\\\\\\\\\\\\\\\\\\\
$(document).ready(function() {

	var options = {
		chart: {
			backgroundColor: null
        },
        title: {
            text: '',
           // x: -20 //center
        },
        subtitle: {
           // text: 'Source: WorldClimate.com',
           // x: -20
        },
        xAxis: {
            categories: [<?php echo  implode(',',$months);?>]
        },
        yAxis: {
            title: {
                text: 'Hours'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' Hours'
        },
        legend: {
            layout: 'vertical',
            align: 'center',
            verticalAlign: 'top',
            borderWidth: 0
        },

        series: [{
            name: 'Average PM Complete Time',
            data: [<?php echo  implode(',',$average_pm_hours_submit);?>]
        }, {
            name: 'Average PM Verification Time',
            data: [<?php echo  implode(',',$average_pm_hours_finish);?>]
        }]
    };
    
    $('#chart_pm_hours').highcharts(options);
	});
</script>


<script>
//////////////////////// *********** Complaint Closed Verification Time ***********\\\\\\\\\\\\\\\\\\\\
$(document).ready(function() {

	var options = {
		chart: {
			backgroundColor: null
        },
        title: {
            text: '',
           // x: -20 //center
        },
        subtitle: {
           // text: 'Source: WorldClimate.com',
           // x: -20
        },
        xAxis: {
            categories: [<?php echo  implode(',',$months);?>]
        },
        yAxis: {
            title: {
                text: 'Hours'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' Hours'
        },
        legend: {
            layout: 'vertical',
            align: 'center',
            verticalAlign: 'top',
            borderWidth: 0
        },

        series: [ {
            name: 'Average TS Close Time',
            data: [<?php echo  implode(',',$average_ts_hours_submit);?>]
        }, {
            name: 'Average TS Verification Time',
            data: [<?php echo  implode(',',$average_ts_hours_finish);?>]
        }]
    };
    
    $('#chart_ts_hours').highcharts(options);
	});
</script>