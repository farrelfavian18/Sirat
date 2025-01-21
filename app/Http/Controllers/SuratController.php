<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Models\User;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surat = Surat::with(['perusahaan', 'karyawan'])->get();
        return view('surat.index', compact('surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perusahaans = Perusahaan::all();
        $users = User::all();
        return view('surat.create', compact('perusahaans', 'karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_data_perusahaans' => 'nullable|exists:data_perusahaans,id',
            'id_karyawans' => 'nullable|exists:karyawans,id',
            'keterangan' => 'required|string',
            'dokumen_surat' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'note' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('dokumen_surat')) {
            $data['dokumen_surat'] = $request->file('dokumen_surat')->store('surat_documents', 'public');
        }

        Surat::create($data);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat, $id)
    {
        $surat = Surat::findOrFail($id);
        $perusahaans = Perusahaan::all();
        $users = User::all();
        return view('surat.edit', compact('surat', 'perusahaans', 'karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat , $id)
    {
        $request->validate([
            'id_data_perusahaans' => 'nullable|exists:data_perusahaans,id',
            'id_karyawans' => 'nullable|exists:karyawans,id',
            'keterangan' => 'required|string',
            'dokumen_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'note' => 'nullable|string',
        ]);

        $surat = Surat::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('dokumen_surat')) {
            if ($surat->dokumen_surat) {
                Storage::delete('public/' . $surat->dokumen_surat);
            }
            $data['dokumen_surat'] = $request->file('dokumen_surat')->store('surat_documents', 'public');
        }

        $surat->update($data);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat, $id)
    {
        $surat = Surat::findOrFail($id);

        if ($surat->dokumen_surat) {
            Storage::delete('public/' . $surat->dokumen_surat);
        }

        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus.');
    }
}
