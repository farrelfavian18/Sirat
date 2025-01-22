<?php

namespace App\Http\Controllers;


use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $perusahaan = Perusahaan::all();
        return view('user.create', compact('user','perusahaan'));
    }

    public function store(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required',
                'id_cabang' => 'required',
                'email' => 'required',
                'role' => 'required',
                'no_wa' => 'required',
                'alamat' => 'required',
                // 'password' => 'required',
                // 'password' => Hash::make($request->password),
                
            ]);
            // $new_password = $request->input('password');
            // $user->password = bcrypt($new_password);
            // $user->save();
            $data = $request->all();
            User::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return to_route('user.index')->with('message','Data Karyawan Telah Di Update');
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
            // 'password' => 'required',
            // 'password' => Hash::make($request->password),
            
        ]);
        $new_password = $request->input('password');
        $user->password = bcrypt($new_password);
        $user->save();

         User::where('id', $user->id)->update($validatedData);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        
        
        // Karyawan::where('id', $karyawan->id)->$karyawan->update( $validated);
        

        return to_route('user.index')->with('message','Data Karyawan Telah Di Update');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')
            ->with('success', 'Data User berhasil dihapus.');
    }
}