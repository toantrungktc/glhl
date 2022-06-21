@extends('layouts.user_temp')

@section('title', 'Pha chế')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/xuat') }}">Xuất</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/xuat/show/'.$log->id) }}">Chi tiết</a></li>
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
      <form class="form" method="post" action="{{ route('update_xuat',$log->id) }}">
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
                    <label for="noidung">Tên Blend</label>
                    <div >
                    <div class="col-sm-7">
                        <p class="form-control-static">{{ $log->congthuc->blend->name }}</p>
                    </div>
                    </div>
                </div>
                <hr>                              
                <input type="hidden" id="ct_id" name="ct_id" >

                <div class="row">
                    <div class="col-6">
                        <label class="col-sm-3 control-label">Số Thông Báo</label>
                        <div class="col-6">
                        <input type="text" class="form-control" id="sothongbao" name="sothongbao" value="{{ $log->congthuc->sothongbao }}" readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="col-sm-3 control-label">Ngày ban hành</label>
                        <div class="col-6">
                            <input type="date" class="form-control" id="ngay_thongbao" name="ngay_thongbao" value="{{ $log->congthuc->ngay_thongbao }}" readonly>
                        </div>
                    </div>
                </div>    
          
                <br>
                <?php $now = Carbon\Carbon::today()->toDateString();?>
                <div class="row">
                    <div class="col-4">
                        <label class="col-4 control-label">Ngày pha chế</label>
                        <div class="col-6">
                        <input type="date" class="form-control" id="ngay_pha" name="ngay_pha" placeholder="Nhập khối lượng pha" value="{{ $log->ngay_pha }}">                        </div>
                    </div>
                    <div class="col-4">
                        <label class="col-4 control-label">Khối lượng lá</label>
                        <div class="col-6">
                            <input type="number" class="form-control" id="kl_la" name="kl_la" placeholder="Nhập khối lượng pha" value="{{ $log->kl_la }}">                        </div>
                    </div>
                    <div class="col-4">
                        <label class="col-4 control-label">Khối lượng sợi</label>
                        <div class="col-6">
                            <input type="number" class="form-control" id="kl_soi" name="kl_soi" placeholder="Nhập khối lượng pha" value="{{ $log->kl_soi }}">
                        </div>
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
                                        <th width="20%">Khối lượng</th>
                                        <!-- <th width="5%">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody id="gialieu_tbody">
                                    @foreach($log->details as $index => $detail)
                                        @if ( $detail->loai_vt == 1 ) 
                                            <tr id="row_id_{{ $index }}">
                                                <td><input type="hidden" id="gl_id_{{ $index }}" name="gialieu[]" value="{{ $detail->id }}">{{  $detail->glhl->name }}</td>
                                                <td><input type="number" readonly step="any" id="gl_tyle_id_{{ $index }}" name="tyle[]" class="form-control" value="{{ number_format($detail->tyle,3) }}" ></td>
                                                <td><input type="number" step="any" id="gl_row_id_{{ $index }}" name="khoiluong[]" class="form-control"  value="{{ number_format($detail->khoiluong,3) }}"></td>
                                            </tr>
                                        @endif
                                    @endforeach             
                                </tbody>
                            </table>                    
                                                
                    </div>
                    <!-- <button id="add_row2" class="btn btn-default float-left">+ Add Row</button> -->
       
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
                                            <th width="20%">Khối lượng</th>
                                            <!-- <th width="5%">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="huonglieu_tbody">
                                    <?php $i=0; ?>
                                        @foreach($log->details as $detail)
                                            @if ( $detail->loai_vt == 2 ) 
                                                <tr id="row_id_{{ $i }}">
                                                    <td><input type="hidden" id="hl_id_{{ $i }}" name="huonglieu[]" value="{{ $detail->id }}">{{  $detail->glhl->name }}</td>
                                                    <td><input type="number" readonly step="any" id="hl_tyle_id_{{ $i }}" name="tyle2[]" class="form-control" value="{{ number_format($detail->tyle,3) }}" ></td>
                                                    <td><input type="number" step="any" id="hl_row_id_{{ $i }}" name="khoiluong2[]" class="form-control"  value="{{ number_format($detail->khoiluong,3) }}"></td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endif
                                        @endforeach                 
                                    </tbody>
                                </table>                    
                                                    
                        </div>
                        <!-- <button id="add_row" class="btn btn-default float-left">+ Add Row</button> -->
        
                    </div>
                <!-- End Table -->
          
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
    function number_format (number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    $("#blend").on("change", function () { 
        var congthuc_id = $(this).val(); // get the selected value
        var url = "{{ route('search_congthuc', ":id") }}";
        url = url.replace(':id', congthuc_id);
        //$("#gialieu_tbody").empty();
        //$('#myModalLabel').html("Chọn "+congthuc_id);
        $.get(url, function (data) {
            $('#ct_id').val(data.id);
            $('#sothongbao').val(data.sothongbao);
            $('#ngay_thongbao').val(data.ngay_thongbao);
            
            $("#gialieu_tbody").empty();
            $.each(data.gialieus, function(index, itemData) {
                $('#gialieu_table').append('<tr id="row_id_'+index+'">'+'<td><input type="hidden" id="gl_id_'+index+'" name="gialieu[]" value="'+itemData.id+'">'+itemData.name+'</td><td><input type="number" readonly step="any" id="gl_tyle_id_'+index+'" name="tyle[]" class="form-control" value="'+number_format(itemData.pivot.tyle,3)+'" ></td><td><input type="number" step="any" id="gl_row_id_'+index+'" name="khoiluong[]" class="form-control" ></td></tr>')
            });

            $("#huonglieu_tbody").empty();
            $.each(data.huonglieus, function(index, itemData) {
                $('#huonglieu_table').append('<tr id="row_id_'+index+'">'+'<td><input type="hidden" id="hl_id_'+index+'" name="huonglieu[]" value="'+itemData.id+'">'+itemData.name+'</td><td><input type="number" readonly step="any" id="hl_tyle_id_'+index+'" name="tyle2[]" class="form-control" value="'+number_format(itemData.pivot.tyle,3)+'" ></td><td><input type="number" step="any" id="hl_row_id_'+index+'" name="khoiluong2[]" class="form-control" ></td></tr>')
            });
            
        });
        
        //$("#show_table").load("ajax/table.php?selected="+selected); // load the table in the div
    });
</script>

<script type="text/javascript">
	
	$(function() {
		$('#kl_la').on('change', function(){
			var khoiluong = $('#kl_la').val();
            let rowCount = $('#gialieu_table tr').length;
            var rowCount2 = $('#gialieu_table tr:last').index();
			

            for(i=0;i<=rowCount2;i++){
                var tyle = $('#gl_tyle_id_'+i).val();
                $('#gl_row_id_'+i).val((khoiluong*tyle)/100);
               }
			
		});
	});

    $(function() {
		$('#kl_soi').on('change', function(){
			var khoiluong_soi = $('#kl_soi').val();
            // let rowCount_soi = $('#gialieu_table tr').length;
            var rowCount2_soi = $('#huonglieu_table tr:last').index();
			

            for(i=0;i<=rowCount2_soi;i++){
                var tyle_hl = $('#hl_tyle_id_'+i).val();
                $('#hl_row_id_'+i).val((khoiluong_soi*tyle_hl)/100);
               }
			
		});
	});
</script>


@endpush
