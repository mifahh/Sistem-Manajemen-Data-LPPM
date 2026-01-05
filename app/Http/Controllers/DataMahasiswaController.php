<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMahasiswa;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;

class DataMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data_mahasiswa_table(Request $request)
    {
        $query = DataMahasiswa::whereNull('deleted_at');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $data_mahasiswa = $query->orderBy('nim', 'asc')->get();
        $statuses = DataMahasiswa::getStatusList();

        return view('data_mahasiswa.data_mahasiswa_table', [
            'data_mahasiswa' => $data_mahasiswa,
            'jml_mahasiswa' => $data_mahasiswa->count(),
            'statuses' => $statuses,
        ]);
    }

    public function tambah_data_mahasiswa_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'unique' => ':attribute sudah ada',
            'in' => ':attribute tidak valid',
            'max' => ':attribute maksimal :max karakter',
        ];

        $request->validate([
            'nim' => 'required|string|unique:data_mahasiswa,nim',
            'nama' => 'required|string',
            'prodi' => 'required|string',
            'status' => 'required|in:GRADUATED,RESIGN,CHANGE MAJOR,NON-ACTIVE,STUDENT,PASSED AWAY,LEAVE',
            'angkatan' => 'required|string',
        ], $messages);

        DB::beginTransaction();
        try {
            DataMahasiswa::create([
                'nim' => $request->nim,
                'nama' => $request->nama,
                'prodi' => $request->prodi,
                'status' => $request->status,
                'angkatan' => $request->angkatan,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data Mahasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error tambah data mahasiswa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit_data_mahasiswa_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'unique' => ':attribute sudah ada',
            'in' => ':attribute tidak valid',
            'max' => ':attribute maksimal :max karakter',
        ];

        $request->validate([
            'id' => 'required|exists:data_mahasiswa,id',
            'nim' => 'required|string|unique:data_mahasiswa,nim,' . $request->id,
            'nama' => 'required|string',
            'prodi' => 'required|string',
            'status' => 'required|in:GRADUATED,RESIGN,CHANGE MAJOR,NON-ACTIVE,STUDENT,PASSED AWAY,LEAVE',
            'angkatan' => 'required|string',
        ], $messages);

        DB::beginTransaction();
        try {
            $dataMahasiswa = DataMahasiswa::findOrFail($request->id);
            $dataMahasiswa->update([
                'nim' => $request->nim,
                'nama' => $request->nama,
                'prodi' => $request->prodi,
                'status' => $request->status,
                'angkatan' => $request->angkatan,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data Mahasiswa berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error edit data mahasiswa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function hapus_data_mahasiswa_table($id)
    {
        DB::beginTransaction();
        try {
            $dataMahasiswa = DataMahasiswa::findOrFail($id);
            $dataMahasiswa->delete();

            DB::commit();
            return redirect()->back()->with('error', 'Data Mahasiswa berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error hapus data mahasiswa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function import_data_mahasiswa_table(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        DB::beginTransaction();
        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getSheetByName('Data Mahasiswa') ?? $spreadsheet->getActiveSheet();
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
                if (empty($nama)) {
                    Log::warning("Skip row " . ($rowIndex + 2) . ": Missing required fields (nama_mahasiswa)");
                    continue;
                }

                if (DataMahasiswa::where('nama', $nama)->exists()) {
                    Log::warning("Skip row " . ($rowIndex + 2) . ": Nama Mahasiswa '$nama' already exists");
                    continue;
                }

                // // Validate required fields
                // if (empty($nim)) {
                //     throw new \Exception("Row " . ($rowIndex + 2) . ": Missing required fields (NIM)");
                // }

                // if (!in_array($status, $validStatuses)) {
                //     throw new \Exception("Row " . ($rowIndex + 2) . ": Invalid status '{$status}'. Valid statuses: " . implode(', ', $validStatuses));
                // }

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

            DB::commit();
            return redirect()->back()->with('success', "Berhasil import {$imported} data mahasiswa");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error import data mahasiswa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }
}
