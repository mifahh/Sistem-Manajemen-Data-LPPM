<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenelitianLuaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penelitian_luaran';

    protected $fillable = [
        'id_penelitian',
        'luaran_wajib',
        'capaian_luaran_wajib',
        'luaran_tambahan',
        'capaian_luaran_tambahan',
    ];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'id_penelitian');
    }
}
