<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Binh Dien JSC'}}</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">
  {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <x-layouts.header/>
    <x-layouts.sidebar/>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard v3</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v3</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <div class="content">
        <div class="container-fluid">
          <div class="row">
            {{ $slot }}
          </div>
        </div>
      </div>

    </div>
    
    <x-layouts.footer/>
  </div>

  <script src="/template/admin/plugins/jquery/jquery.min.js"></script>
  <script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/template/admin/dist/js/adminlte.js"></script>
  <script src="/template/admin/plugins/chart.js/Chart.min.js"></script>
  <script src="/template/admin/dist/js/demo.js"></script>
  <script src="/template/admin/dist/js/pages/dashboard3.js"></script>
  {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
</body>
    
</body>
</html>