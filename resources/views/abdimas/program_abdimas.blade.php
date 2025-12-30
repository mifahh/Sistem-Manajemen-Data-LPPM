@extends('template.layout')

@section('page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Program Abdimas</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Program Abdimas </li>
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
                        <img src="/assets/img/pengmas/logo_pengmas.png" style="width: 100%" alt="">

                    </div>
                    <div class="col-7" style="text-align: justify">
                        <h1 style="text-align: center">
                            <strong>Pengabdian Kepada Masyarakat ITTelkom Surabaya</strong>
                        </h1>
                        Melalui kegiatan Pengabdian Kepada Masyarakat, Institut Teknologi Telkom Surabaya secara langsung
                        dapat memberikan sumbangsih dan kontribusi bagi peningkatan dan pengembangan kesejahteraan
                        masyarakat sebagai upaya memperkuat daya saing bangsa. Sehingga kegiatan Pengabdian Kepada
                        Masyarakat ITTelkom Surabaya harus tepat sasaran dan memberikan nilai tambah manfaat bagi
                        masyarakat. Rencana Strategis (Renstra) Pengabdian Masyarakat ITTelkom Surabaya periode 2019-2023
                        ini disusun sebagai landasan dasar untuk pengeloaan dan pengembangan kegiatan pengabdian masyarakat
                        di lingkungan ITTelkom Surabaya dalam kurun waktu lima tahun kedepan.
                        <br>
                        <br>
                        Dalam pelaksanaan program pengabdian masyarakat, ITTelkom Surabaya ditunjang dengan adanya kelompok
                        pelaksana pengabdian masyarakat. Kelompok ini sama dengan kelompok riset dimana terdapat tiga
                        kelompok pelaksana.
                    </div>
                </div>

                <div class="card-group">
                    <div class="card">
                        <img src="/assets/img/pengmas/desain/SEC.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong> Sistem Elektronik Cerdas </strong></h3>
                            <p class="card-text">Kelompok Pelaksana ini dikelola oleh Fakultas Teknik Elektro dan memiliki
                                roadmap pengabdian masyarakat ELECTRONICS AND INTELLIGENT SYSTEMS.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10-08-2022</small>
                        </div>
                    </div>
                    <div class="card">
                        <img src="/assets/img/pengmas/desain/SEMI.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong> Sistem Enterprise Dan Manajemen Industri </strong></h3>
                            <p class="card-text">Kelompok Pelaksana ini dikelola oleh Fakultas Teknologi Informasi dan
                                Industri dan memiliki roadmap pengabdian masyarakat EXCELLLENT AND COMPETITIVE SMALL AND
                                MEDIUM ENTERPRISES (SMEs) IN SURABAYA AND EAST JAVA.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10-08-2022</small>
                        </div>
                    </div>
                    <div class="card">
                        <img src="/assets/img/pengmas/desain/SCTT.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong> Sistem Cerdas Dan Teknologi Terintegrasi </strong></h3>
                            <p class="card-text">Kelompok Pelaksana ini dikelola oleh Fakultas Teknologi Informasi dan
                                Industri dan memiliki roadmap penelitian SMART SYSTEM AND INTEGRATED TECHNOLOGY.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10-08-2022</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <section class="content">
            <div class="card-header" style="background-color: #95b8d1">
                <h1 style="text-align: center"> <strong> Program Pengabdian Masyarakat</strong></h1>

            </div>
            <div class="card">
                <br>
               <u> <h3 style="text-align: center">Flowchart Proses Abdimas</h3></u>
                <img src="/assets/img/pengmas/desain/proses_abdimas.png" class="card-img-top" alt="..." style="margin: 1%; width:95%">

            </div>

        </section>
        <br>
        <section class="content">
            <br>
            <div class="card">
                <div class="card-body row">
                    <div class="col-5 justify-content-center">
                        <img src="/assets/img/pengmas/program_unggulan.png" style="width: 70%; padding-left : 20%"
                            alt="">

                    </div>
                    <div class="col-7" style="text-align: justify">
                        <h1 style="text-align: center">
                            <strong>Program Unggulan Pengabdian Masyarakat ITTelkom Surabaya</strong>
                        </h1>
                        <br>
                        <h5 style="text-align: left">

                            1. Pemberdayaan Desa/Wilayah Binaan
                        </h5>
                        <h5 style="text-align: left">

                            2. Mitigasi dan Ketangguhan Bencana
                        </h5>
                        <h5 style="text-align: left">

                            3. Industri Kreatif dan Penerapan Teknologi Maju
                        </h5>

                    </div>
                </div>
            </div>
        </section>
        <br>
        {{-- <section class="content">

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

        </section> --}}
        <section class="content">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="card">
                        <img src="/assets/img/pengmas/tuju_2.jpg" class="card-img-top" alt="..."
                            style="width: 95%">
                        <div class="card-body">
                            <h3 style=" text-align:center"> <strong> Tujuan Strategis </strong></h3>
                            <p class="card-text">Terwujudnya peran aktif ITTelkom Surabaya dalam membina dan meningkatkan
                                kesejahteraan masyarakat melalui transfer ilmu pengetahuan dan teknologi untuk mendukung
                                keunggulan kompetitif masyarakat dalam rangka percepatan pembangunan manusia.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <img src="/assets/img/pengmas/sasaran.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong> Sasaran Strategis </strong></h3>
                            <p class="card-text">Terwujudnya 10 wilayah binaan mandiri berbasis ICT yang produktif di
                                wilayah Surabaya dan sekitarnya.</p>
                            <br>

                        </div>
                    </div>
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
                            <strong>Siklus Pengelolaan Pengabdian Masyarakat</strong>
                        </h1>
                        <h5>
                            Tahapan pelaksanaan kegiatan pengabdian masyarakat mengikuti pola siklus disamping yang terdiri
                            dari enam tahapan.
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

                            Dengan menerapkan sistem manajemen mutu berkelanjutan, pengelolaan pengabdian masyarakat
                            diharapkan dapat meningkat secara bertahap melalui perbaikan berkesinambungan.

                        </h5>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
