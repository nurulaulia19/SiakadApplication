@extends('layouts.main')
@section('content')
    <div id="container" class="cls-container">
        
		<!-- BACKGROUND IMAGE -->
		<!--===================================================-->
		<div id="bg-overlay"></div>
		
		
		<!-- LOGIN FORM -->
		<!--===================================================-->
		<div class="cls-content">
		    <div class="cls-content-sm panel">
		        <div class="panel-body">
		            <div class="mar-ver pad-btm">
		                <h1 class="h3">Account Login</h1>
		                <p>Sign In to your account</p>
		            </div>
		            <form method="POST" action="{{ route('siswa.submit') }}">
						@csrf
		                <div class="form-group">

		                    <input id="nis_siswa" type="text" class="form-control @error('nis_siswa') is-invalid @enderror" name="nis_siswa" value="{{ old('nis_siswa') }}" required autocomplete="nis_siswa" autofocus placeholder="nis siswa">
                                    @error('nis_siswa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
		                </div>
		                <div class="form-group">
		                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" placeholder="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
		                </div>
		                {{-- <div class="checkbox pad-btm text-left">
		                    <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox">
		                    <label for="demo-form-checkbox">Remember me</label>
		                </div> --}}
		                <button class="btn btn-lg btn-block" style="background-color:#367E18; color:white" type="submit">Sign In</button>
		            </form>
		        </div>
		
		        <div class="pad-all">
		            {{-- <a href="pages-password-reminder.html" class="btn-link mar-rgt">Forgot password ?</a> --}}
		            <a href="{{ route('register') }}" class="btn-link mar-lft">Create a new account</a>
		
		            <div class="media pad-top bord-top">
		                {{-- <div class="pull-right">
		                    <a href="#" class="pad-rgt"><i class="demo-psi-facebook icon-lg text-primary"></i></a>
		                    <a href="#" class="pad-rgt"><i class="demo-psi-twitter icon-lg text-info"></i></a>
		                    <a href="#" class="pad-rgt"><i class="demo-psi-google-plus icon-lg text-danger"></i></a>
		                </div>
		                <div class="media-body text-left text-bold text-main">
		                    Login with
		                </div> --}}
		            </div>
		        </div>
		    </div>
		</div>
@endsection








