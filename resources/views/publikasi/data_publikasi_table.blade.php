@extends('template.layout')

@section('page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-end">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Publikasi</li>
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
                            <h5 class="card-title">Data Publikasi: {{ $jml_publikasi }} Data</h5>
                        </div>
                        <div class="card-body">
                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                <ol class="col-12 mt-2 mb-2">
                                    <x-table.button-table
                                        title="Publikasi"
                                        data-target-import="#importDataPublikasi"
                                        data-target-baru="#modal-lg"
                                        href-template="{{ asset('file_publikasi/publikasi_template.xlsx') }}"
                                    ></x-table.button-table>
                                </ol>
                            @endif
                            <ol class="col-12 mt-2 mb-2">
                                <form action="{{ route('data_publikasi_table') }}" method="GET">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="tahun_filter">Tahun Published</label>
                                            <select name="tahun_filter" id="tahun_filter" class="form-select" required onchange="this.form.submit()">
                                                @foreach ($tahun_filter as $item)
                                                    <option value="{{ $item }}" {{ (request('tahun_filter') == $item) ? 'selected' : '' }}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="akreditasi_index_jurnal">Akreditasi/Index Jurnal</label>
                                            <select name="akreditasi_index_jurnal" id="akreditasi_index_jurnal" class="form-select" required onchange="this.form.submit()">
                                                @foreach ($akreditasi_index_jurnal as $item)
                                                    <option value="{{ $item }}" {{ (request('akreditasi_index_jurnal') == $item) ? 'selected' : '' }}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </ol>
                            <div class="tab-content p-0">
                                <br />
                                <x-table.datatable-wrapper tableId="data_publikasi">
                                    <x-slot name="thead">
                                        <tr align="center">
                                            <th class="th-sm">Judul Publikasi</th>
                                            <th class="th-sm">Nama Jurnal</th>
                                            <th class="th-sm">Akreditasi/Index</th>
                                            <th class="th-sm">Lembaga Pengindeks</th>
                                            <th class="th-sm">Tahun Published</th>
                                            <th class="th-sm">DOI</th>
                                            <th class="th-sm">Nama Penulis Koresponding</th>
                                            @for ($i = 1; $i <= 15; $i++)
                                                <th class="th-sm">Nama Penulis {{ $i }}</th>
                                                <th class="th-sm">Afiliasi {{ $i }}</th>
                                                <th class="th-sm">Prodi {{ $i }}</th>
                                                <th class="th-sm">Kode dosen {{ $i }}</th>
                                                <th class="th-sm">NIM mahasiswa {{ $i }}</th>
                                            @endfor
                                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                                <th class="th-sm no-export">Tindakan</th>
                                            @endif
                                        </tr>
                                    </x-slot>
                                    @foreach ($publikasi as $index => $item)
                                        <tr>
                                            <td>{{ $item['judul_publikasi'] ?? '-' }}</td>
                                            <td>{{ $item['nama_jurnal'] ?? '-' }}</td>
                                            <td>{{ $item['akreditasi_index_jurnal'] ?? '-' }}</td>
                                            <td>{{ $item['lembaga_pengindeks'] ?? '-' }}</td>
                                            <td>{{ $item['tahun_published'] ?? '-' }}</td>
                                            <td>{{ $item['doi'] ?? '-' }}</td>
                                            <td>{{ $item['nama_penulis_koresponding'] ?? '-' }}</td>
                                            @for ($i = 1; $i <= 15; $i++)
                                                <td>{{ $item['penulis_' . $i] ?? '-' }}</td>
                                                <td>{{ $item['afiliasi_' . $i] ?? '-' }}</td>
                                                <td>{{ $item['prodi_' . $i] ?? '-' }}</td>
                                                <td>{{ $item['kode_dosen_' . $i] ?? '-' }}</td>
                                                <td>{{ $item['nim_' . $i] ?? '-' }}</td>
                                            @endfor
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
    <x-modals.import-excel modalId="importDataPublikasi" title="Data Publikasi"
        action="{{ route('import_publikasi_table') }}"
        template-url="{{ asset('file_publikasi/publikasi_template.xlsx') }}"
        template-text="Download Template Excel" />

    <!-- Modal Create -->
    <x-modals.create modalId="modal-lg" title="Tambah Data Publikasi Baru"
        action="{{ route('tambah_data_publikasi_table') }}" size="xl">
        <div class="card-body">
            <!-- Kolom Penulis Utama -->
            <div class="form-group row">
                <label for="judul_publikasi_create" class="col-sm-2 col-form-label d-flex align-items-center">Judul Publikasi</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="judul_publikasi_create" name="judul_publikasi" placeholder="Isikan Judul Publikasi" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_jurnal_create" class="col-sm-2 col-form-label d-flex align-items-center">Nama Jurnal</label>
                <div class="col-sm-7 d-flex align-items-center">
                    <input type="text" class="form-control" id="nama_jurnal_create" name="nama_jurnal" placeholder="Isikan Nama Jurnal" required>
                </div>
                <label for="tahun_published_create" class="col-sm-1 col-form-label d-flex align-items-center">Tahun Published</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <select name="tahun_published" id="tahun_published_create" class="form-select" required>
                        <option value="">Pilih Tahun</option>
                        @foreach ($tahun as $thn)
                            <option value="{{ $thn->tahun }}">{{ $thn->tahun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="akreditasi_create" class="col-sm-2 col-form-label d-flex align-items-center">Akreditasi/Index</label>
                <div class="col-sm-5 d-flex align-items-center">
                    <input type="text" class="form-control" id="akreditasi_create" name="akreditasi_index_jurnal" placeholder="Isikan Akreditasi/Index">
                </div>
                <label for="lembaga_create" class="col-sm-2 col-form-label d-flex align-items-center">Lembaga Pengindeks</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input type="text" class="form-control" id="lembaga_create" name="lembaga_pengindeks" placeholder="Isikan Lembaga">
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_penulis_create" class="col-sm-2 col-form-label d-flex align-items-center">Nama Penulis Koresponding</label>
                <div class="col-sm-5 d-flex align-items-center">
                    <input type="text" class="form-control" id="nama_penulis_create" name="nama_penulis_koresponding" placeholder="Isikan Nama Penulis" required>
                </div>
                <label for="prodi_create" class="col-sm-2 col-form-label d-flex align-items-center">Prodi</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <select name="prodi" id="prodi_create" class="form-select" required>
                        <option value="">Pilih Prodi</option>
                        @foreach ($jurusan as $j)
                            <option value="{{ $j->nama_jurusan }}">{{ $j->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="status_create" class="col-sm-2 col-form-label d-flex align-items-center">Status</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <select name="status" id="status_create" class="form-select">
                        <option value="">Pilih Status</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="staff">Staff</option>
                        <option value="eksternal">Eksternal</option>
                    </select>
                </div>
                <label for="afiliasi_create" class="col-sm-1 col-form-label d-flex align-items-center">Afiliasi</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input type="text" class="form-control" id="afiliasi_create" name="afiliasi" placeholder="Isikan Afiliasi">
                </div>
                <label for="doi_create" class="col-sm-1 col-form-label d-flex align-items-center">DOI</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input type="text" class="form-control" id="doi_create" name="doi" placeholder="Isikan DOI">
                </div>
            </div>

            <!-- Penulis Tambahan -->
            <hr>
            <h5 class="font-weight-bold d-flex justify-content-center">Data Penulis</h5>
            <div class="container">
                <div class="row">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="col-md-4 mb-4">
                            <fieldset class="form-group border p-3 h-100">
                                <legend class="w-auto px-2 font-weight-bold">Penulis {{ $i }}</legend>
                                <div class="form-group mb-2">
                                    <input type="text" class="form-control" id="penulis_{{ $i }}_create" name="penulis_{{ $i }}" placeholder="Nama Penulis {{ $i }}">
                                </div>
                                <div class="form-group mb-2">
                                    <select name="prodi_{{ $i }}" id="prodi_{{ $i }}_create" class="form-select">
                                        <option value="">Pilih Prodi</option>
                                        @foreach ($jurusan as $jrs)
                                            <option value="{{ $jrs->nama_jurusan }}">{{ $jrs->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="status_{{ $i }}" id="status_{{ $i }}_create" class="form-select">
                                        <option value="">Pilih Status</option>
                                        <option value="dosen">Dosen</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                        <option value="staff">Staff</option>
                                        <option value="eksternal">Eksternal</option>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <input type="text" class="form-control" id="afiliasi_{{ $i }}_create" name="afiliasi_{{ $i }}" placeholder="Afiliasi">
                                </div>
                            </fieldset>
                        </div>
                    @endfor
                    <div class="col-md-12 mb-4">
                        <fieldset class="form-group border p-3 h-100">
                            <legend class="w-auto px-2 font-weight-bold">Penulis Lain</legend>
                            <div class="form-group mb-2">
                                <textarea class="form-control" id="penulis_lain_create" name="penulis_lain" placeholder="Nama Penulis Lain" rows="2"></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <textarea class="form-control" id="prodi_lain_create" name="prodi_lain" placeholder="Prodi Lain" rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="status_lain_create" name="status_lain" placeholder="Status" rows="1"></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <textarea class="form-control" id="afiliasi_lain_create" name="afiliasi_lain" placeholder="Afiliasi" rows="2"></textarea>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </x-modals.create>

    <!-- Edit Modals -->
    @foreach ($publikasi as $item)
        <x-modals.edit modalId="edit{{ $item['id'] }}" title="Edit Data Publikasi"
            action="{{ route('edit_data_publikasi_table') }}" size="xl">
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $item['id'] }}">

                <!-- Kolom Penulis Utama -->
                <div class="form-group row">
                    <label for="judul_publikasi_edit" class="col-sm-2 col-form-label d-flex align-items-center">Judul Publikasi</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="judul_publikasi_edit" name="judul_publikasi" value="{{ $item['judul_publikasi'] }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama_jurnal_edit" class="col-sm-2 col-form-label d-flex align-items-center">Nama Jurnal</label>
                    <div class="col-sm-7 d-flex align-items-center">
                        <input type="text" class="form-control" id="nama_jurnal_edit" name="nama_jurnal" value="{{ $item['nama_jurnal'] }}" required>
                    </div>
                    <label for="tahun_published_edit" class="col-sm-1 col-form-label d-flex align-items-center">Tahun Published</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <select name="tahun_published" id="tahun_published_edit" class="form-select" required>
                            @if(empty($item['tahun_published']))
                                <option value="">Pilih Tahun</option>
                            @endif
                            @foreach ($tahun as $thn)
                                <option value="{{ $thn->tahun }}" {{ ($item['tahun_published'] == $thn->tahun) ? 'selected' : '' }}>{{ $thn->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="akreditasi_edit" class="col-sm-2 col-form-label d-flex align-items-center">Akreditasi/Index</label>
                    <div class="col-sm-5 d-flex align-items-center">
                        <input type="text" class="form-control" id="akreditasi_edit" name="akreditasi_index_jurnal" value="{{ $item['akreditasi_index_jurnal'] }}">
                    </div>
                    <label for="lembaga_edit" class="col-sm-2 col-form-label d-flex align-items-center">Lembaga Pengindeks</label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <input type="text" class="form-control" id="lembaga_edit" name="lembaga_pengindeks" value="{{ $item['lembaga_pengindeks'] }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama_penulis_edit" class="col-sm-2 col-form-label d-flex align-items-center">Nama Penulis Koresponding</label>
                    <div class="col-sm-5 d-flex align-items-center">
                        <input type="text" class="form-control" id="nama_penulis_edit" name="nama_penulis_koresponding" value="{{ $item['nama_penulis_koresponding'] }}" required>
                    </div>
                    <label for="prodi_edit" class="col-sm-2 col-form-label d-flex align-items-center">Prodi</label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <select name="prodi" id="prodi_edit" class="form-select" required>
                            @if(empty($item['prodi']))
                                <option value="">Pilih Prodi</option>
                            @else
                                <option value="{{ $item['prodi'] }}">{{ $item['prodi'] }}</option>
                            @endif
                            @foreach ($jurusan as $j)
                                <option value="{{ $j->nama_jurusan }}" {{ ($item['prodi'] == $j->nama_jurusan) ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status_edit" class="col-sm-2 col-form-label d-flex align-items-center">Status</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <select name="status" id="status_edit" class="form-select">
                            @if(empty($item['status']))
                                <option value="">Pilih Status</option>
                            @endif
                            <option value="dosen" {{ (strtolower($item['status']) == 'dosen') ? 'selected' : '' }}>Dosen</option>
                            <option value="mahasiswa" {{ (strtolower($item['status']) == 'mahasiswa') ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="staff" {{ (strtolower($item['status']) == 'staff') ? 'selected' : '' }}>Staff</option>
                            <option value="eksternal" {{ (strtolower($item['status']) == 'eksternal') ? 'selected' : '' }}>Eksternal</option>
                        </select>
                    </div>
                    <label for="afiliasi_edit" class="col-sm-1 col-form-label d-flex align-items-center">Afiliasi</label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <input type="text" class="form-control" id="afiliasi_edit" name="afiliasi" value="{{ $item['afiliasi'] }}">
                    </div>
                    <label for="doi_edit" class="col-sm-1 col-form-label d-flex align-items-center">DOI</label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <input type="text" class="form-control" id="doi_edit" name="doi" value="{{ $item['doi'] }}">
                    </div>
                </div>

                <!-- Penulis Tambahan -->
                <hr>
                <h5 class="font-weight-bold d-flex justify-content-center">Data Penulis</h5>
                <div class="container">
                    <div class="row">
                        @for ($i = 1; $i <= 6; $i++)
                            <div class="col-md-4 mb-4">
                                <fieldset class="form-group border p-3 h-100">
                                    <legend class="w-auto px-2 font-weight-bold">Penulis {{ $i }}</legend>
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" id="penulis_{{ $i }}_edit" name="penulis_{{ $i }}" value="{{ $item['penulis_' . $i] ?? '' }}" placeholder="Nama Penulis {{ $i }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <select name="prodi_{{ $i }}" id="prodi_{{ $i }}_edit" class="form-select">
                                            @if(empty($item['prodi_' . $i]))
                                                <option value="">Pilih Prodi</option>
                                            @else
                                                <option value="{{ $item['prodi_' . $i] }}">{{ $item['prodi_' . $i] }}</option>
                                            @endif
                                            @foreach ($jurusan as $jrs)
                                                <option value="{{ $jrs->nama_jurusan }}" {{ (isset($item['prodi_' . $i]) && $item['prodi_' . $i] == $jrs->nama_jurusan) ? 'selected' : '' }}>{{ $jrs->nama_jurusan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="status_{{ $i }}" id="status_{{ $i }}_edit" class="form-select">
                                            @if(empty($item['status_' . $i]))
                                                <option value="">Pilih Status</option>
                                            @endif
                                            <option value="dosen" {{ (isset($item['status_' . $i]) && strtolower($item['status_' . $i]) == 'dosen') ? 'selected' : '' }}>Dosen</option>
                                            <option value="mahasiswa" {{ (isset($item['status_' . $i]) && strtolower($item['status_' . $i]) == 'mahasiswa') ? 'selected' : '' }}>Mahasiswa</option>
                                            <option value="staff" {{ (isset($item['status_' . $i]) && strtolower($item['status_' . $i]) == 'staff') ? 'selected' : '' }}>Staff</option>
                                            <option value="eksternal" {{ (isset($item['status_' . $i]) && strtolower($item['status_' . $i]) == 'eksternal') ? 'selected' : '' }}>Eksternal</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" id="afiliasi_{{ $i }}_edit" name="afiliasi_{{ $i }}" value="{{ $item['afiliasi_' . $i] ?? '' }}" placeholder="Afiliasi">
                                    </div>
                                </fieldset>
                            </div>
                        @endfor
                        <div class="col-md-12 mb-4">
                            <fieldset class="form-group border p-3 h-100">
                                <legend class="w-auto px-2 font-weight-bold">Penulis Lain</legend>
                                <div class="form-group mb-2">
                                    <textarea class="form-control" id="penulis_lain_edit" name="penulis_lain" placeholder="Nama Penulis Lain" rows="2">{{ $item['penulis_lain'] ?? '' }}</textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <textarea class="form-control" id="prodi_lain_edit" name="prodi_lain" placeholder="Prodi Lain" rows="2">{{ $item['prodi_lain'] ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" id="status_lain_edit" name="status_lain" placeholder="Status" rows="1">{{ $item['status_lain'] ?? '' }}</textarea>
                                </div>
                                <div class="form-group mt-2">
                                    <textarea class="form-control" id="afiliasi_lain_edit" name="afiliasi_lain" placeholder="Afiliasi" rows="2">{{ $item['afiliasi_lain'] ?? '' }}</textarea>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </x-modals.edit>

        <x-modals.delete modalId="delete{{ $item['id'] }}"
            message="Apakah Anda yakin ingin menghapus data ini?"
            action="{{ route('hapus_data_publikasi_table', $item['id']) }}" />
    @endforeach

    <!-- DataTable Configuration -->
    @php
        $publikasi_columns = [
            0  => ['20%', 'text-wrap'],   // Judul Publikasi
            1  => ['12%', 'text-wrap'],   // Nama Jurnal
            2  => ['8%', 'text-center'],  // Akreditasi/Index
            3  => ['8%', 'text-center'],  // Lembaga Pengindeks
            4  => ['6%', 'text-center'],  // Tahun Published
            5  => ['10%', 'text-wrap'],   // Nama Penulis Koresponding
            6  => ['6%', 'text-center'],  // Prodi
            7  => ['6%', 'text-center'],  // Status
            8 => ['6%', 'text-wrap'],    // Afiliasi
            9  => ['12%', 'text-wrap'],   // Nama Penulis
            10 => ['6%', 'text-center'],  // DOI
        ];
        // Only add Tindakan column if user is admin
        if (Auth::check() && Auth::user()->aktor_id == '1') {
            $publikasi_columns[11] = ['4%', 'text-center no-export']; // Tindakan
        }
    @endphp
    <x-table.datatable-config tableId="data_publikasi" :hasExport="true"
    />
@endsection
