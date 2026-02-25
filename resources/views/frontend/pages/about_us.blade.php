@extends('frontend.master.master')
@section('keyTitle','About Us')

@push('ecomcss')
<style>
:root { --brand:var(--primary-color); --brand-dark:#4f0808; --ink:#0f1115; --muted:#6c757d; --card:#ffffff; --line:#ECEEF2; --bg:#f6f7fb; }
.about-page { background: radial-gradient(1200px 600px at 90% -10%, rgba(154,0,0,.06), transparent 60%), linear-gradient(180deg, #fafbff 0%, var(--bg) 100%); padding: 56px 0 88px; }
.card-neutral { background: var(--card); border: 1px solid var(--line); border-radius: 16px; box-shadow: 0 10px 30px rgba(16,20,40,.04); }
.kicker { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .75rem; border-radius:999px; font-weight:600; font-size:.8rem; letter-spacing:.02em; color:#fff; background:linear-gradient(135deg,var(--brand),var(--brand-dark)); }
.section-title { font-weight:800; color:var(--ink); margin:.6rem 0 .25rem; letter-spacing:-.02em; }
.section-subtitle { color:var(--muted); margin:0 0 1.25rem; }
.btn-neutral { background: var(--ink); color:#fff; border:0; font-weight:600; padding:.85rem 1.25rem; border-radius:999px; transition: transform .2s ease, box-shadow .25s ease, opacity .2s ease; }
.btn-neutral:hover { transform: translateY(-2px); box-shadow:0 10px 24px rgba(0,0,0,.12); color:#fff; }
.btn-accent { background: linear-gradient(135deg,var(--brand),var(--brand-dark)); }
.about-hero .copy { padding: clamp(20px,2vw,28px) clamp(20px,2vw,32px); }
.about-hero ul { color:var(--muted); margin:0; padding-left:1.1rem; }
.about-hero li { margin:.4rem 0; }
.hero-card { position:relative; overflow:hidden; border-radius:16px; height:100%; background:linear-gradient(180deg, rgba(154,0,0,.08), rgba(154,0,0,.02)); border:1px solid var(--line); }
.hero-img { width:100%; height:100%; object-fit:cover; min-height:360px; border-radius:14px; mask-image: linear-gradient(to bottom, rgba(0,0,0,.95), rgba(0,0,0,.92)); }
.ribbon { position:absolute; left:18px; top:18px; z-index:2; background:#fff; border:1px solid var(--line); border-radius:999px; padding:.35rem .65rem; font-size:.8rem; font-weight:600; color:var(--brand-dark); box-shadow:0 6px 18px rgba(16,20,40,.06); }
.angle { position:absolute; inset:auto -30% -30% auto; width:70%; height:60%; background: radial-gradient(60% 60% at 40% 50%, rgba(154,0,0,.16), transparent 70%); transform: rotate(-12deg); }
.header-text { font-family: "Conthic", sans-serif; color: var(--primary-color)!important; }
.normal-text { font-family: "AloveraDisplay", sans-serif; }
@media (max-width: 991px) { .hero-img { min-height:300px; } }
@media (prefers-reduced-motion: reduce) { .btn-neutral:hover { transform:none; box-shadow:none; } }
</style>
@endpush

@section('contents')
<section class="about-page">
  <div class="container">

    <div class="row g-4 align-items-stretch about-hero">
      <div class="col-lg-6">
        <div class="card-neutral h-100">
          <div class="copy">
            <span class="kicker normal-text">About Chileghuri</span>
            <h1 class="section-title header-text">Shopping that feels personal, fast, and fair</h1>
            <p class="section-subtitle normal-text">We blend quality curation with transparent service—so every order feels effortless.</p>

            <p class="mb-3 normal-text">
              At <strong>Chileghuri</strong>, we're obsessed with removing friction. From honest product pages to reliable logistics and helpful humans, we focus on the little details that make a big difference.
            </p>
            <ul class="mb-4">
              <li class="normal-text">Authentic products from trusted partners</li>
              <li class="normal-text">Clear ETAs and proactive updates</li>
              <li class="normal-text">Friendly support that actually solves problems</li>
            </ul>

            <div class="d-flex flex-wrap gap-2">
              <a href="{{ route('contact.us') }}" class="btn btn-neutral normal-text">Contact our team</a>
              <a href="{{ route('home') }}" class="btn btn-neutral btn-accent normal-text">Browse products</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="hero-card">
          <span class="ribbon normal-text">Trusted by thousands</span>
          <span class="angle"></span>
          <img
            src="{{ asset('frontend/images/about-hero.jpg') }}"
            alt="Chileghuri team and products"
            class="hero-img"
            loading="lazy">
        </div>
      </div>
    </div>

  </div>
</section>
@endsection

@push('ecomjs')
<script>
document.querySelectorAll('.card-neutral').forEach(c=>{
  c.addEventListener('mouseenter',()=> c.style.boxShadow='0 14px 38px rgba(16,20,40,.09)');
  c.addEventListener('mouseleave',()=> c.style.boxShadow='0 10px 30px rgba(16,20,40,.04)');
});
</script>
@endpush