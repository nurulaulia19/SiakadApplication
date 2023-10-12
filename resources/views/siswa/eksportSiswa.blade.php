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
    @if ($dataSiswa->isNotEmpty() && $tahun)
    <h3 class="mb-3" style="text-align: center">
        Data Siswa dengan tahun masuk {{ $tahun }}
    </h3>
    @else
        <h3 class="mb-3" style="text-align: center">
            Data Siswa
        </h3>
    @endif

    <p>&nbsp;</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sekolah</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Tahun Masuk</th>
                {{-- <th>Foto</th> --}}
            </tr>
        </thead>
        <tbody>
            
            @foreach ($dataSiswa as $item)
            <tr>
                <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                <td style="vertical-align: middle;">
                    @if ($item->sekolah)
                        {{ $item->sekolah->nama_sekolah }}
                    @else
                        Nama Sekolah not assigned
                    @endif
                </td> 
                <td style="vertical-align: middle;">{{ $item->nis_siswa}}</td>
                <td style="vertical-align: middle;">{{ $item->nama_siswa }}</td>
                <td style="vertical-align: middle;">{{ $item->tempat_lahir }}</td>  
                <td style="vertical-align: middle;">{{ $item->tanggal_lahir }}</td> 
                <td style="vertical-align: middle;">{{ $item->jenis_kelamin }}</td>  
                <td style="vertical-align: middle;">{{ $item->tahun_masuk }}</td>  
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>