<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenelitianMahasiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penelitian_mahasiswa';

    protected $fillable = [
        'id_penelitian',
        'id_mahasiswa',
        'nama_mhs',
        'prodi_mhs',
    ];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'id_penelitian');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'id_mahasiswa');
    }
}
