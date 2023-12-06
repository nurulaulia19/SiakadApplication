

{{-- bener --}}

@extends('layoutsAdmin.main')
@section('content')
    <div id="container" class="effect aside-float aside-bright mainnav-lg">
		@if (session('activated'))
            <div class="alert alert-success" role="alert">
               {{ session('activated') }}
           </div>
        @endif
        <div class="boxed">
            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <div id="page-head">         
					<div class="pad-all text-center">
						<h3>Welcome back to the Dashboard</h3>
						<p>This is your experience to manage the Sistem Informasi Akademik Application</p>
					</div>
                </div>  
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
					    <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Edit Berita</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                {{-- @foreach ( $dataMenu as $item)  --}}
                                    
                                
								<form action="{{ route('berita.update', $dataBerita->id_berita) }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="judul">Judul</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Judul" name="judul" id="judul" class="form-control" value="{{ $dataBerita->judul }}">
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="gambar">Gambar</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="gambar" id="gambar" class="form-control">
                                                @if ($dataBerita->gambar)
                                                    <a href="{{ asset($dataBerita->gambar) }}" target="_blank">
                                                        <img src="{{ asset('storage/photos/'.basename($dataBerita->gambar)) }}" width="100px" alt="Gambar">
                                                    </a>
                                                @endif
                                                @if ($errors->has('gambar'))
                                                        <span class="text-danger">{{ $errors->first('gambar') }}</span>
                                                @endif
                                            </div>                                                   
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="deskripsi">Deskripsi</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" id="deskripsi" name="deskripsi">{{ $dataBerita->deskripsi }}</textarea>
                                                {{-- <input type="text" placeholder="deskripsi" name="deskripsi" id="deskripsi" class="form-control" value="{{ $dataBerita->deskripsi }}"> --}}
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="status">Status</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="status" id="status">
                                                    <option selected >Pilih Status</option>
                                                    <option value="ditampilkan" {{ $dataBerita->status === 'ditampilkan' ? 'selected' : '' }}>Ditampilkan</option>
                                                    <option value="tidak" {{ $dataBerita->status === 'tidak' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('berita.index') }}" class="btn btn-secondary">KEMBALI</a>
                                            <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                        </div>
                                    </div>
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                                {{-- @endforeach --}}
                            </div>
                        </div>	
                        @if(session('error'))
							<div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
				        @endif    
                </div>
                <!--===================================================-->
                <!--End page content-->

            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

			

        <!-- SCROLL PAGE BUTTON -->
        <!--===================================================-->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
        <!--===================================================-->

    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection







