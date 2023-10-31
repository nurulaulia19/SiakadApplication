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
					        <div class="col-xs-12">
					            <div class="panel">
					                <div class="panel-heading">
					                    <h3 class="panel-title">Data Absensi Detail</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-7 table-toolbar-left">
													{{-- <a href="{{ route('kenaikanKelas.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a> --}}
					                            </div>
                                                {{-- <div class="col-md-1">
                                                    <form action="{{ route('jadwal.index') }}" method="GET">
                                                        <div class="form-group">
                                                            <label for="tahun_ajaran_filter">Filter Tahun Ajaran</label>
                                                            <select name="tahun_ajaran_filter" id="tahun_ajaran_filter" class="form-control">
                                                                <option value="">Tampilkan Semua</option>
                                                                <option value="{{ $tahunAjaranFilter }}">{{ $tahunAjaranFilter }}</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-2" style="margin-left:20px">
                                                    <form action="{{ route('jadwal.index') }}" method="GET">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="kelas_filter">Filter Kelas</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input type="hidden" name="tahun_ajaran_filter" value="{{ $tahunAjaranFilter }}">
                                                                    <select name="kelas_filter" id="kelas_filter" class="form-control">
                                                                        <option value="">Tampilkan Semua</option>
                                                                        <option value="{{ $kelasFilter }}">{{ $namaKelas }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-3">
                                                                    <button type="submit" class="btn btn-sm btn-primary mt-1">Filter</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div> --}}
                                                {{-- <div class="col-md-1" style="margin-top: 20px">
                                                    <div class="btn-group">
                                                        <a href="{{ route('exportAbsensiSiswa.pdf') }}" class="btn btn-danger">
                                                            <i style="font-size: 18px" class="fas fa-file-pdf"></i>
                                                        </a>
                                                        <a href="{{ route('exportAbsensiSiswa.excel') }}" style="margin-left: 15px" class="btn btn-success">
                                                            <i style="font-size: 18px" class="fas fa-file-excel"></i>
                                                        </a>                                                                                                               
                                                    </div>
                                                </div>  --}}

					                        </div>
					                    </div>
					                    <div class="table-responsive">
					                        <table class="table table-striped">
					                            <thead>
					                                <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Status</th>

					                                </tr>
					                            </thead>
                                                <tbody>
                                                    {{-- @foreach ($guruPelajaran as $guruMapel)
                                                        @if ($guruMapel->id_gp == $id_gp)
                                                            @foreach ($guruMapel->absensiDetail as $absensi)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $absensi->tanggal }}</td>
                                                                    <td>{{ $absensi->keterangan }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    @endforeach --}}
                                                    @foreach ($guruPelajaran as $guruMapel)
                                                        @if ($guruMapel->id_gp == $id_gp)
                                                            @php
                                                                $absensiAvailable = false;
                                                            @endphp
                                                            @foreach ($guruMapel->absensiDetail as $absensi)
                                                                @if ($absensi->nis_siswa == $nisSiswa)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $absensi->tanggal }}</td>
                                                                        <td>{{ $absensi->keterangan }}</td>
                                                                    </tr>
                                                                    @php
                                                                        $absensiAvailable = true;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            {{-- @if (!$absensiAvailable)
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>-</td>
                                                                </tr>
                                                            @endif --}}
                                                        @endif
                                                    @endforeach

                                                </tbody>
					                        </table>
					                    </div>
                                        {{-- {{ $dataKk->appends(['search' => $search, 'sekolah_filter' => $sekolahFilter, 'tahun_ajaran_filter' => $tahunAjaranFilter])->links('pagination::bootstrap-4') }} --}}
                                        <div class="text-right mt-3">
                                            <a href="{{ route('absensi.index') }}" class="btn btn-primary">KEMBALI</a>
                                            {{-- <button type="submit" class="btn btn-primary">SIMPAN</button> --}}
                                        </div>
					                    <hr class="new-section-xs">
					                </div>
					                <!--===================================================-->
					                <!--End Data Table-->
					
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
@endsection
