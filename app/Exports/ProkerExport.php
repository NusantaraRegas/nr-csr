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

class ProkerExport implements FromView, ShouldAutoSize, WithStyles, WithEvents, WithTitle
{
    protected $data;
    protected $perusahaan;
    protected $tahun;

    public function __construct($data, $perusahaan, $tahun)
    {
        $this->data = $data;
        $this->perusahaan = $perusahaan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('export.proker', [
            'tahun' => $this->tahun,
            'perusahaan' => $this->perusahaan,
            'dataProker' => $this->data,
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
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->freezePane('A3');

                $highestRow = $sheet->getHighestRow();
                $totalRow = $highestRow + 1;

                // Set total baris bawah
                $sheet->setCellValue("E{$totalRow}", 'TOTAL');
                $sheet->getStyle("E{$totalRow}")->getFont()->setBold(true);

                foreach (['F'] as $col) {
                    // Total (SUM) baris bawah
                    $sheet->setCellValue("{$col}{$totalRow}", "=SUM({$col}3:{$col}{$highestRow})");

                    // Format angka: comma style (misal: 1,000,000)
                    $sheet->getStyle("{$col}3:{$col}{$totalRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0'); // format comma tanpa desimal

                    // Align kanan
                    $sheet->getStyle("{$col}3:{$col}{$totalRow}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                    // Bold total row
                    $sheet->getStyle("{$col}{$totalRow}")->getFont()->setBold(true);
                }
            },
        ];
    }

    public function title(): string
    {
        return 'Program Kerja ' . $this->perusahaan. ' Tahun '.$this->tahun;
    }
}