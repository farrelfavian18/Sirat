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
        $surat = Surat::with(['perusahaan', 'users'])->get();
        return view('surat.index', compact('surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perusahaan = Perusahaan::all();
        $user = User::all();
        return view('surat.create', compact('perusahaan', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data=$request->validate([
            
            'id_perusahaans' => 'required',
            'id_users' => 'required',
            'keterangan' => 'required|string',
            'dokumen_surat' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'note' => 'nullable|string',
        ]);

        // if ($request->hasFile('dokumen_surat')) {
        //     $data['dokumen_surat'] = $request->file('dokumen_surat')->store('surat_documents', 'public');
        // }

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
        $perusahaan = Perusahaan::all();
        $user = User::all();
        return view('surat.edit', compact('surat', 'perusahaan', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat , $id)
    {
        $request->validate([
            'id_perusahaan' => 'nullable|exists:data_perusahaan,id',
            'id_user' => 'nullable|exists:user,id',
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
