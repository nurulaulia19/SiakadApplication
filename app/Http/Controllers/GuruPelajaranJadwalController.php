<?php

namespace App\Http\Controllers;

use App\Models\GuruPelajaranJadwal;
use Illuminate\Http\Request;

class GuruPelajaranJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $dataGpj = new GuruPelajaranJadwal();
        $dataGpj->id_gp = $request->id_gp;
        $dataGpj->hari = $request->hari;
        $dataGpj->jam_mulai = $request->jam_mulai;
        $dataGpj->jam_selesai = $request->jam_selesai;
        $dataGpj->save();

        return redirect()->route('guruMapel.index')->with('success', 'Jadwal Guru Mata Pelajaran insert successfully');
            
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
    public function destroy($id_gpj){
        $dataGpj = GuruPelajaranJadwal::where('id_gpj', $id_gpj);
        $dataGpj->delete();
        return redirect()->route('guruMapel.index')->with('success', 'Terdelet');
    }
}
