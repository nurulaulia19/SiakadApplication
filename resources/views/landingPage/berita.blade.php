@extends('layoutsLandingPage.main')
@section('content')
<div class="parallax filter filter-color-red">
    <!-- news section -->
    <div class="section-service mt-5">
        <div class="container main-content" style="min-height: calc(100vh - 100px); position: relative;">
            <div class="d-flex justify-content-center mb-4">
                <div class="header">
                    <h1>BERITA</h1>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    @foreach($dataBerita as $item)
                        <div class="col-lg-4 col-sm-4 animate-slide-up">
                            <div class="service-card">
                                <div class="about-image">
                                    <img src="{{ asset('storage/photos/'.basename($item->gambar)) }}" class="d-block w-100 h-auto" style="max-height: 80vh;" alt="{{ $item->judul }}">
                                </div>
                                <a href="{{ route ('berita.detail' , $item->id_berita) }}" >
                                <h3 style="margin-top: 20px">{{ $item->judul }}</h3> </a>
                                <p class="deskripsi">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>                
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

    .deskripsi {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Menentukan jumlah baris yang ingin ditampilkan */
        -webkit-box-orient: vertical;
    }

    .main-content {
        flex: 1;
    }
  </style>

@yield('script')
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
  </script>
  
 
@endsection

