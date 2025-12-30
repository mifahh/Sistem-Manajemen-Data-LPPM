<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKK extends Model
{
    use HasFactory;

    protected $table = 'master_kk';
    protected $fillable = [
        'nama_kk',
        'aktif',
    ];
}
