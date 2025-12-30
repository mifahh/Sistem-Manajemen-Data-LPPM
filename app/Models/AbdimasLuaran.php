<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbdimasLuaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abdimas_luaran';

    protected $fillable = [
        'id_abdimas',
        'publikasi_ilmiah',
        'media_massa',
        'produk_jasa',
        'capaian_publikasi_ilmiah',
        'capaian_luaran_wajib',
        'luaran_tambahan',
    ];

    public function abdimas()
    {
        return $this->belongsTo(Abdimas::class, 'id_abdimas');
    }
}
