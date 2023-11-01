<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use Illuminate\Http\Request;
use App\Models\GuruPelajaran;

class JadwalGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->user_id;

        // Ambil semua data guru pelajaran berdasarkan user_id
        // $dataGp = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
        //     ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
        //     ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal')
        //     ->where('data_guru_pelajaran.user_id', $user_id)
        //     ->orderBy('data_guru_pelajaran.id_gp', 'DESC')
        //     ->paginate(10);

        $query = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
        ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
        ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal')
        ->where('data_guru_pelajaran.user_id', $user_id);

        // Filter berdasarkan id_pelajaran jika diberikan
        if ($request->has('tahun_ajaran_filter')) {
            $idPelajaranFilter = $request->input('tahun_ajaran_filter');
            $query->where('data_guru_pelajaran.tahun_ajaran', $idPelajaranFilter);
        }

        // Filter berdasarkan id_sekolah jika diberikan
        if ($request->has('id_sekolah_filter')) {
            $idSekolahFilter = $request->input('id_sekolah_filter');
            $query->where('data_sekolah.id_sekolah', $idSekolahFilter);
        }

        // Lakukan query dengan filter
        $dataGp = $query->orderBy('data_guru_pelajaran.id_gp', 'DESC')->paginate(10);

        // Ambil id_pelajaran dari data guru pelajaran
        $idPelajaran = $dataGp->pluck('id_pelajaran');
        $idSekolah = $dataGp->pluck('id_sekolah');

        // Gunakan id_sekolah untuk mengambil dataSekolah
        $dataSekolah = Sekolah::whereIn('id_sekolah', $idSekolah)
            ->distinct()
            ->get();

        $tahunAjarans = GuruPelajaran::whereIn('id_pelajaran', $idPelajaran)
            ->distinct()
            ->pluck('tahun_ajaran');
        $sekolahFilter = $request->input('id_sekolah_filter');
        $tahunAjaranFilter = $request->input('tahun_ajaran_filter');


        



         // Menu
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

    return view('jadwalGuru.index', compact('dataGp', 'dataSekolah', 'tahunAjarans', 'sekolahFilter', 'tahunAjaranFilter', 'menuItemsWithSubmenus'));
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
