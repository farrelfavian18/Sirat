@extends('master.master')

@section('content')
<div class="container">
    <h1>Tambah Referral</h1>
    <form action="{{ route('referral.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_user">Nama Karyawan</label>
            <select name="id_user" id="id_user" class="form-control" required>
                <option value="">-- Pilih Karyawan --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="id_jamaah">Nama Jamaah</label>
            <select name="id_jamaah" id="id_jamaah" class="form-control" required>
                <option value="">-- Pilih Jamaah --</option>
                @foreach($jamaahs as $jamaah)
                    <option value="{{ $jamaah->id }}">{{ $jamaah->nama_jamaah }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" name="status" id="status" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('referral.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
