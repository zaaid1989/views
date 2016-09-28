<?php $this->load->view('header');?>

      <!-- BEGIN PAGE HEADER-->

      <h3 class="page-title"> PEF <small>Director View</small> </h3>

      <div class="page-bar">

        <ul class="page-breadcrumb">

          <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>

          <li> PEF <i class="fa fa-angle-right"></i> </li>

          

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

          <!-- BEGIN EXAMPLE TABLE PORTLET-->

          <div class="portlet box grey-cascade">

            <div class="portlet-title">

              <div class="caption"> <i class="fa fa-globe"></i>Managed Table </div>

              <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

            </div>

            <div class="portlet-body">

              <div class="table-toolbar">

              </div>

            <div class="portlet-body flip-scroll">
                            
                            

             <table class="table table-striped table-bordered table-hover flip-content">

                <thead>

                  <tr>
                    
                    <th> Employee Name </th>
                  
                    <th> Last PEF Date </th>
                    
                    <th> PEF Final Marks </th>

                    <th> Next PEF Due Date</th>
                    
                    <th> Status </th>
                    
                    <th> Open Form </th>

                   

                  </tr>

                </thead>

                <tbody>
				  <?php 
					$myquery=$this->db->query("select * from user where id='".$this->session->userdata('userid')."'");
					$result=$myquery->result_array();
					//
					$rty3="select * from tbl_pef_schedule";
					$myquery3=$this->db->query($rty3);
					$result3=$myquery3->result_array();
					//
					$rty="select * from user where fk_office_id='".$result[0]['fk_office_id']."' ORDER BY  `fk_office_id` ,  `userrole` ASC ";
					//echo $rty;
					$myquery2=$this->db->query($rty);
					$result2=$myquery2->result_array();
					foreach($result2 as $engineer)
					{
					?>
                	<tr class="odd gradeX">
                  
                    <td> <?php echo $engineer['first_name'];?> </td>

                    <td> <?php echo date('d-M-Y', strtotime($result3[0]['last_due_date']));?> </td>
                    
                    <td> 85% </td>
                   
                    <td> <?php echo date('d-M-Y', strtotime($result3[0]['next_due_date']));?> </td>
                    
					<?php
					$rty4="SELECT * FROM  `tbl_pef` where `fk_engineer_id`='".$engineer['id']."' ";
					$myquery4=$this->db->query($rty4);
					$rows=$myquery4->num_rows();
					?>
                    <td>
						<?php if($rows=='0'){?><span class="label label-sm label-info"> Pending for NMTS </span><?php }?>
                        <?php if($rows=='1'){?><span class="label label-sm label-success"> Pending for Supervisor </span><?php }?>
                        <?php if($rows=='2'){?><span class="label label-sm label-warning"> Pending for Director </span><?php }?>
                    </td>

                    <td> <a href="<?php echo base_url();?>complaint/pef_employee/<?php echo $engineer['id'];?>" class="btn btn-default">PEF Form</a> </td>

                  </tr>
          		<?php 
		  			}
					?>
                  

                  
                </tbody>

              </table>

            			</div>

            </div>

          </div>

          <!-- END EXAMPLE TABLE PORTLET--> 

        </div>

      </div>

      

      <!-- END PAGE CONTENT--> 

    </div>

  </div>

  <!-- END CONTENT --> 

  <!-- BEGIN QUICK SIDEBAR --> 

  <!-- END QUICK SIDEBAR --> 

</div>

<!-- END CONTAINER --> 
<?php $this->load->view('footer');?>