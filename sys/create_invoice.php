<?php $this->load->view('header_new_date');
?>

<!-- BEGIN PAGE HEADER-->
<div class="page-head">
<div class="page-title"> <h1>Create Invoice</h1> <small>
  <?php //echo $average_visits_per_day; ?>
  </small> </div>
</div>

<ul class="page-breadcrumb breadcrumb">
    <li> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-circle"></i> </li>
    <li> <span class="active">Create Invoice </span></li>
</ul>
<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"> <i class="icon-equalizer font-red-sunglo"></i> <span class="caption-subject font-red-sunglo bold uppercase">New Customer Invoice</span> <span class="caption-helper"></span> </div>
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
                  <label class="control-label col-md-3">Prepared by</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="username"  placeholder="Username" readonly/>
                    <!--<select name="foo" class="form-control select2">
                    <option value="">--Select--</option>
                      <option value="1">HO</option>
                      <option value="2">LO</option>
                      <option value="3">KO</option>
                    </select>-->
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Office</label>
                  <div class="col-md-9">
                  <input type="text" class="form-control" name="officename" readonly/>
                    <!--<select name="foo2" class="form-control select2">
                    <option value="">--Select--</option>
                      <option value="1">CITILab</option>
                      <option value="2">Shifa International Hospital</option>
                      <option value="3">CMH Rawalpindi</option>
                    </select>-->
                    <!--<span class="help-block"> This field has error. </span>--> </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Prices</label>
                  <div class="col-md-9">
                    <select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">Price Contract</option>
                      <option value="2">Manual Entry</option>
                    </select>
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Header</label>
                  <div class="col-md-9">
                    <select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">PMA</option>
                      <option value="2">RBS</option>
                      <option value="3">White Paper</option>
                      <option value="4">Indus Lab</option>
                      <option value="5">MST</option>
                    </select>
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
             <h3 class="form-section">Part A</h3>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Invoice No</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="invoiceno" readonly/>
                    <!--<input class="form-control date" data-provide="datepicker" size="16" type="text" name="orderdate" value="" readonly/>-->
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Date</label>
                  <div class="col-md-9">
                  <input class="form-control date" data-provide="datepicker" size="16" type="text" name="invoicedate" value="<?php echo date("d-M-Y");?>" readonly/>
                    <!--<select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">Yes</option>
                      <option value="2">No</option>
                    </select>-->
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Bill to</label>
                  <div class="col-md-9">
                    <select name="foo2" class="form-control select2">
                    <option value="">--Select--</option>
                      <option value="1">CITILab</option>
                      <option value="2">Shifa International Hospital</option>
                      <option value="3">CMH Rawalpindi</option>
                    </select>
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group ">
                  <label class="control-label col-md-3">Ship to</label>
                  <div class="col-md-9">
                  <select name="foo22" class="form-control select2">
                    <option value="">--Select--</option>
                      <option value="11">CITILab</option>
                      <option value="22">Shifa International Hospital</option>
                      <option value="33">CMH Rawalpindi</option>
                    </select>
                    <!--<div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                      <div> <span class="btn red btn-outline btn-file"> <span class="fileinput-new"> Select image </span> <span class="fileinput-exists"> Change </span>
                        <input type="file" name="...">
                        </span> <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a> </div>
                    </div>
                    <div class="clearfix margin-top-10"> <span class="label label-success">NOTE!</span> Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead. </div>-->
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
             <h3 class="form-section">Part B</h3>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Customer Order No</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="orderno"/>
                    <!--<input class="form-control date" data-provide="datepicker" size="16" type="text" name="orderdate" value="" readonly/>-->
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Order Date</label>
                  <div class="col-md-9">
                  <input class="form-control date" data-provide="datepicker" size="16" type="text" name="orderdate" value="<?php echo date("d-M-Y");?>" readonly/>
                    <!--<select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">Yes</option>
                      <option value="2">No</option>
                    </select>-->
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Customer Account No</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="customeraccountno"/>
                    <!--<input class="form-control date" data-provide="datepicker" size="16" type="text" name="orderdate" value="" readonly/>-->
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Customer STN/NTN/CNIC No</label>
                  <div class="col-md-9">
                  <input type="text" class="form-control" name="customernicno"/>
                    <!--<select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">Yes</option>
                      <option value="2">No</option>
                    </select>-->
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            
            
            
            
            <h3 class="form-section">Part C</h3>
            <!--/row-->
            <div class="row">
              <div class="col-md-12">
                <div class="table-scrollable">
                  <table class="table  table-condensed table-bordered" id="invoiceitems">
                    <thead class="bg-blue-chambray bg-font-blue-chambray">
                      <tr>
                        <th> </th>
                        <th> Serial No</th>
                        <th> Kit</th>
                        <th> Lot Number </th>
                        <th> Expiry Date</th>
                        <th> Quantity </th>
                        <th> Pack Size </th>
                        <th> Unit Price </th>
                        <th> Gross Price </th>
                        <th> Discount % </th>
                        <th> Net Amount Excl.Sales Tax </th>
                        <th> Sales Tax (%) </th>
                        <th> Sales Tax (Rs) </th>
                        <th> Net Amount Incl Sales Tax </th>
                        <!--<th> </th>-->
                        <!--    <th> Add&nbsp;Row&nbsp;<a href="javascript:void()"><i class="fa fa-plus" onclick="add_row()"></i></a> </th> --> 
                      </tr>
                    </thead>
                    <tbody class="append_tbody">
                    
                      <tr class="orderdetails[0]">
                      <td style=""><a href="javascript:;" class="btn btn-icon-only red"> <i class="fa fa-minus"></i> </a></td>
                        <td>1</td>
                        <td class="kitname"><select class="form-control select2" name="kit[0]" id="kit0" required>
                            <option value="">--Choose--</option>
                            <option value="pcr2">PCR TUBES 0.1ML</option>
                            <option value="ac2f">AC2 FERRITIN</option>
                            
                          </select></td>
                        <td class="lotnumber"><select class="form-control select2" name="lot[0]" id="lot0" required>
                            <option value="">--Choose--</option>
                            <option value="pcr2">PCR TUBES 0.1ML</option>
                            <option value="ac2f">AC2 FERRITIN</option>
                         </select></td>
                        <td><input type="text" class="form-control" name="expirydate[0]" disabled></td>
                        <td><input type="text" class="form-control quantity0" id="quantity" name="quantity[0]" onkeypress="return isNumberKey(event)" required></td>
                        <td><input type="text" class="form-control" name="packsize[0]" disabled></td>
                        <td><input type="text" class="form-control" name="unitprice[0]"  value="2000" disabled></td>
                        <td><input type="text" class="form-control" id="gross" name="grossprice[0]" value="" readonly="readonly"></td>
                        <td><input type="text" class="form-control" id="discount" name="discount[0]" onkeypress="return isNumberKey(event)"></td>
                        <td><input type="text" class="form-control" id="netamount" name="netamount[0]" readonly="readonly"></td>
                        <td><input type="text" class="form-control" id="salestax" name="salestax[0]"></td>
                        <td><input type="text" class="form-control" id="salestaxrs" name="salestaxrs[0]" readonly></td>
                        <td><input type="text" class="form-control" id="netamntwithst" name="netamntwithst[0]" readonly="readonly"></td>
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
            <h3 class="form-section">Part D</h3>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Total Quantity</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="totalquantity" name="totalquantity" value=""/>
                    <!--<input class="form-control date" data-provide="datepicker" size="16" type="text" name="orderdate" value="" readonly/>-->
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Total Gross Price</label>
                  <div class="col-md-9">
                  <input type="text" class="form-control" name="totalgrossprice"/>
                    <!--<select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">Yes</option>
                      <option value="2">No</option>
                    </select>-->
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Total Net Amount Excl Sales Tax</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="totalnetamount"/>
                    <!--<input class="form-control date" data-provide="datepicker" size="16" type="text" name="orderdate" value="" readonly/>-->
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Total Net Amount Incl Sales Tax</label>
                  <div class="col-md-9">
                  <input type="text" class="form-control" name="totalnetamntwithst"/>
                    <!--<select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">Yes</option>
                      <option value="2">No</option>
                    </select>-->
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Total Amount in Words</label>
                  <div class="col-md-9">
                    <textarea name="totalinwords" class="form-control" rows="5" readonly="readonly"></textarea>
                    <!--<input class="form-control date" data-provide="datepicker" size="16" type="text" name="orderdate" value="" readonly/>-->
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Approved by</label>
                  <div class="col-md-9">
                  <input type="text" class="form-control" name="approvedby"/>
                    <!--<select class="form-control select2">
                      <option value="">--Select--</option>
                      <option value="1">Yes</option>
                      <option value="2">No</option>
                    </select>-->
                  </div>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Goods Received by</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="receivedby"/>
                    <!--<input class="form-control date" data-provide="datepicker" size="16" type="text" name="orderdate" value="" readonly/>-->
                  </div>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Order Completed</label>
                  <div class="col-md-9">
                  <!--<input type="text" class="form-control" name="netamntwithst"/>-->
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
            
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">Submit</button>
                    <!--<button type="button" class="btn default">Cancel</button>-->
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
		 add_row();
    });
	
    $(document).on("focus",'#gross',function() {
	
	 var rowindex = $(this).closest('tr').index();
     var x = parseInt(document.getElementsByName("quantity["+rowindex+"]")[0].value);
	 var y = parseInt(document.getElementsByName("unitprice["+rowindex+"]")[0].value);
	 var z = x*y;
	 document.getElementsByName('grossprice['+rowindex+']')[0].value = z;
	 
	 var sum = 0;
     // iterate through each td based on class and add the values
     for(var i=0; i<=rowindex; i++) { 
     sum += parseInt(document.getElementsByName("quantity["+i+"]")[0].value);
     }
     document.getElementsByName('totalquantity')[0].value = sum; 
	 
	  var sum = 0;
     // iterate through each td based on class and add the values
     for(var i=0; i<=rowindex; i++) { 
     sum += parseInt(document.getElementsByName("grossprice["+i+"]")[0].value);
     }
     document.getElementsByName('totalgrossprice')[0].value = sum; 
	 	 
    });
	
	$(document).on("focus",'#netamount',function() {
	 var rowindex = $(this).closest('tr').index();
     var x = parseInt(document.getElementsByName("grossprice["+rowindex+"]")[0].value);
	 var y = parseInt(document.getElementsByName("discount["+rowindex+"]")[0].value);
	 var z = (y/100)*x;
	 var result = x-z;
	 document.getElementsByName('netamount['+rowindex+']')[0].value = result;
	 
	  var sum = 0;
     // iterate through each td based on class and add the values
     for(var i=0; i<=rowindex; i++) { 
     sum += parseInt(document.getElementsByName("netamount["+i+"]")[0].value);
     }
     document.getElementsByName('totalnetamount')[0].value = sum;
	 
    });
	
	$(document).on("focus",'#salestaxrs',function() {
	 var rowindex = $(this).closest('tr').index();
     var x = parseInt(document.getElementsByName("netamount["+rowindex+"]")[0].value);
	 var y = parseInt(document.getElementsByName("salestax["+rowindex+"]")[0].value);
	 var z = (y/100)*x;
	 document.getElementsByName('salestaxrs['+rowindex+']')[0].value = z;	
   });
	
	$(document).on("focus",'#netamntwithst',function() {
	 var rowindex = $(this).closest('tr').index();
     var x = parseInt(document.getElementsByName("salestaxrs["+rowindex+"]")[0].value);
	 var y = parseInt(document.getElementsByName("netamount["+rowindex+"]")[0].value);
	 
	 var z = x + y;
	 document.getElementsByName('netamntwithst['+rowindex+']')[0].value = z;
	 
	 var sum = 0;
     // iterate through each td based on class and add the values
     for(var i=0; i<=rowindex; i++) { 
     sum += parseInt(document.getElementsByName("netamntwithst["+i+"]")[0].value);
     }
     document.getElementsByName('totalnetamntwithst')[0].value = sum; 
	 calculateinwords();
	  	 
    });
	
});

