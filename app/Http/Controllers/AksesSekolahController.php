<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\AksesSekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AksesSekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataAs = AksesSekolah::with('user', 'sekolah')->orderBy('id_as', 'DESC')->paginate(10);

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
     return view('aksesSekolah.index', compact('dataAs','menuItemsWithSubmenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataAs = AksesSekolah::all();
        $dataSekolah = Sekolah::all(); 
        $adminRoleId = Role::where('role_name', 'admin')->value('role_id'); // Mendapatkan ID peran "guru"

        $dataUser = DataUser::whereHas('role', function ($query) use ($adminRoleId) {
            $query->where('role_id', $adminRoleId);
        })->get();

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
        return view('aksessekolah.create', compact('dataAs','dataSekolah','dataUser','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.',
            'id_sekolah.required' => 'Pilih sekolah.',
            'user_id.required' => 'Pilih nama admin.'
        ];
        
        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('akses_sekolah')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('user_id', $request->user_id);
                }),
            ],
            'user_id' => 'required',
        ], $customMessages);

        $result = AksesSekolah::insert([
            // 'id_customer' => $request->id_customer,
            'id_sekolah' => $request->id_sekolah,
            'user_id' => $request->user_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        if($result){
            return redirect()->route('aksessekolah.index')->with('success', 'Akses Sekolah insert successfully');
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_as)
    {
        $dataAs = AksesSekolah::where('id_as', $id_as)->first();
        $dataSekolah = Sekolah::all();
        $adminRoleId = Role::where('role_name', 'admin')->value('role_id'); // Mendapatkan ID peran "guru"

        $dataUser = DataUser::whereHas('role', function ($query) use ($adminRoleId) {
            $query->where('role_id', $adminRoleId);
        })->get();
        
        // Menu
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
        return view('aksessekolah.update', compact('dataAs','dataSekolah','dataUser','menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_as){

        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.',
            'id_sekolah.required' => 'Pilih sekolah.',
            'user_id.required' => 'Pilih nama admin.'
        ];
        
        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('akses_sekolah')->ignore($id_as, 'id_as')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('user_id', $request->user_id);
                }),
            ],
            'user_id' => 'required',
        ], $customMessages);

        DB::table('akses_sekolah')->where('id_as', $id_as)->update([
            'id_sekolah' => $request->id_sekolah,
            'user_id' => $request->user_id,
            'created_at' => now(),
            'updated_at' => now()
    ]);
        return redirect()->route('aksessekolah.index')->with('success', 'Akses Cabang edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_as)
    {
        $dataAs = AksesSekolah::where('id_as', $id_as);
        $dataAs->delete();
        return redirect()->route('aksessekolah.index')->with('success', 'Terdelet');
    }
}
