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
								<h3 class="panel-title">Dashboard Guru</h3>
							</div>
							<div class="pad-all">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- Timeline -->
                                        <!--===================================================-->
                                        <div class="info">
                                            <div class="panel panel-warning panel-colorful media middle pad-all">
                                                <div class="media-left">
                                                    <div class="pad-hor">
                                                        <i class="fas fa-book-open icon-3x"></i>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <p class="text-2x mar-no text-semibold">{{ $jumlahMapel }}</p>
                                                    <p class="mar-no">Mata Pelajaran</p>
                                                </div>
                                            </div>
                                            <div class="panel panel-info panel-colorful media middle pad-all">
                                                <div class="media-left">
                                                    <div class="pad-hor">
                                                        <i class="fas fa-users icon-3x"></i>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <p class="text-2x mar-no text-semibold">{{ $jumlahSiswa }}</p>
                                                    <p class="mar-no">Siswa</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--===================================================-->
                                        <!-- End Timeline -->
                                
                                    </div>
                                    <div class="col-lg-6" style="padding-left: 30px">
                                        <h4>Jadwal Pelajaran</h4>
                                        <!-- Timeline -->
                                        <!--===================================================-->
                                        <div class="timeline">
                                
                                            <!-- Timeline header -->
                                            <div class="timeline-header">
                                                <div class="timeline-header-title bg-purple">{{ $hariIni }}</div>
                                            </div>
                                            {{-- <div class="timeline-entry">
                                                <div class="timeline-stat">
                                                    <div class="timeline-icon bg-warning"><i class="fas fa-clock icon-lg"></i></div>
                                                    <div class="timeline-time">
                                                        @foreach ($gpData as $gp)
                                                            @if ($gp->guruMapelJadwal)
                                                                @foreach ($gp->guruMapelJadwal as $jadwal)
                                                                    @if ($jadwal->hari === $hariIni)
                                                                        {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </div>                                     
                                                </div>
                                                <div class="timeline-label">
                                                    @foreach ($gpData as $gp)
                                                        <p>{{ $gp->mapel->nama_pelajaran }}</p>
                                                    @endforeach 
                                                </div>
                                            </div> --}}
                                            @foreach ($gpData as $gp)
                                                @if ($gp->guruMapelJadwal)
                                                    @foreach ($gp->guruMapelJadwal as $jadwal)
                                                        @if ($jadwal->hari === $hariIni)
                                                            <div class="timeline-entry">
                                                                <div class="timeline-stat">
                                                                    <div class="timeline-icon bg-danger"><i class="fas fa-clock icon-lg"></i></div>
                                                                    <div class="timeline-time">
                                                                        {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                                                    </div>
                                                                </div>
                                                                <div class="timeline-label">
                                                                    <p>{{ $gp->mapel->nama_pelajaran }}</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                        <!--===================================================-->
                                        <!-- End Timeline -->
                                
                                    </div>
                                </div>
							</div>
						</div>
					</div>					
					    {{-- <div class="row">
					    	<div class="col-md-6">
					            <div class="panel panel-danger panel-colorful media middle pad-all">
					                <div class="media-left">
					                    <div class="pad-hor">
											<i class="fas fa-book-open icon-3x"></i>
					                    </div>
					                </div>
					                <div class="media-body">
										<p class="text-2x mar-no text-semibold">{{ $jumlahMapel }}</p>
										<p class="mar-no">Mata Pelajaran</p>
									</div>
					            </div>
					        </div>
					        <div class="col-md-6">
					            <div class="panel panel-warning panel-colorful media middle pad-all">
					                <div class="media-left">
					                    <div class="pad-hor">
					                        <i class="fas fa-users icon-3x"></i>
					                    </div>
					                </div>
					                <div class="media-body">
					                    <p class="text-2x mar-no text-semibold">{{ $jumlahSiswa}}</p>
					                    <p class="mar-no">Siswa</p>
					                </div>
					            </div>
					        </div>
					    </div> --}}
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




  <!--jQuery [ REQUIRED ]-->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  {{-- <script src="js/jquery.min.js"></script> --}}



  