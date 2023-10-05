<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\DataNilai;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use App\Models\GuruPelajaran;
use App\Models\KenaikanKelas;

class DataNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function cekNilai()
    {
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','kategoriNilai')->get();
        $dataNilai = DataNilai::with('siswa', 'sekolah', 'mapel')->get();
        $dataSiswa = DataSiswa::all();
        $dataSekolah = Sekolah::all();

        if ($dataGp->count() > 0) {
            // Mengambil objek GuruPelajaran pertama dari koleksi
            $guruPelajaran = $dataGp;
        
            // Mengakses properti tahun_ajaran dari objek GuruPelajaran
            // $tahunAjaran = $guruPelajaran->tahun_ajaran;
        
            // 3. Gunakan tahun ajaran sebagai filter dalam query
            $dataKk = KenaikanKelas::join('data_guru_pelajaran', 'data_kenaikan_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
                // ->where('data_guru_pelajaran.id_gp', $id_gp)
                // ->where('data_kenaikan_kelas.tahun_ajaran', '=', $tahunAjaran)
                ->orderBy('data_kenaikan_kelas.id_kk', 'desc')
                ->select(
                    // 'data_kenaikan_kelas.id_sekolah',
                    // 'data_kenaikan_kelas.id_kelas',
                    // 'data_kenaikan_kelas.tahun_ajaran',
                    'data_kenaikan_kelas.id_kk', // Kolom id_kk
                    'data_kenaikan_kelas.nis_siswa', // Kolom nis_siswa
                )
                ->with('siswa') 
                ->get();
        } else {
            // Handle jika data GuruPelajaran tidak ditemukan
            session()->flash('warning', 'Data Guru Pelajaran tidak ditemukan.');
            return redirect()->back();
        }

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
        return view('dataNilai.cekNilai', compact('dataKk','dataNilai','dataSekolah','dataSiswa','dataGp','menuItemsWithSubmenus'));
    }
}
