<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\DataGaleri;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class DataGaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataGaleri = DataGaleri::orderBy('id_galeri', 'DESC')->paginate(10);

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
        return view('dataGaleri.index', compact('menuItemsWithSubmenus','dataGaleri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataGaleri = DataGaleri::all();

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

            return view('dataGaleri.create', compact('dataGaleri','menuItemsWithSubmenus'));
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

        $dataGaleri = new DataGaleri();
        $dataGaleri->judul = $request->judul;
        $dataGaleri->gambar = $fileName;
        $dataGaleri->status = $request->status;
        $dataGaleri->save();
    
        return redirect()->route('galeri.index')->with('success', 'Galeri inserted successfully');

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
    public function edit($id_galeri)
    {
        $dataGaleri = DataGaleri::where('id_galeri', $id_galeri)->first();

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
        return view('dataGaleri.update', compact('dataGaleri','menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_galeri)
    {
        
        $validator = Validator::make($request->all(), [
            'gamber' => 'file|mimes:jpeg,jpg,png,pdf,doc,docx'
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       
        $dataGaleri = DataGaleri::find($id_galeri);
        $dataGaleri->judul = $request->judul;
        $dataGaleri->status = $request->status;
    
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            // $fileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/photos', $fileName);
            $dataGaleri->gambar = $fileName;
        }
    
        $dataGaleri->save();
    
        return redirect()->route('galeri.index')->with('success', 'Galeri edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_galeri)
    {
        $dataGaleri = DataGaleri::where('id_galeri', $id_galeri);
        $dataGaleri->delete();
        return redirect()->route('galeri.index')->with('success', 'Terdelet');
    }
}
