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
					                    <h3 class="panel-title">Menu</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-6 table-toolbar-left">
													<a href="{{ route('menu.create') }}" class="btn btn-purple">
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
					                                    <th>Nama Menu</th>
					                                    <th>Link Menu</th>
					                                    <th>Category Menu</th>
					                                    <th class="text-center">Sub Menu</th>
														<th class="text-center">Posisi Menu</th>
					                                </tr>
					                            </thead>
					                            <tbody>
													
													@foreach ($dataMenu as $item)
					                                <tr>
														<td>{{ $loop->iteration }}</td>
					                                    <td>{{ $item->menu_name }}</td>
					                                    <td>{{ $item->menu_link }}</td>
					                                    <td>{{ $item->menu_category }}</td>
					                                    <td class="text-center">{{ $item->submenu_name }}</td>
					                                    <td class="text-center">{{ $item->menu_position }}</td>
														<td class="table-action" style="justify-content:center; display:flex">
															<a style="margin-right: 10px" href="{{ route( 'menu.edit', $item->menu_id) }}" class="btn btn-sm btn-warning">Edit</a>
															<form method="POST" action="" id="delete-form-{{ $item->menu_id }}">
																@csrf
                												@method('DELETE')
																<a href="/admin/menu/destroy/{{ $item->menu_id }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->menu_id }})">Hapus</a>
																{{-- <a href="/menu/destroy/{{ $item->menu_id }}" class="btn btn-sm btn-danger">Hapus</a> --}}
																
															</form>
															
																										
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
									
					                            </tbody>
					                        </table>
					                    </div>
                                        {{ $dataMenu->links('pagination::bootstrap-4') }}
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
