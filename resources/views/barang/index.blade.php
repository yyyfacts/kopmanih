<h1>Daftar Barang</h1>
<table border="1" cellpadding="5" cellspacing="0" style="width:100%;background:#fff;color:#222;">
    <thead style="background:#f3f4f6;">
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Stok Minimum</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($barangs) && count($barangs))
            @foreach($barangs as $barang)
            <tr>
                <td>{{ $barang->id }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->kategori->nama ?? '-' }}</td>
                <td>{{ $barang->stok ?? '-' }}</td>
                <td>{{ $barang->stok_minimum ?? '-' }}</td>
            </tr>
            @endforeach
        @else
            <tr><td colspan="5">Tidak ada data barang.</td></tr>
        @endif
    </tbody>
</table>
