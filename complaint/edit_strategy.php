<?php $this->load->view('header');?>
<?php
	$redirect_customer	=	"no";
	$customer_id		=	0;
	if (isset($_GET['cust'])) {
		$redirect_customer="yes";
		$customer_id=$_GET['cust'];
	}

if (isset($_GET['approve_strategy'])) {
		$as="yes"; //approve strategy
	}	

$strategy_id = $this->uri->segment('3');
$zquery="select business_data.*,tbl_project_strategy.*,tbl_clients.client_name,tbl_cities.city_name,tbl_area.area,user.first_name,tbl_business_types.businesstype_name 
	from tbl_project_strategy
	LEFT JOIN business_data ON business_data.pk_businessproject_id = tbl_project_strategy.fk_project_id
	LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
	LEFT JOIN tbl_area ON tbl_area.pk_area_id = business_data.Area
	LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = business_data.City
	LEFT JOIN user ON user.id = business_data.`Sales Person`
	LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
	WHERE pk_project_strategy_id='" .$strategy_id."'";
	$ty=$this->db->query($zquery);
    $get_business_projects_list=$ty->result_array();
?>
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                    Proposed Strategy 
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                Home 
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Business Projects
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                Proposed Strategy
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE HEADER--> 
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">

        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <?php
                            if(isset($_GET['upt']))
                              { 
                                echo '<div class="alert alert-success alert-dismissable">  
                                        <a class="close" data-dismiss="alert">×</a>  
                                        Business Project Updated Successfully.  
                                      </div>';
                              }
                          ?>
                    
		
          <div class="portlet box green-seagreen">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-edit"></i>Update Business Project Strategy</div>
              <div class="tools"> <a href="javascript:;" class="collapse"> </a> <a href="javascript:;" class="remove"> </a> </div>

            </div>
		   <div class="portlet-body form">
           <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>complaint/update_strategy">
            <input type="hidden" name="businessproject_hidden_id" value="<?php echo $get_business_projects_list[0]['pk_businessproject_id']; ?>" />
            <div class="form-body">
			<?php 
				$project_id=$get_business_projects_list[0]['fk_project_id'];;
				$zquery="select business_data.*,tbl_clients.client_name,tbl_cities.city_name,tbl_area.area,user.first_name,tbl_business_types.businesstype_name 
						from business_data 
						LEFT JOIN tbl_clients ON tbl_clients.pk_client_id = business_data.Customer
						LEFT JOIN tbl_area ON tbl_area.pk_area_id = business_data.Area
						LEFT JOIN tbl_cities ON tbl_cities.pk_city_id = business_data.City
						LEFT JOIN user ON user.id = business_data.`Sales Person`
						LEFT JOIN tbl_business_types ON tbl_business_types.pk_businesstype_id = business_data.`Business Project`
						WHERE pk_businessproject_id='" .$project_id."'";
						$ty=$this->db->query($zquery);
						$rt=$ty->result_array();
				$client_name=$rt[0]['client_name'];
				$client_area=$rt[0]['area'];
				$client_city=$rt[0]['city_name'];
				$date=date('d-M-Y',strtotime($rt[0]['Date']));
				$sap = $rt[0]['first_name'];
				$department = $rt[0]['Department'];
				$category=$rt[0]['businesstype_name'];
				$project_type=$rt[0]['project_type'];
				$description=urldecode($rt[0]['Project Description']);
			
			?>

                <div class="row">
						<div class="form-group">
                            <label class="col-md-3 control-label"> Customer Name</label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $client_name; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Area</label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $client_area; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> City</label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $client_city; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Project Description</label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $description; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Employee Name</label>
                            <div class="col-md-8">
								<label class="control-label"> <?php echo $sap; ?></label>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Strategy</label>
                            <div class="col-md-8">
                                <textarea name="strategy" class="input-xlarge" id="strategy" rows="5" required><?php echo urldecode($get_business_projects_list[0]['strategy']);?></textarea>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label"> Tactics / Actions</label>
                            <div class="col-md-8">
                                <textarea name="tactics" class="input-xlarge" id="tactics" rows="5" required><?php echo urldecode($get_business_projects_list[0]['tactics']);?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Target Date</label>
                            <div class="col-md-4">
                                    <input type="text" class="datepicker2 form-control" name="target_date" 
                                    value="<?php if ($get_business_projects_list[0]['target_date'] != "0000-00-00")echo date('d-M-Y',strtotime($get_business_projects_list[0]['target_date']));?>" required/>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label">Investment</label>
                            <div class="col-md-4">
                                    <input type="number" class="form-control" name="investment" 
                                    value="<?php if ($get_business_projects_list[0]['investment'] != "0")echo $get_business_projects_list[0]['investment'];?>" required/>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3 control-label">Sales / Month</label>
                            <div class="col-md-4">
                                    <input type="number" class="form-control" name="sales_per_month" 
                                    value="<?php if ($get_business_projects_list[0]['sales_per_month'] != "0")echo $get_business_projects_list[0]['sales_per_month'];?>" required/>
                            </div>
                        </div>
                </div>
              
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-3 col-md-9">
				<input type="hidden" name="strategy_status" value="1" />
				<input type="hidden" name="fk_project_id" value="<?php echo $get_business_projects_list[0]['fk_project_id']; ?>" />
				<input type="hidden" name="proj" value="<?php if (isset($_GET['proj'])) echo $_GET['proj']; else echo "0"; ?>" />
				<input type="hidden" name="pk_project_strategy_id" value="<?php echo $this->uri->segment('3'); ?>" />
				<?php
						echo '<input type="hidden" name="redirect_edit_strategy" value="'.$this->uri->segment('2').'" />';
						echo '<button type="submit" class="btn default yellow-crusta">';
						if (!isset($_GET['proj'])) echo 'Approve</button>';
						else echo 'Update</button>';
						
				if (!isset($_GET['proj']))  {
				?>
				
				<a class="btn btn default red" href="<?php echo base_url();?>complaint/disapprove_strategy/<?php echo $strategy_id;?>">
                                                      	Not Approved
                                                      </a>
				<?php } ?>
                </div>
              </div>
            </div>
           </div>
           </form>
           </div>
          </div>
          
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
     </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('footer');?>