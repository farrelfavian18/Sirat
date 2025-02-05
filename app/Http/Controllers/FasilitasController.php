<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Paket;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fasilitas = Fasilitas::with('paket')->get();

        return view('fasilitas.index', compact('fasilitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pakets = Paket::all();

        return view('fasilitas.create', compact('pakets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_paket' => 'required|exists:pakets,id',
            'peralatan' => 'required|array',
            'peralatan.*' => 'required|string|max:255',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string|max:255',
        ]);

        try {
            foreach ($validatedData['peralatan'] as $index => $peralatan) {
                Fasilitas::create([
                    'id_paket' => $validatedData['id_paket'],
                    'peralatan' => $peralatan,
                    'keterangan' => $validatedData['keterangan'][$index] ?? null,
                ]);
            }

            return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Fasilitas $fasilitas, $id)
    {
         // Ambil data fasilitas berdasarkan ID
         $fasilitas = Fasilitas::with('paket')->findOrFail($id);

         return view('fasilitas.show', compact('fasilitas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fasilitas $fasilitas, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $pakets = Paket::all();

        return view('fasilitas.edit', compact('fasilitas', 'pakets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fasilitas $fasilitas)
    {
        $validated = $request->validate([
            'id_paket' => 'required',
            'peralatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Fasilitas::where('id_paket', $request->id_paket)->update($validated);


        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $fasilitas)
    {
        $item = Fasilitas::findOrFail($fasilitas);
        $item->delete();
        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
