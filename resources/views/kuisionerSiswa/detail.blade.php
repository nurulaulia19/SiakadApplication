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
					                {{-- <div class="panel-heading">
					                    <h3 class="panel-title">Data Kuisioner Detail</h3>
					                </div> --}}
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    {{-- <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-7 table-toolbar-left">
													<a href="{{ route('kenaikanKelas.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a>
					                            </div>
					                        </div>
					                    </div> --}}
                                        <table class="table" style="width: 21%; max-width: 21%;">
                                            <tbody>
                                                <!-- Menampilkan informasi mata pelajaran -->
                                                <tr>
                                                    <th style="width: 50%; border: none;">Mata Pelajaran<span style="float: right;">:</span></th>
                                                    <th style="width: 50%; border: none;">
                                                        @foreach ($guruPelajaran as $guruMapel)
                                                            @if ($guruMapel->id_gp == $id_gp)
                                                                @if ($guruMapel->mapelList !== null && count($guruMapel->mapelList) > 0)
                                                                    @foreach ($guruMapel->mapelList as $mapel)
                                                                        {{ $mapel->nama_pelajaran }},
                                                                    @endforeach
                                                                @else
                                                                    Data Mata Pelajaran Tidak Ditemukan
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </th>
                                                </tr>
                                                
                                                <!-- Menampilkan informasi guru -->
                                                <tr>
                                                    <th style="width: 50%; border: none;">Nama Guru<span style="float: right;">:</span></th>
                                                    {{-- <th style="width: 50%; border: none;">
                                                        @if (count($dataNilai) > 0)
                                                            {{ $dataNilai[0]->nis_siswa }}
                                                        @else
                                                            Data Guru Pelajaran Tidak Ditemukan
                                                        @endif
                                                    </th>                                                         --}}
                                            </tbody>
                                        </table>
					                    <div class="table-responsive">
					                        <table class="table table-striped">
					                            <thead>
					                                <tr>
                                                        <th>No</th>
                                                        <th>Kategori</th>
                                                        <th>Pertanyaan</th>
                                                        <th>Sangat Baik</th>
                                                        <th>Baik</th>
                                                        <th>Kurang Baik</th>

					                                </tr>
					                            </thead>
                                                {{-- <tbody
                                                    @foreach ($guruPelajaran as $guruMapel)
                                                        @if ($guruMapel->id_gp == $id_gp)
                                                            @foreach ($guruMapel->absensiDetail as $absensi)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $absensi->tanggal }}</td>
                                                                    <td>{{ $absensi->keterangan }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </tbody> --}}
					                        </table>
					                    </div>
                                        {{-- {{ $dataKk->appends(['search' => $search, 'sekolah_filter' => $sekolahFilter, 'tahun_ajaran_filter' => $tahunAjaranFilter])->links('pagination::bootstrap-4') }} --}}
                                        <div class="text-right mt-3">
                                            <a href="{{ route('kuisionerSiswa.index') }}" class="btn btn-primary">KEMBALI</a>
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
