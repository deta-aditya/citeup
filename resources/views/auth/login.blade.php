@extends('front.layouts.basic')

@section('title')
    Login
@endsection

@section('content')
<div class="container">
    <div class="row" style="margin:25px 0 75px">
        <div class="col-md-4 col-md-offset-4">
            <div class="text-center">
                <h1>Cite UP</h1>
                <p class="lead">Silahkan login untuk lanjut.</p>
            </div>

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

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">
                                Login
                            </button>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Saya lupa password.
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
