

{{-- bener --}}

@extends('layoutsSiswa.main')
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
                                    <h3 class="panel-title">Edit Profil</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                {{-- @foreach ( $dataMenu as $item)  --}}
                                    
                                
								<form method="POST" action="{{ route('profilSiswa.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nama_siswa">Nama Siswa</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Siswa" name="nama_siswa" id="nama_siswa" class="form-control" value="{{ $dataSiswa->nama_siswa }}">
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tempat_lahir">Tempat Lahir</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Tempat Lahir" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ $dataSiswa->tempat_lahir }}">
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tanggal_lahir">Tanggal Lahir</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Tanggal Lahir" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ $dataSiswa->tanggal_lahir }}">
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="foto_siswa">Foto</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="foto_siswa" id="foto_siswa" class="form-control">
                                                @if ($dataSiswa->foto_siswa)
                                                    <a href="{{ asset($dataSiswa->foto_siswa) }}" target="_blank">
                                                        <img src="{{ asset('storage/photos/'.basename($dataSiswa->foto_siswa)) }}" width="100px" alt="">
                                                    </a>
                                                @endif
                                                @if ($errors->has('foto_siswa'))
                                                    <span class="text-danger">{{ $errors->first('foto_siswa') }}</span>
                                                @endif
                                            </div>                                                   
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('siswa.home') }}" class="btn btn-secondary">KEMBALI</a>
                                            <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                        </div>
                                    </div>
                                        @if(session('success'))
                                        <div class="alert alert-info">
                                            {{ session('success') }}
                                        </div>
                                        @endif
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




