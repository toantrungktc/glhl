@extends('layouts.user_temp')

@section('title', 'Chi tiết')


@section('content')
<div class="container ">
    <div class="row justify-content-center ">
        <div class="col-12 ">
			<!-- card -->
		    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Profile</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
			{!! Form::open(array('route' => array('update_role', $role->id),'method'=>'POST', 'files'=>true, 'class'=>'form-horizontal')) !!}
                <div class="card-body">
				          <div class="form-group">
                    <label for="username">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter email" value="{{ $role->name }}">
                  </div>
	
                  <div class="form-group">
                    <label for="exampleInputEmail1">Vài Trò</label>
                      <div class="form-group">
                        @foreach($permissions as  $permission)
                        <div class="form-check form-check-inline" style="width: 230px;">
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input  center-text" id="{{ $permission->id }}" value="{{ $permission->name }}" name="permission[]" {{ $permissionofrole->contains($permission->id) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="{{ $permission->id }}">{{ $permission->name }}</label>
                          </div>
                        </div>
                        @endforeach
                        
                      </div>
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
