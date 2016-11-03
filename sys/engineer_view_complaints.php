<?php $this->load->view('header');?>
<?php 


//
function time_elapsed_string3($start_dat, $end_date, $full) {
	$from_timezone = 'America/New_York';
	$tz1 = new DateTimezone($from_timezone);
	$now = new DateTime($end_date, $tz1);
	$ago = new DateTime($start_dat, $tz1);
	$diff = $now->diff($ago);
	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . '' : '';
}
?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Complaints List <small></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        Home 
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        Complaints List                        
                    </li> 
                    
                </ul>
                    </div>
					
				<?php
						  if(isset($_GET['msg']))
							{ 
							  echo '<div class="alert alert-success alert-dismissable">  
									  <a class="close" data-dismiss="alert">×</a>  
									  Complaint Added Successfully.  
									</div>';
							}
							
							if(isset($_GET['msg_update']))
							{ 
							  echo '<div class="alert alert-success alert-dismissable">  
									  <a class="close" data-dismiss="alert">×</a>  
									  Complaint Updated Successfully.  
									</div>';
							}
							
							if(isset($_GET['msg_delete']))
							  { 
								echo '<div class="alert alert-success alert-dismissable">  
										<a class="close" data-dismiss="alert">×</a>  
										Complaint Deleted Successfully.  
									  </div>';
							  }
						?>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                      <div class="col-md-12"> 
					  
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->

<?php 
$data['table'] = 'all_open';
$data['data_access_role'] = 'FSE'; //FSE, Supervisor, Admin
//if ($this->session->userdata('userrole')=='Supervisor') $data['data_access_role'] = 'Supervisor';
$this->load->view('sys/complaints_table_view',$data);
?>
                        
                        
                        
						<?php //} ?>
					  </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?php $this->load->view('footer');?>
		
		

