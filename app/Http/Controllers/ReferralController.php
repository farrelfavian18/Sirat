<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jamaah;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $referral = Referral::with('user','jamaah')->get();

        return view('referral.index', compact('referral'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = user::all();
        $jamaahs = Jamaah::all();

        return view('referral.create', compact('users', 'jamaahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
        'id_user' => 'required',
        'id_jamaah' => 'required',
        'status' => 'required|string',
    ]);

    // Tambahkan jamaah baru
    Referral::create([
        'id_user' => $validated['id_user'],
        'id_jamaah' => $validated['id_jamaah'],
        'status' => $validated['status'],
        'total_referal' => 1, // Default to 1 for a new referral
    ]);

    // Update total_referals untuk karyawan
    $referral = Referral::where('id_user', $validated['id_user'])->first();
    if ($referral) {
        $referral->increment('total_referals');
    }

    return redirect()->route('referral.index')->with('success', 'Referral created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Referral $referral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Referral $referral, $id)
    {
        $users = user::all();
        $jamaahs = Jamaah::all();
        $referral = Referral::findOrFail($id);

        return view('referral.edit', compact('users', 'jamaahs', 'referral'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Referral $referral)
    {
    $validated = $request->validate([
        'id_user' => 'required',
        'id_jamaah' => 'required',
        'status' => 'required|string',
    ]);

    // Periksa apakah id_user berubah
    if ($referral->id_user !== $validated['id_user']) {
        // Kurangi total referal dari karyawan lama
        $oldReferral = Referral::where('id_user', $referral->id_user)->first();
        if ($oldReferral) {
            $oldReferral->decrement('total_referals');
        }

        // Tambahkan total referal ke karyawan baru
        $newReferral = Referral::where('id_user', $validated['id_user'])->first();
        if ($newReferral) {
            $newReferral->increment('total_referals');
        }
    }

    $referral->update($validated);

    return redirect()->route('referral.index')->with('success', 'Referral updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Referral $referral)
    {
    // Kurangi total referals pada karyawan
    $existingReferral = Referral::where('id_user', $referral->id_user)->first();
    if ($existingReferral) {
        $existingReferral->decrement('total_referals');
    }

    $referral->delete();

    return redirect()->route('referral.index')->with('success', 'Referral deleted successfully.');
    }

}
