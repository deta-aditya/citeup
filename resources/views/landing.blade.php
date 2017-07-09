@extends('front.layouts.basic')

@section('content')

<!-- Welcome Carousel -->
<div id="welcome-carousel" class="carousel slide" data-ride="carousel" style="height:525px">

    <!-- Cover -->
    <div class="carousel-cover" style="position:absolute;z-index:99;width:100%;">
        <div class="container">
            <h1 style="padding-top:100px;font-size:48pt">CITE UP</h1>
            <p style="font-size:24pt">Celebrating The Golden Era of Technology</p>
            <p class="lead">
                Hi there! The landing page is currently under construction. Sorry
                for the inconvenience. Enjoy the trippiness of a half baked
                page below instead!
            </p>
        </div>
    </div>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox" style="">
        
        <div class="item active" style="background-color: #fff;height:525px">
            <div class="container">
                &nbsp;
            </div>
        </div>
    
    </div>

</div>

<!-- Activities Div -->
<div id="activities" style="margin:20px 0 50px">
    <div class="container">
        <h2 class="text-center">Daftar Acara</h2>
        <div class="row" style="margin-top:40px">

            @foreach ($activities as $activity)
                <div class="col-sm-4">
                    <div class="text-center">
                        <img class="img-circle" src="{{ asset($activity->icon) }}">
                        <h3>{{ $activity->name }}</h3>
                        <p>{{ $activity->short_description }}</p>
                        <a class="btn btn-link" href="#">Rincian &raquo;</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

<!-- Prizes Div -->
<div class="background" style="background-color:#fff">
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
<div id="map" style="height:500px;background:#efdfbf">
    
    <!-- Cover -->
    <div class="map-cover" style="position:relative;z-index:99;width:400px;top:50px;left:50px;background:#fff">
        <div class="cover-body" style="padding:20px">
            <h2>Lokasi Perlombaan</h2>
            <address style="font-size:14pt">
                <strong>Komplek Universitas Pertamina</strong><br>
                Jalan Teuku Nyak Arief<br>
                Simprug<br>
                Kebayoran Lama<br>
                Jakarta 12220<br>
            </address>
        </div>
    </div>

</div>

<!-- FAQ Div -->
<div class="background" style="background-color:#fff">
    <div class="container">
        <div id="faq">
            <h2 class="text-center" style="padding-top:20px">Pertanyaan Umum (FAQ)</h2>
            <div class="row" style="padding:20px 0 40px">
                <div class="col-sm-6">
                    <div class="list-group">
                        <a href="#" class="list-group-item">Kenapa Satu tambah Satu Sama Dengan Dua?</a>
                        <a href="#" class="list-group-item">Mengapa Ikut Acara Ini?</a>
                        <a href="#" class="list-group-item">Kapan Pendaftaran Dibuka dan Ditutup?</a>
                        <a href="#" class="list-group-item">Dokumen Apa Saja Yang Dibutuhkan?</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="well answer-area" style="height:175px">                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- News Div -->
<div id="news" style="margin:20px 0">
    <div class="container">
        <h2 class="text-center">Berita Terkini</h2>
        <div class="row" style="margin-top:40px">
            <div class="col-md-6">
                <div style="width:100%;height:250px;overflow:hidden">
                    <img src="{{ asset('storage/images/default.jpg') }}" style="width:100%">
                </div>
                <h3>Lorem Ipsum Dolor Sit Amet</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua!
                </p>
                <p>Petugas XXX &middot; Kemarin pukul 18:00:00</p>
                <p><a href="#">Selengkapnya &raquo;</a></p>
            </div>
            <div class="col-md-6">
                <div class="media" style="border-bottom:1px solid #ddd">
                    <div class="media-left">
                        <div style="height:100px;overflow:hidden">
                            <img src="{{ asset('storage/images/default.jpg') }}">
                        </div>
                    </div>
                    <div class="media-body" style="padding-left:10px">
                        <h4 class="media-heading">Lorem Ipsum Dolor Sit Amet</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                            sed do eiusmod tempor incididunt ut labore et...
                        </p>
                        <p>Petugas XXX &middot; Kemarin pukul 18:00:00</p>
                        <p><a href="#">Selengkapnya &raquo;</a></p>
                    </div>
                </div>
                <div class="media" style="border-bottom:1px solid #ddd">
                    <div class="media-left">
                        <div style="height:100px;overflow:hidden">
                            <img src="{{ asset('storage/images/default.jpg') }}">
                        </div>
                    </div>
                    <div class="media-body" style="padding-left:10px">
                        <h4 class="media-heading">Lorem Ipsum Dolor Sit Amet</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                            sed do eiusmod tempor incididunt ut labore et...
                        </p>
                        <p>Petugas XXX &middot; Kemarin pukul 18:00:00</p>
                        <p><a href="#">Selengkapnya &raquo;</a></p>
                    </div>
                </div>
                <div class="media" style="border-bottom:1px solid #ddd">
                    <div class="media-left">
                        <div style="height:100px;overflow:hidden">
                            <img src="{{ asset('storage/images/default.jpg') }}">
                        </div>
                    </div>
                    <div class="media-body" style="padding-left:10px">
                        <h4 class="media-heading">Lorem Ipsum Dolor Sit Amet</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                            sed do eiusmod tempor incididunt ut labore et...
                        </p>
                        <p>Petugas XXX &middot; Kemarin pukul 18:00:00</p>
                        <p><a href="#">Selengkapnya &raquo;</a></p>
                    </div>
                </div>
                <div class="text-center">
                    <a href="#" class="btn btn-link" style="font-size:16pt">Lihat Semua Berita</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Galleries Div -->
<div id="galleries" style="margin:20px 0 40px">
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

<!-- Register & Contact Div -->
<div class="background" style="background-color:#fff">
    <div class="container">
        <div id="register-now" class="text-center" style="padding:40px">
            <p class="lead" style="font-size:24pt">
                Ayo daftarkan dirimu sekarang juga! 
            </p>
            <div>
                <button class="btn btn-lg btn-primary">Form Pendaftaran &raquo;</button>
            </div>
        </div>

        <hr>

        <div id="contact-us">
            <h2 style="padding-top:20px" class="text-center">Hubungi Kami</h2>

            <div class="row" style="padding:40px 0">
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
            </div>

        </div>

    </div>
</div>

<!-- Sponsors Div -->
<div id="sponsors" style="margin:20px 0 40px">
    <div class="container">
        <h2 class="text-center" style="font-size:15pt">Kegiatan ini disponsori oleh:</h2>
        <div class="text-center" style="margin-top:40px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
            <img src="{{ asset('storage/images/default.jpg') }}" class="img-rounded" style="padding-bottom:5px">
        </div>
    </div>
</div>

@endsection