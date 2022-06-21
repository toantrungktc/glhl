@extends('layouts.user_temp')

@section('title', 'Vai trò')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/user') }}">User</a></li>
			<li class="breadcrumb-item">Thiết bị</li>
            
        </ol>
    </div>
@endsection

@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
        

		       <div class="card card-primary sticky-top" style="top: 58px">
					<div class="card-header">
						<h3 class="card-title ">Danh sách Role</h3>
						<a class="float-right" href="javascript:void(0)" id="create-new-thietbi" role="button"><i class="fa fa-plus"></i> Thêm</a>
					</div>
				</div>
						<!-- /.card-header -->
				<div class="card card-primary" style="top: -20px">
					<div class="card-body">
							<table id="role" class="table table-bordered table-striped">
							<thead>
							<tr>
							    <th>No</th>
								<th>Vai trò</th>
								<th>Quyền</th>
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
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                Thêm
                </button> -->
				
				
				

				
				<!-- Modal -->
                <div class="modal fade" id="modal-default">
					<div class="modal-dialog modal-xl">
						{{-- <form class="form" action="{{ route('store_role') }}" > --}}
					   <form id="postForm" class="form" name="postForm" >
                            @csrf <!-- để xử lý lỗi 419 -->
							<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="myModalLabel"></h4>	
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
								
							</div>
							<div class="modal-body">
							    <input type="hidden" name="id" id="id">
								<div class="form-group">
									<label for="username">Name</label>
									<input type="text" class="form-control" id="name" name="name" placeholder="Enter email">
								</div>
								
								<div class="form-group">
									<label for="exampleInputEmail1">Quyền</label>
									<div class="form-group">
										@foreach($permissions as  $permission)
										<div class="form-check form-check-inline" style="width: 230px;">
										<div class="custom-control custom-switch ">
											<input type="checkbox" class="custom-control-input" id="{{ $permission->id }}" value="{{ $permission->name }}" name="permission[]" >
											<label class="custom-control-label" for="{{ $permission->id }}">{{ $permission->name }}</label>
										</div>
										</div>
										@endforeach
										
									</div>
								</div>
								
							</div>
							<div class="modal-footer justify-content-between">
								<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
								<!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
								<button type="submit" class="btn btn-primary" id="btn-save" value="create">Save</button>
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
    var table = $("#role").DataTable({
		"pageLength": 10,
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
		"dom": 'Bfrtip',
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		"ajax": "{{ route("list2_role") }}",
		"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'permission', name: 'permission'},
				
				{
					data: 'action', 
					name: 'action', 
					orderable: true, 
					searchable: true
				},
				
			]
    });
	table.buttons().container().appendTo('#role_wrapper .col-md-6:eq(0)');
    
	
  });
</script>


<script>
	$(document).ready(function () {
	  $.ajaxSetup({
		  headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
	  });
  
	  $('#create-new-thietbi').click(function () {
		  $('#btn-save').val("create-thietbi");
		  $('#postForm').trigger("reset");
		  $('#myModalLabel').html("Thêm Vai trò");
		  $('#modal-default').modal('show');
	  });
   
	  $('body').on('click', '#edit-post', function () {
		var role_id = $(this).data('id');
		$('.custom-control-input').attr("checked", false);
		$.get('role/edit/'+role_id, function (data) {
		   $('#myModalLabel').html("Chỉnh sửa Vai trò");
			$('#btn-save').val("edit-post");
			$('#modal-default').modal('show');
			$('#id').val(data.id);
			$('#name').val(data.name);
			$.each(data.permissions, function(index, itemData) {
                	var permission_id = itemData.id;
					$('#'+permission_id+'').attr('checked', true);
					console.log(permission_id);
					//$('#gialieu_table').append('<tr id="row_id_'+index+'">'+'<td><input type="hidden" id="gl_id_'+index+'" name="gialieu[]" value="'+itemData.id+'">'+itemData.name+'</td><td><input type="number" readonly step="any" id="gl_tyle_id_'+index+'" name="tyle[]" class="form-control" value="'+number_format(itemData.pivot.tyle,3)+'" ></td><td><input type="number" step="any" id="gl_row_id_'+index+'" name="khoiluong[]" class="form-control" ></td></tr>')
            	});
			
			
		})
	 });
  
	  $('body').on('click', '#delete-post', function () {
		  var thietbi_id = $(this).data("id");
		  
          if(confirm("Are You sure want to delete !")){
			$.ajax({
				type: "DELETE",
				url: "{{ url('user/role/delete/')}}"+'/'+thietbi_id,
				type: "GET",
				success: function (data) {
					$('#role').DataTable().ajax.reload(null, false);
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
					url: "{{ route('store_role') }}",
					type: "POST",
					dataType: 'json',
					success: function (data) {
						$('#role').DataTable().ajax.reload(null, false);
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
