@extends('layouts.user_temp')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $blends }}</h3>

                        <p>Số lượng Blend</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ url('/blend') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $congthucs }}</h3>

                        <p>Số lượng Công thức</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ url('/congthuc') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $glhls }}</h3>

                        <p>Số lượng GLHL</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ url('/glhl') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row --> 
            <div class="row">
                <div class="col-lg-6">
                  <div class="card">
                    <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">Sản lượng sợi theo tuần</h3>
                        {{-- <a href="javascript:void(0);">View Report</a> --}}
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex">
                        <p class="d-flex flex-column">
                          <span class="text-bold text-lg" id="sum_currentweek"></span>
                          <span>Sản lượng sợi (kg)</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right" id="tyle">
                          {{-- <span class="text-success" id="tyle">
                            <i class="fas fa-arrow-up"></i>
                          </span>
                          <span class="text-muted">So với tuần trước</span> --}}
                        </p>
                      </div>
                      <!-- /.d-flex -->
      
                      <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="visitors-chart" height="200" width="457" style="display: block; width: 457px; height: 200px;" class="chartjs-render-monitor"></canvas>
                      </div>
      
                      <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                          <i class="fas fa-square text-primary"></i> Tuần Hiện tại
                        </span>
      
                        <span>
                          <i class="fas fa-square text-gray"></i> Tuần trước
                        </span>
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
      
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">Top 5 Gia liệu Hương Liệu</h3>
                      <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                          <i class="fas fa-download"></i>
                        </a>
                        <a href="#" class="btn btn-tool btn-sm">
                          <i class="fas fa-bars"></i>
                        </a>
                      </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                      <table id="top_glhl" class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                          <th>Stt</th>
                          <th>Tên vật tư</th>
                          <th>Khối lượng</th>
                          
                        </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                  <div class="card">
                    <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">Khối lượng gia liệu</h3>
                        <a href="javascript:void(0);">View Report</a>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex">
                        <p class="d-flex flex-column">
                          <span class="text-bold text-lg" id="sum_currentweek2">></span>
                          <span>Khối lượng</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right" id="tyle2">
                          {{-- <span class="text-success">
                            <i class="fas fa-arrow-up"></i> 33.1%
                          </span>
                          <span class="text-muted">Since last month</span> --}}
                        </p>
                      </div>
                      <!-- /.d-flex -->
      
                      <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="sales-chart" height="200" style="display: block; width: 457px; height: 200px;" width="457" class="chartjs-render-monitor"></canvas>
                      </div>
      
                      <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                          <i class="fas fa-square text-primary"></i> Tuần hiện tại
                        </span>
      
                        <span>
                          <i class="fas fa-square text-gray"></i> Tuần trước
                        </span>
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
      
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">Top 5 Gia liệu Hương Liệu</h3>
                      <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                          <i class="fas fa-download"></i>
                        </a>
                        <a href="#" class="btn btn-tool btn-sm">
                          <i class="fas fa-bars"></i>
                        </a>
                      </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                      <table id="top_glhl2" class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                          <th>Stt</th>
                          <th>Tên vật tư</th>
                          <th>Khối lượng</th>
                          
                        </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset("/bower_components/admin-lte/plugins/chart.js/Chart.min.js") }}"></script>
<!-- DataTables  & Plugins -->

<script src="{{ asset("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/jszip/jszip.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/pdfmake/pdfmake.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/pdfmake/vfs_fonts.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js") }} "></script>


