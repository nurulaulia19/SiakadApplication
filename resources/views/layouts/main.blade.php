<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="{{url('assets/bootstrap/css/style.css')}}"/>  --}}
    <link rel="stylesheet" type="text/css" href="{{url('assets/css/bootstrap.min.css')}}"/> 
  </head>
  <body>
    <header class="header">
        @include('layouts.header')
    </header>
    {{-- @include('layouts.nav') --}}
    <div class="content">
        @yield('content')
        @include('layouts.footer')
    </div>
    <footer>
        @include('layouts.footer')
    </footer>
    {{-- <script src="{{url('assets/bootstrap/js/components/bootstrap.js')}}"></script> --}}
  </body>
</html>