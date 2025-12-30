<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Abdimas;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AbdimasSeeder extends Seeder
{
    public function run(): void
    {
        // Buat reader khusus XLSX
        $reader = IOFactory::createReader('Xlsx');

        // Aktifkan mode read-only (hanya ambil value, abaikan style/format)
        $reader->setReadDataOnly(true);

        // Load file Excel
        $spreadsheet = $reader->load(storage_path('app/private/file_import/DATA MASTER.xlsx'));
        $worksheet = $spreadsheet->getSheetByName('PKM MASTER DATA');
        $rows = $worksheet->toArray();

        // Get hyperlinks from the worksheet
        $hyperlinks = $worksheet->getHyperlinkCollection();

        // Get headers from first row
        $headers = array_shift($rows);

        // Create a helper function to find column index with flexible matching
        $findColumn = function ($searchTerms) use ($headers) {
            $searchTerms = (array)$searchTerms;
            foreach ($searchTerms as $term) {
                $index = array_search($term, $headers, true);
                if ($index !== false) {
                    return $index;
                }
            }
            return false;
        };

        foreach ($rows as $rowIndex => $row) {
            if (empty(array_filter($row))) continue; // Skip empty rows

            // Helper function to get hyperlink value if exists
            $getHyperlink = function ($colIndex) use ($hyperlinks, $rowIndex) {
                if ($colIndex === false) return null;
                $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1) . ($rowIndex + 2);
                if (isset($hyperlinks[$cellCoordinate])) {
                    return $hyperlinks[$cellCoordinate]->getUrl();
                }
                return null;
            };

            // Helper to safely get value from rowData by column index
            $getValue = function ($headers, $row, $colIndex, $default = null) {
                if ($colIndex === false || $colIndex >= count($row)) return $default;
                return $row[$colIndex] ?? $default;
            };

            // Validate required fields before creating record
            $judulIndex = $findColumn(['Judul Penelitian/Pengabdian', 'Judul Penelitian', 'judul_penelitian']);
            $judul_penelitian = $getValue($headers, $row, $judulIndex);

            if (empty($judul_penelitian)) {
                continue;
            }

            // Try to map all possible column variations
            $noSkIndex = $findColumn(['No. SK', 'SK', 'no_sk']);
            $noKontrakIndex = $findColumn(['No. Kontrak', 'Kontrak', 'no_kontrak']);
            $namaSkemaIndex = $findColumn(['Nama Skema', 'Skema', 'nama_skema']);
            $tahunUsuIndex = $findColumn(['Tahun Usulan', 'Tahun Kegiatan', 'tahun_usulan']);
            $tahunPelIndex = $findColumn(['Tahun Pelaksanaan', 'Tahun Pelaksanaan Kegiatan', 'tahun_pelaksanaan']);
            $lamaKegIndex = $findColumn(['Lama Kegiatan (bulan)', 'Lama Kegiatan', 'lama_kegiatan']);
            $bidangFokusIndex = $findColumn(['Bidang Fokus', 'bidang_fokus']);
            $danaUsulIndex = $findColumn(['Dana yang Diusulkan', 'Dana Diusulkan', 'dana_diusulkan']);
            $danaSetujuIndex = $findColumn(['Dana Disetujui', 'dana_disetujui']);
            $targetTktIndex = $findColumn(['Target TKT', 'target_tkt']);
            $namaProgramIndex = $findColumn(['Nama Program Hibah', 'Program Hibah', 'nama_program_hibah']);
            $kategoriDanaIndex = $findColumn(['Kategori Sumber Dana', 'Kategori Dana', 'kategori_sumber_dana']);
            $negaraDanaIndex = $findColumn(['Negara Sumber Dana', 'Negara Dana', 'negara_sumber_dana']);
            $sumberDanaIndex = $findColumn(['Sumber Dana', 'sumber_dana']);
            $namaKetuaIndex = $findColumn(['Nama Ketua', 'Ketua', 'nama_ketua']);
            $danaKetuaIndex = $findColumn(['Dana Ketua', 'DANA KETUA', 'dana_ketua']);
            $ptIndex = $findColumn(['PT', 'Institusi', 'pt']);

            // Create main abdimas record
            $abdimas = Abdimas::create([
                'link_sk' => $getHyperlink($noSkIndex) ?? $getValue($headers, $row, $noSkIndex),
                'no_sk' => $getValue($headers, $row, $noSkIndex),
                'link_kontrak' => $getHyperlink($noKontrakIndex) ?? $getValue($headers, $row, $noKontrakIndex),
                'no_kontrak' => $getValue($headers, $row, $noKontrakIndex),
                'judul_penelitian' => $judul_penelitian,
                'nama_skema' => $getValue($headers, $row, $namaSkemaIndex),
                'tahun_usulan' => parseInteger($getValue($headers, $row, $tahunUsuIndex)) ?? null,
                'tahun_pelaksanaan' => parseInteger($getValue($headers, $row, $tahunPelIndex)) ?? null,
                'lama_kegiatan' => parseInteger($getValue($headers, $row, $lamaKegIndex)) ?? 0,
                'bidang_fokus' => $getValue($headers, $row, $bidangFokusIndex),
                'dana_diusulkan' => parseDana($getValue($headers, $row, $danaUsulIndex)) ?? 0,
                'dana_disetujui' => parseDana($getValue($headers, $row, $danaSetujuIndex)) ?? 0,
                'target_tkt' => parseInteger($getValue($headers, $row, $targetTktIndex)) ?? 0,
                'nama_program_hibah' => $getValue($headers, $row, $namaProgramIndex),
                'kategori_sumber_dana' => $getValue($headers, $row, $kategoriDanaIndex),
                'negara_sumber_dana' => $getValue($headers, $row, $negaraDanaIndex),
                'sumber_dana' => $getValue($headers, $row, $sumberDanaIndex),
                'id_dosen' => getIdDosenByNama($getValue($headers, $row, $namaKetuaIndex)),
                'nama_ketua' => $getValue($headers, $row, $namaKetuaIndex),
                'dana_ketua' => parseDana($getValue($headers, $row, $danaKetuaIndex)) ?? 0,
                'pt' => $getValue($headers, $row, $ptIndex),
            ]);

            // Create members
            for ($i = 1; $i <= 8; $i++) {
                $namaMemIndex = $findColumn(['Nama Member' . $i, 'Member' . $i, 'nama_member' . $i]);
                $namaMem = $getValue($headers, $row, $namaMemIndex);
                if (!empty($namaMem)) {
                    \App\Models\AbdimasMember::create([
                        'id_abdimas' => $abdimas->id,
                        'id_dosen' => getIdDosenByNama($namaMem),
                        'nama_member' => $namaMem,
                        'dana_member' => parseDana($getValue($headers, $row, $findColumn(['Dana Member' . $i, 'DANA MEMBER' . $i, 'dana_member' . $i]))) ?? 0,
                        'pt' => $getValue($headers, $row, $findColumn(['PT Member' . $i, 'PT' . $i, 'pt' . $i])),
                    ]);
                }
            }

            // Create additional fields
            \App\Models\AbdimasAdditionalField::create([
                'id_abdimas' => $abdimas->id,
                'sdg' => $getValue($headers, $row, $findColumn(['SDG', 'sdg'])),
                'proposal' => $getHyperlink($findColumn(['Proposal', 'proposal'])) ?? $getValue($headers, $row, $findColumn(['Proposal', 'proposal'])),
                'laporan_akhir' => $getHyperlink($findColumn(['Laporan Akhir', 'Laporan_Akhir', 'laporan_akhir'])) ?? $getValue($headers, $row, $findColumn(['Laporan Akhir', 'laporan_akhir'])),
            ]);

            // Create mahasiswa records
            for ($i = 1; $i <= 8; $i++) {
                $namaMhsIndex = $findColumn(['Nama Mhs' . $i, 'Nama Mahasiswa' . $i, 'Mahasiswa' . $i, 'nama_mhs' . $i]);
                $namaMhs = $getValue($headers, $row, $namaMhsIndex);
                if (!empty($namaMhs)) {
                    \App\Models\AbdimasMahasiswa::create([
                        'id_abdimas' => $abdimas->id,
                        'nama_mhs' => $namaMhs,
                        'prodi_mhs' => $getValue($headers, $row, $findColumn(['Prodi Mhs' . $i, 'Prodi Mahasiswa' . $i, 'Prodi' . $i, 'prodi_mhs' . $i])),
                    ]);
                }
            }

            // Create luaran record
            \App\Models\AbdimasLuaran::create([
                'id_abdimas' => $abdimas->id,
                'publikasi_ilmiah' => $getValue($headers, $row, $findColumn(['Publikasi Ilmiah', 'publikasi_ilmiah'])),
                'media_massa' => $getValue($headers, $row, $findColumn(['Media Massa', 'media_massa'])),
                'produk_jasa' => $getValue($headers, $row, $findColumn(['Produk / Jasa', 'Produk Jasa', 'produk_jasa'])),
                'capaian_publikasi_ilmiah' => $getValue($headers, $row, $findColumn(['Capaian Publikasi Ilmiah', 'capaian_publikasi_ilmiah'])),
                'capaian_luaran_wajib' => $getValue($headers, $row, $findColumn(['Capaian Luaran Wajib', 'capaian_luaran_wajib'])),
                'luaran_tambahan' => $getValue($headers, $row, $findColumn(['Luaran Tambahan', 'luaran_tambahan'])),
            ]);
        }
    }
}
