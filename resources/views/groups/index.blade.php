@extends('layouts/app')

@section('pageTitle')
groups
@endsection

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Manage
        <small>Groups</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">groups</li>
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
            @if (in_array('createGroup', $user_permission))
            <a href="{{ route('group.create') }}" class="btn btn-primary">Add Group</a>
            <br />
            <br />
            @endif

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Manage Groups</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="groupTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Group Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($groups_data)
                            @foreach ($groups_data as $group)
                            <tr>
                                <td>{{$group['group_name']}} </td>
                                <td>
                                    @if (in_array('updateGroup', $user_permission))
                                    <a href="{{ route('group.edit', ['group' => $group['id']]) }}"
                                        class="btn btn-default"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if (in_array('deleteGroup', $user_permission))
                                    <a href="{{ route('group.destroy', ['group' => $group['id']]) }}"
                                        class="btn delete-confirm btn-default"><i class="fa fa-trash"></i></a>
                                    @endif

                                </td>
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
           $('#groupTable').DataTable({
             'order': []
           });
           $('#groupMainNav').addClass('active');
           $('#manageGroupSubMenu').addClass('active');
         });
</script>

@endsection