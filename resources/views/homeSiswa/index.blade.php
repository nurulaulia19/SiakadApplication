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
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title">Dashboard Siswa</h3>
							</div>

							<div class="pad-all">
								<div class="row">
                                    <div class="col-lg-6">
                                        <!-- Info -->
                                        <!--===================================================-->
                                        <div class="info">
											<div class="panel panel-warning panel-colorful media middle pad-all">
												<a href="{{ route('jadwal.index') }}" class="text-white">
													<div class="media-left">
														<div class="pad-hor">
															<i class="fas fa-calendar icon-3x"></i>
														</div>
													</div>
													<div class="media-body">
														<p class="text-2x mar-no text-semibold">{{ isset($totalMataPelajaran) ? $totalMataPelajaran : 0 }}</p>
														<p class="mar-no">Mata Pelajaran</p>
													</div>
												</a>
											</div>
											<div class="panel panel-info panel-colorful media middle pad-all">
												<a href="{{ route('nilai.index') }}" class="text-white">
													<div class="media-left">
														<div class="pad-hor">
															<i class="fas fa-chart-bar icon-3x"></i>
														</div>
													</div>
													<div class="media-body">
														<p class="text-2x mar-no text-semibold">{{ isset($totalNilaiRata) ? $totalNilaiRata : 0 }}</p>
														<p class="mar-no">Nilai Rata-rata</p>
													</div>
												</a>
											</div>
                                        </div>
                                        <!--===================================================-->
                                        <!-- End Info -->
										<div class="col-md-5">
											<!-- Donut Chart -->
											<!---------------------------------->
											<div class="panel">
												<div class="panel-heading">
													<h3 class="panel-title">Chart Nilai</h3>
												</div>
												<div class="panel-body">
													<div id="demo-morris-donut" class="morris-donut" style="height: 250px;"></div>
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="col-lg-6" style="padding-left: 30px">
                                        <h4>Jadwal Pelajaran</h4>
                                        <!-- Timeline -->
                                        <!--===================================================-->
                                        <div class="timeline">
                                
                                            <!-- Timeline header -->
                                            <div class="timeline-header">
												@if (isset($datGp))
													@foreach ($gpData as $gp)
														<div class="timeline-header-title bg-purple">{{ $hariIni }}</div>
													@endforeach
												@else
												<div class="timeline-header-title bg-purple">{{ $hariIni }}</div>
												@endif
                                                {{-- <div class="timeline-header-title bg-purple">{{ $hariIni }}</div> --}}
                                            </div>
											@if (isset($gpData))
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
											@else
												<p></p>
											@endif
                                        </div>
                                        <!--===================================================-->
                                        <!-- End Timeline -->
                                
                                    </div>
                                </div>
							</div>
						</div>
					</div>					
					    <div class="row">
					        {{-- <div class="col-md-6">
					            <div class="panel panel-danger panel-colorful media middle pad-all">
									<a href="{{ route('jadwal.index') }}" class="text-white">
										<div class="media-left">
											<div class="pad-hor">
												<i class="fas fa-calendar icon-3x"></i>
											</div>
										</div>
										<div class="media-body">
											<p class="text-2x mar-no text-semibold">{{ isset($totalMataPelajaran) ? $totalMataPelajaran : 0 }}</p>
											<p class="mar-no">Jadwal</p>
										</div>
									</a>
					            </div>
					        </div>
					        <div class="col-md-6">
					            <div class="panel panel-warning panel-colorful media middle pad-all">
									<a href="{{ route('nilai.index') }}" class="text-white">
										<div class="media-left">
											<div class="pad-hor">
												<i class="fas fa-chart-bar icon-3x"></i>
											</div>
										</div>
										<div class="media-body">
											<p class="text-2x mar-no text-semibold">{{ isset($totalNilaiRata) ? $totalNilaiRata : 0 }}</p>
											<p class="mar-no">Nilai Rata-rata</p>
										</div>
									</a>
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

{{-- <script>
	document.addEventListener("DOMContentLoaded", function() {
		Morris.Donut({
			element: 'demo-morris-donut',
			data: [
			{label: 'Download Sales', value: 12},
			{label: 'In-Store Sales', value: 30},
			{label: 'Mail-Order Sales', value: 20}
			],
			colors: [
			'#ec407a',
			'#03a9f4',
			'#d8dfe2'
			],
			resize: true
		});
	});
</script> --}}

{{-- <script>
    var dataNilai = {!! json_encode($dataNilai) !!};

    document.addEventListener("DOMContentLoaded", function() {
        Morris.Donut({
            element: 'demo-morris-donut',
            data: dataNilai, // Menggunakan variabel dataNilai yang telah diinisialisasi
            colors: [
                '#ec407a',
                '#03a9f4',
                '#d8dfe2',
				'#A6CF98',
                // Tambahkan warna sesuai dengan kebutuhan Anda.
            ],
            resize: true
        });
    });
</script> --}}

{{-- <script>
    var dataNilai = {!! json_encode($dataNilai) !!};

    document.addEventListener("DOMContentLoaded", function() {
        Morris.Donut({
            element: 'demo-morris-donut',
            data: dataNilai, // Menggunakan variabel dataNilai yang telah diinisialisasi
            colors: [
                '#ec407a',
                '#03a9f4',
                '#d8dfe2',
                '#A6CF98',
                // Tambahkan warna sesuai dengan kebutuhan Anda.
            ],
            resize: true
        });
    });
</script> --}}
<script>
    var dataNilai = {!! json_encode($dataNilai) !!};

    document.addEventListener("DOMContentLoaded", function() {
        Morris.Donut({
            element: 'demo-morris-donut',
            data: dataNilai, // Menggunakan variabel dataNilai yang telah diinisialisasi
            colors: [
                '#ec407a',
                '#03a9f4',
                '#d8dfe2',
                '#A6CF98',
                // Tambahkan warna sesuai dengan kebutuhan Anda.
            ],
            resize: true
        });
    });
</script>
