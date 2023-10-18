<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Models\DataPelajaran;
use App\Models\GuruPelajaran;
use App\Models\PelajaranKelas;

class JadwalSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $siswa = auth()->guard('siswa')->user();
        // $namaSekolah = $siswa->id_sekolah;
        // $dataSekolah = Sekolah::where('id_sekolah', $namaSekolah)->first();
        // $pelajaran = DataPelajaran::where('id_sekolah', $dataSekolah->id_sekolah)->get();
        // // dd($pelajaran);
    
        // // Menerapkan filter tahun ajaran jika dipilih
        // $tahunAjaranFilter = $request->input('tahun_ajaran_filter');
        // $tahunAjarans = [];
    
        // // Membuat daftar tahun ajaran dari 2020 hingga tahun saat ini
        // $tahunSekarang = date('Y');
        // for ($tahun = 2020; $tahun <= $tahunSekarang; $tahun++) {
        //     $tahunAjaran = $tahun;
        //     $tahunAjarans[$tahunAjaran] = $tahunAjaran;
        // }
    
        // // Mengambil data kelas yang sesuai atau filter berdasarkan kelas
        // $kelasFilter = $request->input('kelas_filter');
        // $kelas = Kelas::where('id_sekolah', $dataSekolah->id_sekolah);
    
        // if ($kelasFilter) {
        //     $kelas = $kelas->where('id_sekolah', $kelasFilter);
        // }
    
        // $kelas = $kelas->get();
    
        // return view('jadwalSiswa.index', compact('tahunAjarans', 'kelas', 'tahunAjaranFilter', 'kelasFilter','pelajaran'));

        $siswa = auth()->guard('siswa')->user();
        $namaSekolah = $siswa->id_sekolah;
        $dataSekolah = Sekolah::where('id_sekolah', $namaSekolah)->first();
        $pelajaran = DataPelajaran::where('id_sekolah', $dataSekolah->id_sekolah)->get();
        
        // Mengambil data guru pelajaran yang sesuai dengan sekolah
        $guruPelajaran = GuruPelajaran::where('id_sekolah', $dataSekolah->id_sekolah)
            ->get();
        
        // Menerapkan filter tahun ajaran jika dipilih
        $tahunAjaranFilter = $request->input('tahun_ajaran_filter');
        $tahunAjarans = [];
    
        // Mengambil data tahun ajaran yang sesuai dengan guru pelajaran
        foreach ($guruPelajaran as $guruMapel) {
            // Mengambil tahun ajaran berdasarkan relasi guru pelajaran
            $tahunAjaran = $guruMapel->tahun_ajaran;
            if (!in_array($tahunAjaran, $tahunAjarans)) {
                $tahunAjarans[] = $tahunAjaran;
            }
        }

        $kelasFilter = $request->input('kelas_filter');
        $kelas = collect(); // Menggunakan collect() untuk membuat koleksi kosong

        // Mengambil data kelas yang diajar oleh guru
        foreach ($guruPelajaran as $guruMapel) {
            // Mengambil kelas berdasarkan relasi guru pelajaran
            $kelasGuru = $guruMapel->kelas;
            
            // Memeriksa apakah kelas tersebut telah ditambahkan ke koleksi
            // Jika belum, tambahkan ke koleksi
            if ($kelasGuru && !$kelas->contains('id', $kelasGuru->id)) {
                $kelas->push($kelasGuru);
            }
        }

        return view('jadwalSiswa.index', compact('tahunAjarans', 'kelas', 'tahunAjaranFilter', 'kelasFilter','pelajaran'));

        // $siswa = auth()->guard('siswa')->user();
        // $namaSekolah = $siswa->id_sekolah;
        // $dataSekolah = Sekolah::where('id_sekolah', $namaSekolah)->first();
        // $pelajaran = DataPelajaran::where('id_sekolah', $dataSekolah->id_sekolah)->get();

        // // Mengambil data pelajaran kelas yang sesuai dengan sekolah tertentu
        // $pelajaranKelas = PelajaranKelas::where('id_sekolah', $namaSekolah)->get();

        // $tahunAjarans = [];
        // $kelas = collect(); // Menggunakan collect() untuk membuat koleksi kosong

        // // Mengisi filter tahun ajaran dan kelas berdasarkan data pelajaran kelas
        // foreach ($pelajaranKelas as $pelajaranKelas) {
        //     // Ambil tahun ajaran dari data pelajaran kelas
        //     $tahunAjaran = $pelajaranKelas->tahun_ajaran;

        //     // Jika tahun ajaran belum ada dalam daftar tahun ajaran, tambahkan
        //     if (!in_array($tahunAjaran, $tahunAjarans)) {
        //         $tahunAjarans[] = $tahunAjaran;
        //     }

        //     // Ambil kelas yang sesuai dengan pelajaran kelas
        //     $kelasPelajaran = Kelas::where('id_sekolah', $pelajaranKelas->id_sekolah)->get();

        //     // Tambahkan kelas ke koleksi
        //     $kelas = $kelas->concat($kelasPelajaran);
        // }

        // // Hilangkan duplikasi tahun ajaran dan kelas
        // $tahunAjarans = array_unique($tahunAjarans);
        // $kelas = $kelas->unique('id_kelas');

        // $siswa = auth()->guard('siswa')->user();
        // $namaSekolah = $siswa->id_sekolah;
        // $dataSekolah = Sekolah::where('id_sekolah', $namaSekolah)->first();
        // $pelajaran = DataPelajaran::where('id_sekolah', $dataSekolah->id_sekolah)->get();
        // // dd($pelajaran);

        // // Mengambil data pelajaran kelas yang sesuai dengan sekolah tertentu
        // $pelajaranKelas = PelajaranKelas::where('id_sekolah', $namaSekolah)->get();

        // $tahunAjarans = [];
        // $kelas = collect(); // Menggunakan collect() untuk membuat koleksi kosong

        // // Mengisi filter tahun ajaran dan kelas berdasarkan data pelajaran kelas
        // foreach ($pelajaranKelas as $pelajaranKelas) {
        //     // Ambil tahun ajaran dari data pelajaran kelas
        //     $tahunAjaran = $pelajaranKelas->tahun_ajaran;

        //     // Jika tahun ajaran belum ada dalam daftar tahun ajaran, tambahkan
        //     if (!in_array($tahunAjaran, $tahunAjarans)) {
        //         $tahunAjarans[] = $tahunAjaran;
        //     }

        //     // Ambil kelas yang sesuai dengan pelajaran kelas
        //     $kelasPelajaran = Kelas::where('id_kelas', $pelajaranKelas->id_kelas)->get();

        //     // Tambahkan kelas ke koleksi
        //     $kelas = $kelas->concat($kelasPelajaran);
        // }

        // // Hilangkan duplikasi tahun ajaran dan kelas
        // $tahunAjarans = array_unique($tahunAjarans);
        // $kelas = $kelas->unique('id_kelas');


        // return view('jadwalSiswa.index', compact('tahunAjarans', 'kelas','dataSekolah','pelajaran'));


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