function calculateinwords(){
	  var junkVal=document.getElementsByName('totalnetamntwithst')[0].value;
    junkVal=Math.floor(junkVal);
    var obStr=new String(junkVal);
    numReversed=obStr.split("");
    actnumber=numReversed.reverse();

    if(Number(junkVal) >=0){
        //do nothing
    }
    else{
        alert('wrong Number cannot be converted');
        return false;
    }
    if(Number(junkVal)==0){
        document.getElementById('container').innerHTML=obStr+''+'Rupees Zero Only';
        return false;
    }
    if(actnumber.length>9){
        alert('Oops!!!! the Number is too big to covertes');
        return false;
    }

    var iWords=["Zero", " One", " Two", " Three", " Four", " Five", " Six", " Seven", " Eight", " Nine"];
    var ePlace=['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
    var tensPlace=['dummy', ' Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety' ];

    var iWordsLength=numReversed.length;
    var totalWords="";
    var inWords=new Array();
    var finalWord="";
    j=0;
    for(i=0; i<iWordsLength; i++){
        switch(i)
        {
        case 0:
            if(actnumber[i]==0 || actnumber[i+1]==1 ) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            inWords[j]=inWords[j]+' Only';
            break;
        case 1:
            tens_complication();
            break;
        case 2:
            if(actnumber[i]==0) {
                inWords[j]='';
            }
            else if(actnumber[i-1]!=0 && actnumber[i-2]!=0) {
                inWords[j]=iWords[actnumber[i]]+' Hundred and';
            }
            else {
                inWords[j]=iWords[actnumber[i]]+' Hundred';
            }
            break;
        case 3:
            if(actnumber[i]==0 || actnumber[i+1]==1) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            if(actnumber[i+1] != 0 || actnumber[i] > 0){
                inWords[j]=inWords[j]+" Thousand";
            }
            break;
        case 4:
            tens_complication();
            break;
        case 5:
            if(actnumber[i]==0 || actnumber[i+1]==1) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            if(actnumber[i+1] != 0 || actnumber[i] > 0){
                inWords[j]=inWords[j]+" Lakh";
            }
            break;
        case 6:
            tens_complication();
            break;
        case 7:
            if(actnumber[i]==0 || actnumber[i+1]==1 ){
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            inWords[j]=inWords[j]+" Crore";
            break;
        case 8:
            tens_complication();
            break;
        default:
            break;
        }
        j++;
    }

    function tens_complication() {
        if(actnumber[i]==0) {
            inWords[j]='';
        }
        else if(actnumber[i]==1) {
            inWords[j]=ePlace[actnumber[i-1]];
        }
        else {
            inWords[j]=tensPlace[actnumber[i]];
        }
    }
    inWords.reverse();
    for(i=0; i<inWords.length; i++) {
        finalWord+=inWords[i];
    }
    document.getElementsByName('totalinwords')[0].value = finalWord;	
	 	
	}

function add_row()
            {
              var count = $('#invoiceitems tr').length;
		 var count2 = count-1;
         var count1=Math.floor(Math.random()*101);
             $('.append_tbody').append('<tr class="orderdetails['+count1+']"><td><a href="javascript:;" class="btn btn-icon-only red"><i class="fa fa-minus"></i></a></td><td>'+count+'</td><td class="kitname"><select class="form-control select2 select'+count1+'" name="kit['+count1+']" id="kit'+count1+'" required><option value="">--Choose--</option><option value="pcr'+count1+'">PCR TUBES 0.1ML</option><option value="ac2f'+count1+'">AC2 FERRITIN</option></select></td><td class="lotnumber"><select class="form-control select2 select'+count1+'" name="lot['+count1+']" id="lot'+count1+'" required><option value="">--Choose--</option><option value="pcr2'+count1+'">PCR TUBES 0.1ML</option><option value="ac2f'+count1+'">AC2 FERRITIN</option></select></td><td><input type="text" class="form-control" name="expirydate['+count1+']" disabled></td><td><input type="text" class="form-control quantity'+count1+'" id="quantity" name="quantity['+count2+']" onkeypress="return isNumberKey(event)" required></td><td><input type="text" class="form-control" name="packsize['+count1+']" disabled></td><td><input type="text" class="form-control" name="unitprice['+count2+']" value="1500" disabled></td><td><input type="text" class="form-control" id="gross" name="grossprice['+count2+']" value="" readonly="readonly"></td><td><input type="text" class="form-control" id="discount" name="discount['+count2+']" onkeypress="return isNumberKey(event)"></td><td><input type="text" class="form-control" id="netamount" name="netamount['+count2+']" readonly="readonly"></td><td><input type="text" id="salestax" class="form-control" name="salestax['+count2+']"></td><td><input type="text" class="form-control" id="salestaxrs" name="salestaxrs['+count2+']" readonly="readonly"></td><td><input type="text" id="netamntwithst"class="form-control" name="netamntwithst['+count2+']" readonly="readonly"></td></tr>');
              $('.select'+count1+'').select2();
             $( ".btn-icon-only" ).click(function(event) {
	 $(this).parents('tr').remove();
	 var count = $('#invoiceitems tr').length;
	 var count2 = count-2;
	 
	var sum = 0;
	var sum1 = 0;
	var sum2= 0;
	var sum3=0;
     // iterate through each td based on class and add the values
     for(var i=0; i<=count2; i++) { 
     sum += parseInt(document.getElementsByName("quantity["+i+"]")[0].value);
	 sum1 += parseInt(document.getElementsByName("grossprice["+i+"]")[0].value);
	 sum2 += parseInt(document.getElementsByName("netamount["+i+"]")[0].value);
	 sum3 += parseInt(document.getElementsByName("netamntwithst["+i+"]")[0].value);
     }
     document.getElementsByName('totalquantity')[0].value = sum;
	 document.getElementsByName('totalgrossprice')[0].value = sum1;
	 document.getElementsByName('totalnetamount')[0].value = sum2;
	  document.getElementsByName('totalnetamntwithst')[0].value = sum3; 
	  calculateinwords();
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
