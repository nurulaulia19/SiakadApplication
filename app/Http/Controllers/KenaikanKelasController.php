<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use App\Models\KenaikanKelas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KenaikanKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataSekolah = Sekolah::all();
        $tahunAjarans = KenaikanKelas::distinct()->pluck('tahun_ajaran');
        $search = $request->input('search');
        $sekolahFilter = $request->input('sekolah_filter');
        $tahunAjaranFilter = $request->input('tahun_ajaran_filter');

        
        $dataKk = KenaikanKelas::orderBy('id_kk', 'desc')
            ->when(isset($search), function ($query) use ($search) {
                $query->where('nis_siswa', 'LIKE', '%' . $search . '%');
            })
            ->when(isset($sekolahFilter) && !empty($sekolahFilter), function ($query) use ($sekolahFilter) {
                $query->where('id_sekolah', $sekolahFilter);
            })
            ->when(isset($tahunAjaranFilter) && !empty($tahunAjaranFilter), function ($query) use ($tahunAjaranFilter) {
                $query->where('tahun_ajaran', $tahunAjaranFilter);
            })
            ->select('id_sekolah', 'id_kelas', 'tahun_ajaran', DB::raw('GROUP_CONCAT(id_kk, ", ") as id_kk'), DB::raw('GROUP_CONCAT(nis_siswa SEPARATOR ", ") as nis_siswa'))
            ->groupBy('id_sekolah', 'id_kelas', 'tahun_ajaran')
            ->paginate(10);

        

        // sidebar menu
        $user_id = auth()->user()->user_id;
        $user = DataUser::findOrFail($user_id);
        $menu_ids = $user->role->roleMenus->pluck('menu_id');

        $menu_route_name = request()->route()->getName(); // Nama route dari URL yang diminta

        // Ambil menu berdasarkan menu_link yang sesuai dengan nama route
        $requested_menu = Data_Menu::where('menu_link', $menu_route_name)->first();
        // dd($requested_menu);

        // Periksa izin akses berdasarkan menu_id dan user_id
        if (!$requested_menu || !$menu_ids->contains($requested_menu->menu_id)) {
            return redirect()->back()->with('error', 'You do not have permission to access this menu.');
        }

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


        return view('kenaikanKelas.index', compact('dataKk','menuItemsWithSubmenus','dataSekolah','tahunAjarans','sekolahFilter','tahunAjaranFilter','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataKk = KenaikanKelas::all();
        $dataSiswa = DataSiswa::all();
        $dataKelas = Kelas::all();
        $dataSekolah = Sekolah::all();
        

        
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
        return view('kenaikanKelas.create', compact('dataKk','dataSekolah','dataKelas','dataSiswa','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.'
            // Add other custom error messages as needed
        ];

        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('data_kenaikan_kelas')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('id_kelas', $request->id_kelas)
                        ->where('tahun_ajaran', $request->tahun_ajaran);
                }),
            ],
            'id_kelas' => 'required',
            'tahun_ajaran' => 'required',
            'nis_siswa' => 'required',
        ], $customMessages);
        

        $nis_siswa = $request->nis_siswa;
         // Inisialisasi string kosong

        // Looping melalui array 'nis_siswa' dan menggabungkannya menjadi satu string dengan koma sebagai pemisah
        foreach ($nis_siswa as $nis) {
            $dataKk = new KenaikanKelas();
            $dataKk->id_sekolah = $request->id_sekolah;
            $dataKk->id_kelas = $request->id_kelas;
            $dataKk->tahun_ajaran = $request->tahun_ajaran;
            $dataKk->nis_siswa = $nis;
            $dataKk->save();
        }
                return redirect()->route('kenaikanKelas.index')->with('success', 'Kenaikan Kelas insert successfully');
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
    public function edit($id_kk)
    {
        $dataKk = KenaikanKelas::where('id_kk', $id_kk)->first();

        $selectedSiswaId = KenaikanKelas::where('id_sekolah', $dataKk->id_sekolah)->where('id_kelas', $dataKk->id_kelas)->where('tahun_ajaran', $dataKk->tahun_ajaran)->pluck('nis_siswa')->toArray();

        $dataSiswa = DataSiswa::where('id_sekolah', $dataKk->id_sekolah)->get();
        
        $dataKelas = Kelas::where('id_sekolah', $dataKk->id_sekolah)->get();
        // dd($dataKelas);
        $dataSekolah = Sekolah::all();
      
        // $dataPk = PelajaranKelas::where('id_pk', $id_pk)->first();
        // $dataPelajaran = DataPelajaran::where('id_sekolah', $dataPk->id_sekolah)->get();
        // $dataKelas = Kelas::where('id_sekolah', $dataPk->id_sekolah)->get();
    
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
        return view('kenaikanKelas.update', compact('dataSekolah', 'dataSiswa', 'dataKelas', 'dataKk', 'menuItemsWithSubmenus','selectedSiswaId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_kk)
    {

        $validatedData = $request->validate([
            'nis_siswa' => 'required',
        ]);
        // Hapus data yang sesuai dengan id_kk yang diberikan
        // KenaikanKelas::where('id_kk', $id_kk)->delete();
        $dataKk = KenaikanKelas::where('id_kk', $id_kk)->first();
        KenaikanKelas::where('id_sekolah', $dataKk->id_sekolah)
            ->where('id_kelas', $dataKk->id_kelas)
            ->where('tahun_ajaran', $dataKk->tahun_ajaran)
            ->delete();
        

        // Loop melalui nis_siswa yang ada dalam permintaan
        foreach ($request->nis_siswa as $nis) {
            // Lakukan operasi INSERT pada tabel data_kenaikan_kelas
            DB::table('data_kenaikan_kelas')->insert([
                'id_sekolah' => $request->id_sekolah,
                'id_kelas' => $request->id_kelas,
                'tahun_ajaran' => $request->tahun_ajaran,
                'nis_siswa' => $nis,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->route('kenaikanKelas.index')->with('success', 'Kelas edited successfully');
    }
    



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_kk){
        $dataKk = KenaikanKelas::where('id_kk', $id_kk)->first();
    
        $selectedSiswaId = KenaikanKelas::where('id_sekolah', $dataKk->id_sekolah)
        ->where('id_kelas', $dataKk->id_kelas)
        ->where('tahun_ajaran', $dataKk->tahun_ajaran);

        $selectedSiswaId->delete();
        return redirect()->route('kenaikanKelas.index')->with('success', 'Terdelet');
    }


    public function getKelas(Request $request){
        $kelas = Kelas::where('id_sekolah', $request->sekolahID)->pluck('id_kelas', 'nama_kelas');
        return response()->json($kelas);
    }

    public function getSiswa(Request $request){
        $siswa = DataSiswa::where('id_sekolah', $request->sekolahID)->pluck('nis_siswa', 'nama_siswa');
        return response()->json($siswa);
    }

    
}
