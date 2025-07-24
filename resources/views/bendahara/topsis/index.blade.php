@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Analisis TOPSIS</h1>
    <form method="POST" action="{{ route('bendahara.topsis.hitung') }}">
        @csrf
        <button type="submit" class="btn btn-primary mb-3">Hitung Skor TOPSIS</button>
    </form>
    <div class="card mb-3">
        <div class="card-header">Radar Chart Skor TOPSIS</div>
        <div class="card-body">
            <canvas id="topsisRadarChart"></canvas>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">Tabel Rekomendasi</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Skor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('bendahara.topsis.ekspor') }}" class="btn btn-success">Ekspor PDF</a>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('topsisRadarChart').getContext('2d');
    var radarChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Pengajuan 1', 'Pengajuan 2', 'Pengajuan 3'],
            datasets: [{
                label: 'Skor TOPSIS',
                data: [0, 0, 0],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scale: {
                ticks: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
