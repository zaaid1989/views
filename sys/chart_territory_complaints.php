<?php $this->load->view('header');
	
$territory = 0;
if ($this->session->userdata('userrole') != 'Admin' && $this->session->userdata('userrole') != 'secratery') {
	$territory = $this->session->userdata('territory');
}
else {
	if (isset($_GET['territory'])) $territory = $_GET['territory'];
}
$data['territory'] = $territory;
?>
										
<script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>	

  
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Complaint Monthly Overview 
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Complaints Monthly Overview
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
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
                            	<form method="get" action="<?php echo base_url();?>sys/chart_territory_complaints">
                                <div class="col-md-4">
                            		<div class="form-group">
                                        <select name="territory" id="territory" class="form-control" required>
                                            <option value="">--Select Territory--</option>
											<?php 
											$maxqu = $this->db->query("SELECT * FROM tbl_offices ORDER BY `pk_office_id` ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val) {
                                             ?>
                                                <option value="<?php echo $val['pk_office_id'];?>" <?php if(isset($_GET['territory']) && $_GET['territory']==$val['pk_office_id']){ echo 'selected="selected"';}?>>
													<?php echo $val['office_name'];?>
                                                </option>
                                       <?php } ?>
                                        </select>
                            		</div>
                          		</div>
								
                                <div class="col-md-2">
                            		<div class="form-group">
                                            <input type="submit"  class="btn btn-default purple-seance" value="Search" >
                                    </div>
                                </div>
                          		</form>
								
								<div class="col-md-6">
                            		<p><b>Description of Graph</b><br/>
									- Separate Bars of each month total complaints.<br/>
									- Number on the Top of each Bar is Total Complaints in selected Territory.<br/>
									- Different Colors in each Bar represent individual Product.<br/>
									- Move the cursor on the bar to see further details such as total complaints of that product, pending complaints and units installed in selected Territory.
									</p>
                                </div>
                           </div>	
							
						</div>
					</div>
		<!-- Search Form -->
<?php } ?>



					<div class="portlet solid bordered light bg-inverse " >
						<!-- Portlet Title -->
						<div class="portlet-title">
							<div class="caption font-purple-seance">
								<i class="icon-bar-chart font-purple-seance"></i>
								<span class="caption-subject bold uppercase"> Complaints Monthly Overview</span>
							</div>
							
							<div class="tools">
								<a href="" class="collapse" data-original-title="" title=""></a>
								<a href="" class="fullscreen"></a>
								<a href="" class="remove" data-original-title="" title=""></a>
							</div>
						</div>
						<!-- End Portlet Title -->
						<!-- Begin Portlet Body -->
						<div class="portlet-body" style="margin-left:3%; margin-right:3%; ">
								<div id="chart_territory_complaints_view" style="width: 100%; height: auto; margin-left:20px; "></div> 	 
						</div>
						<!-- End Portlet Body -->
					</div>
   
<!-- END EXAMPLE TABLE PORTLET--> 

      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<?php $this->load->view('sys/chart_territory_complaints_view',$data);?>
<?php $this->load->view('footer');?>
<style>
textarea {
  width: 100%;
}
.highcharts-container { overflow: visible !important; } 
.highcharts-root { overflow: visible !important; } 
svg { overflow: visible; }

</style>