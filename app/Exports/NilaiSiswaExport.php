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
    protected $dataSekolah;
    protected $siswa;

    public function __construct($tahunAjaranFilter, $kelasFilter, $pelajaran, $message, $namaKelas, $guruPelajaran, $dataKategori, $dataSekolah, $siswa)
    {
        $this->tahunAjaranFilter = $tahunAjaranFilter;
        $this->kelasFilter = $kelasFilter;
        $this->pelajaran = $pelajaran;
        $this->message = $message;
        $this->namaKelas = $namaKelas;
        $this->guruPelajaran = $guruPelajaran;
        $this->dataKategori = $dataKategori;
        $this->dataSekolah = $dataSekolah;
        $this->siswa = $siswa;
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
            'dataSekolah' => $this->dataSekolah,
            'siswa' => $this->siswa,
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
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');
        // $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('1:2')->getFont()->setBold(true);


        $sheet->getStyle('B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); 
    }


}


