<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;

class ViewProposalExport implements FromView, ShouldAutoSize, WithStyles, WithEvents, WithTitle
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('export.rekap_proposal', [
            'data' => $this->data
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => [ // Header baris ke-2
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'd9edf7'],
                ],
            ],
            // Wrap text untuk "Penerima Manfaat" (kolom E) dan "Deskripsi" (kolom F)
            'E' => ['alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP]],
            'F' => ['alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Bekukan header di atas
                $sheet->freezePane('A3');

                // Aktifkan auto height agar wrapText benar-benar terlihat
                $highestRow = $sheet->getHighestRow();
                for ($row = 3; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1); // -1 = auto height
                }
            },
        ];
    }

    public function title(): string
    {
        return 'Rekap Proposal';
    }
}
