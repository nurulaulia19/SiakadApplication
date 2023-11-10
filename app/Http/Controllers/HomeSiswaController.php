<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\DataNilai;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use App\Models\DataPelajaran;
use App\Models\GuruPelajaran;
use App\Models\KategoriNilai;
use App\Models\KenaikanKelas;
use App\Models\PelajaranKelas;
use App\Models\GuruPelajaranJadwal;

class HomeSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('auth:siswa');
    }


    public function index()
    {
        // $id_siswa = auth()->user()->id_siswa; // Menggunakan 'id_siswa' sebagai pengganti 'user_id'
        // // dd($id_siswa);

        // $user = DataSiswa::find($id_siswa); // Menggunakan model 'DataSiswa' untuk mengambil data siswa
        
        // // Lanjutkan dengan mengakses role_id dan lainnya sesuai kebutuhan
        // $role_id = $user->role_id;
        
        // $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');
        
        // $mainMenus = Data_Menu::where('menu_category', 'master menu')
        //     ->whereIn('menu_id', $menu_ids)
        //     ->get();
        
        // $menuItemsWithSubmenus = [];
        
        // foreach ($mainMenus as $mainMenu) {
        //     $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
        //         ->where('menu_category', 'sub menu')
        //         ->whereIn('menu_id', $menu_ids)
        //         ->orderBy('menu_position')
        //         ->get();
        
        //     $menuItemsWithSubmenus[] = [
        //         'mainMenu' => $mainMenu,
        //         'subMenus' => $subMenus,
        //     ];
        // }
        
        // Lanjutkan dengan logika Anda sesuai kebutuhan
        

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

            // $tahunAjaran = $kenaikanKelas ? $kenaikanKelas->tahun_ajaran : null;
        
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
                    $totalMataPelajaran = count($pelajaranData);
        
                    // Langkah 3: Dapatkan data pelajaran yang sesuai dengan id_pelajaran
                    $pelajaran = DataPelajaran::whereIn('id_pelajaran', $pelajaranData)->get();
                    // dd($pelajaran);
                    $guruPelajaran = GuruPelajaran::whereIn('id_pelajaran', $pelajaranData)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->with('user', 'nilai')
                    ->get();
                    
                    $nilaiSiswa = $guruPelajaran->pluck('nilai')->flatten();
                    // dd($nilaiSiswa);
                    // Menghitung total nilai
                    $totalNilai = 0;
                    $jumlahNilai = 0;

                    // Iterasi melalui GuruPelajaran dan nilai-nilai
                    foreach ($guruPelajaran as $guru) {
                        foreach ($guru->nilai as $nilai) {
                            $totalNilai += $nilai->nilai;
                            $jumlahNilai++;
                        }
                    }

                    // Menghitung nilai rata-rata
                    if ($jumlahNilai > 0) {
                        $totalNilaiRata = $totalNilai / $jumlahNilai;
                    } else {
                        $totalNilaiRata = 0; // Menghindari pembagian oleh nol
                    };

                    // dd($rataRata);
                    $dataJadwal = GuruPelajaranJadwal::all(); // Isi dengan data jadwal dari database
                    $namaHariInggris = date('l'); // Mendapatkan nama hari dalam bahasa Inggris

                    // Membuat pemetaan dari nama hari Inggris ke nama hari dalam bahasa Indonesia
                    $mapHari = [
                        'Monday' => 'senin',
                        'Tuesday' => 'selasa',
                        'Wednesday' => 'rabu',
                        'Thursday' => 'kamis',
                        'Friday' => 'jumat',
                        'Saturday' => 'sabtu',
                        'Sunday' => 'minggu',
                    ];

                    $hariIni = $mapHari[$namaHariInggris];

                    // $hariIni = 'kamis';
                    
                    // $gpData = GuruPelajaran::whereHas('guruMapelJadwal', function ($query) use ($hariIni) {
                    //     $query->where('hari', $hariIni);
                    // })->get();

                    $gpData =  GuruPelajaran::whereIn('id_pelajaran', $pelajaranData)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->with('user', 'siswa')
                    ->whereHas('guruMapelJadwal', function ($query) use ($hariIni) {
                        $query->where('hari', $hariIni);
                    })->get();
                    
                    // belum berdasarkan th ajaran
                    // $dataNilai = [];
                    // $nisSiswa = $siswa->nis_siswa; // Ambil NIS siswa yang login
                    // $kategoriData = [];

                    // foreach ($guruPelajaran as $guruMapel) {
                    //     foreach ($guruMapel->nilai as $nilai) {
                    //         // Filter data nilai berdasarkan NIS siswa yang login
                    //         if ($nilai->nis_siswa == $nisSiswa) {
                    //             // Mengakses nama_kategori melalui relasi
                    //             $kategori = $nilai->kategoriNilai;

                    //             if ($kategori) {
                    //                 $kategoriId = $kategori->id_kn;

                    //                 // Mengecek apakah sudah ada data untuk kategori ini
                    //                 if (isset($kategoriData[$kategoriId])) {
                    //                     $kategoriData[$kategoriId]['nilai'][] = $nilai->nilai;
                    //                 } else {
                    //                     $kategoriData[$kategoriId] = [
                    //                         'label' => $kategori->kategori,
                    //                         'nilai' => [$nilai->nilai],
                    //                     ];
                    //                 }
                    //             }
                    //         }
                    //     }
                    // }

                    // // Hitung rata-rata untuk setiap kategori
                    // foreach ($kategoriData as $kategoriId => $kategoriInfo) {
                    //     $totalNilai = array_sum($kategoriInfo['nilai']);
                    //     $jumlahNilai = count($kategoriInfo['nilai']);
                    //     $rataRata = $jumlahNilai > 0 ? $totalNilai / $jumlahNilai : 0;

                    //     $dataNilai[] = [
                    //         'label' => $kategoriInfo['label'],
                    //         'value' => $rataRata,
                    //     ];
                    // }

                    // sudah berdasarkan th ajaran
                    $dataNilai = [];
                    $nisSiswa = $siswa->nis_siswa; // Ambil NIS siswa yang login
                    $kategoriData = [];
                    $tahunAjaranSaatIni = now()->format('Y'); // Menggunakan tahun ajaran saat ini
                    
                    foreach ($guruPelajaran as $guruMapel) {
                        foreach ($guruMapel->nilai as $nilai) {
                            // Filter data nilai berdasarkan NIS siswa yang login dan tahun ajaran siswa
                            if ($nilai->nis_siswa == $nisSiswa) {
                                // Mendapatkan data kenaikan kelas untuk siswa
                                $kenaikanKelas = KenaikanKelas::where('nis_siswa', $nisSiswa)->first();
                                $tahunAjaranSiswa = $kenaikanKelas ? $kenaikanKelas->tahun_ajaran : null;
                    
                                // Membandingkan tahun ajaran siswa dengan tahun ajaran saat ini
                                if ($tahunAjaranSiswa && $tahunAjaranSiswa == $tahunAjaranSaatIni) {
                                    // Mengakses nama_kategori melalui relasi
                                    $kategori = $nilai->kategoriNilai;
                    
                                    if ($kategori) {
                                        $kategoriId = $kategori->id_kn;
                    
                                        // Mengecek apakah sudah ada data untuk kategori ini
                                        if (isset($kategoriData[$kategoriId])) {
                                            $kategoriData[$kategoriId]['nilai'][] = $nilai->nilai;
                                        } else {
                                            $kategoriData[$kategoriId] = [
                                                'label' => $kategori->kategori,
                                                'nilai' => [$nilai->nilai],
                                            ];
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    // Hitung rata-rata untuk setiap kategori
                    foreach ($kategoriData as $kategoriId => $kategoriInfo) {
                        $totalNilai = array_sum($kategoriInfo['nilai']);
                        $jumlahNilai = count($kategoriInfo['nilai']);
                        $rataRata = $jumlahNilai > 0 ? $totalNilai / $jumlahNilai : 0;
                    
                        $dataNilai[] = [
                            'label' => $kategoriInfo['label'],
                            'value' => $rataRata,
                        ];
                    }
                    
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

        $namaHariInggris = date('l'); // Mendapatkan nama hari dalam bahasa Inggris

        // Membuat pemetaan dari nama hari Inggris ke nama hari dalam bahasa Indonesia
        $mapHari = [
            'Monday' => 'senin',
            'Tuesday' => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday' => 'kamis',
            'Friday' => 'jumat',
            'Saturday' => 'sabtu',
            'Sunday' => 'minggu',
        ];

        $hariIni = $mapHari[$namaHariInggris];

        if (isset($guruPelajaran)) {
            return view('homeSiswa.index', compact('siswa', 'totalMataPelajaran', 'totalNilaiRata', 'dataJadwal', 'gpData', 'hariIni','dataNilai','tahunAjaranSaatIni'));
        } else {
            return view('homeSiswa.index', compact('siswa','hariIni'));
        }
        // return view('homeSiswa.index', compact('siswa', 'totalMataPelajaran', 'totalNilaiRata'));
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
