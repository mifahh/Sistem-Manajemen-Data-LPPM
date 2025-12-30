<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCoE extends Model
{
    use HasFactory;

    protected $table = 'master_coe';
    protected $fillable = [
        'nama_coe',
        'aktif',
    ];
}
