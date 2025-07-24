<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function getStatusStokAttribute()
    {
        if ($this->stok <= 0) {
            return 'Habis';
        } elseif ($this->stok <= $this->stok_minimum) {
            return 'Kritis';
        }
        return 'Tersedia';
    }
}
