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
					                    <h3 class="panel-title">Data Kuisioner</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-8 table-toolbar-left">
					                            </div>
                                                <div class="col-md-1">
                                                    <form action="{{ route('absensi.index') }}" method="GET">
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
                                                    <form action="{{ route('absensi.index') }}" method="GET">
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
					                        </div>
					                    </div>
					                    <div class="table-responsive">
					                        <table class="table table-striped">
					                            <thead>
					                                <tr>
                                                        <th>No</th>
                                                        <th>Nama Pelajaran</th>
                                                        <th>Nama Guru</th>

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
                                                            <td class="table-action" style="vertical-align: middle;">
                                                                <div style="display: flex; align-items: center;">
                                                                    @foreach ($guruPelajaran as $guruMapel)
                                                                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                                                                            @php
                                                                                $jawabanExist = DB::table('data_jawaban_kuisioner')
                                                                                    ->where('id_gp', $guruMapel->id_gp)
                                                                                    ->exists();
                                                                            @endphp
                                                                        
                                                                            @if ($jawabanExist)
                                                                                <a href="{{ route('kuisionerSiswa.isi', ['id_gp' => $guruMapel->id_gp]) }}" class="btn btn-sm btn-danger">Jawaban</a>
                                                                            @else
                                                                                <a href="{{ route('kuisionerSiswa.detail', ['id_gp' => $guruMapel->id_gp]) }}" class="btn btn-sm btn-warning">Detail</a>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </td>                                                                                                                     
                                                            {{-- <td class="table-action" style="vertical-align: middle;">
                                                                <div style="display: flex; align-items: center;">
                                                                    @foreach ($guruPelajaran as $guruMapel)
                                                                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                                                                            <a href="{{ route('kuisionerSiswa.detail', ['id_gp' => $guruMapel->id_gp]) }}" class="btn btn-sm btn-warning">Detail</a>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                            <td class="table-action" style="vertical-align: middle;">
                                                                <div style="display: flex; align-items: center;">
                                                                    @foreach ($guruPelajaran as $guruMapel)
                                                                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                                                                            <a href="{{ route('kuisionerSiswa.isi', ['id_gp' => $guruMapel->id_gp]) }}" class="btn btn-sm btn-warning">Jawaban</a>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </td> --}}
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
                        @if(session('success'))
							<div class="alert" style="background-color:#367E18; color:white">
                                {{ session('success') }}
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
