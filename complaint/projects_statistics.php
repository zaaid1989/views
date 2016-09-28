<?php $this->load->view('header');?>
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title"> Projects Statistics <small>Employees and City Wise Statistics for Projects</small> </h3>
        <div class="page-bar">
          <ul class="page-breadcrumb">
            <li> <i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i> </li>
            <li> Projects Statistics </li>
            
          </ul>
          
        </div>
        <!-- END PAGE HEADER--> 
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
          <div class="col-md-12"> 
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <!--    <div class="portlet box green-sharp">-->
			<div class="portlet light bg-inverse">
              <div class="portlet-title">
                <div class="caption font-red-intense"> <i class="icon-bar-chart font-red-intense"></i>Projects Statistics for Employees</div>
                <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>
              </div>
              <div class="portlet-body">
                <div class="table-toolbar">
                    <?php
                        if(isset($_GET['msg']))
                          { 
                            echo '<div class="alert alert-success alert-dismissable">  
                                    <a class="close" data-dismiss="alert">×</a>  
                                    Statistic Added Successfully.  
                                  </div>';
                          }
                      ?>
                      <?php
                        if(isset($_GET['upt']))
                          { 
                            echo '<div class="alert alert-success alert-dismissable">  
                                    <a class="close" data-dismiss="alert">×</a>  
                                    User Updated Successfully.  
                                  </div>';
                          }
                      ?>
                  
                </div>
				
            	<div class="portlet-body flip-scroll">
                 <table class="table table-striped table-bordered table-hover hover flip-content" id="sample_4">
                  <thead>
                    <tr>
                      <th class="sorting bg-grey"> Employee 				</th>
                      <?php 
						$ty=$this->db->query("select * from tbl_business_types where status='0'");
						$rt=$ty->result_array();
						foreach ($rt as $category)
						{
					  ?>
                      <th class="bg-grey"> <?php echo $category['businesstype_name']?> </th>
                      <?php }?>
                      <th class="bg-grey">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                          $query=$this->db->query("select * from user WHERE delete_status = '0' ORDER BY  `fk_office_id` ,  `userrole` ASC ");
						  $query_res=$query->result_array();
                          foreach ($query_res as $get_users_list) {
                                  ?>
                                  <tr class="odd gradeX mytr_user<?php echo $get_users_list['id'];?>">
                                      
                                      <td class="bg-blue-hoki">
                                          <?php echo $get_users_list["first_name"]; ?>
                                      </td>
                                      <?php 
											$total=0;
											$ty=$this->db->query("select * from tbl_business_types where status='0'");
											$rt=$ty->result_array();
											foreach ($rt as $category)
											{
										  ?>
										  <td class="bg-red-intense"> 
										  	<?php 
												$business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."'
												AND `Sales Person` = '".$get_users_list['id']."' AND `status`='0'";
												//echo $business_data;
												$projects_query=$this->db->query($business_data);
												$projects=$projects_query->result_array();
												//echo sizeof($projects_query);
												echo $projects_query->num_rows();
												$total=$total+$projects_query->num_rows();
											?> 
                                          </td>
									  <?php }?>
                                          <td class="bg-grey-gallery"> 
										  	<?php 
												echo intval($total);
												if($total==0)
												{
													?>
													<style>
                                                    	.mytr_user<?php echo $get_users_list['id'];?>
														{
															display:none;
														}
                                                    </style>
													<?php
												}
											?> 
                                          </td>
                                  </tr>
                                  <?php
								  }
					 			  ?>
								  <tfoot>
                                  <tr class="odd gradeX grey">
                                      
                                      <td class="bg-grey-cascade">
                                          <b>Category Total</b>
                                      </td>
                                      <?php 
											$ty=$this->db->query("select * from tbl_business_types where status='0'");
											$rt=$ty->result_array();
											foreach ($rt as $category)
											{
										  ?>
										  <td class="bg-grey-cascade"> 
										  	<?php 
												$business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."' AND `status`='0'";
												//echo $business_data;
												$projects_query=$this->db->query($business_data);
												$projects=$projects_query->result_array();
												//echo sizeof($projects_query);
												echo $projects_query->num_rows();
											?> 
                                          </td>
									  <?php }?>
                                          <th class="bg-grey-gallery"> 
										  	<?php 
												$tyz=$this->db->query("select * from business_data where status='0'");
												echo $tyz->num_rows();
											?> 
                                          </th>
                                  </tr>
								</tfoot>
                  </tbody>
                </table>
               </div>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET--> 
            
            
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bg-inverse">
              <div class="portlet-title">
                <div class="caption font-green-haze"> <i class="icon-bar-chart font-green-haze"></i>Projects Statistics for Cities</div>
                <div class="tools"> 
                    <a href="javascript:;" class="collapse"> </a> 
                    
                    <a href="javascript:;" class="remove"> </a> 
                </div>
              </div>
              <div class="portlet-body">
                <div class="table-toolbar">
                  
                </div>
                
            	<div class="portlet-body flip-scroll">
                 <table class="table table-striped table-bordered table-hover flip-content" id="sample_6">
                  <thead>
                    <tr>
                      <th class="sorting bg-grey"> Cities 				</th>
                      <?php 
						$ty=$this->db->query("select * from tbl_business_types where status='0'");
						$rt=$ty->result_array();
						foreach ($rt as $category)
						{
					  ?>
                      <th class="bg-grey"> <?php echo $category['businesstype_name']?> </th>
                      <?php }?>
                      <th class="bg-grey">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                          $query=$this->db->query("select * from tbl_cities");
						  $query_res=$query->result_array();
                          foreach ($query_res as $get_users_list) {
                                  ?>
                                  <tr class="odd gradeX mytr_city<?php echo $get_users_list['pk_city_id'];?>">
                                      
                                      <td class="bg-blue-hoki">
                                          <?php echo $get_users_list["city_name"]; ?>
                                      </td>
                                      <?php 
											$total=0;
											$ty=$this->db->query("select * from tbl_business_types where status='0'");
											$rt=$ty->result_array();
											foreach ($rt as $category)
											{
										  ?>
										  <td class="bg-green-haze"> 
										  	<?php 
												$business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."'
												AND `City` = '".$get_users_list['pk_city_id']."' AND `status`='0'";
												$projects_query=$this->db->query($business_data);
												$projects=$projects_query->result_array();
												echo $projects_query->num_rows();
												$total=$total+$projects_query->num_rows();
											?> 
                                          </td>
									  <?php }?>
                                          <td class="bg-grey-gallery"> 
										  	<?php 
												echo $total;
												if($total==0)
												{
													?>
													<style>
                                                    	.mytr_city<?php echo $get_users_list['pk_city_id'];?>
														{
															display:none;
														}
                                                    </style>
													<?php
												}
											?> 
                                          </td>
                                  </tr>
                                  <?php
								  }
					 			  ?>
								  <tfoot>
                                  <tr class="odd gradeX">
                                      
                                      <td class="bg-grey-cascade">
                                          <b>Category Total</b>
                                      </td>
                                      <?php 
											$ty=$this->db->query("select * from tbl_business_types where status='0'");
											$rt=$ty->result_array();
											foreach ($rt as $category)
											{
										  ?>
										  <td class="bg-grey-cascade"> 
										  	<?php 
												$business_data="select * from business_data where `Business Project`='".$category['pk_businesstype_id']."' AND `status`='0'";
												//echo $business_data;
												$projects_query=$this->db->query($business_data);
												$projects=$projects_query->result_array();
												//echo sizeof($projects_query);
												echo $projects_query->num_rows();
											?> 
                                          </td>
									  <?php }?>
                                          <td class="bg-grey-gallery"> 
										  	<?php 
												echo $tyz->num_rows();
											?> 
                                          </td>
                                  </tr>
								  </tfoot>
                    
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
</div>
<!-- END CONTAINER -->
<script type="text/javascript">
//      $(document).ready(function() {
//        $('#sample_4').dataTable( {
//            
//			"bDestroy":true,
//			"columnDefs": [
//                { "type": "num-html", targets: 8 }
//            ]
//			
//			
//			
//        } );
//	  });
</script>
<?php $this->load->view('footer');?>



