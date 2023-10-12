<?php

namespace App\Exports;

use App\Models\DataSiswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class SiswaExport implements FromView
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
}
