@extends('front.layouts.basic')

@section('title')
    Tentang
@endsection

@section('content')

<div class="bg-lighter wrapper">
    <div id="about-page">
        <div class="page-title-container container-fluid">
            <h1 class="page-title text-center"><img src="{{ asset('storage/images/web/logo_white_lg.png') }}"></h1>
        </div>
        <div class="content-container">
            <div class="container">
                <div class="panel panel-default panel-content">
                    <div class="panel-body">
                        <p class="lead text-center">" Celebrating The Golden Era of Technology "</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>Latar Belakang</h2>
                                <p class="text-justify">
                                    Perkembangan teknologi adalah perkembangan yang selalu
                                    berkembang seiring dengan bertambahnnya usia manusia mendiami bumi
                                    ini. Perkembangan di bidang teknologi informasi telah melahirkan
                                    penemuan seperti televisi, telepon, dan penemuan yang sangat
                                    membantu manusia di era global saat ini yaitu komputer.
                                </p>
                                <p class="text-justify">
                                    Namun di sisi lain dari perkembangan tersebut masih banyak manusia
                                    yang awam terhadap perubahan teknologi sehingga perkembangan
                                    teknologi tidak selalu berjalan seperti yang semestinya.
                                </p>
                                <p class="text-justify">
                                    Berlandaskan pada pesatnya perkembangan teknologi di bidang
                                    teknologi informasi dan kondisi masyarakat saat ini, Universitas Pertamina
                                    melalui slogannya, “Be a Global Leader”, akan menumbuhkan pemahaman
                                    dan pengalaman pelajar dalam bidang teknologi informasi melalui
                                    kegiatan “Computer and IT Event of Universitas Pertamina” yang dapat
                                    disingkat menjadi “CITE UP”
                                </p>
                                <h2>Tujuan</h2>
                                <ul>
                                    <li>
                                        Mengenalkan dan menambah pengalaman mengenai dunia IT secara lebih luas kepada masyarakat, 
                                        khususnya kepada siswa-siswi SMA/K se-Indonesia.
                                    </li>
                                    <li>
                                        Mengenalkan profil program studi Ilmu Komputer sekaligus Universitas Pertamina kepada masyarakat, 
                                        khususnya kepada siswa-siswi SMA/K se-Indonesia.
                                    </li>
                                    <li>
                                        Membantu pihak sponsor mempromosikan perusahaan dan/atau produknya, serta menjalin hubungan baik
                                        berjangka panjang untuk kedepannya antara kampus dan pihak sponsor.
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <h2>Aplikasi &amp; Web</h2>
                                <p>Aplikasi CITE UP kini berada pada versi <i>{{ $config['version'] }}</i>.</p>
                                <p>Aplikasi ini dikembangkan menggunakan <a href="https://laravel.com"  target="_blank">Laravel 5.4</a> dan <a href="https://vuejs.org" target="_blank">Vue.js</a>.</p>
                                <p>Ikon acara dibuat oleh <a href="http://www.freepik.com" title="Freepik">Freepik</a> dari <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> dan berlisensi <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>.</p>
                                <p>Desain tampilan dan sistem pada aplikasi dikembangkan oleh <a href="https://github.com/purplebubblegum" target="_blank" style="color:#991e9b">purplebubblegum</a> dengan dukungan segenap mahasiswa Ilmu Komputer, Universitas Pertamina.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
