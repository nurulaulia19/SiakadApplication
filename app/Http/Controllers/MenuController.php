<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    
     public function index() {
        $dataMenu = Data_Menu::leftJoin('data_menu AS menuSub', 'data_menu.menu_sub', '=', 'menuSub.menu_id')
            ->select('menuSub.menu_name AS submenu_name', 'data_menu.*')->paginate(10);
    
        // $user_id = auth()->user()->user_id;
        // $user = DataUser::findOrFail($user_id);
        // $menu_ids = $user->role->roleMenus->pluck('menu_id');

        // $menu_route_name = request()->route()->getName(); // Nama route dari URL yang diminta

        // // Ambil menu berdasarkan menu_link yang sesuai dengan nama route
        // $requested_menu = Data_Menu::where('menu_link', $menu_route_name)->first();
        // // dd($requested_menu);

        // // Periksa izin akses berdasarkan menu_id dan user_id
        // if (!$requested_menu || !$menu_ids->contains($requested_menu->menu_id)) {
        //     return redirect()->back()->with('error', 'You do not have permission to access this menu.');
        // }

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


        return view('menu.index', compact('dataMenu','menuItemsWithSubmenus'));
    }

    public function create(){
        $dataMenu = DB::table('data_menu')->select('*')->where('menu_category','master menu')->get();

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

        

        return view('menu.create', compact('dataMenu','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_name' => 'required',
            'menu_link' => 'required',
            'menu_category' => 'required',
            'menu_position' => 'required|integer',
            'menu_sub' => 'nullable',
        ]);
        
        $result = Data_Menu::insert([
            'menu_id' => $request->menu_id,
            'menu_name' => $request->menu_name,
            'menu_link' => $request->menu_link,
            'menu_category' => $request->menu_category,
            'menu_sub' => $request->menu_sub,
            'menu_position' => $request->menu_position,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        if($result){
            return redirect()->route('menu.index')->with('success', 'Menu insert successfully');
        }else{
            return $this->create();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // public function tampilkandata($menu_id) {
    //     $dataMenu = Data_Menu::find($menu_id);
    // }


    public function edit($menu_id)
    {
    $menu = Data_Menu::where('menu_id', $menu_id)->first();
    $dataMenu = DB::table('data_menu')->select('*')->where('menu_category','master menu')->get();
    // $mainMenus = Data_Menu::where('menu_category', 'master menu')->get();
    //         $menuItemsWithSubmenus = [];
        
    //         foreach ($mainMenus as $mainMenu) {
    //             $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
    //                                 ->where('menu_category', 'sub menu')
    //                                 ->orderBy('menu_position')
    //                                 ->get();
        
    //             $menuItemsWithSubmenus[] = [
    //                 'mainMenu' => $mainMenu,
    //                 'subMenus' => $subMenus,
    //             ];
    //         }

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
    return view('menu.update', compact('dataMenu','menu','menuItemsWithSubmenus'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
        public function update(Request $request, $menu_id){
        DB::table('data_menu')->where('menu_id', $menu_id)->update([
            'menu_name' => $request->menu_name,
            'menu_link' => $request->menu_link,
            'menu_category' => $request->menu_category,
            'menu_sub' => $request->menu_sub,
            'menu_position' => $request->menu_position,
            'created_at' => now(),
            'updated_at' => now()
    ]);
    return redirect()->route('menu.index')->with('success', 'Menu edited successfully');
}
        
    //     $dataMenu = Data_Menu::where('menu_id', '=', $id)->first();
    //     return view('menu.update',compact('title','dataMenu'));
    //     // return view('menu.update');
    // }

    /**
     * Update the specified resource in storage.
     */
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($menu_id){
        $menu = Data_Menu::where('menu_id', $menu_id);
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Terdelet');
    }


    // public function getMenuData()
    // {
    //     // $menu_id = 1; // Example selected menu_id
    
    //     // $dataMenu = Data_Menu::all();
        
    // }
    




}
