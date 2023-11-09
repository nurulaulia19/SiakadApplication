<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* Add borders to the entire table */
        .table-bordered {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            
        }

         .table-profile {
            border-collapse: collapse;
            width: 100%;
            margin-top: 30px;
        }

        /* Style for table header cells */
        .table-bordered th {
            border: 1px solid black;
            padding: 8px;
            
        }

        /* Style for table data cells */
        .table-bordered td {
            border: 1px solid black;
            padding: 8px;

        }

        .table-profile td {
            padding: 8px;

        }

        h1 {
            text-align: center;
            padding: 20px;
        }
        .profile-column {
            padding: 10px; /* Sesuaikan sesuai kebutuhan */
        }

        .profile-label {
            font-weight: bold;
        }

        .profile-value {
            text-transform: capitalize;
        }

        .info-table {
        width: 50%;
        border-collapse: collapse;
        }

        .info-table th {
            width: 40%;
            border: none;
            text-align: left;
            padding: 8px;
        }

        .info-table td {
            width: 60%;
            border: none;
            padding: 8px;
        }
    </style>
</head>
<body>
    @if(isset($guruPelajaran))
    {{-- @if (isset($guruPelajaran) || isset($guruPelajaran->nilai)) --}}
    {{-- <h3 style="text-align: center">Nilai Kelas {{ $namaKelas }} Tahun Ajaran {{ $tahunAjaranFilter }}</h3> --}}
    <table>
        <tr>
            <td>
                @if ($dataSekolah->logo)
                <img style="width: 50px; height: 50px; margin-bottom: 5px;" src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/photos/' . $dataSekolah->logo))) }}" alt="image">
                @else
                    <p>Logo Sekolah Tidak Ditemukan</p>
                @endif
            </td>
            <td>
                @if ($dataSekolah->nama_sekolah) <p style="margin-left: 12px; margin-top: 4px; margin-bottom: 4px; font-weight: bold;">{{ $dataSekolah->nama_sekolah }}</p> @endif
                @if ($dataSekolah->alamat) <p style="margin-left: 12px; margin-top: 4px; margin-bottom: 4px; font-weight: bold;">{{ $dataSekolah->alamat }}</p> @endif
            </td>
         
        </tr>
    </table>        
    <hr>

    <h3 class="mb-3" style="text-align: center">Laporan Detail Nilai Siswa </h3>
    <table class="info-table">
        <tbody>
            <!-- Menampilkan informasi siswa -->
            <tr>
                <th>Nis Siswa<span style="float: right;">:</span></th>
                <td>
                    @if ($siswa)
                        {{ $siswa->nis_siswa }}
                    @else
                        Data Siswa Tidak Ditemukan
                    @endif
                </td>
            </tr>
            
            <tr>
                <th>Nama Siswa<span style="float: right;">:</span></th>
                <td>
                    @if ($siswa)
                        {{ $siswa->nama_siswa }}
                    @else
                        Data Siswa Tidak Ditemukan
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Tampilkan konten jika data tersedia -->
    @else
        <h3></h3>
        <!-- Tampilkan pesan jika data kosong -->
    @endif

    {{-- <p>&nbsp;</p> --}}
    {{-- @if (isset($guruPelajaran) || isset($guruPelajaran->nilai)) --}}
    @if(isset($guruPelajaran))
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="border:1px solid #000; text-align:center; vertical-align:middle;">No</th>
                <th>Nama Pelajaran</th>
                <th>Nama Guru</th>
                @foreach ($dataKategori as $item)
                    <th style="border:1px solid #000; text-align:center; vertical-align:middle;">Nilai {{ $item->kategori }}</th>
                @endforeach

            </tr>
        </thead>
        <tbody>
        @foreach ($pelajaran as $mapel)
        {{-- @php
        $nilai = App\Http\Controllers\GuruPelajaranController::getNilai($dataGp->id_gp, $kategori->id_kn, $item->nis_siswa);
        @endphp --}}
            <tr>
                <td style="text-align:center; vertical-align:middle;">{{ $loop->iteration }}</td>
                <td style="text-align:center; vertical-align:middle;">{{ $mapel->nama_pelajaran }}</td>
                <td style="text-align:center; vertical-align:middle;">
                    @foreach ($guruPelajaran as $guruMapel)
                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                            {{ $guruMapel->user->user_name }}
                        @endif
                    @endforeach
                </td>
                {{-- @if (count($guruPelajaran) > 0)
                    @foreach ($guruPelajaran as $guruMapel)
                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                            @foreach ($guruMapel->nilai as $nilai)
                                <td style="text-align:center; vertical-align:middle;">
                                    {{ $nilai->nilai ?? '' }}
                                </td>
                            @endforeach
                        @endif
                    @endforeach
                @else
                    <td></td>
                @endif --}}
                @if (count($guruPelajaran) > 0)
                    @php
                        $nilaiAvailable = false;
                    @endphp
                    @foreach ($guruPelajaran as $guruMapel)
                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                            @foreach ($dataKategori as $kategori)
                                @php
                                    $nilai = App\Http\Controllers\NilaiSiswaController::getNilaiByKategori($guruMapel->id_gp, $kategori->id_kn, $nisSiswa);
                                @endphp
                                <td style="text-align:center; vertical-align:middle;">{{ $nilai ?? '' }}</td>
                            @endforeach
                            @php
                                $nilaiAvailable = true;
                            @endphp
                        @endif
                    @endforeach
                @if (!$nilaiAvailable)
                    @foreach ($dataKategori as $kategori)
                    <td></td>
                    @endforeach
                @endif
            @else
                @foreach ($dataKategori as $kategori)
                <td></td>
                @endforeach
            @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <h3 style="text-align: center">Data pelajaran tidak tersedia</h3>
    @endif
</body>
</html>