<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\DataDosen;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Helper function to find id_dosen by nama_dosen
     * Returns id if found, null if not found
     */
    protected function getIdDosenByNama($nama_dosen)
    {
        if (empty($nama_dosen)) {
            return null;
        }

        $dosen = DataDosen::where('nama_dosen', 'like', '%' . trim($nama_dosen) . '%')
            ->first();

        return $dosen ? $dosen->id : null;
    }
}

