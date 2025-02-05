<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\Jamaah;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayarans = Pembayaran::with('jamaah')->get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jamaahs = Jamaah::all();
        return view('pembayaran.create', compact('jamaahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_jamaah' => 'required',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_pembayaran' => 'required|numeric',
            'keterangan' => 'required|string',
            'penerima' => 'required|string',
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,pdf',
        ]);

        $data = $request->all();

        // Simpan file jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            $data['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        Pembayaran::create($data);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        $jamaahs = Jamaah::all();

        return view('pembayaran.edit', compact('pembayaran', 'jamaahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'id_jamaah' => 'required',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_pembayaran' => 'required|integer|min:0',
            'keterangan' => 'required|string',
            'penerima' => 'required|string',
            'bukti_pembayaran' => 'nullable',
        ]);

        // Hapus file lama jika ada file baru yang diupload
        if ($request->hasFile('bukti_pembayaran')) {
            if ($pembayaran->bukti_pembayaran && Storage::exists('public/' . $pembayaran->bukti_pembayaran)) {
                Storage::delete('public/' . $pembayaran->bukti_pembayaran);
            }
            $validated['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $pembayaran->update($validated);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}
