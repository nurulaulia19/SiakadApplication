@extends('layoutsLandingPage.main')
@section('content')
<div class="parallax filter filter-color-red">
    <!-- news section -->
    <div class="section-service mt-5">
        <div class="container main-content" style="min-height: calc(100vh - 100px); position: relative;">
            <div class="d-flex justify-content-center mb-4">
                <div class="header">
                    <h1>BROSUR</h1>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Unduh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataBrosur as $item)
                        <tr>
                            <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                            <td style="vertical-align: middle;">{{ $item->judul }}</td> 
                            <td style="vertical-align: middle;">
                                <a href="{{ route('unduh.brosur', ['id_brosur' => $item->id_brosur]) }}" style="margin-left: 15px">
                                    <i style="font-size: 18px" class="fas fa-download"></i> 
                                </a>
                            </td>                                                                                 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>  
        </div>
    </div>  
</div>

@yield('css')
<style>
    /* CSS Anda */
    .animate-slide-up {
      opacity: 0;
      transform: translateY(50px);
      transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .animate-slide-up.active {
      opacity: 1;
      transform: translateY(0);
    }
    .main-content {
        flex: 1;
    }
  </style>

@yield('script')
{{-- @yield('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Sebelum penutup tag </body> -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
      var elements = document.querySelectorAll('.animate-slide-up');
  
      function handleScroll() {
        elements.forEach(function (element) {
          var bounding = element.getBoundingClientRect();
          if (bounding.top < window.innerHeight - 100) {
            element.classList.add('active');
          }
        });
      }
  
      // Pertama kali panggil untuk menangani elemen yang terlihat saat halaman dimuat
      handleScroll();
  
      // Tambahkan event listener scroll
      window.addEventListener('scroll', handleScroll);
    });
  </script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 
@endsection

