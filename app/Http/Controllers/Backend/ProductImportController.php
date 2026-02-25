<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Size;
use League\Csv\Reader;
use League\Csv\Statement;

class ProductImportController extends Controller
{
    /**
     * Show the CSV import form
     */
    public function showImportForm()
    {
        return view('back-end.product.import');
    }

    /**
     * Handle CSV file upload and import products
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:10240'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Please upload a valid CSV file.');
        }

        try {
            $file = $request->file('csv_file');

            $csv = Reader::createFromPath($file->getPathname(), 'r');
            $csv->setHeaderOffset(0);

            $records = Statement::create()->process($csv);

            $importedCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($records as $index => $record) {
                $rowNumber = $index + 2;

                try {
                    $validationResult = $this->validateCsvRow($record, $rowNumber);

                    if (!$validationResult['valid']) {
                        $errors[] = $validationResult['error'];
                        $errorCount++;
                        continue;
                    }

                    DB::transaction(function () use ($record) {
                        $this->createProductFromCsv($record);
                    });
                    $importedCount++;

                } catch (\Exception $e) {
                    $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                    $errorCount++;
                    Log::error("CSV Import Error - Row {$rowNumber}: " . $e->getMessage());
                }
            }

            $message = "Import completed! {$importedCount} products imported successfully.";
            if ($errorCount > 0) {
                $message .= " {$errorCount} rows had errors.";
            }

            return redirect()->back()
                ->with('success', $message)
                ->with('import_errors', $errors)
                ->with('imported_count', $importedCount)
                ->with('error_count', $errorCount);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CSV Import Failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Validate CSV row data
     */
    private function validateCsvRow($record, $rowNumber)
    {
        $requiredFields = ['product_name', 'price', 'category', 'stock_quantity'];

        foreach ($requiredFields as $field) {
            if (empty($record[$field])) {
                return [
                    'valid' => false,
                    'error' => "Row {$rowNumber}: Missing required field '{$field}'"
                ];
            }
        }

        if (!is_numeric($record['price'])) {
            return [
                'valid' => false,
                'error' => "Row {$rowNumber}: Price must be a number"
            ];
        }

        if (!is_numeric($record['stock_quantity'])) {
            return [
                'valid' => false,
                'error' => "Row {$rowNumber}: Stock quantity must be a number"
            ];
        }

        return ['valid' => true];
    }

    /**
     * Create product from CSV row
     */
    private function createProductFromCsv($record)
    {
        // Find or create category
        $category = Category::firstOrCreate(
            ['name' => trim($record['category'])],
            ['name' => trim($record['category']), 'slug' => Str::slug(trim($record['category'])), 'status' => true]
        );

        // Find or create brand (if provided)
        $brandId = null;
        if (!empty($record['brand'])) {
            $brand = Brand::firstOrCreate(
                ['name' => trim($record['brand'])],
                ['name' => trim($record['brand']), 'slug' => Str::slug(trim($record['brand'])), 'status' => true]
            );
            $brandId = $brand->id;
        }

        // Find or create subcategory scoped to the category (if provided)
        $subcategoryId = null;
        if (!empty($record['subcategory'] ?? '')) {
            $subcategory = Subcategory::firstOrCreate(
                ['name' => trim($record['subcategory']), 'category_id' => $category->id],
                ['name' => trim($record['subcategory']), 'category_id' => $category->id, 'slug' => Str::slug(trim($record['subcategory'])), 'status' => true]
            );
            $subcategoryId = $subcategory->id;
        }

        $productCode = 'P' . strtoupper(uniqid());

        // Create product
        $product = Product::create([
            'product_name'   => trim($record['product_name']),
            'slug'           => Str::slug(trim($record['product_name'])),
            'product_code'   => $productCode,
            'product_image'  => 'default.jpg',
            'sale_price'     => (float) $record['price'],
            'description'    => $record['description'] ?? '',
            'category_id'    => $category->id,
            'subcategory_id' => $subcategoryId,
            'brand_id'       => $brandId,
            'status'         => isset($record['status']) ? (strtolower(trim($record['status'])) === 'active' ? 1 : 0) : 1,
            'featured'       => isset($record['featured']) ? (strtolower(trim($record['featured'])) === 'yes' ? 1 : 0) : 0,
        ]);

        // Create product variants
        $this->createProductVariants($product, $record);

        return $product;
    }

    /**
     * Create product variants from CSV data
     */
    private function createProductVariants($product, $record)
    {
        // Parse variants — format: "S-10,M-15,L-20"
        $variantsData = !empty($record['variants']) ? explode(',', $record['variants']) : [];

        if (empty($variantsData)) {
            // Create a single default variant using the stock_quantity column
            $defaultSize = Size::firstOrCreate(
                ['name' => 'Default'],
                ['name' => 'Default', 'slug' => 'default', 'status' => true]
            );

            ProductVarient::create([
                'product_id'     => $product->id,
                'size_id'        => $defaultSize->id,
                'stock_quantity' => (int) $record['stock_quantity'],
                'sku'            => $product->product_code . '-' . $defaultSize->id,
                'status'         => true,
            ]);
        } else {
            foreach ($variantsData as $variantStr) {
                $parts = explode('-', trim($variantStr));

                if (count($parts) >= 2) {
                    $sizeName = trim($parts[0]);
                    $stock    = (int) trim($parts[1]);

                    $size = Size::firstOrCreate(
                        ['name' => $sizeName],
                        ['name' => $sizeName, 'slug' => Str::slug($sizeName), 'status' => true]
                    );

                    ProductVarient::create([
                        'product_id'     => $product->id,
                        'size_id'        => $size->id,
                        'stock_quantity' => $stock,
                        'sku'            => $product->product_code . '-' . $size->id,
                        'status'         => true,
                    ]);
                }
            }
        }
    }

    /**
     * Download a sample CSV template
     */
    public function downloadSample()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sample-products-import.csv"',
        ];

        $columns = [
            'product_name',
            'price',
            'category',
            'subcategory',
            'stock_quantity',
            'description',
            'brand',
            'variants',
            'status',
            'featured',
        ];

        $sampleData = [
            [
                'Premium T-Shirt',
                '1200',
                'Clothing',
                'Men',
                '50',
                'High quality cotton t-shirt',
                'Fashion Brand',
                'S-10,M-20,L-15,XL-5',
                'active',
                'yes',
            ],
            [
                'Casual Jeans',
                '2500',
                'Clothing',
                '',
                '30',
                'Stylish casual jeans for everyday wear',
                'Denim Co',
                'S-5,M-15,L-10',
                'active',
                'no',
            ],
        ];

        $callback = function () use ($columns, $sampleData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($sampleData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
