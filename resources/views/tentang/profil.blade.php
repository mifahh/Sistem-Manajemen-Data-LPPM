@extends('template.layout')

@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="modal-body">
                        <!-- Project details-->
                        <h1 class="text-uppercase">Hello.. {{Auth::user()->name}} :)</h1>
                        <br>
                        <br>
                        <section class="content">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-md-7">

                                        <div class="card card-primary card-outline">
                                            <div class="card-body box-profile">
                                                <div class="text-center">
                                                    <img class="profile-user-img img-fluid img-circle"
                                                        src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
                                                </div>
                                                @foreach ($data_user as $du )
                                                <h3 class="profile-username text-center">{{$du->name}}</h3>

                                                <p class="text-muted text-center">Telkom University Surabaya</p>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>Email</b> <a class="float-right">{{$du->email}}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>No Hp ( WA )</b> <a class="float-right">{{$du->no_hp}}</a>
                                                    </li>

                                                </ul>
                                                @endforeach

                                                <a href="#" class="btn btn-warning btn-block"><b>Edit</b></a>
                                                <a href="#" class="btn btn-primary btn-block"><b>Kembali</b></a>

                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection