<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use Illuminate\Http\Request;
use App\Models\DataKuisioner;
use App\Models\GuruPelajaran;
use App\Models\JawabanKuisioner;

class KuisionerGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function laporanKuisionerGuru(Request $request) {
        $user = auth()->user();
        $user_id = $user->user_id;

        $dataGp = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal')
            ->where('data_guru_pelajaran.user_id', $user_id);

        if ($request->has('sekolah') && $request->sekolah) {
            $dataGp->where('data_sekolah.id_sekolah', $request->sekolah);
        }

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $dataGp->where('data_guru_pelajaran.tahun_ajaran', $request->tahun_ajaran);
        }

        $dataGp = $dataGp->orderBy('data_guru_pelajaran.id_gp', 'DESC')->paginate(10);

        $listSekolah = GuruPelajaran::where('user_id', $user_id)
            ->join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->pluck('data_sekolah.nama_sekolah', 'data_sekolah.id_sekolah')
            ->all();
        

        $listTahunAjaran = GuruPelajaran::where('user_id', $user_id)
        ->pluck('tahun_ajaran')
        ->unique()
        ->values()
        ->all();
        // dd($listTahunAjaran);

        $sekolahFilter = $request->input('sekolah');
        $tahunFilter = $request->input('tahun_ajaran');
        $id_kn = $request->input('id_kn');


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
        return view('kuisionerGuru.laporan', compact('dataGp','listSekolah','listTahunAjaran','sekolahFilter','tahunFilter','menuItemsWithSubmenus','id_kn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detailLaporanKuisionerGuru($id_gp)
    {
        $user = auth()->user();
        // if (!$user->canAccessGp($id_gp)) {
        //     return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses data ini.');
        // }
        $user_id = $user->user_id;
        $dataGp = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal','siswa')
            ->where('data_guru_pelajaran.user_id', $user_id)->where('id_gp', $id_gp)
            ->orderBy('data_guru_pelajaran.id_gp', 'DESC')
            ->get();

            if (!$dataGp) {
                // Jika ID GP tidak sesuai, Anda dapat mengarahkan pengguna kembali ke halaman sebelumnya dengan pesan kesalahan
                return redirect()->back()->with('error', 'Data Guru Pelajaran tidak ditemukan.');
            }
         
            $id_gp = request('id_gp');
            $dataKuisioner = DataKuisioner::whereIn('id_sekolah', function ($query) use ($id_gp) {
                $query->select('id_sekolah')
                    ->from('data_guru_pelajaran')
                    ->where('id_gp', $id_gp);
            })->with('kategoriKuisioner')->get();

            $groupedQuestions = [];
            foreach ($dataKuisioner as $item) {
                $kategori = $item->kategoriKuisioner->nama_kategori; // Sesuaikan dengan nama kolom yang sesuai
                $groupedQuestions[$kategori][] = $item;
            }

            $jawabanSiswa = JawabanKuisioner::whereIn('id_kuisioner', $dataKuisioner->pluck('id_kuisioner'))
                ->where('id_gp', $id_gp)
                ->get();

            $perhitungan = [];

            foreach ($dataKuisioner as $item) {
                $idKuisioner = $item->id_kuisioner;

                // Hitung jumlah jawaban untuk setiap kategori
                $sangatBaikCount = $jawabanSiswa->where('id_kuisioner', $idKuisioner)->where('jawaban', 'sangatbaik')->count();
                $baikCount = $jawabanSiswa->where('id_kuisioner', $idKuisioner)->where('jawaban', 'baik')->count();
                $cukupBaikCount = $jawabanSiswa->where('id_kuisioner', $idKuisioner)->where('jawaban', 'cukupbaik')->count();
                $kurangBaikCount = $jawabanSiswa->where('id_kuisioner', $idKuisioner)->where('jawaban', 'kurangbaik')->count();

                $perhitungan[$idKuisioner] = [
                    'sangatbaik' => $sangatBaikCount,
                    'baik' => $baikCount,
                    'cukupbaik' => $cukupBaikCount,
                    'kurangbaik' => $kurangBaikCount,
                ];
            }
            // dd($perhitungan);
            // menu
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
        return view('kuisionerGuru.detail', compact('dataGp', 'id_gp', 'dataKuisioner', 'groupedQuestions', 'menuItemsWithSubmenus','perhitungan'));
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
