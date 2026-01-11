<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Publikasi;
use App\Models\PublikasiPenulis;


class PublikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //program publikasi
    public function program_publikasi()
    {
        return view('publikasi.program_publikasi');
    }

    // Data Publikasi Table CRUD
    public function data_publikasi_table(Request $request)
    {
        $query = Publikasi::with('penulis')->whereNull('deleted_at');
        $this->updateIdFromNama();

        $akreditasi_index_jurnal = Publikasi::select('akreditasi_index_jurnal')->distinct()->orderBy('akreditasi_index_jurnal')->pluck('akreditasi_index_jurnal');
        $selected_tahun = ($request->has('tahun_filter') && $request->tahun_filter != '') ? $request->tahun_filter : Publikasi::max('tahun_published');
        $selected_akreditasi = ($request->has('akreditasi_index_jurnal') && $request->akreditasi_index_jurnal != '') ? $request->akreditasi_index_jurnal : $akreditasi_index_jurnal->first();

        $query->where('tahun_published', $selected_tahun);
        $query->where('akreditasi_index_jurnal', $selected_akreditasi);

        $data_publikasi = $query->get();
        $tahun = \App\Models\MasterTahun::all()->sortByDesc('tahun');
        $jurusan = \App\Models\MasterJurusan::all();
        $jml_publikasi = $data_publikasi->count();

        // Transform data to flattened array format
        $transformedData = $data_publikasi->map(function ($item) {
            return $item->getCompleteData();
        });

        // dd($data_publikasi);
        // dd( $transformedData);
        return view('publikasi.data_publikasi_table', [
            'publikasi' => $transformedData,
            'tahun' => $tahun,
            'selected_tahun' => $selected_tahun,
            'selected_akreditasi' => $selected_akreditasi,
            'jurusan' => $jurusan,
            'akreditasi_index_jurnal' => $akreditasi_index_jurnal,
            'jml_publikasi' => $jml_publikasi
        ]);
    }

    private function updateIdFromNama()
    {
        try {
            $publikasiPenulis = PublikasiPenulis::whereNull('deleted_at')->get();

            foreach ($publikasiPenulis as $penulis) {
                if ($penulis->id_dosen === null) {
                    $dosen = \App\Models\DataDosen::where('nama_dosen', $penulis->nama_penulis)->first();
                    $mahasiswa = \App\Models\DataMahasiswa::where('nama_mahasiswa', $penulis->nama_penulis)->first();
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

    public function tambah_data_publikasi_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'unique' => ':attribute sudah ada',
        ];

        $request->validate([
            'judul_publikasi' => 'required|string',
            'nama_jurnal' => 'required|string',
            'tahun_published' => 'required|integer',
            'nama_penulis_koresponding' => 'required|string',
            'akreditasi_index_jurnal' => 'required|string',
        ], $messages);

        DB::beginTransaction();
        try {
            $existing = Publikasi::withTrashed()->where('judul_publikasi', $request->judul_publikasi)->first();
            if ($existing && !is_null($existing->deleted_at)) {
                $existing->restore();
            }

            $publikasi = Publikasi::updateOrCreate(
                [
                    'judul_publikasi' => $request->judul_publikasi,
                ],[
                    'nama_jurnal' => $request->nama_jurnal,
                    'akreditasi_index_jurnal' => $request->akreditasi_index_jurnal,
                    'lembaga_pengindeks' => $request->lembaga_pengindeks,
                    'tahun_published' => $request->tahun_published,
                    'nama_penulis_koresponding' => $request->nama_penulis_koresponding,
                    'status' => $request->status,
                    'afiliasi' => $request->afiliasi,
                    'doi' => $request->doi,
                ]
            );

            for ($i = 1; $i <= 15; $i++) {
                $all = PublikasiPenulis::where('id_publikasi', $publikasi->id)->get();
                $existing = $all[$i - 1] ?? null;

                if ($request->input('penulis_' . $i)) {
                    if ($existing && is_null($existing->deleted_at)) {
                        // Update existing
                        $existing->update([
                            'id_publikasi' => $publikasi->id,
                            'nama_penulis' => $request->input('penulis_' . $i),
                            'id_mahasiswa' => $this->getIdMahasiswaByNama($request->input('penulis_' . $i)),
                            'id_dosen' => $this->getIdDosenByNama($request->input('penulis_' . $i)),
                            'status' => $request->input('status_' . $i),
                            'afiliasi' => $request->input('afiliasi_' . $i),
                        ]);
                    } else {
                        PublikasiPenulis::create([
                            'id_publikasi' => $publikasi->id,
                            'nama_penulis' => $request->input('penulis_' . $i),
                            'id_mahasiswa' => $this->getIdMahasiswaByNama($request->input('penulis_' . $i)),
                            'id_dosen' => $this->getIdDosenByNama($request->input('penulis_' . $i)),
                            'status' => $request->input('status_' . $i),
                            'afiliasi' => $request->input('afiliasi_' . $i),
                        ]);
                    }
                } else if ($existing && is_null($existing->deleted_at)) {
                    // Jika input kosong tapi data existing ada, hapus data existing
                    $existing->delete();
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data publikasi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal tambah publikasi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan data publikasi');
        }
    }

    public function edit_data_publikasi_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
        ];
        $request->validate([
            'id' => 'required|integer',
            'judul_publikasi' => 'required|string',
            'nama_jurnal' => 'required|string',
            'tahun_published' => 'required|integer',
            'nama_penulis_koresponding' => 'required|string',
        ], $messages);

        DB::beginTransaction();
        try {
            $publikasi = Publikasi::findOrFail($request->id);

            $publikasi->update([
                'judul_publikasi' => $request->judul_publikasi,
                'nama_jurnal' => $request->nama_jurnal,
                'akreditasi_index_jurnal' => $request->akreditasi_index_jurnal,
                'lembaga_pengindeks' => $request->lembaga_pengindeks,
                'tahun_published' => $request->tahun_published,
                'nama_penulis_koresponding' => $request->nama_penulis_koresponding,
                'status' => $request->status,
                'afiliasi' => $request->afiliasi,
                'doi' => $request->doi,
            ]);

            $publikasi->penulis()->delete();

            for ($i = 1; $i <= 15; $i++) {
                if ($request->input('penulis_' . $i)) {
                    PublikasiPenulis::create([
                        'id_publikasi' => $publikasi->id,
                        'id_mahasiswa' => $this->getIdMahasiswaByNama($request->input('penulis_' . $i)),
                        'id_dosen' => $this->getIdDosenByNama($request->input('penulis_' . $i)),
                        'nama_penulis' => $request->input('penulis_' . $i),
                        'status' => $request->input('status_' . $i),
                        'afiliasi' => $request->input('afiliasi_' . $i),
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data publikasi berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal edit publikasi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupdate data publikasi' . $e->getMessage());
        }
    }

    public function hapus_data_publikasi_table($id)
    {
        try {
            $publikasi = Publikasi::findOrFail($id);
            $publikasi->delete();
            return redirect()->back()->with('success', 'Data publikasi berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Gagal hapus publikasi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data publikasi');
        }
    }

    public function import_publikasi_table(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        DB::beginTransaction();
        try {

            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getSheetByName('PUBLIKASI') ?? $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Get hyperlinks from the worksheet
            $hyperlinks = $worksheet->getHyperlinkCollection();

            // Get headers from first row
            $headers = array_shift($rows);

            // Expected headers yang wajib ada
            $expectedHeaders = [
                'Judul Publikasi',
                'Nama Jurnal',
                'Akreditasi/Index Jurnal',
                'Lembaga Pengindeks',
                'Tahun Published',
                'Nama Penulis Koresponding',
                'Status',
                'Afiliasi',
                'DOI'
            ];

            // for ($i = 1; $i <= 7; $i++) {
            //     $expectedHeaders[] = 'Nama Penulis' . $i;
            //     $expectedHeaders[] = 'Status' . $i;
            //     $expectedHeaders[] = 'Afiliasi' . $i;
            // }

            // Validasi header
            foreach ($expectedHeaders as $header) {
                if (!in_array($header, $headers)) {
                    DB::rollBack();
                    return redirect()->back()->with(
                        'error',
                        "Template tidak sesuai. Header '$header' tidak ditemukan."
                    );
                }
            }

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

                $existing = Publikasi::withTrashed()->where('judul_publikasi', $rowData['Judul Publikasi'] ?? null)->first();
                if ($existing && !is_null($existing->deleted_at)) {
                    $existing->restore();
                }

                // Create main KI data
                $dataPublikasi = Publikasi::updateOrCreate([
                    'judul_publikasi' => $rowData['Judul Publikasi'] ?? null,
                ], [
                    'nama_jurnal' => $rowData['Nama Jurnal'] ?? null,
                    'akreditasi_index_jurnal' => $rowData['Akreditasi/Index Jurnal'] ?? null,
                    'lembaga_pengindeks' => $rowData['Lembaga Pengindeks'] ?? null,
                    'tahun_published' => $rowData['Tahun Published'] ?? null,
                    'id_dosen' => getIdDosenByNama($rowData['Nama Penulis Koresponding'] ?? null),
                    'nama_penulis_koresponding' => $rowData['Nama Penulis Koresponding'] ?? null,
                    'status' => $rowData['Status'] ?? null,
                    'afiliasi' => $rowData['Afiliasi'] ?? null,
                    'doi' => $getHyperlink(array_search('DOI', $headers)) ?? $rowData['DOI'] ?? null,
                ]);

                // Create anggota data
                for ($i = 1; $i <= 15; $i++) {
                    // Split by semicolon
                    $arrayNamaPenulis = explode(';', $rowData['Nama Penulis' . $i] ?? '');
                    foreach ($arrayNamaPenulis as $namaPenulis) {
                        $nama = trim($namaPenulis);
                        // Skip jika kosong atau hanya berisi dash/placeholder
                        $all = PublikasiPenulis::withTrashed()->where('id_publikasi', $dataPublikasi->id)->get();
                        $existing = $all[$i - 1] ?? null;

                        if (!empty($nama) && $nama !== '-') {
                            if ($existing && is_null($existing->deleted_at)) {
                                // Update existing
                                $existing->update([
                                    'id_publikasi' => $dataPublikasi->id,
                                    'nama_penulis' => $nama,
                                    'id_mahasiswa' => getIdMahasiswaByNama($nama),
                                    'id_dosen' => getIdDosenByNama($nama),
                                    'status' => $rowData['Status' . $i] ?? null,
                                    'afiliasi' => $rowData['Afiliasi' . $i] ?? null,
                                ]);
                            } else {
                                PublikasiPenulis::create([
                                        'id_publikasi' => $dataPublikasi->id,
                                        'nama_penulis' => $nama,
                                        'id_mahasiswa' => getIdMahasiswaByNama($nama),
                                        'id_dosen' => getIdDosenByNama($nama),
                                        'status' => $rowData['Status' . $i] ?? null,
                                        'afiliasi' => $rowData['Afiliasi' . $i] ?? null,
                                ]);
                            }
                        } else if ($existing && is_null($existing->deleted_at)) {
                            // Jika input kosong tapi data existing ada, hapus data existing
                            $existing->delete();
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data publikasi berhasil diimport');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal import publikasi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal import:' . $e->getMessage());
        }
    }
}
