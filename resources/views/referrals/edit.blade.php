@extends('master.master')

@section('content')
<div class="container">
    <h1>Edit Referral</h1>
    <form action="{{ route('referral.update', $referral->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_user">Nama Karyawan</label>
            <select name="id_user" id="id_user" class="form-control" required>
                <option value="">-- Pilih Karyawan --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $referral->id_user ? 'selected' : '' }}>
                        {{ $user->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="id_jamaah">Nama Jamaah</label>
            <select name="id_jamaah" id="id_jamaah" class="form-control" required>
                <option value="">-- Pilih Jamaah --</option>
                @foreach($jamaahs as $jamaah)
                    <option value="{{ $jamaah->id }}" {{ $jamaah->id == $referral->id_jamaah ? 'selected' : '' }}>
                        {{ $jamaah->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" name="status" id="status" class="form-control" value="{{ $referral->status }}" required>
        </div>
        <button type="submit" class="
