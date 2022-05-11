@extends('layouts.app')

@section('pageTitle')
Company Info
@endsection

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Manage
    <small>Company</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">company</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-12 col-xs-12">

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
        @foreach ($errors->all() as $error)
        {{$error}}
        @endforeach
      </div>
      @endif

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage Company Information</h3>
        </div>
        <form role="form" action="company/update" method="post">
          @csrf
          <div class="box-body">

            <div class="form-group">
              <label for="company_name">Company Name</label>
              <input type="text" class="form-control" id="company_name" name="company_name"
                placeholder="Enter company name" value="{{ $company_data['company_name'] }}" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="service_charge_value">Service Charge Amount (%)</label>
              <input type="number" min="0" max="100" class="form-control" id="service_charge_value"
                name="service_charge_value" placeholder="Enter charge amount %"
                value="{{ $company_data['service_charge_value'] }}" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="vat_charge_value">Vat Charge (%)</label>
              <input type="number" min="0" max="100" class="form-control" id="vat_charge_value" name="vat_charge_value"
                placeholder="Enter vat charge %" value="{{ $company_data['vat_charge_value'] }}" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="Enter address"
                value="{{ $company_data['address'] }}" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone"
                value="{{ $company_data['phone'] }}" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="country">Country</label>
              <input type="text" class="form-control" id="country" name="country" placeholder="Enter country"
                value="{{ $company_data['country'] }}" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea class="form-control" id="message" name="message">
                     {{ $company_data['message'] }}
                  </textarea>
            </div>
            <div class="form-group">
              <label for="currency">Currency</label>

              <select class="form-control" id="currency" name="currency">
                <option value="">~~SELECT~~</option>

                @foreach ($currency_symbols as $k => $v)
                <option value="{{ $k }}" @if($company_data['currency']==$k) selected='selected' @endif>{{ $k }}</option>
                @endforeach
              </select>
            </div>

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
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
    $("#companyMainNav").addClass('active');
    $("#message").wysihtml5();
  });
</script>
@endsection