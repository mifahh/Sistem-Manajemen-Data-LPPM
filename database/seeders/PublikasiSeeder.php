<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publikasi;
use App\Models\PublikasiPenulis;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PublikasiSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '2048M'); // atau 2G kalau perlu
        // ini_set('max_execution_time', '3600'); // 300 detik = 5 menit

        // Load file Excel
        $spreadsheet = IOFactory::load(storage_path('app/private/file_import/PUBLIKASI.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();
        // if (!$worksheet) {
        //     throw new \Exception('Worksheet PUBLIKASI (Upd 05Des) not found');
        // }
        $rows = $worksheet->toArray();
        // throw new \Exception('rows: ' . json_encode($rows));

        // Get hyperlinks from the worksheet
        $hyperlinks = $worksheet->getHyperlinkCollection();

        // Get headers from first row
        $headers = array_shift($rows);
        // throw new \Exception('$headers: ' . json_encode($headers));

        // Process each row
        foreach ($rows as $rowIndex => $row) {
            if (empty($row[0])) continue; // Skip judul kosong

            // Helper function to get hyperlink value if exists
            $getHyperlink = function ($colIndex) use ($hyperlinks, $rowIndex) {
                $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1) . ($rowIndex + 2); // +2 because: 1 for 0-based index, 1 for header row

                if (isset($hyperlinks[$cellCoordinate])) {
                    return $hyperlinks[$cellCoordinate]->getUrl();
                }
                return null;
            };

            $rowData = array_combine($headers, $row);

            if (empty($rowData['Judul Publikasi'] ?? null)) {
                continue;
            }

            if (Publikasi::where('judul_publikasi', $rowData['Judul Publikasi'])->exists()) {
                continue;
            }

            // if ($rowData['Tahun Published'] === 2023 || $rowData['Tahun Published'] === '2023' ||
            //     $rowData['Tahun Published'] === 2024 || $rowData['Tahun Published'] === '2024' ||
            //     $rowData['Tahun Published'] === 2025 || $rowData['Tahun Published'] === '2025'
            // ) {
            //     // Skip data tahun 2023
            //     continue;
            // }

            // Create main KI data
            $dataPublikasi = Publikasi::create([
                'judul_publikasi' => $rowData['Judul Publikasi'] ?? null,
                'nama_jurnal' => $rowData['Nama Jurnal'] ?? null,
                'akreditasi_index_jurnal' => $rowData['Akreditasi/Index Jurnal'] ?? null,
                'lembaga_pengindeks' => $rowData['Lembaga Pengindeks'] ?? null,
                'tahun_published' => $rowData['Tahun Published'] ?? null,
                'id_dosen' => getIdDosenByNama($rowData['Nama Penulis Koresponding'] ?? null),
                'nama_penulis_koresponding' => $rowData['Nama Penulis Koresponding'] ?? null,
                'prodi' => getProdiDosenById(getIdDosenByNama($rowData['Nama Penulis Koresponding'] ?? null)) ?? getProdiMahasiswaById(getIdMahasiswaByNama($rowData['Nama Penulis Koresponding'] ?? null)) ?? null,
                'status' => $rowData['Status'] ?? null,
                'afiliasi' => $rowData['Afiliasi'] ?? null,
                'doi' => $getHyperlink(array_search('DOI', $headers)) ?? $rowData['DOI'] ?? null,
            ]);

            // Create anggota data
            for ($i = 1; $i <= 6; $i++) {
                $namaPenulis = trim($rowData['Nama Penulis (' . $i . ')'] ?? '');
                // Skip jika kosong atau hanya berisi dash/placeholder
                if (!empty($namaPenulis) && $namaPenulis !== '-') {
                    PublikasiPenulis::create([
                        'id_publikasi' => $dataPublikasi->id,
                        'id_mahasiswa' => getIdMahasiswaByNama($namaPenulis),
                        'id_dosen' => getIdDosenByNama($namaPenulis),
                        'nama_penulis' => $namaPenulis,
                        'prodi' => $rowData['Prodi' . $i] ?? getProdiDosenById(getIdDosenByNama($namaPenulis)) ?? getProdiMahasiswaById(getIdMahasiswaByNama($namaPenulis)) ?? null,
                        'status' => $rowData['Status' . $i] ?? null,
                        'afiliasi' => $rowData['Afiliasi' . $i] ?? null,
                    ]);
                }
            }

            if(!empty($rowData['Nama Penulis Lain'])) {
                // Split by semicolon or comma
                $otherAuthors = explode(';', $rowData['Nama Penulis Lain']);
                foreach ($otherAuthors as $authorName) {
                    $authorName = trim($authorName);
                    // Skip jika kosong atau hanya berisi dash/placeholder
                    if (!empty($authorName) && $authorName !== '-') {
                        PublikasiPenulis::create([
                            'id_publikasi' => $dataPublikasi->id,
                            'id_mahasiswa' => getIdMahasiswaByNama($authorName),
                            'id_dosen' => getIdDosenByNama($authorName),
                            'nama_penulis' => $authorName,
                            'prodi' => $rowData['Prodi Lain'] ?? getProdiDosenById(getIdDosenByNama($authorName)) ?? getProdiMahasiswaById(getIdMahasiswaByNama($authorName)) ?? null,
                            'status' => $rowData['Status Lain'] ?? null,
                            'afiliasi' => $rowData['Afiliasi Lain'] ?? (getIdDosenByNama($authorName) || getIdMahasiswaByNama($authorName) ? 'Telkom University' : null),
                        ]);
                    }
                }
            }

            // if (!empty($rowData['Nama Penulis Lain'])) {
            //     PublikasiPenulis::create([
            //         'id_publikasi' => $dataPublikasi->id,
            //         'id_mahasiswa' => getIdMahasiswaByNama($rowData['Nama Penulis Lain'] ?? null),
            //         'id_dosen' => getIdDosenByNama($rowData['Nama Penulis Lain'] ?? null),
            //         'nama_penulis' => $rowData['Nama Penulis Lain'] ?? null,
            //         'prodi' => $rowData['Prodi Lain'] ?? null,
            //         'status' => $rowData['Status Lain'] ?? null,
            //         'afiliasi' => $rowData['Afiliasi Lain'] ?? null,
            //     ]);
            // }
        }
    }
}
