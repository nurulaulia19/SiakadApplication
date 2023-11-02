<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class JadwalGuruExport implements FromView, ShouldAutoSize, WithStyles
{
    // 'dataGp','listSekolah','listTahunAjaran','sekolahFilter','tahunFilter','menuItemsWithSubmenus'
    protected $dataGp;
    protected $listSekolah;
    protected $listTahunAjaran;
    protected $sekolahFilter;
    protected $tahunFilter;
    protected $namaSekolah;

    public function __construct($dataGp, $listSekolah, $listTahunAjaran, $sekolahFilter, $tahunFilter, $namaSekolah)
    {
        $this->dataGp = $dataGp;
        $this->listSekolah = $listSekolah;
        $this->listTahunAjaran = $listTahunAjaran;
        $this->sekolahFilter = $sekolahFilter;
        $this->tahunFilter = $tahunFilter;
        $this->namaSekolah = $namaSekolah;
    }


    public function view(): View
    {
        $viewData = [
            'dataGp' => $this->dataGp,
            'listSekolah' => $this->listSekolah,
            'listTahunAjaran' => $this->listTahunAjaran,
            'sekolahFilter' => $this->sekolahFilter,
            'tahunFilter' => $this->tahunFilter,
            'namaSekolah' => $this->namaSekolah,
        ];
    
    
        return view('jadwalGuru.eksportExcelJadwalGuru', $viewData);
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
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
    }


}


