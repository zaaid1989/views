<?php $this->load->view('header');

?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Director <small>View PM</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home 
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        View PM (Director)                        
                    </li>
                    
                </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
					 
<?php 
$data['table'] = 'pm_not_completed';
$data['cn'] = 'PM';
$data['data_access_role'] = 'Admin'; //FSE, Supervisor, Admin
if ($this->session->userdata('userrole')=='Supervisor') $data['data_access_role'] = 'Supervisor';
if ($this->session->userdata('userrole')=='FSE') $data['data_access_role'] = 'FSE';
$this->load->view('sys/complaints_table_view',$data);
?>
					  </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer');?>
		
<script> 
		 $(document).ready(function() { 
			var table = $('#sample_220').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
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
								{ type: "text" }
								
						]

		});
		var table2 = $('#sample_221').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
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
								{ type: "text" }
								
						]

		});
		var table3 = $('#sample_222').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
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
								{ type: "text" }
								
						]

		});
		var table4 = $('#sample_225').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 1, "desc" ]]
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
								{ type: "text" }
								
						]

		});
});

</script>