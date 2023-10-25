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
                                    <h3 class="panel-title">Edit Kuisioner</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
								<form action="{{ route('kuisioner.update', $dataKuisioner->id_kuisioner) }}" method="POST">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_sekolah">Nama Sekolah</label>
                                            <div class="col-sm-9">
                                                <select name="id_sekolah" id="id_sekolah" class="form-control" onchange="handleSekolahChange(this.value)">
                                                    @foreach ($dataSekolah as $item)
                                                    <option value="{{ $item->id_sekolah }}" {{ $item->id_sekolah == $dataKuisioner->id_sekolah ? 'selected' : '' }}>
                                                        {{ $item->nama_sekolah }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('id_sekolah')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_kategori_kuisioner">Pilih Kategori Kuisioner</label>
                                            <div class="col-sm-9">
                                                <select name="id_kategori_kuisioner" id="id_kategori_kuisioner" class="form-control">
                                                    @foreach ($dataKategoriKuisioner as $item)
                                                    <option value="{{ $item->id_kategori_kuisioner }}" {{ $item->id_kategori_kuisioner == $dataKuisioner->id_kategori_kuisioner ? 'selected' : '' }}>
                                                        {{ $item->nama_kategori }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('id_kategori_kuisioner')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="pertanyaan">Pertanyaan</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Pertanyaan" name="pertanyaan" id="pertanyaan" class="form-control" value="{{ $dataKuisioner->pertanyaan }}">
                                                @error('pertanyaan')
                                                <span class="alert text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('kuisioner.index') }}" class="btn btn-secondary">KEMBALI</a>
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

            <script>
                function handleSekolahChange(sekolahID) {
                    // var  = $('#sekolah').val();  
                    let token = $("meta[name='csrf-token']").attr("content");  
                    if (sekolahID) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('kuisioner.getKategori') }}",
                            data: {
                                'sekolahID': sekolahID,
                                "_token": token
                            },
                            dataType: 'JSON',
                            success: function(res) {  
                                console.log(res);             
                                if (res) {
                                    $("#id_kategori_kuisioner").empty();
                                    $("#id_kategori_kuisioner").append('<option disabled selected>Pilih Kategori Kuisioner</option>');
                                    $.each(res, function(nama_kategori, id_kategori_kuisioner) {
                                        $("#id_kategori_kuisioner").append('<option value="'+id_kategori_kuisioner+'">'+nama_kategori+'</option>');
                                    });
                                } else {
                                    $("#id_kategori_kuisioner").empty();
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error: " + error); // Menampilkan pesan kesalahan ke konsol
                            }
                        });
        
                    } else {
                        $("#id_kategori_kuisioner").empty();
                    }      
            
                    
                }
            </script>
			

        <!-- SCROLL PAGE BUTTON -->
        <!--===================================================-->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
        <!--===================================================-->

    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection









