<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class NilaiExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $dataKn;
    protected $dataGp;
    protected $dataSekolah;
    protected $tab;
    protected $dataKk;

    public function __construct($dataKn, $dataGp, $dataSekolah, $tab, $dataKk)
    {
        $this->dataKn = $dataKn;
        $this->dataGp = $dataGp;
        $this->dataSekolah = $dataSekolah;
        $this->tab = $tab;
        $this->dataKk = $dataKk;
    }

    public function view(): View
    {
        return view('dataNilai.eksportNilai', [
            'dataKn' => $this->dataKn,
            'dataGp' => $this->dataGp,
            'dataSekolah' => $this->dataSekolah,
            'tab' => $this->tab,
            'dataKk' => $this->dataKk,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Ambil jumlah baris data
        $rowCount = count($this->dataKk) + 6; // Sesuaikan jumlah baris dengan data yang akan Anda tampilkan

        // Berikan border ke seluruh kolom dan baris yang berisi data mulai dari baris ke-5
        $sheet->getStyle('A6:D' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->mergeCells('A1:D1'); // Sesuaikan dengan sel yang ingin Anda gabungkan
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Mengatur alignment judul

        // Mengatur alignment "Tahun Ajaran" ke kiri
        $sheet->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Mengatur alignment "Tahun Ajaran"

        // $sheet->getStyle('A6:D' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // foreach ($sheet->getRowIterator(6, $rowCount) as $row) {
        //     foreach ($row->getCellIterator('A', 'D') as $cell) {
        //         $value = $cell->getValue();
        //         if (strpos($value, ':') !== false) {
        //             $cell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        //         }
        //     }
        // }
    }


}
