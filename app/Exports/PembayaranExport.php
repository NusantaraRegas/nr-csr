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

class PembayaranExport implements FromView, ShouldAutoSize, WithStyles, WithEvents, WithTitle
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
        return view('export.rekap_pembayaran', [
            'data' => $this->data,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
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
            'E' => ['alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP]], // Deskripsi
            'H' => ['alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP]], // Penerima Manfaat
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->freezePane('A3');

                $highestRow = $sheet->getHighestRow();

                foreach (['Q', 'R', 'S'] as $col) {
                    $sheet->getStyle("{$col}3:{$col}{$highestRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');
                    $sheet->getStyle("{$col}3:{$col}{$highestRow}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                }

                // Total di bawah data
                $totalRow = $highestRow + 1;

                $sheet->setCellValue("L{$totalRow}", 'TOTAL'); // Kolom ke-12 = L
                $sheet->getStyle("L{$totalRow}")->getFont()->setBold(true);

                foreach (['Q', 'R', 'S'] as $col) {
                    $sheet->setCellValue("{$col}{$totalRow}", "=SUM({$col}3:{$col}{$highestRow})");
                    $sheet->getStyle("{$col}{$totalRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');
                    $sheet->getStyle("{$col}{$totalRow}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("{$col}{$totalRow}")->getFont()->setBold(true);
                }
            },
        ];
    }

    public function title(): string
    {
        return 'Rekap Pembayaran ' . $this->tahun;
    }
}
