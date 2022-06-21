@extends('layouts.user_temp')

@section('title', 'Chi tiết')


@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
			<!-- card -->
		    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Vai trò</h3>
                <a href="{{ url('user/role/edit/'.$role->id) }}" class="float-right" role="button" aria-pressed="true"><i class="fas fa-edit"></i> Edit</a>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
			{!! Form::open(array('route' => array('update_role', $role->id),'method'=>'POST', 'files'=>true, 'class'=>'form-horizontal')) !!}
                <div class="card-body">
				          <div class="form-group">
                    <label for="username">Name</label>
                    <p class="form-control-static">{{ $role->name }}</p>
                  </div>
	
                  <div class="form-group">
                    <label for="exampleInputEmail1">Vai Trò</label>
                      <div class="form-group">
                      @foreach($role->permissions as $key => $per)
										    <span class="badge badge-danger">{{ $per->name }}</span>
										  @endforeach
                      </div>
                  </div>

                  
				  
                </div>
                <!-- /.card-body -->

                <!-- <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Lưu</button>
                </div> -->
			{{ Form::close() }}
            </div>
            <!-- /.card -->

        </div>
    </div>
</div>
@endsection


@push('scripts')


@endpush
