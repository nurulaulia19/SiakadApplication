<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\DataBerita;
use App\Models\DataBrosur;
use App\Models\DataGaleri;
use App\Models\DataSlider;
use Illuminate\Http\Request;
use App\Models\DataEkstrakulikuler;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sekolah = Sekolah::all();
        $dataSlider = DataSlider::all();
        $dataBerita = DataBerita::where('status', 'ditampilkan')->orderBy('id_berita', 'desc')->get();
        $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');
        $selectedSekolahId = $request->input('sekolah');

        $ekstrakulikulerOptions = [];
        if ($selectedSekolahId) {
            $ekstrakulikulerOptions = DataEkstrakulikuler::where('id_sekolah', $selectedSekolahId)->pluck('judul', 'id_ekstrakulikuler');
        }
        
        return view('landingPage.index', compact('sekolah','dataSlider','dataBerita','sekolahOptions', 'ekstrakulikulerOptions', 'selectedSekolahId'));
    }

    // public function beritaTari(Request $request)
    // {
    //     $sekolah = Sekolah::all();
    //     $dataSlider = DataSlider::all();
    //     $dataBerita = DataBerita::where('status', 'ditampilkan')->orderBy('id_berita', 'desc')->get();
    //     $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');
    //     $selectedSekolahId = $request->input('sekolah');

    //     $ekstrakulikulerOptions = [];
    //     if ($selectedSekolahId) {
    //         $ekstrakulikulerOptions = DataEkstrakulikuler::where('id_sekolah', $selectedSekolahId)->pluck('judul', 'id_ekstrakulikuler');
    //     }
        
    //     return view('landingPage.berita.tari', compact('sekolah','dataSlider','dataBerita','sekolahOptions', 'ekstrakulikulerOptions', 'selectedSekolahId'));
    // }

    // public function beritaProyek(Request $request)
    // {
    //     $sekolah = Sekolah::all();
    //     $dataSlider = DataSlider::all();
    //     $dataBerita = DataBerita::where('status', 'ditampilkan')->orderBy('id_berita', 'desc')->get();
    //     $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');
    //     $selectedSekolahId = $request->input('sekolah');

    //     $ekstrakulikulerOptions = [];
    //     if ($selectedSekolahId) {
    //         $ekstrakulikulerOptions = DataEkstrakulikuler::where('id_sekolah', $selectedSekolahId)->pluck('judul', 'id_ekstrakulikuler');
    //     }
        
    //     return view('landingPage.berita.proyek', compact('sekolah','dataSlider','dataBerita','sekolahOptions', 'ekstrakulikulerOptions', 'selectedSekolahId'));
    // }

    /**
     * Show the form for news.
     */
    public function berita(Request $request)
    {
        $dataBerita = DataBerita::where('status', 'ditampilkan')->orderBy('id_berita', 'desc')->get();
        $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');
        $selectedSekolahId = $request->input('sekolah');

        $ekstrakulikulerOptions = [];
        if ($selectedSekolahId) {
            $ekstrakulikulerOptions = DataEkstrakulikuler::where('id_sekolah', $selectedSekolahId)->pluck('judul', 'id_ekstrakulikuler');
        }
        
        $dataEskul = null; 

        $id_ekstrakulikuler = $request->input('id_ekstrakulikuler');
        if ($id_ekstrakulikuler) {
            $dataEskul = DataEkstrakulikuler::where('status', 'ditampilkan')
                ->where('id_ekstrakulikuler', $id_ekstrakulikuler)
                ->orderBy('id_ekstrakulikuler', 'desc')
                ->first();
        }
        
        return view('landingPage.berita', compact('dataBerita','sekolahOptions','ekstrakulikulerOptions', 'selectedSekolahId','dataEskul'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function brosur(Request $request)
    {
        // $databrosur = DataBrosur::all();
        $dataBrosur = DataBrosur::where('status', 'ditampilkan')->orderBy('id_brosur', 'desc')->get();
        $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');
        $selectedSekolahId = $request->input('sekolah');

        $ekstrakulikulerOptions = [];
        if ($selectedSekolahId) {
            $ekstrakulikulerOptions = DataEkstrakulikuler::where('id_sekolah', $selectedSekolahId)->pluck('judul', 'id_ekstrakulikuler');
        }
        
        $dataEskul = null; 

        $id_ekstrakulikuler = $request->input('id_ekstrakulikuler');
        if ($id_ekstrakulikuler) {
            $dataEskul = DataEkstrakulikuler::where('status', 'ditampilkan')
                ->where('id_ekstrakulikuler', $id_ekstrakulikuler)
                ->orderBy('id_ekstrakulikuler', 'desc')
                ->first();
        }

        return view('landingPage.brosur', compact('dataBrosur', 'sekolahOptions','ekstrakulikulerOptions', 'selectedSekolahId','dataEskul'));
    }

    public function galeri(Request $request)
    {
        // $databrosur = DataBrosur::all();
        $dataGaleri = DataGaleri::where('status', 'ditampilkan')->orderBy('id_galeri', 'desc')->get();
        $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');
        $selectedSekolahId = $request->input('sekolah');

        $ekstrakulikulerOptions = [];
        if ($selectedSekolahId) {
            $ekstrakulikulerOptions = DataEkstrakulikuler::where('id_sekolah', $selectedSekolahId)->pluck('judul', 'id_ekstrakulikuler');
        }
        
        $dataEskul = null; 

        $id_ekstrakulikuler = $request->input('id_ekstrakulikuler');
        if ($id_ekstrakulikuler) {
            $dataEskul = DataEkstrakulikuler::where('status', 'ditampilkan')
                ->where('id_ekstrakulikuler', $id_ekstrakulikuler)
                ->orderBy('id_ekstrakulikuler', 'desc')
                ->first();
        }
        // dd($dataEskul);
        
        return view('landingPage.galeri', compact('dataGaleri','sekolahOptions', 'ekstrakulikulerOptions', 'selectedSekolahId','dataEskul'));
    }
    



    /**
     * Display the specified resource.
     */
    public function ekstrakulikuler(Request $request)
    {
        $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');
        $selectedSekolahId = $request->input('sekolah');

        $ekstrakulikulerOptions = [];
        if ($selectedSekolahId) {
            $ekstrakulikulerOptions = DataEkstrakulikuler::where('id_sekolah', $selectedSekolahId)->pluck('judul', 'id_ekstrakulikuler');
        }
        
        $dataEskul = null; 

        $id_ekstrakulikuler = $request->input('id_ekstrakulikuler');
        if ($id_ekstrakulikuler) {
            $dataEskul = DataEkstrakulikuler::where('status', 'ditampilkan')
                ->where('id_ekstrakulikuler', $id_ekstrakulikuler)
                ->orderBy('id_ekstrakulikuler', 'desc')
                ->first();
        }

        return view('landingpage.ekstrakulikuler', compact('sekolahOptions', 'ekstrakulikulerOptions', 'selectedSekolahId','dataEskul'));
    }

    // public function getEkstrakulikulerBySekolah($id_sekolah)
    // {
    //     $judulEkstrakulikuler = DataEkstrakulikuler::where('id_sekolah', $id_sekolah)->pluck('judul');
        
    //     return response()->json($judulEkstrakulikuler);
    // }
    
    public static function getEkstrakulikulerBySekolah($id_sekolah)
    {
        $judulEkstrakulikuler = DataEkstrakulikuler::where('id_sekolah', $id_sekolah)
            ->where('status', 'ditampilkan')->get();

        return $judulEkstrakulikuler;
    }


    public function getSekolah()
    {
        $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id_sekolah');

        return response()->json($sekolahOptions);
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
