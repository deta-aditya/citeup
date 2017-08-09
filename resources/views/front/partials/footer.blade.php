
@inject('f_activities', 'App\Modules\Electrons\Activities\ActivityService')
@inject('f_news', 'App\Modules\Electrons\News\NewsService')
@inject('f_faqs', 'App\Modules\Electrons\Faqs\FaqService')
@inject('f_contents', 'App\Modules\Electrons\HtmlContents\HtmlContentService')

<!-- Footer Div -->
<div id="front-footer" style="">
    <div class="container">
        <div class="upper-yard">
            <img src="{{ asset('images/web/logoup_sm.png') }}" class="footer-img logo-up">
            <img src="{{ asset('images/web/logo_lg.png') }}" class="footer-img logo-citeup">
        </div>
        <div class="row middle-yard">
            <div class="col-sm-4">
                <p>
                    {!! $f_contents->single('Footer')->content !!}
                </p>
                <p class="socmeds">
                    <a href="http://facebook.com/{{ $settings->contact->facebook }}" target="_blank"><i class="fa fa-lg fa-facebook"></i></a>
                    <a href="http://twitter.com/{{ $settings->contact->twitter }}" target="_blank"><i class="fa fa-lg fa-twitter"></i></a>
                    <a href="http://instagram.com/{{ $settings->contact->instagram }}" target="_blank"><i class="fa fa-lg fa-instagram"></i></a>
                    <a href="http://line.me/ti/p/~{{ $settings->contact->line }}" target="_blank"><i class="fa fa-lg fa-comment"></i></a>
                </p>
            </div>
            <div class="col-sm-7 col-sm-offset-1">
                <div class="row">
                    <div class="col-sm-4 footer-links">
                        <h3>Acara</h3>
                        <ul class="list-unstyled">
                            @foreach($f_activities->getMultiple([]) as $activity)
                                <li><a href="{{ route('activities', kebab_case($activity->name)) }}">{{ $activity->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4 footer-links">
                        <h3>Berita</h3>
                        <ul class="list-unstyled">
                            @foreach($f_news->getMultiple(['sort' => 'created_at:desc', 'take' => 5]) as $item)
                                <li><a href="{{ route('news.item', ['news' => $item->id, 'slug' => kebab_case($item->title)]) }}">{{ $item->title }}</a></li>
                            @endforeach
                            @if ($f_news->getMultiple([])->count() === 0)
                                <li>Tidak Ada Berita.</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-sm-4 footer-links">
                        <h3>FAQ</h3>
                        <ul class="list-unstyled">
                            @foreach($f_faqs->getMultiple(['sort' => 'created_at:desc', 'take' => 5]) as $faq)
                                <li><a href="{{ route('faqs') }}">{{ $faq->question }}</a></li>
                            @endforeach
                            @if ($f_faqs->getMultiple([])->count() === 0)
                                <li>Tidak Ada FAQ.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="lower-yard">
            <div>&copy; {{ date('Y') }} Ilmu Komputer, Fakultas Sains &amp; Komputer, Universitas Pertamina.</div>
            <p class="help-block"><small>{{ config('app.version') }}. Developed and maintained by <a href="https://github.com/purplebubblegum" style="color:#991e9b">purplebubblegum</a>.</small></p>
        </div>
    </div>
</div>
