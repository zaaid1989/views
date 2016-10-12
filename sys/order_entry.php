<?php $this->load->view('header_new_date');
?>

<!-- BEGIN PAGE HEADER-->
<div class="page-head">
<div class="page-title"> <h1>Order Entry</h1> <small>
  <?php //echo $average_visits_per_day; ?>
  </small> </div>
</div>

<ul class="page-breadcrumb breadcrumb">
    <li> Home  <i class="fa fa-circle"></i> </li>
    <li> <span class="active">Order Entry </span></li>
</ul>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"> <i class="icon-equalizer font-red-sunglo"></i> <span class="caption-subject font-red-sunglo bold uppercase">Order Entry Form</span> <span class="caption-helper">Enter Details of Customer Order</span> </div>
        <div class="tools"> 
         <a href="javascript:;" class="collapse"> </a> 
                <a href="javascript:;" class="remove"> </a> 
         </div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
        <form action="#" class="form-horizontal">
          <div class="form-body">
            <h3 class="form-section">Basic Info</h3>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Office</label>
                  <div class="col-md-9">
                    <select name="foo" class="form-control select2">
                    <option value="">--Select--</option>
                      <option value="1">HO</option>
                      <option value="2">LO</option>
                      <option value="3">KO</option>
                    </select>
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Customer</label>
                  <div class="col-md-9">
                    <select name="foo2" class="form-control select2">
                    <option value="">--Select--</option>
                      <option value="1">CITILab</option>
                      <option value="2">Shifa International Hospital</option>
                      <option value="3">CMH Rawalpindi</option>
                    </select>
                    <!--<span class="help-block"> This field has error. </span>--> </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Order Type</label>
                  <div class="col-md-9">
                    <select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">Written</option>
                      <option value="2">Verbal</option>
                    </select>
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Order Number</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control">
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Order Date</label>
                  <div class="col-md-9">
                    <input class="form-control date" data-provide="datepicker" size="16" type="text" name="orderdate" value="" readonly/>
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Part Supply Allowed</label>
                  <div class="col-md-9">
                    <select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">Yes</option>
                      <option value="2">No</option>
                    </select>
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Comments</label>
                  <div class="col-md-9">
                    <textarea name="comments" class="form-control" rows="5"></textarea>
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group ">
                  <label class="control-label col-md-3">Order Copy Upload</label>
                  <div class="col-md-9">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                      <div> <span class="btn red btn-outline btn-file"> <span class="fileinput-new"> Select image </span> <span class="fileinput-exists"> Change </span>
                        <input type="file" name="...">
                        </span> <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a> </div>
                    </div>
                    <div class="clearfix margin-top-10"> <span class="label label-success">NOTE!</span> Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead. </div>
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <h3 class="form-section">Order Details</h3>
            <!--/row-->
            <div class="row">
              <div class="col-md-12">
                <div class="table-scrollable">
                  <table class="table  table-condensed table-bordered" id="customerorderdetails">
                    <thead class="bg-blue-chambray bg-font-blue-chambray">
                      <tr>
                        <th> </th>
                        <th> Kit</th>
                        <th> Vendor </th>
                        <th> Catalog </th>
                        <th> Pack Size </th>
                        <th> Quantity </th>
                        <th> Price </th>
                        <th> Delivery Date </th>
                        <!--<th> </th>-->
                        <!--    <th> Add&nbsp;Row&nbsp;<a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a> </th> --> 
                      </tr>
                    </thead>
                    <tbody class="append_tbody">
                    
                      <tr class="orderdetails[0]">
                      <td style=""><a href="javascript:;" class="btn btn-icon-only red"> <i class="fa fa-minus"></i> </a></td>
                        <td><select class="form-control select2" name="manufacture[0]" id="manufacture0" required>
                            <option value="">--Choose--</option>
                            <option value="pcr2">PCR TUBES 0.1ML</option>
                            <option value="ac2f">AC2 FERRITIN</option>
                            
                          </select></td>
                        <td class="kitname"><select class="form-control select2" name="kitname[0]">
                            <option value="">--Choose--</option>
                            <option value="bc2">Beckman Coulter</option>
                            <option value="as2">ADELAB SCIENTIFIC</option>
                          </select></td>
                        <td class="catalognumber"><input type="text" class="form-control" name="catalog[0]" disabled></td>
                        <td><input type="text" class="form-control" name="packsize[0]" disabled></td>
                        <td><input type="text" class="form-control quantity0" name="quantity[0]" onkeypress="return isNumberKey(event)" required></td>
                        <td><input type="text" class="form-control" name="price[0]" disabled></td>
                        <td><input class="form-control date" data-provide="datepicker" name="date[0]" size="16" type="text" value="" readonly="readonly" /></td>
                        <!--<td style=""><a href="javascript:;" class="btn btn-icon-only red"> <i class="fa fa-minus"></i> </a></td>-->
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-12">
                <table class="table" style="border-top: 0px !important;">
                  <tr>
                    <td class="pull-right" style="border-top: 0px !important; margin-top:-5px;"><button type="button" class="btn green btn-xs" onclick="add_row()">Add Row +</button></td>
                     
                  </tr>
                </table>
                <!--<div class="form-group">
                  <label class="control-label col-md-3">Comments</label>
                  <div class="col-md-9">
                    <textarea name="comments" class="form-control" rows="5"></textarea>
                    </div>
                </div>--> 
              </div>
            </div>
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">Submit</button>
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
<script>
$(document).ready(function(){
    $(document).on("focus",'.append_tbody tr:last-child td:last-child',function() {
        //append the new row here.
         var count1=Math.floor(Math.random()*101);
              $('.append_tbody').append('<tr class="orderdetails['+count1+']"><td><a href="javascript:;" class="btn btn-icon-only red"><i class="fa fa-minus"></i></a></td><td><select class="form-control select2 select'+count1+'" name="manufacture['+count1+']"  id="manufacture'+count1+'" required><option value="">--Choose--</option><option value="bc'+count1+'">PCR TUBES 0.1ML</option><option value="as'+count1+'">AC2 FERRITIN</option></select></td><td class="kitname'+count1+'"> <select class="form-control select2 select'+count1+'" name="kitname['+count1+']" required><option value="">--Choose--</option><option value="pcr'+count1+'">Beckman Coulter</option><option value="ac2'+count1+'">ADELAB SCIENTIFIC</option></td><td class="catalognumber'+count1+'"><input type="text" class="form-control" name="catalog['+count1+']" disabled></td><td> <input type="text" class="form-control" name="packsize['+count1+']" disabled></td><td> <input type="text" class="form-control quantity'+count1+'" name="quantity['+count1+']" onkeypress="return isNumberKey(event)" required></td><td><input type="text" class="form-control" name="price['+count1+']" disabled></td><td><input class="form-control date" data-provide="datepicker" name="date['+count1+']" size="16" type="text" value="" readonly="readonly" /></td><?php /*?><td><a href="javascript:;" class="btn btn-icon-only red"><i class="fa fa-minus"></i></a></td><?php */?></tr>');
	$('.select'+count1+'').select2();
	$('.date').datepicker({
    format: 'dd-M-yyyy'
 });
              $( ".btn-icon-only" ).click(function(event) {
                    //$(this).closest('tr').remove();
					//event.preventDefault();
					$(this).parents('tr').remove();
                });
//               $('.timepicker1').timepicker({
//                  minuteStep: 5,
//                  showInputs: false,
//                  disableFocus: true,
//                  defaultTime:false
//              });
//              
//              $('.timepicker2').timepicker({
//                  minuteStep: 5,
//                  showInputs: false,
//                  disableFocus: true,
//                  defaultTime:false
//              });
    });
});

