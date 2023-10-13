<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\DataSiswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SiswaExport implements FromView, WithStyles
{
    use Exportable;

    private $tahun;

    public function __construct($tahun = null)
    {
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $dataSiswaQuery = DataSiswa::query();

        // If $tahun is provided, filter the data
        if ($this->tahun) {
            $dataSiswaQuery->where('tahun_masuk', $this->tahun);
        }

        $dataSiswa = $dataSiswaQuery->get(); // Fetch the data

        return view('siswa.eksportSiswa', [
            'dataSiswa' => $dataSiswa,
            'tahun' => $this->tahun,
        ]);
    }

    // public function styles(Worksheet $sheet)
    // {
    //     // Mengatur alignment judul
    //     $sheet->mergeCells('A1:I1');
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //     $headerBorderStyle = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => Border::BORDER_THIN, // Ganti dengan style yang Anda inginkan
    //             ],
    //         ],
    //     ];
    
    //     // Terapkan border pada elemen th (header) kecuali untuk sel "Tahun Masuk"
    //     $sheet->getStyle('A3:' . $sheet->getHighestColumn() . '2')->applyFromArray($headerBorderStyle);
    
    //     // Mengatur border pada elemen td (data)
    //     $dataBorderStyle = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => Border::BORDER_THIN, // Ganti dengan style yang Anda inginkan
    //             ],
    //         ],
    //     ];
    
    //     // Terapkan border pada elemen td (data)
    //     $sheet->getStyle('A3:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($dataBorderStyle);
    // }

    public function map($dataSiswa): array
    {
        return [
            $dataSiswa->no,
            $dataSiswa->nama_sekolah,
            $dataSiswa->nis,
            $dataSiswa->nama_siswa,
            $dataSiswa->tempat_lahir,
            $dataSiswa->tanggal_lahir,
            $dataSiswa->jenis_kelamin,
            $dataSiswa->tahun_masuk,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Mengatur alignment judul
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headerBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN, // Ganti dengan style yang Anda inginkan
                ],
            ],
        ];
    
        // Terapkan border pada elemen th (header) kecuali untuk sel "Tahun Masuk"
        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . '2')->applyFromArray($headerBorderStyle);
    
        // Mengatur border pada elemen td (data)
        $dataBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN, // Ganti dengan style yang Anda inginkan
                ],
            ],
        ];
    
        // Terapkan border pada elemen td (data)
        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($dataBorderStyle);
        
        // Mengatur lebar kolom secara otomatis kecuali kolom "No"
        $highestColumn = $sheet->getHighestColumn();
        for ($col = 'B'; $col <= $highestColumn; $col++) {
            $columnDimension = $sheet->getColumnDimension($col);
            $columnDimension->setAutoSize(true);
        }
    }
}
