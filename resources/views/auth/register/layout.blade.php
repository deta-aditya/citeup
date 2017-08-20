@extends('front.layouts.basic')

@section('title')
    @yield('page-title')
@endsection

@section('content')

<div class="bg-lighter wrapper">
    <div id="register-page">
        <div class="page-title-container text-center container-fluid">
            <div class="logo-container">
                <img class="logo" src="{{ asset('images/web/logo_white_lg.png') }}">
            </div>
            <h1 class="page-title">
                @yield('page-title')
            </h1>
        </div>
        <div class="content-container">
            <div class="container">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terjadi Kesalahan!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('view')
            </div>
        </div>
    </div>
</div>
@endsection
