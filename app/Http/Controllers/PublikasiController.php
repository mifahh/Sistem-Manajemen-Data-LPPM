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

        $query->when(
            $request->filled('tahun_filter') && $request->tahun_filter !== '',
            fn ($q) => $q->where('tahun_published', $request->tahun_filter),
            fn ($q) => $q->where('tahun_published', Publikasi::max('tahun_published'))
        );

        $query->when(
            $request->filled('akreditasi_index_jurnal') && $request->akreditasi_index_jurnal != '',
            fn ($q) => $q->where('akreditasi_index_jurnal', $request->akreditasi_index_jurnal),
            fn ($q) => $q->where('akreditasi_index_jurnal', '-')
        );

        $selected_tahun = ($request->has('tahun_filter') && $request->tahun_filter != '') ? $request->tahun_filter : Publikasi::max('tahun_published');
        $selected_akreditasi = ($request->has('akreditasi_index_jurnal') && $request->akreditasi_index_jurnal != '') ? $request->akreditasi_index_jurnal : '-';

        $data_publikasi = $query->get();
        $tahun_filter = Publikasi::select('tahun_published')->distinct()->orderBy('tahun_published', 'desc')->pluck('tahun_published');
        $tahun = \App\Models\MasterTahun::all();
        $jurusan = \App\Models\MasterJurusan::all();
        $akreditasi_index_jurnal = Publikasi::select('akreditasi_index_jurnal')->distinct()->orderBy('akreditasi_index_jurnal')->pluck('akreditasi_index_jurnal');
        $jml_publikasi = $data_publikasi->count();

        // Transform data to flattened array format
        $transformedData = $data_publikasi->map(function($item) {
            return $item->getCompleteData();
        });

        // dd( $transformedData);
        return view('publikasi.data_publikasi_table', [
            'publikasi' => $transformedData,
            'tahun' => $tahun,
            'tahun_filter' => $tahun_filter,
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
            'judul_publikasi' => 'required|string|unique:data_publikasi,judul_publikasi',
            'nama_jurnal' => 'required|string',
            'tahun_published' => 'required|integer',
            'nama_penulis_koresponding' => 'required|string',
            'prodi' => 'required|string',
        ], $messages);

        DB::beginTransaction();
        try {
            $publikasi = Publikasi::create([
                'judul_publikasi' => $request->judul_publikasi,
                'nama_jurnal' => $request->nama_jurnal,
                'akreditasi_index_jurnal' => $request->akreditasi_index_jurnal,
                'lembaga_pengindeks' => $request->lembaga_pengindeks,
                'tahun_published' => $request->tahun_published,
                'nama_penulis_koresponding' => $request->nama_penulis_koresponding,
                'prodi' => $request->prodi,
                'status' => $request->status,
                'afiliasi' => $request->afiliasi,
                'doi' => $request->doi,
            ]);

            for($i = 1; $i <= 7; $i++) {
                if($i == 7) {
                    $i = 'lain';
                }
                if ($request->input('penulis_' . $i)) {
                    PublikasiPenulis::create([
                        'id_publikasi' => $publikasi->id,
                        'id_dosen' => $request->input('id_dosen_' . $i),
                        'nama_penulis' => $request->input('penulis_' . $i),
                        'prodi' => $request->input('prodi_' . $i),
                        'status' => $request->input('status_' . $i),
                        'afiliasi' => $request->input('afiliasi_' . $i),
                    ]);
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
            'prodi' => 'required|string',
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
                'prodi' => $request->prodi,
                'status' => $request->status,
                'afiliasi' => $request->afiliasi,
                'doi' => $request->doi,
            ]);

            $publikasi->penulis()->delete();

            for($i = 1; $i <= 7; $i++) {
                if($i == 7) {
                    $i = 'lain';
                }
                if ($request->input('penulis_' . $i)) {
                    PublikasiPenulis::create([
                        'id_publikasi' => $publikasi->id,
                        'id_dosen' => $this->getIdDosenByNama($request->input('penulis_' . $i)),
                        'nama_penulis' => $request->input('penulis_' . $i),
                        'prodi' => $request->input('prodi_' . $i),
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
            return redirect()->back()->with('error', 'Gagal mengupdate data publikasi'. $e->getMessage());
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

            // Process each row
            foreach ($rows as $rowIndex => $row) {
                if (empty($row[0])) continue; // Skip judul kosong

                // Helper function to get hyperlink value if exists
                $getHyperlink = function($colIndex) use ($hyperlinks, $rowIndex) {
                    $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1) . ($rowIndex + 2); // +2 because: 1 for 0-based index, 1 for header row

                    if (isset($hyperlinks[$cellCoordinate])) {
                        return $hyperlinks[$cellCoordinate]->getUrl();
                    }
                    return null;
                };

                $rowData = array_combine($headers, $row);

                if (empty($rowData['Judul Publikasi'] ?? null)) {
                    log::warning("Skip row " . ($rowIndex + 2) . ": Judul Publikasi is empty");
                    continue;
                }

                if (Publikasi::where('judul_publikasi', $rowData['Judul Publikasi'])->exists()) {
                    Log::warning("Skip row " . ($rowIndex + 2) . ": Judul Publikasi '" . $rowData['Judul Publikasi'] . "' already exists");
                    continue;
                }

                // Create main KI data
                $dataPublikasi = Publikasi::create([
                    'judul_publikasi' => $rowData['Judul Publikasi'] ?? null,
                    'nama_jurnal' => $rowData['Nama Jurnal'] ?? null,
                    'akreditasi_index_jurnal' => $rowData['Akreditasi/Index Jurnal'] ?? null,
                    'lembaga_pengindeks' => $rowData['Lembaga Pengindeks'] ?? null,
                    'tahun_published' => $rowData['Tahun Published'] ?? null,
                    'nama_penulis_koresponding' => $rowData['Nama Penulis Koresponding'] ?? null,
                    'prodi' => $rowData['Prodi'] ?? null,
                    'status' => $rowData['Status'] ?? null,
                    'afiliasi' => $rowData['Afiliasi'] ?? null,
                    'doi' => $getHyperlink(array_search('DOI', $headers)) ?? $rowData['DOI'] ?? null,
                ]);

                // Create anggota data
                for ($i = 1; $i <= 7; $i++) {
                    if (!empty($rowData['Anggota' . $i] ?? null)) {
                        if($i == 7) {
                            $i = ' lain';
                        }
                        PublikasiPenulis::create([
                            'id_publikasi' => $dataPublikasi->id,
                            'nama_penulis' => $rowData['Anggota' . $i] ?? null,
                            'prodi' => $rowData['Prodi' . $i] ?? null,
                            'status' => $rowData['Status Anggota' . $i] ?? null,
                            'afiliasi' => $rowData['Afiliasi Anggota' . $i] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data publikasi berhasil diimport');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal import publikasi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal import: template file tidak sesuai atau terjadi kesalahan sistem.');
        }
    }
}
