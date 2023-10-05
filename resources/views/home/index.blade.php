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
								<h3 class="panel-title">Laporan Transaksi</h3>
							</div>

							<div class="pad-all">
								<canvas id="transaksiChart" style="width: 1200px; height: 500px;"></canvas>
							</div>
						</div>
					</div>					
					    <div class="row">
					        <div class="col-md-3">
					            <div class="panel panel-warning panel-colorful media middle pad-all">
					                <div class="media-left">
					                    <div class="pad-hor">
											<i class="fas fa-money-bill icon-3x"></i>
					                    </div>
					                </div>
					                {{-- <div class="media-body">
										<p class="text-2x mar-no text-semibold">{{ $jumlahTransaksi }}</p>
										<p class="mar-no">Transaksi</p>
									</div> --}}
					            </div>
					        </div>
					        {{-- <div class="col-md-3">
					            <div class="panel panel-info panel-colorful media middle pad-all">
					                <div class="media-left">
					                    <div class="pad-hor">
					                        <i class="fas fa-shopping-bag icon-3x"></i>
					                    </div>
					                </div>
					                <div class="media-body">
					                    <p class="text-2x mar-no text-semibold">{{ $jumlahJasa}}</p>
					                    <p class="mar-no">Jasa</p>
					                </div>
					            </div>
					        </div>
					        <div class="col-md-3">
					            <div class="panel panel-mint panel-colorful media middle pad-all">
					                <div class="media-left">
					                    <div class="pad-hor">
					                        <i class="fas fa-tag icon-3x"></i>
					                    </div>
					                </div>
					                <div class="media-body">
					                    <p class="text-2x mar-no text-semibold">{{ $jumlahKategori }}</p>
					                    <p class="mar-no">Kategori</p>
					                </div>
					            </div>
					        </div>
							<div class="col-md-3">
					            <div class="panel panel-danger panel-colorful media middle pad-all">
					                <div class="media-left">
					                    <div class="pad-hor">
					                        <i class="fas fa-calculator icon-3x"></i>
					                    </div>
					                </div>
					                <div class="media-body">
					                    <p class="text-2x mar-no text-semibold">{{ number_format($totalHargaProduk, 2, ',', '.') }}</p>
					                    <p class="mar-no">Jumlah Penjualan</p>
					                </div>
					            </div>
					        </div> --}}
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

	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
	<script>
	var ctx = document.getElementById('transaksiChart').getContext('2d');
	var datasets = [];

	@foreach ($dataPerCabang as $cabangId => $totals)
		@if (isset($namaCabang[$cabangId]))
			var namaCabang = {!! json_encode($namaCabang[$cabangId]) !!};
		@else
			var namaCabang = ''; // Atau isikan dengan nilai default jika tidak ada nama cabang
		@endif

		datasets.push({
			label: 'Cabang ' + namaCabang,
			data: {!! json_encode($totals) !!},
			borderColor: getRandomColor(),
			borderWidth: 1,
			fill: false
		});

		@endforeach
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: {!! json_encode($labels) !!},
			datasets: datasets
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});

	function getRandomColor() {
		var letters = '0123456789ABCDEF';
		var color = '#';
		for (var i = 0; i < 6; i++) {
			color += letters[Math.floor(Math.random() * 16)];
		}
		return color;
	}

	</script> --}}


@endsection




  <!--jQuery [ REQUIRED ]-->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  {{-- <script src="js/jquery.min.js"></script> --}}



  