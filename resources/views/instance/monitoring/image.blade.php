@extends('instance.monitoring.index')
@section('image-content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Image</h5>
        <div class="text-center">
            <img src="{{$image1 == '' ? '' : asset('storage/'.$image1)}}" alt="Pilih Kesalahan Untuk Melihat Gambar">
            <img src="{{$image2 == '' ? '' : asset('storage/'.$image2)}}">
        </div>
    </div>
</div>
@endsection