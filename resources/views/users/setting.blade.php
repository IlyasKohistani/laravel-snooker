@extends('layouts/app')

@section('pageTitle')
Setting
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    User
    <small>Setting</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Setting</li>
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
          <h3 class="box-title">Update Information</h3>
        </div>
        <!-- /.box-header -->
        <form role="form" action="{{ route('user.updateSetting') }}" method="post">
          @csrf
          <div class="box-body">


            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                value="{{ $user_data['username'] }}" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                value="{{ $user_data['email'] }}" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="firstname">First name</label>
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name"
                value="{{ $user_data['firstname'] }}" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="lastname">Last name</label>
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name"
                value="{{ $user_data['lastname'] }}" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone"
                value="{{ $user_data['phone'] }}" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="gender">Gender</label>
              <div class="radio">
                <label>
                  <input type="radio" name="gender" id="male" value="1" @if($user_data['gender']==1) checked @endif>
                  Male
                </label>
                <label>
                  <input type="radio" name="gender" id="female" value="2" @if($user_data['gender']==2) checked @endif>
                  Female
                </label>
              </div>
            </div>

            <div class="form-group">
              <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                Leave the password field empty if you don't want to change.
              </div>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="text" class="form-control" id="password" name="password" placeholder="Password"
                autocomplete="off">
            </div>

            <div class="form-group">
              <label for="cpassword">Confirm password</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                placeholder="Confirm Password" autocomplete="off">
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

  </div>
  <!-- /.row -->


</section>
<!-- /.content -->

<script type="text/javascript">
  $(document).ready(function() {
      $("#settingMainNav").addClass('active');
    });
</script>
@endsection