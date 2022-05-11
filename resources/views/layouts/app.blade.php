<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="expires" content="0">
  <link rel="icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon" />
  <title>
    @yield('pageTitle')
  </title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/morris.js/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/jvectormap/jquery-jvectormap.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet"
    href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  <link rel="stylesheet"
    href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fileinput/fileinput.min.css') }}">



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- jQuery 3 -->
  <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('assets/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <!-- Morris.js charts -->
  <script src="{{ asset('assets/bower_components/raphael/raphael.min.js') }}"></script>
  <script src="{{ asset('assets/bower_components/morris.js/morris.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ asset('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
  <!-- jvectormap -->
  <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <!-- datepicker -->
  <script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
  </script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
  <!-- Slimscroll -->
  <script src="{{ asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('assets/bower_components/fastclick/lib/fastclick.js') }}"></script>
  <script src="{{ asset('assets/plugins/fileinput/fileinput.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('assets/bower_components/chart.js/Chart.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('assets/dist/js/demo.js') }}"></script>



  <!-- DataTables -->
  <script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">

      <!-- Logo -->
      <a href="#" class="logo">

        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">LOT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">LOTUS</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="pull-right">
        </div>
      </nav>

    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

          <li id="dashboardMainMenu">
            <a href="{{ route('home') }}">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>
          @if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission)
          || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission))
          <li class="treeview" id="userMainNav">
            <a href="#">
              <i class="ion ion-android-people"></i>
              <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if(in_array('createUser', $user_permission))
              <li id="createUserSubNav"><a href="{{ route('users.create') }}"><i class="fa fa-circle-o"></i> Add
                  User</a>
              </li>
              @endif
              @if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission)
              || in_array('deleteUser', $user_permission))
              <li id="manageUserSubNav"><a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i> Manage
                  Users</a>
              </li>
              @endif
            </ul>
          </li>
          @endif
          @if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission)
          || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission))

          <li class="treeview" id="groupMainNav">
            <a href="#">
              <i class="fa fa-group"></i>
              <span>Groups</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if(in_array('createGroup', $user_permission))
              <li id="createGroupSubMenu"><a href="{{ route('group.create') }}"><i class="fa fa-circle-o"></i> Add
                  Group</a></li>
              @endif
              @if(in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission)
              || in_array('deleteGroup', $user_permission))
              <li id="manageGroupSubMenu"><a href="{{ route('group.index') }}"><i class="fa fa-circle-o"></i> Manage
                  Groups</a></li>
              @endif
            </ul>
          </li>
          @endif




          <!-- <li class="header">Settings</li> -->
          @if(in_array('createStore', $user_permission) || in_array('updateStore', $user_permission)
          || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission))
          <li id="storesMainNav"><a href="{{ route('store.index') }}"><i class="fa fa-home"></i> <span>Stores</span></a>
          </li>
          @endif

          @if(in_array('createTable', $user_permission) || in_array('updateTable', $user_permission) ||
          in_array('viewTable', $user_permission) || in_array('deleteTable', $user_permission))
          <li id="tablesMainNav"><a href="{{ route('table.index') }}"><i class="fa fa-table"></i>
              <span>Tables</span></a></li>
          @endif

          @if(in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) ||
          in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission))
          <li id="categoryMainNav"><a href="{{ route('category.index') }}"><i class="fa fa-list-alt"></i>
              <span>Category</span></a></li>
          @endif



          @if(in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission)
          || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission))
          <li class="treeview" id="productMainNav">
            <a href="#">
              <i class="fa fa-product-hunt"></i>
              <span>Products</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if (in_array('createProduct', $user_permission))
              <li id="createProductSubMenu"><a href="{{ route('product.create') }}"><i class="fa fa-circle-o"></i> Add
                  product</a></li>
              @endif
              @if (in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) ||
              in_array('deleteProduct', $user_permission))
              <li id="manageProductSubMenu"><a href="{{ route('product.index') }}"><i class="fa fa-circle-o"></i> Manage
                  Products</a></li>
              @endif

            </ul>
          </li>
          @endif

          @if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission)
          || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission))
          <li class="treeview" id="OrderMainNav">
            <a href="#">
              <i class="fa fa-get-pocket"></i>
              <span>Orders</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if (in_array('createOrder', $user_permission))
              <li id="createOrderSubMenu"><a href="{{ route('order.create') }}"><i class="fa fa-circle-o"></i> Add
                  order</a></li>
              @endif
              @if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission)
              ||in_array('deleteOrder', $user_permission))
              <li id="manageOrderSubMenu"><a href="{{ route('order.index') }}"><i class="fa fa-circle-o"></i> Manage
                  Orders</a></li>
              @endif

            </ul>
          </li>
          @endif

          @if(in_array('viewReport', $user_permission))
          <li class="treeview" id="ReportMainNav">
            <a href="#">
              <i class="ion ion-stats-bars"></i>
              <span>Reports</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="dailyReportSubMenu"><a href="{{ route('report.daily') }}"><i class="fa fa-circle-o"></i>Daily
                  Wise</a></li>
              <li id="productReportSubMenu"><a href="{{ route('report.index') }}"><i class="fa fa-circle-o"></i> Total
                  Products Wise</a></li>
              <li id="sProductReportSubMenu"><a href="{{ route('report.product') }}"><i class="fa fa-circle-o"></i>
                  Product Wise</a></li>
              <li id="storeReportSubMenu"><a href="{{ route('report.store') }}"><i class="fa fa-circle-o"></i> Total
                  Store Wise</a></li>
              <li id="staffReportSubMenu"><a href="{{ route('report.staff') }}"><i class="fa fa-circle-o"></i> Staff
                  Wise</a></li>

            </ul>
          </li>
          @endif


          @if(in_array('updateCompany', $user_permission))
          <li id="companyMainNav"><a href="{{ route('company') }}"><i class="fa fa-info-circle"></i> <span>Company
                Info</span></a>
          </li>
          @endif

          @if(in_array('viewProfile', $user_permission))
          <li id="profileMainNav"><a href="{{ route('users.show', Auth::id() ) }}"><i class="fa fa-id-badge"></i>
              <span>Profile</span></a></li>
          @endif
          @if(in_array('updateSetting', $user_permission))
          <li id="settingMainNav"><a href="{{ route('user.setting') }}"><i class="fa fa-cogs"></i>
              <span>Setting</span></a></li>
          @endif




          <li><a href="{{ route('logout') }}"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')

    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.2.0
      </div>
      <strong>Copyright &copy; {{ date('Y') }} - {{ date('Y')+1 }}.</strong>

    </footer>

    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

</body>

</html>