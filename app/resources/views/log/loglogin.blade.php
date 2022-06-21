@extends('layouts.user_temp')

@section('title', 'User')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}#">Home</a></li>
            <li class="breadcrumb-item">User</li>
            
        </ol>
    </div>
@endsection

@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
        

		       <div class="card card-primary sticky-top" style="top: 58px">
					<div class="card-header">
						<h3 class="card-title ">Danh sách User </h3>
						@role('admin')
						<a class="float-left" href="{{ url('user/trash') }}" role="button">&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-trash-alt"></i></a>
						@endrole
						@can('add user')
						<a class="float-right" href="javascript:void(0)" id="create-new-thietbi" role="button"><i class="fa fa-plus"></i> Thêm</a>
						@endcan

					</div>
				</div>
						<!-- /.card-header -->
				<div class="card card-primary" style="top: -20px">
					<div class="card-body">
							<table id="user" class="table table-bordered table-striped">
							<thead>
							<tr>
							    <th>No</th>
							    <th>Tên</th>
								<th>Email</th>
								<th>Vai trò</th>
								
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
    var table = $("#user").DataTable({
		"pageLength": 10,
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
		"dom": 'Bfrtip',
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		"ajax": "{{ route("logauth2") }}",
		"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'ip_address', name: 'ip_address'},
				{data: 'login_at', name: 'login_at'},
				{data: 'logout_at', name: 'logout_at'},
				
				
			]
    });
	table.buttons().container().appendTo('#user_wrapper .col-md-6:eq(0)');
    
	
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
			$('#myModalLabel').html("Thêm User");
			$('#modal-default').modal('show');
			$('#password').val('khatoco123');
		});
   
		$('body').on('click', '#edit-post', function () {
			var thietbi_id = $(this).data('id');
			//var role_id = $(this).data('roles');
			$('.custom-control-input').attr("checked", false);
			$.get('user/edit/'+thietbi_id, function (data) {
			$('#myModalLabel').html("Edit User");
				$('#btn-save').val("edit-post");
				$('#modal-default').modal('show');
				$('#id').val(data.id);
				$('#name').val(data.name);
				$('#username').val(data.username);
				$('#email').val(data.email);
				$('#ghichu').val(data.ghichu);
				
				$.each(data.roles, function(index, itemData) {
                	var role_id = itemData.id;
					$('#'+role_id+'').attr('checked', true);
					console.log(role_id);
					//$('#gialieu_table').append('<tr id="row_id_'+index+'">'+'<td><input type="hidden" id="gl_id_'+index+'" name="gialieu[]" value="'+itemData.id+'">'+itemData.name+'</td><td><input type="number" readonly step="any" id="gl_tyle_id_'+index+'" name="tyle[]" class="form-control" value="'+number_format(itemData.pivot.tyle,3)+'" ></td><td><input type="number" step="any" id="gl_row_id_'+index+'" name="khoiluong[]" class="form-control" ></td></tr>')
            	});
				//$('#'+role_id+'').attr('checked', true);
				
			})
		});
  
		$('body').on('click', '#delete-post', function () {
			var thietbi_id = $(this).data("id");

				if(confirm("Are You sure want to delete !")){
					$.ajax({
						type: "DELETE",
						url: "{{ url('user/delete/')}}"+'/'+thietbi_id,
						type: "GET",
						success: function (data) {
							$('#user').DataTable().ajax.reload(null, false);
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
			url: "{{ route('store_user') }}",
			type: "POST",
			dataType: 'json',
			success: function (data) {
				$('#user').DataTable().ajax.reload(null, false);
   
				$('#postForm').trigger("reset");
				$('#modal-default').modal('hide');
				$('#btn-save').html('Save Changes');
				
			},
			error: function (data) {
				//console.log('Error:',data);
				console.log((data.responseJSON.errors));
				$('#validation-errors').html('');
				$.each(data.responseJSON.errors, function(key,value) {
					$('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
				}); 
				$('#btn-save').html('Save Changes');
			}
		});
	  }
	})
  }
	 
	 
	
</script>

<script>
	$('input[type="checkbox"]').on('change', function() {
	  $('input[type="checkbox"]').not(this).prop('checked', false);
	});
</script>



@endpush
