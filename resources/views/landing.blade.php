@extends('front.layouts.basic')

@section('content')

<!-- Welcome Carousel -->
<div id="front-welcometron">

    <div class="container text-center">
        <img class="title" src="{{ asset('storage/images/web/logo_lg.png') }}">
        @if ($config['countdown']['active'])
            <p class="notice">Pendaftaran akan dibuka dalam:</p>
            <countdown done="{{ $config['countdown']['off'] }}"></countdown>
        @endif
    </div>

</div>

<div id="front-about" class="text-center">
    <div class="container">
        <p>"Celebrating The Golden Era Of Technology"</p>
    </div>
</div>

<!-- Activities Div -->
<div id="front-activities">
    <div class="container">
        <div class="row center-block">

            @foreach ($activities as $activity)
                <div class="col-sm-4">
                    <div class="panel panel-default text-center activity-item">
                        <div class="panel-body img-holder">
                            <img src="{{ asset($activity->icon) }}">
                        </div>
                        <div class="panel-body content-holder">
                            <h3 class="activity-title">{{ $activity->name }}</h3>
                            <p>{{ $activity->short_description }}</p>
                            <a class="btn btn-link" href="#">Rincian &raquo;</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

<!-- Prizes Div -->
<div class="background" style="background-color:#fff;display:none">
    <div class="container">
        <div id="prizes" class="text-center">
            <h2 style="padding-top:20px">Total Hadiah</h2>
            <p style="font-size:48pt;padding:20px 0">Rp500.000.000,00</p>
        </div>

        <hr>

        <div class="row" style="padding-bottom:40px">
            <div class="col-sm-6">
                <div class="activity-prize-item text-center">
                    <h3 style="padding:20px 0">Lomba Logika</h2>
                    <dl class="prize-item">
                        <dt style="font-size:16pt">Juara I</dt>
                        <dd style="font-size:24pt">RpXXX.XXX,00</dd>
                    </dl>
                    <dl class="prize-item">
                        <dt style="font-size:16pt">Juara II</dt>
                        <dd style="font-size:24pt">RpXXX.XXX,00</dd>
                    </dl>
                    <dl class="prize-item">
                        <dt style="font-size:18pt">Juara III</dt>
                        <dd style="font-size:24pt">RpXXX.XXX,00</dd>
                    </dl>
                </div>
            </div>

            <div class="col-sm-6" style="border-left:1px solid #eee">
                <div class="activity-prize-item text-center">
                    <h3 style="padding:20px 0">Lomba Desain Grafis</h2>
                    <dl class="prize-item">
                        <dt style="font-size:16pt">Juara I</dt>
                        <dd style="font-size:24pt">RpXXX.XXX,00</dd>
                    </dl>
                    <dl class="prize-item">
                        <dt style="font-size:16pt">Juara II</dt>
                        <dd style="font-size:24pt">RpXXX.XXX,00</dd>
                    </dl>
                    <dl class="prize-item">
                        <dt style="font-size:16pt">Juara III</dt>
                        <dd style="font-size:24pt">RpXXX.XXX,00</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Div -->
<div id="front-map">
    
    <!-- Cover -->
    <div class="map-info">
        <div class="info-body">
            <h2>
                <div class="pull-right">
                    <a href="#" class="go-to-location">
                        <i class="fa fa-lg fa-map-marker"></i>
                    </a>
                </div>
                Lokasi Perlombaan
            </h2>
            <address>
                <strong>Komplek Universitas Pertamina</strong><br>
                <small>
                    Jalan Teuku Nyak Arief<br>
                    Simprug<br>
                    Kebayoran Lama<br>
                    Jakarta 12220<br>
                </small>
            </address>
        </div>
    </div>

</div>

<!-- FAQ Div -->
<div id="front-faq">
    <div class="container">
        <h2>Pertanyaan Umum (FAQ)</h2>
        <div class="panel-group" id="faq-list" role="tablist" aria-multiselectable="true">

            <div class="panel panel-default">
                <div class="panel-heading" role="button" data-toggle="collapse" data-parent="#faq-list" data-target="#collapsible-faq-1">
                    <h4 class="panel-title">Contoh Pertanyaan pada FAQ</h4>
                </div>
                <div id="collapsible-faq-1" class="panel-collapse collapse">
                    <div class="panel-body">
                        Jawaban dari pertanyaan FAQ yang akan ditampilkan saat diklik.
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" role="button" data-toggle="collapse" data-parent="#faq-list" data-target="#collapsible-faq-2">
                    <h4 class="panel-title">Contoh Pertanyaan pada FAQ</h4>
                </div>
                <div id="collapsible-faq-2" class="panel-collapse collapse">
                    <div class="panel-body">
                        Jawaban dari pertanyaan FAQ yang akan ditampilkan saat diklik.
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" role="button" data-toggle="collapse" data-parent="#faq-list" data-target="#collapsible-faq-3">
                    <h4 class="panel-title">Contoh Pertanyaan pada FAQ</h4>
                </div>
                <div id="collapsible-faq-3" class="panel-collapse collapse">
                    <div class="panel-body">
                        Jawaban dari pertanyaan FAQ yang akan ditampilkan saat diklik.
                    </div>
                </div>
            </div>

        </div>

        <p class="see-all">Lihat semua pertanyaan di <a href="#">halaman FAQ</a>.</p>

    </div>
</div>

<hr class="short-middle-bar center-block">

