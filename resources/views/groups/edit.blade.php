@extends('layouts.app')

@section('pageTitle')
Edit Groups
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
     <h1>
          Manage
          <small>Groups</small>
     </h1>
     <ol class="breadcrumb">
          <li><a href="/dashboad"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="/groups">Groups</a></li>
          <li class="active">Edit</li>
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
                         <h3 class="box-title">Edit Group</h3>
                    </div>
                    <form action="{{ route('group.update', ['group' => $group_data['id']]) }}" method="post">
                         @csrf
                         {{ method_field('PATCH') }}
                         <div class="box-body">

                              <div class="form-group">
                                   <label for="group_name">Group Name</label>
                                   <input type="text" class="form-control" id="group_name" name="group_name"
                                        placeholder="Enter group name" value="{{ $group_data['group_name'] }}"
                                        autocomplete="off">
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
                                                  <td><input type="checkbox" name="permission[]" id="permission1"
                                                            value="createUser" @if($serialize_permission)
                                                            @if(in_array('createUser', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updateUser" @if($serialize_permission)
                                                            @if(in_array('updateUser', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="viewUser" @if($serialize_permission)
                                                            @if(in_array('viewUser', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="deleteUser" @if($serialize_permission)
                                                            @if(in_array('deleteUser', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Groups</td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="createGroup" @if($serialize_permission)
                                                            @if(in_array('createGroup', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updateGroup" @if($serialize_permission)
                                                            @if(in_array('updateGroup', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="viewGroup" @if($serialize_permission)
                                                            @if(in_array('viewGroup', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="deleteGroup" @if($serialize_permission)
                                                            @if(in_array('deleteGroup', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Stores</td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="createStore" @if($serialize_permission)
                                                            @if(in_array('createStore', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updateStore" @if($serialize_permission)
                                                            @if(in_array('updateStore', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="viewStore" @if($serialize_permission)
                                                            @if(in_array('viewStore', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="deleteStore" @if($serialize_permission)
                                                            @if(in_array('deleteStore', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Tables</td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="createTable" @if($serialize_permission)
                                                            @if(in_array('createTable', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updateTable" @if($serialize_permission)
                                                            @if(in_array('updateTable', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="viewTable" @if($serialize_permission)
                                                            @if(in_array('viewTable', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="deleteTable" @if($serialize_permission)
                                                            @if(in_array('deleteTable', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Category</td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="createCategory" @if($serialize_permission)
                                                            @if(in_array('createCategory', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updateCategory" @if($serialize_permission)
                                                            @if(in_array('updateCategory', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="viewCategory" @if($serialize_permission)
                                                            @if(in_array('viewCategory', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="deleteCategory" @if($serialize_permission)
                                                            @if(in_array('deleteCategory', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Product</td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="createProduct" @if($serialize_permission)
                                                            @if(in_array('createProduct', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updateProduct" @if($serialize_permission)
                                                            @if(in_array('updateProduct', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="viewProduct" @if($serialize_permission)
                                                            @if(in_array('viewProduct', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="deleteProduct" @if($serialize_permission)
                                                            @if(in_array('deleteProduct', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Orders</td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="createOrder" @if($serialize_permission)
                                                            @if(in_array('createOrder', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updateOrder" @if($serialize_permission)
                                                            @if(in_array('updateOrder', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="viewOrder" @if($serialize_permission)
                                                            @if(in_array('viewOrder', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="deleteOrder" @if($serialize_permission)
                                                            @if(in_array('deleteOrder', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Report</td>
                                                  <td> - </td>
                                                  <td> - </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="viewReport" @if($serialize_permission)
                                                            @if(in_array('viewReport', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td> - </td>
                                             </tr>
                                             <tr>
                                                  <td>Company</td>
                                                  <td> - </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updateCompany" @if($serialize_permission)
                                                            @if(in_array('updateCompany', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td> - </td>
                                                  <td> - </td>
                                             </tr>
                                             <tr>
                                                  <td>Profile</td>
                                                  <td> - </td>
                                                  <td> - </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="viewProfile" @if($serialize_permission)
                                                            @if(in_array('viewProfile', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td> - </td>
                                             </tr>
                                             <tr>
                                                  <td>Setting</td>
                                                  <td> - </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updateSetting" @if($serialize_permission)
                                                            @if(in_array('updateSetting', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
                                                  </td>
                                                  <td> - </td>
                                                  <td> - </td>
                                             </tr>
                                             <tr>
                                                  <td>Payment</td>
                                                  <td> - </td>
                                                  <td><input type="checkbox" name="permission[]" id="permission"
                                                            value="updatePayment" @if($serialize_permission)
                                                            @if(in_array('updatePayment', $serialize_permission))
                                                            {{"checked"}} @endif @endif>
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
                              <button type="submit" class="btn btn-primary">Update
                                   Changes</button>
                              <a href="{{ route('group.index') }}" class="btn btn-warning">Back</a>
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
      $('#manageGroupSubMenu').addClass('active');
    });
</script>
@endsection