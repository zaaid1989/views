<?php $this->load->view('header');?>
      <h3 class="page-title"> PM Form <small></small> </h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                Home
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                PM
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                PM Form
            </li>
        </ul>
        <div class="page-toolbar">
        </div>
      </div>
      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->
      <div class="row">
        <div class="col-md-12">
            <?php
				  $nsql="select * from tbl_complaints where pk_complaint_id ='".$this->uri->segment(3)."'";
				  $n2sql=$this->db->query($nsql);
				  $get_compalaint_result=$n2sql->result_array();
				  
				  $this->load->model("complaint_model");
				  $obj=new Complaint_model();
			?>
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box purple">
            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>PM Information</div>

              <div class="tools">
                  <a href="javascript:;" class="collapse"> </a> 
                  
                  <a href="javascript:;" class="remove"> </a> 
              </div>
            </div>
            <div class="portlet-body">
            
            <div class="table-toolbar">
				  <?php
                      if(isset($_GET['msg_pend_ver']))
                        { 
                          echo '<div class="alert alert-success alert-dismissable">  
                                  <a class="close" data-dismiss="alert">×</a>  
                                  Mark Pending Verification Successfully.  
                                </div>';
                        }
                    ?>
                    <?php
                      if(isset($_GET['msg_other_details']))
                        { 
                          echo '<div class="alert alert-success alert-dismissable">  
                                  <a class="close" data-dismiss="alert">×</a>  
                                  Other Detail Entered Successfully.  
                                </div>';
                        }
                    ?>
                    
                    <?php
                      if(isset($_GET['msg_mark_comp']))
                        { 
                          echo '<div class="alert alert-success alert-dismissable">  
                                  <a class="close" data-dismiss="alert">×</a>  
                                  Mark Completed Successfully.  
                                </div>';
                        }
                    ?>
					<?php
					$nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
								  if($nsql3->num_rows()>0)
									  {
										$n2sql3=$nsql3->result_array();
										
										$nsql4=$this->db->query("select * from tbl_products where pk_product_id ='".$n2sql3[0]['fk_product_id']."'");
										$n2sql4=$nsql4->result_array();
										$product_name = $n2sql4[0]['product_name'];
									  }
									else $product_name = "N/A";
					?>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr><th>Attribute</th><th>Value</th></tr>
                            </thead>
                            <tbody>
							
								<tr class="odd gradeX"> <!-- FSE -->
                                      <td>
                                      FSE
                                     </td>
                                     <td> 
                                     <?php    
                                        $nsql3=$this->db->query("select * from user where id ='".$get_compalaint_result[0]['assign_to']."'");
                                        $n2sql3=$nsql3->result_array();
                                        echo $n2sql3[0]['first_name'];
                                     ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      Customer Name
                                     </td>
                                     <td> 
                                     <?php    
                                        $nsql3=$this->db->query("select * from tbl_clients where pk_client_id ='".$get_compalaint_result[0]['fk_customer_id']."'");
                                        $n2sql3=$nsql3->result_array();
                                        echo $n2sql3[0]['client_name'];
                                     ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">							   
									<td>
									  Serial No.
									 </td>
									 <td>
								   <?php    
									  $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
									  if($nsql3->num_rows()>0)
								  		{
									  $n2sql3=$nsql3->result_array();
									  echo $n2sql3[0]['serial_no'];
										}
								   ?>
									 </td>
                               </tr>
                               <tr class="odd gradeX">
                                  <td>
                                        Create Date
                                     </td>
                                     <td> 
									 	<?php echo date('d-M-Y H:i', strtotime($get_compalaint_result[0]['date']));  ?>
                                    </td>
                               </tr>
                               
                               <tr class="odd gradeX">
                                      <td>
                                        Submission Time
                                     </td>
                                     <td>
										<?php echo date('d-M-Y H:i',strtotime($get_compalaint_result[0]['solution_date']));  ?>
                                     </td>
                               </tr>
							   <?php    
								  
										//if($n2sql4[0]['product_name']=='AU400' || $n2sql4[0]['product_name']=='AU480')
										if($product_name=='KC4D')
										{
											?>
                                               <tr class="odd gradeX">
                                                      <td>
                                                      PT kit in Use (Brand & Pack)
                                                     </td>
                                                     <td> 
                                                        <?php echo $get_compalaint_result[0]['pt_kit_in_use'];  ?>
                                                     </td>
                                               </tr>
											   
											   <tr class="odd gradeX">
                                                      <td>
                                                      APTT kit in Use (Brand & Pack)
                                                     </td>
                                                     <td> 
                                                        <?php echo $get_compalaint_result[0]['appt_kit_in_use'];  ?>
                                                     </td>
                                               </tr>
                                     <?php }
									  ?>
                               <tr class="odd gradeX">
                                      <td>
                                      Name of Customer Signing PM Form
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['name_of_customer_sign_pm_form'];  ?>
                                     </td>
                               </tr>
                               <?php    
								  
										//if($n2sql4[0]['product_name']=='AU400' || $n2sql4[0]['product_name']=='AU480')
										if($product_name=='AU400' || $product_name=='AU480'  || $product_name=='AU680')
										{
											?>
                                               <tr class="odd gradeX">
                                                      <td>
                                                      Counter in Front of Equipment
                                                     </td>
                                                     <td> 
                                                        <?php echo $get_compalaint_result[0]['counter_in_front_of_equipment'];  ?>
                                                     </td>
                                               </tr>
                                     <?php }
									  ?>
                               
                            </tbody>
                       </table>
                </div>
                  
               </div>
               
                <div class="col-md-6">
                
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">

                            <thead>
                              <tr><th>Attribute</th><th>Value</th></tr>
                            </thead>
                            <tbody>
							
								<tr class="odd gradeX"> <!-- status -->
                                      <td>
                                      Status
                                     </td>
                                     <td> 
                                     <?php    
                                        $this->load->model("complaint_model");
										$obj=new Complaint_model();
										$obj->current_status($get_compalaint_result[0]['status'] );
                                     ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      City
                                     </td>
                                     <td> 
                                     <?php    
                                        $nsql3=$this->db->query("select * from tbl_cities where pk_city_id ='".$get_compalaint_result[0]['fk_city_id']."'");
                                        $n2sql3=$nsql3->result_array();
                                        echo $n2sql3[0]['city_name'];
                                     ?>
                                     </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      TS Number
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['ts_number'] ;  ?></td>
                               </tr>
                               <tr class="odd gradeX">
                                  <td>
                                   Start  
                                 </td>
                                 <td>
                                  <?php echo date('d-M-Y H:i', strtotime($get_compalaint_result[0]['reporting_date']));  ?>
                                 </td>
                           </tr>
						   
                           <tr class="odd gradeX">
                                  <td>
                                  Verification Time
                                 </td>
                                 <td>
                                  <?php echo date('d-M-Y H:i', strtotime($get_compalaint_result[0]['finish_time']));  ?>
                                 </td>
                           </tr>
						    <?php    
								  
										//if($n2sql4[0]['product_name']=='AU400' || $n2sql4[0]['product_name']=='AU480')
										if($product_name=='KC4D')
										{
											?>
                                               <tr class="odd gradeX">
                                                      <td>
                                                      Fibrinogen Kit in Use (Brand & Pack)
                                                     </td>
                                                     <td> 
                                                        <?php echo $get_compalaint_result[0]['fibrinogen_kit_in_use'];  ?>
                                                     </td>
                                               </tr>
											   
											   <tr class="odd gradeX">
                                                      <td>
                                                      Cups and Balls in Use (Brand & Pack)
                                                     </td>
                                                     <td> 
                                                        <?php echo $get_compalaint_result[0]['cups_and_balls_in_use'];  ?>
                                                     </td>
                                               </tr>
                                     <?php }
									  ?>
                             <tr class="odd gradeX">
                                      <td>
                                      Mobile Number of Customer Signing PM Form
                                     </td>
                                     <td> 
                                        <?php echo $get_compalaint_result[0]['mobile_no_of_customer_sign_pm_form'];?>
                                     </td>
                               </tr>                                                  
                                   
                            </tbody>
                       </table>
                </div>
                  
               </div>
              </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
        
          <!-- END EXAMPLE TABLE PORTLET-->   
      
         
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
		  <?php
		  if ($this->session->userdata('userrole')=='Supervisor'  && $get_compalaint_result[0]['status']=='Pending')
		  {      
		  ?>  
          <div class="portlet box red">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Other Details</div>

            </div>

            <div class="portlet-body">

              <div class="portlet-body flip-scroll">
                <div class="row">
                          <div class="col-md-12 form-horizontal">
						  
							<form method="post" action="<?php echo base_url();?>sys/pm_form_other_details_insert">
                            <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name="s_pm_form" value="1" />
                            
							<div class="form-group">
							<label class="col-md-4 control-label">Start date:</label>
								<div class="col-md-4">
									<input type="text" class="datepicker2 form-control otherdetailstextfield start_date" name="start_date" 
                                    value="<?php echo date('d-M-Y',strtotime($get_compalaint_result[0]['reporting_date']));  ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Start Time:</label>
								<div class="col-md-4">
									<input type="text" class="form-control timepicker timepicker-24 otherdetailstextfield start_time" name="start_time" 
                                    value="<?php echo date('H:i',strtotime($get_compalaint_result[0]['reporting_date']));  ?>">
								</div>
							</div>
                            
                            <div class="form-group">
							<label class="col-md-4 control-label">Name of Customer Signing PM Form:</label>
								<div class="col-md-4">
									<input type="text" class="form-control otherdetailstextfield" name="name_of_customer_sign_pm_form" value="<?php echo $get_compalaint_result[0]['name_of_customer_sign_pm_form'];  ?>">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Mobile Number of Customer Signing PM Form:</label>
								<div class="col-md-4">
									<input type="text" class="form-control otherdetailstextfield" name="mobile_no_of_customer_sign_pm_form" value="<?php echo $get_compalaint_result[0]['mobile_no_of_customer_sign_pm_form'];  ?>">
								</div>
							</div>
                            <?php    
							  $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
							  if($nsql3->num_rows()>0)
								  {
									$n2sql3=$nsql3->result_array();
									
									$nsql4=$this->db->query("select * from tbl_products where pk_product_id ='".$n2sql3[0]['fk_product_id']."'");
									$n2sql4=$nsql4->result_array();
									if($n2sql4[0]['product_name']=='AU400' || $n2sql4[0]['product_name']=='AU480' || $n2sql4[0]['product_name']=='AU680')
									{
										?>
                                        <div class="form-group">
                                        <label class="col-md-4 control-label">Counter in Front of Equipment:</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control otherdetailstextfield" name="counter_in_front_of_equipment" value="<?php echo $get_compalaint_result[0]['counter_in_front_of_equipment'];  ?>">
                                            </div>
                                        </div>
										<?php
									}
									if($n2sql4[0]['product_name']=='Access 2')
									{
										?>
										<?php
									}
									if($n2sql4[0]['product_name']=='KC4D')
									{
										?>
                                        <div class="form-group">
                                        <label class="col-md-4 control-label">PT kit in Use (Brand & Pack):</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control otherdetailstextfield" name="pt_kit_in_use" value="<?php echo $get_compalaint_result[0]['pt_kit_in_use'];  ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-md-4 control-label">APTT kit in Use (Brand & Pack):</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control otherdetailstextfield" name="appt_kit_in_use" value="<?php echo $get_compalaint_result[0]['appt_kit_in_use'];  ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-md-4 control-label">Fibrinogen Kit in Use (Brand & Pack):</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control otherdetailstextfield" name="fibrinogen_kit_in_use" value="<?php echo $get_compalaint_result[0]['fibrinogen_kit_in_use'];  ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-md-4 control-label">Cups and Balls in Use (Brand & Pack):</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control otherdetailstextfield" name="cups_and_balls_in_use" value="<?php echo $get_compalaint_result[0]['cups_and_balls_in_use'];  ?>">
                                            </div>
                                        </div>
										<?php
									}
								  }
						   ?>
                            <input type="submit" value="Save"  class="btn btn-success" <?php if($get_compalaint_result[0]['status']!='Pending'){?> onclick="return donotsubmit()" <?php }?>/>
                            </form>
                          </div>
                        </div>

				</div>
				
            </div>

          </div>
          <?php
		  }		  
		  ?>
		  <!-- END EXAMPLE TABLE PORTLET-->
          <script src="<?php echo base_url();?>assets/global/plugins/jquery.form.min.js" type="text/javascript"></script>
		  <script type="text/javascript">
          //after succesful upload
          function afterSuccess(my_image)
          {
              $('#submit-btn'+my_image).show(); //hide submit button
              //$('#loading-img'+my_image).hide(); //hide submit button
          	  
			  //alert('sana');
			  $('#loading-img'+my_image).hide(10000, function(){
					// second Ajax call
					var formdata =
						{
						  my_image: my_image
						};
					$.ajax({
					  url: "<?php echo base_url();?>sys/check_file_type/<?php echo $this->uri->segment(3);?>",
					  type: 'POST',
					  data: formdata,
					  success: function(msg){
						  $('.viwimage_td'+my_image).html(msg);
						  }
					  });
					  // thired Ajax call
					var formdata =
						{
						  my_image: my_image
						};
					$.ajax({
					  url: "<?php echo base_url();?>sys/check_if_file_uploaded/<?php echo $this->uri->segment(3);?>",
					  type: 'POST',
					  data: formdata,
					  success: function(msg){
						  $('.uploaded_td'+my_image).html(msg);
						  }
					  });
				});
          }
          
          //function to check file size before uploading.
          function beforeSubmit(my_image){
              var progressbox     = $('#progressbox'+my_image);
              var progressbar     = $('#progressbar'+my_image);
              var statustxt       = $('#statustxt'+my_image);
              var completed       = '0%';
              //check whether browser fully supports all File API
             if (window.File && window.FileReader && window.FileList && window.Blob)
              {
          
                  if( !$('#imageInput'+my_image).val()) //check empty input filed
                  {
                      $("#output"+my_image).html("Are you kidding me?");
                      return false
                  }
                  
                  var fsize = $('#imageInput'+my_image)[0].files[0].size; //get file size
                  var ftype = $('#imageInput'+my_image)[0].files[0].type; // get file type
                  
                  //allow only valid image file types 
                  switch(ftype)
                  {
                      case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg': case 'application/pdf':
                          break;
                      default:
                          $("#output"+my_image).html("<b>"+ftype+"</b> Unsupported file type!");
                          return false
                  }
                  
                  //Allowed file size is less than 1 MB (1048576) making it to 3.5 mb 3670016 26 november 2015
                  //if(fsize>1048576) 
				if(fsize>3670016)
                  {
                      $("#output"+my_image).html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                      return false
                  }
                  
                  //Progress bar
                  progressbox.show(); //show progressbar
                  progressbar.width(completed); //initial value 0% of progressbar
                  statustxt.html(completed); //set status text
                  statustxt.css('color','#000'); //initial color of status text
          
                          
                  $('#submit-btn'+my_image).hide(); //hide submit button
                  $('#loading-img'+my_image).show(); //hide submit button
                  $("#output"+my_image).html("");  
              }
              else
              {
                  //Output error to older unsupported browsers that doesn't support HTML5 File API
                  $("#output"+my_image).html("Please upgrade your browser, because your current browser lacks some new features we need!");
                  return false;
              }
          }
          
          //function to format bites bit.ly/19yoIPO
          function bytesToSize(bytes) {
             var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
             if (bytes == 0) return '0 Bytes';
             var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
             return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
          }
          </script>
          <link href="<?php echo base_url();?>assets/global/css/style_ajaxuploader.css" rel="stylesheet" type="text/css">
          
          <?php    
      $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
      if($nsql3->num_rows()>0)
		  {
			$n2sql3=$nsql3->result_array();
			
			$nsql4=$this->db->query("select * from tbl_products where pk_product_id ='".$n2sql3[0]['fk_product_id']."'");
			$n2sql4=$nsql4->result_array();
			if($n2sql4[0]['product_name']=='AU400' || $n2sql4[0]['product_name']=='AU480' || $n2sql4[0]['product_name']=='AU680')
			{
				$fields_array = array('PM_Form_with_Customer_Signature_Page_1','PM_Form_with_Customer_Signature_Page_2','PM_Form_with_Customer_Signature_Page_3','PM_Form_with_Customer_Signature_Page_4','picture_of_photocal','Picture_of_Reagent_Management','Picture_of_Calibration_display_the_ISE_Maintenance_Menu','Picture_of_Selectivity_Check','Picture_of_ISE_Maintenance_Screen','Picture_of_Analyzer_Maintenance_Screen','Print_out_of_Reagent_Consumption_for_the_last_01_month_Page_1','Print_out_of_Reagent_Consumption_for_the_last_01_month_Page_2', 'Picture_of_Counter_in_the_Front_Lower_Right_Side_of_the_Analyzer','DC_of_any_spare_parts_changed');
				?>
                <!--Show this only when Product is Access 2-->
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>PM form and Supporting Documents</div>
            </div>
            <?php 
				$dbqyery = $this->db->query('select * from tbl_pm_pictures where fk_complaint_id = "'.$this->uri->segment(3).'"');
				if($dbqyery->num_rows()>0)
				{
					//echo "success";
				}
				else
				{
					$dbqyery = $this->db->query('insert into tbl_pm_pictures set fk_complaint_id = "'.$this->uri->segment(3).'"');
				}
				$dbqyery = $this->db->query('select * from tbl_pm_pictures where fk_complaint_id = "'.$this->uri->segment(3).'"');
				$dbres=$dbqyery->result_array();
			?>
            <div class="portlet-body">
			 <div class="portlet-body flip-scroll">
                <div class="row">
                  <div class="col-md-12 ">
                  	<div class="portlet-body flip-scroll">
                    <!--<form method="post" action="<?php echo base_url()?>sys/pm_pictures_update" enctype="multipart/form-data">-->
                      <table class="table table-striped table-bordered table-hover flip-content" id="sample_8">
                        <thead>
                          <tr>
                              
                              <th>
                                   Picture Name
                              </th>
                              <?php
								if($obj->is_allowed('Supervisor') && $get_compalaint_result[0]['status']=='Pending'){ ?>
							  <th>
								   Update
							  </th>
							  <?php }?>
                              <th>
                                   File
                              </th>
                              <th>
                                   View
                              </th>  
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($fields_array as $filed){?>
                         <tr class="odd gradeX">
                                                                          
                              <td>
                                  <?php $mmy_field_name = explode ('_', $filed); 
								  		foreach ($mmy_field_name as $mym)
										{
											if ($mym=="picture")
												echo "Picture".' ';
											else
												echo $mym.' ';
										}
										if($filed=='Picture_of_ISE_Maintenance_Screen' || $filed=='Picture_of_Analyzer_Maintenance_Screen')
										{
											echo ' (grid)';
										}
								  ?>
                              </td>
                              
                              <?php $my_image='_'.$filed;?>
                                <?php $image=$filed;?>
                              <?php if($obj->is_allowed('Supervisor') && $get_compalaint_result[0]['status']=='Pending'){ ?>
                              <td>
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                            <input name="<?php echo $filed;?>" id="imageInput<?php echo $my_image;?>" type="file" />
                                             <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?> ">
                                            <input type="submit" class="btn btn-info"  id="submit-btn<?php echo $my_image;?>" value="Upload" 
                                            onclick="return uploader_function<?php echo $my_image;?>('<?php echo $my_image;?>')" />
                                            <img src="<?php echo base_url()?>assets/global/img/ajax-loader.gif" id="loading-img<?php echo $my_image;?>" 
                                            style="display:none;" alt="Please Wait"/>
                                        </form>
                                        <div id="progressbox<?php echo $my_image;?>" style="display:none;">
                                            <div id="progressbar<?php echo $my_image;?>"></div>
                                            <div id="statustxt<?php echo $my_image;?>">0%</div>
                                        </div>
                                        <div id="output<?php echo $my_image;?>" ></div>
                                    </div>
                                </div>
                              </td>   
                               <?php }?>
                               <div id="<?php echo $filed;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$filed]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
                                        }
                                        else
                                        {
                                            $src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$filed];
                                        }
                                      ?>
                                         <img src="<?php echo $src ;?>" class="img-responsive" />
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <script>
                                  function uploader_function<?php echo $my_image;?>(my_image)  
								   {
									   var options = { 
										  target:   '.output'+my_image,   // target element(s) to be updated with server response 
										  beforeSubmit:  beforeSubmit(my_image),  // pre-submit callback 
										  uploadProgress: OnProgress<?php echo $my_image;?>,
										  success:       afterSuccess(my_image),  // post-submit callback 
										  resetForm: true        // reset the form after successful submit 
									  }; 
									   $('#MyUploadForm'+my_image).ajaxSubmit(options);  			
										  // return false to prevent standard browser submit and page navigation 
										  return false; 
								   }
								 //when upload progresses	
								  function OnProgress<?php echo $my_image;?>(event, position, total, percentComplete)
								  {
									  var progressbox     = $('#progressbox<?php echo $my_image;?>');
									  var progressbar     = $('#progressbar<?php echo $my_image;?>');
									  var statustxt       = $('#statustxt<?php echo $my_image;?>');
									  var completed       = '0%';
									  //Progress bar
									  progressbar.width(percentComplete + '%') //update progressbar percent complete
									  statustxt.html(percentComplete + '%'); //update status text
									  if(percentComplete>50)
										  {
											  statustxt.css('color','#fff'); //change status text to white after 50%
										  }
								  }
                                </script>
								<style>
								#progressbox<?php echo $my_image;?> {
									border: 1px solid #92C8DA;
									padding: 1px; 
									position:relative;
									width:400px;
									border-radius: 3px;
									margin: 10px;
									display:none;
									text-align:left;
								}
								#progressbar<?php echo $my_image;?> {
									height:20px;
									border-radius: 3px;
									background-color: #77E0FA;
									width:1%;
								}
								#statustxt<?php echo $my_image;?> {
									top:3px;
									left:50%;
									position:absolute;
									display:inline-block;
									color: #000000;
								}
								</style>
                              <td class="<?php echo 'uploaded_td'.$my_image?>">
                                  <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            if($filed=='PM_Form_with_Customer_Signature_Page_2' || $filed=='PM_Form_with_Customer_Signature_Page_3' || $filed=='PM_Form_with_Customer_Signature_Page_4' || $filed=='Print_out_of_Reagent_Consumption_for_the_last_01_month_Page_2' || $filed=='DC_of_any_spare_parts_changed')
											{
												echo '<span class="label label-sm label-warning"> Not Uploaded </span>';
												echo '<input type="hidden" class="uploaded_not_uploaded" value="uploaded">';
											}
											else
											{
												echo '<span class="label label-sm label-warning"> Not Uploaded </span>';
												echo '<input type="hidden" class="uploaded_not_uploaded" value="not_uploaded">';
											}
                                        }
                                        else
                                        {
                                            echo '<span class="label label-sm label-success"> Uploaded </span>';
											echo '<input type="hidden" class="uploaded_not_uploaded" value="uploaded">';
                                        }
                                      ?>
                              </td>           
                                                                           
                              <td class="<?php echo 'viwimage_td'.$my_image?>">
                                    <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#'.$filed.'">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#'.$filed.'">View Image</button>';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'"
												 class="btn btn-default blue-madison-stripe" target="_blank">
												View File</a>';
											}
                                        }
                                      ?>
                              </td>    
                      	</tr>
                        <?php }?>
                      </tbody>
                    </table>
                    
                    </div>
				</div>	
             </div>
			  </div>
            </div>
          </div>
          		<!-- END EXAMPLE TABLE PORTLET-->
          		<!---->
				<?php
			}
			if($n2sql4[0]['product_name']=='Access 2')
			{
				$fields_array = array('PM_Form_with_Customer_Signature_Page_1','PM_Form_with_Customer_Signature_Page_2','PM_Form_with_Customer_Signature_Page_3','Temperature_Report','Level_Sense_Test_Report','Full_System_Check_Results_Page_1','Full_System_Check_Results_Page_2','Picture_of_Total_Tests_performed_in_last_30_days','Operator_Maintenance_Sheet','DC_of_any_spare_parts_changed','Run_Time','Pressure_Monitor');
				//print_r($fields_array);exit;
				?>
                <!--Show this only when Product is Access 2-->
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>PM form and Supporting Documents</div>
            </div>
            <?php 
				$dbqyery = $this->db->query('select * from tbl_pm_pictures where fk_complaint_id = "'.$this->uri->segment(3).'"');
				if($dbqyery->num_rows()>0)
				{
					//echo "success";
				}
				else
				{
					$dbqyery = $this->db->query('insert into tbl_pm_pictures set fk_complaint_id = "'.$this->uri->segment(3).'"');
				}
				$dbqyery = $this->db->query('select * from tbl_pm_pictures where fk_complaint_id = "'.$this->uri->segment(3).'"');
				$dbres=$dbqyery->result_array();
			?>
            <div class="portlet-body">
			 <div class="portlet-body flip-scroll">
                <div class="row">
                  <div class="col-md-12 ">
                  	<div class="portlet-body flip-scroll">
                      <table class="table table-striped table-bordered table-hover flip-content" id="sample_8">
                        <thead>
                          <tr>
                              
                              <th>
                                   Picture Name
                              </th>
                              <?php
								if($obj->is_allowed('Supervisor') && $get_compalaint_result[0]['status']=='Pending'){ ?>
							  <th>
								   Update
							  </th>
							  <?php }?>
                              <th>
                                   File
                              </th>
                              <th>
                                   View
                              </th>  
                          </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach ($fields_array as $filed){?>
                         <tr class="odd gradeX">
                                                                          
                              <td>
                                  <?php $mmy_field_name = explode ('_', $filed); 
										$temp_name = "";
								  		foreach ($mmy_field_name as $mym)
										{
											//echo $mym.' ';
											$temp_name = $temp_name.$mym.' ';
										}
										if ($temp_name=="DC of any spare parts changed ")		
											echo "Luminometer Screen (Diagnostics F7 -> Device Diagnostics F4 -> Luminometer F4)";		
										else		
											echo $temp_name;
										if($filed=='Picture_of_ISE_Maintenance_Screen' || $filed=='Picture_of_Analyzer_Maintenance_Screen')
										{
											echo ' (grid)';
										}
										
										if($filed=='Temperature_Report')		
										{		
											echo ' (Diagnostics F7 -> Device Diagnostics F4 -> Analog Devices F2)';		
										}		
										if($filed=='Level_Sense_Test_Report')		
										{		
											echo ' (Use 2 ml Cup and 10 Repititions)';		
										}		
										if($filed=='Run_Time')		
										{		
											echo ' (Event Log -> Click Last Event -> Click DETAILS -> Take picture of screen)';		
										}		
										if($filed=='Pressure_Monitor')		
										{		
											echo ' (Diagnostics F7 -> Device Diagnostics F4 -> Analog Devices F4 -> Pressure Monitor F2)';		
										}
								  ?>
                              </td>
                              
                              <?php $my_image='_'.$filed;?>
                                <?php $image=$filed;?>
                              <?php if($obj->is_allowed('Supervisor') && $get_compalaint_result[0]['status']=='Pending'){ ?>
                              <td>
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $filed;?>" id="imageInput<?php echo $my_image;?>" type="file" />
                                         <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?> ">
                                        <input type="submit" class="btn btn-info"  id="submit-btn<?php echo $my_image;?>" value="Upload" 
                                        onclick="return uploader_function<?php echo $my_image;?>('<?php echo $my_image;?>')" />
                                        <img src="<?php echo base_url()?>assets/global/img/ajax-loader.gif" id="loading-img<?php echo $my_image;?>" style="display:none;" alt="Please Wait"/>
                                        </form>
                                        <div id="progressbox<?php echo $my_image;?>" style="display:none;">
                                            <div id="progressbar<?php echo $my_image;?>"></div>
                                            <div id="statustxt<?php echo $my_image;?>">0%</div>
                                        </div>
                                        <div id="output<?php echo $my_image;?>" ></div>
                                    </div>
                                </div>
                              </td>   
                               <?php }?>
                               <div id="<?php echo $filed;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$filed]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
                                        }
                                        else
                                        {
                                            $src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$filed];
                                        }
                                      ?>
                                         <img src="<?php echo $src ;?>" class="img-responsive" />
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <script>
                                  function uploader_function<?php echo $my_image;?>(my_image)  
								   {
									   var options = { 
										  target:   '.output'+my_image,   // target element(s) to be updated with server response 
										  beforeSubmit:  beforeSubmit(my_image),  // pre-submit callback 
										  uploadProgress: OnProgress<?php echo $my_image;?>,
										  success:       afterSuccess(my_image),  // post-submit callback 
										  resetForm: true        // reset the form after successful submit 
									  }; 
									   $('#MyUploadForm'+my_image).ajaxSubmit(options);  			
										  // return false to prevent standard browser submit and page navigation 
										  return false; 
										  
								   }
								 //when upload progresses	
								  function OnProgress<?php echo $my_image;?>(event, position, total, percentComplete)
								  {
									  var progressbox     = $('#progressbox<?php echo $my_image;?>');
									  var progressbar     = $('#progressbar<?php echo $my_image;?>');
									  var statustxt       = $('#statustxt<?php echo $my_image;?>');
									  var completed       = '0%';
									  //Progress bar
									  progressbar.width(percentComplete + '%') //update progressbar percent complete
									  statustxt.html(percentComplete + '%'); //update status text
									  if(percentComplete>50)
										  {
											  statustxt.css('color','#fff'); //change status text to white after 50%
											  
										  }
								  }
                                </script>
								<style>
								#progressbox<?php echo $my_image;?> {
									border: 1px solid #92C8DA;
									padding: 1px; 
									position:relative;
									width:400px;
									border-radius: 3px;
									margin: 10px;
									display:none;
									text-align:left;
								}
								#progressbar<?php echo $my_image;?> {
									height:20px;
									border-radius: 3px;
									background-color: #77E0FA;
									width:1%;
								}
								#statustxt<?php echo $my_image;?> {
									top:3px;
									left:50%;
									position:absolute;
									display:inline-block;
									color: #000000;
								}
								</style>
                              <td class="<?php echo 'uploaded_td'.$my_image?>">
                                  <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            if($filed=='PM_Form_with_Customer_Signature_Page_2' || $filed=='PM_Form_with_Customer_Signature_Page_3' || $filed=='PM_Form_with_Customer_Signature_Page_4' || $filed=='Print_out_of_Reagent_Consumption_for_the_last_01_month_Page_2' || $filed=='Full_System_Check_Results_Page_2' || $filed=='DC_of_any_spare_parts_changed')
											{
												echo '<span class="label label-sm label-warning"> Not Uploaded </span>';
												echo '<input type="hidden" class="uploaded_not_uploaded" value="uploaded">';
											}
											else
											{
												echo '<span class="label label-sm label-warning"> Not Uploaded </span>';
												echo '<input type="hidden" class="uploaded_not_uploaded" value="not_uploaded">';
											}
                                        }
                                        else
                                        {
                                            echo '<span class="label label-sm label-success"> Uploaded </span>';
											echo '<input type="hidden" class="uploaded_not_uploaded" value="uploaded">';
                                        }
                                      ?>
                              </td>           
                                                                           
                              <td class="<?php echo 'viwimage_td'.$my_image?>">
                                    <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#'.$filed.'">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#'.$filed.'">View Image</button>';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'"
												 class="btn btn-default blue-madison-stripe" target="_blank">
												View File</a>';
											}
                                        }
                                      ?>
                              </td>    
                      	</tr>
                        <?php }?>
                        
                      </tbody>
                    </table>
                    </div>
				</div>	
             </div>
			
			
            
			  </div>
            </div>
          </div>
          		<!-- END EXAMPLE TABLE PORTLET-->
          		<!---->
				<?php
			}
			if($n2sql4[0]['product_name']=='KC4D')
			{
				$fields_array = array('PM_Form_with_Customer_Signature_Page_1','DC_of_any_spare_parts_changed');
				
				?>
                <!--Show this only when Product is Access 2-->
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet box blue">
                    <div class="portlet-title">
                      <div class="caption"> <i class="fa fa-globe"></i>PM form and Supporting Documents</div>
                    </div>
                    <?php 
                        $dbqyery = $this->db->query('select * from tbl_pm_pictures where fk_complaint_id = "'.$this->uri->segment(3).'"');
                        if($dbqyery->num_rows()>0)
                        {
                            //echo "success";
                        }
                        else
                        {
                            $dbqyery = $this->db->query('insert into tbl_pm_pictures set fk_complaint_id = "'.$this->uri->segment(3).'"');
                        }
                        $dbqyery = $this->db->query('select * from tbl_pm_pictures where fk_complaint_id = "'.$this->uri->segment(3).'"');
                        $dbres=$dbqyery->result_array();
                    ?>
                    <div class="portlet-body">
                     <div class="portlet-body flip-scroll">
                        <div class="row">
                          <div class="col-md-12 ">
                            <div class="portlet-body flip-scroll">
                              <table class="table table-striped table-bordered table-hover flip-content" id="sample_8">
                                <thead>
                                  <tr>
                                      <th>
                                           Picture Name
                                      </th>
                                      <?php
										if($obj->is_allowed('Supervisor') && $get_compalaint_result[0]['status']=='Pending'){ ?>
                                      <th>
                                           Update
                                      </th>
                                      <?php }?>
                                      <th>
                                           File
                                      </th>
                                      <th>
                                           View
                                      </th>  
                                  </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($fields_array as $filed){?>
                                     <tr class="odd gradeX">
                                                                                      
                                          <td>
                                              <?php $mmy_field_name = explode ('_', $filed); 
													foreach ($mmy_field_name as $mym)
													{
														echo $mym.' ';
													}
													if($filed=='Picture_of_ISE_Maintenance_Screen' || $filed=='Picture_of_Analyzer_Maintenance_Screen')
													{
														echo ' (grid)';
													}
											  ?>
                                          </td>
                                          
                                          <?php $my_image='_'.$filed;?>
                                            <?php $image=$filed;?>
                                          <?php if($obj->is_allowed('Supervisor') && $get_compalaint_result[0]['status']=='Pending'){ ?>
                                          <td>
                                            <div id="upload-wrapper">
                                                <div align="center">
                                                    <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                                    enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                                        <input name="<?php echo $filed;?>" id="imageInput<?php echo $my_image;?>" type="file" />
                                                         <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?> ">
                                                        <input type="submit" class="btn btn-info"  id="submit-btn<?php echo $my_image;?>" value="Upload" 
                                                        onclick="return uploader_function<?php echo $my_image;?>('<?php echo $my_image;?>')" />
                                                        <img src="<?php echo base_url()?>assets/global/img/ajax-loader.gif" id="loading-img<?php echo $my_image;?>" 
                                                        style="display:none;" alt="Please Wait"/>
                                                    </form>
                                                    <div id="progressbox<?php echo $my_image;?>" style="display:none;">
                                                        <div id="progressbar<?php echo $my_image;?>"></div>
                                                        <div id="statustxt<?php echo $my_image;?>">0%</div>
                                                    </div>
                                                    <div id="output<?php echo $my_image;?>" ></div>
                                                </div>
                                            </div>
                                          </td>   
                                           <?php }?>
                                           <div id="<?php echo $filed;?>" class="modal fade" role="dialog">
                                              <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Modal Header</h4>
                                                  </div>
                                                  <div class="modal-body output<?php echo $my_image;?>">
                                                  <?php 
                                                    if($dbres[0][$filed]=='')
                                                    {
                                                        $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
                                                    }
                                                    else
                                                    {
                                                        $src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$filed];
                                                    }
                                                  ?>
                                                     <img src="<?php echo $src ;?>" class="img-responsive" />
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <script>
                                              function uploader_function<?php echo $my_image;?>(my_image)  
                                               {
                                                   var options = { 
                                                      target:   '.output'+my_image,   // target element(s) to be updated with server response 
                                                      beforeSubmit:  beforeSubmit(my_image),  // pre-submit callback 
                                                      uploadProgress: OnProgress<?php echo $my_image;?>,
                                                      success:       afterSuccess(my_image),  // post-submit callback 
                                                      resetForm: true        // reset the form after successful submit 
                                                  }; 
                                                   $('#MyUploadForm'+my_image).ajaxSubmit(options);  			
                                                      // return false to prevent standard browser submit and page navigation 
                                                      return false; 
                                               }
                                             //when upload progresses	
                                              function OnProgress<?php echo $my_image;?>(event, position, total, percentComplete)
                                              {
                                                  var progressbox     = $('#progressbox<?php echo $my_image;?>');
                                                  var progressbar     = $('#progressbar<?php echo $my_image;?>');
                                                  var statustxt       = $('#statustxt<?php echo $my_image;?>');
                                                  var completed       = '0%';
                                                  //Progress bar
                                                  progressbar.width(percentComplete + '%') //update progressbar percent complete
                                                  statustxt.html(percentComplete + '%'); //update status text
                                                  if(percentComplete>50)
                                                      {
                                                          statustxt.css('color','#fff'); //change status text to white after 50%
                                                      }
                                              }
                                            </script>
                                            <style>
                                            #progressbox<?php echo $my_image;?> {
                                                border: 1px solid #92C8DA;
                                                padding: 1px; 
                                                position:relative;
                                                width:400px;
                                                border-radius: 3px;
                                                margin: 10px;
                                                display:none;
                                                text-align:left;
                                            }
                                            #progressbar<?php echo $my_image;?> {
                                                height:20px;
                                                border-radius: 3px;
                                                background-color: #77E0FA;
                                                width:1%;
                                            }
                                            #statustxt<?php echo $my_image;?> {
                                                top:3px;
                                                left:50%;
                                                position:absolute;
                                                display:inline-block;
                                                color: #000000;
                                            }
                                            </style>
                                          <td class="<?php echo 'uploaded_td'.$my_image?>">
                                              <?php 
                                                    if($dbres[0][$image]=='')
                                                    {
                                                        echo '<span class="label label-sm label-warning"> Not Uploaded </span>';
                                                        echo '<input type="hidden" class="uploaded_not_uploaded" value="not_uploaded">';
                                                    }
                                                    else
                                                    {
                                                        echo '<span class="label label-sm label-success"> Uploaded </span>';
                                                        echo '<input type="hidden" class="uploaded_not_uploaded" value="uploaded">';
                                                    }
                                                  ?>
                                          </td>           
                                                                                       
                                          <td class="<?php echo 'viwimage_td'.$my_image?>">
                                                <?php 
                                                    if($dbres[0][$image]=='')
                                                    {
                                                        echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                                              data-toggle="modal" data-target="#'.$filed.'">View Image</button>';
                                                    }
                                                    else
                                                    {
                                                        $file_name = explode('.',$dbres[0][$image]);
                                                        if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
                                                        {
                                                            echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                                                    data-toggle="modal" data-target="#'.$filed.'">View Image</button>';
                                                        }
                                                        else
                                                        {
                                                            echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'"
                                                             class="btn btn-default blue-madison-stripe" target="_blank">
                                                            View File</a>';
                                                        }
                                                    }
                                                  ?>
                                          </td>    
                                    </tr>
                                <?php }?>
                              </tbody>
                            </table>
                          </div>
                        </div>	
                     </div>
                    </div>
                  </div>
                </div>
          		<!-- END EXAMPLE TABLE PORTLET-->
          		<!---->
				<?php
			}
		  }
   		  ?>
          <?php if($obj->is_allowed('Supervisor')){ ?>
            <form method="post" action="<?php echo base_url();?>sys/fse_pending_varification">
                <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?>" />
                <input type="submit" value="Submit for verification"  onclick="return check_uploaded()"   class="btn btn-success" />
                <input type="hidden" name="s_pm_form" value="s_pm_form" />
            </form>   
            <?php }?>      
   			<script>
			  function check_uploaded()
			  {
				  var myreturn = 'returnyes';
				  $('.uploaded_not_uploaded').each(function(){
					  if($(this).val()=='not_uploaded')
					  {
						   myreturn = 'returnno';
							event.preventDefault();
							alert('All images are Not uploaded');
							return false;
					  }
				  });
				  status = '<?php echo $get_compalaint_result[0]['status'];?>';
				  if(status !='Pending')
				  {
					  alert('Current Status is Not Pending, You are Not Allowed to Submit!');
					  return false;
				  }
				  // Start date should be changed.
				  var start_date = $('.start_date').val();
				  //var db_reporting_date = <?php echo $get_compalaint_result[0]['reporting_date'];?>
				  var invalid_date = '30-Nov--0001';
				  if(start_date == invalid_date )
				  {
					   alert('Start Date Not Updated!'+ start_date);
					  return false;
				  }
				  // Start time should be changed.
				  var start_time = $('.start_time').val();
				  if(start_time=='0:00')
				  {
					   alert('Start Time Not Updated!');
					  return false;
				  }
				  // Other Detail should be filled.
				  $('.otherdetailstextfield').each(function(){
					  if($(this).val()=='')
					  {
							event.preventDefault();
							alert('All feilds of Other Datails Not Filled.');
							return false;
					  }
				  });
			  }
			  //
			  function donotsubmit()
			  {
				  alert('status is not pending');
				  return false; 
			  }
			  </script>
        </div>
      </div>
      <!-- END PAGE CONTENT--> 
  <!-- END CONTENT --> 
</div>

<script type="text/javascript">
  $(function() {
	$('.timepicker-24').timepicker({
                autoclose: true,
                minuteStep: 5,
                showSeconds: false,
                showMeridian: false
            });
  });
  
  
</script>
<!-- END CONTAINER --> 
<?php $this->load->view('footer');?>