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
            width: 100%;
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
    <h3 class="mb-3" style="text-align: center">Laporan Absensi Siswa </h3>
    {{-- <table class="info-table">
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
    </table> --}}
    <table class="info-table">
        <tbody>
            <!-- Menampilkan informasi mata pelajaran -->
            <tr>
                <th>Nama Sekolah<span style="float: right;">:</span></th>
                <td>
                    @if (isset($dataAd[0]->guruPelajaran->sekolah))
                        {{ $dataAd[0]->guruPelajaran->sekolah->nama_sekolah }}
                    @else
                        Data Sekolah Tidak Ditemukan
                    @endif
                </td>
                <th>Tahun Ajaran<span style="float: right;">:</span></th>
                <td>
                    @if (isset($dataAd[0]->guruPelajaran->tahun_ajaran))
                        {{ $dataAd[0]->guruPelajaran->tahun_ajaran }}
                    @else
                        Tahun Ajaran Tidak Ditemukan
                    @endif
                </td>
            </tr>
            <tr>
                <th>Nama Kelas<span style="float: right;">:</span></th>
                <td>
                    @if (isset($dataAd[0]->guruPelajaran->kelas))
                        {{ $dataAd[0]->guruPelajaran->kelas->nama_kelas }}
                    @else
                        Data Kelas Tidak Ditemukan
                    @endif
                </td>
                <th>Mata Pelajaran<span style="float: right;">:</span></th>
                <td>
                    @if (isset($dataAd[0]->guruPelajaran->mapel))
                        {{ $dataAd[0]->guruPelajaran->mapel->nama_pelajaran }}
                    @else
                        Data Pelajaran Tidak Ditemukan
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    
    <table class="table table-bordered" style="margin-top: 10px">
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Nis</th>
                <th style="text-align: center">Nama</th>
                {{-- @foreach ($uniqueDates as $tanggal)
                <th>{{ $tanggal->tanggal }}</th>
                @endforeach --}}
                @foreach ($uniqueDates as $tanggal)
                    @php
                        $tanggalDatabase = date('d-m-Y', strtotime($tanggal->tanggal));
                    @endphp
                    <th style="text-align: center">{{ $tanggalDatabase }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($dataAd as $item)
            <tr>
                <td style="text-align: center">{{ $loop->iteration  }}</td>
                <td style="text-align: center">{{ $item->nis_siswa ?? 'Data tidak ditemukan' }}</td>
                <td style="text-align: center">
                    @if(isset($item->siswa))
                        {{ $item->siswa->nama_siswa }}
                    @else
                        Data tidak ditemukan
                    @endif
                </td>   
                @foreach ($uniqueDates as $tanggal)
                <td style="text-align: center">
                    @php
                    $keterangan = App\Http\Controllers\GuruPelajaranController::getKeterangan($item->id_gp, $tanggal->tanggal, $item->nis_siswa);
                    @endphp
                    {{ $keterangan ?? '' }}
                </td>
                @endforeach
            </tr>                                                
            @endforeach
        </tbody>
    </table>
</body>
</html>