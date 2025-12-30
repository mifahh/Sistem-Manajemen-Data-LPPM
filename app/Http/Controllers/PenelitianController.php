<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Log;
use App\Models\Penelitian;
use App\Models\PenelitianMember;
use App\Models\PenelitianAdditionalField;
use App\Models\PenelitianMahasiswa;
use App\Models\PenelitianLuaran;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PenelitianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //program penelitian

    public function plt_profil_penelitian()
    {
        return view('penelitian.profil_penelitian.profil_penelitian', [
        ]);
    }

    // CRUD untuk tabel penelitian baru
    public function data_penelitian_table(Request $request)
    {
        // Update id_dosen for all penelitian based on nama_ketua
        $this->updateIdDosenFromNama();

        $query = Penelitian::with(['members', 'additionalFields', 'mahasiswa', 'luaran'])
            ->whereNull('deleted_at');

        // Add filter only if tahun parameter provided
        if ($request->has('tahun_filter') && $request->tahun_filter != '') {
            $query->where('tahun_pelaksanaan', $request->tahun_filter);
        }

        $penelitian = $query->get();
        $tahun_filter = Penelitian::select('tahun_pelaksanaan')->distinct()->orderBy('tahun_pelaksanaan', 'desc')->pluck('tahun_pelaksanaan');
        $tahun = \App\Models\MasterTahun::all();
        $jurusan = \App\Models\MasterJurusan::all();
        $jml_penelitian = $penelitian->count();

        // Transform data to flattened format for view
        $transformedData = $penelitian->map(function($item) {
            return $item->getCompleteData();
        });

        return view('penelitian.data_penelitian_table', [
            'penelitian' => $transformedData,
            'jurusan' => $jurusan,
            'tahun_filter' => $tahun_filter,
            'tahun' => $tahun,
            'jml_penelitian' => $jml_penelitian
        ]);
    }

    /**
     * Update id_dosen di table penelitian berdasarkan nama_ketua
     * dan update id_dosen di table penelitian_member berdasarkan nama_member
     */
    private function updateIdDosenFromNama()
    {
        try {
            // Update penelitian ketua
            $penelitians = DB::table('penelitian_main')->whereNull('deleted_at')->get();

            foreach ($penelitians as $p) {
                if (!empty($p->nama_ketua)) {
                    $dosen = getIdDosenByNama($p->nama_ketua);
                    if ($dosen) {
                        DB::table('penelitian_main')
                            ->where('id', $p->id)
                            ->update(['id_dosen' => $dosen->id_dosen]);
                    }
                }
            }

            // Update penelitian members
            $members = DB::table('penelitian_member')->get();

            foreach ($members as $m) {
                if (!empty($m->nama_member)) {
                    $dosen = getIdDosenByNama($m->nama_member);
                    if ($dosen) {
                        DB::table('penelitian_member')
                            ->where('id', $m->id)
                            ->update(['id_dosen' => $dosen->id_dosen]);
                    }
                }
            }

            Log::info('Successfully updated id_dosen for penelitian');
        } catch (\Exception $e) {
            Log::error('Error updating id_dosen: ' . $e->getMessage());
        }
    }

    public function tambah_data_penelitian_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'unique' => ':attribute sudah ada',
        ];

        $request->validate([
            'judul_penelitian' => 'required|string|unique:penelitian_main,judul_penelitian',
            'nama_skema' => 'required|string',
            'tahun_usulan' => 'required|integer',
            'dana_disetujui' => 'required|integer',
            'kategori_sumber_dana' => 'required|string',
            'nama_ketua' => 'required|string',
            'dana_ketua' => 'required|integer',
            'pt' => 'required|string',
        ], $messages);

        DB::beginTransaction();
        try {
            // Create main penelitian record
            $penelitian = Penelitian::create([
                'link_sk' => $request->link_sk,
                'no_sk' => $request->no_sk,
                'link_kontrak' => $request->link_kontrak,
                'no_kontrak' => $request->no_kontrak,
                'judul_penelitian' => $request->judul_penelitian,
                'nama_skema' => $request->nama_skema,
                'tahun_usulan' => $request->tahun_usulan,
                'tahun_pelaksanaan' => $request->tahun_pelaksanaan,
                'lama_kegiatan' => $request->lama_kegiatan,
                'bidang_fokus' => $request->bidang_fokus,
                'dana_disetujui' => $request->dana_disetujui ?? 0,
                'target_tkt' => $request->target_tkt,
                'nama_program_hibah' => $request->nama_program_hibah,
                'kategori_sumber_dana' => $request->kategori_sumber_dana,
                'negara_sumber_dana' => $request->negara_sumber_dana,
                'sumber_dana' => $request->sumber_dana,
                'id_dosen' => $this->getIdDosenByNama($request->input('nama_ketua_dosen')),
                'nama_ketua' => $request->nama_ketua,
                'dana_ketua' => $request->dana_ketua ?? 0,
                'pt' => $request->pt,
            ]);

            // Create members
            for ($i = 1; $i <= 8; $i++) {
                if (!empty($request->input('nama_member' . $i))) {
                    PenelitianMember::create([
                        'id_penelitian' => $penelitian->id,
                        'id_dosen' => $this->getIdDosenByNama($request->input('nama_member' . $i)),
                        'nama_member' => $request->input('nama_member' . $i),
                        'dana_member' => $request->input('dana_member' . $i) ?? 0,
                        'pt' => $request->input('pt' . $i),
                    ]);
                }
            }

            // Create additional fields
            PenelitianAdditionalField::create([
                'id_penelitian' => $penelitian->id,
                'sdg' => $request->sdg,
                'proposal' => $request->proposal,
                'laporan_akhir' => $request->laporan_akhir,
            ]);

            // Create mahasiswa records
            for ($i = 1; $i <= 8; $i++) {
                if (!empty($request->input('nama_mhs' . $i))) {
                    PenelitianMahasiswa::create([
                        'id_penelitian' => $penelitian->id,
                        'nama_mhs' => $request->input('nama_mhs' . $i),
                        'prodi_mhs' => $request->input('prodi_mhs' . $i),
                    ]);
                }
            }

            // Create luaran record
            PenelitianLuaran::create([
                'id_penelitian' => $penelitian->id,
                'luaran_wajib' => $request->luaran_wajib,
                'capaian_luaran_wajib' => $request->capaian_luaran_wajib,
                'luaran_tambahan' => $request->luaran_tambahan,
                'capaian_luaran_tambahan' => $request->capaian_luaran_tambahan,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Data Penelitian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal tambah Penelitian: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan data Penelitian');
        }
    }

    public function edit_data_penelitian_table(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'unique' => ':attribute sudah ada',
        ];
        $request->validate([
            'id' => 'required|exists:penelitian_main,id',
            'judul_penelitian' => 'required|string|unique:penelitian_main,judul_penelitian',
            'nama_skema' => 'required|string',
            'tahun_usulan' => 'required|integer',
            'dana_disetujui' => 'required|integer',
            'kategori_sumber_dana' => 'required|string',
            'nama_ketua' => 'required|string',
            'dana_ketua' => 'required|integer',
            'pt' => 'required|string',
        ], $messages);
        DB::beginTransaction();
        try {
            $penelitian = Penelitian::findOrFail($request->id);

            // Update main record
            $penelitian->update([
                'link_sk' => $request->link_sk,
                'no_sk' => $request->no_sk,
                'link_kontrak' => $request->link_kontrak,
                'no_kontrak' => $request->no_kontrak,
                'judul_penelitian' => $request->judul_penelitian,
                'nama_skema' => $request->nama_skema,
                'tahun_usulan' => $request->tahun_usulan,
                'tahun_pelaksanaan' => $request->tahun_pelaksanaan,
                'lama_kegiatan' => $request->lama_kegiatan,
                'bidang_fokus' => $request->bidang_fokus,
                'dana_disetujui' => $request->dana_disetujui ?? 0,
                'target_tkt' => $request->target_tkt ?? 0,
                'nama_program_hibah' => $request->nama_program_hibah,
                'kategori_sumber_dana' => $request->kategori_sumber_dana,
                'negara_sumber_dana' => $request->negara_sumber_dana,
                'sumber_dana' => $request->sumber_dana,
                'id_dosen' => $this->getIdDosenByNama($request->input('nama_ketua_dosen')),
                'nama_ketua' => $request->nama_ketua,
                'dana_ketua' => $request->dana_ketua ?? 0,
                'pt' => $request->pt,
            ]);

            // Delete existing related records
            $penelitian->members()->delete();
            $penelitian->additionalFields()->delete();
            $penelitian->mahasiswa()->delete();
            $penelitian->luaran()->delete();

            // Recreate members
            for ($i = 1; $i <= 8; $i++) {
                if (!empty($request->input('nama_member' . $i))) {
                    PenelitianMember::create([
                        'id_penelitian' => $penelitian->id,
                        'id_dosen' => $this->getIdDosenByNama($request->input('nama_member' . $i)),
                        'nama_member' => $request->input('nama_member' . $i),
                        'dana_member' => $request->input('dana_member' . $i) ?? 0,
                        'pt' => $request->input('pt' . $i),
                    ]);
                }
            }

            // Recreate additional fields
            PenelitianAdditionalField::create([
                'id_penelitian' => $penelitian->id,
                'sdg' => $request->sdg,
                'proposal' => $request->proposal,
                'laporan_akhir' => $request->laporan_akhir,
            ]);

            // Recreate mahasiswa records
            for ($i = 1; $i <= 8; $i++) {
                if (!empty($request->input('nama_mhs' . $i))) {
                    PenelitianMahasiswa::create([
                        'id_penelitian' => $penelitian->id,
                        'nama_mhs' => $request->input('nama_mhs' . $i),
                        'prodi_mhs' => $request->input('prodi_mhs' . $i),
                    ]);
                }
            }

            // Recreate luaran record
            PenelitianLuaran::create([
                'id_penelitian' => $penelitian->id,
                'luaran_wajib' => $request->luaran_wajib,
                'capaian_luaran_wajib' => $request->capaian_luaran_wajib,
                'luaran_tambahan' => $request->luaran_tambahan,
                'capaian_luaran_tambahan' => $request->capaian_luaran_tambahan,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data Penelitian berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal edit Penelitian: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupdate data Penelitian');
        }
    }

    public function hapus_data_penelitian_table($id)
    {
        DB::beginTransaction();
        try {
            $penelitian = Penelitian::findOrFail($id);
            $penelitian->delete();

            DB::commit();
            return redirect()->back()->with('error', 'Data Penelitian berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error hapus data penelitian: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function import_data_penelitian_table(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        DB::beginTransaction();
        try {
            $file = $request->file('file');
            // Buat reader khusus XLSX
            $reader = IOFactory::createReader('Xlsx');

            // Aktifkan mode read-only (hanya ambil value, abaikan style/format)
            $reader->setReadDataOnly(true);

            // Load file Excel
            $spreadsheet = $reader->load($file);
            $worksheet = $spreadsheet->getSheetByName('PNLT MASTER DATA') ?? $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Get hyperlinks from the worksheet
            $hyperlinks = $worksheet->getHyperlinkCollection();

            // Get headers from first row
            $headers = array_shift($rows);

            // Create a helper function to find column index with flexible matching
            $findColumn = function($searchTerms) use ($headers) {
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
                $getHyperlink = function($colIndex) use ($hyperlinks, $rowIndex) {
                    if ($colIndex === false) return null;
                    $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1) . ($rowIndex + 2);
                    if (isset($hyperlinks[$cellCoordinate])) {
                        return $hyperlinks[$cellCoordinate]->getUrl();
                    }
                    return null;
                };

                // Helper to safely get value from rowData by column index
                $getValue = function($headers, $row, $colIndex, $default = null) {
                    if ($colIndex === false || $colIndex >= count($row)) return $default;
                    return $row[$colIndex] ?? $default;
                };

                // Validate required fields before creating record
                $judulIndex = $findColumn(['Judul Penelitian/Pengabdian', 'Judul Penelitian', 'judul_penelitian']);
                $judul_penelitian = $getValue($headers, $row, $judulIndex);

                if (empty($judul_penelitian)) {
                    Log::warning("Skip row " . ($rowIndex + 2) . ": Judul Penelitian is empty");
                    continue;
                }

                if (Penelitian::where('judul_penelitian', $judul_penelitian)->exists()) {
                    Log::warning("Skip row " . ($rowIndex + 2) . ": Judul Penelitian '$judul_penelitian' already exists");
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
                $danaSetujuIndex = $findColumn(['Dana Disetujui', 'dana_disetujui']);
                $targetTktIndex = $findColumn(['Target TKT', 'target_tkt']);
                $namaProgramIndex = $findColumn(['Nama Program Hibah', 'Program Hibah', 'nama_program_hibah']);
                $kategoriDanaIndex = $findColumn(['Kategori Sumber Dana', 'Kategori Dana', 'kategori_sumber_dana']);
                $negaraDanaIndex = $findColumn(['Negara Sumber Dana', 'Negara Dana', 'negara_sumber_dana']);
                $sumberDanaIndex = $findColumn(['Sumber Dana', 'sumber_dana']);
                $namaKetuaIndex = $findColumn(['Nama Ketua', 'Ketua', 'nama_ketua']);
                $danaKetuaIndex = $findColumn(['Dana Ketua', 'DANA KETUA', 'dana_ketua']);
                $ptIndex = $findColumn(['PT', 'Institusi', 'pt']);

                // Create main penelitian record
                $penelitian = Penelitian::create([
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
                    'dana_disetujui' => parseDana($getValue($headers, $row, $danaSetujuIndex)) ?? 0,
                    'target_tkt' => parseInteger($getValue($headers, $row, $targetTktIndex)) ?? 0,
                    'nama_program_hibah' => $getValue($headers, $row, $namaProgramIndex),
                    'kategori_sumber_dana' => $getValue($headers, $row, $kategoriDanaIndex),
                    'negara_sumber_dana' => $getValue($headers, $row, $negaraDanaIndex),
                    'sumber_dana' => $getValue($headers, $row, $sumberDanaIndex),
                    'id_dosen' => $this->getIdDosenByNama($getValue($headers, $row, $namaKetuaIndex)),
                    'nama_ketua' => $getValue($headers, $row, $namaKetuaIndex),
                    'dana_ketua' => parseDana($getValue($headers, $row, $danaKetuaIndex)) ?? 0,
                    'pt' => $getValue($headers, $row, $ptIndex),
                ]);

                // Create members
                for ($i = 1; $i <= 8; $i++) {
                    $namaMemIndex = $findColumn(['Nama Member' . $i, 'Member' . $i, 'nama_member' . $i]);
                    $namaMem = $getValue($headers, $row, $namaMemIndex);
                    if (!empty($namaMem)) {
                        PenelitianMember::create([
                            'id_penelitian' => $penelitian->id,
                            'id_dosen' => $this->getIdDosenByNama($namaMem),
                            'nama_member' => $namaMem,
                            'dana_member' => parseDana($getValue($headers, $row, $findColumn(['Dana Member' . $i, 'DANA MEMBER' . $i, 'dana_member' . $i]))) ?? 0,
                            'pt' => $getValue($headers, $row, $findColumn(['PT Member' . $i, 'PT' . $i, 'pt' . $i])),
                        ]);
                    }
                }

                // Create additional fields
                PenelitianAdditionalField::create([
                    'id_penelitian' => $penelitian->id,
                    'sdg' => collect([
                        $getValue($headers, $row, $findColumn(['SDG Pertama', 'sdg pertama'])),
                        $getValue($headers, $row, $findColumn(['SDG Kedua', 'sdg kedua'])),
                        $getValue($headers, $row, $findColumn(['SDG Ketiga', 'sdg ketiga'])),
                        $getValue($headers, $row, $findColumn(['SDG Keempat', 'sdg keempat'])),
                        $getValue($headers, $row, $findColumn(['SDG Kelima', 'sdg kelima'])),
                        $getValue($headers, $row, $findColumn(['SDG Keenam', 'sdg keenam'])),
                        $getValue($headers, $row, $findColumn(['SDG Ketujuh', 'sdg ketujuh'])),
                    ])->filter()->join(', '),
                    'proposal' => $getHyperlink($findColumn(['Proposal', 'proposal'])) ?? $getValue($headers, $row, $findColumn(['Proposal', 'proposal'])),
                    'laporan_akhir' => $getHyperlink($findColumn(['Laporan Akhir', 'Laporan_Akhir', 'laporan_akhir'])) ?? $getValue($headers, $row, $findColumn(['Laporan Akhir', 'laporan_akhir'])),
                ]);

                // Create mahasiswa records
                for ($i = 1; $i <= 8; $i++) {
                    $namaMhsIndex = $findColumn(['Nama Mhs' . $i, 'Nama Mahasiswa' . $i, 'Mahasiswa' . $i, 'nama_mhs' . $i]);
                    $namaMhs = $getValue($headers, $row, $namaMhsIndex);
                    if (!empty($namaMhs)) {
                        PenelitianMahasiswa::create([
                            'id_penelitian' => $penelitian->id,
                            'nama_mhs' => $namaMhs,
                            'prodi_mhs' => $getValue($headers, $row, $findColumn(['Prodi Mhs' . $i, 'Prodi Mahasiswa' . $i, 'Prodi' . $i, 'prodi_mhs' . $i])),
                        ]);
                    }
                }

                // Create luaran record
                PenelitianLuaran::create([
                    'id_penelitian' => $penelitian->id,
                    'luaran_wajib' => $getValue($headers, $row, $findColumn(['Luaran Wajib', 'luaran_wajib'])),
                    'capaian_luaran_wajib' => $getValue($headers, $row, $findColumn(['Capaian Luaran Wajib', 'capaian_luaran_wajib'])),
                    'luaran_tambahan' => $getValue($headers, $row, $findColumn(['Luaran Tambahan', 'luaran_tambahan'])),
                    'capaian_luaran_tambahan' => $getValue($headers, $row, $findColumn(['Capaian Luaran Tambahan', 'capaian_luaran_tambahan'])),
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Data Penelitian berhasil diimport');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal import Penelitian Table: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}

