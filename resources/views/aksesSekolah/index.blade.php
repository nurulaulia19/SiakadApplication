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
					                    <h3 class="panel-title">Data Akses Sekolah</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-6 table-toolbar-left">
													<a href="{{ route('aksessekolah.create') }}" class="btn btn-purple">
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
					                                    <th>Nama Sekolah</th>
                                                        <th>Admin</th>
					                                </tr>
					                            </thead>
					                            <tbody>
													
													@foreach ($dataAs as $item)
					                                <tr>
					                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
					                                    <td style="vertical-align: middle;">{{ $item->sekolah->nama_sekolah }}</td>
                                                        <td style="vertical-align: middle;">{{ $item->user->user_name}}</td>
														<td class="table-action" style="vertical-align: middle;">
                                                            <div style="display:flex; align-items:center">
                                                                <a style="margin-right: 10px;" href="{{ route( 'aksessekolah.edit', $item->id_as) }}" class="btn btn-sm btn-warning">Edit</a>
																<form method="GET" action="/admin/aksessekolah/destroy/{{ $item->id_as }}" id="delete-form-{{ $item->id_as }}">
																	@csrf
																	<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_as }})">Hapus</button>
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
									
					                            </tbody>
					                        </table>
					                    </div>
                                        {{ $dataAs->links('pagination::bootstrap-4') }}
					                    <hr class="new-section-xs">
					                </div>
					                <!--===================================================-->
					                <!--End Data Table-->
					
					            </div>
                                @if(session('success'))
                                    <div class="alert alert-info">
                                        {{ session('success') }}
                                    </div>
                                @endif
								@if(session('error'))
									<div class="alert alert-danger">
										{{ session('error') }}
									</div>
								@endif
					        </div>
					    </div>
					
					
					    
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