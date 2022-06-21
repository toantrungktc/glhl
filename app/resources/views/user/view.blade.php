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
			{!! Form::open(array('route' => array('update_user', $user->id),'method'=>'POST', 'files'=>true, 'class'=>'form-horizontal')) !!}
                <div class="card-body">
				          <div class="form-group">
                    <label for="username">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter email" value="{{ $user->name }}">
                  </div>
				          <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ $user->email }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if not changing">
                  </div>
                  
                  <!-- <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="mail" value="1" name="mail" {{ $user->mail == 1 ? 'checked' : '' }}>
                      <label class="custom-control-label" for="mail">Thông báo Mail</label>
                    </div>
                  </div>
				          <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="sms" value="1" name="sms" {{ $user->sms == 1 ? 'checked' : '' }}>
                      <label class="custom-control-label" for="sms">Thông báo SMS</label>
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Vài Trò</label>
                      <div class="form-group">
                        @foreach($roles as  $role)
                        <div class="form-check form-check-inline">
                          <div class="custom-control custom-switch ">
                            <input type="checkbox" class="custom-control-input" id="{{ $role->id }}" value="{{ $role->name }}" name="role" {{ $role->id == $roleofuser ? 'checked' : '' }}>
                            <label class="custom-control-label" for="{{ $role->id }}">{{ $role->name }}</label>
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

<script>
$('input[type="checkbox"]').on('change', function() {
  $('input[type="checkbox"]').not(this).prop('checked', false);
});
</script>

@endpush
