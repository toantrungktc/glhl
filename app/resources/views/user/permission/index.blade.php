@extends('layouts.user_temp')

@section('title', 'Quyền')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}#">Home</a></li>
			<li class="breadcrumb-item"><a href="{{ url('/user') }}">User</a></li>
			<li class="breadcrumb-item">Quyền</li>
            
        </ol>
    </div>
@endsection

@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
        

		       <div class="card card-primary sticky-top" style="top: 58px">
					<div class="card-header">
						<h3 class="card-title ">Danh sách User</h3>
						<a class="float-right" href="javascript:void(0)" id="create-new-thietbi" role="button"><i class="fa fa-plus"></i> Thêm</a>
					</div>
				</div>
						<!-- /.card-header -->
				<div class="card card-primary" style="top: -20px">
					<div class="card-body">
							<table id="permission" class="table table-bordered table-striped">
							<thead>
							<tr>
							    <th>No</th>
								<th>Quền</th>
								
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
                <div class="modal fade" id="modal-add">
					<div class="modal-dialog">
					   
					   <form id="postForm" class="form" name="postForm" >
                            @csrf <!-- để xử lý lỗi 419 -->
							<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="myModalLabel"></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
								
							</div>
							<div class="modal-body">
								<div id="validation-errors"></div>

							    <input type="hidden" name="id" id="id">
								<div class="form-group">
									<label for="username">Name</label>
									<input type="text" class="form-control" id="name" name="name" placeholder="Enter email">
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
    var table = $("#permission").DataTable({
		"pageLength": 10,
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
		"dom": 'Bfrtip',
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		"ajax": "{{ route("get_permission") }}",
		"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{
					data: 'action', 
					name: 'action', 
					orderable: true, 
					searchable: true
				},
				
			]
    });
	table.buttons().container().appendTo('#permission_wrapper .col-md-6:eq(0)');
    
	
  });
</script>

<script type="text/javascript">
function addDays(date, days) {
    var result = new Date(date);
    result.setDate(date.getDate() + days);
    return result;
}

$(function() {
	$('#ngay_kich_hoat').on('change', function(){
		var loai_id = $('#loai').val();
		var ngay_kh = $('#ngay_kich_hoat').val();
		$.get('loaikey/chitiet/'+loai_id, function (data) {
		    //var so1 = pad(data.count +1, 3);
			var ngay_hh = moment(ngay_kh).add(data.thoi_han_su_dung, 'years').format('YYYY-MM-DD');
			var ngay_cb = moment(ngay_hh).subtract(data.thoi_han_nhac, 'days').format('YYYY-MM-DD');
			//var test = moment(ngay_hh).format('YYYY-MM-DD');
			
			$('#ngay_het_han').val(ngay_hh);
			$('#ngay_canh_bao').val(ngay_cb);
			
		})
	});
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
		  $('#myModalLabel').html("Thêm Quyền");
		  $('#modal-add').modal('show');
	  });
   
	  $('body').on('click', '#edit-post', function () {
		var thietbi_id = $(this).data('id');
		$.get('permission/edit/'+thietbi_id, function (data) {
		   $('#myModalLabel').html("Chỉnh sửa Quyền");
			$('#btn-save').val("edit-post");
			$('#modal-add').modal('show');
			$('#id').val(data.id);
			$('#name').val(data.name);	
		})
	 });
  
	  $('body').on('click', '#delete-post', function () {
		  var thietbi_id = $(this).data("id");
		  if(confirm("Are You sure want to delete !")){
			$.ajax({
				type: "DELETE",
				url: "{{ url('user/permission/delete')}}"+'/'+thietbi_id,
				type: "GET",
				success: function (data) {
					$('#permission').DataTable().ajax.reload(null, false);
					console.log(thietbi_id);
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
					url: "{{ route('store_permission') }}",
					type: "POST",
					dataType: 'json',
					success: function (data) {
						$('#permission').DataTable().ajax.reload(null, false);
		
						$('#postForm').trigger("reset");
						$('#modal-add').modal('hide');
						$('#btn-save').html('Save Changes');
						
					},
					error: function (data) {
						console.log('Error:', data);
						console.log((data.responseJSON.errors));
						$('#validation-errors').html('');
						$.each(data.responseJSON.errors, function(key,value) {
							$('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
						}); 
						$('#btn-save').html('Save Changes');
						$('#btn-save').html('Save Changes');
					}
				});
			}
		})
	}

	if ($("#form_update").length > 0) {
		$("#form_update").validate({
	

			submitHandler: function(form) {
				var per_id = $('#id2').val();
				var actionType = $('#btn-save2').val();
				$('#btn-save2').html('Sending..');
				console.log(per_id);
				
				$.ajax({
					data: $('#form_update').serialize(),
					url: "{{ url('user/permission/update')}}"+'/'+per_id,
					type: "POST",
					dataType: 'json',
					success: function (data) {
						$('#permission').DataTable().ajax.reload(null, false);
		
						$('#form_update').trigger("reset");
						$('#modal-update').modal('hide');
						$('#btn-save2').html('Save Changes');
						console.log(data);
					},
					error: function (data) {
						console.log('Error:', data);
						$('#btn-save2').html('Save Changes');
					}
				});
			}
		})
	}


	 
	 
	
</script>



@endpush
