<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;

    protected $table = 'anggarans';
    protected $guarded = [];
}
