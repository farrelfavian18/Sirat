{{-- @extends('layouts.app') --}}
@extends('master.master')
@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-center">Data Jamaah</h2>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('jamaah.create') }}" class="btn btn-success">Tambah Jamaah</a>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Jamaah</th>
                    <th>Alamat</th>
                    <th>No. Telepon</th>
                    <th>Paket</th>
                    <th>Perusahaan</th>
                    <th>Code Referral</th>
                    <th>Dokumen</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jamaah as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nama_jamaah ? $item->nama_jamaah : 'Tidak Ada' }}</td>
                    <td>{{ $item->alamat ? $item->alamat : 'Tidak Ada' }}</td>
                    <td>{{ $item->no_telpon ? $item->no_telpon : 'Tidak Ada' }}</td>
                    <td>{{ $item->paket->nama_paket ? $item->paket->nama_paket : 'Tidak Ada' }}</td>
                    <td>{{ $item->perusahaan->nama_perusahaan ? $item->perusahaan->nama_perusahaan : 'Tidak Ada' }}
                    </td>
                    <td>{{ $item->code_referals ? $item->code_referals : 'Tidak Ada' }}</td>
                    <td>
                        @if($item->kartu_keluarga)
                        <p><a href="{{ asset('storage/' . $item->kartu_keluarga) }}" target="_blank">Kartu
                                Keluarga</a></p>
                        @endif
                        @if($item->ktp)
                        <p><a href="{{ asset('storage/' . $item->ktp) }}" target="_blank">KTP</a></p>
                        @endif
                        @if($item->surat_kesehatan)
                        <p><a href="{{ asset('storage/' . $item->surat_kesehatan) }}" target="_blank">Surat
                                Kesehatan</a></p>
                        @endif
                        @if($item->visa)
                        <p><a href="{{ asset('storage/' . $item->visa) }}" target="_blank">Visa</a></p>
                        @endif
                        @if($item->surat_pendukung)
                        <p><a href="{{ asset('storage/' . $item->surat_pendukung) }}" target="_blank">Surat
                                Pendukung</a></p>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('jamaah.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('jamaah.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data jamaah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection