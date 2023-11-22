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
					                    <h3 class="panel-title">Data Brosur</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-6 table-toolbar-left">
													<a href="{{ route('brosur.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a>
					                            </div>
					                        </div>
					                    </div>
					                    <div class="table-responsive">
					                        <table class="table table-striped">
					                            <thead>
					                                <tr>
                                                        <th>No</th>
                                                        <th>Judul</th>
                                                        <th>File</th>
                                                        <th>Status</th>
					                                </tr>
					                            </thead>
					                            <tbody>
													
													@foreach ($dataBrosur as $item)
					                                <tr>
                                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                        <td style="vertical-align: middle;">{{ $item->judul }}</td>    
                                                        <td style="vertical-align: middle;">
                                                            <div style="display: flex; justify-content: center; align-items: flex-center; flex-direction: column;">
                                                                @if($item->file)
                                                                <img style="width: 50px; height: 50px; margin-bottom: 5px;" src="{{ asset('storage/photos/'.basename($item->file)) }}" alt="File">
                                                                @else
                                                                    No Photo
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">{{ $item->status }}</td>                                                          
														<td class="table-action" style="vertical-align: middle;">
                                                            <div style="display:flex; align-items:center">
                                                                <a style="margin-right: 10px;" href="{{ route( 'brosur.edit', $item->id_brosur) }}" class="btn btn-sm btn-warning">Edit</a>
                                                                <form method="GET" action="/admin/brosur/destroy/{{ $item->id_brosur }}" id="delete-form-{{ $item->id_brosur }}">
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_brosur }})">Hapus</button>
                                                                </form>
                                                            </div>											
														</td>
					                                </tr>
													@endforeach
													<script>
                                                        function confirmDelete(itemId) {
                                                            var result = confirm("Apakah Anda yakin ingin menghapus item ini?");
                                                            if (result) {
                                                                // Jika pengguna menyetujui, kirim formulir penghapusan
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
                                        {{-- {{ $dataSlider->appends(['sekolah' => $filterSekolah , 'search_nama_pelajaran' => $searchNamaPelajaran])->links('pagination::bootstrap-4') }} --}}
                                        {{ $dataBrosur->links('pagination::bootstrap-4') }}
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