function add_row()
            {
              var count1=Math.floor(Math.random()*101);
              $('.append_tbody').append('<tr class="orderdetails['+count1+']"><td><a href="javascript:;" class="btn btn-icon-only red"><i class="fa fa-minus"></i></a></td><td><select class="form-control select2 select'+count1+'" name="manufacture['+count1+']"  id="manufacture'+count1+'" required><option value="">--Choose--</option><option value="bc'+count1+'">Beckman Coulter</option><option value="as'+count1+'">ADELAB SCIENTIFIC</option></select></td><td class="kitname'+count1+'"> <select class="form-control select2 select'+count1+'" name="kitname['+count1+']" required><option value="">--Choose--</option><option value="pcr">PCR TUBES 0.1ML</option><option value="ac2">AC2 FERRITIN</option></td><td class="catalognumber'+count1+'"><input type="text" class="form-control" name="catalog['+count1+']" disabled></td><td> <input type="text" class="form-control" name="packsize['+count1+']" disabled></td><td> <input type="text" class="form-control quantity'+count1+'" name="quantity['+count1+']" onkeypress="return isNumberKey(event)" required></td><td><input type="text" class="form-control" name="price['+count1+']" disabled></td><td><input class="form-control datepicker2" data-provide="datepicker" name="date['+count1+']" size="16" type="text" value="" readonly="readonly" /></td><?php /*?><td><a href="javascript:;" class="btn btn-icon-only red"><i class="fa fa-minus"></i></a></td><?php */?></tr>');
              $('.select'+count1+'').select2();
              $( ".btn-icon-only" ).click(function(event) {
                    //$(this).closest('tr').remove();
					//event.preventDefault();
					$(this).parents('tr').remove();
                });
				
			  $('.date').datepicker({
               format: 'dd-M-yyyy'
              });
                  
             }
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}


</script>
<style>
textarea {
  width: 100%;
}
</style>
