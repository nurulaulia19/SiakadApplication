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
                                        <table class="table" style="width: 21%; max-width: 21%;">
                                            <tbody>
                                                <!-- Menampilkan informasi mata pelajaran -->
                                                <tr>
                                                    <th style="width: 50%; border: none;">Mata Pelajaran<span style="float: right;">:</span></th>
                                                    <th style="width: 50%; border: none;">
                                                        @foreach ($guruPelajaran as $guruMapel)
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
                                                        @foreach ($guruPelajaran as $guruMapel)
                                                            @if ($guruMapel->id_gp == $id_gp)
                                                                {{ $guruMapel->user->user_name }}
                                                            @endif
                                                         @endforeach
                                                    </th>
                                            </tbody>
                                        </table>
                                        <form action="{{ route('jawabanKuisioner.store') }}" method="POST">
                                        @csrf  
					                    <div class="table-responsive">
					                        <table class="table table-striped">
					                            <thead>
					                                <tr>
                                                        <th>No</th>
                                                        <th>Pertanyaan</th>
                                                        <th>Jawaban</th>
					                                </tr>
					                            </thead>
                                                {{-- <tr> --}} 
                                                    <input name="id_gp" type="hidden" value="{{$id_gp}}" readonly>
                                                    <input name="nis_siswa" type="hidden" value="{{$siswa->nis_siswa}}" readonly>  
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
                                                                @foreach ($jawaban[$question->id_kuisioner] as $response)
                                                                    <td> {{ $response->jawaban }}</td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                            </table>
					                    </div>
                                        <div class="text-right mt-3">
                                            <a href="{{ route('kuisionerSiswa.index') }}" class="btn btn-primary">KEMBALI</a>
                                            {{-- <button type="submit" class="btn btn-primary">SIMPAN</button> --}}
                                        </div>
                                        </form>
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
