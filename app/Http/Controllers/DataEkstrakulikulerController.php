<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DataEkstrakulikuler;
use Illuminate\Support\Facades\Validator;

class DataEkstrakulikulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataEskul = DataEkstrakulikuler::with('sekolah')->orderBy('id_ekstrakulikuler', 'DESC')->paginate(10);

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
        return view('dataEskul.index', compact('menuItemsWithSubmenus','dataEskul'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataEskul = DataEkstrakulikuler::all();
        $dataSekolah = Sekolah::all();

        // sidebar menu
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

            return view('dataEskul.create', compact('dataEskul','dataSekolah','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|file|mimes:jpeg,jpg,png',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            // $fileName = $file->getClientOriginalName();
            $file->storeAs('public/photos', $fileName); 
        } else {
            $fileName = null;
        }

        $dataEskul = new DataEkstrakulikuler();
        $dataEskul->id_sekolah = $request->id_sekolah;
        $dataEskul->judul = $request->judul;
        $dataEskul->gambar = $fileName;
        $dataEskul->deskripsi = $request->deskripsi;
        $dataEskul->status = $request->status;
        $dataEskul->save();
    
        return redirect()->route('ekstrakulikuler.index')->with('success', 'Estrakulikuler inserted successfully');

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
    public function edit($id_ekstrakulikuler)
    {
        $dataEskul = DataEkstrakulikuler::where('id_ekstrakulikuler', $id_ekstrakulikuler)->first();
        // $dataSekolah = DataEkstrakulikuler::where('id_sekolah', $id_ekstrakulikuler)->first();
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
        return view('dataEskul.update', compact('dataEskul','dataSekolah','menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_ekstrakulikuler)
    {
        
        $validator = Validator::make($request->all(), [
            'gambar' => 'file|mimes:jpeg,jpg,png'
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       
        $dataEskul = DataEkstrakulikuler::find($id_ekstrakulikuler);
        $dataEskul->id_sekolah = $request->id_sekolah;
        $dataEskul->judul = $request->judul;
        $dataEskul->deskripsi = $request->deskripsi;
        $dataEskul->status = $request->status;
    
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            // $fileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/photos', $fileName);
            $dataEskul->gambar = $fileName;
        }
    
        $dataEskul->save();
    
        return redirect()->route('ekstrakulikuler.index')->with('success', 'Ekstrakulikuler edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_ekstrakulikuler)
    {
        $dataEskul = DataEkstrakulikuler::where('id_ekstrakulikuler', $id_ekstrakulikuler);
        $dataEskul->delete();
        return redirect()->route('ekstrakulikuler.index')->with('success', 'Terdelet');
    }

    public function detail(Request $request, $id_ekstrakulikuler)
    {
        $dataEskul = DataEkstrakulikuler::where('status', 'ditampilkan')->where('id_ekstrakulikuler', $id_ekstrakulikuler)->orderBy('id_ekstrakulikuler', 'desc')->first();
        $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');
        $selectedSekolahId = $request->input('sekolah');

        $ekstrakulikulerOptions = [];
        if ($selectedSekolahId) {
            $ekstrakulikulerOptions = DataEkstrakulikuler::where('id_sekolah', $selectedSekolahId)->pluck('judul', 'id_ekstrakulikuler');
        }
        
        return view('dataEskul.detail', compact('dataEskul','sekolahOptions', 'ekstrakulikulerOptions', 'selectedSekolahId'));
    }
}
