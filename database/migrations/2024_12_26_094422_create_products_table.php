<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
   // Products table (create this first)
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('product_name');
    $table->string('slug');
    $table->string('product_image');  
    $table->string('product_code')->unique();
    $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
   $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('cascade');

   $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
    $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('set null');
    $table->enum('discount_type', ['fixed', 'percentage'])->nullable();  
    $table->decimal('discount_amount', 10, 2)->nullable();
    $table->string('tags')->nullable(); 
    $table->decimal('sale_price', 10, 2)->nullable();
    $table->text('description')->nullable();
    $table->boolean('status')->default(true);
    $table->boolean('featured')->default(false);
    $table->timestamps();
});


}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
