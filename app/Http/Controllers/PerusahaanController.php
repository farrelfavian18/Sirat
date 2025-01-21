<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perusahaan = Perusahaan::all();
        return view('perusahaan.index', compact('perusahaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required',
            'kota_kabupaten' => 'required',
            'alamat' => 'required',
            'nama_pimpinan' => 'required', 
            'nib_cabang' => 'required',
            'pdf_nib' => 'required|file|mimes:pdf|max:2048',
            'pdf_akta_cabang' => 'required|file|mimes:pdf|max:2048',
        ]);

        $data = $request->all();

        // Upload PDF files and store paths
        if ($request->hasFile('pdf_nib')) {
            $data['pdf_nib'] = $request->file('pdf_nib')->store('perusahaan_documents', 'public');
        }
        if ($request->hasFile('pdf_akta_cabang')) {
            $data['pdf_akta_cabang'] = $request->file('pdf_akta_cabang')->store('perusahaan_documents', 'public');
        }

        Perusahaan::create($data);

        return redirect()->route('perusahaan.index')
            ->with('success', 'Data Perusahaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perusahaan $perusahaan, $id)
    {
        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return redirect()->route('perusahaan.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('perusahaan.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perusahaan $perusahaan, $id)
    {
        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return redirect()->route('perusahaan.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('perusahaan.edit', compact('perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perusahaan $perusahaan, $id)
    {
        $request->validate([
            'nama_cabang' => 'required',
            'kota_kabupaten' => 'required',
            'alamat' => 'required',
            'nama_pimpinan' => 'required', 
            'nib_cabang' => 'required',
            'pdf_nib' => 'nullable|file|mimes:pdf|max:2048',
            'pdf_akta_cabang' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return redirect()->route('perusahaan.index')->with('error', 'Data tidak ditemukan.');
        }

        $data = $request->all();

        // Update PDF files and delete old files if replaced
        if ($request->hasFile('pdf_nib')) {
            if ($perusahaan->pdf_nib) {
                Storage::delete('public/' . $perusahaan->pdf_nib);
            }
            $data['pdf_nib'] = $request->file('pdf_nib')->store('perusahaan_documents', 'public');
        }

        if ($request->hasFile('pdf_akta_cabang')) {
            if ($perusahaan->pdf_akta_cabang) {
                Storage::delete('public/' . $perusahaan->pdf_akta_cabang);
            }
            $data['pdf_akta_cabang'] = $request->file('pdf_akta_cabang')->store('perusahaan_documents', 'public');
        }

        $perusahaan->update($data);

        return redirect()->route('perusahaan.index')
            ->with('success', 'Data Perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perusahaan $perusahaan, $id)
    {
        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return redirect()->route('perusahaan.index')->with('error', 'Data tidak ditemukan.');
        }

        // Delete PDF files if exist
        if ($perusahaan->pdf_nib) {
            Storage::delete('public/' . $perusahaan->pdf_nib);
        }
        if ($perusahaan->pdf_akta_cabang) {
            Storage::delete('public/' . $perusahaan->pdf_akta_cabang);
        }

        $perusahaan->delete();

        return redirect()->route('perusahaan.index')
            ->with('success', 'Data Perusahaan berhasil dihapus.');
    }
}
