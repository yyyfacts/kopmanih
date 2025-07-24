@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Detail Pengajuan</h1>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Nama Barang: </h5>
            <p class="card-text">Deskripsi: </p>
            <p class="card-text">Status: </p>
            <form method="POST" action="#">
                @csrf
                <button type="submit" class="btn btn-success">Setujui</button>
                <button type="submit" class="btn btn-danger">Tolak</button>
            </form>
        </div>
    </div>
</div>
@endsection
