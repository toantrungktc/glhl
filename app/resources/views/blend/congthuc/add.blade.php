@extends('layouts.user_temp')

@section('title', 'Thêm Công thức')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/congthuc') }}">Công thức</a></li>
            <li class="breadcrumb-item">Add</li>
            
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
            <button type="submit" class="btn btn-primary btn-xs float-right" style="margin-right: 5px;">
            <i class="far fa-save"></i> Lưu
          </button>
					</div>
        </div>
						<!-- /.card-header -->
	    <div class="card card-primary" style="top: -20px">
			<div class="card-body">
                <div class="form-group">
                    <label for="noidung">Tên Blend</label>
                    <div >
                        <select class="form-control" id="blend" name="blend" required>            
                        </select>
                    </div>
                </div>
                <hr>                              
                <div class="form-group">
                    
                    <label for="noidung">Số Thông Báo</label>
                    <div>
                        <input type="hidden" name="unique_id" value="">
                        <input type="text" class="form-control" id="sothongbao" name="sothongbao" placeholder="Số văn bản" value="" required>
                    </div>
                            
                    <label for="noidung">Ngày</label>
                    <div>
                        <input type="date" class="form-control" id="ngay_thongbao" name="ngay_thongbao" placeholder="Số văn bản liên quan" value="" required>
                    </div>
                </div>    
          
                <br>

          <!-- Table Gia Lieu -->
          <!-- /.row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                            <table class="table" id="gialieu_table">
                                <thead>
                                    <tr>
                                        <th>Gia Liệu</th>
                                        <th width="20%">Tỷ Lệ</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                                    
                                </tbody>
                            </table>                    
                                                
                    </div>
                    <button id="add_row2" class="btn btn-default float-left">+ Add Row</button>
       
                </div>
            <!-- End Table -->
            </br>
            <!-- Table Gia Lieu -->
            <!-- /.row -->
            <div class="row">
                        <div class="col-12 table-responsive">
                                <table class="table" id="huonglieu_table">
                                    <thead>
                                        <tr>
                                            <th>Hương Liệu</th>
                                            <th width="20%">Tỷ Lệ</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                        
                                    </tbody>
                                </table>                    
                                                    
                        </div>
                        <button id="add_row" class="btn btn-default float-left">+ Add Row</button>
        
                    </div>
                <!-- End Table -->
          
            </div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
		<!-- EndTable Data -->

      <!-- this row will not appear when printing -->
      <!-- <div class="col-md-12"> -->
          <button id="add_row2" class="btn btn-default float-left">+ Add Row</button>
      
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
        let rowCount2 = $('#gialieu_table tr').length-1;
        $("#add_row2").click(function(e){
        e.preventDefault();
        
        var newRowContent2 = '<tr id="row_id_'+rowCount2+'">'+'<td>'+'<select class="form-control select2-gialieu" name="gialieu[]" required>'+
        
        '</select>'+'</td><td><input type="number" min="0" step="any" name="tyle[]" class="form-control" value="" required/></td><td><button id="delete" onclick="doSomething('+rowCount2+')">xoa</button></td></tr>';

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
        let rowCount = $('#huonglieu_table tr').length-1;
        $("#add_row").click(function(e){
        e.preventDefault();
        
        var newRowContent = '<tr id="row2_id_'+rowCount+'">'+'<td>'+'<select class="form-control select2-huonglieu" name="huonglieu[]" required>'+
        
        '</select>'+'</td><td><input type="number" min="0" step="any" name="tyle2[]" class="form-control" value="" required/></td><td><button id="delete" onclick="xoahang('+rowCount+')">xoa</button></td></tr>';

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
        $("#row2_id_"+value).remove();
    }
</script>



@endpush
