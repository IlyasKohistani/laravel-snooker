@extends('layouts.app')

@section('pageTitle')
Create Groups
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

                  <div class="box">
                        <div class="box-header">
                              <h3 class="box-title">Add Group</h3>
                        </div>
                        <form role="form" action="{{ route('group.store') }}" method="post">
                              @csrf
                              <div class="box-body">


                                    <div class="form-group">
                                          <label for="group_name">Group Name</label>
                                          <input type="text" class="form-control" id="group_name" name="group_name"
                                                placeholder="Enter group name" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                          <label for="permission">Permission</label>

                                          <table class="table table-responsive">
                                                <thead>
                                                      <tr>
                                                            <th></th>
                                                            <th>Create</th>
                                                            <th>Update</th>
                                                            <th>View</th>
                                                            <th>Delete</th>
                                                      </tr>
                                                </thead>
                                                <tbody>
                                                      <tr>
                                                            <td>Users</td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="createUser">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updateUser">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="viewUser">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="deleteUser">
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Groups</td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="createGroup">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updateGroup">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="viewGroup">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="deleteGroup">
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Stores</td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="createStore">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updateStore">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="viewStore">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="deleteStore">
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Tables</td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="createTable">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updateTable">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="viewTable">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="deleteTable">
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Category</td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="createCategory">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updateCategory">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="viewCategory">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="deleteCategory">
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Product</td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="createProduct">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updateProduct">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="viewProduct">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="deleteProduct">
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Orders</td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="createOrder">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updateOrder">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="viewOrder">
                                                            </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="deleteOrder">
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Report</td>
                                                            <td> - </td>
                                                            <td> - </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="viewReport">
                                                            </td>
                                                            <td> - </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Company</td>
                                                            <td> - </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updateCompany">
                                                            </td>
                                                            <td> - </td>
                                                            <td> - </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Profile</td>
                                                            <td> - </td>
                                                            <td> - </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="viewProfile">
                                                            </td>
                                                            <td> - </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Setting</td>
                                                            <td> - </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updateSetting">
                                                            </td>
                                                            <td> - </td>
                                                            <td> - </td>
                                                      </tr>
                                                      <tr>
                                                            <td>Payment</td>
                                                            <td> - </td>
                                                            <td><input type="checkbox" name="permission[]"
                                                                        id="permission" value="updatePayment">
                                                            </td>
                                                            <td> - </td>
                                                            <td> - </td>
                                                      </tr>
                                                </tbody>
                                          </table>

                                    </div>
                              </div>
                              <!-- /.box-body -->

                              <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Save
                                          Changes</button>
                                    <a href="/group" class="btn btn-warning">Back</a>
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
      $('#groupMainNav').addClass('active');
      $('#createGroupSubMenu').addClass('active');
    });
</script>


@endsection