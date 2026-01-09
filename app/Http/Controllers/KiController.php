<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KI;
use App\Models\KIAnggota;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function data_ki_table(Request $request)
    {
        $query = KI::with('anggota')->whereNull('deleted_at');
        $selected_tahun = ($request->has('tahun_filter') && $request->tahun_filter != '') ? $request->tahun_filter : KI::max('application_year');

        $query->when(
            $request->filled('tahun_filter') && $request->tahun_filter !== '',
            fn ($q) => $q->where('application_year', $request->tahun_filter),
            fn ($q) => $q->where('application_year', KI::max('application_year'))
        );

        $data_ki = $query->get();
        $tahun_filter = KI::select('application_year')->distinct()->orderBy('application_year', 'desc')->pluck('application_year');
        $tahun = \App\Models\MasterTahun::all();
        $jurusan = \App\Models\MasterJurusan::all();
        $kategori = \App\Models\MasterKategoriKI::all();

        // Transform data to flattened format for view
        $transformedData = $data_ki->map(function($item) {
            return $item->getCompleteData();
        });

        return view('ki.data_ki_table', [
            'ki' => $transformedData,
            'tahun_filter' => $tahun_filter,
            'selected_tahun' => $selected_tahun,
            'tahun' => $tahun,
            'jurusan' => $jurusan,
            'kategori' => $kategori,
            'jml_ki' => $data_ki->count()
        ]);
    }

    public function tambah_data_ki_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'unique' => ':attribute sudah ada',
        ];

        $request->validate([
            'kategori' => 'required|string',
            'application_year' => 'required|integer',
            'title' => 'required|string|unique:data_ki,title',
            'jenis_hki' => 'required|string',
            'status' => 'required|string',
        ], $messages);

        DB::beginTransaction();
        try {
            $dataKi = KI::create([
                'application_number' => $request->application_number,
                'kategori' => $request->kategori,
                'application_year' => $request->application_year,
                'title' => $request->title,
                'jenis_hki' => $request->jenis_hki,
                'prototype' => $request->prototype,
                'patent_holder' => $request->patent_holder,
                'inventor' => $request->inventor,
                'jabatan' => $request->jabatan,
                'prodi' => $request->prodi,
                'publication_number' => $request->publication_number,
                'publication_link' => $request->publication_link,
                'publication_date' => $request->publication_date,
                'filling_date' => $request->filling_date,
                'reception_date' => $request->reception_date,
                'registration_date' => $request->registration_date,
                'registration_number' => $request->registration_number,
                'status' => $request->status,
                'link' => $request->link,
            ]);

            for ($i = 1; $i <= 10; $i++) {
                if (!empty($request->input("anggota_{$i}"))) {
                    KIAnggota::create([
                        'id_ki' => $dataKi->id,
                        'id_dosen' => $this->getIdDosenByNama($request->input("anggota_{$i}")),
                        'id_mahasiswa' => $this->getIdMahasiswaByNama($request->input("anggota_{$i}")),
                        'anggota' => $request->input("anggota_{$i}"),
                        'status_anggota' => $request->input("status_anggota_{$i}"),
                        'prodi' => $request->input("prodi_{$i}"),
                    ]);
                }
            }


            DB::commit();
            return redirect()->back()->with('success', 'Data KI berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit_data_ki_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
        ];
        $request->validate([
            'id' => 'required|exists:data_ki,id',
            'kategori' => 'required|string',
            'application_year' => 'required|integer',
            'title' => 'required|string',
            'jenis_hki' => 'required|string',
            'status' => 'required|string',
        ], $messages);
        DB::beginTransaction();
        try {
            $dataKi = KI::findOrFail($request->id);
            $dataKi->update([
                'application_number' => $request->application_number,
                'kategori' => $request->kategori,
                'application_year' => $request->application_year,
                'title' => $request->title,
                'jenis_hki' => $request->jenis_hki,
                'prototype' => $request->prototype,
                'patent_holder' => $request->patent_holder,
                'inventor' => $request->inventor,
                'jabatan' => $request->jabatan,
                'prodi' => $request->prodi,
                'publication_number' => $request->publication_number,
                'publication_link' => $request->publication_link,
                'publication_date' => $request->publication_date,
                'filling_date' => $request->filling_date,
                'reception_date' => $request->reception_date,
                'registration_date' => $request->registration_date,
                'registration_number' => $request->registration_number,
                'status' => $request->status,
                'link' => $request->link,
            ]);

            $dataKi->anggota()->delete();

            for ($i = 1; $i <= 10; $i++) {
                if (!empty($request->input("anggota_{$i}"))) {
                    KIAnggota::create([
                        'id_ki' => $dataKi->id,
                        'id_dosen' => $this->getIdDosenByNama($request->input("anggota_{$i}")),
                        'id_mahasiswa' => $this->getIdMahasiswaByNama($request->input("anggota_{$i}")),
                        'anggota' => $request->input("anggota_{$i}"),
                        'status_anggota' => $request->input("status_anggota_{$i}"),
                        'prodi' => $request->input("prodi_{$i}"),
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data KI berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function hapus_data_ki_table($id)
    {
        DB::beginTransaction();
        try {
            $dataKi = KI::findOrFail($id);
            $dataKi->delete();

            DB::commit();
            return redirect()->back()->with('error', 'Data KI berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function import_ki_table(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        DB::beginTransaction();
        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getSheetByName('KI') ?? $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Get hyperlinks from the worksheet
            $hyperlinks = $worksheet->getHyperlinkCollection();

            // Get headers from first row
            $headers = array_shift($rows);

            // Process each row
            foreach ($rows as $rowIndex => $row) {
                if (empty(array_filter($row))) continue; // Skip empty rows

                // Helper function to get hyperlink value if exists
                $getHyperlink = function($colIndex) use ($hyperlinks, $rowIndex) {
                    $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1) . ($rowIndex + 2); // +2 because: 1 for 0-based index, 1 for header row

                    if (isset($hyperlinks[$cellCoordinate])) {
                        return $hyperlinks[$cellCoordinate]->getUrl();
                    }
                    return null;
                };

                $rowData = array_combine($headers, $row);

                //validasi
                if (empty($rowData['TITLE'])) {
                    continue; // Skip rows with empty TITLE
                }
                if (KI::where('title', $rowData['TITLE'])->exists()) {
                    continue; // Skip duplicates based on title
                }

                // Create main KI data
                $dataKi = KI::create([
                    'application_number' => $rowData['Application Number'] ?? null,
                    'kategori' => $rowData['Kategori'] ?? null,
                    'application_year' => $rowData['APPLICATION YEAR'] ?? null,
                    'title' => $rowData['TITLE'] ?? null,
                    'jenis_hki' => $rowData['Jenis HKI'] ?? null,
                    'prototype' => $rowData['Protoipe'] ?? null,
                    'patent_holder' => $rowData['PATENT HOLDER'] ?? null,
                    'inventor' => $rowData['INVENTOR'] ?? null,
                    'jabatan' => $rowData['Jabatan'] ?? null,
                    'prodi' => $rowData['Prodi'] ?? null,
                    'publication_number' => $rowData['PUBLICATION NUMBER'] ?? null,
                    'publication_link' => $getHyperlink(11),
                    'publication_date' => $rowData['Publication Date'] ?? null,
                    'filling_date' => $rowData['Filling Date'] ?? null,
                    'reception_date' => $rowData['Reception Date'] ?? null,
                    'registration_date' => $rowData['Registration Date'] ?? null,
                    'registration_number' => $rowData['Registration Number'] ?? null,
                    'status' => $rowData['Status'] ?? null,
                    'link' => $getHyperlink(18) ?? $rowData['Link'] ?? null,
                ]);

                // Create anggota data
                for ($i = 1; $i <= 12; $i++) {
                    if (!empty($rowData['Anggota ' . $i] ?? null)) {
                        KIAnggota::create([
                            'id_ki' => $dataKi->id,
                            'anggota' => $rowData['Anggota ' . $i] ?? null,
                            'status_anggota' => $rowData['Status Anggota ' . $i] ?? null,
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diimport');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal import: template file tidak sesuai atau terjadi kesalahan sistem. ' . $e->getMessage());
        }
    }
}
