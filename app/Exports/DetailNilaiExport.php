<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetailNilaiExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $dataSekolah;
    protected $dataNilai;
    protected $dataNilai2;

    public function __construct($dataSekolah, $dataNilai, $dataNilai2)
    {
        $this->dataSekolah = $dataSekolah;
        $this->dataNilai = $dataNilai;
        $this->dataNilai2 = $dataNilai2;
    }

    public function view(): View
    {
        return view('dataNilai.eksportExcelDetailNilai', [
            'dataSekolah' => $this->dataSekolah,
            'dataNilai' => $this->dataNilai,
            'dataNilai2' => $this->dataNilai2,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Ambil jumlah baris data
        // $rowCount = count($this->dataNilai) + 7; // Sesuaikan jumlah baris dengan data yang akan Anda tampilkan
        

        // // Berikan border ke seluruh kolom dan baris yang berisi data mulai dari baris ke-5
        // $sheet->getStyle('A7:F' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');


        // COBA LAGI
        // Menghitung jumlah baris berdasarkan jumlah data yang Anda miliki
       // Menghitung jumlah baris berdasarkan jumlah data yang Anda miliki
    //    $categories = [];

    //     foreach ($this->dataNilai2 as $item) {
    //         $kategori = $item->kategoriNilai->kategori;
    //         if (!in_array($kategori, $categories)) {
    //             $categories[] = $kategori;
    //         }
    //     }

    //     // Menghitung jumlah kolom dalam data nilai (asumsi semua data memiliki jumlah kolom yang sama)
    //     $columnCountInData = count($this->dataNilai2); // Sesuaikan dengan jumlah kolom data nilai

    //     // Tentukan kolom terakhir berdasarkan jumlah kategori
    //     $lastCategoryColumn = chr(ord('F') + count($categories) - 1);
        
    //     // Menghitung jumlah baris berdasarkan jumlah data yang Anda miliki
    //     $rowCount = count($this->dataNilai2) + 7; // Sesuaikan dengan jumlah baris yang sesuai
 
    //     // Mengatur border pada kolom F sampai kolom terakhir yang sesuai dengan jumlah kategori
    //     $sheet->getStyle('F7:' . $lastCategoryColumn . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');

    $categories = [];

foreach ($this->dataNilai2 as $item) {
    $kategori = $item->kategoriNilai->kategori;
    if (!in_array($kategori, $categories)) {
        $categories[] = $kategori;
    }
}

// Create an array to track duplicates based on the "mapel" value
$mapelDuplicates = [];

// Menghitung jumlah kolom dalam data nilai (asumsi semua data memiliki jumlah kolom yang sama)
$columnCountInData = count($this->dataNilai2); // Sesuaikan dengan jumlah kolom data nilai

// Tentukan kolom terakhir berdasarkan jumlah kategori
$lastCategoryColumn = chr(ord('F') + count($categories) - 1);

// Menghitung jumlah baris berdasarkan jumlah data yang Anda miliki
$rowCount = count($this->dataNilai2) + 7; // Sesuaikan dengan jumlah baris yang sesuai

// Loop through the data to track duplicates based on the "mapel" value
foreach ($this->dataNilai2 as $item) {
    $mapel = $item->mapel; // Assuming the field name is "mapel"
    
    // Check if "mapel" value already exists in the duplicates array
    if (in_array($mapel, $mapelDuplicates)) {
        // If it's a duplicate, adjust the rowCount and continue to the next item
        $rowCount--;
        continue;
    }
    
    // Add "mapel" value to the duplicates array
    $mapelDuplicates[] = $mapel;
}

// Mengatur border pada kolom F sampai kolom terakhir yang sesuai dengan jumlah kategori
$sheet->getStyle('F7:' . $lastCategoryColumn . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');


        // Mengatur border pada kolom A hingga kolom terakhir yang sesuai dengan jumlah kolom di data nilai
        // $lastDataColumn = chr(ord('A') + $columnCountInData - 1);
        $sheet->getStyle('A7:A' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('B7:B' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('C7:C' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('D7:D' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('E7:E' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');

       

        $sheet->mergeCells('A1:F1'); // Sesuaikan dengan sel yang ingin Anda gabungkan
        $sheet->mergeCells('A2:F2'); // Sesuaikan dengan sel yang ingin Anda gabungkan
        $sheet->mergeCells('A3:F3'); // Sesuaikan dengan sel yang ingin Anda gabungkan
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('1:2')->getFont()->setBold(true);


        $sheet->getStyle('B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); 

    }
}
