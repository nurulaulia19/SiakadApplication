<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\DataNilai;
use Illuminate\Http\Request;
use App\Models\GuruPelajaran;
use App\Models\KategoriNilai;
use App\Models\KenaikanKelas;

class NilaiGuruController extends Controller
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

    // return view('jadwalGuru.index', compact('dataGp', 'dataSekolah', 'tahunAjarans', 'sekolahFilter', 'tahunAjaranFilter', 'menuItemsWithSubmenus'));
        return view('nilaiGuru.index', compact('dataGp','listSekolah','listTahunAjaran','sekolahFilter','tahunFilter','menuItemsWithSubmenus','id_kn'));
    }


    public function detail(Request $request, $id_gp) {
        // $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel')->orderBy('id_gp', 'DESC')->paginate(10);
        $user = auth()->user();
        $user_id = $user->user_id;
        $dataGp = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal','siswa')
            ->where('data_guru_pelajaran.user_id', $user_id)->where('id_gp', $id_gp)
            ->orderBy('data_guru_pelajaran.id_gp', 'DESC')
            ->first();

            if (!$dataGp) {
                // Jika ID GP tidak sesuai, Anda dapat mengarahkan pengguna kembali ke halaman sebelumnya dengan pesan kesalahan
                return redirect()->back()->with('error', 'Data Guru Pelajaran tidak ditemukan.');
            }
            
            
        
        $dataKn = KategoriNilai::all();
        $tab = $request->query('tab');
        $dataSekolah = Sekolah::all();
        $id_kn = session('id_kn');
       

        if ($dataGp->count() > 0) {
            // Mengambil objek GuruPelajaran pertama dari koleksi
            $guruPelajaran = $dataGp;
        
            // Mengakses properti tahun_ajaran dari objek GuruPelajaran
            $tahunAjaran = $guruPelajaran->tahun_ajaran;
        
            // 3. Gunakan tahun ajaran sebagai filter dalam query
            $dataKk = KenaikanKelas::join('data_guru_pelajaran', 'data_kenaikan_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
                ->where('data_guru_pelajaran.id_gp', $id_gp)
                ->where('data_kenaikan_kelas.tahun_ajaran', '=', $tahunAjaran)
                ->orderBy('data_kenaikan_kelas.id_kk', 'desc')
                ->select(
                    'data_kenaikan_kelas.id_kk', // Kolom id_kk
                    'data_kenaikan_kelas.nis_siswa', // Kolom nis_siswa
                )
                ->with('siswa') 
                ->paginate(10);

        } else {
            // Handle jika data GuruPelajaran tidak ditemukan
            session()->flash('warning', 'Data Guru Pelajaran tidak ditemukan.');
            return redirect()->back();
        }
        

        
        // dd($id_gp);
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

        return view('nilaiGuru.detail', compact('dataGp','menuItemsWithSubmenus','dataKn','dataKk','tab','id_gp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function storeNilaiGuru(Request $request)
    {
        $nis_siswa = $request->input('nis_siswa');
        $nilai = $request->input('nilai');
        $id_gp = $request->input('id_gp');
        $kategori = $request->input('kategori');

        // Hapus data yang sudah ada dengan kriteria yang sama
        DataNilai::where('id_gp', $id_gp)
            ->where('kategori', $kategori)
            ->whereIn('nis_siswa', $nis_siswa)
            ->delete();

        // Simpan data baru
        foreach ($nis_siswa as $key => $nis) {
            $dataNilai = new DataNilai;
            $dataNilai->id_gp = $id_gp;
            $dataNilai->kategori = $kategori;
            $dataNilai->nis_siswa = $nis;
            $dataNilai->nilai = $nilai[$key];
            $dataNilai->save();
        }

        return redirect()->route('nilaiGuru.detail', ['id_gp' => $id_gp, 'tab'=> $kategori
        ])->with('success', 'Nilai insert successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public static function getNilaiGuru ($id_gp, $kategori, $nis_siswa) {
        // $id_nilai = 13;
        $dataNilai = DataNilai::where('id_gp', $id_gp)
        ->where('kategori', $kategori)
        ->where('nis_siswa', $nis_siswa)->first();

        return @$dataNilai->nilai;
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
