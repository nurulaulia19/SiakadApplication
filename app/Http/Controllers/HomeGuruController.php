<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jasa;
use App\Models\Cabang;
use App\Models\DataUser;
use App\Models\Kategori;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\Transaksi;
use App\Models\DataProduk;
use App\Models\AksesCabang;
use App\Models\Verifytoken;
use Illuminate\Http\Request;
use App\Models\GuruPelajaran;
use App\Models\KenaikanKelas;
use App\Models\AditionalProduk;
use Illuminate\Support\Facades\DB;
use App\Models\GuruPelajaranJadwal;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class HomeGuruController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // jumlah mata pelajaran
        $user_id = auth()->user()->user_id;

        $waktuSekarang = now(); // Mendapatkan waktu sekarang
        $tahunAjaranTerbaru = GuruPelajaran::where('user_id', $user_id)
            ->where('tahun_ajaran', '<=', $waktuSekarang) // Filter tahun ajaran yang lebih kecil atau sama dengan waktu sekarang
            ->orderBy('tahun_ajaran', 'desc') // Urutkan tahun ajaran dalam urutan menurun
            ->value('tahun_ajaran');

        $dataMapel = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal')
            ->where('data_guru_pelajaran.user_id', $user_id)
            ->where('tahun_ajaran', $tahunAjaranTerbaru);

        // Menghitung jumlah mata pelajaran
        $jumlahMapel = $dataMapel->count();
        // $jumlahSiswa = KenaikanKelas::where('tahun_ajaran', $tahunAjaranTerbaru)->count();

        // jumlah siswa
        // Mengambil data Guru Pelajaran berdasarkan user_id
        $dataGp = GuruPelajaran::where('user_id', $user_id)->get();

        // Inisialisasi variabel jumlah siswa
        $jumlahSiswa = 0;

        foreach ($dataGp as $guruPelajaran) {
            // Ambil ID guru pelajaran atau informasi lain yang dapat menghubungkan
            $id_kelas = $guruPelajaran->id_kelas;
            
            // // Ambil tahun ajaran dari data Guru Pelajaran
            // $tahunAjaran = $guruPelajaran->tahun_ajaran;

            // Ambil data Kenaikan Kelas berdasarkan ID guru pelajaran dan tahun ajaran
            $dataKk = KenaikanKelas::where('id_kelas', $id_kelas)
                ->where('tahun_ajaran', $tahunAjaranTerbaru)
                ->get();

            // Hitung jumlah siswa dari data Kenaikan Kelas
            $jumlahSiswa += $dataKk->count();
        }

        $dataJadwal = GuruPelajaranJadwal::all(); // Isi dengan data jadwal dari database
        // $gpData = GuruPelajaran::all();
        // Misalkan Anda menggunakan Laravel Eloquent
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

        // $hariIni = 'senin';
        
        $gpData = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
        ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
        ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal')
        ->where('data_guru_pelajaran.user_id', $user_id)
        ->whereHas('guruMapelJadwal', function ($query) use ($hariIni) {
            $query->where('hari', $hariIni);
        })->get();

        // dd($gpData);
         // MENU
         $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'

         $user = DataUser::find($user_id);
         $role_id = $user->role_id;

         $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');

         $mainMenus = Data_Menu::where('menu_category', 'master menu')
             ->whereIn('menu_id', $menu_ids)
             ->get();

         $menuItemsWithSubmenus = [];

         foreach ($mainMenus as $mainMenu) {
             $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                 ->where('menu_category', 'sub menu')
                 ->whereIn('menu_id', $menu_ids)
                 ->orderBy('menu_position')
                 ->get();

             $menuItemsWithSubmenus[] = [
                 'mainMenu' => $mainMenu,
                 'subMenus' => $subMenus,
             ];
         }

        return view('homeGuru.index', compact('menuItemsWithSubmenus','jumlahMapel','jumlahSiswa','dataJadwal','gpData','hariIni'));
    }

}
