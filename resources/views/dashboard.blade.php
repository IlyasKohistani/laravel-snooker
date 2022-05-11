@extends('layouts.app')

@section('pageTitle')
Dashboard
@endsection
@if (!$is_admin)
<style>
  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
    padding: 6px 2px 6px 6px;
    ;
  }

  .small-box .icon .fa-table {
    font-size: 60px;
    transition: all .5s;
  }

  .small-box .icon .fa-table:hover {
    font-size: 65px;
  }

  .small-box .btn-link:active,
  .small-box .btn-link:focus {
    outline: none !important;
  }

  .name {
    font-size: 26px !important;
    font-weight: bold !important;
    letter-spacing: 1px;
    margin-top: 10px !important;
    font-family: initial !important;
    color: #eee;
  }

  .capacity {
    font-size: 18px;
    font-weight: bold;
    font-family: initial !important;
    color: #eee;
  }
</style>
@endif

@section('content')


<!--                      *            Admin Section                          *                          -->

@if($is_admin == true)
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $total_products }}</h3>
          <p>Total Products</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="product" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $total_paid_orders }}</h3>
          <p>Total Paid Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="order" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{ $total_users }}</h3>
          <p>Total Users</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-people"></i>
        </div>
        <a href="users" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ $total_stores }} </h3>
          <p>Total Stores</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-home"></i>
        </div>
        <a href="store" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->
@endif


<!--                      *            Waiter Section                          *                          -->



@if ($is_waiter && !$is_admin)
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Waiter panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
    <li id="timer" class="active"></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">

    @if (session()->has('success'))
    <div class="col-md-12 col-xs-12">
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        {{ session()->get('success') }}
      </div>
    </div>
    @endif
    @if ($errors->any())
    <div class="col-md-12 col-xs-12">
      <div class="alert alert-error alert-dismissible" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        {{$errors->all()[0]}}
      </div>
    </div>
    @endif



    <div id="waiterSection" class="col-lg-12 col-md-12 col-xs-12">

    </div>



  </div>
  <!-- /.row -->

</section>
<!-- /.content -->

@if(in_array('createOrder', $user_permission))
<!-- create brand modal -->
<div class="modal  fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Order</h4>
      </div>

      <form role="form" id="createForm" action="{{ route('order.store') }}" method="post" class="form-horizontal">
        @csrf
        <div class="box-body">
          <br />
          <div class="col-md-6 col-xs-12 pull pull-right">
            <div class="form-group">
              <label for="gross_amount" class="col-sm-12 control-label">Date:
                {{ now()->format('Y-m-d').' '.now()->format('h:i A') }}</label>
            </div>
          </div>

          <div class="col-md-6 col-xs-12 pull pull-left">

            <div class="form-group">
              <label for="gross_amount" class="col-sm-12 col-md-3 " style="text-align:left;">Table</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="txt_table_name" disabled>
                <input id="table_name" name="table_name" hidden>

              </div>
            </div>

          </div>


          <br />
          <table class="table table-bordered" id="product_info_table">
            <thead>
              <tr>
                <th style="width:50%">Product</th>
                <th style="width:10%">Qty</th>
                <th style="width:10%">Rate</th>
                <th style="width:20%">Amount</th>
                <th style="width:10%"><button type="button" id="add_row" class="btn btn-default"><i
                      class="fa fa-plus"></i></button></th>
              </tr>
            </thead>

            <tbody>
              <tr id="row_1">
                <td>
                  <select class="form-control select_group product" data-row-id="row_1" id="product_1" name="product[]"
                    style="width:100%;" onchange="getProductData(1)" required>
                    <option value=""></option>
                    @foreach ($products as $k => $v)
                    <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                    @endforeach
                  </select>
                </td>
                <td><input type="number" name="qty[]" min="1" id="qty_1" class="form-control" required
                    onkeyup="getTotal(1)">
                  <input type="hidden" name="is_game[]" id="is_game_1">
                </td>
                <td>
                  <input type="text" name="rate[]" id="rate_1" class="form-control" disabled autocomplete="off">
                  <input type="hidden" name="rate_value[]" id="rate_value_1" class="form-control" autocomplete="off">
                </td>
                <td>
                  <input type="text" name="amount[]" id="amount_1" class="form-control" disabled autocomplete="off">
                  <input type="hidden" name="amount_value[]" id="amount_value_1" class="form-control"
                    autocomplete="off">
                </td>
                <td><button type="button" class="btn btn-default" onclick="removeRow('1')"><i
                      class="fa fa-close"></i></button></td>
              </tr>
            </tbody>
          </table>

          <br />

          <div class="col-md-6 col-xs-12 pull pull-right">

            <div class="form-group">
              <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled
                  autocomplete="off">
                <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value"
                  autocomplete="off">
              </div>
            </div>
            @if($is_service_enabled)
            <div class="form-group">
              <label for="service_charge" class="col-sm-5 control-label">S-Charge
                {{ $company_data['service_charge_value'] }} %</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="service_charge" name="service_charge" disabled
                  autocomplete="off">
                <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value"
                  autocomplete="off">
              </div>
            </div>
            @endif
            @if($is_vat_enabled)
            <div class="form-group">
              <label for="vat_charge" class="col-sm-5 control-label">Vat
                {{ $company_data['vat_charge_value'] }} %</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="vat_charge" name="vat_charge" disabled autocomplete="off">
                <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value"
                  autocomplete="off">
              </div>
            </div>
            @endif
            <div class="form-group">
              <label for="disc" class="col-sm-5 control-label">Discount</label>
              <div class="col-sm-7">
                <input type="number" class="form-control" id="disc" disabled name="disc" placeholder="0"
                  autocomplete="off">
                <input type="hidden" class="form-control" id="discount" name="discount" onkeyup="subAmount()"
                  autocomplete="off">

              </div>
            </div>
            <div class="form-group">
              <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="net_amount" name="net_amount" disabled autocomplete="off">
                <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value"
                  autocomplete="off">
              </div>
            </div>

          </div>


        </div>
        <!-- /.box-body -->

        <div class="box-footer text-center">
          <input type="hidden" name="service_charge_rate" value="{{ $company_data['service_charge_value'] }}"
            autocomplete="off">
          <input type="hidden" name="vat_charge_rate" value="{{  $company_data['vat_charge_value'] }}"
            autocomplete="off">
          <button type="submit" class="btn btn-primary ">Create Order</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif
