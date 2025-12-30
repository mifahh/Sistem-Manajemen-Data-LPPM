<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penelitian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penelitian_main';

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
        'dana_disetujui',
        'target_tkt',
        'nama_institusi_penerima_dana',
        'nama_program_hibah',
        'kategori_sumber_dana',
        'negara_sumber_dana',
        'sumber_dana',
        'id_dosen',
        'nama_ketua',
        'dana_ketua',
        'pt',
    ];

    public function members()
    {
        return $this->hasMany(PenelitianMember::class, 'id_penelitian');
    }

    public function additionalFields()
    {
        return $this->hasOne(PenelitianAdditionalField::class, 'id_penelitian');
    }

    public function mahasiswa()
    {
        return $this->hasMany(PenelitianMahasiswa::class, 'id_penelitian');
    }

    public function luaran()
    {
        return $this->hasOne(PenelitianLuaran::class, 'id_penelitian');
    }

    public function dosen()
    {
        return $this->belongsTo(DataDosen::class, 'id_dosen');
    }

    // // Helper method to get all related data as single record
    // public function getCompleteData()
    // {
    //     return [
    //         'id' => $this->id,
    //         'link_sk' => $this->link_sk,
    //         'no_sk' => $this->no_sk,
    //         'link_kontrak' => $this->link_kontrak,
    //         'no_kontrak' => $this->no_kontrak,
    //         'judul_penelitian' => $this->judul_penelitian,
    //         'nama_skema' => $this->nama_skema,
    //         'tahun_usulan' => $this->tahun_usulan,
    //         'tahun_pelaksanaan' => $this->tahun_pelaksanaan,
    //         'lama_kegiatan' => $this->lama_kegiatan,
    //         'bidang_fokus' => $this->bidang_fokus,
    //         'dana_disetujui' => $this->dana_disetujui,
    //         'target_tkt' => $this->target_tkt,
    //         'nama_program_hibah' => $this->nama_program_hibah,
    //         'kategori_sumber_dana' => $this->kategori_sumber_dana,
    //         'negara_sumber_dana' => $this->negara_sumber_dana,
    //         'sumber_dana' => $this->sumber_dana,
    //         'id_dosen' => $this->id_dosen,
    //         'nama_ketua' => $this->nama_ketua,
    //         'dana_ketua' => $this->dana_ketua,
    //         'pt' => $this->pt,
    //     ];
    // }

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
            'dana_disetujui' => $this->dana_disetujui,
            'target_tkt' => $this->target_tkt,
            'nama_institusi_penerima_dana' => $this->nama_institusi_penerima_dana,
            'nama_program_hibah' => $this->nama_program_hibah,
            'kategori_sumber_dana' => $this->kategori_sumber_dana,
            'negara_sumber_dana' => $this->negara_sumber_dana,
            'sumber_dana' => $this->sumber_dana,
            'id_dosen' => $this->id_dosen,
            'nama_ketua' => $this->nama_ketua,
            'dana_ketua' => $this->dana_ketua,
            'kode_ketua' => getKodeDosenById($this->id_dosen),
            'pt' => $this->pt,
            // Members data (flattened) - safe array access
            'nama_member1' => isset($this->members[0]) ? $this->members[0]->nama_member : null,
            'dana_member1' => isset($this->members[0]) ? $this->members[0]->dana_member : null,
            'kode_member1' => isset($this->members[0]) ? getKodeDosenById($this->members[0]->id_dosen) : null,
            'pt1' => isset($this->members[0]) ? $this->members[0]->pt : null,
            'nama_member2' => isset($this->members[1]) ? $this->members[1]->nama_member : null,
            'dana_member2' => isset($this->members[1]) ? $this->members[1]->dana_member : null,
            'kode_member2' => isset($this->members[1]) ? getKodeDosenById($this->members[1]->id_dosen) : null,
            'pt2' => isset($this->members[1]) ? $this->members[1]->pt : null,
            'nama_member3' => isset($this->members[2]) ? $this->members[2]->nama_member : null,
            'dana_member3' => isset($this->members[2]) ? $this->members[2]->dana_member : null,
            'kode_member3' => isset($this->members[2]) ? getKodeDosenById($this->members[2]->id_dosen) : null,
            'pt3' => isset($this->members[2]) ? $this->members[2]->pt : null,
            'nama_member4' => isset($this->members[3]) ? $this->members[3]->nama_member : null,
            'dana_member4' => isset($this->members[3]) ? $this->members[3]->dana_member : null,
            'kode_member4' => isset($this->members[3]) ? getKodeDosenById($this->members[3]->id_dosen) : null,
            'pt4' => isset($this->members[3]) ? $this->members[3]->pt : null,
            'nama_member5' => isset($this->members[4]) ? $this->members[4]->nama_member : null,
            'dana_member5' => isset($this->members[4]) ? $this->members[4]->dana_member : null,
            'kode_member5' => isset($this->members[4]) ? getKodeDosenById($this->members[4]->id_dosen) : null,
            'pt5' => isset($this->members[4]) ? $this->members[4]->pt : null,
            'nama_member6' => isset($this->members[5]) ? $this->members[5]->nama_member : null,
            'dana_member6' => isset($this->members[5]) ? $this->members[5]->dana_member : null,
            'kode_member6' => isset($this->members[5]) ? getKodeDosenById($this->members[5]->id_dosen) : null,
            'pt6' => isset($this->members[5]) ? $this->members[5]->pt : null,
            'nama_member7' => isset($this->members[6]) ? $this->members[6]->nama_member : null,
            'dana_member7' => isset($this->members[6]) ? $this->members[6]->dana_member : null,
            'kode_member7' => isset($this->members[6]) ? getKodeDosenById($this->members[6]->id_dosen) : null,
            'pt7' => isset($this->members[6]) ? $this->members[6]->pt : null,
            'nama_member8' => isset($this->members[7]) ? $this->members[7]->nama_member : null,
            'dana_member8' => isset($this->members[7]) ? $this->members[7]->dana_member : null,
            'kode_member8' => isset($this->members[7]) ? getKodeDosenById($this->members[7]->id_dosen) : null,
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
            'luaran_wajib' => $this->luaran ? $this->luaran->luaran_wajib : null,
            'capaian_luaran_wajib' => $this->luaran ? $this->luaran->capaian_luaran_wajib : null,
            'luaran_tambahan' => $this->luaran ? $this->luaran->luaran_tambahan : null,
            'capaian_luaran_tambahan' => $this->luaran ? $this->luaran->capaian_luaran_tambahan : null,
        ];
    }
}
