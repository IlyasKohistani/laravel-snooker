@extends('layouts/app')

@section('pageTitle')
Manage Tables
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Manage
    <small>Tables</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Tables</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-12 col-xs-12">

      <div id="messages"></div>

      @if(in_array('createTable', $user_permission))
      <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Table</button>
      <br /> <br />

      @endif


      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage Tables</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="manageTable" cellspacing="0" class="display nowrap table table-bordered table-striped"
            style="width: 100%">
            <thead>
              <tr>
                <th>Store</th>
                <th>Table name</th>
                <th>Capacity</th>
                <th>Available</th>
                <th>Status</th>
                @if(in_array('updateTable', $user_permission) || in_array('deleteTable', $user_permission))
                <th>Action</th>
                @endif
              </tr>
            </thead>
            <tbody>

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


</section>
<!-- /.content -->

@if(in_array('createTable', $user_permission))
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add table</h4>
      </div>

      <form role="form" action="{{ route('table.store') }}" method="POST" id="createForm">
        @csrf
        <div class="modal-body">

          <div class="form-group">
            <label for="brand_name">Table Name</label>
            <input type="text" class="form-control" id="table_name" name="table_name" placeholder="Enter table name"
              autocomplete="off">
          </div>

          <div class="form-group">
            <label for="brand_name">Capacity</label>
            <input type="number" class="form-control" id="capacity" min="1" max="15" name="capacity"
              placeholder="Enter capacity" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="active">Status</label>
            <select class="form-control" id="active" name="active">
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>
          </div>

          <div class="form-group">
            <label for="active">Store</label>
            <select class="form-control" id="store" name="store">
              @foreach ($store_data as $v)
              <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
              @endforeach
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif

@if(in_array('updateTable', $user_permission))
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit table</h4>
      </div>

      <form role="form" action="" method="Post" id="updateForm">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="brand_name">Table Name</label>
            <input type="text" class="form-control" id="edit_table_name" name="edit_table_name"
              placeholder="Enter table name" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="brand_name">Capacity</label>
            <input type="number" class="form-control" id="edit_capacity" min="1" max="15" name="edit_capacity"
              placeholder="Enter capacity" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="active">Status</label>
            <select class="form-control" id="edit_active" name="edit_active">
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>
          </div>

          <div class="form-group">
            <label for="active">Store</label>
            <select class="form-control" id="edit_store" name="edit_store">
              @foreach ($store_data as $v)
              <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
              @endforeach
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif

@if(in_array('deleteTable', $user_permission))
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove table</h4>
      </div>

      <form role="form" action="" method="post" id="removeForm">
        @csrf
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif



<script type="text/javascript">
  var manageTable;
var base_url = "";


$(document).ready(function() {
  $('#tablesMainNav').addClass('active');
  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + "{{ route('table.data') }}",
    'order': []
  });

  // submit the create from 
  $("#createForm").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTable.ajax.reload(null, false); 

        if(response.success === true) {
          $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          '</div>');


          // hide the modal
          $("#addModal").modal('hide');

          // reset the form
          $("#createForm")[0].reset();
          $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#"+index);

              id.closest('.form-group')
              .removeClass('has-error')
              .removeClass('has-success')
              .addClass(value.length > 0 ? 'has-error' : 'has-success');
              
              id.after(value);

            });
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      }
    }); 

    return false;
  });

  //on delete form submit
  $("#removeForm").unbind('submit').on('submit', function() {
      var form = $(this);
      const id = form.attr('data-id');
      

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: "{{ url('table') }}/"+id,
        type: "POST",
        data: { table_id:id,
            "_method":'DELETE',
            "_token": "{{ csrf_token() }}"}, 
        dataType: 'json',
        success:function(response) {
          // hide the modal
          $("#removeModal").modal('hide');


          manageTable.ajax.reload(null, false); 
          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });

});

// edit function
function editFunc(id)
{ 
  $.ajax({
    url: base_url + "{{ url('/table') }}/"+ id +"/edit",
    type: 'GET',
    dataType: 'json',
    success:function(response) {

      $("#edit_table_name").val(response.table_name);
      $("#edit_capacity").val(response.capacity);
      $("#edit_active").val(response.active);
      $("#edit_store").val(response.store_id);

      // submit the edit from 
      $("#updateForm").unbind('submit').bind('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + "table/"+ id ,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success:function(response) {

            manageTable.ajax.reload(null, false); 

            if(response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              '</div>');


              // hide the modal
              $("#editModal").modal('hide');
              // reset the form 
              $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

            } else {

              if(response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var id = $("#"+index);

                  id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');
                  
                  id.after(value);

                });
              } else {
                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                '</div>');
              }
            }
          }
        }); 

        return false;
      });

    }
  });
}

// remove functions 
function removeFunc(id)
{
  $("#removeForm").attr('data-id',id);
}


</script>

@endsection