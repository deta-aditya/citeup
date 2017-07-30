@extends('front.layouts.error')

@section('code')
    405
@endsection

@section('message')
    Metode yang Anda ajukan untuk mengakses halaman ini tidak diizinkan. Silahkan kembali ke <a href="{{ url()->previous() }}">halaman sebelumnya</a>.
@endsection
