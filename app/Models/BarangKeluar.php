<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangKeluar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'barang_id',
        'jumlah',
        'tanggal_keluar',
        'keterangan', 
        'peminjam',
        'user_id',
        'status',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
        'approved_at' => 'datetime'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
