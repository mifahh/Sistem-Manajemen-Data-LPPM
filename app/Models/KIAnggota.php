<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KIAnggota extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_ki_anggota';

    protected $fillable = [
        'id_ki',
        'id_mahasiswa',
        'id_dosen',
        'anggota',
        'status_anggota',
    ];

    public function dataKi()
    {
        return $this->belongsTo(KI::class, 'id_ki');
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
