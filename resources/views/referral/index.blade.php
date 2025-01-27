@extends('master.master')

@section('content')
<div class="container">
    <h1>Daftar Referral</h1>
    <a href="{{ route('referral.create') }}" class="btn btn-success mb-3">Tambah Referral</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Total Referal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($groupedReferrals as $referral)
            <tr>
                <td>{{ $referral['user']->name ?? 'Tidak ada data' }}</td>
                <td>{{ $referral['total_referals'] }}</td>
                <td>{{ $referral['status'] }}</td>
                <td>
                    <a href="{{ route('referral.edit', $referral['jamaah']->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('referral.destroy', $referral['jamaah']->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus referral ini?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Tidak ada data referral.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
