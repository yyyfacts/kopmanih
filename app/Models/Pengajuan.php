<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengajuan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_barang',
        'urgensi',
        'stok',
        'anggaran',
        'keterangan',
        'user_id',
        'status',
        'skor_topsis'
    ];

    protected $casts = [
        'anggaran' => 'decimal:2',
        'skor_topsis' => 'decimal:4'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
