@extends('layouts/app')

@section('pageTitle')
Create User
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Manage
    <small>Users</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Users</li>
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
          <h3 class="box-title">Add User</h3>
        </div>
        <form role="form" action="{{ route('users.store') }}" method="post">
          <div class="box-body">
            @csrf


            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                autocomplete="off">
            </div>

            <div class="form-group">
              <label for="firstname">First name</label>
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name"
                autocomplete="off">
            </div>

            <div class="form-group">
              <label for="lastname">Last name</label>
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name"
                autocomplete="off">
            </div>


            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
            </div>


            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="group">Groups</label>
              <select class="form-control" id="group" name="group">
                <option value="">Select Groups</option>
                @foreach ($group_data as $v)
                <option value="{{  $v['id'] }}">{{ $v['group_name'] }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="store">Stores</label>
              <select class="form-control" id="store" name="store">
                <option value="">Select store</option>
                @foreach ($store_data as $v)
                <option value="{{  $v['id'] }}">{{ $v['name'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                autocomplete="off">
            </div>

            <div class="form-group">
              <label for="cpassword">Confirm password</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                placeholder="Confirm Password" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="gender">Gender</label>
              <div class="radio">
                <label>
                  <input type="radio" name="gender" id="male" value="1">
                  Male
                </label>
                <label>
                  <input type="radio" name="gender" id="female" value="2">
                  Female
                </label>
              </div>
            </div>

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('users.index') }}" class="btn btn-warning">Back</a>
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
    $("#groups").select2();

    $("#userMainNav").addClass('active');
    $("#createUserSubNav").addClass('active');
    
  });
</script>
@endsection