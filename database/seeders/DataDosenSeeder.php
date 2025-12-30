<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataDosen;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataDosenSeeder extends Seeder
{
    public function run(): void
    {
        // Buat reader khusus XLSX
        $reader = IOFactory::createReader('Xlsx');

        // Aktifkan mode read-only (hanya ambil value, abaikan style/format)
        $reader->setReadDataOnly(true);

        // Load file Excel
        $spreadsheet = $reader->load(storage_path('app/private/file_import/DATA MASTER.xlsx'));
        $worksheet = $spreadsheet->getSheetByName('Data Dosen All');
        $rows = $worksheet->toArray();

        // Get headers from first row
        $headers = array_shift($rows);

        // Map headers to column indices
        $headerMap = [];
        foreach ($headers as $index => $header) {
            $header = strtolower(trim($header));
            $headerMap[$header] = $index;
        }

        $imported = 0;

        // Process each row
        foreach ($rows as $rowIndex => $row) {
            if (empty(array_filter($row))) continue; // Skip empty rows

            // Helper function to get value from row by header name
            $getValue = function ($headerNames) use ($row, $headerMap) {
                foreach ((array)$headerNames as $name) {
                    $name = strtolower(trim($name));
                    if (isset($headerMap[$name]) && !empty($row[$headerMap[$name]])) {
                        return $row[$headerMap[$name]];
                    }
                }
                return null;
            };

            $status_raw = strtolower(trim((string) $getValue(['Status Aktif', 'status', 'aktif', 'active'])));

            // Extract data from row with multiple header naming support
            $nama_dosen = $getValue(['nama_dosen', 'NAMA', 'dosen name', 'name']);
            $status_aktif = !in_array($status_raw, ['aktif-nocount','non-aktif', '0', '0.0', 'false']);
            $prodi = $getValue(['PRODI', 'program studi', 'jurusan', 'department']);
            $nip = $getValue(['nip', 'NIP YPT', 'employee id']);
            $nidn = $getValue(['NIDN', 'nidn dosen', 'lecturer id']);
            $coe = $getValue(['COE', 'center of excellence']);
            $kk = $getValue(['KK', 'kelompok keahlian', 'expertise group']);
            $kode = $getValue(['kode', 'KODE DOSEN', 'code']);

            // Validate required fields
            if (empty($nama_dosen)) {
                throw new \Exception("Row " . ($rowIndex + 2) . ": Missing required fields (nama_dosen)");
            }

            //cek aktif-nocount
            // if (trim((string) $getValue(['Status Aktif', 'status', 'aktif', 'active'])) === 'Aktif-NoCount') {
            //     throw new \Exception("Row " . ($rowIndex + 2) . $nama_dosen. trim((string) $getValue(['Status Aktif', 'status', 'aktif', 'active'])). $status_aktif);
            // }

            // Check if already exists
            $existing = DataDosen::withTrashed()->where('nip', $nip)->first();

            if ($existing && is_null($existing->deleted_at)) {
                // Update existing
                $existing->update([
                    'nama_dosen' => $nama_dosen,
                    'status_aktif' => $status_aktif,
                    'prodi' => $prodi,
                    'nip' => $nip,
                    'nidn' => $nidn,
                    'coe' => $coe,
                    'kk' => $kk,
                    'kode' => $kode,
                ]);
            } else {
                // Create new
                if ($existing && !is_null($existing->deleted_at)) {
                    $existing->restore();
                }

                DataDosen::create([
                    'nama_dosen' => $nama_dosen,
                    'status_aktif' => $status_aktif,
                    'prodi' => $prodi,
                    'nip' => $nip,
                    'nidn' => $nidn,
                    'coe' => $coe,
                    'kk' => $kk,
                    'kode' => $kode,
                ]);
            }

            $imported++;
        }
    }
}
