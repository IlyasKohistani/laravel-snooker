@extends('layouts/app')

@section('pageTitle')
Profile
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    User
    <small>Profile</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Profile</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-12 col-xs-12">

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">{{ $user_data['firstname'].' '.$user_data['lastname'] }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-condensed table-hovered">
            <tr>
              <th>Username</th>
              <td>{{ $user_data['username'] }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{ $user_data['email'] }}</td>
            </tr>
            <tr>
              <th>First Name</th>
              <td>{{ $user_data['firstname'] }}</td>
            </tr>
            <tr>
              <th>Last Name</th>
              <td>{{ $user_data['lastname'] }}</td>
            </tr>
            <tr>
              <th>Gender</th>
              <td>{{ ($user_data['gender'] == 1) ? 'Male' : 'Female' }}</td>
            </tr>
            <tr>
              <th>Phone</th>
              <td>{{ $user_data['phone'] }}</td>
            </tr>
            <tr>
              <th>Group</th>
              <td><span class="label label-info">{{ $user_group['group_name'] }}</span></td>
            </tr>
          </table>
        </div>
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
      $("#profileMainNav").addClass('active');
    });
</script>

@endsection