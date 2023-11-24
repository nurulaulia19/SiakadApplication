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
					                    <h3 class="panel-title">Data Kelas</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-7 table-toolbar-left">
													<a href="{{ route('kelas.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a>
					                            </div>
												<div class="col-sm-2">
                                                    <form action="{{ route('kelas.index') }}" method="GET">
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
                                                    <form action="{{ route('kelas.index') }}" method="GET">
                                                        <label for="search_nama_kelas">Cari Kelas:</label>
                                                        <div class="input-group" >
                                                            <input type="hidden" name="sekolah" value="{{ $filterSekolah }}">
                                                            <input type="text" name="search_nama_kelas" id="search_nama_kelas" class="form-control" placeholder="Nama Kelas..." value="{{ $searchNamaKelas }}">
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
					                                    <th>Nama Kelas</th>
					                                    <th>Nama Sekolah</th>
					                                </tr>
					                            </thead>
					                            <tbody>
													
													@foreach ($dataKelas as $item)
					                                <tr>
                                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
					                                    <td style="vertical-align: middle;">{{ $item->nama_kelas}}</td>
					                                    <td style="vertical-align: middle;">
                                                            @if ($item->sekolah)
                                                                {{ $item->sekolah->nama_sekolah }}
                                                            @else
                                                                Sekolah not assigned
                                                            @endif
                                                        </td>                                                       
														<td class="table-action" style="vertical-align: middle;">
                                                            <div style="display:flex; align-items:center">
                                                                <a style="margin-right: 10px;" href="{{ route( 'kelas.edit', $item->id_kelas) }}" class="btn btn-sm btn-warning">Edit</a>
                                                                <form method="GET" action="/admin/kelas/destroy/{{ $item->id_kelas }}" id="delete-form-{{ $item->id_kelas }}">
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_kelas }})">Hapus</button>
                                                                </form>
                                                            </div>													
														</td>
					                                </tr>
													@endforeach
													<script>
														function confirmDelete(itemId) {
															if (confirm('Are you sure you want to delete this item?')) {
																document.getElementById('delete-form-' + itemId).submit();
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
										{{ $dataKelas->appends(['sekolah' => $filterSekolah , 'search_nama_kelas' => $searchNamaKelas])->links('pagination::bootstrap-4') }}
                                        {{-- {{ $dataKelas->links('pagination::bootstrap-4') }} --}}
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
