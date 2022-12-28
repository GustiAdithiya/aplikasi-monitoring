@extends('layouts.app')

@section('main-content')
<div class="content">
  <div class="d-sm-flex align-items-center justify-content-between">
    <div class="pagetitle">
      <h1>Peserta Ujian : {{$package}}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{Route('home')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{Route('instance.package.index')}}">Paket Ujian</a></li>
          <li class="breadcrumb-item active">Peserta ujian</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card recent-sales overflow-auto">

        <div class="card-body">
          <div class="card-title">
            <div class="d-sm-flex align-items-center justify-content-between">
              <h5>Peserta Ujian</h5>
              <a href="{{ route('instance.participant.create') }}" class="btn btn-sm btn-primary">Tambah Data</a>
            </div>
          </div>

          <table class="table table-borderless datatable" >
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Kode Registrasi</th>
                <th scope="col">NIM / NIK</th>
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
                <td>{{ $participant->participant->no_identity }}</td>
                <td>
                  <div class="d-sm-flex align-items-center justify-content-left">
                    <a href="{{ route('instance.participant.edit', Crypt::encrypt($participant->participant->id)) }}" class="btn btn-sm btn-warning ">
                      <i class="bi bi-pencil-fill"></i>
                    </a>
                    <form action="{{ route('instance.participant.destroy', Crypt::encrypt($participant->participant->id)) }}" method="post">
                      @csrf
                      @method('delete')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash-fill"></i></button>
                    </form>
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