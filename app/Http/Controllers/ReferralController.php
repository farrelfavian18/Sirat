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
        $referrals = Referral::with('user', 'jamaah')->get();

        // Menghitung total referral untuk setiap user berdasarkan user_id
        $totalReferralsPerUser = $referrals->groupBy('user_id')->mapWithKeys(function ($group, $userId) {
            return [$userId => $group->count()]; // Hitung jumlah referral untuk setiap user
        });

        // Pastikan setiap referral tetap memiliki data lengkap dan total referral untuk usernya
        $groupedReferrals = $referrals->map(function ($referral) use ($totalReferralsPerUser) {
            return [
                'id_referral' => $referral->id, // ID referral unik
                'user' => $referral->user, // Informasi user
                'jamaah' => $referral->jamaah, // Informasi jamaah
                'total_referrals' => $totalReferralsPerUser[$referral->user_id] ?? 0, // Total referral user ini
                'status' => $referral->status, // Status referral
            ];
        });

        return view('referral.index', compact('referrals', 'groupedReferrals'));
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

        Referral::create([
            'id_user' => $validated['id_user'],
            'id_jamaah' => $validated['id_jamaah'],
            'status' => $validated['status'],
        ]);

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
        $referral->delete();

        return redirect()->route('referral.index')->with('success', 'Referral deleted successfully.');
    }
}
