@extends('back-end.master')

@section('admin-title')
    Import Products
@endsection

@push('admin-styles')
    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .upload-area {
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            background-color: #e7f3ff;
            border-color: #2196F3;
        }

        .upload-icon {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 20px;
        }

        .instructions {
            background-color: #fff9e6;
            border-left: 4px solid #ffc107;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .instructions h5 {
            color: #856404;
            margin-bottom: 15px;
        }

        .instructions ul {
            margin-bottom: 0;
        }

        .instructions li {
            margin-bottom: 8px;
            color: #333;
        }

        .error-list {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
            max-height: 400px;
            overflow-y: auto;
        }

        .error-list h5 {
            color: #721c24;
            margin-bottom: 10px;
        }

        .error-list ul {
            margin-bottom: 0;
        }

        .error-list li {
            color: #721c24;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .import-stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card.success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
        }

        .stat-card.error {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
    </style>
@endpush

@section('admin-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Import Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Import</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">CSV Product Import</h4>
                        <a href="{{ route('product.import.sample') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Download Sample CSV
                        </a>
                    </div>
                    <div class="card-body">

                        <!-- Instructions -->
                        <div class="instructions">
                            <h5><i class="fas fa-info-circle"></i> Import Instructions</h5>
                            <ul>
                                <li><strong>Required Fields:</strong> product_name, price, category, stock_quantity</li>
                                <li><strong>Optional Fields:</strong> subcategory, description, brand, variants, status, featured</li>
                                <li><strong>Subcategory:</strong> Must belong to the same category in the row; auto-created if not found</li>
                                <li><strong>Variants Format:</strong> SizeName-Stock (e.g., "S-10,M-15,L-20")</li>
                                <li><strong>Status:</strong> Use "active" or "inactive"</li>
                                <li><strong>Featured:</strong> Use "yes" or "no"</li>
                                <li><strong>File Size:</strong> Maximum 10MB</li>
                                <li><strong>File Format:</strong> CSV (.csv) only</li>
                            </ul>
                        </div>

                        <!-- Upload Form -->
                        <form action="{{ route('product.import.process') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="upload-area">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h5>Choose CSV File to Import</h5>
                                <p class="text-muted mb-3">Drag and drop your CSV file here or click to browse</p>
                                <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required
                                    style="max-width: 400px; margin: 0 auto;">
                                @error('csv_file')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-upload"></i> Import Products
                                </button>
                                <a href="{{ route('product.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>

                        <!-- Import Results -->
                        @if(session('success') || session('error'))
                            <div class="mt-4">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                    </div>
                                @endif

                                @if(session('imported_count') !== null || session('error_count') !== null)
                                    <div class="import-stats">
                                        <div class="stat-card success">
                                            <h3>{{ session('imported_count', 0) }}</h3>
                                            <p>Products Imported</p>
                                        </div>
                                        <div class="stat-card error">
                                            <h3>{{ session('error_count', 0) }}</h3>
                                            <p>Errors</p>
                                        </div>
                                    </div>
                                @endif

                                @if(session('import_errors') && count(session('import_errors')) > 0)
                                    <div class="error-list">
                                        <h5><i class="fas fa-exclamation-triangle"></i> Import Errors</h5>
                                        <ul>
                                            @foreach(session('import_errors') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('admin-scripts')
    <script>
        // File input styling
        document.getElementById('csv_file').addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const uploadArea = document.querySelector('.upload-area');
                uploadArea.style.borderColor = '#28a745';
                uploadArea.style.backgroundColor = '#d4edda';

                const fileInfo = document.createElement('p');
                fileInfo.className = 'mt-3 text-success font-weight-bold';
                fileInfo.innerHTML = '<i class="fas fa-file-csv"></i> ' + fileName;

                // Remove previous file info if exists
                const existingInfo = uploadArea.querySelector('.text-success');
                if (existingInfo) {
                    existingInfo.remove();
                }

                uploadArea.appendChild(fileInfo);
            }
        });
    </script>
@endpush