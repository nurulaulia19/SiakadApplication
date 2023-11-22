@extends('layoutsLandingPage.main')
@section('content')
<div class="parallax filter filter-color-red">
    
    <!-- first section -->
    {{-- <div class="first-section d-flex align-items-center justify-content-center" style="background-image: url('{{ asset('assets/landingpage/img/graduated.jpg') }}'); background-size: cover; height: 500px;">
        <!-- Your content goes here -->
    </div> --}}
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        {{-- <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/landingpage/img/graduated.jpg') }}" class="d-block w-100 h-auto" style="max-height: 80vh;" alt="Slide 1">
            </div>            
            <div class="carousel-item">
                <img src="{{ asset('assets/landingpage/img/class.jpg') }}" class="d-block w-100 h-auto" style="max-height: 80vh;" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/landingpage/img/student.jpg') }}" class="d-block w-100 h-auto" style="max-height: 80vh;" alt="Slide 2">
            </div>
            <!-- Add more slides as needed -->
        </div> --}}
        <!-- resources/views/your-view.blade.php -->
        <div class="carousel-inner">
            @foreach($dataSlider as $key => $item)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/photos/'.basename($item->gambar)) }}" class="d-block w-100 h-auto" style="max-height: 80vh;" alt="Slide {{ $key + 1 }}">
                </div>
            @endforeach
        </div>
        <!-- Carousel controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
     <!-- services section -->
    <div class="section-service">
        <div class="container ">
            <div class="d-flex justify-content-center mb-4">
                <div class="header">
                    <h1>Our Services</h1>
                    <div class="separator">♦ ♦ ♦ ♦ ♦</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum vitae voluptatem tempora ipsam, voluptatum, porro enim assumenda, illum quod quidem quia error. Repellendus similique rerum, dolor dolores doloremque voluptatum dicta!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                   <div class="service-card text-center">
                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                        <h2>Angular</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore.</p>
                   </div>
                </div>
                <div class="col-md-4">
                   <div class="service-card text-center">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <h2>Django</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore.</p>
                   </div>
                </div>
                <div class="col-md-4">
                   <div class="service-card text-center">
                        <i class="fa fa-hourglass" aria-hidden="true"></i>
                        <h2>Laravel</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore.</p>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <!-- school section  -->
    <div class="who-we-are bg-light">
        <div class="container">
            <div class="d-flex justify-content-center mb-4">
                <div class="header">
                    <h1>Daftar Sekolah</h1>
                    <div class="separator">♦ ♦ ♦ ♦ ♦</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum vitae voluptatem tempora ipsam, voluptatum, porro enim assumenda, illum quod quidem quia error. Repellendus similique rerum, dolor dolores doloremque voluptatum dicta!</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row">
                        @foreach($sekolah as $item)
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <img src="{{ asset('storage/photos/'.basename($item->logo)) }}" class="img-fluid rounded-circle" alt="{{ $item->nama_sekolah }}" style="width:100px">
                                        <h3>{{ $item->nama_sekolah }}</h3>
                                        <p>{{ $item->alamat }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- news section -->
    {{-- <div class="section-service">
        <div class="container ">
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
                                <p>{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>                
            </div>
        </div>
    </div> --}}
    <div class="section-service">
        <div class="container ">
            <div class="d-flex justify-content-center mb-4">
                <div class="header">
                    <h1>BERITA</h1>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    @php $counter = 0 @endphp
                    @foreach($dataBerita as $item)
                        @if($counter < 3)
                            <div class="col-lg-4 col-sm-4 animate-slide-up">
                                <div class="service-card">
                                    <div class="about-image">
                                        <img src="{{ asset('storage/photos/'.basename($item->gambar)) }}" class="d-block w-100 h-auto" style="max-height: 80vh;" alt="{{ $item->judul }}">
                                    </div>
                                    <a href="{{ route ('berita.detail' , $item->id_berita) }}" >
                                        <h3 style="margin-top: 20px">{{ $item->judul }}</h3>
                                    </a>
                                    <p>{{ $item->deskripsi }}</p>
                                </div>
                            </div>
                            @php $counter++ @endphp
                        @else
                            @break
                        @endif
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

