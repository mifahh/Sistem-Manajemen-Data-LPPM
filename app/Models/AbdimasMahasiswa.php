<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbdimasMahasiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abdimas_mahasiswa';

    protected $fillable = [
        'id_abdimas',
        'nama_mhs',
        'prodi_mhs',
    ];

    public function abdimas()
    {
        return $this->belongsTo(Abdimas::class, 'id_abdimas');
    }
}
