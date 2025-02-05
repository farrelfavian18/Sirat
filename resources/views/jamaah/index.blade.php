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
    @if (session('success'))
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
            {{-- <th>Code Referral</th> --}}
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
              <td>{{ $item->perusahaan->nama_cabang ? $item->perusahaan->nama_cabang : 'Tidak Ada' }}
              </td>
              {{-- <td>{{ $item->code_referals ? $item->code_referals : 'Tidak Ada' }}</td> --}}
              <td>
                @if ($item->kartu_keluarga)
                  <p><a href="#" class="view-file" data-file="{{ asset('storage/' . $item->kartu_keluarga) }}">Kartu
                      Keluarga</a></p>
                @endif
                @if ($item->ktp)
                  <p><a href="#" class="view-file" data-file="{{ asset('storage/' . $item->ktp) }}">KTP</a></p>
                @endif
                @if ($item->surat_kesehatan)
                  <p><a href="#" class="view-file"
                      data-file="{{ asset('storage/' . $item->surat_kesehatan) }}">Surat Kesehatan</a></p>
                @endif
                @if ($item->visa)
                  <p><a href="#" class="view-file" data-file="{{ asset('storage/' . $item->visa) }}">Visa</a></p>
                @endif
                @if ($item->surat_pendukung)
                  <p><a href="#" class="view-file"
                      data-file="{{ asset('storage/' . $item->surat_pendukung) }}">Surat Pendukung</a></p>
                @endif
              </td>
              <td>
                <a href="{{ route('jamaah.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                @if (auth()->user()->role == 'superadmin')
                  <form action="{{ route('jamaah.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center">Tidak ada data jamaah.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="fileModalLabel">Preview File</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              <iframe id="fileViewer" style="width: 100%; height: 500px; border: none;"></iframe>
              <img id="imageViewer" style="width: 100%; height: auto; display: none;" />
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  @push('script')
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".view-file").forEach(function(link) {
          link.addEventListener("click", function(event) {
            event.preventDefault();
            let fileUrl = this.getAttribute("data-file");
            let fileExtension = fileUrl.split('.').pop().toLowerCase();

            if (fileExtension === "pdf") {
              document.getElementById("fileViewer").style.display = "block";
              document.getElementById("imageViewer").style.display = "none";
              document.getElementById("fileViewer").src = fileUrl;
            } else {
              document.getElementById("fileViewer").style.display = "none";
              document.getElementById("imageViewer").style.display = "block";
              document.getElementById("imageViewer").src = fileUrl;
            }

            let fileModal = new bootstrap.Modal(document.getElementById("fileModal"));
            fileModal.show();
          });
        });
      });
    </script>
  @endpush
@endsection
