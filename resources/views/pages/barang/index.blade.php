@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Daftar Barang</h1>
    <table class="min-w-full bg-white dark:bg-gray-900">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="py-3 px-4 text-left">ID</th>
                <th class="py-3 px-4 text-left">Nama Barang</th>
                <th class="py-3 px-4 text-left">Kategori</th>
                <th class="py-3 px-4 text-left">Stok</th>
                <th class="py-3 px-4 text-left">Stok Minimum</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 dark:text-gray-200">
            @if(isset($barangs) && count($barangs))
                @foreach($barangs as $barang)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-gray-800 transition">
                    <td class="py-2 px-4">{{ $barang->id }}</td>
                    <td class="py-2 px-4">{{ $barang->nama_barang }}</td>
                    <td class="py-2 px-4">{{ $barang->kategori->nama ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $barang->stok ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $barang->stok_minimum ?? '-' }}</td>
                </tr>
                @endforeach
            @else
                <tr><td colspan="5" class="py-2 px-4 text-center">Tidak ada data barang.</td></tr>
            @endif
        </tbody>
    </table>
@endsection
