@extends('front.layouts.basic')

@section('content')
<div class="container">
    <div class="row" style="margin:25px 0 75px">
        <div class="col-md-10 col-md-offset-1">
            <div class="text-center">
                <h1>Cite UP</h1>
                <p class="lead">Form pendaftaran peserta.</p>
            </div>

            <div class="panel panel-default">
                <div class="panel-body" style="padding:30px 40px">
                    <form id="form-register" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Nama</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">Alamat E-mail</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password_confirmation" class="control-label">Konfirmasi Password</label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label">Acara yang akan diikuti</label>

                                    <radio-vertical-lg name="activity">

                                        @foreach ($activities as $activity)
                                            <radio-button
                                                :key="{{ $activity->id }}" 
                                                :value="{{ $activity->id }}" 
                                                img="{{ asset($activity->icon) }}">
                                                <template slot="header">{{ $activity->name }}</template>
                                                <template slot="text">{{ substr($activity->short_description, 0, 25) }}...</template>
                                            </radio-button>
                                        @endforeach

                                    </radio-vertical-lg>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-lg btn-default">
                                Hapus
                            </button>
                            <button type="submit" class="btn btn-lg btn-primary">
                                Selanjutnya
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
