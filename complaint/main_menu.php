<?php $this->load->view('header.php');
function zerodisp($val) {
	if ($val==0) return '-';
	else return 'Yes';
}
?>
<script>
$(window).load(function() {   
  $('#loader').hide();
  $('#sample_z').show('slow');
});
</script>

<style>
#sample_zz { display:none }
</style>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title"> Main Menu <small></small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            Home 
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            Main Menu
                        </li> 
                      </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
					<?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success') { 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Main Menu Added Successfully.  
								</div>';
						}
					?>
					
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bg-inverse">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-anchor"></i>Main Menu Management </div>
                            <div class="tools"> 
                                <a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
						  
						  <div class="row">
							<div class="col-md-6">
							  <div class="btn-group">
								<a href="<?php echo base_url();?>complaint/add_main_menu" class="btn yellow-crusta"> 
									Add Main Menu <i class="fa fa-plus"></i> 
								</a>
							  </div>
							</div>
						  </div>
                      <br/>
					  <div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
					  <table class="table table-hover hover flip-content  dataaTable" id="">
                      <thead class="bg-green-jungle">
                        <tr>
						  <th> Main Menu   		</th>
                          <th> Icon   			</th>
						  <th> Order    		</th>
						  <th> Actions	   		</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
						$query = $this->db->query("SELECT * 
						FROM tbl_main_menu
						ORDER BY tbl_main_menu.order");
						$result = $query->result_array();
						foreach ($result AS $mainmenu) {
							echo '<tr>';
							echo '<td>'.$mainmenu['main_menu'].'</td>';
							echo '<td><i class="'.$mainmenu['icon'].'"></i></td>';
							echo '<td>'.$mainmenu['order'].'</td>';
							echo '<td>';
							echo '<a class="btn btn-sm default yellow-crusta"  
											href="'.base_url().'complaint/edit_main_menu/'.$mainmenu["pk_main_menu_id"].'">
											  Update <i class="fa fa-edit"></i>
											</a>';
							echo '</td>';
							echo '</tr>';
						}
                        ?>
                      </tbody>
                    </table>
                  
                                 
                          </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET--> 
                      </div>
                    </div>
      				<!-- END PAGE CONTENT-->
                    
                    
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer.php');?>
		<script>
		$(document).ready(function() { 
			var table = $('.dataaTable').dataTable({
			  'iDisplayLength': 200,
			  'bSort': false,
			  'aaSorting': []
			});
			
			//new $.fn.dataTable.FixedColumns( table );
		});
		</script>