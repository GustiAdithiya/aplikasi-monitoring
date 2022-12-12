@extends('layouts.app')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="mt-2">
                    Selamat Datang <strong>{{ auth()->user()->instance->name }}</strong>!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
