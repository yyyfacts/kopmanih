<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Kategori;
use App\Models\Admin\BarangMasuk;
use App\Models\Admin\BarangKeluar;

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
