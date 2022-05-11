@extends('layouts/app')

@section('pageTitle')
Reports
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Reports
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Reports</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">

    <div class="col-md-12 col-xs-12">
      <form class="form-inline" action="{{ route('report.dailyData') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="date">Year</label>
          <select class="form-control" name="select_year" id="select_year">
            <option value="">Select Year</option>
            @foreach ($report_years as $key => $value)
            <option value="{{ $value }}" @if($value==$selected_year) selected @endif>
              {{ $value }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="date">Month</label>
          <select class="form-control" name="select_month" id="select_month">
            <option value="">Select Month</option>
            @foreach ($report_month as $key => $value)
            <option value="{{ $value }}" @if($value==$selected_month) selected @endif>
              {{ $value }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </div>

    <br /> <br />


    <div class="col-md-12 col-xs-12">

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Total Paid Orders - Report</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="chart">
            <canvas id="barChart" style="height:250px"></canvas>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Total Paid Orders - Report Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="datatables" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Month - Year</th>
                <th>Amount</th>
                <th>Total Items</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($results as $k => $v)
              <tr>
                <td>{{ $k }} </td>
                <td>

                  {!! html_entity_decode($company_currency) .' ' . $v !!}


                </td>
                <td>

                  {{ $quantity[$k] }}
                  <a tabindex="0" role="button" data-key="{{ $k }}" class="hover popover_hover btn btn-link pull-right"
                    data-toggle="popover" data-trigger="focus" style="padding:0;"><i class=" fa fa-eye"></i></a>

                </td>
              </tr>
              @endforeach


            </tbody>
            <tbody>
              <tr>
                <th>Total Amount</th>
                <th>
                  {!! html_entity_decode($company_currency) . ' ' . array_sum($results) !!}
                </th>
                <th>{{ array_sum($quantity). ' Items' }}</th>
              </tr>
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

<script type="text/javascript">
  $(document).ready(function() {
      $("#ReportMainNav").addClass('active');
      $("#dailyReportSubMenu").addClass('active');

      var product_items_count = {!!  $product_items_count !!};

      $(".popover_hover").popover({
      title:'Items Count',
      content:fetchItemsCount,
      html:true,
      trigger:"hover",
      placement:'left'
      });
      
      function fetchItemsCount(){
          var html = '';
          var element = $(this);
          var key = element.attr('data-key');
          html += '<style type="text/css">.popover {max-width: 310px;}.popover-table tr th,.popover-table tr td{padding:5px 3px;font-size:13px;}</style><table class="table table-bordered table-striped po text-center popover-table">\
                <thead>\
                <tr>\
                  <th scope="col">#</th>\
                  <th scope="col"> Product </th>\
                  <th scope="col"> Quantity </th>\
                  <th scope="col"> Amount </th>\
                </tr>\
              </thead>\
              <tbody>';

              let i = 1;
              if(product_items_count.hasOwnProperty(key))
              for (const [index, value] of Object.entries(product_items_count[key])) {
                html += ' <tr>\
                  <th scope="row" class="text-center">' + i + '</th>\
                  <td>' + index + '</td>\
                  <td>' + value['quantity'] + '</td>\
                  <td>{!! html_entity_decode($company_currency) !!} ' + Math.round(value['amount'] * 100)/100 + '</td>\
                </tr>';
                i++
               }
              html += '</tbody></table>';
          return html;
        }
    }); 
    

    var report_data = {{ '[' . implode(',', $results) . ']' }};
    

    $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
     var areaChartData = {
      labels  : ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : report_data
        }
      ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[0].fillColor   = '#00a65a';
    barChartData.datasets[0].strokeColor = '#00a65a';
    barChartData.datasets[0].pointColor  = '#00a65a';
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })
</script>

@endsection