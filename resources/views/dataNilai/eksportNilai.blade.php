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

        .profile-colon {
            float: right;
        }

    </style>
</head>
<body>
    <div class="table-responsive">
        <div class="profile-info">
            {{-- <h3 class="mb-3" style="text-align: center">Laporan Nilai Siswa</h3> --}}
            <h3 class="mb-3" style="text-align: center">Laporan Nilai {{ $dataKn->kategori }} Siswa </h3>
            <table class="table table-profile">
                <tbody>
                    @php
                    $data = [
                        'Sekolah' => $dataGp->sekolah ? $dataGp->sekolah->nama_sekolah : 'Nama Sekolah not assigned',
                        'Kelas' => $dataGp->kelas ? $dataGp->kelas->nama_kelas : 'Nama kelas not assigned',
                        'Tahun Ajaran' => $dataGp->tahun_ajaran,
                        'Mata Pelajaran' => $dataGp->mapel->nama_pelajaran,
                        'Guru' => $dataGp->user ? $dataGp->user->user_name : 'Nama Guru not assigned',
                    ];

                    // Mengonversi data asosiatif ke array dengan 2 elemen per item
                    $dataChunks = array_chunk($data, 2, true);
                    @endphp

                    @foreach ($dataChunks as $chunk)
                    <tr>
                        @foreach ($chunk as $label => $value)
                        {{-- <td class="profile-label" style="text-align: right;">{{ $label }}:</td> --}}
                        <td class="profile-label">{{ $label }}<span class="profile-colon">:</span></td>
                        <td class="profile-value">{{ $value }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">NIS</th>
                    <th style="text-align: center;">Nama</th>
                    <th style="text-align: center;">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataKk as $item)
                @php
                    $nilai = App\Http\Controllers\GuruPelajaranController::getNilai($dataGp->id_gp, $dataKn->id_kn, $item->nis_siswa);
                @endphp
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="text-align: center;">{{ $item->nis_siswa }}</td>
                        <td style="text-align: center;">
                            @if ($item->siswa)
                                {{ $item->siswa->nama_siswa }}
                            @else
                                Siswa not found
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $nilai }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>