<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKategoriKI extends Model
{
    use HasFactory;

    protected $table = 'master_kategori_ki';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];
}