<script>

$("#sample_4 tbody").click(function(event) {
    $(oTable.fnSettings().aoData).each(function (){
        $(this.nTr).removeClass('row_selected');
    });
    $(event.target.parentNode).addClass('row_selected');
});


$("tr").not(':first').hover(
  function () {
    $(this).addClass("zClass");
  }, 
  function () {
    $(this).removeClass("zClass");
  }
);
$(document).ready(function() {
	var lastIdx = null;
    var table = $('#sample_4').DataTable();


$('#sample_4 tbody')
        .on( 'mouseover', 'td', function () {
            var colIdx = table.cell(this).index().column;
 
            if ( colIdx !== lastIdx ) {
                $( table.cells().nodes() ).removeClass( 'highlight' );
                $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
            }
        } )
        .on( 'mouseleave', function () {
            $(table.cells().nodes() ).removeClass( 'highlight' );
        } );
		
		
		var lastIdxx = null;
    var tablee = $('#sample_6').DataTable();
$('#sample_6 tbody')
        .on( 'mouseover', 'td', function () {
            var colIdxx = tablee.cell(this).index().column;
 
            if ( colIdxx !== lastIdxx ) {
                $( tablee.cells().nodes() ).removeClass( 'highlight' );
                $( tablee.column( colIdxx ).nodes() ).addClass( 'highlight' );
            }
        } )
        .on( 'mouseleave', function () {
            $(tablee.cells().nodes() ).removeClass( 'highlight' );
        } );
} );


	
</script>






<style>
td.highlight {
    background-color: #6a96ce !important;
	border: #6a96ce !important;
}
.zClass td {
    background-color: #6a96ce !important; /* Add !important to make sure override datables base styles */
	border: #6a96ce !important;
 }
</style>