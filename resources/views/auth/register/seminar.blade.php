@extends('auth.register.formlayout')

@section('page-title')
    Pendaftaran Seminar IT
@endsection

@section('form')

<div id="lomba-logika-form" class="registration-form">
    <form ref="form" class="panel panel-default form-horizontal" method="post" action="{{ route('register.seminar-it') }}">
        {{ csrf_field() }}
        <div class="panel-body">
            <h3 class="form-title">
                <small><a href="{{ route('register.index') }}" class="pull-right"> Kembali</a></small>
                Data Peserta
            </h3>
        </div>
        <div class="panel-body panel-body-form">
            <static-input name="entry_activity" :label-width="labelWidth" :control-width="controlWidth" :required="true" value="Seminar IT">
                Acara
            </static-input>
            <text-input name="name" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nama
            </text-input>
            <email-input name="user_email" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Email
                <p slot="help-block" class="help-block">Email ini digunakan untuk melakukan login.</p>
            </email-input>
            <password-input name="user_password" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Kata Sandi
            </password-input>
            <password-input name="user_password_confirmation" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Konfirmasi Kata Sandi
            </password-input>
            <text-input name="user_birthplace" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Tempat Lahir / Asal Kota
            </text-input>
            <date-time-input name="user_birthdate" :label-width="labelWidth" :control-width="controlWidth" format="YYYY-MM-DD" :required="true">
                Tanggal Lahir
            </date-time-input>
            <multiline-input name="user_address" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Tempat Tinggal
            </multiline-input>
            <text-input name="user_phone" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nomor Telepon
            </text-input>
            <text-input name="entry_agency" :label-width="labelWidth" :control-width="controlWidth">
                Instansi / Sekolah Asal
                <p slot="help-block" class="help-block">Kosongkan bila tidak perlu.</p>
            </text-input>
            <text-input name="entry_city" :label-width="labelWidth" :control-width="controlWidth" :required="true" placeholder="Contoh: Kota Bandung, Jawa Barat">
                Kota / Kabupaten &amp; Provinsi Asal
            </text-input>
        </div>
        <div class="panel-body text-center">
            <button type="submit" class="btn btn-primary btn-lg btn-submit">Ajukan Pendaftaran</button>
        </div>
    </form>
</div>

@endsection
