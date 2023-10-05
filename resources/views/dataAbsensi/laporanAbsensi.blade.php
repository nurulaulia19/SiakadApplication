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
                                    <h3 class="panel-title">Cek Nilai</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="{{ route('dataAbsensi.tampilkanAbsensi') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <select name="id_sekolah" id="id_sekolah" class="form-control" onchange="handleSekolahChange(this.value)">
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
                                            <label class="col-sm-3 control-label" for="id_kelas">Nama Kelas</label>
                                            <div class="col-sm-9">
                                                <select name="id_kelas" id="id_kelas" class="form-control">
                                                    <option disabled selected>Pilih Kelas</option>
                                                </select>
                                                @error('id_kelas')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="tahun_ajaran">Tahun Ajaran</label>
                                            <div class="col-sm-9">
                                                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                                                    <option disabled selected>Pilih Tahun Ajaran</option>
                                                    @php
                                                        $currentYear = date('Y');
                                                        for ($year = 2020; $year <= $currentYear; $year++) {
                                                            echo "<option value='$year'>$year</option>";
                                                        }
                                                    @endphp
                                                </select>
                                                @error('tahun_ajaran')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_pelajaran">Mata Pelajaran</label>
                                            <div class="col-sm-9">
                                                <div class="checkbox-container" style="display: flex; flex-direction: column;">
                                                    <div id="id_pelajaran">
                                                    </div>
                                                </div>
                                                @error('id_pelajaran')
                                                    <span class="alert text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nis_siswa">Nis / Nama Siswa</label>
                                            <div class="col-sm-9">
                                                <select name="nis_siswa[]" id="demo-cs-multiselect" class="form-control" data-placeholder="Pilih Siswa...">
					                            </select>
                                                @error('nis_siswa')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="panel-footer text-right">
                                        <button type="submit" class="btn btn-primary">TAMPILKAN</button>
                                    </div>
                                </form>

                                <!--===================================================-->
                                <!--End Horizontal Form-->
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <div style="display: flex; justify-content: space-between;">
                                            {{-- @if ($dataNilai)
                                            <table class="table" style="width: 21%; max-width: 21%;">
                                                <tbody>
                                                    <!-- Menampilkan informasi mata pelajaran -->
                                                    <tr>
                                                        <th style="width: 50%; border: none;">Nama Sekolah<span style="float: right;">:</span></th>
                                                        <th style="width: 50%; border: none;">
                                                            @if (count($dataNilai) > 0 && $dataNilai[0]->guruPelajaran)
                                                                {{ $dataNilai[0]->guruPelajaran->sekolah->nama_sekolah }}
                                                            @else
                                                                Data Guru Pelajaran Tidak Ditemukan
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    
                                                    <!-- Menampilkan informasi siswa -->
                                                    <tr>
                                                        <th style="width: 50%; border: none;">Nis Siswa<span style="float: right;">:</span></th>
                                                        <th style="width: 50%; border: none;">
                                                            @if (count($dataNilai) > 0)
                                                                {{ $dataNilai[0]->nis_siswa }}
                                                            @else
                                                                Data Guru Pelajaran Tidak Ditemukan
                                                            @endif
                                                        </th>                                                        
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th style="width: 50%; border: none;">Nama Siswa<span style="float: right;">:</span></th>
                                                        <th style="width: 50%; border: none;">
                                                            @if (count($dataNilai) > 0 && $dataNilai[0]->siswa)
                                                                {{ $dataNilai[0]->siswa->nama_siswa }}
                                                            @else
                                                                Data Guru Pelajaran Tidak Ditemukan
                                                            @endif
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @endif --}}
                                            {{-- @if ($dataKk)
                                            <div style="display: flex; justify-content: flex-end; align-items: flex-end;">
                                                <a style="margin-right: 10px; height: 35px; font-size: 13px;" href="{{ route('exportNilai.pdf', ['id_sekolah' => $id_sekolah[0], 'nis_siswa' => $nis_siswa[0]]) }}" class="btn btn-sm btn-danger">Export to PDF</a>
                                                <a style="margin-right: 10px; height: 35px; font-size: 13px;" href="{{ route('exportNilai.excel', ['id_sekolah' => $id_sekolah[0], 'nis_siswa' => $nis_siswa[0]]) }}" class="btn btn-sm btn-success">Export to Excel</a>
                                            </div> 
                                            @endif                                            --}}
                                        </div>
                                        <table class="table table-striped" style="margin-top: 10px">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nis</th>
                                                    <th>Nama</th>
                                                    <th>Tanggal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataAd as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $item->nis_siswa }}</td>
                                                        <td>
                                                            @if ($item->guruPelajaran && $item->guruPelajaran->siswa)
                                                                {{ $item->guruPelajaran->siswa->nama_siswa }}
                                                            @else
                                                                Data Siswa Tidak Ditemukan
                                                            @endif
                                                        </td>                                                        
                                                        <td>{{ $item->tanggal }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        
                                        
                                    </div>
                                </div>
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

    {{-- filter data kelas dan data siswa berdasarkan id sekolah --}}
    <script>
        function handleSekolahChange(sekolahID) {
            // var  = $('#sekolah').val();  
            let token = $("meta[name='csrf-token']").attr("content");  
            if (sekolahID) {
                 // Mengambil data siswa berdasarkan sekolah
                 $.ajax({
                    type: "GET",
                    url: "{{ route('kenaikanKelas.getkelas') }}",
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
                    url: "{{ route('kenaikanKelas.getsiswa') }}",
                    data: {
                        'sekolahID': sekolahID,
                        "_token": token
                    },
                    dataType: 'JSON',
                    beforeSend: function(){ 
                      $('ul.chosen-results').empty(); 
                      $("#demo-cs-multiselect").empty(); 
                    },
                    success: function(res2) { 
                                     
                        if (res2) {
                            console.log(res2);
                            $("#demo-cs-multiselect").empty();
                            $("#demo-cs-multiselect").append('<option disabled selected>Pilih Siswa...</option>');
                            $.each(res2, function(nama_siswa, nis_siswa) {
                                console.log(nama_siswa);
                                // $("#demo-cs-multiselect").append('<option value="'+id_siswa+'">'+nama_siswa+'</option>');
                                $("#demo-cs-multiselect").append('<option value="' + nis_siswa + '">' + nis_siswa + ' | ' + nama_siswa + '</option>');

                            });
                            $("#demo-cs-multiselect").trigger("chosen:updated");
                        } else {
                            $("#demo-cs-multiselect").empty();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error); // Menampilkan pesan kesalahan ke konsol
                    }
                });
            } else {
                $("#demo-cs-multiselect").empty();
            }      
            
            $.ajax({
                type: "GET",
                url: "{{ route('mapelKelas.getMapel') }}",
                data: {
                    'sekolahID': sekolahID,
                    "_token": token
                },
                dataType: 'JSON',
                success: function(res) {
                    console.log(res);
                    if (res) {
                        // Hapus semua elemen di dalam #id_pelajaran
                        $("#id_pelajaran").empty();
                        
                        // Tambahkan daftar mata pelajaran yang diterima dari server
                        $.each(res, function(namaPelajaran, idPelajaran) {
                            let checkBoxElement = $("<div class='form-check'>"+
                                "<input class='form-check-input' name='id_pelajaran[]' type='checkbox' value='"+idPelajaran+"' id='id_pelajaran_"+idPelajaran+"'>"+
                                "<label class='form-check-label'>"+namaPelajaran+"</label>"+
                            "</div>");
                            $("#id_pelajaran").append(checkBoxElement);
                        });
                    } else {
                        $("#id_pelajaran").empty();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                }
            });
            
        }
    </script>
@endsection
