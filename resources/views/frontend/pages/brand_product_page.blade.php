@extends('frontend.master.master')

@section('keyTitle', 'Brand Products')

@push('ecomcss')
<link rel="stylesheet" href="{{ asset('frontend/css/category-product-page.css') }}">
@endpush

@section('contents')
<!-- Brand Header -->
<section class="category-header d-none d-sm-block">
    <div class="container-fluid">
        <div class="row mobile-stack">
            <div class="col-md-6 col-12">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb bg-white p-2 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="#">Brand</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $brandName ?? 'Products' }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Mobile Version -->
<section class="category-header d-block d-sm-none">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="">
                    <ol class="breadcrumb bg-white p-2 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="#">Brand</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $brandName ?? 'Products' }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Filter and Sort Row -->
<div class="container-fluid">
    <div class="filter-sort-row">
        <div class="filter-trigger">
            <button class="filter-icon-btn" onclick="openFilterSidebar()">
                <i class="fas fa-sliders-h"></i>
                <span>FILTER</span>
                <span class="filter-count" id="filterCount" style="display: none;">0</span>
            </button>
        </div>
        
        <div class="sort-section">
            <span class="sort-label">Sort:</span>
            <select class="sort-select" name="sort">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
            </select>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Product Grid -->
    <div class="row">
        <div class="col-12">
            <div class="row product-list">
                @include('frontend.pages.brand_product_partial', ['product' => $product])
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($product->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $product->links() }}
    </div>
    @endif
</div>

<!-- Filter Overlay -->
<div class="filter-overlay" onclick="closeFilterSidebar()"></div>

<!-- Filter Sidebar -->
<div class="filter-sidebar" id="filterSidebar">
    <div class="filter-header">
        <h4>FILTER</h4>
        <button class="close-filter" onclick="closeFilterSidebar()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="filter-content">
        <!-- Color Filter -->
        <div class="filter-section">
            <h5>COLOUR</h5>
            <div class="color-options">
                @php
                    $availableColors = collect();
                    if(isset($product) && $product->count() > 0) {
                        $availableColors = $product->pluck('variants.*.color')->flatten()->whereNotNull()->unique('id');
                    }
                @endphp
                @foreach($availableColors as $color)
                <div class="color-option" 
                     data-color="{{ $color->id }}" 
                     style="background-color: {{ $color->code }}"
                     onclick="toggleColor(this)"
                     title="{{ $color->name }}">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Price Range Filter -->
        <div class="filter-section">
            <h5>PRICE</h5>
            <div class="price-range">
                <div class="price-slider">
                    <div class="price-progress" id="priceProgress"></div>
                </div>
                <div class="range-input">
                    <input type="range" class="range-min" min="0" max="10000" value="{{ request('min_price', 0) }}" step="100" oninput="updatePriceRange()">
                    <input type="range" class="range-max" min="0" max="10000" value="{{ request('max_price', 10000) }}" step="100" oninput="updatePriceRange()">
                </div>
                <div class="price-values">
                    <span class="value" id="minPrice">TK{{ request('min_price', 0) }}</span>
                    <span class="value" id="maxPrice">TK{{ request('max_price', 10000) }}</span>
                </div>
            </div>
        </div>

        <!-- Size Filter -->
        <div class="filter-section">
            <h5>SIZE</h5>
            <div class="option-group">
                @php
                    $availableSizes = collect();
                    if(isset($product) && $product->count() > 0) {
                        $availableSizes = $product->pluck('variants.*.size')->flatten()->whereNotNull()->unique('id');
                    }
                @endphp
                @foreach($availableSizes as $size)
                <div class="option-item" data-size="{{ $size->id }}" onclick="toggleOption(this)">
                    {{ $size->name }}
                </div>
                @endforeach
            </div>
        </div>

        <!-- Brand Filter -->
        <div class="filter-section">
            <h5>BRAND</h5>
            <div class="option-group">
                @php
                    $availableBrands = collect();
                    if(isset($product) && $product->count() > 0) {
                        $availableBrands = $product->pluck('brand')->whereNotNull()->unique('id');
                    }
                @endphp
                @foreach($availableBrands as $brand)
                <div class="option-item" data-brand="{{ $brand->id }}" onclick="toggleOption(this)">
                    {{ $brand->name }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Filter Actions -->
    <div class="filter-actions">
        <button class="apply-btn" onclick="applyFilters()" id="applyFiltersBtn">
            SEE {{ $product->total() }} RESULTS
        </button>
        <button class="clear-btn" onclick="clearAllFilters()">
            Clear All
        </button>
    </div>
</div>

@endsection

@push('ecomjs')
<script src="{{ asset('frontend/js/category-product-page.js') }}"></script>
@endpush