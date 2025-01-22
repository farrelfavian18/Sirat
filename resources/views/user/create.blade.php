{{-- @extends('layouts.app') --}}
@extends('master.master')
@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-center">Tambah Data Karyawan</h2>
        </div>
    </div>
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" >
        @csrf
        <!-- <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div> -->
        <div class="form-group">
            <label for="name">Nama Akun</label>
            <input type="text" id="" name="name" class="form-control" @error('name') is-invalid @enderror"
                placeholder="contoh: Billy Fernandes">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="superadmin">Superadmin</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
        <div class="form-group">
            <label for="id_cabang">Perusahaan / Cabang</label>
            <select class="form-control select2 @error('id_cabang') is-invalid @enderror" style="width: 100%;"
                name="id_cabang" id="id_cabang">
                <option value="" selected disabled>Pilih Cabang</option>
                @foreach ($perusahaan as $item)
                <option value="{{ $item->id }}" data-email="{{ $item->id_cabang }}">{{ $item->nama_cabang }}
                </option>
                {{-- <option value="{{ $item->id }}">{{ $item->name }}
                </option> --}}
                @endforeach
            </select>
            @error('users_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label for="no_wa" class="form-label">Nomor WhatsApp</label>
            <input type="text" name="no_wa" class="form-control" id="no_wa">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password Akun</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection