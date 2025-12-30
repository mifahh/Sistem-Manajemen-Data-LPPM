<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbdimasAdditionalField extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abdimas_additional_fields';

    protected $fillable = [
        'id_abdimas',
        'sdg',
        'proposal',
        'laporan_akhir',
    ];

    public function abdimas()
    {
        return $this->belongsTo(Abdimas::class, 'id_abdimas');
    }
}
