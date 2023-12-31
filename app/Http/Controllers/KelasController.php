<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\AksesSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // $dataKelas = Kelas::with('sekolah')->orderBy('id_kelas', 'DESC')->paginate(10);

        // Mendapatkan ID pengguna yang sedang login
        $user_id = auth()->user()->user_id; 
        $cek = AksesSekolah::where('akses_sekolah.user_id', $user_id)->first();
        
        // if (empty($cek->user_id)){
        //     // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
        //     $dataKelas = Kelas::with('sekolah')->orderBy('id_kelas', 'DESC')->paginate(10);
        // } else {
        //     // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
        //     $dataKelas = Kelas::join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
        //     ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
        //     ->where('akses_sekolah.user_id', $user_id)
        //     ->orderBy('data_kelas.id_kelas', 'DESC')
        //     ->paginate(10);
        // }

        $filterSekolah = $request->input('sekolah');
        $searchNamaKelas = $request->input('search_nama_kelas');
        $user_id = auth()->user()->user_id;

        $query = Kelas::query();

        if (empty($cek->user_id)) {
            $dataKelas = $query->with('sekolah')
                ->when(!empty($filterSekolah), function ($query) use ($filterSekolah) {
                    $query->where('id_sekolah', $filterSekolah);
                })
                ->when(!empty($searchNamaKelas), function ($query) use ($searchNamaKelas) {
                    $query->where('nama_kelas', 'like', '%' . $searchNamaKelas . '%');
                })
                ->orderBy('id_kelas', 'DESC')
                ->paginate(10);

            $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');
        } else {
            $dataKelas = $query->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
                ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
                ->where('akses_sekolah.user_id', $user_id)
                ->when(!empty($filterSekolah), function ($query) use ($filterSekolah) {
                    $query->where('data_kelas.id_sekolah', $filterSekolah);
                })
                ->when(!empty($searchNamaKelas), function ($query) use ($searchNamaKelas) {
                    $query->where('nama_kelas', 'like', '%' . $searchNamaKelas . '%');
                })
                ->orderBy('data_kelas.id_kelas', 'DESC')
                ->paginate(10);

            $sekolahOptions = Sekolah::join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_sekolah.id_sekolah')
                ->where('akses_sekolah.user_id', $user_id)
                ->pluck('data_sekolah.nama_sekolah', 'data_sekolah.id_sekolah');
        }


        // menu
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


        return view('kelas.index', compact('dataKelas','menuItemsWithSubmenus','sekolahOptions', 'filterSekolah', 'searchNamaKelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataKelas = Kelas::all();
        // $dataSekolah= Sekolah::all();
        $user_id = auth()->user()->user_id; // Mendapatkan ID pengguna yang sedang login
        // dd($user_id);

        // $sekolahUser = AksesSekolah::where('user_id', $user_id)->get();

        // // Kemudian, Anda dapat mengambil daftar sekolah dari relasi
        // $dataSekolah = $sekolahUser->pluck('sekolah');
        $cek = AksesSekolah::where('akses_sekolah.user_id', $user_id)->first();
        $sekolahUser = AksesSekolah::where('user_id', $user_id)->get();
        
        if (empty($cek->user_id)){
            // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
            $dataSekolah = Sekolah::all();
        } else {
            $dataSekolah = $sekolahUser->pluck('sekolah');
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
        return view('kelas.create', compact('dataKelas','dataSekolah','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataKelas = new Kelas;
        $dataKelas->nama_kelas = $request->nama_kelas;
        $dataKelas->id_sekolah = $request->id_sekolah;
        $dataKelas->save();

        return redirect()->route('kelas.index')->with('success', 'Kelas insert successfully');
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
    public function edit($id_kelas)
    {
        // $dataSekolah = Sekolah::all();
        $user_id = auth()->user()->user_id; // Mendapatkan ID pengguna yang sedang login
        // dd($user_id);

        // $sekolahUser = AksesSekolah::where('user_id', $user_id)->get();
       

        // // Kemudian, Anda dapat mengambil daftar sekolah dari relasi
        // $dataSekolah = $sekolahUser->pluck('sekolah');

        $cek = AksesSekolah::where('akses_sekolah.user_id', $user_id)->first();
        $sekolahUser = AksesSekolah::where('user_id', $user_id)->get();
        
        if (empty($cek->user_id)){
            // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
            $dataSekolah = Sekolah::all();
        } else {
            $dataSekolah = $sekolahUser->pluck('sekolah');
        }
        // dd($dataSekolah);

        $dataKelas = Kelas::where('id_kelas', $id_kelas)->first();
    
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
        return view('kelas.update', compact('dataSekolah', 'dataKelas', 'menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_kelas)
    {
         
        DB::table('data_kelas')->where('id_kelas', $id_kelas)->update([
            'nama_kelas' => $request->nama_kelas,
            'id_sekolah' => $request->id_sekolah,
            'created_at' => now(),
            'updated_at' => now()

    ]);

    return redirect()->route('kelas.index')->with('success', 'Kelas edited successfully');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_kelas){
        $dataKelas = Kelas::where('id_kelas', $id_kelas);
        $dataKelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Terdelet');
    }
}
