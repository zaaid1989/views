<?php $this->load->view('header');?>

<?php
if (!isset($eng_id)) {
	$eng_id = $this->session->userdata('userid');
	$userrole = $this->session->userdata('userrole');
}

$ss = 0;
if ($userrole=="Salesman") {
		$q = $this->db->query("SELECT sap_supervisor from user WHERE id ='".$this->session->userdata('userid')."'");
		$r = $q->result_array();
		$ss = $r[0]['sap_supervisor'];
	}

?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Visits Overview <small></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Visits Overview
                            </li> 
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                        <div class="col-md-12"> 
                        
                      <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue-chambray">
                          <div class="portlet-title">
                            <div class="caption"> <i class="fa fa-bar-chart-o"></i>Visits Overview</div>
                            <div class="tools"> 
                              <a href="javascript:;" class="collapse"> </a> 
                              <a href="javascript:;" class="remove"> </a> 
                            </div>
                          </div>
              
                          <div class="portlet-body">
                          		<div class="table-toolbar">
                            	<?php
									$visits=0;
									$mas_hour_result=0;
								  ?>
                            </div>
                                <div class="portlet-body flip-scroll">
                            <?php if ($this->session->userdata('userrole') == "Admin" || $this->session->userdata('userrole') == "secratery"  || $ss==1) {?>
                                <div class="row">
                                    <form method="post" action="<?php echo base_url();?>sys/employee_asc">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                
                                                <select name="engineer" id="engineer" class="form-control" required>
                                                    <option value="">--Select Employee</option>
                                                    <?php 
                                                    $maxqu = $this->db->query("SELECT * FROM user WHERE  delete_status = '0' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
													if ($ss==1) {
														 $maxqu = $this->db->query("SELECT * FROM user WHERE  delete_status = '0'
														 AND
														 fk_office_id = '".$this->session->userdata('territory')."' AND userrole='Salesman' ");
														 if ($this->session->userdata('territory')==1) {
															 $maxqu = $this->db->query("SELECT * FROM user WHERE  delete_status = '0'
															 AND
															 fk_office_id IN ('1','5') AND userrole='Salesman' ");
														 }
													}
                                                    $maxval=$maxqu->result_array();
                                                    foreach($maxval as $val)
                                                    {
                                                        
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>" 
														<?php if(isset($eng_id) && $eng_id==$val['id']){ echo 'selected="selected"';}?>>
                                                            <?php echo $val['first_name'];?>
                                                        </option>
                                                        <?php 
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                    <input type="submit"  class="btn btn-default blue" value="Search" >
                                            </div>
                                        </div>
                                    </form>
                           		</div>  
								<?php } ?>
                                         
                                      <table class="table table-striped table-bordered flip-content sample_z" id="sample_4">
              
                                          <thead>
                          
                                            <tr>
                                              <th style="padding-right:150px;" class="bg-grey-cascade"><strong> Customer&nbsp;Name </strong></th>
                                              <th style="padding-right:100px;" class="bg-grey-cascade"><strong> Area </strong></th>
                                              <th class="bg-grey-cascade"><strong> Total Visits </strong></th>
                                              <?php $i=0;
											  while( $i<=30) { // echo 30 days row with classes
												 if($i==0) { 
												    $myndate=date('d-M-Y');
													//date to put in th class
													$myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i); // multiply with i to subtract number of days
													$week_day = date('D');
												  }
												 else {
													$myndate=date('d-M-Y', time() - 60 * 60 * 24 * $i);
													$week_day = date('D', time() - 60 * 60 * 24 * $i);
													//date to put in th class
													$myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i);
												  }
												$timeexploded=explode('-',$myndate);
												echo '<td';
												echo ' class="';
												echo $myndateclass.'Parent';
												if($week_day=="Sun") echo " redbackgrounclass blue";
												else echo " weekbackgrounclass";
												echo '" >'.$timeexploded[0].' '.$timeexploded[1].' '.$timeexploded[2];
												echo '</td>';
                                              $i++;
											   }
											   ?>
                                            </tr>
                                          </thead>
                                          <tbody>
									  <?php 
                                          $no_of_total_records=0;
                                          if (sizeof($get_eng_dvr) == "0") {} 
                                          else {
											  $visited_client_array= array();
											  $visited_clients= array();
											  $size_of_total_rows=0;
											  foreach ($get_eng_dvr as $eng_dvr) {
												if (in_array($eng_dvr['fk_customer_id'], $visited_clients)) {continue;}
													if(substr($eng_dvr['fk_customer_id'],0,1)=='o'){
																	$myclient 		= 	$eng_dvr['office_name'];
																	$myarea			=	$eng_dvr['office_name'];
																	$none			=	" style='display:none;'";
																}
																else {
																	$myarea =	$eng_dvr['area'];
																	$myclient =	$eng_dvr['client_name'];
																	$none			=	" ";
																}
                                                  
                                                  ?>
                                                 <tr class="odd gradeX" <?php echo $none;?>>
                                                        <td class="bg-grey-border"><?php echo $myclient;?></td>  
                                                        <td class="bg-grey-border"><?php echo $myarea;?></td>
                                                        <td class="bg-grey-border">
                                                             <span class="total_visits_in_row<?php echo $size_of_total_rows;?>"></span>
															 <!-- Defining a span class within a td and definining js functions for each span-->
                                                             <script>
															 $(document).ready( function() {
																 var size=$('#row_visits<?php echo $size_of_total_rows;?>').val();
																 $('.total_visits_in_row<?php echo $size_of_total_rows;?>').html(size);
																 if(size==0){
																	 $('.total_visits_in_row<?php echo $size_of_total_rows;?>').closest('tr').hide();
																 }
															 });
															 </script>
                                                        </td>
                                                        <?php 
														$i=0;
														$row_visits=0;
														while( $i<=30 ) { //looping through each day td element
															if($i==0) $myndate=date('Y-m-d'); 
															else $myndate=date('Y-m-d', time() - 60 * 60 * 24 * $i); // date for each td
															$zaaid=0;
															foreach ($get_eng_dvr as $eng_dvrr) {
																if( $myndate==date('Y-m-d',strtotime($eng_dvrr['date'])) AND $eng_dvr['fk_customer_id'] == $eng_dvrr['fk_customer_id']) $zaaid=$zaaid+1; // if on td date there is an entry for customer at beginning of row add 1 to variable zaaid
																else	$zaaid=$zaaid+0;
															}
															
															if( $zaaid>0)
															{ 
																echo '<td class="blackbackgroundclass"><strong>B</strong></td>';
																$row_visits++;
																$visits++;
															array_push($visited_client_array, $eng_dvr['fk_customer_id']);
															array_push($visited_clients, $eng_dvr['fk_customer_id']);
															}
															else
															{
																 echo '<td class="zclass ';
																 echo $myndate;
																 if($week_day=="Sun") echo " sundayclass ";
																 echo'"><strong>A</strong></td>';
															}
														$i++;
                                                        }?>  
                                                 	<input type="hidden" name="row_visits" id="row_visits<?php echo $size_of_total_rows;?>" 
                                                    value="<?php echo $row_visits;?>" />
                                                 </tr>
												<?php
													$no_of_total_records++;
													$size_of_total_rows++; 
													}
                                                  
                                                  }?>
                                          </tbody>
                                     </table>
                                  <input type="hidden" name="no_of_total_records" value="<?php echo $no_of_total_records;?>" id="no_of_total_records" />
                                 
									  <?php $i=0;
											  while( $i<=30) { 
												 if($i==0) $myndateclass=date('Y-m-d');
												 else $myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i);
												  ?>
												  <script>
								  				  $(document).ready( function(){
												  var class_ocurances = $(".<?php echo $myndateclass?>").length;
												  var no_of_total_records = $("#no_of_total_records").val();
												  if(class_ocurances==no_of_total_records){
													  $(".<?php echo $myndateclass.'Parent'?>").addClass('greenbackgrounclass');
												  }
												  });
												  </script>
                                                  <?php
                                              $i++;
											   }
											   ?>
                             </div>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET--> 
                      
     		<?php if(isset($eng_id) && $userrole=="Salesman") {?>
            <div class="portlet light bg-inverse">
                        <div class="portlet-title">
            
                          <div class="caption font-red-intense"> <i class="fa fa-minus-square font-red-intense"></i>List of Customers not Visited in Last 30 Days</div>
            
                          <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
            
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                            </div>
                                <div class="portlet-body flip-scroll">
                                  <table class="table  table-bordered table-hover flip-content" id="sample_3">
                                      <thead class="bg-blue-chambray">
                                        <tr>
                                          <th> Customer&nbsp;Name </th>
                                          <th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Area &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                        </tr>
                                      </thead>
                                       <tbody>
                                      <?php 
                                           $count_of_customers_not_visited_in_last_30_days=0;
                                         // $myquery="SELECT * FROM tbl_clients where pk_client_id !=  '0' ";
                                          $myquery="SELECT 
                                          tbl_customer_sap_bridge.fk_client_id, tbl_customer_sap_bridge.fk_user_id, 
                                          tbl_clients.client_name, tbl_clients.fk_city_id, tbl_clients.fk_area_id
                                           FROM 
                                           tbl_customer_sap_bridge 
                                           INNER JOIN
                                           tbl_clients
                                           ON
                                           tbl_clients.pk_client_id 	=	tbl_customer_sap_bridge.fk_client_id
                                           where
                                           tbl_clients.pk_client_id !=  '0' 
                                           AND  tbl_customer_sap_bridge.fk_user_id =  '".$eng_id."'";
                                          // for all values of array
                                          
                                          //echo '<pre>';print_r($visited_client_array);echo '</pre>';exit;
                                          if(!empty($visited_client_array))
                                          {
                                          foreach($visited_client_array as $visited)
                                              {
                                                  $myquery.=" AND tbl_clients.pk_client_id !=  '".$visited."'";
                                              }
                                          }
                                          //echo $myquery;exit;
                                          $maxqu6 = $this->db->query($myquery); 
                                          if($maxqu6->num_rows()>0)
                                          {
                                          $maxval6=$maxqu6->result_array();
                                          foreach ($maxval6 as $not_visited) 
                                          {
                                              $nq="select * from
                                                   tbl_dvr
                                                   WHERE
                                                   fk_engineer_id 	=	'".$not_visited['fk_user_id']."'
                                                   AND
                                                   fk_customer_id= '".$not_visited['fk_client_id']."'
                                                   AND
                                                   date
                                                   BETWEEN '".date('Y-m-d', time() - 60 * 60 * 24 * 30)."' 	AND  	'".date('Y-m-d')."'";
                                                   //echo $nq;exit;
                                           $nq6 = $this->db->query($nq);
                                           if ($nq6->num_rows() == 0){
                                              ?>
                                             <tr class="odd gradeX">
                                                    <td>
                                                         <?php echo $not_visited['client_name'];?>
                                                    </td>  
                                                    <td>
                                                         <?php $maxqu = $this->db->query("SELECT * FROM tbl_area where pk_area_id='".$not_visited['fk_area_id']."' "); 
                                                         $maxval=$maxqu->result_array();echo $maxval[0]['area'];?>
                                                    </td>
                                                    
                                             </tr>
                                        <?php 
                                              $count_of_customers_not_visited_in_last_30_days++;
                                              }
                                          }
                                        }
                                        ?>
                                      </tbody>
                                 </table>
                       </div>
                      </div>
                      <input type="hidden" name="count_of_customers_not_visited_in_last_30_days" value="<?php echo $count_of_customers_not_visited_in_last_30_days;?>" 
                      id="count_of_customers_not_visited_in_last_30_days" />
                      <!-- END EXAMPLE TABLE PORTLET--> 
                    </div>
            <?php }?>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<style>
        .weekbackgrounclass
        {
            background-color:#2c3e50 !important;
			color: #FFF;
        }
        .redbackgrounclass
        {
            background-color:#cb5a5e !important;
			color: #FFF;
        }
        .redbackgrounclass.greenbackgrounclass
        {
            background-color:#cb5a5e !important;
        }
        .greenbackgrounclass
        {
            background-color:#1BBC9B !important;
			color: #FFF;
        }
		.blackbackgroundclass
		{
			background:#3598dc !important; 
			color:#3598dc; 
			text-align:center;
		}
		.zclass
		{
			background:#fafafa !important; 
			color:#fff; 
			text-align:center;
		}
		.bg-grey-border
		{
			background:#eeeeee !important; 
			border-bottom:1px solid #dddddd !important;
			border-right:1px solid #dddddd !important;
		}
		.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
		  background-color: #f5f5f5;
		  color: #333;
		}
		
        </style>
        <script>
		  $(document).ready( function() {
			   var holi = $(".greenbackgrounclass").length;
			  //var holidays = 31-holi;
			  //var holidays =<?php //echo $work_days;?>;
			   //alert(holidays);
			   // for all hours
			   
			   //
			   var visits_hidden									=	$('#visits_hidden').val();
			   
			   //$('.visits_show').html(visits_hidden_3);
			   //
			   var count_of_customers_not_visited_in_last_30_days = $('#count_of_customers_not_visited_in_last_30_days').val();
			   $('.count_of_customers_not_visited_in_last_30_days_span').html(count_of_customers_not_visited_in_last_30_days);
			   //total_assigned_customer);
			   
			   //
			   var total_assigned_customer 						= $('.total_assigned_customer_sapn').html();
			   var customer_visited_in_last_30_days 				= total_assigned_customer - count_of_customers_not_visited_in_last_30_days;
			   $('.customer_visited_in_last_30_days_span').html(customer_visited_in_last_30_days);
			   
			   
		   });
		 </script>
<?php $this->load->view('footer');?>