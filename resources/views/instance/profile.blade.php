@extends('layouts.app')

@section('main-content')
<div class="content">
    <div class="d-sm-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Edit Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{Route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <form action="{{route('instance.profile.update', Crypt::encrypt($data->id))}}" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="col-lg-4 order-lg-2">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img id="preview" src="{{ $data->photo == null ? asset('images/preview.png') : asset('storage/'.$data->photo) }}" class="rounded-circle" width="200px" height="200px" />
                        <div class="card-body mt-3">
                            <input accept="image/*" type='file' id="photo" class="form-control " name="photo" value="{{ old('photo') }}" />
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
                        <h5 class="card-title">Edit Profile</h5>
                        @include('layouts.components.flash')
                        <input id="id" type="hidden" class="form-control" name="id" value="{{ $data->id }}">
                        <input id="user_id" type="hidden" class="form-control" name="user_id" value="{{ $data->user_id }}">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input name="name" type="text" class="form-control" id="name" require placeholder="Nama Lengkap" value="{{$data->name}}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="instance_name" class="form-label">Nama Instansi</label>
                                <input name="instance_name" type="text" class="form-control" require id="instance_name" placeholder="Nama Instansi" value="{{$data->instance_name}}">
                                @if ($errors->has('instance_name'))
                                <span class="invalid-feedback">{{ $errors->first('instance_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="instance_address" class="form-label">Alamat Instansi</label>
                                <textarea name="instance_address" placeholder="Alamat Instanse" require class="form-control" id="instance_address">{{$data->instance_address}}</textarea>
                                @if ($errors->has('instance_address'))
                                <span class="invalid-feedback">{{ $errors->first('instance_address') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="email" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" require placeholder="Email" id="email" value="{{$data->email}}">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="phone" class="form-label">No. Telephone</label>
                                <input name="phone" type="text" class="form-control" require placeholder="No. Telephone" id="phone" value="{{$data->phone}}">
                                @if ($errors->has('phone'))
                                <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="username" class="form-label">Username</label>
                                <input name="username" type="text" placeholder="Username" readonly require class="form-control" id="username" value="{{$data->user->username}}">
                                @if ($errors->has('username'))
                                <span class="invalid-feedback">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="current_password" class="form-label">Password Lama</label>
                                <input name="current_password" type="password" class="form-control" placeholder="Password Lama" id="current_password">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label" for="new_password">Password Baru</label>
                                <input type="password" id="new_password" class="form-control" name="new_password" placeholder="Password Baru">
                                @if ($errors->has('new_password'))
                                <span class="invalid-feedback">{{ $errors->first('new_password') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                                <input type="password" id="password-confirm" class="form-control" placeholder="Konfirmasi password" name="password_confirmation" autocomplete="password">
                                @if ($errors->has('password-confirm'))
                                <span class="invalid-feedback">{{ $errors->first('password-confirm') }}</span>
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