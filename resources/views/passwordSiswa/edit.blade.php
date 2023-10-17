

{{-- bener --}}

@extends('layoutsSiswa.main')
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
						<h3>Welcome back to the Dashboard.</h3>
						<p>This is your experience to manage the Sistem Informasi Akademik Application</p>
					</div>
                </div>  
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
					    <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Edit Password</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                {{-- @foreach ( $dataMenu as $item)  --}}
                                    
                                
								<form method="POST" action="{{ route('passwordSiswa.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="current_password">Current Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" placeholder="Current Password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" value="{{ old('current_password') }}">
                                                @if ($errors->has('current_password'))
                                                    <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="new_password">New Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" placeholder="New Password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" value="{{ old('new_password') }}">
                                                @if ($errors->has('new_password'))
                                                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                                @endif
                                            </div>
                                        </div>       
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="new_password_confirmation">Confirm New Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" placeholder="Confirm New Password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('siswa.home') }}" class="btn btn-secondary">KEMBALI</a>
                                            <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                        </div>
                                    </div>
                                    @if(session('success'))
                                    <div class="alert alert-info">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                                {{-- @endforeach --}}
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

    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection








