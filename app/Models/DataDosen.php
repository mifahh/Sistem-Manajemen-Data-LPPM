<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataDosen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "data_dosen";
    // public $incrementing = true;
    // $reader->formatDates(false);
    protected $fillable = [
        'nama_dosen', 'status_aktif', 'prodi', 'nip', 'nidn', 'coe', 'kk', 'kode'
    ];
    // public static function getIpos(){
    //     $ipos = DB::table('tbl_ipos')->get();
    //     return $ipos;
    // }

    // Relasi Penelitian
    public function penelitian()
    {
        return $this->hasMany(Penelitian::class, 'id_dosen');
    }

    public function penelitianMembers()
    {
        return $this->hasMany(PenelitianMember::class, 'id_dosen');
    }

    // Relasi Abdimas
    public function abdimas()
    {
        return $this->hasMany(Abdimas::class, 'id_dosen');
    }

    public function abdimasMembers()
    {
        return $this->hasMany(AbdimasMember::class, 'id_dosen');
    }

    // Relasi KI
    public function kiAnggota()
    {
        return $this->hasMany(KIAnggota::class, 'id_dosen');
    }

    // Relasi Publikasi
    public function publikasiPenulis()
    {
        return $this->hasMany(PublikasiPenulis::class, 'id_dosen');
    }
}
