<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\AksesSekolah;
use Illuminate\Http\Request;
use App\Models\KategoriKuisioner;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KategoriKuisionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'
        // $dataKategoriKuisioner = KategoriKuisioner::join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kategori_kuisioner.id_sekolah')
        //     ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_kategori_kuisioner.id_sekolah')
        //     ->where('akses_sekolah.user_id', $user_id)
        //     ->orderBy('data_kategori_kuisioner.id_kategori_kuisioner', 'DESC')
        //     ->paginate(10);
    
            $user_id = auth()->user()->user_id; 
            $cek = AksesSekolah::where('akses_sekolah.user_id', $user_id)->first();
            
            if (empty($cek->user_id)){
                // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
                $dataKategoriKuisioner = KategoriKuisioner::with('sekolah')->orderBy('id_kategori_kuisioner', 'DESC')->paginate(10);
            } else {
                // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
                $dataKategoriKuisioner = KategoriKuisioner::join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kategori_kuisioner.id_sekolah')
                    ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_kategori_kuisioner.id_sekolah')
                    ->where('akses_sekolah.user_id', $user_id)
                    ->orderBy('data_kategori_kuisioner.id_kategori_kuisioner', 'DESC')
                    ->paginate(10);
            }

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


        return view('kategoriKuisioner.index', compact('dataKategoriKuisioner','menuItemsWithSubmenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataKategoriKuisioner = KategoriKuisioner::all();
        // $dataSekolah= Sekolah::all();
        $user_id = auth()->user()->user_id; // Mendapatkan ID pengguna yang sedang login
        // dd($user_id);

        $sekolahUser = AksesSekolah::where('user_id', $user_id)->get();
       

        // Kemudian, Anda dapat mengambil daftar sekolah dari relasi
        $dataSekolah = $sekolahUser->pluck('sekolah');
        // dd($dataSekolah);

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
        return view('kategoriKuisioner.create', compact('dataKategoriKuisioner','dataSekolah','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.',
            'nama_kategori.required' => 'Data harus diisi.'
        ];
        
        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('data_kategori_kuisioner')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('nama_kategori', $request->nama_kategori);
                }),
            ],
            'nama_kategori' => 'required',
        ], $customMessages);

        $dataKategoriKuisioner = new KategoriKuisioner();
        $dataKategoriKuisioner->id_sekolah = $request->id_sekolah;
        $dataKategoriKuisioner->nama_kategori = $request->nama_kategori;
        $dataKategoriKuisioner->save();

        return redirect()->route('kategoriKuisioner.index')->with('success', 'Kategori Kuisioner insert successfully');
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
    public function edit($id)
    {
        $user_id = auth()->user()->user_id; 
        $sekolahUser = AksesSekolah::where('user_id', $user_id)->get();
        // Kemudian, Anda dapat mengambil daftar sekolah dari relasi
        $dataSekolah = $sekolahUser->pluck('sekolah');
        $dataKategoriKuisioner = KategoriKuisioner::where('id_kategori_kuisioner', $id)->first();
    
        // MENU
        // $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'
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
        return view('kategoriKuisioner.update', compact('dataSekolah', 'dataKategoriKuisioner', 'menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.',
            'nama_kategori.required' => 'Data harus diisi.'
        ];
        
        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('data_kategori_kuisioner')->ignore($id, 'id_kategori_kuisioner')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('nama_kategori', $request->nama_kategori);
                }),
            ],
            'nama_kategori' => 'required',
        ], $customMessages);

        DB::table('data_kategori_kuisioner')->where('id_kategori_kuisioner', $id)->update([
            'id_sekolah' => $request->id_sekolah,
            'nama_kategori' => $request->nama_kategori,
            'created_at' => now(),
            'updated_at' => now()

    ]);

    return redirect()->route('kategoriKuisioner.index')->with('success', 'Kategori Kuisioner edited successfully');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $dataKategoriKuisioner = KategoriKuisioner::where('id_kategori_kuisioner', $id);
        $dataKategoriKuisioner->delete();
        return redirect()->route('kategoriKuisioner.index')->with('success', 'Terdelet');
    }
}
