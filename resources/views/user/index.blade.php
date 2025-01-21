{{-- @extends('layouts.app') --}}
@extends('master.master')
@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-center">Data User Karyawan</h2>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('user.create') }}" class="btn btn-success">Tambah Data Karyawan</a>
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
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Email</th>
                    <!-- <th>No. WA</th>
                    <th>Alamat</th> -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->role }}</td>
                    {{-- <td>
                        @foreach($data_karyawans->data_perusahaans as $item)
                            {{ $item->nama_cabang }} <br>
                        @endforeach
                    </td>
                    <td>{{ $karyawan->data_perusahaans->nama_cabang ?? 'NA' }}</td>
                    <td>{{ $karyawan->cabang_id }}</td>
                    <td>{{ $item->no_wa }}</td>
                    <td>{{ $item->alamat }}</td> --}}

                    <td>{{ $item->email }}</td>
                    <td>
                        <a href="{{ route('user.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection