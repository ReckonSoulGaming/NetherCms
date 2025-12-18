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
        Schema::create('packages_claims', function (Blueprint $table) {
            $table->bigIncrements('claim_id');
            $table->unsignedBigInteger('package_id')->index('itemshop_pockets_item_id_foreign');
            $table->unsignedBigInteger('owner_id')->index('itemshop_pockets_owner_id_foreign');
            $table->boolean('is_claimed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages_claims');
    }
};
