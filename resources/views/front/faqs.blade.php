@extends('front.layouts.basic')

@section('title')
    FAQ
@endsection

@section('content')

<div id="faqs-page" class="wrapper">
    <div class="page-title-container">
        <div class="container"><h1 class="page-title">Pertanyaan Umum (FAQs)</h1></div>
    </div>
    <div class="content-container">
        <div class="container">
            @foreach ($faqs as $faq)
                <div class="faq-section">
                    <h2 class="faq-question"># {{ $faq->question }}</h2>
                    <div class="faq-answer">{!! $faq->answer !!}</div>
                </div>
            @endforeach
            @if ($faqs->count() === 0)
                <p class="lead">Tidak ada FAQ.</p>
            @endif
        </div>
    </div>
</div>

@endsection
