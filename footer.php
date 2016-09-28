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
<!-----------------------********************** For disabling inspect element (Begin) *************************------------------>
<?php if ($this->session->userdata('userrole')!='Admin') { ?>
<script>
/*
var currentInnerHtml;
var element = new Image();
var elementWithHiddenContent = document.querySelector(".row");
var innerHtml = elementWithHiddenContent.innerHTML;

element.__defineGetter__("id", function() {
    currentInnerHtml = "";
});

setInterval(function() {
    currentInnerHtml = innerHtml;
    console.log(element);
    console.clear();
    elementWithHiddenContent.innerHTML = currentInnerHtml;
}, 1000);


document.addEventListener('contextmenu', function(e) {
 e.preventDefault();
});

document.onkeydown = function(e) {
if(event.keyCode == 123) {
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
return false;
}
}
*/
</script>
<?php } ?>
<!-----------------------********************** For disabling inspect element (End) *************************------------------>
<script src="<?php echo base_url();?>/assets/admin/pages/scripts/form-samples.js"></script>


<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>




<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php if ($this->uri->segment(2)=="edit_sub_menu") { ?>
   <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/fuelux/js/spinner.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
   <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
   <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
 <?php } ?>
<link href="<?php echo base_url();?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js"></script>
<script>
$('select').select2();
</script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url();?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>-->
<script src="<?php echo base_url();?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/pages/scripts/form-wizard.js"></script>
<link href="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo base_url();?>assets/global/plugins/num-html.js"></script>



<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery.dataTables.columnFilter.js"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>

<script type="text/javascript" src="../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
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
$(document).ready(function () {
	$(".pulsate-regular").pulsate({
                color: "#bf1c56"
            });
	$('.datepicker2').datepicker({
		dateFormat: 'dd-M-yy'
		});
	});
$(document).ready(function () {
	$('.datepicker').datepicker({
		dateFormat: 'dd-M-yy'
		});
	});

</script>
<?php /*
<script type="text/javascript" src="https://www.datatables.net/release-datatables/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>

<script>

$(document).ready( function () {
    var table = $('.sample_z').DataTable( {
        "scrollY": "450px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false,
		"bSort": false
    } );
    new $.fn.dataTable.FixedColumns( table, {
		leftColumns: 1
	} );
} );

</script>*/ ?>
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