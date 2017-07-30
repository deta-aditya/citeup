@extends('front.layouts.basic')

@section('content')

<div class="bg-lighter wrapper">
    <div id="news-page">
        <div class="page-title-container">
            <div class="container"><h1 class="page-title">Daftar Berita</h1></div>
        </div>
        <div class="content-container">
            <div class="container">
                <div class="row news-list">
                    @foreach ($news as $item)
                        <div class="col-sm-3">
                            <div class="panel news-list-item panel-default">
                                <div class="panel-body img-placeholder">
                                    <a href="#news/id/title-in-kebab-case">
                                        <img src="{{ asset($item->picture) }}">
                                    </a>
                                </div>
                                <div class="panel-body">
                                    <h3><a href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">{{ $item->title }}</a></h3>
                                    <p>{{ str_limit(strip_tags($item->content, 150)) }}</p>
                                    <div class="editor-placeholder text-muted clearfix">
                                        <img src="{{ asset(is_null($item->edits->last()->user->profile) ? '/storage/images/default.jpg' : $item->edits->last()->user->profile->photo) }}" class="img-circle pull-left">
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
