@extends('front.layouts.basic')

@section('content')

<div class="bg-lighter">
    <div id="activities-page">
        <div class="page-title-container">
            <div class="container"><h1 class="page-title">Rincian Acara</h1></div>
        </div>
        <div class="content-container">
            <div class="container">
                <div class="panel panel-content panel-default">
                    <div class="panel-heading">
                        <ul class="activities-nav nav nav-pills" role="tablist">
                            @foreach ($activities as $activity)
                                <li role="presentation" @if ($type == kebab_case($activity['name'])) class="active" @endif>
                                    <a href="#{{ kebab_case($activity['name']) }}" aria-controls="{{ kebab_case($activity['name']) }}" role="tab" data-toggle="tab">
                                        {{ $activity['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="panel-body activity-content">
                        <div class="tab-content">
                            @foreach ($activities as $activity)
                                <div role="tab-panel" class="tab-pane fade @if ($type == kebab_case($activity['name'])) in active @endif" id="{{ kebab_case($activity['name']) }}">
                                    <h2 class="activity-name">{{ $activity['name'] }}</h2>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <img src="{{ asset($activity['icon']) }}" class="pull-left activity-icon">
                                            <p class="lead">{{ $activity['short_description'] }}</p>
                                            {!! $activity['description'] !!}
                                        </div>
                                        <div class="col-sm-4">
                                            @if (! auth()->check()) <a href="{{ route('register') }}" class="btn btn-lg btn-block btn-primary">Daftar</a> @endif
                                            @if ($activity['id'] < 3)
                                                <div class="panel panel-default panel-prizes">
                                                    <div class="panel-heading"><h3 class="panel-title">Hadiah Pemenang</h3></div>
                                                    <div class="list-group">
                                                        @php $prize = collect($config['prizes'])->where('id', $activity['id'])->first(); @endphp
                                                        <div class="list-group-item">
                                                            <div class="prize-place">Juara 1</div>
                                                            <div class="prize-qty">Rp{{ '&#123;&#123;' }} {{ $prize['first'] }} {{ '| monetize &#125;&#125;' }}</div>
                                                        </div>
                                                        <div class="list-group-item">
                                                            <div class="prize-place">Juara 2</div>
                                                            <div class="prize-qty">Rp{{ '&#123;&#123;' }} {{ $prize['second'] }} {{ '| monetize &#125;&#125;' }}</div>
                                                        </div>
                                                        <div class="list-group-item">
                                                            <div class="prize-place">Juara 3</div>
                                                            <div class="prize-qty">Rp{{ '&#123;&#123;' }} {{ $prize['third'] }} {{ '| monetize &#125;&#125;' }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="panel panel-default panel-schedules">
                                                <div class="panel-heading"><h3 class="panel-title">Jadwal Acara</h3></div>
                                                <div class="list-group">
                                                    @foreach ($activity['schedules'] as $schedule)
                                                        <div class="list-group-item text-center">
                                                            <div class="schedule-held-at">{{ \Carbon\Carbon::parse($schedule['held_at'])->format('j F Y, H:i') }}</div>
                                                            <div class="schedule-description">{{ $schedule['description'] }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
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
    </div>
</div>

@endsection
