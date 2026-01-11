<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KI extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_ki';

    protected $fillable = [
        'application_number',
        'kategori',
        'application_year',
        'title',
        'jenis_hki',
        'prototype',
        'patent_holder',
        'id_dosen',
        'id_mahasiswa',
        'inventor',
        'jabatan',
        'publication_number',
        'publication_link',
        'publication_date',
        'filling_date',
        'reception_date',
        'registration_date',
        'registration_number',
        'status',
        'link'
    ];

    //try standarize date format
    // protected $dates = [
    //     'publication_date',
    //     'filling_date',
    //     'reception_date',
    //     'registration_date',
    // ];

    // protected $casts = [
    //     'publication_date' => 'date',
    //     'filling_date' => 'date',
    //     'reception_date' => 'date',
    //     'registration_date' => 'date',
    // ];

    public function anggota()
    {
        return $this->hasMany(KIAnggota::class, 'id_ki');
    }

    // Helper method to get all related data as single record
    public function getCompleteData()
    {
        $data = [
            'id' => $this->id,
            'application_number' => $this->application_number,
            'kategori' => $this->kategori,
            'application_year' => $this->application_year,
            'title' => $this->title,
            'jenis_hki' => $this->jenis_hki,
            'prototype' => $this->prototype,
            'patent_holder' => $this->patent_holder,
            'id_dosen' => $this->id_dosen,
            'id_mahasiswa' => $this->id_mahasiswa,
            'inventor' => $this->inventor,
            'jabatan' => $this->jabatan,
            'publication_number' => $this->publication_number,
            'publication_link' => $this->publication_link,
            'publication_date' => $this->publication_date,
            'filling_date' => $this->filling_date,
            'reception_date' => $this->reception_date,
            'registration_date' => $this->registration_date,
            'registration_number' => $this->registration_number,
            'status' => $this->status,
            'link' => $this->link,
        ];

        for ($i = 1; $i <= 12; $i++) {
            $anggota = $this->anggota[$i - 1] ?? null;

            $data['id_anggota_dosen' . $i] = $anggota ? $anggota->id_dosen : null;
            $data['id_anggota_mahasiswa' . $i] = $anggota ? $anggota->id_mahasiswa : null;
            $data['anggota' . $i] = $anggota ? $anggota->anggota : null;
            $data['status_anggota' . $i] = $anggota ? $anggota->status_anggota : null;
        }

        return $data;
    }
}
