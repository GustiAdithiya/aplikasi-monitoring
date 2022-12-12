@extends('layouts.app')

@section('main-content')
<div class="content">
    <div class="d-sm-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Paket Ujian - Edit</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{Route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{Route('instance.package.index')}}">Paket Ujian</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <form action="{{route('instance.package.update', Crypt::encrypt($data->id))}}" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data</h5>
                        @include('layouts.components.flash')
                        <input name="id" type="hidden" class="form-control" id="id" value="{{$data->id}}">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="code" class="form-label">Kode Paket</label>
                                <input name="code" type="text" class="form-control" id="code" require placeholder="Kode Paket" value="{{$data->code}}">
                                @if ($errors->has('code'))
                                <span class="invalid-feedback">{{ $errors->first('code') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="name" class="form-label">Nama Paket</label>
                                <input name="name" type="text" class="form-control" id="name" require placeholder="Nama Paket" value="{{$data->name}}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="desc" class="form-label">Deskripsi</label>
                                <textarea name="desc" placeholder="Deskripsi" require class="form-control" id="desc">{{$data->desc}}</textarea>
                                @if ($errors->has('desc'))
                                <span class="invalid-feedback">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="start_at" class="form-label">Mulai</label>
                                <input name="start_at" type="datetime-local" class="form-control" require id="start_at" value="{{$data->start_at}}">
                                @if ($errors->has('start_at'))
                                <span class="invalid-feedback">{{ $errors->first('start_at') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="finish_at" class="form-label">Selesai</label>
                                <input name="finish_at" type="datetime-local" class="form-control" require id="finish_at" value="{{$data->finish_at}}">
                                @if ($errors->has('finish_at'))
                                <span class="invalid-feedback">{{ $errors->first('finish_at') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    photo.onchange = evt => {
        const [file] = photo.files
        if (file) {
            preview.src = URL.createObjectURL(file)
        }
    }
</script>
@endpush
@endsection