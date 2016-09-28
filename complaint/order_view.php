<?php $this->load->view('header_new_date');
?>
										
<div class="page-head">					
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-title">
                    <h1>Outstanding Orders</h1> <small><?php //echo $average_visits_per_day; ?></small>
                    </div>
</div>
                    <div class="page-bar">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                
                                <a href="<?php echo base_url();?>">Home<i class="fa fa-circle"></i></a>
                                
                            </li>
                            <li>
                                <span class="active">Outstanding Orders</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
       <!-- BEGIN PAGE CONTENT-->
       <div class="row">
        <div class="col-md-12"> 



          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bg-inverse<?php //echo $portlet_color[$k]; ?>">
            <div class="portlet-title">
              <div class="caption"> <i class="icon-pie-chart font-blue-chambray"></i><span class="caption-subject bold font-blue-chambray ">
						Outstanding Order List </span></div>
              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
			 <div class="alert alert-success">Price column is missing here.<br /> 
             Does the order status represents whole order or status of individual item in the order?<br />
             How the status of order will be updated? WE are assuming it will be updated when the invoice will be generated.Based on our assumption order status will be updated on generation of invoice by subtracting the quantity in invoice from order and making it complete when quantity in inoice = quantity ordered. This is good for part-delivery orders. How will the scenario of part-delivery allowed = NO orders or orders where delivery date of some items is same? How to restrict part-delivery of such orders in invoice?
             
             </div>
                <table class="table  table-hover " id="sample_225">
					<thead class="bg-blue-chambray bg-font-blue-chambray">
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
						<th> </th>
						<th> </th>
						<th> </th>
						
					</tr>
					<tr>
						
						<th> Order Date</th>
						<th> Order No </th>
						<th> Office </th>
						<th> Customer </th>
						<th> Delivery Due Date </th>
						<th> Product </th>
						<th> Catalog </th>
						<th> Pack Size </th>
						<th> Quantity </th>
						<th> Quantity Delivered </th>
						<th> Quantity Pending </th>
						<th> Order Status</th>
						<th> Actions </th>
						
						
					</tr>
					</thead>
					<tbody> 
					     <tr>
                         <td>20-Sep-2016</td>
                         <td>14512</td>
                         <td>HO</td>
                         <td>CMH</td>
                         <td>28-Sep-2016</td>
                         <td>MC4P</td>
                         <td>03-07R-20</td>
                         <td>20 Test</td>
                         <td>5</td>
                         <td>5</td>
                         <td>0</td>
                         <td><span class="label label-sm label-success"> Completed</span></td>
                         <td></td>
                         </tr>
                         
                         <tr>
                         <td>21-Sep-2016</td>
                         <td>34512</td>
                         <td>LO</td>
                         <td>CITILab</td>
                         <td>29-Sep-2016</td>
                         <td>Rotor Gene</td>
                         <td>Z11000</td>
                         <td>1000 Tubes / Pack</td>
                         <td>10</td>
                         <td>0</td>
                         <td>10</td>
                         <td><span class="label label-sm label-danger">Pending</span></td>
                         <td></td>
                         </tr>
                         
                         <tr>
                         <td>22-Sep-2016</td>
                         <td>24512</td>
                         <td>KO</td>
                         <td>Shifa</td>
                         <td>01-OCt-2016</td>
                         <td>Access 2</td>
                         <td>33020</td>
                         <td>6 x 4 ml</td>
                         <td>8</td>
                         <td>5</td>
                         <td>3</td>
                         <td><span class="label label-sm label-warning">Part Delivery</span></td>
                         <td></td>
                         </tr>
					
					</tbody>
              </table>
            </div>
          </div>
		
          
<!-- END EXAMPLE TABLE PORTLET--> 

      </div>
     </div>
    
<?php $this->load->view('footer_new_date');?>

<script>
$(document).ready(function() { 
	var table = $('.dataaTable').dataTable({
	  'iDisplayLength': 500,
	  'aaSorting':[]
	});
	var table4 = $('#sample_225').dataTable({
			  'iDisplayLength': 500,
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