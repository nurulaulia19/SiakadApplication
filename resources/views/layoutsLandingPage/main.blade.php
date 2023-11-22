<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('assets/landingpage/css/pilly.css') }}"> --}}
    {{-- <style>
      /* CSS Anda */
      .animate-slide-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
      }

      .animate-slide-up.active {
        opacity: 1;
        transform: translateY(0);
      }
    </style> --}}

    @yield('style')

    @include('layoutsLandingPage.header')
    </head>
    <body>
      <div id="container">
        @include('layoutsLandingPage.nav')
        <div class="boxed">
          @yield('content')   
          {{-- @include('layoutsLandingPage.sidebar') --}}
        
        <footer id="footer">
          @include('layoutsLandingPage.footer')
        </footer>
      </div>
      </div>
         <!--JAVASCRIPT-->
    <!--=================================================-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
  </body>
</html>