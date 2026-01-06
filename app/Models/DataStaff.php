<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataStaff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "data_staff";
    // public $incrementing = true;
    // $reader->formatDates(false);
    protected $fillable = [
        'nama_staff', 'status_aktif', 'nip'
    ];
    // public static function getIpos(){
    //     $ipos = DB::table('tbl_ipos')->get();
    //     return $ipos;
    // }
}
