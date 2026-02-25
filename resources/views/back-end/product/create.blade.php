@extends('back-end.master')

@section('admin-title')
    Product
@endsection

@push('admin-styles')
    <style>
        .card {
            border-radius: 0;
        }

        .quick-add-btn {
            width: 34px;
            min-width: 34px;
            padding: 0;
            border-radius: 0 4px 4px 0 !important;
            border: 1px solid #ced4da;
            background: #f8f9fa;
            color: #495057;
            transition: background 0.15s, color 0.15s;
        }
        .quick-add-btn:hover {
            background: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        h4.card-title {
            font-size: 18px !important;
        }

        .table thead tr th {
            background: #f5f5f5;
        }

        .table thead tr th,
        .table thead tr td {
            font-size: 14px;
        }

        .supplier-information {
            border: 1px solid rgba(0, 0, 0, .1);
            margin-bottom: 20px;
            padding: 5px 10px;
        }

        label {
            display: inline-block;
            margin-bottom: .5rem;
            font-size: 14px;
        }

        /* Fix bottom border continuity */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da !important;
            border-radius: 4px;
            min-height: 38px;
            width: 100%;
        }

        /* Ensure the container takes full width */
        .select2-container {
            display: block;
            width: 100% !important;
        }

        /* Match the input style with form-control */
        .select2-container .select2-selection {
            background-color: #fff;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem;
            min-height: 38px;
        }

        /* Fix for the focus state */
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid #80bdff !important;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        /* start style for multiimage form */
        .remove-btn {
            position: absolute !important;
            top: -8px;
            right: -2px;
            width: 20px;
            height: 20px;
            padding: 0;
            line-height: 18px;
            font-size: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
        }

        .position-relative {
            margin: 2px;
            display: inline-block;
        }

        #gallery-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
        }

        #gallery-preview img {
            border: 1px solid #dee2e6;
        }
    </style>
@endpush

