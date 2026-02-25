@if ($product->isEmpty())
    <div class="col-12 text-center py-5">
        <div
            style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 16px; padding: 40px; margin: 20px 0;">
            <i class="fas fa-search fa-4x text-muted mb-4"></i>
            <h4 class="text-muted mb-3">No products found</h4>
            <p class="text-muted mb-4">We couldn't find any products matching your search criteria.</p>
        </div>
    </div>
@else
    @foreach ($product as $products)
        <div class="cat-grid-col">
            <x-product-card :product="$products" />
        </div>
    @endforeach
@endif