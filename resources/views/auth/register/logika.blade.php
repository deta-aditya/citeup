@extends('auth.register.layout')

@section('page-title')
    Pendaftaran Lomba Logika
@endsection

@section('view')

<div id="lomba-logika-form" class="registration-form">
    <form ref="form" class="panel panel-default form-horizontal" method="post" action="{{ route('register.lomba-logika') }}">
        {{ csrf_field() }}
        <div class="panel-body">
            <h3 class="form-title">
                <small><a href="{{ route('register.index') }}" class="pull-right"> Kembali</a></small>
                Data Pendaftaran
            </h3>
        </div>
        <div class="panel-body panel-body-form">
            <static-input name="entry_activity" :label-width="labelWidth" :control-width="controlWidth" :required="true" value="Lomba Logika">
                Acara
            </static-input>
            <text-input name="entry_name" :label-width="labelWidth" :control-width="controlWidth" :required="true" :autofocus="true">
                Nama Tim
            </text-input>
            <text-input name="entry_agency" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Sekolah Asal
            </text-input>
            <text-input name="entry_city" :label-width="labelWidth" :control-width="controlWidth" :required="true" placeholder="Contoh: Kota Bandung, Jawa Barat">
                Kota / Kabupaten &amp; Provinsi Asal
            </text-input>
            <multiline-input name="entry_address" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Sekolah
            </multiline-input>
            <text-input name="entry_phone" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nomor Telepon Tim
                <p slot="help-block" class="help-block">Pastikan nomor telepon tim aktif!</p>
            </text-input>
        </div>
        <div class="panel-body">
            <h3 class="form-title">Biodata Ketua</h3>
        </div>
        <div class="panel-body panel-body-form">
            <text-input name="user_0_name" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nama
            </text-input>
            <email-input name="user_0_email" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Email
            </email-input>
            <password-input name="user_0_password" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Kata Sandi
                <p slot="help-block" class="help-block">Email dan kata sandi ketua digunakan untuk melakukan login.</p>
            </password-input>
        </div>
        <div class="panel-body">
            <h3 class="form-title">Biodata Anggota 1</h3>
        </div>
        <div class="panel-body panel-body-form">
            <text-input name="user_1_name" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nama
            </text-input>
            <email-input name="user_1_email" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Email
            </email-input>
        </div>
        <div class="panel-body">
            <h3 class="form-title">Biodata Anggota 2</h3>
        </div>
        <div class="panel-body panel-body-form">
            <text-input name="user_2_name" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nama
            </text-input>
            <email-input name="user_2_email" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Email
            </email-input>
        </div>
        <div class="panel-body text-center">
            <button type="submit" class="btn btn-primary btn-lg btn-submit">Ajukan Pendafatran</button>
        </div>
    </form>
</div>

@endsection
