@extends('front.layouts.basic')

@section('title')
    {{ $news->title }}
@endsection

@section('content')

<div class="bg-lighter wrapper">
    <div id="news-page">
        <div class="page-title-container">
            <div class="container">
                <h1 class="page-title">
                    {{ $news->title }}
                    <div class="pull-right hidden-xs">
                        <a class="back-link" href="{{ route('news') }}">Kembali ke Indeks</a>
                    </div>
                </h1>
            </div>
        </div>
        <div class="content-container">
            <div class="container">
                <div class="panel panel-content panel-default">
                    <div class="panel-body">
                        <div class="editor-placeholder text-muted clearfix">
                            <img src="{{ asset(is_null($news->edits->last()->user->profile) ? '/storage/images/default.jpg' : $news->edits->last()->user->profile->photo) }}" class="img-circle pull-left">
                            <div>{{ $news->edits->last()->user->name }}</div>
                            <small>Terakhir disunting pada {{ \Carbon\Carbon::parse($news->edits->last()->created_at)->format('j M, H:i') }}</small>
                        </div>
                    </div>
                    <div class="panel-body text-center">
                        <img src="{{ asset($news->picture) }}" class="news-picture">
                    </div>
                    <div class="panel-body">
                        {!! $news->content !!}
                    </div>
                    <div class="panel-body">
                        Berita ini dipublikasi pada {{ \Carbon\Carbon::parse($news->created_at)->format('j F Y, H:i:s') }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
