@extends('front.layouts.error')

@section('code')
    404
@endsection

@section('message')
    Halaman yang Anda coba akses tidak ditemukan. Silahkan kembali ke <a href="{{ url()->previous() }}">halaman sebelumnya</a>.
@endsection
