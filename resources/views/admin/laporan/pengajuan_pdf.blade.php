<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan Makanan Bergizi</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333333;
            line-height: 1.4;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #2c7c8f;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header-logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #2c7c8f;
            letter-spacing: -0.5px;
        }

        .header-sub {
            font-size: 10px;
            color: #666666;
        }

        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1a1a1a;
            margin-bottom: 5px;
        }

        .report-subtitle {
            text-align: center;
            font-size: 10px;
            color: #555555;
            margin-bottom: 25px;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .meta-label {
            font-weight: bold;
            width: 15%;
        }

        .meta-val {
            width: 35%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .data-table th {
            background-color: #2c7c8f;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            padding: 8px;
            border: 1px solid #2c7c8f;
        }

        .data-table td {
            padding: 8px;
            border: 1px solid #e0e0e0;
        }

        .data-table tr:nth-child(even) {
            background-color: #fcfcfc;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .badge-waiting {
            color: #b25e00;
            font-weight: bold;
        }

        .badge-approved {
            color: #2c7c8f;
            font-weight: bold;
        }

        .badge-rejected {
            color: #c62828;
            font-weight: bold;
        }

        /* Tanda Tangan */
        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }

        .signature-title {
            margin-bottom: 60px;
        }
    </style>
</head>
<body>

    <!-- Header Kop Surat -->
    <table class="header-table">
        <tr>
            <td style="width: 70%;">
                <span class="header-logo-text">SATUAN PELAYANAN PEMENUHAN GIZI (SPPG)</span><br>
                <span class="header-sub">Sistem Informasi Pengelolaan Permintaan dan Penyaluran Makanan Bergizi (SPPG MBG)</span>
            </td>
            <td style="width: 30%; text-align: right; font-size: 9px; color: #666;">
                Tanggal Cetak: {{ date('d-m-Y H:i') }}
            </td>
        </tr>
    </table>

    <!-- Judul Laporan -->
    <div class="report-title">Laporan Pengajuan Permintaan Makanan</div>
    <div class="report-subtitle">Periode: {{ date('d M Y', strtotime($tglAwal)) }} s/d {{ date('d M Y', strtotime($tglAkhir)) }}</div>

    <!-- Meta Filter -->
    <table class="meta-table">
        <tr>
            <td class="meta-label">Instansi Mitra:</td>
            <td class="meta-val">{{ $selectedInstansi ? $selectedInstansi->nama_instansi : 'Semua Instansi' }}</td>
            <td class="meta-label">Status Verifikasi:</td>
            <td class="meta-val">{{ $status ?? 'Semua Status' }}</td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode Pengajuan</th>
                <th style="width: 25%;">Nama Instansi</th>
                <th style="width: 10%;">Tipe</th>
                <th style="width: 15%;">Kategori Sasaran</th>
                <th style="width: 10%; text-align: center;">Porsi</th>
                <th style="width: 15%;">Tanggal Pengajuan</th>
                <th style="width: 10%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPorsi = 0; @endphp
            @forelse($data as $key => $p)
                @php $totalPorsi += $p->jumlah_porsi; @endphp
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="fw-bold">{{ $p->kode_pengajuan }}</td>
                    <td>{{ $p->instansi->nama_instansi }}</td>
                    <td class="text-center">{{ $p->instansi->jenis_instansi }}</td>
                    <td>{{ $p->kategori_penerima }}</td>
                    <td class="text-center fw-bold">{{ number_format($p->jumlah_porsi) }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->tanggal_pengajuan)) }}</td>
                    <td class="text-center">
                        @if($p->status === 'Menunggu')
                            <span class="badge-waiting">Menunggu</span>
                        @elseif($p->status === 'Disetujui')
                            <span class="badge-approved">Disetujui</span>
                        @else
                            <span class="badge-rejected">Ditolak</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #666;">Tidak ada data yang sesuai filter.</td>
                </tr>
            @endforelse
            
            @if(count($data) > 0)
                <tr style="background-color: #eee; font-weight: bold;">
                    <td colspan="5" class="text-right">TOTAL PORSI:</td>
                    <td class="text-center">{{ number_format($totalPorsi) }}</td>
                    <td colspan="2"></td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Tanda Tangan Laporan -->
    <table class="signature-table">
        <tr>
            <td style="width: 65%;"></td>
            <td style="width: 35%; text-align: center;">
                <div>Gizi Kota, {{ date('d F Y') }}</div>
                <div class="signature-title" style="margin-top: 5px; font-weight: bold;">Kepala Satuan Pelayanan Gizi,</div>
                <div style="font-weight: bold; text-decoration: underline;">Dr. dr. H. Hermawan, M.Gizi</div>
                <div>NIP. 19780512 200501 1 002</div>
            </td>
        </tr>
    </table>

</body>
</html>
