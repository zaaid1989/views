<?php $this->load->view('header.php');?>
          <!-- BEGIN PAGE HEADER-->
          <h3 class="page-title"> Explanation Calls <small>View</small> </h3>
          <div class="page-bar">
            <ul class="page-breadcrumb">
              <li>
                  <i class="fa fa-home"></i>
                  Home 
                  <i class="fa fa-angle-right"></i>
              </li>
              <li>
                  All Explanation Calls
              </li>
            </ul>
          </div>
		  
		  <?php 
                        if(isset($_GET['msg']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Fine Added Successfully.  
                                    </div>';
                            }
						if(isset($_GET['msg_update']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Fine Updated Successfully.  
                                    </div>';
                            }
						if(isset($_GET['del']))
                            { 
                              echo '<div class="alert alert-success alert-dismissable">  
                                      <a class="close" data-dismiss="alert">×</a>  
                                      Fine Deleted Successfully.  
                                    </div>';
                            }
							
                        ?>
          <!-- END PAGE HEADER--> 
		<?php 
		$maxqu = $this->db->query("SELECT * FROM user WHERE id='".$this->session->userdata('userid')."'");
		$maxval=$maxqu->result_array();
		$sap_supervisor = $maxval[0]['sap_supervisor'];
		
		for ($i=1;$i<=3;$i++) { 
			if ($i==1 || ($i==2 && $this->session->userdata('userrole')=='Supervisor' ) || ($i==3 && $sap_supervisor =="1" )) {
		?>
          <!-- BEGIN PAGE CONTENT-->
          <div class="row">
            <div class="col-md-12"> 
			
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet box red">
                <div class="portlet-title">
                  <div class="caption"> <i class="fa fa-globe"></i><?php if ($i==2) echo "Territory Explanation Calls"; else echo "Explanation Calls"; ?> </div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
                <div class="portlet-body">
                  <div class="table-toolbar">
                      
						<?php
						if($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin' || ($this->session->userdata('userrole')=='Supervisor' && $i==2) || ($sap_supervisor =="1" && $i==3))
							{ ?>
								<div class="row">
                                <div class="col-md-6">
                                  <div class="btn-group">
                                    <a href="<?php echo base_url();?>sys/fine" id="sample_editable_1_new" class="btn blue-steel"> 
                              Add New Explanation Call &nbsp;<i class="fa fa-plus"></i> 
									</a>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  
                                </div>
                              </div>
						<?php	}
							else {  ?>
							<div class="note note-active">
							<h3>
							<label class="label bg-blue">Note: Enter your comments/ justification against your pending Explanation Calls</label>
							</h3>
							</div>
								
						<?php	}

						?>
							
						
                    <!--<div class="row">
                      <div class="col-md-6">
                        <div class="btn-group">
                          <a href="<?php echo base_url();?>sys/fine" id="sample_editable_1_new" class="btn green"> 
                              Add New Fine &nbsp;<i class="fa fa-plus"></i> 
                          </a>
                        </div>
                      </div>
                      
                    </div>-->
                  </div>
                  <div class="portlet-body flip-scroll">
                   <table class="table table-striped table-bordered table-hover flip-content dataaTable<?php echo $i; ?>" id="">
                    <thead class="bg-grey-cascade">
					<tr>
					<th>  		</th>
                        <th>  		</th>
                        <th>  			</th>
                        <th>  			</th>
                        <th>  				</th>
                        <th> 			</th>
                        <th> 	</th>
                        <th> 			 	</th>
						<?php if ($i!=2 && $i!=3) { ?>
                        <th> 			 	</th>
						<?php } ?>
                      </tr>
                      <tr>
						<th> Office </th>
                        <th> Employee Name 		</th>
                        <th> Code 			</th>
                        <th> Amount 			</th>
                        <th> Date 				</th>
                        <th> Official Comments			</th>
                        <th> Employee Comment	</th>
                        <th> Status			 	</th>
						<?php if ($i!=2 && $i!=3) { ?>
                        <th> Actions			 	</th>
						<?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                            $myquery="select * from tbl_fine";
							if($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin' )
							{
								$myquery.="";
							}
							else
							{
								$myquery.="  where fk_employee_id =  '".$this->session->userdata('userid')."'";
							}
							$myquery.=" order by pk_fine_id DESC";
							
							if ($i==2) {
								$myquery="select * from tbl_fine WHERE fk_employee_id IN (SELECT id FROM user WHERE delete_status=0 AND userrole='FSE' AND  FIND_IN_SET_X('".$this->session->userdata('territory')."',fk_office_id))";
								$myquery.=" order by pk_fine_id DESC";
							}
							
							if ($i==3) {
								$myquery="select * from tbl_fine WHERE fk_employee_id IN (SELECT id FROM user WHERE delete_status=0 AND userrole='Salesman' AND sap_supervisor='0' AND  FIND_IN_SET_X('".$this->session->userdata('territory')."',fk_office_id))";
								if ($this->session->userdata('territory')=='1') {
									//$myquery="select * from tbl_fine WHERE fk_employee_id IN (SELECT id FROM user WHERE delete_status=0 AND userrole='Salesman' AND sap_supervisor='0' AND fk_office_id IN ('1','5'))";
								}
								$myquery.=" order by pk_fine_id DESC";
							}
							$ty22=$this->db->query($myquery);
                            $rt22=$ty22->result_array();
                            if (sizeof($rt22) == "0") {
                                
                            } else {
                                foreach ($rt22 as $get_users_list) {
									
									
                                    ?>
                                    <tr class="odd gradeX">
									
										<td>
                                            <?php 
                                            $ty44=$this->db->query("select COALESCE(GROUP_CONCAT(tbl_offices.office_name SEPARATOR ', ')) AS office_name,COALESCE(user.first_name) AS first_name,COALESCE(tbl_fine_code.description) AS code_description 
											from tbl_fine 
											LEFT JOIN user ON user.id = tbl_fine.fk_employee_id
											LEFT JOIN tbl_offices ON FIND_IN_SET(tbl_offices.pk_office_id,user.fk_office_id)
											LEFT JOIN tbl_fine_code ON tbl_fine.fk_fine_code_id = tbl_fine_code.pk_fine_code_id
											where pk_fine_id =  '".$get_users_list["pk_fine_id"]."' GROUP BY user.id ORDER BY  `fk_office_id` ,  `userrole` ASC 
											");
											$rt44=$ty44->result_array();
											echo $rt44[0]["office_name"]; // OFFICE NAME
											?>
                                        </td>
                                        
                                        <td>
                                            <?php 
                                           // $ty44=$this->db->query("select * from user where id =  '".$get_users_list["fk_employee_id"]."' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
											//$rt44=$ty44->result_array();
											echo $rt44[0]["first_name"]; // FIRST NAME
											?>
                                        </td>
                                        <td>
                                             <?php 
											if($get_users_list["fk_fine_code_id"]!='Leave is taken within limit of 21 days')
											 {
											//	$ty44=$this->db->query("select * from tbl_fine_code where pk_fine_code_id =  '".$get_users_list["fk_fine_code_id"]."'");
												$rt44=$ty44->result_array();
												echo '<span data-toggle="tooltip" title="'.$get_users_list["z"].'">';
												echo substr($rt44[0]["code_description"], 0, 80); // FINE CODE
												echo "</span>";
											 }
											 else
											 {
												 echo 'Leave is taken within limit of 21 days';
											 }
											?>
                                        </td>
                                        
                                        <td>
                                            <?php echo $get_users_list["amount"];?>
                                        </td>
                                        <td>
                                            <?php echo date('d-M-Y', strtotime($get_users_list["date"]));?>
                                        </td>
                                       <td>
                                            <?php echo urldecode($get_users_list["comments"]);?>
                                        </td>
                                        <td>
                                            <?php echo urldecode($get_users_list["comments_employee"]);?>
                                        </td>
                                        <td>
                                            <?php echo urldecode($get_users_list["status"]);?>
                                        </td>
									<?php if ($i!=2 && $i!=3) { ?>
                                        <td>
                                            <a class="btn btn-sm default blue-steel"  
                                            href="<?php echo base_url();?>sys/update_fine/<?php echo $get_users_list["pk_fine_id"];?>">
                                              Update <i class="fa fa-edit"></i>
                                            </a>
											<?php 
												if ($this->session->userdata('userrole')=='secratery' || $this->session->userdata('userrole')=='Admin')
												{
											?>
                                            <a class="btn btn-sm default red-thunderbird" onClick="return confirm('Are you sure you want to delete?')" 
                                            href="<?php echo base_url();?>sys/delete_fine/<?php echo $get_users_list["pk_fine_id"];?>">
                                              Delete &nbsp;&nbsp;<i class="fa fa-trash-o"></i>
                                            </a>
												<?php } ?>
                                        </td>
									<?php } ?>
                                    </tr>
                                    <?php
                                }
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
		  <?php } ?> 
        <?php } ?>  
          
      </div>
  </div>
  <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer.php');?>

         <script>
		 
		 $(document).ready(function() { 
			var table = $('.dataaTable1').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 4, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
								{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
						]

		});
		
		var table = $('.dataaTable2').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 4, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            {type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
						]

		});
		
		 /* var table = $('#DataTables_Table_1').dataTable({
			  'iDisplayLength': 1000,
			  'order': [[ 3, "desc" ]]
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
					            { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
						]

		});*/
		
		
});
</script>