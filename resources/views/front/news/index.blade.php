@extends('front.layouts.basic')

@section('title')
    Berita
@endsection

@section('content')

<div class="bg-lighter wrapper">
    <div id="news-page">
        <div class="page-title-container">
            <div class="container">
                @if ($news->count() === 0)
                    <h1 class="page-title">Tidak Ada Berita.</h1>
                @else  
                    <h1 class="page-title">Daftar Berita</h1>
                @endif
            </div>
        </div>
        <div class="content-container">
            <div class="container">
                <div class="row news-list">
                    @foreach ($news as $item)
                        <div class="col-md-3 col-sm-6">
                            <div class="panel news-list-item panel-default">
                                <div class="panel-body img-placeholder">
                                    <a href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">
                                        <img src="{{ asset($item->picture) }}">
                                    </a>
                                </div>
                                <div class="panel-body">
                                    <h3><a href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">{{ $item->title }}</a></h3>
                                    <p class="news-content">{{ str_limit(strip_tags($item->content, 150)) }}</p>
                                    <div class="editor-placeholder text-muted clearfix">
                                        <img src="{{ asset($item->edits->last()->user->photo) }}" class="img-circle pull-left">
                                        <div>{{ $item->edits->last()->user->name }}</div>
                                        <small>{{ \Carbon\Carbon::parse($item->updated_at)->format('j M, H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
