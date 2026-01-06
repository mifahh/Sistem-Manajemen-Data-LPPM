@extends('template.layout')

@section('page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-end">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Abdimas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div>
                    <!-- menampilkan error validasi -->
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-block d-flex">
                            <ul class="col mb-0 ml-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                    @endif
                    <!-- menampilkan pesan sukses/error -->
                    @if (!empty(Session::get('success')))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ Session::get('success') }}</strong>
                        </div>
                    @endif
                    @if (!empty(Session::get('error')))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ Session::get('error') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Data Abdimas :
                                {{ $jml_abdimas }}
                                Data
                            </h5>
                        </div>
                        <div class="card-body">
                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                <ol class="col-12 mt-2 mb-2">
                                    <x-table.button-table title="Abdimas" data-target-import="#importDataAbdimas"
                                        data-target-baru="#modal-lg"
                                        href-template="{{ asset('file_abdimas/Abdimas.xlsx') }}"></x-table.button-table>
                                </ol>
                            @endif
                            <ol class="col-12 mt-2 mb-2">
                                <form action="{{ route('data_abdimas_table') }}" method="GET">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="tahun">Tahun Pelaksanaan</label>
                                            <select name="tahun_filter" id="tahun_filter" class="form-select" required onchange="this.form.submit()">
                                                @foreach ($tahun_filter as $item)
                                                    <option value="{{ $item }}" {{ (request('tahun_filter') == $item) ? 'selected' : '' }}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </ol>
                            <div class="tab-content p-0">
                                <br />
                                <x-table.datatable-wrapper tableId="data_abdimas">
                                    <x-slot name="thead">
                                        <tr align="center">
                                            <th class="th-sm">No. SK</th>
                                            <th class="th-sm">No. Kontrak</th>
                                            <th class="th-sm">Judul Penelitian</th>
                                            <th class="th-sm">Nama Skema</th>
                                            <th class="th-sm">Tahun Pelaksanaan Kegiatan</th>
                                            <th class="th-sm">Lama Kegiatan (bulan)</th>
                                            <th class="th-sm">Bidang Fokus</th>
                                            <th class="th-sm">Dana Disetujui</th>
                                            <th class="th-sm">Target TKT</th>
                                            <th class="th-sm">Nama Program Hibah</th>
                                            <th class="th-sm">Sumber Dana</th>
                                            <th class="th-sm">Nama Ketua</th>
                                            <th class="th-sm">Nama Member</th>
                                            <th class="th-sm">SDG</th>
                                            <th class="th-sm w-25">File Proposal</th>
                                            <th class="th-sm w-25">File Laporan Akhir</th>
                                            <th class="th-sm">Nama Mahasiswa</th>
                                            <th class="th-sm">Publikasi Ilmiah</th>
                                            <th class="th-sm">Media Massa</th>
                                            <th class="th-sm">Produk / Jasa</th>
                                            <th class="th-sm">Capaian Publikasi Ilmiah</th>
                                            <th class="th-sm">Capaian Luaran Wajib</th>
                                            <th class="th-sm">Luaran Tambahan</th>
                                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                                <th class="th-sm no-export">Tindakan</th>
                                            @endif
                                        </tr>
                                    </x-slot>
                                    @foreach ($abdimas as $index => $item)
                                        <tr>
                                            @if($item['no_sk'] != null && filter_var($item['link_sk'], FILTER_VALIDATE_URL))
                                                <td><a href="{{ $item['link_sk'] }}" target="_blank"
                                                        rel="noopener noreferrer">{{ $item['no_sk'] }}</a></td>
                                            @else
                                                <td>{{ $item['no_sk'] ?? '-' }}</td>
                                            @endif
                                            @if($item['no_kontrak'] != null && filter_var($item['link_kontrak'], FILTER_VALIDATE_URL))
                                                <td><a href="{{ $item['link_kontrak'] }}" target="_blank"
                                                        rel="noopener noreferrer">{{ $item['no_kontrak'] }}</a></td>
                                            @else
                                                <td>{{ $item['no_kontrak'] ?? '-' }}</td>
                                            @endif
                                            <td>{{ $item['judul_penelitian'] ?? '-' }}</td>
                                            <td>{{ $item['nama_skema'] ?? '-' }}</td>
                                            <td>{{ $item['tahun_pelaksanaan'] ?? '-' }}</td>
                                            <td>{{ $item['lama_kegiatan'] ?? 0 }} bulan</td>
                                            <td>{{ $item['bidang_fokus'] ?? '-' }}</td>
                                            <td>{{ formatRupiah($item['dana_disetujui']) }}</td>
                                            <td>{{ $item['target_tkt'] ?? 0 }}</td>
                                            <td>{{ $item['nama_program_hibah'] ?? '-' }}</td>
                                            <td>{{ $item['sumber_dana'] ?? '-' }}</td>
                                            <td>{{ $item['nama_ketua'] ?? '-' }}</td>
                                            <td>
                                                {{ collect([
                                                    $item['nama_member1'] ?? null,
                                                    $item['nama_member2'] ?? null,
                                                    $item['nama_member3'] ?? null,
                                                    $item['nama_member4'] ?? null,
                                                    $item['nama_member5'] ?? null,
                                                    $item['nama_member6'] ?? null,
                                                    $item['nama_member7'] ?? null,
                                                    $item['nama_member8'] ?? null,
                                                ])->filter()->join(', ') ?: '-' }}
                                            </td>
                                            <td>{{ $item['sdg'] ?? '-' }}</td>
                                            @if($item['proposal'] != null && filter_var($item['proposal'], FILTER_VALIDATE_URL))
                                                <td> <a href="{{ $item['proposal'] }}" target="_blank" rel="noopener noreferrer">
                                                        <i class="fas fa-file-pdf fs-2 d-flex justify-content-center"></i></a>
                                                </td>
                                            @else
                                                <td> {{ $item['proposal'] ?? '-' }} </td>
                                            @endif
                                            @if($item['laporan_akhir'] != null && filter_var($item['laporan_akhir'], FILTER_VALIDATE_URL))
                                                <td> <a href="{{ $item['laporan_akhir'] }}" target="_blank"
                                                        rel="noopener noreferrer"><i class="fas fa-file-pdf fs-2 d-flex justify-content-center"></i></a></td>
                                            @else
                                                <td> {{ $item['laporan_akhir'] ?? '-' }} </td>
                                            @endif
                                            <td>{{ collect([
                                                    $item['nama_mhs1'] ?? null,
                                                    $item['nama_mhs2'] ?? null,
                                                    $item['nama_mhs3'] ?? null,
                                                    $item['nama_mhs4'] ?? null,
                                                    $item['nama_mhs5'] ?? null,
                                                    $item['nama_mhs6'] ?? null,
                                                    $item['nama_mhs7'] ?? null,
                                                    $item['nama_mhs8'] ?? null,
                                                ])->filter()->join(', ') ?: '-' }}
                                            </td>
                                            <td>{{ $item['publikasi_ilmiah'] ?? '-' }}</td>
                                            <td>{{ $item['media_massa'] ?? '-' }}</td>
                                            <td>{{ $item['produk_jasa'] ?? '-' }}</td>
                                            <td>{{ $item['capaian_publikasi_ilmiah'] ?? '-' }}</td>
                                            <td>{{ $item['capaian_luaran_wajib'] ?? '-' }}</td>
                                            <td>{{ $item['luaran_tambahan'] ?? '-' }}</td>
                                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                                <td class="project-actions text-center">
                                                    <a class="btn btn-info btn-sm" href="#" data-toggle="modal"
                                                        data-target="#edit{{ $item['id'] }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal"
                                                        data-target="#delete{{ $item['id'] }}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </x-table.datatable-wrapper>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Import -->
    <x-modals.import-excel modalId="importDataAbdimas" title="Data Abdimas"
        action="{{ route('import_data_abdimas_table') }}" template-url="{{ asset('file_abdimas/Abdimas.xlsx') }}"
        template-text="Download Template Excel" />

    <!-- Modal Create -->
    <x-modals.create modalId="modal-lg" title="Tambah Data Abdimas Baru" action="{{ route('tambah_data_abdimas_table') }}"
        size="xl">
        <div class="card-body">
            <div class="form-group row">
                <label for="linkSk" class="col-sm-2 col-form-label d-flex align-items-center">Link SK</label>
                <div class="col-sm-6 d-flex align-items-center">
                    <input id="linkSk" type="text" class="form-control" name="link_sk" placeholder="Isikan Link SK">
                </div>
                <label for="no_sk" class="col-sm-1 col-form-label d-flex align-items-center">No. SK</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input id="no_sk" type="text" class="form-control" name="no_sk" placeholder="Isikan No. SK">
                </div>
            </div>
            <div class="form-group row">
                <label for="link_kontrak" class="col-sm-2 col-form-label d-flex align-items-center">Link Kontrak</label>
                <div class="col-sm-6 d-flex align-items-center">
                    <input id="link_kontrak" type="text" class="form-control" name="link_kontrak"
                        placeholder="Isikan Link Kontrak">
                </div>
                <label for="no_kontrak" class="col-sm-1 col-form-label d-flex align-items-center">No. Kontrak</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input id="no_kontrak" type="text" class="form-control" name="no_kontrak"
                        placeholder="Isikan No. Kontrak">
                </div>
            </div>
            <div class="form-group row">
                <label for="judul_penelitian_create" class="col-sm-2 col-form-label d-flex align-items-center">Judul Penelitian/Pengabdian</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="judul_penelitian_create" name="judul_penelitian" placeholder="Isikan Judul Penelitian/Pengabdian" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_skema" class="col-sm-2 col-form-label d-flex align-items-center">Nama Skema</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input id="nama_skema" type="text" class="form-control" name="nama_skema"
                        placeholder="Isikan Nama Skema" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="tahun_usulan" class="col-sm-2 col-form-label d-flex align-items-center">Tahun Usulan</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <select name="tahun_usulan" class="form-select" id="tahun_usulan" required>
                        <option value="">Pilih Tahun</option>
                        @foreach ($tahun as $thn)
                            <option value="{{ $thn->tahun }}">{{ $thn->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label for="tahun_pelaksanaan" class="col-sm-2 col-form-label d-flex align-items-center">Tahun
                    Pelaksanaan</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <select name="tahun_pelaksanaan" class="form-select" id="tahun_pelaksanaan" required>
                        <option value="">Pilih Tahun</option>
                        @foreach ($tahun as $thn)
                            <option value="{{ $thn->tahun }}">{{ $thn->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label for="lama_kegiatan" class="col-sm-2 col-form-label d-flex align-items-center">Lama Kegiatan
                    (bulan)</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <input id="lama_kegiatan" type="number" class="form-control" name="lama_kegiatan"
                        placeholder="Isikan Lama Kegiatan (bulan)">
                </div>
            </div>
            <div class="form-group row">
                <label for="bidang_fokus" class="col-sm-2 col-form-label d-flex align-items-center">Bidang Fokus</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input id="bidang_fokus" type="text" class="form-control" name="bidang_fokus"
                        placeholder="Isikan Bidang Fokus">
                </div>
            </div>
            <div class="form-group row">
                <label for="dana_diusulkan" class="col-sm-2 col-form-label d-flex align-items-center">Dana yang
                    Diusulkan</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <input id="dana_diusulkan" type="number" class="form-control" name="dana_diusulkan"
                        placeholder="Isikan Dana yang Diusulkan" style="border-color: yellow;">
                </div>
                <label for="dana_disetujui" class="col-sm-2 col-form-label d-flex align-items-center">Dana Disetujui</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <input id="dana_disetujui" type="number" class="form-control" name="dana_disetujui"
                        placeholder="Isikan Dana Disetujui" required style="border-color: green;">
                </div>
                <label for="target_tkt" class="col-sm-2 col-form-label d-flex align-items-center">Target TKT</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <input id="target_tkt" type="number" class="form-control" name="target_tkt"
                        placeholder="Isikan Target TKT" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_program_hibah" class="col-sm-2 col-form-label d-flex align-items-center">Nama Program
                    Hibah</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input id="nama_program_hibah" type="text" class="form-control" name="nama_program_hibah"
                        placeholder="Isikan Nama Program Hibah">
                </div>
            </div>
            <div class="form-group row">
                <label for="kategori_sumber_dana" class="col-sm-2 col-form-label d-flex align-items-center">Kategori Sumber
                    Dana</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <select name="kategori_sumber_dana" class="form-select" id="kategori_sumber_dana" required>
                        <option value="">Pilih Kategori Sumber Dana</option>
                        <option value="Intenal">Internal</option>
                        <option value="Eksternal">Eksternal</option>
                    </select>
                </div>
                <label for="negara_sumber_dana" class="col-sm-2 col-form-label d-flex align-items-center">Negara Sumber
                    Dana</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <input id="negara_sumber_dana" type="text" class="form-control" name="negara_sumber_dana"
                        placeholder="Isikan Negara Sumber Dana">
                </div>
                <label for="sumber_dana" class="col-sm-2 col-form-label d-flex align-items-center">Sumber Dana</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <input id="sumber_dana" type="text" class="form-control" name="sumber_dana"
                        placeholder="Isikan Sumber Dana">
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_ketua" class="col-sm-2 col-form-label d-flex align-items-center">Nama Ketua</label>
                <div class="col-sm-4 d-flex align-items-center">
                    <input id="nama_ketua" type="text" class="form-control" name="nama_ketua"
                        placeholder="Isikan Nama Ketua" required>
                </div>
                <label for="dana_ketua" class="col-sm-2 col-form-label d-flex align-items-center">DANA KETUA</label>
                <div class="col-sm-4 d-flex align-items-center">
                    <input id="dana_ketua" type="number" class="form-control" name="dana_ketua"
                        placeholder="Isikan Dana Ketua" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="pt" class="col-sm-2 col-form-label d-flex align-items-center">PT</label>
                <div class="col-sm-5 d-flex align-items-center">
                    <input id="pt" type="text" class="form-control" name="pt" placeholder="Isikan PT" required>
                </div>
            </div>

            <!-- Member Fields -->
            <hr>
            <h5 class="font-weight-bold d-flex justify-content-center">Data Member</h5>
            <div class="container">
                <div class="row">
                    @for ($i = 1; $i <= 8; $i++)
                        <div class="col-md-4 mb-4">
                            <fieldset class="form-group border p-3 h-100">
                                <legend class="w-auto px-2 font-weight-bold">Member {{ $i }}</legend>
                                <div class="form-group mb-2">
                                    <input type="text" class="form-control" id="nama_member{{ $i }}" name="nama_member{{ $i }}"
                                        placeholder="Nama Member">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="dana_member{{ $i }}" name="dana_member{{ $i }}"
                                        placeholder="Dana Member">
                                </div>
                                <div class="form-group mt-2">
                                    <input type="text" class="form-control" id="pt{{ $i }}" name="pt{{ $i }}"
                                        placeholder="PT Member">
                                </div>
                            </fieldset>
                        </div>
                    @endfor
                </div>
            </div>
            <!-- Additional Fields -->
            <hr>
            <h6>Additional Fields</h6>
            <div class="form-group row">
                <label for="sdg" class="col-sm-2 col-form-label d-flex align-items-center">SDG</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="sdg" name="sdg" placeholder="Isikan SDG">
                </div>
            </div>

            <div class="form-group row">
                <label for="proposal" class="col-sm-2 col-form-label d-flex align-items-center">Proposal</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="proposal" name="proposal"
                        placeholder="Isikan URL Link Proposal">
                </div>
            </div>

            <div class="form-group row">
                <label for="laporan_akhir" class="col-sm-2 col-form-label d-flex align-items-center">Laporan Akhir</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="laporan_akhir" name="laporan_akhir"
                        placeholder="Isikan URL Link Laporan Akhir">
                </div>
            </div>

            <!-- Mahasiswa Fields -->
            <hr>
            <h5 class="font-weight-bold d-flex justify-content-center">Data Mahasiswa</h5>
                    <div class="container">
                        <div class="row">
                            @for ($i = 1; $i <= 8; $i++)
                                <div class="col-md-4 mb-4">
                                    <fieldset class="form-group border p-3 h-100">
                                        <legend class="w-auto px-2 font-weight-bold">Mahasiswa {{ $i }}</legend>
                                        <div class="form-group mb-2">
                                            <input id="namaMhs{{ $i }}" type="text" class="form-control" name="nama_mhs{{ $i }}"
                                                placeholder="Nama Mahasiswa">
                                        </div>
                                        <div class="form-group mb-2">
                                            <select name="prodi_mhs{{ $i }}" id="prodi_mhs{{ $i }}_create" class="form-select">
                                                <option value="">Pilih Prodi</option>
                                                @foreach ($jurusan as $jrs)
                                                    <option value="{{ $jrs->nama_jurusan }}">{{ $jrs->nama_jurusan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                            @endfor
                        </div>
                    </div>

            <!-- Luaran Fields -->
            <hr>
            <h6>Luaran</h6>
            <div class="form-group row">
                <label for="publikasi_ilmiah" class="col-sm-2 col-form-label d-flex align-items-center">Publikasi
                    Ilmiah</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="publikasi_ilmiah" name="publikasi_ilmiah"
                        placeholder="Isikan Publikasi Ilmiah">
                </div>
            </div>

            <div class="form-group row">
                <label for="media_massa" class="col-sm-2 col-form-label d-flex align-items-center">Media Massa</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="media_massa" name="media_massa"
                        placeholder="Isikan Media Massa">
                </div>
            </div>

            <div class="form-group row">
                <label for="produk_jasa" class="col-sm-2 col-form-label d-flex align-items-center">Produk / Jasa</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="produk_jasa" name="produk_jasa"
                        placeholder="Isikan Produk / Jasa">
                </div>
            </div>

            <div class="form-group row">
                <label for="capaian_publikasi_ilmiah" class="col-sm-2 col-form-label d-flex align-items-center">Capaian
                    Publikasi Ilmiah</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="capaian_publikasi_ilmiah" name="capaian_publikasi_ilmiah"
                        placeholder="Isikan Capaian Publikasi Ilmiah">
                </div>
            </div>

            <div class="form-group row">
                <label for="capaian_luaran_wajib" class="col-sm-2 col-form-label d-flex align-items-center">Capaian Luaran
                    Wajib</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="capaian_luaran_wajib" name="capaian_luaran_wajib"
                        placeholder="Isikan Capaian Luaran Wajib">
                </div>
            </div>

            <div class="form-group row">
                <label for="luaran_tambahan" class="col-sm-2 col-form-label d-flex align-items-center">Luaran
                    Tambahan</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="luaran_tambahan" name="luaran_tambahan"
                        placeholder="Isikan Luaran Tambahan">
                </div>
            </div>


        </div>
    </x-modals.create>

    <!-- Modals Edit & Delete -->
    @foreach($abdimas as $index => $item)
        <x-modals.edit modalId="edit{{ $item['id'] }}" title="Edit Data Abdimas" action="{{ route('edit_data_abdimas_table') }}"
            size="xl">
            <div class="card-body">
                <input type="hidden" value="{{ $item['id'] }}" name="id">
                <div class="form-group row">
                    <label for="link_sk_edit" class="col-sm-2 col-form-label d-flex align-items-center">Link SK</label>
                    <div class="col-sm-6 d-flex align-items-center">
                        <input id="link_sk_edit" type="text" class="form-control" name="link_sk" value="{{ $item['link_sk'] }}">
                    </div>
                    <label for="no_sk_edit" class="col-sm-1 col-form-label d-flex align-items-center">No. SK</label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <input id="no_sk_edit" type="text" class="form-control" name="no_sk" value="{{ $item['no_sk'] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="link_kontrak_edit" class="col-sm-2 col-form-label d-flex align-items-center">Link Kontrak</label>
                    <div class="col-sm-6 d-flex align-items-center">
                        <input id="link_kontrak_edit" type="text" class="form-control" name="link_kontrak"
                            value="{{ $item['link_kontrak'] }}">
                    </div>
                    <label for="no_kontrak_edit" class="col-sm-1 col-form-label d-flex align-items-center">No. Kontrak</label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <input id="no_kontrak_edit" type="text" class="form-control" name="no_kontrak"
                            value="{{ $item['no_kontrak'] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="judul_penelitian_edit" class="col-sm-2 col-form-label d-flex align-items-center">Judul
                        Penelitian</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input id="judul_penelitian_edit" type="text" class="form-control" name="judul_penelitian"
                            value="{{ $item['judul_penelitian'] }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_skema_edit" class="col-sm-2 col-form-label d-flex align-items-center">Nama Skema</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input id="nama_skema_edit" type="text" class="form-control" name="nama_skema"
                            value="{{ $item['nama_skema'] }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tahun_usulan_edit" class="col-sm-2 col-form-label d-flex align-items-center">Tahun Usulan</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <select name="tahun_usulan" class="form-select" id="tahun_usulan_edit" required>
                            @if(empty($item['tahun_usulan']))
                                <option value="">Pilih Tahun</option>
                            @endif
                            @foreach ($tahun as $thn)
                                <option value="{{ $thn->tahun }}" {{ ($item['tahun_usulan'] == $thn->tahun) ? 'selected' : '' }}>{{ $thn->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <label for="tahun_pelaksanaan_edit" class="col-sm-2 col-form-label d-flex align-items-center">Tahun
                        Pelaksanaan</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <select name="tahun_pelaksanaan" class="form-select" id="tahun_pelaksanaan_edit" required>
                            @if(empty($item['tahun_pelaksanaan']))
                                <option value="">Pilih Tahun</option>
                            @endif
                            @foreach ($tahun as $thn)
                                <option value="{{ $thn->tahun }}" {{ ($item['tahun_pelaksanaan'] == $thn->tahun) ? 'selected' : '' }}>{{ $thn->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <label for="lama_kegiatan_edit" class="col-sm-2 col-form-label d-flex align-items-center">Lama Kegiatan
                        (bulan)</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <input id="lama_kegiatan_edit" type="number" class="form-control" name="lama_kegiatan"
                            value="{{ $item['lama_kegiatan'] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bidang_fokus_edit" class="col-sm-2 col-form-label d-flex align-items-center">Bidang Fokus</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input id="bidang_fokus_edit" type="text" class="form-control" name="bidang_fokus"
                            value="{{ $item['bidang_fokus'] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="dana_diusulkan_edit" class="col-sm-2 col-form-label d-flex align-items-center">Dana yang
                        Diusulkan</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <input id="dana_diusulkan_edit" type="number" class="form-control" name="dana_diusulkan"
                            value="{{ $item['dana_diusulkan'] }}" style="border-color: yellow;">
                    </div>
                    <label for="dana_disetujui_edit" class="col-sm-2 col-form-label d-flex align-items-center">Dana Disetujui</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <input id="dana_disetujui_edit" type="number" class="form-control" name="dana_disetujui"
                            value="{{ $item['dana_disetujui'] }}" required style="border-color: green;">
                    </div>
                    <label for="target_tkt_edit" class="col-sm-2 col-form-label d-flex align-items-center">Target TKT</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <input id="target_tkt_edit" type="number" class="form-control" name="target_tkt"
                            value="{{ $item['target_tkt'] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_program_hibah_edit" class="col-sm-2 col-form-label d-flex align-items-center">Nama Program
                        Hibah</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input id="nama_program_hibah_edit" type="text" class="form-control" name="nama_program_hibah"
                            value="{{ $item['nama_program_hibah'] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori_sumber_dana_edit" class="col-sm-2 col-form-label d-flex align-items-center">Kategori Sumber
                        Dana</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <select name="kategori_sumber_dana" class="form-select" id="kategori_sumber_dana_edit" required>
                            @if(empty($item['kategori_sumber_dana']))
                                <option value="">Pilih Kategori Sumber Dana</option>
                            @endif
                            <option value="Intenal" {{ ($item['kategori_sumber_dana'] == 'Intenal') ? 'selected' : '' }}>Internal</option>
                            <option value="Eksternal" {{ ($item['kategori_sumber_dana'] == 'Eksternal') ? 'selected' : '' }}>Eksternal</option>
                        </select>
                    </div>
                    <label for="negara_sumber_dana_edit" class="col-sm-2 col-form-label d-flex align-items-center">Negara Sumber
                        Dana</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <input id="negara_sumber_dana_edit" type="text" class="form-control" name="negara_sumber_dana"
                            value="{{ $item['negara_sumber_dana'] }}">
                    </div>
                    <label for="sumber_dana_edit" class="col-sm-2 col-form-label d-flex align-items-center">Sumber Dana</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <input id="sumber_dana_edit" type="text" class="form-control" name="sumber_dana"
                            value="{{ $item['sumber_dana'] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_ketua_edit" class="col-sm-2 col-form-label d-flex align-items-center">Nama Ketua</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input id="nama_ketua_edit" type="text" class="form-control" name="nama_ketua"
                            value="{{ $item['nama_ketua'] }}" required>
                    </div>
                    <label for="dana_ketua_edit" class="col-sm-2 col-form-label d-flex align-items-center">DANA KETUA</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input id="dana_ketua_edit" type="number" class="form-control" name="dana_ketua"
                            value="{{ $item['dana_ketua'] }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pt_edit" class="col-sm-2 col-form-label d-flex align-items-center">PT</label>
                    <div class="col-sm-5 d-flex align-items-center">
                        <input id="pt_edit" type="text" class="form-control" name="pt" value="{{ $item['pt'] }}" required>
                    </div>
                </div>

                <!-- Member Fields -->
                <hr>
                <h5 class="font-weight-bold d-flex justify-content-center">Data Member</h5>
                <div class="container">
                    <div class="row">
                        @for ($i = 1; $i <= 8; $i++)
                            <div class="col-md-4 mb-4">
                                <fieldset class="form-group border p-3 h-100">
                                    <legend class="w-auto px-2 font-weight-bold">Member {{ $i }}</legend>
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" id="nama_member_{{ $i }}" name="nama_member{{ $i }}"
                                            value="{{ $item['nama_member'.$i] ? $item['nama_member'.$i] : '' }}" placeholder="Nama Member">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control" id="dana_member_{{ $i }}" name="dana_member{{ $i }}"
                                            value="{{ $item['dana_member'.$i] ? $item['dana_member'.$i] : '' }}" placeholder="Dana Member">
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" id="pt_{{ $i }}" name="pt{{ $i }}"
                                            value="{{ $item['pt'.$i] ? $item['pt'.$i] : '' }}" placeholder="PT Member">
                                    </div>
                                </fieldset>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Additional Fields -->
                <hr>
                <h6>Additional Fields</h6>
                <div class="form-group row">
                    <label for="sdg_edit" class="col-sm-2 col-form-label d-flex align-items-center">SDG</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control d-flex align-items-center" id="sdg_edit" name="sdg"
                            value="{{ $item['sdg'] }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="proposal_edit" class="col-sm-2 col-form-label d-flex align-items-center">Proposal</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control d-flex align-items-center" id="proposal_edit" name="proposal"
                            value="{{ $item['proposal'] }}" placeholder="Isikan URL Link Proposal">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="laporan_akhir_edit" class="col-sm-2 col-form-label d-flex align-items-center">Laporan
                        Akhir</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control d-flex align-items-center" id="laporan_akhir_edit"
                            name="laporan_akhir" value="{{ $item['laporan_akhir'] }}"
                            placeholder="Isikan URL Link Laporan Akhir">
                    </div>
                </div>



                <!-- Mahasiswa Fields -->
                <hr>
                <h5 class="font-weight-bold d-flex justify-content-center">Data Mahasiswa</h5>
                    <div class="container">
                        <div class="row">
                            @for ($i = 1; $i <= 8; $i++)
                                <div class="col-md-4 mb-4">
                                    <fieldset class="form-group border p-3 h-100">
                                        <legend class="w-auto px-2 font-weight-bold">Mahasiswa {{ $i }}</legend>
                                        <div class="form-group mb-2">
                                            <input type="text" class="form-control" id="nama_mhs{{ $i }}" name="nama_mhs{{ $i }}"
                                                value="{{ $item['nama_mhs' . $i]  ? $item['nama_mhs' . $i] : '' }}" placeholder="Nama Mahasiswa">
                                        </div>
                                        <div class="form-group mb-2">
                                            <select name="prodi_mhs{{ $i }}" id="prodi_mhs{{ $i }}_edit" class="form-select">
                                                @if(empty($item['prodi_mhs' . $i]))
                                                    <option value="">Pilih Prodi</option>
                                                @else
                                                    <option value="{{ $item['prodi_mhs' . $i] }}">{{ $item['prodi_mhs' . $i] }}</option>
                                                @endif
                                                @foreach ($jurusan as $j)
                                                    <option value="{{ $j->nama_jurusan }}" {{ ($item['prodi_mhs' . $i] == $j->nama_jurusan) ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                            @endfor
                        </div>
                    </div>


                <!-- Luaran Fields -->
                <hr>
                <h6>Luaran</h6>
                <div class="form-group row">
                    <label for="publikasi_ilmiah_edit" class="col-sm-2 col-form-label d-flex align-items-center">Publikasi
                        Ilmiah</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="publikasi_ilmiah_edit" name="publikasi_ilmiah"
                            value="{{ $item['publikasi_ilmiah'] }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="media_massa_edit" class="col-sm-2 col-form-label d-flex align-items-center">Media Massa</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="media_massa_edit" name="media_massa"
                            value="{{ $item['media_massa'] }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="produk_jasa_edit" class="col-sm-2 col-form-label d-flex align-items-center">Produk /
                        Jasa</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="produk_jasa_edit" name="produk_jasa"
                            value="{{ $item['produk_jasa'] }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="capaian_publikasi_ilmiah_edit" class="col-sm-2 col-form-label d-flex align-items-center">Capaian
                        Publikasi Ilmiah</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="capaian_publikasi_ilmiah_edit"
                            name="capaian_publikasi_ilmiah" value="{{ $item['capaian_publikasi_ilmiah'] }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="capaian_luaran_wajib_edit" class="col-sm-2 col-form-label d-flex align-items-center">Capaian
                        Luaran Wajib</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="capaian_luaran_wajib_edit" name="capaian_luaran_wajib"
                            value="{{ $item['capaian_luaran_wajib'] }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="luaran_tambahan_edit" class="col-sm-2 col-form-label d-flex align-items-center">Luaran
                        Tambahan</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="luaran_tambahan_edit" name="luaran_tambahan"
                            value="{{ $item['luaran_tambahan'] }}">
                    </div>
                </div>


            </div>
        </x-modals.edit>

        <x-modals.delete modalId="delete{{ $item['id'] }}" message="Apakah Anda yakin ingin menghapus data ini?"
            action="{{ route('hapus_data_abdimas_table', $item['id']) }}" />
    @endforeach
    {{-- DataTables Config --}}
    @php
        $abdimas_columns = [
            0 => ['6%', 'text-center'],   // No. SK
            1 => ['6%', 'text-center'],   // No. Kontrak
            2 => ['20%', 'text-wrap'],    // Judul Penelitian/Pengabdian
            3 => ['6%', 'text-center'],   // Skema
            4 => ['6%', 'text-center'],   // Tahun Pelaksanaan
            5 => ['6%', 'text-center'],   // Lama Kegiatan
            6 => ['10%', 'text-wrap'],    // Bidang Fokus
            7 => ['8%', 'text-right'],    // Dana Disetujui (right align numbers)
            8 => ['6%', 'text-center'],   // Target TKT
            9 => ['8%', 'text-wrap'],     // Nama Program Hibah
            10 => ['6%', 'text-wrap'],    // Sumber Dana
            11 => ['8%', 'text-wrap'],    // Nama Ketua
            12 => ['8%', 'text-wrap'],    // Nama Member
            13 => ['6%', 'text-center'],  // SDG
            14 => ['4%', 'text-center'],  // File Proposal
            15 => ['4%', 'text-center'],  // File Laporan Akhir
            16 => ['8%', 'text-wrap'],    // Nama Mahasiswa
            17 => ['6%', 'text-wrap'],    // Publikasi Ilmiah
            18 => ['6%', 'text-wrap'],    // Media Massa
            19 => ['6%', 'text-wrap'],    // Produk / Jasa
            20 => ['6%', 'text-wrap'],    // Capaian Publikasi Ilmiah
            21 => ['6%', 'text-wrap'],    // Capaian Luaran Wajib
            22 => ['6%', 'text-wrap'],    // Luaran Tambahan
        ];
        // Only add Tindakan column if user is admin
        if (Auth::check() && Auth::user()->aktor_id == '1') {
            $abdimas_columns[23] = ['4%', 'text-center no-export'];    // Tindakan (Edit/Hapus)
        }
    @endphp
    <x-table.datatable-config tableId="data_abdimas" :hasExport="true" :columns="$abdimas_columns" />
    {{--
    <script>
        $(function () {
            $("#username_input").autocomplete({
                source: "search.php",
            });
        });
    </script> --}}
@endsection