@section('admin-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New Product</h4>
                </div>

                <form class="form-horizontal" action="{{ route('product.store') }}" method="POST"
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
                                                        placeholder="Enter product name" />
                                                    @error('product_name')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Category</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <select name="category_id" id="category" class="form-select form-control">
                                                            <option value="">Select Category</option>
                                                            @foreach ($allcategories as $category)
                                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="quick-add-btn" onclick="openQuickCreate('category')" title="Add new category">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    @error('category_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Subcategory</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <select name="subcategory_id" id="subcategory" class="form-select form-control">
                                                            <option value="">Select Subcategory</option>
                                                        </select>
                                                        <button type="button" class="quick-add-btn" onclick="openQuickCreate('subcategory')" title="Add new subcategory">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Tags(Optional)</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="tags" class="form-control"
                                                        placeholder="Tags..." />
                                                    @error('tags')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Brand</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <select name="brand_id" id="brand_id" class="form-select form-control">
                                                            <option value="">Select Brand</option>
                                                            @foreach ($brand as $item)
                                                                <option value="{{ $item->id }}" {{ old('brand_id') == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="quick-add-btn" onclick="openQuickCreate('brand')" title="Add new brand">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    @error('brand_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
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
    <label class="col-sm-4 col-form-label">Unit</label>
    <div class="col-sm-8">
        <div class="input-group">
            <select name="unit_id" id="unit_id" class="form-select form-control">
                <option value="">Select Unit</option>
                @foreach ($unit as $item)
                    <option value="{{ $item->id }}" {{ old('unit_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            <button type="button" class="quick-add-btn" onclick="openQuickCreate('unit')" title="Add new unit">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        @error('unit_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>


                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Product Image</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="product_image" id="product-image-input" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif" />
                                                    @error('product_image')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                           


                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Price</label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="price" id="price" class="form-control"
                                                        placeholder="Price..." />
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
                                                        <option value="fixed">Flat Amount</option>
                                                        <!-- Changed from 'flat amount' to 'fixed' -->
                                                        <option value="percentage">Percentage</option>
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
                                                        oninput="calculateDiscount()">
                                                    <small id="discountMessage" class="form-text text-muted"></small>
                                                    @error('discount_amount')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>



                                            <script>
                                                function toggleDiscountAmount() {
                                                    const discountType = document.getElementById('discountType').value;
                                                    const discountAmountInput = document.getElementById('discountAmount');
                                                    const discountMessage = document.getElementById('discountMessage');
                                                    const priceInput = document.getElementById('price').value;

                                                    if (discountType === 'fixed') {
                                                        discountAmountInput.placeholder = "Enter flat discount amount...";
                                                        const discountAmount = discountAmountInput.value;
                                                        if (discountAmount && priceInput) {
                                                            const discountedPrice = (priceInput - discountAmount).toFixed(2);
                                                            discountMessage.textContent = `Calculated price after discount: ${discountedPrice}`;
                                                        } else {
                                                            discountMessage.textContent = "";
                                                        }
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
                                                    } else if (discountType === 'fixed' && discountAmount && priceInput) {
                                                        if (discountAmount <= priceInput) {
                                                            const discountedPrice = (priceInput - discountAmount).toFixed(2);
                                                            discountMessage.textContent = `Calculated price after discount: ${discountedPrice}`;
                                                        } else {
                                                            discountMessage.textContent = "Discount amount cannot be greater than price.";
                                                        }
                                                    } else {
                                                        discountMessage.textContent = "";
                                                    }
                                                }
                                            </script>


                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="mb-3 row p-3">

                                <div class="col-sm-12">
                                    <label class="col-sm-12 col-form-label"> Product Description</label>
                                    <div id="quill-editor" style="height: 300px;"></div>
<textarea name="description" id="description" style="display:none;">{{ old('description') }}</textarea>
                                </div>
                            </div>

                        </div>

                    </div>


                    <!-- Product Variants Section -->
                    <!-- Product Variants Section -->
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Product Variants(Need at Least One Variant)</h5>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="openQuickCreate('size')" title="Add new size">
                                    <i class="fas fa-plus"></i> Add Size
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" id="add-variant">
                                    Add Variant <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="variants-container">
                                <div class="variant-row mb-3">
                                  <div class="row">
    <div class="col-md-5">
        <select name="sizes[]" class="form-select form-control">
            <option value="">Select Size</option>
            @foreach ($size as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
        @error('sizes.0')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-5">
        <input type="number" name="stock_quantity[]" class="form-control" placeholder="Stock">
        @error('stock_quantity.0')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2">
        <button type="button" class="btn btn-danger btn-sm remove-variant">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Gallery Images Section -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Gallery Images</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 text-end control-label col-form-label">Gallery Images</label>
                                <div class="col-sm-10">
                                    <input type="file" name="gallery[]" id="gallery-input" class="form-control"
                                        multiple accept="image/*" />
                                    <div id="gallery-preview" class="row mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mb-4">
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
var quill = new Quill('#quill-editor', {
  theme: 'snow',
  modules: {
    toolbar: [
      [{ 'header': [1, 2, 3, false] }],
      ['bold', 'italic', 'underline'],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      ['link', 'image'],
      ['clean']
    ]
  }
});

// Sync content to textarea
quill.on('text-change', function() {
  document.getElementById('description').value = quill.root.innerHTML;
});
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantsContainer = document.getElementById('variants-container');
            const addVariantButton = document.getElementById('add-variant');

            function createVariantRow() {
                // Clone size options from the first existing size select so newly added sizes are included
                const existingSizeSelect = document.querySelector('select[name="sizes[]"]');
                const sizeOptionsHtml = existingSizeSelect
                    ? existingSizeSelect.innerHTML
                    : '<option value="">Select Size</option>';

                const newRow = document.createElement('div');
                newRow.className = 'variant-row mb-3';
                newRow.innerHTML = `
                    <div class="row">
                        <div class="col-md-5">
                            <select name="sizes[]" class="form-select form-control">${sizeOptionsHtml}</select>
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
            addVariantButton.addEventListener('click', function() {
                const newRow = createVariantRow();
                variantsContainer.appendChild(newRow);
            });

            // Remove variant row
            variantsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variant') ||
                    e.target.closest('.remove-variant')) {
                    const row = e.target.closest('.variant-row');
                    if (variantsContainer.children.length > 1) {
                        row.remove();
                    } else {
                        alert('At least one variant is required');
                    }
                }
            });
        });




























        document.addEventListener('DOMContentLoaded', function() {
            const categoryDropdown = document.getElementById('category');
            const subcategoryDropdown = document.getElementById('subcategory');


            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            categoryDropdown.addEventListener('change', function() {
                const categoryId = this.value;

                subcategoryDropdown.innerHTML =
                    '<option  name="subcategory_id" id="subcategory" value="">Select Subcategory</option>';

                if (categoryId) {
                    fetch(`/product/get-subcategories/${categoryId}`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (Array.isArray(data)) {
                                data.forEach(subcategory => {
                                    const option = document.createElement('option');
                                    option.value = subcategory.id;
                                    option.textContent = subcategory.name;
                                    subcategoryDropdown.appendChild(option);
                                });
                            } else {
                                throw new Error('Data is not in expected format');
                            }
                        })
                        .catch(error => {
                            console.error('Error details:', error);
                            alert('Unable to fetch subcategories. Please try again later.');
                        });
                }
            });
        });















        document.addEventListener('DOMContentLoaded', function() {
            const galleryInput = document.getElementById('gallery-input');
            const galleryPreview = document.getElementById('gallery-preview');
            let existingFiles = [];

            galleryInput.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                existingFiles = [...existingFiles, ...files];
                galleryPreview.innerHTML = '';

                existingFiles.forEach((file, index) => {
                    const col = document.createElement('div');
                    col.className = 'col-auto mb-3';

                    const imageContainer = document.createElement('div');
                    imageContainer.className = 'position-relative';
                    imageContainer.style.width = '80px';
                    imageContainer.style.height = '80px';

                    const img = document.createElement('img');
                    img.className = 'rounded';
                    img.style.width = '80px';
                    img.style.height = '80px';
                    img.style.objectFit = 'cover';

                    // Create remove button with cross icon
                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'btn btn-danger btn-sm position-absolute remove-btn';
                    removeBtn.innerHTML = '×'; // Cross symbol
                    removeBtn.type = 'button';

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    removeBtn.addEventListener('click', function() {
                        col.remove();
                        existingFiles = existingFiles.filter((_, i) => i !== index);

                        const dt = new DataTransfer();
                        existingFiles.forEach(file => dt.items.add(file));
                        galleryInput.files = dt.files;
                    });

                    imageContainer.appendChild(img);
                    imageContainer.appendChild(removeBtn);
                    col.appendChild(imageContainer);
                    galleryPreview.appendChild(col);
                });
            });

            galleryInput.closest('form').addEventListener('reset', function() {
                existingFiles = [];
                galleryPreview.innerHTML = '';
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const productImageInput = document.getElementById('product-image-input');

            // Create preview container
            const previewContainer = document.createElement('div');
            previewContainer.className = 'mt-2';
            previewContainer.id = 'product-image-preview';
            productImageInput.parentElement.appendChild(previewContainer);

            productImageInput.addEventListener('change', function(e) {
                const file = this.files[0]; // Only get the first file
                previewContainer.innerHTML = ''; // Clear existing preview

                if (file) {
                    // Create preview elements
                    const imageContainer = document.createElement('div');
                    imageContainer.className = 'position-relative d-inline-block';

                    const img = document.createElement('img');
                    img.className = 'rounded';
                    img.style.width = '100px'; // Smaller size for single product image
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
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    // Remove image handler
                    removeBtn.addEventListener('click', function() {
                        previewContainer.innerHTML = '';
                        productImageInput.value = ''; // Clear the file input
                    });

                    // Assemble and show preview
                    imageContainer.appendChild(img);
                    imageContainer.appendChild(removeBtn);
                    previewContainer.appendChild(imageContainer);
                }
            });
        });
    </script>

    {{-- ── Quick Create Modal ── --}}
    <div class="modal fade" id="quickCreateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title" id="quickCreateModalTitle">Add New</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="quickCreateAlert" class="alert py-2 d-none" role="alert"></div>
                    <div class="mb-0">
                        <label class="form-label small mb-1" id="quickCreateLabel">Name</label>
                        <input type="text" id="quickCreateInput" class="form-control form-control-sm" placeholder="Enter name...">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" id="quickCreateSaveBtn">
                        <i class="fas fa-check me-1"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const URLS = {
                category:    '{{ route("quick.create.category") }}',
                subcategory: '{{ route("quick.create.subcategory") }}',
                brand:       '{{ route("quick.create.brand") }}',
                unit:        '{{ route("quick.create.unit") }}',
                size:        '{{ route("quick.create.size") }}',
            };
            const TITLES = {
                category:    'Add New Category',
                subcategory: 'Add New Subcategory',
                brand:       'Add New Brand',
                unit:        'Add New Unit',
                size:        'Add New Size',
            };

            let currentType = null;
            let modal = null;

            function getModal() {
                if (!modal) modal = new bootstrap.Modal(document.getElementById('quickCreateModal'));
                return modal;
            }

            window.openQuickCreate = function (type) {
                if (type === 'subcategory' && !document.getElementById('category').value) {
                    alert('Please select a category first before adding a subcategory.');
                    return;
                }
                currentType = type;
                document.getElementById('quickCreateModalTitle').textContent = TITLES[type] || 'Add New';
                document.getElementById('quickCreateInput').value = '';
                document.getElementById('quickCreateAlert').classList.add('d-none');
                getModal().show();
                document.getElementById('quickCreateModal').addEventListener('shown.bs.modal', function onShown() {
                    document.getElementById('quickCreateInput').focus();
                    document.getElementById('quickCreateModal').removeEventListener('shown.bs.modal', onShown);
                });
            };

            function showAlert(type, msg) {
                const el = document.getElementById('quickCreateAlert');
                el.className = 'alert py-2 alert-' + (type === 'error' ? 'danger' : 'success');
                el.textContent = msg;
                el.classList.remove('d-none');
            }

            function addToDropdown(type, id, name) {
                if (type === 'category') {
                    const sel = document.getElementById('category');
                    sel.add(new Option(name, id, false, true));
                    sel.dispatchEvent(new Event('change')); // refresh subcategories
                } else if (type === 'subcategory') {
                    const sel = document.getElementById('subcategory');
                    sel.add(new Option(name, id, false, true));
                } else if (type === 'brand') {
                    document.getElementById('brand_id').add(new Option(name, id, false, true));
                } else if (type === 'unit') {
                    document.getElementById('unit_id').add(new Option(name, id, false, true));
                } else if (type === 'size') {
                    // Add to every size select on the page (existing + future rows clone from first)
                    document.querySelectorAll('select[name="sizes[]"]').forEach(function (sel) {
                        sel.add(new Option(name, id));
                    });
                }
            }

            document.getElementById('quickCreateSaveBtn').addEventListener('click', function () {
                const name = document.getElementById('quickCreateInput').value.trim();
                if (!name) { showAlert('error', 'Name is required.'); return; }

                const body = { name };
                if (currentType === 'subcategory') {
                    body.category_id = document.getElementById('category').value;
                }

                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(URLS[currentType], {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify(body),
                })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.success) {
                        addToDropdown(currentType, res.id, res.name);
                        getModal().hide();
                    } else {
                        showAlert('error', res.message || 'Failed to create. Please try again.');
                    }
                })
                .catch(function () { showAlert('error', 'An error occurred. Please try again.'); });
            });

            // Allow Enter key to submit
            document.getElementById('quickCreateInput').addEventListener('keydown', function (e) {
                if (e.key === 'Enter') document.getElementById('quickCreateSaveBtn').click();
            });
        })();
    </script>
@endsection
