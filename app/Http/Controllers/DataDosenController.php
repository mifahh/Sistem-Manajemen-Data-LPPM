<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataDosen;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;

class DataDosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data_dosen_table(Request $request)
    {
        $query = DataDosen::whereNull('deleted_at');

        if ($request->has('status_aktif') && $request->status_aktif != '') {
            $query->where('status_aktif', $request->status_aktif);
        }

        $data_dosen = $query->orderBy('nama_dosen', 'asc')->get();
        $jurusan = \App\Models\MasterJurusan::all();
        $coe = \App\Models\MasterCoE::all();
        $kk = \App\Models\MasterKK::all();

        return view('data_dosen.data_dosen_table', [
            'data_dosen' => $data_dosen,
            'jml_dosen' => $data_dosen->count(),
            'jurusan' => $jurusan,
            'coe' => $coe,
            'kk' => $kk,
        ]);
    }

    public function tambah_data_dosen_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'unique' => ':attribute sudah ada',
            'in' => ':attribute tidak valid',
            'max' => ':attribute maksimal :max karakter',
        ];

        $request->validate([
            'nama_dosen' => 'required|string|unique:data_dosen,nama_dosen',
            'status_aktif' => 'required|in:1,0',
            'prodi' => 'required|string',
            'nip' => 'required|string|max:10|unique:data_dosen,nip',
            'nidn' => 'required|string|max:10|unique:data_dosen,nidn',
            'kode' => 'nullable|string|max:5',
        ], $messages);

        DB::beginTransaction();
        try {
            DataDosen::create([
                'nama_dosen' => $request->nama_dosen,
                'status_aktif' => $request->status_aktif,
                'prodi' => $request->prodi,
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'coe' => $request->coe,
                'kk' => $request->kk,
                'kode' => $request->kode,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data Dosen berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error tambah data dosen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit_data_dosen_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'unique' => ':attribute sudah ada',
            'in' => ':attribute tidak valid',
            'max' => ':attribute maksimal :max karakter',
        ];

        $request->validate([
            'id' => 'required|exists:data_dosen,id',
            'nama_dosen' => 'required|string|unique:data_dosen,nama_dosen,' . $request->id,
            'status_aktif' => 'required|in:1,0',
            'prodi' => 'required|string',
            'nip' => 'required|string|max:10|unique:data_dosen,nip,' . $request->id,
            'nidn' => 'required|string|max:10|unique:data_dosen,nidn,' . $request->id,
            'kode' => 'nullable|string|max:5',
        ], $messages);

        DB::beginTransaction();
        try {
            $dataDosen = DataDosen::findOrFail($request->id);
            $dataDosen->update([
                'nama_dosen' => $request->nama_dosen,
                'status_aktif' => $request->status_aktif,
                'prodi' => $request->prodi,
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'coe' => $request->coe,
                'kk' => $request->kk,
                'kode' => $request->kode,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data Dosen berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error edit data dosen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function hapus_data_dosen_table($id)
    {
        DB::beginTransaction();
        try {
            $dataDosen = DataDosen::findOrFail($id);
            $dataDosen->delete();

            DB::commit();
            return redirect()->back()->with('error', 'Data Dosen berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error hapus data dosen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function import_data_dosen_table(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        DB::beginTransaction();
        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
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
                $status_aktif = !in_array($status_raw, ['non-aktif', '0', '0.0', 'false']);
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

                // Check if already exists
                $existing = DataDosen::withTrashed()->where('nidn', $nidn)->first();

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

            DB::commit();
            return redirect()->back()->with('success', "Berhasil import {$imported} data dosen");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error import data dosen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }
}
