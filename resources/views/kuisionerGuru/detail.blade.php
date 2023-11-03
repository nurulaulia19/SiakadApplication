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
					                    <h3 class="panel-title">Laporan Kuisioner</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
                                        <table class="table" style="width: 20%; max-width: 20%;">
                                            <tbody>
                                                <!-- Menampilkan informasi mata pelajaran -->
                                                <tr>
                                                    <th style="width: 50%; border: none;">Mata Pelajaran<span style="float: right;">:</span></th>
                                                    <th style="width: 50%; border: none;">
                                                        @foreach ($dataGp as $guruMapel)
                                                            @if ($guruMapel->id_gp == $id_gp)
                                                                {{ $guruMapel->mapel->nama_pelajaran }}
                                                            @endif
                                                        @endforeach
                                                    </th>
                                                </tr>
                                                
                                                <!-- Menampilkan informasi guru -->
                                                <tr>
                                                    <th style="width: 50%; border: none;">Nama Guru<span style="float: right;">:</span></th>
                                                    <th style="width: 50%; border: none;">
                                                        @foreach ($dataGp as $guruMapel)
                                                            @if ($guruMapel->id_gp == $id_gp)
                                                                {{ $guruMapel->user->user_name }}
                                                            @endif
                                                        @endforeach
                                                    </th>
                                            </tbody>
                                        </table>
					                    <div class="table-responsive">
					                        <table class="table table-striped">
					                            <thead>
					                                <tr>
                                                        <th>No</th>
                                                        <th>Pertanyaan</th>
                                                        <th style="text-align: center;">Sangat Baik</th>
                                                        <th style="text-align: center;">Baik</th>
                                                        <th style="text-align: center;">Cukup Baik</th>
                                                        <th style="text-align: center;">Kurang Baik</th>
					                                </tr>
					                            </thead>
                                                    @php
                                                        $globalIteration = 1;
                                                    @endphp                                            
                                                    @foreach ($groupedQuestions as $kategori => $questions)
                                                        <tr>
                                                            <td style="background-color:#367E18"></td>
                                                            <td style=" background-color:#367E18; color:white">
                                                                {{ $kategori }}
                                                            </td>
                                                            <td style="background-color:#367E18"></td>
                                                            <td style="background-color:#367E18"></td>
                                                            <td style="background-color:#367E18"></td>
                                                            <td style="background-color:#367E18"></td>
                                                        </tr>
                                                        @foreach ($questions as $question)
                                                            <tr>
                                                                <td>{{ $globalIteration }}</td>
                                                                <td>
                                                                    {{ $question->pertanyaan }}
                                                                    <input name="id_kuisioner" type="hidden" value="{{ $question->id_kuisioner }}" readonly>
                                                                </td>
                                                                @php
                                                                    $globalIteration++;
                                                                @endphp
                                                                  <td style="text-align: center;">{{ $perhitungan[$question->id_kuisioner]['sangatbaik'] }}</td>
                                                                  <td style="text-align: center;">{{ $perhitungan[$question->id_kuisioner]['baik'] }}</td>
                                                                  <td style="text-align: center;">{{ $perhitungan[$question->id_kuisioner]['cukupbaik'] }}</td>
                                                                  <td style="text-align: center;">{{ $perhitungan[$question->id_kuisioner]['kurangbaik'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                            </table>
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <span>{{ $error }}</span>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif                                        
					                    </div>
                                        <div class="text-right mt-3">
                                            <a href="{{ route('laporanKuisionerGuru.laporan') }}" class="btn btn-primary">KEMBALI</a>
                                            {{-- <button type="submit" class="btn btn-primary">SIMPAN</button> --}}
                                        
					                    
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
