<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class NilaiSiswaExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $tahunAjaranFilter;
    protected $kelasFilter;
    protected $pelajaran;
    protected $message;
    protected $namaKelas;
    protected $guruPelajaran;
    protected $dataKategori;

    public function __construct($tahunAjaranFilter, $kelasFilter, $pelajaran, $message, $namaKelas, $guruPelajaran, $dataKategori)
    {
        $this->tahunAjaranFilter = $tahunAjaranFilter;
        $this->kelasFilter = $kelasFilter;
        $this->pelajaran = $pelajaran;
        $this->message = $message;
        $this->namaKelas = $namaKelas;
        $this->guruPelajaran = $guruPelajaran;
        $this->dataKategori = $dataKategori;
    }


    public function view(): View
    {
        // return view('jadwalSiswa.eksportJadwalSiswa', [
        //     'tahunAjaranFilter' => $this->tahunAjaranFilter,
        //     'kelasFilter' => $this->kelasFilter,
        //     'pelajaran' => $this->pelajaran,
        //     'message' => $this->message,
        //     'namaKelas' => $this->namaKelas,
        //     'guruPelajaran' => $this->guruPelajaran,
        // ]);

        $viewData = [
            'tahunAjaranFilter' => $this->tahunAjaranFilter,
            'kelasFilter' => $this->kelasFilter,
            'pelajaran' => $this->pelajaran,
            'message' => $this->message,
            'namaKelas' => $this->namaKelas,
            'dataKategori' => $this->dataKategori,
        ];
    
        // Periksa apakah $guruPelajaran memiliki data sebelum menambahkannya ke $viewData
        if ($this->guruPelajaran) {
            $viewData['guruPelajaran'] = $this->guruPelajaran;
        } else {
            $viewData['guruPelajaran'] = []; // Atur menjadi array kosong jika tidak ada datanya
            $viewData['message'] = 'Data pelajaran tidak tersedia';
        }
    
        return view('nilaiSiswa.eksportExcelNilaiSiswa', $viewData);
    }

    public function getBorderStyles()
    {
        return [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        
    }

    public function styles(Worksheet $sheet){
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }


}


