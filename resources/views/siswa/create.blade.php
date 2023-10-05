

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
                                    <h3 class="panel-title">Tambah Siswa</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="/siswa/store" enctype="multipart/form-data">
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
                                            <label class="col-sm-3 control-label" for="nis_siswa">NIS</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="NIS" name="nis_siswa" id="nis_siswa" class="form-control @error('nis_siswa') is-invalid @enderror">
                                                @if ($errors->has('nis_siswa'))
                                                    <span class="text-danger">NIS sudah ada.</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nama_siswa">Nama Siswa</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Siswa" name="nama_siswa" id="nama_siswa" class="form-control" required>
                                                @error('nama_siswa')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div> 
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tempat_lahir">Tempat Lahir</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Tempat Lahir" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                                                @error('tempat_lahir')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tanggal_lahir">Tanggal Lahir</label>
                                            <div class="col-sm-9">
                                                <input type="date" placeholder="Tanggal Lahir" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                                                @error('tanggal_lahir')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tahun_masuk">Tahun Masuk</label>
                                            <div class="col-sm-9">
                                                <select name="tahun_masuk" id="tahun_masuk" class="form-control" required>
                                                    <option disabled selected>Pilih Tahun Masuk</option>
                                                    @php
                                                        $currentYear = date('Y');
                                                        for ($year = 2020; $year <= $currentYear; $year++) {
                                                            echo "<option value='$year'>$year</option>";
                                                        }
                                                    @endphp
                                                </select>
                                                @error('tahun_masuk')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>                                        
                                        {{-- <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tahun_masuk">Tahun Masuk</label>
                                            <div class="col-sm-9">
                                                <input type="year" placeholder="Tahun Masuk" name="tahun_masuk" id="tahun_masuk" class="form-control" required>
                                                @error('tahun_masuk')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="jenis_kelamin">Jenis Kelamin</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                                    <option disabled selected>Pilih Jenis Kelamin</option>
                                                    <option value="L">Laki-laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                                @error('jenis_kelamin')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_password">Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" placeholder="Password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                                                    <span id="passwordError" class="error-message"></span>
                                                    @if ($errors->has('password'))
                                                        <span class="text-danger">Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.</span>
                                                    @endif
                                            </div>
                                        </div> --}}
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="foto_siswa">Foto</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="foto_siswa" id="foto_siswa" class="form-control">
                                                    @if ($errors->has('foto_siswa'))
                                                        <span class="text-danger">{{ $errors->first('foto_siswa') }}</span>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">KEMBALI</a>
                                        <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
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



