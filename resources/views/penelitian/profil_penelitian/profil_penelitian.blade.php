@extends('template.layout')

@section('page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Program Penelitian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Program Penelitian </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">

        <section class="content">
            <br>
            <div class="card">
                <div class="card-body row">
                    <div class="col-5 justify-content-center">
                        <img src="/assets/img/penelitian/program.jpg" style="width: 100%" alt="">

                    </div>
                    <div class="col-7" style="text-align: justify">
                        <h1 style="text-align: center">
                            <strong>Rencana Strategis Penelitian</strong>
                        </h1>
                        Institut Teknologi Telkom Surabaya berkomitmen untuk melaksanakan penelitian yang berkesinambungan
                        searah dengan cita-cita institusi untuk menjadi perguruan tinggi mandiri dan sebagai pusat unggulan
                        di bidang sains, teknologi, rekayasa, dan matematika berbasis ICT. Guna mewujudkan cita-cita
                        tersebut, telah disusun Rencana Induk Penelitian (RIP) 2019-2023 sebagai kebijakan strategis dalam
                        perencanaan dan pengelolaan kegiatan penelitian dalam kurun waktu 5 tahun kedepan. RIP bertujuan
                        untuk mensinergikan arah penelitian para sivitas akademika dan sekaligus menumbuhkembangkan budaya
                        riset yang menjunjung tinggi etika, integritas, dan nilai budaya di lingkungan ITTelkom Surabaya.
                    </div>
                </div>
            </div>
        </section>
        <br>
        <div class="wrapper" style="margin-bottom: -15%">
            <div class="svg-container">
                <svg version="1.1" viewBox="0 0 500 500" preserveAspectRatio="xMinYMin meet" class="svg-content">

                    <defs>
                        <marker id="arrow" markerWidth="4" markerHeight="10" viewBox="-2 -4 4 4" refX="0"
                            refY="0" markerUnits="strokeWidth" orient="auto">
                            <polyline points="2,-2 0,0 2,2" stroke="#443c3d" stroke-width="0.75px" fill="none" />
                        </marker>
                    </defs>


                    <g class="box-group">
                        <g transform="translate(-5)">
                            <circle fill="#000" cx="55" cy="50" r="35" opacity="1" />
                            <text x="28" y="58" font-family="Open Sans Condensed" font-size="17"
                                stroke="none" fill="#f5f3e7" font-weight="100"
                                style="text-transform:uppercase; letter-spacing: 1px">Start</text>
                            <line x1="102" x2="135" y1="50" y2="50" stroke-width="2"
                                stroke="#443c3d" stroke-dasharray="2,1" />
                        </g>

                        <line x1="100" x2="100" y1="50" y2="50" stroke-width="2" stroke="#443c3d"
                            stroke-dasharray="2,1" />

                        <g transform="translate(136)">
                            <rect fill="#66cc00" x="2" y="25" rx="3" ry="3" width="100"
                                height="50" />
                            <a class="btn btn-outline-danger" href="#" data-toggle="modal" data-target="#sosialisasi">
                                 <text
                                    x="7" y="47" font-family="Open Sans Condensed" font-size="13"
                                    stroke="none" fill="#f5f3e7" font-weight="900"
                                    style="text-transform:uppercase; letter-spacing: 1px">Sosialisasi
                                    <tspan x="5" dy="12" style="font-size: 7">Panduan Penelitian </tspan>
                                </text>
                            </a>
                            {{-- <a href="" class="btn btn-lg btn-primary"></a> --}}
                        </g>

                        <line x1="240" x2="268" y1="50" y2="50" stroke-width="2" stroke="#443c3d"
                            stroke-dasharray="2,1" />

                        <g transform="translate(268)">
                            <rect fill="#66cc00" x="2" y="25" rx="3" ry="3"
                                width="230" height="50" />
                            <a class="btn btn-outline-danger" href="#" data-toggle="modal" data-target="#hibah">
                                <text x="16" y="47" font-family="Open Sans Condensed" font-size="10.5"
                                    stroke="none" fill="#f5f3e7" font-weight="900"
                                    style="text-transform:uppercase; letter-spacing: 1px">Penerimaan
                                    Pengajuan Hibah
                                    <tspan x="26" dy="17">Penelitian Dana Internal</tspan>
                                </text>
                            </a>
                        </g>


                    </g>

                    <line x1="450" x2="450" y1="77" y2="124" stroke-width="2"
                        stroke="#443c3d" stroke-dasharray="2,1" />

                    <g class="box-group" transform="translate(0,100)">
                        <g transform="translate(5)">
                            <rect fill="orange" x="2" y="25" rx="3" ry="3"
                                width="95" height="50" />
                            <a class="btn btn-outline-danger" href="#" data-toggle="modal"
                                data-target="#pemenang">
                                <text x="16" y="47" font-family="Open Sans Condensed" font-size="10"
                                    stroke="none" fill="#f5f3e7" font-weight="900"
                                    style="text-transform:uppercase; letter-spacing: 1px">Penetapan
                                    <tspan x="20" dy="17" style="font-size: 9">Pemenang</tspan>
                                </text>
                            </a>
                        </g>

                        <line x1="110" x2="136" y1="50" y2="50" stroke-width="2"
                            stroke="#443c3d" stroke-dasharray="2,1" />

                        <g transform="translate(136)">
                            <rect fill="#66cc00" x="2" y="25" rx="3" ry="3"
                                width="162" height="50" />
                            <a class="btn btn-outline-danger" href="#" data-toggle="modal" data-target="#pleno">
                                <text x="16" y="47" font-family="Open Sans Condensed" font-size="10"
                                    stroke="none" fill="#f5f3e7" font-weight="900"
                                    style="text-transform:uppercase; letter-spacing: 1px">Seminar Pembahasan
                                    <tspan x="30" dy="17" style="font-size: 9">Proposal (Pleno)</tspan>
                                </text>
                            </a>
                        </g>



                        <line x1="300" x2="400" y1="50" y2="50" stroke-width="2"
                            stroke="#443c3d" stroke-dasharray="2,1" marker-start="url(#arrow)" />

                        <g transform="translate(400)">
                            <rect fill="orange" x="-60" y="25" rx="3" ry="3"
                                width="160" height="50" />
                            <a class="btn btn-outline-danger" href="#" data-toggle="modal"
                                data-target="#evaluation">
                                <text x="-40" y="55" font-family="Open Sans Condensed" font-size="12"
                                    stroke="none" fill="#f5f3e7" font-weight="900"
                                    style="text-transform:uppercase; letter-spacing: 1px; padding-top:100%">Desk Evaluation
                                </text>
                            </a>
                        </g>
                    </g>

                    <line x1="50" x2="50" y1="177" y2="224" stroke-width="2"
                        stroke="#443c3d" stroke-dasharray="2,1" />

                    <g class="box-group" transform="translate(0,200)">
                        <g transform="translate(5)">
                            <rect fill="#66cc00" x="2" y="25" rx="3" ry="3"
                                width="95" height="50" />
                            <a class="btn btn-outline-danger" href="#" data-toggle="modal" data-target="#kontrak">
                                <text x="16" y="47" font-family="Open Sans Condensed" font-size="12"
                                    stroke="none" fill="#f5f3e7" font-weight="900"
                                    style="text-transform:uppercase; letter-spacing: 1px">Kontrak
                                    <tspan x="18" dy="17" style="font-size: 9">Penelitian</tspan>
                                </text>
                            </a>
                        </g>

                        <line x1="105" x2="136" y1="50" y2="50" stroke-width="2"
                            stroke="#443c3d" stroke-dasharray="2,1" />

                        <g transform="translate(136)">
                            <rect fill="#66cc00" x="2" y="25" rx="3" ry="3"
                                width="95" height="50" />
                            <a class="btn btn-outline-danger" href="#" data-toggle="modal"
                                data-target="#kemajuan">
                                <text x="16" y="47" font-family="Open Sans Condensed" font-size="12"
                                    stroke="none" fill="#f5f3e7" font-weight="900"
                                    style="text-transform:uppercase; letter-spacing: 1px">Laporan
                                    <tspan x="19" dy="17" style="font-size: 9">Kemajuan</tspan>
                                </text>
                            </a>
                        </g>

                        <line x1="235" x2="268" y1="50" y2="50" stroke-width="2"
                            stroke="#443c3d" stroke-dasharray="2,1" />

                        <g transform="translate(268)">
                            <rect fill="#66cc00" x="2" y="25" rx="3" ry="3"
                                width="95" height="50" />
                            <a class="btn btn-outline-danger" href="#" data-toggle="modal" data-target="#akhir">
                                <text x="16" y="47" font-family="Open Sans Condensed" font-size="12"
                                    stroke="none" fill="#f5f3e7" font-weight="900"
                                    style="text-transform:uppercase; letter-spacing: 1px">Laporan
                                    <tspan x="30" dy="17" style="font-size: 9">Akhir</tspan>
                                </text>
                            </a>
                        </g>


                        <line x1="365" x2="415" y1="50" y2="50" stroke-width="2"
                            stroke="#443c3d" stroke-dasharray="2,1" />

                        <g transform="translate(392)">
                            <circle fill="#000" cx="55" cy="50" r="35" opacity="1" />
                            <text x="35" y="58" font-family="Open Sans Condensed" font-size="22"
                                stroke="none" fill="#f5f3e7" font-weight="100"
                                style="text-transform:uppercase; letter-spacing: 1px">End</text>
                        </g>
                    </g>

                </svg>
            </div>
            <div class="card" style="text-align: center">
                <div class="card-header">
                    <h3 >Template Dokumen Lain</h3>
                </div>
                <div class="card-content" style="margin: 2%">
                    <a class="btn btn-primary" target="_blank" href="https://docs.google.com/spreadsheets/d/1rUmatO-HwO-XUz8HNfezaIaOGUDhrgoq/edit?usp=drive_web&ouid=113387123707045224599&rtpof=true" style="width: 22%; height: 30%">Template Honor</a>
                    <a class="btn btn-success" target="_blank" href="#" style="width: 22%; height: 30%">Template Presensi </a>
                    <a class="btn btn-warning" target="_blank" href="#" style="width: 22%; height: 30%">Template Pergantian Anggota </a>
                    <a class="btn btn-danger" target="_blank" href="https://docs.google.com/spreadsheets/d/1FSb1YlSbO-PyT2V0XMMNZNZvZpuRCFBK/edit#gid=1306038987" style="width: 22%; height: 30%">Template Pembayaran Dana </a>

                </div>

            </div>
        </div>
        <br>
        <br>
        <div id="akhir" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content" style="text-align: center">
                    <div class="modal-header" style="text-align: center;">
                        <h4 class="modal-title" style="margin-left: 22%">Tahapan Laporan Akhir</h4>
                        {{-- <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button> --}}
                    </div>
                    <div class="modal-body">
                        <a class="btn btn-block btn-primary" target="_blank" href="">SOP Tindak Lanjut Hasil
                            Penelitian</a>
                        <a class="btn btn-block btn-warning" target="_blank" href="">Template Laporan Akhir</a>
                        <a class="btn btn-block btn-warning" target="_blank"
                            href="https://docs.google.com/document/d/1oxPSaQYi4rWQzEREQtf7OZMKJ3y8gSkV/edit?usp=sharing&ouid=113387123707045224599&rtpof=true&sd=true">Template
                            Log Book</a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="kemajuan" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content" style="text-align: center">
                    <div class="modal-header" style="text-align: center;">
                        <h4 class="modal-title" style="margin-left: 22%">Tahapan Laporan Kemajuan</h4>

                    </div>
                    <div class="modal-body">
                        <a class="btn btn-block btn-primary" target="_blank" href="">SOP Seminar Hasil
                            Penelitian</a>
                        <a class="btn btn-block btn-warning" target="_blank" href="">Template Laporan Kemajuan</a>
                        <a class="btn btn-block btn-warning" target="_blank"
                            href="https://docs.google.com/document/d/1oxPSaQYi4rWQzEREQtf7OZMKJ3y8gSkV/edit?usp=sharing&ouid=113387123707045224599&rtpof=true&sd=true">Template
                            Log Book</a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="kontrak" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content" style="text-align: center">
                    <div class="modal-header" style="text-align: center;">
                        <h4 class="modal-title" style="margin-left: 20%">Tahapan Kontrak Penelitian</h4>

                    </div>
                    <div class="modal-body">
                        <a class="btn btn-block btn-primary" target="_blank" href="">SOP Kontrak penelitian</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="pemenang" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content" style="text-align: center">
                    <div class="modal-header" style="text-align: center;">
                        <h4 class="modal-title" style="margin-left: 20%">Tahapan Penetapan Pemenang</h4>

                    </div>
                    <div class="modal-body">
                        <a class="btn btn-block btn-primary" target="_blank" href="">SOP Penetapan Pemenang</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="pleno" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content" style="text-align: center">
                    <div class="modal-header" style="text-align: center;">
                        <h4 class="modal-title" style="margin-left: 0%">Tahapan Seminar Pembahasan Proposal (Pleno)</h4>

                    </div>
                    <div class="modal-body">
                        <a class="btn btn-block btn-primary" target="_blank" href="">SOP Seminar Pembahasan
                            Proposal</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="evaluation" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content" style="text-align: center">
                    <div class="modal-header" style="text-align: center;">
                        <h4 class="modal-title" style="margin-left: 20%">Tahapan Desk Evaluation</h4>

                    </div>
                    <div class="modal-body">
                        <a class="btn btn-block btn-primary" target="_blank" href="">SOP Desk Evaluation</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="hibah" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content" style="text-align: center">
                    <div class="modal-header" style="text-align: center;">
                        <h4 class="modal-title" style="margin-left: 0%">Tahapan Penerimaan Pengajuan Hibah Penelitian Dana
                            Internal</h4>

                    </div>
                    <div class="modal-body">
                        <a class="btn btn-block btn-success" target="_blank" href="">Penerimaan Pengajuan Hibah
                            Penelitian Dana Internal</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="sosialisasi" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content" style="text-align: center">
                    <div class="modal-header" style="text-align: center;">
                        <h4 class="modal-title" style="margin-left: 0%">Sosialisasi Panduan Penelitian</h4>

                    </div>
                    <div class="modal-body">
                        <a class="btn btn-block btn-success" target="_blank" href="">Panduan Penelitian</a>
                        <a class="btn btn-block btn-danger" target="_blank" href="">PPT Sosialisasi</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <section class="content">

            <div class="card" style="background-color: rgb(0, 110, 255); color:white; margin:2%; padding:2%">
                <h1 style=" text-align: center">
                    Tujuan Dan Sasaran Strategis RIP 2019-2023

                </h1>
                <h5>
                    Memacu inovasi dan penguasaan ilmu pengetahuan dan teknologi berbasiskan ICT untuk mendukung keunggulan
                    kompetitif yang berwawasan global di bidang maritim, transportasi, dan logistik dalam rangka
                    meningkatkan daya saing bangsa
                </h5>

            </div>

        </section>
        <br>
        <section class="content">
            <div class="text-center">
                <img src="/assets/img/penelitian/riset.jpg" style="width: 70%" alt="">
            </div>

        </section>
        <br>
        <section class="content">
            <br>
            <div class="card">
                <div class="card-body row">
                    <div class="col-5 justify-content-center">
                        <img src="/assets/img/pengmas/siklus.JPG" style="width: 100%" alt="">

                    </div>
                    <div class="col-7" style="text-align: justify">
                        <h1 style="text-align: center">
                            <strong>Siklus Kegiatan Penelitian</strong>
                        </h1>
                        <h5>
                            Tahapan pelaksanaan kegiatan penelitian mengikuti pola siklus disamping yang terdiri dari enam
                            tahapan.
                        </h5>
                        <h5 style="text-align: left">

                            1. Perencanaan dan Penawaran Skema
                        </h5>
                        <h5 style="text-align: left">

                            2. Penerimaan Proposal
                        </h5>
                        <h5 style="text-align: left">

                            3. Desk Evaluation dan Penetapan,
                        </h5>
                        <h5 style="text-align: left">

                            4. Pelaksanaan Penelitian,
                        </h5>
                        <h5 style="text-align: left">

                            5. Monitoring dan Evaluasi (Kemajuan dan Akhir),
                        </h5>
                        <h5 style="text-align: left">

                            6. Pengembangan sebagai tindak lanjut hasil penelitian.
                        </h5>
                        <h5>

                            Dengan menerapkan sistem manajemen mutu berkelanjutan, pengelolaan penelitian diharapkan dapat
                            meningkat secara bertahap.

                        </h5>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        var svg = document.getElementsByTagName("svg");

        var rect = document.getElementsByTagName("rect");

        var text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', '10');
        text.setAttribute('y', '20');
        text.setAttribute('fill', '#000');
        text.textContent = 'Hello, I am a blah blah blah blah blah';
    </script>
@endsection
