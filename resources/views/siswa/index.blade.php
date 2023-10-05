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
					                    <h3 class="panel-title">Data Siswa</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-6 table-toolbar-left">
													<a href="{{ route('siswa.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a>
													
					                            </div>
                                                <div class="col-sm-3">
                                                    <form action="{{ route('siswa.index') }}" method="GET">
                                                        <div class="form-group">
                                                            <label for="tahun_filter">Filter Tahun Masuk</label>
                                                            <select name="tahun_filter" id="tahun_filter" class="form-control">
                                                                <option value="">Tampilkan Semua</option>
                                                                @foreach ($tahunList as $tahun)
                                                                    <option value="{{ $tahun }}" {{ $tahun == $selectedYear ? 'selected' : '' }}>
                                                                        {{ $tahun }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="submit" class="btn btn-sm btn-primary mt-1">Filter</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm-3">
                                                    <form action="{{ route('siswa.index') }}" method="GET">
                                                        <div class="input-group">
                                                            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIS dan Nama Siswa..." value="{{ request('search') }}">
                                                            <input type="hidden" name="tahun_filter" value="{{ $selectedYear }}">
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
                                                        <th>NIS</th>
					                                    <th>Nama Siswa</th>
					                                    <th>Tempat Lahir</th>
					                                    <th>Tanggal Lahir</th>
                                                        <th>Jenis Kelamin</th>
                                                        <th>Tahun Masuk</th>
                                                        <th>Foto</th>
					                                </tr>
					                            </thead>
					                            <tbody>
													
													@foreach ($dataSiswaList as $item)
					                                <tr>
                                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                        <td style="vertical-align: middle;">
                                                            @if ($item->sekolah)
                                                                {{ $item->sekolah->nama_sekolah }}
                                                            @else
                                                                Nama Sekolah not assigned
                                                            @endif
                                                        </td> 
					                                    <td style="vertical-align: middle;">{{ $item->nis_siswa}}</td>
					                                    <td style="vertical-align: middle;">{{ $item->nama_siswa }}</td>
					                                    <td style="vertical-align: middle;">{{ $item->tempat_lahir }}</td>  
                                                        <td style="vertical-align: middle;">{{ $item->tanggal_lahir }}</td> 
                                                        <td style="vertical-align: middle;">{{ $item->jenis_kelamin }}</td>  
                                                        <td style="vertical-align: middle;">{{ $item->tahun_masuk }}</td>  
                                                        <td style="vertical-align: middle;">
                                                            <div style="display: flex; justify-content: center; align-items: flex-center; flex-direction: column;">
                                                                @if($item->foto_siswa)
                                                                <img style="width: 50px; height: 50px; margin-bottom: 5px;" src="{{ asset('storage/photos/'.basename($item->foto_siswa)) }}" alt="Foto Siswa">
                                                            @else
                                                                No Photo
                                                            @endif
                                                            </div>
                                                            
                                                        </td>   
                                                        {{-- <td style="vertical-align: middle;">{{ $item->foto_siswa }}</td>                                                  --}}
														<td class="table-action" style="vertical-align: middle;">
                                                            <div style="display:flex; align-items:center">
                                                                <a style="margin-right: 10px;" href="{{ route( 'siswa.edit', $item->id_siswa) }}" class="btn btn-sm btn-warning">Edit</a>
															<form method="POST" action="" id="delete-form-{{ $item->id_siswa }}">
																@csrf
                												@method('DELETE')
																<a href="/admin/siswa/destroy/{{ $item->id_siswa }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_siswa }})">Hapus</a>				
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
                                        {{ $dataSiswaList->appends(['search' => $searchTerm, 'tahun_filter' => $selectedYear,])->links('pagination::bootstrap-4') }}
                                        
                                        {{-- {{ $dataSiswaList->links('pagination::bootstrap-4') }} --}}
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
