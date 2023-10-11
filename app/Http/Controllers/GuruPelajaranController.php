<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Role;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\DataNilai;
use App\Models\DataSiswa;
use App\Models\DataAbsensi;
use App\Exports\NilaiExport;
use Illuminate\Http\Request;
use App\Models\AbsensiDetail;
use App\Models\DataPelajaran;
use App\Models\GuruPelajaran;
use App\Models\KategoriNilai;
use App\Models\KenaikanKelas;
use App\Exports\AbsensiExport;
use App\Models\PelajaranKelas;
use Illuminate\Validation\Rule;
use App\Exports\DetailNilaiExport;
use App\Models\PelajaranKelasList;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\GuruPelajaranJadwal;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class GuruPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','guruMapelJadwal')->orderBy('id_gp', 'DESC')->paginate(10);

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
    return view('guruMapel.index', compact('dataGp','menuItemsWithSubmenus'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataGp = GuruPelajaran::all();
        $dataPelajaran = DataPelajaran::all();
        // $dataUser = DataUser::all();
        $guruRoleId = Role::where('role_name', 'guru')->value('role_id'); // Mendapatkan ID peran "guru"

        $dataUser = DataUser::whereHas('role', function ($query) use ($guruRoleId) {
            $query->where('role_id', $guruRoleId);
        })->get();

        $dataSekolah = Sekolah::all();
        $dataKelas = Kelas::all();

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
        return view('guruMapel.create', compact('dataGp','dataUser','dataPelajaran','dataKelas','dataSekolah','menuItemsWithSubmenus'));
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
                Rule::unique('data_guru_pelajaran')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('id_kelas', $request->id_kelas)
                        ->where('tahun_ajaran', $request->tahun_ajaran)
                        ->where('id_pelajaran', $request->id_pelajaran)
                        ->where('user_id', $request->user_id);
                }),
            ],
            'id_kelas' => 'required',
            'tahun_ajaran' => 'required',
        ], $customMessages);
        
        $dataGp = new GuruPelajaran;
        $dataGp->id_sekolah = $request->id_sekolah;
        $dataGp->id_pelajaran = $request->id_pelajaran;
        $dataGp->id_kelas = $request->id_kelas;
        $dataGp->user_id = $request->user_id;
        $dataGp->tahun_ajaran = $request->tahun_ajaran;
        $dataGp->save();
        

        return redirect()->route('guruMapel.index')->with('success', 'Guru Mata Pelajaran insert successfully');
            
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
    public function edit($id_gp)
    {
        
        $dataSekolah = Sekolah::all();
       
        $guruRoleId = Role::where('role_name', 'guru')->value('role_id'); // Mendapatkan ID peran "guru"

        $dataUser = DataUser::whereHas('role', function ($query) use ($guruRoleId) {
            $query->where('role_id', $guruRoleId);
        })->get();
        $selectedMapelId = GuruPelajaran::where('id_gp', $id_gp)->pluck('id_pelajaran')->toArray();
        // $selectedMapelId = PelajaranKelas::where('id_pk', $id_pk)->first()->id_pelajaran;
        $dataGp = GuruPelajaran::where('id_gp', $id_gp)->first();
        $dataPelajaran = DataPelajaran::where('id_sekolah', $dataGp->id_sekolah)->get();
        $dataKelas = Kelas::where('id_sekolah', $dataGp->id_sekolah)->get();
        
    
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
        return view('guruMapel.update', compact('dataGp','dataSekolah','dataKelas','dataUser','dataPelajaran','menuItemsWithSubmenus','selectedMapelId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_gp)
    {
        
        $customMessages = [
            'id_sekolah.unique' => 'Data sudah ada.'
            // Add other custom error messages as needed
        ];
        
        $validatedData = $request->validate([
            'id_sekolah' => [
                'required',
                Rule::unique('data_guru_pelajaran')->ignore($id_gp, 'id_gp')->where(function ($query) use ($request) {
                    return $query->where('id_sekolah', $request->id_sekolah)
                        ->where('id_kelas', $request->id_kelas)
                        ->where('tahun_ajaran', $request->tahun_ajaran)
                        ->where('id_pelajaran', $request->id_pelajaran)
                        ->where('user_id', $request->user_id);
                }),
            ],
            'id_kelas' => 'required',
            'tahun_ajaran' => 'required',
        ], $customMessages);

        DB::table('data_guru_pelajaran')->where('id_gp', $id_gp)->update([
            'id_kelas' => $request->id_kelas,
            'id_pelajaran' => $request->id_pelajaran,
            'user_id' => $request->user_id,
            'id_sekolah' => $request->id_sekolah,
            'tahun_ajaran' => $request->tahun_ajaran,
            'created_at' => now(),
            'updated_at' => now()

    ]);

    return redirect()->route('guruMapel.index')->with('success', 'Guru Mata Pelajaran edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_gp){
        $dataGp = GuruPelajaran::where('id_gp', $id_gp);
        $dataGp->delete();
        $dataGpj = GuruPelajaranJadwal::where('id_gp', $id_gp);
        $dataGpj->delete();
        return redirect()->route('guruMapel.index')->with('success', 'Terdelet');
    }

    public function getKelas(Request $request){
        $kelas = Kelas::where('id_sekolah', $request->sekolahID)->pluck('id_kelas', 'nama_kelas');
        return response()->json($kelas);
    }

    public function getMapel(Request $request){
        $mapel = DataPelajaran::where('id_sekolah', $request->sekolahID)->pluck('id_pelajaran', 'nama_pelajaran');
        return response()->json($mapel);
    }

    public function nilai(Request $request) {
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','kategoriNilai')->orderBy('id_gp', 'DESC')->paginate(10);
        $id_kn = $request->input('id_kn');
        // dd($id_kn);
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
    return view('dataNilai.nilai', compact('dataGp','menuItemsWithSubmenus','id_kn'));
    }


    public function detailNilai(Request $request, $id_gp) {
        // $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel')->orderBy('id_gp', 'DESC')->paginate(10);
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','siswa')->where('id_gp', $id_gp)->first();
        $dataKn = KategoriNilai::all();
        $tab = $request->query('tab');
        $dataSekolah = Sekolah::all();
        $id_kn = session('id_kn');
       

        if ($dataGp->count() > 0) {
            // Mengambil objek GuruPelajaran pertama dari koleksi
            $guruPelajaran = $dataGp;
        
            // Mengakses properti tahun_ajaran dari objek GuruPelajaran
            $tahunAjaran = $guruPelajaran->tahun_ajaran;
        
            // 3. Gunakan tahun ajaran sebagai filter dalam query
            $dataKk = KenaikanKelas::join('data_guru_pelajaran', 'data_kenaikan_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
                ->where('data_guru_pelajaran.id_gp', $id_gp)
                ->where('data_kenaikan_kelas.tahun_ajaran', '=', $tahunAjaran)
                ->orderBy('data_kenaikan_kelas.id_kk', 'desc')
                ->select(
                    // 'data_kenaikan_kelas.id_sekolah',
                    // 'data_kenaikan_kelas.id_kelas',
                    // 'data_kenaikan_kelas.tahun_ajaran',
                    'data_kenaikan_kelas.id_kk', // Kolom id_kk
                    'data_kenaikan_kelas.nis_siswa', // Kolom nis_siswa
                )
                ->with('siswa') 
                ->paginate(10);

        } else {
            // Handle jika data GuruPelajaran tidak ditemukan
            session()->flash('warning', 'Data Guru Pelajaran tidak ditemukan.');
            return redirect()->back();
        }
        

        
        // dd($id_gp);
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

        return view('dataNilai.detail', compact('dataGp','menuItemsWithSubmenus','dataKn','dataKk','tab','id_gp'));
    }

    public function storeNilai(Request $request)
    {
        $nis_siswa = $request->input('nis_siswa');
        $nilai = $request->input('nilai');
        $id_gp = $request->input('id_gp');
        $kategori = $request->input('kategori');

        // Hapus data yang sudah ada dengan kriteria yang sama
        DataNilai::where('id_gp', $id_gp)
            ->where('kategori', $kategori)
            ->whereIn('nis_siswa', $nis_siswa)
            ->delete();

        // Simpan data baru
        foreach ($nis_siswa as $key => $nis) {
            $dataNilai = new DataNilai;
            $dataNilai->id_gp = $id_gp;
            $dataNilai->kategori = $kategori;
            $dataNilai->nis_siswa = $nis;
            $dataNilai->nilai = $nilai[$key];
            $dataNilai->save();
        }

        return redirect()->route('dataNilai.detail', ['id_gp' => $id_gp, 'tab'=> $kategori
        ])->with('success', 'Nilai insert successfully');
    }


    public static function getNilai ($id_gp, $kategori, $nis_siswa) {
        // $id_nilai = 13;
        $dataNilai = DataNilai::where('id_gp', $id_gp)
        ->where('kategori', $kategori)
        ->where('nis_siswa', $nis_siswa)->first();

        return @$dataNilai->nilai;
    }


    public function exportToPDF(Request $request, $id_gp, $id_kn)
    {
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','siswa')->where('id_gp', $id_gp)->first();
        // $requested_menu = Data_Menu::where('menu_link', $menu_route_name)->first();
        $dataKn = KategoriNilai::where('id_kn', $id_kn)->first();

        $dataSekolah = Sekolah::all();
        $tab = $request->query('tab');
        $kategori = KategoriNilai::all();
        

        if ($dataGp->count() > 0) {
            // Mengambil objek GuruPelajaran pertama dari koleksi
            $guruPelajaran = $dataGp;
        
            // Mengakses properti tahun_ajaran dari objek GuruPelajaran
            $tahunAjaran = $guruPelajaran->tahun_ajaran;
        
            // 3. Gunakan tahun ajaran sebagai filter dalam query
            // $dataKk = KenaikanKelas::join('data_guru_pelajaran', 'data_kenaikan_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            //     ->where('data_guru_pelajaran.id_gp', $id_gp)
            //     ->where('data_kenaikan_kelas.tahun_ajaran', '=', $tahunAjaran)
            //     ->orderBy('data_kenaikan_kelas.id_kk', 'desc')
            //     ->select(
            //         // 'data_kenaikan_kelas.id_sekolah',
            //         // 'data_kenaikan_kelas.id_kelas',
            //         // 'data_kenaikan_kelas.tahun_ajaran',
            //         'data_kenaikan_kelas.id_kk', // Kolom id_kk
            //         'data_kenaikan_kelas.nis_siswa', // Kolom nis_siswa
            //     )
            //     ->with('siswa') 
            //     ->get();
            $dataKk = KenaikanKelas::join('data_guru_pelajaran', 'data_kenaikan_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_kategori_nilai', 'data_kategori_nilai.id_sekolah', '=', 'data_guru_pelajaran.id_sekolah')
            ->where('data_guru_pelajaran.id_gp', $id_gp)
            ->where('data_kenaikan_kelas.tahun_ajaran', '=', $tahunAjaran)
            ->where('data_kategori_nilai.id_kn', $id_kn) // Menambahkan kondisi WHERE untuk id_kn
            ->orderBy('data_kenaikan_kelas.id_kk', 'desc')
            ->select(
                'data_kenaikan_kelas.id_kk',
                'data_kenaikan_kelas.nis_siswa'
            )
            ->with('siswa')
            ->get();

            // dd($dataKk);
        } else {
            // Handle jika data GuruPelajaran tidak ditemukan
            session()->flash('warning', 'Data Guru Pelajaran tidak ditemukan.');
            return redirect()->back();
        }
        
        
        $paperSize = $request->input('paper_size', 'A4');

        // $dataNilai = $query->get();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Set ukuran kertas sesuai dengan parameter yang diambil dari request
        $pdfOptions->set('size', $paperSize);

        $pdf = new Dompdf($pdfOptions);

        // Render the view with data and get the HTML content
        $htmlContent = View::make('dataNilai.eksportNilai', compact('dataKk','dataGp','dataKn','tab','kategori'))->render();

        $pdf->loadHtml($htmlContent);

        $pdf->setPaper($paperSize, 'portrait'); // Atur ukuran kertas secara dinamis

        $pdf->render();

        return $pdf->stream('data-nilai.pdf');
    }

    public function exportToExcel(Request $request, $id_gp, $id_kn)
    {
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','siswa')->where('id_gp', $id_gp)->first();
            // $requested_menu = Data_Menu::where('menu_link', $menu_route_name)->first();
        $dataKn = KategoriNilai::where('id_kn', $id_kn)->first();

        $dataSekolah = Sekolah::all();
        $tab = $request->query('tab');
            if ($dataGp->count() > 0) {
                // Mengambil objek GuruPelajaran pertama dari koleksi
                $guruPelajaran = $dataGp;
            
                // Mengakses properti tahun_ajaran dari objek GuruPelajaran
                $tahunAjaran = $guruPelajaran->tahun_ajaran;
            
                $dataKk = KenaikanKelas::join('data_guru_pelajaran', 'data_kenaikan_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
                ->join('data_kategori_nilai', 'data_kategori_nilai.id_sekolah', '=', 'data_guru_pelajaran.id_sekolah')
                ->where('data_guru_pelajaran.id_gp', $id_gp)
                ->where('data_kenaikan_kelas.tahun_ajaran', '=', $tahunAjaran)
                ->where('data_kategori_nilai.id_kn', $id_kn) // Menambahkan kondisi WHERE untuk id_kn
                ->orderBy('data_kenaikan_kelas.id_kk', 'desc')
                ->select(
                    'data_kenaikan_kelas.id_kk',
                    'data_kenaikan_kelas.nis_siswa'
                )
                ->with('siswa')
                ->get();

                // dd($dataKk);
            } else {
                // Handle jika data GuruPelajaran tidak ditemukan
                session()->flash('warning', 'Data Guru Pelajaran tidak ditemukan.');
                return redirect()->back();
            }

        return Excel::download(new NilaiExport($dataKn, $dataGp, $dataSekolah, $tab, $dataKk), 'data-nilai.xlsx');
    }

    public function absensi(Request $request) {
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','kategoriNilai')->orderBy('id_gp', 'DESC')->paginate(10);
        $id_kn = $request->input('id_kn');
        // dd($id_kn);
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
                }// menu
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
    return view('dataAbsensi.absensi', compact('dataGp','menuItemsWithSubmenus','id_kn'));
    }

    public function detailAbsensi(Request $request, $id_gp) {
        $dataGp = GuruPelajaran::with('user','kelas','sekolah','mapel','siswa')->where('id_gp', $id_gp)->first();
        // $dataAd = DataAbsensi::where('id_gp', $id_gp)->get();
        $tab = $request->query('tab');
        $dataSekolah = Sekolah::all();
        $dataAbsensi = DataAbsensi::where('id_gp', $id_gp)->get();
        // $tab = $request->query('tab');
    
        if ($dataGp->count() > 0) {
            // Mengambil objek GuruPelajaran pertama dari koleksi
            $guruPelajaran = $dataGp;
        
            // Mengakses properti tahun_ajaran dari objek GuruPelajaran
            $tahunAjaran = $guruPelajaran->tahun_ajaran;
        
            // 3. Gunakan tahun ajaran sebagai filter dalam query
            $dataKk = KenaikanKelas::join('data_guru_pelajaran', 'data_kenaikan_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
                ->where('data_guru_pelajaran.id_gp', $id_gp)
                ->where('data_kenaikan_kelas.tahun_ajaran', '=', $tahunAjaran)
                ->orderBy('data_kenaikan_kelas.id_kk', 'desc')
                ->select(
                    // 'data_kenaikan_kelas.id_sekolah',
                    // 'data_kenaikan_kelas.id_kelas',
                    // 'data_kenaikan_kelas.tahun_ajaran',
                    'data_kenaikan_kelas.id_kk', // Kolom id_kk
                    'data_kenaikan_kelas.nis_siswa', // Kolom nis_siswa
                )
                ->with('siswa') 
                ->get();
        } else {
            // Handle jika data GuruPelajaran tidak ditemukan
            session()->flash('warning', 'Data Guru Pelajaran tidak ditemukan.');
            return redirect()->back();
        }
        // dd($id_gp);
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

        return view('dataAbsensi.detail', compact('dataGp','menuItemsWithSubmenus','tab','dataAbsensi','dataKk','tab'));
    }

    public function storeAbsensi(Request $request)
    {
        $id_gp = $request->input('id_gp');
        $dataAbsensi = new DataAbsensi();
        $dataAbsensi->id_gp = $request->id_gp;
        $dataAbsensi->tanggal = $request->tanggal;
        $dataAbsensi->save();

        return redirect()->route('dataAbsensi.detail', ['id_gp' => $id_gp, 
        ])->with('success', 'Absensi insert successfully');

        
            
    }

    public function storeAbsensiDetail(Request $request)
    {
        $this->validate($request, [
            'keterangan' => 'required',
        ]);

        $id_absensi = $request->input('id_absensi');
        $nis_siswa = $request->input('nis_siswa');
        $id_gp = $request->input('id_gp');
        $keterangan = $request->input('keterangan');
        $tanggal = $request->input('tanggal');

        // Hapus data yang sudah ada dengan kriteria yang sama
        AbsensiDetail::where('id_gp', $id_gp)
            ->where('id_absensi', $id_absensi)
            ->where('tanggal', $tanggal)
            ->delete();

        // Simpan data baru
        foreach ($nis_siswa as $key => $nis_value) {
            $dataAd = new AbsensiDetail();
            $dataAd->id_gp = $id_gp;
            $dataAd->id_absensi = $id_absensi;
            $dataAd->nis_siswa = $nis_value;
            $dataAd->keterangan = $keterangan[$key];
            $dataAd->tanggal = $tanggal;
            $dataAd->save();
        }

        return redirect()->route('dataAbsensi.detail', ['id_gp' => $id_gp, 'tab'=> $id_absensi
        ])->with('success', 'Absensi Detail insert successfully');
            
        // return redirect()->route('dataNilai.detail', ['id_gp' => $id_gp, 'tab'=> $kategori
        // ])->with('success', 'Nilai insert successfully');
    }

    public function destroyAbsensi($id_absensi){
        // 1. Cari id_gp dan data absensi detail berdasarkan id_absensi
        $dataAbsensi = DataAbsensi::where('id_absensi', $id_absensi)->first();
        
        // Pastikan id_gp ditemukan sebelum melanjutkan
        if (!$dataAbsensi) {
            return redirect()->route('dataAbsensi.index')->with('error', 'Data Absensi tidak ditemukan.');
        }
        
        // 2. Lakukan penghapusan data absensi detail dengan id_absensi yang sama
        AbsensiDetail::where('id_absensi', $id_absensi)->delete();
        
        // 3. Lakukan penghapusan data absensi
        $dataAbsensi->delete();
        
        // 4. Gunakan id_gp dalam pengalihan
        $id_gp = $dataAbsensi->id_gp;
        
        return redirect()->route('dataAbsensi.detail', ['id_gp' => $id_gp])
            ->with('success', 'Data Absensi berhasil dihapus.');
    }
    
    public static function getAbsensiDetail ($id_gp, $id_absensi, $tanggal, $nis_siswa) {
        // $id_nilai = 13;
        $dataAd = AbsensiDetail::where('id_gp', $id_gp)
        ->where('id_absensi', $id_absensi)
        ->where('tanggal', $tanggal)
        ->where('nis_siswa', $nis_siswa)->first();

        return @$dataAd->keterangan;
    }


    public static function getKeterangan ($id_gp, $tanggal, $nis_siswa) {
        $dataAd = AbsensiDetail::where('id_gp', $id_gp)
        ->where('tanggal', $tanggal)
        ->where('nis_siswa', $nis_siswa)->first();

        return @$dataAd->keterangan;
    }

    public function cekNilai(Request $request)
    {
        $dataSekolah = Sekolah::all();
        $dataSiswa = DataSiswa::all();
        $id_sekolah = $request->input('id_sekolah');
        // Check if the form has been submitted
        if (request()->isMethod('post')) {
            $id_sekolah = request()->input('id_sekolah');
            $nis_siswa = request()->input('nis_siswa');

            // Query the database to retrieve grades based on $id_sekolah and $nis_siswa
            $dataNilai = DataNilai::where('id_sekolah', $id_sekolah)
                ->whereIn('nis_siswa', $nis_siswa)
                ->get();
        } else {
            // If the form hasn't been submitted yet, initialize $dataNilai as an empty array
            $dataNilai = [];
        }

        $dataKategori = KategoriNilai::where('id_sekolah', $id_sekolah)
            ->orderBy('id_kn', 'desc')
            ->get();

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
        return view('dataNilai.cekNilai', compact('dataSekolah','dataSiswa','dataNilai','menuItemsWithSubmenus','dataKategori'));
    }

    public function tampilkanNilai(Request $request)
    {
        $id_sekolah = $request->input('id_sekolah');
        $nis_siswa = $request->input('nis_siswa');
    
        $dataSekolah = Sekolah::all();
        
        $dataNilai = DataNilai::join('data_guru_pelajaran', 'data_nilai.id_gp', '=', 'data_guru_pelajaran.id_gp')
            ->with(['guruPelajaran.mapel', 'siswa', 'kategoriNilai', 'guruPelajaran.user'])
            ->whereIn('nis_siswa', $nis_siswa)
            ->where('id_sekolah', $id_sekolah)
            ->orderBy('data_guru_pelajaran.tahun_ajaran', 'desc')
            ->groupBy('data_nilai.id_gp')
            ->get();


        $dataKategori = KategoriNilai::where('id_sekolah', $id_sekolah)
            ->orderBy('id_kn', 'desc')
            ->get();

        // Mengambil user_id dari guru yang mengajar mata pelajaran yang ditampilkan dalam query
        $user_ids = $dataNilai->pluck('guruPelajaran.user.user_id')->unique();

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

        return view('dataNilai.cekNilai', compact('nis_siswa', 'dataNilai', 'dataSekolah','menuItemsWithSubmenus','id_sekolah','dataKategori'));
    }

    public function exportNilaiToPDF(Request $request, $id_sekolah, $nis_siswa)
    {
        $dataSekolah = Sekolah::where('id_sekolah', $id_sekolah)->first();
        // dd($dataSekolah);
        // dd($dataSekolah);
        $dataNilai = DataNilai::join('data_guru_pelajaran', 'data_nilai.id_gp', '=', 'data_guru_pelajaran.id_gp')
            ->with('guruPelajaran.mapel', 'siswa', 'kategoriNilai')
            ->where('nis_siswa', $nis_siswa)
            ->where('id_sekolah', $id_sekolah)
            ->orderBy('data_guru_pelajaran.tahun_ajaran', 'desc')
            ->groupBy('data_nilai.id_gp')
            ->get();
        
        $dataKategori = KategoriNilai::where('id_sekolah', $id_sekolah)
            ->orderBy('id_kn', 'desc')
            ->get();
        
        $paperSize = $request->input('paper_size', 'A4');

        // $dataNilai = $query->get();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Set ukuran kertas sesuai dengan parameter yang diambil dari request
        $pdfOptions->set('size', $paperSize);

        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isPhpEnabled', true);
        $pdfOptions->set('isDebug', true);
        $pdf = new Dompdf($pdfOptions);

        // Render the view with data and get the HTML content
        $htmlContent = View::make('dataNilai.eksportDetailNilai', compact('dataSekolah','dataNilai','dataKategori'))->render();

        $pdf->loadHtml($htmlContent);

        $pdf->setPaper($paperSize, 'portrait'); // Atur ukuran kertas secara dinamis

        $pdf->render();

        return $pdf->stream('data-detail-nilai.pdf');
    }    

    public function exportNilaiToExcel($id_sekolah, $nis_siswa)
    {
        $dataSekolah = Sekolah::where('id_sekolah', $id_sekolah)->first();
        // dd($dataSekolah);
        $dataNilai = DataNilai::join('data_guru_pelajaran', 'data_nilai.id_gp', '=', 'data_guru_pelajaran.id_gp')
            ->with('guruPelajaran.mapel', 'siswa', 'kategoriNilai')
            ->where('nis_siswa', $nis_siswa)
            ->where('id_sekolah', $id_sekolah)
            ->orderBy('data_guru_pelajaran.tahun_ajaran', 'desc')
            ->groupBy('data_nilai.id_gp')
            ->get();

            $dataNilai2 = DataNilai::join('data_guru_pelajaran', 'data_nilai.id_gp', '=', 'data_guru_pelajaran.id_gp')
            ->with('guruPelajaran.mapel', 'siswa', 'kategoriNilai')
            ->where('nis_siswa', $nis_siswa)
            ->where('id_sekolah', $id_sekolah)
            ->orderBy('data_guru_pelajaran.tahun_ajaran', 'desc')
            ->groupBy('data_nilai.id_gp')
            ->groupBy('kategori')->get();
        
        $dataKategori = KategoriNilai::where('id_sekolah', $id_sekolah)
            ->orderBy('id_kn', 'desc')
            ->get();
        // dd($dataNilai2);

        return Excel::download(new DetailNilaiExport($dataSekolah, $dataNilai, $dataNilai2, $dataKategori), 'data-detail-nilai.xlsx');
    }

    public function laporanAbsensi(Request $request)
    {
        $id_sekolah = $request->input('id_sekolah');
        $id_kelas = $request->input('id_kelas');
        $tahun_ajaran = $request->input('tahun_ajaran');
        $id_pelajaran = $request->input('id_pelajaran');
        // $id_gp = $request->input('id_gp');

        // dd($nis_siswa);
        $dataSekolah = Sekolah::all();
        // dd($dataSekolah);
        $dataAd = AbsensiDetail::join('data_guru_pelajaran as dgp', 'data_absensi_detail.id_gp', '=', 'dgp.id_gp')
        ->with('guruPelajaran.mapel', 'siswa')
        ->where('dgp.id_sekolah', $id_sekolah)
        ->where('dgp.id_kelas', $id_kelas)
        ->where('dgp.tahun_ajaran', $tahun_ajaran)
        // ->where('dgp.id_gp', $id_gp)
        ->get();


        $uniqueDates = collect($dataAd)->pluck('tanggal')->unique();


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
        return view('dataAbsensi.laporanAbsensi', compact('dataAd', 'dataSekolah','menuItemsWithSubmenus','id_sekolah','id_kelas','tahun_ajaran','uniqueDates','id_pelajaran'));
    }

    public function tampilkanAbsensi(Request $request)
    {
        $id_sekolah = $request->input('id_sekolah');
        $id_kelas = $request->input('id_kelas');
        $tahun_ajaran = $request->input('tahun_ajaran');
        $id_pelajaran = $request->input('id_pelajaran');
       

        $dataSekolah = Sekolah::all();
        dd($dataSekolah);
        $dataAd = AbsensiDetail::join('data_guru_pelajaran as dgp', 'data_absensi_detail.id_gp', '=', 'dgp.id_gp')
            ->with('guruPelajaran.mapel','siswa')
            ->where('dgp.id_sekolah', $id_sekolah)
            ->where('dgp.id_kelas', $id_kelas)
            ->where('dgp.tahun_ajaran', $tahun_ajaran)
            ->when($id_pelajaran, function ($query) use ($id_pelajaran) {
                $query->where('dgp.id_pelajaran', $id_pelajaran);
            })
            ->groupBy('data_absensi_detail.nis_siswa')
            ->get();
            // dd($dataAd);
    
            // $uniqueDates = DataAbsensi::where('id_gp', $dataAd[0]->id_gp)->get();
        

            // if (empty($dataAd)) {
            //     // Redirect back to the previous page with an error message
            //     return view('dataAbsensi.laporanAbsensi')->with('error', 'No data available.');
            // }

            if ($dataAd->isEmpty()) {
                // Data kosong, arahkan ke halaman sebelumnya atau halaman lain
                return view('dataAbsensi.laporanAbsensi')->with('error', 'No data available.');
            } else {
                $uniqueDates = DataAbsensi::where('id_gp', $dataAd[0]->id_gp)->get();
                // Lanjutkan pemrosesan data jika data tidak kosong
                // ...
            }

            

            
        
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

        return view('dataAbsensi.laporanAbsensi', compact('dataAd', 'dataSekolah','menuItemsWithSubmenus','id_sekolah','id_kelas','tahun_ajaran','uniqueDates','id_pelajaran'));
    }

    public function getMapelByKelas(Request $request)
    {
        $kelasID = $request->input('kelasID');
        $sekolahID = $request->input('sekolahID');
        $tahunAjaranID = $request->input('tahunAjaranID');

        // Ubah 'id_pelajaran' menjadi 'id_kelas' dalam query berikut
        $pels = PelajaranKelas::where('id_kelas', $kelasID)
        ->where('id_sekolah', $sekolahID)
        ->where('tahun_ajaran', $tahunAjaranID)->first();

        $mapels= PelajaranKelasList::join('data_pelajaran', 'data_pelajaran.id_pelajaran', '=', 'data_pelajaran_kelas_list.id_pelajaran')
        ->where('id_pk', $pels->id_pk)->select('data_pelajaran_kelas_list.id_pelajaran', 'nama_pelajaran')->get();

       

        return response()->json($mapels);
    }


    public function exportAbsensiToPDF(Request $request, $id_sekolah, $id_kelas, $tahun_ajaran, $id_pelajaran)
    {
       
        $dataSekolah = Sekolah::where('id_sekolah', $id_sekolah)->first();
        $dataAd = AbsensiDetail::join('data_guru_pelajaran as dgp', 'data_absensi_detail.id_gp', '=', 'dgp.id_gp')
            ->with('guruPelajaran.mapel','siswa')
            ->where('dgp.id_sekolah', $id_sekolah)
            ->where('dgp.id_kelas', $id_kelas)
            ->where('dgp.tahun_ajaran', $tahun_ajaran)
            ->when($id_pelajaran, function ($query) use ($id_pelajaran) {
                $query->where('dgp.id_pelajaran', $id_pelajaran);
            })
            ->groupBy('data_absensi_detail.nis_siswa')
            ->get();
    
        $uniqueDates = DataAbsensi::where('id_gp', $dataAd[0]->id_gp)->get();

        $paperSize = $request->input('paper_size', 'A4');

        // $dataNilai = $query->get();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Set ukuran kertas sesuai dengan parameter yang diambil dari request
        $pdfOptions->set('size', $paperSize);

        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isPhpEnabled', true);
        $pdfOptions->set('isDebug', true);
        $pdf = new Dompdf($pdfOptions);

        // Render the view with data and get the HTML content
        $htmlContent = View::make('dataAbsensi.eksportAbsensi', compact('dataSekolah','dataAd','uniqueDates'))->render();

        $pdf->loadHtml($htmlContent);

        $pdf->setPaper($paperSize, 'portrait'); // Atur ukuran kertas secara dinamis

        $pdf->render();

        return $pdf->stream('data-absensi.pdf');
    } 

    public function exportAbsensiToExcel($id_sekolah, $id_kelas, $tahun_ajaran, $id_pelajaran)
    {
        $dataSekolah = Sekolah::where('id_sekolah', $id_sekolah)->first();
        
        $dataAd = AbsensiDetail::join('data_guru_pelajaran as dgp', 'data_absensi_detail.id_gp', '=', 'dgp.id_gp')
            ->with('guruPelajaran.mapel','siswa')
            ->where('dgp.id_sekolah', $id_sekolah)
            ->where('dgp.id_kelas', $id_kelas)
            ->where('dgp.tahun_ajaran', $tahun_ajaran)
            ->when($id_pelajaran, function ($query) use ($id_pelajaran) {
                $query->where('dgp.id_pelajaran', $id_pelajaran);
            })
            ->groupBy('data_absensi_detail.nis_siswa')
            ->get();
    
        $uniqueDates = DataAbsensi::where('id_gp', $dataAd[0]->id_gp)->get();

        return Excel::download(new AbsensiExport($dataSekolah, $dataAd, $uniqueDates), 'data-absensi.xlsx');
    }
  

}


