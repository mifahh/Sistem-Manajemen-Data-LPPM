<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KI;
use App\Models\KIAnggota;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;

class KiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function data_ki_table(Request $request)
    {
        $query = KI::with('anggota')->whereNull('deleted_at');
        $this->updateIdFromNama();

        $kategori_filter = KI::select('kategori')->distinct()->orderBy('kategori', 'asc')->pluck('kategori');
        $status_filter = KI::select('status')->distinct()->orderBy('status', 'asc')->pluck('status');

        $selected_tahun = ($request->has('tahun_filter') && $request->tahun_filter != '') ? $request->tahun_filter : KI::max('application_year');
        $selected_kategori = ($request->has('kategori_filter') && $request->kategori_filter != '') ? $request->kategori_filter : $kategori_filter->first();
        $selected_status = ($request->has('status_filter') && $request->status_filter != '') ? $request->status_filter : $status_filter->first();
        // $selected_prodi = ($request->has('prodi_filter') && $request->prodi_filter != '') ? $request->prodi_filter : '';

        // $query->when(
        //     $request->filled('prodi_filter') && $request->prodi_filter !== '',
        //     function ($q) use ($request) {
        //         $q->whereHas('anggota', function ($q2) use ($request) {
        //             $q2->where(function ($q3) use ($request) {
        //                 $q3->whereHas('dosen', function ($q4) use ($request) {
        //                     $q4->where('prodi', $request->prodi_filter);
        //                 })->orWhereHas('mahasiswa', function ($q5) use ($request) {
        //                     $q5->where('prodi', $request->prodi_filter);
        //                 });
        //             });
        //         });
        //     }
        // );

        $query->where('application_year', $selected_tahun);
        $query->where('kategori', $selected_kategori);
        $query->where('status', $selected_status);

        $data_ki = $query->get();
        $tahun = \App\Models\MasterTahun::all()->sortByDesc('tahun');
        $jurusan = \App\Models\MasterJurusan::all();
        $kategori = \App\Models\MasterKategoriKI::all();
        $status = \App\Models\MasterStatusKI::all();

        // Transform data to flattened format for view
        $transformedData = $data_ki->map(function ($item) {
            return $item->getCompleteData();
        });

        return view('ki.data_ki_table', [
            'ki' => $transformedData,
            'selected_tahun' => $selected_tahun,
            'kategori_filter' => $kategori_filter,
            'selected_kategori' => $selected_kategori,
            'status_filter' => $status_filter,
            'selected_status' => $selected_status,
            'kategori' => $kategori,
            'status' => $status,
            'tahun' => $tahun,
            'jurusan' => $jurusan,
            'jml_ki' => $data_ki->count()
        ]);
    }

    private function updateIdFromNama()
    {
        try {
            $publikasiPenulis = KIAnggota::whereNull('deleted_at')->get();

            foreach ($publikasiPenulis as $penulis) {
                if ($penulis->id_dosen === null) {
                    $dosen = \App\Models\DataDosen::where('nama_dosen', $penulis->anggota)->first();
                    $mahasiswa = \App\Models\DataMahasiswa::where('nama_mahasiswa', $penulis->anggota)->first();
                    if ($dosen) {
                        $penulis->id_dosen = $dosen->id;
                        $penulis->save();
                    }
                    if ($mahasiswa) {
                        $penulis->id_mahasiswa = $mahasiswa->id;
                        $penulis->save();
                    }
                }
            }

            Log::info('Successfully updated id_dosen for publikasi_penulis');
        } catch (\Exception $e) {
            Log::error('Error updating id_dosen: ' . $e->getMessage());
        }
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
            'title' => 'required|string',
            'jenis_hki' => 'required|string',
            'status' => 'required|string',
        ], $messages);

        DB::beginTransaction();
        try {
            $existing = KI::withTrashed()->where('title', $request->title)->first();
            if ($existing && !is_null($existing->deleted_at)) {
                $existing->restore();
            }

            $dataKi = KI::updateOrCreate([
                'title' => $request->title,
            ], [
                'application_number' => $request->application_number,
                'kategori' => $request->kategori,
                'application_year' => $request->application_year,
                'jenis_hki' => $request->jenis_hki,
                'prototype' => $request->prototype,
                'patent_holder' => $request->patent_holder,
                'id_dosen' => $this->getIdDosenByNama($request->inventor),
                'id_mahasiswa' => $this->getIdMahasiswaByNama($request->inventor),
                'inventor' => $request->inventor,
                'jabatan' => $request->jabatan,
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
                $all = KIAnggota::where('id_ki', $dataKi->id)->get();
                $existing = $all[$i - 1] ?? null;

                if (!empty($request->input("anggota_{$i}"))) {
                    if ($existing && is_null($existing->deleted_at)) {
                        // Update existing
                        $existing->update([
                            'id_ki' => $dataKi->id,
                            'anggota' => $request->input("anggota_{$i}"),
                            'id_dosen' => $this->getIdDosenByNama($request->input("anggota_{$i}")),
                            'id_mahasiswa' => $this->getIdMahasiswaByNama($request->input("anggota_{$i}")),
                            'status_anggota' => $request->input("status_anggota_{$i}"),
                        ]);
                    } else {
                        KIAnggota::create([
                            'id_ki' => $dataKi->id,
                            'anggota' => $request->input("anggota_{$i}"),
                            'id_dosen' => $this->getIdDosenByNama($request->input("anggota_{$i}")),
                            'id_mahasiswa' => $this->getIdMahasiswaByNama($request->input("anggota_{$i}")),
                            'status_anggota' => $request->input("status_anggota_{$i}"),
                        ]);
                    }
                } else if ($existing && is_null($existing->deleted_at)) {
                    // Jika input kosong tapi data existing ada, hapus data existing
                    $existing->delete();
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
                'id_dosen' => $this->getIdDosenByNama($request->inventor),
                'id_mahasiswa' => $this->getIdMahasiswaByNama($request->inventor),
                'inventor' => $request->inventor,
                'jabatan' => $request->jabatan,
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

            $expectedHeaders = ['Application Number', 'Kategori', 'APPLICATION YEAR', 'TITLE', 'Jenis HKI', 'Prototipe', 'PATENT HOLDER', 'INVENTOR', 'Jabatan', 'PUBLICATION NUMBER', 'Publication Date', 'Filling Date', 'Reception Date', 'Registration Date', 'Registration Number', 'Status', 'Link'];

            // for ($i = 1; $i <= 12; $i++) {
            //     $expectedHeaders[] = 'Anggota ' . $i;
            //     $expectedHeaders[] = 'Status Anggota ' . $i;
            // }

            foreach ($expectedHeaders as $header) {
                if (!in_array($header, $headers)) {
                    throw new \Exception("Template tidak sesuai. Header '$header' tidak ditemukan.");
                }
            }

            // Process each row
            foreach ($rows as $rowIndex => $row) {
                if (empty(array_filter($row))) continue; // Skip empty rows

                // Helper function to get hyperlink value if exists
                $getHyperlink = function ($colIndex) use ($hyperlinks, $rowIndex) {
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

                $existing = KI::withTrashed()->where('title', $rowData['TITLE'])->first();
                if ($existing && !is_null($existing->deleted_at)) {
                    $existing->restore();
                }

                // Create main KI data
                $dataKi = KI::updateOrCreate([
                    'title' => $rowData['TITLE'] ?? null,
                ], [
                    'application_number' => $rowData['Application Number'] ?? null,
                    'kategori' => $rowData['Kategori'] ?? null,
                    'application_year' => $rowData['APPLICATION YEAR'] ?? null,
                    'jenis_hki' => $rowData['Jenis HKI'] ?? null,
                    'prototype' => $rowData['Prototipe'] ?? null,
                    'patent_holder' => $rowData['PATENT HOLDER'] ?? null,
                    'id_mahasiswa' => $this->getIdMahasiswaByNama($rowData['INVENTOR'] ?? null),
                    'id_dosen' => $this->getIdDosenByNama($rowData['INVENTOR'] ?? null),
                    'inventor' => $rowData['INVENTOR'] ?? null,
                    'jabatan' => $rowData['Jabatan'] ?? null,
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
                    $all = KIAnggota::withTrashed()->where('id_ki', $dataKi->id)->get();
                    $existing = $all[$i - 1] ?? null;

                    if (!empty($rowData['Anggota ' . $i] ?? null)) {
                        if ($existing && is_null($existing->deleted_at)) {
                            // Update existing
                            $existing->update([
                                'id_ki' => $dataKi->id,
                                'anggota' => $rowData['Anggota ' . $i] ?? null,
                                'id_mahasiswa' => $this->getIdMahasiswaByNama($rowData['Anggota ' . $i] ?? null),
                                'id_dosen' => $this->getIdDosenByNama($rowData['Anggota ' . $i] ?? null),
                                'status_anggota' => $rowData['Status Anggota ' . $i] ?? null,
                            ]);
                        } else {
                            KIAnggota::create([
                                'id_ki' => $dataKi->id,
                                'anggota' => $rowData['Anggota ' . $i] ?? null,
                                'id_mahasiswa' => $this->getIdMahasiswaByNama($rowData['Anggota ' . $i] ?? null),
                                'id_dosen' => $this->getIdDosenByNama($rowData['Anggota ' . $i] ?? null),
                                'status_anggota' => $rowData['Status Anggota ' . $i] ?? null,
                            ]);
                        }
                    } else if ($existing && is_null($existing->deleted_at)) {
                        // Jika input kosong tapi data existing ada, hapus data existing
                        $existing->delete();
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diimport');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
