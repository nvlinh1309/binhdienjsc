<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Binh Dien JSC'}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <x-layouts.header/>
    <div class="container-fluid pb-3">
        <div class="d-grid gap-3" style="grid-template-columns: 0fr 2fr;">
        <x-layouts.nav-left/>
        
        <div class="bg-light border rounded-3">
         {{ $slot }}
        </div>
        </div>
    </div>
    <x-layouts.footer/>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>