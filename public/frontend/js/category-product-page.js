// Filter functionality
let selectedFilters = {
    colors: [],
    sizes: [],
    brands: [],
    priceRange: { min: 0, max: 10000 }
};

let isFilteringInProgress = false;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializePriceRange();
    initializeExistingFilters();
    attachSortListeners();
});

function initializePriceRange() {
    const rangeMin = document.querySelector('.range-min');
    const rangeMax = document.querySelector('.range-max');
    
    if (rangeMin && rangeMax) {
        selectedFilters.priceRange.min = parseInt(rangeMin.value) || 0;
        selectedFilters.priceRange.max = parseInt(rangeMax.value) || 10000;
        updatePriceRange();
    }
}

function initializeExistingFilters() {
    const urlParams = new URLSearchParams(window.location.search);
    
    // Color filters
    if (urlParams.has('colors')) {
        const colors = urlParams.get('colors').split(',');
        selectedFilters.colors = colors;
        colors.forEach(colorId => {
            const colorElement = document.querySelector('[data-color="' + colorId + '"]');
            if (colorElement) {
                colorElement.classList.add('selected');
            }
        });
    }
    
    // Size filters
    if (urlParams.has('sizes')) {
        const sizes = urlParams.get('sizes').split(',');
        selectedFilters.sizes = sizes;
        sizes.forEach(sizeId => {
            const sizeElement = document.querySelector('[data-size="' + sizeId + '"]');
            if (sizeElement) {
                sizeElement.classList.add('selected');
            }
        });
    }
    
    // Brand filters
    if (urlParams.has('brands')) {
        const brands = urlParams.get('brands').split(',');
        selectedFilters.brands = brands;
        brands.forEach(brandId => {
            const brandElement = document.querySelector('[data-brand="' + brandId + '"]');
            if (brandElement) {
                brandElement.classList.add('selected');
            }
        });
    }
    
    updateFilterCount();
}

function openFilterSidebar() {
    const sidebar = document.getElementById('filterSidebar');
    const overlay = document.querySelector('.filter-overlay');
    
    if (sidebar) sidebar.classList.add('open');
    if (overlay) overlay.classList.add('show');
    document.body.classList.add('filter-open');
}

function closeFilterSidebar() {
    const sidebar = document.getElementById('filterSidebar');
    const overlay = document.querySelector('.filter-overlay');
    
    if (sidebar) sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('show');
    document.body.classList.remove('filter-open');
}

function toggleColor(element) {
    const colorId = element.getAttribute('data-color');
    if (!colorId) return;
    
    element.classList.toggle('selected');
    
    if (element.classList.contains('selected')) {
        if (selectedFilters.colors.indexOf(colorId) === -1) {
            selectedFilters.colors.push(colorId);
        }
    } else {
        selectedFilters.colors = selectedFilters.colors.filter(function(c) {
            return c !== colorId;
        });
    }
    updateFilterCount();
}

function toggleOption(element) {
    element.classList.toggle('selected');
    
    const sizeId = element.getAttribute('data-size');
    const brandId = element.getAttribute('data-brand');
    
    if (sizeId) {
        if (element.classList.contains('selected')) {
            if (selectedFilters.sizes.indexOf(sizeId) === -1) {
                selectedFilters.sizes.push(sizeId);
            }
        } else {
            selectedFilters.sizes = selectedFilters.sizes.filter(function(s) {
                return s !== sizeId;
            });
        }
    }
    
    if (brandId) {
        if (element.classList.contains('selected')) {
            if (selectedFilters.brands.indexOf(brandId) === -1) {
                selectedFilters.brands.push(brandId);
            }
        } else {
            selectedFilters.brands = selectedFilters.brands.filter(function(b) {
                return b !== brandId;
            });
        }
    }
    updateFilterCount();
}

function updatePriceRange() {
    const rangeMin = document.querySelector('.range-min');
    const rangeMax = document.querySelector('.range-max');
    const progress = document.getElementById('priceProgress');
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    
    if (!rangeMin || !rangeMax || !progress || !minPrice || !maxPrice) return;
    
    let minVal = parseInt(rangeMin.value) || 0;
    let maxVal = parseInt(rangeMax.value) || 10000;
    
    // Ensure min is less than max
    if (minVal >= maxVal) {
        rangeMin.value = maxVal - 100;
        minVal = maxVal - 100;
    }
    
    if (maxVal <= minVal) {
        rangeMax.value = minVal + 100;
        maxVal = minVal + 100;
    }
    
    const minPercent = (minVal / parseInt(rangeMin.max)) * 100;
    const maxPercent = (maxVal / parseInt(rangeMax.max)) * 100;
    
    progress.style.left = minPercent + '%';
    progress.style.width = (maxPercent - minPercent) + '%';
    
    minPrice.textContent = '৳' + minVal.toLocaleString();
    maxPrice.textContent = '৳' + maxVal.toLocaleString();
    
    selectedFilters.priceRange = { min: minVal, max: maxVal };
    updateFilterCount();
}

