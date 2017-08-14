@extends('auth.register.layout')

@section('page-title')
    Pilih Acara Yang Akan Diikuti
@endsection

@section('view')

<div id="select-activity-view">
    <div class="row">
        @foreach ($activities as $activity)
            <div class="col-sm-{{ 12 / $activities->count() }}">
                <a href="{{ route('register.form', ['id' => $activity->id, 'name' => kebab_case($activity->name)]) }}" class="panel panel-default text-center activity-item">
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

@endsection
