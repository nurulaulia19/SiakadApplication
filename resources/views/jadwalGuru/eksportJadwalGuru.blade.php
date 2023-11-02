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
    @if(isset($sekolahFilter) && isset($tahunFilter))
        <h3 style="text-align: center">Jadwal Pelajaran {{ $namaSekolah }} Tahun Ajaran {{ $tahunFilter }}</h3>
    @elseif(isset($sekolahFilter))
        <h3 style="text-align: center">Jadwal Pelajaran {{ $namaSekolah }}</h3>
    @elseif(isset($tahunFilter))
        <h3 style="text-align: center">Jadwal Pelajaran pada Tahun Ajaran {{ $tahunFilter }}</h3>
    @else
        <h3 style="text-align: center">Jadwal Pelajaran</h3>
    @endif
    <p>&nbsp;</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sekolah</th>
                <th>Nama Kelas</th>
                <th>Tahun Ajaran</th>
                <th>Mata Pelajaran</th>
                <th>Nama Guru</th>
                <th>Jadwal</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($dataGp as $item)
            <tr>
                <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                <td style="vertical-align: middle;">
                    @if ($item->sekolah)
                        {{ $item->sekolah->nama_sekolah }}
                    @else
                        Nama Sekolah not assigned
                    @endif
                </td>  
                <td style="vertical-align: middle;">
                    @if ($item->kelas)
                        {{ $item->kelas->nama_kelas }}
                    @else
                        Nama Kelas not assigned
                    @endif
                </td> 
                <td style="vertical-align: middle;">{{ $item->tahun_ajaran }}</td>    
                <td style="vertical-align: middle;">{{ $item->mapel->nama_pelajaran}}</td>   
                <td style="vertical-align: middle;">
                    @if ($item->user)
                        {{ $item->user->user_name }}
                    @else
                        Nama Guru not assigned
                    @endif
                </td>
                <td style="vertical-align: middle;">
                    @foreach ($item->guruMapelJadwal as $guruMapel)
                        {{ $guruMapel->hari }} - {{ $guruMapel->jam_mulai }} to {{ $guruMapel->jam_selesai }}
                        <br>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    
</body>
</html>