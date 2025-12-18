<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('package_id');
            $table->string('package_name', 30);
            $table->string('package_desc', 30);
            $table->string('package_image_path');
            $table->mediumInteger('package_price');
            $table->mediumInteger('package_discount_price')->nullable();
            $table->unsignedBigInteger('category_id')->index('itemshop_category_id_foreign');
            $table->string('package_command');
            $table->mediumInteger('package_sold');
            $table->timestamps();
            $table->softDeletes();
            $table->longText('package_features')->nullable();
            $table->string('badge_text', 50)->nullable();
            $table->string('badge_color', 20)->default('is-danger');
            $table->string('ribbon_text', 20)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('stock_limit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
