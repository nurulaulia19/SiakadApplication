@extends('layoutsLandingPage.main')
@section('content')
<div class="parallax filter filter-color-red">
     <!-- services section -->
    <div class="section-service mt-5">
        <div class="d-flex justify-content-center">
            <div class="header">
                <h1 class="text-center">{{ $dataEskul->judul }}</h2>
                <div class="row" style="margin-top:35px">
                    <div>
                        <img src="{{ asset('storage/photos/'.basename($dataEskul->gambar)) }}" class="d-block w-100 h-auto" style="max-height: 80vh;" alt="news 1">
                    </div>
                </div> 
            </div>
    </div>
    {{-- <hr class="horizontal-line" style="width: 10%; border: 1px solid #000; margin: 20px auto;"> --}}
    <div class="section-news" style="margin-top: 20px;">
        <div class="d-flex justify-content-center">
            <div class="header text-start">
                <p>{{ $dataEskul->deskripsi }}</p>
            </div>
        </div>
    </div>
    {{-- <div class="section-news">
        <div class="d-flex justify-content-center">
            <div class="header text-start">
                <h1>Our Services</h1>
                <ul>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
                </ul>
            </div>
        </div>
    </div> --}}
</div>
@endsection