function updateFilterCount() {
    const priceChanged = selectedFilters.priceRange.min > 0 || selectedFilters.priceRange.max < 10000;
    const totalFilters = selectedFilters.colors.length + selectedFilters.sizes.length + selectedFilters.brands.length + (priceChanged ? 1 : 0);
    
    const countElement = document.getElementById('filterCount');
    if (countElement) {
        if (totalFilters > 0) {
            countElement.textContent = totalFilters;
            countElement.style.display = 'flex';
        } else {
            countElement.style.display = 'none';
        }
    }
}

function applyFilters() {
    if (isFilteringInProgress) return;
    
    isFilteringInProgress = true;
    
    const productList = document.querySelector('.product-list');
    const resultsCount = document.getElementById('results-count');
    const applyBtn = document.getElementById('applyFiltersBtn');
    
    // Show loading state
    if (productList) {
        productList.innerHTML = '<div class="col-12"><div class="loading-spinner"><div class="spinner"></div>Loading products...</div></div>';
    }
    
    // Build URL parameters
    const params = new URLSearchParams();
    
    if (selectedFilters.priceRange.min > 0) {
        params.append('min_price', selectedFilters.priceRange.min);
    }
    if (selectedFilters.priceRange.max < 10000) {
        params.append('max_price', selectedFilters.priceRange.max);
    }
    if (selectedFilters.colors.length > 0) {
        params.append('colors', selectedFilters.colors.join(','));
    }
    if (selectedFilters.sizes.length > 0) {
        params.append('sizes', selectedFilters.sizes.join(','));
    }
    if (selectedFilters.brands.length > 0) {
        params.append('brands', selectedFilters.brands.join(','));
    }
    
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect && sortSelect.value && sortSelect.value !== 'newest') {
        params.append('sort', sortSelect.value);
    }
    
    const baseUrl = window.location.pathname;
    const url = params.toString() ? baseUrl + '?' + params.toString() : baseUrl;
    
    // Make AJAX request
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(function(data) {
        if (data.success && data.html) {
            if (productList) {
                productList.innerHTML = data.html;
            }
            if (resultsCount) {
                resultsCount.innerHTML = '<i class="fas fa-cube me-1"></i>Showing ' + data.count + ' of ' + data.total + ' products';
            }
            if (applyBtn) {
                applyBtn.textContent = 'SEE ' + data.total + ' RESULTS';
            }
        } else {
            if (productList) {
                productList.innerHTML = '<div class="col-12 text-center py-5"><i class="fas fa-search fa-3x text-muted mb-3"></i><h5 class="text-muted mb-3">No products found</h5><p class="text-muted mb-4">Try adjusting your filters</p><button class="btn btn-primary" onclick="clearAllFilters()" style="background: #4F0808; border-color: #4F0808;"><i class="fas fa-refresh me-1"></i>Clear Filters</button></div>';
            }
            if (resultsCount) {
                resultsCount.innerHTML = '<i class="fas fa-cube me-1"></i>Showing 0 products';
            }
            if (applyBtn) {
                applyBtn.textContent = 'SEE 0 RESULTS';
            }
        }
        
        // Update browser URL
        if (window.history && window.history.pushState) {
            window.history.pushState({}, '', url);
        }
        
        // Close sidebar
        closeFilterSidebar();
        
        // Scroll to results
        if (productList) {
            productList.scrollIntoView({ behavior: 'smooth' });
        }
    })
    .catch(function(error) {
        console.error('Filter Error:', error);
        if (productList) {
            productList.innerHTML = '<div class="col-12 text-center py-5"><i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i><h5 class="text-warning mb-3">Error loading products</h5><button class="btn btn-warning" onclick="applyFilters()"><i class="fas fa-redo me-1"></i>Retry</button></div>';
        }
    })
    .finally(function() {
        isFilteringInProgress = false;
    });
}

function clearAllFilters() {
    // Reset all selected options
    const selectedElements = document.querySelectorAll('.selected');
    for (let i = 0; i < selectedElements.length; i++) {
        selectedElements[i].classList.remove('selected');
    }
    
    // Reset price range
    const rangeMin = document.querySelector('.range-min');
    const rangeMax = document.querySelector('.range-max');
    if (rangeMin && rangeMax) {
        rangeMin.value = 0;
        rangeMax.value = 10000;
        updatePriceRange();
    }
    
    // Reset selected filters object
    selectedFilters = {
        colors: [],
        sizes: [],
        brands: [],
        priceRange: { min: 0, max: 10000 }
    };
    
    updateFilterCount();
    applyFilters();
}

function attachSortListeners() {
    const sortSelects = document.querySelectorAll('.sort-select');
    for (let i = 0; i < sortSelects.length; i++) {
        sortSelects[i].addEventListener('change', function() {
            // Sync all sort selects
            for (let j = 0; j < sortSelects.length; j++) {
                sortSelects[j].value = this.value;
            }
            applyFilters();
        });
    }
}

// Handle browser back/forward
window.addEventListener('popstate', function(event) {
    location.reload();
});

// Close sidebar on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeFilterSidebar();
    }
});