

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
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Tambah User</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="/user/store" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_name">Username</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Username" name="user_name" id="user_name" class="form-control">
                                                <span id="usernameError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_email">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Email" name="user_email" id="user_email" class="form-control">
                                                <span id="emailError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_password">Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" placeholder="Password" name="user_password" id="user_password" class="form-control @error('user_password') is-invalid @enderror" value="{{ old('user_password') }}">
                                                    <span id="passwordError" class="error-message"></span>
                                                    @if ($errors->has('user_password'))
                                                        <span class="text-danger">Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.</span>
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_gender">Gender</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="user_gender" id="user_gender">
                                                    <option disabled selected>Pilih Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                                <span id="genderError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_photo">Foto</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="user_photo" id="user_photo" class="form-control">
                                                <span id="photoError" class="error-message"></span>
                                                    @if ($errors->has('user_photo'))
                                                        <span class="text-danger">{{ $errors->first('user_photo') }}</span>
                                                    @endif

                                                {{-- <input type="file" name="user_photo" id="user_photo" class="form-control">
                                                <span id="photoError" class="error-message"></span> --}}
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="role_id">Role</label>
                                            <div class="col-sm-9">
                                                <select name="role_id" id="role_id" class="form-control">
                                                    <option disabled selected>Pilih Role</option>
                                                    @foreach ($dataRole as $item)
                                                        <option value="{{ $item->role_id }}">{{ $item->role_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="roleError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="user_token">User Token</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="User Token" name="user_token" id="user_token" class="form-control">
                                                <span id="tokenError" class="error-message"></span>
                                                @if ($errors->has('user_token'))
                                                        <span class="text-danger">{{ $errors->first('user_token') }}</span>
                                                 @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <a href="{{ route('user.index') }}" class="btn btn-secondary">KEMBALI</a>
                                        <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                    </div>
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                        
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



