@extends('master.master')

@section('content')
  <div class="container mt-4">
    <div class="row mb-4">
      <div class="col">
        <h2 class="text-center">Edit Jamaah</h2>
      </div>
    </div>
    <form action="{{ route('jamaah.update', $jamaah->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="nama_jamaah" class="form-label">Nama Jamaah</label>
        <input type="text" name="nama_jamaah" class="form-control" id="nama_jamaah" value="{{ $jamaah->nama_jamaah }}"
          required>
      </div>

      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" id="alamat" required>{{ $jamaah->alamat }}</textarea>
      </div>

      <div class="mb-3">
        <label for="no_telpon" class="form-label">No. Telepon</label>
        <input type="text" name="no_telpon" class="form-control" id="no_telpon" value="{{ $jamaah->no_telpon }}"
          required>
      </div>

      <div class="mb-3">
        <label for="id_paket" class="form-label">Paket</label>
        <select name="id_paket" class="form-control" id="id_paket" required>
          @foreach ($pakets as $paket)
            <option value="{{ $paket->id }}" {{ $jamaah->id_paket == $paket->id ? 'selected' : '' }}>
              {{ $paket->nama_paket }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="id_perusahaan" class="form-label">Perusahaan</label>
        <select name="id_perusahaan" class="form-control" id="id_perusahaan" required>
          @foreach ($perusahaans as $perusahaan)
            <option value="{{ $perusahaan->id }}" {{ $jamaah->id_perusahaan == $perusahaan->id ? 'selected' : '' }}>
              {{ $perusahaan->nama_cabang }}
            </option>
          @endforeach
        </select>
      </div>

      @foreach (['kartu_keluarga', 'ktp', 'surat_kesehatan', 'visa', 'surat_pendukung'] as $fileField)
        <div class="mb-3">
          <label for="{{ $fileField }}" class="form-label">{{ ucwords(str_replace('_', ' ', $fileField)) }}</label>
          <input type="file" name="{{ $fileField }}" class="form-control" id="{{ $fileField }}"
            accept="image/*,.pdf">
          @if ($jamaah->$fileField)
            <p><a href="{{ asset('storage/' . $jamaah->$fileField) }}" target="_blank">Lihat File</a></p>
          @endif
        </div>
      @endforeach

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
@endsection
