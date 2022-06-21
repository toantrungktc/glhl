@extends('layouts.user_temp')

@section('title', 'Chi tiết Công thức')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/congthuc') }}">Công thức</a></li>
            <li class="breadcrumb-item">Chi tiết</li>
            
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
      <form class="form" method="post" action="{{ route('store_congthuc') }}">
                            @csrf <!-- để xử lý lỗi 419 -->
      <!-- title row -->
        <div class="card card-primary sticky-top" style="top: 58px">
			<div class="card-header">
				<h3 class="card-title">Chi tiết</h3>
                @role('admin')
					    <a class="float-left" href="{{ url('/congthuc/log/'.$congthuc->id) }}" role="button">&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-history"></i></a>
				@endrole
                @can('edit congthuc')
                <div class="btn-group float-right">
					<a class="float-right" data-toggle="modal" data-target="#modal-import" role="button"><i class="far fa-file-pdf"></i> Thêm file</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('congthuc/edit/'.$congthuc->id) }}" class="float-right" role="button" aria-pressed="true"><i class="fas fa-edit"></i> Edit</a> 
                </div>
                @endcan
            </div>
        </div>
						<!-- /.card-header -->
	    <div class="card card-primary" style="top: -20px">
			<div class="card-body">
                <div class="form-group">
                    <label for="noidung" class="col-sm-2 control-label">Tên Blend</label>
                    <div class="col-sm-7">
                        <p class="form-control-static">{{ $congthuc->blend->name }}</p>
                    </div>
                </div>
                <hr>
                                            
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-4 control-label">Số Thông Báo</label>
                        <div class="col-4">
                            <p class="form-control-static">{{ $congthuc->sothongbao }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-4 control-label">Ngày</label>
                        <div class="col-4">
                            <p class="form-control-static">{{ date('d/m/Y', strtotime($congthuc->ngay_thongbao)) }}</p>
                        </div>
                    </div>
                </div>    
                <div class="form-group">
                    <label class="col-10 control-label">Văn bản</label>
                    <div class="col-10">
                    <a href="{{ route('down_congthuc',$congthuc->id) }}"><b>{{substr($congthuc->file,31)}}</b></a><br>
                    </div>
                </div>          
                </br>

          <!-- Table Gia Lieu -->
          <!-- /.row -->
                <div class="row">
                    <h4 style="margin-top: 5px;">A. Gia liệu</h4>
                    <div class="table-responsive">                               
                        <table class="table" id="gialieu_table">
                            <thead>
                                <tr>
                                    <th>Gia Liệu</th>
                                    <th width="20%">Tỷ Lệ</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($congthuc->gialieus->sortBy('pivot.stt') as $gialieu)
                            <tr>
                            <td>{{ $gialieu->name }}</td>
                            <td>{{ number_format($gialieu->pivot->tyle,3) }}</td>
                            </tr>
                                
                            @endforeach
                            </tbody>
                        </table>
                    </div>     
                </div>
            <!-- End Table -->
                </br>
                <!-- Table Gia Lieu -->
                <!-- /.row -->
                <div class="row">
                    <h4 style="margin-top: 5px;">B. Hương liệu</h4>
                    <div class="table-responsive">                            
                        <table class="table" id="huonglieu_table">
                            <thead>
                                <tr>
                                    <th>Hương Liệu</th>
                                    <th width="20%">Tỷ Lệ</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($congthuc->huonglieus->sortBy('pivot.stt') as $huonglieu)
                                <tr>
                                <td>{{ $huonglieu->name }}</td>
                                <td>{{ number_format($huonglieu->pivot->tyle,3) }}</td>
                                </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>        
                </div>
                <!-- End Table -->
          
            </div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
		<!-- EndTable Data -->

      <!-- this row will not appear when printing -->
      <!-- <div class="col-md-12"> -->
      
      <!-- </div> -->
                  
          @can('edit congthuc')
          <a href="{{ url('congthuc/edit/'.$congthuc->id) }}" class="btn btn-primary float-right" role="button" aria-pressed="true"><i class="fas fa-edit"></i>Edit</a>
          @endcan
          <br></br>

    </form>

                <!-- Modal -->
                <div class="modal fade" id="modal-import">
					<div class="modal-dialog">
					<form action="{{ route('update_file_congthuc',$congthuc->id) }}" method="POST" enctype="multipart/form-data">
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
<!-- bs-custom-file-input -->
<script src="{{ asset("/bower_components/admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js") }} "></script>

<script>
$(function () {
  bsCustomFileInput.init();
});
</script>

<script>
    $(document).ready(function(){
        $('#blend').select2({
            theme: 'bootstrap4',
            minimumInputLength: 3,
            width: '100%',
            ajax: {
                url: '{{ route("blend_search") }}',
                dataType: 'json',
            },
        });
    });

</script>

<script>
    $(document).ready(function(){
        let row_number = 0;
        let rowCount2 = $('#gialieu_table').length-1;
        $("#add_row2").click(function(e){
        e.preventDefault();
        
        var newRowContent2 = '<tr id="row_id_'+rowCount2+'">'+'<td>'+'<select class="form-control select2-gialieu" name="gialieu[]">'+
        
        '</select>'+'</td><td><input type="number" step="any" name="tyle[]" class="form-control" value="" /></td><td><button id="delete" onclick="doSomething('+rowCount2+')">xoa</button></td></tr>';

        $("#gialieu_table").append(newRowContent2);
        rowCount2++;
        $('.select2-gialieu').select2({
                theme: 'bootstrap4',
                minimumInputLength: 3,
                width: '100%',
                ajax: {
                    url: '{{ route("glhl_search") }}',
                    dataType: 'json',
                },
            });    
        });
    
    });
</script>



<script>
    function doSomething(value) {
        $("#row_id_"+value).remove();
    }
</script>

<script>
    $(document).ready(function(){
        let row_number = 0;
        let rowCount = $('#huonglieu_table').length-1;
        $("#add_row").click(function(e){
        e.preventDefault();
        
        var newRowContent = '<tr id="row_id_'+rowCount+'">'+'<td>'+'<select class="form-control select2-huonglieu" name="huonglieu[]">'+
        
        '</select>'+'</td><td><input type="number" step="any" name="tyle2[]" class="form-control" value="" /></td><td><button id="delete" onclick="xoahang('+rowCount+')">xoa</button></td></tr>';

        $("#huonglieu_table").append(newRowContent);
        rowCount++;
        $('.select2-huonglieu').select2({
                theme: 'bootstrap4',
                minimumInputLength: 3,
                width: '100%',
                ajax: {
                    url: '{{ route("glhl_search") }}',
                    dataType: 'json',
                },
            });    
        });

        
    
    });
</script>



<script>
    function xoahang(value) {
        $("#row_id_"+value).remove();
    }
</script>



@endpush
