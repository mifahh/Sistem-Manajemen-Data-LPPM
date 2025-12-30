<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataMahasiswa;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Buat reader khusus XLSX
        $reader = IOFactory::createReader('Xlsx');

        // Aktifkan mode read-only (hanya ambil value, abaikan style/format)
        $reader->setReadDataOnly(true);

        // Load file Excel
        $spreadsheet = $reader->load(storage_path('app/private/file_import/DATA MASTER.xlsx'));
        $worksheet = $spreadsheet->getSheetByName('Data Mahasiswa');
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
        $validStatuses = DataMahasiswa::getStatusList();

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

            // Extract data from row with multiple header naming support
            $nim = $getValue(['nim', 'NIM', 'student id']);
            $nama = $getValue(['nama', 'NAMA', 'nama mahasiswa', 'name', 'student name']);
            $prodi = $getValue(['prodi', 'PRODI', 'program studi', 'jurusan', 'department']);
            $status = strtoupper(trim((string) $getValue(['status', 'STATUS', 'student status'])));
            $angkatan = $getValue(['angkatan', 'ANGKATAN', 'year', 'batch', 'tahun angkatan']);

            // Validate required fields
            if (empty($nim)) {
                throw new \Exception("Row " . ($rowIndex + 2) . ": Missing required fields (NIM)");
            }
            if (empty($nama)) {
                throw new \Exception("Row " . ($rowIndex + 2) . ": Missing required fields (Nama)");
            }
            if (!in_array($status, $validStatuses)) {
                throw new \Exception("Row " . ($rowIndex + 2) . ": Invalid status '{$status}'. Valid statuses: " . implode(', ', $validStatuses));
            }

            // Check if already exists
            $existing = DataMahasiswa::withTrashed()->where('nim', $nim)->first();

            if ($existing && is_null($existing->deleted_at)) {
                // Update existing
                $existing->update([
                    'nim' => $nim,
                    'nama' => $nama,
                    'prodi' => $prodi,
                    'status' => $status,
                    'angkatan' => $angkatan,
                ]);
            } else {
                // Create new
                if ($existing && !is_null($existing->deleted_at)) {
                    $existing->restore();
                }

                DataMahasiswa::create([
                    'nim' => $nim,
                    'nama' => $nama,
                    'prodi' => $prodi,
                    'status' => $status,
                    'angkatan' => $angkatan,
                ]);
            }

            $imported++;
        }
    }
}
