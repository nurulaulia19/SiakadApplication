<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Models\DataPelajaran;
use App\Models\GuruPelajaran;
use App\Models\KenaikanKelas;
use App\Models\PelajaranKelas;
use App\Models\PelajaranKelasList;

class JadwalSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $siswa = auth()->guard('siswa')->user();
        
        $idSiswa = $siswa->id_siswa;
        // $tahunAjaranFilter = $request->input('tahun_ajaran_filter');
        // $kelasFilter = $request->input('kelas_filter');
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
                    ->with('user', 'guruMapelJadwal')
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
        
        

        // return view('jadwalSiswa.index', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran','message','namaKelas','guruPelajaran'));

        if (isset($guruPelajaran)) {
            return view('jadwalSiswa.index', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran', 'message', 'namaKelas', 'guruPelajaran'));
        } else {
            return view('jadwalSiswa.index', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran', 'message', 'namaKelas'));
        }


    }
    

    /**
     * Show the form for creating a new resource.
     */
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
