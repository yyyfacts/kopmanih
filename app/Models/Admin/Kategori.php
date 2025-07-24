<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Barang;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
