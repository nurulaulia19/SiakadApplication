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
					                    <h3 class="panel-title">Data Kenaikan Kelas</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-6 table-toolbar-left">
													<a href="{{ route('kenaikanKelas.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a>
					                            </div>
                                                <div class="col-sm-2">
                                                    <form action="{{ route('kenaikanKelas.index') }}" method="GET">
                                                        <div class="form-group">
                                                            <label for="sekolah_filter">Filter Sekolah</label>
                                                            <select name="sekolah_filter" id="sekolah_filter" class="form-control">
                                                                <option value="">Tampilkan Semua</option>
                                                                @foreach ($dataSekolah as $sekolah)
                                                                    <option value="{{ $sekolah->id_sekolah }}" {{ $sekolahFilter == $sekolah->id_sekolah ? 'selected' : '' }}>
                                                                        {{ $sekolah->nama_sekolah }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="submit" class="btn btn-sm btn-primary mt-1">Filter</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm-2">
                                                    <form action="{{ route('kenaikanKelas.index') }}" method="GET">
                                                        <div class="form-group">
                                                            <label for="tahun_ajaran_filter">Filter Tahun Ajaran</label>
                                                            <input type="hidden" name="sekolah_filter" value="{{ $sekolahFilter }}">
                                                            <select name="tahun_ajaran_filter" id="tahun_ajaran_filter" class="form-control">
                                                                <option value="">Tampilkan Semua</option>
                                                                @foreach ($tahunAjarans as $tahunAjaran)
                                                                    <option value="{{ $tahunAjaran }}" {{ $tahunAjaranFilter == $tahunAjaran ? 'selected' : '' }}>
                                                                        {{ $tahunAjaran }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="submit" class="btn btn-sm btn-primary mt-1">Filter</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm-2">
                                                    <form action="{{ route('kenaikanKelas.index') }}" method="GET">
                                                        <label for="tahun_ajaran_filter">Cari NIS siswa</label>
                                                        <div class="input-group" >
                                                            <input type="hidden" name="sekolah_filter" value="{{ $sekolahFilter }}">
                                                            <input type="hidden" name="tahun_ajaran_filter" value="{{ $tahunAjaranFilter }}">
                                                            <input type="text" name="search" class="form-control" placeholder="Cari" value="{{ request('search') }}">
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
                                                        <th>NIS</th>
                                                        {{-- <th>Nama Siswa</th> --}}
					                                </tr>
					                            </thead>
					                            <tbody>
                                                    @php $iteration = 0; @endphp
													{{-- @foreach ($groupedData as $id_sekolah => $kelasData)
                                                        @foreach ($kelasData as $id_kelas => $tahunData)
                                                            @foreach ($tahunData as $tahun_ajaran => $group)
                                                                
                                                                @php $firstItem = $group[0]; @endphp
                                                                <tr>
                                                                    <td style="vertical-align: middle;">{{ ++$iteration }}</td>
                                                                    <td style="vertical-align: middle;">
                                                                        @if ($firstItem->sekolah)
                                                                            {{ $firstItem->sekolah->nama_sekolah }}
                                                                        @else
                                                                            Sekolah not assigned
                                                                        @endif
                                                                    </td>
                                                                    <td style="vertical-align: middle;">
                                                                        @if ($firstItem->kelas)
                                                                            {{ $firstItem->kelas->nama_kelas }}
                                                                        @else
                                                                            Kelas not assigned
                                                                        @endif
                                                                    </td>
                                                                    <td style="vertical-align: middle;">{{ $tahun_ajaran }}</td>
                                                                    <td>
                                                                        @foreach ($group as $item)
                                                                            {{ $item->nis_siswa }}
                                                                            @if (!$loop->last)
                                                                                ,
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="table-action" style="vertical-align: middle;">
                                                                        <div style="display:flex; align-items:center">
                                                                            <a style="margin-right: 10px;" href="{{ route('kenaikanKelas.edit', $firstItem->id_kk) }}" class="btn btn-sm btn-warning">Edit</a>
                                                                            <form method="POST" action="" id="delete-form-{{ $firstItem->id_kk }}">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <a href="/admin/kenaikanKelas/destroy/{{ $firstItem->id_kk }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $firstItem->id_kk }})">Hapus</a>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach --}}

													@foreach ($dataKk as $item)
					                                <tr>
                                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                        <td style="vertical-align: middle;">
                                                            @if ($item->sekolah)
                                                                {{ $item->sekolah->nama_sekolah }}
                                                            @else
                                                                Sekolah not assigned
                                                            @endif
                                                        </td>  
                                                        <td style="vertical-align: middle;">
                                                            @if ($item->kelas)
                                                                {{ $item->kelas->nama_kelas }}
                                                            @else
                                                                Kelas not assigned
                                                            @endif
                                                        </td>       
                                                        <td style="vertical-align: middle;">{{ $item->tahun_ajaran }}</td>     
                                                        <td style="vertical-align: middle;">{{ $item->nis_siswa }}</td>
														<td class="table-action" style="vertical-align: middle;">
                                                            <div style="display:flex; align-items:center">
                                                                <a style="margin-right: 10px;" href="{{ route( 'kenaikanKelas.edit', $item->id_kk) }}" class="btn btn-sm btn-warning">Edit</a>
															<form method="POST" action="" id="delete-form-{{ $item->id_kk }}">
																@csrf
                												@method('DELETE')
																<a href="/admin/kenaikanKelas/destroy/{{ $item->id_kk }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_kk }})">Hapus</a>				
															</form>	
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
                                        {{ $dataKk->appends(['search' => $search, 'sekolah_filter' => $sekolahFilter, 'tahun_ajaran_filter' => $tahunAjaranFilter])->links('pagination::bootstrap-4') }}
                                
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
