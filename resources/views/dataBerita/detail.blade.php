@extends('layoutsLandingPage.main')
@section('content')
<div class="parallax filter filter-color-red">
     <!-- services section -->
    <div class="section-service mt-5">
        <div class="d-flex justify-content-center">
            <div class="header">
                <h1 class="text-center">{{ $dataBerita->judul }}</h2>
                <div class="row" style="margin-top:35px">
                    <div>
                        <img src="{{ asset('storage/photos/'.basename($dataBerita->gambar)) }}" class="d-block w-100 h-auto" style="max-height: 80vh;" alt="news 1">
                    </div>
                </div> 
            </div>
    </div>
    {{-- <hr class="horizontal-line" style="width: 10%; border: 1px solid #000; margin: 20px auto;"> --}}
    <div class="section-news" style="margin-top: 20px;">
        <div class="d-flex justify-content-center">
            <div class="header text-start">
                <p>{{ $dataBerita->deskripsi }}</p>
            </div>
        </div>
    </div>

    @yield('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</div>
@endsection

