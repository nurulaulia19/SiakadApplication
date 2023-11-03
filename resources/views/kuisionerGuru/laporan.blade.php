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
                                        <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-7 table-toolbar-left">
													{{-- <a href="{{ route('guruMapel.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a> --}}
					                            </div>
                                                <div class="col-sm-2">
                                                    <form method="GET" action="{{ route('absensiGuru.index') }}">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="sekolah">Filter Sekolah</label>
                                                                </div>
                                                                <div class="col-5">
                                                                    <select name="sekolah" class="form-control">
                                                                        <option value="">Pilih Sekolah</option>
                                                                        @foreach($listSekolah as $id_sekolah => $nama_sekolah)
                                                                            <option value="{{ $id_sekolah }}" {{ $sekolahFilter == $id_sekolah ? 'selected' : '' }}>
                                                                                {{ $nama_sekolah }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select> 
                                                                </div>
                                                                <div class="col-2">
                                                                    <button type="submit" class="btn btn-sm btn-primary mt-1" style="margin-left: 5px">Filter Sekolah</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm-2" >
                                                    <form method="GET" action="{{ route('absensiGuru.index') }}">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input type="hidden" name="sekolah" value="{{ $sekolahFilter }}">
                                                            <label for="tahun_ajaran">Filter Tahun Ajaran</label>
                                                            </div>
                                                            <div class="col-7">
                                                                <select name="tahun_ajaran" class="form-control">
                                                                    <option value="">Pilih Tahun Ajaran</option>
                                                                    @foreach($listTahunAjaran as $tahunAjaran)
                                                                        <option value="{{ $tahunAjaran }}" {{ $tahunFilter == $tahunAjaran ? 'selected' : '' }}>
                                                                            {{ $tahunAjaran }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-2">
                                                                <button type="submit" class="btn btn-sm btn-primary mt-1">Filter Tahun Ajaran</button>
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
					                                    <th>Nama Sekolah</th>
                                                        <th>Nama Kelas</th>
                                                        <th>Tahun Ajaran</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>Nama Guru</th>
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
                                                        <td style="vertical-align: middle;">{{ $item->tahun_ajaran }}</td>    
                                                        <td style="vertical-align: middle;">{{ $item->mapel->nama_pelajaran}}</td>   
                                                        <td style="vertical-align: middle;">
                                                            @if ($item->user)
                                                                {{ $item->user->user_name }}
                                                            @else
                                                                Nama Guru not assigned
                                                            @endif
                                                        </td> 
                                                        <td class="table-action" style="vertical-align: middle;">
                                                            <div style="display: flex; align-items: center;">
                                                                @php
                                                                    $jawabanExist = DB::table('data_jawaban_kuisioner')
                                                                        ->where('id_gp', $item->id_gp)
                                                                        ->exists();
                                                                @endphp
                                                                @if ($jawabanExist)
                                                                    <a style="margin-right: 10px;" href="{{ route('laporanKuisionerGuru.detail', ['id_gp' => $item->id_gp]) }}" class="btn btn-sm btn-warning">Detail</a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        
					                                </tr>
													@endforeach
													<script>
														function confirmDelete(menuId) {
															if (confirm('Are you sure you want to delete this item?')) {
																document.getElementById('delete-form-' + menuId).submit();
															}
														}
													</script>
                                                     @if(session('success'))
                                                     <div class="alert alert-info">
                                                         {{ session('success') }}
                                                     </div>
                                                     @endif
					                            </tbody>
					                        </table>
					                    </div>
                                        {{-- {{ $dataGp->links('pagination::bootstrap-4') }} --}}
                                        {{ $dataGp->appends(['sekolah' => $sekolahFilter, 'tahun_ajaran' => $tahunFilter])->links('pagination::bootstrap-4') }}
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
