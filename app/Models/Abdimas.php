<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abdimas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abdimas_main';

    protected $fillable = [
        'link_sk',
        'no_sk',
        'link_kontrak',
        'no_kontrak',
        'judul_penelitian',
        'nama_skema',
        'tahun_usulan',
        'tahun_pelaksanaan',
        'lama_kegiatan',
        'bidang_fokus',
        'dana_diusulkan',
        'dana_disetujui',
        'target_tkt',
        'nama_program_hibah',
        'kategori_sumber_dana',
        'negara_sumber_dana',
        'sumber_dana',
        'id_dosen',
        'nama_ketua',
        'dana_ketua',
        'pt',
    ];

    public function dosen()
    {
        return $this->belongsTo(DataDosen::class, 'id_dosen');
    }

    public function members()
    {
        return $this->hasMany(AbdimasMember::class, 'id_abdimas');
    }

    public function additionalFields()
    {
        return $this->hasOne(AbdimasAdditionalField::class, 'id_abdimas');
    }

    public function mahasiswa()
    {
        return $this->hasMany(AbdimasMahasiswa::class, 'id_abdimas');
    }

    public function luaran()
    {
        return $this->hasOne(AbdimasLuaran::class, 'id_abdimas');
    }

    // Helper method to get all related data as single record
    public function getCompleteData()
    {
        return [
            'id' => $this->id,
            'link_sk' => $this->link_sk,
            'no_sk' => $this->no_sk,
            'link_kontrak' => $this->link_kontrak,
            'no_kontrak' => $this->no_kontrak,
            'judul_penelitian' => $this->judul_penelitian,
            'nama_skema' => $this->nama_skema,
            'tahun_usulan' => $this->tahun_usulan,
            'tahun_pelaksanaan' => $this->tahun_pelaksanaan,
            'lama_kegiatan' => $this->lama_kegiatan,
            'bidang_fokus' => $this->bidang_fokus,
            'dana_diusulkan' => $this->dana_diusulkan,
            'dana_disetujui' => $this->dana_disetujui,
            'target_tkt' => $this->target_tkt,
            'nama_program_hibah' => $this->nama_program_hibah,
            'kategori_sumber_dana' => $this->kategori_sumber_dana,
            'negara_sumber_dana' => $this->negara_sumber_dana,
            'sumber_dana' => $this->sumber_dana,
            'id_dosen' => $this->id_dosen,
            'nama_ketua' => $this->nama_ketua,
            'dana_ketua' => $this->dana_ketua,
            'pt' => $this->pt,
            // Members data (flattened) - safe array access
            'nama_member1' => isset($this->members[0]) ? $this->members[0]->nama_member : null,
            'dana_member1' => isset($this->members[0]) ? $this->members[0]->dana_member : null,
            'pt1' => isset($this->members[0]) ? $this->members[0]->pt : null,
            'nama_member2' => isset($this->members[1]) ? $this->members[1]->nama_member : null,
            'dana_member2' => isset($this->members[1]) ? $this->members[1]->dana_member : null,
            'pt2' => isset($this->members[1]) ? $this->members[1]->pt : null,
            'nama_member3' => isset($this->members[2]) ? $this->members[2]->nama_member : null,
            'dana_member3' => isset($this->members[2]) ? $this->members[2]->dana_member : null,
            'pt3' => isset($this->members[2]) ? $this->members[2]->pt : null,
            'nama_member4' => isset($this->members[3]) ? $this->members[3]->nama_member : null,
            'dana_member4' => isset($this->members[3]) ? $this->members[3]->dana_member : null,
            'pt4' => isset($this->members[3]) ? $this->members[3]->pt : null,
            'nama_member5' => isset($this->members[4]) ? $this->members[4]->nama_member : null,
            'dana_member5' => isset($this->members[4]) ? $this->members[4]->dana_member : null,
            'pt5' => isset($this->members[4]) ? $this->members[4]->pt : null,
            'nama_member6' => isset($this->members[5]) ? $this->members[5]->nama_member : null,
            'dana_member6' => isset($this->members[5]) ? $this->members[5]->dana_member : null,
            'pt6' => isset($this->members[5]) ? $this->members[5]->pt : null,
            'nama_member7' => isset($this->members[6]) ? $this->members[6]->nama_member : null,
            'dana_member7' => isset($this->members[6]) ? $this->members[6]->dana_member : null,
            'pt7' => isset($this->members[6]) ? $this->members[6]->pt : null,
            'nama_member8' => isset($this->members[7]) ? $this->members[7]->nama_member : null,
            'dana_member8' => isset($this->members[7]) ? $this->members[7]->dana_member : null,
            'pt8' => isset($this->members[7]) ? $this->members[7]->pt : null,
            // Additional fields - safe access with null check
            'sdg' => $this->additionalFields ? $this->additionalFields->sdg : null,
            'proposal' => $this->additionalFields ? $this->additionalFields->proposal : null,
            'laporan_akhir' => $this->additionalFields ? $this->additionalFields->laporan_akhir : null,
            // Mahasiswa data (flattened) - safe array access
            'nama_mhs1' => isset($this->mahasiswa[0]) ? $this->mahasiswa[0]->nama_mhs : null,
            'prodi_mhs1' => isset($this->mahasiswa[0]) ? $this->mahasiswa[0]->prodi_mhs : null,
            'nama_mhs2' => isset($this->mahasiswa[1]) ? $this->mahasiswa[1]->nama_mhs : null,
            'prodi_mhs2' => isset($this->mahasiswa[1]) ? $this->mahasiswa[1]->prodi_mhs : null,
            'nama_mhs3' => isset($this->mahasiswa[2]) ? $this->mahasiswa[2]->nama_mhs : null,
            'prodi_mhs3' => isset($this->mahasiswa[2]) ? $this->mahasiswa[2]->prodi_mhs : null,
            'nama_mhs4' => isset($this->mahasiswa[3]) ? $this->mahasiswa[3]->nama_mhs : null,
            'prodi_mhs4' => isset($this->mahasiswa[3]) ? $this->mahasiswa[3]->prodi_mhs : null,
            'nama_mhs5' => isset($this->mahasiswa[4]) ? $this->mahasiswa[4]->nama_mhs : null,
            'prodi_mhs5' => isset($this->mahasiswa[4]) ? $this->mahasiswa[4]->prodi_mhs : null,
            'nama_mhs6' => isset($this->mahasiswa[5]) ? $this->mahasiswa[5]->nama_mhs : null,
            'prodi_mhs6' => isset($this->mahasiswa[5]) ? $this->mahasiswa[5]->prodi_mhs : null,
            'nama_mhs7' => isset($this->mahasiswa[6]) ? $this->mahasiswa[6]->nama_mhs : null,
            'prodi_mhs7' => isset($this->mahasiswa[6]) ? $this->mahasiswa[6]->prodi_mhs : null,
            'nama_mhs8' => isset($this->mahasiswa[7]) ? $this->mahasiswa[7]->nama_mhs : null,
            'prodi_mhs8' => isset($this->mahasiswa[7]) ? $this->mahasiswa[7]->prodi_mhs : null,
            // Luaran data - safe access with null check
            'publikasi_ilmiah' => $this->luaran ? $this->luaran->publikasi_ilmiah : null,
            'media_massa' => $this->luaran ? $this->luaran->media_massa : null,
            'produk_jasa' => $this->luaran ? $this->luaran->produk_jasa : null,
            'capaian_publikasi_ilmiah' => $this->luaran ? $this->luaran->capaian_publikasi_ilmiah : null,
            'capaian_luaran_wajib' => $this->luaran ? $this->luaran->capaian_luaran_wajib : null,
            'luaran_tambahan' => $this->luaran ? $this->luaran->luaran_tambahan : null,
        ];
    }
}
