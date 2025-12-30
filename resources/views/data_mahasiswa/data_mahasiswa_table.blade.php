@extends('template.layout')

@section('page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-end">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Mahasiswa</li>
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
                            <h5 class="card-title">Data Mahasiswa : {{ $jml_mahasiswa }} Data</h5>
                        </div>
                        <div class="card-body">
                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                <ol class="col-12 mt-2 mb-2">
                                    <x-table.button-table title="Data Mahasiswa" data-target-import="#importDataMahasiswa"
                                        data-target-baru="#modal-lg"
                                        href-template="{{ asset('file_mahasiswa/data_mahasiswa_template.xlsx') }}"></x-table.button-table>
                                </ol>
                            @endif
                            <ol class="col-12 mt-2 mb-2">
                                <form action="{{ route('data_mahasiswa_table') }}" method="GET">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-select"
                                                onchange="this.form.submit()">
                                                <option value="">Semua Status</option>
                                                @foreach ($statuses as $s)
                                                    <option value="{{ $s }}" {{ (request('status') == $s) ? 'selected' : '' }}>
                                                        {{ $s }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </ol>
                            <div class="tab-content p-0">
                                <br />
                                <x-table.datatable-wrapper tableId="data_mahasiswa">
                                    <x-slot name="thead">
                                        <tr align="center">
                                            <th class="th-sm">NIM</th>
                                            <th class="th-sm">Nama</th>
                                            <th class="th-sm">Prodi</th>
                                            <th class="th-sm">Status</th>
                                            <th class="th-sm">Angkatan</th>
                                            @if (Auth::check() && Auth::user()->aktor_id == '1')
                                                <th class="th-sm no-export">Tindakan</th>
                                            @endif
                                        </tr>
                                    </x-slot>
                                    @foreach ($data_mahasiswa as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $item->nim ?? '-' }}</td>
                                            <td>{{ $item->nama ?? '-' }}</td>
                                            <td>{{ $item->prodi ?? '-' }}</td>
                                            <td class="text-center">
                                                @php
                                                    $statusBadgeClass = match($item->status) {
                                                        'STUDENT' => 'badge-primary',
                                                        'GRADUATED' => 'badge-success',
                                                        'RESIGNED' => 'badge-danger',
                                                        'RESIGN' => 'badge-danger',
                                                        'NON-ACTIVE' => 'badge-warning',
                                                        'CHANGE MAJOR' => 'badge-info',
                                                        'PASSED AWAY' => 'badge-dark',
                                                        'LEAVE' => 'badge-secondary',
                                                        default => 'badge-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $statusBadgeClass }}">{{ $item->status }}</span>
                                            </td>
                                            <td class="text-center">{{ $item->angkatan ?? '-' }}</td>
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
    <x-modals.import-excel modalId="importDataMahasiswa" title="Data Mahasiswa" action="{{ route('import_data_mahasiswa_table') }}"
        template-url="{{ asset('file_mahasiswa/data_mahasiswa_template.xlsx') }}" template-text="Download Template Excel" />

    <!-- Modal Create -->
    <x-modals.create modalId="modal-lg" title="Tambah Data Mahasiswa Baru" action="{{ route('tambah_data_mahasiswa_table') }}"
        size="lg">
        <div class="card-body">
            <div class="form-group row">
                <label for="nim_create" class="col-sm-2 col-form-label d-flex align-items-center">NIM</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="nim_create" name="nim"
                        placeholder="Isikan NIM" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_create" class="col-sm-2 col-form-label d-flex align-items-center">Nama</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="nama_create" name="nama"
                        placeholder="Isikan Nama Mahasiswa" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="prodi_create" class="col-sm-2 col-form-label d-flex align-items-center">Prodi</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="prodi_create" name="prodi"
                        placeholder="Isikan Program Studi" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="status_create" class="col-sm-2 col-form-label d-flex align-items-center">Status</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <select name="status" id="status_create" class="form-select" required>
                        <option value="">Pilih Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="angkatan_create" class="col-sm-2 col-form-label d-flex align-items-center">Angkatan</label>
                <div class="col-sm-10 d-flex align-items-center">
                    <input type="text" class="form-control" id="angkatan_create" name="angkatan"
                        placeholder="Isikan Angkatan (misal: 2020)" required>
                </div>
            </div>
        </div>
    </x-modals.create>

    <!-- Modal Edit -->
    @foreach ($data_mahasiswa as $item)
        <x-modals.edit modalId="edit{{ $item->id }}" title="Edit Data Mahasiswa" action="{{ route('edit_data_mahasiswa_table') }}"
            size="lg">
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $item->id }}">

                <div class="form-group row">
                    <label for="nim_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">NIM</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="nim_edit{{ $item->id }}" name="nim"
                            placeholder="Isikan NIM" value="{{ $item->nim }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">Nama</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="nama_edit{{ $item->id }}" name="nama"
                            placeholder="Isikan Nama Mahasiswa" value="{{ $item->nama }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="prodi_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">Prodi</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="prodi_edit{{ $item->id }}" name="prodi"
                            placeholder="Isikan Program Studi" value="{{ $item->prodi }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">Status</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <select name="status" id="status_edit{{ $item->id }}" class="form-select" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ $item->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="angkatan_edit{{ $item->id }}" class="col-sm-2 col-form-label d-flex align-items-center">Angkatan</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="angkatan_edit{{ $item->id }}" name="angkatan"
                            placeholder="Isikan Angkatan (misal: 2020)" value="{{ $item->angkatan }}" required>
                    </div>
                </div>
            </div>
        </x-modals.edit>
    @endforeach

    <!-- Modal Delete -->
    @foreach ($data_mahasiswa as $item)
        <x-modals.delete modalId="delete{{ $item->id }}" title="Hapus Data Mahasiswa"
            action="{{ route('hapus_data_mahasiswa_table', $item->id) }}">
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data mahasiswa <strong>{{ $item->nama }} ({{ $item->nim }})</strong>?</p>
            </div>
        </x-modals.delete>
    @endforeach

    <!-- Column Configuration for DataTable -->
    @php
        $mahasiswa_columns = [
            ['8%', 'text-center'],  // NIM
            ['25%', 'text-wrap'],   // Nama
            ['20%', 'text-wrap'],   // Prodi
            ['15%', 'text-center'], // Status
            ['10%', 'text-center'], // Angkatan
        ];
        if (Auth::check() && Auth::user()->aktor_id == '1') {
            $mahasiswa_columns[] = ['7%', 'text-center no-export'];  // Tindakan
        }
    @endphp

    <x-table.datatable-config tableId="data_mahasiswa"/>

@endsection
