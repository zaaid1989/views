<?php $this->load->view('header');?>
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Forms <small>Download Required Form </small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						Home
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						Forms
						<i class="fa fa-angle-right"></i>
					</li>
					
				</ul>
				<div class="page-toolbar">
					
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
            <div class="row">
			  <div class="col-md-12">
			  
			  <div class="portlet box green">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Form Sample </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

                  </div>

                  <div class="portlet-body"> 

                    <!-- BEGIN FORM-->

                    
                     <table class="table table-bordered table-striped">
					 <thead>
					 <tr>
					 <th>Form</th>
					 <th>Download</th>
					 
					 </tr>
					 </thead>
					 
					 <tbody>
					 <tr>
					 <td>Customer Information Form</td>
					 <td><button type="button" class="btn btn-default"><a href="<?php echo base_url()?>forms/Form - Customer Information.docx" download>Download File</a></button></td>
					 </tr>
					 
					 <tr>
					 <td>FOC Product Requisition</td>
					 <td><button type="button" class="btn btn-default"><a href="<?php echo base_url()?>forms/Form - FOC Product Requisition.docx" download>Download File</a></button></td>
					 </tr>
					 
					 <tr>
					 <td>Outstation Visit Expense Claim - V4</td>
					 <td><button type="button" class="btn btn-default"><a href="<?php echo base_url()?>forms/Form - Outstation Visit Expense Claim - V4.docx" download>Download File</a></button></td>
					 </tr>
					 
					 <tr>
					 <td>CDR Requisition</td>
					 <td><button type="button" class="btn btn-default"><a href="<?php echo base_url()?>forms/Form - PMA CDR Requisition.xlsx" download>Download File</a></button></td>
					 </tr>
					 
					 <tr>
					 <td>Leave Application - V9</td>
					 <td><button type="button" class="btn btn-default"><a href="<?php echo base_url()?>forms/Form - PMA Leave Application - V9.docx" download>Download File</a></button></td>
					 </tr>
					 
					 <tr>
					 <td>Purchase Requisition</td>
					 <td><button type="button" class="btn btn-default"><a href="<?php echo base_url()?>forms/Form - PMA Purchase Requisition.xlsx" download>Download File</a></button></td>
					 </tr>
					 
					 <tr>
					 <td>Product Return</td>
					 <td><button type="button" class="btn btn-default"><a href="<?php echo base_url()?>forms/Form - Product Return.docx" download>Download File</a></button></td>
					 </tr>
					 </tbody>
					

                      


                      </table>

                   

                    <!-- END FORM--> 

                  </div>

                </div>			
			  </div>
            </div>			
				
			</div>
			
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- BEGIN CONTENT -->
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	<a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
	
	<!-- END QUICK SIDEBAR -->

<!-- END CONTAINER -->
<?php $this->load->view('footer');?>