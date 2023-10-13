

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
                                    <h3 class="panel-title">Tambah Akses Sekolah</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="/aksessekolah/store">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <select name="id_sekolah" id="id_sekolah" class="form-control">
                                                    <option disabled selected>Pilih Sekolah</option>
                                                    @foreach ($dataSekolah as $item)
                                                        <option value="{{ $item->id_sekolah }}">{{ $item->nama_sekolah }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_sekolah')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_id">Nama Admin</label>
                                            <div class="col-sm-9">
                                                <select name="user_id" id="user_id" class="form-control">
                                                    <option disabled selected>Pilih Admin</option>
                                                    @foreach ($dataUser as $item)
                                                        <option value="{{ $item->user_id }}">{{ $item->user_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                {{-- <span id="CabangError" class="error-message"></span> --}}
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('aksessekolah.index') }}" class="btn btn-secondary">KEMBALI</a>
                                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                                        </div>
                                    </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                        
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


        </div>


        <!-- SCROLL PAGE BUTTON -->
        <!--===================================================-->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
        <!--===================================================-->
    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection