@extends('layouts.user_temp')

@section('title', 'Xuất')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
			<li class="breadcrumb-item"><a href="{{ url('/congthuc') }}">Công thức</a></li>
			<li class="breadcrumb-item"><a href="{{ url('/congthuc/show/'.$id) }}">Chi tiết</a></li>
            <li class="breadcrumb-item">Lịch Sử</li>
            
        </ol>
    </div>
@endsection


@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
            

		    <div class="card card-primary sticky-top" style="top: 58px">
				<div class="card-header">
					<h3 class="card-title">Lịch sử</h3>
					
					
				</div>
		    </div>
						<!-- /.card-header -->
		    <div class="card card-primary" style="top: -20px">
				<div class="card-body">

					<label for="recipient-name" class="col-form-label">Thông tin chung</label>
					
					<table id="log" class="table table-bordered table-striped">
						<thead>
							<tr>
							    <th style="width:3%">No</th>
							    <th style="width:16%">User</th>
								<th style="width:9%">Thao tác</th>
								<th style="width:31%">Nội dung mới</th>
								<th style="width:31%">Nội dung cũ</th>
								<th style="width:10%">Thời gian</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
							
					</table>
					<br>

					<label for="recipient-name" class="col-form-label">Thông tin chi tiết</label>

					<table id="log_detail" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="width:3%">No</th>
							    <th style="width:16%">User</th>
								<th style="width:9%">Thao tác</th>
								<th style="width:31%">Nội dung mới</th>
								<th style="width:31%">Nội dung cũ</th>
								<th style="width:10%">Thời gian</th>
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

<script src="https://cdn.jsdelivr.net/npm/moment@2.24.0/moment.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

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
<script>
	$(function () {
		var log_id = "{{ $id }}";
		var table = $("#log").DataTable({
		"pageLength": 15,
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
		"dom": 'Bfrtip',
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		"ajax": "{{ url('congthuc/log2/')}}"+'/'+log_id,
		"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'user', name: 'user'},
				{data: 'description', name: 'description'},
				{data: 'new', name: 'new'},
				{data: 'old', name: 'old'},
				{data: 'created_at', name: 'created_at'},	
			]
		});
		table.buttons().container().appendTo('#log_wrapper .col-md-6:eq(0)');
	});

	$(function () {
		var log_id = "{{ $id }}";
		var table = $("#log_detail").DataTable({
		"pageLength": 15,
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
		"dom": 'Bfrtip',
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		"ajax": "{{ url('congthuc/log3/')}}"+'/'+log_id,
		"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'user', name: 'user'},
				{data: 'description', name: 'description'},
				{data: 'new', name: 'new'},
				{data: 'old', name: 'old'},
				{data: 'created_at', name: 'created_at'},	
			]
		});
		table.buttons().container().appendTo('#log_detail_wrapper .col-md-6:eq(0)');
	});

</script>

<script>
	$(document).ready(function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	
		$('body').on('click', '#delete-nhap', function () {
			var nhap_id = $(this).data("id");
			if(confirm("Are You sure want to delete !")){
				$.ajax({
					type: "DELETE",
					url: "{{ url('nhap/delete/')}}"+'/'+nhap_id,
					type: "GET",
					success: function (data) {
						$('#nhap').DataTable().ajax.reload(null, false);
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			}	
		});   
	});
    
	
</script>


@endpush






   