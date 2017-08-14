@extends('front.layouts.basic')

@section('title')
    Pendaftaran
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
                @yield('view') {{-- <register-view :activities="{{ $activities->toJson() }}" @change="setCurrentView"></register-view> --}}
            </div>
        </div>
    </div>
</div>
@endsection
