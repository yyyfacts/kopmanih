@extends('layouts.app')

@section('title', 'Analisis TOPSIS')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Analisis TOPSIS - Prioritas Pengadaan</h2>
        </div>
        <div class="col-md-6 text-end">
            <form action="{{ route('topsis.calculate') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calculator"></i> Hitung Ulang TOPSIS
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Hasil Perhitungan TOPSIS</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Ranking</th>
                            <th>Nama Barang</th>
                            <th>Urgensi (50%)</th>
                            <th>Stok (30%)</th>
                            <th>Anggaran (20%)</th>
                            <th>Skor TOPSIS</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuans as $index => $pengajuan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pengajuan->nama_barang }}</td>
                            <td>{{ $pengajuan->urgensi }}/5</td>
                            <td>{{ $pengajuan->stok }}</td>
                            <td>Rp {{ number_format($pengajuan->anggaran, 0, ',', '.') }}</td>
                            <td>{{ number_format($pengajuan->skor_topsis, 4) }}</td>
                            <td>
                                <span class="badge bg-{{ $pengajuan->status === 'approved' ? 'success' : ($pengajuan->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pengajuan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Informasi Perhitungan</h5>
        </div>
        <div class="card-body">
            <h6>Bobot Kriteria:</h6>
            <ul>
                <li>Urgensi: 50% (Semakin tinggi semakin prioritas)</li>
                <li>Stok: 30% (Semakin rendah semakin prioritas)</li>
                <li>Anggaran: 20% (Semakin rendah semakin prioritas)</li>
            </ul>
            <p class="mb-0">
                <i class="fas fa-info-circle"></i>
                Skor TOPSIS berkisar 0-1. Semakin mendekati 1 semakin diprioritaskan.
            </p>
        </div>
    </div>
</div>
@endsection
