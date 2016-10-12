<?php $this->load->view('header');?>
<?php
if (isset($_GET['p'])) {
	$project_id = $_GET['p'];
	
	$q = $this->db->query("SELECT business_data.*, tbl_clients.client_name, tbl_cities.city_name, tbl_business_types.businesstype_name
							from business_data
							LEFT JOIN tbl_clients ON business_data.Customer = tbl_clients.pk_client_id
							LEFT JOIN tbl_cities ON business_data.City = tbl_cities.pk_city_id
							LEFT JOIN tbl_business_types ON business_data.`Business Project` = tbl_business_types.pk_businesstype_id
							WHERE business_data.pk_businessproject_id = $project_id");
	$r = $q->result_array();
	
	$customer_name = $r[0]['client_name'];
	$customer_id = $r[0]['Customer'];
	$city = $r[0]['city_name'];
	$city_id = $r[0]['City'];
	$project_type = $r[0]['businesstype_name'];
	$project_type_id = $r[0]['Business Project'];
	$project_description = urldecode($r[0]['Project Description']);
}
else show_404();
?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Sap <small>VS</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                VS
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
		 <?php
                          if(isset($_GET['msg']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      VS Added Successfully.  
                                    </div>';
                            }
                         ?>

        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET--> 
<?php if (!isset($project_id)) { ?>
		  
          <div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>View VS </div>
              <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
            </div>

            <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-scrollable">
                       
                          <input type="hidden" name="engineer" value="<?php echo $this->session->userdata('userid');?>" />
                          <table class="table table-striped table-bordered table-hover">
                              <thead>
                                <tr>
                                  <th> Customer&nbsp;Name </th>
                                  <th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Area&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                  <?php $i=0; 
                  while( $i<=30)
                                  { 
                                     
                                      if($i==0)
                                      { 
										$myndate=date('d-M-Y', time() + 60 * 60 * 24 * 2);
										$myndateclass=date('Y-m-d',time() + 60 * 60 * 24 * 2);
                                        $week_day = date('D');
                                      }
									  elseif($i==1)
                                      { 
                                        //$myndate=date('d-M-Y'); zaaidddddddddddddddddddddd
										$myndate=date('d-M-Y',strtotime('tomorrow'));
                                        //date to put in th class
                                       // $myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i); zaaidddddddddddddddd
										$myndateclass=date('Y-m-d',strtotime('tomorrow'));
                                        $week_day = date('D');
                                      }
                                     else 
                                      {/********************** zaaid
                                        $myndate=date('d-M-Y', time() - 60 * 60 * 24 * $i);
                                        $week_day = date('D', time() - 60 * 60 * 24 * $i);
                                        //date to put in th class
                                        $myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i); zaaid **************/
										$t=time()+ 60 * 60 * 24 * 2;
										$myndate=date('d-M-Y', $t - 60 * 60 * 24 * $i);
                                        $week_day = date('D', $t - 60 * 60 * 24 * $i);
                                        //date to put in th class
                                        $myndateclass=date('Y-m-d', $t - 60 * 60 * 24 * $i);
										
                                      }
                                        $timeexploded=explode('-',$myndate);
                                        echo '<th';
                                        echo ' class="';
                                        echo $myndateclass.'Parent';
                                        if($week_day=="Sun")
                                        {
                                            echo " redbackgrounclass";
                                        }
                                        echo '">'.$timeexploded[0].'<br>'.$timeexploded[1].'<br>'.$timeexploded[2];?>
                                      </th>
                                      <?php
                                  $i++;
                                   }?>
                                </tr>
              
                              </thead>
  
                              <tbody>
                              <?php 
                              $no_of_total_records=0;
							  
							  $dbres = $this->db->query("
							  SELECT tbl_vs.*,
							  COALESCE(tbl_clients.client_name) AS client_name ,
							  COALESCE(tbl_area.area) AS area
							  FROM tbl_vs 
							  LEFT JOIN tbl_clients ON tbl_vs.fk_customer_id = tbl_clients.pk_client_id
							  LEFT JOIN tbl_area ON tbl_clients.fk_area_id = tbl_area.pk_area_id
							  WHERE fk_engineer_id = '".$this->session->userdata('userid')."' ");
							  $get_eng_vss=$dbres->result_array();
                              if (sizeof($get_eng_vss) == "0") 
                              {
                                                        
                              } 
                              else 
                              {
							  /////////////// zaaid
								$size_of_total_rows=0;
								$visited_client_array= array();
								///////////////// zaaid
                                  foreach ($get_eng_vss as $eng_vs) 
                                  {
								  /////////////////////////// zaaid
								if (in_array($eng_vs['fk_customer_id'], $visited_client_array)) {
									continue;}
								////////////////////////////////////// zaaid
                                      ?>
                                     <tr class="odd gradeX">
                                            <td>
                                                 <?php
                                                        // to check whether office id is stored or customer id is stored. office can be customer too.
                                                    if(substr($eng_vs['fk_customer_id'],0,1)=='o')
                                                    {
                                                        $office_id		=	substr($eng_vs['fk_customer_id'],13,1);
                                                        $qu2			=	"SELECT * from tbl_offices where pk_office_id =  '".$office_id."'";
                                                        $gh2			=	$this->db->query($qu2);
                                                        $rt2			=	$gh2->result_array();
                                                        $myclient 		= 	$rt2[0]['office_name'];
                                                        $area 			= 	$rt2[0]['office_name'];
                                                    }
                                                    else
                                                    {
                                                         // $maxqu = $this->db->query("SELECT * FROM tbl_clients where pk_client_id='".$eng_vs['fk_customer_id']."' ");
                                                         // $maxval=$maxqu->result_array();
                                                         // $myclient = $maxval[0]['client_name'];
														 $myclient = $eng_vs['client_name'];
                                                         //for area
                                                         // $maxqu = $this->db->query("SELECT * FROM tbl_clients where pk_client_id='".$eng_vs['fk_customer_id']."' ");
                                                         // $maxval=$maxqu->result_array();
                                                         // $myclient = $maxval[0]['client_name'];
                                                         //for area finding
                                                         // $maxqu7 = $this->db->query("SELECT * FROM tbl_area where pk_area_id='".$maxval[0]['fk_area_id']."' "); 
                                                         // $maxval7=$maxqu7->result_array();
                                                         $area = $eng_vs['area'];
                                                    }
                                                 ?>
                                                 <?php echo $myclient;?>
                                            </td>  
                                            <td>
                                                 <?php echo $area; ?>
                                            </td>
                                            <?php $i=0;
                                            while( $i<=30)
                                            { 
                                               //if($i==0){ $myndate=date('Y-m-d');} else {$myndate=date('Y-m-d', time() - 60 * 60 * 24 * $i);}
											   if($i==0)
												{
													$myndate=date('Y-m-d',time() + 60 * 60 * 24 * 2);
												}
												elseif($i==1)
												{
													$myndate=date('Y-m-d',strtotime('tomorrow'));
												}
												else
												{
													//$myndate=date('Y-m-d', time() - 60 * 60 * 24 * $i);//this is old
													$t=time()+ 60 * 60 * 24 * 2;
													$myndate=date('Y-m-d', $t - 60 * 60 * 24 * $i);
												}
											   //zaaid $t=time()+ 60 * 60 * 24;
											   //if($i==0){ $myndate=date('d-M-Y',strtotime('tomorrow'));} else {$myndate=date('Y-m-d', $t - 60 * 60 * 24 * $i);}
                                                $zaaid=0;
												
												foreach ($get_eng_vss as $eng_vss) {
															if( $myndate==date('Y-m-d',strtotime($eng_vss['date'])) AND $eng_vs['fk_customer_id'] == $eng_vss['fk_customer_id'] )
															{ 
																//echo '1';
																$zaaid=$zaaid+1;
																//array_push($visited_client_array, $eng_dvr['fk_customer_id']);
															}
															else
															{
																 $zaaid=$zaaid+0;
																 //echo '0';
															}															
															}
												/*
												if( $myndate==$eng_vs['date'])
                                                { 
                                                    echo '<td style="background:#000; color:#fff; text-align:center;"></td>';
                                                }*/
												if( $zaaid>0)
															{  
																
																echo '<td class="blackbackgroundclass';
																//
																if($week_day=="Sun")
																{
																	echo " sundayclass";
																}
																echo '"></td>';
																}
                                                else
                                                {
                                                     echo '<td class="';
                                                     echo $myndate;
                                                     echo'"></td>';
                                                }
												array_push($visited_client_array, $eng_vs['fk_customer_id']);
                                            $i++;
                                            }?>  
                                     </tr>
                             <?php
                                    $no_of_total_records++; 
                                    }
                                  
                                  }?>
                                  </tbody>
                         </table>
                          <input type="hidden" name="no_of_total_records" value="<?php echo $no_of_total_records;?>" id="no_of_total_records" />
                     
                          <?php $i=0;
                                  while( $i<=30)
                                  { 
                                     
                                     if($i==0)
                                      { 
                                      //zaaid  $myndateclass=date('Y-m-d');
									  $myndateclass=date('Y-m-d',time() + 60 * 60 * 24 * 2);
                                      }
									  elseif($i==1)
                                      { 
                                      //zaaid  $myndateclass=date('Y-m-d');
									  $myndateclass=date('Y-m-d',strtotime('tomorrow'));
                                      }
                                     else 
                                      {
										$t=time() + 60 * 60 * 24 * 2;
                                        //zaaid $myndateclass=date('Y-m-d', time() - 60 * 60 * 24 * $i);
										$myndateclass=date('Y-m-d', $t - 60 * 60 * 24 * $i);
                                      }
                                      ?>
                                      <script>
                                      $(document).ready( function(){
                                      var class_ocurances = $(".<?php echo $myndateclass;?>").length;
                                      //alert('class ocurances = '+class_ocurances);
                                      var no_of_total_records = $("#no_of_total_records").val();
                                      //alert('no_of_total_records = '+no_of_total_records);
                                      if(class_ocurances==no_of_total_records)
                                      {
                                          //alert('class ocurances = '+class_ocurances + 'no_of_total_records = '+no_of_total_records);
                                          //$(".<?php echo $myndateclass?>"+Parent).css("background-color", "green");
                                          $(".<?php echo $myndateclass.'Parent';?>").addClass('greenbackgrounclass');
                                      }
                                      });
                                      </script>
                                      <?php
                                  $i++;
                                   }?>
                  </div>
                </div>
              </div>
            </div>

          </div>
<?php } ?>
		  <!--Enter data of visit schedual here-->
          <div class="portlet box grey-gallery">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Visit Schedule of Next Day</div>
				<div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>
            </div>

           <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="">
                      <form action="<?php echo base_url();?>sys/insert_vs" method="post">     
                          <table class="table table-striped table-bordered table-hover">
                            <thead class="bg-blue">
                              <tr>
                                <th colspan="2" style="padding-right:50px;"> Time </th>
                                <th style="padding-right:50px;" >  Customer</th>
                                <th  style="padding-right:50px;"> City</th>
                                <th  style="padding-right:50px;">  Project </th>
                                <th  style="padding-right:20px;">  Project Description</th>
                                <th> Purpose of visit </th>
								<?php if (!isset($project_id)) { ?>
                                <th> Add&nbsp;Row&nbsp;<a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a> </th>
								<?php } ?>
                              </tr>
                            </thead>
                            
                            <tbody class="append_tbody">
                              <tr class="odd gradeX visitschedule">
                                <td> <input  name="starttime[0]" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds"  required>
                                </td>
                                
                                <td> <input   name="endtime[0]" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"   required>
                                </td>
                             <?php if (!isset($project_id)) { ?>  
                                <td> <select class="form-control  " name="customer[0]"  onchange="show_cities(this.value,0)" id="customer0" required>
            
                                          <option value="">--Choose--</option>
                                          <option value="officeoption_1">Rawalpindi Office (HO)</option>
                                          <option value="officeoption_2">Lahore Office (LO)</option>
                                          <option value="officeoption_3">Karachi Office (KO)</option>
                                          <option value="officeoption_4">Multan Office (MO)</option>
                                          <option value="officeoption_5">Peshawar (PO)</option>
                                          <?php $qu="SELECT 
                                                        tbl_clients.pk_client_id, tbl_clients.client_name
                                                         FROM 
                                                         tbl_customer_sap_bridge 
                                                         INNER JOIN
                                                         tbl_clients
                                                         ON
                                                         tbl_clients.pk_client_id 	=	tbl_customer_sap_bridge.fk_client_id
                                                         where
                                                         tbl_customer_sap_bridge.fk_user_id =  '".$this->session->userdata('userid')."' AND tbl_clients.delete_status='0'";
                                        //echo $qu;exit;
                                        $gh=$this->db->query($qu);
                                        $rt=$gh->result_array();
                                        foreach($rt as $value) {
                                              ?>
                                              <option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?></option>
                                              <?php
                                          }?>
                                      </select>
                                </td>
								
                                <td class="citiestd0"> 
                                <select class="form-control  " name="city[0]" required>
                                          <option value="">--Choose--</option>
                                          </select>
                                </td>
                        
                                <td class="businessestd0"><select class="form-control  "  name="business[0]" required>
            
                                          <option value="2">--Choose--</option>
            
                                        </select>
                                </td>
								
                                <td> <textarea class="input-small periority0" name="periority[0]" readonly required rows="4"></textarea></td>
								
								
							 <?php } else { ?>
							 
							 
								<input type="hidden" name="periority[0]" value="<?php echo $project_description ;?>" />
								<input type="hidden" name="business[0]" value="<?php echo $project_id ;//$project_type_id ;?>" />
								<input type="hidden" name="city[0]" value="<?php echo $city_id ;?>" />
								<input type="hidden" name="customer[0]" value="<?php echo $customer_id ;?>" />
								<input type="hidden" name="redirect_project" value="<?php echo $project_id ;?>" />
								
								<td><?php echo $customer_name ;?></td>
								<td><?php echo $city ;?></td>
								<td><?php echo $project_type ;?></td>
								<td><?php echo $project_description ;?></td>
								
							 <?php } ?>
							 
                                <td> <textarea class="input-small summery0" name="summery[0]"  required rows="4"></textarea></td>
								
								<?php if (!isset($project_id)) { ?>
                                <td style="text-align:center;"> 
                                        <a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a>
                                                    <br />
                                        <a href="javascript:void()"><i class="fa fa-minus"></i></a> 
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 </td>
								<? } ?>
            
                              </tr>
            
                              
                            </tbody>
            
                          </table>
                         <div class="form-actions">
                          <div class="row">
                            <div class="col-md-offset-5 col-md-9">
                              <button type="submit" class="btn btn-default blue" onclick="return check_range()">Submit</button>
                            <!--  <button type="button" class="btn btn-circle default">Cancel</button>	-->
                            </div>
                          </div>
                        </div>
                            </form>
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
				/*function fill_business_dec_and_timeelapsed(business_id,rowid)
				{
					
					var formdata =
					  {
						business_id: business_id,
						rowid: rowid
					  };
				  $.ajax({
					url: "<?php echo base_url();?>sys/business_dec_ajax",
					type: 'POST',
					data: formdata,
					success: function(msg){
						$(".business_description"+rowid).val(msg);
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
				}*/
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
                    $('.append_tbody').append('<tr class="odd gradeX visitschedule"><td> <input  name="starttime['+count1+']" type="text" class="form-control timepicker1 timepicker timepicker-no-seconds"   required></td><td> <input   name="endtime['+count1+']" type="text" class="form-control timepicker2 timepicker timepicker-no-seconds"   required></td><td><select class="form-control  " name="customer['+count1+']"  onchange="show_cities(this.value,'+count1+')" required id="customer'+count1+'"><option value="">--Choose--</option><option value="officeoption_1">Rawalpindi Office (HO)</option><option value="officeoption_2">Lahore Office (LO)</option><option value="officeoption_3">Karachi Office (KO)</option><option value="officeoption_4">Multan Office (MO)</option><option value="officeoption_5">Peshawar (PO)</option><?php $qu="SELECT tbl_clients.pk_client_id, tbl_clients.client_name FROM tbl_customer_sap_bridge INNER JOIN tbl_clients ON tbl_clients.pk_client_id 	=	tbl_customer_sap_bridge.fk_client_id where tbl_customer_sap_bridge.fk_user_id =  '".$this->session->userdata('userid')."' AND tbl_clients.delete_status = '0'"; $gh=$this->db->query($qu); $rt=$gh->result_array(); foreach($rt as $value){ ?> <option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?></option> <?php }?></select></td><td class="citiestd'+count1+'"> <select class="form-control  " name="city['+count1+']" required><option value="">--Choose--</option></td><td class="businessestd'+count1+'"><select class="form-control  "  name="business['+count1+']" required><option value="">--Choose--</option><option value="MD">MDx Business</option><option value="ID">IDx Business</option></select></td><td> <textarea class="input-small periority'+count1+'" name="periority['+count1+']" readonly required rows="4"></textarea></td><td> <textarea class="input-small summery'+count1+'" name="summery['+count1+']"  required rows="4"></textarea></td><td><a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a><br /><a href="javascript:void()"><i class="fa fa-minus"></i></a></td></tr>');
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
       </form>
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<style>
        .redbackgrounclass
        {
            background-color:#F00 !important;
        }
        .redbackgrounclass.greenbackgrounclass
        {
            background-color:#F00 !important;
        }
        .greenbackgrounclass
        {
            background-color:#0F0 !important;
        }
		.blackbackgroundclass
		{
			background:#000 !important; 
			color:#fff; 
			text-align:center;
		}
        
</style>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>