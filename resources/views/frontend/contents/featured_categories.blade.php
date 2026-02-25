@if(isset($featuredCategories) && $featuredCategories->count() > 0)

<section class="featured-categories-section">
    <div class="container-fluid px-0">

        <div class="featured-cat-grid">
            @foreach($featuredCategories as $cat)
                <a href="{{ route('category.products', $cat->id) }}" class="featured-cat-card">
                    <div class="featured-cat-img-wrap">
                        @if($cat->icon)
                            <img src="{{ asset('storage/' . $cat->icon) }}"
                                 alt="{{ $cat->name }}"
                                 class="featured-cat-img"
                                 loading="lazy">
                        @else
                            <div class="featured-cat-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <div class="featured-cat-overlay"></div>
                    </div>
                    <div class="featured-cat-name">
                        <span>{{ $cat->name }}</span>
                        <i class="fas fa-arrow-right featured-cat-arrow"></i>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>


@push('ecomcss')
<style>
    .featured-categories-section {
        padding: 10px 0 0;
        background: #fff;
    }

    /* ── Grid — 2 per row ── */
    .featured-cat-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 6px;
    }

    /* ── Card ── */
    .featured-cat-card {
        display: block;
        text-decoration: none;
        overflow: hidden;
        position: relative;
    }

    .featured-cat-card:hover {
        text-decoration: none;
    }

    /* ── Image wrapper ── */
    .featured-cat-img-wrap {
        position: relative;
        width: 100%;
        overflow: hidden;
        background: #f5f0ee;
    }

    .featured-cat-img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.6s ease;
    }

    .featured-cat-card:hover .featured-cat-img {
        transform: scale(1.03);
    }

    /* Minimal dark overlay — subtle on hover only */
    .featured-cat-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0);
        transition: background 0.4s ease;
    }

    .featured-cat-card:hover .featured-cat-overlay {
        background: rgba(0,0,0,0.10);
    }

    /* Placeholder when no image */
    .featured-cat-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0ebe8;
        color: #c0a89a;
        font-size: 48px;
    }

    /* ── Name bar ── */
    .featured-cat-name {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        background: #fff;
        border-top: 1px solid #f0ebe8;
    }

    .featured-cat-name span {
        font-family: var(--font-body, sans-serif);
        font-size: clamp(14px, 1.4vw, 17px);
        font-weight: 600;
        color: var(--secondary-color, #222);
        letter-spacing: 0.5px;
        transition: color 0.2s ease;
    }

    .featured-cat-card:hover .featured-cat-name span {
        color: var(--primary-color, #4f0808);
    }

    .featured-cat-arrow {
        font-size: 13px;
        color: var(--primary-color, #4f0808);
        opacity: 0;
        transform: translateX(-6px);
        transition: opacity 0.25s ease, transform 0.25s ease;
    }

    .featured-cat-card:hover .featured-cat-arrow {
        opacity: 1;
        transform: translateX(0);
    }

    /* ── Mobile ── */
    @media (max-width: 576px) {
        .featured-categories-section {
            padding: 8px 0 0;
        }

        .featured-cat-grid {
            gap: 8px;
        }

        .featured-cat-name {
            padding: 8px 10px;
        }
    }
</style>
@endpush

@endif
