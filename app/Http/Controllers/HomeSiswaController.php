<?php

namespace App\Http\Controllers;

use App\Models\RoleMenu;
use App\Models\DataSiswa;
use App\Models\Data_Menu;
use Illuminate\Http\Request;

class HomeSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('auth:siswa');
    }


    public function index()
    {
        // $id_siswa = auth()->user()->id_siswa; // Menggunakan 'id_siswa' sebagai pengganti 'user_id'
        // // dd($id_siswa);

        // $user = DataSiswa::find($id_siswa); // Menggunakan model 'DataSiswa' untuk mengambil data siswa
        
        // // Lanjutkan dengan mengakses role_id dan lainnya sesuai kebutuhan
        // $role_id = $user->role_id;
        
        // $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');
        
        // $mainMenus = Data_Menu::where('menu_category', 'master menu')
        //     ->whereIn('menu_id', $menu_ids)
        //     ->get();
        
        // $menuItemsWithSubmenus = [];
        
        // foreach ($mainMenus as $mainMenu) {
        //     $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
        //         ->where('menu_category', 'sub menu')
        //         ->whereIn('menu_id', $menu_ids)
        //         ->orderBy('menu_position')
        //         ->get();
        
        //     $menuItemsWithSubmenus[] = [
        //         'mainMenu' => $mainMenu,
        //         'subMenus' => $subMenus,
        //     ];
        // }
        
        // Lanjutkan dengan logika Anda sesuai kebutuhan
        



        return view('homeSiswa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
