@extends('layouts.user_temp')

@section('title', 'Gia Liệu - Hương Liệu')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}#">Home</a></li>
            <li class="breadcrumb-item">GLHL</li>
            
        </ol>
    </div>
@endsection


@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
		@if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif
        @if(Session::has('message'))
                <div class="alert alert-info" role="alert">{{ Session::get('message')}} {{ Session::forget('message') }}</div>
        @endif
            

		    <div class="card card-primary sticky-top" style="top: 58px">
				<div class="card-header">
					<h3 class="card-title">Danh sách Gia Liệu - Hương Liệu</h3>
					@role('admin')
						<a class="float-left" href="{{ url('glhl/trash') }}" role="button">&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-trash-alt"></i></a>
					@endrole
					@can('add glhl')
					<div class="btn-group float-right">
					<a class="float-right" data-toggle="modal" data-target="#modal-import" role="button"><i class="fa fa-plus"></i> Import</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a class="float-right" href="javascript:void(0)" id="create-new-blend" role="button"><i class="fa fa-plus"></i> Thêm</a>
				    </div>
					@endcan
				</div>
		    </div>
						<!-- /.card-header -->
		    <div class="card card-primary" style="top: -20px">
				<div class="card-body">
					<table id="glhl" class="table table-bordered table-striped">
						<thead>
							<tr>
							    <th>No</th>
								<th>STT</th>
							    <th>Tên</th>
								<th>Code 1</th>
								<th>Code 2</th>
								<th>Đơn vị tính</th>
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
									<label for="recipient-name" class="col-form-label">STT</label>
									<input type="number" class="form-control" id="stt" name="stt">
								</div>
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Tên Blend</label>
									<input type="text" class="form-control" id="name" name="name">
								</div>
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Code1</label>
									<input type="text" class="form-control" id="code1" name="code1">
								</div>
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Code2</label>
									<input type="text" class="form-control" id="code2" name="code2">
								</div>
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Đơn vị tính</label>
									<input type="text" class="form-control" id="dvt" name="dvt">
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

				<!-- Modal -->
                <div class="modal fade" id="modal-import">
					<div class="modal-dialog">
					<form action="{{ route('import_glhl') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- để xử lý lỗi 419 -->
							<div class="modal-content">
							<div class="modal-header">
							    <h4 class="modal-title" id="myModalLabel">Import</h4>	
							    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
								
							</div>
							<div class="modal-body">
							    
								<div class="form-group">
									<label for="exampleInputFile">File input</label>
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="file" name="file">
										<label class="custom-file-label" for="exampleInputFile">Choose file</label>
									</div>
								</div>
								<a href="{{ url('download/excel2') }}"  data-toggle="tooltip" data-placement="right" title="Click để down">File Mẫu</a>

								
								
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

<!-- bs-custom-file-input -->
<script src="{{ asset("/bower_components/admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js") }} "></script>

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
		var table = $("#glhl").DataTable({
		"pageLength": 15,
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
		"dom": 'Bfrtip',
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		"ajax": "{{ route("list2_glhl") }}",
		"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'stt', name: 'stt'},
				{data: 'name', name: 'name'},
				{data: 'code1', name: 'code1'},
				{data: 'code2', name: 'code2'},
				{data: 'dvt', name: 'dvt'},
				{
					data: 'action', 
					name: 'action', 
					orderable: true, 
					searchable: true
				},
				
			]
		});
		table.buttons().container().appendTo('#glhl_wrapper .col-md-6:eq(0)');
	});
</script>

<script>
$(function () {
  bsCustomFileInput.init();
});
</script>





<script>
	$(document).ready(function () {
	  $.ajaxSetup({
		  headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
	  });
  
	  $('#create-new-blend').click(function () {
		  $('#btn-save').val("create-thietbi");
		  $('#postForm').trigger("reset");
		  $('#myModalLabel').html("Thêm Blend");
		  $('#modal-default').modal('show');
	  });
   
	  $('body').on('click', '#edit-key', function () {
		var blend_id = $(this).data('id');
		$.get('glhl/edit/'+blend_id, function (data) {
		   $('#myModalLabel').html("Edit Gia Liệu - Hương Liệu");
			$('#btn-save').val("edit-key");
			$('#modal-default').modal('show');
			$('#id').val(data.id);
			$('#stt').val(data.stt);
			$('#name').val(data.name);
			$('#code1').val(data.code1);
			$('#code2').val(data.code2);
			$('#dvt').val(data.dvt);
	
		})
	 });
  
	  $('body').on('click', '#delete-key', function () {
		  var glhl_id = $(this).data("id");
		  if(confirm("Are You sure want to delete !")){
			$.ajax({
				type: "DELETE",
				url: "{{ url('glhl/delete/')}}"+'/'+glhl_id,
				type: "GET",
				success: function (data) {
					$('#glhl').DataTable().ajax.reload(null, false);
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		  }
		  
	  });   
	});
   
	if ($("#postForm").length > 0) {
		$("#postForm").validate({
   
	   submitHandler: function(form) {
  
		var actionType = $('#btn-save').val();
		$('#btn-save').html('Sending..');
  
		
		$.ajax({
			data: $('#postForm').serialize(),
			url: "{{ route('store_glhl') }}",
			type: "POST",
			dataType: 'json',
			success: function (data) {
				$('#glhl').DataTable().ajax.reload(null, false);
   
				$('#postForm').trigger("reset");
				$('#modal-default').modal('hide');
				$('#btn-save').html('Save Changes');
				
			},
			error: function (data) {
				console.log('Error:', data);
				$('#btn-save').html('Save Changes');
			}
		});
	  }
	})
  }
	 
	 
	
</script>

@endpush






   