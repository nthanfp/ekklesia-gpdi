<!DOCTYPE html>
<html>

<head>
    <title>Data Jemaat</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            /* Penting untuk mendukung karakter non-Latin seperti di Bahasa Indonesia */
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Data Jemaat</h1>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Anggota</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>Tgl Lahir</th>
                <th>Status KK</th>
                <th>No. KK</th>
                <th>Rayon</th>
                <th>Status Pelayanan</th>
                <th>Status Keaktifan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jemaats as $index => $jemaat)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $jemaat->no_anggota }}</td>
                    <td>{{ $jemaat->nik ?? '-' }}</td>
                    <td>{{ $jemaat->nama }}</td>
                    <td>{{ $jemaat->getNamaGenderAttribute() }}</td>
                    <td>{{ $jemaat->tanggal_lahir ? $jemaat->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                    <td>{{ $jemaat->statusKkLabel }}</td>
                    <td>{{ $jemaat->kartuKeluarga->no_kk ?? '-' }}</td>
                    <td>{{ $jemaat->kartuKeluarga->rayon->nama ?? '-' }}</td>
                    <td>{{ $jemaat->statusPelayananLabel }}</td>
                    <td>{{ $jemaat->statusKeaktifanLabel }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
