<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jasa;
use App\Models\Cabang;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\Kategori;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\DataSiswa;
use App\Models\Transaksi;
use App\Models\DataProduk;
use App\Models\AksesCabang;
use App\Models\Verifytoken;
use App\Models\AksesSekolah;
use Illuminate\Http\Request;
use App\Models\DataPelajaran;
use App\Models\GuruPelajaran;
use App\Models\AditionalProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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

        $user_id = auth()->user()->user_id;
        $cek = AksesSekolah::where('akses_sekolah.user_id', $user_id)->first();
        $sekolahUser = AksesSekolah::where('user_id', $user_id)->get();
        
        if (empty($cek->user_id)){
            // Ambil semua sekolah
            $semuaSekolah = Sekolah::all();
            // Inisialisasi array untuk menyimpan hasil perhitungan untuk setiap sekolah
            $hasilPerhitungan = [];
            // Loop melalui setiap sekolah
            foreach ($semuaSekolah as $sekolah) {
                // Hitung jumlah mata pelajaran untuk sekolah saat ini
                $jumlahMapel = DataPelajaran::where('id_sekolah', $sekolah->id_sekolah)->count();

                // Hitung jumlah siswa untuk sekolah saat ini
                $jumlahSiswa = DataSiswa::where('id_sekolah', $sekolah->id_sekolah)->count();

                // Hitung jumlah guru untuk sekolah saat ini
                $jumlahGuru = GuruPelajaran::join('data_user', 'data_guru_pelajaran.user_id', '=', 'data_user.user_id')
                    ->where('data_user.role_id', 2)
                    ->where('data_guru_pelajaran.id_sekolah', $sekolah->id_sekolah)
                    ->distinct('data_guru_pelajaran.user_id')
                    ->count();

                // Simpan hasil perhitungan ke dalam array
                $hasilPerhitungan[] = [
                    'sekolah' => $sekolah->nama_sekolah, // Ganti dengan nama kolom yang sesuai
                    'jumlahMapel' => $jumlahMapel,
                    'jumlahSiswa' => $jumlahSiswa,
                    'jumlahGuru' => $jumlahGuru,
                ];
            }
            // dd($hasilPerhitungan);

        } else {
            $hasilPerhitungan = [];

            // Loop melalui setiap sekolah
            foreach ($sekolahUser as $aksesSekolah) {
                // Ambil data sekolah
                $sekolah = Sekolah::find($aksesSekolah->id_sekolah);

                // Hitung jumlah mata pelajaran untuk sekolah saat ini
                $jumlahMapel = DataPelajaran::where('id_sekolah', $sekolah->id_sekolah)->count();

                // Hitung jumlah siswa untuk sekolah saat ini
                $jumlahSiswa = DataSiswa::where('id_sekolah', $sekolah->id_sekolah)->count();

                // Hitung jumlah guru untuk sekolah saat ini
                $jumlahGuru = GuruPelajaran::join('data_user', 'data_guru_pelajaran.user_id', '=', 'data_user.user_id')
                    ->where('data_user.role_id', 2)
                    ->where('data_guru_pelajaran.id_sekolah', $sekolah->id_sekolah)
                    ->distinct('data_guru_pelajaran.user_id')
                    ->count();

                // Simpan hasil perhitungan ke dalam array
                $hasilPerhitungan[] = [
                    'sekolah' => $sekolah->nama_sekolah, // Ganti dengan nama kolom yang sesuai
                    'jumlahMapel' => $jumlahMapel,
                    'jumlahSiswa' => $jumlahSiswa,
                    'jumlahGuru' => $jumlahGuru,
                ];
            }
            // dd($hasilPerhitungan);
        }

        // Menggunakan Eloquent untuk mengambil data pelajaran yang berhubungan dengan sekolah yang terkait dengan pengguna
        // $dataPelajaran = DataPelajaran::join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_pelajaran.id_sekolah')
        //     ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_pelajaran.id_sekolah')
        //     ->where('akses_sekolah.user_id', $user_id)
        //     ->get();

        // // Menghitung jumlah mata pelajaran
        // $jumlahMapel = $dataPelajaran->count();  // Menggunakan metode count() untuk Eloquent Collection

        // $dataSiswa = DataSiswa::join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_siswa.id_sekolah')
        //     ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_siswa.id_sekolah')
        //     ->where('akses_sekolah.user_id', $user_id)
        //     ->get();

        // // Menghitung jumlah siswa
        // $jumlahSiswa = $dataSiswa->count();

        // // menghitung jumlah guru
        // $jumlahGuru = GuruPelajaran::join('data_user', 'data_guru_pelajaran.user_id', '=', 'data_user.user_id')
        //     ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_guru_pelajaran.id_sekolah')
        //     ->where('data_user.role_id', 2)
        //     ->where('akses_sekolah.user_id', $user_id)
        //     ->distinct('data_guru_pelajaran.user_id') // Menjamin setiap guru hanya dihitung sekali
        //     ->count();
    
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

        return view('home.index', compact('menuItemsWithSubmenus','hasilPerhitungan'));
    

    //     $get_user = User::where('email',auth()->user()->email)->first();
    //     if($get_user->is_activated == 1){
    //         return view('home');
    //     }else{
    //         return redirect('/verify-account');
    //     }
        
    // }

    // public function verifyaccount(){
    //     return view('opt_verification');
    }

    // public function useractivation(Request $request){
    //     $get_token = $request->token;
    //     $get_token = Verifytoken::where('token',$get_token)->first();

    //     if($get_token){
    //         $get_token->is_activated = 1;
    //         $get_token->save();
    //         $user = User::where('email',$get_token->email)->first();
    //         $user->is_activated = 1;
    //         $user->save();
    //         $getting_token = Verifytoken::where('token',$get_token->token)->first();
    //         // $getting_token->delete();
    //         return redirect('/home')->with('activated','Your Account has been activated successfully');
    //     } else{
    //         return redirect('/verify-account')->with('incorrect','Your OTP is invalid please check your email once');
    //     }
    // }

    // public function showSidebar()
    // {
    //     $dataMenu = Data_Menu::with('submenus')->get();
    //     return view('layouts.sidebar2', compact('dataMenu'));
    // }
    
}
