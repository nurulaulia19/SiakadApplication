<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Jasa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class JasaExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $dataJasa;
    protected $dataCabang;

    public function __construct($dataJasa, $dataCabang)
    {
        $this->dataJasa = $dataJasa;
        $this->dataCabang = $dataCabang;
    }

    public function view(): View
    {
        return view('laporan.eksportJasa', [
            'dataJasa' => $this->dataJasa,
            'dataCabang' => $this->dataCabang,
        ]);
    }

    public function styles(Worksheet $sheet)
{
    $rowCount = count($this->dataJasa) + 4; // Include three additional empty rows

    // Apply borders and font styling to each cell within the specified range
    for ($row = 3; $row <= $rowCount; $row++) { // Start from row 2 to exclude the title
        for ($col = 'A'; $col <= 'D'; $col++) {
            $cellCoordinate = $col . $row;
            $sheet->getStyle($cellCoordinate)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
                'font' => [
                    'size' => 11,
                ],
            ]);
        }
    }

    $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');

        // Center-align the merged cells content
        $sheet->getStyle('A1:D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
}



}


