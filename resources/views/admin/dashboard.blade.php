@extends('template.layout')

@section('page-content')
    <br>
    <section class="content" onload="load()">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id='0101' class="fs-2 text-light">0</h3>
                            <h2>Penelitian</h2>
                        </div>
                        <div class="icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <a href="{{route('plt_profil_penelitian')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id='0102' class="fs-2 text-light">0</h3>
                            <h2>Abdimas</h2>
                        </div>
                        <div class="icon">
                            <i class="fas fa-people-carry"></i>
                        </div>
                        <a href="{{route('data_abdimas_table')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">

                            <h3 id='0103' class="fs-2 text-light">0</h3>
                            <h2 style="color: white">Publikasi</h2>
                        </div>
                        <div class="icon">
                            <i class="fas fa-upload"></i>
                        </div>
                        <a href="{{route('data_publikasi_table')}}" class="small-box-footer">
                            <font color="white">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </font>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id='0104' class="fs-2 text-light">0</h3>
                            <h2>Kekayaan Intelektual</h2>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <a href="{{route('data_ki_table')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <br>
    <section class="content">

        <div class="card"
            style="background-color: rgb(251, 255, 252); color:rgb(11, 19, 253); margin-left:12%; padding:2%; width:75%;  border: 5px solid rgb(0, 179, 255);
        padding: 10px;
        border-radius: 25px;">
            <h1 style=" text-align: center">
                PENCAPAIAN RISET DAN INOVASI

            </h1>
            <hr>
            <h5 style="text-align: center">
                ITTelkom Surabaya telah mencapai Klaster Penelitian Madya dalam kurun waktu dua tahun dan dipercaya berbagai
                instansi melalui hibah pendanaan eksternal baik untuk penelitian maupun pengabdian masyarakat.
            </h5>
            <br>
            <div class="card" style="width: 70%; margin-left:14%">
                <div class="card-group">
                    <div class="card">
                        <div class="card-body" style="text-align: center">
                            <h3 style="text-align: center" id='0105'> <strong> </strong></h3>
                            <p class="card-text" style="text-align: center">PERINGKAT NASIONAL SINTA</p>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h3 style="text-align: center" id='0106'> <strong>  </strong></h3>
                            <p class="card-text" style="text-align: center">PERINGKAT RISET DAN INOVASI LLDIKTI 7</p>
                        </div>

                    </div>

                </div>
            </div>
        </div>


    </section>
    <section class="content">
        <div class="card"
            style="background-color: rgb(244, 247, 244); color:rgb(0, 0, 0); margin-left:14%; padding:2%; width:70%;  border: 5px solid rgb(255, 191, 0);
        padding: 10px;
        border-radius: 25px;">
            <h1 style=" text-align: center">
                FIND THE LATEST INNOVATION

            </h1>
            <p style="text-align: center">
                Hasil riset dan inovasi yang dihasilkan oleh sivitas akademika ITTelkom Surabaya selalu diupayakan untuk
                menjadi solusi bagi negeri. Berikut ini adalah beberapa karya yang sudah dihasilkan oleh ITTelkom Surabaya
            </p>

        </div>
        <div class="card">
            <div class="card-group">
                <div class="card">
                    <img src="/assets/img/dashboard/srobot.png" style="width: 70%;margin-left:15%; margin-top:5%" alt="...">
                    <div class="card-body" style="text-align: center">
                        <h3 style="text-align: center"> <strong> Logistics Technology</strong></h3>
                        <p class="card-text" style="text-align: center">SROBOT</p>
                    </div>

                </div>
                <div class="card">
                    <img src="/assets/img/dashboard/crane.png" style="width: 70%;margin-left:15%; margin-top:5%" alt="...">
                    <div class="card-body">
                        <h3 style="text-align: center"> <strong> Healthcare </strong></h3>
                        <p class="card-text" style="text-align: center">STRETCHER CRANE PEMULASARAAN JENAZAH</p>
                    </div>

                </div>
                <div class="card">
                    <img src="/assets/img/dashboard/ventilator.png" style="width: 70%;margin-left:15%; margin-top:5%" alt="...">
                    <div class="card-body">
                        <h3 style="text-align: center"> <strong>Healthcare</strong></h3>
                        <p class="card-text"style="text-align: center">DIGITAL VENTILATOR</p>
                    </div>

                </div>
            </div>
        </div>
        <div style="margin:1%; display: flex; justify-content: center;">
            <a href="" class="btn btn-lg btn-outline-primary"> Lihat Selengkapnya</a>
        </div>
    </section>

    <script>
        function animate(obj, initVal, lastVal, duration) {
            let startTime = null;

            //get the current timestamp and assign it to the currentTime variable
            let currentTime = Date.now();

            //pass the current timestamp to the step function
            const step = (currentTime) => {

                //if the start time is null, assign the current time to startTime
                if (!startTime) {
                    startTime = currentTime;
                }

                //calculate the value to be used in calculating the number to be displayed
                const progress = Math.min((currentTime - startTime) / duration, 1);

                //calculate what to be displayed using the value gotten above
                obj.innerHTML = Math.floor(progress * (lastVal - initVal) + initVal);

                //checking to make sure the counter does not exceed the last value (lastVal)
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    window.cancelAnimationFrame(window.requestAnimationFrame(step));
                }
            };
            //start animating
            window.requestAnimationFrame(step);
        }
        let text1 = document.getElementById('0101');
        let text2 = document.getElementById('0102');
        let text3 = document.getElementById('0103');
        let text4 = document.getElementById('0104');
        const load = () => {
            animate(text1, 0, {{''}}, 5000 );
            animate(text2, 0, {{$jml_abdimas}}, 5000);
            animate(text3, 0, {{$jml_publikasi}}, 5000);
            animate(text4, 0, {{$jml_ki}}, 5000);
        }
    </script>
@endsection
