<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenelitianAdditionalField extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penelitian_additional_fields';

    protected $fillable = [
        'id_penelitian',
        'sdg',
        'proposal',
        'laporan_akhir',
    ];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'id_penelitian');
    }
}
