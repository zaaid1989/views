         </div>
         <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 <?php echo date('Y');?> &copy; MIS by Roze Solutions.
	</div>
	<div class="page-footer-tools">
		<span class="go-top">
		<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url();?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url();?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo base_url();?>newtheme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE PLUGINS -->
<script type="text/javascript" src="<?php echo base_url();?>newtheme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/select2new/version402/select2.full.min.js"></script>

<script>
//$('select').select2();
$('.date').datepicker({
    format: 'dd-M-yyyy'
 });
</script>
<script src="<?php echo base_url();?>newtheme/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery.dataTables.columnFilter.js"></script>
<!-- END PAGE PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo base_url();?>newtheme/assets/global/scripts/app.min.js" type="text/javascript"></script>
 <!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>newtheme/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
 <!-- END PAGE LEVEL SCRIPTS -->
 
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo base_url();?>newtheme/assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>newtheme/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->


<?php /*?><script src="<?php echo base_url();?>assets/global/plugins/pace/pace.min.js" type="text/javascript"></script>


<script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/select2new/version402/select2.full.min.js"></script>-->
<!--<script src="<?php echo base_url();?>assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>-->
<script src="<?php echo base_url();?>assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-form.js" type="text/javascript"></script>

<!--<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>-->

<script src="<?php echo base_url();?>assets/admin/pages/scripts/table-managed.js"></script> 

<script src="<?php echo base_url();?>/assets/admin/pages/scripts/form-samples.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>


<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>

<!--<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>



<script src="<?php echo base_url();?>assets/global/plugins/moment.min.js" type="text/javascript"></script>--><?php */?>


<!--Below is old select2. It is now working.-->
<!--<link href="<?php echo base_url();?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>-->
<?php /*?><script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js"></script>
<script>
$('select').select2();
</script>
<!--Above is old select2. It is now working.-->

<?php */?>

<!--File input in change avatar end-->

<?php /*?>For new select2 uncomment below 3 files and also in header uncomment select2 and bootstrapselect files<?php */?>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/select2new/select2.full.min.js"></script>-->

<!--<script src="<?php echo base_url();?>assets/global/scripts/app.min.js"></script> 
<script src="<?php echo base_url();?>assets/global/scripts/components-select2.min.js"></script> -->
<?php /*?><script src="<?php echo base_url();?>assets/global/scripts/components-date-time-pickers.min.js"></script> 

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>-->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php if ($this->uri->segment(2)=="edit_sub_menu") {?>
   <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/fuelux/js/spinner.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
   <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
   <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
 <?php } ?>
<!--<link href="<?php echo base_url();?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js"></script>-->
<script>
<!--$('select').select2();-->

$('.date').datepicker({
    format: 'dd-M-yyyy'
 });
</script>
<!--<link href="<?php echo base_url();?>assets/global/plugins/select2new/select2.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/select2new/select2.min.js"></script>-->


<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url();?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>-->
<script src="<?php echo base_url();?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/pages/scripts/form-wizard.js"></script>
<!--<link href="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>-->
<!--<script src="<?php echo base_url();?>assets/global/plugins/num-html.js"></script>-->



<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery.dataTables.columnFilter.js"></script>
<!--<script src="<?php echo base_url();?>assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>-->

<!--<script type="text/javascript" src="../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>-->
<?php if ($this->uri->segment(2)=="sub_menu") { ?>
   <script src="<?php echo base_url();?>assets/admin/pages/scripts/table-editable.js"></script>
   <?php } ?>
   <?php if ($this->uri->segment(2)=="edit_sub_menu") { ?>
   <script src="<?php echo base_url();?>assets/admin/pages/scripts/components-form-tools.js"></script>
   <?php } ?>



<!-- END PAGE LEVEL SCRIPTS -->
<script>
	jQuery(document).ready(function() {
		$(document).prop('title', $('.page-title').text());
   
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   //QuickSidebar.init(); // init quick sidebar
   Demo.init(); // init demo features
   FormWizard.init();
   TableManaged.init();
   <?php if ($this->uri->segment(2)=="sub_menu") { ?>
   TableEditable.init();
   <?php } ?>
   <?php if ($this->uri->segment(2)=="edit_sub_menu") { ?>
   ComponentsFormTools.init();
   <?php } ?>
  
});

	
</script><?php */?>

<style>
#ui-datepicker-div
{
	border: 1px solid gray;
	border-radius: 5px !important;
	background: none repeat scroll 0 0 #fff;
	padding:5px;
}
.ui-datepicker-header
{
	color:#333 !important;
}
</style>
<!-- END JAVASCRIPTS -->
</body>

<!-- END BODY -->
</html>