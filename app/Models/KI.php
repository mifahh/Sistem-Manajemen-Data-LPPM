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
        'inventor',
        'jabatan',
        'prodi',
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
        return [
            'id' => $this->id,
            'application_number' => $this->application_number,
            'kategori' => $this->kategori,
            'application_year' => $this->application_year,
            'title' => $this->title,
            'jenis_hki' => $this->jenis_hki,
            'prototype' => $this->prototype,
            'patent_holder' => $this->patent_holder,
            'inventor' => $this->inventor,
            'jabatan' => $this->jabatan,
            'prodi' => $this->prodi,
            'publication_number' => $this->publication_number,
            'publication_link' => $this->publication_link,
            'publication_date' => $this->publication_date,
            'filling_date' => $this->filling_date,
            'reception_date' => $this->reception_date,
            'registration_date' => $this->registration_date,
            'registration_number' => $this->registration_number,
            'status' => $this->status,
            'link' => $this->link,
            // Members data (flattened) - safe array access
            'anggota1' => isset($this->anggota[0]) ? $this->anggota[0]->anggota : null,
            'status_anggota1' => isset($this->anggota[0]) ? $this->anggota[0]->status_anggota : null,
            'prodi1' => isset($this->anggota[0]) ? $this->anggota[0]->prodi : null,
            'anggota2' => isset($this->anggota[1]) ? $this->anggota[1]->anggota : null,
            'status_anggota2' => isset($this->anggota[1]) ? $this->anggota[1]->status_anggota : null,
            'prodi2' => isset($this->anggota[1]) ? $this->anggota[1]->prodi : null,
            'anggota3' => isset($this->anggota[2]) ? $this->anggota[2]->anggota : null,
            'status_anggota3' => isset($this->anggota[2]) ? $this->anggota[2]->status_anggota : null,
            'prodi3' => isset($this->anggota[2]) ? $this->anggota[2]->prodi : null,
            'anggota4' => isset($this->anggota[3]) ? $this->anggota[3]->anggota : null,
            'status_anggota4' => isset($this->anggota[3]) ? $this->anggota[3]->status_anggota : null,
            'prodi4' => isset($this->anggota[3]) ? $this->anggota[3]->prodi : null,
            'anggota5' => isset($this->anggota[4]) ? $this->anggota[4]->anggota : null,
            'status_anggota5' => isset($this->anggota[4]) ? $this->anggota[4]->status_anggota : null,
            'prodi5' => isset($this->anggota[4]) ? $this->anggota[4]->prodi : null,
            'anggota6' => isset($this->anggota[5]) ? $this->anggota[5]->anggota : null,
            'status_anggota6' => isset($this->anggota[5]) ? $this->anggota[5]->status_anggota : null,
            'prodi6' => isset($this->anggota[5]) ? $this->anggota[5]->prodi : null,
            'anggota7' => isset($this->anggota[6]) ? $this->anggota[6]->anggota : null,
            'status_anggota7' => isset($this->anggota[6]) ? $this->anggota[6]->status_anggota : null,
            'prodi7' => isset($this->anggota[6]) ? $this->anggota[6]->prodi : null,
            'anggota8' => isset($this->anggota[7]) ? $this->anggota[7]->anggota : null,
            'status_anggota8' => isset($this->anggota[7]) ? $this->anggota[7]->status_anggota : null,
            'prodi8' => isset($this->anggota[7]) ? $this->anggota[7]->prodi : null,
            'anggota9' => isset($this->anggota[8]) ? $this->anggota[8]->anggota : null,
            'status_anggota9' => isset($this->anggota[8]) ? $this->anggota[8]->status_anggota : null,
            'prodi9' => isset($this->anggota[8]) ? $this->anggota[8]->prodi : null,
            'anggota10' => isset($this->anggota[9]) ? $this->anggota[9]->anggota : null,
            'status_anggota10' => isset($this->anggota[9]) ? $this->anggota[9]->status_anggota : null,
            'prodi10' => isset($this->anggota[9]) ? $this->anggota[9]->prodi : null,
        ];
    }
}
