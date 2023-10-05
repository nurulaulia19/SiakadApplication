<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataRole = Role::orderBy('role_id', 'DESC')->paginate(10);
        $roles = Role::with('roleMenus')->get();

        // menu
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

        
        return view('role.index', compact('dataRole', 'roles','menuItemsWithSubmenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        $dataRole = Role::all();
        $dataMenu = Data_Menu::all();

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
        return view('role.create', compact('dataMenu','dataRole','menuItemsWithSubmenus'));
    }
    
    public function store(Request $request)
{
    // $dataRole = Role::crea
    $dataRole = Role::create([
        'role_name' => $request->role_name,
    ]);

    // dd($dataRole);
    $menu_id=$request->menu_id;
    foreach ($menu_id as $id) {
        RoleMenu::create([
            'role_id' => $dataRole->id,
            'menu_id' => $id
        ]);
    }

    return redirect()->route('role.index')->with('success', 'Role insert successfully');
}
    
    /**
     * Store a newly created resource in storage.
     */

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
    // public function edit(string $id)
    // {
    //     //
    // }

    public function edit($role_id)
{
    // $dataRole = Role::find('role_id');
    $selectedMenuIds = RoleMenu::where('role_id', $role_id)->pluck('menu_id')->toArray();
    $dataMenu = Data_Menu::all();
    $dataRole = Role::where('role_id', $role_id)->first();

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
    return view('role.update', compact('dataMenu', 'dataRole', 'selectedMenuIds','menuItemsWithSubmenus'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $role_id)
        {
         //perintah untuk delete data_role_menu berdasarkan role id
        RoleMenu::where('role_id', $role_id)->delete();
        DB::table('data_role')->where('role_id', $role_id)->update([
            'role_name' => $request->role_name,
            'created_at' => now(),
            'updated_at' => now()

    ]);
    $menu_id=$request->menu_id;
    foreach ($menu_id as $id) {
        RoleMenu::create([
            'role_id' => $role_id,
            'menu_id' => $id
        ]);
    }

    return redirect()->route('role.index')->with('success', 'Role edited successfully');

}

    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($role_id){
        $menu = Role::where('role_id', $role_id);
        $menu->delete();
        $dataRoleMenu = RoleMenu::where('role_id', $role_id);
        $dataRoleMenu->delete();
        return redirect()->route('role.index')->with('success', 'Terdelet');
    }
}
