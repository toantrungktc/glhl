@extends('layouts.user_temp')

@section('title', 'Xuất')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item">Xuất</li>
            
        </ol>
    </div>
@endsection


@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
            

		    <div class="card card-primary sticky-top" style="top: 58px">
				<div class="card-header">
					<h3 class="card-title">Danh sách pha chế</h3>
					<a class="float-left" href="{{ url('xuat') }}" role="button">&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-list-alt"></i></a>
					@can('add xuat')
					<a class="float-right" href="{{ url('/xuat/create') }}" role="button"><i class="fa fa-plus"></i> Thêm</a>
					@endcan

				</div>
		    </div>
						<!-- /.card-header -->
		    <div class="card card-primary" style="top: -20px">
				<div class="card-body">
					<table id="trash" class="table table-bordered table-striped">
						<thead>
							<tr>
							    <th>No</th>
							    <th>Tên Sản phẩm</th>
								<th>Ngày pha chế</th>
								<th>Khối lượng lá</th>
								<th>Khối lượng sợi</th>
								<th>Action</th>
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
		var table = $("#trash").DataTable({
		"pageLength": 15,
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
		"dom": 'Bfrtip',
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		"ajax": "{{ route("trash2_xuat") }}",
		"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'ngay_pha', name: 'ngay_pha'},
				{data: 'kl_la', name: 'kl_la'},
				{data: 'kl_soi', name: 'kl_soi'},
				{
					data: 'action', 
					name: 'action', 
					orderable: true, 
					searchable: true
				},
				
			]
		});
		table.buttons().container().appendTo('#trash_wrapper .col-md-6:eq(0)');
	});
</script>

<script>
	$(document).ready(function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('body').on('click', '#delete-user', function () {
			var user_id = $(this).data("id");

				if(confirm("Are You sure want to delete in Database !")){
					$.ajax({
						type: "DELETE",
						url: "{{ url('xuat/forcedelete/')}}"+'/'+user_id,
						type: "GET",
						success: function (data) {
							$('#trash').DataTable().ajax.reload(null, false);
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				}
		});   
		
		$('body').on('click', '#restore-user', function () {
			var user_id = $(this).data("id");

				if(confirm("Are You sure want to restore !")){
					$.ajax({
						type: "DELETE",
						url: "{{ url('xuat/restore/')}}"+'/'+user_id,
						type: "GET",
						success: function (data) {
							$('#trash').DataTable().ajax.reload(null, false);
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






   