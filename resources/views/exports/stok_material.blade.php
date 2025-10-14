<table>
    <thead>
        <tr>
            <th colspan="9" style="text-align:center;">
                LAPORAN STOK MATERIAL
                @if($month)
                BULAN {{ strtoupper(date('F', mktime(0,0,0,$month,1))) }}
                @endif
                TAHUN {{ $year }}
            </th>
        </tr>
        <tr>
            <th>No</th>
            <th>Valuation Area</th>
            <th>Material</th>
            <th>Material Description</th>
            <th>Base Unit of Measure</th>
            <th>Saldo Awal (Kg)</th>
            <th>Masuk (Kg)</th>
            <th>Keluar (Kg)</th>
            <th>Saldo Akhir (Kg)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($materials as $m)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>'{{ $m['plant'] }}</td>
            <td>{{ $m['kode_material'] }}</td>
            <td>{{ $m['nama'] }}</td>
            <td>{{ $m['satuan'] }}</td>
            <td>{{ number_format($m['saldo_awal']) }}</td>
            <td>{{ number_format($m['masuk']) }}</td>
            <td>{{ number_format($m['keluar']) }}</td>
            <td>{{ number_format($m['saldo_akhir']) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>