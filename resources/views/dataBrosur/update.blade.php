

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
                                    <h3 class="panel-title">Edit Brosur</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                {{-- @foreach ( $dataMenu as $item)  --}}
                                    
                                
								<form action="{{ route('brosur.update', $dataBrosur->id_brosur) }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="judul">Judul</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Judul" name="judul" id="judul" class="form-control" value="{{ $dataBrosur->judul }}">
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="file">File</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="file" id="file" class="form-control">
                                                @if ($dataBrosur->file)
                                                    <a href="{{ asset($dataBrosur->file) }}" target="_blank">
                                                        <img src="{{ asset('storage/photos/'.basename($dataBrosur->file)) }}" width="100px" alt="File">
                                                    </a>
                                                @endif
                                                @if ($errors->has('file'))
                                                        <span class="text-danger">{{ $errors->first('file') }}</span>
                                                @endif
                                            </div>                                                   
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="status">Status</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="status" id="status">
                                                    <option selected >Pilih Status</option>
                                                    <option value="ditampilkan" {{ $dataBrosur->status === 'ditampilkan' ? 'selected' : '' }}>Ditampilkan</option>
                                                    <option value="tidak" {{ $dataBrosur->status === 'tidak' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('brosur.index') }}" class="btn btn-secondary">KEMBALI</a>
                                            <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                        </div>
                                    </div>
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                                {{-- @endforeach --}}
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

    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection







