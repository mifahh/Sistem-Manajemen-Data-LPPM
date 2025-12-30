@extends('template.layout')

@section('page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Program Publikasi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Program Publikasi </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <section class="content">

            <div class="card" style="background-color: rgb(0, 110, 255); color:white; margin:2%; padding:2%">
                <h1 style=" text-align: center">
                    Program Peningkatan Publikasi

                </h1>
                <h5 style="text-align: center">
                    ITTelkom Surabaya memiliki komitmen tinggi untuk meningkatkan daya saing dan rekognisinya melalui
                    peningkatan kuantitas dan kualitas publikasi ilmiah. Berikut adalah beberapa program untuk mewujudkan
                    hal tersebut.
                </h5>

            </div>

        </section>
        <br>
        <section class="content">
            <div class="card">
                <div class="card-group">
                    <div class="card">
                        <img src="/assets/img/pengmas/BPI.png" style="width: 50%;margin-left:20%" alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong> Bantuan Publikasi Ilmiah </strong></h3>
                            <p class="card-text" style="text-align: justify">ITTelkom Surabaya telah mengalokasikan anggaran
                                tiap tahunnya untuk bantuan
                                publikasi karya ilmiah, baik berupa jurnal nasional, jurnal internasional maupun seminar
                                internasional.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10-08-2022</small>
                        </div>
                    </div>
                    <div class="card">
                        <img src="/assets/img/pengmas/IP.png" style="width: 50%;margin-left:20%" alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong> Insentif Publikasi </strong></h3>
                            <p class="card-text" style="text-align: justify">Guna meningkatkan produktivitas publikasi
                                ilmiah sekaligus sebagai bentuk
                                apresiasi atas pencapaian kinerja publikasi, maka ITTelkom Surabaya memberikan insentif
                                publikasi ilmiah setiap tahun.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10-08-2022</small>
                        </div>
                    </div>
                    <div class="card">
                        <img src="/assets/img/pengmas/Workshop.png" style="width: 50%;margin-left:20%"
                            alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong>Workshop</strong></h3>
                            <p class="card-text"style="text-align: justify">LPPM rutin menyelenggarakan workshop penulisan
                                jurnal untuk meningkatan
                                kapasitas dosen dalam melakukan publikasi.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10-08-2022</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <br>
        <section class="content">
            <div class="card">
                <div class="card-group">
                    <div class="card">
                        <img src="/assets/img/pengmas/journal.png" style="width: 70%;margin-left:20%; margin-top:5%"
                            alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong>Pengelolaan Jurnal</strong></h3>
                            <p class="card-text" style="text-align: justify">ITTelkom Surabaya telah memiliki dua jurnal
                                ilmiah berkala yang dikelola oleh tiap fakultas. Melalui jurnal tersebut, diharapkan dapat
                                meningkatkan rekognisi institusi sekaligus menjadi sarana publikasi bagi dosen.</p>
                            <div class="center" style="text-align: center">

                                <a href="#" class="btn btn-primary" style="text-align: center">Get The Journal</a>

                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10-08-2022</small>
                        </div>
                    </div>
                    <div class="card">
                        <img src="/assets/img/pengmas/JR.png" style="width: 50%;margin-left:20%" alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong>Jejaring Riset </strong></h3>
                            <p class="card-text">Memperluas jejaring riset dilakukan melalui pelibatan dosen dalam komunitas
                                riset baik skala nasional maupun internasional, misalnya IEEE, IAENG, dsb.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10-08-2022</small>
                        </div>
                    </div>
                    <div class="card">
                        <img src="/assets/img/pengmas/ETIKA.png" style="width: 50%;margin-left:25%"
                            alt="...">
                        <div class="card-body">
                            <h3 style="text-align: center"> <strong>Etika Publikasi Dan Penyediaan Pustaka</strong></h3>
                            <p class="card-text">Pustaka disediakan dalam berbagai sumber baik berupa buku maupun jurnal ilmiah. Penguatan etika publikasi juga difasilitasi melalui pengecekan plagiasi sebelum publikasi.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 10-08-2022</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
