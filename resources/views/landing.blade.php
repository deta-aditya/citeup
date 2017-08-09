@extends('front.layouts.basic')

@section('content')

@if ($settings->show->welcometron)
<!-- Welcome Carousel -->
<div id="front-welcometron">

    <div class="container text-center">
        <div class="logo-placeholder">
            <img src="{{ asset('images/web/logo_white_lg.png') }}">
        </div>
        <div class="text-placeholder">
            @if ($settings->countdown->active)
                <p class="notice">{{ $settings->countdown->text }}</p>
                <countdown done="{{ $settings->countdown->off }}"></countdown>
            @endif
        </div>
    </div>

</div>
@endif

@if ($settings->show->activities)
<!-- About Div -->
<div id="front-about" class="text-center">
    <div class="container">
        <p>"Celebrating The Golden Era Of Technology"</p>
    </div>
</div>

<!-- Activities Div -->
<div id="front-activities">
    <div class="container-container">
        <div class="container">
            <div class="row center-block">

                @foreach ($activities as $activity)
                    <div class="col-xs-4 activity-item-placeholder">
                        <a href="{{ route('activities', ['t' => kebab_case($activity->name)]) }}" class="panel panel-default text-center activity-item">
                            <div class="panel-body icon-holder">
                                <img class="activity-icon" src="{{ asset($activity->icon) }}">
                            </div>
                            <div class="panel-body content-holder">
                                <h3 class="activity-title">{{ $activity->name }}</h3>
                                <p class="hidden-xs">{{ $activity->short_description }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endif

@if ($settings->show->prizes)
<!-- Prizes Div -->
<div id="front-prizes">
    <div class="container-container">
        <div class="container">
            <div class="panel panel-default panel-prizes center-block text-center">
                <div class="panel-body">
                    <h2 class="prizes-title">Total Hadiah</h2>
                    <div class="total-prizes">Rp{{ '&#123;&#123;' }} {{ $activities->sum('total_prizes') }} {{ '| monetize &#125;&#125;' }}</div>
                </div>
                <div class="row prizes-list">
                    @foreach ($activities as $activity)
                        @continue(! $activity->isCompetition())
                        <div class="col-sm-6 prizes-list-item panel-body">
                            <h3>{{ $activity->name }}</h3>
                            <div class="prize-wrapper">
                                <div class="prize-place">Juara 1</div>
                                <div class="prize-qty">Rp{{ '&#123;&#123;' }} {{ $activity->prize_first }} {{ '| monetize &#125;&#125;' }}</div>
                            </div>
                            <div class="prize-wrapper">
                                <div class="prize-place">Juara 2</div>
                                <div class="prize-qty">Rp{{ '&#123;&#123;' }} {{ $activity->prize_second }} {{ '| monetize &#125;&#125;' }}</div>
                            </div>
                            <div class="prize-wrapper">
                                <div class="prize-place">Juara 3</div>
                                <div class="prize-qty">Rp{{ '&#123;&#123;' }} {{ $activity->prize_third }} {{ '| monetize &#125;&#125;' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($settings->show->map)
<!-- Map Div -->
<div id="front-map">

    <!-- Cover -->
    <div class="map-cover">
    </div>

    <!-- Google Map -->
    <gmap-map class="map-content" :center="{{ $settings->location->toJson() }}" :zoom="15" :options="gmapOptions">
        <gmap-marker :position="{{ $settings->location->toJson() }}"></gmap-marker>
    </gmap-map>

    <!-- Info -->
    <div class="map-info">
        <div class="info-body">
            <h2>
                Lokasi Acara
            </h2>
            <address>
                <strong>Universitas Pertamina</strong><br>
                <small>
                    Jalan Teuku Nyak Arief<br>
                    Simprug<br>
                    Kebayoran Lama<br>
                    Jakarta 12220<br>
                </small>
            </address>
        </div>
    </div>

</div>
@endif

@if ($settings->show->faqs)
<!-- FAQ Div -->
<div id="front-faq">
    <div class="container">
        <h2>Pertanyaan Umum (FAQ)</h2>
        <div class="panel-group" id="faq-list" role="tablist" aria-multiselectable="true">
            @foreach ($faqs as $faq)
                <div class="panel panel-default">
                    <div class="panel-heading" role="button" data-toggle="collapse" data-parent="#faq-list" data-target="#collapsible-faq-{{ $faq->id }}">
                        <h4 class="panel-title">{{ $faq->question }}</h4>
                    </div>
                    <div id="collapsible-faq-{{ $faq->id }}" class="panel-collapse collapse">
                        <div class="panel-body">
                            {!! $faq->answer !!}
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($faqs->count() === 0)
                <p class="lead text-center">Tidak Ada FAQ.</p>
            @endif
        </div>
        <p class="see-all">Lihat semua pertanyaan di <a href="{{ route('faqs') }}">halaman FAQ</a>.</p>
    </div>
</div>
@endif

@if ($settings->show->news)
<hr class="short-middle-bar center-block">

<!-- News Div -->
<div id="front-news">
    <div class="container">
        <h2 class="text-center">Berita Terkini</h2>
        
        <div id="news-list">
            @if ($news->count() === 0)
                <p class="lead text-center">Tidak Ada Berita.</p>
            @elseif ($news->count() === 1)
                @php $item = $news->first() @endphp
                <div class="row news-first">
                    <div class="col-sm-8">
                        <a class="img-placeholder" href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">
                            <img src="{{ asset($item->picture) }}">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <h3><a href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">{{ $item->title }}</a></h3>
                        <p class="news-content">{{ str_limit(strip_tags($item->content, 150)) }}</p>
                        <div class="editor-placeholder text-muted clearfix">
                            <img src="{{ asset(is_null($item->edits->last()->user->profile) ? '/images/default.jpg' : $item->edits->last()->user->profile->photo) }}" class="img-circle pull-left">
                            <div>{{ $item->edits->last()->user->name }}</div>
                            <small>{{ \Carbon\Carbon::parse($item->updated_at)->format('j M, H:i') }}</small>
                        </div>
                    </div>
                </div>
            @elseif ($news->count() === 2)
                <div class="row">
                    @foreach ($news as $item)
                        <div class="col-sm-6 news-other">
                            <a class="img-placeholder" href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">
                                <img src="{{ asset($item->picture) }}">
                            </a>
                            <h3><a href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">{{ $item->title }}</a></h3>
                            <p class="news-content">{{ str_limit(strip_tags($item->content, 150)) }}</p>
                            <div class="editor-placeholder text-muted clearfix">
                                <img src="{{ asset(is_null($item->edits->last()->user->profile) ? '/images/default.jpg' : $item->edits->last()->user->profile->photo) }}" class="img-circle pull-left">
                                <div>{{ $item->edits->last()->user->name }}</div>
                                <small>{{ \Carbon\Carbon::parse($item->updated_at)->format('j M, H:i') }}</small>
                            </div>    
                        </div>
                    @endforeach
                </div>
            @elseif ($news->count() === 3)
                <div class="row">
                    @foreach ($news as $item)
                        <div class="col-sm-4 news-other">
                            <a class="img-placeholder" href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">
                                <img src="{{ asset($item->picture) }}">
                            </a>
                            <h3><a href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">{{ $item->title }}</a></h3>
                            <p>{{ str_limit(strip_tags($item->content, 150)) }}</p>
                            <div class="editor-placeholder text-muted clearfix">
                                <img src="{{ asset(is_null($item->edits->last()->user->profile) ? '/images/default.jpg' : $item->edits->last()->user->profile->photo) }}" class="img-circle pull-left">
                                <div>{{ $item->edits->last()->user->name }}</div>
                                <small>{{ \Carbon\Carbon::parse($item->updated_at)->format('j M, H:i') }}</small>
                            </div>    
                        </div>
                    @endforeach
                </div>
            @else
                @php $first = $news->first() @endphp
                <div class="row news-first">
                    <div class="col-sm-8">
                        <a class="img-placeholder" href="{{ route('news.item', ['news' => $first->id, 'slug' => kebab_case($first->title)]) }}">
                            <img src="{{ asset($first->picture) }}">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <h3><a href="{{ route('news.item', ['news' => $first->id, 'slug' => kebab_case($first->title)]) }}">{{ $first->title }}</a></h3>
                        <p>{{ str_limit(strip_tags($first->content, 150)) }}</p>
                        <div class="editor-placeholder text-muted clearfix">
                            <img src="{{ asset(is_null($first->edits->last()->user->profile) ? '/images/default.jpg' : $first->edits->last()->user->profile->photo) }}" class="img-circle pull-left">
                            <div>{{ $first->edits->last()->user->name }}</div>
                            <small>{{ \Carbon\Carbon::parse($first->updated_at)->format('j M, H:i') }}</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($news as $item)
                        @continue($loop->first)
                        <div class="col-sm-4 news-other">
                            <a class="img-placeholder" href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">
                                <img src="{{ asset($item->picture) }}">
                            </a>
                            <h3><a href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">{{ $item->title }}</a></h3>
                            <p>{{ str_limit(strip_tags($item->content, 150)) }}</p>
                            <div class="editor-placeholder text-muted clearfix">
                                <img src="{{ asset(is_null($item->edits->last()->user->profile) ? '/images/default.jpg' : $item->edits->last()->user->profile->photo) }}" class="img-circle pull-left">
                                <div>{{ $item->edits->last()->user->name }}</div>
                                <small>{{ \Carbon\Carbon::parse($item->updated_at)->format('j M, H:i') }}</small>
                            </div>    
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <p class="see-all">Kunjungi <a href="{{ route('news') }}">halaman berita</a> untuk melihat semua berita.</p>

    </div>
</div>
@endif

@if ($settings->show->galleries)
<!-- Galleries Div -->
<div id="front-galleries" style="margin:20px 0 40px;">
    <div class="container">
        <h2 class="text-center">Galeri</h2>
        <div class="text-center" style="margin-top:40px">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail">
        </div>
    </div>
</div>
@endif

@if ($settings->show->contact)
<div id="front-contact-us">
    
    <div class="container text-center">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2>Contact Person</h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    @foreach (config('web.contact.person') as $contactPerson)
                        <div class="col-sm-6">
                            <dl>
                                <dt>{{ $contactPerson['name'] }}</dt>
                                <dd>{{ $contactPerson['phone'] }}</dd>
                                <dd class="email">{{ $contactPerson['email'] }}</dd>
                                <dd><a href="http://line.me/ti/p/~{{ $contactPerson['line'] }}" target="_blank">{{ $contactPerson['line'] }}</a></dd>
                            </dl>      
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endif

@if ($settings->show->sponsors && ($sponsors->count() > 0 || $media_partners->count() > 0))
<!-- Sponsors Div -->
<div id="front-sponsors">
    <div class="container text-center sponsors-container">
        <h2>Sponsor</h2>
        <div class="sponsors-list">
            @foreach ($sponsors as $sponsor)
                @unless (is_null($sponsor->url)) <a href="{{ $sponsor->url }}" target="_blank"> @endunless
                    <img src="{{ asset($sponsor->picture) }}" class="sponsor-item" data-toggle="tooltip" data-placement="top" title="{{ $sponsor->name }}">
                @unless (is_null($sponsor->url)) </a> @endunless
            @endforeach
        </div>
    </div>
    <hr class="short-middle-bar center-block">
    <div class="container text-center media-partners-container">
        <h2>Media Partner</h2>
        <div class="sponsors-list">
            @foreach ($media_partners as $sponsor)
                @unless (is_null($sponsor->url)) <a href="{{ $sponsor->url }}" target="_blank"> @endunless
                    <img src="{{ asset($sponsor->picture) }}" class="media-partner-item" data-toggle="tooltip" data-placement="top" title="{{ $sponsor->name }}">
                @unless (is_null($sponsor->url)) </a> @endunless
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection