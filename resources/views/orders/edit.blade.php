@extends('layouts/app')

@section('pageTitle')
Orders
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Manage
    <small>Orders</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Orders</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-12 col-xs-12">

      <div id="messages"></div>

      @if (session()->has('success'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        {{ session()->get('success') }}
      </div>
      @endif
      @if ($errors->any())
      <div class="alert alert-error alert-dismissible" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        {{$errors->all()[0]}}
      </div>
      @endif


      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Edit Order</h3>
        </div>
        <!-- /.box-header -->
        <form role="form" action="{{ route('order.update', $order_data['order']['id']) }}" method="post"
          class="form-horizontal">
          @csrf
          @method('put')
          <div class="box-body">


            <div class="form-group">
              <label for="date" class="col-sm-12 control-label">Date: {{
                $order_data['order']['created_at']->format('d-m-Y') }}</label>
            </div>
            <div class="form-group">
              <label for="time" class="col-sm-12 control-label">Time: {{ $order_data['order']['created_at']->format('h:i
                A') }}</label>
            </div>

            @if ($order_data['order_table'])
            <div class="col-md-4 col-xs-12 pull pull-left">
              <div class="form-group">
                <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Table</label>
                <div class="col-sm-7">
                  <select class="form-control" id="table_name" @if($order_data['order']['paid_status']==3)
                    disabled='disabled' @endif required name="table_name">
                    @if($order_data['order_table']['id'])
                    <option value="{{ $order_data['order_table']['id'] }}"
                      @if($order_data['order_table']['id']==$order_data['order']['table_id']) selected='selected'
                      @endif>
                      {{ $order_data['order_table']['table_name'] }}</option>
                    @endif

                    @foreach ($table_data as $key => $value)
                    <option value="{{ $value['id'] }}" @if($order_data['order']['table_id']==$value['id'])
                      selected="selected" @endif>
                      {{ $value['table_name'] }}</option>
                    @endforeach

                  </select>
                </div>
              </div>

            </div>
            <br /> <br />
            @endif

            <table class="table table-bordered" id="product_info_table">
              <thead>
                <tr>
                  <th style="width:50%">Product</th>
                  <th style="width:10%">Qty</th>
                  <th style="width:10%">Rate</th>
                  <th style="width:20%">Amount</th>
                  <th style="width:10%"><button type="button" @if($order_data['order']['paid_status']==3)
                      disabled='disabled' @endif id="add_row" class="btn btn-default"><i
                        class="fa fa-plus"></i></button></th>
                </tr>
              </thead>

              <tbody>

                @if(isset($order_data['order_item']))
                @php $x = 1; @endphp
                @foreach ($order_data['order_item'] as $key => $val)
                <tr id="row_{{$x}}">
                  <td>
                    <select class="form-control select_group product" @if($order_data['order']['paid_status']==3)
                      disabled='disabled' @endif data-row-id="row_{{ $x }}" id="product_{{ $x }}" name="product[]"
                      style="width:100%;" onchange="getProductData({{ $x }})" required>
                      <option value=""></option>
                      @foreach ($products as $k => $v)
                      <option value="{{ $v['id'] }}" @if($val->pivot->product_id==$v['id']) selected='selected' @endif>
                        {{ $v['name'] }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td><input type="number" name="qty[]" id="qty_{{ $x }}" @if($val['is_game']==1) readonly="true" @endif
                      @if($order_data['order']['paid_status']==3) disabled='disabled' @endif class="form-control"
                      required min="1" onkeyup="getTotal({{ $x }})" data-calculative="{{ $val['is_game'] }}"
                      value="{{ $val->pivot->qty }}" autocomplete="off">
                    <input type="hidden" name="is_game[]" id="is_game_{{ $x }}" value="{{ $val->pivot->is_game }}">
                  </td>
                  <td>
                    <input type="text" name="rate[]" id="rate_{{ $x }}" class="form-control" disabled
                      value="{{ $val->pivot->rate }}" autocomplete="off">
                    <input type="hidden" name="rate_value[]" id="rate_value_{{ $x }}" class="form-control"
                      value="{{ $val->pivot->rate }}">
                  </td>
                  <td>
                    <input type="text" name="amount[]" id="amount_{{ $x }}" class="form-control" disabled
                      value="{{ $val->pivot->amount }}" autocomplete="off">
                    <input type="hidden" name="amount_value[]" id="amount_value_{{ $x }}" class="form-control"
                      value="{{ $val->pivot->amount }}">
                  </td>
                  <td><button type="button" @if($order_data['order']['paid_status']==3) disabled='disabled' @endif
                      class="btn btn-default" name="remove_row" onclick="removeRow('{{ $x }}')"><i
                        class="fa fa-close"></i></button></td>
                </tr>
                @php $x++ @endphp
                @endforeach
                @endif
              </tbody>
            </table>

            <br /> <br />
            <div class="row">
              <div class="col-md-6 col-xs-12 pull pull-right">

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled
                      value=" {{ $order_data['order']['gross_amount'] }} " autocomplete="off">
                    <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value"
                      value=" {{ $order_data['order']['gross_amount'] }} " autocomplete="off">
                  </div>
                </div>
                @if($is_service_enabled == true)
                <div class="form-group">
                  <label for="service_charge" class="col-sm-5 control-label">S-Charge
                    {{ $company_data['service_charge_value'] }} %</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="service_charge" name="service_charge" disabled
                      value=" {{ $order_data['order']['service_charge_amount'] }} " autocomplete="off">
                    <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value"
                      value=" {{ $order_data['order']['service_charge_amount'] }} " autocomplete="off">
                  </div>
                </div>
                @endif
                @if($is_vat_enabled == true)
                <div class="form-group">
                  <label for="vat_charge" class="col-sm-5 control-label">Vat
                    {{ $company_data['vat_charge_value'] }} %</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="vat_charge" name="vat_charge" disabled
                      value="{{ $order_data['order']['vat_charge_amount'] }}" autocomplete="off">
                    <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value"
                      value="{{ $order_data['order']['vat_charge_amount'] }}" autocomplete="off">
                  </div>
                </div>
                @endif
                <div class="form-group">
                  <label for="disc" class="col-sm-5 control-label">Discount</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" id="disc" disabled name="disc" placeholder="0"
                      autocomplete="off">
                    <input type="hidden" class="form-control" id="discount" name="discount" placeholder="Discount"
                      onkeyup="subAmount()" value="{{ $order_data['order']['discount'] }} " autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="net_amount" name="net_amount" disabled
                      value="{{ $order_data['order']['net_amount'] }} " autocomplete="off">
                    <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value"
                      value="{{ $order_data['order']['net_amount'] }} " autocomplete="off">
                    <input type="hidden" class="form-control" id="total_minutes" name="total_minutes"
                      value="{{ $order_data['order']['total_minutes'] }}">
                    <input type="hidden" class="form-control" id="end_time" name="end_time"
                      value="{{ $order_data['order']['end_time'] }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="paid_status" class="col-sm-5 control-label">Status</label>
                  <div class="col-sm-7">
                    <select type="text" class="form-control" id="paid_status"
                      onchange="calculateSpendTime(`{{$order_data['order']['created_at']}}`, this.value)"
                      name="paid_status">
                      <option value="2" @if($order_data['order']['paid_status']==2) selected @endif>Open</option>
                      <option value="3" @if($order_data['order']['paid_status']==3) selected @endif>Closed</option>
                    </select>
                  </div>
                </div>


              </div>
              <div class="col-md-6 col-xs-12 pull pull-left">
                <div class="form-group pull-left" style="width:100%;">
                  <div class="col-sm-12">
                    <textarea type="text" rows="4" cols="5" maxlength="500"
                      style="width:100%; height:180px; resize:none;" placeholder="Write Down Your Comment"
                      class="form-control" id="comment" name="comment"
                      autocomplete="off">{{ $order_data['order']['comment'] }}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">

            <input type="hidden" name="service_charge_rate" value="{{ $company_data['service_charge_value'] }}"
              autocomplete="off">
            <input type="hidden" name="vat_charge_rate" value="{{ $company_data['vat_charge_value'] }}"
              autocomplete="off">

            <button type="submit" onclick="disableClosedInputs(false)" class="btn btn-primary">Save Changes</button>
            <a href=" {{ URL::previous() }} " class="btn btn-warning">Back</a>
          </div>
        </form>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- col-md-12 -->
  </div>
  <!-- /.row -->


</section>
<!-- /.content -->

<script type="text/javascript">
  var base_url = "";

  $(document).ready(function() {
    setTimeout(function(){ window.location.reload(false); }, 120000);



    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#OrderMainNav").addClass('active');
    $("#manageOrderSubMenu").addClass("active");
    
    
    // Add new row in the table 
    $("#add_row").unbind('click').bind('click', function() {
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;

      $.ajax({
          url: '{{ route("order.tableRowProduct") }}',
          type: 'get',
          dataType: 'json',
          success:function(response) {

               var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+ 
                    '<select class="form-control select_group product" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getProductData('+row_id+')" '+"required"+'>'+
                        '<option value=""></option>';
                        $.each(response, function(index, value) {
                          html += '<option value="'+value.id+'">'+value.name+'</option>';             
                        });
                        
                      html += '</select>'+
                    '</td>'+ 
                    '<td><input type="number" name="qty[]" id="qty_'+row_id+'" required min="1" class="form-control" data-calculative="" onkeyup="getTotal('+row_id+')"><input type="hidden" name="is_game[]" id="is_game_'+row_id+'"></td>'+
                    '<td><input type="text" name="rate[]" id="rate_'+row_id+'" required class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_'+row_id+'" class="form-control"></td>'+
                    '<td><input type="text" name="amount[]" id="amount_'+row_id+'" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_'+row_id+'" class="form-control"></td>'+
                    '<td><button type="button" class="btn btn-default" name="remove_row" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';

                if(count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);  
                }
                else {
                  $("#product_info_table tbody").html(html);
                }

                $(".product").select2();

          }
        });

      return false;
    });

  }); // /document

  function getTotal(row = null) {
    if(row) {
      var total = Number($("#rate_value_"+row).val()) * Number($("#qty_"+row).val());
      total = total.toFixed(2);
      $("#amount_"+row).val(total);
      $("#amount_value_"+row).val(total);
      
      subAmount();

    } else {
      alert('no row !! please refresh the page');
    }
  }

  //this function will calculate order time 
  function calculateSpendTime(start,value){
    let diff = 1;
    let end = null;
    const calculative_inputs = $('input[type="number"][data-calculative="1"]');

    if(value == 3){
      if(calculative_inputs.length > 0){
        start = new Date(start);
        end = new Date();
        diff = (end - start)  / 60000;
        diff = Math.abs(Math.round(diff));
      }

      disableClosedInputs(true)
    }else {
      disableClosedInputs(false)
    }
    
    $('input[type="hidden"]#total_minutes').val(diff);
    $('input[type="hidden"]#end_time').val(end ? end.toLocaleString().replace(',',''): null);

    
    calculative_inputs.val(diff);
    calculative_inputs.keyup();

  }

  // disable select and qty input 
  function disableClosedInputs(val){
      $('input[id^="qty_"').prop('disabled',val);
      $('select[id^="product_"').prop('disabled',val);
      $('button#add_row').prop('disabled',val);
      $('button[name="remove_row"]').prop('disabled',val);
      $('select#table_name').prop('disabled',val);
  }

  // get the product information from the server
  function getProductData(row_id)
  {
    var product_id = $("#product_"+row_id).val();    
    if(product_id == "") {
      $("#rate_"+row_id).val("");
      $("#rate_value_"+row_id).val("");
      $("#amount_"+row_id).val("");
      $("#amount_value_"+row_id).val("");
      $("#qty_"+row_id).val("");           
      $("#qty_"+row_id).keyup()
      $("#is_game_"+row_id).val("");

    } else {
      $.ajax({
        url: "{{  url('/order/getProductValueById')  }}/"+String(product_id),
        type: 'get',
        data: {product_id : product_id},
        dataType: 'json',
        success:function(response) {
          // setting the rate value into the rate input field

          $("#rate_"+row_id).val(response.price);
          $("#rate_value_"+row_id).val(response.price);

          $("#qty_"+row_id).val(1);
          $("#qty_"+row_id).attr('data-calculative',response.is_game);
          $("#qty_value_"+row_id).val(1);
          $("#is_game_"+row_id).val(response.is_game);

           //if it is game then make it readonly
           if(response.is_game == true)
          $("#qty_"+row_id).prop('readonly',true);
          else
          $("#qty_"+row_id).prop('readonly',false);

          var total = Number(response.price) * 1;
          total = total.toFixed(2);
          $("#amount_"+row_id).val(total);
          $("#amount_value_"+row_id).val(total);
          
          subAmount();
        } // /success
      }); // /ajax function to fetch the product data 
    }
  }

  // calculate the total amount of the order
  function subAmount() {
    var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value']:0; ?>;
    var vat_charge = <?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value']:0; ?>;

    var tableProductLength = $("#product_info_table tbody tr").length;
    var totalSubAmount = 0;
    for(x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);

      totalSubAmount = Number(totalSubAmount) + Number($("#amount_"+count).val());
    } // /for

    totalSubAmount = totalSubAmount.toFixed(2);

    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

    // vat
    var vat = (Number($("#gross_amount").val())/100) * vat_charge;
    vat = vat.toFixed(2);
    $("#vat_charge").val(vat);
    $("#vat_charge_value").val(vat);

    // service
    var service = (Number($("#gross_amount").val())/100) * service_charge;
    service = service.toFixed(2);
    $("#service_charge").val(service);
    $("#service_charge_value").val(service);
    
    // total amount
    var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
    totalAmount = totalAmount.toFixed(2);
    // $("#net_amount").val(totalAmount);
    // $("#totalAmountValue").val(totalAmount);

    var discount = $("#discount").val();
    if(discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);
      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);
      
    } // /else discount 

    var paid_amount = Number($("#paid_amount").val());
    if(paid_amount) {
      var net_amount_value = Number($("#net_amount_value").val());
      var remaning = net_amount_value - paid_amount;
      $("#remaining").val(remaning.toFixed(2));
      $("#remaining_value").val(remaning.toFixed(2));
    }

  } // /sub total amount

  function paidAmount() {
    var grandTotal = $("#net_amount_value").val();

    if(grandTotal) {
      var dueAmount = Number($("#net_amount_value").val()) - Number($("#paid_amount").val());
      dueAmount = dueAmount.toFixed(2);
      $("#remaining").val(dueAmount);
      $("#remaining_value").val(dueAmount);
    } // /if
  } // /paid amoutn function

  function removeRow(tr_id)
  {
    $("#product_info_table tbody tr#row_"+tr_id).remove();
    subAmount();
  }
</script>
@endsection