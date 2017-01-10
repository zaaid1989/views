<?php $this->load->view('header');?>
<?php
$rp = $this->db->query("SELECT * FROM tbl_roles WHERE delete_status=0");
$roles = $rp->result_array();

?>
<h3 class="page-title">Manage Permissions
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
							<li><i class="fa fa-home"></i>Home<i class="fa fa-angle-right"></i></li>
							<li> Permissions </li>
						</ul>
					</div>
					
			<div class="portlet box red">
                <div class="portlet-title">
                  <div class="caption"> <i class="fa fa-globe"></i>Manage Permissions </div>
                  <div class="tools"> 
                      <a href="javascript:;" class="collapse"> </a> 
                      
                      <a href="javascript:;" class="remove"> </a> 
                  </div>
                </div>
				
            <div class="portlet-body">
			<div class="row">
			<div class="col-md-6">
			  <div class="btn-group">
			  <?php if(isset($_GET['z'])) { ?>
				<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>csa/perm_insert">
				
				<div class="form-group">
					<label class="col-md-3 control-label">Page ID</label>
					<div class="col-md-8">
						<input type="text"   name="fk_page_id"  class="form-control" id="currency" >	        
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Page</label>
					<div class="col-md-8">
						<input type="text"   name="page"  class="form-control" id="currency" >	        
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Page Title</label>
					<div class="col-md-8">
						<input type="text"   name="page_title"  class="form-control" id="currency" >	        
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Permission</label>
					<div class="col-md-8">
						<input type="text"   name="permission"  class="form-control" id="currency" >	        
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Permission Title</label>
					<div class="col-md-8">
						<input type="text"   name="permission_title"  class="form-control" id="currency" >	        
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Permission Group</label>
					<div class="col-md-8">
						<input type="text"   name="permission_group"  class="form-control" id="currency" >	        
					</div>
				</div>
				
				<div class="row form-actions">
				  <div class="col-md-12">
					<div class="form-group">
					  <div class="col-md-offset-3 col-md-3">
					   <button type="submit" class="btn blue">Submit</button>
					   </div>
					</div>
				  </div>
				</div>
				</form>
			  <?php } ?>
			  </div>
			</div>
			</div>
			
			<div class="row">
                    <div class="col-md-12"> 
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
						<table class="table table-striped table-bordered table-hover flip-content dataaTable1" id="">
							<thead class="bg-grey-gallery">
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<?php foreach($roles as $role): ?>
									<th></th>
									<?php endforeach; ?>
								</tr>
								<tr>
									<th>Module</th>
									<th>Page</th>
									<th>Permission</th>
									<th>Page</th>
									<?php foreach($roles as $role): ?>
									<th><?php echo $role['role_name']; ?></th>
									<?php endforeach; ?>
								</tr>
							</thead>
							<tbody>
								
								<?php
									$pq = $this->db->query("SELECT permission_group,page_title,permission_title,page,fk_page_id,permission,GROUP_CONCAT(tbl_roles.role_name SEPARATOR ',') AS roles_allowed FROM `tbl_permissions` 
									LEFT JOIN tbl_roles ON tbl_roles.pk_role_id = tbl_permissions.fk_role_id
									GROUP BY page,permission
									ORDER BY permission_group,`tbl_permissions`.`page` ASC");
									$permissions = $pq->result_array();
									
									foreach ($permissions AS $permission) {
										echo '<tr>';
										echo "<td>".$permission['permission_group']."</td>";
										echo "<td>".$permission['page_title']."</td>";
										echo "<td>".$permission['permission_title']."</td>";
										echo "<td>".$permission['page']."</td>";
										foreach ($roles AS $role) {
											echo '<td align="center">';
											echo '<button title="' . $role['role_name'] . '" 
											type="button" class="btn btn-default btn-permission" 
											data-page="' . $permission['page'] . '"
											data-permission="' . $permission['permission'] . '"
											data-permissiontitle="' . $permission['permission_title'] . '"
											data-pagetitle="' . $permission['page_title'] . '"
											data-pageid="' . $permission['fk_page_id'] . '"
											data-permissiongroup="' . $permission['permission_group'] . '"
											data-role="' . $role['pk_role_id'] . '">';
											if(in_array($role['role_name'], explode(',', $permission['roles_allowed']))) 
												echo '<i class="fa fa-check font-green"></i>';
											else
												echo '<i class="fa fa-times font-red"></i>';
											echo '</button></td>';
										}
										echo '</tr>';
									}
								?>
								
							</tbody>
						</table>
                        
						
                      </div>
                    </div>
					
				</div>
				</div>
				<!-- end portlet -->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>

<?php $this->load->view('footer');?>
<script>
$(document).ready(function() { 
			var table = $('.dataaTable1').dataTable({
			  'iDisplayLength': 2000
			}).columnFilter({ sPlaceHolder: "head:before",
					aoColumns: [ 	{type: "text" },
								{type: "text" },
								{type: "text" },
					            { type: "text" }
								
						]

		});
});
</script>
<script>

    $('.btn-permission').click(function(){
        var permission = { 'page': $(this).data('page'), 'permission': $(this).data('permission'), 'role': $(this).data('role'), 'fk_page_id': $(this).data('pageid'), 'page_title': $(this).data('pagetitle'), 'permission_title': $(this).data('permissiontitle'), 'permission_group': $(this).data('permissiongroup'), 'operation': ''};
        if($(this).html().indexOf('fa-check') !== -1)
        {
            permission.operation = 'delete';
            $(this).html('<i class="fa fa-times font-red"></i>');
        }
        else
        {
            permission.operation = 'insert';
            $(this).html('<i class="fa fa-check font-green"></i>');
        }
		console.log(permission);
        $.post('<?php echo base_url('sys/update_permission'); ?>', permission, function(){});
    });

</script>