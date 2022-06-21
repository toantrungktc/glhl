@extends('layouts.user_temp')

@section('title', 'Báo cáo')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item">Báo cáo</li>
            
        </ol>
    </div>
@endsection


@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
            

		    <div class="card card-primary sticky-top" style="top: 58px">
				<div class="card-header">
					<?php $now = Carbon\Carbon::now();?>
					<h3 class="card-title">Báo cáo tháng &nbsp;</h3> <h3 class="card-title" id="thang">{{ date('m/Y', strtotime($now)) }}</h3>
					<a class="float-right" href="{{ url('/glhl/pdf') }}" role="button"><i class="far fa-file-pdf"></i> Xuất file</a>
				</div>
		    </div>
						<!-- /.card-header -->
		    <div class="card card-primary" style="top: -20px">
				<div class="card-body">
				<form class="form" method="post" action="{{ route('pdf_glhl') }}" id="form1">
                            @csrf <!-- để xử lý lỗi 419 -->	
					<div class="row">
						<div class="col-md-4">
							<label>Từ ngày:</label>
							<div class="input-group date" id="reservationdate" data-target-input="nearest">
								<input type="text" name="from_date" id="from_date"  class="form-control datetimepicker-input" data-target="#reservationdate"/>
								<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<label>Đến ngày:</label>
							<div class="input-group date" id="reservationdate2" data-target-input="nearest">
								<input type="text" name="to_date" id="to_date" class="form-control datetimepicker-input" data-target="#reservationdate2"/>
								<div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
						    <label>&nbsp;</label>
							<div>
							<button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
							<button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
							<button type="submit" form="form1" value="Submit" id="Submit" class="btn btn-default"><i class="far fa-file-pdf"></i> Xuất file</button>
							</div>
						</div>
					</div>
					<br>
				</form>
					<table id="log" class="table table-bordered table-striped">
						<thead>
							<tr>
							    <th>No</th>
							    <th>Tên </th>
								<th>Tồn đầu</th>
								<th>Nhập</th>
								<th>Xuất</th>
								<th>Tồn cuối</th>
								
								
							</tr>
						</thead>
						<tbody>
							
						</tbody>
							
					</table>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
			<!-- EndTable Data -->
        
				
					
                <!-- Button trigger modal -->
                
				
                
				<!-- Modal -->
                <div class="modal fade" id="modal-default">
					<div class="modal-dialog">
					   <form id="postForm" class="form" name="postForm">
                            @csrf <!-- để xử lý lỗi 419 -->
							<div class="modal-content">
							<div class="modal-header">
							    <h4 class="modal-title" id="myModalLabel"></h4>	
							    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
								
							</div>
							<div class="modal-body">
							    <input type="hidden" name="id" id="id" value="{{ strtoupper(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10)) }}">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Tên Blend</label>
									<input type="text" class="form-control" id="name" name="name">
								</div>
							</div>
							<div class="modal-footer justify-content-between">
								<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
							</div>
							<!-- /.modal-content -->
						</form>
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->


                
                
            
        </div>
    </div>
</div>
@endsection


@push('scripts')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->

<!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->

<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset("/bower_components/admin-lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js") }} "></script>
<!-- InputMask -->
<script src="{{ asset("/bower_components/admin-lte/plugins/moment/moment.min.js") }} "></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/inputmask/jquery.inputmask.min.js") }} "></script>
<!-- date-range-picker -->
<script src="{{ asset("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }} "></script>
<!-- bootstrap color picker -->
<script src="{{ asset("/bower_components/admin-lte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js") }} "></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset("/bower_components/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }} "></script>
<!-- Bootstrap Switch -->
<script src="{{ asset("/bower_components/admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js") }} "></script>
<!-- BS-Stepper -->
<script src="{{ asset("/bower_components/admin-lte/plugins/bs-stepper/js/bs-stepper.min.js") }} "></script>

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

<!-- Page specific script -->


<script type="text/javascript">
$(document).ready(function(){
	
	
	//Date picker
	$('#reservationdate').datetimepicker({
		format:'YYYY-MM-DD'
		});
	$('#reservationdate2').datetimepicker({
			format: 'YYYY-MM-DD'
		});

 	load_data();

	function load_data(from_date = '', to_date = '')
	{
		var table = $("#log").DataTable({
			"pageLength": 15,
			"responsive": true, 
			"lengthChange": false, 
			"autoWidth": false,
			"dom": 'Bfrtip',
			"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
			
			ajax: {
						url:'{{ route("baocao_glhl") }}',
						data:{from_date:from_date, to_date:to_date}
					},
			"columns": [
					{data: 'DT_RowIndex', name: 'DT_RowIndex'},
					{data: 'name', name: 'name'},
					{data: 'ton', name: 'ton'},
					{data: 'nhap', name: 'nhap'},
					{data: 'xuat', name: 'xuat'},
					{data: 'toncuoi', name: 'toncuoi'},
				
			]
    	});
	}

	$('#filter').click(function(){
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var thangbc = from_date.substr(5,2) +"/"+ from_date.substr(0,4);
		console.log(thangbc);
		//var mm = String(thangbc.getMonth() + 1).padStart(2, '0'); //January is 0!
  
		if(from_date != '' &&  to_date != '')
		{
			$("#log").DataTable().destroy();
			load_data(from_date, to_date);
			$('#thang').text(thangbc);
			
		}
		else
		{
			alert('Both Date is required');
		}
	});

	$('#refresh').click(function(){
		$('#from_date').val('');
		$('#to_date').val('');
		$("#log").DataTable().destroy();
		load_data();
	});

});  

</script>

@endpush






   