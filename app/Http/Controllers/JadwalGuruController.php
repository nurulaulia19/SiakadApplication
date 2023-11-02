<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Sekolah;
use App\Models\DataUser;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use Illuminate\Http\Request;
use App\Models\GuruPelajaran;
use App\Exports\JadwalGuruExport;
use Maatwebsite\Excel\Facades\Excel;

class JadwalGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->user_id;

        // Ambil semua data guru pelajaran berdasarkan user_id
        // $dataGp = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
        //     ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
        //     ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal')
        //     ->where('data_guru_pelajaran.user_id', $user_id)
        //     ->orderBy('data_guru_pelajaran.id_gp', 'DESC')
        //     ->paginate(10);

        $dataGp = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal')
            ->where('data_guru_pelajaran.user_id', $user_id);

        if ($request->has('sekolah') && $request->sekolah) {
            $dataGp->where('data_sekolah.id_sekolah', $request->sekolah);
        }

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $dataGp->where('data_guru_pelajaran.tahun_ajaran', $request->tahun_ajaran);
        }

        $dataGp = $dataGp->orderBy('data_guru_pelajaran.id_gp', 'DESC')->paginate(10);

        $listSekolah = GuruPelajaran::where('user_id', $user_id)
            ->join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->pluck('data_sekolah.nama_sekolah', 'data_sekolah.id_sekolah')
            ->all();
        

        $listTahunAjaran = GuruPelajaran::where('user_id', $user_id)
        ->pluck('tahun_ajaran')
        ->unique()
        ->values()
        ->all();
        // dd($listTahunAjaran);

        $sekolahFilter = $request->input('sekolah');
        $tahunFilter = $request->input('tahun_ajaran');

        
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

        // return view('jadwalGuru.index', compact('dataGp', 'dataSekolah', 'tahunAjarans', 'sekolahFilter', 'tahunAjaranFilter', 'menuItemsWithSubmenus'));
        return view('jadwalGuru.index', compact('dataGp','listSekolah','listTahunAjaran','sekolahFilter','tahunFilter','menuItemsWithSubmenus'));
    }


    public function exportJadwalPDF(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->user_id;
        $dataGp = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal')
            ->where('data_guru_pelajaran.user_id', $user_id);

        if ($request->has('sekolah') && $request->sekolah) {
            $dataGp->where('data_sekolah.id_sekolah', $request->sekolah);
        }

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $dataGp->where('data_guru_pelajaran.tahun_ajaran', $request->tahun_ajaran);
        }

        $dataGp = $dataGp->orderBy('data_guru_pelajaran.id_gp', 'DESC')->paginate(10);

        $listSekolah = GuruPelajaran::where('user_id', $user_id)
            ->join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->pluck('data_sekolah.nama_sekolah', 'data_sekolah.id_sekolah')
            ->all();
        

        $listTahunAjaran = GuruPelajaran::where('user_id', $user_id)
        ->pluck('tahun_ajaran')
        ->unique()
        ->values()
        ->all();
        // dd($listTahunAjaran);

        $sekolahFilter = $request->input('sekolah');
        $tahunFilter = $request->input('tahun_ajaran');
        $namaSekolah = '';
        if ($request->has('sekolah') && $request->sekolah) {
            $namaSekolah = Sekolah::find($request->sekolah)->nama_sekolah;
        }
        // Buat opsi PDF
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Inisialisasi Dompdf dengan opsi yang telah ditentukan
        $pdf = new Dompdf($pdfOptions);

        $htmlContent = view('jadwalGuru.eksportJadwalGuru', compact('dataGp','listSekolah','listTahunAjaran','sekolahFilter','tahunFilter','namaSekolah'))->render();

        // Render view dengan data siswa ke dalam HTML
        // $htmlContent = view('jadwalSiswa.eksportJadwalSiswa', compact('tahunAjaranFilter', 'kelasFilter', 'pelajaran', 'message', 'namaKelas', 'guruPelajaran'))->render();

        // Muat konten HTML ke dalam Dompdf
        $pdf->loadHtml($htmlContent);

        // Atur ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Render PDF
        $pdf->render();

        // Kembalikan PDF untuk diunduh
        return $pdf->stream('Jadwal Mata Pelajaran.pdf');
    }

    public function exportJadwalExcel(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->user_id;
        $dataGp = GuruPelajaran::join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->with('user', 'kelas', 'sekolah', 'mapel', 'guruMapelJadwal')
            ->where('data_guru_pelajaran.user_id', $user_id);

        if ($request->has('sekolah') && $request->sekolah) {
            $dataGp->where('data_sekolah.id_sekolah', $request->sekolah);
        }

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $dataGp->where('data_guru_pelajaran.tahun_ajaran', $request->tahun_ajaran);
        }

        $dataGp = $dataGp->orderBy('data_guru_pelajaran.id_gp', 'DESC')->paginate(10);

        $listSekolah = GuruPelajaran::where('user_id', $user_id)
            ->join('data_kelas', 'data_kelas.id_kelas', '=', 'data_guru_pelajaran.id_kelas')
            ->join('data_sekolah', 'data_sekolah.id_sekolah', '=', 'data_kelas.id_sekolah')
            ->pluck('data_sekolah.nama_sekolah', 'data_sekolah.id_sekolah')
            ->all();
        

        $listTahunAjaran = GuruPelajaran::where('user_id', $user_id)
        ->pluck('tahun_ajaran')
        ->unique()
        ->values()
        ->all();
        // dd($listTahunAjaran);

        $sekolahFilter = $request->input('sekolah');
        $tahunFilter = $request->input('tahun_ajaran');
        // $namaSekolah = Sekolah::find($sekolahFilter)->nama_sekolah;
        $namaSekolah = '';
        if ($request->has('sekolah') && $request->sekolah) {
            $namaSekolah = Sekolah::find($request->sekolah)->nama_sekolah;
        }


        return Excel::download(new JadwalGuruExport($dataGp,$listSekolah,$listTahunAjaran,$sekolahFilter,$tahunFilter, $namaSekolah), 'Jadwal Mata Pelajaran.xlsx');

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
