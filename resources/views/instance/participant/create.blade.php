@extends('layouts.app')

@section('main-content')
<div class="content">
    <div class="d-sm-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Peserta Ujian - Tambah</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{Route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{Route('instance.package.index')}}">Paket Ujian</a></li>
                    <li class="breadcrumb-item"><a href="{{Route('instance.participant.index')}}">Peserta Ujian</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <form action="{{route('instance.participant.store')}}" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation">
            {{ csrf_field() }}
            <div class="col-lg-4 order-lg-2">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        
                        <img id="preview" src="{{ asset('images/preview.png') }}" class="rounded-circle" width="200px" height="200px" />                      
                        <div class="card-body mt-3">
                        <input accept="image/*" type='file' id="photo" class="form-control " name="photo" value="{{ old('photo') }}" required/>
                            @if ($errors->has('photo'))
                            <span class="invalid-feedback">{{ $errors->first('photo') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 order-lg-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data</h5>
                        @include('layouts.components.flash')
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="no_identity" class="form-label">NIM / NIK</label>
                                <input name="no_identity" type="text" class="form-control" id="no_identity" require placeholder="Nama Paket" value="{{old('no_identity')}}">
                                @if ($errors->has('no_identity'))
                                <span class="invalid-feedback">{{ $errors->first('no_identity') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="name" class="form-label">Nama Peserta</label>
                                <input name="name" type="text" class="form-control" id="name" require placeholder="Nama Paket" value="{{old('name')}}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
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