@extends('layouts/app')

@section('pageTitle')
Orders
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Manage
    <small>Orders</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Orders</li>
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
        {{$errors->all()[0]}}
      </div>
      @endif

      @if(in_array('createOrder', $user_permission))
      <a href="{{ route('order.create') }}" class="btn btn-primary">Add Order</a>
      <br /> <br />
      @endif

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage Orders</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="manageTable" class="table table-bordered table-striped datatable display" cellspacing="0"
            width="100%">
            <thead>
              <tr>
                <th>Bill no</th>
                <th>Table</th>
                <th>Ordered By</th>
                <th>Date Time</th>
                <th>Total Products</th>
                <th>Total Amount</th>
                <th>status</th>
                @if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) ||
                in_array('updatePayment', $user_permission) || in_array('deleteOrder', $user_permission))
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

@if(in_array('deleteOrder', $user_permission))
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Order</h4>
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

  $("#OrderMainNav").addClass('active');
  $("#manageOrderSubMenu").addClass('active');

  function fetchProducts(){
  var fetch_data = '';
  var element = $(this);
  var id = element.attr('id');
  $.ajax({
    url: '{{ url("/order/index/fetchProducts") }}/'+id,
    method: "get",
    async: false,
    data:{id:id},
    success:function(data){
      fetch_data = data;
    }
  });
  
  return fetch_data;
}

  
  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    "responsive": true,
    "drawCallback": function( settings ) {
      $(".hover_show_products").popover({
      title:'Ordered Products',
      content:fetchProducts,
      html:true,
      trigger:"focus",
      placement:'top'
      });
      $(".hover_show_comment").popover({
      trigger:"hover",
      placement:'top'
      });
      },
    'ajax': base_url + '{{ route("order.data") }}',  
    'order': []
  });
  
  window.onresize = function(){
    var w = this.innerWidth;
    manageTable.column(0).visible(w > 780);
    manageTable.column(2).visible(w > 640);
    manageTable.column(3).visible(w > 500);
    manageTable.column(4).visible(w > 400);
  }
  $(window).trigger('resize');

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
        url: '{{ url("order") }}/'+id,
        type: 'POST',
        data: { order_id:id,
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