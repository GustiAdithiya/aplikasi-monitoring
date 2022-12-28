@extends('layouts.app')

@section('main-content')
<div class="content">
  <div class="d-sm-flex align-items-center justify-content-between">
    <div class="pagetitle">
      <h1>Monitoring - Peserta Ujian : {{$name}}</h1>
      <nav>php 
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{Route('home')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{Route('instance.monitoring.package')}}">Monitoring - Paket Ujian</a></li>
          <li class="breadcrumb-item active">Monitoring - Peserta ujian</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card recent-sales overflow-auto">

        <div class="card-body">
          <div class="card-title">
            <h5>Peserta Ujian</h5>
          </div>

          <table class="table table-borderless datatable">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Kode Registrasi</th>
                <th scope="col">NIM / NIK</th>
                <th scope="col">Nilai</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($participants as $participant)
              <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td><img src="{{ asset('storage/'. $participant->participant->photo) }}" alt="Profile" class="rounded-circle" width="35px" height="35px"> {{ $participant->participant->name}}
                </td>
                <td>{{ $participant->participant->no_reg }}</td>
                <td>{{$participant->participant->no_identity}}</td>
                <td>{{ General::getDataParticipant($code,$participant->participant->no_identity) }}</td>
                <td>
                  <div class="d-sm-flex align-items-center justify-content-left">
                    <a href="{{ route('instance.monitoring.index', array('id' => Crypt::encrypt($participant->participant->id))) }}" class="btn btn-sm btn-primary ">
                      <i class="bi bi-search"></i> Lihat
                    </a>
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