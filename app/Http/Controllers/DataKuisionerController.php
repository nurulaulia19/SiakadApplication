<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\AksesSekolah;
use Illuminate\Http\Request;
use App\Models\DataKuisioner;
use Illuminate\Validation\Rule;
use App\Models\JawabanKuisioner;
use App\Models\KategoriKuisioner;
use Illuminate\Support\Facades\DB;

class DataKuisionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'
        // $dataKuisioner = DataKuisioner::join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kuisioner.id_sekolah')
        //     ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_kuisioner.id_sekolah')
        //     ->with('kategoriKuisioner') // Memuat data kategori kuisioner
        //     ->where('akses_sekolah.user_id', $user_id)
        //     ->orderBy('data_kuisioner.id_kuisioner', 'DESC')
        //     ->paginate(10);

        $user_id = auth()->user()->user_id; 
        $cek = AksesSekolah::where('akses_sekolah.user_id', $user_id)->first();
        
        if (empty($cek->user_id)){
            // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
            $dataKuisioner = DataKuisioner::with('kategoriKuisioner')->orderBy('id_kuisioner', 'DESC')->paginate(10);
        } else {
            // Menggunakan Eloquent untuk mengambil kelas yang berhubungan dengan sekolah yang terkait dengan pengguna
            $dataKuisioner = DataKuisioner::join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kuisioner.id_sekolah')
                ->join('akses_sekolah', 'akses_sekolah.id_sekolah', '=', 'data_kuisioner.id_sekolah')
                ->with('kategoriKuisioner') // Memuat data kategori kuisioner
                ->where('akses_sekolah.user_id', $user_id)
                ->orderBy('data_kuisioner.id_kuisioner', 'DESC')
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


        return view('kuisioner.index', compact('dataKuisioner','menuItemsWithSubmenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataKuisioner = DataKuisioner::all();
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
        
        $dataKategoriKuisioner = KategoriKuisioner::all();

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
        return view('kuisioner.create', compact('dataKuisioner','dataSekolah', 'dataKategoriKuisioner', 'menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.',
            'id_kategori_kuisioner.required' => 'Data harus diisi.',
            'pertanyaan.required' => 'Data harus diisi.'
        ];
        
        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('data_kuisioner')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('id_kategori_kuisioner', $request->id_kategori_kuisioner)
                        ->where('pertanyaan', $request->pertanyaan);
                }),
            ],
            'id_kategori_kuisioner' => 'required',
            'pertanyaan' => 'required',
        ], $customMessages);
        
        $dataKuisioner = new DataKuisioner();
        $dataKuisioner->id_sekolah = $request->id_sekolah;
        $dataKuisioner->id_kategori_kuisioner = $request->id_kategori_kuisioner;
        $dataKuisioner->pertanyaan  = $request->pertanyaan ;
        $dataKuisioner->save();

        return redirect()->route('kuisioner.index')->with('success', 'Kuisioner insert successfully');
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
        $dataKuisioner = DataKuisioner::where('id_kuisioner', $id)->first();
        // $dataKategoriKuisioner = KategoriKuisioner::all();
        $dataKategoriKuisioner = KategoriKuisioner::where('id_sekolah', $dataKuisioner->id_sekolah)->get();
    
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
        return view('kuisioner.update', compact('dataSekolah', 'dataKuisioner', 'dataKategoriKuisioner', 'menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.',
            'id_kategori_kuisioner.required' => 'Data harus diisi.',
            'pertanyaan.required' => 'Data harus diisi.'
        ];
        
        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('data_kuisioner')->ignore($id, 'id_kuisioner')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('id_kategori_kuisioner', $request->id_kategori_kuisioner)
                        ->where('pertanyaan', $request->pertanyaan);
                }),
            ],
            'id_kategori_kuisioner' => 'required',
            'pertanyaan' => 'required',
        ], $customMessages);

        DB::table('data_kuisioner')->where('id_kuisioner', $id)->update([
            'id_sekolah' => $request->id_sekolah,
            'id_kategori_kuisioner' => $request->id_kategori_kuisioner,
            'pertanyaan' => $request->pertanyaan,
            'created_at' => now(),
            'updated_at' => now()

    ]);

        return redirect()->route('kuisioner.index')->with('success', 'Kuisioner edited successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $dataKuisioner = DataKuisioner::where('id_kuisioner', $id);
        $dataKuisioner->delete();
        $dataJawabanKuisioner = JawabanKuisioner::where('id_kuisioner', $id);
        $dataJawabanKuisioner->delete();
        return redirect()->route('kuisioner.index')->with('success', 'Terdelet');
    }

    public function getKategori(Request $request){
        $dataKategoriKuisioner = KategoriKuisioner::where('id_sekolah', $request->sekolahID)->pluck('id_kategori_kuisioner', 'nama_kategori');
        return response()->json($dataKategoriKuisioner);
    }
}
