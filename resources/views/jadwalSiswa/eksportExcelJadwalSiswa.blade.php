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
    @if(empty($guruPelajaran))
        <h3>{{ $message }}</h3>
    @else
        <h3 style="text-align: center">Jadwal Pelajaran Kelas {{ $namaKelas }} Tahun Ajaran {{ $tahunAjaranFilter }}</h3>
    @endif

    <p>&nbsp;</p>
    @if(empty($guruPelajaran))
        <p></p>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="border:1px solid #000; text-align:center; vertical-align:middle;">No</th>
                <th style="border:1px solid #000; text-align:center; vertical-align:middle;">Nama Pelajaran</th>
                <th style="border:1px solid #000; text-align:center; vertical-align:middle;">Nama Guru</th>
                <th style="border:1px solid #000; text-align:center; vertical-align:middle;">Jadwal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelajaran as $mapel)
            <tr>
                <td style="border:1px solid #000; text-align:center; vertical-align:middle;">{{ $loop->iteration }}</td>
                <td style="border:1px solid #000; text-align:center; vertical-align:middle;">{{ $mapel->nama_pelajaran }}</td>
                <td style="border:1px solid #000; text-align:center; vertical-align:middle;">
                    @foreach ($guruPelajaran as $guruMapel)
                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                            {{ $guruMapel->user->user_name }}
                        @endif
                    @endforeach
                </td>
                <td style="border:1px solid #000; text-align:center; vertical-align:middle;">
                    @foreach ($guruPelajaran as $guruMapel)
                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                            @foreach ($guruMapel->guruMapelJadwal as $jadwal)
                                {{ $jadwal->hari }} - {{ $jadwal->jam_mulai }} to {{ $jadwal->jam_selesai }}
                                <br>
                            @endforeach
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        
        </tbody>
    </table>
    @endif
    {{-- <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelajaran</th>
                <th>Nama Guru</th>
                <th>Jadwal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelajaran as $mapel)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mapel->nama_pelajaran }}</td>
                <td>
                    @foreach ($guruPelajaran as $guruMapel)
                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                            {{ $guruMapel->user->user_name }}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($guruPelajaran as $guruMapel)
                        @if ($guruMapel->id_pelajaran == $mapel->id_pelajaran)
                            @foreach ($guruMapel->guruMapelJadwal as $jadwal)
                                {{ $jadwal->hari }} - {{ $jadwal->jam_mulai }} to {{ $jadwal->jam_selesai }}
                                <br>
                            @endforeach
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        
        </tbody>
    </table> --}}
</body>
</html>