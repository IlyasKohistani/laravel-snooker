@extends('layouts/app')

@section('pageTitle')
Users
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Manage
    <small>Users</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
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
      @if (in_array('createUser', $user_permission))
      <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
      <br />
      <br />
      @endif


      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage Users</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="userTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Group</th>

                @if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission))
                <th>Action</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @if($user_data)
              @foreach ($user_data as $v)
              <tr>
                <td>{{  $v['user_info']['username'] }}</td>
                <td>{{  $v['user_info']['email'] }}</td>
                <td>{{  $v['user_info']['firstname'] .' '. $v['user_info']['lastname'] }}</td>
                <td>{{  $v['user_info']['phone'] }}</td>
                <td>{{  $v['user_group']['group_name'] }}</td>

                @if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission))

                <td>
                  @if(in_array('updateUser', $user_permission))
                  <a href="{{route('users.edit', $v['user_info']['id'])}}" class="btn btn-default"><i
                      class="fa fa-edit"></i></a>
                  @endif
                  @if(in_array('deleteUser', $user_permission))
                  <a href="{{ route('users.destroy', $v['user_info']['id']) }}"
                    class="btn delete-confirm btn-default"><i class="fa fa-trash"></i></a>
                  @endif
                </td>
                @endif
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- col-md-12 -->
  </div>
  <!-- /.row -->
  <form id="delete_form" class="delete-form" method="POST">
    @method('delete')
    @csrf
  </form>

</section>
<!-- /.content -->
@include('errors.swalAlert')

<script type="text/javascript">
  $(document).ready(function() {
      $('#userTable').DataTable({
        'order' : [],
        });

      $("#userMainNav").addClass('active');
      $("#manageUserSubNav").addClass('active');
    });
</script>
@endsection