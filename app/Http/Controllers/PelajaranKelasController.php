<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use Illuminate\Http\Request;
use App\Models\DataPelajaran;
use App\Models\PelajaranKelas;
use App\Models\PelajaranKelasList;
use Illuminate\Support\Facades\DB;

class PelajaranKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPk = PelajaranKelas::with('kelas','sekolah','mapelList')->orderBy('id_pk', 'DESC')->paginate(10);

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
    return view('mapelKelas.index', compact('dataPk','menuItemsWithSubmenus'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataPk = PelajaranKelas::all();
        $dataPelajaran = DataPelajaran::all();
        $dataKelas = Kelas::all();
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
        return view('mapelKelas.create', compact('dataPk','dataSekolah','dataKelas','dataPelajaran','menuItemsWithSubmenus'));
    }
    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {

    //     $dataPk = PelajaranKelas::create([
               
    //         'tahun_ajaran' => $request->tahun_ajaran,
    //         'id_kelas' => $request->id_kelas,
    //         'id_sekolah' => $request->id_sekolah,
    //     ]);
       
        
    //     // $id_sekolah = $request->id_sekolah;
    //     $id_pelajaran = $request->id_pelajaran;

        
    //     foreach ($id_pelajaran as $id) {
    //         PelajaranKelasList::create([
    //             // 'id_sekolah' => $id_sekolah, // Ganti dengan kolom yang sesuai
    //             'id_pelajaran' => $id, // Anda mungkin perlu menyesuaikan ini dengan loop juga
    //             'id_pk' => $dataPk->id_pk,
    //         ]);
    //     }
        

    //     return redirect()->route('mapelKelas.index')->with('success', 'Mata Pelajaran Perkelas insert successfully');
    // }

    // cobain ini besokkk!!!! smaa modelnya
    public function store(Request $request)
{
    $customMessages = [
        'id_kelas.unique' => 'nama kelas sudah ada.',
        'id_sekolah.required' => 'nama sekolah tidak boleh kosong.',
        'id_pelajaran.required' => 'mata pelajaran tidak boleh kosong.',
        'tahun_ajaran.required' => 'tahun ajaran tidak boleh kosong.',
        // Add other custom error messages as needed
    ];

    $validatedData = $request->validate([
        'id_kelas' => 'required|unique:pelajaran_kelas,id_kelas',
        'tahun_ajaran' => 'required',
        'id_sekolah' => 'required',
        'id_pelajaran' => 'required',

    ],$customMessages);

    try {
        $dataPk = PelajaranKelas::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'id_kelas' => $validatedData['id_kelas'],
            'id_sekolah' => $request->id_sekolah,
        ]);

        $id_pelajaran = $request->id_pelajaran;

        foreach ($id_pelajaran as $id) {
            PelajaranKelasList::create([
                'id_pelajaran' => $id,
                'id_pk' => $dataPk->id_pk,
            ]);
        }

        // Berhasil, arahkan ke halaman lain atau berikan pesan sukses
        return redirect()->route('mapelKelas.index')->with('success', 'Mata Pelajaran Perkelas insert successfully');
    } catch (\Exception $e) {
        // Tangkap pengecualian validasi dan berikan pesan error
        return redirect()->back()->with('error', 'Error: Kelas sudah ada.');
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
    public function edit($id_pk)
    {
        
        $dataPk = PelajaranKelas::all();
        $dataSekolah = Sekolah::all();
       
        $selectedMapelId = PelajaranKelasList::where('id_pk', $id_pk)->pluck('id_pelajaran')->toArray();
        // $selectedMapelId = PelajaranKelas::where('id_pk', $id_pk)->first()->id_pelajaran;
        $dataPk = PelajaranKelas::where('id_pk', $id_pk)->first();
        $dataPelajaran = DataPelajaran::where('id_sekolah', $dataPk->id_sekolah)->get();
        $dataKelas = Kelas::where('id_sekolah', $dataPk->id_sekolah)->get();
        
    
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
        return view('mapelKelas.update', compact('dataPk','dataSekolah','dataKelas','dataPelajaran','menuItemsWithSubmenus','selectedMapelId'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id_pk)
    // {
        

    //     PelajaranKelasList::where('id_pk', $id_pk)->delete();
    //     DB::table('pelajaran_kelas')->where('id_pk', $id_pk)->update([
    //         'id_kelas' => $request->id_kelas,
    //         'tahun_ajaran' => $request->tahun_ajaran,
    //         'id_sekolah' => $request->id_sekolah,
    //         'created_at' => now(),
    //         'updated_at' => now()
    
    //     ]);

    //     // $id_sekolah = $request->id_sekolah;
    //     $id_pelajaran = $request->id_pelajaran;

        
    //     foreach ($id_pelajaran as $id) {
    //         PelajaranKelasList::create([
    //             // 'id_sekolah' => $id_sekolah, // Ganti dengan kolom yang sesuai
    //             'id_pelajaran' => $id, // Anda mungkin perlu menyesuaikan ini dengan loop juga
    //             'id_pk' => $id_pk,
    //         ]);
    //     }

    // return redirect()->route('mapelKelas.index')->with('success', 'Mata Pelajaran Perkelas edited successfully');
    // }

    public function update(Request $request, $id_pk)
{
    $customMessages = [
        'id_kelas.unique' => 'nama kelas sudah ada.',
        // Add other custom error messages as needed
    ];

    $validatedData = $request->validate([
        'id_kelas' => 'required|unique:pelajaran_kelas,id_kelas,' . $id_pk . ',id_pk',
        

    ],$customMessages);

    try {
        PelajaranKelasList::where('id_pk', $id_pk)->delete();
        DB::table('pelajaran_kelas')->where('id_pk', $id_pk)->update([
            'id_kelas' => $validatedData['id_kelas'],
            'tahun_ajaran' => $request->tahun_ajaran,
            'id_sekolah' => $request->id_sekolah,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $id_pelajaran = $request->id_pelajaran;

        
        foreach ($id_pelajaran as $id) {
            PelajaranKelasList::create([
                // 'id_sekolah' => $id_sekolah, // Ganti dengan kolom yang sesuai
                'id_pelajaran' => $id, // Anda mungkin perlu menyesuaikan ini dengan loop juga
                'id_pk' => $id_pk,
            ]);
        }

        return redirect()->route('mapelKelas.index')->with('success', 'Mata Pelajaran Perkelas edited successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error updating class.');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pk){
        $dataPk = PelajaranKelas::where('id_pk', $id_pk);
        $dataPk->delete();
        $dataPkl = PelajaranKelasList::where('id_pk', $id_pk);
        $dataPkl->delete();
        return redirect()->route('mapelKelas.index')->with('success', 'Terdelet');
    }

   

    public function getKelas(Request $request){
        $kelas = Kelas::where('id_sekolah', $request->sekolahID)->pluck('id_kelas', 'nama_kelas');
        return response()->json($kelas);
    }

    public function getMapel(Request $request){
        $mapel = DataPelajaran::where('id_sekolah', $request->sekolahID)->pluck('id_pelajaran', 'nama_pelajaran');
        return response()->json($mapel);
    }

}
