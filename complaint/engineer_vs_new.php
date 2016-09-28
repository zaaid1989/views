<?php $this->load->view('header');?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Stock Entry <small>Multiple</small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Stock Entry Multiple
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
		<form method="post" action="<?php echo base_url();?>products/spare_part_stock_entry_insert_new">
          <!--Enter data of visit schedual here-->
          <div class="portlet box purple-seance">

            <div class="portlet-title">
                  <div class="caption"> <i class="fa fa-globe"></i>Stock Entry Multiple</div>
            </div>

            <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-scrollable">
                    <table class="table  table-condensed table-bordered">
                      <thead class="bg-grey-gallery">
                        <tr>
                          <th> Stock Location		</th>
                          <th> Vendor Name			</th>
						  <th> Part Number			</th>
                          <th> Part Description		</th>
                          <th> Stock In Quantity	</th>
                          <th> Comments				</th>
                          <th> </th>
                      <!--    <th> Add&nbsp;Row&nbsp;<a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a> </th> -->
                        </tr>
                      </thead>
                      
                      <tbody class="append_tbody">
                        <tr class=" visitschedule">
						
                          <td>
							<select class="form-control" name="customer[0]" id="customer0"  onchange="show_cities(this.value,0)" required>
                                    <option value="">--Choose--</option>
                                     <?php $quw="SELECT * from user where id =  '".$this->session->userdata('userid')."'";
                                  $ghw=$this->db->query($quw);
                                  $rtw=$ghw->result_array();
                                  // get all client of this this office id
                                  $qu="SELECT * from tbl_clients where fk_office_id =  '".$rtw[0]['fk_office_id']."' AND delete_status='0'";
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
						  <td> <input type="text" class="form-control test0" name="test[0]" required></td>
                          <td> <textarea class="input-small summery0" name="summery[0]"  required rows="4"></textarea></td>
                          <td style=""> 
                             <!--     <a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a>
                                              <br /> 
                                  <a href="javascript:void()"><i class="fa fa-minus"></i></a>  -->
								  <a href="javascript:;" class="btn btn-icon-only red">
															<i class="fa fa-minus"></i>
															</a>
                             <!--     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                           </td>
                        </tr>
                      </tbody>
                    </table>
					
					</div>
                 </div>
                </div>
				
            
                    
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
				  
				  
				  </div> <!-- Portlet Body -->
              </div> <!-- Portlet -->
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
              url: "<?php echo base_url();?>complaint/client_select_ajax",
              type: 'POST',
              data: formdata,
              success: function(msg){
                  $(".citiestd"+rowid).html(msg);
                  //alert(msg);
                  }
              })
              $.ajax({
              url: "<?php echo base_url();?>complaint/business_select_ajax",
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
              url: "<?php echo base_url();?>complaint/business_dec_ajax",
              type: 'POST',
              data: formdata,
              success: function(msg){
                  $(".periority"+rowid).val(msg);
                  //alert(msg);
                  }
              })
              $.ajax({
              url: "<?php echo base_url();?>complaint/business_time_elapsed_ajax",
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
              $('.append_tbody').append('<tr class="visitschedule"><td><select class="form-control  " name="customer['+count1+']"  id="customer'+count1+'"  onchange="show_cities(this.value,'+count1+')" required><option value="">--Choose--</option><option value="officeoption_1">Rawalpindi Office (HO)</option><option value="officeoption_2">Lahore Office (LO)</option><option value="officeoption_3">Karachi Office (KO)</option><option value="officeoption_4">Multan Office (MO)</option><option value="officeoption_5">Peshawar (PO)</option><?php $quw="SELECT * from user where id =  '".$this->session->userdata('userid')."'";$ghw=$this->db->query($quw);$rtw=$ghw->result_array();$qu="SELECT * from tbl_clients where fk_office_id =  '".$rtw[0]['fk_office_id']."' AND delete_status='0'";$gh=$this->db->query($qu);$rt=$gh->result_array();foreach($rt as $value){?><option value="<?php echo $value['pk_client_id'];?>"><?php echo $value['client_name'];?></option><?php }?></select></td><td class="citiestd'+count1+'"> <select class="form-control  " name="city['+count1+']" required><option value="">--Choose--</option></td><td class="businessestd'+count1+'"><select class="form-control  "  name="business['+count1+']"><option value="">--Choose--</option><option value="MD">MDx Business</option><option value="ID">IDx Business</option></select></td><td> <textarea class="input-small periority'+count1+'" name="periority['+count1+']" readonly required rows="4"></textarea></td><td> <input type="text" class="form-control test'+count1+'" name="test['+count1+']" required></td><td> <textarea class="input-small summery'+count1+'" name="summery['+count1+']"  required rows="4"></textarea></td><td><a href="javascript:;" class="btn btn-icon-only red"><i class="fa fa-minus"></i></a></td></tr>');
              $('select').select2();
              $( ".btn-icon-only" ).click(function(event) {
                    //$(this).closest('tr').remove();
					//event.preventDefault();
					$(this).parents('tr').remove();
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
                  
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
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
<?php $this->load->view('footer');?>