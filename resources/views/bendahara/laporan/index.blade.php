@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Laporan Realisasi Pengadaan & Dana Kas</h1>
    <form method="GET" action="">
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="month" class="form-control" name="bulan">
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="tahun" placeholder="Tahun">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jenis Laporan</th>
                <th>Periode</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4" class="text-center">Belum ada data.</td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('bendahara.laporan.ekspor') }}" class="btn btn-success">Ekspor PDF</a>
</div>
@endsection
