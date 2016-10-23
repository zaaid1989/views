<?php $this->load->view('header');
	
$territory = 0;
$sap = 0;

if ($this->session->userdata('userrole') != 'Admin' && $this->session->userdata('userrole') != 'secratery') {
	$territory = $this->session->userdata('territory');
	$sap = $this->session->userdata('userid');
}
else {
	if (isset($_GET['territory'])) $territory = $_GET['territory'];
	if (isset($_GET['sap'])) $sap = $_GET['sap'];
}

if ($sap != 0) $territory = 0;

$data['territory'] = $territory;
$data['sap'] = $sap;
?>
										
<script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>										
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    SAP Statistics <small></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                SAP Statistics
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
       <!-- BEGIN PAGE CONTENT-->
	   <!-- Graph Description -->
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bg-inverse" >
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-paper-plane font-purple-seance"></i>
								<span class="caption-subject bold font-purple-seance uppercase">
								Graph Description </span>
							</div>
						</div>
						<div class="portlet-body">
						        <div class="row">
									<div class="col-md-12">
									<p>
		- All the assigned customers to the SAP are divided into five categories depending on the Last visit Date.
<br/>- <span style="color:#00CD66;font-weight: 900;">Green</span> = Active = Last visit ≤ 21 days 
<br/>- <span style="color:#0099CC;font-weight: 900;">Blue</span> = Never Visited but 1 or more projects
<br/>- <span style="color:#FFD700;font-weight: 900;">Yellow</span> = InActive = Last visit ≥ 22 and ≤ 48 days 
<br/>- <span style="color:#DC143C;font-weight: 900;">Red</span> = Ignored = Last visit > 49 days 
<br/>- <span style="color:#000000;font-weight: 900;">Black</span> = Never Visited but 0 projects 
<br/>- Move the cursor on the bar to see further details of Customer Name – (Number of Projects assigned to the customers).
<br/>- Never Visited definition is 0 visit or last visit >120 days
									</p>
									</div>
								</div>	
						</div>
				</div>
			</div>
		</div>
	   <!-- END Graph Description -->
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
                            	<form method="get" action="<?php echo base_url();?>sys/chart_sap_territory_visit_review_projects_customers">
                                <div class="col-md-4">
                            		<div class="form-group">
                            			<select name="territory" id="territory" onchange="territory_changed()" class="form-control" >
                                            <option value="">--Select Territory--</option>
											<?php 
											$maxqu = $this->db->query("SELECT * FROM tbl_offices ORDER BY `pk_office_id` ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val){
                                                ?>
                                                <option value="<?php echo $val['pk_office_id'];?>" <?php if($territory==$val['pk_office_id']){ echo 'selected="selected"';}?>>
													<?php echo $val['office_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
											<option value="0"<?php if($territory==0){ echo 'selected="selected"';}?>>ALL</option>
                                        </select>
                            		</div>
                          		</div>
								<div class="col-md-4">
                            		<div class="form-group">
                            			<select name="sap" id="sap" onchange="sap_changed()" class="form-control" >
                                            <option value="">--Select SAP--</option>
											<option value="0"<?php if(isset($_GET['sap']) && $_GET['sap']==0){ echo 'selected="selected"';}?>>ALL</option>
											<?php 
											$maxqu = $this->db->query("SELECT * FROM user WHERE delete_status='0' AND userrole='Salesman' ORDER BY `fk_office_id` ");
											$maxval=$maxqu->result_array();
                                            foreach($maxval as $val){
                                                ?>
                                                <option value="<?php echo $val['id'];?>" <?php if(isset($_GET['sap']) && $_GET['sap']==$val['id']){ echo 'selected="selected"';}?>>
													<?php echo $val['first_name'];?>
                                                </option>
                                                <?php 
                                            }
                                            ?>
											
                                        </select>
                            		</div>
                          		</div>
								
                                <div class="col-md-2">
                            		<div class="form-group">
                                            <input type="submit"  class="btn btn-default purple-seance" value="Search" >
                                    </div>
                                </div>
                          		</form>
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
								<span class="caption-subject bold uppercase"> SAP Territory Visit Review</span>
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
							<div id="chart_sap_territory_visit_review_projects_customers_view" style="width: 100%; height: 500px; margin-left:20px; "></div>
						</div>
						<!-- End Portlet Body -->
					</div>

      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<?php $this->load->view('sys/chart_sap_territory_visit_review_projects_customers_view',$data);?>

<?php $this->load->view('footer');?>

<script>
function territory_changed() {
	$("#sap").select2().select2('val','0');
}
function sap_changed() {
	
	$("#territory").select2().select2('val','0');
}
</script>

<style>
textarea {
  width: 100%;
}
.highcharts-container { overflow: visible !important; } 
.highcharts-root { overflow: visible !important; } 
svg { overflow: visible; }

</style>