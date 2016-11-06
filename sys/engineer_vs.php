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
                    Engineer <small>VS</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Engineer VS
                            </li>
                        </ul>
                      <div class="page-toolbar">
                        
                      </div>
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">

        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		<form method="post" action="<?php echo base_url();?>sys/insert_vs_engineer">
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
                                <div class="portlet-body ">
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
														 FIND_IN_SET_X('".$this->session->userdata('territory')."',fk_office_id) AND userrole='Salesman' ");
														 if ($this->session->userdata('territory')==1) {
															/* $maxqu = $this->db->query("SELECT * FROM user WHERE  delete_status = '0'
															 AND
															 fk_office_id IN ('1','5') AND userrole='Salesman' "); */
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
                                         
                                      <table class="table table-striped table-bordered  sample_z" id="sample_4">
              
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
          <!--Enter data of visit schedual here-->
          <div class="portlet box blue">

            <div class="portlet-title">
                  <div class="caption"> <i class="fa fa-globe"></i>Visit Schedule of Next Day</div>
                  <div class="tools"> <a href="javascript:;" class="collapse"> </a> 
                   <a href="javascript:;" class="remove"> </a> 
                  </div>
            </div>

            <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-scrollable">
                    <table class="table table-bordered table-hover">
      
                      <thead class="bg-grey-gallery">
      
                        <tr>
                        
                          <th colspan="2"  style="padding-right:100px;"> Time </th>
                          
                          <th  style="padding-right:100px;">  Customer</th>
      
                          <th style="padding-right:100px;"> City</th>
                          
                          <th style="padding-right:100px;">  Project </th>
                          <th>  Project Description</th>
                          <th> Purpose of visit </th>
                          
                          <th> </th>
      
                       
      
                        </tr>
      
                      </thead>
                      
      
                      <tbody class="append_tbody">
      
                        <tr class="odd gradeX visitschedule">
      
                          <td> <input  name="starttime[0]" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds"  required>
                      
                          </td>
                          
                          <td> <input   name="endtime[0]" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"   required>						
                          </td>
                         
                          <td> <select class="form-control" name="customer[0]" id="customer0"  onchange="show_cities(this.value,0)" required>
      
                                    <option value="">--Choose--</option>
                                    <option value="officeoption_1">Rawalpindi Office (HO)</option>
                                    <option value="officeoption_2">Lahore Office (LO)</option>
                                    <option value="officeoption_3">Karachi Office (KO)</option>
                                    <option value="officeoption_4">Multan Office (MO)</option>
                                    <option value="officeoption_5">Peshawar (PO)</option>
                                     <?php $quw="SELECT * from user where id =  '".$this->session->userdata('userid')."'";
                                  $ghw=$this->db->query($quw);
                                  $rtw=$ghw->result_array();
                                  // get all client of this this office id
                                  $qu="SELECT * from tbl_clients where fk_office_id IN(".$rtw[0]['fk_office_id'].") AND delete_status='0'";
                                  $gh=$this->db->query($qu);
                                  $rt=$gh->result_array();
                                  foreach($rt as $value)
                                    {
                                        ?>
                                        <option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?></option>
                                        <?php
                                    }?>
      
                                  </select>
                          </td>
                          <td class="citiestd0"> 
                              <select class="form-control" name="city[0]">
                                  <option value="">--Choose--</option>
                              </select>
                          </td>
                  
                          <td class="businessestd0">
                          		<select class="form-control"  name="business[0]" required>
                                    <option value="2">--Choose--</option>
                                  </select>
                          </td>
                          <td> <textarea class="input-small periority0" name="periority[0]" readonly required rows="4"></textarea></td>
                          <td> <textarea class="input-small summery0" name="summery[0]"  required rows="4"></textarea></td>
                          <td style="text-align:center;"> 
                                  <a href="javascript:;" class="btn btn-icon-only red"><i class="fa fa-minus"></i></a> 
                                  
                           </td>
                        </tr>
                      </tbody>
                    </table>
					
					<div class="row ">
					<div class="form-actions">
                      <div>
					  <table class="table" style="border-top: 0px !important;">
						<tr>
							<td class="pull-right" style="border-top: 0px !important; margin-top:-5px;">
								<button type="button" class="btn green btn-xs" onclick="add_row()">Add Row +</button>
							</td>
						</tr>
						<tr>
							<td class="pull-right">
								<button type="submit" class="btn blue" onclick="return check_range()">Save to Database</button>
							</td>
						</tr>
						</table>
                      </div>
                    </div>
                  </div>
                    
           <script type="text/javascript">
          function check_range()
				{
					$('.visitschedule').each(function(){
							var timepicker1 = $(this).find(".timepicker1").val();
							timepicker1_array=timepicker1.split(' ');
							var timepicker1_ampm =timepicker1_array[1]
							
							timepicker1_array_hrmn=timepicker1_array[0].split(':');
							var timepicker1_hr =timepicker1_array_hrmn[0];
							var timepicker1_mn = timepicker1_array_hrmn[1];
							if(timepicker1_ampm=='AM' && timepicker1_hr==12 ) { timepicker1_hr-=12; }
					
								if(timepicker1_ampm=='PM' && timepicker1_hr<12)
								{
									timepicker1_hr=12+(+timepicker1_hr);
									timepicker1_hr_con= timepicker1_hr*60;
									timepicker1_newvalue=(+timepicker1_hr_con)+(+timepicker1_mn);
								}
								else
								{
									timepicker1_hr_con= timepicker1_hr*60;
									timepicker1_newvalue=(+timepicker1_hr_con)+(+timepicker1_mn);
								}
							// timepicker 2 calculations
							var timepicker2 = $(this).find(".timepicker2").val();
							timepicker2_array=timepicker2.split(' ');
							var timepicker2_ampm =timepicker2_array[1]
							
							timepicker2_array_hrmn=timepicker2_array[0].split(':');
							var timepicker2_hr =timepicker2_array_hrmn[0];
							var timepicker2_mn = timepicker2_array_hrmn[1];
							if(timepicker2_ampm=='AM' && timepicker2_hr==12 ) { timepicker2_hr-=12; }
							
							if(timepicker2_ampm=='PM' && timepicker2_hr<12)
								{
									timepicker2_hr=12+(+timepicker2_hr);
									timepicker2_hr_con= timepicker2_hr*60;
									timepicker2_newvalue=(+timepicker2_hr_con)+(+timepicker2_mn);
								}
								else
								{
									timepicker2_hr_con= timepicker2_hr*60;
									timepicker2_newvalue=(+timepicker2_hr_con)+(+timepicker2_mn);
								}
							if(timepicker2_newvalue<timepicker1_newvalue)
							{
								alert("End time must be greater than start time ");
								return false;
							}
						});
				}
			function show_cities(client_id,rowid)
          {
              var formdata =
                {
                  client_id: client_id,
                  rowid: rowid
                };
            $.ajax({
              url: "<?php echo base_url();?>sys/client_select_ajax",
              type: 'POST',
              data: formdata,
              success: function(msg){
                  $(".citiestd"+rowid).html(msg);
                  //alert(msg);
                  }
              })
              $.ajax({
              url: "<?php echo base_url();?>sys/business_select_ajax",
              type: 'POST',
              data: formdata,
              success: function(msg){
                  $(".businessestd"+rowid).html(msg);
                  //alert(msg);
                  }
              })
              return false;
          }
          function fill_business_dec_and_timeelapsed(business_id,rowid)
          {
               
          if(business_id=='others' || business_id=='')
            {
                //$(".summery"+rowid).prop("readonly",false);
                $(".periority"+rowid).prop("readonly",false);
                $(".summery"+rowid).val('');
                $(".periority"+rowid).val('');
            }
            else
            {
              $(".periority"+rowid).prop("readonly",true);
               // $(".summery"+rowid).prop("readonly",true);
                //alert(business_id);
              var customer_id=$("#customer"+rowid).val();
			  //alert(customer_id);
              var formdata =
                {
                  business_id: business_id,
                  customer_id:customer_id,
                  rowid: rowid
                };
            $.ajax({
              url: "<?php echo base_url();?>sys/business_dec_ajax",
              type: 'POST',
              data: formdata,
              success: function(msg){
                  $(".periority"+rowid).val(msg);
                  //alert(msg);
                  }
              })
              $.ajax({
              url: "<?php echo base_url();?>sys/business_time_elapsed_ajax",
              type: 'POST',
              data: formdata,
              success: function(msg){
                  $(".time_elaped"+rowid).val(msg);
                  //alert(msg);
                  }
              })
              return false;
            }
          }
          
          function add_row()
            {
              var count1=Math.floor(Math.random()*101);
              $('.append_tbody').append('<tr class="odd gradeX visitschedule"><td> <input  name="starttime['+count1+']" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds"   required></td><td> <input   name="endtime['+count1+']" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"   required></td><td><select class="form-control  " name="customer['+count1+']"  id="customer'+count1+'"  onchange="show_cities(this.value,'+count1+')" required><option value="">--Choose--</option><option value="officeoption_1">Rawalpindi Office (HO)</option><option value="officeoption_2">Lahore Office (LO)</option><option value="officeoption_3">Karachi Office (KO)</option><option value="officeoption_4">Multan Office (MO)</option><option value="officeoption_5">Peshawar (PO)</option><?php $quw="SELECT * from user where id =  '".$this->session->userdata('userid')."'";$ghw=$this->db->query($quw);$rtw=$ghw->result_array();$qu="SELECT * from tbl_clients where fk_office_id IN(".$rtw[0]['fk_office_id'].") AND delete_status='0'";$gh=$this->db->query($qu);$rt=$gh->result_array();foreach($rt as $value){?><option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?></option><?php }?></select></td><td class="citiestd'+count1+'"> <select class="form-control  " name="city['+count1+']" required><option value="">--Choose--</option></td><td class="businessestd'+count1+'"><select class="form-control  "  name="business['+count1+']"><option value="">--Choose--</option><option value="MD">MDx Business</option><option value="ID">IDx Business</option></select></td><td> <textarea class="input-small periority'+count1+'" name="periority['+count1+']" readonly required rows="4"></textarea></td><td> <textarea class="input-small summery'+count1+'" name="summery['+count1+']"  required rows="4"></textarea></td><td style="text-align:center;"><a href="javascript:;" class="btn btn-icon-only red"><i class="fa fa-minus"></i></a></td></tr>');
              $('select').select2();
              $( ".fa-minus" ).click(function(event) {
                    $(this).closest('tr').remove();
                });
              
              $('.timepicker1').timepicker({
                  minuteStep: 5,
                  showInputs: false,
                  disableFocus: true,
                  defaultTime:false
              });
              
              $('.timepicker2').timepicker({
                  minuteStep: 5,
                  showInputs: false,
                  disableFocus: true,
                  defaultTime:false
              });
             }
                </script>
                    <script type="text/javascript">
                  $('.timepicker1').timepicker({
                      minuteStep: 5,
                      showInputs: false,
                      disableFocus: true,
                      defaultTime:false
                  });
                  /*$('.timepicker1').timepicker().on('hide.timepicker', function(e) {
                      if(e.time.hour<9 && e.time.meridian=='AM')
                      {
                          alert('time should not be less than 9:AM')
                      }
                      if(e.time.hour>11 && e.time.meridian=='AM')
                      {
                          alert('time should not be Big than 11:59 PM')
                      }
                    });*/
                  $('.timepicker2').timepicker({
                      minuteStep: 5,
                      showInputs: false,
                      disableFocus: true,
                      defaultTime:false
                  });
                </script>
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </form>
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
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
<?php $this->load->view('footer');?>