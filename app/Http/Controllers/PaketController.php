<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pakets = Paket::with('jamaahs')->get(); // Ambil semua data 'pakets' dengan relasi
        return view('paket.index', compact('pakets')); // Kirim variabel 'pakets' ke view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('paket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'hotel_madinah' => 'required|string|max:255',
            'hotel_mekkah' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'pesawat' => 'required|string|max:255',
            'total_seat' => 'required|numeric',
            'jenis_paket' => 'required|boolean',
        ]);

        Paket::create($validated);

        return redirect()->route('paket.index')
            ->with('success', 'Paket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paket $paket, $id)
    {
        $paket = Paket::findOrFail($id);
        return view('paket.edit', compact('paket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $paket, $id)
    {
        $paket = Paket::findOrFail($id);
        return view('paket.edit', compact('paket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paket $paket ,$id)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'hotel_madinah' => 'required|string|max:255',
            'hotel_mekkah' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'pesawat' => 'required|string|max:255',
            'total_seat' => 'required|numeric',
            'jenis_paket' => 'required|boolean',
        ]);

        $paket = Paket::findOrFail($id);
        $paket->update($validated);

        return redirect()->route('paket.index')
            ->with('success', 'Data Paket updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket,$id, $fileField)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect()->route('paket.index')
            ->with('success', 'Data paket deleted successfully');
    }
}
