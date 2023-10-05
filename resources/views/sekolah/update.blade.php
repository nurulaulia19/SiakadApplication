

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
                                    <h3 class="panel-title">Edit User</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                {{-- @foreach ( $dataMenu as $item)  --}}
                                    
                                
								<form action="{{ route('sekolah.update', $dataSekolah->id_sekolah) }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nama_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Sekolah" name="nama_sekolah" id="nama_sekolah" class="form-control" value="{{ $dataSekolah->nama_sekolah }}">
                                                <span id="namasekolahError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nama_kepsek">Nama Kepala Sekolah</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Kepala Sekolah" name="nama_kepsek" id="nama_kepsek" class="form-control" value="{{ $dataSekolah->nama_kepsek }}">
                                                <span id="namakepsekError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="logo">Logo</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="logo" id="logo" class="form-control">
                                                @if ($dataSekolah->logo)
                                                    <a href="{{ asset($dataSekolah->logo) }}" target="_blank">
                                                        <img src="{{ asset('storage/photos/'.basename($dataSekolah->logo)) }}" width="100px" alt="Logo">
                                                    </a>
                                                @endif
                                                @if ($errors->has('logo'))
                                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                                @endif
                                            </div>                                                   
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="alamat">Alamat</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Alamat" name="alamat" id="alamat" class="form-control" value="{{ $dataSekolah->alamat }}">
                                                <span id="alamat" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('sekolah.index') }}" class="btn btn-secondary">KEMBALI</a>
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



<?php
$userPhotoUrl = $dataSekolah->logo; // Ganti $dataUser dengan variabel yang sesuai dengan model atau data pengguna Anda
?>

<!-- Menambahkan nilai awal pada input file saat mengedit -->
<script>
    var userPhotoUrl = "<?php echo $userPhotoUrl; ?>";
    if (userPhotoUrl) {
        var userPhotoInput = document.getElementById('logo');
        
        // Buat elemen option baru
        var option = document.createElement('option');
        option.value = userPhotoUrl;
        option.text = 'Existing Photo';
        option.selected = true; // Tandai sebagai opsi terpilih
        
        // Hapus opsi sebelumnya (opsional)
        while (userPhotoInput.firstChild) {
            userPhotoInput.firstChild.remove();
        }
        
        // Tambahkan opsi ke input file
        userPhotoInput.appendChild(option);
    }
</script>




