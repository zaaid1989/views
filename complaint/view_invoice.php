<?php $this->load->view('header_new_date');
?>
										
<div class="page-head">					
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-title">
                    <h1>View Invoices</h1> <small><?php //echo $average_visits_per_day; ?></small>
                    </div>
</div>
                    <div class="page-bar">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                
                                <a href="<?php echo base_url();?>">Home<i class="fa fa-circle"></i></a>
                                
                            </li>
                            <li>
                                <span class="active">All Invoices</span>
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
						All Invoices List </span></div>
              <div class="tools"> 
              	<a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
			 <!--<div class="alert alert-success">Price column is missing here.<br /> 
             Does the order status represents whole order or status of individual item in the order?<br />
             How the status of order will be updated? WE are assuming it will be updated when the invoice will be generated.Based on our assumption order status will be updated on generation of invoice by subtracting the quantity in invoice from order and making it complete when quantity in inoice = quantity ordered. This is good for part-delivery orders. How will the scenario of part-delivery allowed = NO orders or orders where delivery date of some items is same? How to restrict part-delivery of such orders in invoice?
             
             </div>-->
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
						
						
					</tr>
					<tr>
						
						<th> Office</th>
						<th> Invoice Date </th>
						<th> Header </th>
						<th> Customer </th>
						<th> Invoice Type </th>
						<th> Invoice Issued </th>
						<th> Customer Signed Copy</th>
						<th> Actions </th>
						
						
					</tr>
					</thead>
					<tbody> 
					     <tr>
                         <td>HO</td>
                         <td>28-Sep-2016</td>
                         <td>PMA</td>
                         <td>CMH</td>
                         <td>New</td>
                         <td>Yes</td>
                         <td>No</td>
                         <td></td>
                         </tr>
                         
                         <tr>
                         <td>KO</td>
                         <td>29-Sep-2016</td>
                         <td>RBS</td>
                         <td>Shifa</td>
                         <td>DC</td>
                         <td>No</td>
                         <td>No</td>
                         <td></td>
                         </tr>
                         
                         <tr>
                         <td>LO</td>
                         <td>30-Sep-2016</td>
                         <td>Indus Lab</td>
                         <td>CITILab</td>
                         <td>DC</td>
                         <td>Yes</td>
                         <td>Yes</td>
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