<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\DataPelajaran;
use App\Models\GuruPelajaran;
use App\Models\KategoriNilai;
use App\Models\KenaikanKelas;
use App\Models\PelajaranKelas;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiSiswaExport;
use Dompdf\Dompdf;
use Dompdf\Options;

class NilaiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $siswa = auth()->guard('siswa')->user();
        
        $idSiswa = $siswa->id_siswa;

        if ($siswa) {
            $nisSiswa = $siswa->nis_siswa;
        
            // Dapatkan tahun ajaran dan kelas dari entri kenaikan kelas
            $kenaikanKelas = KenaikanKelas::where('nis_siswa', $nisSiswa)
                ->first();
        
            if ($kenaikanKelas) {
                $tahunAjaranFilter = $kenaikanKelas->tahun_ajaran;
                $kelasFilter = $kenaikanKelas->id_kelas;
                $kelas = Kelas::find($kelasFilter);

                if ($kelas) {
                    $namaKelas = $kelas->nama_kelas; // Mendapatkan nama kelas dari entri kelas
                } else {
                    $namaKelas = 'Kelas Tidak Ditemukan';
                }

                // dd($namaKelas);
            } else {
                // Tindakan jika entri kenaikan kelas tidak ditemukan
                $tahunAjaranFilter = null; // Atau berikan nilai default yang sesuai
                $kelasFilter = null; // Atau berikan nilai default yang sesuai
            }
       
        } else {
            // Tindakan jika pengguna tidak ditemukan
            $tahunAjaranFilter = null; // Atau berikan nilai default yang sesuai
            $kelasFilter = null; // Atau berikan nilai default yang sesuai
        }
        // dd($kelasFilter);
       

        if ($siswa) {
            $nisSiswa = $siswa->nis_siswa;
        
            $kenaikanKelas = KenaikanKelas::where('nis_siswa', $nisSiswa)
                ->when($tahunAjaranFilter, function ($query) use ($tahunAjaranFilter) {
                    return $query->where('tahun_ajaran', $tahunAjaranFilter);
                })
                ->when($kelasFilter, function ($query) use ($kelasFilter) {
                    return $query->where('id_kelas', $kelasFilter);
                })
                ->first();
        
            $message = $kenaikanKelas ? '' : 'Data Kenaikan Kelas tidak ditemukan';
        
            // Lanjutkan dengan mencari data pelajaran
        
        } else {
            // Tindakan jika pengguna tidak ditemukan
            $message = 'Pengguna tidak ditemukan';
        }
        

        $idKelas = $kenaikanKelas->id_kelas;
        // dd($idKelas);

        if ($siswa) {
            $idSekolah = $siswa->id_sekolah;
            $nisSiswa = $siswa->nis_siswa;
        
            // Langkah 1: Dapatkan entri kenaikan kelas siswa
            $kenaikanKelas = KenaikanKelas::where('id_sekolah', $idSekolah)
                ->where('nis_siswa', $nisSiswa)
                ->first();

            $dataKategori = KategoriNilai::where('id_sekolah', $idSekolah)
                ->orderBy('id_kn', 'desc')
                ->get();
        
            if ($kenaikanKelas) {
                $idKelas = $kenaikanKelas->id_kelas;
                $tahunAjaran = $kenaikanKelas->tahun_ajaran;
        
                // Langkah 2: Dapatkan pelajaran kelas sesuai dengan id_kelas
                $pelajaranKelas = PelajaranKelas::where('id_kelas', $idKelas)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->with('mapelList')
                    ->first();
        
                if ($pelajaranKelas) {
                    $pelajaranData = $pelajaranKelas->mapelList->pluck('id_pelajaran')->toArray();
                    
        
                    // Langkah 3: Dapatkan data pelajaran yang sesuai dengan id_pelajaran
                    $pelajaran = DataPelajaran::whereIn('id_pelajaran', $pelajaranData)->get();
                    // dd($pelajaran);

                    // $guruPelajaran = GuruPelajaran::where('id_pelajaran', $pelajaranData)
                    //     ->with('user', 'guruMapelJadwal')
                    //     ->get();
                    $guruPelajaran = GuruPelajaran::whereIn('id_pelajaran', $pelajaranData)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->with('user', 'nilai')
                    ->get();
                    
                   
        
                    // dd($guruPelajaran);
                } else {
                    // Tindakan jika data pelajaran kelas tidak ditemukan
                    $pelajaran = collect(); // Menggunakan koleksi kosong jika data pelajaran kelas tidak ditemukan
                }
            } else {
                // Tindakan jika entri kenaikan kelas tidak ditemukan
                $pelajaran = collect(); // Menggunakan koleksi kosong jika entri kenaikan kelas tidak ditemukan
            }
        } else {
            // Tindakan jika pengguna tidak ditemukan
            $pelajaran = collect(); // Menggunakan koleksi kosong jika pengguna tidak ditemukan
        }
        
        if (isset($guruPelajaran)) {
            return view('nilaiSiswa.index', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran', 'message', 'namaKelas', 'guruPelajaran','dataKategori'));
        } else {
            return view('nilaiSiswa.index', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran', 'message', 'namaKelas','dataKategori'));
        }

        // return view('nilaiSiswa.index', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran','message','namaKelas','guruPelajaran','dataKategori'));
    }

    public function exportPDF(Request $request)
    {
        $siswa = auth()->guard('siswa')->user();
        
        $idSiswa = $siswa->id_siswa;

        if ($siswa) {
            $nisSiswa = $siswa->nis_siswa;
        
            // Dapatkan tahun ajaran dan kelas dari entri kenaikan kelas
            $kenaikanKelas = KenaikanKelas::where('nis_siswa', $nisSiswa)
                ->first();
        
            if ($kenaikanKelas) {
                $tahunAjaranFilter = $kenaikanKelas->tahun_ajaran;
                $kelasFilter = $kenaikanKelas->id_kelas;
                $kelas = Kelas::find($kelasFilter);

                if ($kelas) {
                    $namaKelas = $kelas->nama_kelas; // Mendapatkan nama kelas dari entri kelas
                } else {
                    $namaKelas = 'Kelas Tidak Ditemukan';
                }

                // dd($namaKelas);
            } else {
                // Tindakan jika entri kenaikan kelas tidak ditemukan
                $tahunAjaranFilter = null; // Atau berikan nilai default yang sesuai
                $kelasFilter = null; // Atau berikan nilai default yang sesuai
            }
       
        } else {
            // Tindakan jika pengguna tidak ditemukan
            $tahunAjaranFilter = null; // Atau berikan nilai default yang sesuai
            $kelasFilter = null; // Atau berikan nilai default yang sesuai
        }
        // dd($kelasFilter);
       

        if ($siswa) {
            $nisSiswa = $siswa->nis_siswa;
        
            $kenaikanKelas = KenaikanKelas::where('nis_siswa', $nisSiswa)
                ->when($tahunAjaranFilter, function ($query) use ($tahunAjaranFilter) {
                    return $query->where('tahun_ajaran', $tahunAjaranFilter);
                })
                ->when($kelasFilter, function ($query) use ($kelasFilter) {
                    return $query->where('id_kelas', $kelasFilter);
                })
                ->first();
        
            $message = $kenaikanKelas ? '' : 'Data Kenaikan Kelas tidak ditemukan';
        
            // Lanjutkan dengan mencari data pelajaran
        
        } else {
            // Tindakan jika pengguna tidak ditemukan
            $message = 'Pengguna tidak ditemukan';
        }
        

        $idKelas = $kenaikanKelas->id_kelas;
        // dd($idKelas);

        if ($siswa) {
            $idSekolah = $siswa->id_sekolah;
            $nisSiswa = $siswa->nis_siswa;
        
            // Langkah 1: Dapatkan entri kenaikan kelas siswa
            $kenaikanKelas = KenaikanKelas::where('id_sekolah', $idSekolah)
                ->where('nis_siswa', $nisSiswa)
                ->first();

            $dataKategori = KategoriNilai::where('id_sekolah', $idSekolah)
                ->orderBy('id_kn', 'desc')
                ->get();
        
            if ($kenaikanKelas) {
                $idKelas = $kenaikanKelas->id_kelas;
                $tahunAjaran = $kenaikanKelas->tahun_ajaran;
        
                // Langkah 2: Dapatkan pelajaran kelas sesuai dengan id_kelas
                $pelajaranKelas = PelajaranKelas::where('id_kelas', $idKelas)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->with('mapelList')
                    ->first();
        
                if ($pelajaranKelas) {
                    $pelajaranData = $pelajaranKelas->mapelList->pluck('id_pelajaran')->toArray();
                    
        
                    // Langkah 3: Dapatkan data pelajaran yang sesuai dengan id_pelajaran
                    $pelajaran = DataPelajaran::whereIn('id_pelajaran', $pelajaranData)->get();
                    // dd($pelajaran);

                    // $guruPelajaran = GuruPelajaran::where('id_pelajaran', $pelajaranData)
                    //     ->with('user', 'guruMapelJadwal')
                    //     ->get();
                    $guruPelajaran = GuruPelajaran::whereIn('id_pelajaran', $pelajaranData)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->with('user', 'nilai')
                    ->get();
                    
                   
        
                    // dd($guruPelajaran);
                } else {
                    // Tindakan jika data pelajaran kelas tidak ditemukan
                    $pelajaran = collect(); // Menggunakan koleksi kosong jika data pelajaran kelas tidak ditemukan
                }
            } else {
                // Tindakan jika entri kenaikan kelas tidak ditemukan
                $pelajaran = collect(); // Menggunakan koleksi kosong jika entri kenaikan kelas tidak ditemukan
            }
        } else {
            // Tindakan jika pengguna tidak ditemukan
            $pelajaran = collect(); // Menggunakan koleksi kosong jika pengguna tidak ditemukan
        }


        // Buat opsi PDF
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Inisialisasi Dompdf dengan opsi yang telah ditentukan
        $pdf = new Dompdf($pdfOptions);


        if (isset($guruPelajaran)) {
            $htmlContent = view('nilaiSiswa.eksportNilaiSiswa', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran', 'message', 'namaKelas', 'guruPelajaran','dataKategori'))->render();
        } else {
            $htmlContent = view('nilaiSiswa.eksportNilaiSiswa', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran', 'message', 'namaKelas','dataKategori'))->render();
        }

        // Render view dengan data siswa ke dalam HTML
        // $htmlContent = view('jadwalSiswa.eksportJadwalSiswa', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran', 'message', 'namaKelas', 'guruPelajaran'))->render();

        // Muat konten HTML ke dalam Dompdf
        $pdf->loadHtml($htmlContent);

        // Atur ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Render PDF
        $pdf->render();

        // Kembalikan PDF untuk diunduh
        return $pdf->stream('nilai-siswa.pdf');
    }

    public function exportExcel()
    {
        $siswa = auth()->guard('siswa')->user();
        
        $idSiswa = $siswa->id_siswa;

        if ($siswa) {
            $nisSiswa = $siswa->nis_siswa;
        
            // Dapatkan tahun ajaran dan kelas dari entri kenaikan kelas
            $kenaikanKelas = KenaikanKelas::where('nis_siswa', $nisSiswa)
                ->first();
        
            if ($kenaikanKelas) {
                $tahunAjaranFilter = $kenaikanKelas->tahun_ajaran;
                $kelasFilter = $kenaikanKelas->id_kelas;
                $kelas = Kelas::find($kelasFilter);

                if ($kelas) {
                    $namaKelas = $kelas->nama_kelas; // Mendapatkan nama kelas dari entri kelas
                } else {
                    $namaKelas = 'Kelas Tidak Ditemukan';
                }

                // dd($namaKelas);
            } else {
                // Tindakan jika entri kenaikan kelas tidak ditemukan
                $tahunAjaranFilter = null; // Atau berikan nilai default yang sesuai
                $kelasFilter = null; // Atau berikan nilai default yang sesuai
            }
       
        } else {
            // Tindakan jika pengguna tidak ditemukan
            $tahunAjaranFilter = null; // Atau berikan nilai default yang sesuai
            $kelasFilter = null; // Atau berikan nilai default yang sesuai
        }
        // dd($kelasFilter);
       

        if ($siswa) {
            $nisSiswa = $siswa->nis_siswa;
        
            $kenaikanKelas = KenaikanKelas::where('nis_siswa', $nisSiswa)
                ->when($tahunAjaranFilter, function ($query) use ($tahunAjaranFilter) {
                    return $query->where('tahun_ajaran', $tahunAjaranFilter);
                })
                ->when($kelasFilter, function ($query) use ($kelasFilter) {
                    return $query->where('id_kelas', $kelasFilter);
                })
                ->first();
        
            $message = $kenaikanKelas ? '' : 'Data Kenaikan Kelas tidak ditemukan';
        
            // Lanjutkan dengan mencari data pelajaran
        
        } else {
            // Tindakan jika pengguna tidak ditemukan
            $message = 'Pengguna tidak ditemukan';
        }
        

        $idKelas = $kenaikanKelas->id_kelas;
        // dd($idKelas);

        if ($siswa) {
            $idSekolah = $siswa->id_sekolah;
            $nisSiswa = $siswa->nis_siswa;
        
            // Langkah 1: Dapatkan entri kenaikan kelas siswa
            $kenaikanKelas = KenaikanKelas::where('id_sekolah', $idSekolah)
                ->where('nis_siswa', $nisSiswa)
                ->first();

            $dataKategori = KategoriNilai::where('id_sekolah', $idSekolah)
                ->orderBy('id_kn', 'desc')
                ->get();
        
            if ($kenaikanKelas) {
                $idKelas = $kenaikanKelas->id_kelas;
                $tahunAjaran = $kenaikanKelas->tahun_ajaran;
        
                // Langkah 2: Dapatkan pelajaran kelas sesuai dengan id_kelas
                $pelajaranKelas = PelajaranKelas::where('id_kelas', $idKelas)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->with('mapelList')
                    ->first();
        
                if ($pelajaranKelas) {
                    $pelajaranData = $pelajaranKelas->mapelList->pluck('id_pelajaran')->toArray();
                    
        
                    // Langkah 3: Dapatkan data pelajaran yang sesuai dengan id_pelajaran
                    $pelajaran = DataPelajaran::whereIn('id_pelajaran', $pelajaranData)->get();
                    // dd($pelajaran);

                    // $guruPelajaran = GuruPelajaran::where('id_pelajaran', $pelajaranData)
                    //     ->with('user', 'guruMapelJadwal')
                    //     ->get();
                    $guruPelajaran = GuruPelajaran::whereIn('id_pelajaran', $pelajaranData)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->with('user', 'nilai')
                    ->get();
                    
                   
        
                    // dd($guruPelajaran);
                } else {
                    // Tindakan jika data pelajaran kelas tidak ditemukan
                    $pelajaran = collect(); // Menggunakan koleksi kosong jika data pelajaran kelas tidak ditemukan
                }
            } else {
                // Tindakan jika entri kenaikan kelas tidak ditemukan
                $pelajaran = collect(); // Menggunakan koleksi kosong jika entri kenaikan kelas tidak ditemukan
            }
        } else {
            // Tindakan jika pengguna tidak ditemukan
            $pelajaran = collect(); // Menggunakan koleksi kosong jika pengguna tidak ditemukan
        }


        if (isset($guruPelajaran)) {
            // Jika guruPelajaran memiliki data, maka lakukan ekspor dengan view
            return Excel::download(new NilaiSiswaExport($tahunAjaranFilter, $kelasFilter, $pelajaran, $message, $namaKelas, $guruPelajaran, $dataKategori), 'nilai-siswa.xlsx');
        } else {
            // Jika guruPelajaran kosong, maka hanya lakukan ekspor data lainnya tanpa view
            return Excel::download(new NilaiSiswaExport($tahunAjaranFilter, $kelasFilter, $pelajaran, $message, $namaKelas, [], $dataKategori), 'nilai-siswa.xlsx');
        }
    // Panggil kelas eksport yang telah Anda buat
    // return Excel::download(new JadwalSiswaExport($tahunAjaranFilter, $kelasFilter, $pelajaran, $message, $namaKelas, $guruPelajaran), 'jadwal-siswa.xlsx');

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
