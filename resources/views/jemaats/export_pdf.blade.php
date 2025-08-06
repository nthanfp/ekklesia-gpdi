<!DOCTYPE html>
<html>

<head>
    <title>Data Jemaat</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
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

        .nowrap {
            white-space: nowrap;
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
                <th>Status Pernikahan</th>
                <th>Tgl Pernikahan</th>
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
                    <td class="nowrap">{{ $jemaat->no_anggota }}</td>
                    <td class="nowrap">{{ $jemaat->nik ?? '-' }}</td>
                    <td>{{ $jemaat->nama }}</td>
                    <td class="text-center">{{ $jemaat->getNamaGenderAttribute() }}</td>
                    <td class="nowrap">{{ $jemaat->tanggal_lahir ? $jemaat->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                    <td>{{ $jemaat->statusKkLabel }}</td>
                    <td class="text-center">
                        @if($jemaat->status_kk === 'ANAK')
                            {{ $jemaat->is_menikah ? 'Sudah' : 'Belum' }}
                        @else
                            {{ $jemaat->tanggal_pernikahan ? 'Sudah' : 'Belum' }}
                        @endif
                    </td>
                    <td class="nowrap">
                        @if($jemaat->status_kk === 'ANAK' && $jemaat->is_menikah)
                            {{ $jemaat->tanggal_pernikahan ? $jemaat->tanggal_pernikahan->format('d-m-Y') : '-' }}
                        @elseif(in_array($jemaat->status_kk, ['KEPALA', 'ISTRI']))
                            {{ $jemaat->tanggal_pernikahan ? $jemaat->tanggal_pernikahan->format('d-m-Y') : '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="nowrap">{{ $jemaat->kartuKeluarga->no_kk ?? '-' }}</td>
                    <td>{{ $jemaat->kartuKeluarga->rayon->nama ?? '-' }}</td>
                    <td>{{ $jemaat->statusPelayananLabel }}</td>
                    <td>{{ $jemaat->statusKeaktifanLabel }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>