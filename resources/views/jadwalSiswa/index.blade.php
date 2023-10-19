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
					                    <h3 class="panel-title">Data Jadwal</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-8 table-toolbar-left">
													{{-- <a href="{{ route('kenaikanKelas.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a> --}}
					                            </div>
                                                <div class="col-md-1">
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
                                                </div>
                                                {{-- <label for="tahun_ajaran_filter">Tahun Ajaran:</label> --}}
                                                {{-- <select name="tahun_ajaran_filter" id="tahun_ajaran_filter">
                                                    <option value="">Pilih Tahun Ajaran</option>
                                                    <option value="{{ $tahunAjaranFilter }}">{{ $tahunAjaranFilter }}</option>
                                                    <!-- Tambahkan opsi-opsi tahun ajaran sesuai dengan data dari controller -->
                                                </select>

                                                <label for="kelas_filter">Kelas:</label>
                                                <select name="kelas_filter" id="kelas_filter">
                                                    <option value="">Pilih Kelas</option>
                                                    <option value="{{ $kelasFilter }}">{{ $kelasFilter }}</option>
                                                    <!-- Tambahkan opsi-opsi kelas sesuai dengan data dari controller -->
                                                </select> --}}

					                        </div>
					                    </div>
					                    <div class="table-responsive">
					                        <table class="table table-striped">
					                            <thead>
					                                <tr>
                                                        <th>No</th>
                                                        <th>Nama Pelajaran</th>
                                                        <th>Nama Guru</th>
                                                        <th>Jadwal</th>
					                                </tr>
					                            </thead>
                                                <tbody>
                                                    @foreach ($pelajaran as $mapel)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $mapel->nama_pelajaran }}</td>
                                                        <td>
                                                            @foreach ($guruPelajaran as $guruMapel)
                                                                @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                                                                    {{ $guruMapel->user->user_name }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($guruPelajaran as $guruMapel)
                                                                @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                                                                    @foreach ($guruMapel->guruMapelJadwal as $jadwal)
                                                                        {{ $jadwal->hari }} - {{ $jadwal->jam_mulai }} to {{ $jadwal->jam_selesai }}
                                                                        <br>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                                </tbody>
					                        </table>
					                    </div>
                                        {{-- {{ $dataKk->appends(['search' => $search, 'sekolah_filter' => $sekolahFilter, 'tahun_ajaran_filter' => $tahunAjaranFilter])->links('pagination::bootstrap-4') }} --}}
                                
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
