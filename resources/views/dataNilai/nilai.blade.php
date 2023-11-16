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
					                    <h3 class="panel-title">Data Nilai</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-7 table-toolbar-left">
													{{-- <a href="{{ route('dataNilai.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a> --}}
					                            </div>
                                                <div class="col-sm-2">
                                                    <form action="{{ route('dataNilai.nilai') }}" method="GET">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="sekolah">Filter Sekolah</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <select name="sekolah" id="sekolah" class="form-control">
																		<option value="">Tampilkan semua</option>
																		@foreach($sekolahOptions as $sekolahId => $sekolahNama)
																			<option value="{{ $sekolahId }}" {{ $filterSekolah == $sekolahId ? 'selected' : '' }}>{{ $sekolahNama }}</option>
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
                                                    <form action="{{ route('dataNilai.nilai') }}" method="GET">
                                                        <label for="search_nama_pelajaran">Cari Nama Pelajaran:</label>
                                                        <div class="input-group" >
                                                            <input type="hidden" name="sekolah" value="{{ $filterSekolah }}">
                                                            <input type="text" name="search_nama_pelajaran" id="search_nama_pelajaran" class="form-control" placeholder="Nama Pelajaran..." value="{{ $searchNamaPelajaran }}">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-primary" type="submit">Cari</button>
                                                            </span>
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
                                                            <div style="display:flex; align-items:center">
                                                                {{-- <a href="{{ route( 'guruMapel.edit', $item->id_gp) }}" class="btn btn-danger" style="margin-right: 10px;">
                                                                    <i class="fas fa-heart" style="font-size: 18px;"></i>
                                                                </a> --}}
                                                                 {{-- <a style="margin-right: 10px;" href="{{ route( 'dataNilai.detail', $item->id_gp) }}" class="btn btn-sm btn-warning">Detail</a> --}}
                                                                 {{-- <input type="hidden" name="id_kn" value="{{ $id_kn }}">
                                                                 <a style="margin-right: 10px;" href="{{ route('dataNilai.detail', ['id_gp' => $item->id_gp]) }}" class="btn btn-sm btn-warning">Detail</a> --}}
                                                                 <a style="margin-right: 10px;" href="{{ route('dataNilai.detail', ['id_gp' => $item->id_gp, 'id_kn' => $id_kn]) }}" class="btn btn-sm btn-warning">Detail</a>
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
                                        {{ $dataGp->appends(['sekolah' => $filterSekolah , 'search_nama_pelajaran' => $searchNamaPelajaran])->links('pagination::bootstrap-4') }}
                                        {{-- {{ $dataGp->links('pagination::bootstrap-4') }} --}}
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
