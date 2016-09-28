<?php $this->load->view('header.php');?>
<h3 class="page-title"> Spare Parts Requisition Form <small>form layouts</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> <a href="index.html">Home</a> <i class="fa fa-angle-right"></i> </li>

          <li> <a href="#">Form Stuff</a> <i class="fa fa-angle-right"></i> </li>

          <li> <a href="#">Form Layouts</a> </li>

        </ul>

        <div class="page-toolbar">

          <div class="btn-group pull-right">

            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true"> Actions <i class="fa fa-angle-down"></i> </button>

            <ul class="dropdown-menu pull-right" role="menu">

              <li> <a href="#">Action</a> </li>

              <li> <a href="#">Another action</a> </li>

              <li> <a href="#">Something else here</a> </li>

              <li class="divider"> </li>

              <li> <a href="#">Separated link</a> </li>

            </ul>

          </div>

        </div>

      </div>

      <!-- END PAGE HEADER--> 

      <!-- BEGIN PAGE CONTENT-->

      <div class="row">

        <div class="col-md-12">

          <div class="tabbable tabbable-custom boxless tabbable-reversed">

            <ul class="nav nav-tabs">

              <li class="active"> <a href="#tab_0" data-toggle="tab"> Form Actions </a> </li>

            </ul>

            <div class="tab-content">

              <div class="tab-pane active" id="tab_0">

                <div class="portlet box green">

                  <div class="portlet-title">

                    <div class="caption"> <i class="fa fa-gift"></i>Form Actions On Bottom </div>

                    <div class="tools"> <a href="javascript:;" class="collapse"> </a>  <a href="javascript:;" class="remove"> </a> </div>

                  </div>
                  <?php
						foreach ($get_complaint_list as $k ) {
							$ts_number				 = 	$k['ts_number'];
							$date 					 =	$k['date'];
							$caller_name 			 = 	$k['caller_name'];
							$customer 				 = 	$k['customer'];
							$city 					 = 	$k['fk_city_id'];
							$instrument_name 		 = 	$k['instrument_name'];
							$instrument_serial_no 	 = 	$k['instrument_serial_no'];
						}
						
				  ?>

                  <div class="portlet-body form"> 

                    <!-- BEGIN FORM-->

                    <form action="<?php echo base_url();?>complaint/submit_sprf_approve" method="post" class="form-horizontal">

                      <div class="form-body">

                        <div class="form-group">

                          <label class="col-md-3 control-label">TS Number</label>

                          <div class="col-md-4">

                            <input type="text" class="form-control " value="<?php echo $ts_number;?>" readonly name="ts_number" >

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="col-md-3 control-label">Date(m/d/y)</label>

                          <div class="col-md-4">

                            <input type="text" class="form-control " name="spf_date" value="<?php echo date('d-M-Y', strtotime($date));?>" <?php if($get_complaint_list[0]["status"]=="Pending"){ echo "readonly"; }?> >

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="col-md-3 control-label">Assign TS Person</label>

                          <div class="col-md-4">

                            <input type="text" class="form-control " value="<?php $ty=$this->db->query("select * from user where id='".$get_complaint_list[0]["assign_to"]."'");
													  $rt=$ty->result_array();
													  echo $rt[0]["username"];
													  //echo $get_complaint_list[0]["assign_to"];?>" readonly name="assign_ts_person" >

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="col-md-3 control-label">Customer Name</label>

                          <div class="col-md-4">

                            <input type="text" class="form-control " value="<?php echo $caller_name;?>" readonly name="customer_name" >

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="col-md-3 control-label">City</label>

                          <div class="col-md-4">

                            <?php
                            	$we= $this->db->query("select * from tbl_cities where pk_city_id ='".$city."'");
								$rt=$we->result_array();
							?>
                            <input type="text" class="form-control " value="<?php echo $rt[0]['city_name'];?>" readonly name="city" >

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="col-md-3 control-label">Instrument Model</label>

                          <div class="col-md-4">

                            <input type="text" class="form-control " value="<?php echo $instrument_name;?>" readonly name="instrument_model" >

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="col-md-3 control-label">Instrument Serial #</label>

                          <div class="col-md-4">

                            <input type="text" class="form-control "  value="<?php echo $instrument_serial_no;?>" readonly name="insturment_serial_number" >

                          </div>

                        </div>

              <div class="portlet-body flip-scroll">

             <table class="table table-striped table-bordered table-hover flip-content" id="sample_1">

                <thead>

                  <tr>

                    <th> Part Number </th>

                    <th> Part Description </th>

                    <th> Quantity </th>

                    <th> Unit Price </th>

                    <th> Total </th>

                    <th> Purpose/Justification </th>

                     <th> Billing   </th>

                  </tr>

                </thead>

                <tbody class="append_tbody">

                  <?php  
						$we= $this->db->query("select * from tbl_sprf where fk_complaint_id='".$this->uri->segment(3)."' ");
						if($we->num_rows > 0)
						{
							//echo "sana";exit;
						  $rt=$we->result_array();
						  foreach($rt as $sprf)
						  {
						 ?>
                          <tr class="odd gradeX" id="rowfirst">
        
                            <td>
                            <?php
							$ghq="select * from tbl_parts where pk_part_id='".$sprf['fk_part_id']."'";
							//echo $ghq;exit;
                            $we2	= 	$this->db->query($ghq);
						    $rt2	=	$we2->result_array();
							foreach ($rt2 as $part_data)
							{
								$part_number	=	$part_data['part_number'];
								$description	=	$part_data['description'];
								$unit_price	=	$part_data['unit_price'];
							}
							?>
                               <input name="part[]" type="text" readonly="readonly" value="<?php echo $part_number;?>" class="form-control" />
                            </td>
        
                            <td>
                            <input name="part_description[0]" class="form-control description" value="<?php echo $description;?>" type="text" readonly >
                             </td>
        
                            <td> <input   name="quantity[0]" value="<?php echo $sprf['quantity'];?>" class="form-control quantity"  type="text" readonly> </td>
        
                            <td> <input  name="unit_price[0]" class="form-control unit_price"  type="text" value="<?php echo $unit_price;?>" readonly> </td>
        
                            <td> <input name="Total[0]" class="form-control " type="text" id="totalprice" value="<?php echo $sprf['billing'];?>" readonly > </td>
        
                            <td> <input name="purpose[0]" value="<?php echo $sprf['purpose'];?>" class="form-control " type="text" readonly> </td>
        
                            <td> <select id="problem_type" name="problem_type[0]" class="form-control  ">
        
                                      <option value="">--Choose--</option>
        
                                      <option value="pending" <?php if($sprf['purpose']=="Pending"){ echo"selected";}?>>Pending</option>
        
                                      <option value="foc" <?php if($sprf['purpose']=="FOC"){ echo"selected";}?>>FOC</option>
        
                                      <option value="invoice" <?php if($sprf['purpose']=="Invoice"){ echo"selected";}?>>Invoice</option>
        
                                    </select> </td>
        
                            <td> 
                             </td>
        
                          </tr>
					<?php }
                        }?>

                </tbody>

              </table>
              

                         </div>   
                       </div>

                      <div class="form-actions">

                        <div class="row">

                          <div class="col-md-offset-3 col-md-9">

                            <input type="hidden" name="complaint_id" value="<?php echo $this->uri->segment(3);?>" />
                            <button type="submit" class="btn btn-circle blue">Submit</button>

                      <!--      <button type="button" class="btn btn-circle default">Cancel</button> -->

                          </div>

                        </div>

                      </div>

                    </form>

                    <!-- END FORM--> 

                  </div>

                </div>
<div>

            </div>

          </div>

        </div>

      </div>

      <!-- END PAGE CONTENT--> 

    </div>

  </div>
 </div>

  <!-- END CONTENT --> 
<?php $this->load->view('footer.php');?>