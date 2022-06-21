@extends('layouts.user_temp')

@section('title', 'Profile')


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
                <h3 class="card-title">Profile</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
          
                      <!-- Profile Image -->
                      <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                          <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle user_avatar" src="{{asset(Auth::user()->avatar)}}" alt="User profile picture">
                          </div>
          
                          <h3 class="profile-username text-center user_name">{{ Auth::user()->name }}</h3>
          
                          <p class="text-muted text-center">{{ Auth::user()->roles->first()->name }}</p>
          
                        <input type="file" name="admin_image" id="admin_image" style="opacity: 0;height:1px;display:none">
                        <a href="javascript:void(0)" class="btn btn-primary btn-block" id="change_picture_btn"><b>Change Avatar</b></a>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
          
      
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                      <div class="card">
                        <div class="card-header p-2">
                          <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link  active" href="#info" data-toggle="tab">Thông tin</a></li>
                            <li class="nav-item"><a class="nav-link" href="#passwords" data-toggle="tab">Đổi mật khẩu</a></li>
                            

                          </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                          <div class="tab-content">
                            <div class="tab-pane active" id="info">
                              <form class="form-horizontal" action="{{ route('update_info') }}" method="POST" id="InfoUserForm">                              
                                @csrf <!-- để xử lý lỗi 419 -->

                                <div class="form-group row">
                                  <label for="name" class="col-sm-2 col-form-label">Name</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ Auth::user()->name }}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="username" class="col-sm-2 col-form-label">Username</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Name" value="{{ Auth::user()->username }}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="username" class="col-sm-2 col-form-label">Email</label>
                                  <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ Auth::user()->email }}">
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="mail" name="mail" value="1" {{ Auth::user()->mail == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="mail">Thông báo Mail</label>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input"  id="sms" name="sms" value="1" {{ Auth::user()->sms == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="sms">Thông báo SMS</label>
                                  </div>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Lưu</button>
                              </form>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="passwords">
                              <form class="form-horizontal" action="{{ route('change_password') }}" method="POST" id="changePasswordUserForm">                              
                                @csrf <!-- để xử lý lỗi 419 -->
                                <div class="form-group row">
                                  <label for="inputName" class="col-sm-2 col-form-label">Old Passord</label>
                                  <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputName" placeholder="Enter current password" name="oldpassword">
                                    <span class="text-danger error-text oldpassword_error"></span>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="inputName2" class="col-sm-2 col-form-label">New Password</label>
                                  <div class="col-sm-10">
                                    <input type="password" class="form-control" id="newpassword" placeholder="Enter new password" name="newpassword">
                                    <span class="text-danger error-text newpassword_error"></span>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="inputName2" class="col-sm-2 col-form-label">Confirm New Password</label>
                                  <div class="col-sm-10">
                                    <input type="password" class="form-control" id="cnewpassword" placeholder="ReEnter new password" name="cnewpassword">
                                    <span class="text-danger error-text cnewpassword_error"></span>
                                  </div>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Lưu</button>
                              </form>
                            
                            </div>
                              <!-- /.tab-pane -->
                            
                          </div>
                      <!-- /.tab-content -->

                        </div><!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- /.col -->
                  </div>
				  
                </div>
                <!-- /.card-body -->

                
            </div>
            <!-- /.card -->

            

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

<script src="{{ asset('/plugins/ijaboCropTool/ijaboCropTool.min.js') }}"></script> 

<script>
  $(document).on('click','#change_picture_btn', function(){
    $('#admin_image').click();
  });

  $('#admin_image').ijaboCropTool({
     preview : '.user_avatar',
     setRatio:1,
     allowedExtensions: ['jpg', 'jpeg','png'],
     buttonsText:['CROP','QUIT'],
     buttonsColor:['#30bf7d','#ee5155', -15],
     processUrl:'{{ route("crop_avatar") }}',
     withCSRF:['_token','{{ csrf_token() }}'],
     onSuccess:function(message, element, status){
        alert(message);
     },
     onError:function(message, element, status){
       alert(message);
     }
  });

  $('#changePasswordUserForm').on('submit', function(e){
         e.preventDefault();
         $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function(){
              $(document).find('span.error-text').text('');
            },
            success:function(data){
              if(data.status == 0){
                $.each(data.error, function(prefix, val){
                  $('span.'+prefix+'_error').text(val[0]);
                });
              }else{
                $('#changePasswordUserForm')[0].reset();
                alert(data.msg);
              }
            }
         });
    });

    $('#InfoUserForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
           url:$(this).attr('action'),
           method:$(this).attr('method'),
           data:new FormData(this),
           processData:false,
           dataType:'json',
           contentType:false,
           beforeSend:function(){
               $(document).find('span.error-text').text('');
           },
           success:function(data){
                if(data.status == 0){
                  $.each(data.error, function(prefix, val){
                    $('span.'+prefix+'_error').text(val[0]);
                  });
                }else{
                  $('.user_name').each(function(){
                     $(this).html( $('#InfoUserForm').find( $('input[name="name"]') ).val() );
                  });
                  alert(data.msg);
                }
           }
        });
    });

</script>

@endpush
