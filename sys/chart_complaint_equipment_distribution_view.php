<script>
$(document).ready(function() {

	var options = {

        chart: {
            type: 'pie',
			plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
			backgroundColor: null
        },

        title: {
            text: ''
        },

        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
		
		

         plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
						textOutline: false
                    }
                }
            }
        },

        series: [{
            name: 'Complaints',
            colorByPoint: true,
            data: [
			<?php
				$cq = 	$this->db->query("SELECT *
									FROM tbl_complaints
									WHERE complaint_nature='complaint' AND assign_to = '$fk_employee_id'");
				$cr = 	$cq->result_array(); // For total PM
				$total 	=	sizeof($cr);
				$pq	=	$this->db->query("SELECT DISTINCT(product_name),pk_product_id FROM `tbl_complaints`
									LEFT JOIN tbl_instruments ON tbl_instruments.pk_instrument_id = tbl_complaints.fk_instrument_id
									LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
									WHERE complaint_nature='complaint' AND assign_to = '$fk_employee_id'
									ORDER BY product_name ");
				$pr = 	$pq->result_array(); // For All Product Names
				$comma_limit = sizeof($pr);
				$i = 1;
				foreach ($pr AS $pm) {
					$cq = 	$this->db->query("SELECT * FROM `tbl_complaints`
							LEFT JOIN tbl_instruments ON tbl_instruments.pk_instrument_id = tbl_complaints.fk_instrument_id
							LEFT JOIN tbl_products ON tbl_products.pk_product_id = tbl_instruments.fk_product_id
							WHERE complaint_nature='complaint' AND assign_to = '$fk_employee_id' AND pk_product_id = '".$pm['pk_product_id']."' ");
					$cr = 	$cq->result_array(); // Respective Product PM
					$count 	=	sizeof($cr);
					$pm_percentage	=	($count/$total) * 100;
					echo "{ name: '".$pm['product_name']."',";
					echo "	y:".$pm_percentage."}";
					if ($i<$comma_limit) echo ",";
					$i++;
				}
			?>
			]
        }]
    };
    
    $('#chart_complaint_equipment_distribution').highcharts(options);
	});
</script>
