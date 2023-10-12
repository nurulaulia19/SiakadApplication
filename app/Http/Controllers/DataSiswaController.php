<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use Barryvdh\DomPDF\PDF;
use App\Models\Data_Menu;
use App\Models\DataSiswa;
use Illuminate\Support\Str;
use App\Exports\SiswaExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class DataSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $dataSiswa = DataSiswa::orderBy('id_siswa', 'DESC')->paginate(10);

        $tahunList = DB::table('data_siswa')
        ->select(DB::raw('YEAR(tahun_masuk) as tahun'))
        ->groupBy(DB::raw('YEAR(tahun_masuk)'))
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

        $selectedYear = $request->input('tahun_filter'); // Get the selected year from the form
        $searchTerm = $request->input('search');

        $dataSiswaQuery = DB::table('data_siswa');

        $dataSiswaList = DataSiswa::with('sekolah') // Eager load the 'sekolah' relationship
        ->when($selectedYear, function ($query) use ($selectedYear) {
            $query->where('tahun_masuk', '=', $selectedYear);
        })
        ->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('nama_siswa', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nis_siswa', 'like', '%' . $searchTerm . '%');
            });
        })
        ->orderBy('id_siswa', 'DESC')
        ->paginate(10);
            
        // $dataSiswaList = $dataSiswaQuery->orderBy('id_siswa', 'DESC')->with('sekolah')->paginate(10);
        
        // $dataSiswaList = $query->paginate(10);


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


        return view('siswa.index', compact('menuItemsWithSubmenus','tahunList','dataSiswaList','selectedYear','searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataSiswa = DataSiswa::all();
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

            return view('siswa.create', compact('dataSiswa','menuItemsWithSubmenus','dataSekolah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto_siswa' => 'required|file|mimes:jpeg,jpg,png',
            'nis_siswa' => 'required|unique:data_siswa,nis_siswa',
            'nama_siswa' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'tahun_masuk' => 'required',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if ($request->hasFile('foto_siswa')) {
            $file = $request->file('foto_siswa');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            // $fileName = $file->getClientOriginalName();
            $file->storeAs('public/photos', $fileName); 
        } else {
            $fileName = null;
        }
        
    
        $hashedPassword = Hash::make($request->nis_siswa); 

        $dataSiswa = new DataSiswa;
        $dataSiswa->id_siswa = $request->id_siswa;
        $dataSiswa->id_sekolah = $request->id_sekolah;
        $dataSiswa->nama_siswa = $request->nama_siswa;
        $dataSiswa->nis_siswa = $request->nis_siswa;
        $dataSiswa->tempat_lahir = $request->tempat_lahir;
        $dataSiswa->tanggal_lahir = $request->tanggal_lahir;
        $dataSiswa->jenis_kelamin = $request->jenis_kelamin;
        $dataSiswa->tahun_masuk = $request->tahun_masuk;
        $dataSiswa->foto_siswa = $fileName;
        $dataSiswa->password =$hashedPassword;
        $dataSiswa->save();
    
        return redirect()->route('siswa.index')->with('success', 'Siswa inserted successfully');
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
    public function edit($id_siswa)
    {
        $dataSiswa = DataSiswa::where('id_siswa', $id_siswa)->first();
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
        return view('siswa.update', compact('dataSiswa','menuItemsWithSubmenus','dataSekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_siswa)
    {
        $validator = Validator::make($request->all(), [
            'nis_siswa' => [
                'required',
                Rule::unique('data_siswa', 'nis_siswa')->ignore($id_siswa, 'id_siswa'),
            ],
            'foto_siswa' => 'file|mimes:jpeg,jpg,png',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
            
        ]);
        

        

        if ($request->filled('password')) {
            $validator->sometimes('password', 'required', function ($input) {
                return $input->password !== null;
            });
        }
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // $hashedPassword = Hash::make($request->password);
        $hashedPassword = Hash::make($request->nis_siswa); 
    
        $dataSiswa = DataSiswa::find($id_siswa); // Menggunakan find untuk mengambil data yang sudah ada

// Hapus baris berikut karena Anda sudah menggunakan DataSiswa::find
// $dataSiswa = new DataSiswa;

    $dataSiswa->id_sekolah = $request->id_sekolah;
    $dataSiswa->nama_siswa = $request->nama_siswa;
    $dataSiswa->nis_siswa = $request->nis_siswa;
    $dataSiswa->tempat_lahir = $request->tempat_lahir;
    $dataSiswa->tanggal_lahir = $request->tanggal_lahir;
    $dataSiswa->jenis_kelamin = $request->jenis_kelamin;
    $dataSiswa->tahun_masuk = $request->tahun_masuk;
    $dataSiswa->password = $hashedPassword;

    if ($request->hasFile('foto_siswa')) {
        $file = $request->file('foto_siswa');
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::random(40) . '.' . $extension;
        $file->storeAs('public/photos', $fileName);
        $dataSiswa->foto_siswa = $fileName;
    }

    $dataSiswa->save();
    
        return redirect()->route('siswa.index')->with('success', 'Siswa edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_siswa)
    {
        $dataSiswa = DataSiswa::where('id_siswa', $id_siswa);
        $dataSiswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Terdelet');
    }

    public function exportPDF(Request $request, $tahun = null)
    {
        // Ambil data siswa berdasarkan tahun yang dipilih jika tahun ada, atau ambil semua data jika tidak ada tahun yang dipilih
        if ($tahun) {
            $dataSiswa = DataSiswa::where('tahun_masuk', $tahun)->get();
        } else {
            $dataSiswa = DataSiswa::all();
        }

        // Buat opsi PDF
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Inisialisasi Dompdf dengan opsi yang telah ditentukan
        $pdf = new Dompdf($pdfOptions);

        // Render view dengan data siswa ke dalam HTML
        $htmlContent = view('siswa.eksportSiswa', compact('dataSiswa','tahun'))->render();

        // Muat konten HTML ke dalam Dompdf
        $pdf->loadHtml($htmlContent);

        // Atur ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Render PDF
        $pdf->render();

        // Kembalikan PDF untuk diunduh
        return $pdf->stream('data-siswa.pdf');
    }

    public function exportExcel($tahun = null)
    {
        // Lakukan pemrosesan jika perlu berdasarkan tahun yang diberikan
        if ($tahun) {
            $dataSiswa = DataSiswa::where('tahun_masuk', $tahun)->get();
        } else {
            $dataSiswa = DataSiswa::all();
        }

        // Panggil kelas eksport yang telah Anda buat
        return Excel::download(new SiswaExport($tahun, $dataSiswa), 'data-siswa.xlsx');
    }


}
