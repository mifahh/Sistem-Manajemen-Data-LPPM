<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenelitianMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penelitian_members';

    protected $fillable = [
        'id_penelitian',
        'id_dosen',
        'nama_member',
        'dana_member',
        'pt',
    ];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'id_penelitian');
    }

    public function dosen()
    {
        return $this->belongsTo(DataDosen::class, 'id_dosen');
    }
}
