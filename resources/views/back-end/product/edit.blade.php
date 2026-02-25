@extends('back-end.master')

@section('admin-title')
    Edit Product
@endsection

@push('admin-styles')
    <style>
        /* Reuse your existing styles */
        .card {
            border-radius: 0;
        }

        .table thead tr th {
            background: #f5f5f5;
        }

        /* ... other styles ... */

        /* Add styles for existing images */
        .existing-image {
            position: relative;
            display: inline-block;
            margin: 5px;
        }

        .existing-image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 1px solid #dee2e6;
        }

        .delete-image {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            padding: 0;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
@endpush

@section('admin-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" action="{{ route('product.update', $product->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Basic Product Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Product Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="product_name" class="form-control"
                                                    value="{{ $product->product_name }}" />
                                                @error('product_name')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Category</label>
                                            <div class="col-sm-8">
                                                <select name="category_id" id="category" class="form-select form-control">
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Subcategory</label>
                                            <div class="col-sm-8">
                                                <select name="subcategory_id" id="subcategory"
                                                    class="form-select form-control" required>
                                                    <option value="">Select Subcategory</option>
                                                    @foreach($subcategories as $subcategory)
                                                        <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                                            {{ $subcategory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('subcategory_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Tags(Optional)</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="tags" class="form-control"
                                                    value="{{ $product->tags }}" placeholder="Tags..." />
                                                @error('tags')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Brand</label>
                                            <div class="col-sm-8">
                                                <select name="brand_id" class="form-select form-control">
                                                    <option value="">Select Brand</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                            {{ $brand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Unit</label>
                                            <div class="col-sm-8">
                                                <select name="unit_id" class="form-select form-control">
                                                    <option value="">Select Unit</option>
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>
                                                            {{ $unit->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Additional Details</h5>
                                    </div>
                                    <div class="card-body">


                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Product Image</label>
                                            <div class="col-sm-8">
                                                @if($product->product_image)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('/uploads/products/' . $product->product_image) }}"
                                                            alt="Current product image"
                                                            style="width: 80px; height: 80px; object-fit: cover;"
                                                            class="rounded">
                                                    </div>
                                                @endif
                                                <input type="file" name="product_image" class="form-control"
                                                    accept="image/*" />
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Price</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="price" id="price" class="form-control"
                                                    value="{{ $product->sale_price }}" placeholder="Price..." />
                                                @error('price')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Discount Type</label>
                                            <div class="col-sm-8">
                                                <select name="discount_type" id="discountType" class="form-control"
                                                    onchange="toggleDiscountAmount()">
                                                    <option value="">Select Discount Type</option>
                                                    <option value="fixed" {{ $product->discount_type == 'fixed' ? 'selected' : '' }}>Flat Amount</option>
                                                    <option value="percentage" {{ $product->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                                </select>
                                                @error('discount_type')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label">Discount</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="discount_amount" id="discountAmount"
                                                    class="form-control" placeholder="Enter discount..."
                                                    value="{{ $product->discount_amount }}" oninput="calculateDiscount()">
                                                <small id="discountMessage" class="form-text text-muted"></small>
                                                @error('discount_amount')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <script>
                                                function toggleDiscountAmount() {
                                                    const discountType = document.getElementById('discountType').value;
                                                    const discountAmountInput = document.getElementById('discountAmount');
                                                    const discountMessage = document.getElementById('discountMessage');
                                                    const priceInput = document.getElementById('price').value;

                                                    if (discountType === 'fixed') {
                                                        discountAmountInput.placeholder = "Enter flat discount amount...";
                                                        discountMessage.textContent = "";
                                                    } else if (discountType === 'percentage') {
                                                        discountAmountInput.placeholder = "Enter percentage (0-100)...";
                                                        const discountAmount = discountAmountInput.value;
                                                        if (discountAmount && priceInput) {
                                                            const discountedPrice = (priceInput - (priceInput * discountAmount) / 100).toFixed(2);
                                                            discountMessage.textContent = `Calculated price after discount: ${discountedPrice}`;
                                                        } else {
                                                            discountMessage.textContent = "";
                                                        }
                                                    } else {
                                                        discountAmountInput.placeholder = "Enter discount amount...";
                                                        discountMessage.textContent = "";
                                                    }
                                                }

                                                function calculateDiscount() {
                                                    const discountType = document.getElementById('discountType').value;
                                                    const discountAmount = document.getElementById('discountAmount').value;
                                                    const priceInput = document.getElementById('price').value;
                                                    const discountMessage = document.getElementById('discountMessage');

                                                    if (discountType === 'percentage' && discountAmount && priceInput) {
                                                        if (discountAmount >= 0 && discountAmount <= 100) {
                                                            const discountedPrice = (priceInput - (priceInput * discountAmount) / 100).toFixed(2);
                                                            discountMessage.textContent = `Calculated price after discount: ${discountedPrice}`;
                                                        } else {
                                                            discountMessage.textContent = "Please enter a percentage between 0 and 100.";
                                                        }
                                                    } else if (discountType === 'flat' && discountAmount && priceInput) {
                                                        const discountedPrice = (priceInput - discountAmount).toFixed(2);
                                                        discountMessage.textContent = `Calculated price after discount: ${discountedPrice}`;
                                                    } else {
                                                        discountMessage.textContent = "";
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row p-3">

                            <div class="col-sm-12">
                                <label class="col-sm-12 col-form-label">Product Description</label>
                                <div id="quill-editor" style="height: 300px;"></div>
                                <textarea name="description" id="description"
                                    style="display:none;">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Variants Section -->
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Product Variants</h5>
                        <button type="button" class="btn btn-primary btn-sm" id="add-variant">
                            Add Variant <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="variants-container">
                            @if($product->variants->count() > 0)
                                @foreach($product->variants as $variant)
                                    <div class="variant-row mb-3">
                                        <div class="row">
                                            <input type="hidden" name="variant_ids[]" value="{{ $variant->id }}">

                                            <div class="col-md-5">
                                                <select name="sizes[]" class="form-select form-control">
                                                    <option value="">Select Size</option>
                                                    @foreach($sizes as $size)
                                                        <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                                            {{ $size->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="number" name="stock_quantity[]" class="form-control"
                                                    placeholder="Stock" value="{{ $variant->stock_quantity }}">
                                            </div>

                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-variant">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Gallery Images Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Gallery Images</h5>
                    </div>
                    <div class="card-body">
                        <!-- Existing Gallery Images -->
                        <div class="mb-3">
                            <label class="form-label">Current Gallery Images</label>
                            <div id="existing-gallery">
                                @foreach($product->galleryImages as $image)
                                    <div class="existing-image">
                                        <img src="{{ asset('/uploads/gallery/' . $image->image) }}" alt="Gallery image">
                                        <button type="button" class="delete-image" data-image-id="{{ $image->id }}">×</button>
                                        <input type="hidden" name="existing_gallery[]" value="{{ $image->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Upload New Images -->
                        <div class="form-group">
                            <label>Add New Gallery Images</label>
                            <input type="file" name="gallery[]" id="gallery-edit-input" class="form-control" multiple
                                accept="image/*">
                            <div id="gallery-edit-preview" class="mt-3"></div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center mb-4">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endsection

@push('admin-scripts')

    <script>
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Set existing content
        var existingDescription = document.getElementById('description').value;
        if (existingDescription) {
            quill.root.innerHTML = existingDescription;
        }

        // Sync content to textarea
        quill.on('text-change', function () {
            document.getElementById('description').value = quill.root.innerHTML;
        });
    </script>
    <script>
        // Existing variant handling
        document.addEventListener('DOMContentLoaded', function () {
            const variantsContainer = document.getElementById('variants-container');
            const addVariantButton = document.getElementById('add-variant');

            // Function to create new variant row
            function createVariantRow() {
                const newRow = document.createElement('div');
                newRow.className = 'variant-row mb-3';
                newRow.innerHTML = `
                <div class="row">
                    <input type="hidden" name="variant_ids[]" value="">
                    <div class="col-md-5">
                        <select name="sizes[]" class="form-select form-control">
                            <option value="">Select Size</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="number" name="stock_quantity[]" class="form-control" placeholder="Stock">
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-variant">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
                return newRow;
            }

            // Add new variant row
            addVariantButton.addEventListener('click', function () {
                const newRow = createVariantRow();
                variantsContainer.appendChild(newRow);
            });

            // Remove variant row
            variantsContainer.addEventListener('click', async function (e) {
                if (e.target.classList.contains('remove-variant') ||
                    e.target.closest('.remove-variant')) {
                    const row = e.target.closest('.variant-row');
                    const variantId = row.querySelector('input[name="variant_ids[]"]').value;



                    if (variantsContainer.children.length > 1) {
                        if (variantId) { // If variant exists in database
                            if (confirm('Are you sure you want to delete this variant?')) {
                                try {

                                    const response = await fetch(`/product/delete/variant/${variantId}`, {
                                        method: 'delete',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            'Accept': 'application/json'
                                        }
                                    });

                                    if (response.ok) {
                                        row.remove();
                                    } else {
                                        alert('Failed to delete variant');
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    alert('Failed to delete variant');
                                }
                            }
                        } else { // If it's a new variant not yet saved
                            row.remove();
                        }
                    } else {
                        alert('At least one variant is required');
                    }
                }
            });

            // Handle gallery image deletion
            document.querySelectorAll('.delete-image').forEach(button => {
                button.addEventListener('click', async function () {
                    if (confirm('Are you sure you want to delete this image?')) {
                        const imageId = this.dataset.imageId;
                        try {
                            const response = await fetch(`/product/delete/gallery-image/${imageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });

                            if (response.ok) {
                                this.closest('.existing-image').remove();
                            } else {
                                alert('Failed to delete image');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Failed to delete image');
                        }
                    }
                });
            });






            const galleryInput = document.getElementById('gallery-edit-input');
            const galleryPreview = document.getElementById('gallery-edit-preview');
            let newFiles = [];

            // Add this style for the preview container
            galleryPreview.style.display = 'flex';
            galleryPreview.style.flexWrap = 'wrap';
            galleryPreview.style.gap = '10px';

            galleryInput.addEventListener('change', function (e) {
                const files = Array.from(e.target.files);
                newFiles = [...newFiles, ...files];
                updatePreview();
            });

            function updatePreview() {
                galleryPreview.innerHTML = '';

                newFiles.forEach((file, index) => {
                    const imageContainer = document.createElement('div');
                    imageContainer.className = 'position-relative';
                    imageContainer.style.marginRight = '5px'; // Add space between images
                    imageContainer.style.marginBottom = '5px'; // Add space between rows

                    const img = document.createElement('img');
                    // Add size styling to the image
                    img.style.width = '50px';
                    img.style.height = '50px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '4px';
                    img.style.border = '1px solid #dee2e6';

                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'btn btn-danger btn-sm remove-btn';
                    removeBtn.innerHTML = '×';
                    removeBtn.type = 'button';
                    // Style the remove button
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '-6px';
                    removeBtn.style.right = '-6px';
                    removeBtn.style.width = '15px';
                    removeBtn.style.height = '15px';
                    removeBtn.style.padding = '0';
                    removeBtn.style.lineHeight = '15px';
                    removeBtn.style.fontSize = '12px';
                    removeBtn.style.display = 'flex';
                    removeBtn.style.alignItems = 'center';
                    removeBtn.style.justifyContent = 'center';
                    removeBtn.style.zIndex = '1'; // Ensure remove button stays on top

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    removeBtn.addEventListener('click', function () {
                        newFiles = newFiles.filter((_, i) => i !== index);
                        updatePreview();

                        // Update the file input
                        const dt = new DataTransfer();
                        newFiles.forEach(file => dt.items.add(file));
                        galleryInput.files = dt.files;
                    });

                    imageContainer.appendChild(img);
                    imageContainer.appendChild(removeBtn);
                    galleryPreview.appendChild(imageContainer);
                });
            }

            // Clear preview when form is reset
            galleryInput.closest('form').addEventListener('reset', function () {
                newFiles = [];
                galleryPreview.innerHTML = '';
            });


            // Category-Subcategory relationship handling
            const categoryDropdown = document.getElementById('category');
            const subcategoryDropdown = document.getElementById('subcategory');

            categoryDropdown.addEventListener('change', async function () {
                const categoryId = this.value;
                if (categoryId) {
                    try {
                        const response = await fetch(`/product/get-subcategories/${categoryId}`);
                        const subcategories = await response.json();

                        // Clear current options
                        subcategoryDropdown.innerHTML = '<option value="">Select Subcategory</option>';

                        // Add new options
                        subcategories.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.name;
                            subcategoryDropdown.appendChild(option);
                        });
                    } catch (error) {
                        console.error('Error fetching subcategories:', error);
                    }
                }
            });
        });


        // handling product single image preview

        const productImageInput = document.querySelector('input[name="product_image"]');

        // Create preview container
        const previewContainer = document.createElement('div');
        previewContainer.className = 'mt-2';
        previewContainer.id = 'product-image-preview';
        productImageInput.parentElement.appendChild(previewContainer);

        productImageInput.addEventListener('change', function (e) {
            const file = this.files[0]; // Only get the first file
            previewContainer.innerHTML = ''; // Clear existing preview

            if (file) {
                // Create preview elements
                const imageContainer = document.createElement('div');
                imageContainer.className = 'position-relative d-inline-block';

                const img = document.createElement('img');
                img.className = 'rounded';
                img.style.width = '100px';  // Smaller size for single product image
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.style.border = '1px solid #dee2e6';

                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-danger btn-sm position-absolute';
                removeBtn.innerHTML = '×';
                removeBtn.type = 'button';
                removeBtn.style.top = '-8px';
                removeBtn.style.right = '-8px';
                removeBtn.style.width = '20px';
                removeBtn.style.height = '20px';
                removeBtn.style.padding = '0';
                removeBtn.style.borderRadius = '50%';
                removeBtn.style.lineHeight = '18px';
                removeBtn.style.fontSize = '16px';

                // Preview the image
                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Remove image handler
                removeBtn.addEventListener('click', function () {
                    previewContainer.innerHTML = '';
                    productImageInput.value = ''; // Clear the file input
                });

                // Assemble and show preview
                imageContainer.appendChild(img);
                imageContainer.appendChild(removeBtn);
                previewContainer.appendChild(imageContainer);
            }
        });
    </script>
@endpush