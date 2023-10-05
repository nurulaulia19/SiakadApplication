<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use Illuminate\Http\Request;
use App\Models\KategoriNilai;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class KategoriNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataKn = KategoriNilai::with('sekolah')->orderBy('id_kn', 'DESC')->paginate(10);

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
        return view('kategoriNilai.index', compact('dataKn','menuItemsWithSubmenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataKn = KategoriNilai::all();
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
        return view('kategoriNilai.create', compact('dataKn','dataSekolah','menuItemsWithSubmenus'));
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
                Rule::unique('data_kategori_nilai')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('kategori', $request->kategori);
                }),
            ],
            'kategori' => 'required',
        ], $customMessages);

        $dataKn = new KategoriNilai;
        $dataKn->id_sekolah = $request->id_sekolah;
        $dataKn->kategori = $request->kategori;
        $dataKn->save();
        

        return redirect()->route('kategoriNilai.index')->with('success', 'Kategori Nilai insert successfully');
            
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
    public function edit($id_kn)
    {
        $dataKn = KategoriNilai::where('id_kn', $id_kn)->first();
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
        return view('kategoriNilai.update', compact( 'dataKn','dataSekolah','menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_kn)
    {
         $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.'
            // Add other custom error messages as needed
        ];

        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('data_kategori_nilai')->ignore($id_kn, 'id_kn')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('kategori', $request->kategori);
                }),
            ],
            'kategori' => 'required',
        ], $customMessages);
         
        DB::table('data_kategori_nilai')->where('id_kn', $id_kn)->update([
            'id_sekolah' => $request->id_sekolah,
            'kategori' => $request->kategori,
            'created_at' => now(),
            'updated_at' => now()

    ]);

    return redirect()->route('kategoriNilai.index')->with('success', 'Kategori Nilai edited successfully');

}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_kn){
        $dataKn = KategoriNilai::where('id_kn', $id_kn);
        $dataKn->delete();
        return redirect()->route('kategoriNilai.index')->with('success', 'Terdelet');
    }
}
