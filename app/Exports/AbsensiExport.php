<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\DataAbsensi;


class AbsensiExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $dataSekolah;
    protected $dataAd;
    protected $uniqueDates;

    public function __construct($dataSekolah, $dataAd, $uniqueDates)
    {
        $this->dataSekolah = $dataSekolah;
        $this->dataAd = $dataAd;
        $this->uniqueDates = $uniqueDates;
    }

    public function view(): View
    {
        return view('dataAbsensi.eksportExcelAbsensi', [
            'dataSekolah' => $this->dataSekolah,
            'dataAd' => $this->dataAd,
            'uniqueDates' => $this->uniqueDates,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:D1'); // Sesuaikan dengan sel yang ingin Anda gabungkan
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Mengatur alignment judul

        // Mengatur alignment "Tahun Ajaran" ke kiri
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Mengatur alignment "Tahun Ajaran"

        $rowCount = count($this->dataAd) + 5; // Sesuaikan dengan jumlah baris yang sesuai

        $sheet->getStyle('A5:A' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('B5:B' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('C5:C' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');

        // ...

        // foreach ($this->uniqueDates as $i => $tanggal) {
        //     $column = chr(68 + $i) . '5'; // Kolom 'D', 'E', 'F', dan seterusnya
        //     $rowCount = count($this->dataAd) + 5; // Sesuaikan dengan jumlah baris yang sesuai

        //     $sheet->getStyle($column . ':' . $column)->getBorders()->getAllBorders()->setBorderStyle('thin');
        // }

        // $rowCount = count($this->dataAd) + 5; // Sesuaikan dengan jumlah baris yang sesuai

        $lastKeteranganColumn = chr(ord('D') + count($this->uniqueDates) - 1); // Anggap kolom keterangan adalah yang terakhir
    
        // Menambahkan border ke seluruh baris dalam kolom keterangan
        $sheet->getStyle('D5:' . $lastKeteranganColumn . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');
        
       

        
    }

}
