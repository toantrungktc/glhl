<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }} | @yield('title')</title>

  <!-- PWA  -->
  <meta name="theme-color" content="#007BFF"/>
  <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
  <link rel="manifest" href="{{ asset('/manifest.json') }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/dist/css/adminlte.min.css") }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css") }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/select2/css/select2.min.css") }}">
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.css") }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/dist/css/adminlte.min.css") }}">
  <link rel="stylesheet" href="{{ asset('/plugins/ijaboCropTool/ijaboCropTool.min.css') }}">

  @yield('test')
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

<!-- Navbar -->
@include('layouts.navbar')  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
                @yield('title')
                <small>@yield('page_description')</small>
            </h1>
          </div><!-- /.col -->
          
          @yield('diachi')

          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        @yield('content')
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset("/bower_components/admin-lte/plugins/jquery/jquery.min.js") }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset("/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("/bower_components/admin-lte/dist/js/adminlte.min.js") }}"></script>
<!-- Select2 -->
<script src="{{ asset("/bower_components/admin-lte/plugins/select2/js/select2.full.min.js") }}"></script>

<script src="https://js.pusher.com/4.4/pusher.min.js"></script>

@stack('scripts')

<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>

<script>
  $(document).on('select2:open', () => {
    document.querySelector('.select2-container--open .select2-search__field').focus();
  });
</script>

<script type="text/javascript">
  var notificationsWrapper   = $('.dropdown-notifications');
  var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
  var notificationsCountElem = notificationsToggle.find('i[data-count]');
  var notificationsCount     = parseInt(notificationsCountElem.data('count'));
  var notificationsCount2 = parseInt($('#notifi-count').text());
  var notifications          = notificationsWrapper.find('div.add-notifi');
  
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;
  
  var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
      cluster: 'ap1',
      encrypted: true
  });

  // Subscribe to the channel we specified in our Laravel Event
  var user = <?php echo Auth::user() ; ?>;
  var channel = pusher.subscribe('NotificationEvent'+user.id);

  // Bind a function to a Event (the full Laravel class)
  channel.bind('send-message', function(data) {
      console.log(data);
      // $('#test').append('<p>hello</p>'); 
      var audio = new Audio('{{ url('/fileupload/audio/ring.wav') }}');
      var existingNotifications = notifications.html();
      var newNotificationHtml = `
            <a href="{{ url('congthuc/markasread/`+data.id_ct+`') }}" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="{{ url('/`+data.user_avatar+`') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    <strong>`+data.title+`</strong>  
                  </h3>
                  <p class="text-sm">`+data.name_ct+`</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>about a minute ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
      `;
      
          notifications.html(newNotificationHtml + existingNotifications);

          notificationsCount2 += 1;
          // notificationsCountElem.attr('data-count', notificationsCount);
          // notificationsWrapper.find('.notif-count').text(notificationsCount);
          $("#notifi-count").html(notificationsCount2);
          notificationsWrapper.show();
      
          
          audio.play();

      
      
  });
</script>
<script>
  function json(url) {
  return fetch(url).then(res => res.json());
}

let apiKey = 'a444abe225b702920c973490c0c82d318831748bcc68f1d6e3bcb22d';
json(`https://api.ipdata.co?api-key=${apiKey}`).then(data => {
  console.log(data.ip);
  console.log(data.city);
  console.log(data.country_code);
  $("#userip").val(data.ip);

  // so many more properties
});
</script>

</body>
</html>
