@extends('front.layouts.error')

@section('code')
    503
@endsection

@section('message')
    <div>Aplikasi sedang dirawat (<i>maintenance</i>).</div>
    @isset($exception->retryAfter) <p class="text-muted"><small>{{ $exception->getMessage() }} Cobalah muat ulang beberapa saat lagi.</small></p> @endisset
@endsection
