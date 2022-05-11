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


      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Add Product</h3>
        </div>
        <!-- /.box-header -->
        <form role="form" action="{{ route('product.update',$product_data['id'] ) }}" method="post"
          enctype="multipart/form-data">
          <div class="box-body">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="img">Image Preview: </label>
              <div class="kv-avatar file-preview">
                <img src="{{ asset('images/products/' . $product_data['image'] . '')}}" width="150" height="150"
                  id="img">
              </div>
            </div>

            <div class="form-group">
              <div class="kv-fileinput-error" id="kv-fileinput-error"></div>
              <label for="product_image">Image</label>
              <div class="kv-avatar">
                <div class="file-loading">
                  <input id="product_image" name="product_image" type="file">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="product_name">Product name</label>
              <input type="text" class="form-control" id="product_name" name="product_name"
                placeholder="Enter product name" autocomplete="off" value="{{ $product_data['name'] }}" />
            </div>

            <div class="form-group">
              <label for="price">Price</label>
              <input type="text" class="form-control" id="price" name="price" placeholder="Enter price"
                autocomplete="off" value="{{ $product_data['price'] }}" />
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter 
                  description" autocomplete="off">
                  {{ $product_data['description'] }}
                  </textarea>
            </div>

            <div class="form-group">
              <label for="category">Category</label>
              <select class="form-control select_group" id="category" name="category[]" multiple="multiple"
                style="width: 100%">
                @foreach ($category as $k => $v)
                <option value="{{ $v['id'] }}" @if(in_array($v['id'], $category_data)) selected="selected" @endif>
                  {{ $v['name'] }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="store">Store</label>
              <select class="form-control select_group" id="store" name="store[]" multiple="multiple"
                style="width: 100%">
                @foreach ($stores as $k => $v)
                <option value="{{ $v['id'] }}" @if(in_array($v['id'], $store_data)) selected="selected" @endif>
                  {{ $v['name'] }}
                </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="is_game">Is Game</label>
              <select class="form-control" id="is_game" name="is_game">
                <option value="0" @if($product_data['is_game']==0) selected="selected" @endif>No</option>
                <option value="1" @if($product_data['is_game']==1) selected="selected" @endif>Yes</option>
              </select>
            </div>

            <div class="form-group">
              <label for="active">Active</label>
              <select class="form-control" id="active" name="active">
                <option value="1" @if($product_data['active']==1) selected="selected" @endif>Yes</option>
                <option value="2" @if($product_data['active']==2) selected="selected" @endif>No</option>
              </select>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="/product" class="btn btn-warning">Back</a>
          </div>
        </form>
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
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#productMainNav").addClass('active');
    $("#manageProductSubMenu").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
    $("#product_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 10500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif", "JPG", "jpeg"]
    });

  });
</script>
@endsection