@extends('front.layouts.basic')

@section('title')
    Login
@endsection

@section('content')

<div class="bg-lighter wrapper">
    <div id="register-page">
        <div class="page-title-container text-center container-fluid">
            <div class="logo-container">
                <img class="logo" src="{{ asset('images/web/logo_white_lg.png') }}">
            </div>
            <h1 class="page-title">
                Silahkan Login Untuk Lanjut.
            </h1>
        </div>
        <div class="content-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="form-login" role="form" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input id="email" type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Alamat E-mail" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <input id="password" type="password" class="form-control input-lg" name="password" placeholder="Password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat saya
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
