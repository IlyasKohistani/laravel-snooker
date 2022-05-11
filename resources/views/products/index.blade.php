@extends('layouts/app')

@section('pageTitle')
Products
@endsection

@section('content')



<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Manage
    <small>Products</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Products</li>
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
        @foreach ($errors->all() as $error)
        {{$error}}
        @endforeach
      </div>
      @endif

      @if(in_array('createProduct', $user_permission))
      <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
      @endif
      @if(in_array('viewProduct', $user_permission))
      <a href="{{ route('product.list') }}" class="btn btn-success">View Product</a>
      @endif
      <br /> <br />

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage Products</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="manageTable" class="table table-bordered table-striped" style="width: 100%">
            <thead>
              <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Store</th>
                <th>Status</th>
                @if(in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission))
                <th>Action</th>
                @endif
              </tr>
            </thead>

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

@if(in_array('deleteProduct', $user_permission))
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Product</h4>
      </div>

      <form role="form" action="" method="post" id="removeForm">
        @csrf
        @method('delete')
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

  $("#productMainNav").addClass('active');
  $("#manageProductSubMenu").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': "{{ route('product.data') }}",
    'order': []
  });

});

// remove functions 
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: "{{ url('product') }}/" + id,
        type: 'POST',
        data: { product_id:id,
          "_method": "DELETE",
          "_token": "{{ csrf_token() }}" }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeModal").modal('hide');

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
  }
}


</script>

@endsection