{{-- bener --}}

@extends('layoutsAdmin.main')
@section('content')
    <style>
        /* Gaya untuk tab aktif */
        .nav-tabs > li.active > a,
        .nav-tabs > li.active > a:hover,
        .nav-tabs > li.active > a:focus {
            background-color: #007BFF; /* Warna latar belakang tab aktif */
            color: #FFFFFF; /* Warna teks tab aktif */
        }
    </style>
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
                              <h3 class="panel-title">Detail Nilai</h3>
                          </div>
          
                          <!--Data Table-->
                          <!--===================================================-->
                          <div class="panel-body">
                                        <div class="fixed-fluid">
                                            <div class="fixed-md-200 pull-sm-left fixed-right-border">
                                                <div style="display: flex; justify-content:center">
                                                    {{-- <div class="profile-card">
                                                        <h4 class="profile-name">
                                                            @if ($dataGp->sekolah)
                                                            {{ $dataGp->sekolah->nama_sekolah }}
                                                            @else
                                                            Nama Sekolah not assigned
                                                            @endif
                                                        </h4>
                                                        <div class="profile-info">
                                                            @if ($dataGp->kelas)
                                                            <p class="profile-detail">Kelas: {{ $dataGp->kelas->nama_kelas }}</p>
                                                            @else
                                                            <p class="profile-detail">Nama kelas not assigned</p>
                                                            @endif
                                            
                                                            <p class="profile-detail">Tahun Ajaran: {{ $dataGp->tahun_ajaran }}</p>
                                                            <p class="profile-detail">Mata Pelajaran: {{ $dataGp->mapel->nama_pelajaran }}</p>
                                                            @if ($dataGp->user)
                                                            <p class="profile-detail">Guru: {{ $dataGp->user->user_name }}</p>
                                                            @else
                                                            <p class="profile-detail">Nama Guru not assigned</p>
                                                            @endif
                                                        </div>
                                                    </div> --}}
                                                    <style>
                                                        .profile-grid {
                                                            display: grid;
                                                            gap: 10px;
                                                            font-size: 14px;
                                                        }
                                                    
                                                        .profile-label {
                                                            font-weight: bold;
                                                        }
                                                    </style>
                                                    
                                                    <div class="profile-card">
                                                        <div class="profile-grid">
                                                            <div class="profile-label">Sekolah:</div>
                                                            <div class="profile-value">
                                                                @if ($dataGp->sekolah)
                                                                    {{ $dataGp->sekolah->nama_sekolah }}
                                                                @else
                                                                    Nama Sekolah not assigned
                                                                @endif
                                                            </div>
                                                            
                                                            <div class="profile-label">Kelas:</div>
                                                            <div class="profile-value">
                                                                @if ($dataGp->kelas)
                                                                    {{ $dataGp->kelas->nama_kelas }}
                                                                @else
                                                                    Nama kelas not assigned
                                                                @endif
                                                            </div>
                                                            
                                                            <div class="profile-label">Tahun Ajaran:</div>
                                                            <div class="profile-value">{{ $dataGp->tahun_ajaran }}</div>
                                                            
                                                            <div class="profile-label">Mata Pelajaran:</div>
                                                            <div class="profile-value">{{ $dataGp->mapel->nama_pelajaran }}</div>
                                                            
                                                            <div class="profile-label">Guru:</div>
                                                            <div class="profile-value">
                                                                @if ($dataGp->user)
                                                                    {{ $dataGp->user->user_name }}
                                                                @else
                                                                    Nama Guru not assigned
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr> <!-- Garis pemisah antar elemen -->
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="fluid">
                                                
                                                <div class="tab-base">
                                                    
                                                    {{-- bener --}}
                                                    <div class="container">
                                                        
                                                        <ul class="nav nav-tabs" id="kategori-tabs">
                                                            @foreach ($dataKn as $key => $kategori)
                                                                {{-- @foreach ($dataGp as $item) --}}
                                                                    @if ($dataGp->sekolah && $dataGp->sekolah->id_sekolah == $kategori->id_sekolah)
                                                                        <li class="{{ $tab == $kategori->id_kn ? 'active' : '' }}">
                                                                            <a data-toggle="tab" href="#kategori-{{ $kategori->id_kn }}" data-id-gp="{{ $dataGp->id_gp }}">{{ $kategori->kategori }}</a>
                                                                            {{-- <a data-toggle="tab" href="#kategori-{{ $kategori->id_kn }}" data-id-gp="{{ $dataGp->id_gp }}" data-id-kn="{{ $kategori->id_kn }}" class="kategori-tab">{{ $kategori->kategori }}</a> --}}
                                                                            <input name="kategori" type="hidden" value="{{ $kategori->id_kn }}" readonly>
                                                                            {{-- <a href="{{ route('export.pdf', ['id_gp' => $id_gp]) }}#kategori-{{ $kategori->id_kn }}" class="btn btn-danger" style="margin-right: 10px;">Export to PDF</a> --}}
                                                                        </li>
                                                                    @endif
                                                                {{-- @endforeach --}}
                                                            @endforeach
                                                        </ul>
                                                        <div class="tab-content">
                                                            @foreach ($dataKn as $key => $kategori)
                                                                <div id="kategori-{{ $kategori->id_kn }}" class="tab-pane {{ $tab == $kategori->id_kn ? 'active' : '' }}">
                                                                    <div style="display:flex; justify-content:end">
                                                                        {{-- <a href="{{ route('export.pdf', ['id_gp' => $id_gp]) }}" class="btn btn-danger" style="margin-right: 10px;">Export to PDF</a> --}}
                                                                        <a style="margin-right: 10px;" href="{{ route('export.pdf', ['id_gp' => $id_gp, 'id_kn' => $kategori->id_kn]) }}" class="btn btn-sm btn-danger">Export to PDF</a>
                                                                        <a href="{{ route('export.excel', ['id_gp' => $id_gp, 'id_kn' => $kategori->id_kn]) }}" class="btn btn-success">Export to Excel</a>
                                                                    </div>
                                                                {{-- <div id="kategori-{{ $kategori->id_kn }}" class="tab-pane {{ $tab == $kategori->id_kn || ($tab === null && $key === 0) ? 'active' : '' }}"> --}}
                                                                    <form action="{{ route('nilaiGuru.store') }}" method="POST">
                                                                        @csrf
                                                                        {{-- <input name="id_gp" type="text" value="{{ $item->id_gp }}" readonly> --}}
                                                                        <input type="hidden" id="data_id_gp" value="{{ $dataGp->id_gp }}" name="id_gp">
                                                                        <input name="kategori" type="hidden" value="{{ $kategori->id_kn }}">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>No</th>
                                                                                        <th>NIS</th>
                                                                                        <th>Nama</th>
                                                                                        <th>Nilai</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($dataKk as $item)
                                                                                    @php
                                                                                        $nilai = App\Http\Controllers\NilaiGuruController::getNilaiGuru($dataGp->id_gp, $kategori->id_kn, $item->nis_siswa);
                                                                                    @endphp
                                                                                        <tr>
                                                                                            <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                                                                            <td style="vertical-align: middle;">
                                                                                                {{ $item->nis_siswa }}
                                                                                                <input name="nis_siswa[]" type="hidden" value="{{ $item->nis_siswa }}" readonly>
                                                                                            </td>
                                                                                            <td style="vertical-align: middle;">
                                                                                                @if ($item->siswa)
                                                                                                    {{ $item->siswa->nama_siswa }}
                                                                                                @else
                                                                                                    Siswa not found
                                                                                                @endif
                                                                                            </td>
                                                                                            <td style="vertical-align: middle;">
                                                                                                <input class="form-control" value="{{ $nilai }}" name="nilai[]" type="text" style="width: 100px;">
                                                                                            </td>                                                                                                       
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        {{ $dataKk->links('pagination::bootstrap-4') }}
                                                                        <div class="text-right mt-3">
                                                                            <a href="{{ route('nilaiGuru.index') }}" class="btn btn-secondary">KEMBALI</a>
                                                                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                @if(session('success'))
                <div class="alert alert-info">
                    {{ session('success') }}
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
