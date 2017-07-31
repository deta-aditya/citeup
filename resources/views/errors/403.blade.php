@extends('front.layouts.error')

@section('code')
    403
@endsection

@section('message')
    Anda dilarang mengakses fitur ini. Silahkan kembali ke <a href="{{ url()->previous() }}">halaman sebelumnya</a>.
@endsection
