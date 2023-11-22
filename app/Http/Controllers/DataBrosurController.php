<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\DataBrosur;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class DataBrosurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataBrosur = DataBrosur::orderBy('id_brosur', 'DESC')->paginate(10);

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
        return view('dataBrosur.index', compact('menuItemsWithSubmenus','dataBrosur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataBrosur = DataBrosur::all();

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

            return view('dataBrosur.create', compact('dataBrosur','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpeg,jpg,png,pdf,doc,docx',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            // $fileName = $file->getClientOriginalName();
            $file->storeAs('public/photos', $fileName); 
        } else {
            $fileName = null;
        }

        $dataBrosur = new DataBrosur();
        $dataBrosur->judul = $request->judul;
        $dataBrosur->file = $fileName;
        $dataBrosur->status = $request->status;
        $dataBrosur->save();
    
        return redirect()->route('brosur.index')->with('success', 'Brosur inserted successfully');

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
    public function edit($id_brosur)
    {
        $dataBrosur = DataBrosur::where('id_brosur', $id_brosur)->first();

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
        return view('dataBrosur.update', compact('dataBrosur','menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_brosur)
    {
        
        $validator = Validator::make($request->all(), [
            'file' => 'file|mimes:jpeg,jpg,png,pdf,doc,docx'
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       
        $dataBrosur = DataBrosur::find($id_brosur);
        $dataBrosur->judul = $request->judul;
        $dataBrosur->status = $request->status;
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // $fileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/photos', $fileName);
            $dataBrosur->file = $fileName;
        }
    
        $dataBrosur->save();
    
        return redirect()->route('brosur.index')->with('success', 'Brosur edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_brosur)
    {
        $dataBrosur = DataBrosur::where('id_brosur', $id_brosur);
        $dataBrosur->delete();
        return redirect()->route('brosur.index')->with('success', 'Terdelet');
    }

    public function unduhBrosur($id_brosur)
    {
        // Ambil data brosur berdasarkan ID
        $brosur = DataBrosur::find($id_brosur);

        // Pastikan brosur ditemukan
        if (!$brosur) {
            abort(404);
        }

        // Path ke file brosur di storage
        $filePath = storage_path('app/public/photos/' . $brosur->file);

        // Nama file untuk diunduh (opsional, bisa disesuaikan)
        $fileName = pathinfo($brosur->file, PATHINFO_BASENAME);

        // Unduh file
        return response()->download($filePath, $fileName);
    }


}
