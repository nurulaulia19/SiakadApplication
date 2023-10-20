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
    @if(isset($guruPelajaran))
    <h3 style="text-align: center">Nilai Kelas {{ $namaKelas }} Tahun Ajaran {{ $tahunAjaranFilter }}</h3>
    <!-- Tampilkan konten jika data tersedia -->
    @else
        <h3></h3>
        <!-- Tampilkan pesan jika data kosong -->
    @endif

    <p>&nbsp;</p>
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
                <td style="border:1px solid #000; text-align:center; vertical-align:middle;">{{ $loop->iteration }}</td>
                <td>{{ $mapel->nama_pelajaran }}</td>
                <td>
                    @foreach ($guruPelajaran as $guruMapel)
                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                            {{ $guruMapel->user->user_name }}
                        @endif
                    @endforeach
                </td>
                @foreach ($guruPelajaran as $guruMapel)
                    @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                        @foreach ($guruMapel->nilai as $nilai)
                            <td style="border:1px solid #000; text-align:center; vertical-align:middle;">
                                {{ $nilai->nilai }}
                            </td>
                         @endforeach
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <h3 style="text-align: center">Data Pelajaran Tidak Tersedia</h3>
    @endif
</body>
</html>