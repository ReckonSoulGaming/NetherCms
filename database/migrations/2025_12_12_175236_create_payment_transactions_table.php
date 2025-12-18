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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->unsignedBigInteger('payment_payer_id')->index('payment_transactions_payment_payer_id_foreign');
            $table->integer('package_id')->nullable();
            $table->string('payment_provider');
            $table->string('payment_method');
            $table->string('payment_payer');
            $table->double('payment_amount');
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
