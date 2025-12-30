@extends('template.layout')

@section('page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-end">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Dosen</li>
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
                            <h5 class="card-title">Data Dosen : {{ $jml_dosen }} Data</h5>
                        </div>
                        <div class="card-body">
                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                <ol class="col-12 mt-2 mb-2">
                                    <x-table.button-table title="Data Dosen" data-target-import="#importDataDosen"
                                        data-target-baru="#modal-lg"
                                        href-template="{{ asset('file_dosen/data_dosen_template.xlsx') }}"></x-table.button-table>
                                </ol>
                            @endif
                            <ol class="col-12 mt-2 mb-2">
                                <form action="{{ route('data_dosen_table') }}" method="GET">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="status_aktif">Status</label>
                                            <select name="status_aktif" id="status_aktif" class="form-select"
                                                onchange="this.form.submit()">
                                                <option value="">Semua Status</option>
                                                <option value="1" {{ (request('status_aktif') == '1') ? 'selected' : '' }}>
                                                    Aktif</option>
                                                <option value="0" {{ (request('status_aktif') == '0') ? 'selected' : '' }}>
                                                    Non-Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </ol>
                            <div class="tab-content p-0">
                                <br />
                                <x-table.datatable-wrapper tableId="data_dosen">
                                    <x-slot name="thead">
                                        <tr align="center">
                                            <th class="th-sm">Nama Dosen</th>
                                            <th class="th-sm">Status</th>
                                            <th class="th-sm">Prodi</th>
                                            <th class="th-sm">NIP YPT</th>
                                            <th class="th-sm">NIDN</th>
                                            <th class="th-sm">COE</th>
                                            <th class="th-sm">KK</th>
                                            <th class="th-sm">Kode</th>
                                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                                <th class="th-sm no-export">Tindakan</th>
                                            @endif
                                        </tr>
                                    </x-slot>
                                    @foreach ($data_dosen as $index => $item)
                                        <tr>
                                            <td>{{ $item->nama_dosen ?? '-' }}</td>
                                            <td class="text-center">
                                                @if ($item->status_aktif)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-danger">Non-Aktif</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->prodi ?? '-' }}</td>
                                            <td class="text-center">{{ $item->nip ?? '-' }}</td>
                                            <td class="text-center">{{ $item->nidn ?? '-' }}</td>
                                            <td>{{ $item->coe ?? '-' }}</td>
                                            <td>{{ $item->kk ?? '-' }}</td>
                                            <td class="text-center">{{ $item->kode ?? '-' }}</td>
                                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                                <td class="project-actions text-center">
                                                    <a class="btn btn-info btn-sm" href="#" data-toggle="modal"
                                                        data-target="#edit{{ $item->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal"
                                                        data-target="#delete{{ $item->id }}">
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
    <x-modals.import-excel modalId="importDataDosen" title="Data Dosen" action="{{ route('import_data_dosen_table') }}"
        template-url="{{ asset('file_dosen/data_dosen_template.xlsx') }}" template-text="Download Template Excel" />

    <!-- Modal Create -->
    <x-modals.create modalId="modal-lg" title="Tambah Data Dosen Baru" action="{{ route('tambah_data_dosen_table') }}"
        size="lg">
        <div class="card-body">
            <div class="form-group row">
                <label for="nama_dosen_create" class="col-sm-2 col-form-label d-flex align-items-center">Nama Dosen</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="nama_dosen_create" name="nama_dosen"
                        placeholder="Isikan Nama Dosen" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="status_aktif_create" class="col-sm-2 col-form-label d-flex align-items-center">Status</label>
                <div class="col-sm-4 d-flex align-items-center">
                    <select name="status_aktif" id="status_aktif_create" class="form-select" required>
                        <option value="">Pilih Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Non-Aktif</option>
                    </select>
                </div>
                <label for="prodi_create" class="col-sm-2 col-form-label d-flex align-items-center">Prodi</label>
                <div class="col-sm-4 d-flex align-items-center">
                    <select name="prodi" id="prodi_create" class="form-select" required>
                        <option value="">Pilih Prodi</option>
                        @foreach ($jurusan as $jrs)
                            <option value="{{ $jrs->nama_jurusan }}">{{ $jrs->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="nip_create" class="col-sm-2 col-form-label d-flex align-items-center">NIP</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <input type="text" class="form-control" id="nip_create" name="nip" placeholder="Isikan NIP" required>
                    @error('nip')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <label for="nidn_create" class="col-sm-1 col-form-label d-flex align-items-center">NIDN</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input type="text" class="form-control" id="nidn_create" name="nidn" placeholder="Isikan NIDN" required>
                    @error('nidn')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <label for="kode_create" class="col-sm-2 col-form-label d-flex align-items-center">Kode</label>
                <div class="col-sm-2 d-flex align-items-center">
                    <input type="text" class="form-control" id="kode_create" name="kode" placeholder="Isikan Kode">
                </div>
            </div>

            <div class="form-group row">
                <label for="coe_create" class="col-sm-2 col-form-label d-flex align-items-center">COE</label>
                <div class="col-sm-4 d-flex align-items-center">
                    <select name="coe" id="coe_create" class="form-select">
                        <option value="">Pilih CoE</option>
                        @foreach ($coe as $c)
                            <option value="{{ $c->nama_coe }}">{{ $c->nama_coe }}</option>
                        @endforeach
                    </select>
                </div>
                <label for="kk_create" class="col-sm-2 col-form-label d-flex align-items-center">KK</label>
                <div class="col-sm-4 d-flex align-items-center">
                    <select name="kk" id="kk_create" class="form-select">
                        <option value="">Pilih KK</option>
                        @foreach ($kk as $k)
                            <option value="{{ $k->nama_kk }}">{{ $k->nama_kk }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </x-modals.create>

    <!-- Modal Edit -->
    @foreach ($data_dosen as $item)
        <x-modals.edit modalId="edit{{ $item->id }}" title="Edit Data Dosen" action="{{ route('edit_data_dosen_table') }}"
            size="lg">
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $item->id }}">

                <div class="form-group row">
                    <label for="nama_dosen_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">Nama
                        Dosen</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="nama_dosen_edit{{ $item->id }}" name="nama_dosen"
                            placeholder="Isikan Nama Dosen" value="{{ $item->nama_dosen }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status_aktif_edit{{ $item->id }}"
                        class="col-sm-2 col-form-label d-flex align-items-center">Status</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <select name="status_aktif" id="status_aktif_edit{{ $item->id }}" class="form-select" required>
                            @if(empty($item->status_aktif))
                                <option value="">Pilih Status</option>
                            @endif
                            <option value="1" {{ $item->status_aktif == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $item->status_aktif == 0 ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                    <label for="prodi_edit{{ $item->id }}"
                        class="col-sm-2 col-form-label d-flex align-items-center">Prodi</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <select name="prodi" id="prodi_edit{{ $item->id }}" class="form-select" required>
                            @if(empty($item->prodi))
                                <option value="">Pilih Prodi</option>
                            @endif
                            @foreach ($jurusan as $jrs)
                                <option value="{{ $jrs->nama_jurusan }}" {{ $item->prodi == $jrs->nama_jurusan ? 'selected' : '' }}>{{ $jrs->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nip_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">NIP</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <input type="text" class="form-control" id="nip_edit{{ $item->id }}" name="nip" placeholder="Isikan NIP"
                            value="{{ $item->nip }}" required>
                        @error('nip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <label for="nidn_edit{{ $item->id }}" class="col-sm-1 col-form-label d-flex align-items-center">NIDN</label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <input type="text" class="form-control" id="nidn_edit{{ $item->id }}" name="nidn"
                            placeholder="Isikan NIDN" value="{{ $item->nidn }}" required>
                        @error('nidn')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <label for="kode_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">Kode</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <input type="text" class="form-control" id="kode_edit{{ $item->id }}" name="kode"
                            placeholder="Isikan Kode" value="{{ $item->kode }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="coe_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">COE</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <select name="coe" id="coe_edit{{ $item->id }}" class="form-select">
                            <option value="">Pilih CoE</option>
                            @foreach ($coe as $c)
                                <option value="{{ $c->nama_coe }}" {{ $item->coe == $c->nama_coe ? ' selected' : '' }}>{{ $c->nama_coe }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="kk_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">KK</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <select name="kk" id="kk_edit{{ $item->id }}" class="form-select">
                            @if(empty($item->kk))
                                <option value="">Pilih KK</option>
                            @endif
                            @foreach ($kk as $k)
                                <option value="{{ $k->nama_kk }}" {{ $item->kk == $k->nama_kk ? ' selected' : '' }}>{{ $k->nama_kk }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </x-modals.edit>
    @endforeach

    <!-- Modal Delete -->
    @foreach ($data_dosen as $item)
        <x-modals.delete modalId="delete{{ $item->id }}" title="Hapus Data Dosen"
            action="{{ route('hapus_data_dosen_table', $item->id) }}">
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data dosen <strong>{{ $item->nama_dosen }}</strong>?</p>
            </div>
        </x-modals.delete>
    @endforeach

    <!-- Column Configuration for DataTable -->
    @php
        $dosen_columns = [
            ['20%', 'text-wrap'],  // Nama Dosen
            ['8%', 'text-center'],  // Status
            ['12%', 'text-wrap'],   // Prodi
            ['8%', 'text-center'],  // NIP
            ['8%', 'text-center'],  // NIDN
            ['6%', 'text-center'],  // COE
            ['8%', 'text-center'],  // KK
            ['6%', 'text-center'],  // Kode
        ];
        if (Auth::check() && Auth::user()->aktor_id == '1') {
            $dosen_columns[10] = ['5%', 'text-center no-export'];  // Tindakan
        }
    @endphp

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#modal-lg').modal('show');
        });
    </script> --}}
    {{-- @if ($errors->any())
    @foreach ($data_dosen as $item)
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('#modal-lg').modal('show');
            });
        </script>
    @endforeach
    @endif --}}

    <x-table.datatable-config tableId="data_dosen"/>

@endsection
