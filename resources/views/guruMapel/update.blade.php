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
                                    <h3 class="panel-title">Edit Guru Mata Pelajaran</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
								<form action="{{ route('guruMapel.update', $dataGp->id_gp) }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <select name="id_sekolah" id="id_sekolah" class="form-control" onchange="handleSekolahChange(this.value)">
                                                    @foreach ($dataSekolah as $item)
                                                    <option value="{{ $item->id_sekolah }}" {{ $item->id_sekolah == $dataGp->id_sekolah ? 'selected' : '' }}>
                                                        {{ $item->nama_sekolah }}
                                                    </option>
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
                                            <label class="col-sm-3 control-label" for="id_kelas">Nama Kelas</label>
                                            <div class="col-sm-9">
                                                <select name="id_kelas" id="id_kelas" class="form-control">
                                                    @foreach ($dataKelas as $item)
                                                    <option value="{{ $item->id_kelas }}" {{ $item->id_kelas == $dataGp->id_kelas ? 'selected' : '' }}>
                                                        {{ $item->nama_kelas }}
                                                    </option>
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tahun_ajaran">Tahun Ajaran</label>
                                            <div class="col-sm-9">
                                                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                                                    <option disabled>Pilih Tahun Ajaran</option>
                                                    @php
                                                        $currentYear = date('Y');
                                                    @endphp
                                                    @for ($year = 2020; $year <= $currentYear; $year++)
                                                        <option value="{{ $year }}" {{ $year == $dataGp->tahun_ajaran ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                @error('tahun_ajaran')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_pelajaran">Nama Pelajaran</label>
                                            <div class="col-sm-9">
                                                <select name="id_pelajaran" id="id_pelajaran" class="form-control">
                                                    @foreach ($dataPelajaran as $item)
                                                    <option value="{{ $item->id_pelajaran }}" {{ $item->id_pelajaran == $dataGp->id_pelajaran ? 'selected' : '' }}>
                                                        {{ $item->nama_pelajaran }}
                                                    </option>
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_pelajaran">Nama Pelajaran</label>
                                            <div class="col-sm-9">
                                                <select name="id_pelajaran" id="id_pelajaran" class="form-control">
                                                    <option disabled selected>Pilih Mata Pelajaran</option>
                                                </select>
                                                @error('id_pelajaran')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                       <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_id">Nama Guru</label>
                                            <div class="col-sm-9">
                                                <select name="user_id" id="user_id" class="form-control">
                                                    @foreach ($dataUser as $item)
                                                    <option value="{{ $item->user_id }}" {{ $item->user_id == $dataGp->user_id ? 'selected' : '' }}>
                                                        {{ $item->user_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span id="namasekolahError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('guruMapel.index') }}" class="btn btn-secondary">KEMBALI</a>
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
                        @error('id_kelas')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                        @enderror
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

    <script>
        function handleSekolahChange(sekolahID) {
            // var  = $('#sekolah').val();  
            let token = $("meta[name='csrf-token']").attr("content");  
            if (sekolahID) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('guruMapel.getKelas') }}",
                    data: {
                        'sekolahID': sekolahID,
                        "_token": token
                    },
                    dataType: 'JSON',
                    success: function(res) {  
                        console.log(res);             
                        if (res) {
                            $("#id_kelas").empty();
                            $("#id_kelas").append('<option disabled selected>Pilih Kelas</option>');
                            $.each(res, function(nama_kelas, id_kelas) {
                                $("#id_kelas").append('<option value="'+id_kelas+'">'+nama_kelas+'</option>');
                            });
                        } else {
                            $("#id_kelas").empty();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error); // Menampilkan pesan kesalahan ke konsol
                    }
                });
    
                $.ajax({
                    type: "GET",
                    url: "{{ route('guruMapel.getMapel') }}",
                    data: {
                        'sekolahID': sekolahID,
                        "_token": token
                    },
                    dataType: 'JSON',
                    success: function(res) {  
                        console.log(res);             
                        if (res) {
                            $("#id_pelajaran").empty();
                            $("#id_pelajaran").append('<option disabled selected>Pilih Mata Pelajaran</option>');
                            $.each(res, function(nama_pelajaran, id_pelajaran) {
                                $("#id_pelajaran").append('<option value="'+id_pelajaran+'">'+nama_pelajaran+'</option>');
                            });
                        } else {
                            $("#id_pelajaran").empty();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error); // Menampilkan pesan kesalahan ke konsol
                    }
                });
    
                
            } else {
                $("#id_kelas").empty();
                $("#id_pelajaran").empty();
            }      
    
            
        }
    </script>
@endsection








