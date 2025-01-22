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
        $jamaah = Jamaah::with(['paket', 'perusahaan'])->get();
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
    public function show(Jamaah $jamaah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jamaah $jamaah)
    {
    $pakets = Paket::all();
    $perusahaans = Perusahaan::all();
    $users = User::all();
    return view('jamaah.edit', compact('jamaah', 'pakets', 'perusahaans', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jamaah $jamaah)
    {
        $request->validate([
            'id_paket' => 'required',
            'id_perusahaan' => 'required',
            'nama_jamaah' => 'required',
            'alamat' => 'required',
            'kartu_keluarga' => 'nullable',
            'ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'no_telpon' => 'required|string|max:15',
            'surat_kesehatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'visa' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'surat_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $jamaah = Jamaah::findOrFail($request->id);

        $data = $request->all();

        // Simpan file jika ada
        foreach (['kartu_keluarga', 'ktp', 'surat_kesehatan', 'visa', 'surat_pendukung'] as $fileField) {
            if ($request->hasFile($fileField)) {
                if ($jamaah->$fileField) {
                    Storage::delete('public/' . $jamaah->$fileField);
                }
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

        $jamaah->update($data);

        return redirect()->route('jamaah.index')->with('success', 'Data Jamaah berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jamaah $jamaah, $id)
    {
        $jamaah = Jamaah::find($id);

        if (!$jamaah) {
            return redirect()->route('jamaah.index')->with('error', 'Data tidak ditemukan.');
        }

        // Hapus file yang terkait
        foreach (['kartu_keluarga', 'ktp', 'surat_kesehatan', 'visa', 'surat_pendukung'] as $fileField) {
            if ($jamaah->$fileField) {
                Storage::delete('public/' . $jamaah->$fileField);
            }
        }

        // Kurangi total referal jika ID karyawan terkait ditemukan
        if ($jamaah->id_karyawan) {
            $referral = Referral::where('id_karyawans', $jamaah->id_karyawan)->first();
            if ($referral && $referral->total_referals > 0) {
                $referral->decrement('total_referals');
                if ($referral->total_referals === 0) {
                    $referral->delete();
                }
            }
        }

        $jamaah->delete();

        return redirect()->route('jamaah.index')->with('success', 'Data Jamaah berhasil dihapus.');
    }
}
