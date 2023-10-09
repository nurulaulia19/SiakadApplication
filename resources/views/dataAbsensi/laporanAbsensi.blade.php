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
                                    <h3 class="panel-title">Laporan Absensi</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="{{ route('dataAbsensi.tampilkanAbsensi') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <select name="id_sekolah" id="id_sekolah" class="form-control" onchange="handleSekolahChange(this.value);">
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
                                                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" onchange="handleMapelChange()" required>
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
                                                <select name="id_pelajaran" id="id_pelajaran" class="form-control">
                                                    <option disabled selected>Pilih Mata Pelajaran</option>
                                                    <!-- Opsi mata pelajaran akan ditambahkan melalui JavaScript -->
                                                </select>
                                            </div>
                                        </div>  
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
                                            @if (count($dataAd) > 0)
                                                <table class="table" style="width: 21%; max-width: 21%;">
                                                    <tbody>
                                                        <!-- Menampilkan informasi mata pelajaran -->
                                                        <tr>
                                                            <th style="width: 50%; border: none;">Nama Sekolah<span style="float: right;">:</span></th>
                                                            <th style="width: 50%; border: none;">
                                                                @if (isset($dataAd[0]->guruPelajaran->sekolah))
                                                                    {{ $dataAd[0]->guruPelajaran->sekolah->nama_sekolah }}
                                                                @else
                                                                    Data Sekolah Tidak Ditemukan
                                                                @endif
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width: 50%; border: none;">Nama Kelas<span style="float: right;">:</span></th>
                                                            <th style="width: 50%; border: none;">
                                                                @if (isset($dataAd[0]->guruPelajaran->kelas))
                                                                    {{ $dataAd[0]->guruPelajaran->kelas->nama_kelas }}
                                                                @else
                                                                    Data Kelas Tidak Ditemukan
                                                                @endif
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width: 50%; border: none;">Tahun Ajaran<span style="float: right;">:</span></th>
                                                            <th style="width: 50%; border: none;">
                                                                @if (isset($dataAd[0]->guruPelajaran->tahun_ajaran))
                                                                    {{ $dataAd[0]->guruPelajaran->tahun_ajaran }}
                                                                @else
                                                                    Tahun Ajaran Tidak Ditemukan
                                                                @endif
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width: 50%; border: none;">Mata Pelajaran<span style="float: right;">:</span></th>
                                                            <th style="width: 50%; border: none;">
                                                                @if (isset($dataAd[0]->guruPelajaran->mapel))
                                                                    {{ $dataAd[0]->guruPelajaran->mapel->nama_pelajaran }}
                                                                @else
                                                                    Data Pelajaran Tidak Ditemukan
                                                                @endif
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif

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
                                                    @foreach ($uniqueDates as $tanggal)
                                                    <th>{{ $tanggal }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataAd as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration  }}</td>
                                                    <td>{{ $item->nis_siswa ?? 'Data tidak ditemukan' }}</td>
                                                    <td>
                                                        @if(isset($item->siswa))
                                                            {{ $item->siswa->nama_siswa }}
                                                        @else
                                                            Data tidak ditemukan
                                                        @endif
                                                    </td>                                                        
                                                    {{-- @foreach ($uniqueDates as $tanggal)
                                                    <td>
                                                        @php
                                                        $keterangan = App\Http\Controllers\GuruPelajaranController::getAbsensiDetail($item->id_gp, $item->id_absensi, $tanggal, $item->nis_siswa);
                                                        @endphp
                                                        @if ($item->tanggal == $tanggal)
                                                            {{ $item->keterangan }}
                                                        @endif
                                                    </td>
                                                    @endforeach --}}

                                                    @foreach ($uniqueDates as $tanggal)
                                                    <td>
                                                        @php
                                                        $keterangan = App\Http\Controllers\GuruPelajaranController::getAbsensiDetail($item->id_gp, $item->id_absensi, $tanggal, $item->nis_siswa);
                                                        @endphp
                                                        {{ $keterangan ?? '' }}
                                                    </td>
                                                    @endforeach

                                                    {{-- @foreach ($dataKategori as $item2)
                                                    <td style="vertical-align: middle;">
                                                        @php
                                                            $nilai = App\Http\Controllers\GuruPelajaranController::getNilai($item->id_gp, $item2->id_kn, $item->nis_siswa);
                                                        @endphp
                                                        {{ $nilai }}
                                                    </td>
                                                    @endforeach --}}
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
            let token = $("meta[name='csrf-token']").attr("content");
            
            if (sekolahID) {
                // Mengambil data kelas berdasarkan sekolah
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

                            // Kosongkan atau atur ulang elemen <select> pelajaran ketika sekolah berubah
                            $("#id_pelajaran").empty();
                            $("#id_pelajaran").append('<option disabled selected>Pilih Mata Pelajaran</option>');
                        } else {
                            $("#id_kelas").empty();
                            $("#id_pelajaran").empty(); // Jika data tidak ditemukan, kosongkan elemen <select> pelajaran
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                    }
                });
            } else {
                // Jika tidak ada sekolah yang dipilih, kosongkan elemen <select> kelas dan pelajaran
                $("#id_kelas").empty();
                $("#id_pelajaran").empty();
            }
        }
       
            
        function handleMapelChange() {
            let token = $("meta[name='csrf-token']").attr("content");  
            $.ajax({
                type: "GET",
                url: "{{ route('dataAbsensi.getMapelByKelas') }}",
                data: {
                    'kelasID': $("#id_kelas").val(),
                    'sekolahID': $("#id_sekolah").val(),
                    'tahunAjaranID': $("#tahun_ajaran").val(),
                    "_token": token
                },
                dataType: 'JSON',
                success: function(res) {
                    console.log("Hasil Mapel:", res); // Log data yang diterima
                    if (res) {
                        var selectElement = $("#id_pelajaran");
                        selectElement.empty();
                        selectElement.append("<option value='' disabled selected>Pilih Mata Pelajaran</option>");

                        // Iterasi melalui data pelajaran dan tambahkan pilihan ke elemen <select>
                        $.each(res, function(index, pelajaran) {
                            selectElement.append("<option value='" + pelajaran.id_pelajaran + "'>" + pelajaran.nama_pelajaran + "</option>");
                        });
                    } else {
                        console.log("Data tidak ditemukan."); // Log jika data tidak ditemukan
                        $("#id_pelajaran").empty();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error status:", status); // Log status error
                    console.error("Error message:", error); // Log pesan kesalahan
                }
            });
        }

    </script>
@endsection
