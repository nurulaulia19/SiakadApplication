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
					        <div class="col-xs-12">
					            <div class="panel">
					                <div class="panel-heading">
					                    <h3 class="panel-title">Jadwal Mata Pelajaran</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-8 table-toolbar-left">
					                            </div>
                                                <div class="col-sm-2">
                                                    <form action="{{ route('jadwalGuru.index') }}" method="GET">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="sekolah_filter">Filter Sekolah</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <select name="id_sekolah_filter" id="sekolah_filter" class="form-control">
                                                                        <option value="">Tampilkan Semua</option>
                                                                        @foreach ($dataSekolah as $sekolah)
                                                                            <option value="{{ $sekolah->id_sekolah }}" {{ $sekolahFilter == $sekolah->id_sekolah ? 'selected' : '' }}>
                                                                                {{ $sekolah->nama_sekolah }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-3">
                                                                    <button type="submit" class="btn btn-sm btn-primary mt-1">Filter</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm-2">
                                                    <form action="{{ route('jadwalGuru.index') }}" method="GET">
                                                        <div class="form-group">
                                                            <label for="id_pelajaran_filter">Filter Tahun Ajaran</label>
                                                            <input type="hidden" name="id_sekolah_filter" value="{{ $sekolahFilter }}">
                                                            <select name="tahun_ajaran_filter" id="tahun_ajaran_filter" class="form-control">
                                                                <option value="">Tampilkan Semua</option>
                                                                @foreach ($tahunAjarans as $tahunAjaran)
                                                                    <option value="{{ $tahunAjaran }}" {{ $tahunAjaranFilter == $tahunAjaran ? 'selected' : '' }}>
                                                                        {{ $tahunAjaran }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="submit" class="btn btn-sm btn-primary mt-1" style="margin-left: 5px">Filter</button>
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
                                                        <th>Nama Sekolah</th>
                                                        <th>Nama Kelas</th>
                                                        <th>Tahun Ajaran</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>Nama Guru</th>
                                                        <th>Jadwal</th>
					                                </tr>
					                            </thead>
					                            <tbody>
													
													@foreach ($dataGp as $item)
					                                <tr>
                                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                        <td style="vertical-align: middle;">
                                                            @if ($item->sekolah)
                                                                {{ $item->sekolah->nama_sekolah }}
                                                            @else
                                                                Nama Sekolah not assigned
                                                            @endif
                                                        </td>  
                                                        <td style="vertical-align: middle;">
                                                            @if ($item->kelas)
                                                                {{ $item->kelas->nama_kelas }}
                                                            @else
                                                                Nama Kelas not assigned
                                                            @endif
                                                        </td>  
                                                        {{-- <td> @foreach ($item->mapelList as $mapelList)
															{{ $mapelList->sekolah->nama_sekolah }}
															@if (!$loop->last)
																,
															@endif
															@endforeach
														</td>  --}}
                                                        <td style="vertical-align: middle;">{{ $item->tahun_ajaran }}</td>    
                                                        <td style="vertical-align: middle;">{{ $item->mapel->nama_pelajaran}}</td>   
                                                        <td style="vertical-align: middle;">
                                                            @if ($item->user)
                                                                {{ $item->user->user_name }}
                                                            @else
                                                                Nama Guru not assigned
                                                            @endif
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            @foreach ($item->guruMapelJadwal as $guruMapel)
                                                                <a style="color: blue">
                                                                    {{ $guruMapel->hari }} - {{ $guruMapel->jam_mulai }} to {{ $guruMapel->jam_selesai }}
                                                                </a>
                                                                <br>
                                                            @endforeach
                                                        </td>
					                                </tr>
													@endforeach
					                            </tbody>
					                        </table>
					                    </div>
                                        {{ $dataGp->links('pagination::bootstrap-4') }}
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
