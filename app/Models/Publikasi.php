<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publikasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_publikasi';
    protected $guarded = [];

    protected $fillable = [
        'judul_publikasi',
        'nama_jurnal',
        'akreditasi_index_jurnal',
        'lembaga_pengindeks',
        'tahun_published',
        'id_mahasiswa',
        'id_dosen',
        'nama_penulis_koresponding',
        'status',
        'afiliasi',
        'doi',
    ];

    public function penulis()
    {
        return $this->hasMany(PublikasiPenulis::class, 'id_publikasi');
    }

    public function getCompleteData()
    {
        $data = [
            'id' => $this->id,
            'judul_publikasi' => $this->judul_publikasi,
            'nama_jurnal' => $this->nama_jurnal,
            'akreditasi_index_jurnal' => $this->akreditasi_index_jurnal,
            'lembaga_pengindeks' => $this->lembaga_pengindeks,
            'tahun_published' => $this->tahun_published,
            'id_mahasiswa' => $this->id_mahasiswa,
            'id_dosen' => $this->id_dosen,
            'nama_penulis_koresponding' => $this->nama_penulis_koresponding,
            'status' => $this->status,
            'afiliasi' => $this->afiliasi,
            'doi' => $this->doi,
        ];

        for ($i = 0; $i < 15; $i++) {
            $penulis = $this->penulis[$i - 1] ?? null;
            $data['id_penulis_dosen_' . $i]  = $penulis->id_dosen ?? null;
            $data['id_penulis_mahasiswa_' . $i]  = $penulis->id_mahasiswa ?? null;
            $data['penulis_' . $i]  = $penulis->nama_penulis ?? null;
            $data['status_' . $i]        = $penulis->status ?? null;
            $data['afiliasi_' . $i]      = $penulis->afiliasi ?? null;
        }

        return $data;
    }
}
