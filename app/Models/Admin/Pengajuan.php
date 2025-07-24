<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

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
        'urgensi' => 'integer',
        'stok' => 'integer',
        'anggaran' => 'decimal:2',
        'skor_topsis' => 'decimal:4'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
