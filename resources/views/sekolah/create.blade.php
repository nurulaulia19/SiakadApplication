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
                                    <h3 class="panel-title">Tambah Sekolah</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="/sekolah/store" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nama_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Sekolah" name="nama_sekolah" id="nama_sekolah" class="form-control">
                                                <span id="namasekolahError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nama_kepsek">Nama Kepala Sekolah</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Kepala Sekolah" name="nama_kepsek" id="nama_kepsek" class="form-control">
                                                <span id="namakepsekError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="logo">Logo</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="logo" id="logo" class="form-control">
                                                <span id="logoError" class="error-message"></span>
                                                    @if ($errors->has('logo'))
                                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="alamat">Alamat</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Alamat" name="alamat" id="alamat" class="form-control">
                                                <span id="alamat" class="error-message"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <a href="{{ route('sekolah.index') }}" class="btn btn-secondary">KEMBALI</a>
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



