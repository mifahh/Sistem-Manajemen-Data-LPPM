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
        $data = [
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
            'id_ketua' => $this->id_dosen,
            'nama_ketua' => $this->nama_ketua,
            'dana_ketua' => $this->dana_ketua,
            'pt' => $this->pt,

            // Additional fields - safe access with null check
            'sdg' => $this->additionalFields ? $this->additionalFields->sdg : null,
            'proposal' => $this->additionalFields ? $this->additionalFields->proposal : null,
            'laporan_akhir' => $this->additionalFields ? $this->additionalFields->laporan_akhir : null,

            // Luaran data - safe access with null check
            'luaran_wajib' => $this->luaran ? $this->luaran->luaran_wajib : null,
            'capaian_luaran_wajib' => $this->luaran ? $this->luaran->capaian_luaran_wajib : null,
            'luaran_tambahan' => $this->luaran ? $this->luaran->luaran_tambahan : null,
            'capaian_luaran_tambahan' => $this->luaran ? $this->luaran->capaian_luaran_tambahan : null,
        ];

        // Members data (flattened) - safe array access
        for ($i = 1; $i <= 8; $i++) {
            $member = $this->members[$i - 1] ?? null;

            $data['id_member' . $i] = $member->id_dosen ?? null;
            $data['nama_member' . $i] = $member->nama_member ?? null;
            $data['dana_member' . $i] = $member->dana_member ?? null;
            $data['pt' . $i] = $member->pt ?? null;
        }

        // Mahasiswa data (flattened) - safe array access
        for ($i = 1; $i <= 8; $i++) {
            $mhs = $this->mahasiswa[$i - 1] ?? null;
            $data['nama_mhs' . $i] = $mhs ? $mhs->nama_mhs : null;
            $data['id_mhs' . $i] = $mhs ? $mhs->id_mahasiswa : null;
        }

        return $data;
    }
}
