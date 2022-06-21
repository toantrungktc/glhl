@extends('layouts.user_temp')

@section('title', 'Nhập')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/nhap') }}">Log</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/nhap/show/'.$log->id) }}">Chi tiết</a></li>
            <li class="breadcrumb-item">Edit</li>
            
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
      <form class="form" method="post" action="{{ route('update_nhap',$log->id) }}">
                            @csrf <!-- để xử lý lỗi 419 -->
      <!-- title row -->
        <div class="card card-primary sticky-top" style="top: 58px">
					<div class="card-header">
						<h3 class="card-title">Pha chế</h3>
            <button type="submit" class="btn btn-primary btn-xs float-right" style="margin-right: 5px;">
            <i class="far fa-save"></i> Lưu
          </button>
					</div>
        </div>
						<!-- /.card-header -->
	    <div class="card card-primary" style="top: -20px">
			<div class="card-body">
                <div class="form-group">
                <label for="recipient-name" class="col-form-label">Số Chứng từ</label>
					<input type="text" class="form-control" id="so_ct" name="so_ct" placeholder="Nhập Số Chứng từ" value="{{ $log->so_ct }}">
                </div>
                <hr>                              
                <input type="hidden" id="lan" name="lan" value="{{ $log->lan + 1 }}">
                
                
                <?php $now = Carbon\Carbon::today()->toDateString();?>
                <div class="form-group">
					<label for="recipient-name" class="col-form-label">Ngày nhập</label>
					<input type="date" class="form-control" id="ngay_nhap" name="ngay_nhap" placeholder="Nhập ngày tháng" value="{{ $log->ngay_nhap }}">
				</div>


          <!-- Table Gia Lieu -->
          <!-- /.row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                            <table class="table" id="gialieu_table">
                                <thead>
                                    <tr>
                                        <th>Gia Liệu</th>
                                        <th width="20%">Khối lượng</th>
                                        <th width="20%">Action</th>
                                        <!-- <th width="5%">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody id="gialieu_tbody">
                                    @foreach($log->nhap_details as $index => $detail)
                                    
                                    <tr id="row_id_{{ $index }}">
                                        <input type="hidden" id="id" name="id[]" value="{{ $detail->id }}">
                                        <input type="hidden" id="khoiluong_old[]" name="khoiluong_old[]" value="{{ number_format($detail->khoiluong,2) }}">
                                        <td>
                                            <select class="form-control select2-gialieu" name="gialieu[]">
                                                <option value="{{ $detail->vattu_id }}">{{ $detail->glhl->name }}</option>  
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="khoiluong[]" value="{{ number_format($detail->khoiluong,2) }}">
                                        </td>
                                        <td><button id="delete" onclick="doSomething({{ $index }})" class="btn btn-outline-primary btn-block "><i class="far fa-trash-alt" title="Delete"></i></button></td>                  
                                    </tr>
                                    @endforeach                  
                                </tbody>
                            </table>                    
                                                
                    </div>
                    <button id="add_row2" class="btn btn-default float-left">+ Add Row</button>
       
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
          <!-- <button id="add_row2" class="btn btn-default float-left">+ Add Row</button> -->
      
      <!-- </div> -->
                  
          <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
            <i class="fa  fa-plus"></i> Lưu
          </button>
          <br></br>

    </form>
    </div>
  </div>
</div>

@endsection


@push('scripts')


<script>
    $(document).ready(function(){
        let row_number = 0;
        let rowCount2 = $('#gialieu_table tr').length-1;
        $("#add_row2").click(function(e){
        e.preventDefault();
        
        var newRowContent2 = '<tr id="row_id_'+rowCount2+'">'+'<input type="hidden" id="id" name="id[]" value="0"><input type="hidden" id="khoiluong_old[]" name="khoiluong_old[]" value="0">'+'<td>'+'<select class="form-control select2-gialieu" name="gialieu[]">'+
        
        '</select>'+'</td><td><input type="number" step="any" name="khoiluong[]" class="form-control" value="" /></td><td><button id="delete" onclick="doSomething('+rowCount2+')">xoa</button></td></tr>';

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


@endpush
