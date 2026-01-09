<?php
use App\Models\DataDosen;


if (!function_exists('cleanDana')) {
    function parseDana($value) {
        if (is_null($value)) return null;
        if (is_numeric($value)) return (int) $value;

        $clean = str_replace(['Rp', '.', ',', ' '], '', trim((string) $value));
        return is_numeric($clean) ? (int) $clean : null;
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($value) {
        return $value ? 'Rp' . number_format($value, 2, ',', '.') : '-';
    }

}

if (!function_exists('parseInteger')) {
    function parseInteger($value) {
        if (is_null($value)) return null;
        $value = trim((string) $value);

        // Ambil semua digit dari string
        preg_match('/\d+/', $value, $matches);

        return $matches ? (int)$matches[0] : null;
    }

}

if (!function_exists('getIdDosenByNama')){
    function getIdDosenByNama($nama_dosen)
    {
        if (empty($nama_dosen)) {
            return null;
        }

        $dosen = DataDosen::where('nama_dosen', 'like', '%' . trim($nama_dosen) . '%')
            ->first();

        return $dosen ? $dosen->id : null;
    }
}

if (!function_exists('getProdiDosenByNama')){
    function getProdiDosenByNama($nama_dosen)
    {
        if (empty($nama_dosen)) {
            return null;
        }

        $dosen = DataDosen::where('nama_dosen', 'like', '%' . trim($nama_dosen) . '%')
            ->first();

        return $dosen ? $dosen->prodi : null;
    }
}

if (!function_exists('getKodeDosenById')){
    function getKodeDosenById($id_dosen)
    {
        if (empty($id_dosen)) {
            return null;
        }

        $dosen = DataDosen::find($id_dosen);

        return $dosen ? $dosen->kode : null;
    }
}

if (!function_exists('getProdiDosenById')){
    function getProdiDosenById($id_dosen)
    {
        if (empty($id_dosen)) {
            return null;
        }

        $dosen = DataDosen::find($id_dosen);

        return $dosen ? $dosen->prodi : null;
    }
}

if (!function_exists('getIdMahasiswaByNama')){
    function getIdMahasiswaByNama($nama_mahasiswa)
    {
        if (empty($nama_mahasiswa)) {
            return null;
        }

        $mahasiswa = \App\Models\DataMahasiswa::where('nama_mahasiswa', 'like', '%' . trim($nama_mahasiswa) . '%')
            ->first();

        return $mahasiswa ? $mahasiswa->id : null;
    }
}

if (!function_exists('getProdiMahasiswaByNama')){
    function getProdiMahasiswaByNama($nama_mahasiswa)
    {
        if (empty($nama_mahasiswa)) {
            return null;
        }

        $mahasiswa = \App\Models\DataMahasiswa::where('nama_mahasiswa', 'like', '%' . trim($nama_mahasiswa) . '%')
            ->first();

        return $mahasiswa ? $mahasiswa->prodi : null;
    }
}

if (!function_exists('getNIMMahasiswaById')){
    function getNIMMahasiswaById($id_mahasiswa)
    {
        if (empty($id_mahasiswa)) {
            return null;
        }

        $mahasiswa = \App\Models\DataMahasiswa::find($id_mahasiswa);

        return $mahasiswa ? $mahasiswa->nim : null;
    }
}

if (!function_exists('getProdiMahasiswaById')){
    function getProdiMahasiswaById($id_mahasiswa)
    {
        if (empty($id_mahasiswa)) {
            return null;
        }

        $mahasiswa = \App\Models\DataMahasiswa::find($id_mahasiswa);

        return $mahasiswa ? $mahasiswa->prodi : null;
    }
}
