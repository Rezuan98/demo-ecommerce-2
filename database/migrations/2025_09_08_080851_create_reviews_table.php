<?php
// database/migrations/2024_01_01_000000_create_reviews_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();    // optional internal label
            $table->text('embed_code');             // full Facebook iframe embed code
            $table->string('all_review_link')->nullable(); // link to all FB reviews page
            $table->boolean('status')->default(1);  // active/inactive toggle
            $table->integer('order')->default(0);   // display order
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
