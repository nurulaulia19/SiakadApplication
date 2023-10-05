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
					                    <h3 class="panel-title">User</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-6 table-toolbar-left">
													<a href="{{ route('user.create') }}" class="btn btn-purple">
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
					                                    <th>Username</th>
					                                    <th>Email</th>
					                                    <th>Gender</th>
														<th>Foto</th>
														<th>Role</th>
														<th>User Token</th>
                                                        <th>Action</th>
					                                </tr>
					                            </thead>
					                            <tbody>
													
													@foreach ($dataUser as $item)
					                                <tr>
														<td style="vertical-align: middle;">{{ $loop->iteration }}</td>
					                                    <td style="vertical-align: middle;">{{ $item->user_name }}</td>
					                                    <td style="vertical-align: middle;">{{ $item->user_email }}</td>
					                                    {{-- <td style="vertical-align: middle;">{{ $item->user_password }}</td> --}}
					                                    <td style="vertical-align: middle;">{{ $item->user_gender }}</td>
					                                    <td style="vertical-align: middle;">
                                                            <div style="display: flex; justify-content: center; align-items: flex-center; flex-direction: column;">
                                                                @if($item->user_photo)
                                                                <img style="width: 50px; height: 50px; margin-bottom: 5px;" src="{{ asset('storage/photos/'.basename($item->user_photo)) }}" alt="User Photo">
                                                            @else
                                                                No Photo
                                                            @endif
                                                            </div>
                                                            
                                                        </td>                                                        
														<td style="vertical-align: middle;">
                                                            @if ($item->role)
                                                                {{ $item->role->role_name }}
                                                            @else
                                                                Role not assigned
                                                            @endif 
                                                        </td>
														<td style="vertical-align: middle;">{{ $item->user_token }}</td>
														<td class="table-action" style="vertical-align: middle;">
                                                            <div style="display:flex; align-items:center">
                                                                <a style="margin-right: 10px;" href="{{ route( 'user.edit', $item->user_id) }}" class="btn btn-sm btn-warning">Edit</a>
															<form method="POST" action="" id="delete-form-{{ $item->user_id }}">
																@csrf
                												@method('DELETE')
																<a href="/admin/user/destroy/{{ $item->user_id }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->user_id }})">Hapus</a>				
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
                                        {{ $dataUser->links('pagination::bootstrap-4') }}
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