@endif




<!--                                  *all scripts related to waiter data                          -->
@if ($is_waiter && !$is_admin)
<script type="text/javascript">
  var base_url = "";


  //fetch tables with data from database
  function fetchWaiterTables() {
    $.ajax({
      url: '{{ route("dashboard.waiter") }}',
      type: 'GET',
      dataType: 'html',
      success:function(response) {
        $('#waiterSection').html(response);
      }});
  }


  //count time and set it to span
  function animateValue(id, start, end, duration) {
    var range = end - start;
    var current = start;
    var increment = end > start? 1 : -1;
    var stepTime = Math.abs(Math.floor(duration / range));
    var obj = document.getElementById(id);
    var timer = setInterval(function() {
        current += increment;
        obj.innerHTML = current +"s  &#128336; ";
        if (current <= 10) {
            $('#'+id).css('color', 'red');
        }else if(current <= 30){
            $('#'+id).css('color', '#ffbb00');
        }else{
            $('#'+id).css('color', 'green');
        }

        if (current == end) {
            clearInterval(timer);
            animateValue("timer", 60, 0, 60000);
            fetchWaiterTables();
            // window.location.reload(false);
        }
    }, stepTime);
  }

  fetchWaiterTables();
  animateValue("timer", 60, 0, 60000);




  //clear table input text and append selected table data set table id
  function tableId(id,name){
  if(id) {
  $("#table_name").val(id);
  $("#txt_table_name").val(name);
  }
  }

  $(document).ready(function() {

    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#dashboardMainMenu").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
  
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
            
              // console.log(reponse.x);
               var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+ 
                    '<select class="form-control select_group product"  data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getProductData('+row_id+')"  '+"required"+'>'+
                        '<option value=""></option>';
                        $.each(response, function(index, value) {
                          html += '<option value="'+value.id+'">'+value.name+'</option>';             
                        });
                        
                      html += '</select>'+
                    '</td>'+ 
                    '<td><input type="number" name="qty[]" min="1" id="qty_'+row_id+'" class="form-control" onkeyup="getTotal('+row_id+')"><input type="hidden" name="is_game[]" id="is_game_'+row_id+'"></td>'+
                    '<td><input type="text" name="rate[]" id="rate_'+row_id+'" class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_'+row_id+'" class="form-control"></td>'+
                    '<td><input type="text" name="amount[]" id="amount_'+row_id+'" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_'+row_id+'" class="form-control"></td>'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
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


  //count the total amount of number of quantity
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

  // get the product information from the server
  function getProductData(row_id)
  {
    var product_id = $("#product_"+row_id).val();    
    if(product_id == "") {
      $("#rate_"+row_id).val("");
      $("#rate_value_"+row_id).val("");

      $("#qty_"+row_id).val("");
      $("#qty_"+row_id).keyup();

      $("#is_game_"+row_id).val("");           

      $("#amount_"+row_id).val("");
      $("#amount_value_"+row_id).val("");

    } else {
      $.ajax({
        url: "{{  url('/order/getProductValueById')  }}/"+String(product_id),
        type: 'GET',
        data: {product_id : product_id},
        dataType: 'json',
        success:function(response) {
          // setting the rate value into the rate input field
          
          $("#rate_"+row_id).val(response.price);
          $("#rate_value_"+row_id).val(response.price);

          $("#qty_"+row_id).val(1);
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

  } // /sub total amount

  function removeRow(tr_id)
  {
    $("#product_info_table tbody tr#row_"+tr_id).remove();
    subAmount();
  }
</script>
@endif

@endsection