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
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr><th>Attribute</th><th>Value</th></tr>
                            </thead>
                            <tbody>
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
                                        Date
                                     </td>
                                     <td> <?php echo date('d-M-Y', strtotime($get_compalaint_result[0]['reporting_date']));  ?>
                                                                                             </td>
                               </tr>
                               
                               <tr class="odd gradeX">
                                      <td>
                                        Start Time
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['reporting_time'];  ?>
                                                                                             </td>
                               </tr>
                               <tr class="odd gradeX">
                                      <td>
                                      Caller Name
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['caller_name'];  ?>
                                     </td>
                               </tr>
                               <?php    
								  $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
								  if($nsql3->num_rows()>0)
									  {
										$n2sql3=$nsql3->result_array();
										
										$nsql4=$this->db->query("select * from tbl_products where pk_product_id ='".$n2sql3[0]['fk_product_id']."'");
										$n2sql4=$nsql4->result_array();
										if($n2sql4[0]['product_name']=='AU400' || $n2sql4[0]['product_name']=='AU480')
										{
											?>
                                               <tr class="odd gradeX">
                                                      <td>
                                                      Counter in Front of Equipment
                                                     </td>
                                                     <td> <?php echo $get_compalaint_result[0]['cont_run_after'];  ?>
                                                     </td>
                                               </tr>
                                     <?php }
									  }?>
                               
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
                                   Solution Date  
                                 </td>
                                 <td>
                                  <?php echo date('d-M-Y', strtotime($get_compalaint_result[0]['solution_date']));  ?>
                                 </td>
                           </tr>
						   
                           <tr class="odd gradeX">
                                  <td>
                                  Finish Time
                                 </td>
                                 <td>
                                  <?php echo $get_compalaint_result[0]['solution_time'];  ?>
                                 </td>
                           </tr>
                             <tr class="odd gradeX">
                                      <td>
                                      Mobile Number of Customer Signing PM Form
                                     </td>
                                     <td> <?php echo $get_compalaint_result[0]['phone'];  ?>
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
                            
							<div class="form-group">
							<label class="col-md-4 control-label">Start Time:</label>
								<div class="col-md-4">
									<input type="text" class="datepicker2 form-control" name="start_time" value="">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Finish Time:</label>
								<div class="col-md-4">
									<input type="text" class="form-control datepicker2" name="finish_time" value="">
								</div>
							</div>
                            
                            <div class="form-group">
							<label class="col-md-4 control-label">Name of Customer Signing PM Form:</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="name_of_customer_sign_pm_form" value="">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-md-4 control-label">Mobile Number of Customer Signing PM Form:</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="mobile_no_of_customer_sign_pm_form" value="">
								</div>
							</div>
                            <?php    
							  $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
							  if($nsql3->num_rows()>0)
								  {
									$n2sql3=$nsql3->result_array();
									
									$nsql4=$this->db->query("select * from tbl_products where pk_product_id ='".$n2sql3[0]['fk_product_id']."'");
									$n2sql4=$nsql4->result_array();
									if($n2sql4[0]['product_name']=='AU400' || $n2sql4[0]['product_name']=='AU480')
									{
										?>
                                        <div class="form-group">
                                        <label class="col-md-4 control-label">Counter in Front of Equipment:</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="counter_in_front_of_equipment" value="">
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
										<?php
									}
								  }
						   ?>
                            <input type="submit" value="Submit"  class="btn btn-success" />
                            </form>
							
							
							
							
                          </div>
                        </div>

				</div>
				
            </div>

          </div>

          <!-- END EXAMPLE TABLE PORTLET-->
          
          <script src="<?php echo base_url();?>assets/global/plugins/jquery.form.min.js" type="text/javascript"></script>
		  <script type="text/javascript">
          //after succesful upload
          function afterSuccess(my_image)
          {
              $('#submit-btn'+my_image).show(); //hide submit button
              $('#loading-img'+my_image).hide(); //hide submit button
          
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
                  
                  //Allowed file size is less than 1 MB (1048576)
                  if(fsize>1048576) 
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
			if($n2sql4[0]['product_name']=='AU400' || $n2sql4[0]['product_name']=='AU480')
			{
				$fields_array = array('picture_of_photocal','myname','Picture_of_Reagent_Management','Picture_of_Calibration_display_the_ISE_Maintenance','Picture_of_Selectivity_Check','_Picture_of_ISE_Maintenance_Screen','Picture_of_Analyzer_Maintenance_Screen','Print_out_of_Reagent_Consumption_for_the_last_01_month','Picture_of_Counter_in_the_Front_Lower_Right_Side_of_the_Analyzer','PM_Form_with_Customer_Signature','DC_of_any_spare_parts_changes');
			}
		  }
          
     
      $nsql3=$this->db->query("select * from tbl_instruments where pk_instrument_id ='".$get_compalaint_result[0]['fk_instrument_id']."'");
      if($nsql3->num_rows()>0)
		  {
			$n2sql3=$nsql3->result_array();
			
			$nsql4=$this->db->query("select * from tbl_products where pk_product_id ='".$n2sql3[0]['fk_product_id']."'");
			$n2sql4=$nsql4->result_array();
			if($n2sql4[0]['product_name']=='AU400' || $n2sql4[0]['product_name']=='AU480')
			{
				?>
                <!--Show this only when Product is Access 2-->
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Pictures</div>
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
                      <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                        <thead>
                          <tr>
                              
                              <th>
                                   Picture Name
                              </th>
                              <?php
								if($obj->is_allowed('FSE')){ ?>
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
                         <tr class="odd gradeX">
                                                                          
                              <td>
                                  Picture of Photocal
                              </td>
                              <!--<td>
                                  <input type="file" name="picture_of_photocal" />
                              </td>-->
                              <!--Ajax loader-->
                              
                              <?php $my_image='_picture_of_photocal';?>
                                <?php $image='picture_of_photocal';?>
                              <?php if($obj->is_allowed('FSE')){ ?>
                              <td>
                          
                          		
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="picture_of_photocal" id="imageInput<?php echo $my_image;?>" type="file" />
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
                               <div id="picture_of_photocal" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0]['picture_of_photocal']=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
                                        }
                                        else
                                        {
                                            $src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0]['picture_of_photocal'];
                                        }
                                      ?>
                                         <img src="'.$src.'" class="img-responsive" />
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
                              <td>
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
                                                                           
                              <td>
                                    <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#picture_of_photocal">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#picture_of_photocal">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                         
                              <td>
                                  Picture of Reagent Management (In Reagent Display select TEST)
                              </td>
                               <?php $my_image='_Picture_of_Reagent_Management';?>
                                  <?php $image='Picture_of_Reagent_Management';?>
                               <?php if($obj->is_allowed('FSE')){ ?>
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="Picture_of_Reagent_Management" id="imageInput<?php echo $my_image;?>" type="file" />
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
                               <div id="Picture_of_Reagent_Management" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0]['Picture_of_Reagent_Management']=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
                                        }
                                        else
                                        {
                                            $src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0]['Picture_of_Reagent_Management'];
                                        }
                                      ?>
                                         <img src="'.$src.'" class="img-responsive" />
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
                              <td>
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
                              <td>
                                   <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Picture_of_Reagent_Management">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Picture_of_Reagent_Management">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                         
                              <td>
                                  Picture of Calibration display the "ISE Maintenance: Calibration tab" screen.
                              </td>
                              
                              <?php $my_image='_Picture_of_Calibration_display_the_ISE_Maintenance';?>
                                  <?php $image='Picture_of_Calibration_display_the_ISE_Maintenance';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                   <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Picture_of_Calibration_display_the_ISE_Maintenance">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Picture_of_Calibration_display_the_ISE_Maintenance">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                        
                              <td>
                                  Picture of Selectivity Check  
                              </td>
                              <?php $my_image='_Picture_of_Selectivity_Check';?>
                                  <?php $image='Picture_of_Selectivity_Check';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                  <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Picture_of_Selectivity_Check">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Picture_of_Selectivity_Check">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                          
                              <td>
                                  Picture of ISE Maintenance Screen
                              </td>
                              <?php $my_image='_Picture_of_ISE_Maintenance_Screen';?>
                                  <?php $image='Picture_of_ISE_Maintenance_Screen';?>
							  <?php if($obj->is_allowed('FSE')){ ?> 
                               
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                  <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Picture_of_ISE_Maintenance_Screen">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Picture_of_ISE_Maintenance_Screen">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                       
                              <td>
                                  Picture of Analyzer Maintenance Screen 
                              </td>
                              <?php $my_image='_Picture_of_Analyzer_Maintenance_Screen';?>
                                  <?php $image='Picture_of_Analyzer_Maintenance_Screen';?>
							  <?php if($obj->is_allowed('FSE')){ ?> 
                               
                              <td>
                                 
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                  <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Picture_of_Analyzer_Maintenance_Screen">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Picture_of_Analyzer_Maintenance_Screen">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                      
                              <td>
                                  Print out of Reagent Consumption for the last 01 month
                              </td>
                              <?php $my_image='_Print_out_of_Reagent_Consumption_for_the_last_01_month';?>
                                  <?php $image='Print_out_of_Reagent_Consumption_for_the_last_01_month';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                    <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Print_out_of_Reagent_Consumption_for_the_last_01_month">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Print_out_of_Reagent_Consumption_for_the_last_01_month">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                       
                              <td>
                                  Picture of Counter in the Front Lower Right Side of the Analyzer
                              </td>
                              <?php $my_image='_Picture_of_Counter_in_the_Front_Lower_Right_Side_of_the_Analyzer';?>
                                  <?php $image='Picture_of_Counter_in_the_Front_Lower_Right_Side_of_the_Analyzer';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                  <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Picture_of_Counter_in_the_Front_Lower_Right_Side_of_the_Analyzer">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Picture_of_Counter_in_the_Front_Lower_Right_Side_of_the_Analyzer">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                      
                              <td>
                                  PM Form with Customer Signature – Attach File
                              </td>
                              
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <?php $my_image='_PM_Form_with_Customer_Signature';?>
                                  <?php $image='PM_Form_with_Customer_Signature';?>
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                  <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#PM_Form_with_Customer_Signature">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#PM_Form_with_Customer_Signature">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                    
                              <td>
                                  DC of any spare parts changes – Attach File
                              </td>
                              <?php $my_image='_DC_of_any_spare_parts_changes';?>
                                  <?php $image='DC_of_any_spare_parts_changes';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                  <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#DC_of_any_spare_parts_changes">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#DC_of_any_spare_parts_changes">View Image</button>';
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
				?>
                <!--Show this only when Product is Access 2-->
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i>Pictures Access 2</div>
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
                      <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                        <thead>
                          <tr>
                              
                              <th>
                                   Picture Name
                              </th>
                              <?php
										if($obj->is_allowed('FSE')){ ?>
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
                        
                        
                        <tr class="odd gradeX">
                                                                          
                              <td>
                                  Temperature Report
                              </td>
                              <?php $my_image='_Temperature_Report';?>
                                  <?php $image='Temperature_Report';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <td>
                                   
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                  <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Temperature_Report">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Temperature_Report">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                          
                              <td>
                                  Level Sense Test Report
                              </td>
                              <?php $my_image='_Level_Sense_Test_Report';?>
                                  <?php $image='Level_Sense_Test_Report';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <td>
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                    <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Level_Sense_Test_Report">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Level_Sense_Test_Report">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                          
                              <td>
                                  Full System Check Results
                              </td>
                              <?php $my_image='_Full_System_Check_Results';?>
                                  <?php $image='Full_System_Check_Results';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
                                         
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
                              <td>
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
                              <td>
                                    <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Full_System_Check_Results">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Full_System_Check_Results">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                          
                              <td>
                                  Picture of Total Tests performed in last 30 days
                              </td>
                              <?php $my_image='_Picture_of_Total_Tests_performed_in_last_30_days';?>
                                  <?php $image='Picture_of_Total_Tests_performed_in_last_30_days';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                    <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#Picture_of_Total_Tests_performed_in_last_30_days">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#Picture_of_Total_Tests_performed_in_last_30_days">View Image</button>';
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
                        
                        <tr class="odd gradeX">
                                                                          
                              <td>
                                  PM Form with Customer Signature – Attach File
                              </td>
                              <?php $my_image='_PM_Form_with_Customer_Signature';?>
                                  <?php $image='PM_Form_with_Customer_Signature';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <td>
                                  
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                    <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#PM_Form_with_Customer_Signature">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#PM_Form_with_Customer_Signature">View Image</button>';
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
                        <tr class="odd gradeX">
                                                                          
                              <td>
                                  DC of any spare parts changes – Attach File
                              </td>
                               <?php $my_image='DC_of_any_spare_parts_changes';?>
                                  <?php $image='DC_of_any_spare_parts_changes';?>
                              <?php if($obj->is_allowed('FSE')){ ?> 
                              <td>
                                 
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                        enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                        <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                              <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                      </div>
                                      <div class="modal-body output<?php echo $my_image;?>">
                                      <?php 
                                        if($dbres[0][$image]=='')
                                        {
                                            $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
											echo '<img src="'.$src.'" class="img-responsive" />';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												$src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
												echo '<img src="'.$src.'" class="img-responsive" />';
											}
											else
											{
												echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
												Download File</a>';
											}
                                        }
                                      ?>
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
                              <td>
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
                              <td>
                                    <?php 
                                        if($dbres[0][$image]=='')
                                        {
											echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   				  data-toggle="modal" data-target="#DC_of_any_spare_parts_changes">View Image</button>';
                                        }
                                        else
                                        {
                                            $file_name = explode('.',$dbres[0][$image]);
											if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
											{
												echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                   						data-toggle="modal" data-target="#DC_of_any_spare_parts_changes">View Image</button>';
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
				?>
                <!--Show this only when Product is Access 2-->
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet box blue">
                    <div class="portlet-title">
                      <div class="caption"> <i class="fa fa-globe"></i>Pictures KC4D</div>
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
                              <table class="table table-striped table-bordered table-hover flip-content" id="sample_2">
                                <thead>
                                  <tr>
                                      <th>
                                           Picture Name
                                      </th>
                                      <?php
										if($obj->is_allowed('FSE')){ ?>
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
                                
                                <tr class="odd gradeX">
                                                                                 
                                      <td>
                                          PM Form with Customer Signature – Attach File
                                      </td>
                                      <?php $my_image='_PM_Form_with_Customer_Signature';?>
                                          <?php $image='PM_Form_with_Customer_Signature';?>
                                      <?php if($obj->is_allowed('FSE')){ ?>
                                      <td>
                                          
                                        <div id="upload-wrapper">
                                            <div align="center">
                                                <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                                enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                                <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                                      <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Modal Header</h4>
                                              </div>
                                              <div class="modal-body output<?php echo $my_image;?>">
                                              <?php 
                                                if($dbres[0][$image]=='')
                                                {
                                                    $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
                                                    echo '<img src="'.$src.'" class="img-responsive" />';
                                                }
                                                else
                                                {
                                                    $file_name = explode('.',$dbres[0][$image]);
                                                    if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
                                                    {
                                                        $src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
                                                        echo '<img src="'.$src.'" class="img-responsive" />';
                                                    }
                                                    else
                                                    {
                                                        echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
                                                        Download File</a>';
                                                    }
                                                }
                                              ?>
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
                                      <?php }?>
                                      <td>
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
                                      <td>
                                            <?php 
                                                if($dbres[0][$image]=='')
                                                {
                                                    echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                                          data-toggle="modal" data-target="#PM_Form_with_Customer_Signature">View Image</button>';
                                                }
                                                else
                                                {
                                                    $file_name = explode('.',$dbres[0][$image]);
                                                    if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
                                                    {
                                                        echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                                                data-toggle="modal" data-target="#PM_Form_with_Customer_Signature">View Image</button>';
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
                                <tr class="odd gradeX">
                                                                                 
                                      <td>
                                          DC of any spare parts changes – Attach File
                                      </td>
                                       <?php $my_image='_DC_of_any_spare_parts_changes';?>
                                          <?php $image='DC_of_any_spare_parts_changes';?>
                                      <?php if($obj->is_allowed('FSE')){ ?>
                                      <td>
                                        <div id="upload-wrapper">
                                            <div align="center">
                                                <form action="<?php echo base_url();?>sys/pm_pictures_update" onSubmit="return false" method="post" 
                                                enctype="multipart/form-data" id="MyUploadForm<?php echo $my_image;?>">
                                                <input name="<?php echo $image;?>" id="imageInput<?php echo $my_image;?>" type="file" />
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
                                         <div id="<?php echo $image;?>" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Modal Header</h4>
                                              </div>
                                              <div class="modal-body output<?php echo $my_image;?>">
                                              <?php 
                                                if($dbres[0][$image]=='')
                                                {
                                                    $src = base_url().'usersimages/complaint_images/800px-No_Image_Wide.svg.png';
                                                    echo '<img src="'.$src.'" class="img-responsive" />';
                                                }
                                                else
                                                {
                                                    $file_name = explode('.',$dbres[0][$image]);
                                                    if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
                                                    {
                                                        $src = base_url().'usersimages/complaint_images/pm_form/'. $this->uri->segment(3).'/'.$dbres[0][$image];
                                                        echo '<img src="'.$src.'" class="img-responsive" />';
                                                    }
                                                    else
                                                    {
                                                        echo '<a href="'.base_url().'usersimages/complaint_images/pm_form/'.$this->uri->segment(3).'/'.$dbres[0][$image].'">
                                                        Download File</a>';
                                                    }
                                                }
                                              ?>
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
                                      <td>
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
                                      <td>
                                            <?php 
                                                if($dbres[0][$image]=='')
                                                {
                                                    echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                                          data-toggle="modal" data-target="#DC_of_any_spare_parts_changes">View Image</button>';
                                                }
                                                else
                                                {
                                                    $file_name = explode('.',$dbres[0][$image]);
                                                    if($file_name[1]=='png' || $file_name[1]=='gif' || $file_name[1]=='jpeg' || $file_name[1]=='jpg')
                                                    {
                                                        echo '<button type="button" class="btn btn-default blue-madison-stripe"
                                                                data-toggle="modal" data-target="#DC_of_any_spare_parts_changes">View Image</button>';
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
          
          
		  
		  
		    <?php if($obj->is_allowed('FSE')){ ?>
            <form method="post" action="<?php echo base_url();?>sys/fse_pending_varification">
                <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?>" />
                <input type="submit" value="Submit for verification"  onclick="return check_uploaded()"   class="btn btn-success" />
            </form>   
            <?php }?>
            <?php if($obj->is_allowed('Supervisor')){ ?>
            <form method="post" action="<?php echo base_url();?>sys/supervisor_mark_completed">
                <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?>" />
                <input type="submit" value="Mark Completed" onclick="return check_uploaded()"  class="btn btn-success" />
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
						}
						</script>
        </div>
      </div>
      <!-- END PAGE CONTENT--> 

  <!-- END CONTENT --> 

</div>


<!-- END CONTAINER --> 
<?php $this->load->view('footer');?>