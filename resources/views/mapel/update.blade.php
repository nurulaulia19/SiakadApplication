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
                                    <h3 class="panel-title">Edit Pelajaran</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
								<form action="{{ route('mapel.update', $dataPelajaran->id_pelajaran) }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="kode_pelajaran">Kode Pelajaran</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Kode Pelajaran" name="kode_pelajaran" id="kode_pelajaran" class="form-control" value="{{ $dataPelajaran->kode_pelajaran }}">
                                                <span id="namapelajaranError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nama_pelajaran">Nama Pelajaran</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Pelajaran" name="nama_pelajaran" id="nama_pelajaran" class="form-control" value="{{ $dataPelajaran->nama_pelajaran }}">
                                                <span id="namapelajaranError" class="error-message"></span>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_id">Nama Guru</label>
                                            <div class="col-sm-9">
                                                <select name="user_id" id="user_id" class="form-control">
                                                    @foreach ($dataUser as $item)
                                                    <option value="{{ $item->user_id }}" {{ $item->user_id == $dataPelajaran->user_id ? 'selected' : '' }}>
                                                        {{ $item->user_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span id="namasekolahError" class="error-message"></span>
                                            </div>
                                        </div> --}}
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <select name="id_sekolah" id="id_sekolah" class="form-control">
                                                    @foreach ($dataSekolah as $item)
                                                    <option value="{{ $item->id_sekolah }}" {{ $item->id_sekolah == $dataPelajaran->id_sekolah ? 'selected' : '' }}>
                                                        {{ $item->nama_sekolah }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span id="namasekolahError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('mapel.index') }}" class="btn btn-secondary">KEMBALI</a>
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