<!-- News Div -->
<div id="front-news">
    <div class="container">
        <h2 class="text-center">Berita Terkini</h2>
        
        <div id="news-list">
            <div class="row news-first">
                <div class="col-sm-8">
                    <a class="img-placeholder" href="#">
                        <img src="{{ asset('storage/images/default.jpg') }}">
                    </a>
                </div>
                <div class="col-sm-4">
                    <h3><a href="#">Contoh Judul Artikel/Berita</a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...</p>
                    <div class="editor-placeholder text-muted clearfix">
                        <img src="{{ asset('storage/images/default.jpg') }}" class="img-circle pull-left">
                        <div>Administrator</div>
                        <small>15 Jul, 15:09</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 news-other">
                    <a class="img-placeholder" href="#">
                        <img src="{{ asset('storage/images/default.jpg') }}">
                    </a>
                    <h3><a href="#">Contoh Judul Artikel/Berita</a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...</p>
                    <div class="editor-placeholder text-muted clearfix">
                        <img src="{{ asset('storage/images/default.jpg') }}" class="img-circle pull-left">
                        <div>Administrator</div>
                        <small>15 Jul, 15:09</small>
                    </div>    
                </div>
                <div class="col-sm-4 news-other">
                    <a class="img-placeholder" href="#">
                        <img src="{{ asset('storage/images/default.jpg') }}">
                    </a>
                    <h3><a href="#">Contoh Judul Artikel/Berita</a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...</p>
                    <div class="editor-placeholder text-muted clearfix">
                        <img src="{{ asset('storage/images/default.jpg') }}" class="img-circle pull-left">
                        <div>Administrator</div>
                        <small>15 Jul, 15:09</small>
                    </div>    
                </div>
                <div class="col-sm-4 news-other">
                    <a class="img-placeholder" href="#">
                        <img src="{{ asset('storage/images/default.jpg') }}">
                    </a>
                    <h3><a href="#">Contoh Judul Artikel/Berita</a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...</p>
                    <div class="editor-placeholder text-muted clearfix">
                        <img src="{{ asset('storage/images/default.jpg') }}" class="img-circle pull-left">
                        <div>Administrator</div>
                        <small>15 Jul, 15:09</small>
                    </div>    
                </div>
            </div>
        </div>

        <p class="see-all">Kunjungi <a href="#">halaman berita</a> untuk melihat semua berita.</p>

    </div>
</div>

<!-- Galleries Div -->
<div id="front-galleries" style="margin:20px 0 40px;display:none">
    <div class="container">
        <h2 class="text-center">Galeri</h2>
        <div class="text-center" style="margin-top:40px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-thumbnail">
        </div>
    </div>
</div>

<div id="front-contact-us">
    
    <div class="form-container">
        <form class="panel panel-default" method="post">
            <div class="panel-body">
                <h2 class="text-center">Hubungi Kami</h2>
            </div>
            <div class="panel-body form-body">
                <div class="form-group">
                    <label for="name" class="control-label">Nama</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Alamat E-mail</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Judul</label>
                    <input type="text" class="form-control" name="subject">
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Pesan</label>
                    <textarea class="form-control" name="subject"></textarea>
                </div>
            </div>
            <div class="panel-body">
                <button type="submit" class="btn btn-lg btn-primary pull-right">
                    Kirim Pesan
                </button>
                <div>Balasan akan kami kirim ke alamat e-mail yang Anda tulis di atas.</div>
            </div>
        </form>
    </div>

    {{-- <div class="row" style="padding:40px 0">
        <div class="col-sm-6">
            <form id="form-contact">
                <div class="form-group">
                    <input class="form-control input-lg" type="text" name="name" placeholder="Nama" required>
                </div>
                <div class="form-group">
                    <input class="form-control input-lg" type="email" name="email" placeholder="Alamat E-Mail" required>
                </div>
                <div class="form-group">
                    <input class="form-control input-lg" type="text" name="subject" placeholder="Subjek" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control input-lg" name="message" placeholder="Pesan" rows="6" required></textarea>
                </div>
                <div class="form-group">
                    <!-- Captcha -->
                </div>
                <p class="help-block">Balasan akan kami kirim pada e-mail Anda.</p>
                <div>
                    <button class="btn btn-lg btn-primary" type="submit">Kirim Pesan</button>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <h3 style="margin-top:0">Kunjungi Kami</h3>

            <address style="font-size:12pt">
                <strong>Komplek Universitas Pertamina</strong><br>
                Jalan Teuku Nyak Arief<br>
                Simprug<br>
                Kebayoran Lama<br>
                Jakarta 12220<br>
            </address>

            <hr>

            <h3>Contact Person</h3>
            <p style="font-size:12pt">
                <span class="glyphicon glyphicon-earphone"></span> Humas +62 85720592958
            </p>

            <hr>
            
            <h3>Media Sosial</h3>
            <ul class="list-unstyled">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">LINE</a></li>
            </ul>
        </div>
    </div> --}}

</div>

<!-- Sponsors Div -->
<div id="front-sponsors">
    <div class="container text-center">
        <h2>Kegiatan ini disponsori oleh</h2>
        <div class="sponsors-list">
            <div class="sponsor-item" style="width:100px"></div>
            <div class="sponsor-item" style="width:200px"></div>
            <div class="sponsor-item" style="width:150px"></div>
            <div class="sponsor-item" style="width:80px"></div>
            <div class="sponsor-item" style="width:90px"></div>
            <div class="sponsor-item" style="width:180px"></div>
            <div class="sponsor-item" style="width:150px"></div>
            <div class="sponsor-item" style="width:75px"></div>
            <div class="sponsor-item" style="width:200px"></div>
            <div class="sponsor-item" style="width:100px"></div>
            <div class="sponsor-item" style="width:200px"></div>
            <div class="sponsor-item" style="width:200px"></div>
            <div class="sponsor-item" style="width:50px"></div>
            <div class="sponsor-item" style="width:180px"></div>
            <div class="sponsor-item" style="width:130px"></div>
        </div>
    </div>
</div>

@endsection