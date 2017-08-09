@extends('front.layouts.basic')

@section('title')
    Tentang
@endsection

@section('content')

<div class="bg-lighter wrapper">
    <div id="about-page">
        <div class="page-title-container container-fluid">
            <h1 class="page-title text-center">Tentang CITE UP</h1>
        </div>
        <div class="content-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default panel-content">
                            <div class="panel-body text-justify">
                                {!! $content !!}                   
                            </div>
                        </div>
                        <div class="panel panel-default panel-content">
                            <div class="panel-body">
                                <h2>Aplikasi &amp; Web</h2>
                                <p>Aplikasi CITE UP kini berada pada versi <i>{{ config('app.version') }}</i>.</p>
                                <p>Aplikasi ini dikembangkan menggunakan <a href="https://laravel.com"  target="_blank">Laravel 5.4</a> dan <a href="https://vuejs.org" target="_blank">Vue.js</a>.</p>
                                <p>Ikon acara dibuat oleh <a href="http://www.freepik.com" title="Freepik">Freepik</a> dari <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> dan berlisensi <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>.</p>
                                <p>Desain tampilan dan sistem pada aplikasi dikembangkan oleh <a href="https://github.com/purplebubblegum" target="_blank" style="color:#991e9b">purplebubblegum</a> dengan dukungan segenap mahasiswa Ilmu Komputer, Universitas Pertamina.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <img src="{{ asset('images/web/main_illustration.png') }}" class="main-illustration">
                        <p class="text-center main-motto">" Celebrating The Golden Era of Technology "</p>
                        <div class="row activity-list hidden-sm hidden-xs">
                            @foreach ($activities as $activity)
                                <div class="col-sm-4">
                                    <a href="{{ route('activities', kebab_case($activity->name)) }}" class="panel panel-default activity-list-item">
                                        <img src="{{ asset($activity->icon) }}" class="img-rounded">
                                        <div class="panel-body text-center activity-name">
                                            {{ $activity->name }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center logo-up-container">
                            <p>Acara ini diselenggarakan oleh</p>
                            <img src="{{ asset('images/web/focs_white_sm.png') }}" class="logo-up">
                            <img src="{{ asset('images/web/logoup_white_sm.png') }}" class="logo-up">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
