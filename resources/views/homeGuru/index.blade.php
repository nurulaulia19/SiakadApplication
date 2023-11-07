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
						<div class="panel" style="display: flex; justify-content: center; align-items: center; flex-direction: column; text-align: center;">
							<div class="panel-heading">
								<h3 class="panel-title">Dashboard Guru</h3>
							</div>

							<div class="pad-all">
								{{-- <canvas id="transaksiChart" style="width: 1200px; height: 500px;"></canvas> --}}
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-warning panel-colorful media middle pad-all">
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
                                </div> --}}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- Timeline -->
                                        <!--===================================================-->
                                        <div class="info">
                                            <div class="panel panel-danger panel-colorful media middle pad-all" style="height:300px">
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
                                            <div class="panel panel-warning panel-colorful media middle pad-all" style="height:300px">
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
                                    <div class="col-lg-6">
                                        <h4>With icon</h4>
                                
                                        <!-- Timeline -->
                                        <!--===================================================-->
                                        <div class="timeline">
                                
                                            <!-- Timeline header -->
                                            <div class="timeline-header">
                                                <div class="timeline-header-title bg-purple">Now</div>
                                            </div>
                                            <div class="timeline-entry">
                                                <div class="timeline-stat">
                                                    <div class="timeline-icon bg-warning"><i class="demo-psi-speech-bubble-3 icon-lg"></i></div>
                                                    <div class="timeline-time">3 Hours ago</div>
                                                </div>
                                                <div class="timeline-label">
                                                    <p class="mar-no pad-btm"><a href="#" class="btn-link">Lisa D.</a> commented on <a href="#" class="text-semibold"><i>The Article.</i></a></p>
                                                    <blockquote class="bq-sm bq-open mar-no">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</blockquote>
                                                </div>
                                            </div>
                                            <div class="timeline-entry">
                                                <div class="timeline-stat">
                                                    <div class="timeline-icon bg-info"><i class="demo-psi-mail icon-lg"></i></div>
                                                    <div class="timeline-time">15:45</div>
                                                </div>
                                                <div class="timeline-label">
                                                    <p class="text-main text-semibold">Lorem ipsum dolor sit amet</p>
                                                    <span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.</span>
                                                </div>
                                            </div>
                                            <div class="timeline-entry">
                                                <div class="timeline-stat">
                                                    <div class="timeline-icon"><i class="demo-pli-like icon-2x"></i></div>
                                                    <div class="timeline-time">13:27</div>
                                                </div>
                                                <div class="timeline-label">
                                                    <img class="img-xs img-circle" src="img/profile-photos/5.png" alt="Profile picture">
                                                    <a href="#" class="btn-link">Michael Both</a> Like <a href="#" class="text-semibold"><i>The Article.</i></a>
                                                </div>
                                            </div>
                                            <div class="timeline-entry">
                                                <div class="timeline-stat">
                                                    <div class="timeline-icon"><i class="demo-psi-idea-2 icon-2x"></i></div>
                                                    <div class="timeline-time">11:27</div>
                                                </div>
                                                <div class="timeline-label">
                                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt.
                                                </div>
                                            </div>
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



  