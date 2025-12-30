<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbdimasMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abdimas_members';

    protected $fillable = [
        'id_abdimas',
        'id_dosen',
        'nama_member',
        'dana_member',
        'pt',
    ];

    public function abdimas()
    {
        return $this->belongsTo(Abdimas::class, 'id_abdimas');
    }

    public function dosen()
    {
        return $this->belongsTo(DataDosen::class, 'id_dosen');
    }
}
