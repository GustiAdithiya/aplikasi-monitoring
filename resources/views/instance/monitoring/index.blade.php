@extends('layouts.app')

@section('main-content')
<div class="content">
    <div class="d-sm-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Monitoring - Detail</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{Route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{Route('instance.monitoring.package')}}">Monitoring - Paket Ujian</a></li>
                    <li class="breadcrumb-item"><a href="{{Route('instance.monitoring.participant')}}">Monitoring - Peserta Ujian</a></li>
                    <li class="breadcrumb-item active">Monitoring - Detail</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Informasi Peserta</h5>
                    <div class="row">
                        <div class="row d-sm-flex align-items-center justify-content-between">
                            <div class="col-lg-6 col-xs ">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Nama</th>
                                            <td>:</td>
                                            <td>{{$data->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>NIM / NIK</th>
                                            <td>:</td>
                                            <td>{{$data->no_identity}}</td>
                                        </tr>
                                        <tr>
                                            <th>Kode Registrasi</th>
                                            <td>:</td>
                                            <td>{{$data->no_reg}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-3 col-xs">
                                <h5>Score :</h5>
                                <h1 class="display-3"><strong>{{General::getDataParticipant($code,$data->no_identity)}}</strong></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
        $log = General::getLog($code,$data->no_identity);
        @endphp
        <div class="col-xs-6 col-lg-8 order-lg-1">
            <!-- @yield('image-content') -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bukti Kesalahan</h5>
                    <div id="carousel" data-bs-target="#list" class="carousel slide">
                        <div class="carousel-inner">
                            @forelse($log as $key => $value)
                            <div id="list-item{{$key}}" class="carousel-item {{$log[$key] == reset($log) ? 'active' : ''}}">
                                <img src="{{$log[$key]['image']}}" style="object-fit:contain; width:auto; height:500px;" class="d-block w-100" alt="...">
                            </div>
                            @empty
                        Data Tidak Ditemukan
                        @endforelse
                        </div>
                        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button> -->
                    </div><!-- End Slides with controls -->
                </div>
            </div>
        </div>
        <div class="col-lg-4 order-lg-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List Kesalahan</h5>
                    <div id="list" class="list-group scroll">
                        <?php $i = 0; ?>
                        @forelse($log as $key => $value)
                        <a id="btnList" data-bs-target="#carousel" data-bs-slide-to="{{$i}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" href="#list-item-{{$key}}"><span class="badge border-danger border-1 text-danger">{{$log[$key]['timestamp']}} :</span> {{$log[$key]['label']}}</a>
                        <?php $i++ ?>
                        @empty
                        Data Tidak Ditemukan
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush

@endsection