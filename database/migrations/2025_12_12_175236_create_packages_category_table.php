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
        Schema::create('packages_category', function (Blueprint $table) {
            $table->bigIncrements('category_id');
            $table->string('category_name');
            $table->text('description')->nullable();
            $table->string('category_image')->nullable();
            $table->timestamps();
            $table->string('badge_text', 20)->nullable();
            $table->string('badge_color', 20)->default('is-danger');
            $table->string('ribbon_text', 15)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->string('background_color', 7)->nullable();
            $table->text('custom_css')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages_category');
    }
};
