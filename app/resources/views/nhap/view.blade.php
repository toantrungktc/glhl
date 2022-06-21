@extends('layouts.user_temp')

@section('title', 'Chi tiết Nhập')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/nhap') }}">Nhập</a></li>
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
					<a class="float-left" href="{{ url('/nhap/log/'.$log->id) }}" role="button">&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-history"></i></a>
				@endrole
                @can('edit nhap')
                    <a href="{{ url('nhap/edit/'.$log->id) }}" class="float-right" role="button" aria-pressed="true"><i class="fas fa-edit"></i> Edit</a>
                @endcan    
               
			</div>
        </div>
						<!-- /.card-header -->
	    <div class="card card-primary" style="top: -20px">
			<div class="card-body">
                
                <div class="row">
                    <div class="col-6">
                        <label for="noidung" class="col-7 control-label">Số chứng từ</label>
                        <div class="col-7">
                            <p class="form-control-static">{{ $log->so_ct }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="col-6 control-label">Ngày nhập</label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{ $log->ngay_nhap }}</p>
                        </div>
                    </div>
                </div>
                

          <!-- Table Gia Lieu -->
          <!-- /.row -->
                <div class="row">
                    
                    <div class="table-responsive">                               
                        <table class="table" id="gialieu_table">
                            <thead>
                                <tr>
                                    <th>Tên vật tư</th>
                                    <th width="20%">Khối lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($log->nhap_details as $detail)
                                
                                    <tr>
                                    <td>{{ $detail->glhl->name }}</td>
                                    <td>{{ number_format($detail->khoiluong,2) }}</td>
                                    </tr>
                                 
                            @endforeach
                            </tbody>
                        </table>
                    </div>     
                </div>
            <!-- End Table -->
                </br>
                
          
            </div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
		<!-- EndTable Data -->

      <!-- this row will not appear when printing -->
      <!-- <div class="col-md-12"> -->
      
      <!-- </div> -->
                  
      <a href="{{ url('nhap/print/'.$log->id) }}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
          <a href="{{ url('nhap/edit/'.$log->id) }}" class="btn btn-primary float-right" role="button" aria-pressed="true"><i class="fa fa-plus"></i>Edit</a>
          <br></br>

    </form>
    </div>
  </div>
</div>

@endsection


@push('scripts')
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
