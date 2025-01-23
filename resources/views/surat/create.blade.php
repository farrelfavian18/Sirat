{{-- @extends('layouts.app') --}}
@extends('master.master')
@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-center">Tambah Surat</h2>
        </div>
    </div>
    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="id_perusahaans" class="form-label">Perusahaan</label>
            <select name="id_perusahaans" id="id_perusahaans" class="form-select">
                <option value="">Pilih Perusahaan</option>
                @foreach($perusahaan as $perusahaans)
                <option value="{{ $perusahaans->id }}">{{ $perusahaans->nama_cabang }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="id_users" class="form-label">Karyawan</label>
            <select name="id_users" id="id_users" class="form-select">
                <option value="">Pilih Karyawan</option>
                @foreach($user as $users)
                <option value="{{ $users->id }}">{{ $users->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="dokumen_surat" class="form-label">Dokumen Surat</label>
            <input type="file" name="dokumen_surat" id="dokumen_surat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" id="note" class="form-control" rows="2"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('surat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
