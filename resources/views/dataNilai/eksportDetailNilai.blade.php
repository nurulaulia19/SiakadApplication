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
                    @if (count($dataNilai) > 0)
                        {{ $dataNilai[0]->nis_siswa }}
                    @else
                        Data Guru Pelajaran Tidak Ditemukan
                    @endif
                </td>                                                        
            </tr>
            
            <tr>
                <th>Nama Siswa<span style="float: right;">:</span></th>
                <td>
                    @if (count($dataNilai) > 0 && $dataNilai[0]->siswa)
                        {{ $dataNilai[0]->siswa->nama_siswa }}
                    @else
                        Data Guru Pelajaran Tidak Ditemukan
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun Ajaran</th>
                <th>Nama Kelas</th>
                <th>Nama Guru</th>
                <th>Mata Pelajaran</th>
                
                @php
                    $categories = []; // Inisialisasi array kategori
                @endphp
                @foreach ($dataNilai as $item)
                    @php
                        // Periksa apakah kategori belum ditambahkan ke array
                        $kategori = $item->kategoriNilai->kategori;
                        if (!in_array($kategori, $categories)) {
                            $categories[] = $kategori; // Tambahkan kategori ke array
                        }
                    @endphp
                @endforeach
                @foreach ($categories as $category)
                    <th>Nilai {{ $category }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                // Kelompokkan nilai-nilai berdasarkan mata pelajaran dan kategori
                $nilaiByMapelCategory = [];
                foreach ($dataNilai as $item) {
                    $mapel = $item->guruPelajaran->mapel->nama_pelajaran;
                    $kategori = $item->kategoriNilai->kategori;
                    if (!isset($nilaiByMapelCategory[$mapel])) {
                        $nilaiByMapelCategory[$mapel] = [];
                    }
                    $nilaiByMapelCategory[$mapel][$kategori] = $item['nilai'];
                }
            @endphp
    
            @foreach ($nilaiByMapelCategory as $mapel => $nilaiByCategory)
                <tr>
                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td> 
                    <td style="vertical-align: middle;">
                        @if ($item->guruPelajaran)
                            {{ $item->guruPelajaran->tahun_ajaran }}
                        @else
                            Data Guru Pelajaran Tidak Ditemukan
                        @endif
                    </td> 
                    <td style="vertical-align: middle;">
                        @if ($item->guruPelajaran)
                            {{ $item->guruPelajaran->kelas->nama_kelas }}
                        @else
                            Data Guru Pelajaran Tidak Ditemukan
                        @endif
                    </td> 
                    <td style="vertical-align: middle;">
                        @if ($item->guruPelajaran)
                            {{ $item->guruPelajaran->user->user_name }}
                        @else
                            Data Guru Pelajaran Tidak Ditemukan
                        @endif
                    </td> 
                    <td style="vertical-align: middle;">
                        {{ $mapel }}
                    </td>
                    @foreach ($categories as $category)
                        <td style="vertical-align: middle;">
                            @php
                                $nilai = $nilaiByCategory[$category] ?? null;
                            @endphp
                            @if ($nilai !== null)
                                {{ $nilai }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>