@extends('layouts.app')

@section('main-content')
<div class="content">
    <div class="d-sm-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Monitoring - Paket Ujian</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{Route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Monitoring - Paket Ujian</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <div class="card-title">
                        <h5>Paket Ujian</h5>
                    </div>

                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Penyelenggara</th>
                                <th scope="col">Nama Paket</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($packages as $package)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $package->instance->instance_name }}</td>
                                <td>{{ $package->name }}</td>
                                <td>{{ $package->code }}</td>
                                <td>Start : {{$package->start_at}}</br>Finish : {{$package->finish_at}}</td>
                                <td>
                                    @php
                                    if($time >= $package->start_at && $time <= $package->finish_at){
                                        echo '<span class="badge rounded-pill bg-primary">Sedang Berlangsung</span>';
                                        }
                                        if($time < $package->start_at && $time < $package->finish_at){
                                                echo '<span class="badge rounded-pill bg-danger">Belum Mulai</span>';
                                                }
                                                if($time > $package->finish_at && $time > $package->start_at){ echo '<span class="badge rounded-pill bg-success">Selesai</span>' ; } @endphp </td>
                                <td>
                                    <div class="d-sm-flex align-items-center justify-content-around">
                                        @if($time < $package->start_at && $time < $package->finish_at)
                                                -
                                                @else
                                                <a href="{{ route('instance.monitoring.participant', array('id' => Crypt::encrypt($package->id))) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-search"></i> Lihat
                                                </a>
                                                @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">Data Tidak Ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection