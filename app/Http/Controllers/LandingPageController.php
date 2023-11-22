<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\DataBerita;
use App\Models\DataBrosur;
use App\Models\DataSlider;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sekolah = Sekolah::all();
        $dataSlider = DataSlider::all();
        $dataBerita = DataBerita::where('status', 'ditampilkan')->orderBy('id_berita', 'desc')->get();
        
        return view('landingPage.index', compact('sekolah','dataSlider','dataBerita'));
    }

    public function beritaTari()
    {
        $sekolah = Sekolah::all();
        $dataSlider = DataSlider::all();
        $dataBerita = DataBerita::where('status', 'ditampilkan')->orderBy('id_berita', 'desc')->get();
        
        return view('landingPage.berita.tari', compact('sekolah','dataSlider','dataBerita'));
    }

    public function beritaProyek()
    {
        $sekolah = Sekolah::all();
        $dataSlider = DataSlider::all();
        $dataBerita = DataBerita::where('status', 'ditampilkan')->orderBy('id_berita', 'desc')->get();
        
        return view('landingPage.berita.proyek', compact('sekolah','dataSlider','dataBerita'));
    }

    /**
     * Show the form for news.
     */
    public function berita()
    {
        $dataBerita = DataBerita::where('status', 'ditampilkan')->orderBy('id_berita', 'desc')->get();
        
        return view('landingPage.berita', compact('dataBerita'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function brosur()
    {
        // $databrosur = DataBrosur::all();
        $dataBrosur = DataBrosur::where('status', 'ditampilkan')->orderBy('id_brosur', 'desc')->get();
        
        return view('landingPage.brosur', compact('dataBrosur'));
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