<script>
    function lamtron(x) {
      return Number.parseFloat(x).toFixed(1);
    };
    $(document).ready(function () {
      $.ajax({
          type: "GET",
          url: "{{ route('getQuantityWeek') }}",
          dataType: 'json',
          success: function (response) {
                var labels = (response.day);

                var data_SubWeek = (response.kl_SubWeek);
                var data_CurrentWeek = (response.kl_CurrentWeek);

                var total_current = 0;
                for (var i = 0; i < data_CurrentWeek.length; i++) {
                  total_current += data_CurrentWeek[i] << 0;
                }

                var total_sub = 0;
                for (var i = 0; i < data_SubWeek.length; i++) {
                  total_sub += data_SubWeek[i] << 0;
                }
                
                var tyle = lamtron((total_current/total_sub)*100-100);
                console.log(tyle);
                //console.log(test(tyle));
                $("#sum_currentweek").html(total_current);
                var tab_span = '';
                
                if( tyle < 0 ){
                  tab_span = `<span class="text-danger" id="tyle">
                            <i class="fas fa-arrow-down"></i> `+tyle+`%
                          </span>
                          <span class="text-muted">So với tuần trước</span>`;
                  $("#tyle").html(tab_span);
                }else{
                  tab_span = `<span class="text-primary" id="tyle">
                            <i class="fas fa-arrow-up"></i> `+tyle+`%
                          </span>
                          <span class="text-muted">So với tuần trước</span>`;
                  $("#tyle2").html(tab_span);
                }
                
                var ticksStyle = {
                        fontColor: '#495057',
                        fontStyle: 'bold'
                    }

                var mode = 'index'
                var intersect = true

                var $visitorsChart = $('#visitors-chart')
                // eslint-disable-next-line no-unused-vars
                var visitorsChart = new Chart($visitorsChart, {
                    data: {
                    labels: labels,
                    datasets: [{
                        type: 'line',
                        data: data_CurrentWeek,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        pointBorderColor: '#007bff',
                        pointBackgroundColor: '#007bff',
                        fill: false
                        // pointHoverBackgroundColor: '#007bff',
                        // pointHoverBorderColor    : '#007bff'
                    },{
                        type: 'line',
                        data: data_SubWeek,
                        backgroundColor: 'tansparent',
                        borderColor: '#ced4da',
                        pointBorderColor: '#ced4da',
                        pointBackgroundColor: '#ced4da',
                        fill: false
                        // pointHoverBackgroundColor: '#ced4da',
                        // pointHoverBorderColor    : '#ced4da'
                    }]
                    },
                    options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: '4px',
                            color: 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks: $.extend({
                            beginAtZero: true,
                            suggestedMax: 200
                        }, ticksStyle)
                        }],
                        xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                        }]
                    }
                    }
                })
          },
          error: function(xhr) {
              console.log(xhr.responseJSON);
          }
      });

      $.ajax({
          type: "GET",
          url: "{{ route('getQuantitySuppliesWeek') }}",
          dataType: 'json',
          success: function (response) {
                var labels = (response.day);

                var data_SubWeek = (response.kl_SubWeek);
                var data_CurrentWeek = (response.kl_CurrentWeek);

                var total_current = 0;
                for (var i = 0; i < data_CurrentWeek.length; i++) {
                  total_current += data_CurrentWeek[i] << 0;
                }

                var total_sub = 0;
                for (var i = 0; i < data_SubWeek.length; i++) {
                  total_sub += data_SubWeek[i] << 0;
                }
                
                var tyle = lamtron((total_current/total_sub)*100-100);
                console.log(tyle);
                //console.log(test(tyle));
                $("#sum_currentweek2").html(total_current);
                var tab_span = '';
                
                if( tyle < 0 ){
                  tab_span = `<span class="text-danger" id="tyle">
                            <i class="fas fa-arrow-down"></i> `+tyle+`%
                          </span>
                          <span class="text-muted">So với tuần trước</span>`;
                  $("#tyle2").html(tab_span);
                }else{
                  tab_span = `<span class="text-primary" id="tyle">
                            <i class="fas fa-arrow-up"></i> `+tyle+`%
                          </span>
                          <span class="text-muted">So với tuần trước</span>`;
                  $("#tyle2").html(tab_span);
                }
                
                var ticksStyle = {
                        fontColor: '#495057',
                        fontStyle: 'bold'
                    }

                var mode = 'index'
                var intersect = true

                var $salesChart = $('#sales-chart')
                // eslint-disable-next-line no-unused-vars
                var salesChart = new Chart($salesChart, {
                  type: 'bar',
                  data: {
                    labels: labels,
                    datasets: [
                      {
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        data: data_CurrentWeek
                      },
                      {
                        backgroundColor: '#ced4da',
                        borderColor: '#ced4da',
                        data: data_SubWeek
                      }
                    ]
                  },
                  options: {
                    maintainAspectRatio: false,
                    tooltips: {
                      mode: mode,
                      intersect: intersect
                    },
                    hover: {
                      mode: mode,
                      intersect: intersect
                    },
                    legend: {
                      display: false
                    },
                    scales: {
                      yAxes: [{
                        // display: false,
                        gridLines: {
                          display: true,
                          lineWidth: '4px',
                          color: 'rgba(0, 0, 0, .2)',
                          zeroLineColor: 'transparent'
                        },
                        ticks: $.extend({
                          beginAtZero: true,
                          suggestedMax: 200
                        }, ticksStyle)
                      }],
                      xAxes: [{
                        display: true,
                        gridLines: {
                          display: false
                        },
                        ticks: ticksStyle
                      }]
                    }
                  }
                })
          },
          error: function(xhr) {
              console.log(xhr.responseJSON);
          }
      });
    });
  </script>

<script>
	$(function () {
		var table = $("#top_glhl").DataTable({
		"pageLength": 15,
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
    "searching": false, 
    "paging": false,
    "info": false,
		// "dom": 'Bfrtip',
		// "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		"ajax": "{{ route("top5spweek_xuat") }}",
		"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'kl_soi', name: 'kl_soi'},
	
				
			]
		});

    var table = $("#top_glhl2").DataTable({
		"pageLength": 15,
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
    "searching": false, 
    "paging": false,
    "info": false,
		// "dom": 'Bfrtip',
		// "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		"ajax": "{{ route("top5week_xuat") }}",
		"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'sum_kl', name: 'sum_kl'},
	
				
			]
		});
	});
</script>
 


@endpush