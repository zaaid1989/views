<?php $this->load->view('header_new_date');
?>

<!-- BEGIN PAGE HEADER-->
<div class="page-head">
<div class="page-title"> <h1>Customer Kit Prices</h1> <small>
  <?php //echo $average_visits_per_day; ?>
  </small> </div>
</div>

<ul class="page-breadcrumb breadcrumb">
    <li> Home  <i class="fa fa-circle"></i> </li>
    <li> <span class="active">Add Kit Price </span></li>
</ul>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"> <i class="icon-equalizer font-red-sunglo"></i> <span class="caption-subject font-red-sunglo bold uppercase">Customer Kit Price Form</span> <span class="caption-helper"></span> </div>
        <div class="tools"> 
         <a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
         </div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
        <form action="#" class="form-horizontal">
          <div class="form-body">
          
            <div class="form-group">
                  <label class="control-label col-md-3">Customer</label>
                  <div class="col-md-4">
                    <select name="foo2" class="form-control select2">
                    <option value="">--Select--</option>
                      <option value="1">CITILab</option>
                      <option value="2">Shifa International Hospital</option>
                      <option value="3">CMH Rawalpindi</option>
                    </select>
                    <!--<span class="help-block"> This field has error. </span>--> </div>
                </div>
                
                
              <div class="form-group">
                  <label class="control-label col-md-3">Kit</label>
                  <div class="col-md-4">
                    <select name="foo" class="form-control select2">
                    <option value="">--Select--</option>
                      <option value="1">PCR TUBES 0.1ML</option>
                      <option value="2">COAGULATION BALL DISPENSER</option>
                      <option value="3">AC2 AFP</option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label col-md-3">Price</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="price" />
                  </div>
                </div>
        
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">Save</button>
              <!--      <button type="button" class="btn default">Cancel</button>	 -->
                  </div>
                </div>
              </div>
              <div class="col-md-6"> </div>
            </div>
          </div>
        </form>
        <!-- END FORM--> 
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('footer_new_date');?>

<style>
textarea {
  width: 100%;
}
</style>
