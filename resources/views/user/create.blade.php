{{-- @extends('layouts.app') --}}
@extends('master.master')
@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-center">Tambah Data Karyawan</h2>
        </div>
    </div>
    <form method="POST" action="{{ route('karyawan.store') }}" enctype="multipart/form-data" >
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="superadmin">Karyawan Pusat</option>
                <option value="admin">Pimpinan Cabang</option>
                <option value="user">Karyawan Cabang</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cabang_id">Cabang</label>
            <select class="form-control select2 @error('cabang_id') is-invalid @enderror" style="width: 100%;"
                name="cabang_id" id="cabang_id">
                <option value="" selected disabled>Pilih Cabang</option>
                @foreach ($cabang as $item)
                <option value="{{ $item->id }}" data-email="{{ $item->cabang_id }}">{{ $item->nama_cabang }}
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
            <input type="number" name="no_wa" class="form-control" id="no_wa">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Username Akun</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password Akun</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection