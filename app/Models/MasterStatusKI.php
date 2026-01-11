<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStatusKI extends Model
{
    use HasFactory;

    protected $table = 'master_status_ki';
    protected $fillable = [
        'nama_status',
        'deskripsi',
    ];
}
