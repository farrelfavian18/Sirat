<?php

namespace App\Http\Controllers;


use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $user = User::all();
        return view('user.index', compact('user'));
    }

    public function create()
    {
        $user = User::all();
        return view('user.create', compact('user'));
    }

    public function edit(User $user)
    {
        // $user = User::find($id);
        // $user = User::findOrFail($id);
        // $perusahaan = Perusahaan::findOrFail($id);
        // return view('user.edit', compact('user', 'perusahaan'));]
        return view('user.edit', [
            'user' => $user,
            'perusahaan' => Perusahaan::all(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
            'name' => 'required',
            'id_cabang' => 'required',
            'email' => 'required',
            'role' => 'required',
            'no_wa' => 'required',
            'alamat' => 'required',
            'password' => 'required',
            
        ]);
        
         User::where('id', $user->id)->update($validatedData);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        
        // Karyawan::where('id', $karyawan->id)->$karyawan->update( $validated);
        

        return to_route('karyawan.index')->with('message','Data Karyawan Telah Di Update');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')
            ->with('success', 'Data User berhasil dihapus.');
    }
}