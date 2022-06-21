@extends('layouts.user_temp')

@section('title', 'Chi tiết')

@section('diachi')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/blend') }}">Blend</a></li>
            <li class="breadcrumb-item">Chi tiết</li>
            
        </ol>
    </div>
@endsection

@section('content')

<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
        

        <div class="card card-primary sticky-top" style="top: 58px">
					<div class="card-header">
						<h3 class="card-title">Chi tiết</h3>
            
            @can('add congthuc')
            <a href="{{ url('congthuc/create/') }}" class="float-right" role="button" aria-pressed="true"><i class="fa fa-plus"></i> Thêm Công thức</a>  
					  @endcan
          </div>
				</div>
						<!-- /.card-header -->
		    <div class="card card-primary" style="top: -20px">
					<div class="card-body">
						<!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <b>Key:</b> {{ $blend->name }}<br>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <br>
            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>Stt</th>
                    <th>Số thông báo</th>
                    <th>Ngày ban hành</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php $i = 1; ?>
                  @foreach($blend->congthucs as $congthuc)
                  <tr>
                    <td>{{ $i }}</td>
                    <td><a href="{{ url('congthuc/show/'.$congthuc->id) }}"  data-toggle="tooltip" data-placement="right" title="Monitor">{{ $congthuc->sothongbao }}</a></td>
                    <td>{{ $congthuc->ngay_thongbao }}</td>
                    
                  </tr>
                  <?php $i++; ?>
                      @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            </div>
						<!-- /.card-body -->
				  </div>
						<!-- /.card -->
						<!-- EndTable Data -->

        </div>
    </div>
</div>

@endsection


@push('scripts')


@endpush
