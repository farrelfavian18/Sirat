<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Paket;
use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JamaahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $jamaah = Jamaah::with(['paket', 'perusahaan'])->where('id_perusahaan',$user->id_cabang)->get();
        return view('jamaah.index', compact('jamaah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pakets = Paket::all();
        $perusahaans = Perusahaan::all();
        $users = User::all();
        return view('jamaah.create', compact('pakets', 'perusahaans', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_paket' => 'required',
            'id_perusahaan' => 'required',
            'nama_jamaah' => 'required',
            'alamat' => 'required',
            'kartu_keluarga' => 'required',
            'ktp' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'no_telpon' => 'required|string|max:15',
            'surat_kesehatan' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'visa' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'surat_pendukung' => 'required|file|mimes:pdf,jpg,jpeg,png',

        ]);

        $data = $request->all();

        // Simpan file jika ada
        foreach (['kartu_keluarga', 'ktp', 'surat_kesehatan', 'visa', 'surat_pendukung'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $data[$fileField] = $request->file($fileField)->store('jamaah_documents', 'public');
            }
        }
        // if ($request->id_user) {
        //     $referral = Referral::firstOrCreate(
        //         ['id_karyawans' => $request->id_user],
        //         ['total_referals' => 0]
        //     );
        //     $referral->increment('total_referals');
        // }

        Jamaah::create($data);

        return redirect()->route('jamaah.index')->with('success', 'Data Jamaah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jamaah $jamaah, $id)
    {
        $user = auth()->user();
        $jamaah = Jamaah::find($id)->where('id_perusahaan',$user->id_cabang)->first();

        if (!$jamaah) {
            return redirect()->route('jamaah.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('jamaah.show', compact('jamaah'));
    }
    public function edit($id)
    {
        $user = auth()->user();
        $jamaah = Jamaah::findOrFail($id)->where('id_perusahaan',$user->id_cabang)->first();
        if (!$jamaah) {
            return redirect()->route('jamaah.index')->with('error', 'Data tidak ditemukan.');
        }
        $pakets = Paket::all();
        $perusahaans = Perusahaan::all();
        // $users = User::all();
        return view('jamaah.edit', compact('jamaah', 'pakets', 'perusahaans', 'users'));
    }

public function update(Request $request, $id)
{
    $user = auth()->user();
    $jamaah = Jamaah::findOrFail($id)->where('id_perusahaan',$user->id_cabang)->first();

    $request->validate([
        'id_paket' => 'required',
        'id_perusahaan' => 'required',
        'nama_jamaah' => 'required',
        'alamat' => 'required',
        'kartu_keluarga' => 'required',
        'ktp' => 'required|file|mimes:pdf,jpg,jpeg,png',
        'no_telpon' => 'required|string|max:15',
        'surat_kesehatan' => 'required|file|mimes:pdf,jpg,jpeg,png',
        'visa' => 'required|file|mimes:pdf,jpg,jpeg,png',
        'surat_pendukung' => 'required|file|mimes:pdf,jpg,jpeg,png',
    ]);

    $jamaah = Jamaah::findOrFail($id);

    if (!$jamaah) {
        return redirect()->route('jamaah.index')->with('error', 'Data tidak ditemukan.');
    }

    $data = $request->all();

    // Simpan file jika ada
    foreach (['kartu_keluarga', 'ktp', 'surat_kesehatan', 'visa', 'surat_pendukung'] as $fileField) {
        if ($request->hasFile($fileField)) {
            // Hapus file lama jika ada
            if ($jamaah->$fileField) {
                Storage::disk('public')->delete($jamaah->$fileField);
            }

            $data[$fileField] = $request->file($fileField)->store('jamaah_documents', 'public');
        }
    }

    $jamaah->update($data);

    return redirect()->route('jamaah.index')->with('success', 'Data Jamaah berhasil diupdate.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $jamaah = Jamaah::find($id)->where('id_perusahaan',$user->id_cabang)->first();

        if (!$jamaah) {
            return redirect()->route('jamaah.index')->with('error', 'Data tidak ditemukan.');
        }

        $jamaah->delete();

        return redirect()->route('jamaah.index')->with('success', 'Data Jamaah berhasil dihapus.');
    }
    // public function __construct()
    // {
    // $this->middleware('auth');
    // }



}
