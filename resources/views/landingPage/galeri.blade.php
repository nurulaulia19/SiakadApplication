@extends('layoutsLandingPage.main')
@section('content')
<div class="parallax filter filter-color-red">
    <!-- news section -->
    <div class="section-service mt-5">
        <div class="container main-content" style="min-height: calc(100vh - 100px); position: relative;">
            <div class="d-flex justify-content-center mb-4">
                <div class="header">
                    <h1>GALERI</h1>
                </div>
            </div>
            <div class="row">
                {{-- @foreach($dataGaleri as $item)
                    <div class="col-lg-4 col-sm-4 animate-slide-up">
                        <div class="service-card">
                            <div class="about-image">
                                <img src="{{ asset('storage/photos/'.basename($item->gambar)) }}" class="d-block w-100 h-100" alt="{{ $item->judul }}">
                            </div>
                            <h3 style="margin-top: 20px">{{ $item->judul }}</h3>
                        </div>                            
                    </div>
                @endforeach            --}}
                
                <!-- Loop dataGaleri -->
                @foreach($dataGaleri as $item)
                <div class="col-lg-4 col-sm-4 animate-slide-up">
                    <div class="service-card">
                        <div class="about-image">
                            <a href="javascript:void(0)" class="open-modal" data-id="{{ $item->id_galeri }}" data-src="{{ asset('storage/photos/'.basename($item->gambar)) }}">
                                <img src="{{ asset('storage/photos/'.basename($item->gambar)) }}" class="d-block w-100 h-100" alt="{{ $item->judul }}">
                            </a>
                        </div>
                        {{-- <h3 style="margin-top: 20px">{{ $item->judul }}</h3> --}}
                    </div>
                </div>
                @endforeach
                @include('landingPage.modalGambar')
            </div>                      
        </div>
    </div>  
</div>

<style>
    .service-card {
        margin-bottom: 20px; /* Atur jarak antar service-card */
    }

    .about-image {
        width: 100%;
        height: 300px;
        overflow: hidden;
        position: relative;
    }

    /* .about-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    } */

    .main-content {
        flex: 1;
    }

    .about-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8));
        transition: opacity 0.3s ease;
    }

    .image-overlay h3 {
        color: #fff;
        font-size: 18px;
        text-align: center;
        margin: 0;
    }

    .about-image:hover .image-overlay {
        opacity: 1;
    }

    .about-image:hover img {
        transform: scale(1.1);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- JavaScript -->
<script>
    $(document).ready(function() {
        // Ketika tombol "open-modal" diklik
        $(".open-modal").click(function () {
            var id_galeri = $(this).data('id'); // Mengambil nilai data-id dari elemen yang diklik
            var imageUrl = $(this).data('src'); // Mengambil nilai data-src dari elemen yang diklik

            // Memasukkan id_galeri dan imageUrl ke dalam modal
            $("#id_galeri_modal").val(id_galeri);
            $("#gambarModal").attr('src', imageUrl);

            // Menampilkan modal
            $('#modalGambar').modal('show');
        });
    });
</script>


@endsection

