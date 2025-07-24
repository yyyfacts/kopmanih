@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Input Anggaran Kas</h1>
    <form method="POST" action="{{ route('bendahara.anggaran.store') }}">
        @csrf
        <div class="mb-3">
            <label for="periode" class="form-label">Periode Anggaran</label>
            <input type="month" class="form-control" id="periode" name="periode" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Anggaran (Rp)</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Sumber/Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    <hr>
    <h2>Riwayat Perubahan Anggaran</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Periode</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4" class="text-center">Belum ada data.</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
