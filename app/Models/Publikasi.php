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
        'id_dosen',
        'nama_penulis_koresponding',
        'prodi',
        'status',
        'afiliasi',
        'doi',
    ];

    public function penulis()
    {
        return $this->hasMany(PublikasiPenulis::class, 'id_publikasi');
    }

    protected $dates = ['deleted_at'];
    public function getCompleteData()
    {
        $data = [
            'id' => $this->id,
            'judul_publikasi' => $this->judul_publikasi,
            'nama_jurnal' => $this->nama_jurnal,
            'akreditasi_index_jurnal' => $this->akreditasi_index_jurnal,
            'lembaga_pengindeks' => $this->lembaga_pengindeks,
            'tahun_published' => $this->tahun_published,
            'nama_penulis_koresponding' => $this->nama_penulis_koresponding,
            'prodi' => $this->prodi,
            'status' => $this->status,
            'afiliasi' => $this->afiliasi,
            'doi' => $this->doi,
        ];

        // Loop penulis (maksimal 15)
        for ($i = 1; $i <= 15; $i++) {
            $penulis = $this->penulis[$i - 1] ?? null;

            $data['penulis_' . $i]  = $penulis ? $penulis->nama_penulis : null;
            $data['prodi_' . $i]    = $penulis ? $penulis->prodi : null;
            $data['status_' . $i]   = $penulis ? $penulis->status : null;
            $data['afiliasi_' . $i] = $penulis ? $penulis->afiliasi : null;
        }

        return $data;
    }
}
