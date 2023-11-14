<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\AksesSekolah;
use Illuminate\Http\Request;
use App\Models\DataPelajaran;
use Illuminate\Support\Facades\DB;

class DataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dataPelajaran = DataPelajaran::with('sekolah')->orderBy('kode_pelajaran', 'DESC')->paginate(10);
        // $user_id = auth()->user()->user_id; // Mendapatkan ID pengguna yang sedang login

        // Menggunakan Eloquent untuk mengambil data pelajaran yang berhubungan dengan sekolah yang terkait dengan pengguna
        // $dataPelajaran = DataPelajaran::join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_pelajaran.id_sekolah')
        //     ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_pelajaran.id_sekolah')
        //     ->where('akses_sekolah.user_id', $user_id)
        //     ->orderBy('data_pelajaran.kode_pelajaran', 'DESC')
        //     ->paginate(10);

        // cek
        $user_id = auth()->user()->user_id;
        $cek = AksesSekolah::where('akses_sekolah.user_id', $user_id)->first();
        
        if (empty($cek->user_id)){
            // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
           $dataPelajaran = DataPelajaran::with('sekolah')->orderBy('id_pelajaran', 'DESC')->paginate(10);
        } else {
            // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
            $dataPelajaran = DataPelajaran::join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_pelajaran.id_sekolah')
            ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_pelajaran.id_sekolah')
            ->where('akses_sekolah.user_id', $user_id)
            ->orderBy('data_pelajaran.id_pelajaran', 'DESC')
            ->paginate(10);
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
    return view('mapel.index', compact('dataPelajaran','menuItemsWithSubmenus'));
}

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataPelajaran = DataPelajaran::all();
        $guruRoleId = Role::where('role_name', 'guru')->value('role_id'); // Mendapatkan ID peran "guru"
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
        return view('mapel.create', compact('dataPelajaran','dataSekolah','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataPelajaran = new DataPelajaran;
        $dataPelajaran->kode_pelajaran = $request->kode_pelajaran;
        $dataPelajaran->nama_pelajaran = $request->nama_pelajaran;
        // $dataPelajaran->user_id = $request->user_id;
        $dataPelajaran->id_sekolah = $request->id_sekolah;
        $dataPelajaran->save();

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran insert successfully');
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
    public function edit($id_pelajaran)
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

        $dataPelajaran = DataPelajaran::where('id_pelajaran', $id_pelajaran)->first();
    
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
        return view('mapel.update', compact('dataPelajaran', 'dataSekolah', 'menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_pelajaran)
    {
        DB::table('data_pelajaran')->where('id_pelajaran', $id_pelajaran)->update([
            'nama_pelajaran' => $request->nama_pelajaran,
            'kode_pelajaran' => $request->kode_pelajaran,
            // 'user_id' => $request->user_id,
            'id_sekolah' => $request->id_sekolah,
            'created_at' => now(),
            'updated_at' => now()

    ]);

    return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pelajaran){
        $dataPelajaran = DataPelajaran::where('id_pelajaran', $id_pelajaran);
        $dataPelajaran->delete();
        return redirect()->route('mapel.index')->with('success', 'Terdelet');
    }
}
