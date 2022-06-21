<!-- Navbar sticky-top-->
<nav class="main-header navbar navbar-expand-md navbar-light bg-primary sticky-top">
    <div class="container">
      <a href="../../home" class="navbar-brand">
        <img src="{{ asset("/bower_components/admin-lte/dist/img/khatoco.png") }}" alt="AdminLTE Logo" class="brand-image" >
        <!-- <span class="brand-text font-weight-light">Key</span> -->
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          @can('view congthuc')
          <li class="nav-item">
            <a href="{{ url('/blend') }}" class="nav-link">Blend</a>
          </li>
          @endcan
          @can('view congthuc')
          <li class="nav-item">
            <a href="{{ url('/congthuc') }}" class="nav-link">Công thức</a>
          </li>
          @endcan
          @can('view glhl')
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">GLHL</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ url('/glhl') }}" class="dropdown-item">Danh sách </a></li>
              <li><a href="{{ url('/glhl/baocao') }}" class="dropdown-item">Báo cáo</a></li>
            </ul>
          </li>
          @endcan
          @can('view xuat')
          <li class="nav-item">
            <a href="{{ url('/xuat') }}" class="nav-link">Xuất</a>
          </li>
          @endcan
          @can('view nhap')
          <li class="nav-item">
            <a href="{{ url('/nhap') }}" class="nav-link">Nhập</a>
          </li>
          @endcan
          @can('view user')
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Setting</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ url('/user') }}" class="dropdown-item">User </a></li>
              <li><a href="{{ url('/user/role') }}" class="dropdown-item">Vai Trò </a></li>
              <li><a href="{{ url('/user/permission') }}" class="dropdown-item">Quyền </a></li>
              <li><a href="{{ url('/setting') }}" class="dropdown-item">Setting</a></li>
            </ul>
          </li>
          @endcan
        </ul>

        <!-- SEARCH FORM -->
        <!-- <form class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form> -->
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown dropdown-notifications">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge notifi-count" id="notifi-count">{{ auth()->user()->unreadNotifications->count() }}</span>

          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">{{ auth()->user()->unreadNotifications->count() }} Notifications</span>
            <div class="dropdown-divider"></div>
            <div class="add-notifi">
            </div>
           
            @foreach (Auth::user()->unreadNotifications->take(5) as $notification)
              <div>
                <a href="{{ url('congthuc/markasread/'.$notification->data['id_ct']) }}" class="dropdown-item">
                  <!-- Message Start -->
                  <div class="media">
                    <img src="{{asset( $notification->data['user_avatar'] ) }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        <strong>{{ $notification->data['title'] }}</strong>  
                      </h3>
                      <p class="text-sm">{{ $notification->data['name_ct'] }}</p>
                      <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</p>
                    </div>
                  </div>
                  <!-- Message End -->
                </a>
              </div>

              <div class="dropdown-divider"></div>
            @endforeach
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>

        

        <!-- User Account Menu -->
        <li class="nav-item dropdown user-menu">
              <!-- Menu Toggle Button -->
              <a class="nav-link" data-toggle="dropdown" href="#">
                <!-- The user image in the navbar-->
                <img src="{{asset(Auth::user()->avatar)}}" class="user-image user_avatar" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                
                <span class="d-none d-xs-block d-ld-inline d-xl-inline user_name" >{{ Auth::user()->name }}</span>


              </a>

              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="{{asset(Auth::user()->avatar)}}" class="img-circle user_avatar" alt="User Image">
                
                  <h6 class="text-center user_name">{{ Auth::user()->name }}</h6>
                  <p class="text-muted text-center">{{ Auth::user()->roles->first()->name }}</p>
                </li>
                
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="float-left">
                    <a href="{{ route('profile_user') }}" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="float-right">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            <input id="userip" type="hidden" name="userip">
      
                    </form>
                  </div>
                </li>
              </ul>
              
        </li>

        <!-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li> -->
      
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->