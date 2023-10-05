<?php
namespace App\Exports;

use App\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TransaksiExport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $dataTransaksi;
    protected $totalBayar;
    protected $totalKembalian;
    protected $dataCabang;

    public function __construct($dataTransaksi, $totalBayar, $totalKembalian, $dataCabang)
    {
        $this->dataTransaksi = $dataTransaksi;
        $this->totalBayar = $totalBayar;
        $this->totalKembalian = $totalKembalian;
        $this->dataCabang = $dataCabang;
    }

    public function view(): View
    {
        return view('laporan.eksportTransaksi', [
            'dataTransaksi' => $this->dataTransaksi,
            'totalBayar' => $this->totalBayar,
            'totalKembalian' => $this->totalKembalian,
            'dataCabang' => $this->dataCabang,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->dataTransaksi) + 4; // Include four additional rows

    $styles = [
        // Apply borders to the entire table, including two additional rows at the bottom
        'A3:K' . $rowCount => [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'font' => [
                'size' => 11, // Adjust the font size for most cells
            ],
        ],
    ];

    // Merge cells for the first two rows
    $sheet->mergeCells('A1:K1');
    $sheet->mergeCells('A2:K2');

    // Center-align the merged cells content
    $sheet->getStyle('A1:K2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    return $styles;
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // 'total_harga'
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // 'total_bayar'
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // 'total_kembalian'
        ];
    }
    
    


    
}

