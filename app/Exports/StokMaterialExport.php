<?php

namespace App\Exports;

use App\Models\Material;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class StokMaterialExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithEvents
{
    protected $year, $month;

    public function __construct($year, $month = null)
    {
        $this->year = $year;
        $this->month = $month;
    }

    /* ================= DATA ================= */
    public function collection()
    {
        return Material::with(['penerimaans', 'pengeluarans'])->get();
    }

    /* ================= MAP ================= */
    public function map($item): array
    {
        $saldoAwal = $this->getSaldoAwal($item);
        $masuk = $this->getMasuk($item);
        $keluar = $this->getKeluar($item);

        return [
            $item->plant,
            $item->kode_material,
            $item->uraian_material,
            $item->satuan,
            $saldoAwal,
            $masuk,
            $keluar,
            $saldoAwal + $masuk - $keluar,
        ];
    }

    /* ================= HEADER ================= */
    public function headings(): array
    {
        return [
            'Valuation Area',
            'Material',
            'Material Description',
            'Base Unit',
            'Saldo Awal',
            'Masuk',
            'Keluar',
            'Saldo Akhir',
        ];
    }

    /* ================= STYLE ================= */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastColumn = $sheet->getHighestColumn();

                /* ===== INSERT TITLE ROW ===== */
                $sheet->insertNewRowBefore(1, 1);

                /* ===== TITLE TEXT ===== */
                $bulan = strtoupper(Carbon::createFromDate($this->year, (int) $this->month, 1)->translatedFormat('F'));
                $judul = "LAPORAN STOK MATERIAL BULAN $bulan TAHUN {$this->year}";

                $sheet->setCellValue('A1', $judul);
                $sheet->mergeCells("A1:$lastColumn" . "1");

                /* ===== TITLE STYLE ===== */
                $sheet->getStyle("A1:$lastColumn" . "1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                /* HEADER */
                $sheet->getStyle("A1:$lastCol" . "1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => '1F4E78'],
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                /* ZEBRA */
                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A$row:$lastCol$row")->applyFromArray([
                            'fill' => [
                                'fillType' => 'solid',
                                'startColor' => ['rgb' => 'F5F7FA'],
                            ],
                        ]);
                    }
                }

                /* BORDER */
                $sheet->getStyle("A1:$lastCol$lastRow")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['rgb' => 'D0D0D0'],
                        ],
                    ],
                ]);

                /* FORMAT ANGKA */
                $sheet->getStyle("E2:H$lastRow")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                /* AUTO WIDTH */
                foreach (range('A', $lastCol) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }

    /* ================= HELPER ================= */
    protected function getSaldoAwal($item)
    {
        $cutoff = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth();

        $masukSetelah = $item->penerimaans()
            ->where('tanggal_terima', '>=', $cutoff)
            ->sum('saldo_masuk');

        $keluarSetelah = $item->pengeluarans()
            ->where('tanggal_keluar', '>=', $cutoff)
            ->sum('saldo_keluar');

        return $item->total_saldo + $keluarSetelah - $masukSetelah;
    }

    protected function getMasuk($item)
    {
        return $item->penerimaans()
            ->whereYear('tanggal_terima', $this->year)
            ->whereMonth('tanggal_terima', $this->month)
            ->sum('saldo_masuk');
    }

    protected function getKeluar($item)
    {
        return $item->pengeluarans()
            ->where('status', 'diterima')
            ->whereYear('tanggal_keluar', $this->year)
            ->whereMonth('tanggal_keluar', $this->month)
            ->sum('saldo_keluar');
    }
}
