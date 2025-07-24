<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangMasuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'barang_id',
        'jumlah',
        'tanggal_masuk',
        'supplier',
        'keterangan',
        'user_id'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
