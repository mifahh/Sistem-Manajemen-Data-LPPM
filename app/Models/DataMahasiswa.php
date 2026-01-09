<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataMahasiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "data_mahasiswa";

    protected $fillable = [
        'nim', 'nama_mahasiswa', 'prodi', 'status', 'angkatan'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public static function getStatusList()
    {
        return ['GRADUATED', 'RESIGN', 'CHANGE MAJOR', 'NON-ACTIVE', 'STUDENT', 'PASSED AWAY', 'LEAVE'];
    }

    public function penelitianMahasiswa()
    {
        return $this->hasMany(PenelitianMahasiswa::class, 'id_mahasiswa');
    }

    public function abdimasMahasiswa()
    {
        return $this->hasMany(AbdimasMahasiswa::class, 'id_mahasiswa');
    }

    public function kiAnggota()
    {
        return $this->hasMany(KIAnggota::class, 'id_mahasiswa');
    }

    // Relasi Publikasi
    public function publikasiPenulis()
    {
        return $this->hasMany(PublikasiPenulis::class, 'id_mahasiswa');
    }
}
