<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;

class BookingExport implements FromView, WithTitle, WithStyles, WithEvents, WithDrawings
{
    protected $datas;
    protected $from;
    protected $to;
    protected $exportedBy;

    public function __construct($datas, $from, $to, $exportedBy)
    {
        $this->datas = $datas;
        $this->from = $from;
        $this->to = $to;
        $this->exportedBy = $exportedBy;
    }

    public function view(): View
    {
        return view('export-excel.booking', [
            'datas' => $this->datas,
            'from' => $this->from,
            'to' => $this->to,
            'exportedBy' => $this->exportedBy,
            'exportedAt' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function title(): string
    {
        return 'Booking Export';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            10 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Freeze kolom A dan baris 5 (header)
                $event->sheet->getDelegate()->freezePane('A11');

                // Auto size kolom
                foreach (range('A', 'L') as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Company Logo');
        $drawing->setPath(public_path('template/assets/img/favicon/black-logo.png')); // Ganti path jika beda
        $drawing->setHeight(80); // Ukuran tinggi gambar
        $drawing->setCoordinates('A1');

        return [$drawing];
    }
}
