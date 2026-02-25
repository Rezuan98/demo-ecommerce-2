<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('flat_discount_active')->default(false)->after('youtube_url');
            $table->string('flat_discount_type')->default('percentage')->after('flat_discount_active'); // 'fixed' or 'percentage'
            $table->decimal('flat_discount_amount', 10, 2)->default(0)->after('flat_discount_type');
        });
    }

    public function down()
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['flat_discount_active', 'flat_discount_type', 'flat_discount_amount']);
        });
    }
};
