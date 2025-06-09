<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $report->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 18px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        .info-table .label {
            font-weight: bold;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        .rank-cell {
            text-align: center;
            font-weight: bold;
        }
        .score-cell {
            text-align: center;
            font-weight: bold;
            color: #2563eb;
        }
        .status-cell {
            text-align: center;
            font-weight: bold;
        }
        .status-excellent { color: #059669; }
        .status-good { color: #2563eb; }
        .status-review { color: #d97706; }
        .status-poor { color: #dc2626; }
        .top-rank {
            background-color: #f0f9ff;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN EVALUASI AHP</h1>
        <p>Sistem Pendukung Keputusan Kredit Rumah</p>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">Judul Laporan:</td>
                <td>{{ $report->title }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Perhitungan:</td>
                <td>{{ $report->calculation_date->format('d F Y, H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Total Alternatif:</td>
                <td>{{ $report->total_alternatives }} nasabah</td>
            </tr>
            <tr>
                <td class="label">Total Kriteria:</td>
                <td>{{ $report->total_criteria }} kriteria</td>
            </tr>
            <tr>
                <td class="label">Sub Kriteria:</td>
                <td>{{ $report->total_subcriteria }} sub kriteria</td>
            </tr>
            @if($report->description)
            <tr>
                <td class="label">Deskripsi:</td>
                <td>{{ $report->description }}</td>
            </tr>
            @endif
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="8%">Rank</th>
                <th width="12%">Kode</th>
                <th width="25%">Nama Nasabah</th>
                <th width="20%">Email</th>
                <th width="15%">Telepon</th>
                <th width="12%">Skor Akhir</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alternatives as $alternative)
                @php
                    $status = 'Tidak Layak';
                    $statusClass = 'status-poor';
                    if ($alternative->rank > 0) {
                        if ($alternative->rank <= 3) {
                            $status = 'Sangat Layak';
                            $statusClass = 'status-excellent';
                        } elseif ($alternative->rank <= 5) {
                            $status = 'Layak';
                            $statusClass = 'status-good';
                        } else {
                            $status = 'Perlu Review';
                            $statusClass = 'status-review';
                        }
                    }
                @endphp
                <tr class="{{ $alternative->rank <= 3 && $alternative->rank > 0 ? 'top-rank' : '' }}">
                    <td class="rank-cell">{{ $alternative->rank > 0 ? $alternative->rank : '-' }}</td>
                    <td>{{ $alternative->code }}</td>
                    <td>{{ $alternative->name }}</td>
                    <td>{{ $alternative->email ?: '-' }}</td>
                    <td>{{ $alternative->phone ?: '-' }}</td>
                    <td class="score-cell">{{ number_format($alternative->final_score, 4) }}</td>
                    <td class="status-cell {{ $statusClass }}">{{ $status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan digenerate pada {{ $exportDate->format('d F Y, H:i:s') }}</p>
        <p>Sistem Pendukung Keputusan - Analytic Hierarchy Process (AHP)</p>
    </div>
</body>
</html>
