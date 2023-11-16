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
								<h3 class="panel-title text-center">Dashboard Admin</h3>
							</div>

							<div class="pad-all">
								@foreach($hasilPerhitungan as $hasil)
									<div class="col-lg-6">
										<!-- Timeline -->
										<!--===================================================-->
										<div class="info">
												<div class="panel-body text-center clearfix">
													<div class="col-sm-4 pad-top">
														<div class="text-lg">
															<p class="text-5x text-thin text-main">{{ $hasil['totalSiswa'] }}</p>
														</div>
														<p class="text-sm text-bold text-uppercase">Total Siswa {{ $hasil['sekolah'] }}</p>
													</div>
													<div class="col-sm-8">
														<a href="{{ route('siswa.index') }}" class="btn btn-pink mar-ver">View Detail</a>
														<p class="text-xs">Hasil perhitungan siswa berdasarkan status</p>
														<ul class="list-unstyled text-center bord-top pad-top mar-no row">
															<li class="col-xs-4">
																<span class="text-lg text-semibold text-main">{{ $hasil ['jumlahAktif'] }}</span>
																<p class="text-sm text-muted mar-no">Aktif</p>
															</li>
															<li class="col-xs-4">
																<span class="text-lg text-semibold text-main">{{ $hasil ['jumlahLulus'] }}</span>
																<p class="text-sm text-muted mar-no">Lulus</p>
															</li>
															<li class="col-xs-4">
																<span class="text-lg text-semibold text-main">{{ $hasil ['jumlahKeluar'] }}</span>
																<p class="text-sm text-muted mar-no">Keluar</p>
															</li>
														</ul>
													</div>
												</div>
												<div class="panel panel-danger panel-colorful media middle pad-all">
													<!-- Sesuaikan dengan struktur HTML dan penggunaan variabel yang sesuai -->
													<a href="{{ route('mapel.index') }}" class="text-white">
														<div class="media-left">
															<div class="pad-hor">
																<i class="fas fa-book-open icon-3x"></i>
															</div>
														</div>
														<div class="media-body">
															<p class="text-2x mar-no text-semibold">{{ $hasil['jumlahMapel'] }}</p>
															<p class="mar-no">Mata Pelajaran {{ $hasil['sekolah'] }}</p>
														</div>
													</a>
												</div>
												<!-- Tambahkan blok HTML untuk jumlah siswa dan guru -->
												{{-- <div class="panel panel-info panel-colorful media middle pad-all">
													<a href="{{ route('siswa.index') }}" class="text-white">
														<div class="media-left">
															<div class="pad-hor">
																<i class="fas fa-users icon-3x"></i>
															</div>
														</div>
														<div class="media-body">
															<p class="text-2x mar-no text-semibold">{{ $hasil['jumlahSiswa'] }}</p>
															<p class="mar-no">Siswa {{ $hasil['sekolah'] }}</p>
														</div>
													</a>
												</div> --}}
												<div class="panel panel-info panel-colorful media middle pad-all">
													<a href="{{ route('guruMapel.index') }}" class="text-white">
														<div class="media-left">
															<div class="pad-hor">
																<i class="fas fa-chalkboard-teacher icon-3x"></i>
															</div>
														</div>
														<div class="media-body">
															<p class="text-2x mar-no text-semibold">{{ $hasil['jumlahGuru'] }}</p>
															<p class="mar-no">Guru {{ $hasil['sekolah'] }}</p>
														</div>
													</a>
												</div>
											
										</div>						
										<!--===================================================-->
										<!-- End Timeline -->
									</div>
								@endforeach
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



  