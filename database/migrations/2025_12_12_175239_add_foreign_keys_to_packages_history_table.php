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
        Schema::table('packages_history', function (Blueprint $table) {
            $table->foreign(['buyer_id'], 'itemshop_history_buyer_id_foreign')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['package_id'], 'itemshop_history_item_id_foreign')->references(['package_id'])->on('packages')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages_history', function (Blueprint $table) {
            $table->dropForeign('itemshop_history_buyer_id_foreign');
            $table->dropForeign('itemshop_history_item_id_foreign');
        });
    }
};
