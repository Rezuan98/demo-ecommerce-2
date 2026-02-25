@extends('frontend.master.master')
@section('keyTitle','FAQ')

@push('ecomcss')
<style>
:root{
  --brand:#9A0000;
  --brand-dark:#4f0808;
  --ink:#0f1115;
  --muted:#6c757d;
  --card:#ffffff;
  --line:#ECEEF2;
  --bg:#f6f7fb;
}
.faq-page{
  background:
    radial-gradient(1200px 600px at 90% -10%, rgba(154,0,0,.05), transparent 60%),
    linear-gradient(180deg, #fafbff 0%, var(--bg) 100%);
  padding: 56px 0 88px;
}
.card-neutral{
  background: var(--card);
  border: 1px solid var(--line);
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(16,20,40,.04);
}
.kicker{
  display:inline-flex; align-items:center; gap:.5rem;
  padding:.35rem .75rem; border-radius:999px;
  font-weight:600; font-size:.8rem;
  color:#fff; background:var(--primary-color);
}
.section-title{ font-weight:800; color:var(--ink); margin:.6rem 0 .25rem; letter-spacing:-.02em; }
.section-subtitle{ color:var(--muted); margin:0 0 1.25rem; }

.accordion-button:focus { box-shadow: none; }
.accordion-button{
  font-weight:600;
}
.accordion-button:not(.collapsed){
  color:#fff;
  background: var(--primary-color);
}
.accordion-item{
  border: 1px solid var(--line) !important;
  border-radius: 12px !important;
  overflow: hidden;
  margin-bottom: 10px;
}
.accordion-body{
  color:#485060;
}
</style>
@endpush

@section('contents')
<section class="faq-page">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-10 mx-auto">
        <div class="card-neutral p-4 p-lg-5">
          <span class="kicker">Help Center</span>
          <h1 class="section-title">Frequently Asked Questions</h1>
          <p class="section-subtitle">Quick answers to common questions about orders, payments, and delivery.</p>

          {{-- Accordion --}}
          <div class="accordion" id="faqAccordion">
            @foreach($faqs as $i => $item)
              @php
                $headingId = 'faqHeading'.$i;
                $collapseId = 'faqCollapse'.$i;
              @endphp
              <div class="accordion-item">
                <h2 class="accordion-header" id="{{ $headingId }}">
                  <button class="accordion-button @if($i!==0) collapsed @endif" type="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#{{ $collapseId }}"
                          aria-expanded="{{ $i===0 ? 'true':'false' }}"
                          aria-controls="{{ $collapseId }}">
                    {{ $item['q'] }}
                  </button>
                </h2>
                <div id="{{ $collapseId }}" class="accordion-collapse collapse @if($i===0) show @endif"
                     aria-labelledby="{{ $headingId }}" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    {{ $item['a'] }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          {{-- Contact CTA --}}
          <div class="d-flex flex-wrap align-items-center gap-2 mt-4">
            <span class="text-muted">Didn’t find your answer?</span>
            <a href="{{ route('contact.us') }}" class="btn btn-dark btn-sm rounded-pill">Contact Support</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- SEO: FAQPage structured data --}}
  <script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"FAQPage",
    "mainEntity":[
      @foreach($faqs as $i => $item)
      {
        "@type":"Question",
        "name": @json($item['q']),
        "acceptedAnswer":{
          "@type":"Answer",
          "text": @json($item['a'])
        }
      }@if(!$loop->last),@endif
      @endforeach
    ]
  }
  </script>
</section>
@endsection
