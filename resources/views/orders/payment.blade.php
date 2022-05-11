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
          <h3 class="box-title">Payment</h3>
        </div>
        <!-- /.box-header -->
        <form role="form" action="{{ route('order.pay',$order_data['order']['id']) }}" method="post"
          class="form-horizontal">
          @csrf
          <div class="box-body">


            <div class="form-group">

              <label for="date" class="col-sm-12 control-label">Date: {{
                $order_data['order']['created_at']->format('d-m-Y') }}@if(!empty($order_data['order']['end_time'])), {{
                $order_data['order']['total_minutes'] }}m @endif</label>

              <label for="time" class="col-sm-12 control-label">Time: {{
                $order_data['order']['created_at']->format('h:i
                A') }}@if($order_data['order']['end_time']) - {{
                $order_data['order']['end_time']->format('h:i A') }} @endif</label>
            </div>

            @if ($order_data['order_table'])
            <div class="col-md-4 col-xs-12 pull pull-left">
              <div class="form-group">
                <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Table</label>
                <div class="col-sm-7">
                  <select class="form-control" id="table_name" name="table_name" disabled>
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
                  <th style="width:55%">Product</th>
                  <th style="width:15%">Qty</th>
                  <th style="width:10%">Rate</th>
                  <th style="width:20%">Amount</th>
                </tr>
              </thead>

              <tbody>

                @if(isset($order_data['order_item']))
                @php $x = 1; @endphp
                @foreach ($order_data['order_item'] as $key => $val)
                <tr id="row_{{$x}}">
                  <td>
                    <select class="form-control select_group product" disabled data-row-id="row_{{ $x }}"
                      id="product_{{ $x }}" name="product[]" style="width:100%;" required>
                      <option value=""></option>
                      @foreach ($products as $k => $v)
                      <option value="{{ $v['id'] }}" @if($val->pivot->product_id==$v['id']) selected='selected' @endif>
                        {{ $v['name'] }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td><input type="text" name="qty[]" id="qty_{{ $x }}" class="form-control" disabled required
                      value="{{ $val->pivot->qty }}" autocomplete="off"></td>
                  <td>
                    <input type="text" name="rate[]" id="rate_{{ $x }}" class="form-control" disabled
                      value="{{ $val->pivot->rate }}" autocomplete="off">
                    <input type="hidden" name="rate_value[]" id="rate_value_{{ $x }}" class="form-control"
                      value="{{ $val->pivot->rate }}" autocomplete="off">
                  </td>
                  <td>
                    <input type="text" name="amount[]" id="amount_{{ $x }}" class="form-control" disabled
                      value="{{ $val->pivot->amount }}" autocomplete="off">
                    <input type="hidden" name="amount_value[]" id="amount_value_{{ $x }}" class="form-control"
                      value="{{ $val->pivot->amount }}" autocomplete="off">
                  </td>
                </tr>
                @php $x++ @endphp
                @endforeach
                @endif
              </tbody>
            </table>

            <br /> <br />

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
                    value="{{ $order_data['order']['discount'] }} " autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="net_amount" name="net_amount" disabled
                    value="{{ $order_data['order']['net_amount'] }} " autocomplete="off">
                  <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value"
                    value="{{ $order_data['order']['net_amount'] }} " autocomplete="off">
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
            <button type="submit" class="btn btn-primary">Pay</button>
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
  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#OrderMainNav").addClass('active');
    $("#manageOrderSubMenu").addClass("active");

  

  }); // /document


</script>
@endsection