<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">Pending Registration
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        View Complaints 
                    </li>
                    
                </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        
						<?php
$data['table'] = 'pending_registration';
$data['data_access_role'] = 'Admin'; //FSE, Supervisor, Admin
//if ($this->session->userdata('userrole')=='Supervisor') $data['data_access_role'] = 'Supervisor';
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
		$('#reloadd').click(function() {
    location.reload();
});
		</script>