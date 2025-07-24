<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'stok',
        'stok_minimum',
        'kategori_id',
        'satuan',
        'foto'
    ];

    protected $casts = [
        'stok' => 'integer',
        'stok_minimum' => 'integer'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
