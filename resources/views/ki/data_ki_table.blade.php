@extends('template.layout')

@section('page-content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-end">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data KI</li>
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
                                <h5 class="card-title">Data KI :
                                    {{ $jml_ki }}
                                    Data</h5>
                            </div>
                            <div class="card-body">
                                @if (Auth::check() && Auth::user()->aktor_id == '1')
                                    <ol class="col-12 mt-2 mb-2">
                                        <x-table.button-table
                                            title="KI"
                                            data-target-import="#importDataKi"
                                            data-target-baru="#modal-lg"
                                            href-template="{{ asset('file_ki/KI.xlsx') }}"
                                            ></x-table.button-table>
                                    </ol>
                                @endif
                                    <ol class="col-12 mt-2 mb-2">
                                        <form action="{{ route('data_ki_table') }}" method="GET">
                                            <div class="row">
                                                <div class="form-group col-md-2">
                                                    <label for="tahun">Application Year</label>
                                                    <select name="tahun_filter" id="tahun_filter" class="form-select" required onchange="this.form.submit()">
                                                        @foreach ($tahun_filter as $item)
                                                            <option value="{{ $item }}" {{ ($selected_tahun ?? request('tahun_filter')) == $item ? 'selected' : '' }}>{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </ol>
                                <div class="tab-content p-0">
                                    <br />
                                    <x-table.datatable-wrapper tableId="data_ki">
                                        <x-slot name="thead">
                                            <tr align="center">
                                                <th class="th-sm">Application Number</th>
                                                <th class="th-sm">Kategori</th>
                                                <th class="th-sm">Application Year</th>
                                                <th class="th-sm">Title</th>
                                                <th class="th-sm">Jenis HKI</th>
                                                <th class="th-sm">Prototype</th>
                                                <th class="th-sm">Patent Holder</th>
                                                <th class="th-sm">Inventor</th>
                                                <th class="th-sm">Jabatan</th>
                                                <th class="th-sm">Prodi</th>
                                                <th class="th-sm">Publication Number</th>
                                                <th class="th-sm">Publication Date</th>
                                                <th class="th-sm">Filling Date</th>
                                                <th class="th-sm">Reception Date</th>
                                                <th class="th-sm">Registration Date</th>
                                                <th class="th-sm">Registration Number</th>
                                                <th class="th-sm">Status</th>
                                                <th class="th-sm">Nama Anggota</th>
                                                <th class="th-sm">Link</th>
                                                @if (Auth::check() && Auth::user()->aktor_id == '1')
                                                    <th class="th-sm no-export">Tindakan</th>
                                                @endif
                                            </tr>
                                        </x-slot>
                                        @foreach ($ki as $index => $item)
                                            <tr>
                                                <td>{{ $item['application_number'] ?? '-' }}</td>
                                                <td>{{ $item['kategori'] ?? '-' }}</td>
                                                <td>{{ $item['application_year'] ?? '-' }}</td>
                                                <td>{{ $item['title'] ?? '-' }}</td>
                                                <td>{{ $item['jenis_hki'] ?? '-' }}</td>
                                                <td>{{ $item['prototype'] ?? '-' }}</td>
                                                <td>{{ $item['patent_holder'] ?? '-' }}</td>
                                                <td>{{ $item['inventor'] ?? '-' }}</td>
                                                <td>{{ $item['jabatan'] ?? '-' }}</td>
                                                <td>{{ $item['prodi'] ?? '-' }}</td>
                                                @if($item['publication_number'] != null && $item['publication_link'] != null && filter_var($item['publication_link'], FILTER_VALIDATE_URL))
                                                <td><a href="{{ $item['publication_link'] }}" target="_blank" rel="noopener noreferrer">{{ $item['publication_number'] }}</a></td>
                                                @else
                                                <td>{{ $item['publication_number'] ?? '-' }}</td>
                                                @endif
                                                {{-- <td>{{ $item['publication_date'] ? \Carbon\Carbon::parse($item['publication_date'])->format('d-m-Y') : '-' }}</td>
                                                <td>{{ $item['filling_date'] ? \Carbon\Carbon::parse($item['filling_date'])->format('d-m-Y') : '-' }}</td>
                                                <td>{{ $item['reception_date'] ? \Carbon\Carbon::parse($item['reception_date'])->format('d-m-Y') : '-' }}</td>
                                                <td>{{ $item['registration_date'] ? \Carbon\Carbon::parse($item['registration_date'])->format('d-m-Y') : '-' }}</td> --}}
                                                <td>{{ $item['publication_date'] ?? '-' }}</td>
                                                <td>{{ $item['filling_date'] ?? '-' }}</td>
                                                <td>{{ $item['reception_date'] ?? '-' }}</td>
                                                <td>{{ $item['registration_date'] ?? '-' }}</td>
                                                <td>{{ $item['registration_number'] ?? '-' }}</td>
                                                <td>{{ $item['status'] ?? '-' }}</td>
                                                <td>
                                                    {{ collect([
                                                        $item['anggota1'] ?? null,
                                                        $item['anggota2'] ?? null,
                                                        $item['anggota3'] ?? null,
                                                        $item['anggota4'] ?? null,
                                                        $item['anggota5'] ?? null,
                                                        $item['anggota6'] ?? null,
                                                        $item['anggota7'] ?? null,
                                                        $item['anggota8'] ?? null,
                                                        $item['anggota9'] ?? null,
                                                        $item['anggota10'] ?? null,
                                                    ])->filter()->join(', ') ?: '-' }}
                                                </td>
                                                @if($item['link'] != null && filter_var($item['link'], FILTER_VALIDATE_URL))
                                                <td><a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer"><i class="fas fa-file-pdf fs-2 d-flex justify-content-center"></i></a></td>
                                                @else
                                                <td>{{ $item['link'] ?? '-' }}</td>
                                                @endif
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
        <x-modals.import-excel modalId="importDataKi" title="Data KI"
            action="{{ route('import_ki_table') }}"
            template-url="{{ asset('file_ki/KI.xlsx') }}"
            template-text="Download Template Excel" />

        <!-- Modal Create -->
        <x-modals.create modalId="modal-lg" title="Tambah Data KI Baru"
            action="{{ route('tambah_data_ki_table') }}" size="xl">
            <div class="card-body">
                <!-- Basic Information -->
                <div class="form-group row">
                    <label for="application_number_create" class="col-sm-2 col-form-label d-flex align-items-center">Application Number</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <input type="text" class="form-control" id="application_number_create" name="application_number" placeholder="Isikan Application Number">
                    </div>
                    <label for="kategori_create" class="col-sm-1 col-form-label d-flex align-items-center">Kategori</label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <select name="kategori" id="kategori_create" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $ktg)
                                <option value="{{ $ktg->nama_kategori }}">{{ $ktg->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="application_year_create" class="col-sm-2 col-form-label d-flex align-items-center">Application Year</label>
                    <div class="col-sm-2 d-flex align-items-center">
                        <select name="application_year" id="application_year_create" class="form-select" required>
                            <option value="">Pilih Tahun</option>
                            @foreach ($tahun as $thn)
                                <option value="{{ $thn->tahun }}">{{ $thn->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_create" class="col-sm-2 col-form-label d-flex align-items-center">Title</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="title_create" name="title" placeholder="Isikan Title" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_hki_create" class="col-sm-2 col-form-label d-flex align-items-center">Jenis HKI</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="text" class="form-control" id="jenis_hki_create" name="jenis_hki" placeholder="Isikan Jenis HKI" required>
                    </div>
                    <label for="prototype_create" class="col-sm-2 col-form-label d-flex align-items-center">Prototype</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="text" class="form-control" id="prototype_create" name="prototype" placeholder="Isikan Prototype">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="patent_holder_create" class="col-sm-2 col-form-label d-flex align-items-center">Patent Holder</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="text" class="form-control" id="patent_holder_create" name="patent_holder" placeholder="Isikan Patent Holder">
                    </div>
                    <label for="inventor_create" class="col-sm-2 col-form-label d-flex align-items-center">Inventor</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="text" class="form-control" id="inventor_create" name="inventor" placeholder="Isikan Inventor">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jabatan_create" class="col-sm-2 col-form-label d-flex align-items-center">Jabatan</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <select name="jabatan" id="jabatan_create" class="form-select">
                            <option value="">Pilih Status/Jabatan</option>
                            <option value="dosen">Dosen</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="staff">Staff</option>
                            <option value="eksternal">Eksternal</option>
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
                    <label for="publication_link_create" class="col-sm-2 col-form-label d-flex align-items-center">Publication Link</label>
                    <div class="col-sm-6 d-flex align-items-center">
                        <input type="text" class="form-control" id="publication_link_create" name="publication_link" placeholder="Isikan Publication Link">
                    </div>
                    <label for="publication_number_create" class="col-sm-1 col-form-label d-flex align-items-center">Publication Number</label>
                    <div class="col-sm-3 d-flex align-items-center">
                        <input type="text" class="form-control" id="publication_number_create" name="publication_number" placeholder="Isikan Publication Number">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="publication_date_create" class="col-sm-2 col-form-label d-flex align-items-center">Publication Date</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="date" class="form-control" id="publication_date_create" name="publication_date">
                    </div>
                    <label for="filling_date_create" class="col-sm-2 col-form-label d-flex align-items-center">Filling Date</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="date" class="form-control" id="filling_date_create" name="filling_date">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="reception_date_create" class="col-sm-2 col-form-label d-flex align-items-center">Reception Date</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="date" class="form-control" id="reception_date_create" name="reception_date">
                    </div>
                    <label for="registration_date_create" class="col-sm-2 col-form-label d-flex align-items-center">Registration Date</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="date" class="form-control" id="registration_date_create" name="registration_date">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="registration_number_create" class="col-sm-2 col-form-label d-flex align-items-center">Registration Number</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="text" class="form-control" id="registration_number_create" name="registration_number" placeholder="Isikan Registration Number">
                    </div>
                    <label for="status_create" class="col-sm-2 col-form-label d-flex align-items-center">Status</label>
                    <div class="col-sm-4 d-flex align-items-center">
                        <input type="text" class="form-control" id="status_create" name="status" placeholder="Isikan Status">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="link_create" class="col-sm-2 col-form-label d-flex align-items-center">Link</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <input type="text" class="form-control" id="link_create" name="link" placeholder="Isikan Link Dokumen">
                    </div>
                </div>


                <!-- Anggota Fields -->
                <hr>
                <h5 class="font-weight-bold d-flex justify-content-center">Data Anggota</h5>
                <div class="container">
                    <div class="row">
                        @for ($i = 1; $i <= 12; $i++)
                            <div class="col-md-4 mb-4">
                                <fieldset class="form-group border p-3 h-100">
                                    <legend class="w-auto px-2 font-weight-bold">Anggota {{ $i }}</legend>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="anggota_{{ $i }}_create"
                                            name="anggota_{{ $i }}" placeholder="Nama Anggota {{ $i }}">
                                    </div>
                                    <div class="form-group">
                                        <select name="status_anggota_{{ $i }}" id="status_anggota_{{ $i }}_create" class="form-select">
                                            <option value="">Pilih Status/Jabatan</option>
                                            <option value="dosen">Dosen</option>
                                            <option value="mahasiswa">Mahasiswa</option>
                                            <option value="staff">Staff</option>
                                            <option value="eksternal">Eksternal</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="prodi_{{ $i }}" id="prodi_{{ $i }}_create" class="form-select">
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

            </div>
        </x-modals.create>

        <!-- Edit Modals -->
        @foreach ($ki as $item)
            <x-modals.edit modalId="edit{{ $item['id'] }}" title="Edit Data KI"
                action="{{ route('edit_data_ki_table') }}" size="xl">
                <div class="card-body">
                    <!-- Basic Information -->
                    <div class="form-group row">
                        <label for="application_number_edit" class="col-sm-2 col-form-label d-flex align-items-center">Application Number</label>
                        <div class="col-sm-2 d-flex align-items-center">
                            <input type="text" class="form-control" id="application_number_edit" name="application_number" value="{{ $item['application_number'] }}">
                        </div>
                        <label for="kategori_edit" class="col-sm-2 col-form-label d-flex align-items-center">Kategori</label>
                        <div class="col-sm-2 d-flex align-items-center">
                            <select name="kategori" id="kategori_edit" class="form-select" required>
                                @if(empty($item['kategori']))
                                    <option value="">Pilih Kategori</option>
                                @endif
                                @foreach ($kategori as $ktg)
                                    <option value="{{ $ktg->nama_kategori }}" {{ ($item['kategori'] == $ktg->nama_kategori) ? 'selected' : '' }}>{{ $ktg->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="application_year_edit" class="col-sm-2 col-form-label d-flex align-items-center">Application Year</label>
                        <div class="col-sm-2 d-flex align-items-center">
                            <select name="application_year" id="application_year_edit" class="form-select" required>
                                @if(empty($item['application_year']))
                                    <option value="">Pilih Tahun</option>
                                @endif
                                @foreach ($tahun as $thn)
                                    <option value="{{ $thn->tahun }}" {{ ($item['application_year'] == $thn->tahun) ? 'selected' : '' }}>{{ $thn->tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="title_edit" class="col-sm-2 col-form-label d-flex align-items-center">Title</label>
                        <div class="col-sm-10 d-flex align-items-center">
                            <input type="text" class="form-control" id="title_edit" name="title" value="{{ $item['title'] }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jenis_hki_edit" class="col-sm-2 col-form-label d-flex align-items-center">Jenis HKI</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="text" class="form-control" id="jenis_hki_edit" name="jenis_hki" value="{{ $item['jenis_hki'] }}" required>
                        </div>
                        <label for="prototype_edit" class="col-sm-2 col-form-label d-flex align-items-center">Prototype</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="text" class="form-control" id="prototype_edit" name="prototype" value="{{ $item['prototype'] }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="patent_holder_edit" class="col-sm-2 col-form-label d-flex align-items-center">Patent Holder</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="text" class="form-control" id="patent_holder_edit" name="patent_holder" value="{{ $item['patent_holder'] }}">
                        </div>
                        <label for="inventor_edit" class="col-sm-2 col-form-label d-flex align-items-center">Inventor</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="text" class="form-control" id="inventor_edit" name="inventor" value="{{ $item['inventor'] }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jabatan_edit" class="col-sm-2 col-form-label d-flex align-items-center">Jabatan</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <select name="jabatan" id="jabatan_edit" class="form-select">
                                @if(empty($item['jabatan']))
                                    <option value="">Pilih Status/Jabatan</option>
                                @endif
                                <option value="dosen" {{ strtolower($item['jabatan']) == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="mahasiswa" {{ strtolower($item['jabatan']) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="staff" {{ strtolower($item['jabatan']) == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="eksternal" {{ strtolower($item['jabatan']) == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
                            </select>
                        </div>
                        <label for="prodi_edit" class="col-sm-2 col-form-label d-flex align-items-center">Prodi</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <select name="prodi" id="prodi_edit" class="form-select" required>
                                @if(empty($item['prodi']))
                                    <option value="">Pilih Prodi</option>
                                @else
                                    <option value="{{ $item['prodi'] }}">{{ $item['prodi'] }}</option>
                                @endif
                                @foreach ($jurusan as $jrs)
                                    <option value="{{ $jrs->nama_jurusan }}" {{ $item['prodi'] == $jrs->nama_jurusan ? 'selected' : '' }}>{{ $jrs->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="publication_number_edit" class="col-sm-2 col-form-label d-flex align-items-center">Publication Number</label>
                        <div class="col-sm-5 d-flex align-items-center">
                            <input type="text" class="form-control" id="publication_number_edit" name="publication_number" value="{{ $item['publication_number'] }}">
                        </div>
                        <label for="publication_link_edit" class="col-sm-2 col-form-label d-flex align-items-center">Publication Link</label>
                        <div class="col-sm-3 d-flex align-items-center">
                            <input type="text" class="form-control" id="publication_link_edit" name="publication_link" value="{{ $item['publication_link'] }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="publication_date_edit" class="col-sm-2 col-form-label d-flex align-items-center">Publication Date</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="date" class="form-control" id="publication_date_edit" name="publication_date" value="{{ $item['publication_date'] ?? '' }}">
                        </div>
                        <label for="filling_date_edit" class="col-sm-2 col-form-label d-flex align-items-center">Filling Date</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="date" class="form-control" id="filling_date_edit" name="filling_date" value="{{ $item['filling_date'] ?? '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reception_date_edit" class="col-sm-2 col-form-label d-flex align-items-center">Reception Date</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="date" class="form-control" id="reception_date_edit" name="reception_date" value="{{ $item['reception_date'] ?? '' }}">
                        </div>
                        <label for="registration_date_edit" class="col-sm-2 col-form-label d-flex align-items-center">Registration Date</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="date" class="form-control" id="registration_date_edit" name="registration_date" value="{{ $item['registration_date'] ?? '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="registration_number_edit" class="col-sm-2 col-form-label d-flex align-items-center">Registration Number</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="text" class="form-control" id="registration_number_edit" name="registration_number" value="{{ $item['registration_number'] }}">
                        </div>
                        <label for="status_edit" class="col-sm-2 col-form-label d-flex align-items-center">Status</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <input type="text" class="form-control" id="status_edit" name="status" value="{{ $item['status'] }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="link_edit" class="col-sm-2 col-form-label d-flex align-items-center">Link</label>
                        <div class="col-sm-10 d-flex align-items-center">
                            <input type="text" class="form-control" id="link_edit" name="link" value="{{ $item['link'] }}" placeholder="Isikan Link Dokumen">
                        </div>
                    </div>

                    <!-- Anggota Fields -->
                    <hr>
                    <h5 class="font-weight-bold d-flex justify-content-center">Data Anggota</h5>
                    <div class="container">
                        <div class="row">
                            @for ($i = 1; $i <= 12; $i++)
                                <div class="col-md-4 mb-4">
                                    <fieldset class="form-group border p-3 h-100">
                                        <legend class="w-auto px-2 font-weight-bold">Anggota {{ $i }}</legend>
                                        <div class="form-group mb-2">
                                            <input type="text" class="form-control" id="anggota_{{ $i }}" name="anggota_{{ $i }}"
                                                value="{{ $item['anggota' . $i] ?? '' }}" placeholder="Nama Anggota">
                                        </div>

                                        <div class="form-group mb-2">
                                            <select name="status_anggota_{{ $i }}" id="status_anggota_{{ $i }}" class="form-select">
                                                @if(empty($item['status_anggota' . $i]))
                                                    <option value="">Pilih Status/Jabatan</option>
                                                @endif
                                                <option value="dosen" {{ (strtolower($item['status_anggota' . $i]) ?? '') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                                <option value="mahasiswa" {{ (strtolower($item['status_anggota' . $i]) ?? '') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                                <option value="staff" {{ (strtolower($item['status_anggota' . $i]) ?? '') == 'staff' ? 'selected' : '' }}>Staff</option>
                                                <option value="eksternal" {{ (strtolower($item['status_anggota' . $i]) ?? '') == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <select name="prodi_{{ $i }}" id="prodi_{{ $i }}_edit" class="form-select">
                                                @if(empty($item['prodi' . $i]))
                                                    <option value="">Pilih Prodi</option>
                                                @else
                                                    <option value="{{ $item['prodi' . $i] }}">{{ $item['prodi' . $i] }}</option>
                                                @endif
                                                @foreach ($jurusan as $jrs)
                                                    <option value="{{ $jrs->nama_jurusan }}" {{ $item['prodi' . $i] == $jrs->nama_jurusan ? 'selected' : '' }}>{{ $jrs->nama_jurusan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{ $item['id'] }}">
            </x-modals.edit>

            <x-modals.delete modalId="delete{{ $item['id'] }}"
                message="Apakah Anda yakin ingin menghapus data ini?"
                action="{{ route('hapus_data_ki_table', $item['id']) }}" />
        @endforeach

    <!-- DataTable Configuration -->
    @php
        $ki_columns = [
            0  => ['5%', 'text-center'],   // Application Number
            1  => ['5%', 'text-center'],   // Kategori
            2  => ['4%', 'text-center'],   // Application Year
            3  => ['20%', 'text-wrap'],    // Title (allow wrap, wider)
            4  => ['6%', 'text-center'],   // Jenis HKI
            5  => ['6%', 'text-center'],   // Prototype
            6  => ['8%', 'text-wrap'],     // Patent Holder
            7  => ['8%', 'text-wrap'],     // Inventor
            8  => ['6%', 'text-center'],   // Jabatan
            9  => ['6%', 'text-center'],   // Prodi
            10 => ['7%', 'text-center'],   // Publication Number
            11 => ['6%', 'text-center'],   // Publication Date
            12 => ['6%', 'text-center'],   // Filling Date
            13 => ['6%', 'text-center'],   // Reception Date
            14 => ['6%', 'text-center'],   // Registration Date
            15 => ['8%', 'text-center'],   // Registration Number
            16 => ['6%', 'text-center'],   // Status
            17 => ['12%', 'text-wrap'],    // Nama Anggota
            18 => ['4%', 'text-center'],   // Link
        ];
        // Only add Tindakan column if user is admin
        if (Auth::check() && Auth::user()->aktor_id == '1') {
            $ki_columns[19] = ['3%', 'text-center no-export']; // Tindakan (Edit/Hapus)
        }
    @endphp
    <x-table.datatable-config tableId="data_ki" :hasExport="true"
        :columns="$ki_columns"
    />
@endsection
