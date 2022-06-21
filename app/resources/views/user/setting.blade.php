@extends('layouts.user_temp')

@section('title', '')


@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
			<!-- card -->
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
		    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Setting</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
			{!! Form::open(array('route' => array('update_setting', $setting->id),'method'=>'POST', 'files'=>true, 'class'=>'form-horizontal')) !!}
                     
                <div class="card-body">
                  
				          <div class="form-group">
										<label for="recipient-name" class="col-form-label">Số ngày gửi mail cảnh báo sớm</label>
										<input type="number" class="form-control" id="daily" name="daily" placeholder="Ngày số ngày" value="{{ $setting->daily }}">
									</div>
									<div class="form-group">
										<label for="recipient-name" class="col-form-label">Ngày gửi mail theo tháng</label>
										<input type="number" class="form-control" id="monthly" name="monthly" placeholder="Nhập ngày" value="{{ $setting->monthly }}">
									</div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Lưu</button>
                </div>
			{{ Form::close() }}
            </div>
            <!-- /.card -->

        </div>
    </div>
</div>
@endsection


@push('scripts')


@endpush
