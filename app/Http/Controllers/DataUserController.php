<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;


class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dataUser = DataUser::all();
        $dataUser = DataUser::with('role')->orderBy('user_id', 'DESC')->paginate(10);

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
        return view('user.index', compact('dataUser','menuItemsWithSubmenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataRole = Role::all();
        $dataUser = DataUser::all();

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
        return view('user.create', compact('dataUser','dataRole','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'user_password' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#?!@$%^&*-]).{6,}$/'
            ],
            'user_photo' => 'required|file|mimes:jpeg,jpg,png',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if ($request->hasFile('user_photo')) {
            $file = $request->file('user_photo');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            // $fileName = $file->getClientOriginalName();
            $file->storeAs('public/photos', $fileName); 
        } else {
            $fileName = null;
        }
        // if ($request->hasFile('user_photo')) {
        //     $fileName = $request->file('user_photo')->store('public/photos');
        // } else {
        //     $fileName = null;
        // }
    
        $hashedPassword = Hash::make($request->user_password);

        $dataUser = new DataUser;
        $dataUser->user_id = $request->user_id;
        $dataUser->user_name = $request->user_name;
        $dataUser->user_email = $request->user_email;
        $dataUser->user_password =$hashedPassword;
        $dataUser->user_gender = $request->user_gender;
        $dataUser->user_photo = $fileName;
        $dataUser->role_id = $request->role_id;
        $dataUser->user_token = $request->user_token;
        $dataUser->save();
    
        return redirect()->route('user.index')->with('success', 'User inserted successfully');

       
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
    public function edit($user_id)
    {
        $dataRole = Role::all();
        $dataUser = DataUser::where('user_id', $user_id)->first();

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
        return view('user.update', compact('dataUser','dataRole','menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id)
{
    
    $validator = Validator::make($request->all(), [
        'user_password' => [
            'nullable',
            'string',
            'min:6',
            'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#?!@$%^&*-]).{6,}$/',
        ],
        'user_photo' => 'file|mimes:jpeg,jpg,png'
        // Tambahkan aturan validasi lainnya sesuai kebutuhan
    ]);
    
    if ($request->filled('user_password')) {
        $validator->sometimes('user_password', 'required', function ($input) {
            return $input->user_password !== null;
        });
    }

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }


    $hashedPassword = Hash::make($request->user_password);

    $dataUser = DataUser::find($user_id);
    $dataUser->user_name = $request->user_name;
    $dataUser->user_email = $request->user_email;
    $dataUser->user_password = $hashedPassword;
    $dataUser->user_gender = $request->user_gender;
    $dataUser->role_id = $request->role_id;
    $dataUser->user_token = $request->user_token;

    if ($request->hasFile('user_photo')) {
        $file = $request->file('user_photo');
        // $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::random(40) . '.' . $extension;
        $file->storeAs('public/photos', $fileName);
        $dataUser->user_photo = $fileName;
    }

    $dataUser->save();

    return redirect()->route('user.index')->with('success', 'User edited successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        $dataUser = DataUser::where('user_id', $user_id);
        $dataUser->delete();
        return redirect()->route('user.index')->with('success', 'Terdelet');
    }


    public function editProfil()
    {
        // $dataRole = Role::all();
        $dataUser = Auth::user();
        Log::info($dataUser); // Add this line to log the daat$dataUser data

        // menu
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
        return view('profil.edit', compact('dataUser','menuItemsWithSubmenus'));
    }


        public function updateProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_photo' => 'file|mimes:jpeg,jpg,png',
        ]);

       

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user(); // Mengambil data admin yang sedang login

        $userData = [
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_gender' => $request->user_gender,
        
        ];

        

        if ($request->hasFile('user_photo')) {
            $file = $request->file('user_photo');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/photos', $fileName);
            $userData['user_photo'] = $fileName;
        }

        DB::table('data_user')
            ->where('user_id', $user->user_id)
            ->update($userData);

        return redirect()->route('profil.edit')->with('success', 'User profile updated successfully');
    }

    public function editPassword()
    {
        $dataUser = Auth::user();
        Log::info($dataUser); // Add this line to log the daat$dataUser data

        // menu
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

        return view('password.edit', compact('dataUser','menuItemsWithSubmenus'));
    }


    public function updatePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => [
            'required',
            'string',
            'min:6',
            'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#?!@$%^&*-]).{6,}$/',
            'confirmed',
        ],
    ], [
        'new_password.regex' => 'The password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = Auth::user(); // Mengambil data admin yang sedang login

    // Memeriksa apakah current password sesuai dengan yang ada di database
    if (!Hash::check($request->current_password, $user->user_password)) {
        return redirect()->back()->withErrors(['current_password' => 'Incorrect current password']);
    }

    // Jika semua validasi berhasil, update password baru
    DB::table('data_user')
        ->where('user_id', $user->user_id)
        ->update([
            'user_password' => Hash::make($request->new_password),
        ]);

    return redirect()->route('password.edit')->with('success', 'Password updated successfully');
}
    



}
