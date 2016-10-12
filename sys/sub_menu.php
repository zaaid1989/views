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
                    <h3 class="page-title"> Submenu <small></small> </h3>
                    <div class="page-bar">
                      <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            Home 
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            Submenu
                        </li> 
                      </ul>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
					<?php
					  if(isset($_GET['msg']) && $_GET['msg']=='success') { 
						  echo '<div class="alert alert-success alert-dismissable">  
								  <a class="close" data-dismiss="alert">×</a>  
								  Submenu Added Successfully.  
								</div>';
						}
					?>
					
                    <div class="row">
                      <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bg-inverse">
                          <div class="portlet-title">
                            <div class="caption"> <i class="icon-anchor"></i>Submenu Management </div>
                            <div class="tools"> 
                                <a href="javascript:;" class="collapse"> </a> 
                                <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
                          <div class="portlet-body">
						  
						  <div class="row">
							<div class="col-md-6">
							  <div class="btn-group">
								<a href="<?php echo base_url();?>sys/add_sub_menu" class="btn yellow-crusta"> 
									Add Submenu <i class="fa fa-plus"></i> 
								</a>
							  </div>
							</div>
						  </div>
                      <br/>
					  <div id="loader" ><h3>Loading Data. Please Wait....</h3></div>
					  <table class="table table-hover hover flip-content  dataaTable" id="">
                      <thead class="bg-blue">
                        <tr>
						  <th> Main Menu   		</th>
                          <th> Sub Menu   		</th>
                          <th> Pre				</th>
                          <th> Post   			</th>
                          <th> Icon   			</th>
						  <th> Order    		</th>
						  <th> Admin    		</th>
						  <th> Stcoadmin   		</th>
						  <th> Supervisor  		</th>
						  <th> FSE		   		</th>
						  <th> SAP		   		</th>
						  <th> Actions	   		</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
						$query = $this->db->query("SELECT tbl_sub_menu.*,tbl_main_menu.main_menu 
						FROM tbl_sub_menu
						LEFT JOIN tbl_main_menu ON tbl_main_menu.pk_main_menu_id=tbl_sub_menu.fk_main_menu_id
						ORDER BY tbl_main_menu.order, tbl_sub_menu.order");
						$result = $query->result_array();
						foreach ($result AS $submenu) {
							echo '<tr>';
							echo '<td>'.$submenu['main_menu'].'</td>';
							echo '<td>'.$submenu['sub_menu'].'</td>';
							echo '<td>'.$submenu['pre'].'</td>';
							echo '<td>'.$submenu['post'].'</td>';
							echo '<td><i class="'.$submenu['icon'].'"></i></td>';
							echo '<td>'.$submenu['order'].'</td>';
							echo '<td>'.zerodisp($submenu['Admin']).'</td>';
							echo '<td>'.zerodisp($submenu['secratery']).'</td>';
							echo '<td>'.zerodisp($submenu['Supervisor']).'</td>';
							echo '<td>'.zerodisp($submenu['FSE']).'</td>';
							echo '<td>'.zerodisp($submenu['Salesman']).'</td>';
							echo '<td>';
							echo '<a class="btn btn-sm default yellow-crusta"  
											href="'.base_url().'sys/edit_sub_menu/'.$submenu["pk_sub_menu_id"].'">
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
			
		//	new $.fn.dataTable.FixedColumns( table );
		});
		</script>