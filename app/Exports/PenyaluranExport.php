<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

class PenyaluranExport implements FromView, ShouldAutoSize, WithStyles, WithEvents, WithTitle
{
    protected $data;
    protected $tahun;

    public function __construct($data, $tahun)
    {
        $this->data = $data;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('export.rekap_penyaluran_ykpp', [
            'data' => $this->data,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Baris kedua adalah header kolom
            2 => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'd9edf7'],
                ],
            ],
            // Kolom wrap text jika perlu
            'D' => ['alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP]], // Penerima Manfaat
            'E' => ['alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP]], // Deskripsi
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Freeze baris header
                $sheet->freezePane('A3');

                $highestRow = $sheet->getHighestRow();

                // Format kolom Jumlah (J), Fee (K), dan Subtotal (L)
                foreach (['J', 'K', 'L'] as $col) {
                    $sheet->getStyle("{$col}3:{$col}{$highestRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');

                    $sheet->getStyle("{$col}3:{$col}{$highestRow}")
                        ->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }

                // Hitung total
                $totalRow = $highestRow + 1;

                $sheet->setCellValue("I{$totalRow}", 'TOTAL'); // Label total
                $sheet->getStyle("I{$totalRow}")->getFont()->setBold(true);

                foreach (['J', 'K', 'L'] as $col) {
                    $sheet->setCellValue("{$col}{$totalRow}", "=SUM({$col}3:{$col}{$highestRow})");
                    $sheet->getStyle("{$col}{$totalRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');
                    $sheet->getStyle("{$col}{$totalRow}")
                        ->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("{$col}{$totalRow}")->getFont()->setBold(true);
                }
            },
        ];
    }

    public function title(): string
    {
        return 'Penyaluran YKPP ' . $this->tahun;
    }
}