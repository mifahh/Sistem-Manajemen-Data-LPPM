<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class PublikasiPenulis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_publikasi_penulis';

    protected $fillable = [
        'id_publikasi',
        'id_mahasiswa',
        'id_dosen',
        'nama_penulis',
        'status',
        'afiliasi',
    ];

    public function publication()
    {
        return $this->belongsTo(Publikasi::class, 'id_publikasi');
    }

    public function dosen()
    {
        return $this->belongsTo(DataDosen::class, 'id_dosen');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'id_mahasiswa');
    }
}
